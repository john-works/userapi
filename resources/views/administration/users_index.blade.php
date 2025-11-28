@extends('layouts.app')
@section('title') Users @endsection
@section('content')
    <div class="page-header">
        <h1>
            Administration
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Users
            </small>
        </h1>
    </div>
    <div class="form-actions no-margin-bottom">
        <div class="float-alert center">
            <div class="float-alert-container">
                <div class="col-md-12">
                    <a href="{{ route('administration.users.create') }}" class="clarify btn btn-primary btn-sm" title="Add User">Add User</a>
                    
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <table class="data-table portal_users table table-striped table-bordered table-hover no-margin-bottom no-border-top hide_first_column" >
        <thead>
        <tr>
            <th ></th>
            <th style="vertical-align: top">First Name</th>
            <th style="vertical-align: top">Last Name</th>
            <th style="vertical-align: top">Username</th>
            <th style="vertical-align: top">Department</th>
            <th style="vertical-align: top">Designation</th>
            <th style="vertical-align: top; width: 4%"></th>
        </tr>
        </thead>
    </table>
@endsection

