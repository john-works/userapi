
@extends('layouts.master-admin')
@section('title')
    Admin | Competences
@endsection

@include('behavioral-competences.modal-behavioral-competence')
@include('behavioral-competences.modal-behavioral-competence-edit')
@include('includes.modal-confirm-delete')

@section('content')

    <div class="container">

        <div class="col s12 spacer"></div>

        <div class="row">
            <h5 class="col s6">COMPETENCES</h5>
            <div class="col s6 ">
                <a id="btn_save_competence" href="#modal_competence" class="btn waves-effect waves-light camel-case blue darken-4 right modal-trigger" type="button" >Add</a>
            </div>
        </div>

        <table class="bordered table table-hover table-tiny-text" id="tabla">

            <thead class="timo-admin-table-head">
            <tr>
                <th>Competence Category</th>
                <th>Competence</th>
                <th>Rating</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>

            <tbody id="user_profiles_table">

            @if(!isset($competences) || count($competences) == 0)
                <tr><td class="center" colspan="5">No competences found in the system</td></tr>
            @else
                @foreach($competences as $competence)
                    <tr>
                        <td>{{$competence->category}}</td>
                        <td>{{$competence->competence}}</td>
                        <td>{{$competence->maximumScore}}</td>
                        <td><a
                                data-form-id="form_modal_competence_edit" data-cat-id="{{$competence->categoryCode}}" data-competence="{{$competence->competence}}" data-rating="{{$competence->maximumScore}}" data-record-id="{{$competence->id}}"
                                class="green-text  modal-trigger edit-btn-behavioral-competence" href="#modal_competence_edit"><i class="material-icons center">edit</i></a></td>
                        <td><a data-delete-url="{{route('admin.behavioral-competences.delete',[$competence->categoryCode,$competence->id])}}" data-item-gp="Competence" data-item-name="{{$competence->competence}}" class="red-text timo-btn-delete" href="#" ><i class="material-icons center">delete_forever</i></a></td>
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

        <div id="modal_deletion" class="modal modal-success-confirmation">
            <div class="modal-content">
                <h5>Competence Deletion</h5>
                <p>{{$deletionMessage}}</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">OK</a>
            </div>
        </div>

    @endif

    {{-- End Helper Modals --}}

@endsection
