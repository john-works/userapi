<?php


namespace App;

use app\Helpers\ApiHandler;
use app\Helpers\AppConstants;
use app\Helpers\EndPoints;
use Carbon\Carbon;

class SessionHistory
{

    public $username;
    public $application;
    public $session_creation_datetime;
    public $session_duration_minutes;
    public $session_expiry_datetime;
    public $trusted_device_id;
    public $entities;
    /**
     * SessionHistory constructor.
     * @param Carbon $session_creation_datetime
     * @param null $trustedDevice
     */
    public function __construct(Carbon $session_creation_datetime, $trustedDevice = null)
    {

        $this->username = getAuthUser()->username;
        $this->application = APP_NAME_SESSION_LOG;
        $this->session_creation_datetime = $session_creation_datetime->toDateTimeString();
        $this->trusted_device_id = isset($trustedDevice)?$trustedDevice->deviceId : null;

        /**
         * get the session time
         */
        $sessionLifeTime = config('session.lifetime', 0);
        $this->session_duration_minutes = $sessionLifeTime;

        $expiry = $session_creation_datetime->addMinutes($sessionLifeTime);
        $this->session_expiry_datetime = $expiry->toDateTimeString();
    }

    public function save(){

        try{

            $data = array();
            $data['username'] = $this->username;
            $data['application'] = $this->application;
            $data['session_creation_datetime'] = $this->session_creation_datetime;
            $data['session_duration_minutes'] = $this->session_duration_minutes;
            $data['session_expiry_datetime'] = $this->session_expiry_datetime;
            $data['trusted_device_id'] = $this->trusted_device_id;
            $apiResp = ApiHandler::makePostRequest('/session-history', $data, false, false, endpoint('BASE_URL'));
            if ($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
//                dd($apiResp->statusDescription);
                // return json_encode(ApiResp::failure($apiResp->statusDescription));
            }

            $resp = json_decode($apiResp->result);
            if ($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS) {
//                dd(ApiResp::failure($resp->statusDescription));
                // return json_encode(ApiResp::failure($resp->statusDescription));
            }

        }catch (\Exception $exception){

        }

    }

}