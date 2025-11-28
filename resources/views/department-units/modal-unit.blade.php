<div id="modal_unit" class="modal custom-fields modal-for-ajax-data">

    <div class="modal-content">

        <div  class="col s12">

            <form id="form_modal_unit" class="col s12" method="post" action="{{route('department-units.store')}}">

                <div class="form-container">

                    <div class="center timo-form-headers">Add Department Unit</div>

                    <div class="row">
                        <div class="col input-field m6 offset-m3 l6 offset-l3 s12">
                            <input id="name" name="name" type="text" class="validate" required value="{{old('name')}}">
                            <label for="name">Unit Name</label>
                        </div>
                    </div>

                    <div class="row spacer-bottom">
                        <div class="col m6 offset-m3 l6 offset-l3 s12">
                            <label class="display-block" for="department_code">Department</label>
                            <select name="department_code" required class="browser-default timo-select">
                                <option value="" disabled selected>Choose Department</option>
                                @if(isset($departments) && count($departments) > 0)
                                    @foreach($departments as $dept)
                                        <option  value="{{$dept->departmentCode}}">{{$dept->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col s5"></div>
                    </div>

                    {{-- Hidden created by field --}}
                    <input id="created_by" name="created_by" type="text" class="validate" hidden required value="{{$author->username}}">

                    <div class="row">
                        <div class="col s12">

                            <div class="message-success center" id="form-messages"></div>
                            <div class="message-error" id="print-error-msg" style="display:none">
                                <ul></ul>
                            </div>

                        </div>
                    </div>

                    <div class="row row-custom-modal-footer">
                        <div class="col s12 spacer-small"></div>
                        <div class="col s12">
                            <button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal_unit').modal('close'); return false;"  >CLOSE</button>
                            <button class="modal-action right btn-flat waves-effect waves-light camel-case waves-green" type="submit" name="action">SAVE</button>
                        </div>
                        <div class="col s12 spacer"></div>
                    </div>

                    {{csrf_field()}}
                </div>
            </form>

        </div>

    </div>
</div>