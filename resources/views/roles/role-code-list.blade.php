
@extends('layouts.master-admin')
@section('title')
    Admin | System Roles
@endsection

@include('roles.modal-role-code')
@include('includes.modal-confirm-delete')

@section('content')

    <div class="container">

        <div class="col s12 spacer"></div>
        <div class="row">
            <h5 class="col s6">SYSTEM ROLES</h5>
            <div class="col s6 ">
                <a data-form-id = "form_modal_role_code" href="#modal_role_code"   class="timo-btn-add btn waves-effect waves-light camel-case blue darken-4 right modal-trigger" type="button" >Add</a>
            </div>
        </div>

        <table class="bordered table table-hover  table-tiny-text" id="tabla">

            <thead class="timo-admin-table-head">
            <tr>
                <th>Role Name</th>
                <th>Org. Code</th>
                <th>Active</th>
                <th>Default Page</th>
                <th>Created By</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>

            <tbody id="user_profiles_table">

            @if(is_null($roleCodes) || count($roleCodes) == 0)
                <tr><td class="center" colspan="6">No departments found in the system</td></tr>
            @else
                @foreach($roleCodes as $role)
                    <tr>
                        <td>{{$role->roleName}}</td>
                        <td>{{$role->orgCode}}</td>
                        <td>{{$role->active}}</td>
                        <td>{{$role->defaultPage}}</td>
                        <td>{{$role->createdBy}}</td>
                        <td><a data-record-id="{{$role->roleCode}}" class="green-text modal-trigger edit-button-role-code" href="#modal{{$role->roleCode}}"><i class="material-icons center">edit</i></a></td>
                        <td><a data-delete-url="{{route('role-codes.delete',$role->roleCode)}}" data-item-gp="System Role" data-item-name="{{$role->roleName}}" class="red-text timo-btn-delete" href="#" ><i class="material-icons center">delete_forever</i></a></td>
                    </tr>

                    {{--includeedit modal --}}
                    <div id="modal{{$role->roleCode}}" class="modal ">
                        <div class="modal-content">
                            @include('roles.role-code-form-edit')
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

@endsection
