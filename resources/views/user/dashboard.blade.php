
@extends('layouts.master')
@section('title')
    Dashboard | {{config('app.name')}}
@endsection

@section('content')

    <header>
        @include('includes.nav-bar-general')
    </header>

    <main class="container">

        <div class="row spacer-top">

            {{-- Profile Panel --}}
            <div class="col l4 s12">

                <div class="col s12">

                    <div id="profile-card" class="card">
                        <div class="card-image waves-effect waves-block waves-light">
                            <img class="activator" src="{{asset('images/user-bg-2.jpg')}}" alt="user background">
                        </div>
                        <div class="card-content">
                            <img src="{{asset('images/avatar.jpg')}}" alt="" class="circle responsive-img activator card-profile-image">
                            <a class="btn-floating activator btn-move-up waves-effect waves-light blue darken-4 right">
                                <i class="material-icons mdi-action-account-circle">more_vert</i>
                            </a>

                            <span class="card-title activator grey-text text-darken-2">{{$user->fullName}}</span>
                            <p><i class="mdi-action-perm-identity cyan-text text-darken-2"></i>Department: {{$user->departmentName}}</p>
                            <p><i class="mdi-action-perm-phone-msg cyan-text text-darken-2"></i>Email: {{$user->email}}</p>
                            <p><i class="mdi-communication-email cyan-text text-darken-2"></i>Role: {{$user->roleName}}</p>

                        </div>
                        <div class="card-reveal">
                            <span class="card-title grey-text text-darken-2">{{strtoupper($user->fullName)}} <i class="material-icons right">close</i></span>
                            <p><i class="mdi-action-perm-identity cyan-text text-darken-2"></i>Department: {{$user->departmentName}}</p>
                            <p><i class="mdi-action-perm-phone-msg cyan-text text-darken-2"></i>Email: {{$user->email}}</p>
                            <p><i class="mdi-communication-email cyan-text text-darken-2"></i>Role: {{$user->roleCode}}</p>
                        </div>
                    </div>

                </div>

                <div class="col s12 center spacer-top">
                    <a class="col s12 btn blue darken-4" href="{{route('create_appraisal')}}">Create New Appraisal Form</a>
                </div>

            </div>

            {{-- Main Content Panels, has the appraisals --}}

            <div class="col l8 s12">

                {{-- Appraisals created by you --}}
                <div class="col s12">
                    <div class="col s12">
                        <ul id="issues-collection" class="collection">
                            <li class="collection-item avatar">
                                <i class="material-icons circle blue darken-4">folder</i>
                                <span class="collection-header">Appraisals</span>
                                <p>Initiated by you</p>
                            </li>

                            @if(isset($appraisals) && count($appraisals) > 0)

                                @foreach($appraisals as $appraisal)

                                    @if($loop->iteration <= 3)
                                        <li class="collection-item">
                                            <div class="row row-custom-modal-footer collections-title">
                                                <div class="col s12"><strong>{{$loop->iteration}}.&nbsp;</strong>{{str_replace('_',' ',$appraisal->generatedPdfName)}}</div>
                                            </div>
                                            <div class="row row-custom-modal-footer valign-wrapper">
                                                <div class="col s4"><p>Date: <span class="text-primary">{{$appraisal->createdAt}}</span></p></div>
                                                <div class="col s5">
                                                    <span class="task-cat blue-stepper">
                                                        @if(isset($summaries))
                                                            @foreach($summaries as $summary)
                                                                @if($summary['id'] == $appraisal->appraisalRef)
                                                                    {{$summary['stage']}}
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="col s2">
                                                    <div class="progress">
                                                        <div class="determinate blue darken-4"
                                                             @if(isset($summaries))
                                                             @foreach($summaries as $summary)
                                                             @if($summary['id'] == $appraisal->appraisalRef)
                                                             style="width: {{$summary['percentage']}};"
                                                                @endif
                                                                @endforeach
                                                                @endif
                                                        ></div>
                                                    </div>
                                                </div>
                                                <div class="col s1">
                                                    <p class=" camel-case"><a class="text-primary bold-text" href="{{route('appraisal-forms.show',[$appraisal->appraisalRef])}}">View</a></p>
                                                </div>
                                            </div>

                                        </li>
                                    @endif

                                @endforeach

                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s12 spacer-top">
                                            <a href="{{route('appraisal-forms.owner')}}">View all your appraisals</a>
                                        </div>
                                    </div>
                                </li>

                            @else

                                <li class="collection-item">
                                    <div class="col s12 bold-text">
                                        <p>You have not yet saved any appraisals yet</p>
                                    </div>
                                </li>

                            @endif

                        </ul>
                    </div>
                </div>

                {{-- Appraisal assigned to you --}}
                <div class="col s12">
                    <div class="col s12">
                        <ul id="issues-collection" class="collection">
                            <li class="collection-item avatar">
                                <i class="material-icons circle btn-primary-custom">assignment</i>
                                <span class="collection-header">Appraisals</span>
                                <p>Assigned to you</p>
                            </li>

                            @if(isset($appraisalsAssigned) && count($appraisalsAssigned) > 0)

                                @foreach($appraisalsAssigned as $appraisal)

                                    @if($loop->iteration <= 3)
                                        <li class="collection-item">
                                            <div class="row row-custom-modal-footer collections-title">
                                                <div class="col s12"><strong>{{$loop->iteration}}.&nbsp;</strong>{{str_replace('_',' ',$appraisal->generatedPdfName)}}</div>
                                            </div>

                                            <div class="row row-custom-modal-footer valign-wrapper">
                                                <div class="col s4"><p>Date: <span class="text-primary">{{$appraisal->createdAt}}</span></p></div>
                                                <div class="col s5">
                                                    <span class="task-cat blue darken-4">
                                                    @if(isset($assignedSummaries))
                                                            @foreach($assignedSummaries as $summary)
                                                                @if($summary['id'] == $appraisal->appraisalRef)
                                                                    {{$summary['stage']}}
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                     </span>
                                                </div>
                                                <div class="col s2">
                                                    <div class="progress">
                                                        <div class="determinate red darken-4"
                                                             @if(isset($assignedSummaries))
                                                             @foreach($assignedSummaries as $summary)
                                                             @if($summary['id'] == $appraisal->appraisalRef)
                                                             style="width: {{$summary['percentage']}};"
                                                                @endif
                                                                @endforeach
                                                                @endif
                                                        ></div>
                                                    </div>
                                                </div>
                                                <div class="col s1">
                                                    <p class=" camel-case"><a class="red-text text-darken-4 bold-text" href="{{route('appraisal-forms.show',[$appraisal->appraisalRef])}}">View</a></p>
                                                </div>

                                            </div>
                                        </li>
                                    @endif

                                @endforeach

                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s12 spacer-top">
                                            <a href="">View all your assignments</a>
                                        </div>
                                    </div>
                                </li>

                            @else

                                <li class="collection-item">
                                    <div class="col s12 bold-text">
                                        <p>You do not have any assignments for now</p>
                                    </div>
                                </li>

                            @endif

                        </ul>
                    </div>
                </div>

            </div>


        </div>

        {{-- Message modal --}}
        @if(isset($msg) && isset($isError))
            @include('includes.modal-message')
        @endif

    </main>

@endsection
