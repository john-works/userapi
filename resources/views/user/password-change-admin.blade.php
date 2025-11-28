
@extends('layouts.master-admin')
@section('title')
    Admin | Change Password
@endsection

@section('content')

    <div class="row">

        <div class="col s12 spacer"></div>

        <div class=" card-panel col l6 offset-l3">

            <div id="register" class="col s12">

                <form class="col s12" method="post" action="{{route('change_password')}}">

                    <input name="username" value="{{$user->username}}" type="hidden"/>

                    <div class="form-container">
                        <h5 class=""><i class="material-icons right blue-text text-darken-4">add_circle_outline</i>Password Management</h5>

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
                            <div class="col s12 center">
                                <button class="btn waves-effect waves-light camel-case blue darken-4" type="submit" name="action">Change Password</button>
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

@endsection
