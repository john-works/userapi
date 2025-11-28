@extends('layouts.master')

@section('title')
    {{config('app.name')}} | HOD Approval
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

    <!-- BEGIN: Page Main-->
    <div class="container" id="main">

        <div class="row spacer-top">

            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <h5 class="card-title grey-text text-darken-1 ">HOD APPROVALS<span class="grey-text text-darken-1 "  style="font-size: small" >&nbsp;Assigned to you</span></h5>
                        <div class="hr-dotted spacer-bottom"></div>
                        <div class="row">

                            <div class="col s12">

                                <table id="page-length-option" class="display responsive-table table-tiny-text">

                                    <thead>
                                    <tr class="timo-table-headers">
                                        <th  style="width: 5%">#</th>
                                        <th  style="width: 35%">Appraisal Name</th>
                                        <th  style="width: 15%">Appraisee Name</th>
                                        <th  style="width: 8%">Supervisor Approval</th>
                                        <th  style="width: 8%">HOD Approval</th>
                                        <th  style="width: 8%">ED Approval</th>
                                        <th  style="width: 16%">Submission Date</th>
                                        <th data-orderable="false"  style="width: 5%">View</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if(isset($appraisals) && count($appraisals)>0)

                                        @foreach($appraisals as $appraisal)

                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$appraisal->generatedPdfName}}</td>
                                                <td>{{$appraisal->user->fullName}}</td>
                                                <td>{{$appraisal->supervisorDecision}}</td>
                                                <td>{{$appraisal->deptHeadDecision}}</td>
                                                <td>{{$appraisal->executiveDirectorDecision}}</td>
                                                <td>{{$appraisal->deptHeadSubmissionDate}}</td>
                                                <td><a href="{{route('appraisal-forms.show',[$appraisal->appraisalRef])}}" class="green-text">View</a></td>
                                            </tr>

                                        @endforeach

                                    @else
                                        <tr>
                                            <td colspan="8" class="center">No Appraisals Found In The System</td>
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

    </div>
    <!-- END: Page Main-->

    {{-- Message modal --}}
    @if(isset($isError) && isset($msg))  @include('includes.modal-message')   @endif

@endsection


@section('page-level-js')

    <script src="{{ URL::asset('pixinvent/app-assets/vendors/data-tables/js/jquery.dataTables.min.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('pixinvent/app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('pixinvent/app-assets/vendors/data-tables/js/dataTables.select.min.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('pixinvent/app-assets/js/scripts/data-tables.js')}}" type="text/javascript"></script>

@endsection
