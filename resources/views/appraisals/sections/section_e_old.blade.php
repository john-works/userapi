
<form id="section-e-form" method="post" action="{{route('save_section_e')}}" class="col s12">

    <div class="row ">

        <div class="col s12">

            <table class="bordered" border="1" id="table_sec_e" style="border-collapse: collapse;margin-right: 5px">
                <thead>
                <thead>
                <tr >
                    <th colspan="2">Competence Area </th>
                    <th style="width: 65px;">Maximum rating</th>
                    <th style="width: 65px;">Appraisee&rsquo;s rating</th>
                    <th style="width: 65px;">Appraiser&rsquo;s rating</th>
                    <th style="width: 65px;">Agreed rating</th>
                </tr>
                </thead>

                <tbody>

                {{--new competence form--}}
                @if(isset($competenceCategories))

                    @foreach($competenceCategories as $category)
                    {{--each category is an an array of competence objectives--}}

                        @foreach($category as $competence)

                            {{-- Store the record ID incase of update --}}
                            @if(isset($appraisal) and $appraisal->sectione_status == 1)
                                @foreach($savedCompetences as $savedCompetence)
                                    @if($savedCompetence->competence_count == $competence['count'] and
                                    $savedCompetence->category == $competence['categoryCode'] )
                                        <input type="hidden" value="{{$savedCompetence->id}}" name="{{$competence['categoryCode']}}_record_id_{{$competence['count']}}"/>
                                    @endif
                                @endforeach
                            @endif

                            @if($loop->iteration == 1)
                                {{--category  header--}}

                            <tr>
                                <th style="width: 10px">{{$competence['count']}}</th>
                                <th >{{$competence['competence']}}</th>
                                <th style="width: 65px;">{{$competence['max_rating']}}</th>
                                <th style="width: 65px;">&nbsp;</th>
                                <th style="width: 65px;">&nbsp;</th>
                                <th style="width: 65px;">&nbsp;</th>
                            </tr>

                            @else
                                {{--competence item--}}

                                <tr>

                                    <td>{{$competence['count']}}</td>
                                    <td>{{$competence['competence']}}</td>
                                    <td style="padding-top: 5px;"><input readonly value="{{$competence['max_rating']}}" class="browser-default" tabindex="214"  type="number" size="3" style="width: 65px;" name="secEmax02"  min="0" onblur="finishTable('table_sec_e',2,'secEmaxTotal')"/></td>

                                    <td style="padding-top: 5px;"><input
                                                @if(isset($appraisal) and $appraisal->sectione_status == 1)
                                                    @foreach($savedCompetences as $savedCompetence)
                                                        @if($savedCompetence->competence_count == $competence['count'] and
                                                        $savedCompetence->category == $competence['categoryCode'] )
                                                        value="{{$savedCompetence->appraisee_rating }}"
                                                        @endif
                                                    @endforeach
                                                @endif
                                                class="browser-default" tabindex="215"  type="number" size="3" style="width: 65px;" name="{{$competence['categoryCode']}}_appraisee_rating_{{$competence['count']}}"  min="0"
                                                onblur="finishTable('table_sec_e',3,'secEappraiseeTotal')"/></td>

                                    <td style="padding-top: 5px;"><input
                                                @if(isset($appraisal) and $appraisal->sectione_status == 1)
                                                    @foreach($savedCompetences as $savedCompetence)
                                                        @if($savedCompetence->competence_count == $competence['count'] and
                                                        $savedCompetence->category == $competence['categoryCode'] )
                                                        value="{{$savedCompetence->appraiser_rating }}"
                                                        @endif
                                                    @endforeach
                                                @endif
                                                class="browser-default" tabindex="216"  type="number" size="3" style="width: 65px;" name="{{$competence['categoryCode']}}_appraiser_rating_{{$competence['count']}}"  min="0"
                                                onblur="finishTable('table_sec_e',4,'secEappraiserTotal')"/></td>

                                    <td style="padding-top: 5px;"><input
                                                @if(isset($appraisal) and $appraisal->sectione_status == 1)
                                                    @foreach($savedCompetences as $savedCompetence)
                                                        @if($savedCompetence->competence_count == $competence['count'] and
                                                        $savedCompetence->category == $competence['categoryCode'] )
                                                        value="{{$savedCompetence->agreed_rating }}"
                                                        @endif
                                                    @endforeach
                                                @endif
                                                class="browser-default" tabindex="217"  type="number" size="3" style="width: 65px;" name="{{$competence['categoryCode']}}_agreed_rating_{{$competence['count']}}"  min="0"
                                                onblur="finishTable('table_sec_e',5,'secEagreedTotal');calculateSecEpercent();"/></td>
                                </tr>

                            @endif


                        @endforeach

                    @endforeach

                @endif

                </tbody>

                <tfoot>
                <tr><td colspan="2" style="text-align: right"><strong> TOTAL SCORE</strong></td>
                    <td style="padding-top: 5px;"><input @if(isset($appraisal) && isset($appraisal->competenceSummary) ) value="{{$appraisal->competenceSummary->max_rating}}" @endif
                                tabindex="406" class="browser-default"  type="text" readonly size="3" style="width: 65px;" name="secEmaxTotal" id="secEmaxTotal" onblur="finishTable('table_sec_e',2,'secEmaxTotal')"/></td>
                    <td style="padding-top: 5px;"><input @if(isset($appraisal) && isset($appraisal->competenceSummary) ) value="{{$appraisal->competenceSummary->appraisee_rating}}" @endif
                                tabindex="407" class="browser-default"  type="text" readonly size="3" style="width: 65px;" name="secEappraiseeTotal" id="secEappraiseeTotal" onblur="finishTable('table_sec_e',3,'secEappraiseeTotal')"/></td>
                    <td style="padding-top: 5px;"><input @if(isset($appraisal) && isset($appraisal->competenceSummary) ) value="{{$appraisal->competenceSummary->appraiser_rating}}" @endif
                                tabindex="408" class="browser-default"  type="text" readonly size="3" style="width: 65px;"name="secEappraiserTotal" id="secEappraiserTotal" onblur="finishTable('table_sec_e',4,'secEappraiserTotal')"/></td>
                    <td style="padding-top: 5px;"><input @if(isset($appraisal) && isset($appraisal->competenceSummary) ) value="{{$appraisal->competenceSummary->agreed_rating}}" @endif
                                tabindex="409" class="browser-default"  type="text" readonly size="3" style="width: 65px;" name="secEagreedTotal" id="secEagreedTotal" onblur="finishTable('table_sec_e',5,'secEagreedTotal')"/></td>
                </tr>
                </tfoot>

            </table>

        </div>

    </div>


    <div class="row spacer-top grey lighten-2 valign-wrapper">

        <div class="col m6 s12  spacer-top">
            <div class="row">
                <div class="col s12 blue-text bold-text spacer-bottom">Section E Percentage Scores</div>
                <div class="row ">
                    <div class="col s12 valign-wrapper">
                        <div class="col s8 bold-text">Final Percentage Score</div>
                        <div class="col s4 right"><input @if(isset($appraisal) && isset($appraisal->competenceSummary) ) value="{{$appraisal->competenceSummary->section_e_percentage_score}}" @endif
                                    size="8" name="sec_e_final_percentage_score" id="sec_e_final_percentage_score" type="text" class="validate browser-default"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 valign-wrapper">
                        <div class="col s8 bold-text">Apply 20% weighting</div>
                        <div class="col s4 right"><input @if(isset($appraisal) && isset($appraisal->competenceSummary) ) value="{{$appraisal->competenceSummary->section_e_weighed_score}}" @endif
                                    size="8" name="sec_e_weighed" id="sec_e_weighed" type="text" class="validate browser-default"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col s12 red-text bold-text spacer-bottom">Overall Assessment</div>
                <div class="row ">
                    <div class="col s12 valign-wrapper">
                        <div class="col s8 bold-text">Section D</div>
                        <div class="col s4 right"><input @if(isset($appraisal) && isset($appraisal->competenceSummary) ) value="{{$appraisal->competenceSummary->section_d_final_score}}" @endif
                                    size="8"  name="FinalScoreSecD" id="FinalScoreSecD" type="text" class="validate browser-default"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 valign-wrapper">
                        <div class="col s8 bold-text">Section E</div>
                        <div class="col s4 right"><input @if(isset($appraisal) && isset($appraisal->competenceSummary) ) value="{{$appraisal->competenceSummary->section_e_final_score}}" @endif
                                    size="8"  name="FinalScoreSecE" id="FinalScoreSecE" type="text" class="validate browser-default"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 valign-wrapper">
                        <div class="col s8 bold-text">TOTAL</div>
                        <div class="col s4 right"><input @if(isset($appraisal) && isset($appraisal->competenceSummary) ) value="{{$appraisal->competenceSummary->total_score}}" @endif
                                    size="8" name="OverallTotal" id="OverallTotal" type="text" class="validate browser-default"></div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col m6 s12  spacer-top">
            <div class="row " style="margin-top: 0">
                <div class="col  s12">
                    <div class="row row-no-margin-bot"><span class="col s12 left bold-text">Legend</span></div>
                    <div class="row row-no-margin-bot"> <span class="col s6 left">Excellent</span>  <span class="col s6 right">90% and above</span></div>
                    <div class="row row-no-margin-bot"> <span class="col s6 left">Very Good</span>  <span class="col s6 right">80-89%</span></div>
                    <div class="row row-no-margin-bot"><span class="col s6 left">Good</span>  <span class="col s6 right">70-79%</span></div>
                    <div class="row row-no-margin-bot"><span class="col s6 left">Fairy good</span>  <span class="col s6 right">60-69%</span></div>
                    <div class="row row-no-margin-bot"><span class="col s6 left">Average</span>  <span class="col s6 right">50-59%</span></div>
                    <div class="row row-no-margin-bot"><span class="col s6 left">Poor</span>  <span class="col s6 right">49% and below</span></div>
                    <div class="row row-no-margin-bot"><span class="col s12 left bold-text">*Pass mark at appraisal is 50%</span></div>
                </div>
            </div>
        </div>

    </div>



    <div class="row">
        <div class="input-field col s12">

            @if(!isset($appraisal))
                <button type="submit" name="action" onclick="$('#section-e-form').submit();" class="disabled btn btn-save camel-case blue-stepper">Save Section E</button>
                <input type="hidden" name="save">
            @elseif(isset($appraisal) && !($appraisal->sectione_status))
                <button type="submit" name="action" onclick="$('#section-e-form').submit();" class="btn btn-save camel-case blue-stepper">Save Section E</button>
                <input type="hidden" name="save">
                <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">
            @else
                <button type="submit" name="action" onclick="$('#section-e-form').submit();" class="btn btn-save camel-case blue-stepper">Update Section E</button>
                <input type="hidden" name="update">
                <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">
            @endif

            {{csrf_field()}}

        </div>
    </div>

</form>