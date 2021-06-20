	<section class="dashboard_sidebar dn-1199">
		<div class="dashboard_sidebars">
			<div class="user_board">
				<div class="user_profile">
					<div class="media">
					  	<div class="media-body">
					    	<h4 class="mt-0" style="color: #6C2B69; font-weight: bold; font-size: 1.5em;">Espace Client</h4>
						</div>
					</div>
				</div>
				<div class="dashbord_nav_list">
					<ul>
						<li class="{{ $page_title && $page_title === 'Tableau de bord' ? 'active' : ''}}"><a href="{{ route('student.dashboard') }}"><span class="flaticon-puzzle-1"></span> Tableau de bord</a></li>
						<li class="{{ $page_title && $page_title === "Mes cours" ? 'active' : ''}}"><a href="{{ route('student.mycourses') }}"><span class="flaticon-online-learning"></span> Mes formations</a></li>

						{{-- <li><a href="{{ route('student.whishlist') }}"><span class="flaticon-like"></span> Liste de souhaits</a></li> --}}
                        <li class="{{ $page_title && $page_title === 'Témoignages' ? 'active' : ''}}"><a href="{{ route('student.testimonial') }}"><span class="flaticon-edit"></span> Témoignages</a></li>
                        @if (Auth::user()->organization)
						    <li class="{{ $page_title && $page_title === Auth::user()->organization->name ? 'active' : ''}}"><a href="{{ route('student.mycourses.private', Auth::user()->organization->slug ?? '') }}"><span class="flaticon-global"></span> {{ Auth::user()->organization->name ?? '' }}</a></li>

                        @endif
					</ul>
					<h4>Compte</h4>
					<ul>
						<li class="{{ $page_title && $page_title === "Profil" ? 'active' : ''}}"><a href="{{ route('student.setting') }}"><span class="flaticon-settings"></span> Paramètres</a></li>
						<li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     <span class="flaticon-logout"></span> Déconnexion</a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
					</ul>
				</div>
			</div>
		</div>
	</section>
