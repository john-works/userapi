<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 9/19/19
 * Time: 7:39 AM
 */

namespace App\Helpers;


use App\ApiResp;
use App\ZzztymothyLogger;
use PHPMailer\PHPMailer\PHPMailer;

//use Illuminate\Support\Facades\Mail;


class EmailHandler {


    public static function sendPlainTextEmailPHPMAILER($mailTo, $subject, $message){

        $inProduction = true;
        $resp = new ApiResp();

        try{

            if($inProduction){
                return self::sendMailProduction($mailTo, $subject, $message);
            }else{
                return self::sendMailTestEnvironment($mailTo, $subject, $message);
            }

        }catch (\Exception $exception){

            /*
             * Error occurred on sending the email
             * */
            $resp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $resp->statusDescription = $exception->getMessage();
            ZzztymothyLogger::logError("Stack Track: ".$exception->getTraceAsString());
            return $resp;

        }

    }

    public static function sendEmailToMailingList($subject, $body, $mailingList)
    {
        foreach ($mailingList as $email){
             $emailResp = self::sendPlainTextEmailPHPMAILER($email, $subject, $body);
             if($emailResp->statusCode != CONST_STATUS_CODE_SUCCESS){
                 ZzztymothyLogger::logError("Failed Email Resp: ".json_encode($emailResp));
             }
        }
    }

    private static function sendMailProduction($mailTo, $subject, $message)
    {

        $resp = new ApiResp();

        $mail             = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->SMTPDebug  = 0;  // debugging: 0 = off, 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth   = true;  // authentication enabled
        $mail->SMTPSecure = env('MAIL_ENCRYPTION', 'tls');; // secure transfer enabled REQUIRED for Gmail
        $mail->Host       = env('MAIL_HOST', 'mail.ppda.go.ug');
        $mail->Port       = env('MAIL_PORT', 587);
        $mail->IsHTML(true);


        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->Username = env('MAIL_USERNAME', 'application_admin@ppda.go.ug');
        $mail->Password = env('MAIL_PASSWORD', 'PPDA3ncrypt1on');
        $mail->SetFrom(env('MAIL_FROM', 'application_admin@ppda.go.ug'));

        $mail->set('FromName',env('MAIL_FROM_NAME', 'User Management Portal'));
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AddAddress($mailTo);


        /*
         * We attempt to send the email
         * */
        if (!$mail->Send()) {

            $resp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $resp->statusDescription = 'Failed to Send Email';
            return $resp;

        }


        /*
         * Build success response
         * */
        $resp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
        $resp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
        return $resp;
    }

    private static function sendMailTestEnvironment($mailTo, $subject, $message)
    {

        $resp = new ApiResp();
        /*
         * Send the email
         * */
        $mail             = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->SMTPDebug  = 0;  // debugging: 0 = off, 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth   = true;  // authentication enabled
        $mail->SMTPSecure = env('MAIL_ENCRYPTION', 'tls');;  // secure transfer enabled REQUIRED for Gmail
        $mail->Host       = env('MAIL_HOST', 'smtp.gmail.com');
        $mail->Port       = env('MAIL_PORT', 587);
        $mail->IsHTML(true);


        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->Username = env('MAIL_USERNAME', 'timothykasaga@gmail.com');
        $mail->Password = env('MAIL_PASSWORD', 'yrxfbejwuctcpurx');
        $mail->SetFrom(env('MAIL_USERNAME', 'timothykasaga@gmail.com'));

        $mail->set('FromName',env('MAIL_FROM_NAME', 'User Management Portal'));
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AddAddress($mailTo);

        /*
         * We attempt to send the email
         * */
        if (!$mail->Send()) {

            $resp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $resp->statusDescription = 'Failed to Send Email';
            return $resp;

        }

        /*
         * Build success response
         * */
        $resp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
        $resp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
        return $resp;
    }

}
