<div id="trusted_device_status">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body smaller_accordions">

                    @if(!isset($trustedDevice))

                        {{-- No trusted device show option to add it --}}
                        <div class="row">

                            <div class="col-md-12 center error" style="padding: 10px">
                                {{strtoupper($msg)}}
                            </div>

                            <div class="col-md-12 center" style="margin: 20px 0px">
                                <a title="Set Trusted Device" class="btn btn-minier um-primary-bg clarify_secondary link-trust-device-set" href="{{route('trusted-devices.set-confirm',['PARAM_BROWSER_NAME'])}}">Set Trusted Device</a>
                            </div>

                        </div>

                    @else

                        {{-- trusted device exists, show it's details --}}
                        {{-- accordion container start --}}
                        <div id="accordion_main_container" class="accordion-style1 panel-group accordion-style2 management_letter_accordion">

                            <!--# Panel 1 -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle " data-parent="#accordion_main_container" href="#!" aria-expanded="false">
                                            Trusted Device Details
                                        </a>
                                    </h4>
                                </div>

                                <div class="panel-collapse" id="according_child_1" aria-expanded="false">
                                    <div class="panel-body">

                                        <div class="" style="width: 100%">
                                            <table class="data-table trusted_devices_details {{$trustedDevice->id}} table table-striped table-bordered table-hover no-margin-bottom no-border-top hide-first-column" id="out_of_office_assigned_by_me">
                                                <thead style="background: #cecece" >
                                                <th></th>
                                                <th>User Name</th>
                                                <th>Device Name</th>
                                                <th>Device IP</th>
                                                <th>Browser</th>
                                                <th>Status</th>
                                                <th>Last Action</th>
                                                <th>Last Action User</th>
                                                <th>Last Action Date</th>
                                                <th></th>
                                                </thead>
                                            </table>
                                        </div>

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
