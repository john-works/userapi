<?php

use App\Helpers\Security;
use App\Helpers\EndPoints;
use App\Helpers\ApiHandler;
use App\User;
use App\Http\Controllers\ApiController;

// change date to database date format
if (! function_exists ('db_date_format')) {
    function db_date_format($date)
    {
        return date("Y-m-d", strtotime($date));
    }
}

if (!function_exists('get_user_friendly_date')) {
    function get_user_friendly_date($date)
    {
        if (!$date  || $date == "") {
            return '';
        }
        return date("M d Y", strtotime($date));
    }
}
if (! function_exists ('user_full_name')) {
    function user_full_name($user){
        return !isset($user) ? "" : $user->first_name .' '.$user->last_name;
    }
}

if (! function_exists ('getEmployee')) {
    function getEmployee($username){
        
        if(session(Security::$SESSION_UM_USERS) == null){
            //attempt to get the users from user management

            $users = ApiController::getPpdaUsers()->data;
           
        }else{
            $users = session(Security::$SESSION_UM_USERS);
        }

        if(!isset($users)) return null;
        foreach ($users as $user){
            if($user->username == $username){
                return $user;
            }
        }

        return null;

    }
}
if (! function_exists ('get_dept_names')) {
    function get_dept_names(){
        return array(
            'Corporate',
            'Legal and Investigations',
            'Performance Monitoring',
            'Capacity Building',
            'Operations',
        );
    }
}

if (! function_exists ('addSpaceInfrontOfCapsLetterInWord')) {
    function addSpaceInfrontOfCapsLetterInWord($value){
        return preg_replace('/(?<! )(?<!^)[A-Z]/',' $0', $value);
    }
}

if (!function_exists('get_user_friendly_date_for_email')) {
    function get_user_friendly_date_for_email($date)
    {
        if (!$date || $date == "") {
            return '';
        }
        return date("F d Y", strtotime($date));
    }
}

if (!function_exists('get_user_friendly_date_time')) {
    function get_user_friendly_date_time($date)
    {
        if (!$date  || $date == "") {
            return '';
        }
        return date("M d Y, g:i a", strtotime($date));
    }
}

if (!function_exists('get_user_friendly_date_time_with_day')) {
    function get_user_friendly_date_time_with_day($date)
    {
        if (!$date  || $date == "") {
            return '';
        }
        return date("D M d Y, g:i a", strtotime($date));
    }
}

if (!function_exists('get_edms_html_form_date')) {
    function get_edms_html_form_date($date)
    {
        if (!$date || $date == "") {
            return '';
        }
        return date('Y-m-d', strtotime($date));
    }
}

if (!function_exists('getFirstValidationError')) {
    function getFirstValidationError($validator, array $fieldsValidated) {

        //get the errors object
        $errors = $validator->errors();

        //return the first error you find
        foreach ($fieldsValidated as $field){

            if ($errors->has($field)) {
                return $errors->first($field);
            }
        }

        //this weird no error returned so check your $fieldsValidated list
        return "No error field found " . json_encode($errors);

    }

}
if (! function_exists ('get_system_modules')) {
    function get_system_modules(){
        $modules = [
            MODULE_LOGIN_PAGE_MANAGEMENT_DASHBORAD=>[],
            MODULE_ACTION_LOGS=>[
                BOARD_ACTION_LOGS,
                EXCO_ACTION_LOGS,
                ALL_ACTION_LOGS
            ],
            MODULE_CALENDAR_ADMIN => [
                BOARD_CALENDAR,
                DEPARTMENT_CALENDAR,
                EXCO_CALENDAR,
                TRAINING_ROOM_CALENDAR
            ],
            MODULE_ADMIN => [],
            MODULE_MASTER_DATA=>[]             
        ];
        return $modules;
    }
}

if (! function_exists ('authenticate_module_access')) {
    function authenticate_module_access($module, $rights){
        foreach ( $rights as $right){
            if($right->area == $module && $right->access_right == ACCESS_RIGHT_GRANT_ACCESS){
                return true;
            }
        }
        return false;
    }
}

if (! function_exists ('authenticate_module_subsection_access')) {
    function authenticate_module_subsection_access($module,$sub_module, $rights){
        foreach ( $rights as $right){
            $area = $module.':::'.$sub_module;
            if($right->area == $area && $right->access_right == ACCESS_RIGHT_GRANT_ACCESS){
                return true;
            }
        }
        return false;
    }
}

if (! function_exists ('clear_spaces')) {
    function clear_spaces($value){
        return str_replace(' ','',$value);
    }
}

if (!function_exists('get_json_obj_from_array')) {
    function get_json_obj_from_array($array, $key)
    {
        return isset($array[$key]) ? json_decode(json_encode($array[$key]),false) : null;
    }
}

if (!function_exists('redirectBackWithSessionError')) {
    function redirectBackWithSessionError($error, $routeName = null)
    {
        \session()->flash('errorMsg', $error);
        if ($routeName == null) {
            return redirect()->back();
        }
        return \redirect(route($routeName));
    }
}

if (!function_exists('redirectBackWithSessionSuccess')) {
    function redirectBackWithSessionSuccess($msg, $routeName = null)
    {
        \session()->flash('successMsg', $msg);
        if ($routeName == null) {
            return redirect()->back();
        }
        return \redirect(route($routeName));
    }
}

if (!function_exists('getAuthUser')) {
    function getAuthUser()
    {
        return session('user');
    }
}

