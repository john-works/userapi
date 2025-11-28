
<ul id="drop_down_users" class="dropdown-content">
    <li><a href="{{route('user_registration_form')}}">Add user</a></li>
    <li><a href="{{route('user_profiles')}}">Manage users</a></li>
</ul>

<ul id="drop_down_document_types" class="dropdown-content">
    <li><a href="{{route('document_types')}}">Manage</a></li>
    <li><a href="{{route('create_document_type_form')}}">New</a></li>
    <li><a href="{{route('add_document_type_form')}}">Add Document Type</a></li>
</ul>

<ul id="drop_down_settings" class="dropdown-content">
    <li><a href="{{route('roles')}}">Roles</a></li>
    <li><a href="{{route('departments')}}">Departments</a></li>
</ul>

<nav>
    <div class="nav-wrapper blue darken-4">

        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>

        <ul class="right hide-on-med-and-down">

            <li>
                <a href="{{route('admin_dashboard')}}" @if($active_module == 'dashboard') class="active-module" @endif>
                    <i class="material-icons left">dashboard</i>Dashboard
                </a>
            </li>

            <li>
                <a class="dropdown-trigger @if($active_module == 'users') active-module @endif" href="#!" data-beloworigin="true" data-constrainwidth="false" data-hover="true"   data-activates="drop_down_users">
                    <i class="material-icons left">group</i>Users
                </a>
            </li>

            <li>
                <a class="dropdown-trigger @if($active_module == 'settings') active-module @endif"
                   href="#!" data-beloworigin="true" data-constrainwidth="false" data-hover="true"   data-activates="drop_down_settings">
                    <i class="material-icons left">settings</i>Settings
                </a>
            </li>

            <li>
                <a href="{{route('singout_admin')}}">
                    <i class="material-icons left">lock_open</i>Logout
                </a>
            </li>

        </ul>


        <ul class="side-nav" id="mobile-demo">

            <li>
                <a href="{{route('admin_dashboard')}}" @if($active_module == 'dashboard') class="active-module" @endif>
                    <i class="material-icons left">dashboard</i>Dashboard
                </a>
            </li>

            <li>
                <a class="dropdown-button @if($active_module == 'users') active-module @endif" href="#!" data-beloworigin="true" data-constrainwidth="false" data-hover="true"   data-activates="drop_down_users">
                    <i class="material-icons left">group</i>Users
                </a>
            </li>

            <li>
                <a class="dropdown-button @if($active_module == 'settings') active-module @endif"
                   href="#!" data-beloworigin="true" data-constrainwidth="false" data-hover="true"   data-activates="drop_down_settings">
                    <i class="material-icons left">settings</i>Settings
                </a>
            </li>

            <li>
                <a href="{{route('singout_admin')}}">
                    <i class="material-icons left">lock_open</i>Logout
                </a>
            </li>

        </ul>


    </div>
</nav>