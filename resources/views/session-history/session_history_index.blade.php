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
                                        Front End Cookie
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse" id="according_child_1" aria-expanded="false">
                                <div class="panel-body" >

                                    @if(isset($frontEndCookieTrustedDevice))

                                        <div class="row">

                                            {{-- Trusted Device as in Cookie --}}
                                            <div class="col-md-6">
                                                <div style="font-weight: bold;margin-bottom: 10px;text-decoration: underline">Trusted Device in Front End Cookie</div>
                                                <?php
                                                    $deviceDetails =array(
                                                        'username' => @$frontEndCookieTrustedDevice->username,
                                                        'deviceId' => @$frontEndCookieTrustedDevice->deviceId,
                                                        'deviceName' => @$frontEndCookieTrustedDevice->deviceName,
                                                        'browser' => @$frontEndCookieTrustedDevice->browser,
                                                        'dateTimeCreated' => @$frontEndCookieTrustedDevice->dateTimeCreated,
                                                    );
                                                ?>
                                                @include('session-history.session_history_trusted_device_fields', $deviceDetails)
                                            </div>

                                            {{-- Trusted Device as in DB --}}
                                            <div class="col-md-6" style="border-left: 1px #cecece dotted">
                                                <div style="font-weight: bold;margin-bottom: 10px;text-decoration: underline">Trusted Device in DB</div>
                                                <?php
                                                $deviceDetails =array(
                                                    'username' => @$dbTrustedDevice->username,
                                                    'deviceId' => @$dbTrustedDevice->id,
                                                    'deviceName' => @$dbTrustedDevice->device_name,
                                                    'browser' => @$dbTrustedDevice->browser,
                                                    'dateTimeCreated' => @$dbTrustedDevice->created_at,
                                                );
                                                ?>
                                                @include('session-history.session_history_trusted_device_fields', $deviceDetails)
                                            </div>
                                        </div>


                                    @else
                                        <div class="row">
                                            <div class="col-md-12 center">No Front End Cookie</div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>

                        <!--# Panel 2 -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle " data-parent="#accordion_main_container" href="#!" aria-expanded="false">
                                        Session History in DB
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse" id="according_child_2" aria-expanded="false">
                                <div class="panel-body">

                                    <div class="datatable-no-search datatable-no-paginate" style="width: 100%">
                                        <table class="data-table session_history_for_user table table-striped table-bordered table-hover no-margin-bottom no-border-top hide-first-column" id="session_history_for_user" style="width: 100% !important;">
                                            <thead style="background: #cecece" >
                                                <th></th>
                                                <th>Application</th>
                                                <th style="width: 20%">Session Creation Date</th>
                                                <th style="width: 10%">Session Duration</th>
                                                <th style="width: 20%">Session Expiry Date</th>
                                                <th style="width: 10%">Trusted Device ID</th>
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
