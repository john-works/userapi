<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 5/31/2019
 * Time: 12:27
 */


namespace app\Helpers;


class ConstAppraisalStatus {

    const PENDING_WORKFLOW_SUBMISSION = "000";
    const PENDING_SUPERVISOR_APPROVAL = "001";
    const REJECTED_BY_SUPERVISOR = "002";
    const PENDING_DEPARTMENT_HEAD_APPROVAL = "003";
    const REJECTED_BY_DEPARTMENT_HEAD = "004";
    const PENDING_EXECUTIVE_DIRECTOR_APPROVAL = "005";
    const REJECTED_BY_EXECUTIVE_DIRECTOR = "006";
    const COMPLETED_SUCCESSFULLY = "007";
    const CANCELED_BY_OWNER = "008";
    const PENDING_EMPLOYEE_ACCEPTANCE = "009";

    public static function getAppraisalStatusDescriptionByCode($statusCode) {

        switch ($statusCode){

            case self::PENDING_WORKFLOW_SUBMISSION:{
                return "Pending Workflow Submission";
                break;
            }
            case self::PENDING_SUPERVISOR_APPROVAL:{
                return "Pending Supervisor Approval";
                break;
            }
            case self::REJECTED_BY_SUPERVISOR:{
                return "Rejected by Supervisor";
                break;
            }
            case self::PENDING_DEPARTMENT_HEAD_APPROVAL:{
                return "Pending Head of Department Approval";
                break;
            }
            case self::REJECTED_BY_DEPARTMENT_HEAD:{
                return "Rejected by Head of Department";
                break;
            }
            case self::PENDING_EXECUTIVE_DIRECTOR_APPROVAL:{
                return "Pending Executive Director Approval";
                break;
            }
            case self::REJECTED_BY_EXECUTIVE_DIRECTOR:{
                return "Rejected by Executive Director";
                break;
            }
            case self::COMPLETED_SUCCESSFULLY:{
                return "Completed Successfully";
                break;
            }
            case self::CANCELED_BY_OWNER:{
                return "Cancelled by Owner";
                break;
            }
            default:{
                return "Status Unknown[".$statusCode."]";
                break;
            }
        }

    }

    public static function isRejectedStatus($status) {

        $rejectedStatuses = [self::REJECTED_BY_SUPERVISOR, self::REJECTED_BY_DEPARTMENT_HEAD,
                           self::REJECTED_BY_DEPARTMENT_HEAD, self::REJECTED_BY_EXECUTIVE_DIRECTOR];

        return in_array($status, $rejectedStatuses);

    }

    public static function isPendingApproval($status) {

        $approvalStatuses = [self::PENDING_SUPERVISOR_APPROVAL, self::PENDING_EXECUTIVE_DIRECTOR_APPROVAL,
            self::PENDING_DEPARTMENT_HEAD_APPROVAL];

        return in_array($status, $approvalStatuses);

    }

    public static function getSimpleStatusDescription($statusCode) {

        switch ($statusCode){

            case self::PENDING_WORKFLOW_SUBMISSION:{
                return "Not Yet Submitted";
                break;
            }
            case self::PENDING_SUPERVISOR_APPROVAL:{
                return "Submitted For Approval";
                break;
            }
            case self::REJECTED_BY_SUPERVISOR:{
                return "Rejected";
                break;
            }
            case self::PENDING_DEPARTMENT_HEAD_APPROVAL:{
                return "Submitted For Approval";
                break;
            }
            case self::REJECTED_BY_DEPARTMENT_HEAD:{
                return "Rejected";
                break;
            }
            case self::PENDING_EXECUTIVE_DIRECTOR_APPROVAL:{
                return "Submitted For Approval";
                break;
            }
            case self::REJECTED_BY_EXECUTIVE_DIRECTOR:{
                return "Rejected";
                break;
            }
            case self::COMPLETED_SUCCESSFULLY:{
                return "Fully Approved";
                break;
            }
            case self::CANCELED_BY_OWNER:{
                return "Cancelled";
                break;
            }
            default:{
                return "Status Unknown[".$statusCode."]";
                break;
            }
        }

    }

}