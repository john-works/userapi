
@extends('layouts.master')
@section('title')
    Assign Approvers | {{config('app.name')}}
@endsection

@section('content')

    <header>
        @include('includes.nav-bar-general')
    </header>

    <main class="container">

        <div class="row">

            <div class="col s12 l10 offset-l1 spacer-top ">
                <div class="col s12">
                    <div class="col s12">

                        <div class="row">
                            <div class="col s12 spacer"></div>
                            <div class="col l6 offset-l3"><a class="btn camel-case right red darken-4" type="button" onclick="history.back();">Back</a></div>
                            <div class=" card-panel col l6 offset-l3">

                                <div id="register" class="col s12">
                                    <form class="col s12" method="post" action="{{route('assign_approvers')}}">

                                        <input type="hidden" name="appraisal" value="{{$appraisalRef}}">

                                        <div class="form-container">
                                            <h5 class=""><i class="material-icons right blue-text text-darken-4">add_circle_outline</i>Assign Workflow Participants</h5>

                                            <div class="row spacer-top">
                                                <div class="input-field col s12">
                                                    <select name="supervisor" required class="validate">
                                                        <option value="" disabled selected>Choose Supervisor</option>
                                                        @if(isset($users) && count($users) > 0)
                                                            @foreach($users as $user)
                                                                <option value="{{$user->username}}">{{$user->fullName}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <label>Supervisor</label>
                                                </div>
                                                <div class="col s12 spacer"></div>
                                            </div>

                                            <div class="row spacer-top">
                                                <div class="input-field col s12">
                                                    <select name="hod" required class="validate">
                                                        <option value="" disabled selected>Choose Head of Department</option>
                                                        @if(isset($users) && count($users) > 0)
                                                            @foreach($users as $user)
                                                                <option value="{{$user->username}}">{{$user->fullName}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <label>Head of Department</label>
                                                </div>
                                                <div class="col s12 spacer"></div>
                                            </div>


                                            <div class="row spacer-top">
                                                <div class="input-field col s12">
                                                    <select name="ed" required class="validate">
                                                        <option value="" disabled selected>Choose Executive Director</option>
                                                        @if(isset($users) && count($users) > 0)
                                                            @foreach($users as $user)
                                                                <option value="{{$user->username}}">{{$user->fullName}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <label>Executive Director</label>
                                                </div>
                                                <div class="col s12 spacer"></div>
                                            </div>

                                            <div class="row">
                                                <div class="col s12">
                                                    @if(count($errors->all()) > 0)
                                                        <ul>
                                                            @foreach($errors->all() as $error)
                                                                <li class="invalid">{{$error}}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col s12 spacer"></div>
                                                <div class="col s12 center">
                                                    <button class="btn waves-effect waves-light camel-case blue darken-4" type="submit" name="action">Send to Workflow</button>
                                                </div>
                                            </div>
                                            {{csrf_field()}}
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>

    </main>

    @if(isset($formMessage) && strlen($formMessage) > 0))
    @include('includes.modal_form_message')
    @endif

@endsection
