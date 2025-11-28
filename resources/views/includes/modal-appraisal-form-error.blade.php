<div id="modal_message" class="modal modal-success-confirmation">
    <div class="modal-content">

        <h5 class="red-text">Operation Failed<i class="material-icons right ">error_outline</i></h5>

        @if(count($errors->all()) > 0)
            <div class="spacer-top">
                <div class="col">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li class="invalid-modal">{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">OK</a>
    </div>
</div>