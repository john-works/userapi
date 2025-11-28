var listing = {
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

'trusted_devices_admin' : {
'order_idx_direction' : '0:desc',
'url' : "{{ route('trusted-devices.admin.list') }}",
'cols' : [
{ data: 'id' },
{ data: 'user_full_name' },
{ data: 'device_name' },
{ data: 'device_ip' },
{ data: 'browser' },
{ data: 'status' },
{ data: 'last_action_type' },
{ data: 'last_action_user' },
{ data: 'last_action_date' },
{ data: "actions", "searchable": false, "orderable": false}
]
},

'trusted_devices_action_history' : {
'order_idx_direction' : '0:desc',
'url' : "{{ route('trusted-devices.admin.action-history.list',['[ID]']) }}",
'cols' : [
{ data: 'id' },
{ data: 'action' },
{ data: 'action_user_full_name' },
{ data: 'action_datetime' },
{ data: 'comment' }
]
},

'trusted_devices_details' : {
'order_idx_direction' : '0:desc',
'url' : "{{ route('trusted-devices.admin.list',['[ID]']) }}",
'cols' : [
    { data: 'id' },
    { data: 'user_full_name' },
    { data: 'device_name' },
    { data: 'device_ip' },
    { data: 'browser' },
    { data: 'status' },
    { data: 'last_action_type' },
    { data: 'last_action_user' },
    { data: 'last_action_date' },
    { data: "actions_owner", "searchable": false, "orderable": false}
]
},
'trusted_devices_current_details' : {
        'order_idx_direction' : '0:desc',
        'url' : "{{ route('trusted-devices.current.list',['[ID]']) }}",
        'cols' : [
            { data: 'id' },
            { data: 'user_full_name' },
            { data: 'device_name' },
            { data: 'device_ip' },
            { data: 'browser' },
            { data: 'status' },
            { data: 'last_action_type' },
            { data: 'last_action_user' },
            { data: 'last_action_date' },
            { data: "actions_current", "searchable": false, "orderable": false}
        ]
    },


'out_of_office_admin_records' : {
'order_idx_direction' : '0:desc',
'url' : "{{ route('out-of-office.admin.list') }}",
'cols' : [
    { data: 'id' },
    { data: 'delegation_to_name' },
    { data: 'delegation_to_title' },
    { data: 'delegation_by_name' },
    { data: 'delegation_by_title' },
    { data: 'from_date_fmtd' },
    { data: 'to_date_fmtd' }
{{--    { data: "actions", "searchable": false, "orderable": false}--}}
]
},

'out_of_office_admin_history' : {
'order_idx_direction' : '0:desc',
'url' : "{{ route('out-of-office.admin.history.list') }}",
'cols' : [
    { data: 'id' },
    { data: 'delegation_to_name' },
    { data: 'delegation_to_title' },
    { data: 'delegation_by_name' },
    { data: 'delegation_by_title' },
    { data: 'from_date_fmtd' },
    { data: 'to_date_fmtd' }
{{--    { data: "actions", "searchable": false, "orderable": false}--}}
]
},



'session_history_for_user' : {
'order_idx_direction' : '0:desc',
'url' : "{{ route('session-history.for-user.list') }}",
'cols' : [
    { data: 'id' },
    { data: 'application' },
    { data: 'session_creation_datetime_fmtd' },
    { data: 'session_duration_minutes' },
    { data: 'session_expiry_datetime_fmtd' },
    { data: 'trusted_device_id' }
]
},


'out_of_office_history_by_me' : {
'order_idx_direction' : '0:desc',
'url' : "{{ route('out-of-office.owner.history.list',['[ID]']) }}",
'cols' : [
{ data: 'id' },
{ data: 'delegation_to_name' },
{ data: 'delegation_to_title' },
{ data: 'from_date_fmtd' },
{ data: 'to_date_fmtd' },
{ data: "actions", "searchable": false, "orderable": false}
]
},

'out_of_office_history_to_me' : {
    'order_idx_direction' : '0:desc',
    'url' : "{{ route('out-of-office.owner.history.list',['[ID]']) }}",
    'cols' : [
            { data: 'id' },
            { data: 'delegation_by_name' },
            { data: 'delegation_by_title' },
            { data: 'from_date_fmtd' },
            { data: 'to_date_fmtd' }
        ]
    },

    'job_tracker_statues' : {
        'order_idx_direction' : '0:desc',
        'url' : "{{ route('job_status_tracker_datatables') }}",
        'cols' : [
            {data: 'job_name'},
            {data: 'schedule'},
            {data: 'start_time'},
            {data: 'end_time'},
            {data: 'status'},
            {data: 'error'},
            {data: 'ErrorDetail', searchable: false, orderable: false}
        ]
    },
    'actionlogs' : {
        'order_idx_direction' : '0:desc',
        'url' : "{{ route('actionlogs.list',['[ID]']) }}",
        'cols' : [
            {
                name: 'date_opened',
                searchable: true,
                render: function( data, type, row, meta ){
                    return moment(data).format('ll')
                }
            },
            {name: 'reference_number'},
            {name: 'required_action'},
            {name: 'actionlog_type'},
            {name: 'department.name'},
            {name: 'responsible_person'},
            {name: 'status'},
            {name: 'LastStatusUpdate',searchable:false,orderable:false},
            {name: 'actions', searchable: false, orderable: false}
        ]
    },
    'department_actionlogs' : {
        'order_idx_direction' : '0:desc',
        'url' : "{{ route('department_actionlogs.list',['[ID]']) }}",
        'cols' : [
            {
                name: 'date_opened',
                searchable: true,
                render: function( data, type, row, meta ){
                    return moment(data).format('ll')
                }
            },
            {name: 'reference_number'},
            {name: 'required_action'},
            {name: 'actionlog_type'},
            {name: 'department.name'},
            {name: 'responsible_person'},
            {name: 'status'},
            {name: 'LastStatusUpdate',searchable:false,orderable:false},
            {name: 'actions', searchable: false, orderable: false}
        ]
    },
    'status_update_details' : {
        'order_idx_direction' : '0:desc',
        'url' : "{{ route('status_update_details.list',['[ID]']) }}",
        'cols' : [
            { name: 'id'},
            { name: 'current_status'},
            { name: 'created_by'},
            { name: 'created_at'},
        ]
    },
    'action_log_tasks' : {
        'order_idx_direction' : '0:desc',
        'url' : "{{ route('action_log_tasks.list',['[ID]']) }}",
        'cols' : [
            { name: 'id'},
            { name: 'next_action_user'},
            { name: 'next_action'},
            { name: 'next_action_date'},
            { name: 'created_by'},
            { name: 'updated_at'},
            { name: 'status'},
            {name: 'actions', searchable: false, orderable: false}
        ]
    },
    'trusted_user_action_logs' : {
        'order_idx_direction' : '0:desc',
        'url' : "{{ route('trusted_user_action_logs.list',['[ID]']) }}",
        'cols' : [
            {name: 'required_action'},
            {
                name: 'created_at',
                render: function( data, type, row, meta ){
                    return moment(data).format('ll')
                }
            },
            {name: 'actionlog_type.department_name', orderable: false},
            {name: 'department.name'},
            {name: 'responsible_person'},
            {name: 'status'},
            {
                name: 'status_update.next_action_user',
                searchable: false,
                orderable: false,
                render: function( data, type, row, meta ){
                    if(row[5] == 'Closed') {
                        return 'N/A'
                    }else{
                        return data
                    }
                }
            },
            {
                name: 'status_update.next_action',
                searchable: false,
                orderable: false,
                render: function( data, type, row ){
                    if(row[5] == 'Closed') {
                        return 'N/A'
                    }else{
                        return data
                    }
                }
            },
            {
                name: 'status_update.next_action_date',
                searchable: false,
                orderable:false,
                render: function( data, type, row ){
                    if(row[5] == 'Closed') {
                        return 'N/A'
                    }else{
                        return data
                    }
                }
            },
        ]
        },
    'calendar_users' : {
        'order_idx_direction' : '0:desc',
        'url' : "{{ route('calendar_users.list') }}",
    'cols' : [
        {name: 'user_id'},
        {name: 'calendar.name'},
        {name: 'actions', searchable: false, orderable: false}
    ]
    },
    'calendar_types':{
        'order_idx_direction' : '0:desc',
        'url' : "{{ route('calendar_types.list') }}",
        'cols' : [
            {name: 'department_code'},
            {name: 'department_name'},
            {name: 'color'},
            {name: 'backgroundColor'},
            {name: 'dragBackgroundColor'},
            {name: 'borderColor'},
            {name: 'actions', searchable: false, orderable: false}
        ]
    },
    'calendar_type_admins':{
        'order_idx_direction' : '0:desc',
        'url' : "{{ route('calendar_type_admins.list',['[ID]']) }}",
        'cols' : [
            {name: 'user_id'},
            {name: 'actions', searchable: false, orderable: false}
        ]
    },
    'board_committees':{
        'order_idx_direction' : '0:desc',
        'url' : "{{ route('board_committees.list') }}",
        'cols' : [
            {name: 'name'},
            {name: 'actions', searchable: false, orderable: false}
        ]
    },
    'audit_activities':{
        'order_idx_direction' : '0:desc',
        'url' : "{{ route('audit_activities.list') }}",
        'cols' : [
            {name: 'name'},
            {name: 'actions', searchable: false, orderable: false}
        ]
    },
    'audit_types':{
        'order_idx_direction' : '0:desc',
        'url' : "{{ route('audit_types.list') }}",
        'cols' : [
            {name: 'name'},
            {name: 'actions', searchable: false, orderable: false}
        ]
    },
    'action_log_types':{
        'order_idx_direction' : '0:desc',
        'url' : "{{ route('action_log_types.list') }}",
        'cols' : [
            {name: 'department_code'},
            {name: 'department_name'},
        ]
    },
    'action_log_admins':{
        'order_idx_direction' : '0:desc',
        'url' : "{{ route('action_log_admins.list') }}",
        'cols' : [
            {name: 'department_code'},
            {name: 'name'},
            {name: 'actions', searchable: false, orderable: false}
        ]
    },
    'action_log_type_admins':{
        'order_idx_direction' : '0:desc',
        'url' : "{{ route('action_log_type_admins.list',['[ID]']) }}",
        'cols' : [
            {name: 'user_id'},
            {name: 'actions', searchable: false, orderable: false}
        ]
    },
    'portal_users' : {
        'order_idx_direction' : '0:desc',
        'url' : "{{ route('administration.users.list') }}",
        'cols' : [
            { name: 'id'},
            { name: 'user.first_name',},
            { name: 'user.last_name'},
            { name: 'username'},
            { name: 'Department', "searchable": false, "orderable": false},
            { name: 'Designation', "searchable": false, "orderable": false},
            { name: "Action", "searchable": false, "orderable": false}
        ]
    },
    'master_data_history' : {
        'order_idx_direction' : '0:desc',
        'url' : "{{ route('administration.master_data_history.list') }}",
        'cols' : [
            { name: 'id'},
            { name: 'parent_master_data_type'},
            { name: 'master_data_type'},
            { name: 'action_type'},
            { name: 'action_user'},
            { name: 'action_date'},
            { name: 'OldValueTrimmed', "searchable": false, "orderable": false},
            { name: 'NewValueTrimmed', "searchable": false, "orderable": false},
            { name: "Compare", "searchable": false, "orderable": false}
        ]
    },
    'pm_audit_field_activities_pop_up' : {
        'order_idx_direction' : '3:desc',
        {{-- 'url' : "{{ route('pm_audit_field_activities','[EXTRA]') }}", --}}
        'url' : "http://app-server:10000/datatable/list/NewFieldActivity/%5BEXTRA%5D",
        'cols' : [
            { name: 'Office', orderable:false},
            { name: 'activity_summary'},
            { name: 'entity.entity_name', orderable:false},
            { name: 'activity_start_date'},
            { name: 'line_manager', orderable:false},
            { name: 'TeamMembers',orderable:false},
            { name: 'Scope',orderable:false},
            { name: 'Performance',orderable:false},
        ]
    },
    'shared_resources':{
        'order_idx_direction' : '0:desc',
        'url' : "{{ route('shared_resources.list') }}",
        'cols' : [
            {name: 'name'},
            {name: 'location'},
            {name: 'IsAvailable'},
            {name: 'actions', searchable: false, orderable: false}
        ]
    },
    'bookings' : {
        'order_idx_direction' : '0:desc',
        'url' : "{{ route('bookings.list') }}",
        'cols' : [
            { name: 'id' },
            { name: 'purpose' },
            { name: 'start' },
            { name: 'end' },
            { name: 'internal_participants' },
            { name: 'external_participants' },
            { name: "Actions", "searchable": false, "orderable": false}
        ]
    },
}
