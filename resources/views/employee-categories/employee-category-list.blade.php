
@extends('layouts.master-admin')
@section('title')
    Admin | Employee Categories
@endsection

@section('content')

    {{-- End Helper Modals --}}
    @include('employee-categories.modal-employee-category')
    @include('includes.modal-confirm-delete')

    <div class="container">

        <div class="col s12 spacer"></div>
        <div class="row">
            <h5 class="col s6">EMPLOYEE CATEGORIES</h5>
            <div class="col s6 ">
                <a data-form-id = "form_modal_employee_cat" href="#modal_employee_cat"   class="timo-btn-add btn waves-effect waves-light camel-case blue darken-4 right modal-trigger" type="button" >Add</a>
            </div>
        </div>

        <table class="bordered table table-hover  table-tiny-text" id="tabla">

            <thead class="timo-admin-table-head">
            <tr>
                <th>Category</th>
                <th>Org. Code</th>
                <th>Created By</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>

            <tbody id="user_profiles_table">

            @if(is_null($employeeCategories) || count($employeeCategories) == 0)
                <tr><td class="center" colspan="6">No employee categories found in the system</td></tr>
            @else
                @foreach($employeeCategories as $category)
                    <tr>
                        <td>{{$category->category}}</td>
                        <td>{{$category->orgCode}}</td>
                        <td>{{$category->createdBy}}</td>
                        <td><a data-record-id="{{$category->categoryCode}}" class="green-text modal-trigger edit-button-categories" href="#modal{{$category->categoryCode}}"><i class="material-icons center">edit</i></a></td>
                        <td><a data-delete-url="{{route('employee-categories.delete',$category->categoryCode)}}" data-item-gp="Employee Category" data-item-name="{{$category->category}}" class="red-text timo-btn-delete" href="#" ><i class="material-icons center">delete_forever</i></a></td>
                    </tr>

                    {{--include edit modal --}}
                    <div id="modal{{$category->categoryCode}}" class="modal ">
                        <div class="modal-content">
                            @include('employee-categories.employee-category-form-edit')
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
                <h5>Employee Category Deletion</h5>
                <p>{{$deletionMessage}}</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">OK</a>
            </div>
        </div>

    @endif



@endsection

