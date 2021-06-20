@extends('layouts.student')

@section('content')

<div class="row">

    <div class="col-md-12" >
        <nav class="breadcrumb_widgets" aria-label="breadcrumb mb30" style="background-color: #6C2B69;">
            <h4 class="title float-left" style="color: white;">Tableau de bord</h4>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="#" style="color: white;">Accueil </a></li>
                <li class="breadcrumb-item active" aria-current="page" style="color: white;">Tableau de bord</li>
            </ol>
        </nav>
    </div>


        <div class="application_statics col-md-6">
            <h4>Vos statistiques</h4>

            <div class="row">
                <div class="col-md-6">
                    <div class="ff_one">
                        <div class="icon"><span class="flaticon-speech-bubble"></span></div>
                        <div >
                            <p><strong>Tous mes <br> formations</strong></p>
                            <div class="timer" style="font-size: 1.8em; font-weight: bold;">{{$countAMC}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="ff_one style2">
                        <div class="icon"><span class="flaticon-rating"></span></div>
                        <div >
                            <p><strong>Formations <br> en cours</strong></p>
                            <div class="timer" style="font-size: 1.8em; font-weight: bold;">{{$FIP}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="ff_one style3">
                        <div class="icon"><span class="flaticon-online-learning"></span></div>
                        <div >
                            <p><strong>Formations <br> terminées</strong></p>
                            <div class="timer " style="font-size: 1.8em; font-weight: bold;">{{$FF}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="ff_one style4">
                        <div class="icon"><span class="flaticon-like"></span></div>
                        <div>
                            <p><strong>Certificats & <br> attestations</strong></p>
                            <div class=" timer " style="font-size: 1.8em; font-weight: bold;">0</div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="col-md-6">
        <div class="recent_job_activity">
            <h4 class="title">Notifications</h4>

        </div>
    </div>
</div>

@endsection
