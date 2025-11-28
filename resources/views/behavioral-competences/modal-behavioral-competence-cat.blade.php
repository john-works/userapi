<div id="modal_competence_cat" class="modal custom-fields modal-for-ajax-data d">

    <div class="modal-content">

        <div  class="col s12">

            <form class="col s12" id="form_modal_competence_cat" method="post" action="{{route('admin.behavioral-competence-categories.save')}}">

                {{-- Start : Hidden fields that hold required data --}}
                <input id="created_by" name="created_by" type="text" hidden value="{{$user->username}}">
                {{-- End   : Hidden fields that hold required data --}}

                <div class="form-container">

                    <div class="timo-form-headers center">Competence Category</div>
                    <div class="col s12 spacer"></div>

                    <div class="row">
                        <div class="input-field col m8 offset-m2 l8 offset-l2 s12">
                            <input id="competence_category" name="competence_category" type="text" class="validate" required value="{{old('competence_category')}}">
                            <label for="competence_category">Competence Category</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col m8 offset-m2 l8 offset-l2 s12">
                            <input id="max_rating" name="max_rating" type="text" class="validate" required value="{{old('max_rating')}}">
                            <label for="max_rating">Maximum Rating</label>
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
                            <button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal_competence_cat').modal('close'); return false;"  >CLOSE</button>
                        </div>
                        <div class="col s12 spacer"></div>
                    </div>

                    {{csrf_field()}}

                </div>

            </form>

        </div>

    </div>
</div>