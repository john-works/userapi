<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 2/6/2018
 * Time: 15:53
 */


namespace app\Helpers;


use App\Appraisal;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class Security {

    public static $COOKIE_TOKEN = 'token';
    public static $COOKIE_TOKEN_EXPIRY_MINUTES = 60;
    public static $SESSION_USER = 'user';
    public static $SESSION_USERS = 'staff';
    public static $SESSION_USER_RIGHTS = 'access_rights';
    public static $SESSION_UM_USERS = 'users';
    public static $SESSION_TEMP_USER = 'temp_user';
    public static $SESSION_REFERRAL_URL_TO_APP = 'referral_url_to_app';
    public static $SESSION_REFERRAL_URL_TO_LINK = 'referral_url_to_link';
    public static $SESSION_REFERRAL_URL_PARAMS = 'referral_url_params';
    public static $SESSION_USER_ACCESS_TOKEN = 'access_token';
    public static $SESSION_APPRAISALS_OWNED = 'APPRAISALS_OWNED';
    public static $SESSION_APPRAISALS_ASSIGNED = 'APPRAISALS_ASSIGNED';
    public static $SESSION_USER_LEVEL = 'level';
    public static $SESSION_ENTITIES = 'entities';
    public static $SESSION_VEHICLES = 'vehicles';
    public static function randomPassword($length = 6){
        return str_random($length);
    }

    public static function createDocumentName($surname, $other_name) {

        $date = Carbon::now()->format(AppConstants::dateFormat);
        return $surname.'_'.$other_name.'_Staff_Appraisal_Form_'.$date."_".(new DateTime())->getTimestamp().".pdf";

    }

    public static function getCreateReference() {

        $reference = self::randomPassword(15);
        $appraisal = Appraisal::where('reference','=',$reference)->first();

        return $appraisal == null ? $reference : self::getCreateReference();

    }

    public static function setCookie(Request $request, $cookieName, $cookieValue){



        $minutes = 1;
        /*$response = new Response('Set Cookie');

        $response->withCookie(cookie($cookieName, $cookieValue, $minutes));
        return $response;*/

        Cookie::queue(Cookie::make($cookieName, $cookieValue, $minutes));


    }

    public static function getCookie(Request $request, $cookieName){

        $value = $request->cookie($cookieName);
        return $value;

    }

    public static function dtEncrypt($plainData){

        return encrypt($plainData);

    }


    public static function dtDecrypt($encryptedValue){

        try{

            return decrypt($encryptedValue);

        }catch (\Exception $exception){
            return $encryptedValue;
        }

    }


}