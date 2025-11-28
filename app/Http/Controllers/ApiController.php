<?php

namespace App\Http\Controllers;

use App\CustomEmisAttachmentTypeModule;
use App\Helpers\EndPoints;
use App\IncomingLetter;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\OutgoingLetter;
use App\Http\Resources\IncomingLetter as IncomingLetterResource;
use App\Http\Resources\OutgoingLetter as OutgoingLetterResource;

class ApiController extends Controller
{

    public function getEntities(){

        $url = endpoint('EMIS_ENTITIES_GET');
        $client = new Client([
          'headers' => ["content-type"=>"application/json", "Accept"=>"application/json"]
        ]);

        $response = $client->request("GET", $url, [
          'json'=>["x-code"=>"&80@#74!@3$"]
        ]);

        if($response->getStatusCode() == 200){
          return json_decode($response->getBody());
        }else{
            $data = array(
                'payload'=>[]
            );
            return json_decode(json_encode($data));
        }

    }

    public static function getProviders(){

        $url = endpoint('EMIS_PROVIDERS_GET');
        $client = new Client([
            'headers' => ["content-type"=>"application/json", "Accept"=>"application/json"]
        ]);

        $response = $client->request("GET", $url, [
            'json'=>["x-code"=>"&80@#74!@3$"]
        ]);

        if($response->getStatusCode() == 200){
            return json_decode($response->getBody());
        }else{
            $data = array(
                'payload'=>[]
            );
            return json_decode(json_encode($data));
        }

    }

    public static function getPpdaUsers(){

        $url = endpoint('EMIS_PPDA_USERS_GET');

        $client = new Client([
            'headers' => ["content-type"=>"application/json", "Accept"=>"application/json"]
        ]);

        $response = $client->request("GET", $url, [
            'json'=>["x-code"=>"&80@#74!@3$"]
        ]);

        if($response->getStatusCode() == 200){
            return json_decode($response->getBody());
        }else{
            $data = array(
                'data'=>[]
            );
            return json_decode(json_encode($data));
        }

    }



    /**
    ** Get all incoming letters for a department
     * API expects one of the following parameters(departments) are one of the following; pm_tag
        legal_tag,
        corp_tag,
        advisory_tag,
        cbas_tag
    **/
    public function get_department_incoming_letters($department){
      $letters = IncomingLetter::where($department,1)->get();
      if(!$letters){
          return array("success"=>false, "message"=>"Entity not found");
      }
      $data = IncomingLetterResource::collection($letters);
      return response()->json(array("success"=>true, "payload"=>$data));
    }

    /**
    ** Get all outgoing letters for a department
    **/
    public function get_department_outgoing_letters($department){
      $letters = OutgoingLetter::where($department,1)->get();
      if(!$letters){
          return array("success"=>false, "message"=>"No letters found");
      }
      $data = OutgoingLetterResource::collection($letters);
      return response()->json(array("success"=>true, "payload"=>$data));
    }



    public static function uploadFile($fileName, $authenticationTicket,$pathToFileInEdms){

        $url = endpoint('BASE_URL_EDMS_MIDDLEWARE_API') . endpoint('EDMS_UPLOAD_DOCUMENT');
        $client = new Client([
            'headers' => ["content-type"=>"application/json", "Accept"=>"application/json"]
        ]);

        $response =  $client->request('POST', $url, [
            'multipart' => [
                [
                    'name' => 'documentContents',
                    'contents' => fopen($fileName, 'r'),
                ],
                [
                    'name' => 'authenticationTicket',
                    'contents' => json_encode($authenticationTicket),
                ],
                [
                    'name' => 'pathToFileInEdms',
                    'contents' => json_encode($pathToFileInEdms),
                ]
            ]
        ]);

        if($response->getStatusCode() == 200){
            return json_decode($response->getBody());
        }else{
            return [];
        }

    }

