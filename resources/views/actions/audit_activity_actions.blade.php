<div class="actions">
    <i class="fa fa-list"></i>
    <div class="actions-list">
        <a class="clarify" title="View/Edit - {{$auditActivity->name}}" href="{{ route('audit_activities.edit',$auditActivity->id) }}">
            <i class="fa fa-edit"></i>
            <span>View/Edit Audit Activity</span>
        </a>
        <a data-deletable="{{$auditActivity->deletable}}" class="btn-delete danger" title="Delete Audit Activity" href="{{ route('audit_activities.delete',$auditActivity->id) }}">
            <i class="fa fa-trash-o"></i>
            <span>Delete Audit Activity</span>
        </a>
    </div>
</div>
