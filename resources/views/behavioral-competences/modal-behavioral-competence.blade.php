<div id="modal_competence" class="modal custom-fields modal-for-ajax-data">

    <div class="modal-content">

        <div  class="col s12">

            <form class="col s12" id="form_modal_competence" method="post" action="{{route('admin.behavioral-competences.save')}}">

                {{-- Start : Hidden fields that hold required data --}}
                <input id="created_by" name="created_by" type="text" hidden value="{{$user->username}}">
                <input id="competence_category_id" name="competence_category_id" type="text" hidden value="{{$competenceCategoryId}}">
                {{-- End   : Hidden fields that hold required data --}}

                <div class="form-container">

                    <h5 class="center timo-primary-text">Competence</h5>
                    <div class="col s12 spacer"></div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="competence" name="competence" type="text" class="validate" required value="{{old('competence')}}">
                            <label for="competence">Competence</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="rating" name="rating" type="text" class="validate" required value="{{old('rating')}}">
                            <label for="rating">Rating</label>
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
                            <button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal_competence').modal('close'); return false;"  >CLOSE</button>
                        </div>
                        <div class="col s12 spacer"></div>
                    </div>

                    {{csrf_field()}}

                </div>

            </form>

        </div>

    </div>
</div>