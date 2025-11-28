
<div class="actions">
    <i class="fa fa-list"></i>
    <div class="actions-list">
        @if((!isset($record->last_action) || (isset($record->last_action) && $record->last_action->action != 'Approved'&& $record->last_action->action != 'Revoked')) )
            <a data-url="{{ route('trusted-devices.admin.approve',$record->id) }}" class="btnAjaxGet" title="Approve Device" href="#"><i class="fa fa-edit"></i> <span>Approve</span></a>
        @elseif((isset($record->last_action) && $record->last_action->action == 'Approved'))
            <a data-url="{{ route('trusted-devices.admin.revoke',[$record->id,'PARAM_COMMENT']) }}" class="btnRevokeTrustedDevice" title="Revoke Device" href="#"><i class="fa fa-edit"></i> <span>Revoke</span></a>
        @endif
            <a class="clarify_secondary" title="Action History" href="{{route('trusted-devices.admin.action-history',$record->id)}}"><i class="fa fa-edit"></i> <span>View History</span></a>
    </div>
</div>
