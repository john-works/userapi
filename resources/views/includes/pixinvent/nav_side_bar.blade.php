<aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-light navbar-full sidenav-active-rounded">

    {{-- Brand logo start --}}
    <div class="brand-sidebar">
        <h1 class="logo-wrapper">
            <a class="brand-logo darken-1" href="index-2.html">
                <span class="logo-text hide-on-med-and-down">Appraisal MS</span>
            </a><a class="navbar-toggler" href="#"><i class="material-icons">radio_button_checked</i></a></h1>
    </div>
    {{-- Brand logo end --}}



    {{-- Begin side menu options --}}

    <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">

        <li class="active bold"><a class="collapsible-header waves-effect waves-cyan " href="{{route('admin_dashboard')}}"><i class="material-icons">settings_input_svideo</i>Dashboard</a></li>
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="{{route('users.all')}}"><i class="material-icons">perm_identity</i>System Users</a></li>
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="{{route('departments.all')}}"><i class="material-icons">group</i>Departments</a></li>
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="{{route('department-units.all')}}"><i class="material-icons">group</i>Department Units</a></li>
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="{{route('employee-categories.all')}}"><i class="material-icons">group_work</i>Employee Categories</a></li>
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="{{route('designations.all')}}"><i class="material-icons">group_work</i>Designations</a></li>
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="{{route('regional-offices.all')}}"><i class="material-icons">language</i>Regional Offices</a></li>
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="{{route('organization.all')}}"><i class="material-icons">business</i>Organizations</a></li>
        {{--<li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="{{route('admin.competence-categories.all')}}"><i class="material-icons">settings</i>Old Comp. Categories</a></li>--}}
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="{{route('admin.behavioral-competence-categories.all')}}"><i class="material-icons">settings</i>Competence Categories</a></li>
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="{{route('admin.objectives.all')}}"><i class="material-icons">trending_up</i>Strategic Objectives</a></li>
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="{{route('admin.appraisals.incomplete')}}"><i class="material-icons">dvr</i>Incomplete Appraisals</a></li>
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="{{route('admin.appraisals.complete')}}"><i class="material-icons">done</i>Completed Appraisals</a></li>

    </ul>

    {{-- End side menu options --}}


    <div class="navigation-background"></div><a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>

</aside>