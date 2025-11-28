<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'first_name','last_name','username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setFirstNameAttribute($name){
        $this->attributes['first_name'] = ucwords(strtolower($name));
    }

    public function setLastNameAttribute($name){
        $this->attributes['last_name'] = ucwords(strtolower($name));
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function department()
    {
        return $this->belongsTo('App\Department','department_code','department_code');
    }
    public function designation()
    {
        return $this->belongsTo('App\Designation','designation_id');
    }
    public function calendarUsers()
    {
        return $this->hasMany('App\CalendarUser');
    }
    public function rights(){
        return $this->hasMany('App\Access','user_id');
    }
}
