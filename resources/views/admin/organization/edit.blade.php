@extends('layouts.admin')
@section('includes')
    <link href="{{ asset('assets/admin-formateurs/plugins/dropify/dist/css/dropify.min.css') }}" rel="stylesheet">
@endsection
@section('content')

<div class="content-body">
    <!-- row -->
    <div class="container-fluid">


        <div class="mx-0 row page-titles">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Modifier organisations</h4>
                </div>
            </div>
            <div class="mt-2 col-sm-6 p-md-0 justify-content-sm-end mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index-2.html">Admin</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Organisations</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Modifier organisation</a></li>
                </ol>
            </div>
        </div>

        @include('includes.messages')

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.organizations.update', $organization->id) }}" enctype="multipart/form-data" method='post'>
                            @csrf
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Logo</label>
                                        <input type="file" data-default-file="{{ $organization->image() }}" id="logo" accept="image/*" name="logo" class="dropify">
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Nom</label>
                                        <input type="text" value="{{ $organization->name ?? '' }}" required name='name' class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Téléphone</label>
                                        <input type="tel" value="{{ $organization->phone ?? '' }}" required name='phone' class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Adresse</label>
                                        <input type="text" value="{{ $organization->address ?? '' }}" required name='address' class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" name='description' rows="6">{{ $organization->description ?? '' }}"</textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <button type="submit" class="btn btn-primary" style="color: white; font-weight:bold">Enregistrer</button>
                                    {{-- <button type="submit" class="btn btn-light">Annuler</button> --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


  <!-- Success message -->

    </div>


</div>



@endsection
@section('script')
    <script src="{{ asset('assets/admin-formateurs/plugins/dropify/dist/js/dropify.min.js') }}"> </script>
    <script>
        $(function () {
            $('#logo').dropify({
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
