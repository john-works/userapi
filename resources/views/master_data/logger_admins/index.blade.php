@extends('layouts.app')
@section('title') Master Data @endsection
@section('content')
    <div class="page-header">
        <h1>
            Master Data
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Logger Admins
            </small>
        </h1>
    </div>

    <div class="tabbable master_data">
        @include('master_data.menu')

        <div class="tab-content">
        <div class="form-actions no-margin-bottom">
        <div class="float-alert center">
            <div class="float-alert-container">
                <div class="col-md-12">
                    <a href="{{ route('general_section','logger_admins') }}" class="btn btn-primary btn-sm">Refresh Deparments</a>
                    <hr>
                </div>
            </div>
        </div>
     
        <div class="clearfix"></div>
    </div>
        <table class="data-table logger_admins table table-striped table-bordered table-hover no-margin-bottom no-border-top">
            <thead>
                <tr>
                    <th>Department Code</th>
                    <th>Department Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
        </div>
    </div>
@endsection
