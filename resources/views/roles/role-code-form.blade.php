
@extends('layouts.master-admin')
@section('title')
    Admin | Create Role Code
@endsection

@section('content')

    <div class="row">

        <div class="col s12 spacer"></div>

        <div class=" card-panel col l6 offset-l3">

            <div id="register" class="col s12">

                @if(isset($successMessage))
                    <div class="spacer-top"></div>
                    <div class="col s12 center">
                        <span class="red-text">{{$successMessage}}</span>
                    </div>
                @endif

                <form class="col s12" method="post" action="{{route('role-codes.store')}}">

                    <div class="form-container">

                        <h5 class=""><i class="material-icons right blue-text text-darken-4">add_circle_outline</i>Add System Role</h5>

                        <div class="row">
                            <div class="input-field col m7 s12">
                                <input id="role_name" name="role_name" type="text" class="validate" required value="{{old('role_name')}}">
                                <label for="role_name">Role Name</label>
                            </div>
                            <div class="input-field col m5 s12">
                                <input id="role_code" name="role_code" type="text" class="validate" required value="{{old('role_code')}}">
                                <label for="role_code">Role Code</label>
                            </div>
                        </div>


                        <div class="row">
                            <div class="input-field col s12">
                                <select name="org_code" required class="validate">
                                    <option value="" disabled selected>Choose Organization</option>
                                    @if(isset($organizations) && count($organizations) > 0)
                                        @foreach($organizations as $org)
                                            <option value="{{$org->orgCode}}">{{$org->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="org_code">Organization</label>
                            </div>

                            <div class="col s12 spacer"></div>
                        </div>

                        {{-- Hidden created by field --}}
                        <input id="created_by" name="created_by" type="text" class="validate" hidden required value="{{$user->username}}">

                        <div class="row">
                            <div class="col s12">
                                @if(count($errors->all()) > 0)
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li class="invalid">{{$error}}</li>
                                        @endforeach
                                    </ul>
                                @elseif(isset($formError))
                                    <ul>
                                        <li class="invalid">{{$formError}}</li>
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 spacer"></div>
                            <div class="col s12 center">
                                <button class="btn waves-effect waves-light camel-case blue darken-4" type="submit" name="action">Create System Role</button>
                            </div>
                        </div>
                        {{csrf_field()}}
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(isset($successMessage))

        <div id="modal_org_created" class="modal">
            <div class="modal-content">
                <h5>Operation Successful</h5>
                <p>{{$successMessage}}</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">OK</a>
            </div>
        </div>

    @endif


@endsection
