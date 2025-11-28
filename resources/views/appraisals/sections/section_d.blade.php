
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

    {{-- begin of a section to hold rows --}}
    <span id="parent_dynamic_assignments">
        @for($i = 1; $i <= 4 ; $i++)

            <div>
                <div class="row">
                    <div class="col m1 s12 ">
                        {{$i}}
                    </div>
                    <div class="col m11 s12" style="padding-left: 1.5%">
                        <select  name="objective_{{$i}}" required class="browser-default validate s12" style="width: 100%">
                            <option value="" disabled selected>Select related strategic objective</option>
                            @if(isset($strategicObjectives) && count($strategicObjectives) > 0)
                                @foreach($strategicObjectives as $objective)
                                    <option @if(old('objective_'.$i) == $objective->id ) selected @endif value="{{$objective->id}}">{{$objective->objective}}</option>
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
                            <textarea id="expected_output_sec_d_{{$i}}" name="expected_output_sec_d_{{$i}}" type="text" class="validate">{{old('expected_output_sec_d_'.$i)}}</textarea>
                        </div>
                        <div class="col s5 ">
                            <textarea id="actual_performance_{{$i}}" name="actual_performance_{{$i}}" type="text" class="validate">{{old('actual_performance_'.$i)}}</textarea>
                        </div>
                    </div>

                    <div class="col s5">
                        <div class="col s3 ">
                            <input value="{{old('max_rating_sec_d'.$i)}}" id="max_rating_sec_d{{$i}}" min="0" name="max_rating_sec_d{{$i}}" type="number" onblur="sumRow('max_rating_sec_d',14,'sec_d_total_max_rating',100)" class="validate browser-default tab-input">
                        </div>
                        <div class="col s3 ">
                            <input value="{{old('appraisee_rating_sec_d'.$i)}}" id="appraisee_rating_sec_d{{$i}}" min="0" name="appraisee_rating_sec_d{{$i}}" onblur="sumRow('appraisee_rating_sec_d',14,'sec_d_total_appraisee_rating',100)" type="number" class="validate browser-default tab-input">
                        </div>
                        <div class="col s3 ">
                            <input value="{{old('appraiser_rating_sec_d'.$i)}}" id="appraiser_rating_sec_d{{$i}}" min="0" name="appraiser_rating_sec_d{{$i}}" onblur="sumRow('appraiser_rating_sec_d',14,'sec_d_total_appraiser_rating',100)" type="number" class="validate browser-default tab-input">
                        </div>
                        <div class="col s3 ">
                            <input value="{{old('agreed_rating_sec_d'.$i)}}" id="agreed_rating_sec_d{{$i}}" min="0" name="agreed_rating_sec_d{{$i}}" onblur="sumRow('agreed_rating_sec_d',14,'sec_d_total_agreed_rating',100)" type="number" class="validate browser-default tab-input">
                        </div>
                    </div>
                </div>

                {{-- Used to match the fields when generating then for update --}}
                <input type="hidden" name="form_field_count{{$i}}" value="{{$i}}"/>
            </div>

        @endfor
        </span>
    {{-- end of section to hold rows --}}


    <div class="row valign-wrapper">
        <div class="col s7">
            <span class="bold-text right">TOTAL SCORE</span>
        </div>

        <div class="col s5">
            <div class="col s3 ">
                <input value="{{old('sec_d_total_max_rating')}}" id="sec_d_total_max_rating" min="0" name="sec_d_total_max_rating" type="number" class="validate browser-default tab-input">
            </div>
            <div class="col s3 ">
                <input value="{{old('sec_d_total_appraisee_rating')}}" id="sec_d_total_appraisee_rating"  min="0" name="sec_d_total_appraisee_rating" type="number" class="validate browser-default tab-input">
            </div>
            <div class="col s3 ">
                <input value="{{old('sec_d_total_appraiser_rating')}}" id="sec_d_total_appraiser_rating"  min="0" name="sec_d_total_appraiser_rating" type="number" class="validate browser-default tab-input">
            </div>
            <div class="col s3 ">
                <input value="{{old('sec_d_total_agreed_rating')}}" id="sec_d_total_agreed_rating"  min="0" name="sec_d_total_agreed_rating" type="number" class="validate browser-default tab-input">
            </div>
        </div>
    </div>


    {{-- Keeps track of how rows we have in the above section by default it's 4, each time we add a row or remove
      a row we update this value using javascript --}}
    <input type="hidden" value="4" id="counter_max_rows_assignments" name="counter_max_rows_assignments"/>


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

            <button id="btnSubmitSectionD" type="submit" name="action" class="btn btn-save camel-case blue-stepper">Save Section D</button>
            <input type="hidden" name="save">
            <input type="hidden" name="appraisal" value="@if(isset($appraisal)){{$appraisal->appraisalRef}}@endif">
            {{csrf_field()}}

        </div>
    </div>

</form>