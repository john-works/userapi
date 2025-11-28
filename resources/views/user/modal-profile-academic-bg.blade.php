<div id="modal_user_academic_bg" class="modal custom-fields modal-for-ajax-data">

    <div class="modal-content">

        <div  class="col s12">

            <form class="col s12" id="form_modal_user_academic_bg" method="post" action="{{route('users.academic-bg-save')}}">

                {{-- Start : Hidden fields that hold required data --}}
                <input id="username" name="username" type="text" hidden value="{{$user->username}}">
                {{-- End   : Hidden fields that hold required data --}}

                <div class="form-container">

                    <h5 class="center timo-primary-text">Academic Background</h5>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="institution" name="institution" type="text" class="validate" required value="{{old('institution')}}">
                            <label for="institution">School</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="year_of_study" name="year_of_study" type="text" class="validate" required value="{{old('year_of_study')}}">
                            <label for="year_of_study">Year of Study</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="award" name="award" type="text" class="validate" required value="{{old('award')}}">
                            <label for="award">Award</label>
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
                            <button class="modal-action right btn-flat waves-effect waves-light camel-case waves-green" type="submit" name="action">SAVE</button>
                            <button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal_user_academic_bg').modal('close'); return false;"  >CLOSE</button>
                        </div>
                        <div class="col s12 spacer"></div>
                    </div>

                    {{csrf_field()}}

                </div>

            </form>

        </div>

    </div>
</div>