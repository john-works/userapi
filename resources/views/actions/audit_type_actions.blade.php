<div class="actions">
    <i class="fa fa-list"></i>
    <div class="actions-list">
        <a class="clarify" title="View/Edit - {{$auditType->name}}" href="{{ route('audit_types.edit',$auditType->id) }}">
            <i class="fa fa-edit"></i>
            <span>View/Edit Audit Type</span>
        </a>
        <a data-deletable="{{$auditType->deletable}}" class="btn-delete danger" title="Delete Audit Type" href="{{ route('audit_types.delete',$auditType->id) }}">
            <i class="fa fa-trash-o"></i>
            <span>Delete Audit Type</span>
        </a>
    </div>
</div>
