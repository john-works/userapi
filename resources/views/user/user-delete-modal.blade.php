
<div id="modal_del_{{$user->username}}" class="modal delete-modal">

    <div class="modal-content">
        <h5 class="red-text">Please Confirm</h5>
        <p>Are you sure to want to delete the user profile for {{$user->firstName}} {{$user->lastName}}?</p>
    </div>

    <div class="modal-footer">
        <a href="#" class="waves-effect waves-red btn-flat" onclick=" $('#modal_del_{{$user->username}}').modal('close'); return false;">No</a>
        <a href="#" class="waves-effect waves-green btn-flat" id="modal_del_{{$user->username}}_YesBtn">Yes</a>
    </div>

</div>