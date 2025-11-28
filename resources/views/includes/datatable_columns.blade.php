var data_columns = {

'out_of_office_records' : {
'order_idx_direction' : '0:desc',
'url' : "{{ route('out-of-office.list') }}",
'cols' : [
    { data: 'id' },
    { data: 'delegation_to_name' },
    { data: 'delegation_to_title' },
    { data: 'from_date_fmtd' },
    { data: 'to_date_fmtd' },
    { data: "actions", "searchable": false, "orderable": false}
]
},

'out_of_office_records_assigned_to_me' : {
'order_idx_direction' : '0:desc',
'url' : "{{ route('out-of-office.list.assigned-to-me') }}",
'cols' : [
    { data: 'id' },
    { data: 'delegation_by_name' },
    { data: 'delegation_by_title' },
    { data: 'from_date_fmtd' },
    { data: 'to_date_fmtd' }
]
},

{{--'driver_requests_driver_assignments_unassigned' : {
'url' : "{{ route('driver-assignments.list',DRIVER_REQUEST_STATUS_PENDING_ASSIGNMENT) }}",
'cols' : [
    { name: 'request_by_name' },
    { name: 'request_date' },
    { name: 'DistrictName' },
    { name: 'destination' },
    { name: 'activityType.type_name' },
    { name: 'activity_start_date' },
    { name: 'activity_end_date' },
    { name: 'status' },
    { name: 'AssignedDriver', "searchable": false, "orderable": false},
    { name: "ActionDriverAssignmentsUnAssigned", "searchable": false, "orderable": false}
]
},--}}



}
