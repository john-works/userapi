<?php

namespace App\Http\Controllers;

use App\AttachedDocument;
use App\ApiResp;
use App\Driver;
use App\AssetBorrowing;
use App\StoresRequisition;
use App\FuelRequestFuelIssueDetail;
use App\FuelRequestFundsBalance;
use App\FuelRequestParticular;
use App\Helpers\AppConstants;
use App\Helpers\DataLoader;
use App\Helpers\EdmsDocumentUploadHandler;
use App\Helpers\Security;
use App\IncomingLetter;
use App\LetterAssociation;
use App\LetterMovement;
use App\LetterTypeFieldValue;
use App\OutgoingLettersLetterTypeFieldValue;
use App\ZzztymothyLogger;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



class ActionController extends Controller
{

    public  $request;

    public $_arr_input_fields = array();
    public $_input_table;
    public $arrayTimeStampFields = array(
        'deadline_for_action',
        'date_sent',
        'date_received',
        'date_received_ppda',
        'date_received_registry',
        'memo_date',
        'date_received_registry',
        'date_stamped',
        'request_date',
        'activity_start_date',
        'activity_end_date',
        'driver_license_issue_date',
        'driver_license_expiry_date',
        'reading_date',
        'service_completion_date',
        'insurance_start_date',
        'insurance_end_date',
        'service_requisition_date',
        'service_start_date',
        //#start fuel request dates
        'request_to_hof_date',
        'hod_date',
        'balance_confirmed_by_date',
        'do_date',
        'fuel_issued_by_date',
        'fuel_issue1_date_of_last_issue',
        'fuel_issue2_date_of_last_issue',
        'fuel_issue3_date_of_last_issue',
        'fuel_issue4_date_of_last_issue',
        'fuel_issue5_date_of_last_issue',
        'fuel_issue6_date_of_last_issue',
        //#end fuel request dates
        'inspection_date',
        'transfer_date',
        'date_required',
        'requester_date',
        'account_opening_date',
        'start_date',
        'expiry_date',
        'letter_date',
        'card_transfer_date',
        'transaction_datetime',
        'ticket_issue_datetime'

    );
    public $arrayValueSplit = array('shipTo');
    public $arrayPasswords = array('password');
    public $arrayImageFolders = array(
        'file_on_disk_name' => 'Documents'
    );

    public $_transactionId;
    public $_post_data;
    public $_message = '';
    public $_persistent_id = '';

    /**
     * Create a new controller instance.
     */
    protected $emailService;


