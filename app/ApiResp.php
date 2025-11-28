<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 5/16/2019
 * Time: 00:54
 */


namespace app;


class ApiResp {

    public $statusCode = "";
    public $statusDescription = "";
    public $result;
    public $trustedDeviceCookieToForget;

    public static function success($result, $desc = null)
    {
        $resp = new ApiResp();
        $resp->statusCode = "0";
        $resp->statusDescription = !isset($desc)? "Success":$desc;
        $resp->result =  $result;
        return $resp;
    }

    public static function failure($error)
    {
        $resp = new ApiResp();
        $resp->statusCode = "1";
        $resp->statusDescription = $error;
        $resp->result =  $error;
        return $resp;
    }

}