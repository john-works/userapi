<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 5/16/2019
 * Time: 21:59
 */


namespace app\Helpers;

use app\Models\ApiApplicationStat;
use app\Models\ApiAppraisal;
use App\Models\ApiBehavioralCompetence;
use App\Models\ApiBehavioralCompetenceCategory;
use app\Models\ApiCompetence;
use app\Models\ApiCompetenceCategory;
use app\Models\ApiDepartment;
use app\Models\ApiDepartmentUnit;
use app\Models\ApiEmployeeCategory;
use app\Models\ApiFormAcademicBackground;
use app\Models\ApiFormAdditionalAssignmentScore;
use app\Models\ApiFormAppraiseeRemark;
use app\Models\ApiFormAppraiserComment;
use app\Models\ApiFormAppraiserRecommendation;
use app\Models\ApiFormAssignment;
use app\Models\ApiFormAssignmentScore;
use app\Models\ApiFormAssignmentSummary;
use app\Models\ApiFormCompetence;
use app\Models\ApiFormCompetenceAssessment;
use app\Models\ApiFormCompetenceAssessmentScore;
use app\Models\ApiFormCompetenceAssessmentSummary;
use app\Models\ApiFormCompetenceCategory;
use app\Models\ApiFormDirectorComment;
use app\Models\ApiFormHodComment;
use app\Models\ApiFormKeyDuty;
use app\Models\ApiFormPerformanceChallenge;
use app\Models\ApiFormPerformanceGap;
use app\Models\ApiFormPerformanceSummary;
use app\Models\ApiFormPersonalDetail;
use app\Models\ApiFormStrengthAndWeakness;
use app\Models\ApiFormSupervisorDeclaration;
use app\Models\ApiFormWorkplan;
use App\Models\ApiLmsRole;
use app\Models\ApiOrganization;
use app\Models\ApiRegionalOffice;
use app\Models\ApiRoleCode;
use app\Models\ApiStrategicObjective;
use app\Models\ApiUser;
use app\Models\ApiUserAcademicBg;
use app\Models\ApiUserContract;

class DataFormatter {

    /*
     * We are formatting the data to avoid changing the Frontend code due to change in the API responses
     * */

    public static function formatOrganizations(array $data) {

        $organizations = [];

        foreach ($data as $item){

            $org = self::getApiOrganization($item);
            $organizations[] = $org;

        }

        return $organizations;

    }


    public static function formatRegionalOffices(array $data) {

        $regionalOffices = [];

        foreach ($data as $item){

            $org = self::getApiRegionalOffice($item);
            $regionalOffices[] = $org;

        }

        return $regionalOffices;

    }


    public static function formatDepartments(array $data) {

        $departments = [];

        foreach ($data as $item){

            $department = self::getApiDepartment($item);
            $departments[] = $department;

        }

        return $departments;

    }


    public static function formatDepartmentUnits(array $data) {

        $units = [];

        foreach ($data as $item){

            $unit = self::getApiDepartmentUnit($item);
            $units[] = $unit;

        }

        return $units;

    }


    public static function formatRoleCodes(array $data) {

        $roleCodes = [];

        foreach ($data as $item){

            $roleCode = self::getApiRoleCode($item);
            $roleCodes[] = $roleCode;

        }

        return $roleCodes;

    }


    public static function formatEmployeeCategories(array $data) {

        $employeeCategories = [];

        foreach ($data as $item){

            $category = self::getApiEmployeeCategory($item);
            $employeeCategories[] = $category;

        }

        return $employeeCategories;

    }


    public static function formatUsers(array $data) {

        $users = [];

        foreach ($data as $item){


            $user = self::getApiUser($item);
            $users[] = $user;

        }

        return $users;

    }

