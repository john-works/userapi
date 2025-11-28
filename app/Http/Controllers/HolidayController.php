<?php

namespace App\Http\Controllers;

use app\Helpers\Security;
use app\Helpers\ApiHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HolidayController extends Controller
{
    public function index()
    {
        return view('holidays.index');
    }
    public function getRange(Request $request){
        $token = Cookie::get(Security::$COOKIE_TOKEN);
        $data = $request->all();
        $action = endpoint('PUBLIC_HOLIDAYS_IN_RANGE');
        $baseUlr = endpoint('BASE_URL_LEAVE_MANAGEMENT_API');
        $resp = ApiHandler::makePostRequest($action,$data, true, $token,$baseUlr);
        return json_encode($resp);
    }
    public function getYear(Request $request){
        $token = Cookie::get(Security::$COOKIE_TOKEN);
        $data = $request->all();
        $action = endpoint('PUBLIC_HOLIDAYS_IN_YEAR');
        $baseUlr = endpoint('BASE_URL_LEAVE_MANAGEMENT_API');
        $resp = ApiHandler::makePostRequest($action,$data, true, $token,$baseUlr);
        return json_encode($resp);
    }
}
