<?php

namespace App\Http\Controllers;
use App\Department;
use App\ActionLogType;
use App\ActionLogAdmin;
use app\Helpers\Security;
use app\Helpers\EndPoints;
use app\Helpers\ApiHandler;
use Illuminate\Http\Request;
use app\Helpers\AppConstants;
use app\Helpers\DataFormatter;
use Illuminate\Support\Facades\Cookie;
use Freshbitsweb\Laratables\Laratables;

class ActionLogTypeController extends Controller
{
    public function index()
    {
        $data = [
            'section' => 'action_log_types',
            'level'=> session(Security::$SESSION_USER_LEVEL)
        ];            

        return view('master_data.action_log_types.index')->with($data);
    }
    public function list(){
        return Laratables::recordsOf(ActionLogType::class);
    }
    public function adminList($action_log_type){
        return Laratables::recordsOf(ActionLogAdmin::class, function ($query) use($action_log_type) {
            return $query->where('action_log_type_id', $action_log_type)->orderBy('id','desc');
        });
    }
    public function show(ActionLogType $action_log_type){
        return view('master_data.action_log_types.show')->with('action_log_type', $action_log_type);
    }
    public function create(ActionLogType $action_log_type){
        $token = Cookie::get(Security::$COOKIE_TOKEN);
        $respUsers = ApiHandler::makeGetRequest(endpoint('USERS_ALL'), true, $token);
        if($respUsers->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return $respUsers->statusDescription;
        }
        $apiRespUsers = json_decode($respUsers->result, true);
        $statusCodeUser = $apiRespUsers['statusCode'];
        $statusDescriptionUser = $apiRespUsers['statusDescription'];

        if($statusCodeUser != AppConstants::$STATUS_CODE_SUCCESS){
            return $statusDescriptionUser;
        }


        $users = DataFormatter::formatUsers($apiRespUsers['data']);
        $this->_users = $users;
        $data = [
            'action_log_type_id' => $action_log_type->id,
            'users' => $users,
        ];
        return view('master_data.action_log_types.create')->with($data);
    }
    public function store(Request $request){
        $request->validate([
            'action_log_type_id' => 'required',
            'user_id' => 'required',
        ]);
        $action_log_type = new ActionLogAdmin;
        $action_log_type->action_log_type_id = $request->action_log_type_id;
        $action_log_type->user_id = $request->user_id;
        $action_log_type->save();
        return "Action Log Admin created successfully";
    }
}
