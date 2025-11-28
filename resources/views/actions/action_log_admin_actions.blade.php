<div class="actions">
    <i class="fa fa-list"></i>
    <div class="actions-list">
        <a data-deletable="{{$action_log_admin->deletable}}" class="btn-delete danger" title="Delete Action Log Admin" href="{{ route('action_log_admins.remove',$action_log_admin->id) }}">
            <i class="fa fa-trash-o"></i>
            <span>Delete Action Log Admin</span>
        </a>
    </div>
</div>
