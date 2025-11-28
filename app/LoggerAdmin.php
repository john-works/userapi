<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoggerAdmin extends Model
{    public static function laratablesCustomActions($logger_admin)
    {
        $data = ['logger_admin'=>$logger_admin];
        return view('actions.logger_admin_actions')->with($data)->render();
    }
}
