
<form id="section-b-form" method="post" action="{{route('save_section_b')}}" class="col s12 table-format">

    <div class="row">
        <div class="col m1 s12"><span class="timo-appraisal-th">No.</span></div>
        <div class="col m4 s12"><span class="timo-appraisal-th">School</span></div>
        <div class="col m2 s12"><span class="timo-appraisal-th">Year of Study</span></div>
        <div class="col m5 s12"><span class="timo-appraisal-th">Award / Qualification</span></div>
    </div>


    {{-- begin of a section to hold rows --}}
    <span id="parent_dynamic_education_bg">
        @if(isset($institutions) && count($institutions) > 0)
            @foreach($institutions as $institution)
            <div class="row valign-wrapper">
                <div class="col m1 s12 ">
                    {{$loop->iteration}}
                </div>
                <div class="col m4 s12 ">
                    <input readonly id="school_{{$loop->iteration}}" name="school_{{$loop->iteration}}" type="text" value="{{$institution->institution}}" >
                </div>
                <div class="col m2 s12 ">
                    <input readonly id="year_of_study_{{$loop->iteration}}" name="year_of_study_{{$loop->iteration}}" type="text" value="{{$institution->yearOfStudy}}" >
                </div>
                <div class="col m5 s12 ">
                    <input readonly id="award_{{$loop->iteration}}" name="award_{{$loop->iteration}}" type="text" value="{{$institution->award}}">
                </div>
            </div>
            @endforeach
            <div class="row " style="padding: 10px">
                <div style="font-size: 0.8rem" class="col s12 center blue-text text-darken-2 font-weight-200">PLEASE VISIT THE PROFILE SECTION TO UPDATE THE ACADEMIC BACKGROUND DETAILS ABOVE.</div>
            </div>

            {{-- Keeps track of how rows we have in the above section by default it's 4, each time we add a row or remove a row we update this value using javascript --}}
            <input type="hidden" value="{{count($institutions)}}" id="counter_max_rows" name="counter_max_rows"/>

        @else
            <div class="col s12 center"><h5 class="red-text text-lighten-2">No Academic Background Info Found, Please visit your Profile and update your Academic Background</h5></div>
        @endif

    </span>
    {{-- end of section to hold rows --}}


    {{-- buttons for dynamically removing or adding rows --}}
    <div class="row hidden">
        <div class="col s12 spacer-top">
            <div onclick="addElement('parent_dynamic_education_bg','div','counter_max_rows');" class="btn-add-element camel-case grey darken-1">Add Row</div>
            <div onclick="deleteLastElement('parent_dynamic_education_bg','counter_max_rows');" class="btn-add-element camel-case grey darken-1">Remove Last Row</div>
        </div>
    </div>



    <div class="row">
        <div class="input-field col s12">

            <button @if(!isset($appraisal)) disabled @endif type="submit" name="action" class="btn btn-save camel-case blue-stepper">Save Section B</button>
            <input type="hidden" name="save">
            <input type="hidden" name="appraisal" value="@if(isset($appraisal)){{$appraisal->appraisalRef}}@endif">

            {{csrf_field()}}

        </div>
    </div>

</form>