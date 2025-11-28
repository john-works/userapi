<?php

namespace App\Http\Controllers;
use App\User;
use App\Access;
use App\PortalUser;
use App\ZzztymothyLogger;
use Illuminate\Http\Request;
use app\Helpers\AppConstants;
use Freshbitsweb\Laratables\Laratables;

class AdminController extends Controller
{
    public function index(){
        $data = array(
            'menu_selected' => MENU_ITEM_ADMIN_USER_MANAGEMENT
        );
        return view('administration.users_index')->with($data);
    }
    public function create(){

        $ppdaUsers = ApiController::getPpdaUsers()->data;
        $existentUsers = PortalUser::get()->pluck('username')->toArray();

        //filter out those that already exist
        $users = [];
        foreach ($ppdaUsers as $ppdaUser){
            if(!in_array($ppdaUser->username, $existentUsers)){
                $users[] = $ppdaUser;
            }
        }

        $data = array(
            'users' => $users
        );
        return view('administration.users_create')->with($data);

    }
    public function edit(PortalUser $user){

        $employee = getEmployee($user->username);
        $users = [$employee];

        $data = array(
            'users' => $users,
            'user' => $user,
            'umUser' => $employee,
        );
        return view('administration.users_create')->with($data);

    }
    public function list(){
        return Laratables::recordsOf(PortalUser::class);
    }
    public function store(Request $request){
        try{
            $postedData = $request->all();
            //check if the user already exists
            $rights = Access::where('user_id', $request->fld_id)->get();
            if(count($rights) > 0){
                foreach (get_system_modules() as $module => $subModule){
                    //update the module rights
                    $moduleRightField = 'rights_' . clear_spaces($module);
                    if(array_key_exists($moduleRightField, $postedData)){
                        $right = Access::where('user_id', $request->fld_id)->where('area', $module)->first();
                        if($right){
                            $accessRight = $postedData[$moduleRightField];
                            $right->access_right = $accessRight;
                            $right->save();
                        }
                    }
                    //update the sub module rights
                    if($accessRight == ACCESS_RIGHT_GRANT_ACCESS && count($subModule) > 0){
                        foreach ($subModule as $sub){
                            $subModuleRightField = 'rights_' . clear_spaces($module).'_'.clear_spaces($sub);
                            if(array_key_exists($subModuleRightField, $postedData)){
                                $right = Access::where('user_id', $request->fld_id)->where('area', $module.':::'.$sub)->first();
                                if($right){
                                    $accessRightSubModule = $postedData[$subModuleRightField];
                                    $right->access_right = $accessRightSubModule;
                                    $right->save();
                                }
                            }
                        }
                    }
                }
            }else{
                $user = PortalUser::create([
                    'username' => $request->r_fld['username'],
                    'created_at' => now(),
                ]);

                foreach (get_system_modules() as $module => $subModule){
                    $moduleRightField = 'rights_' . clear_spaces($module);
                    //if the module is in the posted data
                    if(array_key_exists($moduleRightField, $postedData)){
                        $newRight = new Access();
                        $newRight->user_id = $user->id;
                        $newRight->area = $module;
                        $accessRight = $postedData[$moduleRightField];
                        $newRight->access_right = $accessRight;
                        $newRight->save();
    
                        //if granted and it has sub_modules, get the submodules
                        if($accessRight == ACCESS_RIGHT_GRANT_ACCESS && count($subModule) > 0){
    
                            foreach ($subModule as $sub){
    
                                $subModuleRightField = 'rights_' . clear_spaces($module).'_'.clear_spaces($sub);
                                if(array_key_exists($subModuleRightField, $postedData)){
                                    $newRightSubModule = new Access();
                                    $newRightSubModule->user_id = $user->id;
                                    $newRightSubModule->area = $module.':::'.$sub;
                                    $accessRightSubModule = $postedData[$subModuleRightField];
                                    $newRightSubModule->access_right = $accessRightSubModule;
                                    $newRightSubModule->save();
                                }
                            }
                        }
                    }
                }
            }
            $resp['statusCode'] = AppConstants::$STATUS_CODE_SUCCESS;
            $resp['statusDescription'] = "User Details successfully saved";
            return json_encode($resp);
        }catch (\Exception $exception){

            ZzztymothyLogger::logError($exception->getTraceAsString());

            $resp['statusCode'] = AppConstants::$STATUS_CODE_FAILED;
            $resp['statusDescription'] = $exception->getMessage();
            return json_encode($resp);
        }

    }
    
}