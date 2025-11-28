<?php

namespace App\Http\Controllers;

use app\ApiResp;
use app\Helpers\ApiHandler;
use app\Helpers\AppConstants;
use app\Helpers\EndPoints;

class JobErrorLogsController extends Controller
{

    public function error_logs()
    {
        return view('administration.error_logs');
    }

    public function job_status_tracker_datatables(){

        $apiResp = ApiHandler::makeGetRequest('/job_status_trackers',false, false,null, endpoint('BASE_URL'));
        if($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return json_encode(ApiResp::failure($apiResp->statusDescription));
        }

        $resp = json_decode($apiResp->result);
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return json_encode(ApiResp::failure($resp->statusDescription));
        }
        $trackers = $resp->data;

        $result = [];
        foreach ($trackers as $tracker){
            $tracker->ErrorDetail = $this->getErrorDetailsActionBtn($tracker);
            $result[] = $tracker;
        }

        return datatables(collect($result))
            ->rawColumns(['ErrorDetail','error'])
            ->toJson();

    }

    public function error_log_details($error_log){

        $apiResp = ApiHandler::makeGetRequest('/error_log_details',false, false,$error_log, endpoint('BASE_URL'));
        if($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return json_encode(ApiResp::failure($apiResp->statusDescription));
        }

        $resp = json_decode($apiResp->result);
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return json_encode(ApiResp::failure($resp->statusDescription));
        }

        $error = $resp->data;
        return view('administration.error_log_details', compact('error'));
    }

    public function run_jobs()
    {

        $apiResp = ApiHandler::makeGetRequest('/run_jobs_list',false, false,null, endpoint('BASE_URL'));
        if($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return json_encode(ApiResp::failure($apiResp->statusDescription));
        }

        $resp = json_decode($apiResp->result);
        if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
            return json_encode(ApiResp::failure($resp->statusDescription));
        }
        $runJobs = $resp->data;

        $result = [];
        foreach ($runJobs as $job){
            $data = array( 'command' => $job->command);
            $job->actions = view('actions.app_job_actions')->with($data)->render();
            $result[] = $job;
        }

        $data = array(
            'jobs' => $result
        );
        return view('administration.run_jobs')->with($data);
    }

    public function trigger_job($command){

        try{

            set_time_limit ( 0 ); // 0 have no time limit

            $command = decrypt($command);
            $data = array(
              'command' => $command
            );

            $apiResp = ApiHandler::makePostRequest('/trigger_job',$data, false, false, endpoint('BASE_URL'));
            if($apiResp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return json_encode(ApiResp::failure($apiResp->statusDescription));
            }

            $resp = json_decode($apiResp->result);
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return json_encode(ApiResp::failure($resp->statusDescription));
            }

            $msg = $resp->statusDescription;
            return json_encode(ApiResp::success($msg,$msg));

        } catch (\Exception $ex) {
            return json_encode(ApiResp::failure($ex->getMessage()));
        }

    }

    private function getErrorDetailsActionBtn($jobStatusTracker)
    {

        if($jobStatusTracker->error_log_id == null){
            return "<div class='btn-group-minier'><a class='btn' disabled href='#!'>Error Details</a></div>";
        }

        $errorId = $jobStatusTracker->error_log_id;
        return "<div class='btn-group-minier'><a title='Error Details' class='btn btn-danger clarify_secondary' href='".route('error_log_details',$errorId)."'>Error Details</a></div>";

    }


}
