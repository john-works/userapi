<div id="modal_org" class="modal custom-fields modal-for-ajax-data">

    <div class="modal-content">

        <div  class="col s12">

            <form id="form_modal_org" class="col s12" method="post" action="{{route('organization.store')}}">

                <div class="form-container">

                    <div class="col s12 center timo-form-headers">ADD ORGANIZATION</div>

                    <div class="row">
                        <div class="input-field col m6 offset-m3 l6 offset-l3 s12">
                            <input id="name" name="name" type="text" class="validate" required value="">
                            <label for="name">Organization Name</label>
                        </div>
                    </div>


                    <div class="row">
                        <div class="input-field col m6 offset-m3 l6 offset-l3 s12">
                            <input id="contact_person_name" name="contact_person_name" type="text" class="validate" required value="">
                            <label for="contact_person_name">Contact Person Name</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col m6 offset-m3 l6 offset-l3 s12">
                            <input id="contact_person_contact" name="contact_person_contact" type="text" class="validate" required value="">
                            <label for="contact_person_contact">Contact Person Contact</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col m6 offset-m3 l6 offset-l3 s12">
                            <input id="email" name="email" type="email" class="validate" required value="">
                            <label for="email">Email</label>
                        </div>
                    </div>

                    <input id="created_by" name="created_by" type="text" class="validate" hidden required value="{{$author->username}}">

                    <div class="row">
                        <div class="col s12">

                            <div class="message-success center" id="form-messages"></div>
                            <div class="message-error" id="print-error-msg" style="display:none">
                                <ul></ul>
                            </div>

                        </div>
                    </div>

                   {{-- <div class="row spacer-top spacer-bottom">
                        <div class="col s12 center">
                            <button class="btn waves-effect waves-light camel-case blue darken-4" type="submit" name="action">Create Organization</button>
                        </div>
                    </div>--}}
                    <div class="row row-custom-modal-footer">
                        <div class="col s12 spacer-small"></div>
                        <div class="col s12">
                            <button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal_org').modal('close'); return false;"  >CLOSE</button>
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