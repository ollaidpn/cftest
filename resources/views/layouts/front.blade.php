<!DOCTYPE html>
<html dir="ltr" lang="en">

<!-- Mirrored from grandetest.com/theme/edumy-html/index2.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Nov 2020 11:48:56 GMT -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="academy, college, coursera, courses, education, elearning, kindergarten, lms, lynda, online course, online education, school, training, udemy, university">
<meta name="description" content="Futurs Choisis">
<!-- css file -->
<link rel="stylesheet" href="{{ asset('assets/front-clients/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/front-clients/css/style.css')}}">
<!-- Responsive stylesheet -->
<link rel="stylesheet" href="{{ asset('assets/front-clients/css/responsive.css')}}">
<!-- Title -->
<title>{{ $page_title ?? 'Futurs Choisis' }} | Futurs Choisis</title>
<!-- Favicon -->
<link href="{{ getInfoSystem() ? getInfoSystem()->getFavicon() : '' }}" sizes="128x128" rel="shortcut icon" type="image/x-icon" />
<link href="{{ getInfoSystem() ? getInfoSystem()->getFavicon() : '' }}" sizes="128x128" rel="shortcut icon" />

</head>
<body>
<div class="wrapper">
	<div class="preloader"></div>
	<div class="header_top home2" style="background-color:white;">
		<div class="container">
			<div class="row">
				<div class="col-xl-12">
					<div class="ht_left_widget home2 float-left">
						<ul>
							<li class="list-inline-item">
								<div class="logo-widget">
                                    <a href="{{ route('home') }}">
                                        <img class="img-fluid" src="{{ getInfoSystem() ? getInfoSystem()->getLogo() : '' }}" style="height:80px !important;" alt="logo">
                                    </a>
								</div>
							</li>

							<li class="list-inline-item">
								<div class="ht_search_widget">
									<div class="header_search_widget home2">
                                        <form method="POST" action="{{ route('search') }}" class="form-inline mailchimp_form">
                                            @csrf
											<input type="search" name="search" class="form-control mb-2 mr-sm-2" id="inlineFormInputMail2" placeholder="Taper ici pour effectuer une recherche">
											<button type="submit" class="btn btn-primary mb-2"><span class="flaticon-magnifying-glass"></span></button>
										</form>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Main Header Nav -->
	<header class="header-nav home2 style_one navbar-scrolltofixed main-menu" style="background-color:#6c2b69;">
		<div class="container">
		    <!-- Ace Responsive Menu -->
		    <nav>
		        <!-- Menu Toggle btn-->
		        <div class="menu-toggle ">
		            <button type="button" id="menu-btn">

		            </button>
		        </div>
		        <!-- Responsive Menu Structure-->
		        <!--Note: declare the Menu style in the data-menu-style="horizontal" (options: horizontal, vertical, accordion) -->
		        <ul id="respMenu" class="ace-responsive-menu" data-menu-style="horizontal">
				<li class="last">
		                <a href="{{ route('home') }}"><span class="title">Accueil</span></a>
		            </li>

		            <li>
		                <a href="{{ route('front.courses')}}"><span class="title">A la carte</span></a>
		                <ul>
                            @foreach (getCategories()->where('category_parent', '') as $categorie )
                            <li>
                                <a href="{{route('category.show',$categorie->slug)}}">{{ $categorie->title}}</a>
                                <ul>
                                    @if ($categorie->children)
                                        @foreach ( $categorie->children as $child )
                                            <li><a href="{{route('category.show',$child->slug)}}">{{ $child->title}}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                            @endforeach
		                </ul>
		            </li>
				    <li>
		                <a href="#"><span class="title">Certifications</span></a>
		                <ul>
                            <li>Aucune Certification Pour le moment</li>
                            {{-- @foreach ($parcours as $parcour )
                            <li><a href="course.php">{{$parcour->title}}</a>

                            @endforeach --}}

		                </ul>
		            </li>
                    @if (Auth::user() && Auth::user()->organization)
                        <li class="last">
                            <a href="{{ route('student.mycourses.private', Auth::user()->organization->slug) }}"><span class="title">Formations privatives</span></a>
                        </li>
                    @endif




							@if (Auth::check())
                            <li class="pull-right">
                                <a href="{{ route(Auth::user()->role->slug.'.dashboard') }}"><span class="title">Mon Espace</span></a>
                            </li>
                            @else
                            <li class="pull-right">
                                <a href="{{ route('login') }}"><span class="title">Connexion</span></a>
                            </li>
                            @endif


                    <li class="last">
		                <a href="{{ route('front.contact') }}"><span class="title">Contact</span></a>
		            </li>

		        </ul>
		        <ul class="sign_up_btn pull-right dn-smd " >

                    @if (!Auth::check())
                        <li class="list-inline-item"><a href="{{ route('login') }}" class="btn btn-md"><i class="flaticon-user"></i> <span class="dn-md">Connexion / Inscription</span></a></li>
                    @else
                        <li class="list-inline-item"><a href="javascript:;" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="btn btn-md"><i class="flaticon-user"></i> <span class="dn-md">Déconnexion</span></a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endif
	            </ul><!-- Button trigger modal -->
		    </nav>
		    <!-- End of Responsive Menu -->
		</div>
	</header>


	<!-- Main Header Nav For Mobile -->
	<div id="page" class="stylehome1 home2 h0" >
		<div class="mobile-menu" >
			<div class="header stylehome1" style="background-color:white !important;">
				<div class="main_logo_home2">
                    <img class="mt-2"  src="{{ getInfoSystem() ? getInfoSystem()->getLogo() : '' }}" HEIGHT="80" alt="header-logo.png">
				</div>
				<ul class="menu_bar_home2" >
					<li class="list-inline-item">
	                	<div class="search_overlay">
						  <a id="search-button-listener" class="mk-search-trigger mk-fullscreen-trigger" href="#">
						    <div id="search-button"><i class="flaticon-magnifying-glass" style="color:black; top: 11px;"></i></div>
						  </a>
							<div class="mk-fullscreen-search-overlay" id="mk-search-overlay">
							    <a href="#" class="mk-fullscreen-close" id="mk-fullscreen-close-button"><i class="fa fa-times"></i></a>
							    <div id="mk-fullscreen-search-wrapper">
                                  <form method="POST" action='{{ route('search') }}' id="mk-fullscreen-searchform">
                                    @csrf
							        <input type="search" name="search" placeholder="Rechercher une formation..." id="mk-fullscreen-search-input">
							        <i class="flaticon-magnifying-glass fullscreen-search-icon"><input value="" type="submit"></i>
							      </form>
							    </div>
							</div>
						</div>
                    </li>

					<li class="list-inline-item" style="color:black"><a href="#menu" style="font-size:50px; top:7px;">&#9776;</a></li>
				</ul>
			</div>
        </div>
        {{-- <div class="mobile-menu">
			<div class="header stylehome1">
				<div class="main_logo_home2 " >
                    <img class="img-fluid mt-4 " src="{{ getInfoSystem()->getLogo() }}" WIDTH="100" HEIGHT="30" alt="header-logo.png">

				</div>
				<ul class="menu_bar_home2">
					<li class="list-inline-item">
	                	<div class="search_overlay">
						  <a id="search-button-listener" class="mk-search-trigger mk-fullscreen-trigger" href="#">
						    <div id="search-button"><i class="flaticon-magnifying-glass"></i></div>
						  </a>
							<div class="mk-fullscreen-search-overlay" id="mk-search-overlay">
							    <a href="#" class="mk-fullscreen-close" id="mk-fullscreen-close-button"><i class="fa fa-times"></i></a>
							    <div id="mk-fullscreen-search-wrapper">
							      <form method="get" id="mk-fullscreen-searchform">
							        <input type="text" value="" placeholder="Search courses..." id="mk-fullscreen-search-input">
							        <i class="flaticon-magnifying-glass fullscreen-search-icon"><input value="" type="submit"></i>
							      </form>
							    </div>
							</div>
						</div>
					</li>
					<li class="list-inline-item"><a href="#menu"><span></span></a></li>
				</ul>
			</div>
        </div> --}}

        <!-- /.mobile-menu -->
		<nav id="menu" class="stylehome1">

            <ul>
				<li><a href="{{ route('home') }}">Accueil </a>

				</li>


                    <li>
		                <a href="{{ route('front.courses')}}"><span class="title">A la carte</span></a>
		                <ul>
                            @foreach (getCategories()->where('category_parent', '') as $categorie )
                            <li>
                                <a href="{{ route('category.show',$categorie->slug) }}">{{ $categorie->title}}</a>
                                <ul>
                                    @if ($categorie->children)
                                        @foreach ( $categorie->children as $child )
                                            <li><a href="{{ route('category.show',$child->slug) }}">{{ $child->title}}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                            @endforeach
		                </ul>
                    </li>

					<li>
		                <a href="#"><span class="title">Certifications</span></a>
		                <ul>
                            {{-- @foreach ($parcours as $parcour )
                            <li><a href="course.php">{{$parcour->title}}</a>

                            @endforeach --}}

		                </ul>
		            </li>
                    @if (Auth::user() && Auth::user()->organization)
                        <li class="last">
                            <a href="#"><span class="title">Formations privatives</span></a>
                        </li>
                    @endif


		            @if (Auth::user() && Auth::user()->organization)
                        <li class="last">
                            <a href="#"><span class="title">Formations privatives</span></a>
                        </li>
                    @endif


		            <li >
		                <a href="javascript:;"><span class="title">Mon Compte</span></a>
		                <ul>
							@if (Auth::check())
                                <li><a href="{{ route(Auth::user()->role->slug.'.dashboard') }}">Mon Espace</a></li>
                            @else
                                <li><a href="{{ route('login') }}">Mon Espace</a></li>
                            @endif
		                </ul>
		            </li>
				<li><a href="contact.php">Contact</a></li>

                <ul >

                    @if (!Auth::check())
                        <li class="list-inline-item"><a href="{{ route('login') }}" class="btn btn-md"><i class="flaticon-user"></i> <span class="dn-md">Connexion / Inscription</span></a></li>
                    @else
                        <li class="list-inline-item"><a href="javascript:;" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="btn btn-md"><i class="flaticon-user"></i> <span class="dn-md">Déconnexion</span></a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endif
	            </ul><!-- Button trigger modal -->
			</ul>
			{{-- <ul>
				<li><a href="index.php">Accueil </a>

				</li>
				<li>
		                <a href=""><span class="title">A la carte</span></a>
		                <ul>
		                    <li><a href="course.php">Affaires</a></li>
		                    <li><a href="course.php">Immobilier</a></li>
		                    <li><a href="course.php">Énergies</a></li>
		                    <li><a href="course.php">Banques et finances</a></li>
		                    <li><a href="course.php">Numérique</a></li>
		                    <li><a href="course.php">Stratégies,gouvernance et politiques publiques</a></li>
		                    <li><a href="course.php">Légistique et réformes</a></li>
							<li><a href="course.php">Compétences et talents (Management)</a></li>

		                </ul>
		            </li>
					<li>
		                <a href=""><span class="title">Certifications</span></a>
		                <ul>
		                    <li><a href="course.php">Certificat de juriste technicien </a></li>
							<li><a href="course.php">Certificat de juriste praticien</a></li>
		                    <li><a href="course.php">Certificat de juriste Expert</a></li>
		                </ul>
		            </li>


					<li class="last">
		                <a href="course.php"><span class="title">Formations privatives</span></a>
		            </li>
		            <li>
		                <a href=""><span class="title">Mon Compte</span></a>
		                <ul>
							<li><a href="dashboard.php">Espaces clients</a></li>
							<li><a href="cart.php">Panier</a></li>

							<li><a href="404.php">Espace formateurs</a></li>
		                    <li><a href="404.php">Espaces admins</a></li>
		                </ul>
		            </li>
				<li><a href="contact.php">Contact</a></li>
				<li><a href="{{ route('login') }}"><span class="flaticon-user"></span> Connexion</a></li>
				<li><a href="{{ route('register') }}"><span class="flaticon-edit"></span> Inscription</a></li>
			</ul> --}}
		</nav>
	</div>
