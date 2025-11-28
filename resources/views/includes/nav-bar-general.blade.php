<div style="width: 100%" class="grey lighten-2">
<div class="container ">
    <div class="row " id="logo-section">
        <div class="col l3 m12 s12 left valign-wrapper"><img src="{{URL::asset('images/ppda-logo.png')}}"></div>
        <div class="col l6 m12 s12 center"></div>
        <nav class="col l3 m12 s12 transparent z-depth-0">
            <ul><li class="right"><a class="dropdown-button valign-wrapper blue-text text-darken-4" data-activates="drop_down_profile"  data-constrainwidth="false" data-hover="false" data-beloworigin="true" href="#!"  ><i class="material-icons left">account_circle</i>@if(session()->has('user')){{strtoupper(session('user')->fullName)}}@else{{'USER'}}@endif<i class="material-icons right">arrow_drop_down</i></a></li></ul>
        </nav>
    </div>
</div>
</div>

<nav>
    <div class="nav-wrapper blue darken-4 nav-border-bottom">

        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down nav-bar-customize ">
            @if(session('user'))
                <li>
                    <a class="@if($active_module == 'my_appraisals') active-module @endif nav-border-left nav-border-right" href="{{route('appraisal-forms.owner')}}">My Appraisals</a>
                </li>
                <li>
                    <a class="@if($active_module == 'supervisor_appraisals') active-module @endif nav-border-right" href="{{route('appraisal-forms.supervisor')}}">Supervisor Approvals</a>
                </li>
                <li>
                    <a class="@if($active_module == 'hod_appraisals') active-module @endif nav-border-right" href="{{route('appraisal-forms.hod')}}">HOD Approvals</a>
                </li>
                <li>
                    <a class="@if($active_module == 'director_appraisals') active-module @endif nav-border-right" href="{{route('appraisal-forms.director')}}">Executive Director Approvals</a>
                </li>

                @if(session('user')->roleCode == 'HR')
                <li>
                    <a class="@if($active_module == 'hr') active-module @endif nav-border-right " href="{{route('human-resource.index')}}" >Human Resource</a>
                </li>
                @endif
                <li>
                    <a class="@if($active_module == 'profiles') active-module @endif nav-border-right " href="{{route('users.profile')}}" >Profile</a>
                </li>

            @endif
        </ul>

        <ul class="side-nav" id="mobile-demo">
            @if(session('user'))
                <li>
                    <a class="@if($active_module == 'my_appraisals') active-module @endif nav-border-left nav-border-right" href="{{route('appraisal-forms.owner')}}">My Appraisals</a>
                </li>
                <li>
                    <a class="@if($active_module == 'supervisor_appraisals') active-module @endif nav-border-right" href="{{route('appraisal-forms.supervisor')}}">Supervisor Approvals</a>
                </li>
                <li>
                    <a class="@if($active_module == 'hod_appraisals') active-module @endif nav-border-right" href="{{route('appraisal-forms.hod')}}">HOD Approvals</a>
                </li>
                <li>
                    <a class="@if($active_module == 'director_appraisals') active-module @endif nav-border-right" href="{{route('appraisal-forms.director')}}">Executive Director Approvals</a>
                </li>
                @if(session('user')->roleCode == 'HR')
                <li>
                    <a class="@if($active_module == 'hr') active-module @endif nav-border-right " href="{{route('human-resource.index')}}" >Human Resource</a>
                </li>
                @endif
                <li>
                    <a class="@if($active_module == 'profiles') active-module @endif nav-border-right " href="{{route('users.profile')}}" >Profile</a>
                </li>
            @endif
        </ul>

    </div>
</nav>

<ul id="drop_down_profile" class="dropdown-content">
    <li><a href="{{route('users.change-password-form')}}"><i class="material-icons left">settings</i>Change Password</a></li>
    <li><a href="{{route('singout_admin')}}"><i class="material-icons left">lock_open</i>Logout</a></li>
</ul>

