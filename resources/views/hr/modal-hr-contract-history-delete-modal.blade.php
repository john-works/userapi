
<div id="modal_del_{{$contract->id}}" class="modal delete-modal">

    <div class="modal-content">
        <h5 class="red-text">Please Confirm</h5>
        <p>Are you sure to want to delete the Contract Details for the Period {{$contract->startDate}} to {{$contract->expiryDate}}?</p>
    </div>

    <div class="modal-footer">
        <a href="#" class="waves-effect waves-red btn-flat" onclick=" $('#modal_del_{{$contract->id}}').modal('close'); return false;">No</a>
        <a href="{{route('human-resource.user-contract.delete',$contract->id)}}" class="waves-effect waves-green btn-flat " id="modal_del_{{$contract->id}}_YesBtn">Yes</a>
    </div>

</div>