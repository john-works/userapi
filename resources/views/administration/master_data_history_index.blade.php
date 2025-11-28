@extends('layouts.app')
@section('title') Administration - Master Data History @endsection
@section('content')
    <div class="page-header">
        <h1>
            Administration
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Master Data History
            </small>
        </h1>
    </div>
    <div class="form-actions no-margin-bottom">
        <div class="float-alert center">
            <div class="float-alert-container">
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <table class="data-table master_data_history table table-striped table-bordered table-hover no-margin-bottom no-border-top hide_first_column" >
        <thead>
        <tr>
            <th ></th>
            <th style="vertical-align: top;width: 13%">Parent Master Data Type</th>
            <th style="vertical-align: top;width: 13%">Master Data Type</th>
            <th style="vertical-align: top">Action Type</th>
            <th style="vertical-align: top">Action User</th>
            <th style="vertical-align: top">Action Date</th>
            <th style="vertical-align: top">Old Value</th>
            <th style="vertical-align: top">New Value</th>
            <th style="vertical-align: top; width: 4%"></th>
        </tr>
        </thead>
    </table>
@endsection

