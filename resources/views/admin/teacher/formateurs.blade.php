@extends('layouts.admin')
@section('includes')

    <link href="{{ asset('assets/admin-formateurs/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">

        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Tous les Formateurs</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index-2.html">Admin</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Formateurs</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Liste</a></li>
                </ol>
            </div>
        </div>

        @include('includes.messages')

        <div class="row">
            <div class="col-lg-12">
                <ul class="nav nav-pills mb-3">
                </ul>
            </div>
            <div class="col-lg-12">
                <div class="row tab-content">
                    <div id="list-view" class="tab-pane fade active show col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Liste complète  </h4>
                                <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary" style="color: white; font-weight:bold">+ Ajouter</a>
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
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($users as $user)
                                            <tr>
                                                <td><img class="rounded-circle" width="35" src="{{ $user->image() }}" alt=""></td>
                                                <td><a href="javascript:void(0);"><strong>{{$user->first_name ?? ''}}</strong></a></td>
                                                <td><a href="javascript:void(0);"><strong>{{$user->last_name ?? ''}}</strong></a></td>
                                                <td>{{$user->email ?? ''}}</td>
                                                <td>{{$user->phone ?? ''}}</td>
                                                <td>{{$user->country ?? ''}}</td>
                                                <td>

                                                    <a href="#showModal" data-toggle='modal' id-teacher={{$user->id}} class="btn btn-sm btn-secondary btn-show"><i class="la la-eye" style="color: white" title="Afficher"></i></a>
                                                    <a href="{{route('admin.teachers.edit', $user->id)}}" class="btn btn-sm btn-primary"><i class="la la-pencil" style="color: white" title="Edit"></i></a>
                                                    <a href="#deleteConfirmationModal" data-toggle='modal' id-teacher={{$user->id}} class="btn btn-sm btn-danger delete-btn"><i class="la la-trash-o" title="Delete"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
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
                                            Voulez vous vraiment supprimer cette formateur ?
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

                        </div>
                    </div>

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
    <div class="modal fade" id="showModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
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
                            <img src="" id="avatar-teacher" class="align-items-center" style="width: 100%" alt="avatar">
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
            var url = "{{route('admin.teachers.show','id-teacher')}}";
            var _this = $(this);
            id_teacher = _this.attr('id-teacher');
            url = url.replace('id-teacher', id_teacher)
            $.get(url, function (data) {
                $('#first_name').text(data.teacher.first_name);
                $('#last_name').text(data.teacher.last_name);
                $('#address').text(data.teacher.address);
                $('#phone').text(data.teacher.phone);
                $('#gender').text(data.teacher.gender);
                $('#email').text(data.teacher.email);
                $('#country').text(data.teacher.country);
                $('#birthday').text(data.teacher.date_of_birth);
                var img = data.teacher.avatar ? "{{ asset('storage/'.'url-img') }}" : "{{ asset('assets/admin-formateurs/images/avatar/avatar.png') }}";
                $('#avatar-teacher').attr('src', img.replace('url-img', data.teacher.avatar ));
                $('#organization').text(data.teacher.organization ?  data.teacher.organization.name : 'Aucun');
            });
        });
    });
</script>
<script>

    jQuery(document).ready(function() {

        var btn_yes = $('#btn-yes');
        var id_teacher = 0;
        var url = "{{route('admin.teachers.delete','id-teacher')}}"

        $(document).on('click', '.delete-btn', function () {
            console.log('delete clicked');
            var _this = $(this);
            id_teacher = _this.attr('id-teacher');
            console.log(_this);
            url = url.replace('id-teacher', id_teacher)
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