<!-- Home Design -->
    @yield('content')

	<section class="footer_middle_area p0" style="background-color:white;">
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-md-3 col-lg-3 col-xl-2 pb10 pt15">
					<div class="logo-widget home2 ">
						<img class="img-fluid " src="{{ getInfoSystem() ? getInfoSystem()->getLogo() : '' }}" style="height:67px !important;" alt="header-logo.png">
					</div>
				</div>
				<div class="col-sm-8 col-md-5 col-lg-6 col-xl-6 pb35 pt25 brdr_left_right">
					<div class="footer_menu_widget" >
						<ul>
							<li class="list-inline-item"><a href="mailto:{{ getInfoSystem()->system_email ?? '' }}" style="color:rgb(108, 43, 105);"><strong>{{ getInfoSystem()->system_email ?? '' }}</strong></a></li>
							<li class="list-inline-item">
                                <a href="tel:{{ getInfoSystem()->fixe ?? '' }}" style="color:rgb(108, 43, 105);">
                                    <strong>Fixe: {{ getInfoSystem()->fixe ?? '' }}</strong>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="tel:{{ getInfoSystem()->mobile ?? '' }}" style="color:rgb(108, 43, 105);">
                                    <strong>Mobile: {{ getInfoSystem()->mobile ?? '' }}</strong>
                                </a>
                            </li>
						</ul>
					</div>
				</div>
				<div class="col-sm-12 col-md-4 col-lg-3 col-xl-4 pb15 pt15">
					<div class="footer_social_widget mt15">
						<ul>
							<li class="list-inline-item"><a href="{{ getInfoSystem()->facebook ?? '' }}"><i class="fa fa-facebook" style="color: rgb(108, 43, 105)"></i></a></li>
							<li class="list-inline-item"><a href="{{ getInfoSystem()->twitter ?? '' }}"><i class="fa fa-twitter" style="color: rgb(108, 43, 105)"></i></a></li>
							<li class="list-inline-item"><a href="{{ getInfoSystem()->insta ?? '' }}"><i class="fa fa-instagram" style="color: rgb(108, 43, 105)"></i></a></li>
							<li class="list-inline-item"><a href="{{ getInfoSystem()->linkedin ?? '' }}"><i class="fa fa-linkedin" style="color: rgb(108, 43, 105)"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Our Footer Bottom Area -->
	<section class="footer_bottom_area pt15 pb15" style="background-color:rgb(108, 43, 105); color:white;">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 offset-lg-3">
					<div class="copyright-widget text-center">
						<p><strong>Futurs Choisis © {{ date('Y') }}. Tous Droits Réservéss.</strong> </p>
					</div>
				</div>
			</div>
		</div>
	</section>
    <a class="scrollToHome" href="#"><i class="flaticon-up-arrow-1"></i></a>
</div>
  <!-- Wrapper End -->
  <script type="text/javascript" src="{{ asset('assets/front-clients/js/jquery-3.3.1.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/front-clients/js/jquery-migrate-3.0.0.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/front-clients/js/popper.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/front-clients/js/bootstrap.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/front-clients/js/jquery.mmenu.all.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/front-clients/js/ace-responsive-menu.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/front-clients/js/bootstrap-select.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/front-clients/js/snackbar.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/front-clients/js/simplebar.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/front-clients/js/parallax.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/front-clients/js/scrollto.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/front-clients/js/jquery-scrolltofixed-min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/front-clients/js/jquery.counterup.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/front-clients/js/wow.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/front-clients/js/progressbar.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/front-clients/js/slider.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/front-clients/js/timepicker.js')}}"></script>
  <!-- Custom script for all pages -->
  <script type="text/javascript" src="{{ asset('assets/front-clients/js/script.js')}}"></script>

</body>

</html>
