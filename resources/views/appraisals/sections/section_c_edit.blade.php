
<form id="section-c-form" method="post" action="{{route('save_section_c')}}" class="col s12 table-format">

        <div class="row spacer-bottom">
            <div class="col m1 s12"><span class="timo-appraisal-th">No.</span></div>
            <div class="col m4 s12"><span class="timo-appraisal-th">Job Assignment</span></div>
            <div class="col m4 s12"><span class="timo-appraisal-th">Expected Output</span></div>
            <div class="col m1 s12 center"><span class="timo-appraisal-th center-align">Maximum Rating</span></div>
            <div class="col m2 s12 center"><span class="timo-appraisal-th center-align">Time Frame (Months)</span></div>
        </div>

    {{-- Check if we are key duties exist --}}
        @if(isset($appraisal) && count($appraisal->keyDuties) > 0)

        {{-- begin of a section to hold rows --}}
        <span id="parent_dynamic_key_duties">



            @foreach($appraisal->keyDuties as $duty)
            <div>
                <input name="record_id_{{$loop->iteration}}" value="{{$duty->id}}"  type="hidden"/>

                <div class="row">
                    <div class="col m1 s12 ">
                        {{$loop->iteration}}
                    </div>
                    <div class="col m11 s12">
                        <select name="objective_{{$loop->iteration}}" required class="browser-default validate s12" style="width: 100%">

                            <option value="" disabled>Select related strategic objective</option>
                            @if(isset($strategicObjectives) && count($strategicObjectives) > 0)
                                @foreach($strategicObjectives as $objective)
                                    <option value="{{$objective->id}}" @if($duty->objectiveId === $objective->id) selected @endif>{{$objective->objective}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="row ">
                <div class="col m1 s12 ">
                    {{--{{$loop->iteration}}--}}
                </div>
                <div class="col m4 s12 ">
                                    <textarea  id="assignment_{{$loop->iteration}}" onchange="copyBetweenTextField('assignment_{{$loop->iteration}}', 'expected_output_sec_d_{{$loop->iteration}}')"
                                               name="assignment_{{$loop->iteration}}" type="text" class="validate">{{$duty->jobAssignment}}</textarea>
                </div>
                <div class="col m4 s12 ">
                    <textarea id="expected_output_{{$loop->iteration}}" name="expected_output_{{$loop->iteration}}" type="text" class="validate">{{$duty->expectedOutput}}</textarea>
                </div>
                <div class="col m1 s12 ">
                    <input  id="max_rating_{{$loop->iteration}}" name="max_rating_{{$loop->iteration}}" type="number"  class="validate browser-default tab-input " value="{{$duty->maximumRating}}">
                </div>
                <div class="col m2 s12 ">
                    <input  id="time_frame_{{$loop->iteration}}" name="time_frame_{{$loop->iteration}}" type="text" class="validate  browser-default tab-input" value="{{$duty->timeFrame}}">
                </div>
                {{-- Used to match the fields when generating then for update --}}
                <input type="hidden" name="form_field_count{{$loop->iteration}}" value="{{$loop->iteration}}"/>

            </div>
            </div>
            @endforeach
        </span>
        {{-- end of section to hold rows --}}

        {{-- Keeps track of how rows we have in the above section by default it's 4, each time we add a row or remove a row we update this value using javascript --}}
        <input type="hidden" value="{{count($appraisal->keyDuties)}}" id="counter_max_rows_key_duty" name="counter_max_rows_key_duty"/>

        {{-- buttons for dynamically removing or adding rows --}}
        <div class="row">
            <div class="col s12 spacer-top">
                <div onclick="addElement('parent_dynamic_key_duties','div','counter_max_rows_key_duty');" class="btn-add-element camel-case grey darken-1">Add Row</div>
                <div onclick="deleteLastElement('parent_dynamic_key_duties','counter_max_rows_key_duty');" class="btn-add-element camel-case grey darken-1">Remove Last Row</div>
            </div>
        </div>

        @endif

    <br>

    <div class="row">
        <div class="input-field col s12">

            <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Update Section C</button>
            <input type="hidden" name="update">
            <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">
            {{csrf_field()}}

        </div>
    </div>

</form>