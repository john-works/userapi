<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 6/15/2018
 * Time: 12:18
 */


namespace app\Helpers;


use App\Appraisal;
use app\Models\ApiAppraisal;
use App\Workflow;

class DataGenerator {

    public static function strategicObjectives(){

        return [

            ["code"=>"001","value"=>"To strengthen Transparency and Accountability in Procurement"],
            ["code"=>"002","value"=>"To increase competition and hence contribute to domestic industry development"],
            ["code"=>"003","value"=>"To enhance the efficiency of the public procurement process"],
            ["code"=>"004","value"=>"To leverage technology through e-procurement and other ICT platforms to improve procurement outcomes"],
            ["code"=>"005","value"=>"To enhance the performance of public procurement beyond compliance"],
            ["code"=>"006","value"=>"To enhance the effectiveness of capacity building, research and knowledge management"],
            ["code"=>"007","value"=>"To strengthen internal PPDA capacity to deliver improved performance of public procurement"],
            ["code"=>"008","value"=>"Leverage and enhance PPDA’s partnerships and collaborations"],

        ];

    }

    public static function getAppraisalSummaries($appraisals) {

        $summaries = [];

        foreach ($appraisals as $appraisal){

            $percentage = DataGenerator::getPercentageComplete($appraisal);
            $stage = DataGenerator::getCurrentStage($appraisal);
            $summaries[] = ["id"=>$appraisal->appraisalRef,"percentage"=>$percentage,"stage"=>$stage];

        }

        return $summaries;

    }

    private static function getPercentageComplete(ApiAppraisal $appraisal) {

        $total = 15;
        $done = 0;

        if(isset($appraisal->personalInfo)){  $done++; }
        if(isset($appraisal->academicBackgrounds) && count($appraisal->academicBackgrounds) >0){  $done++; }
        if(isset($appraisal->keyDuties) && count($appraisal->keyDuties) >0){  $done++; }
        if(isset($appraisal->assignments) && count($appraisal->assignments) >0){  $done++; }
        if(isset($appraisal->additionalAssignments) && count($appraisal->additionalAssignments) >0){  $done++; }
        if(isset($appraisal->performanceChallenges) && count($appraisal->performanceChallenges) >0){  $done++; }
        if(isset($appraisal->performanceGaps) && count($appraisal->performanceGaps) >0){  $done++; }
        if(isset($appraisal->appraiserComment) ){  $done++; }
        if(isset($appraisal->strengthAndWeakness) ){  $done++; }
        if(isset($appraisal->appraiserRecommendation) ){  $done++; }
        if(isset($appraisal->supervisorDeclaration) ){  $done++; }
        if(isset($appraisal->hodComment) ){  $done++; }
        if(isset($appraisal->workPlans) && count($appraisal->workPlans) >0){  $done++; }
        if(isset($appraisal->appraiseeRemark) ){  $done++; }
        if(isset($appraisal->directorComment) ){  $done++; }

        /*
        if($appraisal->sectiona_status){  $done++; }
        if($appraisal->sectionb_status){  $done++; }
        if($appraisal->sectionc_status){  $done++; }
        if($appraisal->sectiond_status){  $done++; }
        if($appraisal->sectione_status){  $done++; }
        if($appraisal->sectionf_status){  $done++; }
        if($appraisal->sectiong_status){  $done++; }
        if($appraisal->sectionh_status){  $done++; }
        if($appraisal->sectioni_status){  $done++; }
        if($appraisal->sectionj_status){  $done++; }
        if($appraisal->sectionk_status){  $done++; }
        if($appraisal->sectionl_status){  $done++; }
        if($appraisal->sectionm_status){  $done++; }
        if($appraisal->sectionn_status){  $done++; }
        */

        $percentage = round((($done/$total) * 100));
        return $percentage."%";

    }

    private static function getCurrentStage(ApiAppraisal $appraisal) {

        $statusCode = $appraisal->status;
        $status = ConstAppraisalStatus::getAppraisalStatusDescriptionByCode($statusCode);
        return $status;

    }

