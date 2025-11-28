@extends('layouts.app')
@section('title') Master Data @endsection
@section('content')
    <div class="page-header">
        <h1>
            Master Data
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Details
            </small>
        </h1>
    </div>

    <div class="tabbable master_data">
        @include('master_data.menu')
        <div class="tab-content">
        </div>
    </div>
@endsection