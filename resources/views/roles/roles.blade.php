
@extends('layouts.master-admin')
@section('title')
    System Settings - Add User Role
@endsection

@section('content')


    <div class="col s12 spacer"></div>

    <div class="row">

        <div class=" card-panel col l3 m12 s12">

            <div id="register" class="col s12">
                <form class="col s12" method="post" action="{{route('create_role')}}">

                    <div class="form-container">
                        <h5 class=""><i class="material-icons right blue-text text-darken-4">add_circle_outline</i>Add User Role</h5>

                        <div class="row">
                            <div class="input-field col s12">
                                <input id="role" name="role" type="text" class="validate" required value="{{old('role')}}">
                                <label for="role">Role</label>
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
                                <button class="btn waves-effect waves-light camel-case blue darken-4" type="submit" name="action">Create User Role</button>
                            </div>
                        </div>
                        {{csrf_field()}}
                    </div>
                </form>
            </div>
        </div>

        <div class="col l9 m12 s12">
            <div class=" card-panel col m10 offset-m1 s12">

                <div id="register" class="col s12">

                    <div class="form-container">
                        <h5 class=""><i class="material-icons right blue-text text-darken-4">list</i>User Roles</h5>

                        <div class="row">
                            <table class="bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Role</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>

                                <tbody>

                                @if(isset($roles) && count($roles) > 0)
                                    @foreach($roles as $role)
                                        <tr>
                                            <td>{{ $loop->iteration }} </td>
                                            <td>{{$role->role}}</td>
                                            <td><a data-record-id="{{$role->id}}" class="green-text edit-button-role" href="#modal{{$role->id}}"><i class="material-icons center">edit</i></a></td>
                                            <td><a class="red-text"  href="{{route('delete_role',$role->id)}}" onclick="showDeleteConfirmationModal(this, 'modal_del_{{$role->id}}'); return false;"><i class="material-icons center">delete_forever</i></a></td>

                                            {{--include role view modal --}}
                                            <div id="modal{{$role->id}}" class="modal ">
                                                <div class="modal-content">
                                                    @include('roles.role_view')
                                                </div>
                                            </div>

                                            {{--include role delete modal --}}
                                            @include('roles.confirm_role_delete')

                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="center-align">No roles found</td>
                                    </tr>
                                @endif

                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>


    </div>


    @if(isset($message))

        <div id="modal_account_created" class="modal">
            <div class="modal-content">
                <h5>Operation Successful</h5>
                <p>{{$message}}</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">OK</a>
            </div>
        </div>

    @endif

@endsection
