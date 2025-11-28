
@extends('layouts.master-admin')
@section('title')
    Admin | Strategic Objectives
@endsection

@section('content')

    <div class="container">

        <div class="col s12 spacer"></div>

        <div class="row">
            <h5 class="col s6">STRATEGIC OBJECTIVES</h5>
            <div class="col s6 ">
                <a data-form-id = "form_modal_objective" href="#modal_objective" id="btn_save_objective"  class="btn waves-effect waves-light camel-case blue darken-4 right modal-trigger" type="button" >Add</a>
            </div>
        </div>

        <table class="bordered table table-hover table-tiny-text" id="tabla">

            <thead class="timo-admin-table-head">
            <tr>
                <th>#</th>
                <th>Organization</th>
                <th>Objective</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>

            <tbody id="user_profiles_table">

            @if(!isset($objectives) || count($objectives) == 0)
                <tr><td class="center" colspan="6">No strategic objectives found in the system</td></tr>
            @else
                @foreach($objectives as $objective)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$objective->orgName}}</td>
                        <td>{{$objective->objective}}</td>
                        <td><a data-form-id="form_modal_objective_edit" data-org-code="{{$objective->orgCode}}" data-obj="{{$objective->objective}}"  data-record-id="{{$objective->id}}" class="green-text  modal-trigger edit-btn-objective" href="#modal_objective_edit"><i class="material-icons center">edit</i></a></td>
                        <td><a data-delete-url="{{route('admin.strategic-objectives.delete',$objective->id)}}" data-item-gp="Objective" data-item-name="{{$objective->objective}}" class="red-text timo-btn-delete" href="#" ><i class="material-icons center">delete_forever</i></a></td>
                    </tr>
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
                <h5>Data Deletion</h5>
                <p>{{$deletionMessage}}</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">OK</a>
            </div>
        </div>

    @endif

    {{-- End Helper Modals --}}
    @include('objectives.modal-objective')
    @include('objectives.modal-objective-edit')
    @include('includes.modal-confirm-delete')

@endsection
