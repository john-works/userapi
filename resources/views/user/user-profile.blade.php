@extends('layouts.master')
@section('title')
User | Profile
@endsection
@section('content')
<header>
    @include('includes.nav-bar-general')
</header>
<main class="container">

    <div class="row spacer-top">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <div class="row" style="margin-bottom: 5px">
                        <div class="col s6">
                            <h5 class="card-title timo-grey-text">Personal Biodata</h5>
                        </div>
                    </div>
                    <div class="hr-dotted spacer-bottom"></div>
                    <div class="row">
                        <div class="col l6 m6 m12">

                            <ul class="collection">
                                <li class="collection-item"><span class="profile-field ">Username: </span><span class="profile-field-value">{{$user->username}}</span></li>
                                <li class="collection-item"><span class="profile-field">Staff Personal File Number: </span><span class="profile-field-value">{{$user->staffNumber}}</span></li>
                                <li class="collection-item"><span class="profile-field">Current Contract Start Date: </span><span class="profile-field-value">{{$user->contractStartDate}}</span></li>
                                <li class="collection-item"><span class="profile-field">Current Contract End Date: </span><span class="profile-field-value">{{$user->contractExpiryDate}}</span></li>
                                <li class="collection-item"><span class="profile-field">Department: </span><span class="profile-field-value">{{$user->departmentName}}</span></li>
                                <li class="collection-item"><span class="profile-field">Head Of Department: </span><span class="profile-field-value">{{$user->departmentHeadFullName}}</span></li>
                             </ul>

                        </div>

                        <div class="col l6 m6 m12 ">

                            <ul class="collection">
                                <li class="collection-item"><span class="profile-field ">First Name: </span><span class="profile-field-value">{{$user->firstName}}</span></li>
                                <li class="collection-item"><span class="profile-field">Last Name: </span><span class="profile-field-value">{{$user->lastName}}</span></li>
                                <li class="collection-item"><span class="profile-field">Designation: </span><span class="profile-field-value">{{$user->designation}}</span></li>
                                <li class="collection-item"><span class="profile-field">Date Of Birth: </span><span class="profile-field-value">{{$user->dateOfBirth}}</span></li>
                             </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <div class="row" style="margin-bottom: 5px">
                        <div class="col s6">
                            <h5 class="card-title timo-grey-text">Academic Background</h5>
                        </div>
                        <div class="col s6">
                            <a id="btn_save_academic_bg" href="#modal_user_academic_bg" class="btn waves-effect waves-light camel-case blue darken-4 right modal-trigger" type="button" >Add</a>
                        </div>
                    </div>
                    <div class="hr-dotted spacer-bottom"></div>
                    <div class="row">

                        <div class="col l10 offset-l1 s12">
                            <table  class="bordered">
                                <thead>
                                <tr>
                                    <th>School</th>
                                    <th>Year of Study</th>
                                    <th>Award/Qualification</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(isset($academicBackgrounds) && count($academicBackgrounds) > 0)
                                    @foreach($academicBackgrounds as $background)
                                    <tr>
                                        <td>{{$background->institution}}</td>
                                        <td>{{$background->yearOfStudy}}</td>
                                        <td>{{$background->award}}</td>
                                        <td><a data-modal-form-id ="#form_modal_user_academic_bg_edit" data-source="{{route('users.profile.academic-bg',[$background->id])}}" class="green-text modal-trigger ajax-edit-button" href="#modal_academic_bg"><i class="material-icons center">edit</i></a></td>
                                        <td><a class="red-text" href="{{route('users.academic-bg.delete',$background->id)}}" onclick="showDeleteConfirmationModal(this, 'modal_del_{{$background->id}}'); return false;"><i class="material-icons center">delete_forever</i></a></td>
                                    </tr>

                                    @include('user.modal-profile-academic-bg-delete-modal')

                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="center">No Academic Background Information Found</td>
                                </tr>
                                @endif

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@include('user.modal-profile-academic-bg')
@include('user.modal-profile-academic-bg-edit')


{{-- Message modal --}}
@if(isset($msg) && isset($isError))
    @include('includes.modal-message')
@endif
</main>
@endsection