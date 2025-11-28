<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $fillable = [
        'department_code',
        'department_name',
        'color',
        'backgroundColor',
        'dragBackgroundColor',
        'borderColor',
    ];
    public function events(){
        return $this->hasMany('App\Event');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function calendarUsers()
    {
        return $this->hasMany('App\CalendarUser');
    }
}