    public static function getAccountingOfficerTitles(){

        $url = 'http://'. endpoint('SERVER_IP') . ':10000/api/entity_query/get_accounting_officer_titles';
        $client = new Client([
            'headers' => ["content-type"=>"application/json", "Accept"=>"application/json"]
        ]);

        $response = $client->request("GET", $url, [
            'json'=>["x-code"=>"&80@#74!@3$"]
        ]);

        if($response->getStatusCode() == 200){
            return json_decode($response->getBody());
        }else{
            $data = array(
                'payload'=>[]
            );
            return json_decode(json_encode($data));
        }

    }


    public static function getEmisAdministrativeReviews($entity = null){

        $url = 'http://'. endpoint('SERVER_IP') . ':10000/api/lms_query/get_legal_financial_year_admin_reviews'.($entity == null ? '':'/'.$entity);
        $client = new Client([
            'headers' => ["content-type"=>"application/json", "Accept"=>"application/json"]
        ]);

        $response = $client->request("GET", $url, [
            'json'=>["x-code"=>"&80@#74!@3$"]
        ]);

        if($response->getStatusCode() == 200){
            return json_decode($response->getBody());
        }else{
            $data = array(
                'payload'=>[]
            );
            return json_decode(json_encode($data));
        }
   }

    public static function getEmisInvestigations($entity = null){

        $url = 'http://'. endpoint('SERVER_IP') . ':10000/api/lms_query/get_legal_financial_year_investigations'.($entity == null ? '':'/'.$entity);
        $client = new Client([
            'headers' => ["content-type"=>"application/json", "Accept"=>"application/json"]
        ]);

        $response = $client->request("GET", $url, [
            'json'=>["x-code"=>"&80@#74!@3$"]
        ]);

        if($response->getStatusCode() == 200){
            return json_decode($response->getBody());
        }else{
            $data = array(
                'payload'=>[]
            );
            return json_decode(json_encode($data));
        }
    }

    public static function getEmisDeviations($entity = null){

        $url = 'http://'. endpoint('SERVER_IP') . ':10000/api/lms_query/get_legal_financial_year_deviations'.($entity == null ? '':'/'.$entity);
        $client = new Client([
            'headers' => ["content-type"=>"application/json", "Accept"=>"application/json"]
        ]);

        $response = $client->request("GET", $url, [
            'json'=>["x-code"=>"&80@#74!@3$"]
        ]);

        if($response->getStatusCode() == 200){
            return json_decode($response->getBody());
        }else{
            $data = array(
                'payload'=>[]
            );
            return json_decode(json_encode($data));
        }
    }

    public static function getEmisAccreditations($entity = null){

        $url = 'http://'. endpoint('SERVER_IP') . ':10000/api/lms_query/get_legal_financial_year_accreditations'.($entity == null ? '':'/'.$entity);
        $client = new Client([
            'headers' => ["content-type"=>"application/json", "Accept"=>"application/json"]
        ]);

        $response = $client->request("GET", $url, [
            'json'=>["x-code"=>"&80@#74!@3$"]
        ]);

        if($response->getStatusCode() == 200){
            return json_decode($response->getBody());
        }else{
            $data = array(
                'payload'=>[]
            );
            return json_decode(json_encode($data));
        }
    }

    public static function getEmisTribunals($entity = null){

        $url = 'http://'. endpoint('SERVER_IP') . ':10000/api/lms_query/get_legal_financial_year_tribunals'.($entity == null ? '':'/'.$entity);
        $client = new Client([
            'headers' => ["content-type"=>"application/json", "Accept"=>"application/json"]
        ]);

        $response = $client->request("GET", $url, [
            'json'=>["x-code"=>"&80@#74!@3$"]
        ]);

        if($response->getStatusCode() == 200){
            return json_decode($response->getBody());
        }else{
            $data = array(
                'payload'=>[]
            );
            return json_decode(json_encode($data));
        }
    }

