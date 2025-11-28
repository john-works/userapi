@extends('layouts.app_public')

@section('title')
    Login
@endsection

@section('content')
<div class="hidden-xs" id="desktop_view">
    <header>
        <div>
            <div class="col-md-12 text-left um-primary-bg">
                <a href="{{ asset('') }}" class="navbar-brand text-white">
                    <small> PPDA Applications </small>
                </a>
                <span class="navbar-brand text-white" id="ajax_test_device" style="display:none">
                    <a  href="{{ route('employee_360_view.index') }}" title="Employee 360 View" id="employee_360_viewer" class="navbar-brand btn btn-minier btn-out-of-office clarify mt-2 pull-right btn_employee_360_viewer">
                        Employee 360
                    </a>
                    <a  href="{{ route('app.usage.report') }}" title="App Usage" id="app_usage" class="navbar-brand btn btn-minier btn-out-of-office clarify mt-2 pull-right btn_app_usage">
                        App Usage
                    </a>
                    <a  href="{{ route('events.department') }}" title="View Calendar" id="trusted_calendar" class="navbar-brand btn btn-minier btn-out-of-office clarify mt-2 pull-right btn_trusted_calendar">
                        View Calendar
                    </a>
                    <a  href="{{route('management-dashboards',['ISADMIN'])}}" title="Exco Dashboards" id="management_dashboard" class="navbar-brand btn btn-minier btn-out-of-office mt-2 pull-right clarify btn_management_dashboard">
                        Exco Dashboards
                    </a>
                    {{-- <a  href="{{route('ed-dashboard')}}" target="_blank" title="ED Dashboard" class="navbar-brand btn btn-minier btn-out-of-office mt-2 pull-right">
                        ED Dashboard
                    </a> --}}
                    <a  href="{{route('my.pending.actions')}}" title="My Pending Actions" id="trusted_user" class="navbar-brand btn btn-minier btn-out-of-office clarify mt-2 pull-right">
                        My Pending Actions
                    </a>
                    <a  href="{{ route('driver_requests.index',['USERNAME']) }}" title="Driver Requests" id="driver_requests_btn" class="navbar-brand btn btn-minier btn-out-of-office clarify mt-2 pull-right driver_requests_btn">
                        Driver Requests
                    </a>
                    <a  href="{{ route('tickets.index',['USERNAME']) }}" title="IT Support Tickets" id="it_tickets" class="navbar-brand btn btn-minier btn-out-of-office clarify mt-2 pull-right">
                        IT Support Tickets
                    </a>
                    <a  href="{{ route('fuel_issues.create',['USERNAME']) }}" title="Fuel Issue Capture" id="fuel_issues" class="navbar-brand btn btn-minier btn-out-of-office clarify mt-2 pull-right btn_fuel_capture">
                        Fuel Issue Capture
                    </a>
                    {{-- <a  href="{{ route('public_holidays.index') }}" title="Get Public Holidays" id="public_holidays" class="navbar-brand btn btn-minier btn-out-of-office clarify_secondary mt-2 pull-right">
                        Get Public Holidays
                    </a> --}}
                </span>
               
                <span class="navbar-brand text-white pull-right" style="font-size: 130%;">
                    <span class="inline pull-left" style="margin-right: 20px;">Quick Links: </span>
                    <a title="Staff Extensions" class="navbar-brand btn btn-minier btn-out-of-office clarify mt-2" href="{{ route('important-contacts') }}">
                        Staff Extensions
                    </a>
                    {{-- <a title="Add Calendar" class="navbar-brand btn btn-minier btn-out-of-office clarify mt-2" href="{{ route('trusted-devices.currentstatus') }}">
                        Trusted Devices
                    </a> --}}
                </span>
            </div>
        </div>
    </header>

    <main >

        <div class="parallax" style="background-image: url({{asset('images/wall_2.jpg')}})">

            <div class="container" >
                <div class="row">
                    <div class="col-md-4 col-md-offset-4 panel" style="margin-top: 8%">

                        <form id="signin_form" class="col-md-12" method="post" action="{{route('signin')}}">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2 center">
                                    <span class="um-primary-text">LOGIN HERE</span>
                                </div>
                                <div class="col-md-12 spacer-small"></div>
                                <div class="col-md-12  divider"></div>
                                <div class="col-md-12  spacer-small"></div>
                                @if(isset($bannerMessage))
                                    <div class="col-md-12 center error" style="font-size: 12px">{{$bannerMessage}}</div>
                                    <div class="col-md-12  spacer-small"></div>
                                @endif
                                <div class="row">
                                    <div class="input-field col-md-8 col-md-offset-2">
                                        <label id="username_login_page_label" @if(!is_null(old('username'))) class="active" @endif for="username_login_page">Username</label>
                                        <input id="username_login_page" name="username" type="text" class="validate fill-parent" value="{{old('username')}}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col-md-8 col-md-offset-2">
                                        <label id="password_login_page_label" for="password">Password</label>
                                        <input id="password" name="password" type="password" class="validate fill-parent" required>
                                    </div>
                                </div>
                                @if(count($errors->all()) > 0)
                                    <div class="row">
                                        <div class="col-md-8 col-md-offset-2 input-field" style="margin-top: 5px">
                                            <ul>
                                                @foreach($errors->all() as $error)
                                                    <li class="invalid">{{$error}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2 center">
                                        <button id="login_button" type="submit" name="action" class="btn camel-case um-primary-bg">Login</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2 center" style="margin-top: 10px;margin-bottom: 10px">
                                        <a title="FORGOT PASSWORD"  class="um-primary-text clarify" href="{{route('user.forgot-password')}}">Forgot Password</a>
                                    </div>
                                </div>
                            </div>
                            {{csrf_field()}}
                        </form>
                    </div>

                </div>
            </div>

        </div>

        {{-- Message modal --}}
        @if(isset($isError) && isset($msg) && count($errors->all()) == 0)  @include('includes.modal-message')   @endif

    </main>
</div>
<div class="visible-xs" id="mobile_view">
    <div class="col-xs-12 login_mobile">
        <!-- Mobile Buttons Row 1 -->
        <div class="row">
            <div class="col-xs-4"><div class="mobile_btn" id="public_holidays_mobile">Get Public Holidays</div></div>
            <div class="col-xs-4"><div class="mobile_btn" id="fuel_issue_mobile">Fuel Issue Capture</div></div>
            <div class="col-xs-4"><div class="mobile_btn" id="it_tickets_mobile">IT Tickets</div></div>
        </div>
        <!-- Mobile Buttons Row 2 -->
        <div class="row" style="margin-top: 10px;">
            <div class="col-xs-4"><div class="mobile_btn" id="driver_requests_mobile">Driver Requests</div></div>
            <div class="col-xs-4"><div class="mobile_btn" id="pending_actions_mobile">My Pending Actions</div></div>
            <div class="col-xs-4"><div class="mobile_btn" id="management_dashboards_mobile">Management Dashboards</div></div>
        </div>
        <!-- Mobile Buttons Row 3 -->
        <div class="row" style="margin-top: 10px;">
            <div class="col-xs-4"><div class="mobile_btn" id="view_calendar_mobile">View Calendar</div></div>
            <div class="col-xs-4"><div class="mobile_btn" id="app_usage_report_mobile">App Usage Report</div></div>
            <div class="col-xs-4"><div class="mobile_btn" id="staff_extensions_mobile">Staff Extensions</div></div>
        </div>
        <div class="mobile-form">
            <h2 class="text-center">Login Here</h2>
            <form id="signin_mobile" class="col-md-12" method="post" action="{{route('signin')}}">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="email">Username</label>
                    <input type="email" class="form-control" id="username_mobile" name="username" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="password_mobile">Password</label>
                    <input type="password" class="form-control" id="password_mobile" name="password" placeholder="Password" required>
                </div>
                @if(count($errors->all()) > 0)
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 input-field" style="margin-top: 5px">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li class="invalid">{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
                <div class="row text-center">
                    <button type="submit" class="btn btn-primary login-btn">Login</button>
                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 center" style="margin-top: 10px;margin-bottom: 10px">
                        <a style="text-decoration: none" title="FORGOT PASSWORD"  class="um-primary-text clarify" href="{{route('user.forgot-password')}}">Forgot Password</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
