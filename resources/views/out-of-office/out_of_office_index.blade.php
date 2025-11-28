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
                                        My Delegation to Other People
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse" id="according_child_1" aria-expanded="false">
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-md-12" style="margin-bottom: 5px">
                                            <a title="Add Out of Office" class="btn btn-minier um-primary-bg clarify_secondary pull-right" href="{{route('out-of-office.create')}}">Add Out of Office</a>
                                            <a title="My Out of Office History" class="btn btn-minier um-primary-bg clarify_secondary pull-right mr-5" href="{{route('out-of-office.owner.history')}}">My Out of Office History</a>
                                        </div>
                                    </div>

                                    <div class="datatable-no-search datatable-no-paginate" style="width: 100%">
                                        <table class="data-table out_of_office_records table table-striped table-bordered table-hover no-margin-bottom no-border-top hide-first-column" id="out_of_office_assigned_by_me">
                                            <thead style="background: #cecece" >
                                            <th></th>
                                            <th>User Name</th>
                                            <th>Title</th>
                                            <th style="width: 23%">Starting From</th>
                                            <th style="width: 23%">Ending On</th>
                                            <th></th>
                                            </thead>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!--# Panel 2 -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle " data-parent="#accordion_main_container" href="#!" aria-expanded="false">
                                        Other Peoples Delegation to Me
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse" id="according_child_2" aria-expanded="false">
                                <div class="panel-body">

                                    <div class="datatable-no-search datatable-no-paginate" style="width: 100%">
                                        <table class="data-table out_of_office_records_assigned_to_me table table-striped table-bordered table-hover no-margin-bottom no-border-top hide-first-column" id="out_of_office_records_assigned_to_me" style="width: 100% !important;">
                                            <thead style="background: #cecece" >
                                            <th></th>
                                            <th>User Name</th>
                                            <th>Title</th>
                                            <th style="width: 23%">Starting From</th>
                                            <th style="width: 23%">Ending On</th>
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
