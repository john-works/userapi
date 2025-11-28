<div class="actions">
    <i class="fa fa-list"></i>
    <div class="actions-list">
        <a data-deletable="{{$logger_admin->deletable}}" class="btn-delete danger" title="Delete Logger Admin" href="{{ route('logger_admins.remove',$logger_admin->id) }}">
            <i class="fa fa-trash-o"></i>
            <span>Delete Logger Admin</span>
        </a>
    </div>
</div>
