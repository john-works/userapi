<?php

namespace App\Http\Controllers;

use App\DocumentType;
use app\Helpers\AppConstants;
use App\Http\Requests\DocumentTypeRequest;
use App\Repositories\Contracts\DocumentTypeRepoInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DocumentTypesController extends Controller {

    /**
     * @var DocumentTypeRepoInterface
     */
    private $documentTypeRepo;

    function __construct(DocumentTypeRepoInterface $documentTypeRepo) {
        $this->documentTypeRepo = $documentTypeRepo;
    }

    public function documentTypes(){

        $documentTypes = $this->documentTypeRepo->documentTypes();

        $active_module = AppConstants::$ACTIVE_MOD_DOC_TYPES;
        return view('documenttypes/document_types',compact('active_module','documentTypes'));

    }

    public function getNewDocumentTypeForm(){

        $active_module = AppConstants::$ACTIVE_MOD_DOC_TYPES;
        return view('documenttypes/document_types_new',compact('active_module'));

    }
    public function getAddNewDocumentTypeForm(){

        $active_module = AppConstants::$ACTIVE_MOD_DOC_TYPES;
        return view('documenttypes/document_type_add',compact('active_module'));

    }

    public function addNewDocumentType(Request $request){

    }

    public function createDocumentType(DocumentTypeRequest $request){

        $documentTypeName = ucwords(strtolower($request['doc_type_name']));

        $fileHTML = $request->file('html_template');
        $mimeHTML = $fileHTML->getClientMimeType();
        $extensionHTML = $fileHTML->getClientOriginalExtension();
        $fileNameHTML = $documentTypeName . '.' . $extensionHTML;
        $filePathHTML = $fileHTML->storeAs( $documentTypeName, $fileNameHTML,'partitionE');

        $filePDF = $request->file('pdf_template');
        $mimePDF = $filePDF->getClientMimeType();
        $extensionPDF = $filePDF->getClientOriginalExtension();
        $fileNamePDF = $documentTypeName . '.' . $extensionPDF;
        $filePathPDF = $filePDF->storeAs( $documentTypeName, $fileNamePDF,'partitionE');

        $documentType = new DocumentType();

        $documentType->doc_type_html_template = $filePathHTML;
        $documentType->doc_type_html_template_filename = $fileNameHTML;
        $documentType->doc_type_html_template_mime = $mimeHTML;

        $documentType->doc_type_pdf_template = $filePathPDF;
        $documentType->doc_type_pdf_template_filename = $fileNamePDF;
        $documentType->doc_type_pdf_template_mime = $mimePDF;

        $documentType->doc_type_name = $documentTypeName;
        $this->documentTypeRepo->createDocumentType($documentType);

        $successfulOperationMessage = "Document type successfully created";
        $active_module = AppConstants::$ACTIVE_MOD_DOC_TYPES;
        return view('documenttypes/document_types_new',compact('active_module','successfulOperationMessage'));

    }

    public function editDocumentType(Request $request){

        if($request->ajax()){

            $validator = Validator::make($request->all(), [
                'doc_type_name' => 'required',
                'html_template' => 'sometimes|mimes:html',
                'pdf_template' => 'sometimes|mimes:pdf',
            ]);

            if ($validator->passes()) {
                return $this->updateDocumentType($request);
            }

            return response()->json(['error'=>$validator->errors()->all()]);

        }else{
            return response()->json('Not ajax response', 403);
        }

    }

    private function updateDocumentType(Request $request) {

        $documentTypeName = ucwords(strtolower($request['doc_type_name']));
        $documentTypeId = $request['document_type_id'];

        $documentType = $this->documentTypeRepo->findDocumentType($documentTypeId);
        $this->renameDocumentTypeFolder($documentTypeName,$documentType->doc_type_name);

        $fileHTML = $request->file('html_template');
        $filePDF = $request->file('pdf_template');

        if(!is_null($fileHTML)){

            /* A new file has been upload replace the old file both in db and folder with d new file */
            $mimeHTML = $fileHTML->getClientMimeType();
            $extensionHTML = $fileHTML->getClientOriginalExtension();
            $fileNameHTML = $documentTypeName . '.' . $extensionHTML;
            $filePathHTML = $fileHTML->storeAs( $documentTypeName, $fileNameHTML,'partitionE');

            $documentType->doc_type_html_template = $filePathHTML;
            $documentType->doc_type_html_template_filename = $fileNameHTML;
            $documentType->doc_type_html_template_mime = $mimeHTML;

        }else{

            /* No new upload rename the document and update path to document in the db*/
            $oldFileNamePDF = $documentType->doc_type_html_template_filename;
            $oldExtensionPDF = explode('.',$oldFileNamePDF)[count(explode('.',$oldFileNamePDF)) - 1];
            $newFileNamePDF = $documentTypeName . '.' . $oldExtensionPDF;
            $newFilePathHTML = $documentTypeName.'/'.$newFileNamePDF;

            $oldFilePathPDF = $documentTypeName.'/'.$oldFileNamePDF;

            $this->renameDocumentTypeDocument($oldFilePathPDF,$newFilePathHTML);

            $documentType->doc_type_html_template = $newFilePathHTML;
            $documentType->doc_type_html_template_filename = $newFileNamePDF;

        }

        if(!is_null($filePDF)){

            $mimePDF = $filePDF->getClientMimeType();
            $extensionPDF = $filePDF->getClientOriginalExtension();
            $fileNamePDF = $documentTypeName . '.' . $extensionPDF;
            $filePathPDF = $filePDF->storeAs( $documentTypeName, $fileNamePDF,'partitionE');

            $documentType->doc_type_pdf_template = $filePathPDF;
            $documentType->doc_type_pdf_template_filename = $fileNamePDF;
            $documentType->doc_type_pdf_template_mime = $mimePDF;

        }else{

            $oldFileNamePDF = $documentType->doc_type_pdf_template_filename;
            $oldExtensionPDF = explode('.',$oldFileNamePDF)[count(explode('.',$oldFileNamePDF)) - 1];
            $newFileNamePDF = $documentTypeName . '.' . $oldExtensionPDF;
            $newFilePathHTML = $documentTypeName.'/'.$newFileNamePDF;

            $oldFilePathPDF = $documentTypeName.'/'.$oldFileNamePDF;

            $this->renameDocumentTypeDocument($oldFilePathPDF,$newFilePathHTML);

            $documentType->doc_type_pdf_template = $newFilePathHTML;
            $documentType->doc_type_pdf_template_filename = $newFileNamePDF;

        }

        $documentType->doc_type_name = $documentTypeName;
        $this->documentTypeRepo->updateDocumentType($documentType);

        return response()->json(['success' => 'Document Type information successfully updated']);

    }

    private function renameDocumentTypeFolder($newDocumentTypeName, $oldDocumentTypeName) {

        if(strcmp($newDocumentTypeName,$oldDocumentTypeName) != 0){
            Storage::disk('partitionE')->move($oldDocumentTypeName, $newDocumentTypeName);
        }

    }

    private function renameDocumentTypeDocument($oldFileName,$newFileName) {

        if(strcmp($oldFileName,$newFileName) != 0){
            Storage::disk('partitionE')->move($oldFileName, $newFileName);
        }

    }

    public function downloadHtml(Request $request){

        $documentTypeId = $request['id'];
        $documentType = $this->documentTypeRepo->findDocumentType($documentTypeId);

        if($documentType != null && Storage::disk('partitionE')->exists($documentType->doc_type_html_template)){

            $fileName = $documentType->doc_type_html_template_filename;
            $pathToFile = Storage::disk('partitionE')->getDriver()->getAdapter()->applyPathPrefix('Appraisal/Appraisal.html');
            return response()->download($pathToFile, $fileName);

        }else{
            return "Oops, file not found";
        }

    }

    public function downloadPdf(Request $request){

        $documentTypeId = $request['id'];
        $documentType = $this->documentTypeRepo->findDocumentType($documentTypeId);

        if($documentType != null && Storage::disk('partitionE')->exists($documentType->doc_type_pdf_template)){

            $fileName = $documentType->doc_type_pdf_template_filename;
            $pathToFile = Storage::disk('partitionE')->getDriver()->getAdapter()->applyPathPrefix($documentType->doc_type_pdf_template);
            return response()->download($pathToFile, $fileName);

        }else{
            return "Oops, file not found";
        }

    }

}
