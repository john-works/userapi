
<form id="section-f-form" class="col s12 table-format" method="post" action="{{route('save_section_f')}}">

    <div class="row spacer-top ">
        <div class="col s12 bold-text">Performance Gaps</div>
    </div>

    <div class="row spacer-top">
        <div class="col s12">
            <div class="col m1 s12"><span class="timo-appraisal-th">No.</span></div>
            <div class="col m3 s12"><span class="timo-appraisal-th">Performance Gaps</span></div>
            <div class="col m3 s12"><span class="timo-appraisal-th">Causes</span></div>
            <div class="col m3 s12"><span class="timo-appraisal-th">Recommendation</span></div>
            <div class="col m2 s12"><span class="timo-appraisal-th">When</span></div>
        </div>
    </div>

    {{-- begin of a section to hold rows --}}
    <span id="parent_dynamic_performance_gaps">
    @for($i = 1; $i <= 3 ; $i++)
            <div >

            <div class="col s12">

                <div class="col s1 ">
                    {{$i}}
                </div>
                <div class="col s3 ">
                    <textarea id="gap_{{$i}}" name="gap_{{$i}}" type="text" class="validate">{{old('gap_'.$i)}}</textarea>
                </div>
                <div class="col s3 ">
                    <textarea id="cause_{{$i}}" name="cause_{{$i}}" type="text" class="validate">{{old('cause_'.$i)}}</textarea>
                </div>
                <div class="col s3 ">
                    <textarea id="recommendation_{{$i}}" name="recommendation_{{$i}}" type="text" class="validate">{{old('recommendation_'.$i)}}</textarea>
                </div>
                <div class="col s2 ">
                    <input value="{{old('when_'.$i)}}" id="when_{{$i}}" name="when_{{$i}}" type="text" class="validate  browser-default tab-input">
                </div>
            </div>

        </div>
        @endfor
     </span>
    {{-- end of section to hold rows --}}

    {{-- Keeps track of how rows we have in the above section by default it's 4, each time we add a row or remove a row we update this value using javascript --}}
    <input type="hidden" value="3" id="counter_max_rows_performance_gaps" name="counter_max_rows_performance_gaps"/>

    {{-- buttons for dynamically removing or adding rows --}}
    <div class="row">
        <div class="col s12 spacer-top">
            <div onclick="addElement('parent_dynamic_performance_gaps','div','counter_max_rows_performance_gaps');" class="btn-add-element camel-case grey darken-1">Add Row</div>
            <div onclick="deleteLastElement('parent_dynamic_performance_gaps','counter_max_rows_performance_gaps');" class="btn-add-element camel-case grey darken-1">Remove Last Row</div>
        </div>
    </div>

    <div class="row spacer-top">
        <div class="divider"></div>
    </div>

    <div class="row spacer-top ">
        <div class="col s12 bold-text">Challenges</div>
    </div>

    <div class="row spacer-top">
        <div class="col s12">
            <div class="col m1 s12"><span class="timo-appraisal-th">No.</span></div>
            <div class="col m3 s12"><span class="timo-appraisal-th">Challenges</span></div>
            <div class="col m3 s12"><span class="timo-appraisal-th">Causes</span></div>
            <div class="col m3 s12"><span class="timo-appraisal-th">Recommendation</span></div>
            <div class="col m2 s12"><span class="timo-appraisal-th">When</span></div>
        </div>
    </div>

    {{-- begin of a section to hold rows --}}
    <span id="parent_dynamic_challenges">
    @for($i = 1; $i <= 3 ; $i++)
            <div >
            <div class="col s12">

                <div class="col s1 ">
                    {{$i}}
                </div>
                <div class="col s3 ">
                    <textarea id="challenge_{{$i}}" name="challenge_{{$i}}" type="text" class="validate">{{old('challenge_'.$i)}}</textarea>
                </div>
                <div class="col s3 ">
                    <textarea id="challenge_cause_{{$i}}" name="challenge_cause_{{$i}}" type="text" class="validate">{{old('challenge_cause_'.$i)}}</textarea>
                </div>
                <div class="col s3 ">
                    <textarea id="challenge_recommendation_{{$i}}" name="challenge_recommendation_{{$i}}" type="text" class="validate">{{old('challenge_recommendation_'.$i)}}</textarea>
                </div>
                <div class="col s2 ">
                    <input value="{{old('challenge_when_'.$i)}}" id="challenge_when_{{$i}}" name="challenge_when_{{$i}}" type="text" class="validate browser-default tab-input">
                </div>
            </div>
        </div>
        @endfor
    </span>
    {{-- end of section to hold rows --}}

    {{-- Keeps track of how rows we have in the above section by default it's 4, each time we add a row or remove a row we update this value using javascript --}}
    <input type="hidden" value="3" id="counter_max_rows_challenges" name="counter_max_rows_challenges"/>

    {{-- buttons for dynamically removing or adding rows --}}
    <div class="row">
        <div class="col s12 spacer-top">
            <div onclick="addElement('parent_dynamic_challenges','div','counter_max_rows_challenges');" class="btn-add-element camel-case grey darken-1">Add Row</div>
            <div onclick="deleteLastElement('parent_dynamic_challenges','counter_max_rows_challenges');" class="btn-add-element camel-case grey darken-1">Remove Last Row</div>
        </div>
    </div>

    <div class="row spacer-top">
        <div class="col s12 bold-text">Appraiser’s comments on training</div>
        <div class="row">
            <div class="col s12 valign-wrapper">
                <textarea name="appraiser_comment" >{{old('appraiser_comment')}}</textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">

            <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Save Section F</button>
            <input type="hidden" name="save">
            <input type="hidden" name="appraisal" value="@if(isset($appraisal)){{$appraisal->appraisalRef}}@endif">

            {{csrf_field()}}

        </div>
    </div>


</form>