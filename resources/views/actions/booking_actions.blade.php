<div class="actions">
    <i class="fa fa-list"></i>
    <div class="actions-list">
        <a class="clarify_tertiary" title="View/Edit Booking" href="{{ route('bookings.edit',$booking->id) }}">
            <i class="fa fa-edit"></i>
            <span>View/Edit Booking</span>
        </a>
        <a data-deletable="{{$booking->deletable}}" class="btn-delete danger" title="Delete Booking" href="{{ route('bookings.delete',$booking->id) }}">
            <i class="fa fa-trash-o"></i>
            <span>Delete Booking</span>
        </a>
    </div>
</div>
