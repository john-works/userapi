<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 2/9/2018
 * Time: 02:12
 */


namespace App\Repositories\Contracts;

use App\DocumentType;

interface DocumentTypeRepoInterface {

    public function documentTypes();
    public function createDocumentType(DocumentType $documentType);
    public function findDocumentType($documentTypeId);
    public function updateDocumentType(DocumentType $documentType);

}