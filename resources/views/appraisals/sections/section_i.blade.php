
<form id="section-i-form" method="post" action="{{route('save_section_i')}}" class="col s12 table-format">

    @if(isset($appraisal) && isset($appraisal->appraiserRecommendation))
        <input type="hidden" name="record_id" value="{{$appraisal->appraiserRecommendation->id}}"/>
    @endif


    <div class="row spacer-top">
        <div class="col s12 timo-appraisal-th">Recommendations</div>
        <div class="row">
            <div class="col s12 valign-wrapper">
                <textarea required name="recommendation">@if(isset($appraisal) && isset($appraisal->appraiserRecommendation)){{$appraisal->appraiserRecommendation->recommendations}}@else{{old('recommendation')}}@endif</textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">

            @if(!isset($appraisal))
                <button type="submit" name="action" class="disabled btn btn-save camel-case blue-stepper">Save Section I</button>
                <input type="hidden" name="save">
            @elseif(isset($appraisal) && !isset($appraisal->appraiserRecommendation))
                <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Save Section I</button>
                <input type="hidden" name="save">
                <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">
            @else
                <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Update Section I</button>
                <input type="hidden" name="update">
                <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">
            @endif

            {{csrf_field()}}

        </div>
    </div>

</form>