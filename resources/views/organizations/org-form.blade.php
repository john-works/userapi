
@extends('layouts.master-admin')
@section('title')
    Admin | Create Organization
@endsection

@section('content')

    <div class="row">

        <div class="col s12 spacer"></div>

        <div class=" card-panel col l6 offset-l3">

            <div id="register" class="col s12">

                @if(isset($successMessage))
                    <div class="spacer-top"></div>
                    <div class="col s12 center">
                        <span class="red-text">{{$successMessage}}</span>
                    </div>
                @endif

                <form class="col s12" method="post" action="{{route('organization.store')}}">

                    <div class="form-container">

                        <h5 class=""><i class="material-icons right blue-text text-darken-4">add_circle_outline</i>Add Organization</h5>

                        <div class="row">
                            <div class="input-field col m7 s12">
                                <input id="name" name="name" type="text" class="validate" required value="{{old('name')}}">
                                <label for="name">Organization Name</label>
                            </div>
                            <div class="input-field col m5 s12">
                                <input id="org_code" name="org_code" type="text" class="validate" required value="{{old('org_code')}}">
                                <label for="org_code">Organization Code</label>
                            </div>
                        </div>


                        <div class="row">
                            <div class="input-field col m7 s12">
                                <input id="contact_person_name" name="contact_person_name" type="text" class="validate" required value="{{old('contact_person_name')}}">
                                <label for="contact_person_name">Contact Person Name</label>
                            </div>
                            <div class="input-field col m5 s12">
                                <input id="contact_person_contact" name="contact_person_contact" type="text" class="validate" required value="{{old('contact_person_contact')}}">
                                <label for="contact_person_contact">Contact Person Contact</label>
                            </div>
                        </div>


                        <div class="row">
                            <div class="input-field col s12">
                                <input id="email" name="email" type="email" class="validate" required value="{{old('email')}}">
                                <label for="email">Email</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <input id="location" name="location" type="text" class="validate" required value="{{old('location')}}">
                                <label for="location">Location</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <input id="description" name="description" type="text" class="validate" required value="{{old('description')}}">
                                <label for="description">Description</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <input id="created_by" name="created_by" type="text" class="validate" hidden required value="{{$user->username}}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12">
                                @if(count($errors->all()) > 0)
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li class="invalid">{{$error}}</li>
                                        @endforeach
                                    </ul>
                                @elseif(isset($formError))
                                    <ul>
                                        <li class="invalid">{{$formError}}</li>
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 spacer"></div>
                            <div class="col s12 center">
                                <button class="btn waves-effect waves-light camel-case blue darken-4" type="submit" name="action">Create Organization</button>
                            </div>
                        </div>
                        {{csrf_field()}}
                    </div>
                </form>

            </div>
        </div>
    </div>

    @if(isset($successMessage))

        <div id="modal_org_created" class="modal">
            <div class="modal-content">
                <h5>Operation Successful</h5>
                <p>{{$successMessage}}</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">OK</a>
            </div>
        </div>

    @endif


@endsection
