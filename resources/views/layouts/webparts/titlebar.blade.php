<link rel="shortcut icon" href="{{ asset('') }}favicon.ico">
		<div class="top-bar row">
			<div class="col-md-5" style="font-size: 60%;"><img src="{{ asset('img/logo.png') }}" alt="The Public Procurement and Disposal of Public Assets Authority" /></div>
			<div class="col-md-8 hide" style="font-size: 60%;">
				<div>THE PUBLIC PROCUREMENT AND DISPOSAL</div>
				<span>OF PUBLIC ASSETS AUTHORITY</span>
			</div>
			<div class="col-md-7"><img src="{{ asset('img/coa.png') }}" class="hide" /></div>

			<div class="col-md-7">
				<div class="col-md-6 text-left">
					<a href="{{ asset('') }}" class="navbar-brand">
						<small>
                            {{APP_NAME_CUSTOM}}
						</small>
					</a>
				</div>

				<div class="col-md-6">
					@if((session('user') != null))
                        <div class=" btn-group-minier clearfix">
                            <a style="margin-top: 20px;" href="{{route('logout_user')}}" class="btn btn-danger pull-right"><i class="ace-icon fa fa-power-off" style="padding-right: 5px"></i>Logout</a>
                            <a style="margin-top: 20px;" href="{{route('back-to-ppda-apps')}}" class="btn btn-primary pull-right"><i class="ace-icon fa fa-home" style="padding-right: 5px"></i>Back to PPDA Apps</a>
                        </div>
                        <div style="font-size: 1.4rem;padding-right: 5px" class="pull-right">{{ucwords((session('user')->fullName))}}</div>
					@endif
				</div>

			</div>


			</div>

		</div>

		<div id="navbar" class="navbar navbar-default navbar-collapse h-navbar">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left col-md-5">
					<!-- #section:basics/navbar.layout.brand -->
					@guest
						<a href="{{ asset('') }}" class="navbar-brand">
							<small style="display: none">
								Welcome  <span style="color:#fff; font-size:60%; ">Guest </span>
							</small>
						</a>
					@endguest

					<!-- /section:basics/navbar.layout.brand -->

					<!-- #section:basics/navbar.toggle -->
					<button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-buttons,.navbar-menu">
						<span class="sr-only">Toggle user menu</span>

						<span class="icon-bar"></span>

						<span class="icon-bar"></span>

						<span class="icon-bar"></span>

					</button>

					<button class="pull-right navbar-toggle navbar-toggle-img collapsed" type="button" data-toggle="collapse" data-target="#sidebar">
						<span class="sr-only">Toggle sidebar</span>

						<!-- <span class="icon-bar"></span>

						<span class="icon-bar"></span>

						<span class="icon-bar"></span> -->
					</button>

					<!-- /section:basics/navbar.toggle -->
				</div>

			@auth
				<!-- #section:basics/navbar.dropdown -->
				<div class="navbar-buttons navbar-header pull-right  collapse navbar-collapse hide" role="navigation">

					<ul class="nav ace-nav hide">

						<!-- #section:basics/navbar.user_menu -->
						<li class="light-blue user-min">

							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="{{ asset('') }}dashboard?sl=1">
										<i class="ace-icon fa fa-user"></i>
										Dashboard
									</a>
								</li>

								<li>
									<a href="#" target="_blank">
										<i class="ace-icon fa fa-question-circle"></i>
										Help
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="{{ asset('') }}logout?sl=1">
										<i class="ace-icon fa fa-power-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>

						<!-- /section:basics/navbar.user_menu -->
					</ul>
				</div>
			@endauth

				<div class="navbar-buttons navbar-header pull-right collapse navbar-collapse" role="navigation">

					<ul style="display:none"  class="nav ace-nav">
						<li class="transparent">
								<a data-toggle="dropdown" class="dropdown-toggle" href="#">
									<i class="ace-icon fa fa-bell icon-animated-bell"></i>
									<span class="badge badge-important">3</span>
								</a>

								<ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
									<li class="dropdown-header">
										<i class="ace-icon fa fa-exclamation-triangle"></i>
										3 Notifications
									</li>

									<li class="dropdown-content">
										<ul class="dropdown-menu dropdown-navbar navbar-pink">
											<li>
												<a href="#">
													<div class="clearfix">
														<span class="pull-left">
															<i class="btn btn-xs no-hover btn-pink fa fa-times"></i>
															Document(s) rejected
														</span>
														<span class="pull-right badge badge-info">+12</span>
													</div>
												</a>
											</li>

											<li>
												<a href="#">
													<i class="btn btn-xs btn-primary fa fa-exchange"></i>
													Document(s) forwarded.
												</a>
											</li>

											<li>
												<a href="#">
													<div class="clearfix">
														<span class="pull-left">
															<i class="btn btn-xs no-hover btn-success fa fa-check"></i>
															Document(s) approved
														</span>
														<span class="pull-right badge badge-success">+8</span>
													</div>
												</a>
											</li>


										</ul>
									</li>

									<li class="dropdown-footer">
										<a href="tracking.php">
											See all notifications
											<i class="ace-icon fa fa-arrow-right"></i>
										</a>
									</li>
								</ul>
							</li>

						</ul>
					</div>

				<!-- /section:basics/navbar.dropdown -->
				<nav role="navigation" class="navbar-menu pull-right collapse navbar-collapse">
					<!-- #section:basics/navbar.nav -->
					<ul class="nav navbar-nav">
						<li class="hide">
							<a href="{{ url('/home') }}">
								Home&nbsp;
							</a>
						</li>
						<li class="hide">
							<a class="close_tab" href="javascript:void(0);">
								Hide/Show Administration tab&nbsp;
							</a>
						</li>
						<li>
							<a href="#!">
								FAQs&nbsp;
							</a>
						</li>
						<li class="hide">
							<a href="{{ asset('') }}contacts?tp=2">
								Contacts&nbsp;
							</a>
						</li>
					</ul>
					<!-- /section:basics/navbar.nav -->
				</nav>
			</div><!-- /.navbar-container -->
		</div>
