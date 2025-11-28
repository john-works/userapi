<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 6/13/2019
 * Time: 08:45
 */


namespace app\Helpers;


class AjaxResponseHandler {

    public static function successResponse($data, $statusDescription = "SUCCESS"){
        $resp = [];
        $resp['statusCode'] = AppConstants::$STATUS_CODE_SUCCESS;
        $resp['statusDescription'] = $statusDescription;
        $resp['data'] = $data;
        return json_encode($resp);
    }

    public static function failedResponse($statusDescription){
        $resp = [];
        $resp['statusCode'] = AppConstants::$STATUS_CODE_FAILED;
        $resp['statusDescription'] = $statusDescription;
        return json_encode($resp);
    }

}