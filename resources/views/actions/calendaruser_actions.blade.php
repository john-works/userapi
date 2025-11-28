<div class="actions">
    <i class="fa fa-list"></i>
    <div class="actions-list">
        <a data-deletable="{{$calendaruser->deletable}}" class="btn-delete danger" title="Delete Calendar User" href="{{ route('calendar_users.delete',$calendaruser->id) }}">
            <i class="fa fa-trash-o"></i>
            <span>Delete Calendar User</span>
        </a>
    </div>
</div>