    /**
     * @param $userDataObjectFromApi
     * @return ApiUser
     */
    public static function getApiUser($userDataObjectFromApi) {
        $user = new ApiUser();
        $user->id = isset($userDataObjectFromApi['id'])? $userDataObjectFromApi['id'] : null;
        $user->firstName = isset($userDataObjectFromApi['first_name']) ? SharedCommons::capitalize($userDataObjectFromApi['first_name']) : null;
        $user->lastName = isset($userDataObjectFromApi['last_name']) ? SharedCommons::capitalize($userDataObjectFromApi['last_name']) : null;
        $user->otherName = isset($userDataObjectFromApi['other_name']) ? SharedCommons::capitalize($userDataObjectFromApi['other_name']) : null;
        $user->fullName = isset($userDataObjectFromApi['first_name'], $userDataObjectFromApi['last_name']) ? SharedCommons::capitalize(trim($user->firstName . ' ' . $user->lastName)) : null;
        $user->username = isset($userDataObjectFromApi['username'])? $userDataObjectFromApi['username'] : null;
        $user->email = isset($userDataObjectFromApi['email'])? $userDataObjectFromApi['email'] : null;
        $user->phone = isset($userDataObjectFromApi['phone'])? $userDataObjectFromApi['phone'] : null;
        $user->phone_1 = isset($userDataObjectFromApi['phone_1'])? $userDataObjectFromApi['phone_1'] : null;
        $user->phone_2 = isset($userDataObjectFromApi['phone_2'])? $userDataObjectFromApi['phone_2'] : null;
        $user->createdAt = isset($userDataObjectFromApi['created_at'])? $userDataObjectFromApi['created_at'] : null;
        $user->createdBy = isset($userDataObjectFromApi['created_by'])? $userDataObjectFromApi['created_by'] : null;
        $user->staffNumber = isset($userDataObjectFromApi['staff_number'])? $userDataObjectFromApi['staff_number'] : null;
        $user->dateOfBirth = isset($userDataObjectFromApi['date_of_birth'])? $userDataObjectFromApi['date_of_birth'] : null;
        $user->contractStartDate = isset($userDataObjectFromApi['contract_start_date'])? $userDataObjectFromApi['contract_start_date'] : null;
        $user->contractExpiryDate = isset($userDataObjectFromApi['contract_expiry_date'])? $userDataObjectFromApi['contract_expiry_date'] : null;
        $user->roleLetterMovement = isset($userDataObjectFromApi['letter_movement_role_code'])? $userDataObjectFromApi['letter_movement_role_code'] : null;
        $user->lmsRole = isset($userDataObjectFromApi['lms_role']) ? self::getApiLmsRole($userDataObjectFromApi['lms_role']) : null;
        $user->unitCode = isset($userDataObjectFromApi['department_unit']) ? $userDataObjectFromApi['department_unit'] : null;
        $apiDept = isset($userDataObjectFromApi['department'])? self::getApiDepartment($userDataObjectFromApi['department']): null;
        $user->departmentId = isset($apiDept) ?$apiDept->id: null;
        $user->departmentCode = isset($apiDept) ?$apiDept->departmentCode: null;
        $user->departmentName = isset($apiDept) ?SharedCommons::capitalize($apiDept->name): null;
        $user->departmentHeadUsername = isset($apiDept) ?$apiDept->hodUsername: null;
        $user->departmentHeadFullName = $user->departmentHeadUsername;
        $apiCategory = self::getApiEmployeeCategory($userDataObjectFromApi['employee_category']);
        $user->categoryCode = isset($apiCategory) ?$apiCategory->categoryCode: null;
        $user->category = isset($apiCategory) ?$apiCategory->category: null;
        $apiRegionalOffice = self::getApiRegionalOffice($userDataObjectFromApi['regional_office']);
        $user->regionalOfficeCode = isset($apiRegionalOffice) ?$apiRegionalOffice->regionalOfficeCode: null;
        $user->regionalOfficeName = isset($apiRegionalOffice) ?$apiRegionalOffice->name: null;
        $designationData = isset($userDataObjectFromApi['user_designation'])?$userDataObjectFromApi['user_designation']:null;
        $user->designationId = isset($designationData) ? $designationData['id'] :null;
        $user->designationTitle = isset($designationData) ? $designationData['title'] :null;
        $user->designation = isset($designationData) ? $designationData['title'] :null;
        $user->roleCode = isset($userDataObjectFromApi['role_code'])? $userDataObjectFromApi['role_code'] : null;
        $user->roleName = isset($userDataObjectFromApi['role_code'])? $userDataObjectFromApi['role_code'] : null;
        $user->is_admin = isset($userDataObjectFromApi['is_admin'])? $userDataObjectFromApi['is_admin'] : null;
        $user->is_out_of_office_delegate_user = isset($userDataObjectFromApi['is_out_of_office_delegate_user'])? $userDataObjectFromApi['is_out_of_office_delegate_user'] : null;
        $user->trusted_devices = isset($userDataObjectFromApi['trusted_devices'])? $userDataObjectFromApi['trusted_devices'] : null;
        $user->orgCode = isset($userDataObjectFromApi['organization']) ? self::getApiOrganization($userDataObjectFromApi['organization'])->orgCode : null;
        $user->orgName = isset($userDataObjectFromApi['organization']) ? self::getApiOrganization($userDataObjectFromApi['organization'])->name : null;
        $user->orgEdUsername = isset($userDataObjectFromApi['organization']) ? self::getApiOrganization($userDataObjectFromApi['organization'])->executiveDirector : null;
    
        return $user;
    }
    

    public static function getAppStat($appStatFromApi) {

        $stat = new ApiApplicationStat();

        $stat->countAppraisals = $appStatFromApi['countAppraisals'];
        $stat->countAppraisalsNew = $appStatFromApi['countAppraisalsNew'];

        $stat->countRegionalOffices = $appStatFromApi['countRegionalOffice'];
        $stat->countRegionalOfficesNew = $appStatFromApi['countRegionalOfficeNew'];

        $stat->countDepartments = $appStatFromApi['countDepartments'];
        $stat->countDepartmentsNew = $appStatFromApi['countDepartmentsNew'];

        $stat->countUsers = $appStatFromApi['countUsers'];
        $stat->countUsersNew = $appStatFromApi['countUsersNew'];

        return $stat;

    }

    public static function formatAppraisals($appraisals) {

        $result =  [];

        foreach ($appraisals as $item){

            $apiAppraisal = self::getApiAppraisal($item);
            $result[] = $apiAppraisal;

        }

        return $result;

    }

