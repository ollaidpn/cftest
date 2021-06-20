@extends('layouts.admin')
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

        @include('includes.messages')

        <div class="row">
            @if ($formations)
                @foreach ($formations as $formation)
                    <div class="col-xl-3 col-xxl-4 col-lg-4 col-md-6 col-sm-6">
                        <div class="card">
                            <img class="img-fluid" src="{{ $formation->cover() }}" alt="{{ $formation->title ?? '' }}">
                            <div class="card-body">
                                <h4>{{ $formation->title ?? '' }}</h4>
                                <ul class="list-group mb-3 list-group-flush">
                                    <li class="list-group-item px-0 border-top-0 d-flex justify-content-between"><span class="mb-0 text-muted">{{ $formation->created_at ?? '' }}</span>
                                    <li class="list-group-item px-0 d-flex justify-content-between">
                                        <span class="mb-0"><i class="fa fa-clock-o text-primary mr-2"></i>Durée :</span><strong>{{ $formation->nb_hours ?? '' }}</strong></li>
                                    <li class="list-group-item px-0 d-flex justify-content-between">
                                        <span class="mb-0"><i class="fa fa-user text-primary mr-2"></i>Formateur :</span><strong>{{$formation->teacher() ? $formation->teacher()->getFullName() : 'Futurs Choisis'}}</strong></li>
                                    <li class="list-group-item px-0 d-flex justify-content-between">
                                        <span><i class="fa fa-graduation-cap text-primary mr-2"></i>Apprenants</span><strong>{{ count($formation->students) ?? '' }}</strong></li>
                                </ul>
                                <div class="justify-content-between">
                                    <a href="{{ route('admin.formations.update', $formation->id) }}" class="btn btn-primary" style="color: white; font-weight:bold">Modifier</a>
                                    <a href="{{ route('front.course.show', $formation->slug ?? '') }}" class="btn btn-primary" style="color: white; font-weight:bold">Voir</a>
                                    <a href="#deleteConfirmationModal" data-toggle='modal' id-formation={{$formation->id}} class="btn btn-danger float-right delete-btn"><i class="la la-trash-o" title="Supprimer"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            @else
                Aucune Formations n'a été trouvé !
            @endif

        </div>

        <div class="d-flex justify-content-center">
            {{ $formations->links() }}
        </div>

    </div>
</div>


{{-- Delete Modal --}}
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Supprimer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                Voulez vous vraiment supprimer cette formation ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold"
                    data-dismiss="modal">Non</button>
                <a href="#" type="button" id="btn-yes"
                    class="btn btn-danger font-weight-bold">Oui</a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>

    jQuery(document).ready(function() {

        var btn_yes = $('#btn-yes');
        var id_formation = 0;
        var url = "{{route('admin.formations.delete','id-formation')}}"

        $(document).on('click', '.delete-btn', function () {
            console.log('delete clicked');
            var _this = $(this);
            id_formation = _this.attr('id-formation');
            console.log(_this);
            url = url.replace('id-formation', id_formation)
            btn_yes.attr('href', url);
        });

    });

</script>
@endsection
