<div id="modal_competence_cat_edit" class="modal custom-fields modal-for-ajax-data modal-70-fixed">

    <div class="modal-content">

        <div  class="col s12">

            <form class="col s12" id="form_modal_competence_cat_edit" method="post" action="{{route('admin.competence-categories.update')}}">

                {{-- Start : Hidden fields that hold required data --}}
                <input id="created_by_edit" name="created_by" type="text" hidden value="{{$user->username}}">
                <input id="record_id_edit" name="record_id" type="text" hidden value="">
                {{-- End   : Hidden fields that hold required data --}}

                <div class="form-container">

                    <h5 class="center timo-primary-text">Competence Category</h5>
                    <div class="col s12 spacer"></div>
                    <div class="row">
                        <div class="input-field col m6 offset-m3 l6 offset-l3 s12">
                            <select id="org_code_edit" name="org_code" required class="validate">
                                <option value="" disabled>Choose Organization</option>
                                @if(isset($organizations) && count($organizations) > 0)
                                    @foreach($organizations as $org)
                                        <option value="{{$org->orgCode}}">{{$org->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label for="org_code" >Organization</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col m6 offset-m3 l6 offset-l3 s12">
                            <select id="employee_category_code_edit" name="employee_category_code" required class="validate">
                                <option value="" disabled >Choose Employee Category</option>
                                @if(isset($employeeCategories) && count($employeeCategories) > 0)
                                    @foreach($employeeCategories as $empCategory)
                                        <option value="{{$empCategory->categoryCode}}">{{$empCategory->category}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label for="org_code" >Employee Category</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col m6 offset-m3 l6 offset-l3 s12">
                            <input id="competence_category_edit" name="competence_category" type="text" class="validate" required value="{{'.'}}">
                            <label for="competence_category" class="active">Competence Category</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col m6 offset-m3 l6 offset-l3 s12">
                            <input id="max_rating_edit" name="max_rating" type="text" class="validate" required value="{{'.'}}">
                            <label for="max_rating" class="active">Maximum Rating</label>
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
                            <button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal_competence_cat_edit').modal('close'); return false;"  >CLOSE</button>
                        </div>
                        <div class="col s12 spacer"></div>
                    </div>

                    {{csrf_field()}}

                </div>

            </form>

        </div>

    </div>
</div>