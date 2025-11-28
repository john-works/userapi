@extends('layouts.app')
@section('title') Master Data @endsection
@section('content')
    <div class="page-header">
        <h1>
            Master Data
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Action Log Types
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
                    <button class="btn btn-primary btn-sm" id="reloadCalendars">Refresh Departments</button>
                    <hr>
                </div>
            </div>
        </div>
     
        <div class="clearfix"></div>
    </div>
        <table class="data-table calendar_types table table-striped table-bordered table-hover no-margin-bottom no-border-top">
            <thead>
                <tr>
                    <th>Department Code</th>
                    <th>Department Name</th>
                    <th>Color</th>
                    <th>Background Color</th>
                    <th>Drag Background Color</th>
                    <th>Border Color</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
        </div>
    </div>
@endsection
