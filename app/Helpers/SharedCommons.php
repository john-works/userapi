<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 5/29/2019
 * Time: 12:20
 */


namespace app\Helpers;


use Carbon\Carbon;

class SharedCommons {


    public static function formatDateStringToFormat($dateString, $dateFormat = 'Y-m-d') {

        try{

            if(is_null($dateString)) return $dateString;

            $date = Carbon::createFromTimeString($dateString); // Carbon::parse($dateString);
            return $date->format($dateFormat);


        }catch (\Exception $exception){

            return $dateString;

        }

    }

    public static function customFormError($error) {
        return ['custom_form_error' => $error];
    }

    public static function capitalize($data) {
        return $data == null ? $data : ucwords(strtolower($data));
    }

    public static function generateEmployeeAcceptanceStatus($appraisal)
    {

        return is_null($appraisal['appraisee_agreement_action'])|| strtolower($appraisal['appraisee_agreement_action']) == 'pending'  ?
            "Pending" :
            ucwords(strtolower($appraisal['appraisee_agreement_action']));// . "\n(".SharedCommons::formatDateStringToFormat($appraisal['appraisee_agreement_action_date']).")";

    }

}