    public static function getEmisCourtCases($entity = null){

        $url = 'http://'. endpoint('SERVER_IP') . ':10000/api/lms_query/get_legal_financial_year_court_cases'.($entity == null ? '':'/'.$entity);
        $client = new Client([
            'headers' => ["content-type"=>"application/json", "Accept"=>"application/json"]
        ]);

        $response = $client->request("GET", $url, [
            'json'=>["x-code"=>"&80@#74!@3$"]
        ]);

        if($response->getStatusCode() == 200){
            return json_decode($response->getBody());
        }else{
            $data = array(
                'payload'=>[]
            );
            return json_decode(json_encode($data));
        }
    }

    public static function getEmisSuspensions($entity = null){

        $url = 'http://'. endpoint('SERVER_IP') . ':10000/api/lms_query/get_legal_financial_year_suspensions'.($entity == null ? '':'/'.$entity);
        $client = new Client([
            'headers' => ["content-type"=>"application/json", "Accept"=>"application/json"]
        ]);

        $response = $client->request("GET", $url, [
            'json'=>["x-code"=>"&80@#74!@3$"]
        ]);

        if($response->getStatusCode() == 200){
            return json_decode($response->getBody());
        }else{
            $data = array(
                'payload'=>[]
            );
            return json_decode(json_encode($data));
        }
    }

    public static function getEmisCirculars($entity = null){

        $url = 'http://'. endpoint('SERVER_IP') . ':10000/api/lms_query/get_financial_year_circulars'.($entity == null ? '':'/'.$entity);
        $client = new Client([
            'headers' => ["content-type"=>"application/json", "Accept"=>"application/json"]
        ]);

        $response = $client->request("GET", $url, [
            'json'=>["x-code"=>"&80@#74!@3$"]
        ]);

        if($response->getStatusCode() == 200){
            return json_decode($response->getBody());
        }else{
            $data = array(
                'payload'=>[]
            );
            return json_decode(json_encode($data));
        }
    }

    public static function getEmisPmActivities($entity = null){

        $url = 'http://'. endpoint('SERVER_IP') . ':10000/api/lms_query/get_pm_financial_year_activities'.($entity == null ? '':'/'.$entity);
        $client = new Client([
            'headers' => ["content-type"=>"application/json", "Accept"=>"application/json"]
        ]);

        $response = $client->request("GET", $url, [
            'json'=>["x-code"=>"&80@#74!@3$"]
        ]);

        if($response->getStatusCode() == 200){
            return json_decode($response->getBody());
        }else{
            $data = array(
                'payload'=>[]
            );
            return json_decode(json_encode($data));
        }
    }

    public static function getEmisCbasActivities($entity = null){

        $url = 'http://'. endpoint('SERVER_IP') . ':10000/api/lms_query/get_cbas_financial_year_activities'.($entity == null ? '':'/'.$entity);
        $client = new Client([
            'headers' => ["content-type"=>"application/json", "Accept"=>"application/json"]
        ]);

        $response = $client->request("GET", $url, [
            'json'=>["x-code"=>"&80@#74!@3$"]
        ]);

        if($response->getStatusCode() == 200){
            return json_decode($response->getBody());
        }else{
            $data = array(
                'payload'=>[]
            );
            return json_decode(json_encode($data));
        }
    }

    public static function getEmisCbasTrainingNeedsAssessment($entity = null){

        $url = 'http://'. endpoint('SERVER_IP') . ':10000/api/lms_query/get_cbas_financial_year_training_needs_assessment'.($entity == null ? '':'/'.$entity);
        $client = new Client([
            'headers' => ["content-type"=>"application/json", "Accept"=>"application/json"]
        ]);

        $response = $client->request("GET", $url, [
            'json'=>["x-code"=>"&80@#74!@3$"]
        ]);

        if($response->getStatusCode() == 200){
            return json_decode($response->getBody());
        }else{
            $data = array(
                'payload'=>[]
            );
            return json_decode(json_encode($data));
        }
    }

