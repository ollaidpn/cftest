        <div class="deznav">
            <div class="deznav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="nav-label first">Main Menu</li>
                    <li>


                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
							<i class="la la-home"></i>
							<span class="nav-text">Tableau de bord</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('admin.dashboard') }}">Vue Globale</a></li>
                            <li><a href="#">Statistiques</a></li>
                        </ul>

                    </li>

					<li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
							<i class="la la-user"></i>
							<span class="nav-text">Formateurs</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('admin.teachers') }}">Tous les formateurs</a></li>
                            <li><a href="{{ route('admin.teachers.create') }}">Ajouter</a></li>
                        </ul>
                    </li>
					<li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
							<i class="la la-user"></i>
							<span class="nav-text">R. Pédagogiques</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('admin.educational-admins') }}">Tous les R. Pédagogiques</a></li>
                            <li><a href="{{ route('admin.educational-admins.create') }}">Ajouter</a></li>
                        </ul>
                    </li>
					<li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
							<i class="la la-users"></i>
							<span class="nav-text">Apprenants</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('admin.students') }}">Liste des apprenants</a></li>
                            <li><a href="{{ route('admin.students.create') }}">Ajouter</a></li>

                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="la la-building"></i>
                        <span class="nav-text">Organisations</span>
                    </a>
                    <ul aria-expanded="false">
                    <li><a href="{{ route('admin.organizations') }}" >Tous les organisations</a></li>
                        <li><a href="{{ route('admin.organizations.create') }}">Ajouter une organisation</a></li>
                    </ul>
                </li>

                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="la la-graduation-cap"></i>
                            <span class="nav-text">Formations</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('admin.formations') }}">Toutes les formations</a></li>
                            <li><a href="{{ route('admin.formations.create') }}">Ajouter</a></li>
                            <li><a href="{{ route('admin.categories') }}">Categories</a></li>
                        </ul>

                </li>
					<li><a  href="{{ route('admin.equipes') }}" aria-expanded="false">
                        <i class="la la-users"></i>
							<span class="nav-text">Equipes</span>
						</a>

                    </li>
                    <li>
                        <a href="{{ route('admin.messages') }}" aria-expanded="false">
                            <i class="la la-envelope"></i>
                            <span class="nav-text">Messages</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.testimonials') }}" aria-expanded="false">
                            <i class="la la-pencil"></i>
                            <span class="nav-text">Témoignages</span>
                        </a>
                    </li>
                    <li class="nav-label">Réglages</li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
							<i class="la la-th-list"></i>
							<span class="nav-text">Paramètres</span>
                        </a>
                        <ul aria-expanded="false">
                        <li><a href="{{route('admin.systeminfo')}}">Paramètres système</a></li>
                            <li><a href="{{ route('admin.settings.users.liste') }}">Utilisateurs</a></li>

                            <li><a href="{{ route('admin.settings.users.create') }}">Ajouter un utilisateur</a></li>
                        </ul>

                    </li>
                    <li>
                        <a class="" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" aria-expanded="false">
<i class="la la-sign-out"></i> <span class="nav-text">Deconnexion</span>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </a>

                </li>
				</ul>
            </div>


        </div>
