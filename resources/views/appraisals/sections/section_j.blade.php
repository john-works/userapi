
<form id="section-j-form" method="post" action="{{route('save_section_j')}}" class="col s12 table-format">

    @if(isset($appraisal) && isset($appraisal->supervisorDeclaration))
        <input type="hidden" name="record_id" value="{{$appraisal->supervisorDeclaration->id}}"/>
    @endif

    <div class="row spacer-top">
        <div class="col s12">

            I, <input required tabindex="444"
                      value="@if(isset($appraisal) && isset($appraisal->supervisorDeclaration)){{$appraisal->supervisorDeclaration->appraiserName}}@else{{old('appraiser_name')}}@endif"
                      type="" placeholder="Appraiser's Name" name="appraiser_name" maxlength="22"/> having supervised
            <input required tabindex="445"
                   value="@if(isset($appraisal) && isset($appraisal->supervisorDeclaration)){{$appraisal->supervisorDeclaration->appraiseeName}}@else{{old('appraisee_name')}}@endif"
                   type="" placeholder="Appraisee Name" name="appraisee_name" maxlength="22"/>&nbsp;for&nbsp;<input tabindex="446"
                   value="@if(isset($appraisal) && isset($appraisal->supervisorDeclaration)){{$appraisal->supervisorDeclaration->duration}}@else{{old('duration')}}@endif"
                   type="" placeholder="Duration" name="duration" maxlength="22"/> in the period
            from
                <input required
                        value="@if(isset($appraisal) && isset($appraisal->supervisorDeclaration)){{$appraisal->supervisorDeclaration->startDate}}@else{{old('start_date')}}@endif"
                        class="inline browser-default" tabindex="447"  style="margin-top:2px;" type="date" name="start_date" maxlength="12"/>

            to
            <input required
                    value="@if(isset($appraisal) && isset($appraisal->supervisorDeclaration)){{$appraisal->supervisorDeclaration->endDate}}@else{{old('end_date')}}@endif"
                    class="inline browser-default" tabindex="448"  style="margin-top:2px;" type="date" name="end_date" maxlength="12"/>
            do affirm that I have completed the
            appropriate sections of this Staff Evaluation Form to the best of my judgment believing the contents therein to be true.

        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">

            @if(!isset($appraisal))
                <button type="submit" name="action" class="disabled btn btn-save camel-case blue-stepper">Save Section J</button>
                <input type="hidden" name="save">
            @elseif(isset($appraisal) && !isset($appraisal->supervisorDeclaration))
                <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Save Section J</button>
                <input type="hidden" name="save">
                <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">
            @else
                <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Update Section J</button>
                <input type="hidden" name="update">
                <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">
            @endif

            {{csrf_field()}}

        </div>
    </div>

</form>