    /**
     * Store record from the form
     * It calls the _addNewRec function with the right input tag array
     * returns last insert id for new record
     */
    public function store()
    {

        $this->request = \request();

        $this->_post_data = request()->all();
        $table = $this->_post_data['table'];


        //save the record
        $this->_transactionId = $this->_addNewRec();
        $this->_persistent_id = $this->_transactionId; //keep track of the main record ID

        if (isset($this->_post_data['document_count'])) {

            //for attached documents we are only handling deleting those that have been deleted from end. the saving is done front end on the fly
            $documents = $this->_post_data['document'];
            $docTableType = $this->_post_data['doc_tableable_type'];
            $docTableId = $this->_post_data['doc_tableable_id'];
            AttachedDocument::deleteAttachedDocuments($documents, $docTableType, $docTableId);

        }
        if (isset($this->_post_data['particular_count'])) {

            $i = 0;
            foreach ($this->_post_data['particular']['item_table_id'] as $identifier){
                if($identifier == TBD_IDENTIFIER ){
                    $this->_post_data['particular']['item_table_id'][$i] = $this->_persistent_id;
                }
                $i++;
            }
            $this->multipleSave('particular', 'particular_count', 'ItemParticular');

        }

        if (isset($this->_post_data['f_request_particular_count'])) {

            $i = 0;
            foreach ($this->_post_data['f_request_particular']['fuel_request_id'] as $identifier){
                if($identifier == TBD_IDENTIFIER ){
                    $this->_post_data['f_request_particular']['fuel_request_id'][$i] = $this->_persistent_id;
                }
                $i++;
            }
            $this->multipleSave('f_request_particular', 'f_request_particular_count', 'FuelRequestParticular');

        }

        if (isset($this->_post_data['f_req_particular_mgt_tecom_routine_count'])) {

            $i = 0;
            foreach ($this->_post_data['f_req_particular_mgt_tecom_routine']['fuel_request_id'] as $identifier){
                if($identifier == TBD_IDENTIFIER ){
                    $this->_post_data['f_req_particular_mgt_tecom_routine']['fuel_request_id'][$i] = $this->_persistent_id;
                }
                $i++;
            }
            $this->multipleSave('f_req_particular_mgt_tecom_routine', 'f_req_particular_mgt_tecom_routine_count', 'FuelRequestCardEncumbrance');

        }

        //we have form 5 particulars to save
        if (isset($this->_post_data['f_form_five_particular_count'])) {

            $i = 0;
            foreach ($this->_post_data['f_form_five_particular']['form_five_id'] as $identifier){
                if($identifier == TBD_IDENTIFIER ){
                    $this->_post_data['f_form_five_particular']['form_five_id'][$i] = $this->_persistent_id;
                }
                $i++;
            }
            $this->multipleSave('f_form_five_particular', 'f_form_five_particular_count', 'FormFiveDetail');

        }

        //#start fuel request extra tables
        if (isset($this->_post_data['fuel_particulars'])) {
            FuelRequestParticular::saveParticulars($this->_persistent_id, $this->_post_data['fuel_particulars']);
        }

        if (isset($this->_post_data['funds_balances'])) {
            $i = 0;
            foreach ($this->_post_data['funds_balances']['fuel_request_id'] as $identifier){
                if($identifier == TBD_IDENTIFIER ){  $this->_post_data['funds_balances']['fuel_request_id'][$i] = $this->_persistent_id; }
                $i++;
            }
            $this->multipleSave('funds_balances', 'funds_balances_count', 'FuelRequestFundsBalance'); //FuelRequestFundsBalance::saveBalances($this->_persistent_id, $this->_post_data['funds_balances']);
        }

        if (isset($this->_post_data['fuel_issues'])) {
            FuelRequestFuelIssueDetail::saveFuelIssues($this->_persistent_id, $this->_post_data['fuel_issues']);
        }
        //#end fuel request extra tables

        //user groups
        if (isset($this->_post_data['group_users_count'])) {

            $this->multipleSave('group_users', 'group_users_count', 'GroupUser');

        }

        //initial mileage comment
        if (isset($this->_post_data['mileage_comments_count'])) {
            $i = 0;
            foreach ($this->_post_data['mileage_comments'] as $rawData){
                $this->_post_data['mileage_comments']['commentable_id'][$i] = $this->_persistent_id;
                $i++;
            }
            $this->multipleSave('mileage_comments', 'mileage_comments_count', 'Comment');
        }

        if($table == 'ServiceCenter' || $table == 'VehicleType' || $table == 'InsuranceCompany'|| $table == 'Itasset'|| $table == 'ItassetType'|| $table == 'OsVersion'|| $table == 'OfficeVersion'){

            $resp =  array(
                'success' => true,
                'message' => $this->_message,
                'id' => $this->_transactionId,
            );
   
            return $resp;



        }

    }

