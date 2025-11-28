<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body smaller_accordions">

                    {{-- accordion container start --}}
                    <div id="accordion_main_container" class="accordion-style1 panel-group accordion-style2 management_letter_accordion">

                        <!--# Panel 1 -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle " data-parent="#accordion_main_container" href="#!" aria-expanded="false">
                                        Action History
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse" id="according_child_1" aria-expanded="false">
                                <div class="panel-body">

                                    <div class="" style="width: 100%">
                                        <table class="data-table trusted_devices_action_history {{$deviceId}} table table-striped table-bordered table-hover no-margin-bottom no-border-top hide-first-column" id="trusted_devices_action_history">
                                            <thead style="background: #cecece" >
                                            <th></th>
                                            <th style="width: 25%">Action</th>
                                            <th>Action User</th>
                                            <th style="width: 20%">Action Date</th>
                                            <th>Comment</th>
                                            </thead>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    {{-- accordion container end --}}

                </div>
            </div>
        </div>
    </div>
</div>
