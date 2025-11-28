<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 5/20/2019
 * Time: 14:22
 */


namespace app\Repositories\General;


use app\Helpers\ApiHandler;
use app\Helpers\AppConstants;
use app\Helpers\DataFormatter;
use app\Helpers\EndPoints;
use app\RepositoryResp;

class ApplicationStatsRepo {


    public static function getApplicationStats($token){

        $repoResp = new RepositoryResp();

        $apiResp = ApiHandler::makeGetRequest(endpoint('APPLICATION_STATS_ALL'), true, $token);

        /*
         * Check if got a response from the API
         * */
        if($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            $repoResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $repoResp->statusDescription = $apiResp->statusDescription;
            return $repoResp;
        }

        /*
         * Get the server response
         * */
        $apiRespAppStats = json_decode($apiResp->result, true);
        $statusCodeAppStats = $apiRespAppStats['statusCode'];
        $statusDescriptionAppStats = $apiRespAppStats['statusDescription'];


        /*
         * Check if we got success for the requests from the server
         * */
        if($statusCodeAppStats != AppConstants::$STATUS_CODE_SUCCESS){
            $repoResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $repoResp->statusDescription = $statusDescriptionAppStats;
            return $repoResp;
        }

        /*
         * We format the data returned
         * */
        $appStats = DataFormatter::getAppStat($apiRespAppStats['data']);

        /*
         * Construct success response
         * */
        $repoResp->repoData = $appStats;
        $repoResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
        $repoResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
        return $repoResp;

    }

}