        <div class="deznav">
            <div class="deznav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="nav-label first">Main Menu</li>
                    <li>


                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
							<i class="la la-home"></i>
							<span class="nav-text">Tableau de bord</span>
						</a>



                        <!--<a  href="{{ route('educational-admin.dashboard') }}" aria-expanded="false">
							<i class="la la-home"></i>
							<span class="nav-text">Tableau de bord</span>
						</a>-->

                    </li>

					<li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
							<i class="la la-user"></i>
							<span class="nav-text">Formateurs</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('educational-admin.teachers') }}">Tous les formateurs</a></li>
                            <li><a href="{{ route('educational-admin.teachers.create') }}">Ajouter</a></li>
                        </ul>
                    </li>

                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="la la-graduation-cap"></i>
                        <span class="nav-text">Formations</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('educational-admin.formations') }}">Toutes les formations</a></li>
                        <li><a href="{{ route('educational-admin.categories') }}">Categories</a></li>
                    </ul>
                    <li>
                        <a class="" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" aria-expanded="false">
                        <i class="la la-th-list"></i>
                        <span class="nav-text">Deconnexion</span>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </a>

                    </li>
                    </ul>
            </div>


        </div>
