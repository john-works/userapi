<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 5/16/2019
 * Time: 15:28
 */


namespace App\Helpers;


class EndPoints {


   // const SERVER_IP = '192.168.33.27';
   // const SERVER_IP = '192.168.33.27';
    // const SERVER_IP = 'localhost';
    const SERVER_IP = 'localhost';
    public static $BASE_URL_USER_MANAGEMENT = 'http://'.self::SERVER_IP.':7001/api';
    public static $USERS_GET_AUTHENTICATED_USER = '/users/auth-user';
    public static $BASE_URL = 'http://'.self::SERVER_IP.':7001/api';
    public static $BASE_URL_APPRAISAL_APP_API = "http://".self::SERVER_IP.":9001/api";
    public static $BASE_URL_FLEET_API = "http://".self::SERVER_IP.":8002/api";
    public static $USER_MANAGEMENT_LOGIN_PAGE =  'http://'.self::SERVER_IP.'/';
    public static $USER_MANAGEMENT_LOGOUT_LINK =  'http://'.self::SERVER_IP.'/admin/signout';
    public static $BASE_URL_LEAVE_MANAGEMENT_API =  'http://'.self::SERVER_IP.':10001/api';
    public static $PUBLIC_HOLIDAYS_IN_RANGE = "/holidays_range";
    public static $PUBLIC_HOLIDAYS_IN_YEAR = "/holidays_year";
    /*
     * End points for users
     * */
    public static $USERS_LOGIN = '/user/login';
    public static $USERS_RESET_PASSWORD = '/user/reset-password';
    public static $USERS_CHANGE_PASSWORD = '/user/change-password';
    public static $USERS_CHANGE_DEFAULT_PASSWORD = '/user/password/change-default';
    public static $USERS_STORE = '/user';
    public static $USERS_UPDATE = '/user';
    public static $USERS_DELETE = '/user';
    public static $USERS_ALL = '/users';
    public static $VEHICLES_ALL = 'http://'.self::SERVER_IP.':8002/api/vehicles';
    public static $USERS_UPDATE_PROFILE_BY_USER = '/user/owner-profile-update';

    public static $USERS_USER_ACADEMIC_BG_SAVE = '/user-academic-background';
    public static $USERS_USER_ACADEMIC_BG_UPDATE = '/user-academic-background';
    public static $USERS_USER_ACADEMIC_BG_ALL = '/user-academic-backgrounds';
    public static $USERS_USER_ACADEMIC_BG_DELETE = '/user-academic-background';

    public static $USER_CONTRACT_SAVE = '/user-contract';
    public static $USER_CONTRACT_UPDATE = '/user-contract';
    public static $USER_CONTRACT_ALL = '/user-contracts';
    public static $USER_CONTRACT_DELETE = '/user-contract';

    /*
     * End points for organizations
     * */
    public static $ORGANIZATIONS_STORE = '/organization';
    public static $ORGANIZATIONS_UPDATE = '/organization';
    public static $ORGANIZATIONS_DELETE = '/organization';
    public static $ORGANIZATIONS_ALL = '/organizations';

    /*
     * End points for regional offices
     * */
    public static $REGIONAL_OFFICES_STORE = '/regional-office';
    public static $REGIONAL_OFFICES_UPDATE = '/regional-office';
    public static $REGIONAL_OFFICES_DELETE = '/regional-office';
    public static $REGIONAL_OFFICES_ALL = '/regional-offices';

    /*
     * End points for departments
     * */
    public static $DEPARTMENTS_STORE = '/department';
    public static $DEPARTMENTS_UPDATE = '/department';
    public static $DEPARTMENTS_DELETE = '/department';
    public static $DEPARTMENTS_ALL = '/departments';

    /*
     * End points for departments units
     * */
    public static $DEPARTMENT_UNIT_STORE = '/department-unit';
    public static $DEPARTMENT_UNIT_UPDATE = '/department-unit';
    public static $DEPARTMENT_UNIT_DELETE = '/department-unit';
    public static $DEPARTMENT_UNIT_ALL = '/department-units';

    /*
    * End points for role codes
    * */
    public static $ROLE_CODES_STORE = '/role-code';
    public static $ROLE_CODES_UPDATE = '/role-code';
    public static $ROLE_CODES_DELETE = '/role-code';
    public static $ROLE_CODES_ALL = '/role-codes';

