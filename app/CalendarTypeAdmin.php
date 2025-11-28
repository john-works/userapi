<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarTypeAdmin extends Model
{
    protected $fillable = ['calendar_type_id', 'user_id'];
    public static function laratablesCustomActions($calendar_type_admin)
    {
        $data = ['calendar_type_admin'=>$calendar_type_admin];
        return view('actions.calendar_type_admin_actions')->with($data)->render();
    }
}
