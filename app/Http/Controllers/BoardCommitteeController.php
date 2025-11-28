<?php

namespace App\Http\Controllers;

use App\BoardCommittee;
use Illuminate\Http\Request;
use Freshbitsweb\Laratables\Laratables;

class BoardCommitteeController extends Controller
{
    public function index()
    {
        $data = array(
            'menu_selected' => MENU_ITEM_BOARD_COMMITTEE,
        );
        return view('master_data.board_committees.index')->with($data);
    }
    public function create(){
        return view('master_data.board_committees.create');
    }
    public function store(Request $request){
        $resp = [];
        $data = $this->validate($request, [
            'name' => 'required',
            'created_by' => 'nullable',
         ]);

         if(isset($request->id)){
            $data['id'] = $request->id;
            $board_committee = $this->update($data);
            $resp = $board_committee;
         }else{
            $board_committee = new BoardCommittee;
            $board_committee->name = $request->name;
            $board_committee->created_by = $request->created_by;
            $board_committee->save();
            $id = $board_committee->id;
         }
         return "Committee created successfully";
    }
    public function list(){
        return Laratables::recordsOf(BoardCommittee::class);
    }
    public function edit(BoardCommittee $board_committee){
        return $this->create()->with('board_committee', $board_committee);
    }
    public function update($data){
        $board_committee = BoardCommittee::findOrFail($data['id']);
        $board_committee->name = $data['name'];
        $board_committee->save();
         return "Committee updated successfully";
    }
    public function destroy(BoardCommittee $board_committee){
        try {
            // if (!$board_committee->itassets()->exists() || $board_committee->itassets()->count() == 0) {
                $board_committee->delete();
                return redirectBackWithSessionSuccess("Board Committee successfully deleted");
            // } else {

            // }
        } catch (\Exception $e) {
            return redirectBackWithSessionError('Cannot delete this Board Committee. Try again later');
        }
    }

}
