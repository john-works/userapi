<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index($username)
    {
        return view('tickets.index')->with('username', $username);
    }
    public function create($username)
    {
        $actual_name = getUserFullName(getEmployee($username));
        $users = ppda_users();
        $data =[
            'users' => $users ?? [],
            'username' => $username ?? '',
            'actual_name' => $actual_name ?? '',
        ];
        return view('tickets.create')->with($data);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'created_by' => 'required',
            'created_for' => 'required',
            'issue_details' => 'required',
        ]);
        $url = endpoint('STORES_CREATE_TICKET');

        $client = new Client([
            'headers' => ["content-type"=>"application/json", "Accept"=>"application/json"]
        ]);

        $response = $client->request("POST", $url, [
            'json'=>[
                "x-code"=>"&80@#74!@3$",
                "created_date"=>now(),
                "created_by"=>$data['created_by'],
                "created_for"=>$data['created_for'],
                "issue_details"=>$data['issue_details']
            ]
        ]);

        $result = json_decode($response->getBody());
        if($response->getStatusCode() == 200){
            $resp =[
                'statusCode'=>0,
                'message'=>'Ticket created successfully',
                'tickets'=>$result->tickets
            ];
            return json_encode($resp);
        }else{
            $resp =[ 'statusCode'=>1, 'message'=>'Ticket creation failed'];
            return json_encode($resp);
        }

    }
    public function reopen(Request $request)
    {
        $data = [
            'ticket_id' => $request->ticket_id,
            'created_by' => $request->ticket_created_by,
            'created_for' => $request->ticket_created_for,

        ];
        return view('tickets.reopen')->with($data);
    }
    public static function getIssueCategories(){

        $url = endpoint('STORES_GET_ISSUE_CATEGORIES');

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
