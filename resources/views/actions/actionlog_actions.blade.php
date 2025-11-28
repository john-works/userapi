
<div class="actions">
    <i class="fa fa-list"></i>
    <div class="actions-list">
        @if((isset($actionlog)))
                <a class="{{($actionlog->created_by == session('user')->username)?'clarify_secondary':'check_creator'}}" title="Edit Actionlog" data-current="{{session('user')->username}}" data-creator="{{$actionlog->created_by}}" id="checkActionLogCreator" href="{{route('actionlogs.edit',$actionlog->id)}}">
                    <i class="fa fa-edit"></i>
                    <span>Edit Actionlog</span>
                </a>
            @if($actionlog->status == ACTION_LOG_STATUS_CLOSED)
                <a class="clarify_secondary" title="Status History" href="{{route('statusupdates.get',$actionlog->id)}}">
                    <i class="fa fa-edit"></i>
                    <span>View Status History</span>
                </a>
            @else
                <a class="clarify_secondary" title="Status History" href="{{route('statusupdates.get',$actionlog->id)}}">
                    <i class="fa fa-edit"></i>
                    <span>View Status History</span>
                </a>
                @php
                    $url = ($actionlog->status == ACTION_LOG_STATUS_IN_PROGRESS) ? 'actionlogs.to_pending' : 'actionlogs.complete';
                @endphp
                @if($actionlog->status == ACTION_LOG_STATUS_IN_PROGRESS)
                    <a class="{{($actionlog->created_by == session('user')->username)?'clarify_tertiary':'check_creator'}}" data-current="{{session('user')->username}}" data-creator="{{$actionlog->created_by}}" id="closeActionLog" title="Close Action Log" href="{{ route( $url,$actionlog->id) }}">
                        <i class="fa fa-edit"></i>
                        <span>Close Action Log</span>
                    </a>
                @endif
                @if($actionlog->status == ACTION_LOG_PENDING_CLOSURE)
                    <a class="{{($actionlog->created_by == session('user')->username)?'clarify_tertiary':'check_creator'}}" data-current="{{session('user')->username}}" data-creator="{{$actionlog->created_by}}" id="closeActionLog" title="Close Action Log" href="{{ route( $url,$actionlog->id) }}">
                        <i class="fa fa-edit"></i>
                        <span>Confirm Action Log Close</span>
                    </a>
                @endif
            @endif
        @endif
    </div>
</div>
