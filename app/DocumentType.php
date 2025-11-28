<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    public function setDocumentTypeNameAttribute($documentTypeName){
        $this->attributes['doc_type_name'] = ucwords(strtolower($documentTypeName));
    }
}
