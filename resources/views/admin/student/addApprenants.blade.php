@extends('layouts.admin')
@section('includes')
    <link href="{{ asset('assets/admin-formateurs/plugins/dropify/dist/css/dropify.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin-formateurs/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">

@endsection

@section('content')
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">

        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Ajouter Apprenant</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index-2.html">Admin</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Apprenants</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Ajouter</a></li>
                </ol>
            </div>
        </div>

        @include('includes.messages')
        <div class="row">
            <div class="col-xl-12 col-xxl-12 col-sm-12">
                <div class="card">

                    <div class="card-body">
                    <form action="{{route('admin.students.create.validate')}}" enctype="multipart/form-data" method="post">
                        @csrf

                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Avatar</label>
                                        <input type="file" id="avatar" accept="image/*" name="avatar" alt="avatar" class="dropify">
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Prénom</label>
                                        <input type="text" name="first_name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Nom</label>
                                        <input type="text" name="last_name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Genre</label>
                                        <select class="custom-select" type="text" name="gender">
                                            <option value="Homme">Homme</option>
                                            <option value="Femme">Femme</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Date de naissance</label>
                                        <input  name="date_of_birth" type="date" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Téléphone</label>
                                        <input type="tel" name="phone" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Pays</label>
                                        <select class="custom-select" name="country">
                                            @foreach ($countries as $key => $country)
                                                <option value="{{ $country }}">{{ $country }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Organisation</label>
                                        <select class="custom-select organization" name="organization">
                                            <option>Aucune</option>
                                            @foreach ($organizations as $organization)
                                                <option value="{{ $organization->id }}">{{ $organization->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Équipes</label>
                                        <select id="teams" name="teams[]" multiple="multiple"></select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Adresse</label>
                                        <input type="text" name="address" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <button type="submit" class="btn btn-primary" style="color: white; font-weight:bold">Enregistrer</button>
                                    {{-- <button type="reset" class="btn btn-light">Annuler</button> --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('script')
    <script src="{{ asset('assets/admin-formateurs/plugins/dropify/dist/js/dropify.min.js') }}"> </script>
    <script src="{{ asset('assets/admin-formateurs/plugins/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {

            $('#teams').select2({placeholder: "Selectionnez une ou plusieurs équipes"});

            $('#avatar').dropify({
                messages: {
                    'default': 'Faites un glissé déposé ou cliquez',
                    'replace': 'Faites un glissé déposé ou cliquez pour remplacer',
                    'remove':  'Supprimer',
                    'error':   'Ficher trop lourd'
                }
            });

            var selectedOrganization = $("select.organization").children("option:selected").val();
            var url=`{{route('admin.organization.getTeam','id-team')}}`;
            url= url.replace('id-team', selectedOrganization);

            if (selectedOrganization !== "Aucune") {
                $.get(url, function (data){
                    data.teams.map(function (value) {
                        $('#teams').append(`<option value="${value.id}">${value.name}</option>`);
                    });
                });
            }

            $("select.organization").change(function(){
                selectedOrganization = $(this).children("option:selected").val();
                url = `{{route('admin.organization.getTeam','id-team')}}`;
                url = url.replace('id-team', selectedOrganization);
                $('#teams').children("option").remove();
                $.get(url, function (data){
                    data.teams.map(function (value) {
                        $('#teams').append(`<option value="${value.id}">${value.name}</option>`);
                    })
                });
            });
        });
    </script>
@endsection
