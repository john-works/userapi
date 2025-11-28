
<form id="section-d-additional-form" method="post" action="{{route('save_section_d_additional')}}" class="col s12 table-format">

    <div class="row">
        <div class="col s7">
            <div class="col m2 s2"><span class="timo-appraisal-th">No.</span></div>
            <div class="col m5 s5"><span class="timo-appraisal-th">Expected Output</span></div>
            <div class="col m5 s5"><span class="timo-appraisal-th">Description of Actual Performance</span></div>
        </div>
        <div class="col s5">
            <div class="col s3 center"><span class="timo-appraisal-th">Maximum rating</span></div>
            <div class="col s3 center"><span class="timo-appraisal-th">Appraisee rating</span></div>
            <div class="col s3 center"><span class="timo-appraisal-th">Appraiser rating</span></div>
            <div class="col s3 center"><span class="timo-appraisal-th">Agreed rating</span></div>
        </div>
    </div>


    {{-- Span to hold the rows --}}
    <span id="parent_dynamic_additional_assignments">
        @for($i = 1; $i <= 4 ; $i++)

            <div>

                <div class="row">
                    <div class="col m1 s12 ">
                        {{$i}}
                    </div>
                    <div class="col m11 s12" style="padding-left: 1.5%">
                        <select name="objective_{{$i}}" required class="browser-default validate s12" style="width: 100%">
                            <option value="" disabled selected>Select related strategic objective</option>
                            @if(isset($strategicObjectives) && count($strategicObjectives) > 0)
                                @foreach($strategicObjectives as $objective)
                                    <option @if(old('objective_'.$i) == $objective->id) selected @endif value="{{$objective->id}}">{{$objective->objective}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="row ">

                    <div class="col s7">

                        <div class="col s2 ">
                            {{--{{$i}}--}}
                        </div>
                        <div class="col s5 ">
                            <textarea id="expected_output_sec_d_add{{$i}}" name="expected_output_sec_d_add{{$i}}" type="text" class="validate">{{old('expected_output_sec_d_add'.$i)}}</textarea>
                        </div>
                        <div class="col s5 ">
                            <textarea id="actual_performance_sec_d_add{{$i}}" name="actual_performance_sec_d_add{{$i}}" type="text" class="validate">{{old('actual_performance_sec_d_add'.$i)}}</textarea>
                        </div>
                    </div>

                    <div class="col s5">
                        <div class="col s3 ">
                            <input value="{{old('max_rating_sec_d_add'.$i)}}" id="max_rating_sec_d_add{{$i}}" min="0" name="max_rating_sec_d_add{{$i}}" type="number" onblur="sumRow('max_rating_sec_d_add',5,'sec_d_add_total_max_rating',20)" class="validate browser-default tab-input">
                        </div>
                        <div class="col s3 ">
                            <input value="{{old('appraisee_rating_sec_d_add'.$i)}}" id="appraisee_rating_sec_d_add{{$i}}" min="0" name="appraisee_rating_sec_d_add{{$i}}" type="number" onblur="sumRow('appraisee_rating_sec_d_add',5,'sec_d_add_total_appraisee_rating',20)" class="validate browser-default tab-input">
                        </div>
                        <div class="col s3 ">
                            <input value="{{old('appraiser_rating_sec_d_add'.$i)}}" id="appraiser_rating_sec_d_add{{$i}}" min="0" name="appraiser_rating_sec_d_add{{$i}}" type="number" onblur="sumRow('appraiser_rating_sec_d_add',5,'sec_d_add_total_appraiser_rating',20)" class="validate browser-default tab-input">
                        </div>
                        <div class="col s3 ">
                            <input value="{{old('agreed_rating_sec_d_add'.$i)}}" id="agreed_rating_sec_d_add{{$i}}" min="0" name="agreed_rating_sec_d_add{{$i}}" type="number" onblur="sumRow('agreed_rating_sec_d_add',5,'sec_d_add_total_agreed_rating',20)" class="validate browser-default tab-input">
                        </div>
                    </div>
                </div>

            </div>

        @endfor
        </span>
    {{-- End span to hold the rows --}}


    <div class="row valign-wrapper">
        <div class="col s7">
            <span class="bold-text right">TOTAL SCORE</span>
        </div>
        <div class="col s5">
            <div class="col s3 ">
                <input value="{{old('sec_d_add_total_max_rating')}}" id="sec_d_add_total_max_rating" min="0" name="sec_d_add_total_max_rating" type="number" class="validate browser-default tab-input">
            </div>
            <div class="col s3 ">
                <input  value="{{old('sec_d_add_total_appraisee_rating')}}" id="sec_d_add_total_appraisee_rating"  min="0" name="sec_d_add_total_appraisee_rating" type="number" class="validate browser-default tab-input">
            </div>
            <div class="col s3 ">
                <input value="{{old('sec_d_add_total_appraiser_rating')}}" id="sec_d_add_total_appraiser_rating"  min="0" name="sec_d_add_total_appraiser_rating" type="number" class="validate browser-default tab-input">
            </div>
            <div class="col s3 ">
                <input value="{{old('sec_d_add_total_agreed_rating')}}" id="sec_d_add_total_agreed_rating"  min="0" name="sec_d_add_total_agreed_rating" type="number" class="validate browser-default tab-input">
            </div>
        </div>
    </div>


    {{-- Keeps track of how rows we have in the above section by default it's 4, each time we add a row or remove a row we update this value using javascript --}}
    <input type="hidden" value="4" id="counter_max_rows_add_assignments" name="counter_max_rows_add_assignments"/>

    {{-- buttons for dynamically removing or adding rows --}}
    <div class="row">
        <div class="col s12 spacer-top">
            <div onclick="addElement('parent_dynamic_additional_assignments','div','counter_max_rows_add_assignments');" class="btn-add-element camel-case grey darken-1">Add Row</div>
            <div onclick="deleteLastElement('parent_dynamic_additional_assignments','counter_max_rows_add_assignments');" class="btn-add-element camel-case grey darken-1">Remove Last Row</div>
        </div>
    </div>

    <br>


    <div class="row spacer-top  grey lighten-2 " style="padding: 20px">

        <div class="col s12">

            <div class="row">
                <div class="col s12 blue-text bold-text spacer-bottom">Section D Percentage Scores</div>
                <div class="col s12 ">
                    <div class="row">
                        <div class="col s6 valign-wrapper">
                            <div class="col s8 bold-text">Final Percentage Score</div>
                            <div class="col s4"><input value="{{old('sec_d_final_percentage_score')}}" name="sec_d_final_percentage_score" id="sec_d_final_percentage_score" type="text" class="validate browser-default"></div>
                        </div>
                    </div>
                </div>
                <div class="col s12 ">
                    <div class="row">
                        <div class="col s6 valign-wrapper">
                            <div class="col s8 bold-text">Apply 80% weighting</div>
                            <div class="col s4"><input value="{{old('sec_d_weighed')}}" name="sec_d_weighed" id="sec_d_weighed" type="text" class="validate browser-default"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="row spacer-top">
        <div class="col s12 timo-appraisal-th">Appraiser's Comment</div>
        <div class="row">
            <div class="col s12 valign-wrapper">
                <textarea name="sec_d_appraiser_comment">{{old('sec_d_appraiser_comment')}}</textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">

            @if(!isset($appraisal))
                <button type="submit" name="action"  class="disabled btn btn-save camel-case blue-stepper">Save Section D</button>
                <input type="hidden" name="save">
            @elseif(isset($appraisal) && count($appraisal->additionalAssignments) < 1)
                <button type="submit" name="action"  class="btn btn-save camel-case blue-stepper">Save Section D</button>
                <input type="hidden" name="save">
                <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">
            @endif

            {{csrf_field()}}


        </div>
    </div>


</form>