    public static function getApiAppraisal($appraisal) {

        $apiAppraisal = new ApiAppraisal();

        $apiAppraisal->appraisalRef = $appraisal['appraisal_reference'];
        $apiAppraisal->appraisalType = $appraisal['appraisal_type'];
        $apiAppraisal->ownerUsername = $appraisal['owner_id'];
        $apiAppraisal->status = $appraisal['appraisal_status'];
        $apiAppraisal->generatedPdfName = $appraisal['generated_pdf_name'];
        $apiAppraisal->pdfDownloadLink = $appraisal['download_link'];
        $apiAppraisal->deptHeadUsername = $appraisal['department_head_id'];
        $apiAppraisal->deptHeadDecision = is_null($appraisal['department_head_decision']) ? "Pending" : ucwords(strtolower($appraisal['department_head_decision']));
        $apiAppraisal->deptHeadRemark = $appraisal['department_head_remark'];
        $apiAppraisal->deptHeadSubmissionDate = $appraisal['department_head_submission_date'];
        $apiAppraisal->deptHeadActionDate = $appraisal['department_head_action_date'];
        $apiAppraisal->supervisorUsername = $appraisal['supervisor_id'];
        $apiAppraisal->supervisorDecision = is_null($appraisal['supervisor_decision']) ? "Pending" : ucwords(strtolower($appraisal['supervisor_decision']));
        $apiAppraisal->supervisorRemark = $appraisal['supervisor_remark'];
        $apiAppraisal->supervisorSubmissionDate = $appraisal['supervisor_submission_date'];
        $apiAppraisal->supervisorActionDate = $appraisal['supervisor_action_date'];

        $apiAppraisal->employeeAcceptanceStatus = SharedCommons::generateEmployeeAcceptanceStatus($appraisal);

        $apiAppraisal->executiveDirectorUsername = $appraisal['executive_director_id'];
        $apiAppraisal->executiveDirectorDecision = is_null($appraisal['executive_director_decision'])? "Pending" :ucwords(strtolower($appraisal['executive_director_decision']));
        $apiAppraisal->executiveDirectorRemark = $appraisal['executive_director_remark'];
        $apiAppraisal->executiveDirectorSubmissionDate = $appraisal['executive_director_submission_date'];
        $apiAppraisal->executiveDirectorActionDate = $appraisal['executive_director_action_date'];
        $apiAppraisal->createdAt = SharedCommons::formatDateStringToFormat($appraisal['created_at']);

        //get the personal details (object) hence getApi
        if(array_key_exists('appraisal_personal_detail',$appraisal)){
            $apiAcademicBg = $appraisal['appraisal_personal_detail'];
            $apiAppraisal->personalInfo = DataFormatter::getApiFormPersonalDetail($apiAcademicBg);
        }

        //get the academic backgrounds (array) hence formatForm
        if(array_key_exists('appraisal_academic_backgrounds',$appraisal)){
            $apiAcademicBg = $appraisal['appraisal_academic_backgrounds'];
            $apiAppraisal->academicBackgrounds = DataFormatter::formatFormAcademicBackgrounds($apiAcademicBg);
        }

        //get the key duties (array) hence formatForm
        if(array_key_exists('appraisal_key_duties',$appraisal)){
            $apiKeyDuties = $appraisal['appraisal_key_duties'];
            $apiAppraisal->keyDuties = DataFormatter::formatFormKeyDuties($apiKeyDuties);
        }

        //get the assignments (array) hence formatForm
        if(array_key_exists('appraisal_assignments',$appraisal)){
            $apiAssignments = $appraisal['appraisal_assignments'];
            $apiAppraisal->assignments = DataFormatter::formatFormAssignments($apiAssignments);
        }

        //get the additional assignments (array) hence formatForm
        if(array_key_exists('appraisal_additional_assignments',$appraisal)){
            $apiAdditionalAssignments = $appraisal['appraisal_additional_assignments'];
            $apiAppraisal->additionalAssignments = DataFormatter::formatFormAdditionalAssignments($apiAdditionalAssignments);
        }

        if(array_key_exists('appraisal_competence_assessments',$appraisal)){
            $apiCompetenceAssessments = $appraisal['appraisal_competence_assessments'];
            $apiAppraisal->competenceAssessments = DataFormatter::formatFormCompetenceAssessments($apiCompetenceAssessments);
        }

        if(array_key_exists('appraisal_train_performance_gaps',$appraisal)){
            $apiGaps = $appraisal['appraisal_train_performance_gaps'];
            $apiAppraisal->performanceGaps = DataFormatter::formatFormPerformanceGaps($apiGaps);
        }

        if(array_key_exists('appraisal_train_challenges',$appraisal)){
            $apiChallenges = $appraisal['appraisal_train_challenges'];
            $apiAppraisal->performanceChallenges = DataFormatter::formatFormPerformanceChallenges($apiChallenges);
        }

        if(array_key_exists('appraisal_workplans',$appraisal)){
            $apiWorkPlans = $appraisal['appraisal_workplans'];
            $apiAppraisal->workPlans = DataFormatter::formatFormWorkPlans($apiWorkPlans);
        }

        //get the appraiser comment (object) hence getApi
        if(array_key_exists('appraisal_appraiser_comment',$appraisal)){
            $apiAppraiserComment = $appraisal['appraisal_appraiser_comment'];
            $apiAppraisal->appraiserComment = DataFormatter::getApiFormAppraiserComment($apiAppraiserComment);
        }

        if(array_key_exists('appraisal_strength_and_weekness',$appraisal)){
            $apiStrengthAndWeakness = $appraisal['appraisal_strength_and_weekness'];
            $apiAppraisal->strengthAndWeakness = DataFormatter::getApiFormStrengthAndWeakness($apiStrengthAndWeakness);
        }

        if(array_key_exists('appraisal_strength_and_weekness',$appraisal)){
            $apiStrengthAndWeakness = $appraisal['appraisal_strength_and_weekness'];
            $apiAppraisal->strengthAndWeakness = DataFormatter::getApiFormStrengthAndWeakness($apiStrengthAndWeakness);
        }

        if(array_key_exists('appraisal_appraiser_recommendation',$appraisal)){
            $apiAppraiserRecommendation = $appraisal['appraisal_appraiser_recommendation'];
            $apiAppraisal->appraiserRecommendation = DataFormatter::getApiFormAppraiserRecommendation($apiAppraiserRecommendation);
        }

        if(array_key_exists('appraisal_supervisor_declaration',$appraisal)){
            $apiSupervisorDeclaration = $appraisal['appraisal_supervisor_declaration'];
            $apiAppraisal->supervisorDeclaration = DataFormatter::getApiFormSupervisorDeclaration($apiSupervisorDeclaration);
        }

        if(array_key_exists('appraisal_hod_comment',$appraisal)){
            $apiHodComment = $appraisal['appraisal_hod_comment'];
            $apiAppraisal->hodComment = DataFormatter::getApiFormHodComment($apiHodComment);
        }

        if(array_key_exists('appraisal_appraisee_remark',$appraisal)){
            $apiAppraiseeRemark = $appraisal['appraisal_appraisee_remark'];
            $apiAppraisal->appraiseeRemark = DataFormatter::getApiFormAppraiseeRemarks($apiAppraiseeRemark);
        }

        if(array_key_exists('appraisal_director_comment',$appraisal)){
            $apiDirectorComment = $appraisal['appraisal_director_comment'];
            $apiAppraisal->directorComment = DataFormatter::getApiFormDirectorComment($apiDirectorComment);
        }

        if(array_key_exists('appraisal_train_summary',$appraisal)){
            $apiTrainingSummary = $appraisal['appraisal_train_summary'];
            $apiAppraisal->performancesSummaries = DataFormatter::getApiFormPerformanceSummary($apiTrainingSummary);
        }

        if(array_key_exists('appraisal_assignment_summary',$appraisal)){
            $apiAssignmentSummary = $appraisal['appraisal_assignment_summary'];
            $apiAppraisal->assignmentsSummaries = DataFormatter::getApiFormAssignmentsSummary($apiAssignmentSummary);
        }

        if(array_key_exists('appraisal_assignment_score',$appraisal)){
            $apiAssignmentScore = $appraisal['appraisal_assignment_score'];
            $apiAppraisal->assignmentsScores = DataFormatter::getApiFormAssigmentsScores($apiAssignmentScore);
        }

        if(array_key_exists('appraisal_additional_assignment_score',$appraisal)){
            $apiAdditionalAssignmentScore = $appraisal['appraisal_additional_assignment_score'];
            $apiAppraisal->additionalAssignmentsScores = DataFormatter::getApiFormAdditionalAssigmentsScores($apiAdditionalAssignmentScore);
        }

        if(array_key_exists('appraisal_competence_assessment_summary',$appraisal)){
            $apiCompetenceAssessmentSummary = $appraisal['appraisal_competence_assessment_summary'];
            $apiAppraisal->competenceAssessmentsSummaries = DataFormatter::getApiFormCompetenceAssessmentsSummary($apiCompetenceAssessmentSummary);
        }

        if(array_key_exists('appraisal_competence_assessment_score',$appraisal)){
            $apiCompetenceAssessmentScore = $appraisal['appraisal_competence_assessment_score'];
            $apiAppraisal->competenceAssessmentsScores = DataFormatter::getApiFormCompetenceAssessmentsScores($apiCompetenceAssessmentScore);
        }

        if(array_key_exists('user',$appraisal)){
            $apiUser = $appraisal['user'];
            $apiAppraisal->user = null;// DataFormatter::getApiUserWithNoRelationsShips($apiUser);
        }

        /*
         * If the status is not pending approval, then it's at the owner level, the owner can resubmit to workflow to cancel it
         * */
        if(!ConstAppraisalStatus::isPendingApproval($apiAppraisal->status)){
            $apiAppraisal->isOwner = true;
        }else{
            $apiAppraisal->isOwner = false;
        }

        if($apiAppraisal->status == ConstAppraisalStatus::CANCELED_BY_OWNER){
            $apiAppraisal->isCancelled = true;
        }

        $apiAppraisal->isCompleted = $apiAppraisal->status == ConstAppraisalStatus::COMPLETED_SUCCESSFULLY;

        $apiAppraisal->isRejected = ConstAppraisalStatus::isRejectedStatus($apiAppraisal->status);

        $apiAppraisal->simpleStatus = ConstAppraisalStatus::getSimpleStatusDescription($apiAppraisal->status);

        return $apiAppraisal;

    }

