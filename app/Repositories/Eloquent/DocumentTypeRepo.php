<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 2/9/2018
 * Time: 02:12
 */


namespace App\Repositories\Eloquent;

use App\DocumentType;
use App\Repositories\Contracts\DocumentTypeRepoInterface;

class DocumentTypeRepo extends Repository implements DocumentTypeRepoInterface {

    function model() {
        return 'App\DocumentType';
    }

    public function documentTypes() {
        return $this->all();
    }

    public function createDocumentType(DocumentType $documentType) {
        return $documentType->save();
    }

    public function findDocumentType($documentTypeId) {
        return $this->find($documentTypeId);
    }

    public function updateDocumentType(DocumentType $documentType) {
        return $documentType->save();
    }
}