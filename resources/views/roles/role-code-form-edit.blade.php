
<div  class="col s12">

    <form class="col s12" id="edit_role_code_form{{$role->roleCode}}" method="post" action="{{route('role-codes.update')}}">

        {{-- Start : Hidden fields that hold required data --}}
        <input id="role_code" name="role_code" type="text" class="validate" hidden required value="{{$role->roleCode}}">
        <input id="created_by" name="created_by" type="text" class="validate" hidden required value="{{$role->createdBy}}">
        <input id="updated_by" name="updated_by" type="text" class="validate" hidden required value="{{$author->username}}">
        {{-- End   : Hidden fields that hold required data --}}

        <div class="form-container">

            <div class="center timo-form-headers">System Role Details</div>


            {{-- Organization --}}
            <div class="row">
                <div class="col m6 offset-m3 l6 offset-l3 s12">
                    <label class="display-block" for="org_code">Organization</label>
                    <select name="org_code" id="org_code_{{$role->roleCode}}" required class="browser-default timo-select">
                        <option value="" disabled selected>Choose Organization</option>
                        @if(isset($organizations) && count($organizations) > 0)
                            @foreach($organizations as $org)
                                <option @if($role->orgCode == $org->orgCode) selected @endif value="{{$org->orgCode}}">{{$org->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col s12 spacer"></div>
            </div>
            {{-- Role Code and Role Name --}}
            <div class="row">
                <div class="input-field col m6 offset-m3 l6 offset-l3 s12">
                    <input id="role_name" name="role_name" type="text" class="validate" required value="{{$role->roleName}}">
                    <label for="role_name">Role Name</label>
                </div>
            </div>

            <div class="row">
                <div class="col s12">

                    <div class="message-success center" id="form-messages{{$role->roleCode}}"></div>
                    <div class="message-error" id="print-error-msg{{$role->roleCode}}" style="display:none">
                        <ul></ul>
                    </div>

                </div>
            </div>

            <div class="row row-custom-modal-footer">
                <div class="col s12 spacer-small"></div>
                <div class="col s12">
                    <button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal{{$role->roleCode}}').modal('close'); return false;"  >CLOSE</button>
                    <button class="modal-action right btn-flat waves-effect waves-light camel-case waves-green" type="submit" name="action">UPDATE</button>
                </div>
                <div class="col s12 spacer"></div>
            </div>

            {{csrf_field()}}

        </div>

    </form>

</div>