
<div  class="col s12">

    <form class="col s12" id="edit_department_form{{$department->departmentCode}}" method="post" action="{{route('departments.update')}}">

        {{-- Start : Hidden fields that hold required data --}}
        <input id="department_code" name="department_code" type="text" class="validate" hidden required value="{{$department->departmentCode}}">
        <input id="created_by" name="created_by" type="text" class="validate" hidden required value="{{$department->createdBy}}">
        <input id="updated_by" name="updated_by" type="text" class="validate" hidden required value="{{$author->username}}">
        {{-- End   : Hidden fields that hold required data --}}

        <div class="form-container">

            <div class="center timo-form-headers">Department Details</div>

            {{-- Department Name and Department Code fields --}}
            <div class="row">
                <div class="input-field col m6 offset-m3 l6 offset-l3 s12">
                    <input id="name" name="name" type="text" class="validate" required value="{{$department->name}}">
                    <label for="name">Department Name</label>
                </div>
            </div>

            {{-- Organization Code Fields --}}
            <div class="row">
                <div class="col m6 offset-m3 l6 offset-l3 s12">
                    <label class="display-block" for="org_code">Organization</label>
                    <select style="width: 98%" name="org_code" id="org_code_{{$department->departmentCode}}" required class="browser-default">
                        <option value="" disabled selected>Choose Organization</option>
                        @if(isset($organizations) && count($organizations) > 0)
                            @foreach($organizations as $org)
                                <option @if($org->orgCode == $department->orgCode) selected @endif value="{{$org->orgCode}}">{{$org->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="col s12 spacer"></div>
            </div>

            <div class="row">
                <div class=" col m6 offset-m3 l6 offset-l3 s12">
                    <label class="display-block" for="hod">Head of Department</label>
                    <select style="width: 98%" name="hod" id="head_of_department_{{$department->departmentCode}}" required class="browser-default ">
                        <option value="" disabled selected>Choose Head of Department</option>
                        @if(isset($users) && count($users) > 0)
                            @foreach($users as $user)
                                <option @if($user->username == $department->hodUsername) selected @endif value="{{$user->username}}">{{$user->fullName}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col s12 spacer"></div>
            </div>


            <div class="row">
                <div class="col s12">

                    <div class="message-success center" id="form-messages{{$department->departmentCode}}"></div>
                    <div class="message-error" id="print-error-msg{{$department->departmentCode}}" style="display:none">
                        <ul></ul>
                    </div>

                </div>
            </div>

            <div class="row row-custom-modal-footer">
                <div class="col s12 spacer-small"></div>
                <div class="col s12">
                    <button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal{{$department->departmentCode}}').modal('close'); return false;"  >CLOSE</button>
                    <button class="modal-action right btn-flat waves-effect waves-light camel-case waves-green" type="submit" name="action">UPDATE</button>
                </div>
                <div class="col s12 spacer"></div>
            </div>

            {{csrf_field()}}

        </div>

    </form>

</div>