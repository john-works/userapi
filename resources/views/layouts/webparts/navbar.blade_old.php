<!-- _@auth -->
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
				</div><!-- /.sidebar-shortcuts -->


				<ul class="nav nav-list">
					<li @if(isset($level) && ($level == 'reception' || $level == 'super_user')) @else style="display: none" @endif class="{{ (($menu_selected == 'reception' || $menu_selected == 'entity_branches' || $menu_selected == 'entity_people' || $menu_selected == 'entity_audit_history' || $menu_selected == 'entity_mgt')?'active':'') }} hover">
						<a href="{{route('home') }}" class="dropdown-toggle-">
							<i class="menu-icon fa fa-building"></i>
							<span class="menu-text">
								Reception
							</span>
						</a>
						<b class="arrow-"></b>
					</li>
					<li @if(isset($level) && ($level == 'registry' || $level == 'super_user')) @else style="display: none"  @endif  class="{{ (($menu_selected == 'registry')?'active':'') }} hover">
						<a href="{{ route('registry') }}">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Registry </span>
						</a>
						<b class="arrow"></b>
					</li>
					<li @if(isset($level) && ($level == 'ed_office' || $level == 'super_user')) @else style="display: none"  @endif  class="{{ (($menu_selected == 'ed_office')?'active':'') }} hover">
						<a href="{{ route('ed_office') }}">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> ED's Office </span>
						</a>
						<b class="arrow"></b>
					</li>
					<li class="{{ (($menu_selected == 'letter_movements')?'active':'') }} hover">
						<a href="{{route('letter_movement')}}">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Letter Movements </span>
						</a>
						<b class="arrow"></b>
					</li>
					<li @if(isset($level) && ($level == 'ed_office' || $level == 'registry' || $level == 'super_user')) @else style="display: none"  @endif  class="{{ (($menu_selected == 'outgoingletters')?'active':'') }} hover">
						<a href="{{ route('outgoingletters') }}">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Outgoing Letters </span>
						</a>
						<b class="arrow"></b>
					</li>
					<li @if(isset($level) && ($level == 'super_user')) @else style="display: none"  @endif class="{{ (($menu_selected == 'master_data')?'active':'') }} hover master_data_tab hide-">
						<a href="{{ route('master_data_index') }}">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Master Data </span>
						</a>
						<b class="arrow"></b>
					</li>

					<button type="button" class="sidebar-collapse btn btn-white btn-primary pull-right" data-target="#sidebar">
						<i class="ace-icon fa fa-angle-double-up" data-icon1="ace-icon fa fa-angle-double-up" data-icon2="ace-icon fa fa-angle-double-down"></i>

					</button>

				</ul><!-- /.nav-list -->

				<!-- #section:basics/sidebar.layout.minimize -->

				<!-- /section:basics/sidebar.layout.minimize -->
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>

<!-- _@endauth -->
