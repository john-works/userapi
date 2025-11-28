
<div  class="col s12">

    <form class="col s12" id="edit_role_form{{$role->id}}" method="post" action="{{route('edit_role')}}">

        <input type="hidden" value="{{$role->id}}" name="role_id"/>

        <div class="form-container">

            <h5 class="">Role Information</h5>

            <div class="row">
                <div class="input-field col s12">
                    <input id="role" name="role" type="text" class="validate" required value="{{$role->role}}">
                    <label for="role">Role</label>
                </div>
            </div>

            <div class="row">
                <div class="col s12">

                    <div class="message-success" id="form-messages{{$role->id}}"></div>
                    <div class="message-error" id="print-error-msg{{$role->id}}" style="display:none">
                        <ul></ul>
                    </div>

                </div>
            </div>

            <div class="row row-custom-modal-footer">
                <div class="col s12 spacer-small"></div>
                <div class="col s12">
                    <button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal{{$role->id}}').modal('close'); return false;"  >CLOSE</button>
                    <button class="modal-action right btn-flat waves-effect waves-light camel-case waves-green" type="submit" name="action">UPDATE</button>
                </div>
                <div class="col s12 spacer"></div>
            </div>

            {{csrf_field()}}

        </div>

    </form>

</div>