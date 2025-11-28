<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
    public function portalUser(){
        return $this->belongsTo('App\PortalUser','user_id');
    }
}
