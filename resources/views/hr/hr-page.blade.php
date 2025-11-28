@extends('layouts.master')
@section('title')
{{config('app.name')}} | Human Resource
@endsection

@section('page-level-css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('pixinvent/app-assets/vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('pixinvent/app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('pixinvent/app-assets/vendors/data-tables/css/select.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('pixinvent/app-assets/css/data-tables.css')}}">
@endsection

@section('content')
<header>
    @include('includes.nav-bar-general')
</header>
<main class="container">

    <div class="row">
        <div class="col s12">
            <ul class="tabs blue darken-1">
                <li class="tab col m3 "><a class="white-text active camel-case" href="#tab_contracts">Employee Contracts</a></li>
                <li class="tab col m3"><a  class="white-text camel-case" href="#tab_appraisals">Completed Appraisals</a></li>
            </ul>
        </div>
    </div>

    <div id="tab_contracts" class="row ">

        <div  class="col s12">
            <div class="card">
                <div class="card-content">
                    <div class="row" style="margin-bottom: 5px">
                        <div class="col s6">
                            <h5 class="card-title grey-text text-darken-1">Employee Contracts</h5>
                        </div>
                        <div class="col s6"></div>
                    </div>
                    <div class="hr-dotted spacer-bottom"></div>
                    <div class="row">

                        <div class="col s12">
                            <table id="page-length-option"  class="display responsive-table table-tiny-text">
                                <thead>
                                <tr class="timo-table-headers">
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 15%;">Username</th>
                                    <th style="width: 15%;">Employee Name</th>
                                    <th style="width: 10%;">Region</th>
                                    <th style="width: 20%;">Department</th>
                                    <th style="width: 10%;">Designation</th>
                                    <th style="width: 10%;">Contract Start Date</th>
                                    <th style="width: 10%;">Contract End Date</th>
                                    <th style="width: 5%">History</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(isset($users) && count($users) > 0)
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$user->username}}</td>
                                            <td>{{$user->fullName}}</td>
                                            <td>{{$user->regionalOfficeName}}</td>
                                            <td>{{$user->departmentName}}</td>
                                            <td>{{$user->designation}}</td>
                                            <td>{{$user->contractStartDate}}</td>
                                            <td>{{$user->contractExpiryDate}}</td>
                                            <td><a data-source="{{route('human-resource.user-contracts',[$user->username])}}" class="red-text modal-trigger hr-emp-details-button" id="{{$user->username}}" href="#modal_hr_contract_history"><i class="material-icons center">history</i></a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="center">No Users Founds</td>
                                    </tr>
                                @endif

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="tab_appraisals" class="row ">

        <div  class="col s12">
            <div class="card">
                <div class="card-content">
                    <div class="row" style="margin-bottom: 5px">
                        <div class="col s6">
                            <h5 class="card-title grey-text text-darken-1">Completed Appraisals</h5>
                        </div>
                        <div class="col s6"></div>
                    </div>
                    <div class="hr-dotted spacer-bottom"></div>
                    <div class="row">

                        <div class="col l12 s12">
                            <table id="#page-length-option-a"  class="bordered display table-tiny-text">
                                <thead class="timo-table-headers">
                                <tr>
                                    <th style="width:3%">#</th>
                                    <th style="width:23%">Appraisal</th>
                                    <th style="width:15%">Employee Name</th>
                                    <th style="width:10%">Appraisal Type</th>
                                    <th style="width:10%">Start Date</th>
                                    <th style="width:10%">End Date</th>
                                    <th style="width:8%">Supervisor Approval Date</th>
                                    <th style="width:8%">HOD Approval Date</th>
                                    <th style="width:8%">ED Approval Date</th>
                                    <th data-orderable="false" style="width:5%">Pdf</th>

                                </tr>
                                </thead>
                                <tbody>

                                @if(isset($appraisals) && count($appraisals) > 0)
                                    @foreach($appraisals as $appraisal)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$appraisal->generatedPdfName}}</td>
                                            <td>{{$appraisal->personalInfo->firstName .' '. $appraisal->personalInfo->lastName}}</td>
                                            <td>{{'Annual'}}</td>
                                            <td>{{$appraisal->personalInfo->appraisalPeriodStartDate}}</td>
                                            <td>{{$appraisal->personalInfo->appraisalPeriodEndDate}}</td>
                                            <td>{{$appraisal->supervisorActionDate}}</td>
                                            <td>{{$appraisal->deptHeadActionDate}}</td>
                                            <td>{{$appraisal->executiveDirectorActionDate}}</td>
                                            <td><a class="red-text modal-trigger edit-button" href="{{$appraisal->pdfDownloadLink}}"><i class="material-icons center">insert_drive_file</i></a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="10" class="center">No Completed Appraisals Found</td>
                                    </tr>
                                @endif

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@include('hr.modal-hr-contract-history')

{{-- Message modal --}}
@if(isset($msg) && isset($isError))
    @include('includes.modal-message')
@endif
</main>
@endsection

@section('page-level-js')

    <script src="{{ URL::asset('pixinvent/app-assets/vendors/data-tables/js/jquery.dataTables.min.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('pixinvent/app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('pixinvent/app-assets/vendors/data-tables/js/dataTables.select.min.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('pixinvent/app-assets/js/scripts/data-tables.js')}}" type="text/javascript"></script>

@endsection