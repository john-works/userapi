<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterDataHistory extends Model
{

    public static function laratablesCustomCompare(MasterDataHistory $masterDataHistory)
    {
        return "<div class='btn-group-minier'><a title='View Changes' class='btn btn-success clarify' href='".route('administration.master_data_history.view_changes',$masterDataHistory->id)."'>View Changes</a></div>";
    }

    public static function laratablesAdditionalColumns()
    {
        $columns = ['new_value','old_value'];
        return $columns;
    }

    public static function laratablesCustomNewValueTrimmed(MasterDataHistory $masterDataHistory)
    {
        $value =  $masterDataHistory->new_value;
        if(!isset($value)) return $value;

        if(strlen($value) <= MD_HISTORY_MAX_CHARACTERS_FOR_JSON_VAL) {
            return $value;
        }
        $trimmed = substr($value, 0, MD_HISTORY_MAX_CHARACTERS_FOR_JSON_VAL - 1);
        return $trimmed . ' ...';
    }

    public static function laratablesCustomOldValueTrimmed(MasterDataHistory $masterDataHistory)
    {
        $value =  $masterDataHistory->old_value;
        if(!isset($value)) return $value;

        if(strlen($value) <= MD_HISTORY_MAX_CHARACTERS_FOR_JSON_VAL) {
            return $value;
        }
        $trimmed = substr($value, 0, MD_HISTORY_MAX_CHARACTERS_FOR_JSON_VAL - 1);
        return $trimmed . ' ...';
    }

    public function getActionDateAttribute($value){

        return get_user_friendly_date_time($value);

    }

    public function getOldValueAttribute($value){
        return !isset($value) ? "N/A" : $value;
    }

    public function getNewValueAttribute($value){
        return !isset($value) ? "N/A" : $value;
    }



}

