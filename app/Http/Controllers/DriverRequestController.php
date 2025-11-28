<?php

namespace App\Http\Controllers;

use app\ApiResp;
use app\Helpers\Security;
use app\Helpers\EndPoints;
use app\Helpers\ApiHandler;
use Illuminate\Http\Request;
use app\Helpers\AppConstants;
use app\Helpers\DataFormatter;
use Illuminate\Support\Facades\Cookie;
use Facades\App\Facades\AppUsageTracker;
use GuzzleHttp\Client;
class DriverRequestController extends Controller
{
    public function index($username)
    {
        return view('driver_requests.index')->with('username', $username);
    }
    public function create($username)
    {
        // $track = AppUsageTracker::track('User Management','Login Portal','Driver Requests','Driver Requests',null,$username);
        // $actual_name = getUserFullName(getEmployee($username));
        // $users = current_users();
        $data = [
            'username' => $username,
        ];
        
        return view('driver_requests.create')->with($data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "request_date" => 'required',
            "request_by" => 'required',
            "request_for" => 'required',
            "destination" => 'required',
            "drop_off_date" => 'required',
            'drop_off_time' => 'required',
            "pick_up_date" => 'nullable',
            'pick_up_time' => 'nullable',
        ]);
        return json_encode($data);
        
        $url = endpoint('FLEET_CREATE_DRIVER_REQUEST');
    
        $client = new Client([
            'headers' => ["content-type"=>"application/json", "Accept"=>"application/json"]
        ]);
    
        $response = $client->request("POST", $url, [
            'json'=>[
                "x-code"=>"&80@#74!@3$",
                "request_date"=>$data['request_date'],
                "request_by"=>$data['request_by'],
                "request_for"=>$data['request_for'],
                "destination"=>$data['destination'],
                "drop_off_date"=>$data['drop_off_date'],
                "drop_off_time"=>$data['drop_off_time'],
                "pick_up_date"=>$data['pick_up_date'],
                "pick_up_time"=>$data['pick_up_time'],
            ]
        ]);
        
        $result = json_decode($response->getBody());

        if($response->getStatusCode() == 200){
            $resp =[
                'statusCode'=>0,
                'message'=>'Driver Request created successfully',
                'driver_requests'=>$result->driver_requests
            ];
            return json_encode($resp);
        }else{
            $resp =[ 'statusCode'=>1, 'message'=>'Driver Request creation failed'];
            return json_encode($resp);
        }
    
    }
    public function createFuelIssue($username)
    {
        $track = AppUsageTracker::track('User Management','Login Portal','Driver Requests','Driver Requests',null,$username);
        $vehicles = ppda_vehicles();
        $users = current_users();

        $data = [
            'username' => $username ?? '',
            'vehicles' => $vehicles ?? [],
            'users' => $users ?? [],
        ];

        return view('fuel_issues.create')->with($data);
    }
    public function storeFuelIssue(Request $request){
        $request->validate([
            'data_source' => 'required',
            'created_by' => 'required',
            'issue_driver' => 'required',
            'fuel_type' => 'required',
            'issue_date' => 'required|date',
            'issue_amount' => 'required',
            'issue_vehicle_id' => 'required',
            'front_picture' => 'required|mimes:jpeg,jpg,png',
            'back_picture' => 'required|mimes:jpeg,jpg,png',
        ]);

        $frontPicture = $request->file('front_picture');
        $backPicture = $request->file('back_picture');
        $baseUrl = endpoint('BASE_URL_FLEET_API');
        $endPoint = endpoint('FUEL_ISSUE_STORE');
        $url = $baseUrl . $endPoint;

        $client = new Client();
        $front_final_name = date('YmdHis').sprintf('%02d', rand(0, 99)).'_front_image.'.$frontPicture->getClientOriginalExtension();
        $back_final_name = date('YmdHis').sprintf('%02d', rand(0, 99)).'_back_image.'.$backPicture->getClientOriginalExtension();
        $response = $client->post($url, [
            'multipart' => [
                [
                    'name' => 'front_picture',
                    'contents' => fopen($frontPicture->path(), 'r'),
                    'filename' => $front_final_name
                ],
                [
                    'name' => 'back_picture',
                    'contents' => fopen($backPicture->path(), 'r'),
                    'filename' => $back_final_name
                ],
                [
                    'name' => 'issue_driver',
                    'contents' => $request->input('issue_driver')
                ],
                [
                    'name' => 'ticket_issue_datetime',
                    'contents' => db_date_format($request->input('issue_date'))
                ],
                [
                    'name' => 'ticket_amount',
                    'contents' => $request->input('issue_amount')
                ],
                [
                    'name' => 'data_source',
                    'contents' => $request->input('data_source')
                ],
                [
                    'name' => 'captured_by',
                    'contents' => $request->input('created_by')
                ],
                [
                    'name' => 'fuel_request_category',
                    'contents' => 'Batch-WeeklyTopup'
                ]
                ,
                [
                    'name' => 'fuel_type',
                    'contents' => $request->input('fuel_type')
                ],
                [
                    'name' => 'issue_vehicle_id',
                    'contents' => $request->input('issue_vehicle_id')
                ]
            ],
        ]);
        return $response->getBody();
    }
    private function getVehicles(){

        $url = endpoint('VEHICLES_ALL');

        $client = new Client([
            'headers' => ["content-type"=>"application/json", "Accept"=>"application/json"]
        ]);

        $response = $client->request("GET", $url, [
            'json'=>["x-code"=>"&80@#74!@3$"]
        ]);

        if($response->getStatusCode() == 200){
            return json_decode($response->getBody());
        }else{
            $data = array(
                'data'=>[]
            );
            return json_decode(json_encode($data));
        }

    }
}
