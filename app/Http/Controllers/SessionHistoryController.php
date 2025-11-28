<?php

namespace App\Http\Controllers;

use app\ApiResp;
use app\Helpers\ApiHandler;
use app\Helpers\AppConstants;
use app\Helpers\EndPoints;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class SessionHistoryController extends Controller
{

    public function index(){

        $encryptedTrustedDeviceCookie = Cookie::get(COOKIE_TRUSTED_DEVICE);
        $frontEndCookieTrustedDevice = null;
        $dbTrustedDevice = null;

        if(isset($encryptedTrustedDeviceCookie)){

            $trustedDeviceCookie = decrypt($encryptedTrustedDeviceCookie);
            $frontEndCookieTrustedDevice = json_decode($trustedDeviceCookie);

            $trustedDevController = new TrustedDevicesController();
            $respValidateDevice = $trustedDevController->validateTrustedDeviceFromServerSide($frontEndCookieTrustedDevice);
            if ($respValidateDevice->statusCode == AppConstants::$STATUS_CODE_SUCCESS) {
                /**
                 * Matching row exists in trusted devices table
                 */
                $dbTrustedDevice = $respValidateDevice->result;
            }

        }

        $data = array(
            'frontEndCookieTrustedDevice' => $frontEndCookieTrustedDevice,
            'dbTrustedDevice' => $dbTrustedDevice,
        );
        return view('session-history.session_history_index')->with($data);
    }


    public function sessionHistoryForUserList(){

        $username = getAuthUser()->username;
        $apiResp = ApiHandler::makeGetRequest('/session-history/per-app-for-user',false, false,$username, endpoint('BASE_URL'));
        if($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return json_encode(ApiResp::failure($apiResp->statusDescription));
        }

        $resp = json_decode($apiResp->result);
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return json_encode(ApiResp::failure($resp->statusDescription));
        }
        $records = $resp->data;

        $result = [];
        foreach ($records as $log){
            //$outOfOffice->actions = view('actions.action_out_of_office', compact('outOfOffice'))->render();
            $log->session_creation_datetime_fmtd = get_user_friendly_date_time($log->session_creation_datetime);
            $log->session_expiry_datetime_fmtd = get_user_friendly_date_time($log->session_expiry_datetime);
            $result[] = $log;
        }

        return datatables(collect($result))
         //   ->rawColumns(['actions'])
            ->toJson();

    }

}
