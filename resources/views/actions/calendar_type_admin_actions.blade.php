<div class="actions">
    <i class="fa fa-list"></i>
    <div class="actions-list">
        <a data-deletable="{{$calendar_type_admin->deletable}}" class="btn-delete danger" title="Delete Action Log Admin" href="{{ route('calendar_type_admins.remove',$calendar_type_admin->id) }}">
            <i class="fa fa-trash-o"></i>
            <span>Delete Calendar Type Admin</span>
        </a>
    </div>
</div>
