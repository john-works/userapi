
<form id="section-l-form" method="post" action="{{route('save_section_l')}}" class="col s12 table-format">

    <div class="row">
        <div class="col m1 s12"><span class="timo-appraisal-th">No.</span></div>
        <div class="col m4 s12"><span class="timo-appraisal-th">Job Assignment</span></div>
        <div class="col m4 s12"><span class="timo-appraisal-th">Expected Output</span></div>
        <div class="col m1 s12 center"><span class="timo-appraisal-th center-align">Maximum Rating</span></div>
        <div class="col m2 s12 center"><span class="timo-appraisal-th center-align">Time Frame (Months)</span></div>
    </div>

    @if(isset($appraisal) && count($appraisal->workPlans) > 0)

        {{-- begin of a section to hold rows --}}
        <span id="parent_dynamic_workplan">
        @foreach($appraisal->workPlans as $plan)

            <div>
                <div class="row">

                <div class="col m1 s12 ">
                    {{$loop->iteration}}
                </div>
                <div class="col m4 s12 ">
                    <textarea id="assignment_{{$loop->iteration}}" name="assignment_{{$loop->iteration}}" type="text" class="validate">{{$plan->jobAssignment}}</textarea>
                </div>
                <div class="col m4 s12 ">
                    <textarea id="expected_output_{{$loop->iteration}}" name="expected_output_{{$loop->iteration}}" type="text" class="validate">{{$plan->expectedOutput}}</textarea>
                </div>
                <div class="col m1 s12 ">
                    <input value="{{$plan->maximumRating}}" id="max_rating{{$loop->iteration}}" name="max_rating{{$loop->iteration}}" type="number" class="validate browser-default tab-input">
                </div>
                <div class="col m2 s12 ">
                    <input value="{{$plan->timeFrame}}" id="time_frame_{{$loop->iteration}}" name="time_frame_{{$loop->iteration}}" type="text" class="validate browser-default tab-input">
                </div>
                <input type="hidden" name="record_id_{{$loop->iteration}}" value="{{$plan->id}}">

            </div>
            </div>

        @endforeach
         </span>
        {{-- end of section to hold rows --}}

        {{-- Keeps track of how rows we have in the above section by default it's 4, each time we add a row or remove a row we update this value using javascript --}}
        <input type="hidden" value="{{count($appraisal->workPlans)}}" id="counter_max_rows_workplan" name="counter_max_rows_workplan"/>

        {{-- buttons for dynamically removing or adding rows --}}
        <div class="row">
            <div class="col s12 spacer-top">
                <div onclick="addElement('parent_dynamic_workplan','div','counter_max_rows_workplan');" class="btn-add-element camel-case grey darken-1">Add Row</div>
                <div onclick="deleteLastElement('parent_dynamic_workplan','counter_max_rows_workplan');" class="btn-add-element camel-case grey darken-1">Remove Last Row</div>
            </div>
        </div>

    @endif

    <div class="row">
        <div class="input-field col s12">

            <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Update Section L</button>
            <input type="hidden" name="update">
            <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">
            {{csrf_field()}}


        </div>
    </div>

</form>