
<form id="section-e-form" method="post" action="{{route('save_section_e')}}" class="col s12">

    <div class="row ">

        <div class="col s12">

            <table class="bordered" border="1" id="table_sec_e" style="border-collapse: collapse;margin-right: 5px">
                <thead>
                <thead>
                <tr >
                    <th class="timo-appraisal-th" colspan="2">Competence Area </th>
                    <th class="timo-appraisal-th" style="width: 65px;">Maximum rating</th>
                    <th class="timo-appraisal-th" style="width: 65px;">Appraisee rating</th>
                    <th class="timo-appraisal-th" style="width: 65px;">Appraiser rating</th>
                    <th class="timo-appraisal-th" style="width: 65px;">Agreed rating</th>
                </tr>
                </thead>

                <tbody>

                {{--new competence form--}}
                @if(isset($categorizedCompetences))

                    @foreach($categorizedCompetences as $category)
                        {{--each category is an an array of competence objectives--}}

                        {{--category  header--}}

                        <tr>
                            <th style="width: 10px">{{$loop->iteration}}</th>
                            <th >{{$category->competenceCategory}}</th>
                            <th style="width: 65px;">{{$category->maxRating}}</th>
                            <th style="width: 65px;">&nbsp;</th>
                            <th style="width: 65px;">&nbsp;</th>
                            <th style="width: 65px;">&nbsp;</th>
                        </tr>

                        {{-- loop through the competence --}}

                        @foreach($category->appraisalCompetences as $item)
                            <tr>
                                <td>{{$item->rank}}</td>
                                <td>{{$item->competence}}</td>
                                <td style="padding-top: 5px;"><input readonly value="{{$item->rating}}" class="browser-default" tabindex="214"  type="number" size="3" style="width: 65px;" name="secEmax02"  min="0" onblur="finishTable('table_sec_e',2,'secEmaxTotal')"/></td>

                                <td style="padding-top: 5px;"><input value="{{isset($item->scoreAppraiseeRating) ? $item->scoreAppraiseeRating : old($category->id.'_appraisee_rating_'.$item->id)}}" class="browser-default" tabindex="215"  type="number" size="3" style="width: 65px;" name="{{$category->id}}_appraisee_rating_{{$item->id}}"  min="0"
                                            onblur="finishTable('table_sec_e',3,'secEappraiseeTotal')"/></td>

                                <td style="padding-top: 5px;"><input  value="{{isset($item->scoreAppraiserRating) ? $item->scoreAppraiserRating : old($category->id.'_appraiser_rating_'.$item->id)}}" class="browser-default" tabindex="216"  type="number" size="3" style="width: 65px;" name="{{$category->id}}_appraiser_rating_{{$item->id}}"  min="0"
                                            onblur="finishTable('table_sec_e',4,'secEappraiserTotal')"/></td>

                                <td style="padding-top: 5px;"><input value="{{isset($item->scoreAgreedRating) ? $item->scoreAgreedRating : old($category->id.'_agreed_rating_'.$item->id)}}" class="browser-default" tabindex="217"  type="number" size="3" style="width: 65px;" name="{{$category->id}}_agreed_rating_{{$item->id}}"  min="0"
                                            onblur="finishTable('table_sec_e',5,'secEagreedTotal');calculateSecEpercent();calculateSectionDAndSectionDAdditionalAsAPercentage()"/></td>
                            </tr>

                            @if(isset($item->scoreRecordId)) <input value="{{$item->scoreRecordId}}" name="{{$category->id}}_record_id_{{$item->id}}" type="hidden"/> @endif

                        @endforeach


                    @endforeach

                @endif

                </tbody>

                <tfoot>
                <tr><td colspan="2" style="text-align: right"><strong> TOTAL SCORE</strong></td>
                    <td style="padding-top: 5px;"><input @if(isset($appraisal) && isset($appraisal->competenceAssessmentsScores) ) value="{{$appraisal->competenceAssessmentsScores->totalMaximumRating}}" @endif
                                tabindex="406" class="browser-default"  type="text" readonly size="3" style="width: 65px;" name="secEmaxTotal" id="secEmaxTotal" onblur="finishTable('table_sec_e',2,'secEmaxTotal')"/></td>
                    <td style="padding-top: 5px;"><input @if(isset($appraisal) && isset($appraisal->competenceAssessmentsScores) ) value="{{$appraisal->competenceAssessmentsScores->totalAppraiseeRating}}" @else value="{{old('secEappraiseeTotal')}}" @endif
                                tabindex="407" class="browser-default"  type="text" readonly size="3" style="width: 65px;" name="secEappraiseeTotal" id="secEappraiseeTotal" onblur="finishTable('table_sec_e',3,'secEappraiseeTotal')"/></td>
                    <td style="padding-top: 5px;"><input @if(isset($appraisal) && isset($appraisal->competenceAssessmentsScores) ) value="{{$appraisal->competenceAssessmentsScores->totalAppraiserRating}}" @else value="{{old('secEappraiserTotal')}}" @endif
                                tabindex="408" class="browser-default"  type="text" readonly size="3" style="width: 65px;"name="secEappraiserTotal" id="secEappraiserTotal" onblur="finishTable('table_sec_e',4,'secEappraiserTotal')"/></td>
                    <td style="padding-top: 5px;"><input @if(isset($appraisal) && isset($appraisal->competenceAssessmentsScores) ) value="{{$appraisal->competenceAssessmentsScores->totalAgreedRating}}" @else value="{{old('secEagreedTotal')}}" @endif
                                tabindex="409" class="browser-default"  type="text" readonly size="3" style="width: 65px;" name="secEagreedTotal" id="secEagreedTotal" onblur="finishTable('table_sec_e',5,'secEagreedTotal')"/></td>
                </tr>
                </tfoot>

            </table>

            @if(isset($appraisal) && isset($appraisal->competenceAssessmentsScores))
                <input type="hidden" name="scores_sec_e_record_id" value="{{$appraisal->competenceAssessmentsScores->id}}"/>
            @endif

        </div>

    </div>


    <div class="row spacer-top grey lighten-2 valign-wrapper">

        <div class="col m6 s12  spacer-top">
            <div class="row">
                <div class="col s12 blue-text bold-text spacer-bottom">Section E Percentage Scores</div>
                <div class="row ">
                    <div class="col s12 valign-wrapper">
                        <div class="col s8 bold-text">Final Percentage Score</div>
                        <div class="col s4 right"><input @if(isset($appraisal) && isset($appraisal->competenceAssessmentsSummaries) ) value="{{$appraisal->competenceAssessmentsSummaries->sectionEPercentageScore}}" @endif
                                    size="8" name="sec_e_final_percentage_score" id="sec_e_final_percentage_score" type="text" class="validate browser-default"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 valign-wrapper">
                        <div class="col s8 bold-text">Apply 20% weighting</div>
                        <div class="col s4 right"><input @if(isset($appraisal) && isset($appraisal->competenceAssessmentsSummaries) ) value="{{$appraisal->competenceAssessmentsSummaries->sectionEWeighedScore}}" @endif
                                    size="8" name="sec_e_weighed" id="sec_e_weighed" type="text" class="validate browser-default"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col s12 red-text bold-text spacer-bottom">Overall Assessment</div>
                <div class="row ">
                    <div class="col s12 valign-wrapper">
                        <div class="col s8 bold-text">Section D</div>
                        <div class="col s4 right"><input @if(isset($appraisal) && isset($appraisal->competenceAssessmentsSummaries) ) value="{{$appraisal->competenceAssessmentsSummaries->sectionDScore}}" @endif
                                    size="8"  name="FinalScoreSecD" id="FinalScoreSecD" type="text" class="validate browser-default"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 valign-wrapper">
                        <div class="col s8 bold-text">Section E</div>
                        <div class="col s4 right"><input @if(isset($appraisal) && isset($appraisal->competenceAssessmentsSummaries) ) value="{{$appraisal->competenceAssessmentsSummaries->sectionEScore}}" @endif
                                    size="8"  name="FinalScoreSecE" id="FinalScoreSecE" type="text" class="validate browser-default"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 valign-wrapper">
                        <div class="col s8 bold-text">TOTAL</div>
                        <div class="col s4 right"><input @if(isset($appraisal) && isset($appraisal->competenceAssessmentsSummaries) ) value="{{$appraisal->competenceAssessmentsSummaries->appraisalTotalScore}}" @endif
                                    size="8" name="OverallTotal" id="OverallTotal" type="text" class="validate browser-default"></div>
                    </div>
                </div>

                @if(isset($appraisal) && isset($appraisal->competenceAssessmentsSummaries))
                    <input type="hidden" name="sec_e_summary_record_id" value="{{$appraisal->competenceAssessmentsSummaries->id}}"/>
                @endif

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

            @if(
            !isset($appraisal) ||
            (isset($appraisal) && !isset($appraisal->competenceAssessments)) ||
            (isset($appraisal) && count($appraisal->competenceAssessments) <1 ) )

                <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Save Section E</button>
                <input type="hidden" name="save">
                <input type="hidden" name="appraisal" value="@if(isset($appraisal)){{$appraisal->appraisalRef}}@endif">

            @else
                <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Update Section E</button>
                <input type="hidden" name="update">
                <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">
            @endif

            {{csrf_field()}}

        </div>
    </div>

</form>