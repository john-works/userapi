<?php

namespace App\Notifications;

use Carbon\Carbon;
use App\Department;
use App\ActionLogAdmin;
use App\ActionlogTask;
use App\ZzztymothyLogger;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ActionlogTaskNotification extends Notification
{
    use Queueable;
    const SUBJECT_TEMPLATE = "Action Log - [ACTION_TYPE]";
    const ACTION_LOG_ASSIGNMENT = "New Action Log Task";
    
    public $actionlog_task;
    
    public $subject = "";
   public $actionType = "";
   public $actionLogType = "";
   public $nextAction = "";
   public $nextActionUser = "";
   public $nextActionDate = "";
   public $actionDateTime = "";
   public $dateOpened = "";
   public $requiredAction = "";

    public static function actionlogTaskAssigned(ActionlogTask $actionlog_task)
    {

        $actionType = self::ACTION_LOG_ASSIGNMENT;
        $notify = new ActionlogTaskNotification();
        $notify->subject = str_replace("[ACTION_TYPE]",$actionType,self::SUBJECT_TEMPLATE);
        $notify->actionLogType = $actionlog_task->actionlog->actionlog_type;
        $notify->nextAction = $actionlog_task->next_action;
        $notify->nextActionUser = $actionlog_task->next_action_user;
        $notify->nextActionDate = $actionlog_task->next_action_date;
        $notify->dateOpened = $actionlog_task->actionlog->date_opened;
        $notify->requiredAction = $actionlog_task->actionlog->required_action;
        return $notify;
    }
}
