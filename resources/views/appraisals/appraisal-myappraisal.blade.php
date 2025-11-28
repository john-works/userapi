@extends('layouts.master')

@section('title')
    {{config('app.name')}} | My Appraisals
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
                        <div class="row" style="margin-bottom: 5px">
                            <div class="col s6">
                                <h5 class="card-title grey-text text-darken-1 ">APPRAISALS<span class="grey-text text-darken-1 "  style="font-size: small" >&nbsp;initiated by you</span></h5>
                            </div>
                            <div class="col s6">
                                <a class="btn blue darken-4 right camel-case" href="{{route('create_appraisal')}}">Create New Appraisal Form</a>
                            </div>
                        </div>
                        <div class="hr-dotted spacer-bottom"></div>
                        <div class="row">

                            <div class="col s12">

                                <table id="page-length-option" class="display responsive-table">

                                    <thead>
                                    <tr class="timo-table-headers">
                                        <th style="width: 5%">#</th>
                                        <th style="width: 44%">Appraisal Name</th>
                                        <th style="width: 15%">Status</th>
                                        <th style="width: 7%">Supervisor Approval</th>
                                        <th style="width: 7%">HOD Approval</th>
                                        <th style="width: 7%">ED Approval</th>
                                        <th style="width: 10%">Date Created</th>
                                        <th data-orderable="false" style="width: 5%">View</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if(isset($appraisals) && count($appraisals)>0)

                                        @foreach($appraisals as $appraisal)

                                            <tr @if($appraisal->isRejected)class="red-text text-darken-2"@endif>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$appraisal->generatedPdfName}}</td>
                                                <td>{{$appraisal->simpleStatus}}</td>
                                                <td>{{$appraisal->supervisorDecision}}</td>
                                                <td>{{$appraisal->deptHeadDecision}}</td>
                                                <td>{{$appraisal->executiveDirectorDecision}}</td>
                                                <td>{{$appraisal->createdAt}}</td>
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
