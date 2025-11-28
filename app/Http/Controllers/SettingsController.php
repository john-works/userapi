<?php

namespace App\Http\Controllers;

use App\Department;
use app\Helpers\ApiHandler;
use app\Helpers\AppConstants;
use app\Helpers\ConstAppraisalStatus;
use app\Helpers\DataFormatter;
use app\Helpers\DataLoader;
use app\Helpers\EndPoints;
use app\Helpers\Security;
use app\Helpers\SharedCommons;
use App\Http\Requests\CreateDepartmentRequest;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EmployeeCategoryRequest;
use App\Http\Requests\OrganizationRequest;
use App\Http\Requests\RegionalOfficeRequest;
use app\Models\ApiAppraisalReq;
use app\Repositories\General\OrganizationsRepo;
use App\Role;
use App\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SettingsController extends BaseController
{

    public function __construct() {
        parent::__construct(AppConstants::$ACTIVE_MOD_SETTINGS);
    }


    /*
     * Logic for organizations : Start
     * */

    public function getCreationOrganizationForm($message = null, $isError = false){

        /*
         * Set variable for the active module for highlight purposes
         * */

        $active_module = $this->active_module;

        /*
         * Get the user who is logged in
         * */
        $user = session(Security::$SESSION_USER);

        /*
         * What happens if I fail to get the user who is logged in, I redirect to login page
         * */
        if($user == null){
            return redirect('/');
        }


        /*
         * We managed to get the logged in user
         * */

        /*
         * Here a dealing with a new request to this page, we a just returning a fresh page
         * */
        if($message == null){

            return view('organizations/org-form',compact('active_module','user'));

        }



        /*
         * Here it's like have been doing some stuff on the page
         * */


        /*
         * We were creating an organization and got an error
         * */
        if($isError){

            return back()
                ->withInput()
                ->withErrors([$message]);

        }else{

            $successMessage = $message;
            return view('organizations/org-form',compact('active_module','user','successMessage'));

        }

    }


    public function storeOrganization(OrganizationRequest $request){


        /*
         * Get the authentication token
         * */
        $token = Cookie::get(Security::$COOKIE_TOKEN);


        /*
         * Request data
         * */
        $data = [
            'name' => $request['name'],
            'org_code' => $request['org_code'],
            'email' => $request['email'],
            'location' => $request['location'],
            'contact_person_name' => $request['contact_person_name'],
            'contact_person_contact' => $request['contact_person_contact'],
            'description' => $request['description'],
            'created_by' => $request['created_by'],
        ];


        /*
         * Action
         * */
        $action = endpoint('ORGANIZATIONS_STORE');


        /*
         * Send request to the API
         * */
        $resp = ApiHandler::makePostRequest($action, $data, true, $token);

        /*
         * Error occurred on sending the request, redirect to the page with data
         * */
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            return $this->getCreationOrganizationForm($resp->statusDescription, true);

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

            return $this->getCreationOrganizationForm($statusDescription, true);

        }


        /*
         * Operation was successful at the server side
         * */

        $successMessage = "ORGANIZATION [".$request['name']."] SUCCESSFULLY CREATED";

        /*
         * Return to the form create page with a success message
         * */
        return $this->getCreationOrganizationForm($successMessage);

    }


    public function allOrganizations($deletionMessage = null){

        /*
         * Aren't you supposed to put this stuff in a try catch block
         * */

        /*
         * Get tha access token
         * */
        $token = Cookie::get(Security::$COOKIE_TOKEN);

        /*
         * Send request to the api
         * */
        $resp = ApiHandler::makeGetRequest(endpoint('ORGANIZATIONS_ALL'), true, $token);

        /*
         * We didn't get a response from API
         * */
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            /*
             * Return error
             * */
            return $resp->statusDescription;
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
            /*
             * Return error
             * */
            return $statusDescription;
        }


        /*
         * We got the data from the API
         * */
        $data = $apiResp['data'];


        /*
         * Format user data
         * */
        $organizations = DataFormatter::formatOrganizations($data);


        /*
         * Holds the active module
         * */
        $active_module = $this->active_module;

        /*
         * Get logged in user
         * */
        $author = session(Security::$SESSION_USER);

        if($author == null){
            return AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN;
        }

        $resp1 = DataLoader::allUsers();
        $users = $resp1->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $resp1->result : [];

        /*
         * Return the view with the organizations
         * */
        return view('organizations/org-list',compact('active_module','author','organizations','deletionMessage','users'));

    }


    public function saveOrgAjax(Request $request){

        try{


            if(!$request->ajax()){

                return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);

            }


            $validator = Validator::make($request->all(), [
                'name'=>'required|min:2', 'email'=>'required|email', 'created_by' => 'required',
            ]);


            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }


            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $data = [
                'name' => $request['name'],
                'email' => $request['email'],
                'location' => $request['location'],
                'contact_person_name' => $request['contact_person_name'],
                'contact_person_contact' => $request['contact_person_contact'],
                'description' => $request['description'],
                'created_by' => $request['created_by'],
            ];

            $action = endpoint('ORGANIZATIONS_STORE');
            $resp = ApiHandler::makePostRequest($action, $data, true, $token);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return response()->json(['error'=>[$resp->statusDescription]]);
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
                return response()->json(['error'=>[$statusDescription]]);
            }

            $successMessage = "ORGANIZATION [".$request['name']."] SUCCESSFULLY CREATED";
            return response()->json(['success' => $successMessage]);


        }catch (\Exception $exception){
            return response()->json(['error'=>[AppConstants::generalError($exception->getMessage())]]);
        }

    }


    public function saveRegionalOfficeAjax(Request $request){

        try{


            if(!$request->ajax()){
                return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
            }

            $validator = Validator::make($request->all(), [
                'name'=>'required|min:2', 'org_code'=>'required', 'created_by'=>'required'
            ]);


            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $data = [
                'name' => $request['name'],
                'org_code' => $request['org_code'],
                'email' => $request['email'],
                'location' => $request['location'],
                'contact_person_name' => $request['contact_person_name'],
                'contact_person_contact' => $request['contact_person_contact'],
                'created_by' => $request['created_by'],
            ];


            $action = endpoint('REGIONAL_OFFICES_STORE');
            $resp = ApiHandler::makePostRequest($action, $data, true, $token);


            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return response()->json(['error'=>[$resp->statusDescription]]);
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
                return response()->json(['error'=>[$statusDescription]]);
            }

            $successMessage = "REGIONAL OFFICE [".$request['name']."] SUCCESSFULLY CREATED";
            return response()->json(['success' => $successMessage]);


        }catch (\Exception $exception){
            return response()->json(['error'=>[AppConstants::generalError($exception->getMessage())]]);
        }

    }


    public function saveRoleCodeAjax(Request $request){

        try{


            if(!$request->ajax()){
                return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
            }


            $validator = Validator::make($request->all(), [
                'role_name'=>'required|min:2', 'org_code'=>'required', 'created_by'=>'required'
            ]);


            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $data = [
                'role_name' => $request['role_name'],
                'org_code' => $request['org_code'],
                'created_by' => $request['created_by'],
            ];

            $action = endpoint('ROLE_CODES_STORE');
            $resp = ApiHandler::makePostRequest($action, $data, true, $token);


            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return response()->json(['error'=>[$resp->statusDescription]]);
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
                return response()->json(['error'=>[$statusDescription]]);
            }

            $successMessage = "ROLE CODE [".$request['name']."] SUCCESSFULLY CREATED";
            return response()->json(['success' => $successMessage]);


        }catch (\Exception $exception){
            return response()->json(['error'=>[AppConstants::generalError($exception->getMessage())]]);
        }

    }


    public function saveEmployeeCategoryAjax(Request $request){

        try{


            if(!$request->ajax()){
                return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
            }


            $validator = Validator::make($request->all(), [
                'category'=>'required|min:2','org_code'=>'required', 'created_by'=>'required'
            ]);


            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $data = [
                'category' => $request['category'],
                'org_code' => $request['org_code'],
                'created_by' => $request['created_by'],
            ];

            $action = endpoint('EMPLOYEE_CATEGORIES_STORE');
            $resp = ApiHandler::makePostRequest($action, $data, true, $token);


            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return response()->json(['error'=>[$resp->statusDescription]]);
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
                return response()->json(['error'=>[$statusDescription]]);
            }

            $successMessage = "EMPLOYEE CATEGORY [".$request['category']."] SUCCESSFULLY CREATED";
            return response()->json(['success' => $successMessage]);


        }catch (\Exception $exception){
            return response()->json(['error'=>[AppConstants::generalError($exception->getMessage())]]);
        }

    }


    public function saveDepartmentAjax(Request $request){

        try{


            if(!$request->ajax()){
                return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
            }


            $validator = Validator::make($request->all(), [
                'name'=>'required|min:2', 'org_code'=>'required', 'created_by'=>'required'
               ]);


            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $data = [
                'name' => $request['name'],
                'org_code' => $request['org_code'],
                'created_by' => $request['created_by'],
                'head_of_department' => $request['head_of_department'],
            ];

            $action = endpoint('DEPARTMENTS_STORE');
            $resp = ApiHandler::makePostRequest($action, $data, true, $token);


            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return response()->json(['error'=>[$resp->statusDescription]]);
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
                return response()->json(['error'=>[$statusDescription]]);
            }

            $successMessage = "EMPLOYEE CATEGORY [".$request['category']."] SUCCESSFULLY CREATED";
            return response()->json(['success' => $successMessage]);


        }catch (\Exception $exception){
            return response()->json(['error'=>[AppConstants::generalError($exception->getMessage())]]);
        }

    }


    public function saveDepartmentUnitAjax(Request $request){

        try{


            if(!$request->ajax()){
                return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
            }


            $validator = Validator::make($request->all(), [
                'name'=>'required|min:2', 'department_code'=>'required'
            ]);


            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $data = [
                'name' => $request['name'],
                'department_code' => $request['department_code']
            ];

            $action = endpoint('DEPARTMENT_UNIT_STORE');
            $resp = ApiHandler::makePostRequest($action, $data, true, $token);


            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return response()->json(['error'=>[$resp->statusDescription]]);
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
                return response()->json(['error'=>[$statusDescription]]);
            }

            $successMessage = "DEPARTMENT UNIT [".$request['name']."] SUCCESSFULLY CREATED";
            return response()->json(['success' => $successMessage]);


        }catch (\Exception $exception){
            return response()->json(['error'=>[AppConstants::generalError($exception->getMessage())]]);
        }

    }


    public function editOrganization(Request $request){

        /*
         * Check if request received is ajax
         * */
        if(!$request->ajax()){

            /*
             * We did not get JSON from the client
             * */
            return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);

        }

        /*
         * Validate JSON Request
         * */
        $validator = Validator::make($request->all(), [
            'name'=>'required|min:2',
            'org_code'=>'required',
            'email'=>'required|email',
            'created_by' => 'required',
            'updated_by' => 'required',
            'executive_director' => 'required',
        ]);


        /*
         * Check if validation passed
         * */
        if (!$validator->passes()) {
            /*
             * Validation failed
             * */
            return response()->json(['error'=>$validator->errors()->all()]);

        }

        /*
         * Validation was Successful
         * */
        return $this->updateOrganizationViaApi($request);

    }


    public function deleteOrganization(Request $request){

        try{

            /*
             * Get the authentication token
             * */
            $token = Cookie::get(Security::$COOKIE_TOKEN);

            /*
             * Record we are updating
             * */
            $orgCode = $request['id'];


            /*
             * Get the user who is deleting
             * */
            $user = session(Security::$SESSION_USER);

            /*
             * We failed to get the logged in user
             * */
            if($user == null){
                return $this->allOrganizations(AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN);
            }

            /*
             * Request data
             * */
            $data = [ 'deleted_by' => $user->username ];


            /*
             * Action
             * */
            $action = endpoint('ORGANIZATIONS_DELETE');


            /*
             * Send request to the API
             * */
            $resp = ApiHandler::makeDeleteRequest($action, $orgCode, $data, true, $token);

            /*
             * Error occurred on sending the request
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->allOrganizations($resp->statusDescription);
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


            /*
             * Api returned failed
             * */
            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->allOrganizations($resp->$statusDescription);
            }


            /*
             * Operation was successful at the server side
             * */

            $successMessage = "ORGANIZATION [".$orgCode."] SUCCESSFULLY DELETED";


            /*
             * Return to the form create page with a success message
             * */
            return $this->allOrganizations($successMessage);


        }catch (\Exception $exception){

            /*
             * We should log the error message we have got
             * */
            $errorMessage = "Failed To Delete Organization With Error. ".$exception->getMessage();
            return $this->allOrganizations($errorMessage);

        }


    }



    /*
     * Logic for organizations : End
     * */






    /*
 * Logic for Regional Offices : Start
 * */

    public function getCreationRegionalOfficeForm($message = null, $isError = false){

        /*
         * Set variable for the active module for highlight purposes
         * */

        $active_module = $this->active_module;

        /*
         * Get the user who is logged in
         * */
        $user = session(Security::$SESSION_USER);

        /*
         * What happens if I fail to get the user who is logged in, I redirect to login page
         * */
        if($user == null){
            return redirect('/');
        }


        /*
         * We managed to get the logged in user,
         * Now we need to go and get the list of organizations
         * */

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

        /*
         * Here a dealing with a new request to this page, we a just returning a fresh page
         * */
        if($message == null){

            return view('regional-offices/reg-office-form',compact('active_module','user','organizations'));

        }



        /*
         * Here it's like have been doing some stuff on the page
         * */


        /*
         * We were creating a regional office and got an error
         * */
        if($isError){

            return back()
                ->withInput()
                ->withErrors([$message]);

        }else{

            $successMessage = $message;
            return view('regional-offices/reg-office-form',compact('active_module','user','organizations','successMessage'));

        }

    }


    public function storeRegionalOffice(RegionalOfficeRequest $request){


        /*
         * Get the authentication token
         * */
        $token = Cookie::get(Security::$COOKIE_TOKEN);


        /*
         * Request data
         * */
        $data = [
            'name' => $request['name'],
            'org_code' => $request['org_code'],
            'regional_office_code' => $request['regional_office_code'],
            'email' => $request['email'],
            'location' => $request['location'],
            'contact_person_name' => $request['contact_person_name'],
            'contact_person_contact' => $request['contact_person_contact'],
            'description' => $request['description'],
            'created_by' => $request['created_by'],
        ];


        /*
         * Action
         * */
        $action = endpoint('REGIONAL_OFFICES_STORE');


        /*
         * Send request to the API
         * */
        $resp = ApiHandler::makePostRequest($action, $data, true, $token);

        /*
         * Error occurred on sending the request, redirect to the page with data
         * */
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            return $this->getCreationRegionalOfficeForm($resp->statusDescription, true);

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

            return $this->getCreationRegionalOfficeForm($statusDescription, true);

        }


        /*
         * Operation was successful at the server side
         * */

        $successMessage = "REGIONAL OFFICE [".$request['name']."] SUCCESSFULLY CREATED";

        /*
         * Return to the form create page with a success message
         * */
        return $this->getCreationRegionalOfficeForm($successMessage);

    }


    public function allRegionalOffices($deletionMessage = null){

        /*
         * Aren't you supposed to put this stuff in a try catch block
         * */

        /*
         * Get tha access token
         * */
        $token = Cookie::get(Security::$COOKIE_TOKEN);

        /*
         * Send request to the api
         * */
        $resp = ApiHandler::makeGetRequest(endpoint('REGIONAL_OFFICES_ALL'), true, $token);

        /*
         * We didn't get a response from API
         * */
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            /*
             * Return error
             * */
            return $resp->statusDescription;
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
            /*
             * Return error
             * */
            return $statusDescription;
        }


        /*
         * We got the data from the API
         * */
        $data = $apiResp['data'];


        /*
         * Format user data
         * */
        $regionalOffices = DataFormatter::formatRegionalOffices($data);


        /*
         * Get logged in user
         * */
        $author = session(Security::$SESSION_USER);

        if($author == null){
            return AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN;
        }


        /*
         * Get list of organizations
         * */
        $repoResp = OrganizationsRepo::allOrganizations($token);

        if($repoResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return $repoResp->statusDescription;
        }

        $organizations = $repoResp->repoData;

        /*
         * Holds the active module
         * */
        $active_module = $this->active_module;


        /*
         * Return the view with the regional offices
         * */
        return view('regional-offices/reg-office-list',compact('active_module','author','organizations','regionalOffices','deletionMessage'));

    }


    public function editRegionalOffice(Request $request){

        /*
         * Check if request received is ajax
         * */
        if(!$request->ajax()){

            /*
             * We did not get JSON from the client
             * */
            return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);

        }

        /*
         * Validate JSON Request
         * */
        $validator = Validator::make($request->all(), [
            'name'=>'required|min:2',
            'org_code'=>'required',
            'regional_office_code'=>'required',
            'updated_by' => 'required',
        ]);


        /*
         * Check if validation passed
         * */
        if (!$validator->passes()) {
            /*
             * Validation failed
             * */
            return response()->json(['error'=>$validator->errors()->all()]);

        }

        /*
         * Validation was Successful
         * */
        return $this->updateRegionalOfficeViaApi($request);

    }


    public function deleteRegionalOffice(Request $request){

        try{

            /*
             * Get the authentication token
             * */
            $token = Cookie::get(Security::$COOKIE_TOKEN);

            /*
             * Record we are updating
             * */
            $regionalOfficeCode = $request['id'];


            /*
             * Get the user who is deleting
             * */
            $user = session(Security::$SESSION_USER);

            /*
             * We failed to get the logged in user
             * */
            if($user == null){
                return $this->allRegionalOffices(AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN);
            }

            /*
             * Request data
             * */
            $data = [ 'deleted_by' => $user->username ];


            /*
             * Action
             * */
            $action = endpoint('REGIONAL_OFFICES_DELETE');


            /*
             * Send request to the API
             * */
            $resp = ApiHandler::makeDeleteRequest($action, $regionalOfficeCode, $data, true, $token);

            /*
             * Error occurred on sending the request
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->allRegionalOffices($resp->statusDescription);
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


            /*
             * Api returned failed
             * */
            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->allRegionalOffices($resp->$statusDescription);
            }


            /*
             * Operation was successful at the server side
             * */

            $successMessage = "REGIONAL OFFICE [".$regionalOfficeCode."] SUCCESSFULLY DELETED";


            /*
             * Return to the form create page with a success message
             * */
            return $this->allRegionalOffices($successMessage);


        }catch (\Exception $exception){

            /*
             * We should log the error message we have got
             * */
            $errorMessage = "Failed To Delete Regional Office With Error. ".$exception->getMessage();
            return $this->allRegionalOffices($errorMessage);

        }


    }


    /*
     * Logic for Regional Offices : End
     * */



    /*
    * Logic for Departments : Start
    * */

    public function getCreationDepartmentForm($message = null, $isError = false){

        /*
         * Set variable for the active module for highlight purposes
         * */

        $active_module = $this->active_module;

        /*
         * Get the user who is logged in
         * */
        $user = session(Security::$SESSION_USER);

        /*
         * What happens if I fail to get the user who is logged in, I redirect to login page
         * */
        if($user == null){
            return redirect('/');
        }


        /*
         * We managed to get the logged in user,
         * Now we need to go and get the list of organizations
         * */

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

        /*
         * Here a dealing with a new request to this page, we a just returning a fresh page
         * */
        if($message == null){

            return view('departments/department-form',compact('active_module','user','organizations'));

        }


        /*
         * Here it's like have been doing some stuff on the page
         * */


        /*
         * We were creating a regional office and got an error
         * */
        if($isError){

            return back()
                ->withInput()
                ->withErrors([$message]);

        }else{

            $successMessage = $message;
            return view('departments/department-form',compact('active_module','user','organizations','successMessage'));

        }

    }


    public function storeDepartment(CreateDepartmentRequest $request){


        /*
         * Get the authentication token
         * */
        $token = Cookie::get(Security::$COOKIE_TOKEN);


        /*
         * Request data
         * */
        $data = [
            'name' => $request['name'],
            'org_code' => $request['org_code'],
            'department_code' => $request['department_code'],
            'created_by' => $request['created_by'],
        ];


        /*
         * Action
         * */
        $action = endpoint('DEPARTMENTS_STORE');


        /*
         * Send request to the API
         * */
        $resp = ApiHandler::makePostRequest($action, $data, true, $token);

        /*
         * Error occurred on sending the request, redirect to the page with data
         * */
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            return $this->getCreationDepartmentForm($resp->statusDescription, true);

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

            return $this->getCreationDepartmentForm($statusDescription, true);

        }


        /*
         * Operation was successful at the server side
         * */

        $successMessage = "DEPARTMENT [".$request['name']."] SUCCESSFULLY CREATED";

        /*
         * Return to the form create page with a success message
         * */
        return $this->getCreationDepartmentForm($successMessage);

    }


    public function allDepartments($deleteMessage = null){

        /*
         * Aren't you supposed to put this stuff in a try catch block
         * */

        /*
         * Get the access token
         * */
        $token = Cookie::get(Security::$COOKIE_TOKEN);


        /*
         * Send request to the api
         * */
        $resp = ApiHandler::makeGetRequest(endpoint('DEPARTMENTS_ALL'), true, $token);

        /*
         * We didn't get a response from API
         * */
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            /*
             * Return error
             * */
            return $resp->statusDescription;
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
            /*
             * Return error
             * */
            return $statusDescription;
        }


        /*
         * We got the data from the API
         * */
        $data = $apiResp['data'];


        /*
         * Format data
         * */
        $departments = DataFormatter::formatDepartments($data);


        /*
         * Holds the active module
         * */
        $active_module = $this->active_module;


        /*
         * Get logged in user
         * */
        $author = session(Security::$SESSION_USER);

        if($author == null){
            return AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN;
        }


        /*
         * Get list of organizations
         * */
        $repoResp = OrganizationsRepo::allOrganizations($token);

        if($repoResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return $repoResp->statusDescription;
        }

        $organizations = $repoResp->repoData;

        $resp1 = DataLoader::allUsers();
        $users = $resp1->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $resp1->result : [];

        /*
         * Return the view with the regional offices
         * */
        return view('departments/department-list',compact('active_module','author','departments','organizations','users','deleteMessage'));

    }



    public function allDepartmentUnits($deleteMessage = null){


         /*
         * Get the access token
         * */
        $token = Cookie::get(Security::$COOKIE_TOKEN);


        /*
         * Send request to the api
         * */
        $resp = ApiHandler::makeGetRequest(endpoint('DEPARTMENT_UNIT_ALL'), true, $token);

        /*
         * We didn't get a response from API
         * */
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            /*
             * Return error
             * */
            return $this->redirectBackToFormWithError($resp->statusDescription);
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
            return $this->redirectBackToFormWithError($statusDescription);
        }


        /*
         * We got the data from the API
         * */
        $data = $apiResp['data'];


        /*
         * Format data
         * */
        $units = DataFormatter::formatDepartmentUnits($data);

        /*
         * Holds the active module
         * */
        $active_module = $this->active_module;


        /*
         * Get logged in user
         * */
        $author = session(Security::$SESSION_USER);

        if($author == null){
            return AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN;
        }


        $deptResp = DataLoader::getDepartments();
        $departments = $deptResp->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $deptResp->result : [];

        /*
         * Return the view with the regional offices
         * */
        return view('department-units/unit-list',compact('active_module','author','departments','units','deleteMessage'));

    }




    /*
     * Logic for Departments : End
     * */




    /*
    * Logic for Role Codes : Start
    * */

    public function getCreationRoleCodeForm($message = null, $isError = false){

        /*
         * Set variable for the active module for highlight purposes
         * */

        $active_module = $this->active_module;

        /*
         * Get the user who is logged in
         * */
        $user = session(Security::$SESSION_USER);

        /*
         * What happens if I fail to get the user who is logged in, I redirect to login page
         * */
        if($user == null){
            return redirect('/');
        }


        /*
         * We managed to get the logged in user,
         * Now we need to go and get the list of organizations
         * */

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

        /*
         * Here a dealing with a new request to this page, we a just returning a fresh page
         * */
        if($message == null){

            return view('roles/role-code-form',compact('active_module','user','organizations'));

        }


        /*
         * Here it's like have been doing some stuff on the page
         * */


        /*
         * We were creating a role code and got an error
         * */
        if($isError){

            return back()
                ->withInput()
                ->withErrors([$message]);

        }else{

            $successMessage = $message;
            return view('roles/role-code-form',compact('active_module','user','organizations','successMessage'));

        }

    }


    public function storeRoleCode(CreateRoleRequest $request){


        /*
         * Get the authentication token
         * */
        $token = Cookie::get(Security::$COOKIE_TOKEN);


        /*
         * Request data
         * */
        $data = [
            'role_name' => $request['role_name'],
            'role_code' => $request['role_code'],
            'org_code' => $request['org_code'],
            'created_by' => $request['created_by'],
        ];


        /*
         * Action
         * */
        $action = endpoint('ROLE_CODES_STORE');


        /*
         * Send request to the API
         * */
        $resp = ApiHandler::makePostRequest($action, $data, true, $token);

        /*
         * Error occurred on sending the request, redirect to the page with data
         * */
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            return $this->getCreationRoleCodeForm($resp->statusDescription, true);

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

            return $this->getCreationRoleCodeForm($statusDescription, true);

        }


        /*
         * Operation was successful at the server side
         * */

        $successMessage = "SYSTEM ROLE [".$request['role_name']."] SUCCESSFULLY CREATED";

        /*
         * Return to the form create page with a success message
         * */
        return $this->getCreationRoleCodeForm($successMessage);

    }


    public function allRoleCodes($deletionMessage = null){

        /*
         * Aren't you supposed to put this stuff in a try catch block
         * */

        /*
         * Get tha access token
         * */
        $token = Cookie::get(Security::$COOKIE_TOKEN);

        /*
         * Send request to the api
         * */
        $resp = ApiHandler::makeGetRequest(endpoint('ROLE_CODES_ALL'), true, $token);

        /*
         * We didn't get a response from API
         * */
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            /*
             * Return error
             * */
            return $resp->statusDescription;
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
            /*
             * Return error
             * */
            return $statusDescription;
        }


        /*
         * We got the data from the API
         * */
        $data = $apiResp['data'];


        /*
         * Format data
         * */
        $roleCodes = DataFormatter::formatRoleCodes($data);


        /*
         * Holds the active module
         * */
        $active_module = $this->active_module;


        /*
         * Get logged in user
         * */
        $author = session(Security::$SESSION_USER);

        if($author == null){
            return AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN;
        }


        /*
         * Get list of organizations
         * */
        $repoResp = OrganizationsRepo::allOrganizations($token);

        if($repoResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return $repoResp->statusDescription;
        }

        $organizations = $repoResp->repoData;

        /*
         * Return the view with the role codes
         * */
        return view('roles/role-code-list',compact('active_module','author','organizations','roleCodes','deletionMessage'));

    }


    public function editRoleCode(Request $request){

        /*
         * Check if request received is ajax
         * */
        if(!$request->ajax()){

            /*
             * We did not get JSON from the client
             * */
            return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);

        }

        /*
         * Validate JSON Request
         * */
        $validator = Validator::make($request->all(), [
            'role_name' => 'required|min:2',
            'role_code' => 'required',
            'org_code' => 'required',
            'created_by' => 'required',
            'updated_by' => 'required',
        ]);


        /*
         * Check if validation passed
         * */
        if (!$validator->passes()) {
            /*
             * Validation failed
             * */
            return response()->json(['error'=>$validator->errors()->all()]);

        }

        /*
         * Validation was Successful
         * */
        return $this->updateRoleCodeViaApi($request);

    }


    public function deleteRoleCode(Request $request){

        try{

            /*
             * Get the authentication token
             * */
            $token = Cookie::get(Security::$COOKIE_TOKEN);

            /*
             * Record we are updating
             * */
            $roleCode = $request['id'];


            /*
             * Get the user who is deleting
             * */
            $user = session(Security::$SESSION_USER);

            /*
             * We failed to get the logged in user
             * */
            if($user == null){
                return $this->allRoleCodes(AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN);
            }

            /*
             * Request data
             * */
            $data = [ 'deleted_by' => $user->username ];


            /*
             * Action
             * */
            $action = endpoint('ROLE_CODES_DELETE');


            /*
             * Send request to the API
             * */
            $resp = ApiHandler::makeDeleteRequest($action, $roleCode, $data, true, $token);

            /*
             * Error occurred on sending the request
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->allRoleCodes($resp->statusDescription);
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


            /*
             * Api returned failed
             * */
            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->allRoleCodes($resp->$statusDescription);
            }


            /*
             * Operation was successful at the server side
             * */

            $successMessage = "ROLE CODE [".$roleCode."] SUCCESSFULLY DELETED";


            /*
             * Return to the form create page with a success message
             * */
            return $this->allRoleCodes($successMessage);


        }catch (\Exception $exception){

            /*
             * We should log the error message we have got
             * */
            $errorMessage = "Failed To Delete Role Code With Error. ".$exception->getMessage();
            return $this->allRoleCodes($errorMessage);

        }


    }


    /*
     * Logic for Role Codes : End
     * */




    /*
    * Logic for Employee Categories : Start
    * */

    public function getCreationEmployeeCategoryForm($message = null, $isError = false){

        /*
         * Set variable for the active module for highlight purposes
         * */

        $active_module = $this->active_module;

        /*
         * Get the user who is logged in
         * */
        $user = session(Security::$SESSION_USER);

        /*
         * What happens if I fail to get the user who is logged in, I redirect to login page
         * */
        if($user == null){
            return redirect('/');
        }


        /*
         * We managed to get the logged in user,
         * Now we need to go and get the list of organizations
         * */

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

        /*
         * Here a dealing with a new request to this page, we a just returning a fresh page
         * */
        if($message == null){

            return view('employee-categories/employee-category-form',compact('active_module','user','organizations'));

        }


        /*
         * Here it's like have been doing some stuff on the page
         * */


        /*
         * We were creating a role code and got an error
         * */
        if($isError){

            return back()
                ->withInput()
                ->withErrors([$message]);

        }else{

            $successMessage = $message;
            return view('employee-categories/employee-category-form',compact('active_module','user','organizations','successMessage'));

        }

    }


    public function storeEmployeeCategory(EmployeeCategoryRequest $request){


        /*
         * Get the authentication token
         * */
        $token = Cookie::get(Security::$COOKIE_TOKEN);


        /*
         * Request data
         * */
        $data = [
            'category' => $request['category'],
            'category_code' => $request['category_code'],
            'org_code' => $request['org_code'],
            'created_by' => $request['created_by'],
        ];


        /*
         * Action
         * */
        $action = endpoint('EMPLOYEE_CATEGORIES_STORE');


        /*
         * Send request to the API
         * */
        $resp = ApiHandler::makePostRequest($action, $data, true, $token);

        /*
         * Error occurred on sending the request, redirect to the page with data
         * */
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            return $this->getCreationEmployeeCategoryForm($resp->statusDescription, true);

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

            return $this->getCreationEmployeeCategoryForm($statusDescription, true);

        }


        /*
         * Operation was successful at the server side
         * */

        $successMessage = "EMPLOYEE CATEGORY [".$request['category']."] SUCCESSFULLY CREATED";

        /*
         * Return to the form create page with a success message
         * */
        return $this->getCreationEmployeeCategoryForm($successMessage);

    }


    public function allEmployeeCategories($deletionMessage = null){

        /*
         * Aren't you supposed to put this stuff in a try catch block
         * */

        /*
         * Get tha access token
         * */
        $token = Cookie::get(Security::$COOKIE_TOKEN);

        /*
         * Send request to the api
         * */
        $resp = ApiHandler::makeGetRequest(endpoint('EMPLOYEE_CATEGORIES_ALL'), true, $token);

        /*
         * We didn't get a response from API
         * */
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            /*
             * Return error
             * */
            return $resp->statusDescription;
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
            /*
             * Return error
             * */
            return $statusDescription;
        }


        /*
         * We got the data from the API
         * */
        $data = $apiResp['data'];


        /*
         * Format data
         * */
        $employeeCategories = DataFormatter::formatEmployeeCategories($data);


        /*
         * Holds the active module
         * */
        $active_module = $this->active_module;


        /*
         * Get logged in user
         * */
        $author = session(Security::$SESSION_USER);

        if($author == null){
            return AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN;
        }


        /*
         * Get list of organizations
         * */
        $repoResp = OrganizationsRepo::allOrganizations($token);

        if($repoResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return $repoResp->statusDescription;
        }

        $organizations = $repoResp->repoData;


        /*
         * Return the view with the role codes
         * */
        return view('employee-categories/employee-category-list',compact('active_module','author','organizations','employeeCategories','deletionMessage'));

    }


    public function editEmployeeCategory(Request $request){

        /*
         * Check if request received is ajax
         * */
        if(!$request->ajax()){

            /*
             * We did not get JSON from the client
             * */
            return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);

        }

        /*
         * Validate JSON Request
         * */
        $validator = Validator::make($request->all(), [
            'category' => 'required|min:2',
            'category_code' => 'required',
            'org_code' => 'required',
            'created_by' => 'required',
            'updated_by' => 'required',
        ]);


        /*
         * Check if validation passed
         * */
        if (!$validator->passes()) {
            /*
             * Validation failed
             * */
            return response()->json(['error'=>$validator->errors()->all()]);

        }

        /*
         * Validation was Successful
         * */
        return $this->updateEmployeeCategoryViaApi($request);

    }


    public function deleteEmployeeCategory(Request $request){

        try{

            /*
             * Get the authentication token
             * */
            $token = Cookie::get(Security::$COOKIE_TOKEN);

            /*
             * Record we are updating
             * */
            $categoryCode = $request['id'];


            /*
             * Get the user who is deleting
             * */
            $user = session(Security::$SESSION_USER);

            /*
             * We failed to get the logged in user
             * */
            if($user == null){
                return $this->allEmployeeCategories(AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN);
            }

            /*
             * Request data
             * */
            $data = [ 'deleted_by' => $user->username ];


            /*
             * Action
             * */
            $action = endpoint('EMPLOYEE_CATEGORIES_DELETE');


            /*
             * Send request to the API
             * */
            $resp = ApiHandler::makeDeleteRequest($action, $categoryCode, $data, true, $token);

            /*
             * Error occurred on sending the request
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->allEmployeeCategories($resp->statusDescription);
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


            /*
             * Api returned failed
             * */
            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->allEmployeeCategories($resp->$statusDescription);
            }


            /*
             * Operation was successful at the server side
             * */

            $successMessage = "EMPLOYEE CATEGORY [".$categoryCode."] SUCCESSFULLY DELETED";


            /*
             * Return to the form create page with a success message
             * */
            return $this->allEmployeeCategories($successMessage);


        }catch (\Exception $exception){

            /*
             * We should log the error message we have got
             * */
            $errorMessage = "Failed To Delete Employee Category With Error. ".$exception->getMessage();
            return $this->allEmployeeCategories($errorMessage);

        }


    }


    /*
     * Logic for Employee Categories : End
     * */





    public function departments(){


        $active_module = $this->active_module;
        $departments = Department::all();
        return view('departments/departments',compact('active_module','departments'));

    }

    public function roles(){

        $active_module = $this->active_module;
        $roles = Role::all();
        return view('roles/roles',compact('active_module','roles'));

    }

    public function createDepartment(CreateDepartmentRequest $request){

        Department::create($request->all());
        $message = "Department with name ".$request->input('department')." created";
        $active_module = $this->active_module;

        $departments = Department::all();
        return view('departments/departments',compact('active_module','message','departments'));

    }

    public function editDepartment(Request $request){

        /*
         * Check if request received is ajax
         * */
        if(!$request->ajax()){

            /*
             * We did not get JSON from the client
             * */
            return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);

        }

        /*
         * Validate JSON Request
         * */
        $validator = Validator::make($request->all(), [
            /*'institution' => 'institution|min:2',
            'institution' => 'institution|min:2',
            'institution' => 'institution|min:2', */
        ]);


        /*
         * Check if validation passed
         * */
        if (!$validator->passes()) {
            /*
             * Validation failed
             * */
            return response()->json(['error'=>$validator->errors()->all()]);

        }

        /*
         * Validation was Successful
         * */
        return $this->updateDepartmentViaApi($request);

    }

    public function deleteDepartment(Request $request){

        try{

            /*
             * Get the authentication token
             * */
            $token = Cookie::get(Security::$COOKIE_TOKEN);

            /*
             * Department we are updating
             * */
            $departmentCode = $request['id'];


            /*
             * Get the user who is deleting
             * */
            $user = session(Security::$SESSION_USER);

            /*
             * We failed to get the logged in user
             * */
            if($user == null){
                return $this->allDepartments(AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN);
            }

            /*
             * Request data
             * */
            $data = [ 'deleted_by' => $user->username ];


            /*
             * Action
             * */
            $action = endpoint('DEPARTMENTS_DELETE');


            /*
             * Send request to the API
             * */
            $resp = ApiHandler::makeDeleteRequest($action, $departmentCode, $data, true, $token);

            /*
             * Error occurred on sending the request
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->allDepartments($resp->statusDescription);
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


            /*
             * Api returned failed
             * */
            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->allDepartments($resp->$statusDescription);
            }


            /*
             * Operation was successful at the server side
             * */

            $successMessage = "DEPARTMENT [".$departmentCode."] SUCCESSFULLY DELETED";


            /*
             * Return to the form create page with a success message
             * */
            return $this->allDepartments($successMessage);


        }catch (\Exception $exception){

            /*
             * We should log the error message we have got
             * */
            $errorMessage = "Failed To Delete Department With Error. ".$exception->getMessage();
            return $this->allDepartments($errorMessage);

        }


    }


    public function deleteDepartmentUnit(Request $request){

        try{

            /*
             * Get the authentication token
             * */
            $token = Cookie::get(Security::$COOKIE_TOKEN);

            /*
             * Department unit we are updating
             * */
            $unitCode = $request['id'];


            /*
             * Get the user who is deleting
             * */
            $user = session(Security::$SESSION_USER);

            /*
             * We failed to get the logged in user
             * */
            if($user == null){
                return $this->allDepartmentUnits(AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN);
            }


            /*
             * Action
             * */
            $action = endpoint('DEPARTMENT_UNIT_DELETE');


            /*
             * Send request to the API
             * */
            $resp = ApiHandler::makeDeleteRequest($action, $unitCode, [], true, $token);

            /*
             * Error occurred on sending the request
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->allDepartmentUnits($resp->statusDescription);
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


            /*
             * Api returned failed
             * */
            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->allDepartmentUnits($resp->$statusDescription);
            }


            /*
             * Operation was successful at the server side
             * */

            /*
             * Return to the form create page with a success message
             * */
            return redirect(route('department-units.all'));


        }catch (\Exception $exception){

            /*
             * We should log the error message we have got
             * */
            $errorMessage = "Failed To Delete Department With Error. ".$exception->getMessage();
            return $this->allDepartmentUnits($errorMessage);

        }


    }



    public function createRole(CreateRoleRequest $request){

        Role::create($request->all());
        $message = "Role with name ".$request->input('role')." created";
        $active_module = $this->active_module;

        $roles = Role::all();
        return view('roles/roles',compact('active_module','message','roles'));

    }

    public function editRole(Request $request){

        if($request->ajax()){

            $validator = Validator::make($request->all(), [
                'role' => 'required|min:2',
                'role_id' => 'required',
            ]);

            if ($validator->passes()) {
                return $this->updateRole($request);
            }

            return response()->json(['error'=>$validator->errors()->all()]);

        }else{
            return response()->json(['responseText' => 'Error!'.json_encode($request->all())], 403);
        }

    }


    private function updateRole($request) {

        $roleId = $request['role_id'];
        $newRoleName = $request['role'];
        $savedRole = Role::find($roleId);

        if ($savedRole == null) {
            return response()->json(['error' => ['Failed to find role by ID']]);
        }

        /* Verify if there exists a role with the name supplied */
        $role = Role::where('role', '=', $newRoleName)->first();
        if ($role != null) {
            return response()->json(['error' => ['Role name supplied already exists']]);
        }

        $savedRole->role = $newRoleName;
        $savedRole->save();
        return response()->json(['success' => 'Role name successfully updated']);

    }


    private function updateRoleCodeViaApi($request) {


        /*
         * Get the authentication token
         * */
        $token = Cookie::get(Security::$COOKIE_TOKEN);

        /*
         * Role we are updating
         * */
        $roleCode = $request['role_code'];

        /*
         * Request data
         * */
        $data = [

            'role_code' => $roleCode,
            'role_name' => $request['role_name'],
            'active' => true,
            'org_code' => $request['org_code'],
            'created_by' => $request['created_by'],
            'updated_by' => $request['updated_by']

        ];


        /*
         * Action
         * */
        $action = endpoint('ROLE_CODES_UPDATE');


        /*
         * Send request to the API
         * */
        $resp = ApiHandler::makePutRequest($action, $roleCode, $data, true, $token);

        /*
         * Error occurred on sending the request
         * */
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            return response()->json(['error' => [$resp->statusDescription]]);

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


        /*
         * Api returned failed
         * */
        if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            return response()->json(['error' => [$statusDescription]]);

        }


        /*
         * Operation was successful at the server side
         * */

        $successMessage = "ROLE CODE [".$roleCode."] SUCCESSFULLY UPDATED";


        /*
         * Return to the form create page with a success message
         * */
        return response()->json(['success' => $successMessage]);


    }

    private function updateDepartmentViaApi($request) {


        /*
         * Get the authentication token
         * */
        $token = Cookie::get(Security::$COOKIE_TOKEN);

        /*
         * Department we are updating
         * */
        $departmentCode = $request['department_code'];

        /*
         * Request data
         * */
        $data = [

            'department_code' => $departmentCode,
            'name' => $request['name'],
            'org_code' => $request['org_code'],
            'created_by' => $request['created_by'],
            'updated_by' => $request['updated_by'],
            'head_of_department' => $request['hod']
        ];


        /*
         * Action
         * */
        $action = endpoint('DEPARTMENTS_UPDATE');


        /*
         * Send request to the API
         * */
        $resp = ApiHandler::makePutRequest($action, $departmentCode, $data, true, $token);

        /*
         * Error occurred on sending the request
         * */
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            $desc = $resp->statusDescription;
            return response()->json(['error' => [ $desc.json_encode($request)]]);

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


        /*
         * Api returned failed
         * */
        if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            return response()->json(['error' => [$statusDescription. ' HOD '. $request['head_of_department']]]);

        }


        /*
         * Operation was successful at the server side
         * */

        $successMessage = "DEPARTMENT [".$departmentCode."] SUCCESSFULLY UPDATED";


        /*
         * Return to the form create page with a success message
         * */
        return response()->json(['success' => $successMessage]);


    }


    public function updateDepartmentUnitViaApi(Request $request) {

        /*
        * Check if request received is ajax
        * */
        if(!$request->ajax()){
            return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
        }

        /*
         * Get the authentication token
         * */
        $token = Cookie::get(Security::$COOKIE_TOKEN);

        /*
         * Department unit we are updating
         * */
        $unitCode = $request['unit_code'];

        /*
         * Request data
         * */
        $data = [

            'unit_code' => $unitCode,
            'name' => $request['name'],
            'department_code' => $request['department_code']
        ];


        /*
         * Action
         * */
        $action = endpoint('DEPARTMENT_UNIT_UPDATE');


        /*
         * Send request to the API
         * */
        $resp = ApiHandler::makePutRequest($action, $unitCode, $data, true, $token);

        /*
         * Error occurred on sending the request
         * */
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            $desc = $resp->statusDescription;
            return response()->json(['error' => [ $desc.json_encode($request)]]);

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


        /*
         * Api returned failed
         * */
        if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            return response()->json(['error' => [$statusDescription]]);

        }


        /*
         * Operation was successful at the server side
         * */

        $successMessage = "DEPARTMENT UNIT [".$unitCode."] SUCCESSFULLY UPDATED";


        /*
         * Return to the form create page with a success message
         * */
        return response()->json(['success' => $successMessage]);


    }


    private function updateEmployeeCategoryViaApi($request) {


        /*
         * Get the authentication token
         * */
        $token = Cookie::get(Security::$COOKIE_TOKEN);

        /*
         * Employee Category we are updating
         * */
        $categoryCode = $request['category_code'];

        /*
         * Request data
         * */
        $data = [

            'category_code' => $categoryCode,
            'category' => $request['category'],
            'org_code' => $request['org_code'],
            'created_by' => $request['created_by'],
            'updated_by' => $request['updated_by']

        ];


        /*
         * Action
         * */
        $action = endpoint('EMPLOYEE_CATEGORIES_UPDATE');


        /*
         * Send request to the API
         * */
        $resp = ApiHandler::makePutRequest($action, $categoryCode, $data, true, $token);

        /*
         * Error occurred on sending the request
         * */
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            return response()->json(['error' => [$resp->statusDescription]]);

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


        /*
         * Api returned failed
         * */
        if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            return response()->json(['error' => [$statusDescription]]);

        }


        /*
         * Operation was successful at the server side
         * */

        $successMessage = "EMPLOYEE CATEGORY [".$categoryCode."] SUCCESSFULLY UPDATED";


        /*
         * Return to the form create page with a success message
         * */
        return response()->json(['success' => $successMessage]);


    }

    private function updateRegionalOfficeViaApi($request) {


        /*
         * Get the authentication token
         * */
        $token = Cookie::get(Security::$COOKIE_TOKEN);

        /*
         * Regional Office we are updating
         * */
        $regionalOfficeCode = $request['regional_office_code'];

        /*
         * Request data
         * */
        $data = [

            'regional_office_code' => $regionalOfficeCode,
            'name' => $request['name'],
            'org_code' => $request['org_code'],
            'email' => $request['email'],
            'location' => $request['location'],
            'contact_person_name' => $request['contact_person_name'],
            'contact_person_contact' => $request['contact_person_contact'],
            'description' => $request['description'],
            'created_by' => $request['created_by'],
            'updated_by' => $request['updated_by']

        ];


        /*
         * Action
         * */
        $action = endpoint('REGIONAL_OFFICES_UPDATE');


        /*
         * Send request to the API
         * */
        $resp = ApiHandler::makePutRequest($action, $regionalOfficeCode, $data, true, $token);

        /*
         * Error occurred on sending the request
         * */
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            return response()->json(['error' => [$resp->statusDescription]]);

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


        /*
         * Api returned failed
         * */
        if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            return response()->json(['error' => [$statusDescription]]);

        }


        /*
         * Operation was successful at the server side
         * */

        $successMessage = "REGIONAL OFFICE [".$regionalOfficeCode."] SUCCESSFULLY UPDATED";


        /*
         * Return to the form create page with a success message
         * */
        return response()->json(['success' => $successMessage]);


    }

    private function updateOrganizationViaApi($request) {


        /*
         * Get the authentication token
         * */
        $token = Cookie::get(Security::$COOKIE_TOKEN);

        /*
         * Organization we are updating
         * */
        $orgCode = $request['org_code'];

        /*
         * Request data
         * */
        $data = [

            'org_code' => $orgCode,
            'name' => $request['name'],
            'email' => $request['email'],
            'location' => $request['location'],
            'contact_person_name' => $request['contact_person_name'],
            'contact_person_contact' => $request['contact_person_contact'],
            'description' => $request['description'],
            'created_by' => $request['created_by'],
            'updated_by' => $request['updated_by'],
            'executive_director' => $request['executive_director'],

        ];


        /*
         * Action
         * */
        $action = endpoint('ORGANIZATIONS_UPDATE');


        /*
         * Send request to the API
         * */
        $resp = ApiHandler::makePutRequest($action, $orgCode, $data, true, $token);

        /*
         * Error occurred on sending the request
         * */
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            return response()->json(['error' => [$resp->statusDescription]]);

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


        /*
         * Api returned failed
         * */
        if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            return response()->json(['error' => [$statusDescription]]);

        }


        /*
         * Operation was successful at the server side
         * */

        $successMessage = "ORGANIZATION [".$orgCode."] SUCCESSFULLY UPDATED";


        /*
         * Return to the form create page with a success message
         * */
        return response()->json(['success' => $successMessage]);


    }

    public function allCompetenceCategories($deleteMessage = null){

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $resp = DataLoader::getAdminCompetenceCategories($token);
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->redirectBackToFormWithError($resp->statusDescription);
            }
            $categories = $resp->result;

            $resp1 = DataLoader::getOrganizations();
            $resp2 = DataLoader::getEmployeeCategories();

            $organizations = $resp1->statusCode != AppConstants::$STATUS_CODE_SUCCESS ? [] : $resp1->result;
            $employeeCategories = $resp2->statusCode != AppConstants::$STATUS_CODE_SUCCESS ? [] : $resp2->result;

            $user = session(Security::$SESSION_USER);

            return view('competences.competences-cat-list',compact('categories','user','organizations','employeeCategories','deleteMessage'));

        }catch (\Exception $exception){

            return $this->redirectBackToFormWithError(AppConstants::generalError($exception->getMessage()));

        }

    }


    public function getCompetenceCategoryCompetences($id, $deletionMessage = null){

        try{

            $resp = DataLoader::getAdminCompetencesForACompetenceCategory($id);
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $resp->statusDescription;
            }
            $competences = $resp->result;

            $user = session(Security::$SESSION_USER);
            $competenceCategoryId = $id;

            return view('competences.competences-list',compact('competences','user','competenceCategoryId','deletionMessage'));

        }catch (\Exception $exception){

            return AppConstants::generalError($exception->getMessage());

        }

    }

    public function saveCompetenceCategoryAjax(Request $request){

        try{

            //check if request us ajax
            if(!$request->ajax()){
                return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
            }

            //validate request
            $validator = Validator::make($request->all(), [
                'org_code' => 'required|min:2',
                'employee_category_code' => 'required|min:2',
                'competence_category' => 'required|min:2',
                'max_rating' => 'required|numeric',
                'created_by' => 'required|min:2',
            ]);

            //failed validation
            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            //send request to API
            $data =
                [
                    'org_code' => $request['org_code'],
                    'employee_category_code' => $request['employee_category_code'],
                    'competence_category' => $request['competence_category'],
                    'max_rating' => $request['max_rating'],
                    'created_by' => $request['created_by'],
                ];

            $resp = DataLoader::saveAdminCompetenceCategory($data);

            // Error occurred on sending the request
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return response()->json(['error' => [$resp->statusDescription]]);
            }

            $successMessage = "RECORD SUCCESSFULLY SAVED";
            return response()->json(['success' => $successMessage]);

        }catch (\Exception $exception){
            return response()->json(['error' => [AppConstants::generalError($exception->getMessage())]]);
        }

    }


    public function updateCompetenceCategoryAjax(Request $request){

        try{

            //check if request us ajax
            if(!$request->ajax()){
                return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
            }

            //validate request
            $validator = Validator::make($request->all(), [
                'org_code' => 'required|min:2',
                'employee_category_code' => 'required|min:2',
                'competence_category' => 'required|min:2',
                'max_rating' => 'required|numeric',
                'record_id' => 'required|numeric',
            ]);

            //failed validation
            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            //send request to API
            $data =
                [
                    'org_code' => $request['org_code'],
                    'employee_category_code' => $request['employee_category_code'],
                    'competence_category' => $request['competence_category'],
                    'max_rating' => $request['max_rating'],
                ];

            $identifier = $request['record_id'];
            $resp = DataLoader::saveAdminCompetenceCategory($data,true,$identifier);

            // Error occurred on sending the request
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return response()->json(['error' => [$resp->statusDescription]]);
            }

            $successMessage = "RECORD SUCCESSFULLY UPDATED";
            return response()->json(['success' => $successMessage]);

        }catch (\Exception $exception){
            return response()->json(['error' => [AppConstants::generalError($exception->getMessage())]]);
        }

    }


    public function updateAppraisalApproversAjax(Request $request){

        try{

            //check if request us ajax
            if(!$request->ajax()){
                return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
            }

            //validate request
            $validator = Validator::make($request->all(), [
                'appraisal_ref' => 'required|min:2',
                'ed' => 'required|min:2',
                'hod' => 'required|min:2',
                'supervisor' => 'required||min:2',
            ]);

            //failed validation
            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            //send request to API
            $data =
                [
                    'appraisal_ref' => $request['appraisal_ref'],
                    'executive_director_id' => $request['ed'],
                    'department_head_id' => $request['hod'],
                    'supervisor_id' => $request['supervisor'],
                ];

            $resp = DataLoader::updateAppraisalApprovers($data);

            // Error occurred on sending the request
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return response()->json(['error' => [$resp->statusDescription]]);
            }

            $successMessage = "APPROVERS SUCCESSFULLY UPDATED";
            return response()->json(['success' => $successMessage]);

        }catch (\Exception $exception){
            return response()->json(['error' => [AppConstants::generalError($exception->getMessage())]]);
        }

    }


    public function saveCompetenceAjax(Request $request){

        try{

            //check if request us ajax
            if(!$request->ajax()){
                return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
            }

            //validate request
            $validator = Validator::make($request->all(), [
                'competence' => 'required|min:2',
                'rank' => 'required|numeric',
                'rating' => 'required|numeric',
                'competence_category_id' => 'required|numeric',
            ]);

            //failed validation
            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            //send request to API
            $data =
                [
                    'competence' => $request['competence'],
                    'rank' => $request['rank'],
                    'rating' => $request['rating'],
                    'appraisal_competence_category_id' => $request['competence_category_id'],
                ];

            $resp = DataLoader::saveAdminCompetence($data);

            // Error occurred on sending the request
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return response()->json(['error' => [$resp->statusDescription]]);
            }

            $successMessage = "RECORD SUCCESSFULLY SAVED";
            return response()->json(['success' => $successMessage]);

        }catch (\Exception $exception){
            return response()->json(['error' => [AppConstants::generalError($exception->getMessage())]]);
        }

    }


    public function updateCompetenceAjax(Request $request){

        try{

            //check if request us ajax
            if(!$request->ajax()){
                return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
            }

            //validate request
            $validator = Validator::make($request->all(), [
                'competence' => 'required|min:2',
                'rank' => 'required|numeric',
                'rating' => 'required|numeric',
                'competence_category_id' => 'required|numeric',
                'record_id' => 'required|numeric',
            ]);

            //failed validation
            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            //send request to API
            $data =
                [
                    'competence' => $request['competence'],
                    'rank' => $request['rank'],
                    'rating' => $request['rating'],
                    'appraisal_competence_category_id' => $request['competence_category_id'],
                ];

            $identifier = $request['record_id'];
            $resp = DataLoader::saveAdminCompetence($data,true,$identifier);

            // Error occurred on sending the request
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return response()->json(['error' => [$resp->statusDescription]]);
            }

            $successMessage = "RECORD SUCCESSFULLY UPDATED";
            return response()->json(['success' => $successMessage]);

        }catch (\Exception $exception){
            return response()->json(['error' => [AppConstants::generalError($exception->getMessage())]]);
        }

    }


    /**
     * @param $error
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectBackToFormWithError($error) {

        return redirect()->back()->withErrors(SharedCommons::customFormError($error))->withInput();

    }


    public function getAdminIncompleteAppraisals($statusFilter = null){

        try{

            $req = new ApiAppraisalReq();
            $req->token = Cookie::get(Security::$COOKIE_TOKEN);
            $req->workflowRole = AppConstants::WORK_FLOW_ROLE_ALL;
            $req->status = 'incomplete';
            $req->additionStatusFilter = $statusFilter;

            $resp = DataLoader::getUserAppraisals($req);

            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->redirectBackToFormWithError($resp->statusDescription);
            }

            $appraisals = $resp->result;
            $user = session(Security::$SESSION_USER);

            $resp1 = DataLoader::allUsers();
            $users = $resp1->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $resp1->result : [];

            return view('admin.appraisals.admin-appraisals-incomplete',compact('appraisals','user','users','statusFilter'));

        }catch (\Exception $exception){

            return $this->redirectBackToFormWithError($exception->getMessage());

        }

    }


    public function getAdminCompletedAppraisals(){

        try{

            $req = new ApiAppraisalReq();
            $req->token = Cookie::get(Security::$COOKIE_TOKEN);
            $req->workflowRole = AppConstants::WORK_FLOW_ROLE_ALL;
            $req->status = 'complete';

            $resp = DataLoader::getUserAppraisals($req);

            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $resp->statusDescription;
            }

            $appraisals = $resp->result;
            $user = session(Security::$SESSION_USER);

            return view('admin.appraisals.admin-appraisals-completed',compact('appraisals','user'));

        }catch (\Exception $exception){

            return AppConstants::generalError($exception->getMessage());

        }

    }



    public function allStrategicObjectives($deletionMessage = null){

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);
            $resp = DataLoader::getStrategicObjectives($token);

            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $resp->statusDescription;
            }
            $objectives = $resp->result;

            $resp1 = DataLoader::getOrganizations();
            $organizations = $resp1->statusCode != AppConstants::$STATUS_CODE_SUCCESS ? [] : $resp1->result;

            $user = session(Security::$SESSION_USER);

            return view('objectives.objectives-list',compact('objectives','user','organizations','deletionMessage'));

        }catch (\Exception $exception){

            return AppConstants::generalError($exception->getMessage());

        }

    }


    public function saveStrategicObjectiveAjax(Request $request){

            try{

                //check if request us ajax
                if(!$request->ajax()){
                    return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
                }

                //validate request
                $validator = Validator::make($request->all(), [
                    'organization' => 'required|min:2',
                    'objective' => 'required|min:2'
                ]);

                //failed validation
                if (!$validator->passes()) {
                    return response()->json(['error'=>$validator->errors()->all()]);
                }

                $user = session(Security::$SESSION_USER);
                if($user == null){
                    return response()->json(['error'=>[AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN]]);
                }

                //send request to API
                $data =
                    [
                        'org_code' => $request['organization'],
                        'objective' => $request['objective'],
                        'created_by' => $user->username,
                    ];

                $resp = DataLoader::saveStrategicObjective($data);

                // Error occurred on sending the request
                if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                    return response()->json(['error' => [$resp->statusDescription]]);
                }

                $successMessage = "RECORD SUCCESSFULLY SAVED";
                return response()->json(['success' => $successMessage]);

            }catch (\Exception $exception){
                return response()->json(['error' => [AppConstants::generalError($exception->getMessage())]]);
            }

    }



    public function updateStrategicObjectiveAjax(Request $request){

        try{

            //check if request us ajax
            if(!$request->ajax()){
                return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
            }

            //validate request
            $validator = Validator::make($request->all(), [
                'organization' => 'required|min:2',
                'objective' => 'required|min:2',
                'record_id' => 'required|numeric',
            ]);

            //failed validation
            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            //send request to API
            $data =
                [
                    'org_code' => $request['organization'],
                    'objective' => $request['objective'],
                ];

            $identifier = $request['record_id'];
            $resp = DataLoader::saveStrategicObjective($data,true,$identifier);

            // Error occurred on sending the request
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return response()->json(['error' => [$resp->statusDescription]]);
            }

            $successMessage = "RECORD SUCCESSFULLY UPDATED";
            return response()->json(['success' => $successMessage]);

        }catch (\Exception $exception){
            return response()->json(['error' => [AppConstants::generalError($exception->getMessage())]]);
        }

    }

    public function deleteStrategicObjective(Request $request){

        try{

            $identifier = $request['id'];

            /*
             * Send request to the API
             * */
            $resp = DataLoader::deleteStrategicObjective([],$identifier);

            /*
             * Error occurred on sending the request
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->allStrategicObjectives($resp->statusDescription);
            }

            /*
             * Return to the form create page with a success message
             * */
            $successMessage = "STRATEGIC OBJECTIVE SUCCESSFULLY DELETED";
            return $this->allStrategicObjectives($successMessage);


        }catch (\Exception $exception){

            /*
             * We should log the error message we have got
             * */
            $errorMessage = "Failed To Delete Strategic Objective With Error. ".AppConstants::generalError($exception->getMessage());
            return $this->allStrategicObjectives($errorMessage);

        }


    }


    public function deleteCompetenceCategory(Request $request){

        try{

            $identifier = $request['id'];

            /*
             * Send request to the API
             * */
            $resp = DataLoader::deleteCompetenceCategory([],$identifier);

            /*
             * Error occurred on sending the request
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->redirectBackToFormWithError($resp->statusDescription);
            }

            /*
             * Return to the form create page with a success message
             * */
            $successMessage = "COMPETENCE CATEGORY SUCCESSFULLY DELETED";
            return $this->allCompetenceCategories($successMessage);


        }catch (\Exception $exception){

            /*
             * We should log the error message we have got
             * */
            $errorMessage = "Failed To Delete Competence Category With Error. ".AppConstants::generalError($exception->getMessage());
            return $this->redirectBackToFormWithError($errorMessage);

        }


    }


    public function deleteCompetence(Request $request){

        try{

            $identifier = $request['id'];
            $categoryId = $request['categoryId'];

            /*
             * Send request to the API
             * */
            $resp = DataLoader::deleteCompetenceByAdmin([],$identifier);

            /*
             * Error occurred on sending the request
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->getCompetenceCategoryCompetences($categoryId,$resp->statusDescription);
            }

            /*
             * Return to the form create page with a success message
             * */
            $successMessage = "COMPETENCE SUCCESSFULLY DELETED";
            return $this->getCompetenceCategoryCompetences($categoryId,$successMessage);


        }catch (\Exception $exception){

            /*
             * We should log the error message we have got
             * */
            $errorMessage = "Failed To Delete Competence With Error. ".AppConstants::generalError($exception->getMessage());
            return $this->getCompetenceCategoryCompetences($categoryId,$errorMessage);

        }

    }

    public function allDesignations(){

        $token = Cookie::get(Security::$COOKIE_TOKEN);

        $resp = DataLoader::getDesignations();
        $statusCode = $resp->statusCode;
        $statusDescription = $resp->statusDescription;

        if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return $this->redirectBackWithSessionError($statusDescription);
        }

        $designations = $resp->result;

        /*
         * Holds the active module
         * */
        $active_module = $this->active_module;


        /*
         * Get logged in user
         * */
        $author = session(Security::$SESSION_USER);

        if($author == null){
            return $this->redirectBackWithSessionError(AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN);
        }

        /*
         * Return the view with the regional offices
         * */
        return view('designations/designation-list',compact('active_module','author','designations'));

    }

    public function saveDesignation(Request $request){

        try{


            if(!$request->ajax()){
                return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
            }

            $validator = Validator::make($request->all(), [
                'title'=>'required|min:2'
            ]);

            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            $data = [
                'title' => $request['title'],
            ];

            $resp = DataLoader::saveDesignation($data);
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return response()->json(['error'=>[$resp->statusDescription]]);
            }

            $successMessage = "DESIGNATION [".$request['title']."] SUCCESSFULLY CREATED";
            return response()->json(['success' => $successMessage]);


        }catch (\Exception $exception){
            return response()->json(['error'=>[AppConstants::generalError($exception->getMessage())]]);
        }

    }

    public function updateDesignation(Request $request){

        try{

            //check if request us ajax
            if(!$request->ajax()){
                return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
            }

            //validate request
            $validator = Validator::make($request->all(), [
                'title' => 'required|min:2',
                'designation_id' => 'required|numeric',
            ]);

            //failed validation
            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            //send request to API
            $data =
                [
                    'title' => $request['title'],
                    'id' => $request['designation_id'],
                ];

            $identifier = $request['designation_id'];
            $resp = DataLoader::saveDesignation($data,true,$identifier);

            // Error occurred on sending the request
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return response()->json(['error' => [$resp->statusDescription]]);
            }

            $successMessage = "RECORD SUCCESSFULLY UPDATED";
            return response()->json(['success' => $successMessage]);

        }catch (\Exception $exception){
            return response()->json(['error' => [AppConstants::generalError($exception->getMessage())]]);
        }

    }

    public function deleteDesignation(Request $request){

        try{

            $designationId = $request['id'];

            $user = session(Security::$SESSION_USER);
            if($user == null){
                return $this->redirectBackWithSessionError(AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN);
            }

            $resp = DataLoader::deleteDesignation([], $designationId);
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->redirectBackWithSessionError($resp->statusDescription);
            }

            $successMessage = "DESIGNATION SUCCESSFULLY DELETED";
            return $this->redirectBackWithSessionSuccess($successMessage);


        }catch (\Exception $exception){
            $errorMessage = "Failed To Delete Designation With Error. ".$exception->getMessage();
            return $this->redirectBackWithSessionError($errorMessage);
        }


    }

    public function redirectBackWithSessionError($error, $routeName = null){

        \session()->flash('errorMsg', $error);
        if($routeName == null){
            return redirect()->back();
        }
        return \redirect(route($routeName));
    }

    public function redirectBackWithSessionSuccess($msg, $routeName = null){

        \session()->flash('successMsg', $msg);
        if($routeName == null){
            return redirect()->back();
        }
        return \redirect(route($routeName));
    }

}
