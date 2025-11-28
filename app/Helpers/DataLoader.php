<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 5/24/2019
 * Time: 13:35
 */


namespace app\Helpers;


use app\ApiResp;
use app\Models\ApiUser;
use App\Models\ApiLmsRole;
use app\Helpers\AppConstants;
use app\Models\ApiDepartment;
use app\Models\ApiAppraisalReq;
use app\Models\ApiDepartmentUnit;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class DataLoader {

    public static function getAuthenticatedUser($token) {

        $baseResp = new ApiResp();

        try{

            $action = endpoint('USERS_GET_AUTHENTICATED_USER');
            
            $resp = ApiHandler::makeGetRequest($action, true,$token, null, endpoint('BASE_URL_USER_MANAGEMENT'));
            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->result = self::getApiUser($apiResult['data']);
            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            return $baseResp;

        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }
    public static function getApiUser($userDataObjectFromApi) {

        $user = new ApiUser();
        $user->id = $userDataObjectFromApi['id'];
        $user->firstName = $userDataObjectFromApi['first_name'];
        $user->lastName = $userDataObjectFromApi['last_name'];
        $user->otherName = $userDataObjectFromApi['other_name'];
        $user->fullName = trim($user->firstName . ' ' . $user->lastName . ' ' . $user->otherName);
        $user->username = $userDataObjectFromApi['username'];
        $user->email = $userDataObjectFromApi['email'];
        $user->phone = $userDataObjectFromApi['phone'];
        $user->createdAt = $userDataObjectFromApi['created_at'];
        $user->createdBy = $userDataObjectFromApi['created_by'];
        $user->is_admin = $userDataObjectFromApi['is_admin'];

        $user->staffNumber = $userDataObjectFromApi['staff_number'];
        $usrDesignation = get_json_obj_from_array($userDataObjectFromApi,'user_designation');
        $user->designation = isset($usrDesignation) ? $usrDesignation->title : null;
        $user->dateOfBirth = $userDataObjectFromApi['date_of_birth'];
        $user->contractStartDate = $userDataObjectFromApi['contract_start_date'];
        $user->contractExpiryDate = $userDataObjectFromApi['contract_expiry_date'];

        $user->roleLetterMovement = self::getLetterMovementAppSpecificRoleCodes($userDataObjectFromApi['letter_movement_role_code']);

        // $apiDept = self::getApiDepartment($userDataObjectFromApi['department']);
        $apiDept = isset($userDataObjectFromApi['department'])? self::getApiDepartment($userDataObjectFromApi['department']): null;
        $user->lmsRole = self::getApiLmsRole($userDataObjectFromApi['lms_role']);

        $user->departmentCode = is_null($apiDept) ? "" : $apiDept->departmentCode;
        $user->departmentName = is_null($apiDept) ? "" : $apiDept->name;
        $user->departmentHeadUsername = is_null($apiDept) ? "" : $apiDept->hodUsername;

        $region =  isset($userDataObjectFromApi['regional_office']) ? json_decode(json_encode($userDataObjectFromApi['regional_office']),false) : null;
        $user->regionalOfficeCode = !isset($region) ? "" : $region->regional_office_code;
        $user->regionalOfficeName = !isset($region) ? "" : $region->name;

        return $user;

    }
    public static function getApiDepartment($item) {

        $department = new ApiDepartment();
        $department->name = $item['name'];
        $department->departmentCode = $item['department_code'];
        $department->createdBy = $item['created_by'];
        $department->orgCode = $item['org_code'];
        $department->hodUsername = $item['head_of_department'];
        return $department;

    }
    
    public static function getApiDepartmentUnit($data) {

        $units = [];
       foreach ($data as $datum){

           $unit = new ApiDepartmentUnit();
           $unit->unit = $datum['name'];
           $unit->code = $datum['unit_code'];
           $unit->deptCode = array_key_exists('department',$datum) ?  $datum['department']['department_code'] : '';
           $unit->deptName = array_key_exists('department',$datum) ?  $datum['department']['name'] : '';

           $units[] = $unit;

       }
        return $units;

    }
    public static function getApiLmsRole($item) {

        $role = new ApiLmsRole();

        if($item == null){

            $role->reception = false;
            $role->registry = false;
            $role->edOffice = false;
            $role->outLetters = false;
            $role->masterData = false;
            $role->reports = false;
            return $role;
        }else{
            $role->reception = $item['reception_flag'] == 1;
            $role->registry = $item['registry_flag'] == 1;
            $role->edOffice = $item['ed_office_flag'] == 1;
            $role->outLetters = $item['outgoing_letter_flag'] == 1;
            $role->masterData = $item['master_data_flag'] == 1;
            $role->reports = $item['reports_flag'] == 1;
            return $role;

        }

    }
    private static function getLetterMovementAppSpecificRoleCodes($letter_movement_role_code)
    {
        if($letter_movement_role_code == AppConstants::$API_ROLE_CODE_RECEPTION)
        {
            return AppConstants::$ROLE_CODE_RECEPTION;
        }
        else if($letter_movement_role_code == AppConstants::$API_ROLE_CODE_REGISTRY)
        {
            return AppConstants::$ROLE_CODE_REGISTRY;
        }
        else if($letter_movement_role_code == AppConstants::$API_ROLE_CODE_ED)
        {
            return AppConstants::$ROLE_CODE_ED;
        }
        else if($letter_movement_role_code == AppConstants::$API_ROLE_CODE_SUPER_USER)
        {
            return AppConstants::$ROLE_CODE_SUPER_USER;
        }
        else
        {
            return $letter_movement_role_code;
        }

    }
    public static function getStrategicObjectives($token) {

        $baseResp = new ApiResp();

        try{

            $action = endpoint('APPRAISAL_STRATEGIC_OBJECTIVES_ALL');

            $resp = ApiHandler::makeGetRequest($action, true, $token);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            $baseResp->result = DataFormatter::formatStrategicObjectives($apiResult['data']);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function getCategorizedCompetences($token, $appraisalRef = 'NEW', $competenceAssessments = []) {

        $baseResp = new ApiResp();

        try{

            $action = endpoint('APPRAISAL_COMPETENCE_CATEGORIES_ALL');

            $resp = ApiHandler::makeGetRequest($action, true, $token, $appraisalRef,endpoint('BASE_URL_APPRAISAL_APP_API'));

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            $baseResp->result = DataFormatter::formatCategorizedCompetences($apiResult['data'], $competenceAssessments);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function getUserAppraisals(ApiAppraisalReq $req) {

        $baseResp = new ApiResp();

        try{

            /*
             * Build the body
             * */
            $data = [ 'work_flow_role' => $req->workflowRole ];

            if(isset($req->status)){
                $data['status'] = $req->status;
            }
            if(isset($req->additionStatusFilter)){
                $data['additionStatusFilter'] = $req->additionStatusFilter;
            }
            if(isset($req->startDate)){
                $data['start_date'] = $req->startDate;
            }
            if(isset($req->endDate)){
                $data['end_date'] = $req->endDate;
            }
            if(isset($req->supervisorDecision)){
                $data['supervisor_decision'] = $req->supervisorDecision;
            }
            if(isset($req->hodDecision)){
                $data['department_head_decision'] = $req->hodDecision;
            }
            if(isset($req->directorDecision)){
                $data['director_decision'] = $req->directorDecision;
            }

            /*
             * Action
             * */
            $action = endpoint('APPRAISAL_ALL');

            /*
             * Make the request
             * */
            $resp = ApiHandler::makePostRequest($action,$data, true, $req->token,endpoint('BASE_URL_APPRAISAL_APP_API'));

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            $baseResp->result = DataFormatter::formatAppraisals($apiResult['data']);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception->getMessage());
            return $baseResp;
        }

    }

    public static function saveAcademicInstitutes($token, $data, $update = false) {

        $baseResp = new ApiResp();

        try{

            $action = !$update ?  endpoint('APPRAISAL_ACADEMIC_BG_SAVE') : endpoint('APPRAISAL_ACADEMIC_BG_UPDATE');

            $resp = ApiHandler::makePostRequest($action, $data,true, $token);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $apiAppraisal = json_decode($apiResult['data'],true);
            $baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function saveKeyDuties($token, $data, $update = false) {

        $baseResp = new ApiResp();

        try{

            $action = !$update ?  endpoint('APPRAISAL_KEY_DUTIES_SAVE') : endpoint('APPRAISAL_KEY_DUTIES_UPDATE');

            $resp = ApiHandler::makePostRequest($action, $data,true, $token);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $apiAppraisal = json_decode($apiResult['data'],true);
            $baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function saveAssignments($token, $data, $update = false) {

        $baseResp = new ApiResp();

        try{

            $action = !$update ?  endpoint('APPRAISAL_ASSIGNMENTS_SAVE') : endpoint('APPRAISAL_ASSIGNMENTS_UPDATE');

            $resp = ApiHandler::makePostRequest($action, $data,true, $token);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $apiAppraisal = json_decode($apiResult['data'],true);
            $baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function saveCompetenceAssessments($token, $data, $update = false) {

        $baseResp = new ApiResp();

        try{

            $action = !$update ?  endpoint('APPRAISAL_COMPETENCE_ASSESSMENT_SAVE') : endpoint('APPRAISAL_COMPETENCE_ASSESSMENT_UPDATE');

            $resp = ApiHandler::makePostRequest($action, $data,true, $token);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $apiAppraisal = json_decode($apiResult['data'],true);
            $baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function savePerformanceGaps($token, $data, $update = false) {

        $baseResp = new ApiResp();

        try{

            $action = !$update ?  endpoint('APPRAISAL_PERFORMANCE_GAPS_SAVE') : endpoint('APPRAISAL_PERFORMANCE_GAPS_UPDATE');

            $resp = ApiHandler::makePostRequest($action, $data,true, $token);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $apiAppraisal = json_decode($apiResult['data'],true);
            $baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function savePerformanceChallenges($token, $data, $update = false) {

        $baseResp = new ApiResp();

        try{

            $action = !$update ?  endpoint('APPRAISAL_PERFORMANCE_CHALLENGES_SAVE') : endpoint('APPRAISAL_PERFORMANCE_CHALLENGES_UPDATE');

            $resp = ApiHandler::makePostRequest($action, $data,true, $token);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $apiAppraisal = json_decode($apiResult['data'],true);
            $baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function saveAdditionalAssignments($token, $data, $update = false) {

        $baseResp = new ApiResp();

        try{

            $action = !$update ?  endpoint('APPRAISAL_ADDITIONAL_ASSIGNMENTS_SAVE') : endpoint('APPRAISAL_ADDITIONAL_ASSIGNMENTS_UPDATE');

            $resp = ApiHandler::makePostRequest($action, $data,true, $token);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $apiAppraisal = json_decode($apiResult['data'],true);
            $baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function saveWorkPlans($token, $data, $update = false) {

        $baseResp = new ApiResp();

        try{

            $action = !$update ?  endpoint('APPRAISAL_WORK_PLAN_SAVE') : endpoint('APPRAISAL_WORK_PLAN_UPDATE');

            $resp = ApiHandler::makePostRequest($action, $data,true, $token);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $apiAppraisal = json_decode($apiResult['data'],true);
            $baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function getTopThreeLatestAppraisals($token) {

        $baseResp = new ApiResp();

        try{

            $action = endpoint('APPRAISAL_TOP_3');

            $resp = ApiHandler::makeGetRequest($action, true, $token);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            $baseResp->result = $apiResult['data'];

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function getAppraisalByAppraisalReference($appraisalRef,$token = null) {

        $baseResp = new ApiResp();

        try{

            if(is_null($token)){
                $token = Cookie::get(Security::$COOKIE_TOKEN);
            }

            /*
             * We have failed to get an access token
             * */
            if(is_null($token)){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN;
                return $baseResp;
            }


            $identifier = $appraisalRef;
            $action = endpoint('APPRAISAL_GET');

            $resp = ApiHandler::makeGetRequest($action, true, $token, $identifier);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $appraisal = json_decode($apiResult['data'],true);
            $baseResp->result = DataFormatter::getApiAppraisal($appraisal);

            return $baseResp;

        }catch (\Exception $exception){
            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function saveAppraiserComment($data, $update = false,$identifier = null) {


        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            if(!$update){
                $action = endpoint('APPRAISAL_APPRAISER_COMMENT_SAVE');
                $resp = ApiHandler::makePostRequest($action, $data,true, $token);
            }else{
                $action = endpoint('APPRAISAL_APPRAISER_COMMENT_UPDATE');
                $resp = ApiHandler::makePutRequest($action, $identifier, $data,true, $token);
            }

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $apiAppraisal = json_decode($apiResult['data'],true);
            $baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function saveStrengthsAndWeaknesses($data, $update = false,$identifier = null) {


        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            if(!$update){
                $action = endpoint('APPRAISAL_STRENGTH_AND_WEAKNESS_SAVE');
                $resp = ApiHandler::makePostRequest($action, $data,true, $token);
            }else{
                $action = endpoint('APPRAISAL_STRENGTH_AND_WEAKNESS_UPDATE');
                $resp = ApiHandler::makePutRequest($action, $identifier, $data,true, $token);
            }

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $apiAppraisal = json_decode($apiResult['data'],true);
            $baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function saveAppraiserRecommendation($data, $update = false,$identifier = null) {


        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            if(!$update){
                $action = endpoint('APPRAISAL_APPRAISER_RECOMMENDATION_SAVE');
                $resp = ApiHandler::makePostRequest($action, $data,true, $token);
            }else{
                $action = endpoint('APPRAISAL_APPRAISER_RECOMMENDATION_UPDATE');
                $resp = ApiHandler::makePutRequest($action, $identifier, $data,true, $token);
            }

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $apiAppraisal = json_decode($apiResult['data'],true);
            $baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function saveSupervisorDeclaration($data, $update = false, $identifier = null) {


        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            if(!$update){
                $action = endpoint('APPRAISAL_SUPERVISOR_DECLARATION_SAVE');
                $resp = ApiHandler::makePostRequest($action, $data,true, $token);
            }else{
                $action = endpoint('APPRAISAL_SUPERVISOR_DECLARATION_UPDATE');
                $resp = ApiHandler::makePutRequest($action, $identifier, $data,true, $token);
            }

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $apiAppraisal = json_decode($apiResult['data'],true);
            $baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function saveHodComment($data, $update = false,$identifier = null) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            if(!$update){
                $action = endpoint('APPRAISAL_HOD_COMMENT_SAVE');
                $resp = ApiHandler::makePostRequest($action, $data,true, $token);
            }else{
                $action = endpoint('APPRAISAL_HOD_COMMENT_UPDATE');
                $resp = ApiHandler::makePutRequest($action, $identifier, $data,true, $token);
            }

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $apiAppraisal = json_decode($apiResult['data'],true);
            $baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function saveAssignmentsScore($data, $update = false,$identifier = null) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            if(!$update){
                $action = endpoint('APPRAISAL_ASSIGNMENTS_SCORES_SAVE');
                $resp = ApiHandler::makePostRequest($action, $data,true, $token);
            }else{
                $action = endpoint('APPRAISAL_ASSIGNMENTS_SCORES_UPDATE');
                $resp = ApiHandler::makePutRequest($action, $identifier, $data,true, $token);
            }

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $apiAppraisal = json_decode($apiResult['data'],true);
            $baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function saveAdditionalAssignmentsScore($data, $update = false,$identifier = null) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            if(!$update){
                $action = endpoint('APPRAISAL_ADDITIONAL_ASSIGNMENTS_SCORES_SAVE');
                $resp = ApiHandler::makePostRequest($action, $data,true, $token);
            }else{
                $action = endpoint('APPRAISAL_ADDITIONAL_ASSIGNMENTS_SCORES_UPDATE');
                $resp = ApiHandler::makePutRequest($action, $identifier, $data,true, $token);
            }

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $apiAppraisal = json_decode($apiResult['data'],true);
            $baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function saveAssignmentsSummary($data, $update = false,$identifier = null) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            if(!$update){
                $action = endpoint('APPRAISAL_ASSIGNMENTS_SUMMARY_SAVE');
                $resp = ApiHandler::makePostRequest($action, $data,true, $token);
            }else{
                $action = endpoint('APPRAISAL_ASSIGNMENTS_SUMMARY_UPDATE');
                $resp = ApiHandler::makePutRequest($action, $identifier, $data,true, $token);
            }

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $apiAppraisal = json_decode($apiResult['data'],true);
            $baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function saveTrainingSummary($data, $update = false,$identifier = null) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            if(!$update){
                $action = endpoint('APPRAISAL_PERFORMANCE_SUMMARY_SAVE');
                $resp = ApiHandler::makePostRequest($action, $data,true, $token);
            }else{
                $action = endpoint('APPRAISAL_PERFORMANCE_SUMMARY_UPDATE');
                $resp = ApiHandler::makePutRequest($action, $identifier, $data,true, $token);
            }

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $apiAppraisal = json_decode($apiResult['data'],true);
            $baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function saveCompetenceAssessmentsScore($data, $update = false,$identifier = null) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            if(!$update){
                $action = endpoint('APPRAISAL_COMPETENCE_ASSESSMENT_SCORES_SAVE');
                $resp = ApiHandler::makePostRequest($action, $data,true, $token);
            }else{
                $action = endpoint('APPRAISAL_COMPETENCE_ASSESSMENT_SCORES_UPDATE');
                $resp = ApiHandler::makePutRequest($action, $identifier, $data,true, $token);
            }

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $apiAppraisal = json_decode($apiResult['data'],true);
            $baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function saveCompetenceAssessmentsSummary($data, $update = false,$identifier = null) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            if(!$update){
                $action = endpoint('APPRAISAL_COMPETENCE_ASSESSMENT_SUMMARY_SAVE');
                $resp = ApiHandler::makePostRequest($action, $data,true, $token);
            }else{
                $action = endpoint('APPRAISAL_COMPETENCE_ASSESSMENT_SUMMARY_UPDATE');
                $resp = ApiHandler::makePutRequest($action, $identifier, $data,true, $token);
            }

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $apiAppraisal = json_decode($apiResult['data'],true);
            $baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }


    public static function saveAppraiseeRemarks($data, $update = false,$identifier = null) {


        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            if(!$update){
                $action = endpoint('APPRAISAL_APPRAISEE_REMARK_SAVE');
                $resp = ApiHandler::makePostRequest($action, $data,true, $token);
            }else{
                $action = endpoint('APPRAISAL_APPRAISEE_REMARK_UPDATE');
                $resp = ApiHandler::makePutRequest($action, $identifier, $data,true, $token);
            }

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $apiAppraisal = json_decode($apiResult['data'],true);
            $baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function saveDirectorComment($data, $update = false,$identifier = null) {


        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            if(!$update){
                $action = endpoint('APPRAISAL_DIRECTOR_COMMENT_SAVE');
                $resp = ApiHandler::makePostRequest($action, $data,true, $token);
            }else{
                $action = endpoint('APPRAISAL_DIRECTOR_COMMENT_UPDATE');
                $resp = ApiHandler::makePutRequest($action, $identifier, $data,true, $token);
            }

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $apiAppraisal = json_decode($apiResult['data'],true);
            $baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function allUsers() {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);
            $resp = ApiHandler::makeGetRequest(endpoint('USERS_ALL'), true, $token);

            /*
             * We didn't get a response from API
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                /*
                 * Return error
                 * */
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp->statusDescription;
            }

            /*
             * We got a response from the API
             * */
            $apiResp = json_decode($resp->result, true);

            /*
             * Get statusCode, statusDescription
             * */
            $statusCode = $apiResp['statusCode'];
            $statusDescription = $apiResp['statusDescription'];

            /*
             * Check if got a success on fetching the data from the API
             * */
            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            /*
             * We got the data from the API
             * */
            $data = $apiResp['data'];

            /*
             * Format data
             * */
            $users = DataFormatter::formatUsers($data);

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            $baseResp->result = $users;

            return $baseResp;


        }catch (\Exception $exception){
            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception->getMessage());
            return $baseResp;
        }

    }

    public static function appraisalWorkFlowStart($data) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $action = endpoint('APPRAISAL_WORKFLOW_START');
            $resp = ApiHandler::makePostRequest($action, $data,true, $token);

            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            //$apiAppraisal = json_decode($apiResult['data'],true);
            //$baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);
            return $baseResp;

        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function appraisalWorkFlowMove($data) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $action = endpoint('APPRAISAL_WORKFLOW_MOVE');
            $resp = ApiHandler::makePostRequest($action, $data,true, $token);

            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            //$apiAppraisal = json_decode($apiResult['data'],true);
            //$baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);
            return $baseResp;

        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }


    public static function updateUserProfileByOwner($data, $username) {


        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $action = endpoint('USERS_UPDATE_PROFILE_BY_USER');
            $resp = ApiHandler::makePutRequest($action, $username, $data,true, $token);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $baseResp->result = DataFormatter::getApiUser($apiResult['data']);

            //update the user in the session
            session([Security::$SESSION_USER => $baseResp->result]);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }


    public static function saveUserAcademicBackground($data, $update = false,$identifier = null) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            if(!$update){
                $action = endpoint('USERS_USER_ACADEMIC_BG_SAVE');
                $resp = ApiHandler::makePostRequest($action, $data,true, $token);
            }else{
                $action = endpoint('USERS_USER_ACADEMIC_BG_UPDATE');
                $resp = ApiHandler::makePutRequest($action, $identifier, $data,true, $token);
            }

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

           /* $apiAppraisal = json_decode($apiResult['data'],true);
            $baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);*/
            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }


    public static function saveAdminCompetenceCategory($data, $update = false,$identifier = null) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            if(!$update){
                $action = endpoint('COMPETENCE_CATEGORY_SAVE');
                $resp = ApiHandler::makePostRequest($action, $data,true, $token,endpoint('BASE_URL_APPRAISAL_APP_API'));
            }else{
                $action = endpoint('COMPETENCE_CATEGORY_UPDATE');
                $resp = ApiHandler::makePutRequest($action, $identifier, $data,true, $token,endpoint('BASE_URL_APPRAISAL_APP_API'));
            }

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }


    public static function deleteBehavioralCompetenceByAdmin($data, $identifier = null) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $action = endpoint('BEHAVIORAL_COMPETENCES_DELETE');
            $resp = ApiHandler::makeDeleteRequest($action, $identifier, $data,true, $token,endpoint('BASE_URL_APPRAISAL_APP_API'));

            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function deleteBehavioralCompetenceCategoryByAdmin($data, $identifier = null) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $action = endpoint('BEHAVIORAL_COMPETENCE_CATEGORY_DELETE');
            $resp = ApiHandler::makeDeleteRequest($action, $identifier, $data,true, $token,endpoint('BASE_URL_APPRAISAL_APP_API'));

            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }


    public static function saveBehavioralCompetenceCategory($data, $update = false,$identifier = null) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            if(!$update){
                $action = endpoint('BEHAVIORAL_COMPETENCE_CATEGORY_SAVE');
                $resp = ApiHandler::makePostRequest($action, $data,true, $token,endpoint('BASE_URL_APPRAISAL_APP_API'));
            }else{
                $action = endpoint('BEHAVIORAL_COMPETENCE_CATEGORY_UPDATE');
                $resp = ApiHandler::makePutRequest($action, $identifier, $data,true, $token,endpoint('BASE_URL_APPRAISAL_APP_API'));
            }

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }


    public static function getBehaviorCompetenceCategories($token) {

        $baseResp = new ApiResp();

        try{

            $action = endpoint('BEHAVIORAL_COMPETENCE_CATEGORY_ALL');

            $resp = ApiHandler::makeGetRequest($action, true, $token,null,endpoint('BASE_URL_APPRAISAL_APP_API'));

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            $baseResp->result = DataFormatter::formatBehavioralCompetenceCategories($apiResult['data']);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function updateAppraisalApprovers($data) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $action = endpoint('APPRAISAL_UPDATE_APPROVERS');
            $resp = ApiHandler::makePostRequest($action, $data,true, $token,endpoint('BASE_URL_APPRAISAL_APP_API'));

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }



    public static function saveAdminCompetence($data, $update = false,$identifier = null) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            if(!$update){
                $action = endpoint('COMPETENCES_SAVE');
                $resp = ApiHandler::makePostRequest($action, $data,true, $token,endpoint('BASE_URL_APPRAISAL_APP_API'));
            }else{
                $action = endpoint('COMPETENCES_UPDATE');
                $resp = ApiHandler::makePutRequest($action, $identifier, $data,true, $token,endpoint('BASE_URL_APPRAISAL_APP_API'));
            }

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function saveBehavioralCompetence($data, $update = false,$identifier = null) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            if(!$update){
                $action = endpoint('BEHAVIORAL_COMPETENCES_SAVE');
                $resp = ApiHandler::makePostRequest($action, $data,true, $token,endpoint('BASE_URL_APPRAISAL_APP_API'));
            }else{
                $action = endpoint('BEHAVIORAL_COMPETENCES_UPDATE');
                $resp = ApiHandler::makePutRequest($action, $identifier, $data,true, $token,endpoint('BASE_URL_APPRAISAL_APP_API'));
            }

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }


    public static function deleteAcademicBackground($data, $identifier = null) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $action = endpoint('USERS_USER_ACADEMIC_BG_DELETE');
            $resp = ApiHandler::makeDeleteRequest($action, $identifier, $data,true, $token);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }


    public static function deleteUserContract($data, $identifier = null) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $action = endpoint('USER_CONTRACT_DELETE');
            $resp = ApiHandler::makeDeleteRequest($action, $identifier, $data,true, $token);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }



    public static function saveUserContract($data, $update = false,$identifier = null) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            if(!$update){
                $action = endpoint('USER_CONTRACT_SAVE');
                $resp = ApiHandler::makePostRequest($action, $data,true, $token);
            }else{
                $action = endpoint('USER_CONTRACT_UPDATE');
                $resp = ApiHandler::makePutRequest($action, $identifier, $data,true, $token);
            }

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            /* $apiAppraisal = json_decode($apiResult['data'],true);
             $baseResp->result = DataFormatter::getApiAppraisal($apiAppraisal);*/
            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }


    public static function saveStrategicObjective($data, $update = false,$identifier = null) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            if(!$update){
                $action = endpoint('APPRAISAL_STRATEGIC_OBJECTIVES_SAVE');
                $resp = ApiHandler::makePostRequest($action, $data,true, $token);
            }else{
                $action = endpoint('APPRAISAL_STRATEGIC_OBJECTIVES_UPDATE');
                $resp = ApiHandler::makePutRequest($action, $identifier, $data,true, $token);
            }

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function deleteStrategicObjective($data, $identifier = null) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $action = endpoint('APPRAISAL_STRATEGIC_OBJECTIVES_DELETE');
            $resp = ApiHandler::makeDeleteRequest($action, $identifier, $data,true, $token);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }


    public static function getUsersAcademicBackgrounds($username) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            /*
             * We have failed to get an access token
             * */
            if(is_null($token)){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN;
                return $baseResp;
            }

            $action = endpoint('USERS_USER_ACADEMIC_BG_ALL');
            $resp = ApiHandler::makeGetRequest($action, true, $token, $username);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $baseResp->result = DataFormatter::formatUserAcademicBackgrounds($apiResult['data']);

            return $baseResp;

        }catch (\Exception $exception){
            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function getUsersContracts($username) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            /*
             * We have failed to get an access token
             * */
            if(is_null($token)){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN;
                return $baseResp;
            }

            $action = endpoint('USER_CONTRACT_ALL');
            $resp = ApiHandler::makeGetRequest($action, true, $token, $username);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $baseResp->result = DataFormatter::formatUserContracts($apiResult['data']);

            return $baseResp;

        }catch (\Exception $exception){
            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }


    public static function getAdminCompetenceCategories($token) {

        $baseResp = new ApiResp();

        try{

            $action = endpoint('COMPETENCE_CATEGORY_ALL');

            $resp = ApiHandler::makeGetRequest($action, true, $token,null,endpoint('BASE_URL_APPRAISAL_APP_API'));

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            $baseResp->result = DataFormatter::formatAdminCompetenceCategories($apiResult['data']);

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function deleteCompetenceCategory($data, $identifier = null) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $action = endpoint('COMPETENCE_CATEGORY_DELETE');
            $resp = ApiHandler::makeDeleteRequest($action, $identifier, $data,true, $token,endpoint('BASE_URL_APPRAISAL_APP_API'));

            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }



    public static function getOrganizations() {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);
            $resp = ApiHandler::makeGetRequest(endpoint('ORGANIZATIONS_ALL'), true, $token);

            /*
             * Failed to get a response from the server
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $resp->statusDescription;
            }


            $apiResp = json_decode($resp->result, true);;
            $statusCode = $apiResp['statusCode'];
            $statusDescription = $apiResp['statusDescription'];

            /*
             * Failed to get the organizations from the server
             * */
            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $statusDescription;
            }

            $organizations = DataFormatter::formatOrganizations($apiResp['data']);

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            $baseResp->result = $organizations;

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }



    public static function getDepartments() {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);
            $resp = ApiHandler::makeGetRequest(endpoint('DEPARTMENTS_ALL'), true, $token);

            /*
             * Failed to get a response from the server
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $resp->statusDescription;
            }


            $apiResp = json_decode($resp->result, true);;
            $statusCode = $apiResp['statusCode'];
            $statusDescription = $apiResp['statusDescription'];

            /*
             * Failed to get the organizations from the server
             * */
            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $statusDescription;
            }

            $organizations = DataFormatter::formatDepartments($apiResp['data']);

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            $baseResp->result = $organizations;

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function getDesignations() {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);
            $resp = ApiHandler::makeGetRequest('/designations', true, $token);

            /*
             * Failed to get a response from the server
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            $apiResp = json_decode($resp->result);;
            $statusCode = $apiResp->statusCode;
            $statusDescription = $apiResp->statusDescription;

            /*
             * Failed to get the organizations from the server
             * */
            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $designations = $apiResp->data;

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            $baseResp->result = $designations;

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function saveDesignation($data, $update = false,$identifier = null) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            if(!$update){
                $action = '/designation';
                $resp = ApiHandler::makePostRequest($action, $data,true, $token);
            }else{
                $action = '/designation';
                $resp = ApiHandler::makePutRequest($action, $identifier, $data,true, $token);
            }

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }
    }

    public static function deleteDesignation($data, $identifier = null) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $action = '/designation';
            $resp = ApiHandler::makeDeleteRequest($action, $identifier, $data,true, $token);

            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }


    public static function getDepartmentUnits() {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);
            $resp = ApiHandler::makeGetRequest(endpoint('DEPARTMENT_UNIT_ALL'), true, $token);
            /*
             * Failed to get a response from the server
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $resp->statusDescription;
            }


            $apiResp = json_decode($resp->result, true);
            $statusCode = $apiResp['statusCode'];
            $statusDescription = $apiResp['statusDescription'];

            /*
             * Failed to get the organizations from the server
             * */
            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $statusDescription;
            }

            $units = DataFormatter::formatDepartmentUnits($apiResp['data']);

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            $baseResp->result = $units;

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }



    public static function getEmployeeCategories() {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);
            $resp = ApiHandler::makeGetRequest(endpoint('EMPLOYEE_CATEGORIES_ALL'), true, $token);

            /*
             * Failed to get a response from the server
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $resp->statusDescription;
            }


            $apiResp = json_decode($resp->result, true);;
            $statusCode = $apiResp['statusCode'];
            $statusDescription = $apiResp['statusDescription'];

            /*
             * Failed to get the organizations from the server
             * */
            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $statusDescription;
            }

            $employeeCategories = DataFormatter::formatEmployeeCategories($apiResp['data']);

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            $baseResp->result = $employeeCategories;

            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }


    public static function getAdminCompetencesForACompetenceCategory($competenceCategoryId) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            /*
             * We have failed to get an access token
             * */
            if(is_null($token)){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN;
                return $baseResp;
            }

            $action = endpoint('COMPETENCES_FOR_CATEGORY_ID');
            $resp = ApiHandler::makeGetRequest($action, true, $token, $competenceCategoryId,endpoint('BASE_URL_APPRAISAL_APP_API'));

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $baseResp->result = DataFormatter::formatAdminCompetences($apiResult['data']);

            return $baseResp;

        }catch (\Exception $exception){
            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }


    public static function getBehavioralCompetencesForACompetenceCategory($competenceCategoryCode) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            /*
             * We have failed to get an access token
             * */
            if(is_null($token)){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN;
                return $baseResp;
            }

            $action = endpoint('BEHAVIORAL_COMPETENCES_FOR_CATEGORY_ID');
            $resp = ApiHandler::makeGetRequest($action, true, $token, $competenceCategoryCode,endpoint('BASE_URL_APPRAISAL_APP_API'));

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;

            $baseResp->result = DataFormatter::formatBehavioralCompetences($apiResult['data']);

            return $baseResp;

        }catch (\Exception $exception){
            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }


    public static function deleteCompetenceByAdmin($data, $identifier = null) {

        $baseResp = new ApiResp();

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $action = endpoint('COMPETENCES_DELETE');
            $resp = ApiHandler::makeDeleteRequest($action, $identifier, $data,true, $token,endpoint('BASE_URL_APPRAISAL_APP_API'));

            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }


    public static function saveErrorLog($data) {

        $baseResp = new ApiResp();

        try{

            $action = endpoint('ERROR_LOG_SAVE');
            $resp = ApiHandler::makePostRequest($action, $data);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            return $baseResp;

        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }


    public static function appraisalCancel($appraisalRef, $token = null) {

        $baseResp = new ApiResp();

        try{

            if(is_null($token)){
                $token = Cookie::get(Security::$COOKIE_TOKEN);
            }

            /*
             * We have failed to get an access token
             * */
            if(is_null($token)){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN;
                return $baseResp;
            }

            $identifier = $appraisalRef;
            $action = endpoint('APPRAISAL_WORKFLOW_CANCEL');

            $resp = ApiHandler::makeGetRequest($action, true, $token, $identifier);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;
            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;
            }

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = $statusDescription;
            return $baseResp;

        }catch (\Exception $exception){
            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }

    public static function sendEmisAuthenticationRequest($data) {

        $baseResp = new ApiResp();

        try{

            $action = endpoint('EMIS_APP_AUTHENTICATION_END_POINT');
            $baseURL = endpoint('EMIS_API_BASE_URL');
            $resp = ApiHandler::makePostRequest($action, $data,false,null,$baseURL);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $resp->statusDescription;
                return $baseResp;

            }

            /*
             * Here got a response from the server, so we get the response from the server
             * */
            $apiResult = json_decode($resp->result, true);

            /*
             * Get the status code from the API
             * */
            $statusCode = $apiResult['success'];

            if($statusCode != true){

                $statusDescription = $apiResult['message'];
                $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
                $baseResp->statusDescription = $statusDescription;
                return $baseResp;

            }

            $encryptedUserToken = $apiResult['user_id'];

            $baseResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
            $baseResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
            $baseResp->result = $encryptedUserToken;
            return $baseResp;


        }catch (\Exception $exception){

            $baseResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $baseResp->statusDescription = AppConstants::generalError($exception);
            return $baseResp;
        }

    }


}