<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZzztymothyLogger extends Model
{
    public static function logError($messsage){
        $log = new ZzztymothyLogger();
        $log->log = $messsage;
        $log->save();
    }
}
