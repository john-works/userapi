<div id="trusted_user_status">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body smaller_accordions">
                    @if(!isset($username))
                        {{-- No trusted user show option to add it --}}
                        <div class="row">

                            <div class="col-md-12 center error" style="padding: 10px">
                                {{strtoupper($msg)}}
                            </div>

                            <div class="col-md-12 center" style="margin: 20px 0px">
                                <a title="Set Trusted User" class="btn btn-minier um-primary-bg clarify_secondary link-trust-user-set" href="{{route('trusted-users.set-confirm',['PARAM_BROWSER_NAME'])}}">Set Trusted User</a>
                            </div>
                        </div>
                    @else
                        <div id="accordion_main_container" class="accordion-style1 panel-group accordion-style2 management_letter_accordion">
                            <!--# Panel 1 -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle " data-parent="#accordion_main_container" href="#!" aria-expanded="false">
                                            User Tasks
                                        </a>
                                    </h4>
                                </div>
                                <div class="panel-body">
                                    <div class="" style="width: 100%">
                                        <table class="data-table trusted_user_action_logs {{$username}} table table-striped table-bordered table-hover no-margin-bottom no-border-top hide-first-column" id="out_of_office_assigned_by_me">
                                            <thead style="background: #cecece" >
                                                <th>Required Action</th>
                                                <th>Date Created</th>
                                                <th>Action Log Type</th>
                                                <th>Responsible Department</th>
                                                <th>Responsible Person</th>
                                                <th>Status</th>
                                                <th>Next Action User</th>
                                                <th>Next Action</th>
                                                <th>Next Action Date</th>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- accordion container end --}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