    /*
   * End points for employee categories
   * */
    public static $EMPLOYEE_CATEGORIES_STORE = '/employee-category';
    public static $EMPLOYEE_CATEGORIES_UPDATE = '/employee-category';
    public static $EMPLOYEE_CATEGORIES_DELETE = '/employee-category';
    public static $EMPLOYEE_CATEGORIES_ALL = '/employee-categories';


    /*
     * Application Stats
     * */
    public static $APPLICATION_STATS_ALL = '/app-stats';


    /*
    * End points for appraisal
    * */
    public static $APPRAISAL_STRATEGIC_OBJECTIVES_ALL = '/appraisal-strategic-objectives';
    public static $APPRAISAL_STRATEGIC_OBJECTIVES_SAVE = '/appraisal-strategic-objective';
    public static $APPRAISAL_STRATEGIC_OBJECTIVES_UPDATE = '/appraisal-strategic-objective';
    public static $APPRAISAL_STRATEGIC_OBJECTIVES_DELETE = '/appraisal-strategic-objective';


    public static $APPRAISAL_COMPETENCE_CATEGORIES_ALL = '/appraisal-competence-categories';
    public static $APPRAISAL_SAVE_APPRAISAL = '/appraisal';
    public static $APPRAISAL_ALL = '/appraisals';
    public static $APPRAISAL_GET = '/appraisal';
    public static $APPRAISAL_TOP_3 = '/appraisals/latest';


    public static $APPRAISAL_PERSONAL_DETAILS_UPDATE = '/appraisal-personal-detail';

    public static $APPRAISAL_ACADEMIC_BG_SAVE = '/appraisal-academic-backgrounds/save';
    public static $APPRAISAL_ACADEMIC_BG_UPDATE = '/appraisal-academic-backgrounds/update';

    public static $APPRAISAL_KEY_DUTIES_SAVE = '/appraisal-key-duties/save';
    public static $APPRAISAL_KEY_DUTIES_UPDATE = '/appraisal-key-duties/update';

    public static $APPRAISAL_ASSIGNMENTS_SAVE = '/appraisal-assignments/save';
    public static $APPRAISAL_ASSIGNMENTS_UPDATE = '/appraisal-assignments/update';

    public static $APPRAISAL_ASSIGNMENTS_SCORES_SAVE = '/appraisal-assignment-score';
    public static $APPRAISAL_ASSIGNMENTS_SCORES_UPDATE = '/appraisal-assignment-score';

    public static $APPRAISAL_ASSIGNMENTS_SUMMARY_SAVE = '/appraisal-assignment-summary';
    public static $APPRAISAL_ASSIGNMENTS_SUMMARY_UPDATE = '/appraisal-assignment-summary';

    public static $APPRAISAL_ADDITIONAL_ASSIGNMENTS_SAVE = '/appraisal-additional-assignments/save';
    public static $APPRAISAL_ADDITIONAL_ASSIGNMENTS_UPDATE = '/appraisal-additional-assignments/update';

    public static $APPRAISAL_ADDITIONAL_ASSIGNMENTS_SCORES_SAVE = '/appraisal-additional-assignment-score';
    public static $APPRAISAL_ADDITIONAL_ASSIGNMENTS_SCORES_UPDATE = '/appraisal-additional-assignment-score';

    public static $APPRAISAL_PERFORMANCE_GAPS_SAVE = '/appraisal-performance-gaps/save';
    public static $APPRAISAL_PERFORMANCE_GAPS_UPDATE = '/appraisal-performance-gaps/update';

    public static $APPRAISAL_PERFORMANCE_CHALLENGES_SAVE = '/appraisal-performance-challenges/save';
    public static $APPRAISAL_PERFORMANCE_CHALLENGES_UPDATE = '/appraisal-performance-challenges/update';

    public static $APPRAISAL_PERFORMANCE_SUMMARY_SAVE = '/appraisal-train-summary';
    public static $APPRAISAL_PERFORMANCE_SUMMARY_UPDATE = '/appraisal-train-summary';

    public static $APPRAISAL_COMPETENCE_ASSESSMENT_SAVE = '/appraisal-competence-assessments/save';
    public static $APPRAISAL_COMPETENCE_ASSESSMENT_UPDATE = '/appraisal-competence-assessments/update';

    public static $APPRAISAL_COMPETENCE_ASSESSMENT_SCORES_SAVE = '/appraisal-competence-assessment-score';
    public static $APPRAISAL_COMPETENCE_ASSESSMENT_SCORES_UPDATE = '/appraisal-competence-assessment-score';
    public static $APPRAISAL_COMPETENCE_ASSESSMENT_SUMMARY_SAVE = '/appraisal-competence-assessment-summary';
    public static $APPRAISAL_COMPETENCE_ASSESSMENT_SUMMARY_UPDATE = '/appraisal-competence-assessment-summary';

