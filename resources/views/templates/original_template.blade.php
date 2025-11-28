<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <?php $css_path = '/css/styles.css'; $css_mat_path = '/css/materialize.min.css'; ?>
    <link rel="stylesheet" href="{{ public_path() . $css_path }}" type="text/css"/>
    <style>

        .container{
            width:  85%;
            margin: 0 auto;
            text-align: center;
        }
        .spacer-bottom{
            margin-bottom: 10px;
        }
        .bold-text{
            font-weight: bold;
        }

        .divider{
            height: 1px;
            background-color: #cecece;
            width: 100%;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .row{
            width: 100%;
            display: block;
        }

        .c-label{
            /*color: #0000cc;*/
        }

        .c-content{
            font-weight: bold;
            margin-left: 10px;
        }

        table{
            width: 100%;
            border-collapse: collapse;
            border-color: #cecece;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        td,th{
            border: 1px #cecece solid;
        }

        th{
            text-align: center;
        }


        .td-sec-a-label{
            width: 30%;
        }
        .td-sec-a-value{
            width: 70%;
        }

        .th-number{
            width: 3%;
        }
        .th-percent{
            width: 5%;
        }
        .th-timeframe{
            width: 15%;
        }

        .center,.center-align{text-align:center}


    </style>
</head>

<body>
<div class="container ">
    <?php $image_path = '/images/ppda_logo.png'; ?>
    {{--<div class="banner center spacer-bottom"><img src="{{ public_path() . $image_path }}"/></div>--}}
    <h5><div style="text-align: center;" class="spacer-bottom">
            <img style="display: block"  height="40px" src="{{public_path() . $image_path}}"/>
        </div>
    </h5>
    {{--<div style="text-align: center"  class="banner spacer-bottom"><img  height="40px" src="{{asset('images/ppda_logo.png')}}"/></div>--}}
    <div class="bold-text spacer-bottom">STAFF ANNUAL PERFORMANCE AND DEVELOPMENT REVIEW</div>
    <div class="spacer-bottom" >JOB LEVEL - SENIOR OFFICER</div>
    <div class="divider"></div>


    {{-- Period Section --}}
    <div class="row">
        <table >
            <tr>
                <td><span class="c-label">Staff Personal File Number:</span><span class="c-content">{{$data->staff_file_number}}</span></td>
                <td><span class="c-label">From:</span><span class="c-content">{{$data->start_date}}</span></td>
                <td><span class="c-label">To:</span><span class="c-content">{{$data->end_date}}</span></td>
            </tr>
        </table>
    </div>
    {{--End of Period section --}}


    {{-- Score summary --}}
    <div>
        <table>
            <tr><th colspan="4">SUMMARY (To be filled by appraiser)</th></tr>
            <tr><th></th><th>Item</th><th>Maximum Score</th><th>Scored</th></tr>
            <tr><td>Section A</td><td>Staff Personal Details</td>   <td>NA</td><td>NA</td></tr>
            <tr><td>Section B</td><td>Education/Training Background</td>   <td>NA</td><td>NA</td></tr>
            <tr><td>Section C</td><td>Key Duties/responsibilities</td>   <td>NA</td><td>NA</td></tr>
            <tr><td>Section D</td><td>Job Performance Achievements</td>   <td>NA</td><td>NA</td></tr>
            <tr><td>Section E</td><td>Staff competence assessment</td>   <td>NA</td><td>NA</td></tr>
            <tr><td>Section F</td><td>Training & development needs assessment</td>   <td>NA</td><td>NA</td></tr>
            <tr><td>Section G</td><td>Appraisee Strengths/Weaknesses/Opportunities</td>   <td>NA</td><td>NA</td></tr>
            <tr><td>Section H</td><td>Recommendations</td>   <td>NA</td><td>NA</td></tr>
            <tr><td>Section I</td><td>Declaration by Supervisor</td>   <td>NA</td><td>NA</td></tr>
            <tr><td>Section J</td><td>Head of Department’s comments</td>   <td>NA</td><td>NA</td></tr>
            <tr><td>Section K</td><td>Appraisee Remarks</td>   <td>NA</td><td>NA</td></tr>
            <tr><td>Section L</td><td>Agreed work plan for the following year</td>   <td>NA</td><td>NA</td></tr>
            <tr><td>Section M</td><td>Overall comments by Executive Director</td>   <td>NA</td><td>NA</td></tr>
            <tr><th colspan="2" >AGREED RATING/TOTAL SCORE</th>   <td>NA</td><td>NA</td></tr>
        </table>
    </div>
    {{-- End of Score summary --}}



    {{-- Personal info section --}}
    <div class="row">
        <table style="width: 100%">

            <tr>
                <td colspan="4" >
                    <div >SECTION A (To be filled by appraisee) Personal Details</div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="td-sec-a-label"><div style="width: 100%" ><span class="label-seca">SURNAME:</span><span class=""></span></div></td>
                <td colspan="2" class="td-sec-a-value">{{$data->surname}}</td>
            </tr>
            <tr>
                <td colspan="2" class="td-sec-a-label"><div style="width: 100%" ><span class="label-seca">OTHER NAMES:</span><span class=""></span></div></td>
                <td colspan="2" class="td-sec-a-value">{{$data->other_name}}</td>
            </tr>
            <tr>
                <td colspan="2" class="td-sec-a-label"><div style="width: 100%" ><span class="label-seca">DATE OF BIRTH:</span><span class=""></span></div></td>
                <td colspan="2" class="td-sec-a-value">{{$data->dob}}</td>
            </tr>
            <tr>
                <td class="td-sec-a-label"><div style="width: 100%" ><span class="label-seca">DESIGNATION:</span><span class=""></span></div></td>
                <td class="td-sec-a-value">{{$data->designation}}</td>
                <td class="td-sec-a-label"><div style="width: 100%" ><span class="label-seca">DEPARTMENT:</span><span class=""></span></div></td>
                <td class="td-sec-a-value">{{$data->department}}</td>
            </tr>

        </table>
    </div>

    {{-- Education Background section --}}
    <div class="row">
        <table style="width: 100%">

            <tr>
                <td colspan="4 " >
                    <div >SECTION B (To be filled by appraisee)</div>
                    <div>Education/Training Background (Begin with the most recent and include courses which are in progress)</div>
                </td>
            </tr>
            <tr>
                <th class="th-number">No.</th>
                <th>School</th>
                <th>Year of Study</th>
                <th>Award/Qualification</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Mengo Senior School</td>
                <td>2011 - 2012</td>
                <td>A level Certificate</td>
            </tr>


        </table>
    </div>


    {{-- Key duties --}}
    <div class="row">
        <table style="width: 100%">

            <tr>
                <td colspan="5" >
                    <div >SECTION C (To be filled by appraisee and should be derived from contract, agreed work plan/objectives for the last appraisal period/Financial year)</div>
                    <div>Key duties /responsibilities and tasks during the year (Job description)</div>
                </td>
            </tr>
            <tr>
                <th class="th-number">No.</th>
                <th>Job assignments for the year</th>
                <th>Expected Outputs</th>
                <th class="th-percent">Maximum rating</th>
                <th class="th-timeframe">Time Frame</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Mengo Senior School</td>
                <td>A level Certificate</td>
                <td>100</td>
                <td>3 - months</td>
            </tr>


        </table>
    </div>


    {{-- Achievements --}}
    <div class="row">
        <table style="width: 100%">

            <tr>
                <td colspan="7" >
                    <div >SECTION D (To be filled by both appraiser and appraisee)</div>
                    <div>Achievements during the period under review (Based on C above)</div>
                </td>
            </tr>
            <tr>
                <th class="th-number">No.</th>
                <th>Expected output</th>
                <th>Description of actual performance</th>
                <th class="th-percent">Maximum rating</th>
                <th class="th-percent">Appraisee's Rating</th>
                <th class="th-percent">Appraiser's Rating</th>
                <th class="th-percent">Agreed Rating</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Mengo Senior School</td>
                <td>A level Certificate</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
            </tr>

            <tfoot>
            <tr>
                <td colspan="3"></td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
            </tr>
            </tfoot>


        </table>
    </div>



    {{-- Additional Assignments --}}
    <div class="row">
        <table style="width: 100%">

            <tr>
                <td colspan="7" >
                    <div >Section D - Additional Assignments</div>
                </td>
            </tr>
            <tr>
                <th class="th-number">No.</th>
                <th>Additional Expected output</th>
                <th>Description of actual performance</th>
                <th class="th-percent">Maximum rating</th>
                <th class="th-percent">Appraisee's Rating</th>
                <th class="th-percent">Appraiser's Rating</th>
                <th class="th-percent">Agreed Rating</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Mengo Senior School</td>
                <td>A level Certificate</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
            </tr>

            <tfoot>
            <tr>
                <td colspan="3"></td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
            </tr>
            </tfoot>


        </table>


        <table style="width: 100%">

            <tr>
                <th colspan="2" >
                    <div >Section D Percentage Scores</div>
                </th>
            </tr>
            <tr>
                <td>Final Percentage Score:</td> <td></td>
            </tr>
            <tr>
                <td>Apply 80% weighting:</td> <td></td>
            </tr>

            <tr><td colspan="2"></td></tr>

            <tr>
                <td class="td-sec-a-label">Appraiser's Comments:</td> <td></td>
            </tr>

        </table>

    </div>



    {{-- STAFF COMPETENCE ASSESSMENT --}}
    <div class="row">
        <table style="width: 100%">

            <tr>
                <td colspan="6" >
                    <div >Section E: STAFF COMPETENCE ASSESSMENT (To be filled by appraiser and appraisee)</div>
                </td>
            </tr>
            <tr>
                <th class="th-number">No.</th>
                <th>Competence Area</th>
                <th class="th-percent">Maximum rating</th>
                <th class="th-percent">Appraisee's Rating</th>
                <th class="th-percent">Appraiser's Rating</th>
                <th class="th-percent">Agreed Rating</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Mengo Senior School</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
            </tr>

        </table>

        <table style="width: 100%">

            <tr>
                <th colspan="2" >
                    <div >Section E Percentage Scores</div>
                </th>
            </tr>
            <tr>
                <td>Final Percentage Score:</td> <td></td>
            </tr>
            <tr>
                <td>Apply 20% weighting:</td> <td></td>
            </tr>

        </table>

        <table style="width: 100%">

            <tr>
                <th colspan="2" >
                    <div >OVERALL ASSESSMENT</div>
                </th>
            </tr>
            <tr>
                <td>Section D:</td> <td></td>
            </tr>
            <tr>
                <td>Section E:</td> <td></td>
            </tr>
            <tr>
                <td>Total:</td> <td></td>
            </tr>

        </table>

        <table style="width: 100%">

            <tr>
                <th colspan="2" >
                    <div >Legend</div>
                </th>
            </tr>
            <tr> <td>Excellent</td> <td>90% and above</td>  </tr>
            <tr> <td>Very Good</td> <td>80-89%</td>  </tr>
            <tr> <td>Good</td> <td>70-79%</td>  </tr>
            <tr> <td>Fairy good</td> <td>60-69%</td>  </tr>
            <tr> <td>Average</td> <td>50-59%</td>  </tr>
            <tr> <td>Poor</td> <td>49% and below</td>  </tr>
            <tr><td colspan="2"></td></tr>
            <tr> <td colspan="2" class="bold-text">*Pass mark at appraisal is 50%</td> </tr>

        </table>

    </div>

    {{-- STAFF COMPETENCE ASSESSMENT --}}
    <div class="row">
        <table style="width: 100%">

            <tr>
                <td colspan="5" >
                    <div >SECTION F: TRAINING & DEVELOPMENT NEEDS’ ASSESSMENT. (To be filled by appraisee)</div>
                </td>
            </tr>
            <tr>
                <th class="th-number">No.</th>
                <th>Performance Gaps</th>
                <th>Causes</th>
                <th>Recommendations</th>
                <th class="th-timeframe">When</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Mengo Senior School</td>
                <td>Mengo Senior School</td>
                <td>Mengo Senior School</td>
                <td>Next Year</td>
            </tr>

            <tr><td colspan="5"></td></tr>

            <tr>
                <th class="th-number">No.</th>
                <th>Challenges</th>
                <th>Causes</th>
                <th>Recommendations</th>
                <th class="th-timeframe">When</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Mengo Senior School</td>
                <td>Mengo Senior School</td>
                <td>Mengo Senior School</td>
                <td>Next Year</td>
            </tr>


        </table>
    </div>


    {{-- Appraiser’s overall comments --}}
    <div class="row">
        <table style="width: 100%">

            <tr>
                <td colspan="2" >
                    <div >SECTION G: Appraiser’s overall comments/recommendations (Give brief reasons)</div>
                </td>
            </tr>
            <tr>
                <th >Recommendation</th>
                <th>Comment</th>
            </tr>
            <tr>
                <td class="td-sec-a-label">To Renew Contract</td>
                <td>Mengo Senior School</td>
            </tr>

        </table>
    </div>


    {{-- Appraiser’s overall comments --}}
    <div class="row">
        <table style="width: 100%">

            <tr>
                <td>
                    <div >SECTION H: APPRAISEE STRENGTHS/WEAKNESSES /OPPORTUNITIES REVIEW (To be filled by appraiser)</div>
                </td>
            </tr>

            <tr>
                <th >Strengths</th>
            </tr>
            <tr>
                <td >To Renew Contract</td>
            </tr>

            <tr><td></td></tr>

            <tr>
                <th >Weaknesses</th>
            </tr>
            <tr>
                <td >To Renew Contract</td>
            </tr>

        </table>
    </div>

    {{-- RECOMMENDATIONS --}}
    <div class="row">
        <table style="width: 100%">

            <tr>
                <td>
                    <div >SECTION I: RECOMMENDATIONS</div>
                </td>
            </tr>

            <tr>
                <th >Recommendations</th>
            </tr>
            <tr>
                <td >To Renew Contract</td>
            </tr>

        </table>
    </div>

    {{-- Declaration by Supervisor --}}
    <div class="row">


        <table class="spacer-bottom" style="width: 100%">

            <tr>
                <td>
                    <div >SECTION J: DECLARATION BY SUPERVISOR</div>
                </td>
            </tr>

            <tr>
                <td >
                    I, <span class="bold-text">Timothy Kasaga</span> having supervised <span class="bold-text">Martin Mubiru</span> for <span class="bold-text">3 months</span>
                    in the period from <span class="bold-text">1 January 2018 </span> to <span class="bold-text">1 March 2018 </span>
                    do affirm that I have completed the appropriate sections of this StaffEvaluation Form
                    to the best of my judgment believing the contents therein to be true.
                </td>
            </tr>

        </table>


        <table style="width: 100%">

            <tr>
                <td class="td-sec-a-label"><div style="width: 100%" ><span class="label-seca">Date of Interview:</span><span class=""></span></div></td>
                <td class="td-sec-a-value"></td>
            </tr>
            <tr>
                <td class="td-sec-a-label"><div style="width: 100%" ><span class="label-seca">Place:</span><span class=""></span></div></td>
                <td class="td-sec-a-value"></td>
            </tr>
            <tr>
                <td class="td-sec-a-label"><div style="width: 100%" ><span class="label-seca">Supervisor's Name:</span><span class=""></span></div></td>
                <td class="td-sec-a-value"></td>
            </tr>
            <tr>
                <td class="td-sec-a-label"><div style="width: 100%" ><span class="label-seca">Signature:</span><span class=""></span></div></td>
                <td class="td-sec-a-value"></td>
            </tr>
            <tr>
                <td class="td-sec-a-label"><div style="width: 100%" ><span class="label-seca">Date:</span><span class=""></span></div></td>
                <td class="td-sec-a-value"></td>
            </tr>

        </table>

    </div>


    {{-- HEAD OF DEPARTMENT’S COMMENTS --}}
    <div class="row">
        <table style="width: 100%">

            <tr>
                <td>
                    <div >SECTION K: HEAD OF DEPARTMENT’S COMMENTS (where applicable)</div>
                </td>
            </tr>

            <tr>
                <th >Comments</th>
            </tr>
            <tr>
                <td >To Renew Contract</td>
            </tr>

        </table>

        <table style="width: 100%">

            <tr>
                <td class="td-sec-a-label"><div style="width: 100%" ><span class="label-seca">Name:</span><span class=""></span></div></td>
                <td class="td-sec-a-value"></td>
            </tr>
            <tr>
                <td class="td-sec-a-label"><div style="width: 100%" ><span class="label-seca">Signature:</span><span class=""></span></div></td>
                <td class="td-sec-a-value"></td>
            </tr>
            <tr>
                <td class="td-sec-a-label"><div style="width: 100%" ><span class="label-seca">Date:</span><span class=""></span></div></td>
                <td class="td-sec-a-value"></td>
            </tr>


        </table>

    </div>

    {{-- AGREED WORK PLAN FOR THE FOLLOWING YEAR --}}
    <div class="row">
        <table style="width: 100%">

            <tr>
                <td colspan="5" >
                    <div >SECTION L. AGREED WORK PLAN FOR THE FOLLOWING YEAR</div>
                </td>
            </tr>
            <tr>
                <th class="th-number">No.</th>
                <th>Job assignments for the year</th>
                <th>Expected Outputs</th>
                <th class="th-percent">Maximum rating</th>
                <th class="th-timeframe">Time Frame</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Mengo Senior School</td>
                <td>A level Certificate</td>
                <td>100</td>
                <td>3 - months</td>
            </tr>


        </table>
    </div>


    {{-- APPRAISEE REMARKS --}}
    <div class="row">


        <table class="spacer-bottom" style="width: 100%">

            <tr>
                <td>
                    <div >SECTION M: APPRAISEE REMARKS</div>
                </td>
            </tr>

            <tr>
                <td >
                    I, <span class="bold-text">Timothy Kasaga</span> (Appraisee) <span class="bold-text">Agree</span><span class="bold-text">*</span>
                    with the outcome of this appraisal.
                </td>
            </tr>
            <tr><td></td></tr>
            <tr><th>Reasons for disagreement (If applicable)</th></tr>
            <tr><td>Not Happy</td></tr>

        </table>


        <table style="width: 100%">

            <tr>
                <td class="td-sec-a-label"><div style="width: 100%" ><span class="label-seca">Appraisee’s Name:</span><span class=""></span></div></td>
                <td class="td-sec-a-value"></td>
            </tr>
            <tr>
                <td class="td-sec-a-label"><div style="width: 100%" ><span class="label-seca">Signature:</span><span class=""></span></div></td>
                <td class="td-sec-a-value"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="bold-text">
                        NOTE: In case of a strong disagreement from the appraisee, the appraisal may be referred to the Executive Director for adjudication.
                    </div>
                </td>
            </tr>

        </table>

    </div>



    {{-- OVERALL COMMENTS BY EXECUTIVE DIRECTOR --}}
    <div class="row">
        <table style="width: 100%">

            <tr>
                <td>
                    <div >SECTION N: OVERALL COMMENTS BY EXECUTIVE DIRECTOR</div>
                </td>
            </tr>

            <tr>
                <th >Comments</th>
            </tr>
            <tr>
                <td >To Renew Contract</td>
            </tr>

        </table>

        <table style="width: 100%">

            <tr>
                <td class="td-sec-a-label"><div style="width: 100%" ><span class="label-seca">Executive Director:</span><span class=""></span></div></td>
                <td class="td-sec-a-value"></td>
            </tr>
            <tr>
                <td class="td-sec-a-label"><div style="width: 100%" ><span class="label-seca">Signature:</span><span class=""></span></div></td>
                <td class="td-sec-a-value"></td>
            </tr>
            <tr>
                <td class="td-sec-a-label"><div style="width: 100%" ><span class="label-seca">Date:</span><span class=""></span></div></td>
                <td class="td-sec-a-value"></td>
            </tr>

        </table>

    </div>


    <div class="row" style="margin-top: 50px;margin-bottom: 20px">
        <div style="width: 100%" class="center bold-text">
            For: Public Procurement and disposal of Public Assets Authority
        </div>
    </div>

    <div class="divider"></div>

    <div>
        <div style="text-align: left;width: 100%">
            <p>Performance appraisal is not a once for all exercise. It is an ongoing process and a development technique. This form is not a substitute for the need to build a spirit between the
                supervisors and subordinates – positive interpersonal relationships, individual progress and strengthening of the Authority. The following should be noted:
            </p>
        </div>
        <div style="text-align: left">
            <ol>
                <li>Performance Appraisals will be carried out on completion of Probationary appointments.</li>
                <li>Performance Appraisals will be annual.</li>
                <li>Performance Appraisals will be carried out at the end of staff contracts.</li>
            </ol>
        </div>

    </div>


</div>
</body>

</html>