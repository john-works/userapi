
@extends('layouts.app_public')
@section('title')
    Password Change
@endsection

@section('content')
    <header>
        @include('includes.navbar_guest')
    </header>

    <main >

        <div class="parallax" style="background-image: url({{asset('images/wall_2.jpg')}})">
            <div class="container " >
                <div class="row" >
                    <div class="col-md-4 col-md-offset-4 panel" style="margin-top: 8%">
                        <form id="signin_form" class="col-md-12" method="post" action="{{route('user.password.change-default')}}">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2 center">
                                    <span class="um-primary-text">CHANGE PASSWORD</span>
                                </div>
                                <div class="col-md-12 spacer-small"></div>
                                <div class="col-md-12 divider"></div>
                                <div class="col-md-12 spacer"></div>
                                <div class="col-md-12 center timo-appraisal-th"><span class="text-danger">Password Change Is Required To Proceed</span></div>
                                <div class="col-md-12 spacer-small"></div>
                                <div class="row">
                                    <div class="input-field col-md-8 col-md-offset-2">
                                        <label @if(count($errors->all()) > 0) class="active" @endif for="new_password">New Password</label>
                                        <input id="new_password" name="new_password" type="password" class="validate fill-parent" value="{{old('new_password')}}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col-md-8 col-md-offset-2">
                                        <label  @if(count($errors->all()) > 0) class="active" @endif for="new_password_confirmation">Confirm New Password</label>
                                        <input id="new_password_confirmation" name="new_password_confirmation" type="password" class="validate fill-parent" value="{{old('new_password_confirmation')}}" required>
                                    </div>
                                </div>

                                @if(count($errors->all()) > 0)
                                    <div class="row">
                                        <div class="col-md-8 col-md-offset-2 input-field">
                                                @foreach($errors->all() as $error)
                                                    <div class="error">{{$error}}</div>
                                                @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2 center">
                                        <button id="login_button" type="submit" name="action" class="btn camel-case um-primary-bg">Change Password</button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 center" style="margin-top: 10px"><a class="um-primary-text" href="{{route('login')}}">Login Here</a></div>
                                </div>

                            </div>
                            {{csrf_field()}}
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </main>

    {{-- Message modal --}}
    @if(isset($isError) && isset($msg))  @include('includes.modal-message')   @endif

@endsection
