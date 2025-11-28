<?php

namespace App\Http\Controllers;

use App\CalendarType;
use App\CalendarUser;
use app\Helpers\Security;
use App\CalendarTypeAdmin;
use app\Helpers\ApiHandler;
use Illuminate\Http\Request;
use app\Helpers\AppConstants;
use app\Helpers\DataFormatter;
use Illuminate\Support\Facades\Cookie;
use Freshbitsweb\Laratables\Laratables;

class CalendarController extends Controller
{
    public function listCalendars(){
        $calendars = CalendarType::all();
        return response()->json($calendars);
    }
    public function createUsers(){
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
        
        $data = [
            'calendars' => CalendarType::all(),
            'users' => $users,
        ];
        return view('calendar.create_users')->with($data);
    }
    public function storeUsers(Request $request){
        $data = $request->validate([
            'calendar_id'=> 'required',
            'user_id'=> 'required',
            'can_edit'=> 'required',
            'created_by'=> 'required',
        ]);

        $calendarUser = CalendarUser::where(['calendar_id'=>$data['calendar_id'],'user_id'=>$data['user_id']])->first();
        if($calendarUser){
            return response()->json(['Calendar user already exists']);
        }else{

            CalendarUser::create([
                'calendar_id'=>$data['calendar_id'],
                'user_id'=>$data['user_id'],
                'can_edit'=>$data['can_edit']=='yes'?1:0,
                'created_by'=>$data['created_by'],
            ]);
            return response()->json(['Calendar user created successfully']);
        }
    }
    public function listUsers(){
        $calendarusers = CalendarUser::with(['user', 'calendar'])
        ->select('users.first_name AS first_name', 'users.last_name AS last_name','calendars.name as calendar_name', 'calendar_users.can_edit')
        ->join('users', 'calendar_users.user_id', '=', 'users.username')
        ->join('calendars', 'calendar_users.calendar_id', '=', 'calendars.id')
        ->get();
        return view('calendar.users',compact('calendarusers'));
    }
    public function list(){
        return Laratables::recordsOf(CalendarUser::class);
    }
    public function calendarTypesList(){
        return Laratables::recordsOf(CalendarType::class);
    }
    public function calendarTypesshow(CalendarType $calendar_type){
        return view('master_data.calendar_types.show')->with('calendar_type', $calendar_type);
    }
    public function calendarTypeAdminCreate(CalendarType $calendar_type){
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

        $data = [
            'users' => $users,
            'calendar_type' => $calendar_type,
        ];
        return view('master_data.calendar_types.create')->with($data);
    }
    public function calendarTypeAdminStore(Request $request){
        $data = $request->validate([
            'calendar_type_id'=> 'required',
            'user_id'=> 'required',
        ]);

        $admin = CalendarTypeAdmin::where(['calendar_type_id'=>$data['calendar_type_id']])->where(['user_id'=>$data['user_id']])->first();
        if($admin){
            return response()->json(['Calendar type Admin already exists']);
        }else{
            CalendarTypeAdmin::create([
                'calendar_type_id'=>$data['calendar_type_id'],
                'user_id'=>$data['user_id'],
            ]);
            return response()->json(['Calendar type admin created successfully']);
        }
    }
    public function adminList($calendar_type){
        return Laratables::recordsOf(CalendarTypeAdmin::class, function ($query) use($calendar_type) {
            return $query->where('calendar_type_id', $calendar_type)->orderBy('id','desc');
        });
    }
    public function calendarTypesAdminsRemove(CalendarTypeAdmin $calendar_type_admin){
        $calendar_type_admin->delete();
        return redirectBackWithSessionSuccess('Calendar type admin successfully deleted');

    }
    public function destroy($id){

        try {
            $calendarUser = CalendarUser::find($id);
            $calendarUser->delete();
            return redirectBackWithSessionSuccess('Calendar user successfully deleted');
        } catch (\Exception $e) {
            return redirectBackWithSessionError('An error occurred while deleting Calendar user');
        }
    }
    public function create(){
        return view('calendar.create');
    }
    //add calendar store
    public function store(Request $request){
        $data = $request->validate([
            'code'=> 'required',
            'name'=> 'required',
            'color'=> 'required',
            'background_color'=> 'required',
        ]);

        $calendar = CalendarType::where(['name'=>$data['name']])->first();
        if($calendar){
            return response()->json(['Calendar already exists']);
        }else{
            CalendarType::create([
                'department_code'=>$data['code'],
                'department_name'=>$data['name'],
                'color'=>$data['color'],
                'backgroundColor'=>$data['background_color'],
                'dragBackgroundColor'=>$data['background_color'],
                'borderColor'=>$data['background_color'],
            ]);
            return response()->json(['Calendar created successfully']);
        }
    }
}