    public static $APPRAISAL_WORK_PLAN_SAVE = '/appraisal-work-plans/save';
    public static $APPRAISAL_WORK_PLAN_UPDATE = '/appraisal-work-plans/update';

    public static $APPRAISAL_APPRAISER_COMMENT_SAVE = '/appraisal-appraiser-comment';
    public static $APPRAISAL_APPRAISER_COMMENT_UPDATE = '/appraisal-appraiser-comment';

    public static $APPRAISAL_STRENGTH_AND_WEAKNESS_SAVE = '/appraisal-strengths-and-weakness';
    public static $APPRAISAL_STRENGTH_AND_WEAKNESS_UPDATE = '/appraisal-strengths-and-weakness';

    public static $APPRAISAL_APPRAISER_RECOMMENDATION_SAVE = '/appraisal-appraiser-recommendation';
    public static $APPRAISAL_APPRAISER_RECOMMENDATION_UPDATE = '/appraisal-appraiser-recommendation';

    public static $APPRAISAL_SUPERVISOR_DECLARATION_SAVE = '/appraisal-supervisor-declaration';
    public static $APPRAISAL_SUPERVISOR_DECLARATION_UPDATE = '/appraisal-supervisor-declaration';

    public static $APPRAISAL_HOD_COMMENT_SAVE = '/appraisal-hod-comment';
    public static $APPRAISAL_HOD_COMMENT_UPDATE = '/appraisal-hod-comment';

    public static $APPRAISAL_APPRAISEE_REMARK_SAVE = '/appraisal-appraisee-remark';
    public static $APPRAISAL_APPRAISEE_REMARK_UPDATE = '/appraisal-appraisee-remark';

    public static $APPRAISAL_DIRECTOR_COMMENT_SAVE = '/appraisal-director-comment';
    public static $APPRAISAL_DIRECTOR_COMMENT_UPDATE = '/appraisal-director-comment';

    public static $APPRAISAL_WORKFLOW_START = '/appraisal/workflow-start';
    public static $APPRAISAL_WORKFLOW_MOVE = '/appraisal/workflow-move';
    public static $APPRAISAL_WORKFLOW_CANCEL = '/appraisal/workflow-cancel';

    public static $APPRAISAL_UPDATE_APPROVERS = '/appraisal/update-approvers';


    public static $COMPETENCE_CATEGORY_ALL = '/admin/appraisal-competence-categories';
    public static $COMPETENCE_CATEGORY_SAVE = '/appraisal-competence-category';
    public static $COMPETENCE_CATEGORY_UPDATE = '/appraisal-competence-category';
    public static $COMPETENCE_CATEGORY_DELETE = '/appraisal-competence-category';

    public static $COMPETENCES_FOR_CATEGORY_ID = '/appraisal-competences';
    public static $COMPETENCES_SAVE = '/appraisal-competence';
    public static $COMPETENCES_UPDATE = '/appraisal-competence';
    public static $COMPETENCES_DELETE = '/appraisal-competence';


    public static $BEHAVIORAL_COMPETENCE_CATEGORY_ALL = '/behavioral-competence-categories';
    public static $BEHAVIORAL_COMPETENCE_CATEGORY_SAVE = '/behavioral-competence-category';
    public static $BEHAVIORAL_COMPETENCE_CATEGORY_UPDATE = '/behavioral-competence-category';
    public static $BEHAVIORAL_COMPETENCE_CATEGORY_DELETE = '/behavioral-competence-category';

    public static $BEHAVIORAL_COMPETENCES_FOR_CATEGORY_ID = '/behavioral-competences';
    public static $BEHAVIORAL_COMPETENCES_SAVE = '/behavioral-competence';
    public static $BEHAVIORAL_COMPETENCES_UPDATE = '/behavioral-competence';
    public static $BEHAVIORAL_COMPETENCES_DELETE = '/behavioral-competence';


    public static $ERROR_LOG_SAVE = '/error-log';

    public static $LETTER_MOVEMENT_APP_END_POINT = "http://".self::SERVER_IP.":8000/users/auth/";
    public static $LETTER_APPRAISAL_APP_END_POINT = "http://".self::SERVER_IP.":9000/users/auth/";
   public static $EMIS_APP_AUTHENTICATION_END_POINT = "/log_in_to_emis";
  public static $EMIS_APP_HOME_END_POINT = "http://localhost:10000/home";
  public static $EMIS_API_BASE_URL = "http://".self::SERVER_IP.":10000/external";
  public static $EMIS_APP_LOGIN_REDIRECT = "http://".self::SERVER_IP.":10000/external/log_in_user/";

