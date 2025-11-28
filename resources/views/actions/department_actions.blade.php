<div class="actions">
    <i class="fa fa-list"></i>
    <div class="actions-list">
        {{-- <a class="clarify" title="View/Edit - {{$department->name}}" href="{{ route('action_log_admins.index',$department->id) }}"> --}}
        <a class="clarify" title="View/Edit - {{$department->name}}" href="{{ route('action_log_admins.show',$department->id) }}">
            <i class="fa fa-edit"></i>
            <span>View/Edit Action Log Admins</span>
        </a>
    </div>
</div>
