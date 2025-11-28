
@extends('layouts.master')
@section('title')
    PPDA Applications | Password Change
@endsection

@section('content')
    <header>
        @include('includes.navbar_guest')
    </header>

    <main >

        <div class="parallax-container">
            <div class="container " style="margin-top: 8%" >
                <div class="row">
                    <div class="col  l4 offset-l4 m4 offset-m4 s12">
                        <form id="signin_form" class="col s12 card-panel" method="post" action="{{route('user.password.change-default')}}">
                            <div class="row">
                                <div class="col s8 offset-s2 center">
                                    <span class="blue-text text-darken-4">CHANGE PASSWORD</span>
                                </div>
                                <div class="col s12 spacer-small"></div>
                                <div class="col s12 divider"></div>
                                <div class="col s12 spacer"></div>
                                <div class="col s12 center red-text timo-appraisal-th">Password Change Is Required To Proceed</div>
                                <div class="col s12 spacer-small"></div>
                                <div class="row">
                                    <div class="input-field col s8 offset-s2">
                                        <input id="new_password" name="new_password" type="password" class=validate" value="{{old('new_password')}}" required>
                                        <label @if(count($errors->all()) > 0) class="active" @endif for="new_password">New Password</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s8 offset-s2">
                                        <input id="new_password_confirmation" name="new_password_confirmation" type="password" class=validate" value="{{old('new_password_confirmation')}}" required>
                                        <label  @if(count($errors->all()) > 0) class="active" @endif for="new_password_confirmation">Confirm New Password</label>
                                    </div>
                                </div>

                                @if(count($errors->all()) > 0)
                                    <div class="row">
                                        <div class="col s8 offset-s2 input-field">
                                            <ul>
                                                @foreach($errors->all() as $error)
                                                    <li class="invalid">{{$error}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col s8 offset-s2 center">
                                        <button id="login_button" type="submit" name="action" class="btn camel-case blue darken-4">Change Password</button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col s12 center"><a class="blue-text text-darken-4" href="{{route('login')}}">Login Here</a></div>
                                </div>
                            </div>
                            {{csrf_field()}}
                        </form>
                    </div>

                </div>
            </div>
            <div class="parallax"><img src="{{asset('images/wall_2.jpg')}}">
            </div>
        </div>

    </main>

    {{-- Message modal --}}
    @if(isset($isError) && isset($msg))  @include('includes.modal-message')   @endif

@endsection
