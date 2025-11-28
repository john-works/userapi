
@extends('layouts.master-admin')
@section('title')
    Admin | Competence Categories
@endsection

@section('content')

    <div class="container">

        <div class="col s12 spacer"></div>

        <div class="row">
            <h5 class="col s6">COMPETENCE CATEGORIES</h5>
            <div class="col s6 ">
                <a id="btn_save_competence_cat" href="#modal_competence_cat" class="btn waves-effect waves-light camel-case blue darken-4 right modal-trigger" type="button" >Add</a>
            </div>
        </div>

        <table class="bordered table table-hover  table-tiny-text" id="tabla">

            <thead class="timo-admin-table-head">
            <tr>
                <th>Org. Code</th>
                <th>Employee Category</th>
                <th>Competence Category</th>
                <th>Maximum Rating</th>
                <th>Created By</th>
                <th>Competences</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>

            <tbody id="user_profiles_table">

            @if(!isset($categories) || count($categories) == 0)
                <tr><td class="center" colspan="6">No competence categories found in the system</td></tr>
            @else
                @foreach($categories as $category)
                    <tr>
                        <td>{{$category->orgCode}}</td>
                        <td>{{$category->employeeCategoryName}}</td>
                        <td>{{$category->competenceCategory}}</td>
                        <td>{{$category->maxRating}}</td>
                        <td>{{$category->createdBy}}</td>
                        <td class="center"><a class="blue-text"  href="{{route('admin.competence-categories.show-competences',[$category->id])}}"><i class="material-icons center">chevron_right</i></a></td>
                        <td><a data-org-code="{{$category->orgCode}}" data-emp-cat-code="{{$category->empCategoryCode}}" data-cat="{{$category->competenceCategory}}" data-max-rating="{{$category->maxRating}}" data-record-id="{{$category->id}}" class="green-text  modal-trigger edit-btn-competence-cat" href="#modal_competence_cat_edit"><i class="material-icons center">edit</i></a></td>
                        <td><a data-delete-url="{{route('admin.competence-categories.delete',$category->id)}}" data-item-gp="Competence Category" data-item-name="{{$category->competenceCategory}}" class="red-text timo-btn-delete" href="#" ><i class="material-icons center">delete_forever</i></a></td>
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
                <h5>Competence Category Deletion</h5>
                <p>{{$deletionMessage}}</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">OK</a>
            </div>
        </div>

    @endif

    {{-- End Helper Modals --}}

    @include('competences.modal-competence-cat')
    @include('competences.modal-competence-cat-edit')
    @include('includes.modal-confirm-delete')

@endsection
