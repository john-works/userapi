<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 5/24/2019
 * Time: 11:03
 */


namespace app\Models;


class ApiAppraisal {

    public $appraisalRef = "";
    public $appraisalType = "";
    public $ownerUsername = "";
    public $status = "";
    public $generatedPdfName = "";
    public $pdfDownloadLink = "";

    public $supervisorUsername = "";
    public $supervisorDecision = "";
    public $supervisorSubmissionDate = "";
    public $supervisorActionDate = "";
    public $supervisorRemark = "";

    public $employeeAcceptanceStatus = "";

    public $deptHeadUsername = "";
    public $deptHeadDecision = "";
    public $deptHeadSubmissionDate = "";
    public $deptHeadActionDate = "";
    public $deptHeadRemark = "";

    public $executiveDirectorUsername = "";
    public $executiveDirectorDecision = "";
    public $executiveDirectorSubmissionDate = "";
    public $executiveDirectorActionDate = "";
    public $executiveDirectorRemark = "";

    public $createdAt = "";


    /*
     * Fields for the different sections
     * */

    public $user;
    public $personalInfo;

    public $academicBackgrounds = [];
    public $keyDuties = [];
    public $assignments = [];
    public $additionalAssignments = [];
    public $performanceGaps = [];
    public $performanceChallenges = [];
    public $performanceAppraiserComment = [];
    public $workPlans = [];
    public $competenceAssessments = [];

    public $assignmentsScores;
    public $additionalAssignmentsScores;
    public $assignmentsSummaries;

    public $performancesSummaries;

    public $competenceAssessmentsScores;
    public $competenceAssessmentsSummaries;

    public $appraiserComment;
    public $strengthAndWeakness;
    public $appraiserRecommendation;
    public $supervisorDeclaration;
    public $hodComment;
    public $appraiseeRemark;
    public $directorComment;

    public $isOwner = true;
    public $isPendingApproval = false;
    public $isCancelled = false;
    public $isRejected = false;
    public $isCompleted = false;
    public $simpleStatus;

    public $redirectTo;

}