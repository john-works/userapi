<div id="modal_designation" class="modal custom-fields modal-for-ajax-data">

    <div class="modal-content">

        <div  class="col s12">

            <form id="form_modal_designation" class="col s12" method="post" action="{{route('designations.store')}}">

                <div class="form-container">

                    <div class="center timo-form-headers">Add Designation</div>

                    <div class="row">
                        <div class="col input-field m6 offset-m3 l6 offset-l3 s12">
                            <input id="title" name="title" type="text" class="validate" required value="{{old('title')}}">
                            <label for="title">Designation Title</label>
                        </div>
                    </div>

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
                            <button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal_designation').modal('close'); return false;"  >CLOSE</button>
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