    public static function formatStrategicObjectives($strategicObjectives){

        $result = [];

        foreach ($strategicObjectives as $objective){

            $data = self::getApiStrategicObjective($objective);
            $result[] = $data;

        }

        return $result;

    }


    public static function formatAdminCompetenceCategories($competenceCategories){

        $result = [];

        foreach ($competenceCategories as $category){

            $data = self::getApiAdminCompetenceCategory($category);
            $result[] = $data;

        }

        return $result;

    }


    public static function formatBehavioralCompetenceCategories($competenceCategories){

        $result = [];

        foreach ($competenceCategories as $category){

            $data = self::getApiBehaviorCompetenceCategory($category);
            $result[] = $data;

        }

        return $result;

    }


    public static function formatAdminCompetences($competences){

        $result = [];

        foreach ($competences as $item){

            $data = self::getApiAdminCompetence($item);
            $result[] = $data;

        }

        return $result;

    }

    public static function formatBehavioralCompetences($competences){

        $result = [];

        foreach ($competences as $item){

            $data = self::getApiBehavioralCompetence($item);
            $result[] = $data;

        }

        return $result;

    }





    public static function formatCategorizedCompetences($categorizedCompetences, $competenceAssessments = []){

        $result = [];

        foreach ($categorizedCompetences as $categorizedCompetence){

            $data = self::getApiCompetenceCategory($categorizedCompetence, $competenceAssessments);
            $result[] = $data;

        }

        return $result;

    }

    public static function getApiStrategicObjective($objective) {

        $obj = new ApiStrategicObjective();

        $obj->id = $objective['id'];
        $obj->orgCode = $objective['org_code'];
        $obj->objective = $objective['objective'];
        $obj->createdBy = $objective['created_by'];
        $obj->orgName = array_key_exists('organization',$objective) ? $objective['organization']['name'] : '';

        return $obj;

    }

    public static function getApiAdminCompetenceCategory($category) {

        $obj = new ApiCompetenceCategory();

        $obj->id = $category['id'];
        $obj->orgCode = $category['org_code'];
        $obj->empCategoryCode = $category['employee_category_code'];
        if(array_key_exists('employee_category', $category)){
            $empCat = self::getApiEmployeeCategory($category['employee_category']);
            $obj->employeeCategoryName = is_null($empCat) ? "" : SharedCommons::capitalize($empCat->category);
        }
        $obj->competenceCategory = $category['competence_category'];
        $obj->maxRating = $category['max_rating'];
        $obj->createdBy = $category['created_by'];

        return $obj;

    }


    public static function getApiBehaviorCompetenceCategory($category) {

        $obj = new ApiBehavioralCompetenceCategory();

        $obj->id = $category['id'];
        $obj->categoryCode = $category['category_code'];
        $obj->category = $category['category'];
        $obj->maximumRating = $category['maximum_rating'];

        return $obj;

    }

