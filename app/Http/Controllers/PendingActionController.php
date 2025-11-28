<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facades\App\Facades\AppUsageTracker;

class PendingActionController extends Controller
{
    public function my_pending_actions(){
        $td_service = new TrustedDevicesController();
        $resp = $td_service->getTrustedDeviceInfo();
        if(isset($resp['trustedDevice'])){
            $user = $resp['trustedDevice']->username;
            $track = AppUsageTracker::track('User Management','Login Portal','My Pending Actions','My Pending Actions', null, $user);
            return view('pending-actions.my',compact('user'));
        }else{
            throw new \Exception('There is no trusted device set!');
        }
    }
}
