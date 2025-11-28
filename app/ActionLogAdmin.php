<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionLogAdmin extends Model
{
    protected $table = 'action_log_admins';
    public static function laratablesCustomActions($action_log_admin)
    {
        $data = ['action_log_admin'=>$action_log_admin];
        return view('actions.action_log_admin_actions')->with($data)->render();
    }
    public function department()
    {
        return $this->belongsTo('App\Department');
    }
}
