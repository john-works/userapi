<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionLogType extends Model
{
    public static function laratablesCustomActions($action_log_type)
    {
        $data = ['action_log_type'=>$action_log_type];
        return view('actions.action_log_type_actions')->with($data)->render();
    }
    public function department()
    {
        return $this->belongsTo('App\Department');
    }
}
