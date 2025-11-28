@extends('layouts.master')
@section('title')
    User | Password Management
@endsection
@section('content')
    <header>
        @include('includes.navbar_guest')
    </header>
    <main class="container">

        <div class="row">

            <div class="col s12 spacer"></div>

            <div class=" card-panel col l6 offset-l3">

                <div id="register" class="col s12">

                    <form class="col s12" method="post" action="{{route('change_password')}}">

                        <input name="username" value="{{$user->username}}" type="hidden"/>

                        <div class="form-container">
                            <h5 class="timo-primary-text center">Password Management</h5>

                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="old_password" name="old_password" type="password" class="validate" required value="{{old('old_password')}}">
                                    <label for="old_password">Old Password</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="new_password" name="new_password" type="password" class="validate" required value="{{old('new_password')}}">
                                    <label for="new_password">New Password</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="new_password_confirmation" name="new_password_confirmation" type="password" class="validate" required value="{{old('new_password_confirmation')}}">
                                    <label for="new_password_confirmation">Confirm New Password</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col s12">
                                    @if(count($errors->all()) > 0)
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li class="invalid">{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col s12 spacer"></div>
                                <div class="col s12 right">
                                    <button class="right btn waves-effect waves-light camel-case green darken-4" type="submit" name="action">Change Password</button>
                                    <a href="{{route('users.app-selection')}}" class="btn waves-effect waves-light camel-case blue darken-4" name="action">Back to App Selection</a>
                                </div>
                                <div class="col s12 spacer"></div>
                            </div>
                            {{csrf_field()}}
                        </div>
                    </form>
                </div>

            </div>
        </div>

        @if(isset($isError) && isset($msg)) @include('includes.modal-message') @endif

    </main>
@endsection