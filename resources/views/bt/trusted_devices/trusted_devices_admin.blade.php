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
                                        User Trusted Devices
                                    </a>
                                </h4>
                            </div>
                            <div class="row">
                                <div class="col-md-12 pt-2" style="margin-bottom: 5px">
                                    <a title="Revoke User Trusted Devices" class="btn btn-minier um-primary-bg clarify_secondary pull-right" href="{{route('trusted-devices.admin.revoke-user')}}">
                                        Revoke User
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                            <div style="width: 100%">
                                <table class="data-table trusted_devices_admin table table-striped table-bordered table-hover no-margin-bottom no-border-top hide-first-column" id="trusted_devise_admin">
                                    <thead>
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

                </div>
            </div>
        </div>
    </div>
</div>
