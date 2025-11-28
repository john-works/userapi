<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionlogTask extends Model
{
    protected $table = "action_log_tasks";
    protected $fillable = [
        'actionlog_id',
        'next_action_department_name',
        'next_action_department_code',
        'next_action_unit_name',
        'next_action_unit_code',
        'next_action_user',
        'next_action',
        'next_action_date',
        'created_by',
        'status',
        'completion_user',
        'completion_datetime',
        'completion_note',
    ];
    public function actionlog()
    {
        return $this->belongsTo('App\Actionlog', 'actionlog_id');
    }
    public static function laratablesCustomActions($action_log_task)
    {
        $data = ['action_log_task'=>$action_log_task];
        return view('actions.action_log_task_actions')->with($data)->render();
    }
    public static function laratablesAdditionalColumns()
    {
        return ['completion_user'];
    }
    public static function laratablesStatus($action_log_task)
    {
        if($action_log_task->status == ACTION_LOG_TASK_COMPLETED){
            return $action_log_task->status.' By '.$action_log_task->completion_user;
        }else{
            return $action_log_task->status;
        }
    }
}
