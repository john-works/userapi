
@extends('layouts.master-admin')
@section('title')
    Admin | System Users
@endsection

@section('page-level-css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('pixinvent/app-assets/vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('pixinvent/app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('pixinvent/app-assets/vendors/data-tables/css/select.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('pixinvent/app-assets/css/data-tables.css')}}">
@endsection

@section('content')

    {{-- End Helper Modals --}}
    @include('user.modal-user')
    @include('includes.modal-confirm-delete')
    @include('user.modal-user-lms-roles')

    <div class="container-95">

        <div class="col s12 spacer"></div>
        <div class="row">
            <h5 class="col s6">SYSTEM USERS</h5>
            <div class="col s6 ">
                <a data-form-id = "form_modal_user" href="#modal_user"   class="timo-btn-add btn waves-effect waves-light camel-case blue darken-4 right modal-trigger" type="button" >Add</a>
            </div>
        </div>

        <table class="bordered table table-hover table-tiny-text" id="page-length-option">

            <thead >
            <tr class="timo-table-headers">
                <th style="width: 25%">Username</th>
                <th style="width: 20%;">Name</th>
                <th style="width: 20%;">Designation</th>
                <th style="width: 18%;">Department</th>
                <th style="width: 12%;">Appraisal Role</th>
                <th style="width: 5%;">Edit</th>
            </tr>
            </thead>

            <tbody id="user_profiles_table">

            @if(is_null($users) || count($users) == 0)
                <tr><td class="center" colspan="8">No users accounts found in the system</td></tr>
            @else
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->username}}</td>
                        <td>{{$user->fullName}}</td>
                        <td>{{$user->designationTitle}}</td>
                        <td>{{$user->departmentName}}</td>
                        <td>{{ucwords(strtolower($user->roleName))}}</td>
                        <td><a data-user_id="{{$user->id}}" class="green-text modal-trigger edit-button" href="#modal_user_edit{{$user->id}}"><i class="material-icons center">edit</i></a></td>
                     </tr>

                    {{--include profile view modal --}}
                    <div id="modal_user_edit{{$user->id}}" class="modal modal-70">
                        <div class="modal-content">
                            @include('user.user-form-edit')
                        </div>
                    </div>

                @endforeach
            @endif

            </tbody>

        </table>

        <div class="col s12 spacer"></div>
        <div class="col s12 center">
            <div><span id="total_users"></span></div>
            <ul class="pagination pager" id="myPager"></ul>
        </div>

    </div>


    {{-- Helper Modals are below --}}

    @if(isset($deletionMessage))

        <div id="modal_deletion" class="modal">
            <div class="modal-content">
                <h5>User Deletion</h5>
                <p>{{$deletionMessage}}</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">OK</a>
            </div>
        </div>

    @endif

@endsection


@section('page-level-js')

    <script src="{{ URL::asset('pixinvent/app-assets/vendors/data-tables/js/jquery.dataTables.min.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('pixinvent/app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('pixinvent/app-assets/vendors/data-tables/js/dataTables.select.min.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('pixinvent/app-assets/js/scripts/data-tables.js')}}" type="text/javascript"></script>

@endsection


