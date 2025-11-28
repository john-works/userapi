<div id="sidebar" class="sidebar responsive col-md-4" data-sidebar="true" data-sidebar-scroll="true" data-sidebar-hover="true">
    <ul class="nav nav-list">
        <li class="{{ (($section == 'action_log_types' || $section == 'calendar_types' || $section == 'board_committees')?'active open':'active open' ) }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-caret-right"></i>
                General
                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li class="{{ (($section == 'action_log_types')?'active':'') }}">
                    <a href="{{ route('general_section','action_log_types') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Action Log Types
                    </a>

                    <b class="arrow"></b>
                </li>
                <li class="{{ (($section == 'calendar_types')?'active':'') }}">
                    <a href="{{ route('general_section','calendar_types') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Calendar Types
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="{{ (($section == 'board_committees')?'active':'') }}">
                    <a href="{{ route('general_section','board_committees') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Board Committees
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="{{ (($section == 'audit_types')?'active':'') }}">
                    <a href="{{ route('general_section','audit_types') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Audit Types
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="{{ (($section == 'audit_activities')?'active':'') }}">
                    <a href="{{ route('general_section','audit_activities') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Audit Activities
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="{{ (($section == 'shared_resources')?'active':'') }}">
                    <a href="{{ route('general_section','shared_resources') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Shared Resources
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>

    </ul>
</div>
