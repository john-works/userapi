<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body smaller_accordions">
                    {{-- accordion container start --}}
                    <div id="accordion_main_container" class="accordion-style1 panel-group accordion-style2 management_letter_accordion">
                        <!--# Panel 1 -->
                        <div class="panel panel-default">
                            <div class="panel-collapse" id="according_child_1" aria-expanded="false">
                                <div class="panel-body">
                                    {{-- center this button --}}
                                    <div class="text-center mb-3">
                                        <a title="Add a Booking" class="mt-2 btn btn-primary btn-sm clarify_secondary" href="{{ route('bookings.create','action_log_admins') }}">
                                            Add Booking
                                        </a>
                                    </div>
                                    {{-- clear floats --}}
                                    <div class="clearfix"></div>
                                    {{-- bookings table --}}
                                    <table class="data-table bookings table table-striped table-bordered table-hover no-margin-bottom no-border-top hide-first-column mt-3" id="bookings">
                                        <thead style="background: #cecece" >
                                        <th></th>
                                        <th style="width:35%">Purpose</th>
                                        <th style="width:10%">Starting From</th>
                                        <th style="width:10%">Ending On</th>
                                        <th style="width:10%">Internal Participants</th>
                                        <th style="width:10%">External Participants</th>
                                        <th></th>
                                        </thead>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