    public static function getApiAdminCompetence($category) {

        $obj = new ApiCompetence();

        $obj->id = $category['id'];
        $obj->competenceCategoryId = $category['appraisal_competence_category_id'];
        $obj->competence = $category['competence'];
        $obj->rank = $category['rank'];
        $obj->rating = $category['rating'];
        $obj->categoryDesc = array_key_exists('appraisal_competence_category',$category) ?
                             $category['appraisal_competence_category']['competence_category'] : "";

        return $obj;

    }


    public static function getApiBehavioralCompetence($category) {

        $obj = new ApiBehavioralCompetence();

        $obj->id = $category['id'];
        $obj->categoryCode = $category['category_code'];
        $obj->competence = $category['competence'];
        $obj->maximumScore = $category['maximum_score'];

        if(array_key_exists('behavioral_competence_category',$category)){
            $catData = self::getApiBehaviorCompetenceCategory($category['behavioral_competence_category']);
            $obj->category = $catData == null ? "" : $catData->category;
        }

        return $obj;

    }


    public static function getApiCompetenceCategory($categorizedCompetence, $competenceAssessments = []) {

        $competenceCategory = new ApiFormCompetenceCategory();

        $competenceCategory->id = $categorizedCompetence['id'];
        $competenceCategory->orgCode = $categorizedCompetence['org_code'];
        $competenceCategory->employeeCategoryCode = $categorizedCompetence['employee_category_code'];

        if(array_key_exists('employee_category', $categorizedCompetence)){
            $empCat = self::getApiEmployeeCategory($categorizedCompetence['employee_category']);
            $competenceCategory->employeeCategoryName = is_null($empCat) ? "" : $empCat->category;
        }

        $competenceCategory->competenceCategory = $categorizedCompetence['competence_category'];
        $competenceCategory->maxRating = $categorizedCompetence['max_rating'];

        $competences = [];

        //get the list of competences attached to this competence category
        $apiCompetenceList = $categorizedCompetence['appraisal_competences'];
        foreach ($apiCompetenceList as $item){

            $formCompetence = new ApiFormCompetence();
            $formCompetence->id = $item['id'];
            $formCompetence->appraisalCompetenceCategoryId = $item['appraisal_competence_category_id'];
            $formCompetence->competence = $item['competence'];
            $formCompetence->rank = $item['rank'];
            $formCompetence->rating = $item['rating'];

            //if this not an empty array, then it has the scores for the difference competences passed
            if(count($competenceAssessments) > 0){

                $competenceScores = self::getCompetenceAssessmentScoresForCompetenceByCategoryIdAndCompetenceId(
                                    $formCompetence->appraisalCompetenceCategoryId,$formCompetence->id, $competenceAssessments);

                $formCompetence->scoreAppraiseeRating = $competenceScores->appraiseeRating;
                $formCompetence->scoreAppraiserRating = $competenceScores->appraiserRating;
                $formCompetence->scoreAgreedRating = $competenceScores->agreedRating;
                $formCompetence->scoreRecordId = $competenceScores->id;

            }

            $competences[] = $formCompetence;

        }

        $competenceCategory->appraisalCompetences = $competences;

        return $competenceCategory;

    }

    /**
     * @param $item
     * @return ApiDepartment
     */
    public static function getApiDepartment($item) {

        $department = new ApiDepartment();
        $department->id = $item['id'];
        $department->name = $item['name'];
        $department->departmentCode = $item['department_code'];
        $department->createdBy = $item['created_by'];
        $department->orgCode = $item['org_code'];
        $department->hodUsername = $item['head_of_department'];
        return $department;

    }


    /**
     * @param $item
     * @return ApiDepartmentUnit
     */
    public static function getApiDepartmentUnit($item) {
        $departmentUnit = new ApiDepartmentUnit();
    
        $departmentUnit->name = $item['name'] ?? null;
        $departmentUnit->unitCode = $item['unit_code'] ?? null;
        $departmentUnit->id = $item['id'] ?? null;
    
        // Check if 'department' key exists in $item and is not null
        if (array_key_exists('department', $item) && $item['department'] !== null) {
            // Use a try-catch block to handle potential errors in getApiDepartment
            try {
                $dept = self::getApiDepartment($item['department']);
                $departmentUnit->departmentCode = $dept->departmentCode ?? null;
                $departmentUnit->departmentName = $dept->name ?? null;
            } catch (\Exception $e) {
                // Log or handle the exception as needed
                $departmentUnit->departmentCode = null;
                $departmentUnit->departmentName = null;
            }
        } else {
            $departmentUnit->departmentCode = null;
            $departmentUnit->departmentName = null;
        }
    
        return $departmentUnit;
    }



    /**
     * @param $item
     * @return ApiEmployeeCategory
     */
    public static function getApiEmployeeCategory($item) {

        $category = new ApiEmployeeCategory();
        $category->category = @$item['category'];
        $category->categoryCode = @$item['category_code'];
        $category->createdBy = @$item['created_by'];
        $category->orgCode = @$item['org_code'];
        return $category;

    }

    public static function getApiLmsRole($item) {

        $role = new ApiLmsRole();

        if($item == null){

            $role->reception = false;
            $role->registry = false;
            $role->finance = false;
            $role->edOffice = false;
            $role->outLetters = false;
            $role->masterData = false;
            $role->reports = false;
            return $role;
        }else{
            $role->reception = $item['reception_flag'] == 1;
            $role->registry = $item['registry_flag'] == 1;
            $role->finance = $item['finance_flag'] == 1;
            $role->edOffice = $item['ed_office_flag'] == 1;
            $role->outLetters = $item['outgoing_letter_flag'] == 1;
            $role->masterData = $item['master_data_flag'] == 1;
            $role->reports = $item['reports_flag'] == 1;
            return $role;
        }

    }


    /**
     * @param $item
     * @return ApiOrganization
     */
    public static function getApiOrganization($item) {

        $org = new ApiOrganization();
        $org->name = $item['name'];
        $org->contactPersonContact = $item['contact_person_contact'];
        $org->contactPersonName = $item['contact_person_name'];
        $org->createdBy = $item['created_by'];
        $org->orgCode = $item['org_code'];
        $org->email = $item['email'];
        $org->executiveDirector = $item['executive_director'];
        return $org;

    }

