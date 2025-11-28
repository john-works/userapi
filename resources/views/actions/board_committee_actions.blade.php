<div class="actions">
    <i class="fa fa-list"></i>
    <div class="actions-list">
        <a class="clarify" title="View/Edit - {{$board_committee->name}}" href="{{ route('board_committees.edit',$board_committee->id) }}">
            <i class="fa fa-edit"></i>
            <span>View/Edit Board Committee</span>
        </a>
        <a data-deletable="{{$board_committee->deletable}}" class="btn-delete danger" title="Delete Board Committee" href="{{ route('board_committees.delete',$board_committee->id) }}">
            <i class="fa fa-trash-o"></i>
            <span>Delete Board Committee</span>
        </a>
    </div>
</div>
