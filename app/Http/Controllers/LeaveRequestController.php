<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function moreLeave($username)
    {
        return view('request_details.leave')->with('username', $username);
    }
    public function moreAppraisal($username)
    {
        return view('request_details.appraisal')->with('username', $username);
    }
}
