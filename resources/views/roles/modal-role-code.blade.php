<div id="modal_role_code" class="modal custom-fields modal-for-ajax-data">

    <div class="modal-content">

        <div  class="col s12">

            <form id="form_modal_role_code" class="col s12" method="post" action="{{route('role-codes.store')}}">

                <div class="form-container">

                    <div class="center timo-form-headers">Add System Role</div>

                    <div class="row">
                        <div class="col m6 offset-m3 l6 offset-l3 s12">
                            <label class="display-block" for="org_code">Organization</label>
                            <select name="org_code" required class="browser-default timo-select">
                                <option value="" disabled selected>Choose Organization</option>
                                @if(isset($organizations) && count($organizations) > 0)
                                    @foreach($organizations as $org)
                                        <option value="{{$org->orgCode}}">{{$org->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col m6 offset-m3 l6 offset-l3 s12">
                            <input id="role_name" name="role_name" type="text" class="validate" required value="">
                            <label for="role_name">Role Name</label>
                        </div>
                    </div>

                    {{-- Hidden created by field --}}
                    <input id="created_by" name="created_by" type="text" class="validate" hidden required value="{{$author->username}}">

                    <div class="row">
                        <div class="col s12">

                            <div class="message-success center" id="form-messages"></div>
                            <div class="message-error" id="print-error-msg" style="display:none">
                                <ul></ul>
                            </div>

                        </div>
                    </div>

                    {{--<div class="row spacer-bottom">
                        <div class="col s12 spacer"></div>
                        <div class="col s12 center">
                            <button class="btn waves-effect waves-light camel-case blue darken-4" type="submit" name="action">Create System Role</button>
                        </div>
                    </div>--}}
                    <div class="row row-custom-modal-footer">
                        <div class="col s12 spacer-small"></div>
                        <div class="col s12">
                            <button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal_role_code').modal('close'); return false;"  >CLOSE</button>
                            <button class="modal-action right btn-flat waves-effect waves-light camel-case waves-green" type="submit" name="action">SAVE</button>
                        </div>
                        <div class="col s12 spacer"></div>
                    </div>
                    {{csrf_field()}}
                </div>
            </form>

        </div>

    </div>
</div>