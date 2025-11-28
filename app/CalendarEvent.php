<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    protected $table = 'calendar_events';
    protected $fillable = [
        'calendar_type_id',
        'title',
        'location',
        'start',
        'end',
        'isAllDay',
        'category',
        'isPrivate',
        'state',
        'pm_event_type',
        'pm_audit_type_id',
        'pm_audit_activity_id',
        'pm_entity_id',
        'pm_entity_name',
    ];
    public function calendar(){
        return $this->belongsTo('App\CalendarType');
    }
}
