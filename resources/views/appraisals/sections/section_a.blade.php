<form class="col s12" id="section-a-form" action="{{route('save_section_a')}}" method="post">
    <div class="row">

        <div class="col s12 spacer"></div>

        <div class="col m4 s12">
            <label style="display: block">Appraisal Type</label>
            <select id="appraisal_type"  name="appraisal_type"  required class="validate browser-default">
                <option value="0" disabled selected>Choose Appraisal Type</option>
                <option @if(old('appraisal_type') == 'ANNUAL') selected @endif  value="ANNUAL">Annual Appraisal</option>
                <option @if(old('appraisal_type') == 'PROBATION') selected @endif value="PROBATION">End of Probation</option>
                <option @if(old('appraisal_type') == 'RENEWAL') selected @endif value="RENEWAL">Contract Renewal</option>
            </select>
        </div>
        <div class="col m8 s12"> </div>
    </div>

    <div class="row spacer-top">
        <div class="col m4 s12">
            <label class="display-block">Supervisor</label>
            <select name="supervisor" required class="validate browser-default">
                <option value="" disabled selected>Choose Supervisor</option>
                @if(isset($users) && count($users) > 0)
                    @foreach($users as $usr)
                        <option @if(old('supervisor') == $usr->username) selected @endif value="{{$usr->username}}">{{$usr->fullName}}</option>
                    @endforeach
                @endif
            </select>

        </div>
        <div class="col  m4 s12">
            <label class="display-block">Head of Department</label>
            <select name="hod" required class="browser-default">
                <option value="" disabled selected>Choose Head of Department</option>
                @if(isset($users) && count($users) > 0)
                    @foreach($users as $usr)
                        <option @if($usr->username == $user->departmentHeadUsername) selected @endif  value="{{$usr->username}}">{{$usr->fullName}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col  m4 s12">
            <label class="display-block">Executive Director</label>
            <select name="ed" required class=" browser-default">
                <option value="" disabled selected>Choose Executive Director</option>
                @if(isset($users) && count($users) > 0)
                    @foreach($users as $usr)
                        <option @if($usr->username == $user->orgEdUsername) selected @endif value="{{$usr->username}}">{{$usr->fullName}}</option>
                    @endforeach
                @endif
            </select>

        </div>
    </div>

    {{-- Appraisal Evalualtion Period Dates --}}
    <div class="row">
        {{-- Appraisal Start Date --}}
        <div class=" col m6 s12">
            <label for="appraisal_start_date" class="display-block @if(isset($appraisal)) active @endif">
                Appraisal Period Start Date
            </label>
            <input style="width: 98%"  id="appraisal_start_date" name="appraisal_start_date" type="date" class="validate timo-date-picker browser-default" value="{{old('appraisal_start_date')}}" required>

        </div>
        {{-- Appraisal End Date --}}
        <div class="col m6 s12">
            <label for="appraisal_end_date" class="display-block @if(isset($appraisal)) active @endif">
                Appraisal Period End Date
            </label>
            <input style="width: 98%" id="appraisal_end_date" name="appraisal_end_date" type="date" class="validate timo-date-picker browser-default"  value="{{old('appraisal_end_date')}}" required>

        </div>

    </div>

    <div class="row">
        <div class="col s12 divider-primary" style="margin-top: 20px;margin-bottom: 20px"> </div>
    </div>

    <div class="row spacer-top">
        <div class="input-field col m6 s12">
            <input id="surname" name="surname" type="text" class="" readonly value="@if(isset($user)){{$user->lastName}}@endif">
            <label for="surname" class="@if(isset($user)) active @endif">Surname </label>
        </div>
        <div class="input-field col m6 s12">
            <input id="other_name" name="other_name" type="text" class="" readonly value="@if(isset($user)){{$user->firstName}}@endif">
            <label for="other_name" class="@if(isset($user)) active @endif">Other Names</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col m6 s12">
            <input  id="department" name="department" type="text" class="" readonly value="@if(isset($user)){{$user->departmentName}}@endif">
            <label for="department" class="@if(isset($user)) active @endif">Department</label>
        </div>

        <div class="input-field col m6 s12">
            <input  id="designation" name="designation" type="text" class="" readonly value="@if(isset($user)){{$user->designation}}@endif">
            <label for="designation" class="@if(isset($appraisal)) active @endif">Designation</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col m6 s12">
            <input  id="dob" name="dob" type="text" class="" value="{{$user->dateOfBirth}}" readonly required>
            <label for="dob" class="active">Date of birth</label>
        </div>
        {{-- Staff Person File number --}}
        <div class="input-field col m6 s12">
            <input id="staff_file_number" name="staff_file_number" type="text" value="{{$user->staffNumber}}" readonly required class="">
            <label for="staff_file_number" class="active">Staff Personal File Number</label>
        </div>
    </div>


    {{-- Contract Expiry Fields --}}
    <div class="row">
        {{-- Contract Start Date --}}
        <div class="input-field col m6 s12">
            <input  id="contract_start_date" name="contract_start_date" type="text" class="" value="{{$user->contractStartDate}}" readonly required>
            <label for="contract_start_date" class="active">Contract Start Date</label>
        </div>
        {{-- Contract End Date --}}
        <div class="input-field col m6 s12">
            <input  id="contract_expiry_date" name="contract_expiry_date" type="text" class="" value="{{$user->contractExpiryDate}}" readonly required>
            <label for="contract_expiry_date" class="active">Contract Expiry Date</label>
        </div>
    </div>

    {{-- Employee Category Fields --}}
    <div class="row">
        {{-- Contract Start Date --}}
        <div class="input-field col m6 s12">
            <input  id="employee_category" name="employee_category" type="text" class="" value="{{$user->category}}" readonly required>
            <label for="employee_category" class="active">Staff Category</label>
        </div>
        <div class=" col m6 s12"></div>
    </div>

    <div class="row " style="padding: 10px">
        <div style="font-size: 0.8rem" class="col s12 center blue-text text-darken-2 font-weight-200">PLEASE VISIT THE PROFILE SECTION TO UPDATE THE BIO-DATA DETAILS ABOVE.</div>
    </div>


    <div class="row">
        <div class="input-field col s12">

            @if(!isset($appraisal))
            <button type="submit" name="action"  class="btn btn-save camel-case blue-stepper">Save Section A</button>
                <input type="hidden" name="save">
            @else
            <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Update Section A</button>
                <input type="hidden" name="update">
                <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">
            @endif

        </div>
    </div>

    {{csrf_field()}}

</form>