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
                                        Out of Office History
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse" id="according_child_1" aria-expanded="false">
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-md-12" style="margin-bottom: 5px">
{{--                                            <a title="Out of Office History" class="btn btn-minier um-primary-bg clarify_secondary pull-right" href="{{route('out-of-office.create')}}">View Out of Office History</a>--}}
                                        </div>
                                    </div>

                                    <div class="datatable-no-search- datatable-no-paginate-" style="width: 100%">
                                        <table class="data-table out_of_office_admin_history table table-striped table-bordered table-hover no-margin-bottom no-border-top hide-first-column" id="out_of_office_admin_history">
                                            <thead style="background: #cecece" >
                                            <th></th>
                                            <th>Delegated To Person</th>
                                            <th>Delegated To Title</th>
                                            <th>Delegated By Person</th>
                                            <th>Delegated By Title</th>
                                            <th style="width: 15%">Starting From</th>
                                            <th style="width: 15%">Ending On</th>
{{--                                            <th></th>--}}
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