    /**
     * @param $item
     * @return ApiRegionalOffice
     */
    public static function getApiRegionalOffice($item) {
        $org = new ApiRegionalOffice();
        $org->name = $item['name'];
        $org->contactPersonContact = $item['contact_person_contact'];
        $org->contactPersonName = $item['contact_person_name'];
        $org->createdBy = $item['created_by'];
        $org->orgCode = $item['org_code'];
        $org->regionalOfficeCode = $item['regional_office_code'];
        $org->email = $item['email'];
        return $org;
    }

    /**
     * @param $item
     * @return ApiRoleCode
     */
    public static function getApiRoleCode($item) {
        $roleCode = new ApiRoleCode();
        $roleCode->roleName = $item['role_name'];
        $roleCode->roleCode = $item['role_code'];
        $roleCode->active = $item['active'];
        $roleCode->defaultPage = $item['page'];
        $roleCode->createdBy = $item['created_by'];
        $roleCode->orgCode = $item['org_code'];
        return $roleCode;
    }

    private static function getApiFormPersonalDetail($apiPersonalInfo) {

        if(is_null($apiPersonalInfo)){
            return null;
        }

        $info = new ApiFormPersonalDetail();
        $info->appraisalPeriodEndDate = SharedCommons::formatDateStringToFormat($apiPersonalInfo['appraisal_period_end_date']);
        $info->appraisalPeriodStartDate = SharedCommons::formatDateStringToFormat($apiPersonalInfo['appraisal_period_start_date']);
        $info->appraisalReference = $apiPersonalInfo['appraisal_reference'];
        $info->contractExpiryDate = SharedCommons::formatDateStringToFormat($apiPersonalInfo['contract_expiry_date']);
        $info->contractStartDate = SharedCommons::formatDateStringToFormat($apiPersonalInfo['contract_start_date']);
        $info->createdAt = $apiPersonalInfo['created_at'];
        $info->dateOfBirth = SharedCommons::formatDateStringToFormat($apiPersonalInfo['date_of_birth']);
        $info->department = $apiPersonalInfo['department'];
        $info->designation = $apiPersonalInfo['designation'];
        $info->firstName = $apiPersonalInfo['first_name'];
        $info->lastName = $apiPersonalInfo['last_name'];
        $info->otherName = $apiPersonalInfo['other_name'];
        $info->staffNumber = $apiPersonalInfo['staff_number'];
        $info->employeeCategory = $apiPersonalInfo['employee_category'];
        $info->id = $apiPersonalInfo['id'];

        return $info;

    }

    private static function getApiFormAppraiserComment($apiAppraiserComment) {

        if(is_null($apiAppraiserComment)){
            return null;
        }

        $appraiserComment = new ApiFormAppraiserComment();
        $appraiserComment->recommendation = $apiAppraiserComment['recommendation'];
        $appraiserComment->comment = $apiAppraiserComment['comment'];
        $appraiserComment->id = $apiAppraiserComment['id'];

        return $appraiserComment;

    }


    private static function getApiFormStrengthAndWeakness($apiData) {

        if(is_null($apiData)){
            return null;
        }

        $data = new ApiFormStrengthAndWeakness();
        $data->id = $apiData['id'];
        $data->strengths = $apiData['strengths'];
        $data->weaknesses = $apiData['weaknesses'];

        return $data;

    }

    private static function getApiFormAppraiserRecommendation($apiData) {

        if(is_null($apiData)){
            return null;
        }

        $data = new ApiFormAppraiserRecommendation();
        $data->id = $apiData['id'];
        $data->recommendations = $apiData['recommendations'];

        return $data;

    }

    private static function getApiFormSupervisorDeclaration($apiData) {

        if(is_null($apiData)){
            return null;
        }

        $data = new ApiFormSupervisorDeclaration();
        $data->id = $apiData['id'];
        $data->appraiseeName = $apiData['appraisee_name'];
        $data->appraiserName = $apiData['appraiser_name'];
        $data->duration = $apiData['duration'];
        $data->startDate = $apiData['start_date'];
        $data->endDate = $apiData['end_date'];

        return $data;

    }


    private static function getApiFormHodComment($apiData) {

        if(is_null($apiData)){
            return null;
        }

        $data = new ApiFormHodComment();
        $data->id = $apiData['id'];
        $data->name = $apiData['name'];
        $data->initials = $apiData['initials'];
        $data->comments = $apiData['comments'];
        $data->date = $apiData['date'];

        return $data;

    }


    public static function getApiUserAcademicBg($apiData) {

        if(is_null($apiData)){
            return null;
        }

        $data = new ApiUserAcademicBg();
        $data->id = $apiData['id'];
        $data->username = $apiData['username'];
        $data->institution = $apiData['institution'];
        $data->yearOfStudy = $apiData['year_of_study'];
        $data->award = $apiData['award'];

        return $data;

    }


    public static function getApiUserContract($apiData) {

        if(is_null($apiData)){
            return null;
        }

        $data = new ApiUserContract();
        $data->id = $apiData['id'];
        $data->username = $apiData['username'];
        $data->contractReference = $apiData['contract_reference'];
        $data->startDate = $apiData['start_date'];
        $data->expiryDate = $apiData['expiry_date'];
        $data->createdBy = $apiData['created_by'];

        return $data;

    }


    private static function getApiFormAppraiseeRemarks($apiData) {

        if(is_null($apiData)){
            return null;
        }

        $data = new ApiFormAppraiseeRemark();
        $data->id = $apiData['id'];
        $data->appraiseeName = $apiData['appraisee_name'];
        $data->agreementDecision = $apiData['agreement_decision'];
        $data->disagreementReason = $apiData['disagreement_reason'];
        $data->declarationName = $apiData['declaration_name'];
        $data->declarationInitials = $apiData['declaration_initials'];
        $data->declarationDate = $apiData['declaration_date'];

        return $data;

    }


