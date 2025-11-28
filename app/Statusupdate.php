<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statusupdate extends Model
{
    protected $table = "action_log_status_updates";
    protected $fillable = [
        'actionlog_id',
        'current_status',
        'next_action_department_name',
        'next_action_department_code',
        'next_action_unit_name',
        'next_action_unit_code',
        'next_action_user',
        'next_action',
        'next_action_date',
        'created_by',
    ];
    public function actionlog()
    {
        return $this->belongsTo('App\Actionlog', 'actionlog_id');
    }
}