    /**
     * _addNewRec()
     * responsible for adding a new record into the system
     * Parameters: _input_table, _arr_input_fields, arrayId
     * Returns: 1 (on fail), array() (on success)
    */
	public function _addNewRec($arrayId = 'r_fld')
    {

        $this->_arr_input_fields = $this->_post_data[$arrayId];
        $this->_input_table = $this->_post_data['table'];

        $model = "App\\".$this->_input_table;

        $record = $model::find( isset($this->_post_data['fld_id'])?$this->_post_data['fld_id']:'' );
        if (!$record) $record = new $model();

        foreach($this->_arr_input_fields as $field => $value)
		{
			if(in_array($field,$this->arrayTimeStampFields)){
				$value = db_date_format($value);
				//$value = date("Y-m-d", strtotime($value));
			}
			elseif(in_array($field,$this->arrayPasswords)){
				$value = Hash::make($value);
            }
            elseif(array_key_exists($field,$this->arrayImageFolders)){

                /*
                 * So the file, uploaded prior using JQuery and stored to this path, so you need to understand how that happens before proceeding,
                 * Meaning by the time you are hear the file is already stored temporarily in some folder
                 * */
                $localFile = public_path('Documents/' . @$value);
                $fileName = $this->_arr_input_fields['doc_name'];
                $edmsFolder = $this->_arr_input_fields['edms_doc_path'];

                /*
                 * Attempt to send request to EDMS, ie move file to EDMS
                 * */
                $edms_status = EdmsDocumentUploadHandler::moveFileToEDMS($edmsFolder, $localFile, $fileName);

                /*
                 * Keep track of the result from the EDMS Request
                 * */
                $record->edmsRequestStatus = $edms_status;
                $this->_message .= '<strong>'.$fileName.'</strong><br>'.$edms_status->statusDescription.'<br>';

			}
			elseif(in_array($field,$this->arrayValueSplit)){
				$_a_values = $value;
				if(is_array($value)){
					$value = '';
					foreach($_a_values as $_val)
					{
						$value .= $_val.':::';
					}
				}
			}
            $record->$field = $value;
		}

        /*
        * This variable holds the result of the request to EDMS in case a request was made to EDMS
        * */
        if(isset($record->edmsRequestStatus)){
            $edmsRequestStatus = $record->edmsRequestStatus;
            unset($record->edmsRequestStatus); //clear the field such that no attempt to save it to DB is made
        }

        /*
         * If it's an attached document, update it's status
         * */
        if(isset($edmsRequestStatus)){

            //Document was successfully moved to EDMS
            if($edmsRequestStatus->statusCode == AppConstants::$STATUS_CODE_SUCCESS){
                $docStatus = ATTACHED_DOC_STATUS_UPLOADED_TO_EDMS;
                $edmsDocId = $edmsRequestStatus->createdEDMSDocumentId;
                $record->doc_status = $docStatus;
                $record->edms_doc_id = $edmsDocId;
                $record->save();
            }

        }else{

            $record->save();

        }

        /*=====================================
         * handle tables with special actions after save
         *==================================== */
        $this->handleTablesWithSpecialActionsAfterSave($record);
        /*====================================
         * #END
         *====================================*/

        if($this->_post_data['table'] == 'ServiceCenter' || $this->_post_data['table'] == 'VehicleType' || $this->_post_data['table'] == 'InsuranceCompany'|| $this->_post_data['table'] == 'Itasset'||$this->_post_data['table'] =='ItassetType'||$this->_post_data['table'] =='OsVersion'||$this->_post_data['table'] =='OfficeVersion'){
            $this->_message .= addSpaceInfrontOfCapsLetterInWord($this->_input_table).' successfully saved <br>';
            $this->_transactionId = $record->id;
        }else{
            echo addSpaceInfrontOfCapsLetterInWord($this->_input_table).' successfully saved <br>';
        }

        return $record->id;
    }