    private static function getApiFormDirectorComment($apiData) {

        if(is_null($apiData)){
            return null;
        }

        $data = new ApiFormDirectorComment();
        $data->id = $apiData['id'];
        $data->name = $apiData['name'];
        $data->initials = $apiData['initials'];
        $data->date = $apiData['date'];
        $data->comments = $apiData['comments'];

        return $data;

    }


    private static function getApiFormAssigmentsScores($apiData) {

        if(is_null($apiData)){
            return null;
        }

        $data = new ApiFormAssignmentScore();
        $data->id = $apiData['id'];
        $data->totalAppraiseeRating = $apiData['total_appraisee_rating'];
        $data->totalAppraiserRating = $apiData['total_appraiser_rating'];
        $data->totalAgreedRating = $apiData['total_agreed_rating'];
        $data->totalMaximumRating = $apiData['total_maximum_rating'];

        return $data;

    }


    private static function getApiFormAdditionalAssigmentsScores($apiData) {

        if(is_null($apiData)){
            return null;
        }

        $data = new ApiFormAdditionalAssignmentScore();
        $data->id = $apiData['id'];
        $data->totalAppraiseeRating = $apiData['total_appraisee_rating'];
        $data->totalAppraiserRating = $apiData['total_appraiser_rating'];
        $data->totalAgreedRating = $apiData['total_agreed_rating'];
        $data->totalMaximumRating = $apiData['total_maximum_rating'];

        return $data;

    }

    private static function getApiFormCompetenceAssessmentsScores($apiData) {

        if(is_null($apiData)){
            return null;
        }

        $data = new ApiFormCompetenceAssessmentScore();
        $data->id = $apiData['id'];
        $data->totalAppraiseeRating = $apiData['total_appraisee_rating'];
        $data->totalAppraiserRating = $apiData['total_appraiser_rating'];
        $data->totalAgreedRating = $apiData['total_agreed_rating'];
        $data->totalMaximumRating = $apiData['total_maximum_rating'];

        return $data;

    }

    private static function getApiFormAssignmentsSummary($apiData) {

        if(is_null($apiData)){
            return null;
        }

        $data = new ApiFormAssignmentSummary();
        $data->id = $apiData['id'];
        $data->sectionDPercentageScore = $apiData['section_d_percentage_score'];
        $data->sectionDWeighedScore = $apiData['section_d_weighed_score'];
        $data->appraiserComment = $apiData['appraiser_comment'];

        return $data;

    }

    private static function getApiFormCompetenceAssessmentsSummary($apiData) {

        if(is_null($apiData)){
            return null;
        }

        $data = new ApiFormCompetenceAssessmentSummary();
        $data->id = $apiData['id'];
        $data->sectionEPercentageScore = $apiData['section_e_percentage_score'];
        $data->sectionEWeighedScore = $apiData['section_e_weighed_score'];
        $data->sectionDScore = $apiData['section_d_score'];
        $data->sectionEScore = $apiData['section_e_score'];
        $data->appraisalTotalScore = $apiData['appraisal_total_score'];

        return $data;

    }

    private static function getApiFormPerformanceSummary($apiData) {

        if(is_null($apiData)){
            return null;
        }

        $data = new ApiFormPerformanceSummary();
        $data->id = $apiData['id'];
        $data->appraiserComment = $apiData['appraiser_comment'];

        return $data;

    }


    private static function formatFormAcademicBackgrounds($apiAcademicBgs) {

        try{

            $list = [];
            foreach ($apiAcademicBgs as $bg){

                $apiBg = new ApiFormAcademicBackground();
                $apiBg->id = $bg['id'];
                $apiBg->appraisalRef = $bg['appraisal_reference'];
                $apiBg->school = $bg['school'];
                $apiBg->year = $bg['year'];
                $apiBg->award = $bg['award'];

                $list[] = $apiBg;

            }
            return $list;

        }catch (\Exception $exception){
            return [];
        }

    }

    private static function formatFormKeyDuties($apiKeyDuties) {

        try{

            $list = [];
            foreach ($apiKeyDuties as $keyDuty){

                $apiFormKeyDuty = new ApiFormKeyDuty();
                $apiFormKeyDuty->id = $keyDuty['id'];
                $apiFormKeyDuty->objectiveId = $keyDuty['appraisal_strategic_objective_id'];
                $apiFormKeyDuty->objective = $keyDuty['appraisal_strategic_objective_id'];
                $apiFormKeyDuty->jobAssignment = $keyDuty['job_assignment'];
                $apiFormKeyDuty->expectedOutput = $keyDuty['expected_output'];
                $apiFormKeyDuty->maximumRating = $keyDuty['maximum_rating'];
                $apiFormKeyDuty->timeFrame = $keyDuty['time_frame'];

                $list[] = $apiFormKeyDuty;

            }
            return $list;

        }catch (\Exception $exception){
            return [];
        }

    }


    private static function formatFormAssignments($apiAssignments) {

        try{

            $list = [];
            foreach ($apiAssignments as $assignment){

                $apiFormAssignment = new ApiFormAssignment();
                $apiFormAssignment->id = $assignment['id'];
                $apiFormAssignment->objectiveId = $assignment['appraisal_strategic_objective_id'];
                $apiFormAssignment->expectedOutput = $assignment['expected_output'];
                $apiFormAssignment->actualPerformance = $assignment['actual_performance'];
                $apiFormAssignment->maximumRating = $assignment['maximum_rating'];
                $apiFormAssignment->appraiseeRating = $assignment['appraisee_rating'];
                $apiFormAssignment->appraiserRating = $assignment['appraiser_rating'];
                $apiFormAssignment->agreedRating = $assignment['agreed_rating'];

                $list[] = $apiFormAssignment;

            }
            return $list;

        }catch (\Exception $exception){
            return [];
        }

    }

