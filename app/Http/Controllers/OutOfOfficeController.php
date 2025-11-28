<?php

namespace App\Http\Controllers;

use app\ApiResp;
use app\Helpers\ApiHandler;
use app\Helpers\AppConstants;
use app\Helpers\DataLoader;
use app\Helpers\EndPoints;
use app\Helpers\Security;
use Illuminate\Http\Request;

class OutOfOfficeController extends Controller
{

    public function outOfOfficeIndex(){

        $user = session(Security::$SESSION_USER);
        $username = $user->username;

        $apiResp = ApiHandler::makeGetRequest('/out-of-offices/delegated-by',false, false,$username, endpoint('BASE_URL'));
        if($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return json_encode(ApiResp::failure($apiResp->statusDescription));
        }

        $resp = json_decode($apiResp->result);
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return json_encode(ApiResp::failure($resp->statusDescription));
        }
        $outOfOffices = $resp->data;

        $data = array(
            'outOfOffices' => $outOfOffices,
        );

        return view('out-of-office.out_of_office_index')->with($data);

    }

    public function outOfOfficeCreate($enableUserSelection = 0){

        $user = session(Security::$SESSION_USER);
        $username = $user->username;

        $apiResp = ApiHandler::makeGetRequest('/users',false, false,null, endpoint('BASE_URL'));
        if($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return json_encode(ApiResp::failure($apiResp->statusDescription));
        }

        $resp = json_decode($apiResp->result);
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return json_encode(ApiResp::failure($resp->statusDescription));
        }
        $users = $resp->data;

        $data = array(
            'username' => $username,
            'enableUserSelection' => $enableUserSelection,
            'users' => $users,
        );

        return view('out-of-office.out_of_office_create')->with($data);

    }

    public function outOfOfficeStore(Request $request){
        try{

            $data = $request->all();
            unset($data['_token']);

            $apiResp = ApiHandler::makePostRequest('/out-of-office',$data,false, false,endpoint('BASE_URL'));

            if($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return json_encode(ApiResp::failure($apiResp->statusDescription));
            }

            $resp = json_decode($apiResp->result);
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

                if($resp->statusDescription != STATUS_DESC_PERSON_DELEGATED_TO_HAS_OVERLAPPING_OUT_OF_OFFICES){
                    return json_encode(ApiResp::failure($resp->statusDescription));
                }

                $overlapOutOfOffices = $resp->data;
                $data = array('outOfOffices' => $overlapOutOfOffices);
                $outOfOfficesHtml = count($overlapOutOfOffices) == 0 ? null :
                    view('out-of-office.users_with_out_of_office')->with($data)->render();

                return json_encode(ApiResp::failure($outOfOfficesHtml));
            }

            $msg = "Out of office successfully saved";
            $apiResp = ApiResp::success($msg, $msg);
            return json_encode($apiResp);

        }catch (\Exception $exception){
            $apiResp = ApiResp::failure($exception->getMessage());
            return json_encode($apiResp);
        }
    }

    public function outOfOfficeRemove($outOfOffice){

        try{

            $outOfOfficeId = decrypt($outOfOffice);

            $apiResp = ApiHandler::makeGetRequest('/out-of-office/delete',false, false,$outOfOfficeId, endpoint('BASE_URL'));
            if($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return json_encode(ApiResp::failure($apiResp->statusDescription));
            }

            $resp = json_decode($apiResp->result);
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return json_encode(ApiResp::failure($resp->statusDescription));
            }

            $msg = "Out of Office successfully removed";
            return json_encode(ApiResp::success($msg, $msg));

        }catch (\Exception $exception){
            $apiResp = ApiResp::failure($exception->getMessage());
            return json_encode($apiResp);
        }

    }

    public function outOfOfficeListAssignedByMe(){

        $user = session(Security::$SESSION_USER);
        $username = $user->username;

        $apiResp = ApiHandler::makeGetRequest('/out-of-offices/delegated-by',false, false,$username, endpoint('BASE_URL'));
        if($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return json_encode(ApiResp::failure($apiResp->statusDescription));
        }

        $resp = json_decode($apiResp->result);
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return json_encode(ApiResp::failure($resp->statusDescription));
        }
        $outOfOffices = $resp->data;

        $result = [];
        foreach ($outOfOffices as $outOfOffice){
            $outOfOffice->actions = view('actions.action_out_of_office', compact('outOfOffice'))->render();
            $outOfOffice->from_date_fmtd = get_user_friendly_date_time($outOfOffice->from);
            $outOfOffice->to_date_fmtd = get_user_friendly_date_time($outOfOffice->to);
            $result[] = $outOfOffice;
        }

        return datatables(collect($result))
            ->rawColumns(['actions'])
            ->toJson();

    }

    public function outOfOfficeListAssignedTo(){

        $user = session(Security::$SESSION_USER);
        $username = $user->username;

        $apiResp = ApiHandler::makeGetRequest('/out-of-offices/delegated-to',false, false,$username, endpoint('BASE_URL'));
        if($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return json_encode(ApiResp::failure($apiResp->statusDescription));
        }

        $resp = json_decode($apiResp->result);
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return json_encode(ApiResp::failure($resp->statusDescription));
        }
        $outOfOffices = $resp->data;

        $result = [];
        foreach ($outOfOffices as $outOfOffice){
//            $outOfOffice->actions = view('actions.action_out_of_office', compact('outOfOffice'))->render();
            $outOfOffice->from_date_fmtd = get_user_friendly_date_time($outOfOffice->from);
            $outOfOffice->to_date_fmtd = get_user_friendly_date_time($outOfOffice->to);
            $result[] = $outOfOffice;
        }

        return datatables(collect($result))
            ->rawColumns(['actions'])
            ->toJson();

    }


    public function outOfOfficeAdminIndex(){
        $data = array();
        return view('out-of-office.out_of_office_admin_index')->with($data);
    }

    public function outOfOfficeAdminList(){

        $outOfficeStatus = 'active'; //'all'
        $apiResp = ApiHandler::makeGetRequest('/out-of-offices',false, false,$outOfficeStatus, endpoint('BASE_URL'));
        if($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return json_encode(ApiResp::failure($apiResp->statusDescription));
        }

        $resp = json_decode($apiResp->result);
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return json_encode(ApiResp::failure($resp->statusDescription));
        }
        $outOfOffices = $resp->data;

        $result = [];
        foreach ($outOfOffices as $outOfOffice){
            $outOfOffice->actions = view('actions.action_out_of_office', compact('outOfOffice'))->render();
            $outOfOffice->from_date_fmtd = get_user_friendly_date_time($outOfOffice->from);
            $outOfOffice->to_date_fmtd = get_user_friendly_date_time($outOfOffice->to);
            $result[] = $outOfOffice;
        }

        return datatables(collect($result))
            ->rawColumns(['actions'])
            ->toJson();

    }

    public function outOfOfficeAdminHistory(){
        $data = array();
        return view('out-of-office.out_of_office_admin_history')->with($data);
    }

    public function outOfOfficeAdminHistoryList(){

        $outOfficeStatus = 'all';
        $apiResp = ApiHandler::makeGetRequest('/out-of-offices',false, false,$outOfficeStatus, endpoint('BASE_URL'));
        if($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return json_encode(ApiResp::failure($apiResp->statusDescription));
        }

        $resp = json_decode($apiResp->result);
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return json_encode(ApiResp::failure($resp->statusDescription));
        }
        $outOfOffices = $resp->data;

        $result = [];
        foreach ($outOfOffices as $outOfOffice){
            $outOfOffice->actions = view('actions.action_out_of_office', compact('outOfOffice'))->render();
            $outOfOffice->from_date_fmtd = get_user_friendly_date_time($outOfOffice->from);
            $outOfOffice->to_date_fmtd = get_user_friendly_date_time($outOfOffice->to);
            $result[] = $outOfOffice;
        }

        return datatables(collect($result))
            ->rawColumns(['actions'])
            ->toJson();

    }

    public function outOfOfficeOwnerHistoryIndex(){
        return view('out-of-office.out_of_office_owner_history');
    }

    public function outOfOfficeOwnerHistoryList($type){

        //possible values for $type are by_me,  to_me, to_me_and_by_me

        $user = session(Security::$SESSION_USER);
        $username = $user->username;
        $identifier = $username .'/'. $type;

        //action, /out-of-offices/history/{username}/{type}
        $apiResp = ApiHandler::makeGetRequest('/out-of-offices/history',false, false,$identifier, endpoint('BASE_URL'));
        if($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return json_encode(ApiResp::failure($apiResp->statusDescription));
        }

        $resp = json_decode($apiResp->result);
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return json_encode(ApiResp::failure($resp->statusDescription));
        }
        $outOfOffices = $resp->data;

        $result = [];
        foreach ($outOfOffices as $outOfOffice){
            $outOfOffice->actions = view('actions.action_out_of_office', compact('outOfOffice'))->render();
            $outOfOffice->from_date_fmtd = get_user_friendly_date_time($outOfOffice->from);
            $outOfOffice->to_date_fmtd = get_user_friendly_date_time($outOfOffice->to);
            $result[] = $outOfOffice;
        }

        return datatables(collect($result))
            ->rawColumns(['actions'])
            ->toJson();

    }


}
