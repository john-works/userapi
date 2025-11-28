<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actionlog extends Model
{
    protected $table = "action_logs";
    protected $fillable = [
        'required_action',
        'actionlog_type',
        'department_id',
        'responsible_person',
        'status',
        'completion_user',
        'completion_datetime',
        'completion_comment',
        'created_by',
        'reference_number',
        'date_opened',
        'initial_due_date',
        'revised_due_date',
    ];

    public static function laratablesAdditionalColumns()
    {
        return ['created_by'];
    }
    public static function laratablesCustomLastStatusUpdate($actionlog)
    {
        // return 'Last Status Update';
        // return $actionlog->status_update->latest()->current_status;
        if(empty($actionlog->status_update->current_status)){
            return 'N/A';
        }
        return $actionlog->status_update->current_status.' ['.$actionlog->status_update->created_by.' ON '.$actionlog->status_update->created_at.']';
    }
    public static function laratablesCustomActions($actionlog)
    {
        $data = ['actionlog'=>$actionlog];
        return view('actions.actionlog_actions')->with($data)->render();
    }
    public function status_updates()
    {
        return $this->hasMany(Statusupdate::class);
    }
    public function department()
    {
        return $this->belongsTo('App\Department');
    }
    public function actionlog_type()
    {
        return $this->belongsTo('App\ActionLogType');
    }
    public function status_update()
    {
        return $this->hasOne('App\Statusupdate')->latest();
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function latestTask()
    {
        return $this->hasOne('App\ActionlogTask')->latest();
    }
    public static function getLaratablesData()
    {
        return static::select('action_logs.*', 'action_log_tasks.next_action_user')
            ->leftJoin('action_log_tasks', 'action_logs.id', '=', 'action_log_tasks.actionlog_id')
            ->where('action_log_tasks.next_action_user', session('user')->username)
            ->where('action_log_tasks.status', ACTION_LOG_TASK_IN_PROGRESS)
            ->orderBy('action_logs.id', 'desc')
            ->get();
    }
}
