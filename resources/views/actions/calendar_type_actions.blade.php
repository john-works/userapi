<div class="actions">
    <i class="fa fa-list"></i>
    <div class="actions-list">
        <a class="clarify" title="View/Edit - {{$calendar_type->department_name}}" href="{{ route('calendar_types.show',$calendar_type->id) }}">
            <i class="fa fa-edit"></i>
            <span>View/Edit Calendar Type</span>
        </a>
        <a class="clarify" title="View/Edit - {{$calendar_type->name}}" href="{{ route('calendar_colors.edit',$calendar_type->id) }}">
            <i class="fa fa-edit"></i>
            <span>Edit Colors</span>
        </a>
    </div>
</div>
