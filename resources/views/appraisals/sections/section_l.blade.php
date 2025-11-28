
<form id="section-l-form" method="post" action="{{route('save_section_l')}}" class="col s12 table-format">

    <div class="row">
        <div class="col m1 s12"><span class="timo-appraisal-th">No.</span></div>
        <div class="col m4 s12"><span class="timo-appraisal-th">Job Assignment</span></div>
        <div class="col m4 s12"><span class="timo-appraisal-th">Expected Output</span></div>
        <div class="col m1 s12 center"><span class="timo-appraisal-th center-align">Maximum Rating</span></div>
        <div class="col m2 s12 center"><span class="timo-appraisal-th center-align">Time Frame (Months)</span></div>
    </div>

    {{-- begin of a section to hold rows --}}
    <span id="parent_dynamic_workplan">
    @for($i = 1; $i < 7 ; $i++)

            <div>
            <div class="row ">
                <div class="col m1 s12 ">
                    {{$i}}
                </div>
                <div class="col m4 s12 ">
                    <textarea required id="assignment_{{$i}}" name="assignment_{{$i}}" type="text" class="validate" >{{old(''.$i)}}</textarea>
                </div>
                <div class="col m4 s12 ">
                    <textarea id="expected_output_{{$i}}" name="expected_output_{{$i}}" type="text" class="validate">{{old(''.$i)}}</textarea>
                </div>
                <div class="col m1 s12 ">
                    <input value="{{old('max_rating'.$i)}}" id="max_rating{{$i}}" name="max_rating{{$i}}" type="number" class="validate browser-default tab-input">
                </div>
                <div class="col m2 s12 ">
                    <input value="{{old('time_frame_'.$i)}}" id="time_frame_{{$i}}" name="time_frame_{{$i}}" type="text" class="validate browser-default tab-input">
                </div>
                <input type="hidden" name="record_id_count" value="{{$i}}">
            </div>
        </div>

        @endfor
    </span>
    {{-- end of section to hold rows --}}


    {{-- Keeps track of how rows we have in the above section by default it's 4, each time we add a row or remove a row we update this value using javascript --}}
    <input type="hidden" value="6" id="counter_max_rows_workplan" name="counter_max_rows_workplan"/>

    {{-- buttons for dynamically removing or adding rows --}}
    <div class="row">
        <div class="col s12 spacer-top">
            <div onclick="addElement('parent_dynamic_workplan','div','counter_max_rows_workplan');" class="btn-add-element camel-case grey darken-1">Add Row</div>
            <div onclick="deleteLastElement('parent_dynamic_workplan','counter_max_rows_workplan');" class="btn-add-element camel-case grey darken-1">Remove Last Row</div>
        </div>
    </div>


    <div class="row">
        <div class="input-field col s12">

            <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Save Section L</button>
            <input type="hidden" name="save">
            <input type="hidden" name="appraisal" value="@if(isset($appraisal)){{$appraisal->appraisalRef}}@endif">
            {{csrf_field()}}

        </div>
    </div>

</form>