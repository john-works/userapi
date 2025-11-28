<div  class="col s12">

    <form class="col s12 ajax-created-form" id="form_modal_user_academic_bg" method="post" action="{{route('users.academic-bg-update')}}">

        {{-- Start : Hidden fields that hold required data --}}
        <input id="username" name="username" type="text" hidden value="{{$user->username}}">
        <input id="record_id" name="record_id" type="text" hidden value="{{$academicBg->id}}">
        {{-- End   : Hidden fields that hold required data --}}

        <div class="form-container">

            <h5 class="">Academic Background</h5>

            <div class="row">
                <div class="input-field col s12">
                    <input id="institution" name="institution" type="text" class="validate " required value="{{$academicBg->institution}}">
                    <label for="institution" class="active">School</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                    <input id="year_of_study" name="year_of_study" type="text" class="validate" required value="{{$academicBg->yearOfStudy}}">
                    <label for="year_of_study" class="active">Year of Study</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                    <input id="award" name="award" type="text" class="validate" required value="{{$academicBg->award}}">
                    <label for="award" class="active">Award</label>
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
                    <button class="modal-action right btn-flat waves-effect waves-light camel-case waves-green" type="submit" name="action">UPDATE</button>
                    <button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal_academic_bg').modal('close'); return false;"  >CLOSE</button>
                </div>
                <div class="col s12 spacer"></div>
            </div>

            {{csrf_field()}}

        </div>

    </form>

</div>