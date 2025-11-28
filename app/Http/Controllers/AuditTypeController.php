<?php

namespace App\Http\Controllers;

use App\AuditType;
use Illuminate\Http\Request;
use Freshbitsweb\Laratables\Laratables;

class AuditTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master_data.audit_types.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master_data.audit_types.create');
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
            $auditType = $this->update($data);
            $msg = "Audit Type updated successfully";
         }else{
            $auditType = new AuditType;
            $auditType->name = $request->name;
            $auditType->created_by = $request->created_by;
            $auditType->save();
            $id = $auditType->id;
            $msg = "Audit Type created successfully";
         }
         return $msg;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AuditType  $auditType
     * @return \Illuminate\Http\Response
     */

    public function list(){
        return Laratables::recordsOf(AuditType::class);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AuditType  $auditType
     * @return \Illuminate\Http\Response
     */
    public function edit(AuditType $auditType)
    {
        return $this->create()->with('auditType', $auditType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AuditType  $auditType
     * @return \Illuminate\Http\Response
     */
    public function update($data)
    {
        $auditType = AuditType::find($data['id']);
        $auditType->name = $data['name'];
        $auditType->updated_by = $data['updated_by'];
        $auditType->save();
        return $auditType;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AuditType  $auditType
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuditType $auditType)
    {
        try {
            $auditType->delete();
            return redirectBackWithSessionSuccess("Audit Type successfully deleted");
        } catch (\Exception $e) {
            return redirectBackWithSessionError('Cannot delete this Audit Type. Try again later');
        }
    }
}
