
<div  class="col s12">


    <form class="col s12" id="edit_organization_form{{$org->orgCode}}" method="post" action="{{route('organizations.update')}}">

        {{-- Start : Hidden fields that hold required data --}}
        <input id="org_code" name="org_code" type="text" class="validate" hidden required value="{{$org->orgCode}}">
        <input id="created_by" name="created_by" type="text" class="validate" hidden required value="{{$org->createdBy}}">
        <input id="updated_by" name="updated_by" type="text" class="validate" hidden required value="{{$author->username}}">
        {{-- End   : Hidden fields that hold required data --}}

        <div class="form-container">

            <div class="col s12 center timo-form-headers">ORGANIZATION DETAILS</div>

            {{-- Organization name and Code --}}
            <div class="row">
                <div class="input-field col m6 offset-m3 l6 offset-l3 s12">
                    <input id="name" name="name" type="text" class="validate" required value="{{$org->name}}">
                    <label for="name">Organization Name</label>
                </div>
            </div>


            <div class="row">
                <div class="input-field col m6 offset-m3 l6 offset-l3 s12">
                    <input id="contact_person_name" name="contact_person_name" type="text" class="validate" required value="{{$org->contactPersonName}}">
                    <label for="contact_person_name">Contact Person Name</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col  m6 offset-m3 l6 offset-l3 s12">
                    <input id="contact_person_contact" name="contact_person_contact" type="text" class="validate" required value="{{$org->contactPersonContact}}">
                    <label for="contact_person_contact">Contact Person Contact</label>
                </div>
            </div>


            <div class="row">
                <div class="input-field col  m6 offset-m3 l6 offset-l3 s12">
                    <input id="email" name="email" type="email" class="validate" required value="{{$org->email}}">
                    <label for="email">Email</label>
                </div>
            </div>

            <div class="row">
                <div class=" col  m6 offset-m3 l6 offset-l3 s12">
                    <label class="display-block" for="executive_director">Executive Director</label>
                    <select style="width: 98%" name="executive_director" id="executive_director_{{$org->orgCode}}" required class="browser-default ">
                        <option value="" disabled selected>Choose Executive Director</option>
                        @if(isset($users) && count($users) > 0)
                            @foreach($users as $user)
                                <option @if($user->username == $org->executiveDirector) selected @endif value="{{$user->username}}">{{$user->fullName}}</option>
                            @endforeach
                        @endif
                    </select>

                </div>
            </div>


            <div class="row">
                <div class="col s12">

                    <div class="message-success center" id="form-messages{{$org->orgCode}}"></div>
                    <div class="message-error" id="print-error-msg{{$org->orgCode}}" style="display:none">
                        <ul></ul>
                    </div>

                </div>
            </div>

            <div class="row row-custom-modal-footer">
                <div class="col s12 spacer-small"></div>
                <div class="col s12">
                    <button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal{{$org->orgCode}}').modal('close'); return false;"  >CLOSE</button>
                    <button class="modal-action right btn-flat waves-effect waves-light camel-case waves-green" type="submit" name="action">UPDATE</button>
                </div>
                <div class="col s12 spacer"></div>
            </div>

            {{csrf_field()}}

        </div>

    </form>

</div>