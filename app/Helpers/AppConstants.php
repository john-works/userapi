<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 2/5/2018
 * Time: 17:45
 */


namespace app\Helpers;


class AppConstants {


    const IN_DEBUG = true;

    const WORK_FLOW_ROLE_OWNER = 'owner';
    const WORK_FLOW_ROLE_HOD = 'hod';
    const WORK_FLOW_ROLE_DIRECTOR = 'director';
    const WORK_FLOW_ROLE_SUPERVISOR = 'supervisor';
    const WORK_FLOW_ROLE_ALL = 'all';


    public static $STATUS_CODE_SUCCESS = "0";
    public static $STATUS_CODE_FAILED = "100";
    public static $STATUS_DESC_SUCCESS = "SUCCESS";

    public static $GENERAL_ERROR_AT_TDS = "SOMETHING WENT WRONG ON OUR SIDE";
    public static $API_ROLE_CODE_RECEPTION = "RECEPTION USER";
    public static $API_ROLE_CODE_ED = "EXECUTIVE DIRECTOR USER";
    public static $API_ROLE_CODE_NORMAL_USER = "NORMAL USER";
    public static $API_ROLE_CODE_REGISTRY = "REGISTRY USER";
    public static $API_ROLE_CODE_SUPER_USER= "SUPER USER";
    public static $ROLE_CODE_RECEPTION = 'reception';
    public static $ROLE_CODE_ED = 'ed_office';
    public static $ROLE_CODE_REGISTRY = 'registry';
    public static $ROLE_CODE_SUPER_USER = 'super_user';
    const dateFormat = "d-m-Y";
    public static $ACCOUNT_TYPE_ADMIN = '000';//'ADMIN';
    public static $ACCOUNT_TYPE_USER = 'USER';

    public static $ACTIVE_MOD_USERS = 'users';
    public static $ACTIVE_MOD_PROFILES = 'profiles';
    public static $ACTIVE_MOD_DASHBOARD = 'dashboard';
    public static $ACTIVE_MOD_DOC_TYPES = 'document_types';
    public static $ACTIVE_MOD_DOC_LIBRARY = 'library';
    public static $ACTIVE_MOD_SETTINGS = 'settings';
    public static $ACTIVE_MOD_APPRAISAL = 'appraisals';
    public static $ACTIVE_MOD_MY_APPRAISALS = 'my_appraisals';
    public static $ACTIVE_MOD_SUPERVISOR_APPRAISALS = 'supervisor_appraisals';
    public static $ACTIVE_MOD_HOD_APPRAISALS = 'hod_appraisals';
    public static $ACTIVE_MOD_DIRECTOR_APPRAISALS = 'director_appraisals';
    public static $ACTIVE_MOD_HUMAN_RESOURCE = 'hr';

    public static $STAFF_CAT_L2_L4 = "L2_L4";
    public static $STAFF_CAT_L4_L6 = "L4_L6";
    public static $STAFF_CAT_L7_L8 = "L7_L8";

    public static $WORK_FLOW_STEP1_OWNER = "owner";
    public static $WORK_FLOW_STEP2_SUPERVISOR = "supervisor";
    public static $WORK_FLOW_STEP3_HOD = "hod";
    public static $WORK_FLOW_STEP4_ED = "ed";
    public static $WORK_FLOW_STEP5_DONE = "done";

    public static $VISIBLE_FORM_STEP_1 = "step_1";
    public static $VISIBLE_FORM_STEP_2 = "step_2";
    public static $VISIBLE_FORM_STEP_3 = "step_3";
    public static $VISIBLE_FORM_STEP_4 = "step_4";
    public static $VISIBLE_FORM_ALL = "all";


    public static $SECTION_A = "sec_a";
    public static $SECTION_B = "sec_b";
    public static $SECTION_C = "sec_c";
    public static $SECTION_D = "sec_d";
    public static $SECTION_D1 = "sec_d_add";
    public static $SECTION_E = "sec_e";
    public static $SECTION_F = "sec_f";
    public static $SECTION_G = "sec_g";
    public static $SECTION_H = "sec_h";
    public static $SECTION_I = "sec_i";
    public static $SECTION_J = "sec_j";
    public static $SECTION_K = "sec_k";
    public static $SECTION_L = "sec_l";
    public static $SECTION_M = "sec_m";
    public static $SECTION_N = "sec_n";
    public static $SECTION_O = "sec_o";
    public static $EDIT_MODE_ON = "edit-on";
    public static $EDIT_MODE_OFF = "edit-off";
    public static $MSG_SESSION_TIMEOUT_LOGIN_AGAIN = "We failed to get the logged in user. Please login again and try again";
    public static $MSG_BAD_REQUEST_JSON_EXPECTED = 'Bad Request type, JSON Expected';
    public static $MSG_INVALID_APPROVAL_STATUS = 'Invalid Approval Status';
    public static $ROLE_CODE_HUMAN_RESOURCE = 'HR';
    public static $ROLE_CODE_ADMIN = 'ADMIN';
    public static $REQUIRE_CHANGE_PASSWORD = "CHANGE PASSWORD";
    public static $SUPPORTED_APPLICATIONS = ['staff-appraisal','letter-movement','emis','dms','ppda-admin-app','leave-management','recruitment','stores','employee-lifecycle'];
    public static $SUPPORTED_APPLICATIONS_STAFF_APPRAISAL = 'staff-appraisal';
    public static $SUPPORTED_APPLICATIONS_LETTER_MOVEMENT = 'letter-movement';
    public static $SUPPORTED_APPLICATIONS_EMIS = 'emis';
    public static $SUPPORTED_APPLICATIONS_DRIVER_MANAGEMENT_SYSTEM = 'dms';
    public static $SUPPORTED_APPLICATIONS_ADMIN_APP = 'ppda-admin-app';
    public static $SUPPORTED_APPLICATIONS_LEAVE_MANAGEMENT = 'leave-management';
    public static $SUPPORTED_APPLICATIONS_EMPLOYEE_LIFECYCLE = 'employee-lifecycle';
    public static $SUPPORTED_APPLICATIONS_RECRUITMENT = 'recruitment';
    public static $SUPPORTED_APPLICATIONS_STORES = 'stores';

    public static function generalError($actualError) {

        try{

            $data = [
                'error_message' => 'PORTAL-ERROR ' . $actualError
            ];
         //   $resp = DataLoader::saveErrorLog($data);

        }catch (\Exception $exception){

        }finally{

            if($actualError instanceof \Exception){
                $message = $actualError->getMessage();
            }else{
                $message = $actualError;
            }

            return !AppConstants::IN_DEBUG ? AppConstants::$GENERAL_ERROR_AT_TDS : AppConstants::$GENERAL_ERROR_AT_TDS . ' ' .$message;
        }

    }

}