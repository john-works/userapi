
<div class="navbar navbar-fixed">

    <nav class="navbar-main navbar-color nav-collapsible sideNav-lock navbar-dark blue darken-4">

        <div class="nav-wrapper">

            <div class="header-search-wrapper hide-on-med-and-down"><i class="material-icons">search</i>
                <input class="header-search-input z-depth-2" type="text" name="Search" placeholder="Explore Appraisal MS">
            </div>
            <ul class="navbar-list right">
                <li class="hide-on-med-and-down"><a class="waves-effect waves-block waves-light translation-button" href="javascript:void(0);" data-target="translation-dropdown"><span class="flag-icon flag-icon-ug"></span></a></li>
                <li class="hide-on-med-and-down"><a class="waves-effect waves-block waves-light toggle-fullscreen" href="javascript:void(0);"><i class="material-icons">settings_overscan</i></a></li>
                <li class="hide-on-large-only"><a class="waves-effect waves-block waves-light search-button" href="javascript:void(0);"><i class="material-icons">search</i></a></li>
                <li><a class="waves-effect waves-block waves-light notification-button" href="javascript:void(0);" data-target="notifications-dropdown"><i class="material-icons">notifications_none<small class="notification-badge">0</small></i></a></li>
                <li><a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);" data-target="profile-dropdown"><span class="avatar-status avatar-online"><img src="{{ URL::asset('images/avatar.jpg')}}" alt="avatar"><i></i></span></a></li>

            </ul>
            <!-- translation-button-->
            <ul class="dropdown-content" id="translation-dropdown">
                <li><a class="grey-text text-darken-1" href="#!"><i class="flag-icon flag-icon-ug"></i> Uganda</a></li>
            </ul>
            <!-- notifications-dropdown-->
            <ul class="dropdown-content" id="notifications-dropdown">
                <li>
                    <h6>NOTIFICATIONS<span class="new badge">0</span></h6>
                </li>
                <li class="divider"></li>
                {{--<li><a class="grey-text text-darken-2" href="#!"><span class="material-icons icon-bg-circle red small">stars</span> Completed the task</a>
                    <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">3 days ago</time>
                </li>--}}
            </ul>

            <!-- profile-dropdown-->
            <ul class="dropdown-content" id="profile-dropdown">
                <li><a class="grey-text text-darken-1" href="{{route('users.change-password-form')}}"><i class="material-icons">lock</i>Password</a></li>
                <li><a class="grey-text text-darken-1" href="{{route('singout_admin')}}"><i class="material-icons">keyboard_tab</i> Logout</a></li>
            </ul>

        </div>

        <nav class="display-none search-sm">
            <div class="nav-wrapper">
                <form>
                    <div class="input-field">
                        <input class="search-box-sm" type="search" required="">
                        <label class="label-icon" for="search"><i class="material-icons search-sm-icon">search</i></label><i class="material-icons search-sm-close">close</i>
                    </div>
                </form>
            </div>
        </nav>

    </nav>

</div>
