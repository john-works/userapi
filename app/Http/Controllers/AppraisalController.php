<?php

namespace App\Http\Controllers;

use App\AddAssignmentsSummary;
use App\Appraisal;
use App\AssignmentsSummary;
use App\CompetenceSummary;
use app\Helpers\ApiHandler;
use app\Helpers\AppConstants;
use app\Helpers\ConstAppraisalStatus;
use app\Helpers\DataFormatter;
use app\Helpers\DataGenerator;
use app\Helpers\DataLoader;
use app\Helpers\EndPoints;
use app\Helpers\Security;
use app\Helpers\SharedCommons;
use App\Http\Requests\SectionARequest;
use app\Models\ApiAppraisal;
use app\Models\ApiAppraisalReq;
use app\Models\ApiUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class AppraisalController extends BaseController
{

    private  $formDataSavedMessage = "Appraisal form has been created, please continue to fill in the relevant sections, when done click the SUBMIT button at the end of the Form";
    private  $formDataUpdateMessage = "Appraisal form data has been updated successfully";

    public function __construct() {

        parent::__construct(AppConstants::$ACTIVE_MOD_APPRAISAL);
    }

    public function index(){
        return $this->getView();
    }

    private function getView(ApiAppraisal $appraisal = null, $formMessage =  null, $workFlowStep = null,
                             $visibleSections = [],$activeStep = null, $isError = false, $msg = null) {

        /*
         * 1. Get the strategic objectives based on the user's organization
         * 2. Get the competences based on the user's organization and employee category
         * */

        /*
         * Get the logged in user
         * */
        $user = session(Security::$SESSION_USER);

        /*
         * Get strategic objectives
         * */
        $token = Cookie::get(Security::$COOKIE_TOKEN);
        $baseResp = DataLoader::getStrategicObjectives($token);

        $assessmentScores = $this->getAppraisalCompetenceAssessments($appraisal);
        $baseResp1 = isset($appraisal) ? DataLoader::getCategorizedCompetences($token, $appraisal->appraisalRef, $assessmentScores) :  DataLoader::getCategorizedCompetences($token);
        $baseResp2 = DataLoader::getUsersAcademicBackgrounds($user->username);
        $baseResp3 = DataLoader::allUsers();

        $strategicObjectives = $baseResp->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $baseResp->result : [];
        $categorizedCompetences = $baseResp1->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $baseResp1->result : [];
        $institutions = $baseResp2->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $baseResp2->result : [];
        $users = $baseResp3->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $baseResp3->result : [];


        $editClass = $this->checkIfAuthUserCanEditAtThisStage($appraisal,$user);
        $doneSteps = [];
        $activeStep = !isset($activeStep) ? 'NONE' : $activeStep;
        $defaultActiveStepIndex = $this->getDefaultActiveStepIndex($activeStep);
        $active_module = AppConstants::$ACTIVE_MOD_MY_APPRAISALS;

        $viewParams = [];
        $viewParams[] = ['editClass','appraisal','user','active_module','doneSteps','activeStep',
            'strategicObjectives', 'categorizedCompetences','institutions','users','isError','msg','defaultActiveStepIndex'];

        if($formMessage != null){
            $viewParams[] = 'formMessage';
        }

        if($workFlowStep == null){
            $workFlowStep = AppConstants::$WORK_FLOW_STEP1_OWNER;
            $viewParams[] = 'workFlowStep';
        }else{
            $viewParams[] = 'workFlowStep';
        }

        /*
         * I add the condition true == false because I want all sections to be visible
         * */
        if(count($visibleSections) > 0 && true == false){
            $viewParams[] = 'visibleSections';
        }else{
            $visibleSections = DataGenerator::formStepAllSections();
            $viewParams[] = 'visibleSections';
        }

        return view('appraisals/appraisal_form', compact($viewParams));

     }

    public function saveSectionA(SectionARequest $request){

        /*
         * Check if we are saving for the first time
         * */
        if($request->has('save')){

            return $this->saveSectionAData($request);

        }
        /*
         * Here we are updating
         * */


        return $this->updateSectionAData($request);

    }

    private function saveSectionAData(Request $request) {

        try{

            /*
             * Save the info via the API
             * */
            $token = Cookie::get(Security::$COOKIE_TOKEN);
            $user = session(Security::$SESSION_USER);

            /*
             * We failed to get the logged in user
             * */
            if($user == null){
                return $this->redirectBackToFormWithError(AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN);
            }

            /*
             * Request data
             * */
            $data = [
                'owner_id' => $user->username,
                'appraisal_type' => $request['appraisal_type'],
                'supervisor_id' => $request['supervisor'],
                'department_head_id' => $request['hod'],
                'executive_director_id' => $request['ed'],
                'person_info_staff_number' => $request['staff_file_number'],
                'person_info_first_name' => $request['other_name'],
                'person_info_last_name' => $request['surname'],
                'person_info_department' => $request['department'],
                'person_info_designation' => $request['designation'],
                'person_info_employee_category' => $request['employee_category'],
                'person_info_date_of_birth' => $request['dob'],
                'person_info_appraisal_period_start_date' => $request['appraisal_start_date'],
                'person_info_appraisal_period_end_date' => $request['appraisal_end_date'],
                'person_info_contract_start_date' => $request['contract_start_date'],
                'person_info_contract_expiry_date' => $request['contract_expiry_date'],
            ];

            /*
             * Action
             * */
            $action = endpoint('APPRAISAL_SAVE_APPRAISAL');


            /*
             * Send request to the API
             * */
            $resp = ApiHandler::makePostRequest($action, $data, true, $token);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->redirectBackToFormWithError($resp->statusDescription);
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
                return $this->redirectBackToFormWithError($statusDescription);
            }


            /*
             * Operation was successful at the server side
             * */
            $apiAppraisal = json_decode($apiResult['data'],true);
            $appraisal = DataFormatter::getApiAppraisal($apiAppraisal);
            return $this->getView($appraisal,$this->formDataSavedMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_B),AppConstants::$SECTION_B);


        }catch (\Exception $exception){

            /*An exception occurred on saving the form, we need to redirect back with the error */

            $error = AppConstants::generalError($exception->getMessage());
            return $this->redirectBackToFormWithError($error);

        }


    }

    private function updateSectionAData(Request $request) {


        try{

            /*
             * Save the info via the API
             * */

            $appraisalRef = $request['appraisal'];
            $identifier = $request['code'];
            $token = Cookie::get(Security::$COOKIE_TOKEN);
            $user = session(Security::$SESSION_USER);

            /*
             * We failed to get the logged in user
             * */
            if($user == null){
                return $this->redirectBackToFormWithError(AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN);
            }

            /*
             * Request data
             * */
            $data = [
                'appraisal_reference' => $appraisalRef,
                'staff_number' => $request['staff_file_number'],
                'first_name' => $request['other_name'],
                'last_name' => $request['surname'],
                'department' => $request['department'],
                'designation' => $request['designation'],
                'date_of_birth' => $request['dob'],
                'appraisal_type' => $request['appraisal_type'],
                'supervisor_id' => $request['supervisor'],
                'department_head_id' => $request['hod'],
                'executive_director_id' => $request['ed'],
                'appraisal_period_start_date' => $request['appraisal_start_date'],
                'appraisal_period_end_date' => $request['appraisal_end_date'],
                'contract_start_date' => $request['contract_start_date'],
                'contract_expiry_date' => $request['contract_expiry_date'],
                'employee_category' => $request['employee_category'],
            ];


            /*
             * Action
             * */
            $action = endpoint('APPRAISAL_PERSONAL_DETAILS_UPDATE');


            /*
             * Send request to the API
             * */
            $resp = ApiHandler::makePutRequest($action,$identifier, $data, true, $token);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->redirectBackToFormWithError($resp->statusDescription);
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
                return $this->redirectBackToFormWithError($statusDescription);
            }


            /*
             * Operation was successful at the server side
             * */
            $apiAppraisal = json_decode($apiResult['data'],true);
            $appraisal = DataFormatter::getApiAppraisal($apiAppraisal);
            //  return $appraisal;
            return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_B),AppConstants::$SECTION_B);


        }catch (\Exception $exception){

            /*An exception occurred on saving the form, we need to redirect back with the error */
            $error = AppConstants::generalError($exception->getMessage());
            return $this->redirectBackToFormWithError($error);

        }


    }

    public function saveSectionB(Request $request){


        try{

            //it's the first time we saving section B
            if($request->has('save')){

                //get the appraisal form ID
                $appraisalRef = $request['appraisal'];

                //how do I dynamically get the max_rows passed
                //if it's numeric we take the value, else we assume we did not receive any values
                $countRowsPassed = is_numeric($request['counter_max_rows']) ? $request['counter_max_rows'] : 0;


                //define array to hold the schools
                $institutions = [];

                //now we loop through all the rows saving the data therein
                for($i = 1; $i<= $countRowsPassed; $i++){

                    $school = $request['school_'.$i];
                    $year = $request['year_of_study_'.$i];
                    $award = $request['award_'.$i];

                    //institute object
                    $institute = [];
                    $institute['school'] = $school;
                    $institute['year'] = $year;
                    $institute['award'] = $award;

                    //Add to institute list
                    $institutions[] = $institute;

                }


                //we now have to save these institutes using the API
                $token = Cookie::get(Security::$COOKIE_TOKEN);
                $data = [];
                $data['appraisal_reference'] = $appraisalRef;
                $data['institutions'] = $institutions;

                $baseResp = DataLoader::saveAcademicInstitutes($token, $data);

                if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                    $msg = $baseResp->statusDescription;
                    $respAppraisal = DataLoader::getAppraisalByAppraisalReference($appraisalRef);
                    $appraisal = $respAppraisal->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $respAppraisal->result : null;
                    return $this->getView($appraisal,null,null,DataGenerator::visibleSections(AppConstants::$SECTION_B),AppConstants::$SECTION_B,true,$msg);

                }

                $appraisal = $baseResp->result;
                return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_C),AppConstants::$SECTION_C);

            }
            else{

                //get the appraisal form ID
                $appraisalRef = $request['appraisal'];

                //dynamically get the count of rows passed
                $countRowsPassed = is_numeric($request['counter_max_rows_update']) ? $request['counter_max_rows_update'] : 0;

                //hold list of institutions
                $institutions = [];

                //loop through the rows passed as we update the data
                for($i = 1; $i<= $countRowsPassed; $i++){

                    $recordId  = $request['record_id_'.$i];
                    $school = $request['school_'.$i];
                    $year = $request['year_of_study_'.$i];
                    $award = $request['award_'.$i];

                    //institute object
                    $institute = [];
                    $institute['school'] = $school;
                    $institute['year'] = $year;
                    $institute['award'] = $award;

                    //if this is not set, then it's a new row being created, so in that case we do not set the record id field
                    if(isset($recordId)){
                        $institute['record_id'] = $recordId;
                    }

                    //Add to institute list
                    $institutions[] = $institute;

                }

                //we now have to save these institutes using the API
                $token = Cookie::get(Security::$COOKIE_TOKEN);
                $data = [];
                $data['appraisal_reference'] = $appraisalRef;
                $data['institutions'] = $institutions;

                //make request to the API
                $baseResp = DataLoader::saveAcademicInstitutes($token, $data, true);

                if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                    $msg = $baseResp->statusDescription;
                    $appraisal = null;
                    return $this->getView($appraisal,null,null,DataGenerator::visibleSections(AppConstants::$SECTION_B),AppConstants::$SECTION_B,true,$msg);

                }

                $appraisal = $baseResp->result;
                return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_C),AppConstants::$SECTION_C);

            }

        }catch (\Exception $exception){

            /*An exception occurred on saving the form, we need to redirect back with the error */

            $error = AppConstants::generalError($exception->getMessage());
            return $this->getView(null,null,null,[],null,true,$error);

        }

    }


    public function saveSectionC(Request $request) {


        try{

            if($request->has('save')){
                //do saving

                //get the appraisal form ID
                $appraisalRef = $request['appraisal'];

                //how do I dynamically get the max_rows passed
                //if it's numeric we take the value, else we assume we did not receive any values
                $countRowsPassed = is_numeric($request['counter_max_rows_key_duty']) ? $request['counter_max_rows_key_duty'] : 0;


                //define array to data
                $keyDuties = [];

                //now we loop through all the rows saving the data therein
                for($i = 1; $i<= $countRowsPassed; $i++){

                    $objective = $request['objective_'.$i];
                    $assignment = $request['assignment_'.$i];
                    $expectedOutput = $request['expected_output_'.$i];
                    $maxRating = $request['max_rating_'.$i];
                    $timeFrame = $request['time_frame_'.$i];

                    //duty object
                    $duty = [];
                    $duty['objective_id'] = $objective;
                    $duty['job_assignment'] = $assignment;
                    $duty['expected_output'] = $expectedOutput;
                    $duty['maximum_rating'] = $maxRating;
                    $duty['time_frame'] = $timeFrame;

                    //Add to duties list
                    $keyDuties[] = $duty;

                }


                //we now have to save these institutes using the API
                $token = Cookie::get(Security::$COOKIE_TOKEN);
                $data = [];
                $data['appraisal_reference'] = $appraisalRef;
                $data['key_duties'] = $keyDuties;

                $baseResp = DataLoader::saveKeyDuties($token, $data);

                if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                    return $this->redirectBackToFormWithError($baseResp->statusDescription);

                }

                $appraisal = $baseResp->result;
                return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_D),AppConstants::$SECTION_D);

            }
            else{
                //do update

                //get the appraisal form ID
                $appraisalRef = $request['appraisal'];

                //how do I dynamically get the max_rows passed
                //if it's numeric we take the value, else we assume we did not receive any values
                $countRowsPassed = is_numeric($request['counter_max_rows_key_duty']) ? $request['counter_max_rows_key_duty'] : 0;


                //define array to data
                $keyDuties = [];

                //now we loop through all the rows saving the data therein
                for($i = 1; $i<= $countRowsPassed; $i++){

                    $objective = $request['objective_'.$i];
                    $assignment = $request['assignment_'.$i];
                    $expectedOutput = $request['expected_output_'.$i];
                    $maxRating = $request['max_rating_'.$i];
                    $timeFrame = $request['time_frame_'.$i];
                    $recordId = $request['record_id_'.$i];

                    //duty object
                    $duty = [];
                    $duty['objective_id'] = $objective;
                    $duty['job_assignment'] = $assignment;
                    $duty['expected_output'] = $expectedOutput;
                    $duty['maximum_rating'] = $maxRating;
                    $duty['time_frame'] = $timeFrame;

                    //if no recordId, then it's a new being added dynamically
                    if(isset($recordId)){
                        $duty['record_id'] = $recordId;
                    }

                    //Add to duties list
                    $keyDuties[] = $duty;

                }

                //we now have to save these institutes using the API
                $token = Cookie::get(Security::$COOKIE_TOKEN);
                $data = [];
                $data['appraisal_reference'] = $appraisalRef;
                $data['key_duties'] = $keyDuties;

                $baseResp = DataLoader::saveKeyDuties($token, $data,true);

                if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                    return $this->redirectBackToFormWithError($baseResp->statusDescription);

                }

                $appraisal = $baseResp->result;
                return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_D),AppConstants::$SECTION_D);

            }

        }catch (\Exception $exception){
            /*An exception occurred on saving the form, we need to redirect back with the error */
            $error = AppConstants::generalError($exception->getMessage());
            $this->redirectBackToFormWithError($error);

        }

    }

    public function saveSectionD(Request $request) {

        try{

            /*
             * We are saving
             * */
            if($request->has('save')){
                return $this->sectionDSave($request);
            }


            /*
             * We are updating
             * */
            return $this->sectionDUpdate($request);


        }catch (\Exception $exception){
            /*An exception occurred on saving the form, we need to redirect back with the error */
            $error = AppConstants::generalError($exception->getMessage());
            return $this->getView(null,null,null,[],null,true,$error);
        }

    }

    public function saveSectionDAdditional(Request $request){

        try{

            if($request->has('save')){

                return $this->sectionDAdditionalSave($request);

            }
            else{

                return $this->sectionDAdditionalUpdate($request);

            }

        }catch (\Exception $exception){

            /*An exception occurred on saving the form, we need to redirect back with the error */
            $error = AppConstants::generalError($exception->getMessage());
            return $this->redirectBackToFormWithError($error);

        }

    }

    public function saveSectionE(Request $request){

        try{

            if($request->has('save')){

                return $this->sectionESave($request);

            }else{

                return $this->sectionEUpdate($request);

            }

        }catch (\Exception $exception){

            /*An exception occurred on saving the form, we need to redirect back with the error */
            $error = AppConstants::generalError($exception->getMessage());
            return $this->redirectBackToFormWithError($error);

        }

    }

    private function sectionESave($request){


        $appraisalRef = $request['appraisal'];

        //get the competence categories
        $token = Cookie::get(Security::$COOKIE_TOKEN);
        $baseResp = DataLoader::getCategorizedCompetences($token, $appraisalRef);
        $categorizedCompetences = $baseResp->statusCode === AppConstants::$STATUS_CODE_SUCCESS ? $baseResp->result : [];

        //list to hold data to send to API
        $competencesList = [];

        //loop through the categories
        foreach ($categorizedCompetences as $category){

            $categoryId = $category->id;
            $competences = $category->appraisalCompetences;

            //foreach competence check for it's values
            foreach ($competences as $item){

                $maxRating = $item->rating;
                $competenceId = $item->id;

                $appraiseeRating = $request[$categoryId.'_appraisee_rating_'.$competenceId];
                $appraiserRating = $request[$categoryId.'_appraiser_rating_'.$competenceId];
                $agreedRating = $request[$categoryId.'_agreed_rating_'.$competenceId];

                $competenceData = [];
                $competenceData['competence_category_id'] = $categoryId;
                $competenceData['appraisal_competence_id'] = $competenceId;

                /*
                 * Some of these fields may be empty e.g if the appraisal is at the appraisee level and
                 * the appraise has not put in their marks. So in this case i dont send them to server because the server
                 * would validate them and it expects only numeric if the values are sent
                 * */
                if(isset($maxRating) && !empty($maxRating)){
                    $competenceData['maximum_rating'] = $maxRating;
                }
                if(isset($appraiseeRating) && !empty($appraiseeRating)){
                    $competenceData['appraisee_rating'] = $appraiseeRating;
                }
                if(isset($appraiserRating) && !empty($appraiserRating)){
                    $competenceData['appraiser_rating'] = $appraiserRating;
                }
                if(isset($agreedRating) && !empty($agreedRating)){
                    $competenceData['agreed_rating'] = $agreedRating;
                }


                //add to list
                $competencesList[] = $competenceData;

            }

        }

        $data = [];
        $data['appraisal_reference'] = $appraisalRef;
        $data['assessments'] = $competencesList;

        $baseResp1 = DataLoader::saveCompetenceAssessments($token, $data);

        if($baseResp1->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            $msg = $baseResp1->statusDescription;
            return $this->redirectBackToFormWithError($msg);
        }

        $appraisal = $baseResp1->result;



        /*
         * Begin the saving of the scores
         * */

        $dataNext = [];
        $dataNext['appraisal_reference'] = $appraisalRef;
        $dataNext['total_maximum_rating'] = $request['secEmaxTotal'];

        if(isset($request['secEappraiseeTotal']) && !empty($request['secEappraiseeTotal'])){
            $dataNext['total_appraisee_rating'] = $request['secEappraiseeTotal'];
        }
        if(isset($request['secEappraiserTotal']) && !empty($request['secEappraiserTotal'])){
            $dataNext['total_appraiser_rating'] = $request['secEappraiserTotal'];
        }
        if(isset($request['secEagreedTotal']) && !empty($request['secEagreedTotal'])){
            $dataNext['total_agreed_rating'] = $request['secEagreedTotal'];
        }

        $baseRespNext = DataLoader::saveCompetenceAssessmentsScore($dataNext);

        if($baseRespNext->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            $msg = $baseRespNext->statusDescription;
            return $this->redirectBackToFormWithError($msg);

        }
        $appraisal = $baseRespNext->result;

        /*
         * End saving of the scores
         * */





        /*
         * Start saving of the summary
         * */

        $secEFinalPercentageScore = $request['sec_e_final_percentage_score'];
        $secEWeighed = $request['sec_e_weighed'];
        $finalScoreSecD = $request['FinalScoreSecD'];
        $finalScoreSecE = $request['FinalScoreSecE'];
        $overallTotal = $request['OverallTotal'];

        if(!$this->validInputSectionESummary($secEFinalPercentageScore, $secEWeighed, $finalScoreSecD, $finalScoreSecE, $overallTotal)){

            /*
             * If the validation fails, I dont attempt to save the summary
             * */
            return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_F),AppConstants::$SECTION_F);

        }

        $dataSummary = [
            'appraisal_reference' => $appraisalRef,
            'section_e_percentage_score' => $secEFinalPercentageScore,
            'section_e_weighed_score' => $secEWeighed,
            'section_d_score' => $finalScoreSecD,
            'section_e_score' => $finalScoreSecE,
            'appraisal_total_score' => $overallTotal,
        ];

        $baseRespSummary = DataLoader::saveCompetenceAssessmentsSummary($dataSummary);
        if($baseRespSummary->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            $msg = $baseRespSummary->statusDescription;
            return $this->redirectBackToFormWithError($msg);
        }
        $appraisal = $baseRespSummary->result;


        /*
         * End saving of the summary
         * */


        return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_F),AppConstants::$SECTION_F);

    }

    private function sectionEUpdate($request){

        $appraisalRef = $request['appraisal'];

        //get the competence categories
        $token = Cookie::get(Security::$COOKIE_TOKEN);
        $baseResp = DataLoader::getCategorizedCompetences($token, $appraisalRef);
        $categorizedCompetences = $baseResp->statusCode === AppConstants::$STATUS_CODE_SUCCESS ? $baseResp->result : [];

        //list to hold data to send to API
        $competencesList = [];

        //loop through the categories
        foreach ($categorizedCompetences as $category){

            $categoryId = $category->id;
            $competences = $category->appraisalCompetences;

            //foreach competence check for it's values
            foreach ($competences as $item){

                $maxRating = $item->rating;
                $competenceId = $item->id;

                $appraiseeRating = $request[$categoryId.'_appraisee_rating_'.$competenceId];
                $appraiserRating = $request[$categoryId.'_appraiser_rating_'.$competenceId];
                $agreedRating = $request[$categoryId.'_agreed_rating_'.$competenceId];
                $recordId = $request[$categoryId.'_record_id_'.$competenceId];

                $competenceData = [];
                $competenceData['record_id'] = $recordId;
                $competenceData['competence_category_id'] = $categoryId;
                $competenceData['appraisal_competence_id'] = $competenceId;

                /*
                 * Some of these fields may be empty e.g if the appraisal is at the appraisee level and
                 * the appraise has not put in their marks. So in this case i dont send them to server because the server
                 * would validate them and it expects only numeric if the values are sent
                 * */
                if(isset($maxRating) && !empty($maxRating)){
                    $competenceData['maximum_rating'] = $maxRating;
                }
                if(isset($appraiseeRating) && !empty($appraiseeRating)){
                    $competenceData['appraisee_rating'] = $appraiseeRating;
                }
                if(isset($appraiserRating) && !empty($appraiserRating)){
                    $competenceData['appraiser_rating'] = $appraiserRating;
                }
                if(isset($agreedRating) && !empty($agreedRating)){
                    $competenceData['agreed_rating'] = $agreedRating;
                }

                //add to list
                $competencesList[] = $competenceData;

            }

        }


        $data = [];
        $data['appraisal_reference'] = $appraisalRef;
        $data['assessments'] = $competencesList;

        $baseResp1 = DataLoader::saveCompetenceAssessments($token, $data,true);

        if($baseResp1->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            $msg = $baseResp1->statusDescription;
            $respNext= DataLoader::getAppraisalByAppraisalReference($appraisalRef);
            $appraisal = $respNext->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $respNext->result : null;
            return $this->getView($appraisal,null,null,DataGenerator::visibleSections(AppConstants::$SECTION_E),AppConstants::$SECTION_E,true,$msg);

        }




        /*
         * Begin saving of the scores
         * */

        $recordId = $request['scores_sec_e_record_id'];

        $dataNext = [];
        $dataNext['record_id'] = $recordId;
        $dataNext['appraisal_reference'] = $appraisalRef;
        $dataNext['total_maximum_rating'] = $request['secEmaxTotal'];

        /*
         * These fields can be empty e.g when the form is at the appraisee and the appraiser has no input in the form
         * */
        if(isset($request['secEappraiseeTotal']) && !empty($request['secEappraiseeTotal'])){
            $dataNext['total_appraisee_rating'] = $request['secEappraiseeTotal'];
        }
        if(isset($request['secEappraiserTotal']) && !empty($request['secEappraiserTotal'])){
            $dataNext['total_appraiser_rating'] = $request['secEappraiserTotal'];
        }
        if(isset($request['secEagreedTotal']) && !empty($request['secEagreedTotal'])){
            $dataNext['total_agreed_rating'] = $request['secEagreedTotal'];
        }


        $baseRespNext = isset($recordId) && !empty($recordId) ?
            DataLoader::saveCompetenceAssessmentsScore($dataNext,true,$recordId) :
            DataLoader::saveCompetenceAssessmentsScore($dataNext);


        if($baseRespNext->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            $msg = $baseRespNext->statusDescription;
            $respNext= DataLoader::getAppraisalByAppraisalReference($appraisalRef);
            $appraisal = $respNext->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $respNext->result : null;
            return $this->getView($appraisal,null,null,DataGenerator::visibleSections(AppConstants::$SECTION_E),AppConstants::$SECTION_E,true,$msg);

        }

        $appraisal = $baseRespNext->result;

        /*
         * End saving of the scores
         * */




        /*
        * Start saving of the summary
        * */

        $recordId = $request['sec_e_summary_record_id'];
        $secEFinalPercentageScore = $request['sec_e_final_percentage_score'];
        $secEWeighed = $request['sec_e_weighed'];
        $finalScoreSecD = $request['FinalScoreSecD'];
        $finalScoreSecE = $request['FinalScoreSecE'];
        $overallTotal = $request['OverallTotal'];

        if(!$this->validInputSectionESummary($secEFinalPercentageScore, $secEWeighed, $finalScoreSecD, $finalScoreSecE, $overallTotal)){

            /*
             * If the validation fails, I dont attempt to save the summary
             * */
            return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_F),AppConstants::$SECTION_F);

        }

        $dataSummary = [
            'appraisal_reference' => $appraisalRef,
            'section_e_percentage_score' => $secEFinalPercentageScore,
            'section_e_weighed_score' => $secEWeighed,
            'section_d_score' => $finalScoreSecD,
            'section_e_score' => $finalScoreSecE,
            'appraisal_total_score' => $overallTotal,
            'record_id' => $recordId,
        ];

        $baseRespSummary = isset($recordId) && !empty($recordId) ?
            DataLoader::saveCompetenceAssessmentsSummary($dataSummary,true,$recordId) :
            DataLoader::saveCompetenceAssessmentsSummary($dataSummary);

        if($baseRespSummary->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            $msg = $baseRespSummary->statusDescription;
            $respNext= DataLoader::getAppraisalByAppraisalReference($appraisalRef);
            $appraisal = $respNext->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $respNext->result : null;
            return $this->getView($appraisal,null,null,DataGenerator::visibleSections(AppConstants::$SECTION_E),AppConstants::$SECTION_E,true,$msg);
        }
        $appraisal = $baseRespSummary->result;

        /*
         * End the saving of the summary
         * */


        return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_F),AppConstants::$SECTION_F);

    }


    public function saveSectionF(Request $request) {

        try{

            $appraisalRef = $request['appraisal'];

            if($request->has('save')){

                //do saving
                //call method to save the performance gaps, save the challenges, save the summary

                //save the gaps
                $baseResp = $this->saveSectionFPerformanceGaps($request);
                if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                    $msg = $baseResp->statusDescription;
                    return $this->redirectBackToFormWithError($msg);
                }

                //save the challenges
                $baseResp = $this->saveSectionFChallenges($request);
                if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                    $msg = "Performance gaps saved, but failed to save challenges with error. " . $baseResp->statusDescription;
                    return $this->redirectBackToFormWithError($msg);
                }


                //Summary start

                $appraisalRef = $request['appraisal'];
                $dataNext = [
                    'appraisal_reference' => $appraisalRef,
                    'appraiser_comment' => $request['appraiser_comment'],
                ];

                $baseRespNext = DataLoader::saveTrainingSummary($dataNext);
                if($baseRespNext->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                    $msg = "Performance gaps and challenges saved but failed to save appraiser's comment with error. " . $baseRespNext->statusDescription;
                    return $this->redirectBackToFormWithError($msg);
                }
                $appraisal = $baseRespNext->result;

                //Summary end


                //return success
                return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_G),AppConstants::$SECTION_G);

            }
            else{

                //do update
                //call method to save the performance gaps, save the challenges, save the summary

                //save the gaps
                $baseResp = $this->updateSectionFPerformanceGaps($request);
                if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                    $msg = $baseResp->statusDescription;
                    $respNext= DataLoader::getAppraisalByAppraisalReference($appraisalRef);
                    $appraisal = $respNext->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $respNext->result : null;
                    return $this->getView($appraisal,null,null,DataGenerator::visibleSections(AppConstants::$SECTION_F),AppConstants::$SECTION_F,true,$msg);
                }

                //save the challenges
                $baseResp = $this->updateSectionFChallenges($request);
                if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                    $msg = "Performance gaps saved, but failed to save challenges with error. " . $baseResp->statusDescription;
                    $respNext= DataLoader::getAppraisalByAppraisalReference($appraisalRef);
                    $appraisal = $respNext->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $respNext->result : null;
                    return $this->getView($appraisal,null,null,DataGenerator::visibleSections(AppConstants::$SECTION_F),AppConstants::$SECTION_F,true,$msg);
                }

                //Summary start

                $appraisalRef = $request['appraisal'];
                $recordId = $request['section_f_summary_record_id'];
                $dataNext = [
                    'appraisal_reference' => $appraisalRef,
                    'appraiser_comment' => $request['appraiser_comment'],
                    'record_id' => $recordId,
                ];

                $baseRespNext = isset($recordId) ? DataLoader::saveTrainingSummary($dataNext,true,$recordId) : DataLoader::saveTrainingSummary($dataNext);
                if($baseRespNext->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                    $msg = "Performance gaps and challenges saved but failed to save appraiser's comment with error. " . $baseRespNext->statusDescription;
                    $respNext= DataLoader::getAppraisalByAppraisalReference($appraisalRef);
                    $appraisal = $respNext->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $respNext->result : null;
                    return $this->getView($appraisal,null,null,DataGenerator::visibleSections(AppConstants::$SECTION_F),AppConstants::$SECTION_F,true,$msg);
                }
                $appraisal = $baseRespNext->result;

                //Summary end

                //return success
                return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_G),AppConstants::$SECTION_G);

            }

        }catch (\Exception $exception){
            /*An exception occurred on saving the form, we need to redirect back with the error */
            $error = AppConstants::generalError($exception->getMessage());
            return $this->redirectBackToFormWithError($error);
        }

    }


    public function saveSectionG(Request $request) {

        try{

            $appraisalRef = $request['appraisal'];
            $recommendationDecision = $request['recommendation_decision'];
            $comment = $request['comment'];

            $data = [];
            $data['appraisal_reference'] = $appraisalRef;
            $data['recommendation'] = $recommendationDecision;
            $data['comment'] = $comment;

            if(!$request->has('record_id')){

                $baseResp = DataLoader::saveAppraiserComment($data,false);

            }else{

                $identifier = $request['record_id'];
                $baseResp = DataLoader::saveAppraiserComment($data,true,$identifier);

            }

            if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $msg = $baseResp->statusDescription;
                return $this->redirectBackToFormWithError($msg);
            }

            $appraisal = $baseResp->result;
            return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_H),AppConstants::$SECTION_H);

        }catch (\Exception $exception){

            $msg = AppConstants::generalError($exception->getMessage());
            return $this->redirectBackToFormWithError($msg);

        }

    }

    public function saveSectionH(Request $request){

        try{

            $appraisalRef = $request['appraisal'];
            $strengths = $request['strengths'];
            $weaknesses = $request['weaknesses'];

            $data = [];
            $data['appraisal_reference'] = $appraisalRef;
            $data['strengths'] = $strengths;
            $data['weaknesses'] = $weaknesses;

            if(!$request->has('record_id')){

                $baseResp = DataLoader::saveStrengthsAndWeaknesses($data,false);

            }else{

                $identifier = $request['record_id'];
                $baseResp = DataLoader::saveStrengthsAndWeaknesses($data,true,$identifier);

            }

            if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $msg = $baseResp->statusDescription;
                return $this->redirectBackToFormWithError($msg);

            }

            $appraisal = $baseResp->result;
            return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_I),AppConstants::$SECTION_I);

        }catch (\Exception $exception){

            $msg = AppConstants::generalError($exception->getMessage());
            return $this->redirectBackToFormWithError($msg);

        }

    }

    public function saveSectionI(Request $request){

        try{

            $appraisalRef = $request['appraisal'];
            $recommendation = $request['recommendation'];

            $data = [];
            $data['appraisal_reference'] = $appraisalRef;
            $data['recommendations'] = $recommendation;

            if(!$request->has('record_id')){

                $baseResp = DataLoader::saveAppraiserRecommendation($data,false);

            }else{

                $identifier = $request['record_id'];
                $baseResp = DataLoader::saveAppraiserRecommendation($data,true,$identifier);

            }

            if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $msg = $baseResp->statusDescription;
                return $this->redirectBackToFormWithError($msg);
            }

            $appraisal = $baseResp->result;
            return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_J),AppConstants::$SECTION_J);

        }catch (\Exception $exception){

            $msg = AppConstants::generalError($exception->getMessage());
            return $this->redirectBackToFormWithError($msg);

        }

    }

    public function saveSectionJ(Request $request){

        try{

            $appraisalRef = $request['appraisal'];
            $appraiserName = $request['appraiser_name'];
            $appraiseeName = $request['appraisee_name'];
            $duration = $request['duration'];
            $startDate = $request['start_date'];
            $endDate = $request['end_date'];

            $data = [];
            $data['appraisal_reference'] = $appraisalRef;
            $data['appraiser_name'] = $appraiserName;
            $data['appraisee_name'] = $appraiseeName;
            $data['duration'] = $duration;
            $data['start_date'] = $startDate;
            $data['end_date'] = $endDate;

            if(!$request->has('record_id')){

                $baseResp = DataLoader::saveSupervisorDeclaration($data,false);

            }else{

                $identifier = $request['record_id'];
                $baseResp = DataLoader::saveSupervisorDeclaration($data,true,$identifier);

            }

            if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $msg = $baseResp->statusDescription;
                return $this->redirectBackToFormWithError($msg);
            }

            $appraisal = $baseResp->result;
            return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_K),AppConstants::$SECTION_K);

        }catch (\Exception $exception){

            $msg = AppConstants::generalError($exception->getMessage());
            return $this->redirectBackToFormWithError($msg);

        }

    }

    public function saveSectionK(Request $request){


        try{

            $appraisalRef = $request['appraisal'];
            $hodComment = $request['comment'];
            $hodName = $request['hod_name'];
            $hodInitials = $request['hod_initials'];
            $date = $request['date'];

            $data = [];
            $data['appraisal_reference'] = $appraisalRef;
            $data['comments'] = $hodComment;
            $data['name'] = $hodName;
            $data['initials'] = $hodInitials;
            $data['date'] = $date;

            if(!$request->has('record_id')){

                $baseResp = DataLoader::saveHodComment($data,false);

            }else{

                $identifier = $request['record_id'];
                $baseResp = DataLoader::saveHodComment($data,true,$identifier);

            }

            if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $msg = $baseResp->statusDescription;
                return $this->redirectBackToFormWithError($msg);
            }

            $appraisal = $baseResp->result;
            return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_L),AppConstants::$SECTION_L);

        }catch (\Exception $exception){

            $msg = AppConstants::generalError($exception->getMessage());
            return $this->redirectBackToFormWithError($msg);

        }

    }

    public function saveSectionL(Request $request) {

        try{

            if($request->has('save')){
                //do saving

                //get the appraisal form ID
                $appraisalRef = $request['appraisal'];

                //how do I dynamically get the max_rows passed
                //if it's numeric we take the value, else we assume we did not receive any values
                $countRowsPassed = is_numeric($request['counter_max_rows_workplan']) ? $request['counter_max_rows_workplan'] : 0;

                //define array to data
                $workPlans = [];

                //now we loop through all the rows saving the data therein
                for($i = 1; $i<= $countRowsPassed; $i++){

                    $assignment = $request['assignment_'.$i];
                    $expectedOutput = $request['expected_output_'.$i];
                    $maxRating = $request['max_rating'.$i];
                    $timeFrame = $request['time_frame_'.$i];

                    //assignment object
                    $plan = [];
                    $plan['job_assignment'] = $assignment;
                    $plan['expected_output'] = $expectedOutput;
                    $plan['maximum_rating'] = $maxRating;
                    $plan['time_frame'] = $timeFrame;
                    //Add to list
                    $workPlans[] = $plan;

                }


                //we now have to save these institutes using the API
                $token = Cookie::get(Security::$COOKIE_TOKEN);
                $data = [];
                $data['appraisal_reference'] = $appraisalRef;
                $data['plans'] = $workPlans;

                $baseResp = DataLoader::saveWorkPlans($token, $data);

                if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                    $msg = $baseResp->statusDescription;
                    return $this->redirectBackToFormWithError($msg);
                }

                $appraisal = $baseResp->result;
                return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_M),AppConstants::$SECTION_M);

            }
            else{
                //do update

                //get the appraisal form ID
                $appraisalRef = $request['appraisal'];

                //how do I dynamically get the max_rows passed
                //if it's numeric we take the value, else we assume we did not receive any values
                $countRowsPassed = is_numeric($request['counter_max_rows_workplan']) ? $request['counter_max_rows_workplan'] : 0;


                //define array to data
                $workPlans = [];

                //now we loop through all the rows saving the data therein
                for($i = 1; $i<= $countRowsPassed; $i++){

                    $assignment = $request['assignment_'.$i];
                    $expectedOutput = $request['expected_output_'.$i];
                    $maxRating = $request['max_rating'.$i];
                    $timeFrame = $request['time_frame_'.$i];

                    // object
                    $plan = [];
                    $plan['job_assignment'] = $assignment;
                    $plan['expected_output'] = $expectedOutput;
                    $plan['maximum_rating'] = $maxRating;
                    $plan['time_frame'] = $timeFrame;

                    $recordId = $request['record_id_'.$i];

                    //if no recordId, then it's a new being added dynamically
                    if(isset($recordId)){
                        $plan['record_id'] = $recordId;
                    }

                    //Add to list
                    $workPlans[] = $plan;

                }

                //we now have to save data using the API
                $token = Cookie::get(Security::$COOKIE_TOKEN);
                $data = [];
                $data['appraisal_reference'] = $appraisalRef;
                $data['plans'] = $workPlans;

                $baseResp = DataLoader::saveWorkPlans($token, $data,true);


                if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                    $msg = $baseResp->statusDescription;
                    $respNext= DataLoader::getAppraisalByAppraisalReference($appraisalRef);
                    $appraisal = $respNext->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $respNext->result : null;
                    return $this->getView($appraisal,null,null,DataGenerator::visibleSections(AppConstants::$SECTION_L),AppConstants::$SECTION_L,true,$msg);

                }

                $appraisal = $baseResp->result;
                return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_M),AppConstants::$SECTION_M);

            }

        }catch (\Exception $exception){
            /*An exception occurred on saving the form, we need to redirect back with the error */
            $error = AppConstants::generalError($exception->getMessage());
            return $this->redirectBackToFormWithError($error);

        }

    }

    public function saveSectionM(Request $request){

        try{

            $appraisalRef = $request['appraisal'];
            $appraiseeName = $request['appraisee_name'];
            $agreedOrDisagreed = $request['agree_or_disagree'];
            $reasonForDisagree = $request['reason_for_disagreement'];
            $name = $request['name'];
            $initials = $request['initials'];
            $date = $request['date'];

            $data = [];
            $data['appraisal_reference'] = $appraisalRef;
            $data['appraisee_name'] = $appraiseeName;
            $data['agreement_decision'] = $agreedOrDisagreed;
            $data['disagreement_reason'] = $reasonForDisagree;
            $data['declaration_name'] = $name;
            $data['declaration_initials'] = $initials;
            $data['declaration_date'] = $date;

            if(!$request->has('record_id')){

                $baseResp = DataLoader::saveAppraiseeRemarks($data,false);

            }else{

                $identifier = $request['record_id'];
                $baseResp = DataLoader::saveAppraiseeRemarks($data,true,$identifier);

            }

            if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $msg = $baseResp->statusDescription;
                return $this->redirectBackToFormWithError($msg);
            }

            $appraisal = $baseResp->result;
            return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_N),AppConstants::$SECTION_N);

        }catch (\Exception $exception){

            $msg = AppConstants::generalError($exception->getMessage());
            return $this->redirectBackToFormWithError($msg);

        }

    }

    public function saveSectionN(Request $request){


        try{

            $appraisalRef = $request['appraisal'];
            $edComment = $request['comment'];
            $edName = $request['ed_name'];
            $edInitials = $request['ed_initials'];
            $date = $request['date'];

            $data = [];
            $data['appraisal_reference'] = $appraisalRef;
            $data['comments'] = $edComment;
            $data['name'] = $edName;
            $data['initials'] = $edInitials;
            $data['date'] = $date;

            if(!$request->has('record_id')){

                $baseResp = DataLoader::saveDirectorComment($data,false);

            }else{

                $identifier = $request['record_id'];
                $baseResp = DataLoader::saveDirectorComment($data,true,$identifier);

            }

            if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $msg = $baseResp->statusDescription;
                return $this->redirectBackToFormWithError($msg);

            }

            $appraisal = $baseResp->result;
            return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_O));

        }catch (\Exception $exception){

            $msg = AppConstants::generalError($exception->getMessage());
            return $this->redirectBackToFormWithError($msg);

        }

    }

    public function moveAppraisal($appraisalId,$workflowStep){

        try{

            $active_module = $this->active_module;
            $appraisalStatus = $workflowStep;
            $appraisalRef = $appraisalId;

            if($appraisalStatus == ConstAppraisalStatus::PENDING_WORKFLOW_SUBMISSION ||
                $appraisalStatus == ConstAppraisalStatus::REJECTED_BY_SUPERVISOR ||
                $appraisalStatus == ConstAppraisalStatus::REJECTED_BY_DEPARTMENT_HEAD ||
                $appraisalStatus == ConstAppraisalStatus::REJECTED_BY_EXECUTIVE_DIRECTOR
            ){

                $data = [];
                $data['appraisal_reference'] = $appraisalId;

                $baseResp = DataLoader::appraisalWorkFlowStart($data);

                if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                    $error =$baseResp->statusDescription;
                    return $this->getView(null,null,null,[],null,true,$error);
                }

                /*
                 * Redirect to the list of appraisee forms
                 * */
                return redirect()->route('appraisal-forms.owner');

            }

            /*
             * Appraisal is already in a workflow so we are forwarding it
             * */
            return redirect()->route('approval_form',[$appraisalRef,$appraisalStatus]);


        }catch (\Exception $exception){
            /*An exception occurred on saving the form, we need to redirect back with the error */
            $error = AppConstants::generalError($exception->getMessage());
            return $this->getView(null,null,null,[],null,true,$error);
        }

    }



    public function cancelAppraisal($appraisalRef){

        try{

            /*
             * Send cancel request to the API
             * */
            $baseResp = DataLoader::appraisalCancel($appraisalRef);

            if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                $respAppraisal = DataLoader::getAppraisalByAppraisalReference($appraisalRef);
                $appraisal = $respAppraisal->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $respAppraisal->result : null;
                return $this->getView($appraisal,null,null,DataGenerator::visibleSections(AppConstants::$SECTION_A),AppConstants::$SECTION_A,true,$baseResp->statusDescription);

            }

            /*
             * Redirect back to my appraisals
             * */
            return redirect()->route('appraisal-forms.owner');


        }catch (\Exception $exception){

            /*An exception occurred on saving the form, we need to redirect back with the error */
            $error = AppConstants::generalError($exception->getMessage());
            $respAppraisal = DataLoader::getAppraisalByAppraisalReference($appraisalRef);
            $appraisal = $respAppraisal->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $respAppraisal->result : null;
            return $this->getView($appraisal,null,null,DataGenerator::visibleSections(AppConstants::$SECTION_A),AppConstants::$SECTION_A,true,$error);

        }

    }

    public function assignApprovers(Request $request){

        try{

            $appraisalId = $request['appraisal'];
            $supervisor = $request['supervisor'];
            $hod = $request['hod'];
            $ed = $request['ed'];

            $data = [];
            $data['appraisal_reference'] = $appraisalId;
            $data['supervisor_id'] = $supervisor;
            $data['department_head_id'] = $hod;
            $data['executive_director_id'] = $ed;

            $baseResp = DataLoader::appraisalWorkFlowStart($data);

            if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $error = $baseResp->statusDescription;
                return $this->getView(null,null,null,[],null,true,$error);
            }

            return redirect(route('user_dashboard'));

        }catch (\Exception $exception){

            /*An exception occurred on saving the form, we need to redirect back with the error */
            $error = AppConstants::generalError($exception->getMessage());
            return $this->getView(null,null,null,[],null,true,$error);

        }

    }

    public function show($id){

        $appraisalRef = $id;

        /*
         * About redirecting back with an Error Message
         * */
        if(!$appraisalRef){
            return redirect()->back();
        }

        /*
         * Go to the TDS API and get the appraisal
         * */
        $baseResp = DataLoader::getAppraisalByAppraisalReference($appraisalRef);

        /*
         * About redirecting back with an Error Message
         * */
        if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return redirect()->back();
        }

        /*
         * We got the appraisal
         * */
        $appraisal = $baseResp->result;
        //return json_encode($appraisal);
        return $this->getView($appraisal,null,null);

    }

    public function getApprovalForm($appraisalId,$workFlowStep){

        $appraisalRef = $appraisalId;
        $appraisalStatus = $workFlowStep;
        $active_module = $this->active_module;
        $viewParams = [];
        $viewParams[] = 'active_module';
        $viewParams[] = 'appraisalStatus';
        $viewParams[] = 'appraisalRef';

        return view('appraisals.approval_decision',compact($viewParams));

    }

    public function approveOrRejectAppraisal(Request $request){

        try{

            $appraisalRef= $request['appraisal_reference'];
            $decision = $request['approval_decision'];
            $rejectionReason = $request['rejection_reason'];

            $data = [];
            $data['appraisal_reference'] = $appraisalRef;
            $data['is_movement_forward'] = $decision == 'approved' ? true : false;
            $data['remark'] = $rejectionReason;

            //send movement request to the API
            $baseResp = DataLoader::appraisalWorkFlowMove($data);

            //movement failed
            if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $error = $baseResp->statusDescription;
                return $this->getView(null,null,null,[],null,true,$error);
            }

            //movement was successful
            return redirect()-> route('user_dashboard');

            //todo generate the pdf and save it to a EDMS
            //$this->generateAppraisalFormPdf($appraisalRef);

        }catch (\Exception $exception){

            /*An exception occurred on saving the form, we need to redirect back with the error */
            $error = AppConstants::generalError($exception->getMessage());
            return $this->getView(null,null,null,[],null,true,$error);

        }

    }

    public function appraisalApprove($appraisalId,$workflowStep){

        try{

            $appraisalStatus = $workflowStep;
            $appraisalRef = $appraisalId;

            /*
             * Confirm if the appraisal is really up for approval
             * */
            if($appraisalStatus == ConstAppraisalStatus::PENDING_SUPERVISOR_APPROVAL ||
                $appraisalStatus == ConstAppraisalStatus::PENDING_DEPARTMENT_HEAD_APPROVAL ||
                $appraisalStatus == ConstAppraisalStatus::PENDING_EXECUTIVE_DIRECTOR_APPROVAL
            ){

                $data = [];
                $data['appraisal_reference'] = $appraisalRef;
                $data['is_movement_forward'] = true;

                //send movement request to the API
                $baseResp = DataLoader::appraisalWorkFlowMove($data);

                if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                    $error =$baseResp->statusDescription;
                    return $this->getView(null,null,null,[],null,true,$error);
                }

                /*
                 * Redirect to the list of appraisee forms
                 * */
                return redirect()->route('appraisal-forms.owner');

            }else{

                /*
                 * This status is not a valid status for approval
                 * */
                $error = AppConstants::$MSG_INVALID_APPROVAL_STATUS.' ['.$appraisalStatus.']';
                return $this->getView(null,null,null,[],null,true,$error);

            }


        }catch (\Exception $exception){
            /*An exception occurred on saving the form, we need to redirect back with the error */
            $error = AppConstants::generalError($exception->getMessage());
            return $this->getView(null,null,null,[],null,true,$error);
        }

    }

    public function appraisalReject(Request $request){

        try{

            $appraisalRef= $request['appraisal_reference'];
            $rejectionReason = $request['rejection_reason'];

            $data = [];
            $data['appraisal_reference'] = $appraisalRef;
            $data['is_movement_forward'] = false;
            $data['remark'] = $rejectionReason;

            //send movement request to the API
            $baseResp = DataLoader::appraisalWorkFlowMove($data);

            //movement failed
            if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $error = $baseResp->statusDescription;
                return $this->getView(null,null,null,[],null,true,$error);
            }

            //movement was successful
            return redirect()-> route('user_dashboard');

        }catch (\Exception $exception){

            /*An exception occurred on saving the form, we need to redirect back with the error */
            $error = AppConstants::generalError($exception->getMessage());
            return $this->getView(null,null,null,[],null,true,$error);

        }

    }

    /**
     * Attempt to save the totlas for the assignments sections
     * @param Request $request
     * @param $appraisalId
     */
    private function saveAssignmentSummmaries(Request $request, $appraisalId) {

        $totalMaxRating = $request['sec_d_total_max_rating'];
        $totalAppraiseeRating = $request['sec_d_total_appraisee_rating'];
        $totalAppraiserRating = $request['sec_d_total_appraiser_rating'];
        $totalAgreedRating = $request['sec_d_total_agreed_rating'];

        $summary = AssignmentsSummary::where('appraisal_id','=',$appraisalId)->first();
        $summary = $summary != null ? $summary : new AssignmentsSummary();
        $summary->appraisal_id = $appraisalId;
        $summary->maxRating = $totalMaxRating;
        $summary->appraiseeRating = $totalAppraiseeRating;
        $summary->appraiserRating = $totalAppraiserRating;
        $summary->agreedRating = $totalAgreedRating;

        $summary->save();

    }

    /** Attempt to save additional assignments totals
     * @param Request $request
     * @param $appraisalId
     */
    private function saveAdditionalAssignmentsAssignmentSummmaries(Request $request, $appraisalId) {

        $totalMaxRating = $request['sec_d_add_total_max_rating'];
        $totalAppraiseeRating = $request['sec_d_add_total_appraisee_rating'];
        $totalAppraiserRating = $request['sec_d_add_total_appraiser_rating'];
        $totalAgreedRating = $request['sec_d_add_total_agreed_rating'];

        $secDPercentageScore = $request['sec_d_final_percentage_score'];
        $secDWeighedScore = $request['sec_d_weighed'];
        $appraisserComment = $request['sec_d_appraiser_comment'];

        $summary = AddAssignmentsSummary::where('appraisal_id','=',$appraisalId)->first();
        $summary = $summary != null ? $summary : new AddAssignmentsSummary();
        $summary->appraisal_id = $appraisalId;
        $summary->max_rating = $totalMaxRating;
        $summary->appraisee_rating = $totalAppraiseeRating;
        $summary->appraiser_rating = $totalAppraiserRating;
        $summary->agreed_rating = $totalAgreedRating;

        $summary->section_d_percentage_score = $secDPercentageScore;
        $summary->section_d_weighed_score = $secDWeighedScore;
        $summary->appraiser_comment = $appraisserComment;

        $summary->save();

    }

    private function saveCompetenceSummmaries(Request $request, $appraisalId) {

        $totalMaxRating = $request['secEmaxTotal'];
        $totalAppraiseeRating = $request['secEappraiseeTotal'];
        $totalAppraiserRating = $request['secEappraiserTotal'];
        $totalAgreedRating = $request['secEagreedTotal'];

        $secEPercentageScore = $request['sec_e_final_percentage_score'];
        $secEWeighedScore = $request['sec_e_weighed'];

        $sectionEFinalScore = $request['FinalScoreSecE'];
        $sectionDFinalScore = $request['FinalScoreSecD'];
        $totalFinalScore = $request['OverallTotal'];

        $summary = CompetenceSummary::where('appraisal_id','=',$appraisalId)->first();
        $summary = $summary != null ? $summary : new CompetenceSummary();
        $summary->appraisal_id = $appraisalId;
        $summary->max_rating = $totalMaxRating;
        $summary->appraisee_rating = $totalAppraiseeRating;
        $summary->appraiser_rating = $totalAppraiserRating;
        $summary->agreed_rating = $totalAgreedRating;

        $summary->section_e_percentage_score = $secEPercentageScore;
        $summary->section_e_weighed_score = $secEWeighedScore;

        $summary->section_e_final_score = $sectionEFinalScore;
        $summary->section_d_final_score = $sectionDFinalScore;
        $summary->total_score = $totalFinalScore;

        $summary->save();

    }

    private function getWorkFlowStep($workflow) {

        if($workflow == null){
            return AppConstants::$WORK_FLOW_STEP1_OWNER;
        }

        $supervisorApproval = $workflow->supervisor_approval;
        $hodApproval = $workflow->hod_approval;
        $edApproval = $workflow->executive_director_approval;

        if(!$supervisorApproval)
            return AppConstants::$WORK_FLOW_STEP2_SUPERVISOR;
        if($supervisorApproval && !$hodApproval)
            return AppConstants::$WORK_FLOW_STEP3_HOD;
        if($supervisorApproval && $hodApproval && !$edApproval)
            return AppConstants::$WORK_FLOW_STEP4_ED;
        if($supervisorApproval && $hodApproval && $edApproval){
            return AppConstants::$WORK_FLOW_STEP5_DONE;
        }else{
            return AppConstants::$WORK_FLOW_STEP4_ED;
        }

    }

    private function checkIfAuthUserCanEdit($workflow) {

        if($workflow == null){
            return true;
        }

        $userId = Auth::user()->id;
        $supervisorApproval = $workflow->supervisor_approval;
        $supervisorId = $workflow->supervisor_id;
        $hodApproval = $workflow->hod_approval;
        $hodId = $workflow->hod_id;
        $edApproval = $workflow->executive_director_approval;
        $edId = $workflow->executive_director_id;

        if(!$supervisorApproval && $this->idsMatch($userId,$supervisorId))
            return true;
        if($supervisorApproval && !$hodApproval && $this->idsMatch($userId,$hodId))
            return true;
        if($supervisorApproval && $hodApproval && !$edApproval && $this->idsMatch($userId,$edId))
            return true;
        if($supervisorApproval && $hodApproval && $edApproval){
            return false;
        }else{
            return false;
        }

    }

    private function idsMatch($userId, $workflowStepPersonId) {
        return $userId == $workflowStepPersonId;
    }

    private function generateAppraisalFormPdf($appraisalId) {

        try{

            $withData = [
                'academicBackgrounds',
                'keyDuties',
                'additionalAssignments',
                'assignments',
                'competences',
                'performanceGaps',
                'performanceChallenges',
                'performanceAppraiserComment',
                'sectiong',
                'sectionh',
                'sectioni',
                'sectionj',
                'sectionk',
                'sectionl',
                'sectionm',
                'sectionn',
                'assignmentsSummary',
                'addAssignmentsSummary',
                'competenceSummary',
                'directorsAndManagersCompetences',
                'supportStaffCompetences',
                'officersCompetences',
            ];

            $appraisal =  Appraisal::with($withData)->find($appraisalId);
            $data = ["data" => $appraisal];

            $path = Storage::disk('partitionE')->getAdapter()->getPathPrefix();
            $filePath = $path.'/'.$appraisal->document_name;

            //$pdf = \PDF::loadView('templates.appraisal', $data)->save('appraisal.pdf');
            $pdf = \PDF::loadView('templates.appraisal', $data)
//                ->setPaper('a4', 'portrait')
//                ->setOptions(['margin-top'=>0,'margin-right'=>0,'margin-bottom'=>0,'margin-left'=>0,'print-media-type' => true])
                ->save($filePath);
          //  return $pdf->stream('appraisal.pdf');

        }catch (\Exception $exception){

          //   return $exception->getMessage();
        }

    }

    public function getOwnerAppraisals(Request $request){


        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $req = new ApiAppraisalReq();
            $req->token = $token;
            $req->workflowRole = AppConstants::WORK_FLOW_ROLE_OWNER;

            $baseResp = DataLoader::getUserAppraisals($req);

            if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->getViewOwnerAppraisals([], $baseResp->statusDescription, true);
            }

            /*
             * We successfully got the appraisals
             * */
            $appraisals =  $baseResp->result;
            return $this->getViewOwnerAppraisals($appraisals);

        }catch (\Exception $exception){

            $msg = AppConstants::generalError($exception->getMessage());
            return $this->getViewOwnerAppraisals([], $msg, true);

        }

    }

    public function getSupervisorAppraisals(Request $request){

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $req = new ApiAppraisalReq();
            $req->token = $token;
            $req->workflowRole = AppConstants::WORK_FLOW_ROLE_SUPERVISOR;
            $req->status = ConstAppraisalStatus::PENDING_SUPERVISOR_APPROVAL;
            $req->supervisorDecision = 'PENDING';

            $baseResp = DataLoader::getUserAppraisals($req);
            if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->getViewSupervisorAppraisals([], $baseResp->statusDescription, true);
            }

            /*
             * We successfully got the appraisals
             * */
            $appraisals =  $baseResp->result;
            return $this->getViewSupervisorAppraisals($appraisals);

        }catch (\Exception $exception){

            $msg = AppConstants::generalError($exception->getMessage());
            return $this->getViewSupervisorAppraisals([], $msg, true);

        }

    }

    public function getViewOwnerAppraisals($appraisals, $msg = null, $isError = false){

        $active_module = AppConstants::$ACTIVE_MOD_MY_APPRAISALS;
        return view('appraisals.appraisal-myappraisal',compact('appraisals','active_module','msg','isError'));

    }

    public function getViewSupervisorAppraisals($appraisals, $msg = null, $isError = false){

        $active_module = AppConstants::$ACTIVE_MOD_SUPERVISOR_APPRAISALS;
        return view('appraisals.appraisal-supervisor-approval',compact('appraisals','active_module','msg','isError'));

    }

    public function getViewHodAppraisals($appraisals, $msg = null, $isError = false){

        $active_module = AppConstants::$ACTIVE_MOD_HOD_APPRAISALS;
        return view('appraisals.appraisal-hod-approval',compact('appraisals','active_module','msg','isError'));

    }

    public function getViewDirectorAppraisals($appraisals, $msg = null, $isError = false){

        $active_module = AppConstants::$ACTIVE_MOD_DIRECTOR_APPRAISALS;
        return view('appraisals.appraisal-director-approval',compact('appraisals','active_module','msg','isError'));

    }

    public function getHodAppraisals(Request $request){

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $req = new ApiAppraisalReq();
            $req->token = $token;
            $req->workflowRole = AppConstants::WORK_FLOW_ROLE_HOD;
            $req->status = ConstAppraisalStatus::PENDING_DEPARTMENT_HEAD_APPROVAL;
            $req->hodDecision = 'PENDING';

            $baseResp = DataLoader::getUserAppraisals($req);

            if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->getViewHodAppraisals([], $baseResp->statusDescription, true);
            }

            /*
             * We successfully got the appraisals
             * */
            $appraisals =  $baseResp->result;
            return $this->getViewHodAppraisals($appraisals);

        }catch (\Exception $exception){

            $msg = AppConstants::generalError($exception->getMessage());
            return $this->getViewHodAppraisals([], $msg, true);

        }

    }

    public function getDirectorAppraisals(Request $request){

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $req = new ApiAppraisalReq();
            $req->token = $token;
            $req->workflowRole = AppConstants::WORK_FLOW_ROLE_DIRECTOR;
            $req->directorDecision = 'PENDING';
            $req->status = ConstAppraisalStatus::PENDING_EXECUTIVE_DIRECTOR_APPROVAL;

            $baseResp = DataLoader::getUserAppraisals($req);

            if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->getViewDirectorAppraisals([], $baseResp->statusDescription, true);
            }

            /*
             * We successfully got the appraisals
             * */
            $appraisals =  $baseResp->result;
            return $this->getViewDirectorAppraisals($appraisals);

        }catch (\Exception $exception){

            $msg = AppConstants::generalError($exception->getMessage());
            return $this->getViewDirectorAppraisals([], $msg, true);

        }

    }

    private function saveSectionFPerformanceGaps(Request $request) {

        //get the appraisal form ID
        $appraisalRef = $request['appraisal'];

        //how do I dynamically get the max_rows passed. If it's numeric we take the value, else we assume we did not receive any values
        $countRowsPassed = is_numeric($request['counter_max_rows_performance_gaps']) ? $request['counter_max_rows_performance_gaps'] : 0;

        //define array to data
        $gaps = [];

        //now we loop through all the rows saving the data therein
        for($i = 1; $i<= $countRowsPassed; $i++){

            $gap = $request['gap_'.$i];
            $cause = $request['cause_'.$i];
            $recommendation = $request['recommendation_'.$i];
            $when = $request['when_'.$i];

            // object
            $performanceGap = [];
            $performanceGap['performance_gap'] = $gap;
            $performanceGap['causes'] = $cause;
            $performanceGap['recommendation'] = $recommendation;
            $performanceGap['when'] = $when;

            //Add to list
            $gaps[] = $performanceGap;
        }

        //we now have to save these using the API
        $token = Cookie::get(Security::$COOKIE_TOKEN);
        $data = [];
        $data['appraisal_reference'] = $appraisalRef;
        $data['performance_gaps'] = $gaps;

        $baseResp = DataLoader::savePerformanceGaps($token, $data);

        return $baseResp;

    }

    private function saveSectionFChallenges($request) {

        //get the appraisal form ID
        $appraisalRef = $request['appraisal'];

        //how do I dynamically get the max_rows passed. If it's numeric we take the value, else we assume we did not receive any values
        $countRowsPassed = is_numeric($request['counter_max_rows_challenges']) ? $request['counter_max_rows_challenges'] : 0;

        //define array to data
        $challenges = [];

        //now we loop through all the rows saving the data therein
        for($i = 1; $i<= $countRowsPassed; $i++){

            $challenge = $request['challenge_'.$i];
            $challengeCause = $request['challenge_cause_'.$i];
            $challengeRecommendation = $request['challenge_recommendation_'.$i];
            $challengeWhen = $request['challenge_when_'.$i];

            // object
            $performanceChallenge = [];
            $performanceChallenge['challenge'] = $challenge;
            $performanceChallenge['causes'] = $challengeCause;
            $performanceChallenge['recommendation'] = $challengeRecommendation;
            $performanceChallenge['when'] = $challengeWhen;

            //Add to list
            $challenges[] = $performanceChallenge;
        }

        //we now have to save these using the API
        $token = Cookie::get(Security::$COOKIE_TOKEN);
        $data = [];
        $data['appraisal_reference'] = $appraisalRef;
        $data['challenges'] = $challenges;

        $baseResp = DataLoader::savePerformanceChallenges($token, $data);

        return $baseResp;

    }

    private function updateSectionFPerformanceGaps(Request $request) {

        //get the appraisal form ID
        $appraisalRef = $request['appraisal'];

        //how do I dynamically get the max_rows passed. If it's numeric we take the value, else we assume we did not receive any values
        $countRowsPassed = is_numeric($request['counter_max_rows_performance_gaps']) ? $request['counter_max_rows_performance_gaps'] : 0;

        //define array to data
        $gaps = [];

        //now we loop through all the rows saving the data therein
        for($i = 1; $i<= $countRowsPassed; $i++){

            $gap = $request['gap_'.$i];
            $cause = $request['cause_'.$i];
            $recommendation = $request['recommendation_'.$i];
            $when = $request['when_'.$i];

            // object
            $performanceGap = [];
            $performanceGap['performance_gap'] = $gap;
            $performanceGap['causes'] = $cause;
            $performanceGap['recommendation'] = $recommendation;
            $performanceGap['when'] = $when;

            $recordId = $request['record_id_gap_'.$i];

            //if no recordId, then it's a new being added dynamically
            if(isset($recordId)){
                $performanceGap['record_id_gap_'] = $recordId;
            }

            //Add to list
            $gaps[] = $performanceGap;
        }

        //we now have to save these using the API
        $token = Cookie::get(Security::$COOKIE_TOKEN);
        $data = [];
        $data['appraisal_reference'] = $appraisalRef;
        $data['performance_gaps'] = $gaps;

        $baseResp = DataLoader::savePerformanceGaps($token, $data,true);

        return $baseResp;

    }

    private function updateSectionFChallenges($request) {

        //get the appraisal form ID
        $appraisalRef = $request['appraisal'];

        //how do I dynamically get the max_rows passed. If it's numeric we take the value, else we assume we did not receive any values
        $countRowsPassed = is_numeric($request['counter_max_rows_challenges']) ? $request['counter_max_rows_challenges'] : 0;

        //define array to data
        $challenges = [];

        //now we loop through all the rows saving the data therein
        for($i = 1; $i<= $countRowsPassed; $i++){

            $challenge = $request['challenge_'.$i];
            $challengeCause = $request['challenge_cause_'.$i];
            $challengeRecommendation = $request['challenge_recommendation_'.$i];
            $challengeWhen = $request['challenge_when_'.$i];

            // object
            $performanceChallenge = [];
            $performanceChallenge['challenge'] = $challenge;
            $performanceChallenge['causes'] = $challengeCause;
            $performanceChallenge['recommendation'] = $challengeRecommendation;
            $performanceChallenge['when'] = $challengeWhen;

            $recordId = $request['record_id_challenge_'.$i];

            //if no recordId, then it's a new being added dynamically
            if(isset($recordId)){
                $performanceChallenge['record_id_challenge_'] = $recordId;
            }

            //Add to list
            $challenges[] = $performanceChallenge;
        }

        //we now have to save these using the API
        $token = Cookie::get(Security::$COOKIE_TOKEN);
        $data = [];
        $data['appraisal_reference'] = $appraisalRef;
        $data['challenges'] = $challenges;

        $baseResp = DataLoader::savePerformanceChallenges($token, $data, true);

        return $baseResp;

    }

    /**
     * @param $appraisal
     * @return array
     */
    private function getAppraisalCompetenceAssessments($appraisal) {

        return isset($appraisal) && isset($appraisal->competenceAssessments) && count($appraisal->competenceAssessments) > 0 ?
            $appraisal->competenceAssessments : [];

    }

    private function checkIfAuthUserCanEditAtThisStage($appraisal, ApiUser $user) {


        try{

            if(!isset($appraisal) || !$appraisal instanceof  ApiAppraisal){
                return AppConstants::$EDIT_MODE_ON;
            }

            if(!isset($user)){
                return AppConstants::$EDIT_MODE_OFF;
            }

            /*
            * Form is completed (fully approved) or cancelled no fucking Nigga should edit it
            * */
            if($appraisal->status == ConstAppraisalStatus::COMPLETED_SUCCESSFULLY || $appraisal->status == ConstAppraisalStatus::CANCELED_BY_OWNER){
                return AppConstants::$EDIT_MODE_OFF;
            }

            /*
             * Form is at supervisor step, so if not supervisor reject edit
             * */
            if($appraisal->status == ConstAppraisalStatus::PENDING_SUPERVISOR_APPROVAL && $user->username != $appraisal->supervisorUsername){
                return AppConstants::$EDIT_MODE_OFF;
            }

            /*
             *
             * Form is at the HOD step, so if not HOD reject edit*/
            if($appraisal->status == ConstAppraisalStatus::PENDING_DEPARTMENT_HEAD_APPROVAL && $user->username != $appraisal->deptHeadUsername){
                return AppConstants::$EDIT_MODE_OFF;
            }

            /*
             * Form is at the ED, so if not ED reject edit
             * */
            if($appraisal->status == ConstAppraisalStatus::PENDING_EXECUTIVE_DIRECTOR_APPROVAL && $user->username != $appraisal->executiveDirectorUsername){
                return AppConstants::$EDIT_MODE_OFF;
            }

            /*
             * All rejected forms must be at the owner, any other guy reject edit
             * */
            if(ConstAppraisalStatus::isRejectedStatus($appraisal->status) && $user->username != $appraisal->ownerUsername){
                return AppConstants::$EDIT_MODE_OFF;
            }

            return AppConstants::$EDIT_MODE_ON;

        }catch (\Exception $exception){
            return AppConstants::$EDIT_MODE_OFF;
        }

    }

    /**
     * @param $error
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectBackToFormWithError($error) {

        return redirect()->back()->withErrors(SharedCommons::customFormError($error))->withInput();

    }

    private function getDefaultActiveStepIndex($activeStep) {

        switch ($activeStep){
            case AppConstants::$SECTION_A:{
                return 0; break;
            }
            case AppConstants::$SECTION_B:{
                return 1; break;
            }
            case AppConstants::$SECTION_C:{
                return 2;  break;
            }
            case AppConstants::$SECTION_D:{
                return 3; break;
            }
            case AppConstants::$SECTION_D1:{
                return 4; break;
            }
            case AppConstants::$SECTION_E:{
                return 5; break;
            }
            case AppConstants::$SECTION_F:{
                return 6; break;
            }
            case AppConstants::$SECTION_G:{
                return 7; break;
            }
            case AppConstants::$SECTION_H:{
                return 8; break;
            }
            case AppConstants::$SECTION_I:{
                return 9; break;
            }
            case AppConstants::$SECTION_J:{
                return 10; break;
            }
            case AppConstants::$SECTION_K:{
                return 11; break;
            }
            case AppConstants::$SECTION_L:{
                return 12; break;
            }
            case AppConstants::$SECTION_M:{
                return 13; break;
            }
            case AppConstants::$SECTION_N:{
                return 14; break;
            }
            default :{
                return 0;
            }
        }


    }

    private function sectionDUpdate(Request $request) {

        //do update

        //get the appraisal form ID
        $appraisalRef = $request['appraisal'];

        //how do I dynamically get the max_rows passed
        //if it's numeric we take the value, else we assume we did not receive any values
        $countRowsPassed = is_numeric($request['counter_max_rows_assignments']) ? $request['counter_max_rows_assignments'] : 0;


        //define array to data
        $assignments = [];

        //now we loop through all the rows saving the data therein
        for($i = 1; $i<= $countRowsPassed; $i++){

            $objective = $request['objective_'.$i];
            $expectedOutput = $request['expected_output_sec_d_'.$i];
            $actualPerformance = $request['actual_performance_'.$i];
            $maxRating = $request['max_rating_sec_d'.$i];
            $appraiseeRating = $request['appraisee_rating_sec_d'.$i];
            $appraiserRating = $request['appraiser_rating_sec_d'.$i];
            $agreedRating = $request['agreed_rating_sec_d'.$i];

            //assignment object
            $assignment = [];
            $assignment['objective_id'] = $objective;
            $assignment['expected_output'] = $expectedOutput;
            $assignment['actual_performance'] = $actualPerformance;
            $assignment['maximum_rating'] = $maxRating;

            /*
             * These values below, if they are empty on null, I dont send them because the API expects I either dont send
             *  them or if i send them I send numeric values
             * */
            if(isset($appraiseeRating) && !empty($appraiseeRating)){
                $assignment['appraisee_rating'] = $appraiseeRating;
            }
            if(isset($appraiserRating) && !empty($appraiserRating)){
                $assignment['appraiser_rating'] = $appraiserRating;
            }
            if(isset($agreedRating)  && !empty($agreedRating)){
                $assignment['agreed_rating'] = $agreedRating;
            }

            $recordId = $request['record_id_'.$i];

            //if no recordId, then it's a new being added dynamically
            if(isset($recordId)){
                $assignment['record_id'] = $recordId;
            }

            //Add to list
            $assignments[] = $assignment;

        }

        //we now have to save data using the API
        $token = Cookie::get(Security::$COOKIE_TOKEN);
        $data = [];
        $data['appraisal_reference'] = $appraisalRef;
        $data['assignments'] = $assignments;

        $baseResp = DataLoader::saveAssignments($token, $data,true);

        if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            $msg = $baseResp->statusDescription;
            $respNext= DataLoader::getAppraisalByAppraisalReference($appraisalRef);
            $appraisal = $respNext->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $respNext->result : null;
            return $this->getView($appraisal,null,null,DataGenerator::visibleSections(AppConstants::$SECTION_D),AppConstants::$SECTION_D,true,$msg);

        }


        //Assignment scores begin

        $recordId = $request['scores_sec_d_record_id'];

        $dataNext = [];
        $dataNext['record_id'] = $recordId;
        $dataNext['appraisal_reference'] = $appraisalRef;
        $dataNext['total_maximum_rating'] = $request['sec_d_total_max_rating'];


        /*
         * Please note, I am assuming these fields can be saved later on, e.g the appraiser total may be empty
         * therefore i dont pass them to API when they empty or null because if I pass them
         * they will fail validation as only numbers are expected
         * */
        if(isset($request['sec_d_total_appraisee_rating']) && !empty($request['sec_d_total_appraisee_rating'])){
            $dataNext['total_appraisee_rating'] = $request['sec_d_total_appraisee_rating'];
        }
        if(isset($request['sec_d_total_appraiser_rating']) && !empty($request['sec_d_total_appraiser_rating'])){
            $dataNext['total_appraiser_rating'] = $request['sec_d_total_appraiser_rating'];
        }
        if(isset($request['sec_d_total_agreed_rating']) && !empty($request['sec_d_total_agreed_rating'])){
            $dataNext['total_agreed_rating'] = $request['sec_d_total_agreed_rating'];
        }


        /*
         * If the record ID is not set, then we saving for the first time else we are updating
         * */
        $baseRespNext = !isset($recordId) ? DataLoader::saveAssignmentsScore($dataNext) : DataLoader::saveAssignmentsScore($dataNext, true, $recordId);

        if($baseRespNext->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            $msg = $baseRespNext->statusDescription;
            $respNext= DataLoader::getAppraisalByAppraisalReference($appraisalRef);
            $appraisal = $respNext->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $respNext->result : null;
            return $this->getView($appraisal,null,null,DataGenerator::visibleSections(AppConstants::$SECTION_D),AppConstants::$SECTION_D,true,$msg);

        }
        $appraisal = $baseRespNext->result;

        //Assignment scores end

        return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_D1),AppConstants::$SECTION_D1);


    }

    private function sectionDSave(Request $request) {

        //do saving

        //get the appraisal form ID
        $appraisalRef = $request['appraisal'];

        //how do I dynamically get the max_rows passed
        //if it's numeric we take the value, else we assume we did not receive any values
        $countRowsPassed = is_numeric($request['counter_max_rows_assignments']) ? $request['counter_max_rows_assignments'] : 0;

        //define array to data
        $assignments = [];

        //now we loop through all the rows saving the data therein
        for($i = 1; $i<= $countRowsPassed; $i++){

            $objective = $request['objective_'.$i];
            $expectedOutput = $request['expected_output_sec_d_'.$i];
            $actualPerformance = $request['actual_performance_'.$i];
            $maxRating = $request['max_rating_sec_d'.$i];
            $appraiseeRating = $request['appraisee_rating_sec_d'.$i];
            $appraiserRating = $request['appraiser_rating_sec_d'.$i];
            $agreedRating = $request['agreed_rating_sec_d'.$i];


            //assignment object
            $assignment = [];
            $assignment['objective_id'] = $objective;
            $assignment['expected_output'] = $expectedOutput;
            $assignment['actual_performance'] = $actualPerformance;
            $assignment['maximum_rating'] = $maxRating;


            /*
             * For the values I only send them when they are not null or empty because if they are null or empty, they will be rejected
             * */
            if(isset($appraiseeRating) && !empty($appraiseeRating)){ $assignment['appraisee_rating'] = $appraiseeRating; };
            if(isset($appraiserRating) && !empty($appraiserRating)){ $assignment['appraiser_rating'] = $appraiserRating; };
            if(isset($agreedRating) && !empty($agreedRating)){ $assignment['agreed_rating'] = $agreedRating; };

            //Add to list
            $assignments[] = $assignment;

        }


        //we now have to save these institutes using the API
        $token = Cookie::get(Security::$COOKIE_TOKEN);
        $data = [];
        $data['appraisal_reference'] = $appraisalRef;
        $data['assignments'] = $assignments;

        $baseResp = DataLoader::saveAssignments($token, $data);

        if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            $msg = $baseResp->statusDescription;
            return $this->redirectBackToFormWithError($msg);
        }



        /*
         * Begin the saving of the scores
         * */

        $dataNext = [];
        $dataNext['appraisal_reference'] = $appraisalRef;
        $dataNext['total_maximum_rating'] = $request['sec_d_total_max_rating'];

        /*
         * Please note, I am assuming these fields can be saved later on, e.g the appraiser total may be empty
         * therefore i dont pass them to API when they empty or null because if I pass them
         * they will fail validation as only numbers are expected
         * */
        $secDTotalAppraiseeRating = $request['sec_d_total_appraisee_rating'];
        $secDTotalAppraiserRating = $request['sec_d_total_appraiser_rating'];
        $secDTotalAgreedRating = $request['sec_d_total_agreed_rating'];


        if(isset($secDTotalAppraiseeRating) && !empty($secDTotalAppraiseeRating)){
            $dataNext['total_appraisee_rating'] = $secDTotalAppraiseeRating;
        }
        if(isset($secDTotalAppraiserRating) && !empty($secDTotalAppraiserRating)){
            $dataNext['total_appraiser_rating'] = $secDTotalAppraiserRating;
        }
        if(isset($secDTotalAgreedRating) && !empty($secDTotalAgreedRating)){
            $dataNext['total_agreed_rating'] = $secDTotalAgreedRating;
        }


        $baseRespNext = DataLoader::saveAssignmentsScore($dataNext);

        if($baseRespNext->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            $msg = $baseRespNext->statusDescription;
            return $this->redirectBackToFormWithError($msg);
        }

        $appraisal = $baseRespNext->result;

        /*
         * End saving of the scores
         * */


        return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_D1),AppConstants::$SECTION_D1);

    }

    private function sectionDAdditionalSave($request) {


        //get the appraisal form ID
        $appraisalRef = $request['appraisal'];

        //how do I dynamically get the max_rows passed
        //if it's numeric we take the value, else we assume we did not receive any values
        $countRowsPassed = is_numeric($request['counter_max_rows_add_assignments']) ? $request['counter_max_rows_add_assignments'] : 0;

        //define array to data
        $assignments = [];

        //now we loop through all the rows saving the data therein
        for($i = 1; $i<= $countRowsPassed; $i++){

            $assignment = $this->getAdditionalAssignmentRowData($request, $i);
            $assignments[] = $assignment;

        }


        //we now have to save these items using the API
        $token = Cookie::get(Security::$COOKIE_TOKEN);
        $data = [];
        $data['appraisal_reference'] = $appraisalRef;
        $data['assignments'] = $assignments;

        $baseResp = DataLoader::saveAdditionalAssignments($token, $data);

        if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            $msg = $baseResp->statusDescription;
            return $this->redirectBackToFormWithError($msg);

        }

        //Assignment scores begin

        $dataNext = [];
        $dataNext['appraisal_reference'] = $appraisalRef;
        $dataNext['total_maximum_rating'] = $request['sec_d_add_total_max_rating'];

        $secDAddTotalAppraiseeRating = $request['sec_d_add_total_appraisee_rating'];
        $secDAddTotalAppraiserRating = $request['sec_d_add_total_appraiser_rating'];
        $secDAddTotalAgreedRating = $request['sec_d_add_total_agreed_rating'];

        /*
         * We only send these values if they not null or empty else they will be rejected as they must be numeric
         * */
        if(isset($secDAddTotalAppraiseeRating) && !empty($secDAddTotalAppraiseeRating)){
            $dataNext['total_appraisee_rating'] = $secDAddTotalAppraiseeRating;
        }
        if(isset($secDAddTotalAppraiserRating) && !empty($secDAddTotalAppraiserRating)){
            $dataNext['total_appraiser_rating'] = $secDAddTotalAppraiserRating;
        }
        if(isset($secDAddTotalAgreedRating) && !empty($secDAddTotalAgreedRating)){
            $dataNext['total_agreed_rating'] = $secDAddTotalAgreedRating;
        }

        $baseRespNext = DataLoader::saveAdditionalAssignmentsScore($dataNext);
        if($baseRespNext->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            $msg = $baseRespNext->statusDescription;
            return $this->redirectBackToFormWithError($msg);
        }

        $appraisal = $baseRespNext->result;

        /*
         * End saving of assignment scores
         * */




        /*
         *
         * Begin the saving of the summary
         * */

        $secDFinalPercentageScore = $request['sec_d_final_percentage_score'];
        $secDWeighed = $request['sec_d_weighed'];
        $secDAppraiserComment = $request['sec_d_appraiser_comment'];


        if(!$this->validInputSectionDAdditionalSummary($secDFinalPercentageScore, $secDWeighed, $secDAppraiserComment)){

            /*
             * If these fields are not populated, I dont attempt to save
             * */
            return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_E),AppConstants::$SECTION_E);

        }


        $dataSummary = [
            'appraisal_reference' => $appraisalRef,
            'section_d_percentage_score' => $secDFinalPercentageScore,
            'section_d_weighed_score' => $secDWeighed,
            'appraiser_comment' => $secDAppraiserComment,
        ];



        $baseRespSummary = DataLoader::saveAssignmentsSummary($dataSummary);
        if($baseRespSummary->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            $msg = $baseRespSummary->statusDescription;
            return $this->redirectBackToFormWithError($msg);

        }
        $appraisal = $baseRespSummary->result;

        //Summary end

        return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_E),AppConstants::$SECTION_E);

    }

    private function sectionDAdditionalUpdate($request) {

        //get the appraisal form ID
        $appraisalRef = $request['appraisal'];

        //how do I dynamically get the max_rows passed
        //if it's numeric we take the value, else we assume we did not receive any values
        $countRowsPassed = is_numeric($request['counter_max_rows_add_assignments']) ? $request['counter_max_rows_add_assignments'] : 0;


        //define array to data
        $assignments = [];

        //now we loop through all the rows saving the data therein
        for($i = 1; $i<= $countRowsPassed; $i++){

            $assignment = $this->getAdditionalAssignmentUpdateRowData($request, $i);
            //Add to list
            $assignments[] = $assignment;

        }

        //we now have to save data using the API
        $token = Cookie::get(Security::$COOKIE_TOKEN);
        $data = [];
        $data['appraisal_reference'] = $appraisalRef;
        $data['assignments'] = $assignments;

        $baseResp = DataLoader::saveAdditionalAssignments($token, $data,true);

        if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            $msg = $baseResp->statusDescription;
            $respNext= DataLoader::getAppraisalByAppraisalReference($appraisalRef);
            $appraisal = $respNext->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $respNext->result : null;
            return $this->getView($appraisal,null,null,DataGenerator::visibleSections(AppConstants::$SECTION_D1),AppConstants::$SECTION_D1,true,$msg);

        }




        /*
         * Begin the saving of Assignment scores
         * */

        $recordId = $request['scores_sec_d_add_record_id'];

        $dataNext = [];
        $dataNext['record_id'] = $recordId;
        $dataNext['appraisal_reference'] = $appraisalRef;
        $dataNext['total_maximum_rating'] = $request['sec_d_add_total_max_rating'];

        $secDAddTotalAppraiseeRating = $request['sec_d_add_total_appraisee_rating'];
        $secDAddTotalAppraiserRating = $request['sec_d_add_total_appraiser_rating'];
        $secDAddTotalAgreedRating = $request['sec_d_add_total_agreed_rating'];

        /*
         * We only send these values if they not null or empty else they will be rejected as they must be numeric
         * */
        if(isset($secDAddTotalAppraiseeRating) && !empty($secDAddTotalAppraiseeRating)){
            $dataNext['total_appraisee_rating'] = $secDAddTotalAppraiseeRating;
        }
        if(isset($secDAddTotalAppraiserRating) && !empty($secDAddTotalAppraiserRating)){
            $dataNext['total_appraiser_rating'] = $secDAddTotalAppraiserRating;
        }
        if(isset($secDAddTotalAgreedRating) && !empty($secDAddTotalAgreedRating)){
            $dataNext['total_agreed_rating'] = $secDAddTotalAgreedRating;
        }

        $baseRespNext = isset($recordId) ? DataLoader::saveAdditionalAssignmentsScore($dataNext,true,$recordId) : DataLoader::saveAdditionalAssignmentsScore($dataNext);

        if($baseRespNext->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            $msg = $baseRespNext->statusDescription;
            $respNext= DataLoader::getAppraisalByAppraisalReference($appraisalRef);
            $appraisal = $respNext->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $respNext->result : null;
            return $this->getView($appraisal,null,null,DataGenerator::visibleSections(AppConstants::$SECTION_D1),AppConstants::$SECTION_D1,true,$msg);

        }

        $appraisal = $baseRespNext->result;

        /*
         * End saving of additional assignment scores
         * */




        /*
         *
         * Attempt to start saving the summary details
         * */

        $recordId = $request['assignments_summary_record_id'];
        $secDFinalPercentageScore = $request['sec_d_final_percentage_score'];
        $secDWeighed = $request['sec_d_weighed'];
        $secDAppraiserComment = $request['sec_d_appraiser_comment'];


        if(!$this->validInputSectionDAdditionalSummary($secDFinalPercentageScore, $secDWeighed, $secDAppraiserComment)){

            /*
             * If these fields are not populated, I dont attempt to save
             * */
            return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_E),AppConstants::$SECTION_E);

        }


        $dataSummary = [
            'appraisal_reference' => $appraisalRef,
            'section_d_percentage_score' => $secDFinalPercentageScore,
            'section_d_weighed_score' => $secDWeighed,
            'appraiser_comment' => $secDAppraiserComment,
            'record_id' => $recordId,
        ];

        $baseRespSummary = isset($recordId) ? DataLoader::saveAssignmentsSummary($dataSummary, true,$recordId) : DataLoader::saveAssignmentsSummary($dataSummary);
        if($baseRespSummary->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            $msg = $baseRespSummary->statusDescription;
            $respNext= DataLoader::getAppraisalByAppraisalReference($appraisalRef);
            $appraisal = $respNext->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $respNext->result : null;
            return $this->getView($appraisal,null,null,DataGenerator::visibleSections(AppConstants::$SECTION_D1),AppConstants::$SECTION_D1,true,$msg);
        }

        $appraisal = $baseRespSummary->result;

        /*
         * End saving of the summary details
         * */


        return $this->getView($appraisal,$this->formDataUpdateMessage,null,DataGenerator::visibleSections(AppConstants::$SECTION_E),AppConstants::$SECTION_E);


    }

    /**
     * @param $request
     * @param $index
     * @return array
     */
    private function getAdditionalAssignmentRowData(Request $request, $index) {

        $objective = $request['objective_' . $index];
        $expectedOutput = $request['expected_output_sec_d_add' . $index];
        $actualPerformance = $request['actual_performance_sec_d_add' . $index];
        $maxRating = $request['max_rating_sec_d_add' . $index];
        $appraiseeRating = $request['appraisee_rating_sec_d_add' . $index];
        $appraiserRating = $request['appraiser_rating_sec_d_add' . $index];
        $agreedRating = $request['agreed_rating_sec_d_add' . $index];


        //assignment object
        $assignment = [];
        $assignment['objective_id'] = $objective;
        $assignment['expected_output'] = $expectedOutput;
        $assignment['actual_performance'] = $actualPerformance;


        /*
         * If these fields are empty, i dont send them, eg its still at the appraisee and the appraiser marks are not there
         * */
        if (isset($maxRating) && !empty($maxRating)) {
            $assignment['maximum_rating'] = $maxRating;
        }
        if (isset($appraiseeRating) && !empty($appraiseeRating)) {
            $assignment['appraisee_rating'] = $appraiseeRating;
        }
        if (isset($appraiserRating) && !empty($appraiserRating)) {
            $assignment['appraiser_rating'] = $appraiserRating;
        }
        if (isset($agreedRating) && !empty($agreedRating)) {
            $assignment['agreed_rating'] = $agreedRating;
            return $assignment;
        }

        return $assignment;

    }

    /**
     * @param $request
     * @param $i
     * @return array
     */
    private function getAdditionalAssignmentUpdateRowData($request, $i) {

        $objective = $request['objective_' . $i];
        $expectedOutput = $request['expected_output_sec_d_add' . $i];
        $actualPerformance = $request['actual_performance_sec_d_add' . $i];
        $maxRating = $request['max_rating_sec_d_add' . $i];
        $appraiseeRating = $request['appraisee_rating_sec_d_add' . $i];
        $appraiserRating = $request['appraiser_rating_sec_d_add' . $i];
        $agreedRating = $request['agreed_rating_sec_d_add' . $i];

        //assignment object
        $assignment = [];
        $assignment['objective_id'] = $objective;
        $assignment['expected_output'] = $expectedOutput;
        $assignment['actual_performance'] = $actualPerformance;

        /*
         * If these fields are empty, i dont send them, eg its still at the appraisee and the appraiser marks are not there
         * */
        if (isset($maxRating) && !empty($maxRating)) {
            $assignment['maximum_rating'] = $maxRating;
        }
        if (isset($appraiseeRating) && !empty($appraiseeRating)) {
            $assignment['appraisee_rating'] = $appraiseeRating;
        }
        if (isset($appraiserRating) && !empty($appraiserRating)) {
            $assignment['appraiser_rating'] = $appraiserRating;
        }
        if (isset($agreedRating) && !empty($agreedRating)) {
            $assignment['agreed_rating'] = $agreedRating;
        }

        $recordId = $request['record_id_' . $i];

        //if no recordId, then it's a new being added dynamically
        if (isset($recordId)) {
            $assignment['record_id'] = $recordId;
        }

        return $assignment;

    }

    private function validInputSectionDAdditionalSummary($sec_d_final_percentage_score, $sec_d_weighed, $sec_d_appraiser_comment) {

        return
            (isset($sec_d_final_percentage_score) && !empty($sec_d_final_percentage_score))  &&
            (isset($sec_d_weighed) && !empty($sec_d_weighed)) &&
            (isset($sec_d_appraiser_comment) && !empty($sec_d_appraiser_comment));

    }

    private function validInputSectionESummary($secEFinalPercentageScore, $secEWeighed, $finalScoreSecD, $finalScoreSecE, $overallTotal) {

        return
        isset($secEFinalPercentageScore) && !empty($secEFinalPercentageScore) &&
        isset($secEWeighed) && !empty($secEWeighed) &&
        isset($finalScoreSecD) && !empty($finalScoreSecD) &&
        isset($finalScoreSecE) && !empty($finalScoreSecE) &&
        isset($overallTotal) && !empty($overallTotal);

    }

}
