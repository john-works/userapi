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
                    <a href="{{ route('shared_resources.create') }}" class="clarify_tertiary btn btn-primary btn-sm" title="Add Shared Resource">Add Shared Resource</a>
                </div>
            </div>
        </div>
     
        <div class="clearfix"></div>
    </div>
        <table class="data-table shared_resources table table-striped table-bordered table-hover no-margin-bottom no-border-top">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
        </div>
    </div>
@endsection
