
@extends('layouts.master')
@section('title')
Staff Appraisal Form
@endsection
@section('page-level-css')
<link rel="stylesheet" href="{{ URL::asset('css/mstepper.min.css') }}" type="text/css"/>

<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
<meta http-equiv="Pragma" content="no-cache"/>
<meta http-equiv="Expires" content="0"/>
@endsection

@section('content')
<header> @include('includes.nav-bar-general') </header>

@if(count($errors->all()) > 0) @include('includes.modal-appraisal-form-error') @endif

<main class="stepper-container" >

    {{-- This the trigger as to whether the user can edit the form or not, if no we add the class edit-off, if yes we dont --}}
    <div class="hide {{isset($editClass) ? $editClass : ''}}"></div>

    <div class="row">

        <div class="col s12 l10 offset-l1 spacer-top ">
            <div class="col s12">
                <div class="col s12">
                    <div class="row valign-wrapper">
                        <div class="col s6 grey-text text-darken-1"><h5>Staff Appraisal Form</h5></div>
                        <div class="col s6 right"><a href="{{isset($appraisal) ? $appraisal->redirectTo:URL::previous()}}" class=" timo-primary-text right ">BACK<i class="material-icons left ">keyboard_arrow_left</i></a></div>
                    </div>
                    <div class="col s12 hr-dotted spacer-bottom"></div>
                    <div class="col s12 spacer-bottom step-by-step-registration">
                        @include('appraisals.stepped-registration')
                    </div>
                    <div style="display: block" class="col s12">

                    @if(isset($appraisal))

                       @if(isset($appraisal) && !$appraisal->isOwner && $appraisal->ownerUsername != $user->username)

                        <form class="col s12" method="post" action="{{route('appraisals.reject')}}">

                            <input type="hidden" name="appraisal_reference" value="{{$appraisal->appraisalRef}}"/>

                            <div class="col s12 spacer-top spacer-bottom">
                                <label class="red-text text-darken-4">After filling in and saving all the necessary information in all sections, press the Approve button to approve the Appraisal</label>
                            </div>
                            <div class="row spacer-top">
                                <label class="col s12" for="rejection_reason">Reason for rejection</label>
                                <div class="input-field col s12">
                                    <textarea rows="3" style="min-height: 25px" id="rejection_reason" name="rejection_reason" ></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col s12 spacer"></div>
                            </div>

                            <div class="row spacer-top">
                                <div class="col s6 "><button class="left btn-move-form btn waves-effect waves-light camel-case red  darken-2" type="submit" name="action">Reject</button>                                    </div>
                                <div class="col s6 "><a href="{{route('appraisals.approve',[$appraisal->appraisalRef,$appraisal->status])}}" class="right btn-move-form waves-effect waves-light btn camel-case green darken-2">Approve</a></div>
                            </div>

                            {{csrf_field()}}

                        </form>

                       @elseif(isset($appraisal) && $appraisal->isOwner && !$appraisal->isCancelled && !$appraisal->isCompleted)
                            <div class="col s12 spacer-top spacer-bottom">
                                <label class="red-text text-darken-4">After filling in and saving all the necessary information in all sections, press the Submit button to submit form to the next step in workflow</label>
                            </div>
                            <div class="row">
                                <div class="col s6 "><a href="{{route('appraisal-form.cancel',[$appraisal->appraisalRef])}}" class="left btn-move-form waves-effect waves-light btn camel-case red darken-2">Cancel</a></div>
                                <div class="col s6 "><a href="{{route('move_form',[$appraisal->appraisalRef,$appraisal->status])}}" class="right btn-move-form waves-effect waves-light btn camel-case green darken-2">Submit</a></div>
                            </div>
                       @endif

                    @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

</main>

@if(isset($formMessage) && strlen($formMessage) > 0))
    @include('includes.modal_form_message')
@elseif((isset($msg) && isset($isError)))
    @include('includes.modal-message')
@endif

@endsection
@section('page-level-js')
<script src="{{ URL::asset('js/mstepper.min.js') }}" type="text/javascript"> </script>
@endsection
