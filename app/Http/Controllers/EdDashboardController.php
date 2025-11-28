<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facades\App\Facades\AppUsageTracker;

class EdDashboardController extends Controller
{
    public function index(){
        $td_service = new TrustedDevicesController();
        $resp = $td_service->getTrustedDeviceInfo();
        if(isset($resp['trustedDevice'])){
            $user =$resp['trustedDevice']->username;
            $track = AppUsageTracker::track('User Management','Login Portal','ED Dashboard','ED Dashboard', null, $user);
        }else{
            //get ed from usermanagement  go to userapi and modify OrganizationController@getEd to get ed from user table
            $user = 'bturamye@ppda.go.ug';
        }
        return view('ed-dashboards.index',compact('user'));
    }
}
