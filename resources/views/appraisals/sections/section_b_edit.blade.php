
<form id="section-b-form" method="post" action="{{route('save_section_b')}}" class="col s12 table-format">

    <div class="row">
        <div class="col m1 s12"><span class="timo-appraisal-th">No.</span></div>
        <div class="col m4 s12"><span class="timo-appraisal-th">School</span></div>
        <div class="col m2 s12"><span class="timo-appraisal-th">Year of Study</span></div>
        <div class="col m5 s12"><span class="timo-appraisal-th">Award / Qualification</span></div>
    </div>

    {{-- Check if academic background has data --}}

    @if(isset($appraisal) && isset($appraisal->academicBackgrounds))

        {{-- begin of a section to hold rows --}}
        <span id="parent_dynamic_education_bg">
        @foreach($appraisal->academicBackgrounds as $background)

            <div class="row valign-wrapper">
                <div class="col m1 s12 ">
                    {{$loop->iteration}}
                </div>
                <div class="col m4 s12 ">
                    <input readonly id="school_{{$loop->iteration}}" value="{{$background->school}}" name="school_{{$loop->iteration}}" type="text" >
                </div>
                <div class="col m2 s12 ">
                    <input readonly id="year_of_study_{{$loop->iteration}}" value="{{$background->year}}" name="year_of_study_{{$loop->iteration}}" type="text" >
                </div>
                <div class="col m5 s12 ">
                    <input readonly id="award_{{$loop->iteration}}" name="award_{{$loop->iteration}}" value="{{$background->award}}" type="text" >
                </div>
                <input type="hidden" name="record_id_{{$loop->iteration}}" value="{{$background->id}}">
            </div>

        @endforeach
         </span>
        {{-- end of section to hold rows --}}

            {{-- Keeps track of how rows we have in the section above  --}}
            <input type="hidden" value="{{count($appraisal->academicBackgrounds)}}" id="counter_max_rows_update" name="counter_max_rows_update"/>

            {{-- buttons for dynamically removing or adding rows --}}
            <div class="row hidden">
                <div class="col s12 spacer-top">
                    <div onclick="addElement('parent_dynamic_education_bg','div','counter_max_rows_update');" class="btn-add-element camel-case grey darken-1">Add Row</div>
                    <div onclick="deleteLastElement('parent_dynamic_education_bg','counter_max_rows_update');" class="btn-add-element camel-case grey darken-1">Remove Last Row</div>
                </div>
            </div>

    @endif

    <div class="row">
        <div class="input-field col s12">

            <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Update Section B</button>
            <input type="hidden" name="update">
            <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">

            {{csrf_field()}}

        </div>
    </div>

</form>