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
                    <h4>Modifier Apprenant</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index-2.html">Admin</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Apprenant</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Modifier</a></li>
                </ol>
            </div>
        </div>

        @include('includes.messages')
        <div class="row">
            <div class="col-xl-12 col-xxl-12 col-sm-12">
                <div class="card">

                    <div class="card-body">
                    <form action="{{route('admin.students.update', $student->id)}}" enctype="multipart/form-data" method="post">
                        @csrf

                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Avatar</label>
                                        <input type="file" data-default-file="{{ file_exists(public_path('storage/'.$student->avatar)) ? asset('storage/'.$student->avatar) : '' }}" id="avatar" accept="image/*" name="avatar" alt="avatar" class="dropify">
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Prénom</label>
                                        <input type="text" name="first_name" value="{{ $student->first_name ?? '' }}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Nom</label>
                                        <input type="text" name="last_name" value="{{ $student->last_name ?? '' }}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Genre</label>
                                        <select class="custom-select" type="text" name="gender">
                                            <option @if($student->gender === 'Homme') selected @endif value="Homme">Homme</option>
                                            <option @if($student->gender === 'Femme') selected @endif value="Femme">Femme</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Date de naissance</label>
                                        <input  name="date_of_birth" type="date" value="{{ $student->date_of_birth ?? '' }}" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" value="{{ $student->email ?? '' }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Téléphone</label>
                                        <input type="tel" name="phone" value="{{ $student->phone ?? '' }}" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Pays</label>
                                        <select class="custom-select" type="text" name="country">
                                            @foreach ($countries as $key => $country)
                                                <option @if($country === $student->country) selected @endif value="{{ $country }}">{{ $country }}</option>
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
                                                <option @if($student->organization_id === $organization->id) selected @endif value="{{ $organization->id }}">{{ $organization->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Équipes</label>
                                        <select id="teams" required name="teams[]" multiple="multiple"></select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Adresse</label>
                                        <input type="text" value="{{ $student->address ?? '' }}" name="address" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <button type="submit" class="btn btn-primary" style="color: white; font-weight:bold">Enregistrer</button>
                                    {{-- <input type="reset" class="btn btn-light">/> --}}
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

            var teams = {!! $student->teams !!};
            var teams_id = teams.length !== 0 ? teams.map(team => team.id) : null;
            var organization_id = teams.length !== 0 ? teams[0].organization.id : null;

            $('#teams').select2({placeholder: "Selectionnez une ou plusieurs équipes"});

            $('#avatar').dropify({
                messages: {
                    'default': 'Faites un glissé déposé ou cliquez',
                    'replace': 'Faites un glissé déposé ou cliquez pour remplacer',
                    'remove':  'Supprimer',
                    'error':   'Ficher trop lourd'
                }
            });

            if (organization_id) {
                $("select.organization").children(`option[value='${organization_id}']`).attr('selected', 'selected');
                loadTeams();
            }

            $("select.organization").change(function(){
                loadTeams();
            });

            function loadTeams () {
                var url = `{{route('admin.organization.getTeam','id-organization')}}`;
                url = url.replace('id-organization', organization_id ? organization_id : $("select.organization").children(`option:selected`).val());
                $('#teams').children("option").remove();
                $.get(url, function (data){
                    data.teams.map(function (value) {
                        teams_id ? $('#teams').append(`<option ${teams_id.includes(value.id) ? 'selected' : ''} value="${value.id}">${value.name}</option>`)
                                : $('#teams').append(`<option value="${value.id}">${value.name}</option>`);
                    });
                });
            }
        });

    </script>
@endsection
