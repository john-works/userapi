<div id="modal_user" class="modal custom-fields modal-70">

    <div class="modal-content">

        <div  class="col s12">

            <form id="form_modal_user" class="col s12" method="post" action="{{route('users.store')}}">

                <div class="form-container">
                    <div class="center timo-form-headers">User Registration</div>
                    {{-- Staff File Number & Email --}}
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="staff_number" name="staff_number" type="text" class="validate" required value="{{old('staff_number')}}">
                            <label for="staff_number">Staff Personal File Number</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="email" name="email" type="email" class="validate" required value="{{old('email')}}">
                            <label for="email">Email</label>
                        </div>
                    </div>
                    {{-- Names --}}
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="first_name" name="first_name" type="text" class="validate" required value="{{old('first_name')}}">
                            <label for="first_name">First Name</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="last_name" name="last_name" type="text" class="validate" required value="{{old('last_name')}}">
                            <label for="last_name">Last Name</label>
                        </div>
                        <div class="col s12 spacer"></div>
                    </div>
                    {{-- Contract Details --}}
                    <div class="row spacer-bottom">
                        <div class=" col s6">
                            <label class="display-block" for="contract_start_date">Current Contract Start Date</label>
                            <input style="width: 98%" id="contract_start_date" name="contract_start_date" type="date" class="browser-default timo-date-picker" required value="{{old('contract_start_date')}}">
                        </div>
                        <div class=" col s6">
                            <label class="display-block" for="contract_expiry_date">Current Contract Expiry Date</label>
                            <input style="width: 98%" id="contract_expiry_date" name="contract_expiry_date" type="date" class="browser-default timo-date-picker" required value="{{old('contract_expiry_date')}}">
                        </div>
                    </div>

                    {{-- DOB and Designation --}}
                    <div class="row">
                        <div class=" col s6">
                            <label class="display-block" for="date_of_birth">Date of Birth</label>
                            <input style="width: 98%" id="date_of_birth" name="date_of_birth" type="date" class="browser-default timo-date-picker" required value="{{old('date_of_birth')}}">
                        </div>
                        <div class="col s6">
                            <label class="display-block" for="designation_id">Designation</label>
                            <select id="designation_id" name="designation_id" required class="browser-default timo-select">
                                <option value="" disabled selected>Choose designation</option>
                                @if(isset($designations) && count($designations) > 0)
                                    @foreach($designations as $designation)
                                        <option value="{{$designation->id}}">{{$designation->title}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    {{-- Organization Field & Regional Office Field --}}
                    <div class="row spacer-bottom">
                        <div class="col s6">
                            <label class="display-block" for="org_code">Organization</label>
                            <select name="org_code" required class="browser-default timo-select">
                                <option value="" disabled selected>Choose organization</option>
                                @if(isset($organizations) && count($organizations) > 0)
                                    @foreach($organizations as $organization)
                                        <option value="{{$organization->orgCode}}">{{$organization->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col s6">
                            <label class="display-block" for="regional_office_code">Regional Office</label>
                            <select name="regional_office_code" required class="browser-default timo-select">
                                <option value="" disabled selected>Choose regional office</option>
                                @if(isset($regionalOffices) && count($regionalOffices) > 0)
                                    @foreach($regionalOffices as $office)
                                        <option value="{{$office->regionalOfficeCode}}">{{$office->name}}</option>
                                    @endforeach
                                @endif
                            </select>

                        </div>

                    </div>

                    {{-- Employee Category Field --}}
                    <div class="row spacer-bottom">
                        <div class=" col s6">
                            <label class="display-block" for="category_code">Staff Category</label>
                            <select name="category_code" required class="browser-default timo-select">
                                <option value="" disabled selected>Choose staff category</option>
                                @if(isset($categories) && count($categories) > 0)
                                    @foreach($categories as $category)
                                        <option value="{{$category->categoryCode}}">{{$category->category}}</option>
                                    @endforeach
                                @endif
                            </select>

                        </div>
                        <div class="col s6 ">
                            <label class="display-block" for="department_code">Department</label>
                            <select name="department_code" required class="browser-default timo-select">
                                <option value="" disabled selected>Choose department</option>
                                @if(isset($departments) && count($departments) > 0)
                                    @foreach($departments as $department)
                                        <option value="{{$department->departmentCode}}">{{$department->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                    </div>

                    <div class="row spacer-bottom">

                        {{-- Role Code field --}}
                        <div class=" col m6 s12">
                            <label class="display-block" for="role_code">Appraisal System Role</label>
                            <select name="role_code" required class="browser-default timo-select">
                                <option value="" disabled selected>Choose appraisal role</option>
                                <option value="NORMAL USER">Normal User</option>
                                <option value="HUMAN RESOURCE USER">Human Resource User</option>
                            </select>
                        </div>

                    </div>

                    <div class="row spacer-bottom">
                        <div class=" col s6">
                            <label class="display-block" for="category_code">Department Unit</label>
                            <select name="department_unit" required class="browser-default timo-select">
                                <option value="" disabled selected>Choose department unit</option>
                                @if(isset($units) && count($units) > 0)
                                    @foreach($units as $unit)
                                        <option value="{{$unit->unitCode}}">{{$unit->unit}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col s6 ">
                            <div class="">
                                <a href="#!" data-id-prefix="" class="btn btnSetLmsRoles timo-primary camel-case">Set LMS Roles</a>
                                <input type="hidden" id="reception_flag" name="reception_flag" value="0"/>
                                <input type="hidden" id="finance_flag" name="finance_flag" value="0"/>
                                <input type="hidden" id="registry_flag" name="registry_flag" value="0"/>
                                <input type="hidden" id="ed_office_flag" name="ed_office_flag" value="0"/>
                                <input type="hidden" id="outgoing_letter_flag" name="outgoing_letter_flag" value="0"/>
                                <input type="hidden" id="master_data_flag" name="master_data_flag" value="0"/>
                                <input type="hidden" id="reports_flag" name="reports_flag" value="0"/>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col s12">

                            <div class="message-success center" id="form-messages"></div>
                            <div class="message-error" id="print-error-msg" style="display:none">
                                <ul></ul>
                            </div>

                        </div>
                    </div>

                    <input id="created_by" name="created_by" type="text" class="validate" hidden required value="{{$author->username}}">

                    <div class="row row-custom-modal-footer">
                        <div class="col s12 spacer-small"></div>
                        <div class="col s12">
                            <button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal_user').modal('close'); return false;"  >CLOSE</button>
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
