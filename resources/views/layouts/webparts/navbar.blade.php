
<?php $rights = json_decode(decrypt(session('access_rights'))); ?>
 <div id="sidebar" class="sidebar h-sidebar navbar-collapse collapse" <?php echo 'style="display: none- !important;"'; ?>>
	<script type="text/javascript">
		try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
	</script>
	<div class="sidebar-shortcuts" id="sidebar-shortcuts" style="display:none;">
		<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
			<button class="btn btn-success">
				<i class="ace-icon fa fa-signal"></i>
			</button>

			<button class="btn btn-info">
				<i class="ace-icon fa fa-pencil"></i>
			</button>

			<!-- #section:basics/sidebar.layout.shortcuts -->
			<button class="btn btn-warning">
				<i class="ace-icon fa fa-users"></i>
			</button>

			<button class="btn btn-danger">
				<i class="ace-icon fa fa-cogs"></i>
			</button>

			<!-- /section:basics/sidebar.layout.shortcuts -->
		</div>

		<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
			<span class="btn btn-success"></span>

			<span class="btn btn-info"></span>

			<span class="btn btn-warning"></span>

			<span class="btn btn-danger"></span>
		</div>
	</div>
	<ul class="nav nav-list">
		<li class="{{ (($menu_selected == 'actionlogs') ? 'active':'') }} hover">
			<a href="#" class="dropdown-toggle-">
				<i class="menu-icon fa fa-building"></i>
				<span class="menu-text">
					Action Logs
				</span>
			</a>
			<b class="arrow-"></b>
			<ul class="submenu">
				<li class="hover open {{ (($menu_selected == MENU_ITEM_ACTIONLOGS_MY_ACTION)?'active':'') }}">
					<a href="{{route('actionlogs',MENU_ITEM_ACTIONLOGS_MY_ACTION)}}">
						<i class="menu-icon fa fa-caret-right"></i>
						Pending My Action
					</a>
					<b class="arrow"></b>
				</li>
				<li class="hover open {{ (($menu_selected == MENU_ITEM_ACTIONLOGS_MY_DEPARTMENT)?'active':'') }}">
					<a href="#">
						<i class="menu-icon fa fa-caret-right"></i>
						Department Action Logs
					</a>
					<b class="arrow"></b>
					<ul class="submenu">
						<li class="hover">
							<a href="{{route('actionlogs.department',MENU_ITEM_ACTIONLOGS_MY_DEPARTMENT_OPEN)}}">
								<i class="menu-icon fa fa-caret-right"></i>
								Open
							</a>
						</li>
						<li class="hover">
							<a href="{{route('actionlogs.department',MENU_ITEM_ACTIONLOGS_MY_DEPARTMENT_PENDING)}}">
								<i class="menu-icon fa fa-caret-right"></i>
								Pending Closure
							</a>
						</li>
						<li class="hover">
							<a href="{{ route('actionlogs.department',MENU_ITEM_ACTIONLOGS_MY_DEPARTMENT_CLOSED) }}">
								<i class="menu-icon fa fa-caret-right"></i>
								Closed
							</a>
						</li>
					</ul>
				</li>
				@if(authenticate_module_subsection_access(MODULE_ACTION_LOGS,BOARD_ACTION_LOGS,$rights))
				<li class="hover open {{ (($menu_selected == MENU_ITEM_ACTIONLOGS_BOARD)?'active':'') }}">
					<a href="{{route('actionlogs',MENU_ITEM_ACTIONLOGS_BOARD)}}">
						<i class="menu-icon fa fa-caret-right"></i>
						Board Action Logs
					</a>
					<b class="arrow"></b>
				</li>
				@endif
				@if(authenticate_module_subsection_access(MODULE_ACTION_LOGS,EXCO_ACTION_LOGS,$rights))
				<li class="hover open {{ (($menu_selected == MENU_ITEM_ACTIONLOGS_EXCO)?'active':'') }}">
					<a href="{{route('actionlogs',MENU_ITEM_ACTIONLOGS_EXCO)}}">
					
						<i class="menu-icon fa fa-caret-right"></i>
						Exco Action Logs
					</a>
					<b class="arrow"></b>
				</li>
				@endif
				@if(authenticate_module_subsection_access(MODULE_ACTION_LOGS,ALL_ACTION_LOGS,$rights))
				<li class="hover open {{ (($menu_selected == MENU_ITEM_ACTIONLOGS)?'active':'') }}">
					<a href="{{route('actionlogs',MENU_ITEM_ACTIONLOGS) }}">
						<i class="menu-icon fa fa-caret-right"></i>
						Action Logs - All
					</a>
					<b class="arrow"></b>
				</li>
				@endif
			</ul>
		</li>
		<li class="{{ (($menu_selected == 'calendar_amin') ? 'active':'') }} hover">
			<a href="#" class="dropdown-toggle-">
				<i class="menu-icon fa fa-building"></i>
				<span class="menu-text">
					Calendar Admin
				</span>
			</a>
			<b class="arrow-"></b>
			<ul class="submenu">
				<li class="hover open {{ (($menu_selected == MENU_ITEM_DEPARTMENT_CALENDAR)?'active':'') }}">
					<a href="#" id="department_calendar" class="calendar_btn" title="Department Calendar" data-ref="{{MENU_ITEM_DEPARTMENT_CALENDAR}}">
						<i class="menu-icon fa fa-caret-right"></i>
						Department Calendar
					</a>
					<b class="arrow"></b>
				</li>
				@if(authenticate_module_subsection_access(MODULE_CALENDAR_ADMIN,BOARD_CALENDAR,$rights))
				<li class="hover open {{ (($menu_selected == MENU_ITEM_BOARD_CALENDAR)?'active':'') }}">
					<a href="#" id="board_calendar" class="calendar_btn" title="Board Calendar" data-ref="{{MENU_ITEM_BOARD_CALENDAR}}">
						<i class="menu-icon fa fa-caret-right"></i>
						Board Calendar
					</a>
					<b class="arrow"></b>
				</li>
				@endif
				@if(authenticate_module_subsection_access(MODULE_CALENDAR_ADMIN,EXCO_CALENDAR,$rights))
				<li class="hover open {{ (($menu_selected == MENU_ITEM_EXCO_CALENDAR)?'active':'') }}">
					<a href="#" id="exco_calendar" class="calendar_btn" title="Exco Calendar" data-ref="{{MENU_ITEM_EXCO_CALENDAR}}">
						<i class="menu-icon fa fa-caret-right"></i>
						Exco Calendar
					</a>
					<b class="arrow"></b>
				</li>
				@endif
				@if(authenticate_module_subsection_access(MODULE_CALENDAR_ADMIN,TRAINING_ROOM_CALENDAR,$rights))
				<li class="hover open {{ (($menu_selected == MENU_ITEM_TRAINING_ROOM_CALENDAR)?'active':'') }}">
					<a href="#" id="training_room_calendar" class="calendar_btn" title="Training Room Calendar" data-ref="{{MENU_ITEM_TRAINING_ROOM_CALENDAR}}">
						<i class="menu-icon fa fa-caret-right"></i>
						Training Room Calendar
					</a>
					<b class="arrow"></b>
				</li>
				@endif
				<li class="hover open {{ (($menu_selected == MENU_ITEM_PM_CALENDAR)?'active':'') }}">
					<a href="#" id="pm_calendar" class="calendar_btn" title="PM Calendar" data-ref="{{MENU_ITEM_PM_CALENDAR}}">
						<i class="menu-icon fa fa-caret-right"></i>
						PM Calendar
					</a>
					<b class="arrow"></b>
				</li>
			</ul>
		</li>
		@if(getAuthUser()->is_admin == 1)
			@if(authenticate_module_access(MODULE_ADMIN, $rights))
				<li class="{{ ((in_array($menu_selected,[MENU_ITEM_ADMIN_USER_MANAGEMENT,MENU_ITEM_ADMIN_ERROR_LOGS,MENU_ITEM_ADMIN_RUN_JOBS,MENU_ITEM_ADMIN_MASTER_DATA_HISTORY]) )?'active':'') }} hover">
					<a href="javascript:void(0)" class="dropdown-toggle">
						<i class="menu-icon fa fa-gears"></i>
						<span class="menu-text">
								Administration
						</span>
					</a>
					<b class="arrow"></b>
					<ul class="submenu">
						<li class="hover open {{ (($menu_selected == MENU_ITEM_ADMIN_USER_MANAGEMENT)?'active':'') }}">
						
							<a href="{{route('administration.users.index')}}">
							
								<i class="menu-icon fa fa-caret-right"></i>
							User Management
							</a>
							<b class="arrow"></b>
						</li>
						<li class="hover open {{ (($menu_selected == MENU_ITEM_ADMIN_MASTER_DATA_HISTORY)?'active':'') }}">
							<a href="{{route('administration.master_data_history')}}">
								<i class="menu-icon fa fa-caret-right"></i>
								Master Data History
							</a>
							<b class="arrow"></b>
						</li>
					</ul>
					@endif
					<li @if(authenticate_module_access(MODULE_MASTER_DATA, $rights)) @else style="display: none"  @endif class="{{ (($menu_selected == 'master_data')?'active':'') }} hover master_data_tab hide-">
						<a href="{{ route('master_data_index') }}">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Master Data </span>
						</a>
						<b class="arrow"></b>
					</li>
				</li>
		@endif
	</ul>
	<script type="text/javascript">
		try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
	</script>
</div>