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
                    <h4>Ajouter Apprenants</h4>
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
                    <form action="{{route('admin.settings.update')}}" enctype="multipart/form-data" method="post">
                        @csrf

                            <div class="col-12">
                                <h3 style="margin-bottom: 1em">Informations Générales du Système </h3>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Logo</label>
                                            <input type="file" id="logo" data-default-file="{{ getInfoSystem() ? getInfoSystem()->getLogo() : '' }}" accept="image/*" name="logo" class="dropify">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Favicon</label>
                                            <input type="file" id="favicon" data-default-file="{{ getInfoSystem() ? getInfoSystem()->getFavicon() : '' }}" accept="image/*" name="favicon" class="dropify">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">Image Slider</label>
                                            <input type="file" id="img_slider" data-default-file="{{ getInfoSystem() ? getInfoSystem()->getImgSlider() : '' }}" accept="image/*" name="img_slider" class="dropify">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">Image Header</label>
                                            <input type="file" id="img_header" data-default-file="{{ getInfoSystem() ? getInfoSystem()->getImgHeader() : '' }}" accept="image/*" name="img_header" class="dropify">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Nom de la plateforme</label>
                                            <input type="text" name="system_name" value="{{getInfoSystem()->system_name ?? ''}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="system_email" value="{{getInfoSystem()->system_email ?? ''}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Adresse</label>
                                            <input type="text" name="address" value="{{getInfoSystem()->address ?? ''}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Fixe</label>
                                            <input type="tel" name="fixe" value="{{getInfoSystem()->fixe ?? ''}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Mobile</label>
                                            <input type="tel" name="mobile" value="{{getInfoSystem()->mobile ?? ''}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <h3 style="margin-bottom: 1em; margin-top: 1em">Lien Réseaux Sociauxs </h3>
                                <hr/>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Facebook</label>
                                        <input type="text" name="facebook"  value="{{getInfoSystem()->facebook ?? ''}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Instagram</label>
                                            <input type="text" name="insta"  value="{{getInfoSystem()->insta ?? ''}}"  class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Linkedin</label>
                                            <input type="text" name="linkedin"  value="{{getInfoSystem()->linkedin ?? ''}}"  class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Twitter</label>
                                            <input type="text" name="twitter"  value="{{getInfoSystem()->twitter ?? ''}}"  class="form-control">
                                        </div>
                                    </div>
                                </div>
                                    <button type="submit" class="btn btn-primary" style="color: white; font-weight:bold">Enregistrer</button>
                                    {{-- <button type="submit" class="btn btn-light">Annuler</button> --}}
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
            $('#logo').dropify({
                messages: {
                    'default': 'Faites un glissé déposé ou cliquez',
                    'replace': 'Faites un glissé déposé ou cliquez pour remplacer',
                    'remove':  'Supprimer',
                    'error':   'Ficher trop lourd'
                }
            });

            $('#favicon').dropify({
                messages: {
                    'default': 'Faites un glissé déposé ou cliquez',
                    'replace': 'Faites un glissé déposé ou cliquez pour remplacer',
                    'remove':  'Supprimer',
                    'error':   'Ficher trop lourd'
                }
            });

            $('#img_slider').dropify({
                messages: {
                    'default': 'Faites un glissé déposé ou cliquez',
                    'replace': 'Faites un glissé déposé ou cliquez pour remplacer',
                    'remove':  'Supprimer',
                    'error':   'Ficher trop lourd'
                }
            });

            $('#img_header').dropify({
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
