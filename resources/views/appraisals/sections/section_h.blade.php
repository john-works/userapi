
<form id="section-h-form" method="post" action="{{route('save_section_h')}}" class="col s12 table-format">


    @if(isset($appraisal) && isset($appraisal->strengthAndWeakness))
        <input type="hidden" name="record_id" value="{{$appraisal->strengthAndWeakness->id}}"/>
    @endif


    <div class="row spacer-top">
        <div class="col s12 timo-appraisal-th">Strengths of Appraisee</div>
        <div class="row">
            <div class="col s12 valign-wrapper">
                <textarea name="strengths" >@if(isset($appraisal) && isset($appraisal->strengthAndWeakness)){{$appraisal->strengthAndWeakness->strengths}}@else{{old('strengths')}}@endif</textarea>
            </div>
        </div>
    </div>

    <div class="row spacer-top">
        <div class="col s12 timo-appraisal-th">Weaknesses Identified</div>
        <div class="row">
            <div class="col s12 valign-wrapper">
                <textarea name="weaknesses">@if(isset($appraisal) && isset($appraisal->strengthAndWeakness)){{$appraisal->strengthAndWeakness->weaknesses}}@else{{old('weaknesses')}}@endif</textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">

            @if(!isset($appraisal))
                <button type="submit" name="action" class="disabled btn btn-save camel-case blue-stepper">Save Section H</button>
                <input type="hidden" name="save">
            @elseif(isset($appraisal) && !isset($appraisal->strengthAndWeakness))
                <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Save Section H</button>
                <input type="hidden" name="save">
                <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">
            @else
                <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Update Section H</button>
                <input type="hidden" name="update">
                <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">
            @endif

            {{csrf_field()}}

        </div>
    </div>

</form>