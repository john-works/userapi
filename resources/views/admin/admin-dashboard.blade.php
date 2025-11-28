@extends('layouts.master-admin')
@section('title')
    Dashboard | {{config('app.name')}}
@endsection

@section('content')


    <!-- BEGIN: Page Main-->

    <div class="container">


        <!--card stats start-->
        <div id="card-stats">
            <div class="row">
                <div class="col s12 m6 l6 xl3">
                    <div class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text animate fadeLeft">
                        <div class="padding-4">
                            <div class="col s7 m7">
                                <i class="material-icons background-round mt-5">dvr</i>
                                <p>Appraisals</p>
                            </div>
                            <div class="col s5 m5 right-align">
                                <h5 class="mb-0 white-text">{{$appStats->countAppraisalsNew}}</h5>
                                <p class="no-margin">New</p>
                                <p>{{$appStats->countAppraisals}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l6 xl3">
                    <div class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text animate fadeLeft">
                        <div class="padding-4">
                            <div class="col s7 m7">
                                <i class="material-icons background-round mt-5">perm_identity</i>
                                <p>Users</p>
                            </div>
                            <div class="col s5 m5 right-align">
                                <h5 class="mb-0 white-text">{{$appStats->countUsersNew}}</h5>
                                <p class="no-margin">New</p>
                                <p>{{$appStats->countUsers}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l6 xl3">
                    <div class="card gradient-45deg-amber-amber gradient-shadow min-height-100 white-text animate fadeRight">
                        <div class="padding-4">
                            <div class="col s7 m7">
                                <i class="material-icons background-round mt-5">language</i>
                                <p>Reg. Offices</p>
                            </div>
                            <div class="col s5 m5 right-align">
                                <h5 class="mb-0 white-text">{{$appStats->countRegionalOfficesNew}}</h5>
                                <p class="no-margin">New</p>
                                <p>{{$appStats->countRegionalOffices}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l6 xl3">
                    <div class="card gradient-45deg-green-teal gradient-shadow min-height-100 white-text animate fadeRight">
                        <div class="padding-4">
                            <div class="col s7 m7">
                                <i class="material-icons background-round mt-5">group</i>
                                <p>Departments</p>
                            </div>
                            <div class="col s5 m5 right-align">
                                <h5 class="mb-0 white-text">{{$appStats->countDepartmentsNew}}</h5>
                                <p class="no-margin">New</p>
                                <p>{{$appStats->countDepartments}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--card stats end-->


        <!--yearly & weekly revenue chart start-->
        <div id="sales-chart">

            <div class="row">
                <div class="col s12">
                    <div id="revenue-chart" class="card animate fadeUp">
                        <div class="card-content">
                            <h4 class="header mt-0">
                                APPRAISALS FOR THE LAST 2 MONTHS
                                <span class="purple-text small text-darken-1 ml-1">
                     <i class="material-icons">keyboard_arrow_up</i> 15.58 %</span>
                                <a class="waves-effect waves-light btn gradient-45deg-purple-deep-orange gradient-shadow right">Details</a>
                            </h4>
                            <div class="row">
                                <div class="col s12">
                                    <div class="yearly-revenue-chart">
                                        <canvas id="thisYearRevenue" class="firstShadow" height="350"></canvas>
                                        <canvas id="lastYearRevenue" height="350"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--yearly & weekly revenue chart end-->

    </div>

    <!-- END: Page Main-->

@endsection