<div class="actions">
    <i class="fa fa-list"></i>
    <div class="actions-list">
        <a class="clarify_tertiary" title="View/Edit - {{$shared_resource->name}}" href="{{ route('shared_resources.edit',$shared_resource->id) }}">
            <i class="fa fa-edit"></i>
            <span>View/Edit Resource</span>
        </a>
        @if($shared_resource->is_available ==true)
            <a class="btn-deactivate" href="{{ route('shared_resources.unavail',$shared_resource->id) }}">
                <i class="fa fa-thumbs-down"></i>
                <span>Unavail Resource</span>
            </a>
        @else
            <a class="btn-activate" href="{{ route('shared_resources.avail',$shared_resource->id) }}">
                <i class="fa fa-thumbs-up"></i>
                <span>Avail Resource</span>
            </a>
        @endif
    </div>
</div>
