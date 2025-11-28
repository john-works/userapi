
@extends('layouts.master-admin')
@section('title')
    Admin | Departments
@endsection

@section('content')

    {{-- End Helper Modals --}}
    @include('departments.modal-department')
    @include('includes.modal-confirm-delete')

    <div class="container">

        <div class="col s12 spacer"></div>
        <div class="row">
            <h5 class="col s6">DEPARTMENTS</h5>
            <div class="col s6 ">
                <a data-form-id = "form_modal_department" href="#modal_department"   class="timo-btn-add btn waves-effect waves-light camel-case blue darken-4 right modal-trigger" type="button" >Add</a>
            </div>
        </div>

        <table class="bordered table table-hover  table-tiny-text" id="tabla">

            <thead class="timo-admin-table-head">
            <tr>
                <th>Department</th>
                <th>Head of Department</th>
                <th>Org. Code</th>
                <th>Created By</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>

            <tbody id="user_profiles_table">

            @if(is_null($departments) || count($departments) == 0)
                <tr><td class="center" colspan="6">No departments found in the system</td></tr>
            @else
                @foreach($departments as $department)
                    <tr>
                        <td>{{$department->name}}</td>
                        <td>{{$department->hodUsername}}</td>
                        <td>{{$department->orgCode}}</td>
                        <td>{{$department->createdBy}}</td>
                        <td><a data-record-id="{{$department->departmentCode}}" class="green-text  modal-trigger edit-button-department" href="#modal{{$department->departmentCode}}"><i class="material-icons center">edit</i></a></td>
                        <td><a data-delete-url="{{route('departments.delete',$department->departmentCode)}}" data-item-gp="Department" data-item-name="{{$department->name}}" class="red-text timo-btn-delete" href="#" ><i class="material-icons center">delete_forever</i></a></td>
                    </tr>

                    {{--include edit modal --}}
                    <div id="modal{{$department->departmentCode}}" class="modal">
                        <div class="modal-content">
                            @include('departments.department-form-edit')
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
                <h5>Department Deletion</h5>
                <p>{{$deletionMessage}}</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">OK</a>
            </div>
        </div>

    @endif



@endsection
