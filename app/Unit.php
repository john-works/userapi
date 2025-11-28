<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = "department_units";
    public function department(){
        return $this->belongsTo("App\Department","department_code","department_code");
    }
}
