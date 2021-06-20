@extends('layouts.student')
@push('styles')
    <link href="{{ asset('assets/admin-formateurs/plugins/dropify/dist/css/dropify.min.css') }}" rel="stylesheet">
@endpush
@section('content')
<div class="col-lg-12">
    <nav class="breadcrumb_widgets" aria-label="breadcrumb mb30" style="background-color: #6C2B69;">
        <h4 class="title float-left" style="color: white;">Paramètres de compte</h4>
        <ol class="breadcrumb float-right">
            <li class="breadcrumb-item" ><a href="#" style="color: white;">Espace Client</a></li>
            <li class="breadcrumb-item active" aria-current="page" style="color: whitesmoke;">Profile</li>
        </ol>
    </nav>

</div>
@include('includes.messages')
<div class="col-lg-12">
    <div class="my_course_content_container">
        <div class="my_setting_content mb30">
            <div class="my_setting_content_header">
                <div class="my_sch_title">
                    <h4 class="m0">Information de compte</h4>
                </div>
            </div>
            <form action="{{route('student.settings.profil.update')}}" enctype="multipart/form-data" id="my_form" method="post">
                @csrf
                <div class="row my_setting_content_details pb0">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group fallback w-100" wire:ignore>
                        <label class="form-label d-block">Avatar</label>
                        <input type="file" data-default-file="{{ file_exists(public_path('storage/'.$student->avatar)) ? $student->image() : '' }}" id="avatar" accept="image/*" name="avatar" alt="avatar" class="dropify">
                    </div>
                    @error('image')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="row">
                        <div class="col-xl-6 col-md-6 col-sm-6">
                            <div class="my_profile_setting_input form-group">
                                <label for="formGroupExampleInput1">Prénom</label>
                                <input type="text" name="first_name" value='{{$student->first_name ?? ''}}' class="form-control" id="formGroupExampleInput1">
                            </div>
                            <div class="my_profile_setting_input form-group">
                                <label for="formGroupExampleInput2">Nom</label>
                                <input type="text" name="last_name" value='{{$student->last_name ?? ''}}' class="form-control" id="formGroupExampleInput2">
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 col-sm-6">
                            <div class="my_profile_setting_input form-group">
                                <label for="formGroupExampleInput3">Date de naissance</label>
                                <input type="date" name="date_of_birth" value='{{$student->date_of_birth ?? ''}}' class="form-control" id="formGroupExampleInput3" placeholder="Cliquez pour ajouter">
                            </div>
                            <div class="my_profile_setting_input form-group">
                                <label for="exampleInputPhone">Numéro de téléphone</label>
                                <input type="tel" name="phone" value='{{$student->phone ?? ''}}' class="form-control" id="exampleInputPhone" aria-describedby="phoneNumber">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="my_resume_textarea">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Email</label>
                            <input type="email" name="email" value='{{$student->email ?? ''}}' class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="my_resume_textarea">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Adresse</label>
                            <input type="text" name="address" value='{{$student->address ?? ''}}' class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label class="form-label">Genre</label>
                        <select class="custom-select" type="text" name="gender">
                            <option @if($student->gender==='Homme') selected @endif value="Homme">Homme</option>
                            <option @if($student->gender==='Femme') selected @endif value="Femme">Femme</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label class="form-label">Pays</label>
                        <select class="custom-select" type="text" name="country">
                            @foreach ($countries as $country)
                                <option @if($student->country===$country) selected @endif value="{{ $country }}">{{ $country }}</option>
                            @endforeach

                        </select>
                    </div>
                </div>

            </div>

            <div class="row my_setting_content_details pb0">
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Ancien mot de passe</label>
                        <input type="password" name="actual_password" class="form-control" id="exampleInputPassword1">
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="exampleInputPassword2">Nouveau mot de passe</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword2">
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="exampleInputPassword3">Confirmation du mot de passse</label>
                        <input type="password" name="password_confirmation" class="form-control mb0" id="exampleInputPassword3">
                    </div>
                </div>

                <div class="col-md-12 my-3">
                    <button class="btn btn-primary text-white">
                        <a href="javascript:{}" class="text-white" onclick="document.getElementById('my_form').submit(); return false;">Enregistrer</a>
                    </button>
                </div>
            </div>
            </form>

        </div>
    </div>
</div>

@endsection

@push('scripts')
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
@endpush
