
<div id="modal_del_{{$org->orgCode}}" class="modal delete-modal">

    <div class="modal-content">
        <h5 class="red-text">Please Confirm</h5>
        <p>Are you sure to want to delete the Organization {{$org->name}}?</p>
    </div>

    <div class="modal-footer">
        <a href="#" class="waves-effect waves-red btn-flat" onclick=" $('#modal_del_{{$org->orgCode}}').modal('close'); return false;">No</a>
        <a href="#" class="waves-effect waves-green btn-flat" id="modal_del_{{$org->orgCode}}_YesBtn">Yes</a>
    </div>

</div>