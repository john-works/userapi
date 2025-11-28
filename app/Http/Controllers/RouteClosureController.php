<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Facades\App\Facades\AppUsageTracker;

class RouteClosureController extends Controller
{
    public function user_api (Request $request) {
        return $request->user();
    }

    public function login (){
        return redirect(route('login'));
    }

    public function test (){
        return \view('test');
    }

    public function important_contacts(){
        $track = AppUsageTracker::track('User Management','Login Portal','Staff Extensions','Staff Extensions');
        return \view('important-contacts');
    }
}
