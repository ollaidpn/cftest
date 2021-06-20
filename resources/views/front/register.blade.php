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
                        <form action="#">
                            <div class="form-group">
                                <input type="text" class="form-control" id="exampleInputName2" placeholder="Prénom">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="exampleInputName2" placeholder="Nom">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="exampleInputName2" placeholder="Numéro de téléphone">
                            </div>
                             <div class="form-group">
                                <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Adresse email">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="exampleInputPassword4" placeholder="Mot de passe">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="exampleInputPassword5" placeholder="Confirmer votre mot de passe">
                            </div>
                            <div class="form-group custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="exampleCheck3">
                                <label class="custom-control-label" for="exampleCheck3">Vous voulez devenir formateur et dispenser des formations ?</label>
                            </div>
                            <button type="submit" class="btn btn-log btn-block btn-thm2">Inscription</button>
                            <div class="divide">
                                <span class="lf_divider">Or</span>
                                <hr>
                            </div>
                            <button type="submit" class="btn btn-log btn-block btn-thm2">Connexion</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
