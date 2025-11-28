
<form id="section-g-form" method="post" action="{{route('save_section_g')}}" class="col s12 table-format">

    @if(isset($appraisal) && isset($appraisal->appraiserComment))
        <input type="hidden" name="record_id" value="{{$appraisal->appraiserComment->id}}"/>
    @endif


    <div class="row valign-wrapper spacer-top">

        <div class="col s12">
            <select name="recommendation_decision" required class="browser-default validate " style="width: 100%">
                <option value="" disabled selected>Select Appraiser Overall Comment/Recommendation</option>
                <option
                        @if(isset($appraisal) && ($appraisal->appraiserComment != null) && ($appraisal->appraiserComment->recommendation == 'To confirm in service')) selected @elseif(old('recommendation_decision') == 'To confirm in service') selected @endif
                >To confirm in service</option>
                <option
                        @if(isset($appraisal) && ($appraisal->appraiserComment != null) && ($appraisal->appraiserComment->recommendation == 'Not to confirm in service')) selected @elseif(old('recommendation_decision') == 'Not to confirm in service') selected  @endif
                >Not to confirm in service</option>
                <option
                        @if(isset($appraisal) && ($appraisal->appraiserComment != null) && ($appraisal->appraiserComment->recommendation == 'To renew contract')) selected @elseif(old('recommendation_decision') == 'To renew contract') selected  @endif
                >To renew contract</option>
                <option
                        @if(isset($appraisal) && ($appraisal->appraiserComment != null) && ($appraisal->appraiserComment->recommendation == 'Training')) selected @elseif(old('recommendation_decision') == 'Training') selected  @endif
                >Training</option>
                <option
                        @if(isset($appraisal) && ($appraisal->appraiserComment != null) && ($appraisal->appraiserComment->recommendation == 'Transfer')) selected @elseif(old('recommendation_decision') == 'Transfer') selected  @endif
                >Transfer</option>
                <option
                        @if(isset($appraisal) && ($appraisal->appraiserComment != null) && ($appraisal->appraiserComment->recommendation == 'Regrading')) selected @elseif(old('recommendation_decision') == 'Regrading') selected  @endif
                >Regrading</option>
                <option
                        @if(isset($appraisal) && ($appraisal->appraiserComment != null) && ($appraisal->appraiserComment->recommendation == 'Termination of services')) selected @elseif(old('recommendation_decision') == 'Termination of services') selected  @endif
                >Termination of services</option>
                <option
                        @if(isset($appraisal) && ($appraisal->appraiserComment != null) && ($appraisal->appraiserComment->recommendation == 'Probationary period comments')) selected @elseif(old('recommendation_decision') == 'Probationary period comments') selected  @endif
                >Probationary period comments</option>
                <option
                        @if(isset($appraisal) && ($appraisal->appraiserComment != null) && ($appraisal->appraiserComment->recommendation == 'Others')) selected @elseif(old('recommendation_decision') == 'Others') selected   @endif
                >Others</option>
            </select>
        </div>

    </div>

    <div class="row valign-wrapper spacer-top">
        <div class="col s12 ">
            <textarea placeholder="Enter your comment here" name="comment" class="textarea-sec-g">@if(isset($appraisal) && ($appraisal->appraiserComment != null)){{$appraisal->appraiserComment->comment}}@else{{old('comment')}}@endif</textarea>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">

            @if(!isset($appraisal))
                <button type="submit" name="action" class="disabled btn btn-save camel-case blue-stepper">Save Section G</button>
                <input type="hidden" name="save">
            @elseif(isset($appraisal) && !isset($appraisal->appraiserComment))
                <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Save Section G</button>
                <input type="hidden" name="save">
                <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">
            @else
                <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Update Section G</button>
                <input type="hidden" name="update">
                <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">
            @endif

            {{csrf_field()}}

         </div>
    </div>

</form>