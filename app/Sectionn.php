<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sectionn extends Model
{
    public function appraisal(){
        return $this->belongsTo('App\Appraisal');
    }

}
