@extends('layouts.master')
@section('title')
    Approve Appraisal | {{config('app.name')}}
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

                                    <form class="col s12" method="post" action="{{route('approve_or_reject')}}">

                                        <input type="hidden" name="appraisal_reference" value="{{$appraisalRef}}">
                                        <input type="hidden" name="appraisal_status" value="{{$appraisalStatus}}">

                                        <div class="form-container">

                                            <h5 class=""><i class="material-icons right blue-text text-darken-4">add_circle_outline</i>Approve or Reject Appraisal</h5>

                                            <div class="row ">
                                                <div class="input-field col s12">
                                                    <p>
                                                        <input name="approval_decision" value="approved" checked type="radio" id="approved" />
                                                        <label for="approved">Approve</label>
                                                    </p>
                                                    <p>
                                                        <input name="approval_decision" value="rejected" type="radio" id="rejected" />
                                                        <label for="rejected">Reject</label>
                                                    </p>
                                                </div>
                                                <div class="input-field col s12 spacer-bottom"></div>
                                            </div>

                                            <div class="row spacer-top">
                                                <label class="col s12" for="rejection_reason">Reason for rejection</label>
                                                <div class="input-field col s12">
                                                    <textarea id="rejection_reason" name="rejection_reason" class="browser-default"></textarea>
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
                                                    <button class="btn waves-effect waves-light camel-case blue darken-4" type="submit" name="action">Submit</button>
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