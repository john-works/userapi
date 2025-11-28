
<input id="default_active_step" value="@if(isset($defaultActiveStepIndex)){{$defaultActiveStepIndex}}@else{{0}}@endif" type="hidden" />
<ul style="overflow: visible" class="stepper col s12">

    <li data-before="add"  id="sec_a" class="step @if(!in_array('sec_a',$visibleSections)) hidden @endif @if(isset($activeStep) and $activeStep == 'sec_a')  @elseif(in_array('sec_a',$doneSteps)) done @endif">
        <div  data-step-index = "0" data-step-label="To be filled by appraisee" class="step-title waves-effect">SECTION  A - Personal Details</div>
        <div class="step-content">
            <div class="row">
                {{-- Check if we updating this section or not --}}
                @if(isset($appraisal) && isset($appraisal->personalInfo)) @include('appraisals.sections.section_a_edit')
                @else @include('appraisals.sections.section_a') @endif
            </div>
        </div>
    </li>

    <li id="sec_b" class="step @if(!in_array('sec_b',$visibleSections)) hidden @endif @if(isset($activeStep) and $activeStep == 'sec_b') active @elseif(in_array('sec_b',$doneSteps)) done @endif">
        <div data-step-index = "1" data-step-label="To be filled by appraisee" class="step-title waves-effect">SECTION  B - Education/Training Background</div>
        <div class="step-content">
            <div class="row">
                {{-- Check if we updating this section or not --}}
                @if(isset($appraisal) && isset($appraisal->academicBackgrounds) && count($appraisal->academicBackgrounds) > 0) @include('appraisals.sections.section_b_edit')
                @else @include('appraisals.sections.section_b') @endif
            </div>
        </div>
    </li>

    <li  id="sec_c" class="step @if(!in_array('sec_c',$visibleSections)) hidden @endif @if(isset($activeStep) and $activeStep == 'sec_c') active @elseif(in_array('sec_c',$doneSteps)) done @endif">
        <div data-step-index = "2"  data-step-label="To be filled by appraisee and should be derived from contract, agreed work plan/objectives for the last appraisal period/Financial year"
              class="step-title waves-effect">SECTION  C - Key duties /responsibilities and tasks during the year (Job description)</div>
        <div class="step-content">
            <div class="row">
                {{-- Check if we updating this section or not --}}
                @if(isset($appraisal) && isset($appraisal->keyDuties) && count($appraisal->keyDuties) > 0) @include('appraisals.sections.section_c_edit')
                @else @include('appraisals.sections.section_c') @endif
            </div>
        </div>
    </li>

    <li id="sec_d" class="step @if(!in_array('sec_d',$visibleSections)) hidden @endif @if(isset($activeStep) and $activeStep == 'sec_d') active @elseif(in_array('sec_d',$doneSteps)) done @endif">
        <div data-step-index = "3" data-step-label="Achievements during the period under review (Based on C above)" class="step-title waves-effect">SECTION  D - Assignments (Out of 100)  contributes 80% of the Overall rate</div>
        <div class="step-content">
            <div class="row">
                {{-- Check if we updating this section or not --}}
                @if(isset($appraisal) && isset($appraisal->assignments) && count($appraisal->assignments) > 0) @include('appraisals.sections.section_d_edit')
                @else @include('appraisals.sections.section_d') @endif
            </div>
        </div>
    </li>

    <li  id="sec_d_add" class="step @if(!in_array('sec_d_add',$visibleSections)) hidden @endif @if(isset($activeStep) and $activeStep == 'sec_d_add') active @elseif(in_array('sec_d_add',$doneSteps)) done @endif">
        <div data-step-index = "4" class="step-title waves-effect">SECTION  D - Additional Assignments  (Out of 20)</div>
        <div class="step-content">
            <div class="row">
                {{-- Check if we updating this section or not --}}
                @if(isset($appraisal) && isset($appraisal->additionalAssignments) && count($appraisal->additionalAssignments) > 0) @include('appraisals.sections.section_d_additional_edit')
                @else @include('appraisals.sections.section_d_additional') @endif
            </div>
        </div>
    </li>

    <li  id="sec_e" class="step @if(!in_array('sec_e',$visibleSections)) hidden @endif @if(isset($activeStep) and $activeStep == 'sec_e') active @elseif(in_array('sec_e',$doneSteps)) done @endif">
        <div data-step-index = "5" data-step-label="To be filled by appraiser and appraisee" class="step-title waves-effect">SECTION  E - Staff Competence Assessment  (Out of 100) contributes 20% of the Overall rate</div>
        <div class="step-content">
            <div class="row">
                @include('appraisals.sections.section_e')
            </div>
        </div>
    </li>

    <li  id="sec_f" class="step @if(!in_array('sec_f',$visibleSections)) hidden @endif @if(isset($activeStep) and $activeStep == 'sec_f') active @elseif(in_array('sec_f',$doneSteps)) done @endif">
        <div data-step-index = "6" data-step-label="To be filled by appraisee" class="step-title waves-effect">SECTION  F - Training & Development Needs' Assessment</div>
        <div class="step-content">
            <div class="row">
                {{-- Check if we updating this section or not --}}
                @if(isset($appraisal) && isset($appraisal->performanceGaps) && count($appraisal->performanceGaps) > 0) @include('appraisals.sections.section_f_edit')
                @else @include('appraisals.sections.section_f') @endif
            </div>
        </div>
    </li>

    <li  id="sec_g" class="step @if(!in_array('sec_g',$visibleSections)) hidden @endif @if(isset($activeStep) and $activeStep == 'sec_g') active @elseif(in_array('sec_g',$doneSteps)) done @endif">
        <div data-step-index = "7" data-step-label="Appraiser’s overall comments/recommendations" class="step-title waves-effect">SECTION  G</div>
        <div class="step-content">
            <div class="row">
                @include('appraisals.sections.section_g')
            </div>
        </div>
    </li>

    <li  id="sec_h" class="step @if(!in_array('sec_h',$visibleSections)) hidden @endif @if(isset($activeStep) and $activeStep == 'sec_h') active @elseif(in_array('sec_h',$doneSteps)) done @endif">
        <div data-step-index = "8" data-step-label="To be filled by appraiser" class="step-title waves-effect">SECTION  H - Appraisee Strengths/Weaknesses /Opportunities Review</div>
        <div class="step-content">
            <div class="row">
                @include('appraisals.sections.section_h')
            </div>
        </div>
    </li>

    <li  id="sec_i" class="step @if(!in_array('sec_i',$visibleSections)) hidden @endif @if(isset($activeStep) and $activeStep == 'sec_i') active @elseif(in_array('sec_i',$doneSteps)) done @endif">
        <div data-step-index = "9" data-step-label="To be filled by appraiser" class="step-title waves-effect">SECTION  I - Recommendations</div>
        <div class="step-content">
            <div class="row">
                @include('appraisals.sections.section_i')
            </div>
        </div>
    </li>

    <li  id="sec_j" class="step @if(!in_array('sec_j',$visibleSections)) hidden @endif @if(isset($activeStep) and $activeStep == 'sec_j') active @elseif(in_array('sec_j',$doneSteps)) done @endif">
        <div data-step-index = "10" data-step-label="To be filled by appraiser" class="step-title waves-effect">SECTION  J - Declaration by Supervisor</div>
        <div class="step-content">
            <div class="row">
                @include('appraisals.sections.section_j')
            </div>
        </div>
    </li>

    <li id="sec_k" class="step @if(!in_array('sec_k',$visibleSections)) hidden @endif @if(isset($activeStep) and $activeStep == 'sec_k') active @elseif(in_array('sec_k',$doneSteps)) done @endif">
        <div data-step-index = "11"  data-step-label="To be filled by Head of Department" class="step-title waves-effect">SECTION  K - Head of Department's Comment</div>
        <div class="step-content">
            <div class="row">
                @include('appraisals.sections.section_k')
            </div>
        </div>
    </li>

    <li id="sec_l" class="step @if(!in_array('sec_l',$visibleSections)) hidden @endif @if(isset($activeStep) and $activeStep == 'sec_l') active @elseif(in_array('sec_l',$doneSteps)) done @endif">
        <div data-step-index = "12" data-step-label="To be filled by appraisee" class="step-title waves-effect">SECTION L - Agreed Work Plan for the following year</div>
        <div class="step-content">
            <div class="row">
                {{-- Check if we updating this section or not --}}
                @if(isset($appraisal) && isset($appraisal->workPlans) && count($appraisal->workPlans) > 0) @include('appraisals.sections.section_l_edit')
                @else @include('appraisals.sections.section_l') @endif
            </div>
        </div>
    </li>

    <li  id="sec_m" class="step @if(!in_array('sec_m',$visibleSections)) hidden @endif @if(isset($activeStep) and $activeStep == 'sec_m') active @elseif(in_array('sec_m',$doneSteps)) done @endif">
        <div data-step-index = "13" data-step-label="To be filled by appraisee" class="step-title waves-effect">SECTION M - Appraisee Remarks</div>
        <div class="step-content">
            <div class="row">
                @include('appraisals.sections.section_m')
            </div>
        </div>
    </li>

    <li id="sec_n" class="step @if(!in_array('sec_n',$visibleSections)) hidden @endif @if(isset($activeStep) and $activeStep == 'sec_n') active @elseif(in_array('sec_n',$doneSteps)) done @endif">
        <div data-step-index = "14" data-step-label="To be filled by Executive Director" class="step-title waves-effect">SECTION N - Overall Comments by Executive Director</div>
        <div class="step-content">
            <div class="row">
                @include('appraisals.sections.section_n')
            </div>
        </div>
    </li>

</ul>