<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 5/19/2019
 * Time: 14:05
 */


namespace app\Repositories\General;


use app\Helpers\ApiHandler;
use app\Helpers\AppConstants;
use app\Helpers\DataFormatter;
use app\Helpers\EndPoints;
use app\RepositoryResp;

class OrganizationsRepo {

    public static function allOrganizations($token){

        $repoResp = new RepositoryResp();

        $respOrganizations = ApiHandler::makeGetRequest(endpoint('ORGANIZATIONS_ALL'), true, $token);

        /*
         * Check if got a response from the API
         * */
        if($respOrganizations->statusCode != AppConstants::$STATUS_CODE_SUCCESS){

            $repoResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $repoResp->statusDescription = $respOrganizations->statusDescription;
            return $repoResp;
        }

        /*
         * Get the server response
         * */
        $apiRespOrg = json_decode($respOrganizations->result, true);
        $statusCodeOrg = $apiRespOrg['statusCode'];
        $statusDescriptionOrg = $apiRespOrg['statusDescription'];


        /*
         * Check if we got success for the requests from the server
         * */
        if($statusCodeOrg != AppConstants::$STATUS_CODE_SUCCESS){
            $repoResp->statusCode = AppConstants::$STATUS_CODE_FAILED;
            $repoResp->statusDescription = $statusDescriptionOrg;
            return $repoResp;
        }

        /*
         * We format the data returned
         * */
        $organizations = DataFormatter::formatOrganizations($apiRespOrg['data']);

        /*
         * Construc success response
         * */
        $repoResp->repoData = $organizations;
        $repoResp->statusCode = AppConstants::$STATUS_CODE_SUCCESS;
        $repoResp->statusDescription = AppConstants::$STATUS_DESC_SUCCESS;
        return $repoResp;

    }


}