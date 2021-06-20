@extends('layouts.front')

@section('content')
<!-- Inner Page Breadcrumb -->
<section class="inner_page_breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3 text-center">
                <div class="breadcrumb_content">
                    <h4 class="breadcrumb_title">Inscription</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Page Inscription</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our LogIn Register -->
<section class="our-log-reg bgc-fa">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-6 offset-lg-3">
                <div class="sign_up_form inner_page">
                    <div class="heading">
                        <h3 class="text-center">Inscrivez-vous et commencer à apprendre </h3>
                        <p class="text-center">Vous avez déjà un compte ? <a class="text-thm" href="page-login.html">Connectez vous !</a></p>
                    </div>
                    <div class="details">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" placeholder="Prénom" required autocomplete="first_name" autofocus>
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" placeholder="Nom" required autocomplete="last_name" autofocus>
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="Téléphone" required autocomplete="phone" autofocus>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                             <div class="form-group">
                                <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="password" type="password" placeholder="Mot de passe" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="password_confirmation" type="password" placeholder="Confirmation du mot de passe" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="password_confirmation">
                            </div>
                            {{-- <div class="form-group custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="exampleCheck3">
                                <label class="custom-control-label" for="exampleCheck3">Vous voulez devenir formateur et dispenser des cours ?</label>
                            </div> --}}
                            <button type="submit" class="btn btn-log btn-block btn-thm2">Inscription</button>
                            <div class="divide">
                                <span class="lf_divider">Ou</span>
                                <hr>
                            </div>
                            <a href="{{ route('login') }}" class="btn btn-log btn-block btn-thm2">Connexion</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
