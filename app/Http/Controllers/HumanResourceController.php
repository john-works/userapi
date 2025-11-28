<?php

namespace App\Http\Controllers;

use app\Helpers\AppConstants;
use app\Helpers\ConstAppraisalStatus;
use app\Helpers\DataLoader;
use app\Helpers\Security;
use app\Models\ApiAppraisalReq;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HumanResourceController extends Controller
{

    public function __construct(){
        /**in this case the middleware named auth is applied
        to every single function within this controller
         */
        $this->middleware('users.hr');
    }

    public function index($msg = null, $isError = false){

        try{

            //we attempt to get the users
            $baseResp = DataLoader::allUsers();

            if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                $error =$baseResp->statusDescription;
                return $this->getHumanResourceView([],[], $error,true);
            }

            $users = $baseResp->result;


            //we now attempt to get the appraisals completed
            $req = new ApiAppraisalReq();
            $req->token = Cookie::get(Security::$COOKIE_TOKEN);;
            $req->workflowRole = AppConstants::WORK_FLOW_ROLE_ALL;
            $req->status = ConstAppraisalStatus::COMPLETED_SUCCESSFULLY;

            $baseRespNext = DataLoader::getUserAppraisals($req);

            if($baseRespNext->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->getHumanResourceView($users,[], $baseRespNext->statusDescription, true);
            }

            $appraisals =  $baseRespNext->result;


            return $this->getHumanResourceView($users, $appraisals,$msg,$isError);

        }catch (\Exception $exception){
            return $this->getHumanResourceView([], [], AppConstants::generalError($exception->getMessage()),true);
        }

    }

    private function getHumanResourceView($users = [], $appraisals = [], $msg = null, $isError = null) {

        $active_module = AppConstants::$ACTIVE_MOD_HUMAN_RESOURCE;
        return view('hr.hr-page', compact('active_module','users','appraisals','msg','isError'));

    }

    public function getUserContractsView($username){

        try{

            $user = session(Security::$SESSION_USER);
            if($user == null){
                return AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN;
            }

            $baseResp = DataLoader::getUsersContracts($username);

            if($baseResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $baseResp->statusDescription;
            }

            $contracts = $baseResp->result;
            $author = $user;
            return view('hr.modal-hr-contract-history-content', compact('author','username','contracts'));

        }catch (\Exception $exception){
            return AppConstants::generalError($exception->getMessage());
        }

    }

    public function saveUserContractAjax(Request $request){

        try{

            //check if request us ajax
            if(!$request->ajax()){
                return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
            }

            //validate request
            $validator = Validator::make($request->all(), [
                'username' => 'required|min:2',
                'contract_start_date' => 'required|date',
                'contract_expiry_date' => 'required|date',
                'created_by' => 'required|min:2',
            ]);

            //failed validation
            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            //send request to API
            $data =
                [
                    'username' => $request['username'],
                    'contract_reference' => $request['contract_reference'],
                    'start_date' => $request['contract_start_date'],
                    'expiry_date' => $request['contract_expiry_date'],
                    'created_by' => $request['created_by'],
                ];

            $resp = DataLoader::saveUserContract($data);

            // Error occurred on sending the request
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return response()->json(['error' => [$resp->statusDescription]]);
            }

            $successMessage = "CONTRACT SUCCESSFULLY SAVED";
            return response()->json(['success' => $successMessage]);

        }catch (\Exception $exception){
            return response()->json(['error' => [AppConstants::generalError($exception->getMessage())]]);
        }

    }

    public function updateUserContractAjax(Request $request){

        try{

            //check if request us ajax
            if(!$request->ajax()){
                return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
            }

            //validate request
            $validator = Validator::make($request->all(), [
                'username' => 'required|min:2',
                'contract_start_date' => 'required|date',
                'contract_expiry_date' => 'required|date',
                'record_id' => 'required|numeric',
            ]);

            //failed validation
            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            //send request to API
            $data =
                [
                    'username' => $request['username'],
                    'contract_reference' => $request['contract_reference'],
                    'start_date' => $request['contract_start_date'],
                    'expiry_date' => $request['contract_expiry_date'],
                    'record_id' => $request['record_id'],
                ];

            $identifier = $request['record_id'];
            $resp = DataLoader::saveUserContract($data, true, $identifier);

            // Error occurred on sending the request
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return response()->json(['error' => [$resp->statusDescription]]);
            }

            $successMessage = "CONTRACT DETAILS SUCCESSFULLY UPDATED";
            return response()->json(['success' => $successMessage]);

        }catch (\Exception $exception){
            return response()->json(['error' => [AppConstants::generalError($exception->getMessage())]]);
        }

    }


    public function deleteUserContract(Request $request){

        try{

            $identifier = $request['id'];
            $user = session(Security::$SESSION_USER);

            /*
             * We failed to get the logged in user
             * */
            if($user == null){
                return $this->index(AppConstants::$MSG_SESSION_TIMEOUT_LOGIN_AGAIN, true);
            }

            /*
             * Send request to the API
             * */
            $resp = DataLoader::deleteUserContract([],$identifier);

            /*
             * Error occurred on sending the request
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->index($resp->statusDescription, true);
            }

            /*
             * Operation was successful at the server side
             * */
            $successMessage = "CONTRACT DETAILS SUCCESSFULLY DELETED";
            return $this->index($successMessage);


        }catch (\Exception $exception){

            $errorMessage = "Failed To Delete Contract Details With Error. ".$exception->getMessage();
            return $this->index($errorMessage,true);

        }


    }

}
