@extends('layouts.admin')

@section('content')
<div class="content-body">
            <!-- row  ca commence ici -->
            <div class="container-fluid">

                <div class="row">
                    <div class="col-xl-3 col-xxl-3 col-sm-6">
						<div class="widget-stat card">
							<div class="card-body">
								<div class="media ai-icon">
									<span class="mr-3">
										<!-- <i class="ti-user"></i> -->
										<svg id="icon-customers" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
											<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
											<circle cx="12" cy="7" r="4"></circle>
										</svg>
									</span>
									<div class="media-body">
										<p class="mb-1">Total Utilisateurs</p>
										<h4 class="mb-0">{{ $count_users ?? 0 }}</h4>
										<span class="badge badge-success">{{ $count_today_new_user > 0 ? "+".$count_today_new_user : $count_today_new_user ?? '' }}</span> <small>aujourdhui</small>
									</div>
								</div>
							</div>
						</div>
                    </div>
                    <div class="col-xl-3 col-xxl-3 col-sm-6">
                        <div class="widget-stat card">
							<div class="card-body">
								<div class="media ai-icon">
									<span class="mr-3">
										<!-- <i class="ti-user"></i> -->
										<svg id="icon-customers" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
											<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
											<circle cx="12" cy="7" r="4"></circle>
										</svg>
									</span>
									<div class="media-body">
										<p class="mb-1">Apprenants</p>
										<h4 class="mb-0">{{ $count_students ?? '' }}</h4>
										<span class="badge badge-success">{{ $count_today_new_students > 0 ? "+".$count_today_new_students : $count_today_new_students ?? '' }}</span> <small>aujourdhui</small>
									</div>
								</div>
							</div>
						</div>
                    </div>
                    <div class="col-xl-3 col-xxl-3 col-sm-6">
                        <div class="widget-stat card">
							<div class="card-body">
								<div class="media ai-icon">
									<span class="mr-3">
										<!-- <i class="ti-user"></i> -->
										<svg id="icon-customers" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
											<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
											<circle cx="12" cy="7" r="4"></circle>
										</svg>
									</span>
									<div class="media-body">
										<p class="mb-1">Foramteurs</p>
										<h4 class="mb-0">{{ $count_teachers ?? '' }}</h4>
										<span class="badge badge-success">
                                            {{ $count_today_new_teachers > 0 ? "+".$count_today_new_teachers : $count_today_new_teachers ?? '' }}
                                        </span>
                                        <small>aujourdhui</small>
									</div>
								</div>
							</div>
						</div>
                    </div>
                    <div class="col-xl-3 col-xxl-3 col-sm-6">
                        <div class="widget-stat card">
							<div class="card-body">
								<div class="media ai-icon">
									<span class="mr-3">
										<!-- <i class="ti-user"></i> -->
										<svg id="icon-customers" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
											<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
											<circle cx="12" cy="7" r="4"></circle>
										</svg>
									</span>
									<div class="media-body">
										<p class="mb-1">Administrateur / A. Pédagogiques</p>
										<h4 class="mb-0">{{ $count_educational_admins ?? '' }}</h4>
										<span class="badge badge-success">
                                            {{ $count_today_new_educational_admins > 0 ? "+".$count_today_new_educational_admins : $count_today_new_educational_admins ?? '' }}
                                        </span> <small>aujourdhui</small>
									</div>
								</div>
							</div>
						</div>
                    </div>


                    <div class="col-xl-3 col-xxl-3 col-sm-6">
						<div class="widget-stat card">
							<div class="card-body">
								<div class="media ai-icon">
									<span class="mr-3">
										<svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
											<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
											<polyline points="14 2 14 8 20 8"></polyline>
											<line x1="16" y1="13" x2="8" y2="13"></line>
											<line x1="16" y1="17" x2="8" y2="17"></line>
											<polyline points="10 9 9 9 8 9"></polyline>
										</svg>
									</span>
									<div class="media-body">
										<p class="mb-1">Total Formations</p>
										<h4 class="mb-0">{{ $count_formations ?? '' }}</h4>
										<span class="badge badge-success">
                                            {{ $count_today_new_formations > 0 ? "+".$count_today_new_formations : $count_today_new_formations ?? '' }}
                                        </span> <small>aujourdhui</small>
									</div>
								</div>
							</div>
						</div>
                    </div>
                    <div class="col-xl-3 col-xxl-3 col-sm-6">
                        <div class="widget-stat card">
							<div class="card-body">
								<div class="media ai-icon">
									<span class="mr-3">
										<svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
											<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
											<polyline points="14 2 14 8 20 8"></polyline>
											<line x1="16" y1="13" x2="8" y2="13"></line>
											<line x1="16" y1="17" x2="8" y2="17"></line>
											<polyline points="10 9 9 9 8 9"></polyline>
										</svg>
									</span>
									<div class="media-body">
										<p class="mb-1">Formations à la carte</p>
										<h4 class="mb-0">{{ $count_public_formations ?? '' }}</h4>
										<span class="badge badge-success">
                                            {{ $count_today_new_public_formations > 0 ? "+".$count_today_new_public_formations : $count_today_new_public_formations ?? '' }}
                                        </span> <small>aujourdhui</small>
									</div>
								</div>
							</div>
						</div>
                    </div>
                    <div class="col-xl-3 col-xxl-3 col-sm-6">
                        <div class="widget-stat card">
							<div class="card-body">
								<div class="media ai-icon">
									<span class="mr-3">
										<svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
											<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
											<polyline points="14 2 14 8 20 8"></polyline>
											<line x1="16" y1="13" x2="8" y2="13"></line>
											<line x1="16" y1="17" x2="8" y2="17"></line>
											<polyline points="10 9 9 9 8 9"></polyline>
										</svg>
									</span>
									<div class="media-body">
										<p class="mb-1">Formations privatives</p>
										<h4 class="mb-0">{{ $count_private_formations ?? '' }}</h4>
										<span class="badge badge-success">
                                            {{ $count_today_new_private_formations > 0 ? "+".$count_today_new_private_formations : $count_today_new_private_formations ?? '' }}
                                        </span> <small>aujourdhui</small>
									</div>
								</div>
							</div>
						</div>
                    </div>
                    <div class="col-xl-3 col-xxl-3 col-sm-6">
                        <div class="widget-stat card">
							<div class="card-body">
								<div class="media ai-icon">
									<span class="mr-3">
										<svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
											<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
											<polyline points="14 2 14 8 20 8"></polyline>
											<line x1="16" y1="13" x2="8" y2="13"></line>
											<line x1="16" y1="17" x2="8" y2="17"></line>
											<polyline points="10 9 9 9 8 9"></polyline>
										</svg>
									</span>
									<div class="media-body">
										<p class="mb-1">Formations Certifiantes</p>
										<h4 class="mb-0">0</h4>
										<span class="badge badge-success">0</span> <small>aujourdhui</small>
									</div>
								</div>
							</div>
						</div>
                    </div>

					<div class="col-xl-6 col-lg-6 col-xxl-6 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Messages</h5>
                                <h6 class="fload-right"><a href="{{ route('admin.messages') }}" style="color: #6C2B69;">Voir plus</a></h6>
                            </div>
                            <div class="card-body">
								<div id="DZ_W_Message" class="widget-message dz-scroll" style="height:350px;">
                                    @if (count($last_four_messages) > 0)
                                        @foreach ($last_four_messages as $message)
                                        <div class="media mb-3">
                                            <div class="media-body">
                                                <h5>{{ $message->first_name." ".$message->last_name }}<small class="text-primary float-right"> {{ $message->getFormatedCreatedAt() }}</small></h5>
                                                <p class="mb-2">{{ strlen($message->message) > 220 ? substr($message->message, 0, 220).'...' : $message->message ?? '' }}</p>
                                            </div>
                                        </div>
                                        <hr class="mt-0 mb-3">
                                        @endforeach
                                    @else
                                        Aucun message !
                                    @endif
								</div>
                            </div>
                        </div>
                    </div>

					<div class="col-xl-6 col-lg-6 col-xxl-6 col-md-6">
						<div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Derniers Témoignages</h4>
                                <h6 class="fload-right"><a href="{{ route('admin.testimonials') }}" style="color: #6C2B69;">Voir plus</a></h6>
                            </div>
                            <div class="py-2">
                                <ul class="list-group list-group-flush dz-scroll" id="DZ_W_Doctor_List" style="height:350px;">
                                    @if (count($last_five_testimonials) > 0)
                                        @foreach ($last_five_testimonials as $testimonial)
                                            <li class="list-group-item">
                                                <a class="timeline-panel text-muted d-flex align-items-center" href="#">
                                                    <img class="rounded-sm" alt="image" width="50" src="{{ $testimonial->user ? $testimonial->user->image() : ''}}">
                                                    <div class="col">
                                                        <h5 class="mb-1">{{ $testimonial->user ? $testimonial->user->getFullName() : ''}}</h5>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <small class="d-block">
                                                                {{ strlen($testimonial->testimonial) > 220 ? substr($testimonial->testimonial, 0, 220).'...' : $testimonial->testimonial ?? '' }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    @else
                                        Aucun témoignage
                                    @endif

								</ul>
                            </div>
                        </div>
                    </div>

					<div class="col-xl-8 col-xxl-8 col-lg-8 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Formations en cours</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table header-border table-hover verticle-middle">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Prénom et nom</th>
                                                <th scope="col">Formations</th>
                                                <th scope="col">Type de formation</th>
                                                <th scope="col">Progression</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($six_almost_finished_formations) > 0)
                                                @foreach ($six_almost_finished_formations as $key => $formation)
                                                    <tr>
                                                        <th>{{ ++$key }}</th>
                                                        <td>{{ $formation['user']->getFullName() }}</td>
                                                        <td>{{ $formation['formation']->title ?? '' }}</td>
                                                        @if ($formation['formation']->type === 'public')
                                                            <td><span class="badge badge-rounded badge-success">Publique</span></td>
                                                        @elseif($formation['formation']->type === 'private')
                                                            <td><span class="badge badge-rounded badge-danger">Privative</span></td>
                                                        @endif
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: {{ $formation['process'] }}%;" role="progressbar">
                                                                    <span class="sr-only">{{ $formation['process'] }}% Complète</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        Aucune formation en cours
                                                    </td>

                                                </tr>

                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="col-xl-4 col-xxl-4 col-lg-4 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Dernières inscriptions</h4>
                            </div>
                            <div class="card-body">
                                <div class="widget-todo dz-scroll" style="height:370px;" id="DZ_W_Notifications">
                                    <ul class="timeline">
                                        @if (count($last_applications) > 0)
                                            @foreach ($last_applications as $key => $application)
                                                <li>
                                                    <div class="timeline-badge primary"></div>
                                                    <a class="timeline-panel text-muted mb-3 d-flex align-items-center" href="javascript:void(0);">
                                                        <img class="rounded-circle" alt="image" width="50" src="{{ $application['user']->image() }}">
                                                        <div class="col">
                                                            <h5 class="mb-1">{{ $application['user']->getFullName() }}  <i class="la la-arrow-right"></i> <strong>{{ $application['formation']->title ?? '' }}</strong></h5>
                                                            <small class="d-block">{{ $application['created_at'] }}</small>
                                                        </div>
                                                    </a>
                                                </li>
                                                <hr class="mt-0 mb-2">
                                            @endforeach
                                        @else
                                                Aucun inscrit pour le moment
                                        @endif

                                    </ul>
                                </div>
                            </div>
						</div>
					</div>
					<div class="col-lg-12">
                        <div class="card">
							<div class="card-header">
                                <h4 class="card-title">10 Dernières Formations publiées </h4>
                                <h6 class="fload-right"><a href="{{ route('admin.formations') }}" class="mr-5" style="color: #6C2B69;">Voir plus</a></h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive recentOrderTable">
                                    <table class="table verticle-middle table-responsive-md">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nom de la formation</th>
                                                <th scope="col">Categorie</th>
                                                <th scope="col">Publié par</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Prix</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($last_ten_formations) > 0)
                                                @foreach ($last_ten_formations as $formation)
                                                    <tr>
                                                        <td>{{ $formation->title ?? '' }}</td>
                                                        <td>{{ $formation->categories->first()->title ?? '' }}</td>
                                                        <td>{{ $formation->teacher()->getFullName() ?? '' }}</td>
                                                        @if ($formation->type === 'public')
                                                            <td><span class="badge badge-rounded badge-success">Publique</span></td>
                                                        @elseif($formation->type === 'private')
                                                            <td><span class="badge badge-rounded badge-danger">Privative</span></td>
                                                        @endif

                                                        <td>{{ $formation->getFormatedCreatedAt() ?? '' }}</td>
                                                        <td>{{ $formation->price ?? '' }} Fcfa</td>
                                                        <td>
                                                            <a href="{{ route('admin.formations.update', $formation->id) }}" class="btn btn-sm btn-primary"><i class="la la-pencil text-white"></i></a>
                                                            <a href="#deleteConfirmationModal" data-toggle="modal" id-formation="{{ $formation->id }}" class="delete-btn btn btn-sm btn-danger"><i class="la la-trash-o"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                Aucune formation
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
            </div>
        </div>


{{-- Delete Modal --}}
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Supprimer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                Voulez vous vraiment supprimer ce formation ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold"
                    data-dismiss="modal">Non</button>
                <a href="#" type="button" id="btn-yes"
                    class="btn btn-danger font-weight-bold">Oui</a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>

    jQuery(document).ready(function() {

        var btn_yes = $('#btn-yes');
        var id_formation = 0;
        var url = "{{route('admin.formations.delete','id-formation')}}"

        $(document).on('click', '.delete-btn', function () {
            console.log('delete clicked');
            var _this = $(this);
            id_formation = _this.attr('id-formation');
            console.log(_this);
            url = url.replace('id-formation', id_formation)
            btn_yes.attr('href', url);
        });

    });

</script>
@endsection
