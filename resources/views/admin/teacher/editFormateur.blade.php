@extends('layouts.admin')
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
                    <h4>Modifier Formateur</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index-2.html">Admin</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Formateur</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Modifier</a></li>
                </ol>
            </div>
        </div>

        @include('includes.messages')
        <div class="row">
            <div class="col-xl-12 col-xxl-12 col-sm-12">
                <div class="card">

                    <div class="card-body">
                    <form action="{{route('admin.teachers.update', $teacher->id)}}" enctype="multipart/form-data" method="post">
                        @csrf

                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Avatar</label>
                                        <input type="file" data-default-file="{{ file_exists(public_path('storage/'.$teacher->avatar)) ? asset('storage/'.$teacher->avatar) : '' }}" id="avatar" accept="image/*" name="avatar" alt="avatar" class="dropify">
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Pr??nom</label>
                                        <input type="text" name="first_name" value="{{ $teacher->first_name ?? '' }}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Nom</label>
                                        <input type="text" name="last_name" value="{{ $teacher->last_name ?? '' }}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Genre</label>
                                        <select class="custom-select" type="text" name="gender">
                                            <option @if($teacher->gender === 'Homme') selected @endif value="Homme">Homme</option>
                                            <option @if($teacher->gender === 'Femme') selected @endif value="Femme">Femme</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Date de naissance</label>
                                        <input  name="date_of_birth" type="date" value="{{ $teacher->date_of_birth ?? '' }}" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" value="{{ $teacher->email ?? '' }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">T??l??phone</label>
                                        <input type="tel" name="phone" value="{{ $teacher->phone ?? '' }}" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Pays</label>
                                        <select class="custom-select" type="text" name="country">
                                            @foreach ($countries as $key => $country)
                                                <option @if($country === $teacher->country) selected @endif value="{{ $country }}">{{ $country }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Adresse</label>
                                        <input type="text" name="address" value="{{ $teacher->address ?? '' }}" class="form-control">
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
                    'default': 'Faites un gliss?? d??pos?? ou cliquez',
                    'replace': 'Faites un gliss?? d??pos?? ou cliquez pour remplacer',
                    'remove':  'Supprimer',
                    'error':   'Ficher trop lourd'
                }
            });
        });
    </script>
@endsection
