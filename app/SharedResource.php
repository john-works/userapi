<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SharedResource extends Model
{
    protected $fillable = ['name', 'location', 'is_available'];
    public static function laratablesCustomActions($shared_resource)
    {
        $data = ['shared_resource'=>$shared_resource];
        return view('actions.shared_resource_actions')->with($data)->render();
    }
    public static function laratablesCustomIsAvailable($shared_resource)
    {
         if($shared_resource->is_available == true){
            return '<span class="badge badge-success">Available</span>';
        }else{
            return '<span class="badge badge-danger">Unavailable</span>';
        }
    }
    
    public static function laratablesAdditionalColumns()
    {
        return ['is_available'];
    }
}
