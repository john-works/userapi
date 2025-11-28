<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuditActivity extends Model
{
    public static function laratablesCustomActions($auditActivity)
    {
        $data = ['auditActivity'=>$auditActivity];
        return view('actions.audit_activity_actions')->with($data)->render();
    }
}
