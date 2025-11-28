
<form id="section-c-form" method="post" action="{{route('save_section_c')}}" class="col s12 table-format">

    <div class="row spacer-bottom">
        <div class="col m1 s12"><span class="timo-appraisal-th">No.</span></div>
        <div class="col m4 s12"><span class="timo-appraisal-th">Job Assignment</span></div>
        <div class="col m4 s12"><span class="timo-appraisal-th">Expected Output</span></div>
        <div class="col m1 s12 center"><span class="timo-appraisal-th center-align">Maximum Rating</span></div>
        <div class="col m2 s12 center"><span class="timo-appraisal-th center-align">Time Frame (Months)</span></div>
    </div>


    {{-- begin of a section to hold rows --}}
    <span id="parent_dynamic_key_duties">

        @for($i = 1; $i <= 4 ; $i++)
        <div>

            <div class="row">
                <div class="col m1 s12 ">
                    {{$i}}
                </div>
                <div class="col m11 s12">
                    <select name="objective_{{$i}}" required class="browser-default validate s12" style="width: 100%">
                        <option value="" disabled selected>Select related strategic objective</option>
                        @if(isset($strategicObjectives) && count($strategicObjectives) > 0)
                            @foreach($strategicObjectives as $objective)
                                <option @if(old('objective_'.$i) == $objective->id ) selected @endif value="{{$objective->id}}">{{$objective->objective}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="row ">

                    <div class="col m1 s12 ">
                        {{--{{$i}}--}}
                    </div>
                    <div class="col m4 s12 ">
                        <textarea  id="assignment_{{$i}}" onchange="copyBetweenTextField('assignment_{{$i}}', 'expected_output_sec_d_{{$i}}')"
                                   name="assignment_{{$i}}" type="text" class="validate">{{old('assignment_'.$i)}}</textarea>
                    </div>
                    <div class="col m4 s12 ">
                        <textarea id="expected_output_{{$i}}" name="expected_output_{{$i}}" type="text" class="validate">{{old('expected_output_'.$i)}}</textarea>
                    </div>
                    <div class="col m1 s12 ">
                        <input  id="max_rating_{{$i}}" name="max_rating_{{$i}}" type="number" value="{{old('max_rating_'.$i)}}"  class="validate browser-default tab-input ">
                    </div>
                    <div class="col m2 s12 ">
                        <input  id="time_frame_{{$i}}" name="time_frame_{{$i}}" type="text" value="{{old('time_frame_'.$i)}}" class="validate  browser-default tab-input">
                    </div>
                    {{-- Used to match the fields when generating then for update --}}
                    <input type="hidden" name="form_field_count{{$i}}" value="{{$i}}"/>

                </div>

        </div>

        @endfor
    </span>
    {{-- end of section to hold rows --}}

    {{-- Keeps track of how rows we have in the above section by default it's 4, each time we add a row or remove
      a row we update this value using javascript --}}
    <input type="hidden" value="4" id="counter_max_rows_key_duty" name="counter_max_rows_key_duty"/>


    {{-- buttons for dynamically removing or adding rows --}}
    <div class="row">
        <div class="col s12 spacer-top">
            <div onclick="addElement('parent_dynamic_key_duties','div','counter_max_rows_key_duty');" class="btn-add-element camel-case grey darken-1">Add Row</div>
            <div onclick="deleteLastElement('parent_dynamic_key_duties','counter_max_rows_key_duty');" class="btn-add-element camel-case grey darken-1">Remove Last Row</div>
        </div>
    </div>

    <br>

    {{-- Button for saving the form data --}}
    <div class="row">
        <div class="input-field col s12">

            <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Save Section C</button>
            <input type="hidden" name="save">
            <input type="hidden" name="appraisal" value="@if(isset($appraisal)){{$appraisal->appraisalRef}}@endif">
            {{csrf_field()}}

        </div>
    </div>

</form>