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

                                    <div class="datatable-no-search datatable-no-paginate" style="width: 100%">
                                        <table class="data-table out_of_office_history_by_me by_me table table-striped table-bordered table-hover no-margin-bottom no-border-top hide-first-column" id="out_of_office_history_assigned_by_me">
                                            <thead style="background: #cecece" >
                                            <th></th>
                                            <th style="width: 20%">User Name</th>
                                            <th style="width: 25%">Title</th>
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
                                        <table class="data-table out_of_office_history_to_me to_me table table-striped table-bordered table-hover no-margin-bottom no-border-top hide-first-column" id="out_of_office_history_assigned_to_me" style="width: 100% !important;">
                                            <thead style="background: #cecece" >
                                            <th></th>
                                            <th style="width: 20%">User Name</th>
                                            <th style="width: 25%">Title</th>
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
