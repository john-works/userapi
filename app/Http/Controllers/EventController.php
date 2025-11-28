<?php

namespace App\Http\Controllers;

use App\User;
use App\CalendarEvent;
use App\AuditType;
use Carbon\Carbon;
use App\CalendarType;
use App\AuditActivity;
use Illuminate\Http\Request;
use Facades\App\Facades\AppUsageTracker;

class EventController extends Controller
{
    public function index($calendar_type=null)
    {
        if(!$calendar_type){
            $calendar_types = CalendarType::all();
        }elseif($calendar_type == MENU_ITEM_DEPARTMENT_CALENDAR){
            $code = ($calendar_type === MENU_ITEM_DEPARTMENT_CALENDAR) ? session('user')->departmentCode : $calendar_type;
            $calendar_types = CalendarType::where('department_code', $code)->get();
        }elseif($calendar_type == MENU_ITEM_PM_CALENDAR){
            $code = ($calendar_type === MENU_ITEM_PM_CALENDAR) ? 'DEPT_24' : 'DEPT_26';
            $calendar_types = CalendarType::where('department_code', $code)->get();
        }else{
            $calendar_types = CalendarType::where('department_code', $calendar_type)->get();
        }
        $events = $this->showEvents($calendar_types);
        return $events;
    }
    public function showEvents($calendar_types=null){
        if ($calendar_types) {
            foreach ($calendar_types as $calendar_type) {
                $events = CalendarEvent::where('calendar_type_id', $calendar_type->department_code)->get();
                return response()->json([
                    'calendar_types'=>[$calendar_type],
                    'events' => $events,
                    'styling' => [
                        'backgroundColor' => $calendar_type->backgroundColor,
                        'borderColor' => $calendar_type->borderColor,
                        'color' => $calendar_type->color,
                    ],
                ]);
            }
        } else {
            $allCalendars = CalendarType::all();
            $allEvents = CalendarEvent::all();
    
            $calendarsWithStyling = $allCalendars->map(function ($calendar) use ($allEvents) {
                $events = $allEvents->where('calendar_type_id', $calendar->department_code)->values();
    
                return [
                    'id' => $calendar->id,
                    'name' => $calendar->name,
                    'styling' => [
                        'backgroundColor' => $calendar->backgroundColor,
                        'borderColor' => $calendar->borderColor,
                        'color' => $calendar->color,
                    ],
                    'events' => $events,
                ];
            });
            return response()->json(['calendars' => $calendarsWithStyling]);
        }
    }
    public function store(Request $request){

        $data = $request->validate([
            'title'=>'required',
            'location'=>'required',
            'start'=>'required',
            'end'=>'required',
            'calendarId'=>'required',
            'category'=>'nullable',
            'isPrivate'=>'required',
            'state'=>'nullable',
            'pm_event_type'=>'nullable',
            'audit_activity'=>'nullable',
            'audit_type'=>'nullable',
            'entity_id'=>'nullable',
        ]);

        if($data['pm_event_type']=='Audit'){
            $entity = $this->getNameById(ppda_entities(),$data['entity_id']);
            $found_entity = $entity ? $entity : 'N/A';
        }
        $startDateTime = Carbon::parse($data['start']);
        $endDateTime = Carbon::parse($data['end']);

        $event = CalendarEvent::create([
            'calendar_type_id'=>$data['calendarId'],
            'title'=>$data['title'],
            'location'=>$data['location'],
            'start' => $startDateTime->toDateTimeString(),
            'end' => $endDateTime->toDateTimeString(),
            'isAllDay'=>1,
            'category'=>isset($data['category'])? $data['category']:'allday',
            'isPrivate'=>isset($data['isPrivate'])? $data['isPrivate']:0,
            'state'=>isset($data['state'])? $data['state']:'Busy',
            'pm_event_type'=>$data['pm_event_type'],
            'pm_audit_activity_id'=>$data['pm_event_type']=='Audit'? $data['audit_activity'] : null,
            'pm_audit_type_id'=>$data['pm_event_type']=='Audit'? $data['audit_type']: null,
            'pm_entity_name'=>$data['pm_event_type']=='Audit'? $found_entity: null,
            'pm_entity_id'=>$data['pm_event_type']=='Audit'? $data['entity_id']: null,
        ]);
        $styles = CalendarType::where('department_code',$data['calendarId'])->orWhere('department_name',$data['calendarId'])->get();
        return [
            'event'=>$event,
            'styles'=>$styles
        ];
    }
    public function getNameById($array, $searchId) {
        foreach ($array as $entity) {
            if ($entity['id'] == $searchId) {
                return $entity['entity_name'];
            }
        }
        return null;
    }
    
