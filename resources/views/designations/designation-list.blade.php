
@extends('layouts.master-admin')
@section('title')
    Admin | Designations
@endsection

@section('content')

    {{-- End Helper Modals --}}
    @include('designations.modal-designation')
    @include('includes.modal-confirm-delete')

    <div class="container">

        <div class="col s12 spacer"></div>
        <div class="row">
            <h5 class="col s6">DESIGNATIONS</h5>
            <div class="col s6 ">
                <a data-form-id = "form_modal_designation" href="#modal_designation"   class="timo-btn-add btn waves-effect waves-light camel-case blue darken-4 right modal-trigger" type="button" >Add</a>
            </div>
        </div>

        <table class="bordered table table-hover  table-tiny-text" id="tabla">

            <thead class="timo-admin-table-head">
            <tr>
                <th>*</th>
                <th>Designation</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>

            <tbody id="user_profiles_table">

            @if(is_null($designations) || count($designations) == 0)
                <tr><td class="center" colspan="6">No designations found in the system</td></tr>
            @else
                @foreach($designations as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->title}}</td>
                        <td><a data-record-id="{{$item->id}}" class="green-text  modal-trigger edit-button-designation" href="#modal{{$item->id}}"><i class="material-icons center">edit</i></a></td>
                        <td><a data-delete-url="{{route('designations.delete',$item->id)}}" data-item-gp="Designation" data-item-name="{{$item->title}}" class="red-text timo-btn-delete" href="#" ><i class="material-icons center">delete_forever</i></a></td>
                    </tr>

                    {{--include edit modal --}}
                    <div id="modal{{$item->id}}" class="modal">
                        <div class="modal-content">
                            @include('designations.designation-form-edit')
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