    /**
     * multipleSave()
     * We are saving multiple values from the form
     */
    function multipleSave($input_array, $row_count_array, $table)
    {

        unset($this->_post_data['new_array_']);
		$updateIds = array(

            'AttachedDocument'=>'id',
            'ItemParticular'=>'id',
            'FuelRequestParticular'=>'id',
            'FormFiveDetail'=>'id',
            'GroupUser'=>'id',
            'FuelRequestFundsBalance'=>'id',
            'FuelRequestCardEncumbrance'=>'id',
            'Comment'=>'id',

            'TrainingMaterial'=>'id',
            'CbActivityAttendance'=>'id',
            'CbActivityModule'=>'id',
            "BudgetItemAmount"=>'id',
            'CbActivityDay'=>'id',
            'TrainerImprovement'=>'id',
            'SurveyTrainingEvaluation'=>'id',
            'PmTeamMember'=>'id',
            'PmActivity'=>'id',
            'CbExpectedOutcome'=>'id',
            'CbActivityEntity'=>'id',
            'EntityAuditCount'=>'id',
            'PmAuditDate'=>'id',
            'CbActivityTrainer'=>'id',
            'EntityAllowancesBudget'=>'id',
            'EntityFuelBudget'=>'id',
            'Exception'=>'id',
            'PmAuditCountFundingSource'=>'id',
            'LegalCaseOfficer'=>'id',
            'LegalArea'=>'id',
            'EntityBudgetPlanAmount'=>'id',
            'LegalGround'=>'id',
            'MonthlyForexRate'=>'id',
            'ModuleTrainer'=>'id',
            'LegalDoc'=>'id',
            'CapacityGap'=>'id',

            'LetterTypeField'=>'id',
    );
		$important_fields = array(

			'AttachedDocument'=>'doc_name',
			'ItemParticular'=>'item',
			'FuelRequestParticular'=>'particular',
			'FuelRequestCardEncumbrance'=>'particularable_id',
			'FormFiveDetail'=>'description',
			'GroupUser'=>'username',
            'FuelRequestFundsBalance'=>'proposed_encumbrance_amount',
            'Comment'=>'comment',

            'TrainingMaterial'=>'material_name',
            'CbActivityAttendance'=>'cb_activity_person_id',
            'CbActivityModule'=>'module_id',
            "BudgetItemAmount"=>'amount',
            'CbActivityDay'=>'activity_date',
            'TrainerImprovement'=>'comment',
            'SurveyTrainingEvaluation'=>'comment',
            'PmTeamMember'=>'user_id',
            'PmActivity'=>'entity_id',
            'CbExpectedOutcome'=>'expected_outcome',
            'CbActivityEntity'=>'entity_id',
            'EntityAuditCount'=>'audit_type',
            'PmAuditDate'=>'activity',
            'CbActivityTrainer'=>'trainer_id',
            'EntityAllowancesBudget'=>'budget_item_id',
            'EntityFuelBudget'=>'budget_item_id',
            'Exception'=>'exception_title',
            'PmAuditCountFundingSource'=>'amount',
            'LegalCaseOfficer'=>'user_id',
            'LegalArea'=>'area',
            'EntityBudgetPlanAmount'=>'amount',
            'LegalGround'=>'ground',
            'MonthlyForexRate'=>'financial_year_id',
            'ModuleTrainer'=>'module_id',
            'LegalDoc'=>'legal_doc',
            'CapacityGap'=>'module_id',

            'LetterTypeField'=>'field_name',
		);
		$foreign_keys = array(
			'TrainingMaterial'=>'cb_activity_id',
			'AttachedDocument'=>'doc_tableable_id',
			'ItemParticular'=>'item_table_id',
			'FuelRequestParticular'=>'fuel_request_id',
			'FuelRequestCardEncumbrance'=>'fuel_request_id',
			'FormFiveDetail'=>'form_five_id',
			'GroupUser'=>'group_id',
			'FuelRequestFundsBalance'=>'fuel_request_id',
			'Comment'=>'commentable_id',

            'CbActivityAttendance'=>'cb_activity_person_id',
            'CbActivityModule'=>'cb_activity_id',
            "BudgetItemAmount"=>'commentable_id',
            'CbActivityDay'=>'cb_activity_id',
            'TrainerImprovement'=>'cb_activity_survey_id',
            'SurveyTrainingEvaluation'=>'cb_activity_survey_id',
            'PmTeamMember'=>'pm_team_id',
            'PmActivity'=>'activity_type_id',
            'CbExpectedOutcome'=>'cb_activity_id',
            'CbActivityEntity'=>'cb_activity_id',
            'EntityAuditCount'=>'pm_plan_id',
            'PmAuditDate'=>'pm_activity_id',
            'CbActivityTrainer'=>'cb_activity_id',
            'EntityAllowancesBudget'=>'entity_id',
            'EntityFuelBudget'=>'entity_id',
            'Exception'=>'mgt_letter_section_id',
            'PmAuditCountFundingSource'=>'entity_audit_count_id',
            'LegalCaseOfficer'=>'commentable_id',
            'LegalArea'=>'commentable_id',
            'EntityBudgetPlanAmount'=>'entity_budget_plan_id',
            'LegalGround'=>'commentable_id',
            'MonthlyForexRate'=>'currency_id',
            'ModuleTrainer'=>'commentable_id',
            'LegalDoc'=>'commentable_id',
            'CapacityGap'=>'training_needs_assessment_id',

            'LetterTypeField'=>'letter_type_id',
    );

		$items = $this->_post_data[$row_count_array];
        $num = count($items);


		if($num > 0){
			$ids = array();
			$id = '';
			$error = '';

			$this->_post_data['table'] = $table;
			$this->_post_data['field_'] = $updateIds[$table];



			for($i = 0; $i<$num; $i++){
				$id = $this->_post_data['fld_id'] = $this->_post_data[$input_array][$updateIds[$table]][$i];

				(($id != '' )?array_push($ids,$id):'');

				if(@$this->_post_data[$input_array][$important_fields[$table]][$i] == '') continue;
				foreach($this->_post_data[$input_array] as $_fld => $val){
					if($_fld == $foreign_keys[$table] && $val[$i] == ''){
						$val[$i]= $this->_transactionId;
                    }
                    //echo $_fld;
					$this->_post_data['new_array_'][$_fld] = $val[$i];
				}
                $new_id = $this->_addNewRec('new_array_');
                array_push($ids,$new_id);
                //echo $this->Action->getError();
			}

			//clear missing items

			if(isset($this->_post_data['delete_rows']) && $this->_post_data['delete_rows'] == 1){

                $foreignId = ($this->_transactionId != '')?$this->_transactionId:$this->_post_data[$input_array][$foreign_keys[$table]][0];

                $model = "App\\".$table;
                $result=$model ::where($foreign_keys[$table],$foreignId);

                if($table == 'EntityAllowancesBudget' || $table == 'EntityFuelBudget'){
                    $activity = $this->_post_data['activity'];
                    $result = $result->where('activity',$activity);
                }elseif($table == 'ItemParticular'){
                    $item_table = $this->_post_data['item_table'];
                    $result = $result->where('item_table_type',$item_table);
                }

                $tablesWithSpecialDeletionLogic = ['AttachedDocument'];
                if(!in_array($table, $tablesWithSpecialDeletionLogic)){
                    $result->whereNotIn('id',$ids)->delete();
                }else{

                    if($table == 'AttachedDocument'){
                        $idsThatDontExist = $result->where('doc_tableable_type',$this->_post_data['doc_tableable_type'])->whereNotIn('id',$ids)->pluck("id")->toArray();
                        UploadController::deleteAttachedFiles( $idsThatDontExist);
                    }

                }

			}

		}

    }

