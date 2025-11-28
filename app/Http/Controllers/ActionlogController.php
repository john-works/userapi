<?php

namespace App\Http\Controllers;

use App\Unit;
use App\User;
use App\Email;
use Validator;
use app\ApiResp;
use App\Actionlog;
use App\Department;
use App\Statusupdate;
use App\ActionlogTask;
use App\ActionLogType;
use App\ActionLogAdmin;
use app\Helpers\Security;
use app\Helpers\EndPoints;
use app\Helpers\ApiHandler;
use app\Helpers\DataLoader;
use Illuminate\Http\Request;
use app\Helpers\AppConstants;
use App\Helpers\EmailHandler;
use app\Helpers\DataFormatter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\ApiController;
use Freshbitsweb\Laratables\Laratables;
use App\Notifications\ActionlogNotification;
use App\Notifications\ActionlogTaskNotification;

class ActionlogController extends Controller
{
    public $_users = '';

    public function index($menu_selected=MENU_ITEM_ACTIONLOGS)
    {
        $data = array(
            'menu_selected' => $menu_selected,
        );
        return view('actionlogs.index')->with($data);
    }
    public function list($menu_selected=MENU_ITEM_ACTIONLOGS){
        if($menu_selected == MENU_ITEM_ACTIONLOGS_MY_ACTION){
            return Laratables::recordsOf(Actionlog::class, function ($query) {
            //=====ELECETING THE LATEST STATUS UPDATE FROM THE ACTION_LOG_STATUS_UPDATES TABLE===
            // return $query->join(
            //     \DB::raw('(SELECT actionlog_id, MAX(updated_at) AS latest_updated_at
            //               FROM action_log_status_updates
            //               GROUP BY actionlog_id) AS latest_updates'),
            //     function ($join) {
            //         $join->on('action_logs.id', '=', 'latest_updates.actionlog_id');
            //     }
            // )
            // ->join('action_log_status_updates', function ($join) {
            //     $join->on('action_logs.id', '=', 'action_log_status_updates.actionlog_id')
            //         ->on('latest_updates.latest_updated_at', '=', 'action_log_status_updates.updated_at');
            // })
            // ->where('action_log_status_updates.next_action_user', session('user')->username)
            // ->select('action_logs.*', 'action_log_status_updates.next_action_user')
            // ->orderBy('action_logs.id', 'desc');
            //==== SELECTING THE LATEST TASK FROM THE ACTION_LOG_TASKS TABLE====
                return $query->join(
                    \DB::raw('(SELECT actionlog_id, MAX(updated_at) AS latest_updated_at
                              FROM action_log_tasks
                              GROUP BY actionlog_id) AS latest_updates'),
                    function ($join) {
                        $join->on('action_logs.id', '=', 'latest_updates.actionlog_id');
                    }
                )
                ->join('action_log_tasks', function ($join) {
                    $join->on('action_logs.id', '=', 'action_log_tasks.actionlog_id')
                        ->on('latest_updates.latest_updated_at', '=', 'action_log_tasks.updated_at');
                })
                ->where('action_log_tasks.next_action_user', session('user')->username)
                ->where('action_log_tasks.status', ACTION_LOG_TASK_IN_PROGRESS)
                ->select('action_logs.*', 'action_log_tasks.next_action_user')
                ->orderBy('action_logs.id', 'desc');
        });
        }else if($menu_selected == MENU_ITEM_ACTIONLOGS_MY_DEPARTMENT){

            return Laratables::recordsOf(Actionlog::class, function ($query){
                return $query->where(['actionlog_type'=>session('user')->departmentName])->orderBy('id','desc');
            });
        }else if($menu_selected == MENU_ITEM_ACTIONLOGS_MY_DEPARTMENT_PENDING){

            return Laratables::recordsOf(Actionlog::class, function ($query){
                return $query->where(['actionlog_type'=>session('user')->departmentName])->orderBy('id','desc');
            });
        }else if($menu_selected == MENU_ITEM_ACTIONLOGS_MY_DEPARTMENT_CLOSED){

            return Laratables::recordsOf(Actionlog::class, function ($query){
                return $query->where(['actionlog_type'=>session('user')->departmentName])->orderBy('id','desc');
            });
        }else if($menu_selected == MENU_ITEM_ACTIONLOGS_BOARD){
            return Laratables::recordsOf(Actionlog::class, function ($query){
                return $query->where(['actionlog_type'=>DEPARTMENT_BOARD])->orderBy('id','desc');
            });
        }else if($menu_selected == MENU_ITEM_ACTIONLOGS_EXCO){
            return Laratables::recordsOf(Actionlog::class, function ($query){
                return $query->where(['actionlog_type'=>DEPARTMENT_EXCO])->orderBy('id','desc');
            });
        }else{
            return Laratables::recordsOf(Actionlog::class, function ($query){
                return $query->orderBy('id','desc');
            });
        }
    }
    public function departmentIndex($status){
        $data = array(
            'current_status' => $status,
            'menu_selected' => MENU_ITEM_ACTIONLOGS_MY_DEPARTMENT,
        );
        return view('actionlogs.department')->with($data);
    }
    public function departmentList($status){
        if($status == 'department_open'){
            return Laratables::recordsOf(Actionlog::class, function ($query) {
                return $query->where(['actionlog_type'=>session('user')->departmentName,'status'=>ACTION_LOG_STATUS_IN_PROGRESS])->orderBy('id','desc');
            });
        }else if($status == 'department_pending'){
            return Laratables::recordsOf(Actionlog::class, function ($query) {
                return $query->where(['actionlog_type'=>session('user')->departmentName,'status'=>ACTION_LOG_PENDING_CLOSURE])->orderBy('id','desc');
            });
        }else if($status == 'department_closed'){
            return Laratables::recordsOf(Actionlog::class, function ($query) {
                return $query->where(['actionlog_type'=>session('user')->departmentName,'status'=>ACTION_LOG_STATUS_CLOSED])->orderBy('id','desc');
            });
        }

    } 
    public function create($menu_selected=MENU_ITEM_ACTIONLOGS){

        $actionlog_types = ActionLogType::all();
        $departments = Department::all(); 
        $users = [];

        $staff = User::select('first_name', 'last_name', 'username')->get();
        
        foreach ($staff as $user) {
            $userData = new \stdClass();
        
            $userData->username = $user->username;
            $userData->fullname = $user->first_name . ' ' . $user->last_name;
        
            $users[] = $userData;
        }
        
        $data = [
            'actionlog_types' => $actionlog_types,
            'departments' => $departments,
            'users' => $users,
            'menu_selected'=>$menu_selected,
        ];
        return view('actionlogs.create')->with($data);
    }
    public function store(Request $request)
    {
        $msg = '';
        $data = $request->validate([
            'required_action' => 'required',
            'responsible_department' => 'required',
            'actionlog_type' => 'required',
            'responsible_person' => 'required',
            'created_by' => 'nullable',
            'updated_by' => 'nullable',
            'id' => 'nullable',
            'reference_number' => 'required',
            'date_opened' => 'required|date',
            'initial_due_date' => 'required|date|after:date_opened',
            'revised_due_date' => 'nullable',
        ]);
        
        // if ($validator->fails()) return response()->json(['status'=>0,'errors'=>$validator->errors()]);
        if ($request->id){

            $actionlog = Actionlog::where(['id'=>$request->id])->first();
                $updated = $actionlog->update([
                    'required_action' => $request['required_action'],
                    'department_id' => $request['responsible_department'],
                    'actionlog_type' => $request['actionlog_type'],
                    'responsible_person' => $request['responsible_person'],
                    'status'=> ACTION_LOG_STATUS_IN_PROGRESS,
                    'updated_by' => $request['updated_by'],
                    'reference_number' => $request['reference_number'],
                    'date_opened' => $request['date_opened'],
                    'initial_due_date' => $request['initial_due_date'],
                    'revised_due_date' => $request['revised_due_date'],
                ]);
                if($updated){
                    $msg = 'Action log updated successfully';
                }

        }else{
            $actionlog = Actionlog::create([
                'required_action' => $request['required_action'],
                'department_id' => $request['responsible_department'],
                'actionlog_type' => $request['actionlog_type'],
                'responsible_person' => $request['responsible_person'],
                'status'=> ACTION_LOG_STATUS_IN_PROGRESS,
                'created_by' => $request['created_by'],
                'reference_number' => $request['reference_number'],
                'date_opened' => $request['date_opened'],
                'initial_due_date' => $request['initial_due_date'],
                'revised_due_date' => $request['revised_due_date'],
            ]);
           if($actionlog){
            $new_status = Statusupdate::create([
                'actionlog_id' => $actionlog->id,
                'current_status' => ACTION_LOG_DEFAULT_STATUS,
                'next_action_department_name' => $actionlog->department->name,
                'next_action_department_code' => $actionlog->department->department_code,
                'next_action_user' => $actionlog->responsible_person,
                'next_action' => ACTION_LOG_DEFAULT_STATUS,
                'next_action_date' => now(),
                'created_by' => $request['created_by'],
            ]);
               $msg = 'Action log created successfully';
           }
        }
        return $msg;

    }
    public function edit(Actionlog $actionlog){
        $data =[
            'actionlog'=> $actionlog,
        ];

        return $this->create()->with($data);
    }
    public function complete(Actionlog $actionlog){
        $data =[
            'actionlog'=> $actionlog
        ];
        return view('actionlogs.comment')->with($data);
    }
    public function toPending(Actionlog $actionlog){
        $data =[
            'actionlog'=> $actionlog
        ];
        return view('actionlogs.closure')->with($data);
    }
    public function pendClosure(Request $request){
        $data = $request->validate([
            'completion_user'=>'required',
            'completion_comment'=>'required',
        ]);
        $actionlog = Actionlog::where(['id'=>$request->id]);
        $closed = $actionlog->update([
            'completion_user'=> $data['completion_user'],
            'completion_comment'=> $data['completion_comment'],
            'status'=> ACTION_LOG_PENDING_CLOSURE,
            'completion_datetime'=>now()
        ]);
        if($closed){
            return 'Action log closed successfully';
        }else{
            return 'Sorry, Action log still in progress';
        }
    }
    public function close(Request $request){
        $data = $request->validate([
            'completion_user'=>'required',
            'completion_comment'=>'required',
        ]);
        $actionlog = Actionlog::where(['id'=>$request->id]);
        $closed = $actionlog->update([
            'completion_user'=> $data['completion_user'],
            'completion_comment'=> $data['completion_comment'],
            'status'=> ACTION_LOG_STATUS_CLOSED,
            'completion_datetime'=>now()
        ]);
        if($closed){
            return 'Action log closed successfully';
        }else{
            return 'Sorry, Action log still in progress';
        }
    }
    public function getUpdates(Actionlog $actionlog)
    {
        $statusupdates = Statusupdate::where('actionlog_id',$actionlog->id)->get();
        $data = [
            'statusupdates'=>$statusupdates,
            'actionlog' =>$actionlog
        ];
        return view('actionlogs.show_updates')->with($data);
    }
    public function createUpdates(Actionlog $actionlog)
    {
        $departments = Department::all();
        $units = Unit::all();
        $users = [];
        $staff = User::select('first_name', 'last_name', 'username')->get();
        foreach ($staff as $user) {
            $userData = new \stdClass();
            $userData->username = $user->username;
            $userData->fullname = $user->first_name . ' ' . $user->last_name;
            $users[] = $userData;
        }

        $data = [
            'actionlog' => $actionlog,
            'departments' => $departments,
            'users' => $users,
            'units' => $units
        ];
        return view('actionlogs.create_updates')->with($data);
    }
    public function createTask(Actionlog $actionlog)
    {
        $departments = Department::all();
        $units = Unit::all();
        $users = [];
        $staff = User::select('first_name', 'last_name', 'username')->get();
        foreach ($staff as $user) {
            $userData = new \stdClass();
            $userData->username = $user->username;
            $userData->fullname = $user->first_name . ' ' . $user->last_name;
            $users[] = $userData;
        }

        $data = [
            'actionlog' => $actionlog,
            'departments' => $departments,
            'users' => $users,
            'units' => $units
        ];
        return view('actionlogs.create_task')->with($data);
    }
    public function storeUpdates(Request $request)
    {
        $request->validate([
            'actionlog_id' => 'required',
            'current_status' => 'required',
            'next_action_department_name' => 'nullable',
            'next_action_unit_name' => 'nullable',
            'next_action_user' => 'nullable',
            'next_action' => 'nullable',
            'next_action_date' => 'nullable|date:after_or_equal:today',
            'created_by' => 'nullable',
        ]);
        
        $department = Department::where('id', $request->next_action_department_name)->first(['name', 'department_code']);
        $unit = Unit::where('id', $request->next_action_unit_name)->first(['name', 'unit_code']);
        
        $statusupdate = Statusupdate::create([
            'actionlog_id' => $request->actionlog_id,
            'current_status' => $request->current_status,
            'next_action_department_name' => isset($department)? $department->name: null,
            'next_action_department_code' => isset($department)? $department->department_code: null,
            'next_action_unit_name' => isset($unit)? $unit->name: null,
            'next_action_unit_code' => isset($unit)? $unit->unit_code: null,
            'next_action_user' => $request->next_action_user,
            'next_action' => $request->next_action,
            'next_action_date' => $request->next_action_date,
            'created_by' => $request->created_by,
        ]);
        $this->sendActionlogNotification($statusupdate);
        $msg = 'Status Update created successfully';
        return json_encode(ApiResp::success($msg, $msg));
    }
    public function storeTask(Request $request)
    {
        $request->validate([
            'actionlog_id' => 'required',
            'next_action_department_name' => 'required',
            'next_action_unit_name' => 'required',
            'next_action_user' => 'required',
            'next_action' => 'required',
            'next_action_date' => 'required|date:after_or_equal:today',
            'created_by' => 'required',
        ]);
        
        $department = Department::where('id', $request->next_action_department_name)->first(['name', 'department_code']);
        $unit = Unit::where('id', $request->next_action_unit_name)->first(['name', 'unit_code']);
        
        $actionlog_task = ActionlogTask::create([
            'actionlog_id' => $request->actionlog_id,
            'next_action_department_name' => $department->name,
            'next_action_department_code' => $department->department_code,
            'next_action_unit_name' => $unit->name,
            'next_action_unit_code' => $unit->unit_code,
            'next_action_user' => $request->next_action_user,
            'next_action' => $request->next_action,
            'next_action_date' => $request->next_action_date,
            'created_by' => $request->created_by,
            'status' => ACTION_LOG_TASK_IN_PROGRESS,
        ]);
        $this->sendTaskNotification($actionlog_task);
        $msg = 'Task Created created successfully';
        return json_encode(ApiResp::success($msg, $msg));
    }
    public function addCompletionNote(ActionlogTask $action_log_task){
        $data =[
            'action_log_task'=> $action_log_task
        ]; 
        return view('actionlogs.task_note')->with($data);
    }
    public function reopenTask(Request $request){
        $action_log_task = ActionlogTask::where('id', $request->id)->first();

        $action_log_task->update([
            'status' => ACTION_LOG_TASK_IN_PROGRESS,
            'completion_user' => null,
            'completion_note' => null,
            'completion_datetime' => null,
        ]);

        if($action_log_task){

            $data =[
                'success' => true,
                'message' => 'Task Reopened successfully'
            ];
            return $data;
        }else{
            $data =[
                'success' => false,
                'message' => 'Task not Reopened'
            ];
            return $data;
        }
    }
    public function completeTask(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'completion_user' => 'required',
            'completion_note' => 'required',
        ]);
        
        $actionlog_task = ActionlogTask::where('id', $request->id)->first();
        $actionlog_task->update([
            'completion_user' => $request->completion_user,
            'completion_note' => $request->completion_note,
            'completion_datetime' => now(),
            'status' => ACTION_LOG_TASK_COMPLETED,
        ]);
        return 'Task Completed successfully';
    }
    public function updateDetailsList($actionlog_id)
    {
        return Laratables::recordsOf(Statusupdate::class, function ($query) use ($actionlog_id) {
            return $query->where('actionlog_id', $actionlog_id)->orderBy('id', 'desc');
        });
    }
    public function taskList($actionlog_id)
    {
        return Laratables::recordsOf(ActionlogTask::class, function ($query) use ($actionlog_id) {
            return $query->where('actionlog_id', $actionlog_id)->orderBy('id', 'desc');
        });
    }
    private function sendActionlogNotification(Statusupdate $statusupdate)
    {

        $recipients = [];
        $notify = ActionlogNotification::actionlogAssigned($statusupdate);
        $body = view('emails.actionlogs.status')->with(array('notification' => $notify))->render();
        $subject = $notify->subject;
        $recipients[] = $statusupdate->actionlog->responsible_person;

        $data = array(
            'application'=>APP_NAME_CUSTOM,
            'sender' => 'PPDA',
            'subject' => $subject,
            'body' => $body,
            'recipients' => $recipients
        );
        $this->saveEmails($data);
    }
    private function sendTaskNotification(ActionlogTask $actionlog_task)
    {
        $recipients = [];
        $notify = ActionlogTaskNotification::actionlogTaskAssigned($actionlog_task);
        $body = view('emails.actionlogs.index')->with(array('notification' => $notify))->render();
        $subject = $notify->subject;
        $recipients[] = $actionlog_task->next_action_user;

        $data = array(
            'application'=>APP_NAME_CUSTOM,
            'sender' => 'PPDA',
            'subject' => $subject,
            'body' => $body,
            'recipients' => $recipients
        );
        $this->saveEmails($data);
    }
    public function trustedUserTasks($username=null){
        if($username == null){
            $data = array(
                'msg' => 'there is no trusted device info'
            );
            $view = view('actionlogs.trusted_users')->with($data);
        }else{
            $data = array(
                'username' => $username,
                'msg' => 'there is no trusted device info'
            );
            $view = view('actionlogs.trusted_users')->with($data);
        }
        return $view;
    }
    public function trustedUserActionLogList($username)
    {

        return Laratables::recordsOf(Actionlog::class, function ($query) use ($username) {
            return $query->join('action_log_status_updates', 'action_logs.id', '=', 'action_log_status_updates.actionlog_id')
            ->where('action_log_status_updates.next_action_user', $username)
            ->orderBy('action_logs.id', 'desc')
            ->select('action_logs.*', 'action_log_status_updates.next_action_user');
        });
    }
    private function saveEmails($data)
    {
        foreach ($data['recipients'] as $recipient){
            $email = new Email();
            $email->application = $data['application'];
            $email->sender = $data['sender'];
            $email->recipient = $recipient;
            $email->subject = $data['subject'];
            $email->body = $data['body'];
            $email->save();
        }
    }
}