    public static function getAssingedAppraisals($userId) {

        $appraisalIds = [];
        $appraisals = [];
        $assignmentsAsSupervisor = Workflow::where('supervisor_id','=',$userId)->where('supervisor_approval','=',0)->orderby('id','desc')->get();
        $assignmentsAsHod = Workflow::where('hod_id','=',$userId)->where('hod_approval','=',0)->orderby('id','desc')->get();
        $assignmentsAsEd = Workflow::where('executive_director_id','=',$userId)->where('executive_director_approval','=',0)->orderby('id','desc')->get();

        foreach ($assignmentsAsSupervisor as $item){
            if(!in_array($item->appraisal_id,$appraisalIds)){

                if(DataGenerator::isAppraisalAtThisWorkFlowStep($item->appraisal_id,AppConstants::$WORK_FLOW_STEP2_SUPERVISOR)){
                    $appraisalIds[] = $item->appraisal_id;
                    $appraisals[] = Appraisal::find($item->appraisal_id);
                }

            }
        }

        foreach ($assignmentsAsHod as $item){
            if(!in_array($item->appraisal_id,$appraisalIds)){

                if(DataGenerator::isAppraisalAtThisWorkFlowStep($item->appraisal_id,AppConstants::$WORK_FLOW_STEP3_HOD)){
                $appraisalIds[] = $item->appraisal_id;
                $appraisals[] = Appraisal::find($item->appraisal_id);
                }
            }
        }

        foreach ($assignmentsAsEd as $item){
            if(!in_array($item->appraisal_id,$appraisalIds)){

                if(DataGenerator::isAppraisalAtThisWorkFlowStep($item->appraisal_id,AppConstants::$WORK_FLOW_STEP4_ED)){
                $appraisalIds[] = $item->appraisal_id;
                $appraisals[] = Appraisal::find($item->appraisal_id);
                }
            }
        }

        return $appraisals;

    }

    public static function getAppraisalWorkflowStage($id) {

        $workflow = Workflow::where('appraisal_id','=',$id)->first();

        if($workflow ==  null){
            //Appraisal not yet in workflow
            return AppConstants::$WORK_FLOW_STEP1_OWNER;
        }

        if(!$workflow->supervisor_approval){
            return AppConstants::$WORK_FLOW_STEP2_SUPERVISOR;
        }else{

            if(!$workflow->hod_approval){
                return AppConstants::$WORK_FLOW_STEP3_HOD;
            }else{

                if(!$workflow->executive_director_approval){
                    return AppConstants::$WORK_FLOW_STEP4_ED;
                }

                return AppConstants::$WORK_FLOW_STEP5_DONE;

            }
        }

    }

    private static function isAppraisalAtThisWorkFlowStep($appraisal_id, $workFlowStep) {

        $appraisalWorkflowStep = DataGenerator::getAppraisalWorkflowStage($appraisal_id);
        return $appraisalWorkflowStep == $workFlowStep;

    }

    public static function visibleSections($nextSection, $showAllSections = false){

        if($showAllSections){
            return self::formStepAllSections();
        }

        if(in_array($nextSection,self::formStep1Sections())){
            return self::formStep1Sections();
        }

        if(in_array($nextSection,self::formStep2Sections())){
            return self::formStep2Sections();
        }

        if(in_array($nextSection,self::formStep3Sections())){
            return self::formStep3Sections();
        }

        if(in_array($nextSection,self::formStep4Sections())){
            return self::formStep4Sections();
        }

        return self::formStepAllSections();

    }

    public static function formStepAllSections(){

        $arr = [];
        $arr = array_merge($arr, DataGenerator::formStep1Sections());
        $arr = array_merge($arr, DataGenerator::formStep2Sections());
        $arr = array_merge($arr, DataGenerator::formStep3Sections());
        $arr = array_merge($arr, DataGenerator::formStep4Sections());
        return $arr;

    }

    public static function formStep1Sections(){
        return [AppConstants::$SECTION_A,AppConstants::$SECTION_B];
    }

    public static function formStep2Sections(){
        return [AppConstants::$SECTION_C,AppConstants::$SECTION_D,AppConstants::$SECTION_D1,AppConstants::$SECTION_E];
    }

    public static function formStep3Sections(){
        return [AppConstants::$SECTION_F,AppConstants::$SECTION_G,AppConstants::$SECTION_H,AppConstants::$SECTION_I];
    }

    public static function formStep4Sections(){
        return [AppConstants::$SECTION_J,AppConstants::$SECTION_K,AppConstants::$SECTION_L,AppConstants::$SECTION_M,AppConstants::$SECTION_N];
    }



}