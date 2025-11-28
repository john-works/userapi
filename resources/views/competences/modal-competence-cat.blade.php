<div id="modal_competence_cat" class="modal custom-fields modal-for-ajax-data modal-70-fixed">

    <div class="modal-content">

        <div  class="col s12">

            <form class="col s12" id="form_modal_competence_cat" method="post" action="{{route('admin.competence-categories.save')}}">

                {{-- Start : Hidden fields that hold required data --}}
                <input id="created_by" name="created_by" type="text" hidden value="{{$user->username}}">
                {{-- End   : Hidden fields that hold required data --}}

                <div class="form-container">

                    <h5 class="center timo-primary-text">Competence Category</h5>
                    <div class="col s12 spacer"></div>
                    <div class="row spacer-bottom">
                        <div class="col m6 offset-m3 l6 offset-l3 s12">
                            <label class="display-block" for="org_code">Organization</label>
                            <select name="org_code" required class="browser-default timo-select">
                                <option value="" disabled selected>Choose Organization</option>
                                @if(isset($organizations) && count($organizations) > 0)
                                    @foreach($organizations as $org)
                                        <option @if($org->name == 'PPDA') selected @endif value="{{$org->orgCode}}">{{$org->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="row spacer-bottom">
                        <div class="col m6 offset-m3 l6 offset-l3 s12">
                            <label class="display-block" for="org_code">Employee Category</label>
                            <select name="employee_category_code" required class="browser-default timo-select">
                                <option value="" disabled selected>Choose Employee Category</option>
                                @if(isset($employeeCategories) && count($employeeCategories) > 0)
                                    @foreach($employeeCategories as $empCategory)
                                        <option value="{{$empCategory->categoryCode}}">{{$empCategory->category}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col m6 offset-m3 l6 offset-l3 s12">
                            <input id="competence_category" name="competence_category" type="text" class="validate" required value="{{old('competence_category')}}">
                            <label for="competence_category">Competence Category</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col m6 offset-m3 l6 offset-l3 s12">
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