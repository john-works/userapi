<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoardCommittee extends Model
{
    public static function laratablesCustomActions($board_committee)
    {
        $data = ['board_committee'=>$board_committee];
        return view('actions.board_committee_actions')->with($data)->render();
    }
}
