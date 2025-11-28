
<form id="section-m-form" method="post" action="{{route('save_section_m')}}" class="col s12">

    @if(isset($appraisal) && isset($appraisal->appraiseeRemark))
        <input type="hidden" name="record_id" value="{{$appraisal->appraiseeRemark->id}}"/>
    @endif

    <div class="row spacer-top spacer-bottom">
        <div class="col s12">
            I,
            <input required value="@if(isset($appraisal) && isset($appraisal->appraiseeRemark)){{$appraisal->appraiseeRemark->appraiseeName}}@endif"
                    class="browser-default" tabindex="482"  type="text" placeholder="Appraisee Name" name="appraisee_name" maxlength="22"/>
            (Appraisee)
            <select required class="inline browser-default" tabindex="483" name="agree_or_disagree">
                <option class="browser-default" value="agree"
                        @if(isset($appraisal) && isset($appraisal->appraiseeRemark) && $appraisal->appraiseeRemark->agreementDecision == 'agree')
                        selected @elseif(old('agree_or_disagree') == 'agree') selected
                        @endif
                        >agree</option>
                <option class="browser-default" value="disagree"
                        @if(isset($appraisal) && isset($appraisal->appraiseeRemark) && $appraisal->appraiseeRemark->agreementDecision == 'disagree')
                        selected @elseif(old('agree_or_disagree') == 'disagree') selected
                        @endif
                        >disagree</option>
            </select>* with the outcome of this appraisal.

        </div>
    </div>

    <div class="row ">
        <div class="col s12 timo-appraisal-th">Reason for disagreement</div>
        <div class="row">
            <div class="col s12 valign-wrapper">
                <textarea name="reason_for_disagreement">@if(isset($appraisal) && isset($appraisal->appraiseeRemark)){{$appraisal->appraiseeRemark->disagreementReason}}@else{{old('reason_for_disagreement')}}@endif</textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s6">
            <input required id="name"
                   value="@if(isset($appraisal) && isset($appraisal->appraiseeRemark)){{$appraisal->appraiseeRemark->declarationName}}@else{{old('name')}}@endif"
                   name="name" type="text" class="validate" >
            <label class="@if(isset($appraisal) && isset($appraisal->appraiseeRemark)) active @endif"  for="name" >Name</label>
        </div>
        <div class="input-field col s6">
            <input required id="initials"
                   value="@if(isset($appraisal) && isset($appraisal->appraiseeRemark)){{$appraisal->appraiseeRemark->declarationInitials}}@else{{old('initials')}}@endif"
                   name="initials" type="text" class="validate" >
            <label class="@if(isset($appraisal) && isset($appraisal->appraiseeRemark)) active @endif" for="initials"> Initials  </label>
        </div>
    </div>

    <div class="row spacer-bottom">
        <div class="input-field col s6">
            <input required  id="date_sec_m"
                    value="@if(isset($appraisal) && isset($appraisal->appraiseeRemark)){{$appraisal->appraiseeRemark->declarationDate}}@else{{old('date')}}@endif"
                    name="date" type="date" class="datepicker">
            <label class="@if(isset($appraisal) && isset($appraisal->appraiseeRemark)) active @endif" for="date_sec_m">Date</label>
        </div>
        <div class="col s6"></div>
    </div>

    <div class="col s12 timo-appraisal-th-level-2 spacer-top red-text">
        NOTE: In case of a strong disagreement from the appraisee, the appraisal may be referred to the Executive Director for adjudication.
    </div>

    <div class="row">
        <div class="input-field col s12">

            @if(!isset($appraisal))
                <button type="submit" name="action"  class="disabled btn btn-save camel-case blue-stepper">Save Section M</button>
                <input type="hidden" name="save">
            @elseif(isset($appraisal) && !isset($appraisal->appraiseeRemark))
                <button type="submit" name="action"  class="btn btn-save camel-case blue-stepper">Save Section M</button>
                <input type="hidden" name="save">
                <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">
            @else
                <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Update Section M</button>
                <input type="hidden" name="update">
                <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">
            @endif

            {{csrf_field()}}

        </div>
    </div>

</form>