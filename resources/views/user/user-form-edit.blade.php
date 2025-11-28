
<div  class="col s12">


    <form class="col s12" id="edit_profile_form{{$user->id}}" method="post" action="{{route('users.update')}}">

        {{-- Start : Hidden fields that hold required data --}}
        <input id="created_by" name="created_by" type="text" class="validate" hidden required value="{{$user->createdBy}}">
        <input id="updated_by" name="updated_by" type="text" class="validate" hidden required value="{{$author->username}}">
        <input id="username" name="username" type="text" class="validate" hidden required value="{{$user->username}}">
        {{-- End   : Hidden fields that hold required data --}}


        <div class="form-container">

            <div class="center timo-form-headers spacer-bottom">User Profile</div>

            {{-- Email Field --}}
            <div class="row">
                <div class="input-field col s6">
                    <input id="staff_number" name="staff_number" type="text" class="validate" required value="{{isset($user->staffNumber)?$user->staffNumber:' '}}">
                    <label class="active" for="staff_number">Staff Personal File Number</label>
                </div>
                <div class="input-field col s6">
                    <input id="email" name="email" type="email" class="validate" required value="{{$user->email}}">
                    <label for="email">Email</label>
                </div>
            </div>

            {{-- Names Field --}}
            <div class="row">
                <div class="input-field col s6">
                    <input id="first_name" name="first_name" type="text" class="validate" required value="{{$user->firstName}}">
                    <label for="first_name">First Name</label>
                </div>
                <div class="input-field col s6">
                    <input id="last_name" name="last_name" type="text" class="validate" required value="{{$user->lastName}}">
                    <label for="last_name">Last Name</label>
                </div>
            </div>

            <div class="row spacer-bottom">
                <div class=" col s6">
                    <label class="display-block" for="contract_start_date">Current Contract Start Date</label>
                    <input style="width: 98%" id="contract_start_date" name="contract_start_date" type="date" class="browser-default timo-date-picker" required value="{{$user->contractStartDate}}">
                </div>
                <div class=" col s6">
                    <label class="display-block" for="contract_expiry_date">Current Contract Expiry Date</label>
                    <input style="width: 98%" id="contract_expiry_date" name="contract_expiry_date" type="date" class="browser-default timo-date-picker" required value="{{$user->contractExpiryDate}}">
                </div>
            </div>

            <div class="row">
                <div class=" col s6">
                    <label class="display-block" for="date_of_birth">Date of Birth</label>
                    <input style="width: 98%" id="date_of_birth" name="date_of_birth" type="date" class="browser-default timo-date-picker" required value="{{$user->dateOfBirth}}">
                </div>
                <div class="col s6">
                    <label class="display-block" for="designation_id">Designation</label>
                    <select id="designation_id" name="designation_id" required class="browser-default timo-select">
                        <option value="" disabled selected>Choose designation</option>
                        @if(isset($designations) && count($designations) > 0)
                            @foreach($designations as $designation)
                                <option @if($user->designationId == $designation->id) {{'selected'}} @endif value="{{$designation->id}}">{{$designation->title}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            {{-- Organization Field --}}
            <div class="row spacer-bottom" >
                <div class="col s6">
                    <label class="display-block" for="org_code">Organization</label>
                    <select name="org_code" id="org_code_{{$user->id}}" required class="browser-default timo-select">
                        <option value="" disabled >Choose organization</option>
                        @if(isset($organizations) && count($organizations) > 0)
                            @foreach($organizations as $organization)
                                <option @if($user->orgCode == $organization->orgCode) selected="selected" @endif value="{{$organization->orgCode}}">{{$organization->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col s6">
                    <label class="display-block" for="regional_office_code">Regional Office</label>
                    <select name="regional_office_code" id="regional_office_code_{{$user->id}}" required class="browser-default timo-select">
                        <option value="" disabled >Choose regional office</option>
                        @if(isset($regionalOffices) && count($regionalOffices) > 0)
                            @foreach($regionalOffices as $office)
                                <option @if($user->regionalOfficeCode == $office->regionalOfficeCode) selected @endif  value="{{$office->regionalOfficeCode}}">{{$office->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>


            {{-- Employee Category Field --}}
            <div class="row spacer-bottom">
                <div class="col s6">
                    <label class="display-block" for="category_code">Staff Category</label>
                    <select name="category_code" id="category_code_{{$user->id}}" required class="browser-default timo-select">
                        <option value="" disabled >Choose staff category</option>
                        @if(isset($categories) && count($categories) > 0)
                            @foreach($categories as $category)
                                <option @if($user->categoryCode == $category->categoryCode) selected @endif value="{{$category->categoryCode}}">{{$category->category}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col s6 ">
                    <label class="display-block" for="department_code">Department</label>
                    <select name="department_code" id="department_code_{{$user->id}}" required class="browser-default timo-select">
                        <option value="" disabled >Choose department</option>
                        @if(isset($departments) && count($departments) > 0)
                            @foreach($departments as $department)
                                <option @if($user->departmentCode == $department->departmentCode) selected @endif value="{{$department->departmentCode}}">{{$department->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>


            {{-- Department Field --}}
            <div class="row spacer-bottom">
                {{-- Role Code field --}}
                <div class="col s6">
                    <label class="display-block" for="role_code">Appraisal System Role</label>
                    <select name="role_code" id="role_code_{{$user->id}}" required class="browser-default timo-select">
                        <option value="" disabled selected>Choose role</option>
                        <option value="NORMAL USER" @if($user->roleCode == 'NORMAL USER') selected @endif >Normal User</option>
                        <option  value="HUMAN RESOURCE USER" @if($user->roleCode == 'HUMAN RESOURCE USER') selected @endif>Human Resource</option>
                    </select>
                </div>

            </div>



            <div class="row spacer-bottom">
                <div class="col s6">
                    <label class="display-block" for="department_unit">Department unit</label>
                    <select name="department_unit" id="department_unit_{{$user->id}}" required class="browser-default timo-select">
                        <option value="" disabled selected >Choose department unit</option>
                        @if(isset($units) && count($units) > 0)
                            @foreach($units as $unit)
                                @if($unit->departmentCode == $user->departmentCode) <option @if($user->unitCode == $unit->unitCode) selected @endif value="{{$unit->unitCode}}">{{$unit->unit}}</option> @endif
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col s6 ">
                    <div class="">
                        <a href="#!" data-id-prefix="{{$user->id}}" class="btn btnSetLmsRoles timo-primary camel-case">Set LMS Roles</a>
                        <input type="hidden" id="{{$user->id}}reception_flag" name="reception_flag" value="{{(isset($user->lmsRole) && $user->lmsRole->reception) ? 1 : 0}}"/>
                        <input type="hidden" id="{{$user->id}}finance_flag" name="finance_flag" value="{{(isset($user->lmsRole) && $user->lmsRole->finance) ? 1 : 0}}"/>
                        <input type="hidden" id="{{$user->id}}registry_flag" name="registry_flag" value="{{(isset($user->lmsRole) && $user->lmsRole->registry) ? 1 : 0}}"/>
                        <input type="hidden" id="{{$user->id}}ed_office_flag" name="ed_office_flag" value="{{(isset($user->lmsRole) && $user->lmsRole->edOffice) ? 1 : 0}}"/>
                        <input type="hidden" id="{{$user->id}}outgoing_letter_flag" name="outgoing_letter_flag" value="{{(isset($user->lmsRole) && $user->lmsRole->outLetters) ? 1 : 0}}"/>
                        <input type="hidden" id="{{$user->id}}master_data_flag" name="master_data_flag" value="{{(isset($user->lmsRole) && $user->lmsRole->masterData) ? 1 : 0}}"/>
                        <input type="hidden" id="{{$user->id}}reports_flag" name="reports_flag" value="{{(isset($user->lmsRole) && $user->lmsRole->reports) ? 1 : 0}}"/>
                    </div>
                </div><div class="col s6 "></div>
            </div>

            <div class="row">
                <div class="col s12">
                    @if(count($errors->all()) > 0)
                        <ul>
                            @foreach($errors->all() as $error)
                                <li class="invalid">{{$error}}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>


            <div class="row">
                <div class="col s12">

                    <div class="message-success center" id="form-messages{{$user->id}}"></div>
                    <div class="message-error" id="print-error-msg{{$user->id}}" style="display:none">
                        <ul></ul>
                    </div>

                </div>
            </div>

            <div class="row row-custom-modal-footer">
                <div class="col s12 spacer-small"></div>
                <div class="col s12">
                    <button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal_user_edit{{$user->id}}').modal('close'); return false;"  >CLOSE</button>
                    <button class="modal-action right btn-flat waves-effect waves-light camel-case waves-green" type="submit" name="action">UPDATE</button>
                </div>
            </div>

            {{csrf_field()}}


        </div>


    </form>

</div>
