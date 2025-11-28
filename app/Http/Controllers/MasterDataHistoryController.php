<?php

namespace App\Http\Controllers;

use App\MasterDataHistory;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;

class MasterDataHistoryController extends Controller
{

    public function index(){
        $data = array(
            'menu_selected' => MENU_ITEM_ADMIN_MASTER_DATA_HISTORY
        );
        return view('administration.master_data_history_index')->with($data);
    }

    public function list(){

        return Laratables::recordsOf(MasterDataHistory::class, function ($query) {
            return $query->orderBy('id','desc');
        });

    }

    public function viewChanges(MasterDataHistory $masterDataHistory){

        $previous = null;
        if(isset($masterDataHistory->old_value)){
            $previous = $masterDataHistory->is_json_value ? json_decode($masterDataHistory->old_value, true) : $masterDataHistory->old_value;
        }

        $updated = null;
        if(isset($masterDataHistory->new_value)){
            $updated = $masterDataHistory->is_json_value ? json_decode($masterDataHistory->new_value, true) : $masterDataHistory->new_value;
        }
        
        $data = array(
            'previous' => $previous,
            'updated' => $updated,
            'history' => $masterDataHistory,
        );
        return view('administration.master_data_history_compare_values')->with($data)->render();
    }

}

