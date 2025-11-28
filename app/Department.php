<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [ 'department' ];

    public function users()
    {
        return $this->hasMany('App\User');
    }
    public function actionlogs()
    {
        return $this->hasMany('App\Actionlog');
    }
    public static function laratablesCustomActions($department)
    {
        $data = ['department'=>$department];
        return view('actions.department_actions')->with($data)->render();
    }
    public function ActionLogAdmins(){
        return $this->hasMany('App\ActionLogAdmin');
    }
    public function units(){
        return $this->hasMany('App\Unit');
    }
}
