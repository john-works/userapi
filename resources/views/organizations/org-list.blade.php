
@extends('layouts.master-admin')
@section('title')
    Admin | Organizations
@endsection

@section('content')

    @include('organizations.modal-org')
    @include('includes.modal-confirm-delete')

    <div class="container">

        <div class="col s12 spacer"></div>

        <div class="row">
            <h5 class="col s6">ORGANISATIONS</h5>
            <div class="col s6 ">
                <a data-form-id = "form_modal_org" href="#modal_org"   class="timo-btn-add btn waves-effect waves-light camel-case blue darken-4 right modal-trigger" type="button" >Add</a>
            </div>
        </div>

        <table class="bordered table table-hover table-tiny-text" id="tabla">

            <thead class="timo-admin-table-head">
            <tr>
                <th>Organization Name</th>
                <th>Email</th>
                <th>Contact Person</th>
                <th>Contact</th>
                <th>Created By</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>

            <tbody id="user_profiles_table">

            @if(is_null($organizations) || count($organizations) == 0)
                <tr><td class="center" colspan="6">No organizations found in the system</td></tr>
            @else
                @foreach($organizations as $org)
                    <tr>
                        <td>{{$org->name}}</td>
                        <td>{{$org->email}}</td>
                        <td>{{$org->contactPersonName}}</td>
                        <td>{{$org->contactPersonContact}}</td>
                        <td>{{$org->createdBy}}</td>
                        <td><a data-record-id="{{$org->orgCode}}" class="green-text modal-trigger edit-button-organization" href="#modal{{$org->orgCode}}"><i class="material-icons center">edit</i></a></td>
                         <td><a data-delete-url="{{route('organizations.delete',$org->orgCode)}}" data-item-gp="Organization" data-item-name="{{$org->name}}" class="red-text timo-btn-delete" href="#" ><i class="material-icons center">delete_forever</i></a></td>
                    </tr>

                    {{--include edit modal --}}
                    <div id="modal{{$org->orgCode}}" class="modal ">
                        <div class="modal-content">
                            @include('organizations.org-form-edit')
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


