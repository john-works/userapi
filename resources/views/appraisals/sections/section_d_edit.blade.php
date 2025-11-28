
<form id="section-d-form" class="col s12 table-format" action="{{route('save_section_d')}}" method="post">

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

    @if(isset($appraisal) && count($appraisal->assignments) > 0)

        {{-- begin of a section to hold rows --}}
        <span id="parent_dynamic_assignments">
        @foreach($appraisal->assignments as $assignment)

           <div>

                <input name="record_id_{{$loop->iteration}}" value="{{$assignment->id}}"  type="hidden"/>

                <div class="row">
                    <div class="col m1 s12 ">
                        {{$loop->iteration}}
                    </div>
                    <div class="col m11 s12" style="padding-left: 1.5%">
                        <select name="objective_{{$loop->iteration}}" required class="browser-default validate s12" style="width: 100%">
                            <option value="" disabled selected>Select related strategic objective</option>
                            @if(isset($strategicObjectives) && count($strategicObjectives) > 0)
                                @foreach($strategicObjectives as $objective)
                                    <option value="{{$objective->id}}"
                                            @if($assignment->objectiveId == $objective->id) selected @endif
                                    >{{$objective->objective}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="row">
                <div class="col s7">

                    <div class="col s2 ">
                    </div>
                    <div class="col s5 ">
                        <textarea id="expected_output_sec_d_{{$loop->iteration}}" name="expected_output_sec_d_{{$loop->iteration}}" type="text" class="validate">{{$assignment->expectedOutput}}</textarea>
                    </div>
                    <div class="col s5 ">
                        <textarea id="actual_performance_{{$loop->iteration}}" name="actual_performance_{{$loop->iteration}}" type="text" class="validate">{{$assignment->actualPerformance}}</textarea>
                    </div>
                </div>

                <div class="col s5">
                    <div class="col s3 ">
                        <input value="{{$assignment->maximumRating}}" id="max_rating_sec_d{{$loop->iteration}}" min="0" name="max_rating_sec_d{{$loop->iteration}}" type="number" onblur="sumRow('max_rating_sec_d',14,'sec_d_total_max_rating',100)" class="validate browser-default tab-input">
                    </div>
                    <div class="col s3 ">
                        <input  value="{{$assignment->appraiseeRating}}" id="appraisee_rating_sec_d{{$loop->iteration}}" min="0" name="appraisee_rating_sec_d{{$loop->iteration}}" onblur="sumRow('appraisee_rating_sec_d',14,'sec_d_total_appraisee_rating',100)" type="number" class="validate browser-default tab-input">
                    </div>
                    <div class="col s3 ">
                        <input  value="{{$assignment->appraiserRating}}" id="appraiser_rating_sec_d{{$loop->iteration}}" min="0" name="appraiser_rating_sec_d{{$loop->iteration}}" onblur="sumRow('appraiser_rating_sec_d',14,'sec_d_total_appraiser_rating',100)" type="number" class="validate browser-default tab-input">
                    </div>
                    <div class="col s3 ">
                        <input value="{{$assignment->agreedRating}}" id="agreed_rating_sec_d{{$loop->iteration}}" min="0" name="agreed_rating_sec_d{{$loop->iteration}}" onblur="sumRow('agreed_rating_sec_d',14,'sec_d_total_agreed_rating',100)" type="number" class="validate browser-default tab-input">
                    </div>
                </div>
            </div>

               {{-- Used to match the fields when generating then for update --}}
               <input type="hidden" name="form_field_count{{$loop->iteration}}" value="{{$loop->iteration}}"/>

           </div>

        @endforeach
        </span>
        {{-- end of section to hold rows --}}

    @endif

    <div class="row valign-wrapper">
        <div class="col s7">
            <span class="bold-text right">TOTAL SCORE</span>
        </div>

        <div class="col s5">
            <div class="col s3 ">
                <input @if(isset($appraisal) && isset($appraisal->assignmentsScores) ) value="{{$appraisal->assignmentsScores->totalMaximumRating}}" @endif
                        id="sec_d_total_max_rating" min="0" name="sec_d_total_max_rating" type="number" class="validate browser-default tab-input">
            </div>
            <div class="col s3 ">
                <input @if(isset($appraisal) && isset($appraisal->assignmentsScores) ) value="{{$appraisal->assignmentsScores->totalAppraiseeRating}}" @endif
                        id="sec_d_total_appraisee_rating"  min="0" name="sec_d_total_appraisee_rating" type="number" class="validate browser-default tab-input">
            </div>
            <div class="col s3 ">
                <input @if(isset($appraisal) && isset($appraisal->assignmentsScores) ) value="{{$appraisal->assignmentsScores->totalAppraiserRating}}" @endif
                        id="sec_d_total_appraiser_rating"  min="0" name="sec_d_total_appraiser_rating" type="number" class="validate browser-default tab-input">
            </div>
            <div class="col s3 ">
                <input @if(isset($appraisal) && isset($appraisal->assignmentsScores) ) value="{{$appraisal->assignmentsScores->totalAgreedRating}}" @endif
                        id="sec_d_total_agreed_rating"  min="0" name="sec_d_total_agreed_rating" type="number" class="validate browser-default tab-input">
            </div>
            @if(isset($appraisal) && isset($appraisal->assignmentsScores))
                <input type="hidden" name="scores_sec_d_record_id" value="{{$appraisal->assignmentsScores->id}}"/>
            @endif
        </div>
    </div>


    {{-- Keeps track of how rows we have in the above section by default it's 4, each time we add a row or remove
      a row we update this value using javascript --}}
    <input type="hidden" value="{{count($appraisal->assignments)}}" id="counter_max_rows_assignments" name="counter_max_rows_assignments"/>


    {{-- buttons for dynamically removing or adding rows --}}
    <div class="row">
        <div class="col s12 spacer-top">
            <div onclick="addElement('parent_dynamic_assignments','div','counter_max_rows_assignments');" class="btn-add-element camel-case grey darken-1">Add Row</div>
            <div onclick="deleteLastElement('parent_dynamic_assignments','counter_max_rows_assignments');" class="btn-add-element camel-case grey darken-1">Remove Last Row</div>
        </div>
    </div>

    <br>


    <div class="row">
        <div class="input-field col s12">

            <button id="btnSubmitSectionD" type="submit" name="action" class="btn btn-save camel-case blue-stepper">Update Section D</button>
            <input type="hidden" name="update">
            <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">
            {{csrf_field()}}

        </div>
        </div>


</form>