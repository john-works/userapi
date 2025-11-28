<div id="modal_academic_bg" class="modal custom-fields modal-70 modal-for-ajax-data " >

    <div class="modal-content">

        {{-- Content of this orm will be got dynamically --}}
        {{--<div id="ajax_lorem" class="ajax_lorem col s12 center spacer-bottom spacer-top"><h5 class="red-text center">Loading Data ...</h5></div>--}}

        <div id="ajax_actual"  class="ajax_actual col s12">

            <form class="col s12 ajax-created-form" id="form_modal_user_academic_bg_edit" method="post" action="{{route('users.academic-bg-update')}}">

                {{-- Start : Hidden fields that hold required data --}}
                <input id="username_edit" name="username" type="text" hidden value="">
                <input id="record_id_edit" name="record_id" type="text" hidden value="">
                {{-- End   : Hidden fields that hold required data --}}

                <div class="form-container">

                    <h5 class="center timo-primary-text">Academic Background</h5>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="institution_edit" name="institution" type="text" class="validate " required value="">
                            <label for="institution" class="active">School</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="year_of_study_edit" name="year_of_study" type="text" class="validate" required value="">
                            <label for="year_of_study" class="active">Year of Study</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="award_edit" name="award" type="text" class="validate" required value="">
                            <label for="award" class="active">Award</label>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col s12">

                            <div class="message-success center" id="form-messagesedit"></div>
                            <div class="message-error" id="print-error-msgedit" style="display:none">
                                <ul></ul>
                            </div>

                        </div>
                    </div>

                    <div class="row row-custom-modal-footer">
                        <div class="col s12 spacer-small"></div>
                        <div class="col s12">
                            <button class="modal-action right btn-flat waves-effect waves-light camel-case waves-green" type="submit" name="action">UPDATE</button>
                            <button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal_academic_bg').modal('close'); return false;"  >CLOSE</button>
                        </div>
                        <div class="col s12 spacer"></div>
                    </div>

                    {{csrf_field()}}

                </div>

            </form>

        </div>


    </div>
</div>