    public function edit(CalendarEvent $event){
        $pm_event_type = $event->pm_event_type;
        $entity = $event->pm_entity_name;
        $entity_id = $event->pm_entity_id;
        $pm_audit_type = AuditType::where('id',$event->pm_audit_type_id)->first();
        $pm_audit_activity =AuditActivity::where('id',$event->pm_audit_activity_id)->first();
        $data = [
            'event'=>$event,
            'pm_event_type'=>$pm_event_type,
            'pm_audit_type'=>$pm_audit_type,
            'pm_audit_activity'=>$pm_audit_activity,
            'pm_entity_name'=>$entity,
            'pm_entity_id'=>$entity_id,
        ];
        return $data;
    }
    public function sessionEntities(){
        return ppda_entities();
    }
    public function update(Request $request, CalendarEvent $event){

        $data = $request->validate([
            'pm_event_type'=>'nullable',
            'audit_activity'=>'nullable',
            'audit_type'=>'nullable',
            'entity_name'=>'nullable',
            'entity_id'=>'nullable',
            'title'=>'required',
            'location'=>'required',
            'start'=>'required',
            'end'=>'required',
            'calendarId'=>'required',
            'category'=>'nullable',
            'isPrivate'=>'required',
            'state'=>'nullable',
        ]);
        

        if($data['pm_event_type']=='Audit'){
            $entity = $this->getNameById(ppda_entities(),$data['entity_id']);
            $found_entity = $entity ? $entity : 'N/A';
        }
        $startDateTime = Carbon::parse($data['start']);
        $endDateTime = Carbon::parse($data['end']);
        
        $event->update([
            'pm_event_type'=>$data['pm_event_type'],
            'pm_audit_activity_id'=>$data['pm_event_type']=='Audit'? $data['audit_activity']: null,
            'pm_audit_type_id'=>$data['pm_event_type']=='Audit'? $data['audit_type']: null,
            'pm_entity_name'=>$data['pm_event_type']=='Audit'? $found_entity: null,
            'pm_entity_id'=>$data['pm_event_type']=='Audit'? $data['entity_id']: null,
            'calendar_type_id'=>$data['calendarId'],
            'title'=>$data['title'],
            'location'=>$data['location'],
            'start' => $startDateTime->toDateTimeString(),
            'end' => $endDateTime->toDateTimeString(),
            'isAllDay' => 1,
            'isPrivate' => $data['isPrivate'] ? 1 : 0,
            'category'=>isset($data['category'])? $data['category']:'allday',
            'state'=>isset($data['state'])? $data['state']:'Busy',
        ]);
        return $event;
    }
    public function departmentCalendar(){
        $td_service = new TrustedDevicesController();
        $resp = $td_service->getTrustedDeviceInfo();
        if(isset($resp['trustedDevice'])){
            $user = User::where('username',$resp['trustedDevice']->username)->first();
            $track = AppUsageTracker::track('User Management','Login Portal','View Calendar','View Calendar', null, $user->username);
            $department = $user->department;
            $department_code = $department->department_code;
            $specific_ids = ['BOARD','EXCO','TRAINING_ROOM',$department_code];
            $calendars = CalendarType::whereIn('department_code',$specific_ids)->get();

            foreach ($calendars as $calendar) {
                $events = CalendarEvent::where('calendar_type_id', $calendar->department_code)->get();
                $styling = [
                    'backgroundColor' => $calendar->backgroundColor,
                    'borderColor' => $calendar->borderColor,
                    'color' => $calendar->color,
                ];
            }

            $data = [
                'user'=>$user,
                'department'=>$department,
                'calendars'=>$calendars,
                'events' => $events,
                'styling' => $styling,
            ];

            return view('calendar.index')->with($data);

        }else{
            throw new \Exception('There is no trusted device set!');
        }
    }

    public function destroy(CalendarEvent $event){
        $event->delete();
        return response()->json(['message'=>'Event deleted successfully!']);
    }
}
