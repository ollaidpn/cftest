	<div id="page" class="stylehome1 h0" style="background-color:white !important">
		<div class="mobile-menu" style="background-color:white !important">
	        <ul class="header_user_notif dashbord_pages_mobile_version pull-right">
                <li class="user_notif">
					<div class="dropdown">
					    <a class="notification_icon" href="#" data-toggle="dropdown"><span class="flaticon-email"></span></a>
					    <div class="dropdown-menu notification_dropdown_content">
							<div class="so_heading">
								<p>Notifications</p>
							</div>
							<div class="so_content" data-simplebar="init">
								<ul>
                                    <li>
                                        <h5>12/12/2020</h5>
                                        <p>Ceci est un notification ........................................................</p>
                                    </li>
								</ul>
							</div>
							<a class="view_all_noti text-thm" href="#">Voir tous</a>
					    </div>
					</div>
                </li>
                <li class="user_notif">
					<div class="dropdown">
					    <a class="notification_icon" href="#" data-toggle="dropdown"><span class="flaticon-alarm"></span></a>
					    <div class="dropdown-menu notification_dropdown_content">
							<div class="so_heading">
								<p>Notifications</p>
							</div>
							<div class="so_content" data-simplebar="init">
								<ul>
								<li>
											<h5>12/12/2020</h5>
											<p>Ceci est un notification ........................................................</p>
										</li>
								</ul>
							</div>
							<a class="view_all_noti text-thm" href="#">Voir tous</a>
					    </div>
					</div>
                </li>
                <li class="user_setting">
						<div class="dropdown">
	                		<a class="btn dropdown-toggle" href="#" data-toggle="dropdown"><img class="rounded-circle" src="{{ Auth::user()->image() }}" alt="avatar.png"></a>
						    <div class="dropdown-menu">
						    	<div class="user_set_header">
						    		<img class="float-left" src="{{ Auth::user()->image() }}" alt="e1.png">
							    	<p><strong>{{ Auth::user()->getFullName() }}</strong></p>
						    	</div>
						    	<div class="user_setting_content">
									<a class="dropdown-item active" href="settings.php">Paramètres de compte</a>
									<a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Se déconnecter</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

						    	</div>
						    </div>
						</div>
			        </li>
            </ul>
			<div class="header stylehome1 dashbord_mobile_logo" style="background-color:white !important" >
				<div class="main_logo_home2" style="background-color:white !important">
		            <img class="nav_logo_img ml-0 img-fluid float-left mt15" src="{{ getInfoSystem() ? getInfoSystem()->getLogo() : '' }}" style="height:70px;" alt="header-logo.png">
				</div>
				<ul class="menu_bar_home2">
					<li class="list-inline-item"></li>
					<li class="list-inline-item"><a href="#menu" style="font-size:50px; top:0px;">&#9776;</a></li>
				</ul>
			</div>
		</div><!-- /.mobile-menu -->
		<nav id="menu" class="stylehome1">

		    <ul>

	                   	<li class="active"><a href="{{ route('student.dashboard') }}"><span class="flaticon-puzzle-1"></span> Tableau de bord</a></li>
						<li><a href="{{ route('student.mycourses') }}"><span class="flaticon-online-learning"></span> Mes formations</a></li>

						{{-- <li><a href="{{ route('student.whishlist') }}"><span class="flaticon-like"></span> Liste de souhaits</a></li> --}}
                        <li><a href="{{ route('student.testimonial') }}"><span class="flaticon-edit"></span> Témoignages</a></li>
                        @if (Auth::user()->organization)
						    <li><a href="{{ route('student.mycourses.private', Auth::user()->organization->slug ?? '') }}"><span class="flaticon-global"></span> {{ Auth::user()->organization->name ?? '' }}</a></li>
                        @endif

				<li><span>Compte</span>
					<ul>
					    <li><a href="{{ route('student.setting') }}"><span class="flaticon-settings"></span> Paramètres</a></li>
						<li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     <span class="flaticon-logout"></span> Déconnexion</a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>

					</ul>
				</li>

			</ul>
		</nav>

		</nav>
	</div>
