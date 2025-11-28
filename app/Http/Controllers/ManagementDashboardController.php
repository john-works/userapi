<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facades\App\Facades\AppUsageTracker;

class ManagementDashboardController extends Controller
{
    public function index($is_admin){
        $is_admin = isset($is_admin)? $is_admin:false;
        $td_service = new TrustedDevicesController();
        $resp = $td_service->getTrustedDeviceInfo();
        if(isset($resp['trustedDevice'])){
            $user =$resp['trustedDevice']->username;
            $track = AppUsageTracker::track('User Management','Login Portal','Management Dashboard','Management Dashboard', null, $user);
        }
        return view('management-dashboards.index', compact('is_admin'));
    }

    public function pm_audit_field_activities($extra){
        //dd($extra);
        //return var requisition_action_url = "{{ endpoint('EMIS_GET_PENDING_ACTIONS') }}"+user


    }
}
