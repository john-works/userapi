
<div  class="col s12">

    <form class="col s12" id="edit_unit_form{{$unit->unitCode}}" method="post" action="{{route('department-units.update')}}">

        {{-- Start : Hidden fields that hold required data --}}
        <input id="unit_code" name="unit_code" type="text" class="validate" hidden required value="{{$unit->unitCode}}">

        <div class="form-container">

            <div class="center timo-form-headers">Department Unit Details</div>

            <div class="row">
                <div class="col input-field m6 offset-m3 l6 offset-l3 s12">
                    <input id="name" name="name" type="text" class="validate" required value="{{$unit->unit}}">
                    <label for="name">Unit Name</label>
                </div>
            </div>

            <div class="row spacer-bottom">
                <div class="col m6 offset-m3 l6 offset-l3 s12">
                    <label class="display-block" for="department_code">Department</label>
                    <select name="department_code" id="department_code{{$unit->unitCode}}" required class="browser-default timo-select">
                        <option value="" disabled selected>Choose Department</option>
                        @if(isset($departments) && count($departments) > 0)
                            @foreach($departments as $dept)
                                <option @if($unit->departmentCode == $dept->departmentCode) selected @endif  value="{{$dept->departmentCode}}">{{$dept->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col s5"></div>
            </div>

            <div class="row">
                <div class="col s12">

                    <div class="message-success center" id="form-messages{{$unit->unitCode}}"></div>
                    <div class="message-error" id="print-error-msg{{$unit->unitCode}}" style="display:none">
                        <ul></ul>
                    </div>

                </div>
            </div>

            <div class="row row-custom-modal-footer">
                <div class="col s12 spacer-small"></div>
                <div class="col s12">
                    <button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal{{$unit->unitCode}}').modal('close'); return false;"  >CLOSE</button>
                    <button class="modal-action right btn-flat waves-effect waves-light camel-case waves-green" type="submit" name="action">UPDATE</button>
                </div>
                <div class="col s12 spacer"></div>
            </div>

            {{csrf_field()}}

        </div>

    </form>

</div>