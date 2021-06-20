@extends('layouts.teacher')
@section('includes')
    <link href="{{ asset('assets/admin-formateurs/plugins/dropify/dist/css/dropify.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Mon Profil</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index-2.html">Admin</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Paramètres</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Profil</a></li>
                </ol>
            </div>
        </div>

        @include('includes.messages')

        <div class="row">
            <div class="col-xl-12 col-xxl-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Information basique</h5>
                    </div>
                    <div class="card-body">
                    <form action="{{route('teacher.profile.update')}}" enctype="multipart/form-data" method="post">
                        @csrf

                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Avatar</label>
                                        <input type="file" data-default-file="{{ file_exists(public_path('storage/'.$user->avatar)) ? $user->image() : '' }}" id="avatar" accept="image/*" name="avatar" alt="avatar" class="dropify">
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Prénom</label>
                                        <input type="text" name="first_name" value="{{ $user->first_name ?? '' }}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Nom</label>
                                        <input type="text" name="last_name" value="{{ $user->last_name ?? '' }}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Genre</label>
                                        <select class="custom-select" type="text" name="gender">
                                            <option @if($user->gender === 'Homme') selected @endif value="Homme">Homme</option>
                                            <option @if($user->gender === 'Femme') selected @endif value="Femme">Femme</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Date de naissance</label>
                                        <input  name="date_of_birth" type="date" value="{{ $user->date_of_birth ?? '' }}" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" value="{{ $user->email ?? '' }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Téléphone</label>
                                        <input type="tel" name="phone" value="{{ $user->phone ?? '' }}" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Pays</label>
                                        <select class="custom-select" type="text" name="country">
                                            @foreach ($countries as $key => $country)
                                                <option @if($country === $user->country) selected @endif value="{{ $country }}">{{ $country }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Adresse</label>
                                        <input type="text" name="address" value="{{ $user->address ?? '' }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Type de compte</label>
                                        <select class="custom-select" type="text" name="role_id">
                                            @foreach ($roles as $role)
                                                <option @if($role->id === $user->role_id) selected @endif value="{{ $role->id ?? '' }}">{{ $role->title ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 mt-4 mb-2">
                                    <hr class="mb-2">
                                </div>

                                <div class="col-12 mb-3">
                                    <small>Cette partie n'est pas obligatoire sauf si vous voulez modifier votre mot de passe</small>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Mot de passe actuel</label>
                                        <input type="password" name="actual_password" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Mot de passe</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Confirmation du nouveau mot de passe</label>
                                        <input type="password" name="password_confirmation" class="form-control">
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
    <script>
        $(function () {
            $('#avatar').dropify({
                messages: {
                    'default': 'Faites un glissé déposé ou cliquez',
                    'replace': 'Faites un glissé déposé ou cliquez pour remplacer',
                    'remove':  'Supprimer',
                    'error':   'Ficher trop lourd'
                }
            });
        });
    </script>
@endsection
