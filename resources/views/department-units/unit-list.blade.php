
@extends('layouts.master-admin')
@section('title')
    Admin | Department Units
@endsection

@section('content')

    {{-- End Helper Modals --}}
    @include('department-units.modal-unit')
    @include('includes.modal-confirm-delete')

    <div class="container">

        <div class="col s12 spacer"></div>
        <div class="row">
            <h5 class="col s6">DEPARTMENTS UNITS</h5>
            <div class="col s6 ">
                <a data-form-id = "form_modal_unit" href="#modal_unit"   class="timo-btn-add btn waves-effect waves-light camel-case blue darken-4 right modal-trigger" type="button" >Add</a>
            </div>
        </div>

        <table class="bordered table table-hover  table-tiny-text" id="tabla">

            <thead class="timo-admin-table-head">
            <tr>
                <th style="width: 45%">Unit Name</th>
                <th style="width: 45%">Department</th>
                <th style="width: 5%">Edit</th>
                <th style="width: 5%">Delete</th>
            </tr>
            </thead>

            <tbody id="user_profiles_table">

            @if(is_null($units) || count($units) == 0)
                <tr><td class="center" colspan="4">No departments unit found in the system</td></tr>
            @else
                @foreach($units as $unit)
                    <tr>
                        <td>{{$unit->unit}}</td>
                        <td>{{$unit->departmentName}}</td>
                         <td><a data-record-id="{{$unit->unitCode}}" class="green-text  modal-trigger edit-button-unit" href="#modal{{$unit->unitCode}}"><i class="material-icons center">edit</i></a></td>
                        <td><a data-delete-url="{{route('department-units.delete',$unit->unitCode)}}" data-item-gp="Department" data-item-name="{{$unit->unit}}" class="red-text timo-btn-delete" href="#" ><i class="material-icons center">delete_forever</i></a></td>
                    </tr>

                    {{--include edit modal --}}
                    <div id="modal{{$unit->unitCode}}" class="modal">
                        <div class="modal-content">
                            @include('department-units.unit-form-edit')
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
