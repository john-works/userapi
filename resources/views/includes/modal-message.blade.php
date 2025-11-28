<div id="modal_message" class="modal modal-success-confirmation">
    <div class="modal-content">
        @if($isError)

            <h5 class="red-text">Operation Failed</h5>
            <p>{{$msg}}</p>

        @else

            <h5 class="green-text">Operation Successful</h5>
            <p>{{$msg}}</p>

        @endif

    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">OK</a>
    </div>
</div>