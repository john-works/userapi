<?php

namespace App\Http\Controllers;

use App\AuditType;
use App\AuditActivity;
use Illuminate\Http\Request;
use Freshbitsweb\Laratables\Laratables;

class AuditActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master_data.audit_activities.index');
    }
    public function allActivities()
    {
        $auditActivities = AuditActivity::all();
        $auditTypes = AuditType::all();
        $data = [
            'activities'=>$auditActivities,
            'types'=>$auditTypes
        ];
        return $data;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master_data.audit_activities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $msg="";
        $data = $this->validate($request, [
            'name' => 'required',
            'created_by' => 'nullable',
            'id'=>'nullable',
            'updated_by'=>'nullable'
         ]);

         if(isset($request->id)){
            $data['id'] = $request->id;
            $auditActivity = $this->update($data);
            $msg = "Audit Type updated successfully";
         }else{
            $auditActivity = new AuditActivity;
            $auditActivity->name = $request->name;
            $auditActivity->created_by = $request->created_by;
            $auditActivity->save();
            $msg = "Audit Type created successfully";
         }
         return $msg;
    }

    public function list(){
        return Laratables::recordsOf(AuditActivity::class);
    }
    public function edit(AuditActivity $auditActivity)
    {
        return $this->create()->with('auditActivity', $auditActivity);
    }
    public function update($data)
    {
        $auditActivity = AuditActivity::find($data['id']);
        $auditActivity->name = $data['name'];
        $auditActivity->updated_by = $data['updated_by'];
        $auditActivity->save();
        return $auditActivity;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AuditActivity  $auditActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuditActivity $auditActivity)
    {
        try {
            $auditActivity->delete();
            return redirectBackWithSessionSuccess("Audit Activity successfully deleted");
        } catch (\Exception $e) {
            return redirectBackWithSessionError('Cannot delete this Audit Activity. Try again later');
        }
    }
}
