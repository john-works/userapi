<?php

namespace App\Http\Controllers;

use App\User;
use App\Access;
use app\ApiResp;
use App\PortalUser;
use GuzzleHttp\Client;
use app\Helpers\EndPoints;
use app\Helpers\ApiHandler;
use Illuminate\Http\Request;
use app\Helpers\AppConstants;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class TrustedDevicesController extends Controller
{

    public function trustedDevicesSetConfirmation($browser)
    {

        //$publicIp = file_get_contents("http://ipecho.net/plain");
        $localIp = gethostbyname(gethostname());
        $hostName = gethostname();
        $otherData = php_uname('n');
        $httpHost = $_SERVER['HTTP_HOST'];
        //$otherDetails = $hostName . ':::' . $publicIp . ':::' . $otherData . ':::' . $httpHost;
        $otherDetails = $hostName . ':::' . $otherData . ':::' . $httpHost;

        $data = array(
            'authUser' => getAuthUser(),
            'browser' => $browser,
            'deviceIp' => $localIp,
            'otherDeviceData' => "$otherDetails",
        );
        return view('bt.trusted_devices.trusted_device_set')->with($data);
    }


    public function trustedDevicesSave(Request $request)
    {

        try {
            
            $data = $request->all();

            $confirmationCode = $data['confirmation_code'];
            $confirmationCode = decrypt($confirmationCode);
            $userSuppliedCode = $data['confirmation_code_input'];

            if ($confirmationCode != $userSuppliedCode) {
                return json_encode(ApiResp::failure("Invalid Confirmation Code supplied"));
            }

            unset($data['_token'], $data['confirmation_code'], $data['confirmation_code_input']);

            $apiResp = ApiHandler::makePostRequest('/trusted-device', $data, false, false, endpoint('BASE_URL'));

            if ($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
                return json_encode(ApiResp::failure($apiResp->statusDescription));
            }

            $resp = json_decode($apiResp->result);
            if ($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
                return json_encode(ApiResp::failure($resp->statusDescription));
            }

            if (!isset($resp->data)) {

                /**
                 * we didn't create a new device, so we just show the response
                 */
                $msg = $resp->statusDescription;
                return json_encode(ApiResp::success($msg, $msg));

            } else {

                /**
                 * if we created a new device and returned it,
                 * set cookie with the trusted device details as the values
                 */
                $deviceReturned = $resp->data;
                $trustedDevice = trusted_device($deviceReturned->username, $deviceReturned->id, $deviceReturned->device_name, $deviceReturned->browser, $deviceReturned->created_at);
                $encryptedTrustedDeviceData = encrypt($trustedDevice);

                $cookieName = COOKIE_TRUSTED_DEVICE;
                $cookieVal = $encryptedTrustedDeviceData;
                $msg = "Trusted Device successfully set";
                return response()->json(json_encode(ApiResp::success($msg, $msg)))->withCookie(cookie($cookieName, $cookieVal, COOKIE_TRUSTED_DEVICE_EXPIRY_MINUTES));

            }


        } catch (\Exception $exception) {
            return json_encode(ApiResp::failure($exception->getMessage()));
        }

    }

    public function trustedDeviceAdminIndex()
    {

        return view('bt.trusted_devices.trusted_devices_admin');

    }

    public function trustedDeviceAdminList($deviceId = null)
    {

        $apiResp = ApiHandler::makeGetRequest('/trusted-devices', false, false, $deviceId, endpoint('BASE_URL'));
        if ($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
            return json_encode(ApiResp::failure($apiResp->statusDescription));
        }

        $resp = json_decode($apiResp->result);
        if ($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
            return json_encode(ApiResp::failure($resp->statusDescription));
        }
        $records = $resp->data;

        $result = [];
        foreach ($records as $record) {
            $record->actions = view('actions.action_trusted_device_admin', compact('record'))->render();
            $record->actions_owner = view('actions.action_trusted_device_owner', compact('record'))->render();

            $lastActionPerformed = $record->last_action; //get the last action performed

            $record->last_action_type = (isset($lastActionPerformed) ? $lastActionPerformed->action : '');
            $record->last_action_user = (isset($lastActionPerformed) ? $lastActionPerformed->action_user_full_name : '');
            $record->last_action_date = get_user_friendly_date_time((isset($lastActionPerformed) ? $lastActionPerformed->action_datetime : null));
            $result[] = $record;
        }

        return datatables(collect($result))
            ->rawColumns(['actions', 'actions_owner'])
            ->toJson();

    }
    public function trustedDeviceCurrentList($deviceId = null)
    {

        $apiResp = ApiHandler::makeGetRequest('/trusted-devices', false, false, $deviceId, endpoint('BASE_URL'));
        if ($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
            return json_encode(ApiResp::failure($apiResp->statusDescription));
        }

        $resp = json_decode($apiResp->result);
        if ($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
            return json_encode(ApiResp::failure($resp->statusDescription));
        }
        $records = $resp->data;

        $result = [];
        foreach ($records as $record) {
            $record->actions = view('actions.action_trusted_device_admin', compact('record'))->render();
            $record->actions_current = view('actions.action_trusted_device_current', compact('record'))->render();

            $lastActionPerformed = $record->last_action;//get the last action performed

            $record->last_action_type = (isset($lastActionPerformed) ? $lastActionPerformed->action : '');
            $record->last_action_user = (isset($lastActionPerformed) ? $lastActionPerformed->action_user_full_name : '');
            $record->last_action_date = get_user_friendly_date_time((isset($lastActionPerformed) ? $lastActionPerformed->action_datetime : null));
            $result[] = $record;
        }

        return datatables(collect($result))
            ->rawColumns(['actions', 'actions_current'])
            ->toJson();

    }

    public function trustedDevicesApprove($deviceId)
    {

        try {

            if (getAuthUser() == null) {
                return json_encode(ApiResp::failure("Session expired please Login Again and retry"));
            }

            $data = array();
            $data['approved_by'] = getAuthUser()->username;
            $data['device_id'] = $deviceId;

            $apiResp = ApiHandler::makePostRequest('/trusted-device/approve', $data, false, false, endpoint('BASE_URL'));

            if ($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
                return json_encode(ApiResp::failure($apiResp->statusDescription));
            }

            $resp = json_decode($apiResp->result);
            if ($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
                return json_encode(ApiResp::failure($resp->statusDescription));
            }

            $msg = "Trusted Device successfully approved";
            return json_encode(ApiResp::success($msg, $msg));

        } catch (\Exception $exception) {
            return json_encode(ApiResp::failure($exception->getMessage()));
        }

    }

    public function trustedDevicesRevoke($deviceDetails)
    {

        try {

            $device = json_decode(decrypt($deviceDetails));
            $revokedBy = getAuthUser()->username;
            $trustedDevice = trusted_device($device->username, $device->id, $device->device_name, $device->browser, $device->created_at);
            $trustedDevice = json_decode($trustedDevice);

            /**
             * Perform revoke
             */
            $apiResp = $this->revokeTrustedDevice($trustedDevice, $revokedBy, null);

            if ($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
                return json_encode(ApiResp::failure($apiResp->statusDescription));
            }

            $msg = "Trusted Device successfully revoked";
            return json_encode(ApiResp::success($msg, $msg));

        } catch (\Exception $exception) {
            return json_encode(ApiResp::failure($exception->getMessage()));
        }

    }

    public function trustedDevicesRevokeAdmin($deviceId, $revokeComment)
    {

        try {

            $revokeComment = urldecode($revokeComment);

            $data = array();
            $data['revoked_by'] = getAuthUser()->username;
            $data['device_id'] = $deviceId;
            $data['comment'] = $revokeComment;

            $apiResp = ApiHandler::makePostRequest('/trusted-device/revoke/admin', $data, false, false, endpoint('BASE_URL'));

            if ($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
                return json_encode(ApiResp::failure($apiResp->statusDescription));
            }

            $resp = json_decode($apiResp->result);
            if ($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
                return json_encode(ApiResp::failure($resp->statusDescription));
            }

            $msg = "Trusted Device successfully revoked";
            return json_encode(ApiResp::success($msg, $msg));

        } catch (\Exception $exception) {
            return json_encode(ApiResp::failure($exception->getMessage()));
        }

    }

    public function trustedDevicesSendConfirmationCode($deviceDetails)
    {

        try {

            $deviceDetails = urldecode($deviceDetails);
            $detailsParts = explode(':::', $deviceDetails);
            $browser = $detailsParts[0];
            $deviceName = $detailsParts[1];
            $deviceIp = $detailsParts[2];

            $data = array();
            $data['username'] = getAuthUser()->username;
            $data['browser'] = $browser;
            $data['device_name'] = $deviceName;
            $data['device_ip'] = $deviceIp;

            $apiResp = ApiHandler::makePostRequest('/trusted-device/sent-confirmation-code', $data, false, false, endpoint('BASE_URL'));
            if ($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
                return json_encode(ApiResp::failure($apiResp->statusDescription));
            }

            $resp = json_decode($apiResp->result);
            if ($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
                return json_encode(ApiResp::failure($resp->statusDescription));
            }

            $code = encrypt($resp->data);
            $msg = "Trusted Device setup confirmation code sent";
            return json_encode(ApiResp::success($code, $msg));

        } catch (\Exception $exception) {
            return json_encode(ApiResp::failure($exception->getMessage()));
        }

    }

    public function trustedDeviceAdminActionHistoryList($deviceId)
    {

        $apiResp = ApiHandler::makeGetRequest('/trusted-devices/action-history', false, false, $deviceId, endpoint('BASE_URL'));
        if ($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
            return json_encode(ApiResp::failure($apiResp->statusDescription));
        }

        $resp = json_decode($apiResp->result);
        if ($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
            return json_encode(ApiResp::failure($resp->statusDescription));
        }
        $records = $resp->data;

        $result = [];
        foreach ($records as $record) {
            $record->action_datetime = get_user_friendly_date_time($record->action_datetime);
            $result[] = $record;
        }

        return datatables(collect($result))
            ->rawColumns(['actions'])
            ->toJson();

    }

    public function trustedDeviceAdminActionHistory($deviceId)
    {
        $data = array(
            'deviceId' => $deviceId
        );
        return view('bt.trusted_devices.trusted_devices_action_history')->with($data);
    }

    public function trustedDeviceAdminRevokeUserForm()
    {

        $apiResp = ApiHandler::makeGetRequest('/users', false, false, null, endpoint('BASE_URL'));
        if ($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
            return json_encode(ApiResp::failure($apiResp->statusDescription));
        }

        $resp = json_decode($apiResp->result);
        if ($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
            return json_encode(ApiResp::failure($resp->statusDescription));
        }
        $users = $resp->data;

        $data = array(
            'users' => $users
        );

        return view('bt.trusted_devices.trusted_devices_revoke_user')->with($data);

    }

    public function trustedDeviceAdminRevokeUser(Request $request)
    {

        try {

            $data = array();
            $data['username'] = $request['username'];
            $data['revoked_by'] = getAuthUser()->username;

            $apiResp = ApiHandler::makePostRequest('/trusted-device/revoke/admin/revoke-user', $data, false, false, endpoint('BASE_URL'));

            if ($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
                return json_encode(ApiResp::failure($apiResp->statusDescription));
            }

            $resp = json_decode($apiResp->result);
            if ($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
                return json_encode(ApiResp::failure($resp->statusDescription));
            }

            $msg = "User Trusted Devices successfully revoked";
            return json_encode(ApiResp::success($msg, $msg));

        } catch (\Exception $exception) {
            return json_encode(ApiResp::failure($exception->getMessage()));
        }

    }

    public function trustedDeviceStatus()
    {

        $resp = $this->validateAndCleanUpTrustedDeviceCookie(COOKIE_TRUSTED_DEVICE);
        $trustedDevice = null;
        $cookie = $resp->trustedDeviceCookieToForget;

        if ($resp->statusCode == AppConstants::$STATUS_CODE_SUCCESS) {
            $trustedDevice = $resp->result;
        }

        $data = array(
            'trustedDevice' => $trustedDevice,
            'msg' => $resp->statusDescription
        );

        $view = view('bt.trusted_devices.trusted_devices_status')->with($data);

        if (!isset($cookie)) {

            /**
             * Just return the view
             */
            return $view;

        } else {

            /**
             * Cookie is only returned when we want to forget
             */
            $response = new Response($view);
            $response->withCookie(Cookie::forget(COOKIE_TRUSTED_DEVICE)); // $response->withCookie($cookie);
            return $response;

        }

    }
    public function getTrustedDeviceInfo()
    {
        $cookie = Cookie::get(COOKIE_TRUSTED_DEVICE);
        $resp = $this->validateAndCleanUpTrustedDeviceCookie(COOKIE_TRUSTED_DEVICE);
        $trustedDevice = null;
        $cookie = $resp->trustedDeviceCookieToForget;
        $data = null;
        if ($resp->statusCode == AppConstants::$STATUS_CODE_SUCCESS) {
            $trustedDevice = $resp->result;
            $data = array(
                'trustedDevice' => $trustedDevice,
                'msg' => $resp->statusDescription
            );
        }
        return $data;
    }
    public function getTrustedDeviceInfoAjax()
    {
        $resp = $this->validateAndCleanUpTrustedDeviceCookie(COOKIE_TRUSTED_DEVICE);
       
        $trustedDevice = null;
        if ($resp->statusCode == AppConstants::$STATUS_CODE_SUCCESS) {
            $trustedDevice = $resp->result;
            $app_usage_rights = false;
            $management_rights = false;
            $is_admin = false;
            $is_employee_360_viewer = false;
            $app_usage_rights_value = User::where('username', $trustedDevice->username)->pluck('is_app_usage_report_user');
            $management_rights_value = User::where('username', $trustedDevice->username)->pluck('is_management_dashboard_user');
            $is_admin_value = User::where('username', $trustedDevice->username)->pluck('is_admin');
            $is_employee_360_viewer_value = User::where('username', $trustedDevice->username)->pluck('is_employee_360_viewer');

            if($app_usage_rights_value[0]==1){
                $app_usage_rights = true;
            }
            if($management_rights_value[0]==1){
                $management_rights = true;
            }
            if($is_admin_value[0]==1){
                $is_admin = true;
            }

            if($is_employee_360_viewer_value[0]==1){
                $is_employee_360_viewer = true;
            }
            
            // $rights_id = PortalUser::where('username', $trustedDevice->username)->pluck('id');
            // $has_rights = false;
            // if($rights_id->count() > 0){
            //     $management_rights = Access::where('user_id', $rights_id)->where('area',MODULE_LOGIN_PAGE_MANAGEMENT_DASHBORAD)
            //                             ->where('access_right','Grant Access')->get();
            //     $has_rights = ($management_rights->count() >0)? true:false;
            // }

            $data = [
                'trustedDevice' => $trustedDevice,
                'msg' => $resp->statusDescription,
                'management_rights' => $management_rights,
                'app_usage_rights' =>$app_usage_rights,
                'is_admin' => $is_admin,
                'is_employee_360_viewer' => $is_employee_360_viewer
            ];

            if(!empty($trustedDevice->status)){
                if($trustedDevice->status === 'Approved'){
                    return json_encode($data);
                }else{
                    return json_encode('Device Not Approved');
                }
            }else{
                return json_encode('No Trusted Device Found');
            }
        }else{
            return json_encode('No Trusted Device Found: '.$resp->statusDescription);
        }
    }
    public function trustedDeviceCurrentStatus()
    {
        //get the cookie
        $cookie = Cookie::get(COOKIE_TRUSTED_DEVICE);
       
        $resp = $this->validateAndCleanUpTrustedDeviceCookie(COOKIE_TRUSTED_DEVICE);
       
        $trustedDevice = null;
        $cookie = $resp->trustedDeviceCookieToForget;
        
        if ($resp->statusCode == AppConstants::$STATUS_CODE_SUCCESS) {
            $trustedDevice = $resp->result;
        }

        $data = array(
            'trustedDevice' => $trustedDevice,
            'msg' => $resp->statusDescription
        );
 
        $view = view('bt.trusted_devices.trusted_devices_current_status')->with($data);

        if (!isset($cookie)) {

            /**
             * Just return the view
             */
            return $view;

        } else {

            /**
             * Cookie is only returned when we want to forget
             */
            $response = new Response($view);
            $response->withCookie(Cookie::forget(COOKIE_TRUSTED_DEVICE)); // $response->withCookie($cookie);
            return $response;

        }

    }

    /**
     * @param string $cookieKey
     *
     * - In case of valid trusted cookie. We return success status code and the trusted device in result field
     * - In case of an invalid trusted device cookie. We return failure and in case we want to forget we return the cookie to be
     *   forgotten
     *
     * @return ApiResp
     */
    public function validateAndCleanUpTrustedDeviceCookie(string $cookieKey)
    {

        $encryptedTrustedDeviceCookie = Cookie::get($cookieKey);
        $cookieExists = $encryptedTrustedDeviceCookie != null;

        if (!$cookieExists) {

            /**
             * Front end cookie doesnt exist or is null
             */
            return ApiResp::failure("Invalid Cookie"); //return "Invalid Cookie";

        } else {

            /**
             * Cookie exists.
             *
             * Validate cookie format (check qn hash of username+devicename+browser+datetimecreated)
             */
            $validStructureTrustedDevice = $this->validateCookie($encryptedTrustedDeviceCookie);
            $validCookie = $validStructureTrustedDevice != null;

            if ($validCookie) {

                /**
                 * Valid cookie
                 */
                $respValidateDevice = $this->validateTrustedDeviceFromServerSide($validStructureTrustedDevice);
                if ($respValidateDevice->statusCode == AppConstants::$STATUS_CODE_SUCCESS) {

                    /**
                     * Matching row exists in trusted devices table
                     */
                    $returnedTrustedDevice = $respValidateDevice->result;
                    return ApiResp::success($returnedTrustedDevice, "Valid Cookie " . $returnedTrustedDevice->status); // return "Valid Cookie " .$returnedTrustedDevice->status; //"Valid Cookie" + Status (Approved, Pending Approval, Revoked)

                } else {

                    /**
                     * - No matching row.
                     * - Delete front end and back end cookie
                     */

                    /**
                     * We need to return the cookie as forgotten
                     */

                   $cookieForgotten = cookie(COOKIE_TRUSTED_DEVICE, null, time() - 3600);
                   setcookie(COOKIE_TRUSTED_DEVICE, "", time()-(60*60*24*7),"/");
                   unset($_COOKIE[COOKIE_TRUSTED_DEVICE]);
                   $resp = ApiResp::failure("Invalid Cookie");
                   $resp->trustedDeviceCookieToForget = $cookieForgotten;
                   return $resp; // return "Invalid Cookie";
                }

            }
            else {

                /**
                 * Invalid cookie format
                 */

                try{

                    $trustedDeviceCookie = decrypt($encryptedTrustedDeviceCookie);
                    $trustedDevice = json_decode($trustedDeviceCookie);

                    $respValidateDevice = $this->validateTrustedDeviceFromServerSide($trustedDevice);
                    if ($respValidateDevice->statusCode == AppConstants::$STATUS_CODE_SUCCESS) {

                        /**
                         * Matching row exists in trusted devices table
                         * Revoke TD backend - add new revoke row in child action history by user "System"
                         * with comment - "Invalid Trusted Devices Cookie cleared by System" + set parent
                         * Trusted Devices row to status Revoked
                         */

                        /**
                         * Revoke the device from the backend
                         */
                        $apiResp = $this->revokeTrustedDevice($respValidateDevice->result, "System", "Invalid Trusted Devices Cookie cleared by System");

                    }

                    /**
                     * Delete front end and back end cookie
                     */
                    $cookieForgotten = cookie(COOKIE_TRUSTED_DEVICE, null, time() - 3600);
                    setcookie(COOKIE_TRUSTED_DEVICE, "", time()-(60*60*24*7),"/");
                    unset($_COOKIE[COOKIE_TRUSTED_DEVICE]);
                    $resp = ApiResp::failure("Invalid Cookie");
                    $resp->trustedDeviceCookieToForget = $cookieForgotten;
                    return $resp; // return "Invalid Cookie";

                }catch (\Exception $exception){

                    /**
                     * Delete front end and back end cookie
                     */
                    $cookieForgotten = cookie(COOKIE_TRUSTED_DEVICE, null, time() - 3600);
                   setcookie(COOKIE_TRUSTED_DEVICE, "", time()-(60*60*24*7),"/");
                   unset($_COOKIE[COOKIE_TRUSTED_DEVICE]);
                   $resp = ApiResp::failure("Invalid Cookie");
                   $resp->trustedDeviceCookieToForget = $cookieForgotten;
                   return $resp; // return "Invalid Cookie";

                }

            }

        }

    }


    private function validateAndCleanUpTrustedDeviceCookieV1(string $cookieKey)
    {

        $msgNoTrustedDevice = "No trusted device";
        $encryptedTrustedDeviceCookie = Cookie::get($cookieKey);
        $cookieExists = $encryptedTrustedDeviceCookie != null;

        if (!$cookieExists) {

            /**
             * Cookie doesn't exist
             */
            $resp = ApiResp::failure($msgNoTrustedDevice . " - Not exist");
            return $resp;

        }

        /**
         * Cookie exists
         */
        $validStructureTrustedDevice = $this->validateCookie($encryptedTrustedDeviceCookie);


        if ($validStructureTrustedDevice == null) {

            /**
             * Cookie not valid.
             * 1. If row exists for device. Revoke the device. 2. Delete the cookie from frontend and backend
             */

            /**
             * Revoke the device from the backend
             */
            $apiResp = $this->revokeTrustedDevice($validStructureTrustedDevice, "System", "Automatic system revocation during cleanup");

            /**
             * We need to return the cookie as forgotten
             */
            $cookieForgotten = cookie(COOKIE_TRUSTED_DEVICE, null, time() - 3600);

            $resp = ApiResp::failure($msgNoTrustedDevice . " - Invalid Structure");
            $resp->trustedDeviceCookieToForget = $cookieForgotten;
            return $resp;

        } else {

            /**
             * Cookie is valid
             */

            /**
             * Find if there's a matching row in the trusted devices table
             */
            $respValidateDevice = $this->validateTrustedDeviceFromServerSide($validStructureTrustedDevice);
            if ($respValidateDevice->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {

                return ApiResp::failure($msgNoTrustedDevice . " - Validation at Server Side failed [" . $respValidateDevice->statusDescription . "]");

            } else {

                return ApiResp::success($respValidateDevice->result);

            }

        }


    }


    /**
     * takes in an encrypted trusted device cookie
     * returns the trustedDevice object only if it's a valid device cookie, else it returns null
     * @param string $encryptedTrustedDeviceCookie
     * @return mixed|null
     */
    private function validateCookie(string $encryptedTrustedDeviceCookie)
    {

        try {

            $trustedDeviceCookie = decrypt($encryptedTrustedDeviceCookie);
            $trustedDevice = json_decode($trustedDeviceCookie);

            /**
             * Check that all the necessary fields are set
             */
            if (isset($trustedDevice->username) && isset($trustedDevice->deviceId) && isset($trustedDevice->deviceName) && isset($trustedDevice->browser)) {

                /**
                 * All expected fields are set
                 */

                $newQuestion = $trustedDevice->username . $trustedDevice->deviceName . $trustedDevice->browser . $trustedDevice->dateTimeCreated;

                if (Hash::check($newQuestion, $trustedDevice->question)) {

                    /**
                     * Question is valid
                     */
                    return $trustedDevice;

                } else {

                    /**
                     * Question was tampered with
                     */
                    return null;

                }

            } else {

                /**
                 * Some field is missing
                 */
                return null;

            }

        } catch (\Exception $exception) {

            /**
             * Decryption failed so cookie was tampered with
             */
            return null;

        }

    }

    private function revokeTrustedDevice($trustedDevice, $revokedBy, $comment)
    {

        try {

            $data = array();
            $data['revoked_by'] = $revokedBy;
            $data['username'] = $trustedDevice->username;
            $data['device_name'] = $trustedDevice->deviceName;
            $data['browser'] = $trustedDevice->browser;
            $data['comment'] = $comment;

            $apiResp = ApiHandler::makePostRequest('/trusted-device/revoke', $data, false, false, endpoint('BASE_URL'));

            if ($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
                return ApiResp::failure($apiResp->statusDescription);
            }

            $resp = json_decode($apiResp->result);
            if ($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
                return ApiResp::failure($resp->statusDescription);
            }
            //viva remove front end cookie
             /**
                     * We need to return the cookie as forgotten
                     */
                    $cookieForgotten = cookie(COOKIE_TRUSTED_DEVICE, null, time() - 3600);
                    setcookie(COOKIE_TRUSTED_DEVICE, "", time()-(60*60*24*7),"/");
                    unset($_COOKIE[COOKIE_TRUSTED_DEVICE]);
                    // $resp = ApiResp::failure("Invalid Cookie");
                    $resp->trustedDeviceCookieToForget = $cookieForgotten;
                    // return $resp; // return "Invalid Cookie";


            $msg = "Trusted Device successfully revoked";
            // dd($resp);
            return ApiResp::success($msg, $msg);

        } catch (\Exception $exception) {

            return ApiResp::failure($exception->getMessage());

        }

    }

    public function validateTrustedDeviceFromServerSide($trustedDevice)
    {

        $data = array();
        $data['username'] = $trustedDevice->username;
        $data['device_name'] = $trustedDevice->deviceName;
        $data['browser'] = $trustedDevice->browser;

        $apiResp = ApiHandler::makePostRequest('/trusted-device/validate', $data, false, false, endpoint('BASE_URL'));

        if ($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
            return ApiResp::failure($apiResp->statusDescription);
        }

        $resp = json_decode($apiResp->result);
        if ($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
            return ApiResp::failure($resp->statusDescription);
        }

        $existentTrustedDevice = $resp->data;
        $resp = ApiResp::success($existentTrustedDevice, $resp->statusDescription);
        return $resp;
    }
}
