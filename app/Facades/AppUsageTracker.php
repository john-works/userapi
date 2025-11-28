<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade as BaseFacade;
use App\Helpers\ApiHandler;

class AppUsageTracker extends BaseFacade
{
    protected $to = [];

    protected static function getFacadeAccessor() { return 'app.usage.tracker'; }

    public function track($application,$module,$section,$sub_section=null,$detail=null,$username=null){
        $usageData = [
            'application'=>$application,
            'module'=>$module,
            'section'=>$section,
            'sub_section'=>$sub_section,
            'detail'=>$detail,
            'username'=>$username,
            'access_datetime'=>date("Y-m-d H:i:s"),
        ];

        /*
         * send the request
         * */
        $app_usage_tracker_api_endpoint = endpoint("app_usage_tracker");
        $baseURL = $app_usage_tracker_api_endpoint;
        $resp = ApiHandler::makePostRequest("", $usageData, false,null, $baseURL );

        $result = json_decode($resp->result);
        // if($resp->statusCode == "0" && $result->statusCode != "0" && $result->statusDescription == 'Validation Failed'){

        //     $result->statusDescription =  json_encode($result->errors);
        //     $resp->result = json_encode($result);
        // }
        return $resp;

    }

}
