<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sectiong extends Model
{

    public function appraisal(){
        return $this->belongsTo('App\Appraisal');
    }

}
