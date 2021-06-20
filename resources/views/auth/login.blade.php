@extends('layouts.front')

@section('content')
<!-- Inner Page Breadcrumb -->
<section class="inner_page_breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3 text-center">
                <div class="breadcrumb_content">
                    <h4 class="breadcrumb_title">Connexion</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Page de connexion</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our LogIn Register -->
<section class="our-log bgc-fa">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-6 offset-lg-3">
                <div class="login_form inner_page">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="heading">
                            <h3 class="text-center">Connectez vous à votre compte</h3>
                            {{-- <p class="text-center">Vous n'avez pas un compte ? <a class="text-thm" href="page-register.html">S'inscrire !</a></p> --}}
                        </div>
                         <div class="form-group">
                            <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="password" type="password" placeholder="Mot de passe" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" checked name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="remember">Se souvenir de moi</label>
                            <a class="tdu btn-fpswd text-black-50 float-right" href="{{ route('password.request') }}">Mot de passe oublié?</a>
                        </div>
                        <button type="submit" class="btn btn-log btn-block btn-thm2">Connexion</button>
                        <div class="divide">
                            <span class="lf_divider">Ou</span>
                            <hr>
                        </div>
                        <a href="{{ route('register') }}" class="btn btn-log btn-block btn-thm2">Inscription</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