    /**
     * delete()
     * responsible for deleting a record from the system
     * Parameters: table, id
     * Returns: 1 (on fail), array() (on success)
    */
	function delete($table='',$id = 0)
    {
        $model = "App\\".$table;
        $record = $model::find($id);
        $record->delete();
        echo $table.' deleted successfully';
    }

    public function handleTablesWithSpecialActionsAfterSave($record)
    {

        if ($this->_post_data['table'] == 'Vehicle') {
            //we are supposed to update the default driver
            $defaultDriver = $this->_post_data['default_driver'];
            Driver::updateDefaultVehicle($defaultDriver, $record->id);
        }

    }

    private function saveProviderToEmis()
    {

        $this->_arr_input_fields = $this->_post_data['r_fld'];

        $data = [];
        foreach($this->_arr_input_fields as $field => $value)
        {
            $data[$field] = $value;
        }

        $dataArry = [];
        $dataArry['providers'] = array($data);

        $resp = DataLoader::saveProviderInEmis($dataArry);
        $message = $resp->statusCode != 0 ? "Error occurred on saving provider" : 'Provider successfully saved';
        echo $message;

    }

    public function launchLetterMovement(): void
    {

        //its a launch letter movement request
        $letterMovementUsersTo = [];
        $assignedToCorporate = $this->_post_data['r_fld']['assign_to_corporate'];
        $assignedToCbas = $this->_post_data['r_fld']['assign_to_cbas'];
        $assignedToAdvisory = $this->_post_data['r_fld']['assign_to_advisory'];
        $assignedToPm = $this->_post_data['r_fld']['assign_to_performance_monitoring'];
        $assignedToOperations = $this->_post_data['r_fld']['assign_to_operations'];
        $assignedToLegal = $this->_post_data['r_fld']['assign_to_legal'];
        $assignedToMac = $this->_post_data['r_fld']['assign_to_mac'];

        //check enabled tags
        $enabledLegal = $this->_post_data['r_fld']['legal_tag'] == 1;
        $enabledMac = $this->_post_data['r_fld']['mac_tag'] == 1;
        $enabledCorp = $this->_post_data['r_fld']['corp_tag'] == 1;
        $enabledAdvisory = $this->_post_data['r_fld']['advisory_tag'] == 1;
        $enabledPm = $this->_post_data['r_fld']['pm_tag'] == 1;
        $enabledOperations = $this->_post_data['r_fld']['operations_tag'] == 1;
        $enabledCbas = $this->_post_data['r_fld']['cbas_tag'] == 1;

        //if department tag is enabled and a user is set we assign them to the UserTo list
        if (isset($assignedToCbas) && $assignedToCbas != null && $enabledCbas) {
            $data = [];
            $data['username'] = $assignedToCbas;
            $data['name'] = $this->_post_data['r_fld']['assign_to_cbas_name'];
            $data['department'] = $this->_post_data['r_fld']['assign_to_cbas_department'];
            $letterMovementUsersTo[] = $data;
        }
        if (isset($assignedToAdvisory) && $assignedToAdvisory != null && $enabledAdvisory) {
            $data = [];
            $data['username'] = $assignedToAdvisory;
            $data['name'] = $this->_post_data['r_fld']['assign_to_advisory_name'];
            $data['department'] = $this->_post_data['r_fld']['assign_to_advisory_department'];
            $letterMovementUsersTo[] = $data;
        }
        if (isset($assignedToPm) && $assignedToPm != null && $enabledPm) {
            $data = [];
            $data['username'] = $assignedToPm;
            $data['name'] = $this->_post_data['r_fld']['assign_to_performance_monitoring_name'];
            $data['department'] = $this->_post_data['r_fld']['assign_to_performance_monitoring_department'];
            $letterMovementUsersTo[] = $data;
        }
        if (isset($assignedToCorporate) && $assignedToCorporate != null && $enabledCorp) {
            $data = [];
            $data['username'] = $assignedToCorporate;
            $data['name'] = $this->_post_data['r_fld']['assign_to_corporate_name'];
            $data['department'] = $this->_post_data['r_fld']['assign_to_corporate_department'];
            $letterMovementUsersTo[] = $data;
        }
        if (isset($assignedToOperations) && $assignedToOperations != null && $enabledOperations) {
            $data = [];
            $data['username'] = $assignedToOperations;
            $data['name'] = $this->_post_data['r_fld']['assign_to_operations_name'];
            $data['department'] = $this->_post_data['r_fld']['assign_to_operations_department'];
            $letterMovementUsersTo[] = $data;
        }
        if (isset($assignedToLegal) && $assignedToLegal != null && $enabledLegal) {
            $data = [];
            $data['username'] = $assignedToLegal;
            $data['name'] = $this->_post_data['r_fld']['assign_to_legal_name'];
            $data['department'] = $this->_post_data['r_fld']['assign_to_legal_department'];
            $letterMovementUsersTo[] = $data;
        }
        if (isset($assignedToMac) && $assignedToMac != null && $enabledMac) {
            $data = [];
            $data['username'] = $assignedToMac;
            $data['name'] = $this->_post_data['r_fld']['assign_to_mac_name'];
            $data['department'] = $this->_post_data['r_fld']['assign_to_mac_department'];
            $letterMovementUsersTo[] = $data;
        }

        //get the date sent
        $dateSent = Carbon::now();
        $emailList = [];

        //this guy uses polymorphic relationships, so these fields carter for that
        $model = $this->_post_data['r_fld']['model'];
        $modelId = $this->_post_data['r_fld']['model_id'];

        //foreach user create a letter movement entry
        foreach ($letterMovementUsersTo as $userData) {

            $letterMovt = new LetterMovement();

            //build mail list data
            $mailListData = [
                'department' => $userData['department'],
                'email' => 'it@ppda.go.ug' //'it@ppda.go.ug' //$userData['username']
            ];
            $emailList[] = $mailListData;

            $letterMovt->to = $userData['username'];
            $letterMovt->to_name = $userData['name'];
            $letterMovt->to_department = $userData['department'];

           //$letterMovt->letter_id = $this->_post_data['r_fld']['letter_id'];
            $letterMovt->moveable_id = $modelId;
            $letterMovt->moveable_type = $model;

            $letterMovt->from = $this->_post_data['r_fld']['from'];
            $letterMovt->from_name = $this->_post_data['r_fld']['from_name'];
            $letterMovt->from_department = $this->_post_data['r_fld']['from_department'];
            $letterMovt->required_action = $this->_post_data['r_fld']['required_action'];
            $letterMovt->deadline_for_action = db_date_format($this->_post_data['r_fld']['deadline_for_action']);
            $letterMovt->date_sent = $dateSent;

            $letterMovt->save();

        }


        //update either the incoming letters or internal memo table based on the model

        if($model == 'App\IncomingLetter'){

//            $letterId = $this->_post_data['r_fld']['letter_id'];
            $letterId = $modelId;
            $letter = IncomingLetter::find($letterId);
            $letter->assign_to_legal = $assignedToLegal;
            $letter->assign_to_mac = $assignedToMac;
            $letter->assign_to_corporate = $assignedToCorporate;
            $letter->assign_to_performance_monitoring = $assignedToPm;
            $letter->assign_to_advisory = $assignedToAdvisory;
            $letter->assign_to_cbas = $assignedToCbas;
            $letter->assign_to_operations = $assignedToOperations;
            $letter->save();

        }

        //send email notification
        $emailDataLetterOrMemoIdId = $modelId;
        $emailDataModelType = $model == 'App\IncomingLetter' ? AppConstants::$LETTER_MOVT_DOC_TYPES_INCOMING_LETTER : AppConstants::$LETTER_MOVT_DOC_TYPES_INTERNAL_MEMO;
        $emailDataFromName = $this->_post_data['r_fld']['from_name'];
        $actionRequired = $this->_post_data['r_fld']['required_action'];
        $emailDataDateSent = date("F d Y", strtotime($dateSent));
        $emailDataDeadlineDate = date("F d Y", strtotime($this->_post_data['r_fld']['deadline_for_action']));

        LetterMovementController::sendLetterForwardedNotificationEmail($emailList, $emailDataLetterOrMemoIdId, $emailDataFromName, $emailDataDateSent, $emailDataDeadlineDate, $actionRequired, $emailDataModelType);

        echo 'Letter movement successfully launched';

    }

