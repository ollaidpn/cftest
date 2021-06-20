@extends('layouts.teacher')
@section('content')
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">

        <div class="mx-0 row page-titles">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Toutes les formations</h4>
                </div>
            </div>
            <div class="mt-2 col-sm-6 p-md-0 justify-content-sm-end mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index-2.html">Admin</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Formations</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Liste</a></li>
                </ol>
            </div>
        </div>

        <div class="row mx-0">
            @if (count($formations)>0)
                @foreach ($formations as $formation)
                    <div class="col-xl-3 col-xxl-4 col-lg-4 col-md-6 col-sm-6">
                        <div class="card">
                            <img class="img-fluid" src="{{ $formation->cover() }}" alt="{{ $formation->title ?? '' }}">
                            <div class="card-body">
                                <h4>{{ $formation->title ?? '' }}</h4>
                                <ul class="list-group mb-3 list-group-flush">
                                    <li class="list-group-item px-0 border-top-0 d-flex justify-content-between"><span class="mb-0 text-muted">{{ $formation->created_at ?? '' }}</span>
                                        {{-- <a href="javascript:void(0);"><i class="la la-heart-o mr-1"></i><strong>230</strong></a></li> --}}
                                    <li class="list-group-item px-0 d-flex justify-content-between">
                                        <span class="mb-0"><i class="fa fa-clock-o text-primary mr-2"></i>Durée :</span><strong>{{ $formation->nb_hours ?? '' }}</strong></li>
                                    <li class="list-group-item px-0 d-flex justify-content-between">
                                        <span class="mb-0"><i class="fa fa-user text-primary mr-2"></i>Formateur :</span><strong>{{$formation->teacher() ? $formation->teacher()->getFullName() : 'Futurs Choisis'}}</strong></li>
                                    <li class="list-group-item px-0 d-flex justify-content-between">
                                        <span><i class="fa fa-graduation-cap text-primary mr-2"></i>Apprenants</span><strong>{{ count($formation->students) ?? '' }}</strong></li>
                                </ul>
                                <div class="justify-content-between">
                                    <a href="{{ route('admin.formations.update', $formation->id) }}" class="btn btn-primary" style="color: white; font-weight:bold">Modifier</a>
                                    <a href="about-courses.html" class="btn btn-primary" style="color: white; font-weight:bold">Voir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            @else
                    <div class="col-12  page-titles card">
                        Aucune formation n'a été trouvé !
                    </div>

            @endif

        </div>

        <div class="d-flex justify-content-center">
            {{ $formations->links() }}
        </div>

    </div>
</div>
@endsection
