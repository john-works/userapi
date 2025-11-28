<div class="modal container fade" id="modalSessionFlushedMessage" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="modalSessionFlushedMessageContent" data-message="{{$msg}}" data-type="{{($isError)?'error':'success'}}"></div>
            <div class="modal-header">
                @if($isError)
                    <h4 class="modal-title text-danger">Operation Failed</h4>
                @else
                    <h4 class="modal-title text-success">Operation Successful</h4>
                @endif
            </div>
            <div class="modal-body">
                <p>{{$msg}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var flushedMessageType = $('#modalSessionFlushedMessageContent').attr('data-type');
    var flushedMessage = $('#modalSessionFlushedMessageContent').attr('data-message');
    show_custom_message_modal(flushedMessageType,flushedMessage,null,null);
</script>
