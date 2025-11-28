
@extends('layouts.master-admin')
@section('title')
    Admin | Regional Offices
@endsection

@section('content')

    @include('regional-offices.modal-reg-office')
    @include('includes.modal-confirm-delete')

    <div class="container">

        <div class="col s12 spacer"></div>
        <div class="row">
            <h5 class="col s6">REGIONAL OFFICES</h5>
            <div class="col s6 ">
                <a data-form-id = "form_modal_reg_office" href="#modal_reg_office"   class="timo-btn-add btn waves-effect waves-light camel-case blue darken-4 right modal-trigger" type="button" >Add</a>
            </div>
        </div>

        <table class="bordered table table-hover table-tiny-text" id="tabla">

            <thead class="timo-admin-table-head">
            <tr>
                <th>Regional Office</th>
                <th>Org. Code</th>
                <th>Email</th>
                <th>Contact Person</th>
                <th>Contact</th>
                <th>Created By</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>

            <tbody id="user_profiles_table">

            @if(is_null($regionalOffices) || count($regionalOffices) == 0)
                <tr><td class="center" colspan="6">No regional offices found in the system</td></tr>
            @else
                @foreach($regionalOffices as $office)
                    <tr>
                        <td>{{$office->name}}</td>
                        <td>{{$office->orgCode}}</td>
                        <td>{{$office->email}}</td>
                        <td>{{$office->contactPersonName}}</td>
                        <td>{{$office->contactPersonContact}}</td>
                        <td>{{$office->createdBy}}</td>
                        <td><a data-record-id="{{$office->regionalOfficeCode}}" class="green-text modal-trigger edit-button-regional-office" href="#modal{{$office->regionalOfficeCode}}"><i class="material-icons center">edit</i></a></td>
                        <td><a data-delete-url="{{route('regional-offices.delete',$office->regionalOfficeCode)}}" data-item-gp="Regional Office" data-item-name="{{$office->name}}" class="red-text timo-btn-delete" href="#" ><i class="material-icons center">delete_forever</i></a></td>
                    </tr>

                    {{--include edit modal --}}
                    <div id="modal{{$office->regionalOfficeCode}}" class="modal ">
                        <div class="modal-content">
                            @include('regional-offices.reg-office-form-edit')
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
