
<div  class="col s12">

    <form class="col s12" id="edit_regional_office_form{{$office->regionalOfficeCode}}" method="post" action="{{route('regional-offices.update')}}">

        {{-- Start : Hidden fields that hold required data --}}
        <input id="regional_office_code" name="regional_office_code" type="text" class="validate" hidden required value="{{$office->regionalOfficeCode}}">
        <input id="created_by" name="created_by" type="text" class="validate" hidden required value="{{$office->createdBy}}">
        <input id="updated_by" name="updated_by" type="text" class="validate" hidden required value="{{$author->username}}">
        {{-- End   : Hidden fields that hold required data --}}

        <div class="form-container">

            <div class="timo-form-headers center">Regional Office Details</div>

            {{-- Organization --}}
            <div class="row">
                <div class=" col m6 offset-m3 l6 offset-l3 s12">
                    <label class="display-block" for="org_code">Organization</label>
                    <select name="org_code" id="org_code_{{$office->regionalOfficeCode}}"  required class="browser-default timo-select">
                        <option value="" disabled selected>Choose Organization</option>
                        @if(isset($organizations) && count($organizations) > 0)
                            @foreach($organizations as $org)
                                <option @if($org->orgCode == $office->orgCode) selected @endif value="{{$org->orgCode}}">{{$org->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col s12 spacer"></div>
            </div>
            {{-- Regional office code --}}
            <div class="row">
                <div class="input-field col m6 offset-m3 l6 offset-l3 s12">
                    <input id="name" name="name" type="text" class="validate" required value="{{$office->name}}">
                    <label for="name">Regional Office Name</label>
                </div>
            </div>

            {{-- Contact Person Name, Contact --}}
            <div class="row">
                <div class="input-field col m6 offset-m3 l6 offset-l3 s12">
                    <input id="contact_person_name" name="contact_person_name" type="text" class="validate" value="{{$office->contactPersonName}}">
                    <label for="contact_person_name">Contact Person Name</label>
                </div>
            </div>
            {{-- Contact Person Name, Contact --}}
            <div class="row">
                <div class="input-field col m6 offset-m3 l6 offset-l3 s12">
                    <input id="contact_person_contact" name="contact_person_contact" type="text" class="validate" value="{{$office->contactPersonContact}}">
                    <label for="contact_person_contact">Contact Person Contact</label>
                </div>
            </div>

            {{-- Email --}}
            <div class="row">
                <div class="input-field col m6 offset-m3 l6 offset-l3 s12">
                    <input id="email" name="email" type="email" class="validate" value="{{$office->email}}">
                    <label for="email">Email</label>
                </div>
            </div>


            <div class="row">
                <div class="col s12">

                    <div class="message-success center" id="form-messages{{$office->regionalOfficeCode}}"></div>
                    <div class="message-error" id="print-error-msg{{$office->regionalOfficeCode}}" style="display:none">
                        <ul></ul>
                    </div>

                </div>
            </div>

            <div class="row row-custom-modal-footer">
                <div class="col s12 spacer-small"></div>
                <div class="col s12">
                    <button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal{{$office->regionalOfficeCode}}').modal('close'); return false;"  >CLOSE</button>
                    <button class="modal-action right btn-flat waves-effect waves-light camel-case waves-green" type="submit" name="action">UPDATE</button>
                </div>
                <div class="col s12 spacer"></div>
            </div>

            {{csrf_field()}}

        </div>

    </form>

</div>