    public static $DRIVER_MANAGEMENT_APP_END_POINT = "http://".self::SERVER_IP.":8002/users/auth/";
    public static $STORES_END_POINT = "http://" . self::SERVER_IP . ":10005/users/auth/";
    public static $EMPLOYEE_LIFECYCLE_END_POINT = "http://" . self::SERVER_IP . ":10003/users/auth/";
    public static $LIBRARY_END_POINT = "http://" . self::SERVER_IP . ":10006/users/auth/";

    public static $EMIS_PPDA_USERS_GET = 'http://'.self::SERVER_IP.':7001/api/users';
    public static $FUEL_ISSUE_STORE = "/incoming_fuel_issue_store";
    public static $STORES_GET_PENDING_ACTIONS = 'http://'.self::SERVER_IP.':10005/api/get_pending_actions/';
    public static $FLEET_GET_PENDING_ACTIONS = 'http://'.self::SERVER_IP.':8002/api/get_pending_actions/';
    public static $EMIS_GET_PENDING_ACCREDITATIONS = 'http://'.self::SERVER_IP.':10000/api/get_pending_accreditations';
    public static $EMIS_GET_PENDING_DEVIATIONS = 'http://'.self::SERVER_IP.':10000/api/get_pending_deviations';
    public static $EMIS_GET_LEGAL_SUMMARY = 'http://'.self::SERVER_IP.':10000/api/get_legal_summary';
    public static $EMIS_GET_AUDIT_TRACKER_SUMMARY = 'http://'.self::SERVER_IP.':10000/api/get_audit_tracker_summary';
    public static $app_usage_tracker = 'http://'.self::SERVER_IP.':80/api/app/usage/tracker';
    public static $FLEET_GET_LICENSE_EXPIRY = 'http://'.self::SERVER_IP.':8002/api/get_license_expiry';
    public static $FLEET_GET_INSURANCE_EXPIRY = 'http://'.self::SERVER_IP.':8002/api/get_insurance_expiry';
    public static $FLEET_GET_SERVICE_EXPIRY = 'http://'.self::SERVER_IP.':8002/api/get_service_expiry';
    public static $FLEET_GET_LAPSED_MILEAGE = 'http://'.self::SERVER_IP.':8002/api/get_lapsed_mileage';
    public static $FLEET_GET_DRIVER_REQUESTS = 'http://'.self::SERVER_IP.':8002/api/get_driver_requests/';
    public static $FLEET_CREATE_DRIVER_REQUEST = 'http://'.self::SERVER_IP.':8002/api/create_driver_request';
    public static $STORES_GET_TICKETS = 'http://'.self::SERVER_IP.':10005/api/get_tickets/';
    public static $STORES_SAVE_TICKETS = 'http://'.self::SERVER_IP.':10005/api/save_tickets';
    public static $STORES_GET_ISSUE_CATEGORIES = 'http://'.self::SERVER_IP.':10005/api/get_issue_categories';
    public static $STORES_CREATE_TICKET = 'http://'.self::SERVER_IP.':10005/api/create_ticket';
    public static $EMIS_GET_AUDIT_TRACKER_SUMMARY_2='http://'.self::SERVER_IP.':10000/api/get_audit_tracker_summary_2';
    public static $EMIS_GET_AUDIT_TRACKER_ACTIONS = 'http://app-server:10000/api/get_audit_tracker_actions';
    public static $GET_CURRENT_PPDA_USERS = "http://".self::SERVER_IP.":7001/api/current_staff";
    public static $STORES_REOPEN_TICKET = 'http://'.self::SERVER_IP.':10005/api/reopen_ticket';
    public static $get_user_profile = 'http://'.self::SERVER_IP.':7001/api/get_user_profile/';
    public static $GET_EMPLOYEE_LEAVE = 'http://'.self::SERVER_IP.':10001/api/get_employee_leave/';
    public static $EMPLOYEE_LEAVE_DETAILS = 'http://'.self::SERVER_IP.':10001/api/employee_leave_details/';
    public static $GET_EMPLOYEE_APPRAISALS = 'http://app-server:9001/api/get_user_appraisals/';
    public static $GET_EMPLOYEE_CONTRACTS = 'http://app-server:9001/api/get_user_contracts/';
}
