<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PortalUser extends Model
{
    protected $table = 'portal_users';
    protected $fillable = [
        'username',
        'created_at',
        'updated_at',
    ];
    public function rights(){
        return $this->hasMany('App\Access','user_id','id');
    }
    
     public static function laratablesCustomAction($portaluser)
    {
        $data = array(
            'user'=>$portaluser
        );
        return view('actions.portal_user_actions')->with($data)->render();
        
    }
    public static function laratablesCustomDepartment($portaluser)
    {
        $user = User::where('username', $portaluser->username)->first();
        if ($user && $user->department) {
            return $user->department->name;
        } else {
            return '';
        }
    }

    public static function laratablesCustomDesignation($portaluser)
    {
        $user = User::where('username', $portaluser->username)->first();
        if ($user && $user->designation) {
            return $user->designation->title;
        } else {
            return '';
        }
    }
    public function user(){
        return $this->belongsTo('App\User','username','username');
    }
}
