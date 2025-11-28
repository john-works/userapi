<form id="section-k-form" method="post" action="{{route('save_section_k')}}" class="col s12">

    @if(isset($appraisal) && isset($appraisal->hodComment))
        <input type="hidden" name="record_id" value="{{$appraisal->hodComment->id}}"/>
    @endif

    <div class="row ">
        <div class="col s12 timo-appraisal-th">Comment</div>
        <div class="row">
            <div class="col s12 valign-wrapper">
                <textarea required name="comment">@if(isset($appraisal) && isset($appraisal->hodComment)){{$appraisal->hodComment->comments}}@else{{old('comment')}}@endif</textarea>
            </div>
        </div>
    </div>

    <div class="row spacer-top">
        <div class="input-field col s6">
            <input id="hod_name" required
                   value="@if(isset($appraisal) && isset($appraisal->hodComment)){{$appraisal->hodComment->name}}@else{{old('hod_name')}}@endif"
                   name="hod_name" type="text" class="validate" >
            <label for="hod_name" class="@if(isset($appraisal) && isset($appraisal->hodComment)) active @endif" >Name</label>
        </div>
        <div class="input-field col s6">
            <input id="hod_initials" required
                   value="@if(isset($appraisal) && isset($appraisal->hodComment)){{$appraisal->hodComment->initials}}@else{{old('hod_initials')}}@endif"
                   name="hod_initials" type="text" class="validate" >
            <label for="hod_initials" class="@if(isset($appraisal) && isset($appraisal->hodComment)) active @endif">Initials </label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s6">
            <input  id="date" required
                    value="@if(isset($appraisal) && isset($appraisal->hodComment)){{$appraisal->hodComment->date}}@else{{old('date')}}@endif"
                    name="date" type="date" class="datepicker">
            <label for="date" class="@if(isset($appraisal) && isset($appraisal->hodComment)) active @endif">Date</label>
        </div>
        <div class="col s6"></div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            @if(!isset($appraisal))
                <button type="submit" name="action" class="disabled btn btn-save camel-case blue-stepper">Save Section K</button>
                <input type="hidden" name="save">
            @elseif(isset($appraisal) && !isset($appraisal->hodComment))
                <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Save Section K</button>
                <input type="hidden" name="save">
                <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">
            @else
                <button type="submit" name="action" class="btn btn-save camel-case blue-stepper">Update Section K</button>
                <input type="hidden" name="update">
                <input type="hidden" name="appraisal" value="{{$appraisal->appraisalRef}}">
            @endif

            {{csrf_field()}}

        </div>
    </div>

</form>