
@extends('layouts.master')
@section('title')
    PPDA Applications | App Selection
@endsection

@section('no-cache')
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>
@endsection

@section('page-level-css')
@endsection

@section('page-level-js') @endsection

@section('content')
    <header>
        @include('includes.navbar_guest',['appSelection'=>'yes'])
    </header>

    <main >

        <div class="parallax-container">
            <div class="container " style="margin-top: 12%" >

               <div class="row">
                   <div class="col l6 offset-l3 m6 offset-m3 s12 center ">
                       <div class=" white-text timo-transparent-bg">
                           <h6>Welcome @if(session()->has('user')){{strtoupper(session('user')->fullName)}}@else{{'USER'}}@endif, Please Select the Application You Want To Access</h6>
                       </div>
                   </div>
               </div>

                <div class="row padding-top-180">
                    <div  style="padding: 30px; background-color: #cecece; margin-left: 10px;margin-right: 20px" class="col card  m12 s12 timo-grey-text ">

                        <div class="col center m3">
                        <div class="text-center">
                            <h5 class="tt-headline loading-bar">
                                <span class="tt-words-wrapper timo-primary-text"> <b>Staff</br>Appraisal</b> </span>
                            </h5>
                            <a style="width: 90%" class="spacer-top btn camel-case mt-30 waves-effect waves-light timo-primary" href="{{route('users.access-app',['staff-appraisal'])}}">Access Application</a>
                        </div>
                        </div>

                        <div class="col center m3">
                            <div class="text-center">
                                <h5 class="tt-headline">
                                    <span class="tt-words-wrapper timo-primary-text"><b>Entity Management System</b></span>
                                </h5>
                                <a style="width: 90%" class="spacer-top btn camel-case mt-30 waves-effect waves-light timo-primary" href="{{route('users.access-app',['emis'])}}">Access Application</a>
                            </div>
                        </div>

                        <div class="col center m3">
                            <div class="text-center">
                                <h5 class="tt-headline">
                                    <span class="tt-words-wrapper timo-primary-text"><b>Letter</br>Movement</b></span>
                                </h5>
                                <a style="width: 90%" class="spacer-top btn camel-case mt-30 waves-effect waves-light timo-primary" href="{{route('users.access-app',['letter-movement'])}}">Access Application</a>
                            </div>
                        </div>

                        <div class="col center m3">
                            <div class="text-center">
                                <h5 class="tt-headline">
                                    <span class="tt-words-wrapper timo-primary-text"><b>Fleet Management</br>System</b></span>
                                </h5>
                                <a style="width: 90%" class="spacer-top btn camel-case mt-30 waves-effect waves-light timo-primary" href="{{route('users.access-app',['dms'])}}">Access Application</a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="parallax"><img src="{{asset('images/wall_2.jpg')}}">
            </div>
        </div>

    </main>

    {{-- Message modal --}}
    @if(isset($isError) && isset($msg))
        @include('includes.modal-message')
    @endif

@endsection
