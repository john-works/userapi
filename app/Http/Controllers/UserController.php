<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Access;
use App\ApiResp;
use App\Appraisal;
use Carbon\Carbon;
use App\Department;
use App\PortalUser;
use App\UserAccess;
use GuzzleHttp\Client;
use App\Models\ApiUser;
use App\SessionHistory;
use App\Helpers\Security;
use App\Helpers\EndPoints;
use App\Helpers\ApiHandler;
use App\Helpers\DataLoader;
use Illuminate\Http\Request;
use App\Helpers\AppConstants;
use Illuminate\Http\Response;
use App\Helpers\DataFormatter;
use App\Helpers\SharedCommons;
use App\Models\ApiApplicationStat;
use App\Helpers\AjaxResponseHandler;
use App\Http\Requests\SignInRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\PasswordChangeRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\UserProfileUpdateRequest;
use App\Repositories\Contracts\UserRepoInterface;
use App\Repositories\General\ApplicationStatsRepo;

use App\Http\Requests\ChangeDefaultPasswordRequest;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends Controller {

    /**
     * @var UserRepoInterface
     */
    private $userRepo;
    private $active_module;

    /*
     * added this comment before I moved to the login page and app-selection to bootstrap
     * */
    function __construct(UserRepoInterface $userRepo) {
        $this->userRepo = $userRepo;
        $this->active_module = AppConstants::$ACTIVE_MOD_USERS;
    }
    public function indexV1(Request $request){


        /**
         * check if the user is required to do an explicit login
         */

        if(session(SESSION_KEY_REQUIRE_LOGIN, false) == true){

            /**
             * clear all session for the user
             */
//            $request->session()->flush(); //comment out because it was already cleared on logout and clear it again here invalidates the request form

            /**
             * show the login page
             */
            return $this->normalLoginPage();

        }


        /**
         * user is not required to do an explicit login so we will attempt to auto - login the user
         */
        return $this->attemptAutoLogin($request);


    }

    public function index(Request $request, $redirectToApp = null, $redirectSpecificPage = null){

        /**
         * store redirect to
         */
        $this->saveReferralIfExists($redirectToApp, $redirectSpecificPage);

        //VIVA - 30/09/2024
        //THE CODE BELOW WORKS FINE BUT HAS BEEN BYPASSED TO DISABLE AUTO LOGIN

        return $this->normalLoginPage();



        /**
         * Check if the user is required to do an explicit login
         */

        if(session(SESSION_KEY_REQUIRE_LOGIN, false) == true)
        {

            /**
             * User forced logout so we must prompt them to login again
             *
             * - Clear user object from user management session - ???? (user mgt  ....) | clear user:key
             * - Proceed to login page as normal (skip autologin)
             * - After successful re-login set forced logout to false??
             */

            /**
             * Clear user object from session
             */
            $request->session()->forget(Security::$SESSION_USER);

            /**
             * show the login page. After successful login set require login to false
             */
            return $this->normalLoginPage();

        }
        else
        {

            /**
             * Not a forced logout
             */

            $trustedDevicesController = new TrustedDevicesController();

            /**
             * Validate the trusted device cookie if exists
             */
            $respValidateCookie = $trustedDevicesController->validateAndCleanUpTrustedDeviceCookie(COOKIE_TRUSTED_DEVICE);

            if($respValidateCookie->statusCode == AppConstants::$STATUS_CODE_SUCCESS && $respValidateCookie->result->status == TRUSTED_DEVICE_STATUS_APPROVED){

                /**
                 * Cookie valid and the Trusted device was approved
                 * Attempt auto-login the user
                 */

                $trustedDevice = $respValidateCookie->result;
                return $this->autoLogin($request, $trustedDevice);

            }
             else
             {

                 /**
                  * Cookie is invalid
                  *
                  * - Proceed to login page as normal (skip autologin)
                  * - After normal login: if(not a redirect/referal)send to normal app selection page + if a redirect send to wateva url
                  */
                 return $this->normalLoginPage();

             }

        }

    }

    private function autoLogin(Request $request, $existentTrustedDevice){

        /*
        - Check if there's a user-management-session (user session in user management app)
        - If it's not there: Create a new session for the user with an expiry that points to a static variable : Trusted_Devices_Session_Duration (In Production 7 days)
         after autologin: if(not a redirect/referal)send to normal app selection page + if a redirect send to wateva url
        - if its there and expired invalidate the old session and send to normal login page with a flag that
         this a trusted device to ensure we set the new session with Trusted_Devices_Session_Duration.
         after normal login: if(not a redirect/referal)send to normal app selection page + if a redirect send to wateva url
        - If it has not expired,
         after autologin: if(not a redirect/referal)send to normal app selection page + if a redirect send to wateva url
        */


        /**
         * Get session user
         */
        $user = session(Security::$SESSION_USER);

        if(isset($user)){

            /**
             * User session is still valid/has not expired, we just take the user to the defaultPage (either app-selection-page or referral URL)
             */
            return $this->loadDefaultPage($user->token);

        }
        else{

            /**
             * The user session expired.
             * So we have to auto-log them in with the session time for trusted device user
            /**
             * Make API call to auto-authenticate the user based on the device ID
             */
            $deviceId = $existentTrustedDevice->id;
            $encryptedDeviceId = encrypt($deviceId);

            $data = ['device_id'=>$encryptedDeviceId];
            $result = ApiHandler::makePostRequest("/user/trusted-device-auto-login",$data);

            if($result->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                /**
                 * Login failed. Go to Login with error !!!!!!@@@$$$
                 */
                return redirect(route('singout_admin'));
               // session([SESSION_KEY_REQUIRE_LOGIN => true]);
               // return $this->normalLoginPage(null,$result->statusDescription);
            }

            $apiResult = json_decode($result->result);
            if($apiResult->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                /**
                 * Login failed. Go to login with error
                 */
                return redirect(route('singout_admin'));
                //session([SESSION_KEY_REQUIRE_LOGIN => true]);
                //return $this->normalLoginPage(null,$apiResult->statusDescription);

            }

            /**
             * Login was successful and we got a user object back.
             * Format user object
             */
            $user = DataFormatter::getApiUser(json_decode(json_encode($apiResult->data),true));
            $user->token = $apiResult->token;

            /**
             * Save the user in session
             */
            $this->setUserAuthenticationSession($user);

            /**
             * We now proceed to the app selection page or the referral url
             */
            return $this->loadDefaultPage($apiResult->token);
        }


    }


    /*
    * Logic for Users : Start
    * */
    public function getCreationUserForm($message = null, $isError = false){

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

        /*
         * Get all the data required to prefill the user form
         * I think you can decide to fetch all this data in one trip
         * */
        $respOrganizations = ApiHandler::makeGetRequest(endpoint('ORGANIZATIONS_ALL'), true, $token);
        $respRegOffices = ApiHandler::makeGetRequest(endpoint('REGIONAL_OFFICES_ALL'), true, $token);
        $respDepts = ApiHandler::makeGetRequest(endpoint('DEPARTMENTS_ALL'), true, $token);
        $respCategories = ApiHandler::makeGetRequest(endpoint('EMPLOYEE_CATEGORIES_ALL'), true, $token);
        $respRoleCodes = ApiHandler::makeGetRequest(endpoint('ROLE_CODES_ALL'), true, $token);


        /*
         * Failed to get a response from the server
         * */

        if($respOrganizations->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return $respOrganizations->statusDescription;
        }
        if($respRegOffices->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return $respRegOffices->statusDescription;
        }
        if($respDepts->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return $respDepts->statusDescription;
        }
        if($respCategories->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return $respCategories->statusDescription;
        }
        if($respRoleCodes->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return $respRoleCodes->statusDescription;
        }

        /*
         * End of check to see if we got data from the server
         * Past this we received data from the requests made above
         * */



        /*
         * Get the different status and status description from the different responses
         * */

        $apiRespOrg = json_decode($respOrganizations->result, true);
        $statusCodeOrg = $apiRespOrg['statusCode'];
        $statusDescriptionOrg = $apiRespOrg['statusDescription'];

        $apiRespCategories = json_decode($respCategories->result, true);
        $statusCodeCategories = $apiRespCategories['statusCode'];
        $statusDescriptionCategories = $apiRespCategories['statusDescription'];

        $apiRespDepts = json_decode($respDepts->result, true);
        $statusCodeDept = $apiRespDepts['statusCode'];
        $statusDescriptionDept = $apiRespDepts['statusDescription'];

        $apiRespRegOffices = json_decode($respRegOffices->result, true);
        $statusCodeRegOffices = $apiRespRegOffices['statusCode'];
        $statusDescriptionRegOffices = $apiRespRegOffices['statusDescription'];

        $apiRespRoleCodes = json_decode($respRoleCodes->result, true);
        $statusCodeRoleCodes = $apiRespRoleCodes['statusCode'];
        $statusDescriptionRoleCodes = $apiRespRoleCodes['statusDescription'];

        /*
         * End getting the different statuses
         * */


        /*
         * Check if we got success for all the requests from the server
         * */
        if($statusCodeOrg != AppConstants::$STATUS_CODE_SUCCESS){
            return $statusDescriptionOrg;
        }
        if($statusCodeDept != AppConstants::$STATUS_CODE_SUCCESS){
            return $statusDescriptionDept;
        }
        if($statusCodeRegOffices != AppConstants::$STATUS_CODE_SUCCESS){
            return $statusDescriptionRegOffices;
        }
        if($statusCodeCategories != AppConstants::$STATUS_CODE_SUCCESS){
            return $statusDescriptionCategories;
        }
        if($statusCodeRoleCodes != AppConstants::$STATUS_CODE_SUCCESS){
            return $statusDescriptionRoleCodes;
        }
        /*
         * By the end these checks, we got success from the server for all our request
         * We can proceed to format the data
         * */


        /*
         * We format the data returned
         * */
        $organizations = DataFormatter::formatOrganizations($apiRespOrg['data']);
        $regionalOffices = DataFormatter::formatRegionalOffices($apiRespRegOffices['data']);
        $departments = DataFormatter::formatDepartments($apiRespDepts['data']);
        $categories = DataFormatter::formatEmployeeCategories($apiRespCategories['data']);
        $roles = DataFormatter::formatRoleCodes($apiRespRoleCodes['data']);


        /*
         * I echo below line to see if I reach here after the long journey
         * */
        //return "SUCCESS FOR SURE WE GOOD HERE";


        /*
         * Here a dealing with a new request to this page, we a just returning a fresh page
         * */
        if($message == null){

            return view('user/user-form',
                compact('active_module','user','organizations','regionalOffices','departments','categories','roles'));

        }


        /*
         * Here it's like have been doing some stuff on the page
         * */


        /*
         * We were creating a user and got an error
         * */
        if($isError){

            return back()
                ->withInput()
                ->withErrors([$message]);

        }else{

            $successMessage = $message;
            return view('user/user-form',
                compact('active_module','successMessage','user','organizations','regionalOffices','departments','categories','roles'));

        }

    }


    public function allUsers($deletionMessage = null){

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
        $resp = ApiHandler::makeGetRequest(endpoint('USERS_ALL'), true, $token);

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
        $users = DataFormatter::formatUsers($data);


        /*
         * ------------------------------------
         * START : COMPLEX LOGIC OF GETTING
         * ORGS, DEPTS, ROLES, REGIONS, CATEGORIES
         * ------------------------------------
         * */


        /*
         * Get all the data required to prefill the user form
         * I think you can decide to fetch all this data in one trip
         * */
        $respOrganizations = ApiHandler::makeGetRequest(endpoint('ORGANIZATIONS_ALL'), true, $token);
        $respRegOffices = ApiHandler::makeGetRequest(endpoint('REGIONAL_OFFICES_ALL'), true, $token);
        $respDepts = ApiHandler::makeGetRequest(endpoint('DEPARTMENTS_ALL'), true, $token);
        $respCategories = ApiHandler::makeGetRequest(endpoint('EMPLOYEE_CATEGORIES_ALL'), true, $token);
        $respRoleCodes = ApiHandler::makeGetRequest(endpoint('ROLE_CODES_ALL'), true, $token);


        /*
         * Failed to get a response from the server
         * */

        if($respOrganizations->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return $respOrganizations->statusDescription;
        }
        if($respRegOffices->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return $respRegOffices->statusDescription;
        }
        if($respDepts->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return $respDepts->statusDescription;
        }
        if($respCategories->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return $respCategories->statusDescription;
        }
        if($respRoleCodes->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return $respRoleCodes->statusDescription;
        }

        $resp = DataLoader::getDesignations();
        $statusCode = $resp->statusCode;
        $designations = $statusCode != AppConstants::$STATUS_CODE_SUCCESS ? [] : $resp->result;

        /*
         * End of check to see if we got data from the server
         * Past this we received data from the requests made above
         * */



        /*
         * Get the different status and status description from the different responses
         * */

        $apiRespOrg = json_decode($respOrganizations->result, true);
        $statusCodeOrg = $apiRespOrg['statusCode'];
        $statusDescriptionOrg = $apiRespOrg['statusDescription'];

        $apiRespCategories = json_decode($respCategories->result, true);
        $statusCodeCategories = $apiRespCategories['statusCode'];
        $statusDescriptionCategories = $apiRespCategories['statusDescription'];

        $apiRespDepts = json_decode($respDepts->result, true);
        $statusCodeDept = $apiRespDepts['statusCode'];
        $statusDescriptionDept = $apiRespDepts['statusDescription'];

        $apiRespRegOffices = json_decode($respRegOffices->result, true);
        $statusCodeRegOffices = $apiRespRegOffices['statusCode'];
        $statusDescriptionRegOffices = $apiRespRegOffices['statusDescription'];

        $apiRespRoleCodes = json_decode($respRoleCodes->result, true);
        $statusCodeRoleCodes = $apiRespRoleCodes['statusCode'];
        $statusDescriptionRoleCodes = $apiRespRoleCodes['statusDescription'];

        /*
         * End getting the different statuses
         * */


        /*
         * Check if we got success for all the requests from the server
         * */
        if($statusCodeOrg != AppConstants::$STATUS_CODE_SUCCESS){
            return $statusDescriptionOrg;
        }
        if($statusCodeDept != AppConstants::$STATUS_CODE_SUCCESS){
            return $statusDescriptionDept;
        }
        if($statusCodeRegOffices != AppConstants::$STATUS_CODE_SUCCESS){
            return $statusDescriptionRegOffices;
        }
        if($statusCodeCategories != AppConstants::$STATUS_CODE_SUCCESS){
            return $statusDescriptionCategories;
        }
        if($statusCodeRoleCodes != AppConstants::$STATUS_CODE_SUCCESS){
            return $statusDescriptionRoleCodes;
        }
        /*
         * By the end these checks, we got success from the server for all our request
         * We can proceed to format the data
         * */


        /*
         * We format the data returned
         * */
        $organizations = DataFormatter::formatOrganizations($apiRespOrg['data']);
        $regionalOffices = DataFormatter::formatRegionalOffices($apiRespRegOffices['data']);
        $departments = DataFormatter::formatDepartments($apiRespDepts['data']);
        $categories = DataFormatter::formatEmployeeCategories($apiRespCategories['data']);
        $roles = DataFormatter::formatRoleCodes($apiRespRoleCodes['data']);


        /*
         * I echo below line to see if I reach here after the long journey
         * */
        //return "SUCCESS FOR SURE WE GOOD HERE";


        /*
         * ----------------------------------
         * END : COMPLEX LOGIC
         * ---------------------------------
         * */


        /*
         * Holds the active module
         * */
        $active_module = $this->active_module;


        /*
         * Get logged in user
         * */
        $author = session(Security::$SESSION_USER);


        /*
         * We are unable to get the logged in user due to a session timeout
         * */
        if($author == null){
            return "Failed to get logged in user. Please login again and try again";
        }

        $apiRespUnits = DataLoader::getDepartmentUnits();
        $units = $apiRespUnits->statusCode == AppConstants::$STATUS_CODE_SUCCESS ? $apiRespUnits->result : [];

        /*
         * Return the view with the role codes
         * */
        return view('user/user-list',compact(
            'active_module','author','users','organizations','regionalOffices','departments','categories','units','roles','designations','deletionMessage'));

    }


    public function updateUser(Request $request){


        try{


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
             * Valid JSON received, validate the request
             * */
            $validator = Validator::make($request->all(), [

                'first_name' => 'required|min:2',
                'last_name' => 'required|min:2',
                'email' => 'required|email',
                'org_code' => 'required|min:2',
                'regional_office_code' => 'required',
                'department_code' => 'required',
                'role_code' => 'required',
                'department_unit' => 'required',
                'staff_number'=>'required|min:2',
                'date_of_birth'=>'required|date',
                'designation_id'=>'required',

            ]);


            /*
             * If validation failed
             * */
            if (!$validator->passes()) {

                return response()->json(['error'=>$validator->errors()->all()]);

            }

            /*
             * Successful validation
             * */
            return $this->updateUserViaApi($request);


        }catch (\Exception $exception){

            /*
             * Log error here
             * */
            return response()->json(['error' => [AppConstants::$GENERAL_ERROR_AT_TDS.' '.$exception->getMessage()]], 500);

        }

    }


    public function getResetPasswordForm($msg = null, $isError = false){

        return view('bt.users.password_reset');

    }

    public function resetPassword(PasswordResetRequest $request){

        try{

            $validator = Validator::make($request->all(), ((new PasswordResetRequest())->rules()));
            if ($validator->fails()) {
                $firstValidationError = getFirstValidationError($validator,  [ 'username']);
                return json_encode( ApiResp::failure($firstValidationError));
            }

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            /*
             * Request data
             * */
            $data = [  'username' => $request['username'] ];

            /*
             * Send request to the API
             * */
            $resp = ApiHandler::makePostRequest(endpoint('USERS_RESET_PASSWORD'), $data, true, $token);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return json_encode(ApiResp::failure($resp->statusDescription));
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
                return json_encode(ApiResp::failure($statusDescription));
            }


            /*
             * Operation was successful at the server side
             * */
            $successMessage = "PASSWORD SUCCESSFULLY RESET, CHECK EMAIL FOR NEW CREDENTIALS";
            return json_encode(ApiResp::success($successMessage,$successMessage));


        }catch (\Exception $exception){

            return $this->getResetPasswordForm(AppConstants::$GENERAL_ERROR_AT_TDS. ' ' .$exception->getMessage());

        }


    }

    /*
     * Logic for Users : End
     * */


    /**
     * @param SignInRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     *
     * Sign in via the User Management App API
     * Save the auth_token to a session
     * For all next requests send the auth_token as a header
     *
     */
    public function signin(SignInRequest $request){

        try{

            /*
             * Username
             * */
            $username = $request['username'];
            $password = $request['password'];
            /*
             * Build data to send in the request
             * */
            $data = ['username'=>$username,'password'=>$password];


            /*
             * Get the end point to access
             * */
            $endPoint = endpoint('USERS_LOGIN');


            /*
             * Make request to the API
             * */
            $result = ApiHandler::makePostRequest($endPoint,$data);


            /*
             * We failed to get data from the API
             * */
            if($result->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                return $this->redirectBackToFormWithError($result->statusDescription);

            }


            /*
             * We got data from the API
             * */
            $apiResult = json_decode($result->result, true);


            /*
             * Get the statusCode, statusDescription
             * */
            $statusCode = $apiResult['statusCode'];
            $statusDescription = $apiResult['statusDescription'];

            /*
             * We failed to validate from the API
             * */
            if($statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                return $this->redirectBackToFormWithError($statusDescription);

            }

            /*
             * The user is required to change their password
             * */
            if($statusDescription == AppConstants::$REQUIRE_CHANGE_PASSWORD){

                $token = $apiResult['token'];
                $user = $apiResult['data']['profile'];
                $user = DataFormatter::getApiUser($user);

                //store the temp user object in the session and as well store the access token
                session([Security::$SESSION_TEMP_USER => $user]);
                $cookie = cookie(Security::$COOKIE_TOKEN, $token, Security::$COOKIE_TOKEN_EXPIRY_MINUTES);

                return redirect()->route('user.password.change-auto.form')->withCookie($cookie);

            }


            /*
             *Authentication was successful
             * */


            /*
             * Get the access token
             * */
            $token = $apiResult['token'];

            /*
             * Get user profile information and dashboard info
             * */
            $user = $apiResult['data']['profile'];
            $user = DataFormatter::getApiUser($user);

            /*
             * we need to unset the require login flag
             * */
            session([SESSION_KEY_REQUIRE_LOGIN => false]);

            /*
             * save user in session
             * */
            $user->token = $token;

            $this->setUserAuthenticationSession($user);

            /*
             * we now proceed to load the default page
             * */
            return $this->loadDefaultPage($token);


        }catch (\Exception $exception){

            return $this->redirectBackToFormWithError(AppConstants::generalError($exception->getMessage()));

        }


    }

    private function showAppSelectionPage($accessToken) {

        session([Security::$SESSION_USER_ACCESS_TOKEN => $accessToken]);
        $cookie = cookie(Security::$COOKIE_TOKEN, $accessToken, Security::$COOKIE_TOKEN_EXPIRY_MINUTES);

        return redirect(route('users.app-selection'))->withCookie($cookie);

    }

    public function getAdminDashboard(){


        $token = Cookie::get(Security::$COOKIE_TOKEN);

        /*
         * Get the app stats for use on the dashboard
         * */
        $repoResp = ApplicationStatsRepo::getApplicationStats($token);

        /*
         * If we fail to get the values we default to 0
         * */
        $appStats = $repoResp->statusCode == AppConstants::$STATUS_CODE_SUCCESS ?
                    $repoResp->repoData : new ApiApplicationStat();


        return view('admin.admin-dashboard', compact('appStats'));

    }

    public function getUserDashboard(){

        try{

            return redirect(route('appraisal-forms.owner'));

        }catch (\Exception $exception){

            $user = session(Security::$SESSION_USER);
            $msg = AppConstants::generalError($exception->getMessage());
            $isError = true;
            return view('user.dashboard', compact('user','active_module','msg','isError'));

        }

    }

    public function signoutAdmin(Request $request, $redirectToApp = null, $redirectSpecificPage = null ){

        /**
         * Invalidate the session
         */
        $request->session()->invalidate();

        /**
         * To prevent the user from any attempts of auto-login, we set this flag to true
         */
        session([SESSION_KEY_REQUIRE_LOGIN => true]);

        /**
         * Load login page
         */
        if(isset($redirectToApp) && isset($redirectSpecificPage)){

            /**
             * Put the referrals parameters back into the session, because invalidating session up, removed them
             */
            session([Security::$SESSION_REFERRAL_URL_TO_APP => $redirectToApp, Security::$SESSION_REFERRAL_URL_TO_LINK=>$redirectSpecificPage]);

            /**
             * It's a referral so we pass the parameters
             */
            return redirect(route('login',[$redirectToApp,$redirectSpecificPage]));
        }

        /**
         * It's a normal login
         */
        return redirect(route('login'));

    }

    public function getUserRegistrationForm($message = null){

        $active_module = AppConstants::$ACTIVE_MOD_USERS;
        $departments = Department::all();
        $roles = Role::all();
        $registrationMessage = $message;

        if($message != nullOrEmptyString()){
            return view('user.registration',compact('active_module','departments','roles','registrationMessage'));
        }
        return view('user.registration',compact('active_module','departments','roles'));

    }

    public function createUser(CreateUserRequest $request){

        $user = new User();
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->email = $request['email'];
        $user->department_id = $request['department'];
        $user->staff_category = $request['staff_category'];
        $roleId = $request['role'];
        $unencrypted_password = $request['password'];//Security::randomPassword();
        $user->password = bcrypt($unencrypted_password);
        $user->account_type = AppConstants::$ACCOUNT_TYPE_USER;
        $user->created_at = Carbon::now();

        $username = $this->createUsername($user->first_name,$user->last_name);
        $user->username = $username;


        if(($this->userRepo->createUser($user))){

            $user->roles()->sync([$roleId]);

            $registrationMessage = "Account for user ".$username.
                " with password [ ".$unencrypted_password." ] has been successfully created";

            return $this->getUserRegistrationForm($registrationMessage);

        }

        return redirect()->back();

    }

    private function createUsername($firstName, $lastName) {

        $firstNameArr = str_split(strtolower($firstName));
        $firstNameInitial = $firstNameArr[0];

        $temporaryUsername = $firstNameInitial . strtolower($lastName);
        $username = $this->userRepo->nonExistentUsername($temporaryUsername);

        return strtolower($username);

    }

    public function userProfiles(){

        $users = $this->userRepo->users();
        $active_module = AppConstants::$ACTIVE_MOD_USERS;
        return view('user.user_profiles',compact('active_module','users'));

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function updateUserViaApi(Request $request) {


        /*
         * Get the authentication token
         * */
        $token = Cookie::get(Security::$COOKIE_TOKEN);

        /*
         * User we are updating
         * */
        $username = $request['username'];

        $lmsRoles =
            [
                'reception_flag' => $request['reception_flag'],
                'registry_flag' => $request['registry_flag'],
                'finance_flag' => $request['finance_flag'],
                'ed_office_flag' => $request['ed_office_flag'],
                'outgoing_letter_flag' => $request['outgoing_letter_flag'],
                'master_data_flag' => $request['master_data_flag'],
                'reports_flag' => $request['reports_flag'],
            ];


        /*
         * Request data
         * */
        $data = [


            'username' => $username,
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'other_name' => $request['other_name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'org_code' => $request['org_code'],
            'role_code' => $request['role_code'],
            'department_code' => $request['department_code'],
            'category_code' => $request['category_code'],
            'regional_office_code' => $request['regional_office_code'],
            'created_by' => $request['created_by'],
            'updated_by' => $request['updated_by'],
            'letter_movement_role' =>"",
            'department_unit' => $request['department_unit'],

            'staff_number' => $request['staff_number'],
            'contract_start_date'=> $request['contract_start_date'],
            'contract_expiry_date'=> $request['contract_expiry_date'],
            'date_of_birth' => $request['date_of_birth'],
            'designation_id' => $request['designation_id'],
            'lms_role' => $lmsRoles
        ];


        /*
         * Action
         * */
        $action = endpoint('USERS_UPDATE');


        /*
         * Send request to the API
         * */
        $resp = ApiHandler::makePutRequest($action, $username, $data, true, $token);

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

        $successMessage = "SYSTEM USER [".$username."] SUCCESSFULLY UPDATED";


        /*
         * Return to the form create page with a success message
         * */
        return response()->json(['success' => $successMessage]);


    }

    public function deleteProfile(Request $request){


        try{

            /*
             * Get the authentication token
             * */
            $token = Cookie::get(Security::$COOKIE_TOKEN);

            /*
             * User we are updating
             * */
            $username = $request['id'];


            /*
             * Get the user who is deleting
             * */
            $user = session(Security::$SESSION_USER);

            /*
             * We failed to get the logged in user
             * */
            if($user == null){
                return $this->allUsers(AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN);
            }

            /*
             * Request data
             * */
            $data = [ 'deleted_by' => $user->username ];


            /*
             * Action
             * */
            $action = endpoint('USERS_DELETE');


            /*
             * Send request to the API
             * */
            $resp = ApiHandler::makeDeleteRequest($action, $username, $data, true, $token);

            /*
             * Error occurred on sending the request
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->allUsers($resp->statusDescription);
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
                return $this->allUsers($resp->$statusDescription);
            }


            /*
             * Operation was successful at the server side
             * */

            $successMessage = "SYSTEM USER [".$username."] SUCCESSFULLY DELETED";


            /*
             * Return to the form create page with a success message
             * */
            return $this->allUsers($successMessage);


        }catch (\Exception $exception){

            /*
             * We should log the error message we have got
             * */
            $errorMessage = "Failed To Delete User With Error. ".$exception->getMessage();
            return $this->allUsers($errorMessage);

        }

    }

    /**
     * @param $sentEmail
     * @param $user
     * @return bool
     */
    private function userEmailTaken($sentEmail, $user) {
        return (strcmp($sentEmail, $user->email) != 0) && ($this->userRepo->accountWithEmailExists($sentEmail));
    }

    public function getPasswordChangeForm($msg = null, $isError = false){

        $active_module = AppConstants::$ACTIVE_MOD_PROFILES;
        $user = session(Security::$SESSION_USER);

        if($user == null){
            return redirect('/');
        }

        /*
         * If it's the admin redirect to the admin change password page
         * */
        if($user->roleCode == AppConstants::$ROLE_CODE_ADMIN){
            return view('user.password-change-admin',compact('active_module', 'msg','isError','user'));
        }else{
            return view('bt.users.password_change');
        }



    }

    public function changePassword(Request $request){


        try{

            $validator = Validator::make($request->all(), ((new PasswordChangeRequest())->rules()));
            if ($validator->fails()) {
                $firstValidationError = getFirstValidationError($validator,  [ 'username','old_password','new_password','new_password_confirmation' ]);
                return json_encode( ApiResp::failure($firstValidationError));
            }

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            /*
             * Request data
             * */
            $data = [
                'username' => $request['username'],
                'old_password' => $request['old_password'],
                'new_password' => $request['new_password'],
            ];

            /*
             * Action
             * */
            $action = endpoint('USERS_CHANGE_PASSWORD');


            /*
             * Send request to the API
             * */
            $resp = ApiHandler::makePostRequest($action, $data, true, $token);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return json_encode(ApiResp::failure($resp->statusDescription));
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
                return json_encode(ApiResp::failure($statusDescription));
            }


            /*
             * Operation was successful at the server side
             * */
            $successMessage = "Password Successfully Changed";
            return json_encode(ApiResp::success($successMessage,$successMessage));

        }catch (\Exception $exception){
            $err = AppConstants::$GENERAL_ERROR_AT_TDS . ' ' . $exception->getMessage();
            return json_encode(ApiResp::failure($err));
        }

    }

    public function getUserProfilePage($msg = null, $isError = false){

        try{

            $active_module = AppConstants::$ACTIVE_MOD_PROFILES;

            $user = session(Security::$SESSION_USER);
            if($user ==  null){
                return redirect('login');
            }

            //send request to API
            $baseResp = DataLoader::getUsersAcademicBackgrounds($user->username);

            //error on getting API data
            if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $msg = $baseResp->statusDescription;
                $isError = true;
                return view('user.user-profile', compact('active_module','user','msg','isError'));
            }

            //get the academic backgrounds
            $academicBackgrounds = $baseResp->result;

            return view('user.user-profile', compact('active_module','user','msg','isError','academicBackgrounds'));

        }catch (\Exception $exception){

            $user = session(Security::$SESSION_USER);
            if($user ==  null){
                return redirect('login');
            }

            $active_module = AppConstants::$ACTIVE_MOD_PROFILES;
            $msg = AppConstants::generalError($exception->getMessage());
            $isError = true;
            return view('user.user-profile', compact('active_module','user','msg','isError'));

        }

    }

    public function saveUserAcademicBackgroundAjax(Request $request){

        try{

            //check if request us ajax
            if(!$request->ajax()){
                return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
            }

            //validate request
            $validator = Validator::make($request->all(), [
                'username' => 'required|min:2',
                'institution' => 'required|min:2',
                'year_of_study' => 'required|min:2',
                'award' => 'required|min:2',
            ]);

            //failed validation
            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            //send request to API
            $data =
                [
                    'username' => $request['username'],
                    'institution' => $request['institution'],
                    'year_of_study' => $request['year_of_study'],
                    'award' => $request['award'],
                ];

            $resp = DataLoader::saveUserAcademicBackground($data);

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

    public function updateUserAcademicBackgroundAjax(Request $request){

        try{

            //check if request us ajax
            if(!$request->ajax()){
                return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
            }

            //validate request
            $validator = Validator::make($request->all(), [
                'username' => 'required|min:2',
                'institution' => 'required|min:2',
                'year_of_study' => 'required|min:2',
                'award' => 'required|min:2',
                'record_id' => 'required|numeric',
            ]);

            //failed validation
            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            //send request to API
            $data =
                [
                    'username' => $request['username'],
                    'institution' => $request['institution'],
                    'year_of_study' => $request['year_of_study'],
                    'award' => $request['award'],
                    'record_id' => $request['record_id'],
                ];

            $identifier = $request['record_id'];
            $resp = DataLoader::saveUserAcademicBackground($data,true, $identifier);

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

    public function showAcademicBg($id){


        try{

            $user = session(Security::$SESSION_USER);
            if($user == null){
                return AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN;
            }

            $baseResp = DataLoader::getUsersAcademicBackgrounds($user->username);

            if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return AjaxResponseHandler::failedResponse($baseResp->statusDescription);
            }

            $academicBg = null;
            foreach ($baseResp->result as $school){

                if($school->id == $id) {
                    $academicBg = $school;
                    return AjaxResponseHandler::successResponse($academicBg);
                };

            }

            return AjaxResponseHandler::failedResponse("FAILED TO GET ACADEMIC BG WITH ID [".$id."]");

        }catch (\Exception $exception){
            return AjaxResponseHandler::failedResponse(AppConstants::generalError($exception->getMessage()));
        }

    }

    public function deleteAcademicBackground(Request $request){

        try{

            $identifier = $request['id'];
            $user = session(Security::$SESSION_USER);

            /*
             * We failed to get the logged in user
             * */
            if($user == null){
                return $this->getUserProfilePage(AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN, true);
            }

            /*
             * Send request to the API
             * */
            $resp = DataLoader::deleteAcademicBackground([],$identifier);

            /*
             * Error occurred on sending the request
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->getUserProfilePage($resp->statusDescription);
            }

            /*
             * Operation was successful at the server side
             * */
            $successMessage = "INSTITUTION SUCCESSFULLY DELETED";
            return $this->getUserProfilePage($successMessage);


        }catch (\Exception $exception){

            $errorMessage = "Failed To Delete Institution With Error. ".$exception->getMessage();
            return $this->getUserProfilePage($errorMessage,true);

        }


    }


    public function saveUserAjax(Request $request){

        try{


            if(!$request->ajax()){
                return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
            }


            $validator = Validator::make($request->all(), [
                'first_name' => 'required|min:2',
                'last_name' => 'required|min:2',
                'role_code' => 'required',
                'department_code' => 'required',
                'category_code' => 'required',
                'org_code' => 'required',
                'department_unit' => 'required',
                'email' => 'required|email',
                'staff_number'=>'required|min:2',
                'contract_start_date'=>'required|date',
                'contract_expiry_date'=>'required|date',
                'date_of_birth'=>'required|date',
                'designation_id'=>'required',
                'letter_movement_role'=>"",
               ]);


            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $lmsRoles =
                [
                    'reception_flag' => $request['reception_flag'],
                    'registry_flag' => $request['registry_flag'],
                    'finance_flag' => $request['finance_flag'],
                    'ed_office_flag' => $request['ed_office_flag'],
                    'outgoing_letter_flag' => $request['outgoing_letter_flag'],
                    'master_data_flag' => $request['master_data_flag'],
                    'reports_flag' => $request['reports_flag'],
                ];

            $data = [

                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'other_name' => $request['other_name'],
                'email' => $request['email'],

                'staff_number' => $request['staff_number'],
                'contract_start_date' => $request['contract_start_date'],
                'contract_expiry_date' => $request['contract_expiry_date'],
                'date_of_birth' => $request['date_of_birth'],
                'designation_id' => $request['designation_id'],

                'phone' => $request['phone'],
                'org_code' => $request['org_code'],
                'role_code' => $request['role_code'],
                'department_code' => $request['department_code'],
                'category_code' => $request['category_code'],
                'regional_office_code' => $request['regional_office_code'],
                'created_by' => $request['created_by'],
                'letter_movement_role' => $request['letter_movement_role'],
                'department_unit' => $request['department_unit'],
                'lms_role' => $lmsRoles,

            ];

            $action = endpoint('USERS_STORE');
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

            $successMessage = "USER [".$request['first_name']."] SUCCESSFULLY CREATED";
            return response()->json(['success' => $successMessage]);


        }catch (\Exception $exception){
            return response()->json(['error'=>[AppConstants::generalError($exception->getMessage())]]);
        }

    }

    public function getChangeDefaultPasswordForm($msg = null, $isError = false){

        /*
         * We store the temporarily logged in user in this session variable
         * */
        $user = session(Security::$SESSION_TEMP_USER);

        if($user == null){
            return redirect('/');
        }

        return view('bt.users.password_change_default');

    }
    public function logoutUser(Request $request){

        session()->flush();
        return Redirect::to(endpoint('USER_MANAGEMENT_LOGOUT_LINK'));

    }

    public function logoutAndRedirectBackToPpdaApps(Request $request){

        session()->flush();
        $url = "http://".endpoint('SERVER_IP').'/ppda-apps/selection';
        return Redirect::to($url);

    }

    public function changeDefaultPassword(ChangeDefaultPasswordRequest $request){

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);
            $tempUser = session(Security::$SESSION_TEMP_USER);

            /*
             * Request data
             * */
            $data = [
                'username' => $tempUser->username,
                'new_password' => $request['new_password'],
            ];

            /*
             * Action
             * */
            $action = endpoint('USERS_CHANGE_DEFAULT_PASSWORD');


            /*
             * Send request to the API
             * */
            $resp = ApiHandler::makePostRequest($action, $data, true, $token);

            /*
             * Error occurred on sending the request, redirect to the page with data
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                return $this->getChangeDefaultPasswordForm($resp->statusDescription, true);

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
                return $this->getChangeDefaultPasswordForm($statusDescription, true);
            }


            /*
             * Operation was successful at the server side
             * */
            $successMessage = "Password successfully changed, you can now login using your new password";

            /*
             * Return to the form create page with a success message
             * */
            return redirectBackWithSessionSuccess($successMessage,'login');

        }catch (\Exception $exception){

            return $this->getChangeDefaultPasswordForm(AppConstants::$GENERAL_ERROR_AT_TDS. ' ' .$exception->getMessage(), true);

        }

    }

    public function appSelectionView($token, $msg = null, $isError = false){

        try{

            $isTrustedDevice = $this->deviceIsTrustedDevice();

            $data = array(
                'msg' => $msg,
                'isError' => $isError,
                'isTrustedDevice' => $isTrustedDevice,
            );
            $response = new Response(view('bt-app-selection')->with($data));

            $cookie = cookie(Security::$COOKIE_TOKEN, $token, Security::$COOKIE_TOKEN_EXPIRY_MINUTES);
            $response->withCookie($cookie);
            session([Security::$SESSION_USER_ACCESS_TOKEN => $token]);
            return $response;

        }catch (\Exception $exception){
            return redirect(route('login'));
        }

    }

    public function getAppSelectionView(){
        /*
         * Get the user token from the stored session
         * */
        $tokenFromSession = session(Security::$SESSION_USER_ACCESS_TOKEN);
        /*
        * User Rights in PortalUser
        * */
        $token = Security::dtDecrypt($tokenFromSession);
        $resp = DataLoader::getAuthenticatedUser($token);

        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return $resp->statusDescription;
        }
        $user = $resp->result;

        $portalUser = PortalUser::where('username',$user->username)->first();
        $rights = isset($portalUser) ? $portalUser->rights : [];
        session([Security::$SESSION_USER_RIGHTS => encrypt(json_encode($rights))]);
        return $this->appSelectionView($tokenFromSession);
    }


    public function accessApp($app){

        try{

            $this->logTimeInitiatedRedirect($app);

            $token = Cookie::get(Security::$COOKIE_TOKEN);
            /*
             * Check if the supplied application is valid
             * */
            if(!in_array($app, AppConstants::$SUPPORTED_APPLICATIONS) && $app != 'appraisal_new'){
                return $this->appSelectionView($token, "APPLICATION ['.$app.'] NOT SUPPORTED", true);
            }

            /*
             * user wants to access the staff appraisal system, so we redirect them to that
             * */
            if($app == AppConstants::$SUPPORTED_APPLICATIONS_STAFF_APPRAISAL){

                /*
                * I encrypt the access token
                * */
                $encryptedCookie = Security::dtEncrypt($token);
                $url = "http://".endpoint('SERVER_IP').":9001/users/auth/".$encryptedCookie;
                return Redirect::to($url);

            }

            if($app == 'appraisal_new'){

                $encryptedCookie = Security::dtEncrypt($token);
                $url = "http://".endpoint('SERVER_IP').":9002/users/auth/".$encryptedCookie;
                return Redirect::to($url);

            }

            /*
             * user wants to access the emis system, so we redirect them to that
             * */
            if($app == AppConstants::$SUPPORTED_APPLICATIONS_EMIS){

                $user = session(Security::$SESSION_USER);
                $data = [];
                $data['email'] = $user->username;

                $apiResp = DataLoader::sendEmisAuthenticationRequest($data);

                if($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                    //authentication failed
                    $error = $apiResp->statusDescription;
                    $token = Cookie::get(Security::$COOKIE_TOKEN);
                    return $this->appSelectionView($token, $error, true);

                }else{

                    //authentication successful, redirect to emis
                    $encryptedToken = $apiResp->result;
                    $url = endpoint('EMIS_APP_LOGIN_REDIRECT') . $encryptedToken;
                    return Redirect::to($url);

                }

            }


            /*
             * user wants to access the letter movement so we redirect them to that
             * */
            if($app == AppConstants::$SUPPORTED_APPLICATIONS_LETTER_MOVEMENT){

              return $this->redirectToLetterMovement($token);

            }

            /*
             * user wants to access the driver management system so we redirect them to that
             * */
            if($app == AppConstants::$SUPPORTED_APPLICATIONS_DRIVER_MANAGEMENT_SYSTEM){

                return $this->redirectToDriverManagementSystem($token);

            }

            /*
             * user wants to access the admin app so we redirect them to that
             * */
            if($app == AppConstants::$SUPPORTED_APPLICATIONS_ADMIN_APP){
                $encryptedCookie = Security::dtEncrypt($token);
                $url = endpoint('PPDA_ADMIN_APP_END_POINT') . $encryptedCookie;
                return Redirect::to($url);
            }

            /*
             * user wants to access the leave management app so we redirect them to that
             * */
            if($app == AppConstants::$SUPPORTED_APPLICATIONS_LEAVE_MANAGEMENT){

                return $this->redirectToLeaveManagement($token);

            }

            /*
             * user wants to access the recruitment app so we redirect them to that
             * */
            if($app == AppConstants::$SUPPORTED_APPLICATIONS_RECRUITMENT){

                return $this->redirectToRecruitment($token);

            }

            if($app == AppConstants::$SUPPORTED_APPLICATIONS_STORES){

                return $this->redirectToStores($token);

            }
            //employee lifecycle
            if($app == AppConstants::$SUPPORTED_APPLICATIONS_EMPLOYEE_LIFECYCLE){
                return $this->redirectToEmployeeLifeCycle($token);

            }

            /*
             * No method to handle supplied application
             * */
            return $this->appSelectionView($token, "NO URL DEFINED TO HANDLE SUPPLIED APPLICATION ['.$app.']", true);


        }catch (\Exception $exception){

            $error = AppConstants::generalError($exception->getMessage());
            $token = Cookie::get(Security::$COOKIE_TOKEN);
            return $this->appSelectionView($token, $error, true);

        }

    }


    public function redirectToLoginPage(Request $request,$msg = null, $isError = false) {

        $fromPasswordReset = true;
        return \redirect(route('login',[$fromPasswordReset]));

    }

    /**
     * @param $error
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectBackToFormWithError($error) {

        return redirect()->back()->withErrors(SharedCommons::customFormError($error))->withInput();

    }

    /**
     *
     * the route expects the $toApp where we are supposed to go
     * and a list og parameters that that are required in the redirect
     *
     * @param $toApp
     * @param null $params
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function referralLogin ($toApp, $params = null){

        $referralRequestParams = [];

        /*
         * Put the parameters passed in an array if they exist
         * */
        if($params)
        {
            $params = explode('/', $params);
            foreach ($params as $item){
                if($item != ""){
                    $referralRequestParams[] = $item;
                }
            }
        }

        /*
         * Save the referral url params in a session
         * */
        session([Security::$SESSION_REFERRAL_URL_TO_APP => $toApp]);
        session([Security::$SESSION_REFERRAL_URL_PARAMS => $referralRequestParams]);

        return redirect(route('login'));

    }

    private function redirectToLetterMovement(string $token)
    {

        $referralUrlSessionData = session(Security::$SESSION_REFERRAL_URL_PARAMS, null);

        if($referralUrlSessionData != null){

            /*
             * We are going to redirect to the referral URL, and attach the params that we have stored in the session
             * */
            $encryptedCookie = Security::dtEncrypt($token);
            $url = "http://".endpoint('SERVER_IP').":8000/users/auth-ref/".$encryptedCookie;

            /*
             * Attach the referral parameters to the URL so they are sent as well
             * */
            foreach ($referralUrlSessionData as $item){
                $url .= "/".$item;
            }

            /*
             * Remove the session data for Referral URL params
             * */
            session()->forget(Security::$SESSION_REFERRAL_URL_TO_APP);
            session()->forget(Security::$SESSION_REFERRAL_URL_PARAMS);

            return Redirect::to($url);

        }else{

            /*
             * I encrypt the access token
             * */
            $encryptedCookie = Security::dtEncrypt($token);
            $isTrustedDevice = 1;
            $url = endpoint('LETTER_MOVEMENT_APP_END_POINT') . $encryptedCookie."?is_trusted_device=".$isTrustedDevice;

            /*
             * Redirect to the letter movement app with the token
             * */
            return Redirect::to($url);

        }

    }


    private function redirectToDriverManagementSystem(string $token)
    {
        $referralUrlSessionData = session(Security::$SESSION_REFERRAL_URL_PARAMS, null);
        if($referralUrlSessionData != null){

            /*
             * We are going to redirect to the referral URL, and attach the params that we have stored in the session
             * */
            $encryptedCookie = Security::dtEncrypt($token);
            $url = "http://".endpoint('SERVER_IP').":8002/users/auth-ref/".$encryptedCookie;

            /*
             * Attach the referral parameters to the URL so they are sent as well
             * */
            foreach ($referralUrlSessionData as $item){
                $url .= "/".$item;
            }

            /*
             * Remove the session data for Referral URL params
             * */
            session()->forget(Security::$SESSION_REFERRAL_URL_TO_APP);
            session()->forget(Security::$SESSION_REFERRAL_URL_PARAMS);

            return Redirect::to($url);

        }else{

            /*
             * I encrypt the access token
             * */
            $encryptedCookie = Security::dtEncrypt($token);
            $url = endpoint('DRIVER_MANAGEMENT_APP_END_POINT') . $encryptedCookie;
            /*
             * Redirect to the letter movement app with the token
             * */
            return Redirect::to($url);

        }

    }

    private function redirectToLeaveManagement(string $token)
    {

        $referralUrlSessionData = session(Security::$SESSION_REFERRAL_URL_PARAMS, null);

        if($referralUrlSessionData != null){

            /*
             * We are going to redirect to the referral URL, and attach the params that we have stored in the session
             * */
            $encryptedCookie = Security::dtEncrypt($token);
            $url = endpoint('LEAVE_MANAGEMENT_APP_END_POINT').$encryptedCookie;

            /*
             * Attach the referral parameters to the URL so they are sent as well
             * */
            foreach ($referralUrlSessionData as $item){
                $url .= "/".$item;
            }

            /*
             * Remove the session data for Referral URL params
             * */
            session()->forget(Security::$SESSION_REFERRAL_URL_TO_APP);
            session()->forget(Security::$SESSION_REFERRAL_URL_PARAMS);

            return Redirect::to($url);

        }else{

            /*
             * I encrypt the access token
             * */
            $encryptedCookie = Security::dtEncrypt($token);
            $url = endpoint('LEAVE_MANAGEMENT_APP_END_POINT') . $encryptedCookie;

            /*
             * Redirect to the letter movement app with the token
             * */
            return Redirect::to($url);

        }

    }

    private function redirectToRecruitment(string $token)
    {

        $referralUrlSessionData = session(Security::$SESSION_REFERRAL_URL_PARAMS, null);

        if($referralUrlSessionData != null){

            /*
             * We are going to redirect to the referral URL, and attach the params that we have stored in the session
             * */
            $encryptedCookie = Security::dtEncrypt($token);
            $url = endpoint('RECRUITMENT_APP_END_POINT').$encryptedCookie;

            /*
             * Attach the referral parameters to the URL so they are sent as well
             * */
            foreach ($referralUrlSessionData as $item){
                $url .= "/".$item;
            }

            /*
             * Remove the session data for Referral URL params
             * */
            session()->forget(Security::$SESSION_REFERRAL_URL_TO_APP);
            session()->forget(Security::$SESSION_REFERRAL_URL_PARAMS);

            return Redirect::to($url);

        }else{

            /*
             * I encrypt the access token
             * */
            $encryptedCookie = Security::dtEncrypt($token);
            $url = endpoint('RECRUITMENT_APP_END_POINT') . $encryptedCookie;

            //dd($url);

            /*
             * Redirect to the letter movement app with the token
             * */
            return Redirect::to($url);

        }

    }
    private function redirectToStores(string $token)
        {
    
            $referralUrlSessionData = session(Security::$SESSION_REFERRAL_URL_PARAMS, null);
    
            if($referralUrlSessionData != null){
    
                /*
                 * We are going to redirect to the referral URL, and attach the params that we have stored in the session
                 * */
                $encryptedCookie = Security::dtEncrypt($token);
                $url = "http://".endpoint('SERVER_IP').":10005/users/auth-ref/".$encryptedCookie;
    
                /*
                 * Attach the referral parameters to the URL so they are sent as well
                 * */
                foreach ($referralUrlSessionData as $item){
                    $url .= "/".$item;
                }
    
                /*
                 * Remove the session data for Referral URL params
                 * */
                session()->forget(Security::$SESSION_REFERRAL_URL_TO_APP);
                session()->forget(Security::$SESSION_REFERRAL_URL_PARAMS);
    
                return Redirect::to($url);
    
            }else{
                
    
                /*
                 * I encrypt the access token
                 * */
                $encryptedCookie = Security::dtEncrypt($token);
                $isTrustedDevice = 1;
                $url = endpoint('STORES_END_POINT') . $encryptedCookie."?is_trusted_device=".$isTrustedDevice;
    
                /*
                 * Redirect to the letter new app with the token
                 * */
                return Redirect::to($url);
    
            }
    
        }
        private function redirectToEmployeeLifeCycle(string $token)
        {
    
            $referralUrlSessionData = session(Security::$SESSION_REFERRAL_URL_PARAMS, null);
    
            if($referralUrlSessionData != null){
    
                /*
                 * We are going to redirect to the referral URL, and attach the params that we have stored in the session
                 * */
                $encryptedCookie = Security::dtEncrypt($token);
                $url = "http://".endpoint('SERVER_IP').":10003/users/auth-ref/".$encryptedCookie;
    
                /*
                 * Attach the referral parameters to the URL so they are sent as well
                 * */
                foreach ($referralUrlSessionData as $item){
                    $url .= "/".$item;
                }
    
                /*
                 * Remove the session data for Referral URL params
                 * */
                session()->forget(Security::$SESSION_REFERRAL_URL_TO_APP);
                session()->forget(Security::$SESSION_REFERRAL_URL_PARAMS);
    
                return Redirect::to($url);
    
            }else{
                
    
                /*
                 * I encrypt the access token
                 * */
                $encryptedCookie = Security::dtEncrypt($token);
                $isTrustedDevice = 1;
                $url = endpoint('EMPLOYEE_LIFECYCLE_END_POINT') . $encryptedCookie."?is_trusted_device=".$isTrustedDevice;
    
                /*
                 * Redirect to the letter new app with the token
                 * */
                return Redirect::to($url);
    
            }
    
        }
    private function logTimeInitiatedRedirect($app)
    {
        $data = array();
        $data['error_message'] = Carbon::now(). " - Redirect to: ".$app;
        $data['error_code'] = 'test';
        $data['line_number'] = 'test';
        $data['stack_trace'] = 'test';
        $data['class_name'] = 'test';
        $data['method'] = 'test';

       // DataLoader::saveErrorLog($data);

    }

    private function deviceIsTrustedDevice()
    {
        if(getAuthUser() == null){
            return false;
        }

        $hostName = gethostname();
        $currentDeviceIdentifier = $hostName;
        return  in_array($currentDeviceIdentifier, getAuthUser()->trusted_devices);

    }

    /**
     * @param $cookie
     * @param null $bannerMessage
     * @return \Illuminate\Contracts\View\Factory|Response|\Illuminate\View\View
     */
    private function normalLoginPage($cookie = null, $bannerMessage = null)
    {
        $data = [
            'bannerMessage' => $bannerMessage
        ];

        if(isset($cookie)){

            /**
             * Cookie was passed and has to be passed back
             */
            $response = new Response(view('bt-login-page')->with($data));
            $response->withCookie($cookie);
            return $response;

        }else{

            return view('bt-login-page')->with($data);

        }

    }

    private function attemptAutoLogin(Request $request)
    {

        /**
         * Attempt to get the TRUSTED_DEVICE COOKIE VALUE
         */
        $encryptedTrustedDeviceCookie = Cookie::get(COOKIE_TRUSTED_DEVICE);

        if(!isset($encryptedTrustedDeviceCookie)){

            /**
             * This is not a trusted device so we take them to login
             */
            return $this->normalLoginPage();

        }


        /**
         * Decrypt the cookie
         */
        $trustedDeviceCookie = decrypt($encryptedTrustedDeviceCookie);
        $trustedDeviceCookie = json_decode($trustedDeviceCookie);


        /**
         * Validate the cookie using the User Management API
         */
        $data = array();
        $data['username'] = $trustedDeviceCookie->username;
        $data['device_name'] = $trustedDeviceCookie->deviceName;
        $data['browser'] = $trustedDeviceCookie->browser;

        $apiResp = ApiHandler::makePostRequest('/trusted-device/validate',$data,false, false,endpoint('BASE_URL'));

        if($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            /**
             * Delete the cookie and send to normal login page
             */
            $cookieForgotten = cookie(COOKIE_TRUSTED_DEVICE, null, time() - 3600);
            return $this->normalLoginPage($cookieForgotten);

        }

        $resp = json_decode($apiResp->result);
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            /**
             * Delete the cookie and send to normal login page
             */
            $cookieForgotten = cookie(COOKIE_TRUSTED_DEVICE, null, time() - 3600);
            return $this->normalLoginPage($cookieForgotten);

        }

        $existentTrustedDevice = $resp->data;
        if($existentTrustedDevice->status == TRUSTED_DEVICE_STATUS_SUBMITTED_FOR_APPROVAL){

            /**
             * The trusted device is valid but it's not yet approved
             */
            return $this->normalLoginPage(null, "Please contact IT to complete set up of your trusted device");

        }else if($existentTrustedDevice->status == TRUSTED_DEVICE_STATUS_REVOKED){

            /**
             * The trusted device is valid but it's was revoked
             */
            return $this->normalLoginPage(null);

        }


        /**
         * Trusted device is valid and it's approved
         */
        return $this->autoLoginOld($request, $existentTrustedDevice);


    }

    private function autoLoginOld(Request $request, $existentTrustedDevice)
    {

        /**
         * Get session user
         */
        $user = session(Security::$SESSION_USER);

        if(isset($user)){

            /**
             * Session user exists send them to app selection page
             */
            return $this->showAppSelectionPage($user->token);

        }else{

            /**
             * Give the user a longer session
             */
            config(['session.lifetime' => SESSION_LIFETIME_TRUSTED_DEVICE_MINUTES]);


            /**
             * Get the user object and save it to a session
             */

            $deviceId = $existentTrustedDevice->id;
            $encryptedDeviceId = encrypt($deviceId);

            $data = ['device_id'=>$encryptedDeviceId];

            $result = ApiHandler::makePostRequest("/user/trusted-device-auto-login",$data);
            if($result->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                /**
                 * Go to Login with error
                 */
                return $this->normalLoginPage(null,$result->statusDescription);

            }

            $apiResult = json_decode($result->result);
            if($apiResult->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                /**
                 * Go to login with error
                 */
                return $this->normalLoginPage(null,$apiResult->statusDescription);

            }

            /**
             * Format user object
             */
            $user = DataFormatter::getApiUser(json_decode(json_encode($apiResult->data),true));
            $user->token = $apiResult->token;

            /**
             * Save the user in session
             */
            $this->setUserAuthenticationSession($user);

            /**
             * We now proceed to the app selection page
             */
            return $this->showAppSelectionPage($apiResult->token);

        }


    }

    private function loadDefaultPage($accessToken)
    {

        $isReferralUrl = session(Security::$SESSION_REFERRAL_URL_TO_APP) != null;
        $referralPageToLoad = session(Security::$SESSION_REFERRAL_URL_TO_LINK);


        if(!$isReferralUrl || $referralPageToLoad == null){


            /**
             * It's not a referral URL so we redirect the user to the app selection
             */
            return $this->showAppSelectionPage($accessToken);
        }
        else{

            /**
             * It's a referral so we have to redirect the user to where they are supposed to go
             */
            return $this->handleReferralRedirects($accessToken);

        }

    }

    private function handleReferralRedirects($accessToken)
    {

        $toApp = session(Security::$SESSION_REFERRAL_URL_TO_APP);
        $referralPage = session(Security::$SESSION_REFERRAL_URL_TO_LINK);

    //    $params = session(Security::$SESSION_REFERRAL_URL_PARAMS);

        if($toApp == null || !in_array($toApp, AppConstants::$SUPPORTED_APPLICATIONS)){

            /**
             * We don't know which app we want to redirect to
             */
            return $this->showAppSelectionPage($accessToken);

        }

        $url = null;

        if($toApp == AppConstants::$SUPPORTED_APPLICATIONS_LETTER_MOVEMENT){

            $encryptedCookie = Security::dtEncrypt($accessToken);
            $url = "http://".endpoint('SERVER_IP').":8000/users/auth-ref/".$encryptedCookie;

        }
        else if($toApp == AppConstants::$SUPPORTED_APPLICATIONS_DRIVER_MANAGEMENT_SYSTEM){

            $encryptedCookie = Security::dtEncrypt($accessToken);
            $url = "http://".endpoint('SERVER_IP').":8002/users/auth-ref/".$encryptedCookie;

        }
        else if($toApp == AppConstants::$SUPPORTED_APPLICATIONS_STORES){

            $encryptedCookie = Security::dtEncrypt($accessToken);
            $url = "http://".endpoint('SERVER_IP').":10005/users/auth-ref/".$encryptedCookie;

        }


        if(isset($url)){

            /**
             * We have a valid referral to go to
             */
            return $this->redirectToReferral($url, $referralPage);

        }


        /**
         * We don't have a valid referral to go
         */
        return $this->showAppSelectionPage($accessToken);

    }

    private function clearReferralSessionData()
    {
        session()->forget(Security::$SESSION_REFERRAL_URL_TO_APP);
        session()->forget(Security::$SESSION_REFERRAL_URL_PARAMS);
    }

    private function redirectToReferral($url, $referralPage)
    {

        /**
         * Attach the referral parameters to the URL so they are sent as well which is the specific page to load
         */
        $url .= "/".$referralPage;

        /**
         * Remove the session data for Referral URL params
         */
        $this->clearReferralSessionData();

        /**
         * go to the referral
         */
        return Redirect::to($url);

    }


    private function saveReferralIfExists($redirectToApp, $redirectSpecificPage)
    {

        if(!isset($redirectTo) || !isset($redirectSpecificPage)){
            return;
        }

        session([Security::$SESSION_REFERRAL_URL_TO_APP => $redirectToApp]);
        session([Security::$SESSION_REFERRAL_URL_TO_LINK => $redirectSpecificPage]);

    }

    /**
     * @param ApiUser $user
     */
    private function setUserAuthenticationSession(ApiUser $user)
    {
        session([Security::$SESSION_USER => $user]);
        $trustedDevice = $this->attemptToGetTrustedDeviceIfItExists();
        $sessionLog = new SessionHistory(Carbon::now(),$trustedDevice);
        $sessionLog->save();
    }

    private function attemptToGetTrustedDeviceIfItExists(){

        try{

            $encryptedTrustedDeviceCookie = Cookie::get(COOKIE_TRUSTED_DEVICE);
            $device = null;

            if(isset($encryptedTrustedDeviceCookie)){
                $trustedDeviceCookie = decrypt($encryptedTrustedDeviceCookie);
                $device = json_decode($trustedDeviceCookie);
                return $device;
            }else{
                return null;
            }

        }catch (\Exception $exception){
            return null;
        }

    }
}
