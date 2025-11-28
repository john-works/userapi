
@extends('layouts.master-admin')
@section('title')
    Admin | Behavioral Competence Categories
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
                <th>Competence Category</th>
                <th>Maximum Rating</th>
                <th class="center">Competences</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>

            <tbody id="user_profiles_table">

            @if(!isset($categories) || count($categories) == 0)
                <tr><td class="center" colspan="5">No competence categories found in the system</td></tr>
            @else
                @foreach($categories as $category)
                    <tr>
                        <td>{{$category->category}}</td>
                        <td>{{$category->maximumRating}}</td>
                        <td class="center"><a class="blue-text"  href="{{route('admin.behavioral-competence-categories.show-competences',[$category->categoryCode])}}"><i class="material-icons center">chevron_right</i></a></td>
                        <td><a  data-cat="{{$category->category}}" data-max-rating="{{$category->maximumRating}}" data-record-id="{{$category->categoryCode}}" class="green-text  modal-trigger edit-btn-behavioral-competence-cat" href="#modal_competence_cat_edit"><i class="material-icons center">edit</i></a></td>
                        <td><a data-delete-url="{{route('admin.behavioral-competence-categories.delete',$category->categoryCode)}}" data-item-gp="Competence Category" data-item-name="{{$category->category}}" class="red-text timo-btn-delete" href="#" ><i class="material-icons center">delete_forever</i></a></td>
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

    @include('behavioral-competences.modal-behavioral-competence-cat')
    @include('behavioral-competences.modal-behavioral-competence-cat-edit')
    @include('includes.modal-confirm-delete')

@endsection