    private static function formatFormAdditionalAssignments($apiAssignments) {

        try{

            $list = [];
            foreach ($apiAssignments as $assignment){

                $apiFormAssignment = new ApiFormAssignment();
                $apiFormAssignment->id = $assignment['id'];
                $apiFormAssignment->objectiveId = $assignment['appraisal_strategic_objective_id'];
                $apiFormAssignment->expectedOutput = $assignment['expected_output'];
                $apiFormAssignment->actualPerformance = $assignment['actual_performance'];
                $apiFormAssignment->maximumRating = $assignment['maximum_rating'];
                $apiFormAssignment->appraiseeRating = $assignment['appraisee_rating'];
                $apiFormAssignment->appraiserRating = $assignment['appraiser_rating'];
                $apiFormAssignment->agreedRating = $assignment['agreed_rating'];

                $list[] = $apiFormAssignment;

            }
            return $list;

        }catch (\Exception $exception){
            return [];
        }

    }


    private static function formatFormPerformanceGaps($apiGaps) {

        try{

            $list = [];
            foreach ($apiGaps as $gap){

                $formPerformanceGap = new ApiFormPerformanceGap();
                $formPerformanceGap->id = $gap['id'];
                $formPerformanceGap->causes = $gap['causes'];
                $formPerformanceGap->performanceGap = $gap['performance_gap'];
                $formPerformanceGap->recommendation = $gap['recommendation'];
                $formPerformanceGap->when = $gap['when'];

                $list[] = $formPerformanceGap;

            }
            return $list;

        }catch (\Exception $exception){
            return [];
        }

    }

    private static function formatFormPerformanceChallenges($apiChallenges) {

        try{

            $list = [];
            foreach ($apiChallenges as $challenge){

                $formPerformanceChallenge = new ApiFormPerformanceChallenge();
                $formPerformanceChallenge->id = $challenge['id'];
                $formPerformanceChallenge->challenge = $challenge['challenge'];
                $formPerformanceChallenge->recommendation = $challenge['recommendation'];
                $formPerformanceChallenge->causes = $challenge['causes'];
                $formPerformanceChallenge->when = $challenge['when'];

                $list[] = $formPerformanceChallenge;

            }
            return $list;

        }catch (\Exception $exception){
            return [];
        }

    }

    private static function formatFormCompetenceAssessments($apiCompetenceAssessments) {

        try{

            $list = [];
            foreach ($apiCompetenceAssessments as $assessment){

                $formCompetenceAssessment = new ApiFormCompetenceAssessment();
                $formCompetenceAssessment->id = $assessment['id'];
                $formCompetenceAssessment->competenceCategoryId = $assessment['competence_category_id'];
                $formCompetenceAssessment->competenceId = $assessment['appraisal_competence_id'];
                $formCompetenceAssessment->maximumRating = $assessment['maximum_rating'];
                $formCompetenceAssessment->appraiseeRating = $assessment['appraisee_rating'];
                $formCompetenceAssessment->appraiserRating = $assessment['appraiser_rating'];
                $formCompetenceAssessment->agreedRating = $assessment['agreed_rating'];

                $list[] = $formCompetenceAssessment;

            }
            return $list;

        }catch (\Exception $exception){
            return [];
        }

    }

    private static function formatFormWorkPlans($apiWorkPlans) {

        try{

            $list = [];
            foreach ($apiWorkPlans as $workPlan){

                $formWorkplan = new ApiFormWorkplan();
                $formWorkplan->id = $workPlan['id'];
                $formWorkplan->expectedOutput = $workPlan['expected_output'];
                $formWorkplan->jobAssignment = $workPlan['job_assignment'];
                $formWorkplan->maximumRating = $workPlan['maximum_rating'];
                $formWorkplan->timeFrame = $workPlan['time_frame'];

                $list[] = $formWorkplan;

            }
            return $list;

        }catch (\Exception $exception){
            return [];
        }

    }

    private static function getCompetenceAssessmentScoresForCompetenceByCategoryIdAndCompetenceId(
        $categoryId, $competenceId, $competenceAssessments) {

        foreach ($competenceAssessments as $assessment){

            $assessmentCategoryId = $assessment->competenceCategoryId;
            $assessmentCompetenceId = $assessment->competenceId;

            if($categoryId == $assessmentCategoryId && $competenceId == $assessmentCompetenceId){
                return $assessment;
            }

        }

        return new ApiFormCompetenceAssessment();

    }

    public static function formatUserAcademicBackgrounds($apiAcademicBgs) {

        try{

            $list = [];
            foreach ($apiAcademicBgs as $bg){
                $apiBg = self::getApiUserAcademicBg($bg);
                $list[] = $apiBg;
            }
            return $list;

        }catch (\Exception $exception){
            return [];
        }

    }

    public static function formatUserContracts($apiUserContracts) {

        try{

            $list = [];
            foreach ($apiUserContracts as $userContract){
                $contract = self::getApiUserContract($userContract);
                $list[] = $contract;
            }
            return $list;

        }catch (\Exception $exception){
            return [];
        }

    }

    private static function getAppraisalRedirectToUrl(ApiAppraisal $apiAppraisal) {

        try{

            $urlMyAppraisals = route('appraisal-forms.owner');
            $urlSupervisorAppraisals = route('appraisal-forms.supervisor');
            $urlHodAppraisals = route('appraisal-forms.hod');
            $urlEdAppraisals = route('appraisal-forms.director');

            $user = session(Security::$SESSION_USER);
            if($user == null){
                return $urlMyAppraisals;
            }

            $username = $user->username;

            if($user == null || $apiAppraisal->ownerUsername == $username){
                return $urlMyAppraisals;
            }

            if($apiAppraisal->supervisorUsername == $username){
                return $urlSupervisorAppraisals;
            }

            if($apiAppraisal->deptHeadUsername == $username){
                return $urlHodAppraisals;
            }

            if($apiAppraisal->executiveDirectorUsername == $username){
                return $urlEdAppraisals;
            }

            return $urlMyAppraisals;

        }catch (\Exception $exception){
            return route('appraisal-forms.owner');
        }

    }


}