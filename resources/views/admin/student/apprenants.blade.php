@extends('layouts.admin')
@section('includes')

<link href="{{ asset('assets/admin-formateurs/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">

@endsection

@section('content')
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">

        <div class="mx-0 row page-titles">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Tous les apprenants</h4>
                </div>
            </div>
            <div class="mt-2 col-sm-6 p-md-0 justify-content-sm-end mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index-2.html">Admin</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Apprenants</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Liste</a></li>
                </ol>
            </div>
        </div>
        @if (session()->has('success'))
        <div class="alert alert-success fade show" role="alert">
            <div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
            <div class="alert-text">{{ session('success') }}</div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="ki ki-close"></i></span>
                    </button>
                </div>
            </div>
        @elseif (session()->has('error'))
            <div class="alert alert-custom alert-notice alert-light-danger fade show" role="alert">
                <div class="alert-icon"><i class="flaticon2-delete"></i></div>
            <div class="alert-text">{{ session('error') }}</div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="ki ki-close"></i></span>
                    </button>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <ul class="mb-3 nav nav-pills">
                </ul>
            </div>
            <div class="col-lg-12">
                <div class="row tab-content">
                    <div id="list-view" class="tab-pane fade active show col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Liste complète  </h4>
                                <a href="{{ route('admin.students.create') }}" class="btn btn-primary" style="color: white; font-weight:bold">+ Ajouter</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>Profile</th>
                                                <th>Prénom</th>
                                                <th>nom</th>
                                                <th>Email</th>
                                                <th>Téléphone</th>
                                                <th>Pays</th>
                                                <th>Organisation</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($users as $user)
                                            <tr>
                                                <td>
                                                    <img class="rounded-circle" width="35" src="{{ $user->image() }}" alt="avatar">
                                                </td>
                                                <td><a href="javascript:void(0);"><strong>{{$user->first_name ?? ''}}</strong></a></td>
                                                <td><a href="javascript:void(0);"><strong>{{$user->last_name ?? ''}}</strong></a></td>
                                                <td>{{$user->email ?? ''}}</td>
                                                <td>{{$user->phone ?? ''}}</td>
                                                <td>{{$user->country ?? ''}}</td>
                                                <td>{{count($user->teams) !== 0 ? $user->teams[0]->organization->name : 'Aucun'}}</td>
                                                <td>
                                                    <a href="#showModal" data-toggle='modal' id-student={{$user-> id}} class="btn btn-sm btn-secondary btn-show"><i class="la la-eye" style="color: white" title="Afficher"></i></a>
                                                    <a href="{{route('admin.students.edit', $user->id)}}" class="btn btn-sm btn-primary"><i class="la la-pencil" style="color: white" title="Edit"></i></a>
                                                    <a href="#deleteConfirmationModal" data-toggle='modal' id-student={{$user-> id}} class="btn btn-sm btn-danger delete-btn"><i class="la la-trash-o" title="Delete"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
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
                    Voulez vous vraiment supprimer cette apprenants ?
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

    <div class="modal fade" id="showModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Afficher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="la la-close text-black"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="" id="avatar-student" class="align-items-center" style="width: 100%" alt="avatar">
                        </div>
                        <div class="col-md-8">
                            <ul class="list-group mb-3 list-group-flush">
                                <li class="list-group-item px-0 d-flex">
                                    <span class="mb-0 mr-2">Nom: </span><span id="last_name"></span>
                                </li>
                                <li class="list-group-item px-0 d-flex">
                                    <span class="mb-0 mr-2">Prénom: </span><span id="first_name"></span>
                                </li>
                                <li class="list-group-item px-0 d-flex">
                                    <span class="mb-0 mr-2">Gender: </span><span id="gender"></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="profile-photo">
                        </div>
                        <ul class="list-group mb-3 list-group-flush">
                            <li class="list-group-item px-0 d-flex">
                                <span class="mb-0 mr-2">Phone No.: </span><span id="phone"></span>
                            </li>
                            <li class="list-group-item px-0 d-flex">
                                <span class="mb-0 mr-2">Email: </span><span id="email"></span>
                            </li>
                            <li class="list-group-item px-0 d-flex">
                                <span class="mb-0 mr-2">Address: </span><span id="address"></span>
                            </li>
                            <li class="list-group-item px-0 d-flex">
                                <span class="mb-0 mr-2">Date de naissance: </span><span id="birthday"></span>
                            </li>
                            <li class="list-group-item px-0 d-flex">
                                <span class="mb-0 mr-2">Pays: </span><span id="country"></span>
                            </li>
                            <li class="list-group-item px-0 d-flex">
                                <span class="mb-0 mr-2">Organisation: </span><span id="organization">Aucun</span>
                            </li>
                            <li class="list-group-item px-0 d-flex">
                                <span class="mb-0 mr-2">Equipes: </span>
                                <div id="teams"></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script>
    $(function () {
        $(document).on('click', '.btn-show', function () {
            var url = "{{route('admin.students.show','id-student')}}";
            var _this = $(this);
            id_student = _this.attr('id-student');
            url = url.replace('id-student', id_student)
            $.get(url, function (data) {
                $('#first_name').text(data.student.first_name);
                $('#last_name').text(data.student.last_name);
                $('#address').text(data.student.address);
                $('#phone').text(data.student.phone);
                $('#gender').text(data.student.gender);
                $('#email').text(data.student.email);
                $('#country').text(data.student.country);
                $('#birthday').text(data.student.date_of_birth);
                var img = data.student.avatar ? "{{ asset('storage/'.'url-img') }}" : "{{ asset('assets/admin-formateurs/images/avatar/avatar.png') }}";
                $('#avatar-student').attr('src', img.replace('url-img', data.student.avatar ));
                $('#organization').text(data.student.teams.length !== 0 ? data.student.teams[0].organization.name : 'Aucun');
                console.log(data.student.teams.length);
                if (data.student.teams.length !== 0) {
                    data.student.teams.map(function (team) {
                        $('#teams').append(`<span class='ml-3'>- ${team.name}</span>`);
                    });
                } else {
                    $('#teams').append("Aucune");
                }

            });
        });
        $('#showModal').on('hidden.bs.modal', function (e) {
            $('#teams').children().remove();
        });
    });
</script>

<script>

    jQuery(document).ready(function() {

        var btn_yes = $('#btn-yes');
        var id_student = 0;
        var url = "{{route('admin.students.delete','id-student')}}"

        $(document).on('click', '.delete-btn', function () {
            console.log('delete clicked');
            var _this = $(this);
            id_student = _this.attr('id-student');
            console.log(_this);
            url = url.replace('id-student', id_student)
            btn_yes.attr('href', url);
        });

    });

</script>


<script src="{{ asset('assets/admin-formateurs/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script>
    $(function () {
        $('#example3').DataTable();
    })
</script>
@endsection


