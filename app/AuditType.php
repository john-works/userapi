<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuditType extends Model
{
    public static function laratablesCustomActions($auditType)
    {
        $data = ['auditType'=>$auditType];
        return view('actions.audit_type_actions')->with($data)->render();
    }
}
