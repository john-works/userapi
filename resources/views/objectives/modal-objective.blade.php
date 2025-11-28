<div id="modal_objective" class="modal custom-fields modal-for-ajax-data">

    <div class="modal-content">

        <div  class="col s12">

            <form class="col s12" id="form_modal_objective" method="post" action="{{route('admin.strategic-objectives.save')}}">

                {{-- Start : Hidden fields that hold required data --}}
                <input id="created_by" name="created_by" type="text" hidden value="{{$user->username}}">
                {{-- End   : Hidden fields that hold required data --}}

                <div class="form-container">

                    <div class="center timo-form-headers">Strategic Objectives</div>
                    <div class="col s12 spacer"></div>
                    <div class="row">
                        <div class="col m6 s12">
                            <label for="organization" class="display-block">Organization</label>
                            <select style="width: 98%" name="organization" required class="browser-default">
                                <option value="" disabled selected>Choose Organization</option>
                                @if(isset($organizations) && count($organizations) > 0)
                                    @foreach($organizations as $org)
                                        <option @if($org->name == 'PPDA') selected @endif  value="{{$org->orgCode}}">{{$org->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="row spacer-top">
                        <div class="input-field col s12">
                            <input id="objective" name="objective" type="text" class="validate" required value="{{old('objective')}}">
                            <label for="objective">Strategic Objective</label>
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

                    <div class="row row-custom-modal-footer spacer-bottom">
                        <div class="col s12 spacer-small"></div>
                        <div class="col s12">
                            <button class="modal-action right btn-flat waves-effect waves-light camel-case waves-green" type="submit" name="action">SAVE</button>
                            <button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal_objective').modal('close'); return false;"  >CLOSE</button>
                        </div>
                        <div class="col s12 spacer"></div>
                    </div>

                    {{csrf_field()}}

                </div>

            </form>

        </div>

    </div>
</div>