    private function createLetterAssociation()
    {

        $associateLetterId = $this->_post_data['letter_id'];
        $associateLetterType = $this->_post_data['letter_category'];

        if(array_key_exists('incoming',$this->_post_data['associate_letters'])){

            $selectedIncomingLetters = $this->_post_data['associate_letters']['incoming'];
            foreach ($selectedIncomingLetters as $linkedLetterId){

                //todo check if association exists
                $linkedLetterType = 'incoming';

                $exists = LetterAssociation::
                where('associate_letter_id',$associateLetterId)->
                where('associate_letter_type',$associateLetterType)->
                where('associated_letter_id',$linkedLetterId)->
                where('associated_letter_type',$linkedLetterType)->first();

                if($exists == null){
                    $association = new LetterAssociation();
                    $association->associate_letter_id = $associateLetterId;
                    $association->associate_letter_type = $associateLetterType;
                    $association->associated_letter_id = $linkedLetterId;
                    $association->associated_letter_type = $linkedLetterType;
                    $association->save();
                }

            }

        }
        else if(array_key_exists('outgoing',$this->_post_data['associate_letters'])){

            $selectedOutgoingLetters = $this->_post_data['associate_letters']['outgoing'];
            foreach ($selectedOutgoingLetters as $linkedLetterId){

                //todo check if association exists
                $linkedLetterType = 'outgoing';

                $exists = LetterAssociation::
                where('associate_letter_id',$associateLetterId)->
                where('associate_letter_type',$associateLetterType)->
                where('associated_letter_id',$linkedLetterId)->
                where('associated_letter_type',$linkedLetterType)->first();

                if($exists == null){
                    $association = new LetterAssociation();
                    $association->associate_letter_id = $associateLetterId;
                    $association->associate_letter_type = $associateLetterType;
                    $association->associated_letter_id = $linkedLetterId;
                    $association->associated_letter_type = $linkedLetterType;
                    $association->save();
                }

            }

        }

        echo 'Association(s) successfully created';

    }


}