    public static function getEmisAttachmentTypes(){

        $url = 'http://'. endpoint('SERVER_IP') . ':10000/api/general_query/get_attachment_types';

        $client = new Client([
            'headers' => ["content-type"=>"application/json", "Accept"=>"application/json"]
        ]);

        $response = $client->request("GET", $url, [
            'json'=>["x-code"=>"&80@#74!@3$"]
        ]);

        if($response->getStatusCode() == 200){
            $result = json_decode($response->getBody());

            if($result->success == false){
                return false;
            }

            $records = $result->payload;
            $records = CustomEmisAttachmentTypeModule::buildCustomRecords($records);
            return $records;
//            return json_encode($records);

        }else{
            $data = array(
                'payload'=>[]
            );
            return json_decode(json_encode($data));
        }
    }

    public static function getEmisAttachmentFileDetails($emisAttachedDocumentId){

        $url = 'http://'. endpoint('SERVER_IP') . ':10000/api/lms_query/get_emis_attached_document_details/'.$emisAttachedDocumentId;
        $client = new Client([
            'headers' => ["content-type"=>"application/json", "Accept"=>"application/json"]
        ]);

        $response = $client->request("GET", $url, [
            'json'=>["x-code"=>"&80@#74!@3$"]
        ]);

        if($response->getStatusCode() == 200){

            $result = json_decode($response->getBody());

            if($result->success == false){
                return false;
            }

            $records = $result->payload;
            return $records;
        }else{
            return [];
        }

    }


    public function clearEmisAttachmentFields($letterCategory, $letterId){

        try{

            if($letterCategory == 'incoming'){
                $letter = IncomingLetter::find($letterId);
            }
            else if($letterCategory == 'outgoing'){
                $letter = OutgoingLetter::find($letterId);
            }

            if(!isset($letter)){
                return array("success"=>false, "message"=> ucwords($letterCategory)." Letter with Id [".$letterId."] not Found");
            }

            //clear the fields
            $letter->emis_attachment_documents_id = null;
            $letter->emis_attachment_notes = null;
            $letter->emis_attachment_username = null;
            $letter->emis_attachment_datetime = null;
            $letter->emis_attachment_user_fullname = null;

            $letter->save();

            return array("success"=>true, "message"=> "EMIS Attachment Details Successfully Cleared");

        }catch (\Exception $exception){

            return array("success"=>false, "message"=>$exception->getMessage());

        }

    }

    public function update_emis_attachment_fields($letterCategory, $letterId, $department,$attachedDocumentId, $caseType, $attachedBy){

        try{

            if($letterCategory == 'incoming'){
                $letter = IncomingLetter::find($letterId);
            }
            else if($letterCategory == 'outgoing'){
                $letter = OutgoingLetter::find($letterId);
            }

            if(!isset($letter)){
                return array("success"=>false, "message"=> ucwords($letterCategory)." Letter with Id [".$letterId."] not Found");
            }

            //clear the fields
            $letter->emis_attachment_documents_id = $attachedDocumentId;
            $letter->emis_attachment_notes = $caseType. " - Attached from EMIS";

            if(isset($attachedBy)){
                $letter->emis_attachment_username = $attachedBy;
                $letter->emis_attachment_user_fullname = $attachedBy;
                $letter->emis_attachment_datetime = Carbon::now();
            }

            //clear all other tag flags
            foreach (EmisAttachmentsController::EMIS_TAGS as $tag){
                $letter->$tag = 0;
            }

            $tagToCheck = self::getEmisTagBasedOnDepartmentFromEmisRequest($department);
            if($tagToCheck != null){
                $letter->$tagToCheck = 1;
            }

            $letter->save();

            return array("success"=>true, "message"=> "Attachment Details successfully Saved");

        }catch (\Exception $exception){

            return array("success"=>false, "message"=>$exception->getMessage());

        }

    }

}
