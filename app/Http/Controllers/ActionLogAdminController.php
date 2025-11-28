<?php

namespace App\Http\Controllers;
use App\Department;
use App\ActionLogAdmin;
use app\Helpers\Security;
use app\Helpers\EndPoints;
use app\Helpers\ApiHandler;
use Illuminate\Http\Request;
use app\Helpers\AppConstants;
use app\Helpers\DataFormatter;
use Illuminate\Support\Facades\Cookie;
use Freshbitsweb\Laratables\Laratables;

class ActionLogAdminController extends Controller
{
    public function show(Department $department){
        return view('master_data.action_log_admins.show')->with('department', $department);
    }
    public function create(Department $department){
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
            'department_id' => $department->id,
            'users' => $users,
        ];
        return view('master_data.action_log_admins.create')->with($data);
    }
    public function store(Request $request){
        $request->validate([
            'department_id' => 'required',
            'user_id' => 'required',
        ]);
        $action_log_admin = new ActionLogAdmin;
        $action_log_admin->department_id = $request->department_id;
        $action_log_admin->user_id = $request->user_id;
        $action_log_admin->save();
        return "Action Log Admin created successfully";
    }

    public function list(){
        return Laratables::recordsOf(Department::class);
    }
    public function departmentList(Department $department){
        return Laratables::recordsOf(ActionLogAdmin::class, function ($query) use($department) {
            return $query->where('action_log_type_id', $department)->orderBy('id','desc');
        });
    }
    public function destroy(ActionLogAdmin $action_log_admin){
        try{
            $action_log_admin->delete();
            return redirectBackWithSessionSuccess("Action Log Admin successfully deleted");
        }
        catch(\Exception $e){
            return redirectBackWithSessionError('Cannot delete this Record .'.$e->getMessage());
        }
    }
}
