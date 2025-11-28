@extends('layouts.app')
@section('title')
    Action Logs
@endsection
@section('content')
<?php
    $board = 'Board';
    $exco = 'Exco';
    $all = 'All';
?>
<div class="page-header">
    <h1>
        Action Log
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Action Logs (@if($menu_selected == MENU_ITEM_ACTIONLOGS_MY_DEPARTMENT){{session('user')->departmentName}}
            @elseif($menu_selected == MENU_ITEM_ACTIONLOGS_MY_ACTION)Pending My Action
                @elseif($menu_selected == MENU_ITEM_ACTIONLOGS_BOARD){{$board}}
                @elseif ($menu_selected == MENU_ITEM_ACTIONLOGS_EXCO){{$exco}}
                @else{{$all}}@endif)
        </small>
    </h1>
</div>
<div class="form-actions no-margin-bottom">
    <div class="float-alert center">
        <div class="float-alert-container">
            <div class="col-md-12">
                @if ($menu_selected == MENU_ITEM_ACTIONLOGS_MY_ACTION)
                @else
                <a href="{{ route('actionlogs.create',$menu_selected) }}" class="clarify btn btn-primary btn-sm" title="Add Action Log">Add Action Log</a>
                @endif
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<table class="data-table actionlogs {{$menu_selected}} table table-striped table-bordered table-hover no-margin-bottom no-border-top hide-first-column">
    <thead>
        <tr>
            <th>Date Opened</th>
            <th>Reference Number</th>
            <th>Required Action</th>
            <th>Action Log Type</th>
            <th>Responsible Department</th>
            <th>Responsible Person</th>
            <th>Status</th>
            <th>Last Status Update</th>
            {{-- <th>Next Action User</th>
            <th>Next Action</th>
            <th>Next Action Date</th> --}}
            <th>Actions</th>
        </tr>
    </thead>
</table>
@endsection