<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarType extends Model
{
    protected $table = 'calendar_types';
    protected $fillable = [
        'department_code',
        'department_name',
        'color',
        'backgroundColor',
        'dragBackgroundColor',
        'borderColor',
    ];
    public function events(){
        return $this->hasMany('App\CalendarEvent');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function calendarUsers()
    {
        return $this->hasMany('App\CalendarUser');
    }
    public static function laratablesCustomActions($calendar_type)
    {
        $data = ['calendar_type'=>$calendar_type];
        return view('actions.calendar_type_actions')->with($data)->render();
    }
}