if (!function_exists('trusted_device')) {
    function trusted_device($username, $deviceId, $deviceName,$browser, $dateTimeCreated,$expiry = null)
    {

        $question = $username.$deviceName.$browser.$dateTimeCreated;
        $question = bcrypt($question);

        $data = [
            'username' => $username,
            'deviceId' => $deviceId,
            'deviceName' => $deviceName,
            'browser' => $browser,
            'dateTimeCreated' => $dateTimeCreated,
            'question' => $question,
            'expiry' => $expiry,
        ];

        //return it as an object
        return json_encode($data);

    }
}

if(!function_exists('get_session_value')){
    function get_session_value($key){
        // decrypt(session('access_rights'))
        return decrypt(session($key));
    }
}  

if(!function_exists('endpoint')){
    function endpoint($key){
        return config('endpoint.'.$key) ?? EndPoints::$$key;
    }
} 

if(!function_exists('endpoint')){
    function endpoint($key){
        return config('endpoint.'.$key) ?? EndPoints::$$key;
    }
}

if (!function_exists('ppda_entities')) {
    function ppda_entities()
    {
        if(session(Security::$SESSION_ENTITIES)){
            return session(Security::$SESSION_ENTITIES);
        }else{
            $deptsResp = ApiHandler::getEntitiesFromEmis();
            if($deptsResp->statusCode == CONST_STATUS_CODE_SUCCESS){
                $entities = [];
                for($i = 0; $i < count($deptsResp->result); $i++){
                    $entities[$i]['id'] = $deptsResp->result[$i]->id;
                    $entities[$i]['entity_name'] = $deptsResp->result[$i]->entity_name;
                    $entities[$i]['proc_code'] = $deptsResp->result[$i]->proc_code;
                }
                session([Security::$SESSION_ENTITIES => $entities]);
            }
            return $deptsResp->statusCode == CONST_STATUS_CODE_SUCCESS ?  $deptsResp->result : [];
        }
    }
}
if (!function_exists('ppda_vehicles')) {
    function ppda_vehicles()
    {
        if(session(Security::$SESSION_VEHICLES)){
            return session(Security::$SESSION_VEHICLES);
        }else{
            $vehiclesResp = ApiHandler::getVehicles();
            if($vehiclesResp->statusCode == CONST_STATUS_CODE_SUCCESS){
                $vehicles = [];
                for($i = 0; $i < count($vehiclesResp->result); $i++){
                    $vehicles[$i]['id'] = $vehiclesResp->result[$i]->id;
                    $vehicles[$i]['number_plate'] = $vehiclesResp->result[$i]->number_plate;
                }
                session([Security::$SESSION_VEHICLES => $vehicles]);
            }
            return $vehiclesResp->statusCode == CONST_STATUS_CODE_SUCCESS ?  $vehiclesResp->result : [];
        }
    }
}
if (!function_exists('ppda_users')) {
    function ppda_users()
    {
        if(session(Security::$SESSION_USERS)){
            return session(Security::$SESSION_USERS);
        }else{
            $usersResp = ApiHandler::getUSERs();
            if($usersResp->statusCode == CONST_STATUS_CODE_SUCCESS){
                $users = [];
                for($i = 0; $i < count($usersResp->data); $i++){
                    $users[$i]['username'] = $usersResp->data[$i]->username;
                    $users[$i]['first_name'] = $usersResp->data[$i]->first_name;
                    $users[$i]['last_name'] = $usersResp->data[$i]->last_name;
                    $users[$i]['fullName'] = $usersResp->data[$i]->first_name.' '.$usersResp->data[$i]->last_name;
                }
                session([Security::$SESSION_USERS => $users]);
            }
            return $usersResp->statusCode == CONST_STATUS_CODE_SUCCESS ?  $usersResp->data : [];
        }
    }
}
if (!function_exists('current_users')) {
    function current_users()
    {
        $usersResp = ApiHandler::getCurrentUsers();
        if($usersResp->statusCode == CONST_STATUS_CODE_SUCCESS){
            $users_result = json_decode(json_encode($usersResp->data), true);
            $users = $users_result['data'];
            $users = array_filter($users, function($user){
                return $user['first_name'] != 'Test';
            });
        }
        return $users;
    }
}
if (!function_exists('getFullname')) {
    function getFullname($username)
    {
        $user = User::where('username', $username)->first();
        return $user->first_name . ' ' . $user->last_name;
    }
}
if (! function_exists ('form_val')) {
    function form_val($record, $fieldName, $formatToNo = false){
        return isset($record)?($formatToNo ? number_format(@$record->$fieldName):@$record->$fieldName):'';
    }
}
if (! function_exists ('form_select_option')) {
    function form_select_option($record, $fieldName,$optionValue){
        if(!isset($record) || $record->$fieldName != $optionValue){
            return '';
        }else{
            return 'selected';
        }
    }
}
if(!function_exists ('get_users')){
    function get_users($except = []){
        if(session('ppda_users') != null){
            $ppdaUsers = session('ppda_users');
        }elseif(session('users') != null){
            $ppdaUsers = session('users');
        }else{
            $ppdaUsers = ppda_users();
        }
        $users = [];
        foreach($ppdaUsers as $user){
            //change $user array to object
            $user = json_decode(json_encode($user));
            if(in_array($user->username, $except)) continue;
            $users[$user->username] = $user->first_name .' '.$user->last_name;
        }
        return $users;
    }
}
if (! function_exists ('getUserFullName')) {
    function getUserFullName($user){

        return isset($user) ? $user->first_name . ' ' . $user->last_name : '';

    }
}