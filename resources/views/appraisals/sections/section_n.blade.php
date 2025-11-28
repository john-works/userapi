<form id="section-n-form" method="post" action="{{route('save_section_n')}}" class="col s12">
    @if(isset($appraisal) && isset($appraisal->directorComment))
        <input type="hidden" name="record_id" value="{{$appraisal->directorComment->id}}"/>
    @endif

    <div class="row ">
        <div class="col s12 timo-appraisal-th">Comments</div>
        <div class="row">
            <div class="col s12 valign-wrapper">
                <textarea required name="comment">@if(isset($appraisal) && isset($appraisal->directorComment)){{$appraisal->directorComment->comments}}@else{{old('comment')}}@endif</textarea>
            </div>
        </div>
    </div>

    <div class="row spacer-top">
        <div class="input-field col s6">
            <input id="ed_name" required
                   value="@if(isset($appraisal) && isset($appraisal->directorComment)){{$appraisal->directorComment->name}}@else{{old('ed_name')}}@endif"
                   name="ed_name" type="text" class="validate" >
            <label for="ed_name" class="@if(isset($appraisal) && isset($appraisal->directorComment)) active @endif" >Executive Director</label>
        </div>
        <div class="input-field col s6">
            <input id="ed_initials" required
                   value="@if(isset($appraisal) && isset($appraisal->directorComment)){{$appraisal->directorComment->initials}}@else{{old('ed_initials')}}@endif"
                   name="ed_initials" type="text" class="validate" >
            <label class="@if(isset($appraisal) && isset($appraisal->directorComment)) active @endif" for="ed_initials">Initials</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s6">
            <input required  id="date_sec_n" value="@if(isset($appraisal) && isset($appraisal->directorComment)){{$appraisal->directorComment->date}}@else{{old('')}}@endif" name="date" type="date" class="datepicker">
            <label class="@if(isset($appraisal) && isset($appraisal->directorComment)) active @endif" for="date_sec_n">Date</label>
        </div>
        <div class="col s6"></div>
    </div>

    <div class="row">
        <div class="input-field col s12">

            @if(!isset($appraisal))
                <button type="submit" name="action" class="disabled btn btn-save camel-case blue-stepper">Save Section N</button>
                <input type="hidden" name="save">
            @elseif(isset($appraisal) && !isset($appraisal->directorComment))
                <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Save Section N</button>
                <input type="hidden" name="save">
                <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">
            @else
                <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Update Section N</button>
                <input type="hidden" name="update">
                <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">
            @endif

            {{csrf_field()}}

        </div>
    </div>

</form>