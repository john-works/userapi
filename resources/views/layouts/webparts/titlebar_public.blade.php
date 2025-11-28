
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
							Letter Movement Application  <span style="color:#fff; font-size:60%; display: none;">Search Engine </span>
						</small>
					</a>
				</div>
                <div class="col-md-6" style="display: none">
                    <h5 class="grey bolder- text-left pull-right" style="margin-left: 20px;line-height: 1.4;margin-top: 3px;">
                        <small style="display: inline-block;">
                            Welcome Guest
                        </small>
                        <br>
                        <a class="smaller-70" href="{{ asset('dashboard') }}">
                            <i class="ace-icon fa fa-tachometer"></i>
                            Home
                        </a>
                    </h5>
                    <i class="fa fa-user bigger-150 pull-right light-grey"></i>
                </div>
			</div>


			</div>

		</div>

		<div id="navbar" class="navbar navbar-default    navbar-collapse       h-navbar">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left col-md-5">
					<!-- #section:basics/navbar.layout.brand -->
					<h4 class="text-white-50"></h4>

					<!-- /section:basics/navbar.layout.brand -->

					<!-- #section:basics/navbar.toggle -->
					<button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-buttons,.navbar-menu">
						<span class="sr-only">Toggle user menu</span>

						<span class="icon-bar"></span>

						<span class="icon-bar"></span>

						<span class="icon-bar"></span>
						<!-- <img src="{{ asset('') }}avatars/user.jpg" alt="Jason's Photo" /> -->
					</button>

					<button class="pull-right navbar-toggle navbar-toggle-img collapsed" type="button" data-toggle="collapse" data-target="#sidebar">
						<span class="sr-only">Toggle sidebar</span>

						<img src="{{ asset('') }}avatars/user.jpg" alt="Jason's Photo" />

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
								<img class="nav-user-photo" src="{{ asset('') }}avatars/user.jpg" alt="<?php echo '$fname'; ?>'s Photo" />


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
									<a href="{{ asset('') }}faqs?sl=1" target="_blank">
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

				<div class="user-info pull-right hide" style="min-width:400px; color: #fff; text-align: right;">
					<small style="display: inline-block;">Welcome,</small>
				</div>

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
						<li>
							<a href="{{ route('login') }}">
								Home&nbsp;
							</a>
						</li>
					</ul>
					<!-- /section:basics/navbar.nav -->
				</nav>
			</div><!-- /.navbar-container -->
		</div>
