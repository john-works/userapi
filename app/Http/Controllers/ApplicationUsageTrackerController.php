<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApplicationUsageTracker;

class ApplicationUsageTrackerController extends Controller
{
    public function save(Request $request){
        try{
            $tracker = ApplicationUsageTracker::create([
                'application'=>$request->application,
                'module'=>$request->module,
                'section'=>$request->section,
                'sub_section'=>$request->sub_section,
                'detail'=>$request->detail,
                'username'=>$request->username,
                'access_datetime'=>$request->access_datetime,
            ]);
            return 'Track created successfully!';
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function report(){
        return view('app-usage.report');
    }

    public function generate(Request $request){
        $start_date = \Carbon\Carbon::parse($request->start_date);
        $end_date = \Carbon\Carbon::parse($request->end_date);
        $report_type = $request->report_type;

        $records = ApplicationUsageTracker::whereBetween('access_datetime',[$start_date,$end_date])->get();

        $period = ' '.$start_date->format('j M Y').' - '.$end_date->format('j M Y');

        if($report_type == 'Detailed'){
            return view('app-usage.detailed',compact('records','period'));
        }else{
            return view('app-usage.summary',compact('records','period'));
        }

    }
}
