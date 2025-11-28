

{{-- Form is used for edititng section a details --}}

<form class="col s12" id="section-a-form" action="{{route('save_section_a')}}" method="post">
    {{-- The record ID we are going to be updating --}}
    <input name="code" type="hidden" value="{{$appraisal->personalInfo->id}}"/>

    <div class="row">

        <div class="col s12  spacer"></div>

        <div class="col m4 s12 ">
            <label style="display: block">Appraisal Type</label>
            <select id="appraisal_type" name="appraisal_type" required class="browser-default">
                <option value="0" disabled>Choose Appraisal Type</option>
                <option value="ANNUAL" @if($appraisal->appraisalType == 'ANNUAL') selected @endif>Annual Appraisal</option>
                <option value="PROBATION" @if($appraisal->appraisalType == 'PROBATION') selected @endif>End of Probation</option>
                <option value="RENEWAL" @if($appraisal->appraisalType == 'RENEWAL') selected @endif>Contract Renewal</option>
            </select>
        </div>
        <div class="col m8 s12"> </div>
    </div>

    <div class="row spacer-top">
        <div class="col s4">
            <label class="display-block">Supervisor</label>
            <select name="supervisor" required class="browser-default" readonly>
                <option value="" disabled selected>Choose Supervisor</option>
                @if(isset($users) && count($users) > 0)
                    @foreach($users as $usr)
                        <option @if($appraisal->supervisorUsername == $usr->username)selected @endif  value="{{$usr->username}}">{{$usr->fullName}}</option>
                    @endforeach
                @endif
            </select>

        </div>
        <div class="col s4">
            <label class="display-block">Head of Department</label>
            <select name="hod" required class=" browser-default" readonly>
                <option value="" disabled>Choose Head of Department</option>
                @if(isset($users) && count($users) > 0)
                    @foreach($users as $usr)
                        <option @if($appraisal->deptHeadUsername == $usr->username)selected @endif value="{{$usr->username}}">{{$usr->fullName}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col s4">
            <label class="display-block">Executive Director</label>
            <select name="ed" required class=" browser-default" readonly>
                <option value="" disabled >Choose Executive Director</option>
                @if(isset($users) && count($users) > 0)
                    @foreach($users as $usr)
                        <option @if($appraisal->executiveDirectorUsername == $usr->username)selected @endif  value="{{$usr->username}}">{{$usr->fullName}}</option>
                    @endforeach
                @endif
            </select>

        </div>
    </div>


    {{-- Appraisal Evalualtion Period Dates --}}
    <div class="row">

        {{-- Appraisal Start Date --}}
        <div class="col m6 s12">
            <label for="appraisal_start_date" class="display-block active">
                Appraisal Period Start Date
            </label>
            <input style="width: 98%"  id="appraisal_start_date" name="appraisal_start_date" type="date" class="timo-date-picker browser-default"
                    value="{{$appraisal->personalInfo->appraisalPeriodStartDate}}" required>

        </div>
        {{-- Appraisal End Date --}}
        <div class="col m6 s12">
            <label for="appraisal_end_date" class="display-block active">
                Appraisal Period End Date
            </label>
            <input style="width: 98%"  id="appraisal_end_date" name="appraisal_end_date" type="date" class="timo-date-picker browser-default"
                    value="{{$appraisal->personalInfo->appraisalPeriodEndDate}}" required>

        </div>

    </div>

    <div class="row">
        <div class="col s12 divider-primary" style="margin-top: 20px;margin-bottom: 20px"> </div>
    </div>

    <div class="row">
        <div class="input-field col m6 s12">
            <input id="surname" name="surname" type="text" class="" readonly
                   value="{{$appraisal->personalInfo->firstName}}">
            <label for="surname" class="active">
                Surname Name
            </label>
        </div>
        <div class="input-field col m6 s12">
            <input id="other_name" name="other_name" type="text" class="" readonly
                   value="{{$appraisal->personalInfo->lastName}}">
            <label for="other_name" class="active">
                Other Names
            </label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col m6 s12">
            <input  id="department" name="department" type="text" class="" readonly
                    value="{{$appraisal->personalInfo->department}}">
            <label for="department" class="active">
                Department
            </label>
        </div>

        <div class="input-field col m6 s12">
            <input  id="designation" name="designation" type="text" class="" readonly
                    value="{{$appraisal->personalInfo->designation}}">
            <label for="designation" class="@if(isset($appraisal)) active @endif">
                Designation
            </label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col m6 s12">
            <input  id="dob" name="dob" type="text" value="{{$appraisal->personalInfo->dateOfBirth}}" readonly required>
            <label for="dob" class="active">Date of birth</label>
        </div>
        {{-- Staff Person File number --}}
        <div class="input-field col m6 s12">
            <input id="staff_file_number" name="staff_file_number" readonly type="text"
                   value="{{$appraisal->personalInfo->staffNumber}}"  class="validate">
            <label for="staff_file_number" class="active">
                Staff Personal File Number
            </label>
        </div>
    </div>

    {{-- Contract Expiry Fields --}}
    <div class="row">
        {{-- Contract Start Date --}}
        <div class="input-field col m6 s12">
            <input  id="contract_start_date" name="contract_start_date" type="date" readonly class="text"
                    value="{{$appraisal->personalInfo->contractStartDate}}" required>
            <label for="contract_start_date" class="active">
                Contract Start Date
            </label>
        </div>
        {{-- Contract End Date --}}
        <div class="input-field col m6 s12">
            <input  id="contract_expiry_date" name="contract_expiry_date" type="date" readonly class="text"
                    value="{{$appraisal->personalInfo->contractExpiryDate}}" required>
            <label for="contract_expiry_date" class="active">
                Contract Expiry Date
            </label>
        </div>
    </div>

    {{-- Employee Category Fields --}}
    <div class="row">
        <div class="col s12 spacer"></div>
        {{-- Contract Start Date --}}
        <div class="input-field col m6 s12">
            <input  id="employee_category" name="employee_category" type="text" class="" value="{{isset($appraisal->personalInfo->employeeCategory)?$appraisal->personalInfo->employeeCategory : '  '}}" readonly required >
            <label for="employee_category" class="active">Staff Category</label>
        </div>
        <div class=" col m6 s12"></div>
    </div>

    <div class="row">
        <div class="input-field col s12">

            <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Update Section A</button>
            <input type="hidden" name="update">
            <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">

        </div>
    </div>

    {{csrf_field()}}

</form>