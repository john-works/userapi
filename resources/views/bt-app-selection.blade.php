
@extends('layouts.app_public')
@section('title') App Selection @endsection
@section('no-cache')
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>
@endsection
@section('page-level-css')@endsection
@section('page-level-js')@endsection
@section('content')
    <header>
        @include('includes.navbar_guest',['appSelection'=>'yes'])
    </header>
    <main >
        @php
            $this_user = getAuthUser();
        @endphp
        <div class="parallax" style="background:  url({{asset('images/wall_2.jpg')}})">
            <div class="container" >
                <div class="row" style="margin-top: 16%">
                   <div class="col-md-6 col-md-offset-3 center ">
                       <div class="text-white timo-transparent-bg">
                           <h6>Welcome @if(session()->has('user')){{strtoupper(session('user')->fullName)}}@else{{'USER'}}@endif, Please Select the Application You Want To Access</h6>
                       </div>
                   </div>
                </div>
                <div class="row pt-20">
                    <div  style="padding-top: 20px; background-color: #cecece; margin-left: 10px;margin-right: 20px" class="col-md-12 card timo-grey-text">
                        @if($this_user->designationId != 65)
                            <div class="col-md-2 center col-md-offset-1-">
                                <div class="text-center">
                                    <h5 class="tt-headline loading-bar">
                                        <a href="#">
                                            <span class="um-primary-text">
                                                <b>Staff</br>Appraisal</b>
                                            </span>
                                        </a>
                                    </h5>
                                    <a style="width: 90%" class="btn camel-case waves-effect waves-light um-primary-bg" href="{{route('users.access-app',['staff-appraisal'])}}">Access Application</a>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-2 center">
                            <div class="text-center">
                                <h5 class="tt-headline">
                                    <span class="um-primary-text"><b>Entity</br> Management System</b></span>
                                </h5>
                                <a style="width: 90%" class="btn camel-case waves-effect waves-light um-primary-bg" href="{{route('users.access-app',['emis'])}}">Access Application</a>
                            </div>
                        </div>
                        <div class="col-md-2 center">
                            <div class="text-center">
                                <h5 class="tt-headline">
                                    <span class="um-primary-text"><b>Letter</br>Movement</b></span>
                                </h5>
                                <a style="width: 90%" class="btn camel-case waves-effect waves-light um-primary-bg" href="{{route('users.access-app',['letter-movement'])}}">Access Application</a>
                            </div>
                        </div>
                        @if($this_user->designationId != 65)
                            <div class="col-md-2 center">
                                <div class="text-center">
                                    <h5 class="tt-headline">
                                        <span class="um-primary-text"><b>Fleet Management</br>System</b></span>
                                    </h5>
                                    <a style="width: 90%" class="btn camel-case waves-effect waves-light um-primary-bg" href="{{route('users.access-app',['dms'])}}">Access Application</a>
                                </div>
                            </div>
                            <div class="col-md-2 center">
                                <div class="text-center">
                                    <h5 class="tt-headline">
                                        <span class="um-primary-text"><b>Leave</br>Management</b></span>
                                    </h5>
                                    <a style="width: 90%" class="btn camel-case waves-effect waves-light um-primary-bg" href="{{route('users.access-app',['leave-management'])}}">Access Application</a>
                                </div>
                            </div>
                            <div class="col-md-2 center">
                                <div class="text-center">
                                    <h5 class="tt-headline">
                                        <span class="um-primary-text"><b>Action Log</br>&nbsp;</b></span>
                                    </h5>
                                    <a style="width: 90%" class="btn camel-case waves-effect waves-light um-primary-bg" href="{{route('actionlogs',MENU_ITEM_ACTIONLOGS_MY_ACTION)}}">Access Application</a>
                                </div>
                            </div>
                    </div>
                    <div  style="padding-top: 40px; padding-bottom: 30px; background-color: #cecece; margin-left: 10px;margin-right: 20px" class="col-md-12 card timo-grey-text">
                        <div class="col-md-2 center">
                            <div class="text-center">
                                <h5 class="tt-headline">
                                    <span class="um-primary-text"><b>Stores</b></span>
                                </h5>
                                <a style="width: 90%" class="btn camel-case waves-effect waves-light um-primary-bg" href="{{route('users.access-app',['stores'])}}">Access Application</a>
                            </div>
                        </div>
                        @if(getAuthUser() != null)
                        @if(getAuthUser()->is_admin == 1)
                            <div class="col-md-2 center">
                                <div class="text-center">
                                    <h5 class="tt-headline">
                                        <span class="um-primary-text"><b>Employee Lifecycle</b></span>
                                    </h5>
                                    <a style="width: 90%" class="btn camel-case waves-effect waves-light um-primary-bg" href="{{route('users.access-app',['employee-lifecycle'])}}">Access Application</a>
                                </div>
                            </div>

                            <div class="col-md-2 center">
                                <div class="text-center">
                                    <h5 class="tt-headline">
                                        <span class="um-primary-text"><b>Recruitment</b></span>
                                    </h5>
                                    <a style="width: 90%" class="btn camel-case waves-effect waves-light um-primary-bg" href="{{route('users.access-app',['recruitment'])}}">Access Application</a>
                                </div>
                            </div>
                        @endif
                    @endif
                @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
    {{-- Message modal --}}
    @if(isset($isError) && isset($msg))
        @include('includes.modal-message')
    @endif
@endsection
