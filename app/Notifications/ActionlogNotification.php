<?php

namespace App\Notifications;

use Carbon\Carbon;
use App\Department;
use App\ActionLogAdmin;
use App\Statusupdate;
use App\ZzztymothyLogger;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ActionlogNotification extends Notification
{
    use Queueable;
    const SUBJECT_TEMPLATE = "Action Log - [ACTION_TYPE]";
    const ACTION_LOG_ASSIGNMENT = "Status Update";
    
    public $statusUpdate;
   public $dateOpened = "";
   public $dateUpdated = "";
   public $requiredAction = "";

    public static function actionlogAssigned(Statusupdate $statusupdate)
    {

        $actionType = self::ACTION_LOG_ASSIGNMENT;
        $notify = new ActionlogNotification();
        $notify->subject = str_replace("[ACTION_TYPE]",$actionType,self::SUBJECT_TEMPLATE);
        $notify->actionLogType = $statusupdate->actionlog->actionlog_type;
        $notify->statusUpdate = $statusupdate->current_status;
        $notify->createdBy = $statusupdate->created_by;
        $notify->dateOpened = $statusupdate->actionlog->date_opened;
        $notify->requiredAction = $statusupdate->actionlog->required_action;
        $notify->dateUpdated = $statusupdate->created_at;
        return $notify;
    }
}
