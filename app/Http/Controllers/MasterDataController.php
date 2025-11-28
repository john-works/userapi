<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\Department;
use App\CalendarType;
use App\ActionLogType;
use App\Helpers\Security;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public $menu_selected = 'master_data';

    public function __construct()
    {
        /* $this->middleware('auth'); */
    }

    public function index()
    {
        $data = array(
            'menu_selected' => $this->menu_selected,
            'section' => '',
            'level'=> session(Security::$SESSION_USER_LEVEL)
        );
        return view('master_data.index')->with($data);
    }

    /**
      * master method for general data
      * Here you have to pass a parameter to the route
     **/
    public function general($section)
    {
        $data = array(
            'section' => $section,
            'menu_selected' => $this->menu_selected,
            'level'=> session(Security::$SESSION_USER_LEVEL)
        );

        return view('master_data.'.$section.'.index')->with($data);
    }
    public function refresh($section){
        $departments = [
            [
                'name' => 'BOARD',
                'department_code' => 'BOARD',
            ],
            [
                'name' => 'EXCO',
                'department_code' => 'EXCO',
            ],
            [
                'name' => 'TRAINING ROOM',
                'department_code' => 'TRAINING_ROOM',
            ],
        ];

        $dpts = Department::select('name', 'department_code')->get();

        foreach($dpts as $department){
            $departments[] = [
                'name' => $department->name,
                'department_code' => $department->department_code,
            ];
        }
        if($section =='action_log_types'){
            foreach($departments as $department){
                $action_log_type = ActionLogType::where('department_code', $department['department_code'])->first();
                if($action_log_type){
                    if($department['name'] != $action_log_type->department_name || $department['department_code'] != $action_log_type->department_code){                
                        $action_log_type->department_name = $department['name'];
                        $action_log_type->department_code = $department['department_code'];
                        $action_log_type->save();
                    }
                }else{
                    $action_log_type = new ActionLogType();
                    $action_log_type->department_code = $department['department_code'];
                    $action_log_type->department_name = $department['name'];
                    $action_log_type->save();
                }
            }
            $data = array(
                'section' => $section,
                'menu_selected' => $this->menu_selected,
                'level'=> session(Security::$SESSION_USER_LEVEL)
            );
            return view('master_data.action_log_types.index')->with($data);
        }elseif($section =='calendar_types'){

            foreach($departments as $department){
                $calendar_type = CalendarType::where('department_code', $department['department_code'])->first();
                $default_colors = ['color'=>'#FFFFFF', 'backgroundColor'=>'#228B22', 'dragBackgroundColor'=>'#228B22', 'borderColor'=>'#228B22'];

                if($calendar_type){
                    if($department['name'] != $calendar_type->department_name || $department['department_code'] != $calendar_type->department_code){                
                        $calendar_type->department_name = $department['name'];
                        $calendar_type->department_code = $department['department_code'];
                        $calendar_type->color = $default_colors['color'];
                        $calendar_type->backgroundColor = $default_colors['backgroundColor'];
                        $calendar_type->dragBackgroundColor = $default_colors['dragBackgroundColor'];
                        $calendar_type->borderColor = $default_colors['borderColor'];
                        $calendar_type->save();
                    }
                }else{
                    $calendar_type = new CalendarType();
                    $calendar_type->department_code = $department['department_code'];
                    $calendar_type->department_name = $department['name'];
                    $calendar_type->color = $default_colors['color'];
                    $calendar_type->backgroundColor = $default_colors['backgroundColor'];
                    $calendar_type->dragBackgroundColor = $default_colors['dragBackgroundColor'];
                    $calendar_type->borderColor = $default_colors['borderColor'];
                    $calendar_type->save();
                }
            
            }
            $data = array(
                'section' => $section,
                'menu_selected' => $this->menu_selected,
                'level'=> session(Security::$SESSION_USER_LEVEL)
            );
            return view('master_data.calendar_types.index')->with($data);
        }
    }
}