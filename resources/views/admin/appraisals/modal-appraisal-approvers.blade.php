<div id="modal_appraisal_approvers" class="modal modal-70">
    <div class="modal-content">

        <div  class="col m6 offset-m3 l6 offset-l3 s12">

            <form class="col s12" id="form_modal_appraisal_approvers" method="post" action="{{route('admin.appraisals.update-approvers')}}">


                <div class="form-container">

                    <h5 class="timo-primary-text center spacer-bottom">APPRAISAL APPROVERS</h5>

                    <div class="row">
                        <div class=" col s12">
                            <label class="display-block" for="hod">Supervisor</label>
                            <select style="width: 98%" name="supervisor" id="supervisor" required class="browser-default ">
                                <option value="" disabled selected>Choose Supervisor</option>
                                @if(isset($users) && count($users) > 0)
                                    @foreach($users as $user)
                                        <option value="{{$user->username}}">{{$user->fullName}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col s12 spacer"></div>
                    </div>

                    <div class="row">
                        <div class=" col s12">
                            <label class="display-block" for="head_of_department">Head of Department</label>
                            <select style="width: 98%" name="hod" id="head_of_department" required class="browser-default ">
                                <option value="" disabled selected>Choose Head of Department</option>
                                @if(isset($users) && count($users) > 0)
                                    @foreach($users as $user)
                                        <option value="{{$user->username}}">{{$user->fullName}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col s12 spacer"></div>
                    </div>

                    <div class="row">
                        <div class=" col s12">
                            <label class="display-block" for="executive_director">Executive Director</label>
                            <select style="width: 98%" name="ed" id="executive_director" required class="browser-default ">
                                <option value="" disabled selected>Choose Executive Director</option>
                                @if(isset($users) && count($users) > 0)
                                    @foreach($users as $user)
                                        <option value="{{$user->username}}">{{$user->fullName}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col s12 spacer"></div>
                    </div>

                    <div class="row">
                        <div class="col s12">
                            {{-- Start : Hidden fields that hold required data --}}
                            <input id="appraisal_ref" name="appraisal_ref" type="text" value="ref"  hidden >
                            <input id="timo" name="timo" type="text" value=""  >
                            {{-- End   : Hidden fields that hold required data --}}
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
                            <button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal_appraisal_approvers').modal('close'); return false;"  >CLOSE</button>
                            <button class="modal-action right btn-flat waves-effect waves-light camel-case waves-green" type="submit" name="action">UPDATE</button>
                        </div>
                        <div class="col s12 spacer"></div>
                    </div>

                    {{csrf_field()}}

                </div>

            </form>

        </div>

    </div>
</div>
