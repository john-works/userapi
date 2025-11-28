
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

    @if(isset($appraisal) && count($appraisal->performanceGaps) > 0)

        {{-- begin of a section to hold rows --}}
        <span id="parent_dynamic_performance_gaps">
        @foreach($appraisal->performanceGaps as $gap)

            <div >

                <div class="row">

                <div class="col s1 ">
                    {{$loop->iteration}}
                </div>
                <div class="col s3 ">
                    <textarea id="gap_{{$loop->iteration}}" name="gap_{{$loop->iteration}}" type="text" class="validate">{{$gap->performanceGap}}</textarea>
                </div>
                <div class="col s3 ">
                    <textarea id="cause_{{$loop->iteration}}" name="cause_{{$loop->iteration}}" type="text" class="validate">{{$gap->causes}}</textarea>
                </div>
                <div class="col s3 ">
                    <textarea id="recommendation_{{$loop->iteration}}" name="recommendation_{{$loop->iteration}}" type="text" class="validate">{{$gap->recommendation}}</textarea>
                </div>
                <div class="col s2 ">
                    <input id="when_{{$loop->iteration}}" value="{{$gap->when}}" name="when_{{$loop->iteration}}" type="text" class="validate  browser-default tab-input">
                </div>
                <input type="hidden" name="record_id_gap_{{$loop->iteration}}" value="{{$gap->id}}">
            </div>

            </div>
        @endforeach
         </span>
        {{-- end of section to hold rows --}}

        {{-- Keeps track of how rows we have in the above section by default it's 4, each time we add a row or remove a row we update this value using javascript --}}
        <input type="hidden" value="{{count($appraisal->performanceGaps)}}" id="counter_max_rows_performance_gaps" name="counter_max_rows_performance_gaps"/>

        {{-- buttons for dynamically removing or adding rows --}}
        <div class="row">
            <div class="col s12 spacer-top">
                <div onclick="addElement('parent_dynamic_performance_gaps','div','counter_max_rows_performance_gaps');" class="btn-add-element camel-case grey darken-1">Add Row</div>
                <div onclick="deleteLastElement('parent_dynamic_performance_gaps','counter_max_rows_performance_gaps');" class="btn-add-element camel-case grey darken-1">Remove Last Row</div>
            </div>
        </div>

    @endif

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

    @if(isset($appraisal) && count($appraisal->performanceChallenges) > 0)

        {{-- begin of a section to hold rows --}}
        <span id="parent_dynamic_challenges">
        @foreach($appraisal->performanceChallenges as $challenge)

            <div>
                <div class="row">

                    <div class="col s1 ">
                        {{$loop->iteration}}
                    </div>
                    <div class="col s3 ">
                        <textarea id="challenge_{{$loop->iteration}}" name="challenge_{{$loop->iteration}}" type="text" class="validate">{{$challenge->challenge}}</textarea>
                    </div>
                    <div class="col s3 ">
                        <textarea id="challenge_cause_{{$loop->iteration}}" name="challenge_cause_{{$loop->iteration}}" type="text" class="validate">{{$challenge->causes}}</textarea>
                    </div>
                    <div class="col s3 ">
                        <textarea id="challenge_recommendation_{{$loop->iteration}}" name="challenge_recommendation_{{$loop->iteration}}" type="text" class="validate">{{$challenge->recommendation}}</textarea>
                    </div>
                    <div class="col s2 ">
                        <input id="challenge_when_{{$loop->iteration}}" value="{{$challenge->when}}" name="challenge_when_{{$loop->iteration}}" type="text" class="validate  browser-default tab-input">
                    </div>
                    <input type="hidden" name="record_id_challenge_{{$loop->iteration}}" value="{{$challenge->id}}">
                </div>
            </div>

        @endforeach
         </span>
        {{-- end of section to hold rows --}}

        {{-- Keeps track of how rows we have in the above section by default it's 4, each time we add a row or remove a row we update this value using javascript --}}
        <input type="hidden" value="{{count($appraisal->performanceChallenges)}}" id="counter_max_rows_challenges" name="counter_max_rows_challenges"/>

        {{-- buttons for dynamically removing or adding rows --}}
        <div class="row">
            <div class="col s12 spacer-top">
                <div onclick="addElement('parent_dynamic_challenges','div','counter_max_rows_challenges');" class="btn-add-element camel-case grey darken-1">Add Row</div>
                <div onclick="deleteLastElement('parent_dynamic_challenges','counter_max_rows_challenges');" class="btn-add-element camel-case grey darken-1">Remove Last Row</div>
            </div>
        </div>

    @endif

    <div class="row spacer-top">
        <div class="col s12 bold-text">Appraiser’s comments on training</div>
        <div class="row">
            <div class="col s12 valign-wrapper">
                <textarea
                        name="appraiser_comment" >@if(isset($appraisal) && isset($appraisal->performancesSummaries)){{$appraisal->performancesSummaries->appraiserComment}}@endif</textarea>
            </div>
        </div>
        @if(isset($appraisal) && isset($appraisal->performancesSummaries))
            <input type="hidden" name="section_f_summary_record_id" value="{{$appraisal->performancesSummaries->id}}"/>
        @endif
    </div>

    <div class="row">
        <div class="input-field col s12">

            <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Update Section F</button>
            <input type="hidden" name="update">
            <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">

            {{csrf_field()}}

        </div>
    </div>


</form>