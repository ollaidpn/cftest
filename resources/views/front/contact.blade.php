@extends('layouts.front')

@section('content')
<!-- Inner Page Breadcrumb -->
<section class="inner_page_breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3 text-center">
                <div class="breadcrumb_content">
                    <h4 class="breadcrumb_title">Contactez Nous</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Accueil </a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contactez Nous</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It's Work -->
<section class="our-contact">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-lg-4">
                <div class="contact_localtion text-center">
                    <div class="icon"><span class="flaticon-placeholder-1"></span></div>
                    <h4>Notre Adresse</h4>
                    <p>{{getInfoSystem()->address ?? ""}} </p>
                    <p>Dakar, Sénégal</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="contact_localtion text-center">
                    <div class="icon"><span class="flaticon-phone-call"></span></div>
                    <h4>Téléphones</h4>
                    <p class="mb0">Mobile: {{getInfoSystem()->mobile ?? ""}} <br> Fixe: {{getInfoSystem()->fixe ?? ""}}</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="contact_localtion text-center">
                    <div class="icon"><span class="flaticon-email"></span></div>
                    <h4>Mail</h4>
                    <p><a href="" class="__cf_email__" data-cfemail="d099beb6bf90b5b4a5bda9feb3bfbd">{{getInfoSystem()->system_email ?? ""}}</a></p>
                {{-- <p><a href="#" class="__cf_email__" data-cfemail="d099beb6bf90b5b4a5bda9feb3bfbd">{{getInfoSystem()->mobile ?? ""}}</a></p> --}}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30875.81261211274!2d-17.472088653306443!3d14.68562029388607!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xec172a1f672e155%3A0xad7d3ba6c108d4ff!2sCarapaces%20Strat%C3%A9gies%20%26%20Conformit%C3%A9s!5e0!3m2!1sfr!2ssn!4v1605092586666!5m2!1sfr!2ssn" width="600" height="660" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>

            <div class="col-lg-6 form_grid">
                @include('includes.messages')
                <h4 class="mb5">Envoyez nous un message</h4>
                <form class="contact_form"  action="{{route('contact.message')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="first_name">Votre nom</label>
                                <input id="first_name" name="first_name" class="form-control" required="required"  type="text">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="last_name">Votre prénom</label>
                                <input id="last_name" name="last_name" class="form-control" required="required"  type="text">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="email">Votre email</label>
                                <input id="email" name="email" class="form-control email" required="required"  type="email">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="object">L'objet de votre message</label>
                                <input id="object" name="object" class="form-control required" required="required"  type="text">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="message">Votre message</label>
                                <textarea id="message" name="message" class="form-control required" rows="5" required="required" ></textarea>
                            </div>
                            <div class="form-group ui_kit_button mb0">
                                <button type="submit" class="btn dbxshad btn-lg btn-thm circle white">Envoyer</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
