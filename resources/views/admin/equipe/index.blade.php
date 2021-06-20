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
                    <h4>Équipes</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index-2.html">Admin</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Equipes</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Listes</a></li>
                </ol>
            </div>
        </div>

        @include('includes.messages')


        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Liste des équipes </h4>
                        <a href="#showModal" data-toggle="modal" class="btn btn-primary" style="color: white; font-weight:bold">+ Ajouter</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nom</th>
                                        <th>Organisation</th>
                                        <th>Date</th>
                                        <th>Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($teams as $key => $team)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{$team->name ?? ''}}</td>
                                        <td>{{$team->organization->name ?? ''}}</td>
                                        <td>{{$team->created_at ?? ''}}</td>
                                        <td>
                                        <a href="#editTeam" id="id-team" id-team='{{$team->id}}' data-toggle='modal' class="btn btn-sm btn-primary edit-btn"><i class="la la-pencil" style="color: white" title="Edit"></i></a>
                                        <a href="#deleteConfirmationModal" id-team='{{$team->id}}' data-toggle='modal' class="btn btn-sm btn-danger delete-btn"><i class="la la-trash-o" title="Delete"></i></a>
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

{{-- popup ajouter team --}}
<div class="modal fade" id="showModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="la la-close text-black"></i>
                </button>
            </div>
            <div class="card-body">
                <form action="{{route('admin.team.validate')}} " method="post">
                    @csrf
                    <div class="form-group">
                        <span class="mb-0 mr-2">Nom: </span><span id="name"></span>
                        <input type="text" name='name' class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Organisation</label>
                        <select class="custom-select organization" name="organization_id">
                            @foreach ($organizations as $organization)
                                <option value="{{ $organization->id }}">{{ $organization->name ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" style="color: white; font-weight:bold">Enregistrer</button>
                </form>

                <div class="text-center">
                    <div class="profile-photo">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- popup delete team --}}
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
                Voulez vous vraiment supprimer cette équipe ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold"
                    data-dismiss="modal">Non</button>
                <a href="#" id="btn-yes"
                    class="btn btn-danger font-weight-bold">Oui</a>
            </div>
        </div>
    </div>
</div>

{{-- popup edit team --}}
<div class="modal fade" id="editTeam" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTeam">Modifier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="la la-close text-black"></i>
                </button>
            </div>
            <div class="card-body">
                <form action="#" id='update-team' method="post">
                    @csrf
                    <div class="form-group">
                        <span class="mb-0 mr-2">Nom: </span><span id="name"></span>
                        <input type="text" id='team_name' name='name' class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Organisation</label>
                        <select class="custom-select organization" id="team_organization" name="organization_id">
                            @foreach ($organizations as $organization)
                                <option value="{{ $organization->id }}">{{ $organization->name ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" style="color: white; font-weight:bold">Enregistrer</button>
                </form>

                <div class="text-center">
                    <div class="profile-photo">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- Datatable -->
<script src="{{ asset('assets/admin-formateurs/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script>
    $(function () {
        $('#example3').DataTable();
    })
</script>
<script>

    jQuery(document).ready(function() {

        const btn_yes = $('#btn-yes');
        let id_team = 0;


        $(document).on('click', '.delete-btn', function () {
            let url = "{{route('admin.teams.delete','id-team')}}";
            console.log('delete clicked');
            var _this = $(this);
            id_team = _this.attr('id-team');
            console.log(_this);
            url = url.replace('id-team', id_team)
            btn_yes.attr('href', url);
        });

        $(document).on('click', '.edit-btn', function () {
            var _this = $(this);
            id_team = _this.attr('id-team');
            var url = `{{route('admin.team.show','id-team')}}`;
            url = url.replace('id-team', id_team);
            var update_url=`{{route('admin.teams.update','id-team')}}`;
            update_url= update_url.replace('id-team', id_team);
            $('#update-team').attr('action', update_url);
            console.log(url);

            $.get(url, function (data){
                $('#team_name').val(data.team.name);
                $(`#team_organization option[value='${data.team.organization_id}']`).attr("selected", "selected");
            })
        });

    });

</script>
@endsection
