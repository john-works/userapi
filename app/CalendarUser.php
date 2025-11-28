<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarUser extends Model
{
    protected $fillable = [
        "calendar_id",
        "user_id",
        "can_edit",
        "created_by",
    ];
    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'username');
    }
    public function calendar(){
        return $this->belongsTo('App\Calendar');
    }
    public static function laratablesCustomActions($calendaruser)
    {
        $data = ['calendaruser'=>$calendaruser];
        return view('actions.calendaruser_actions')->with($data)->render();
    }
}
