<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 5/25/2019
 * Time: 13:04
 */


namespace app\Models;


class ApiAppraisalReq {

    public $token = "";
    public $workflowRole;
    public $status;
    public $additionStatusFilter;
    public $supervisorDecision;
    public $hodDecision;
    public $directorDecision;
    public $startDate;
    public $endDate;

}