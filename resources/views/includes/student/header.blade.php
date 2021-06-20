	<header class="header-nav menu_style_home_one dashbord_pages navbar-scrolltofixed stricky main-menu" >
		<div class="container-fluid">
		    <!-- Ace Responsive Menu -->
		    <nav >
		        <!-- Menu Toggle btn-->
		        <div class="menu-toggle">
		            <img class="nav_logo_img img-fluid" src="{{ getInfoSystem() ? getInfoSystem()->getLogo() : '' }}" WIDTH="100" HEIGHT="30" alt="head.png">
		            <button type="button" id="menu-btn">
		                <span class="icon-bar"></span>
		                <span class="icon-bar"></span>
		                <span class="icon-bar"></span>
		            </button>
		        </div>
		        <a href="#" class="navbar_brand float-left dn-smd" style="margin-top: 13px">
		            <img class="logo1 img-fluid" src="{{ getInfoSystem() ? getInfoSystem()->getLogo() : '' }}" style="height: 70px" alt="header-logo.png">
		            <img class="logo2 img-fluid" src="{{ getInfoSystem() ? getInfoSystem()->getLogo() : '' }}" style="height: 70px" alt="header-logo.png">
		        </a>
		        <!-- Responsive Menu Structure-->
		        <!--Note: declare the Menu style in the data-menu-style="horizontal" (options: horizontal, vertical, accordion) -->
		        <ul id="respMenu" class="ace-responsive-menu" data-menu-style="horizontal">

		            <li class="last">
		                <a href="{{ route('home') }}"><strong  style="color:#6C2B69;">Retourner à la page d'accueil</strong></a>
		            </li>
		        </ul>
		        <ul class="header_user_notif pull-right dn-smd">
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
											<p>Ceci est un message .........................................................</p>
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
								<a class="view_all_noti text-thm" href="#">voir tous</a>
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
		    </nav>
		</div>
	</header>
