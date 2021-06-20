@extends('layouts.admin')
@section('includes')
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="mx-0 row page-titles">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Liste des organisations</h4>
                    <span class="ml-1">Statistics</span>
                </div>
            </div>
            <div class="mt-2 col-sm-6 p-md-0 justify-content-sm-end mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Admin</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Organisations</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->

        @include('includes.messages')

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Liste complète  </h4>
                        <a href="{{ route('admin.organizations.create') }}" class="btn btn-primary" style="color: white; font-weight:bold">+ Ajouter</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($organizations as $organization)
                            <div class="col-md-6 col-xl-6 col-xxl-6 col-sm-12">
                                <div class="widget-stat card" style="background-color:#D9C7D7" >
                                    <div class="card-body d-flex justify-content-between">
                                        <a href="#showModal" data-toggle="modal" class="btn-show" id-organization="{{ $organization->id }}">
                                            <div class="media ai-icon">
                                                <span class="mr-3">
                                                    <img src="{{ $organization->image() }}" class="rounded-circle" style="height: inherit;" alt="logo-{{ $organization->name ?? '' }}">
                                                </span>
                                                <div class="media-body">
                                                    <p class="mb-1" style="color: black; font-weight:bold">{{$organization->name ?? ''}} </p>
                                                    <h5 class="mb-0">Téléphone: <strong class="text-primary">{{$organization->phone ?? ''}} </strong></h5>
                                                    <h5 class="mb-0">Adresse: <strong class="text-primary">{{$organization->address ?? ''}} </strong></h5>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="buttons">
                                            <div>
                                                <a href="{{ route('admin.organizations.edit', $organization->id) }}">
                                                    <i class="la la-pencil" style="font-size: 24px;" title="Edit"></i>
                                                </a>
                                            </div>
                                            <div class="h-100" style="display: flex; justify-content: space-around; flex-direction: column;">
                                                <a href="#deleteConfirmationModal" class="delete-btn" data-toggle='modal' id-organization="{{ $organization->id }}">
                                                    <i class="la la-trash-o" style="font-size: 24px;" title="Delete"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $organizations->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Delete confirmation modal --}}
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
                Voulez vous vraiment supprimer cette organisation ?
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

{{-- Showing information popup --}}
<div class="modal fade" id="showModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Afficher</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="la la-close text-black"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <img src="" id="logo-organization" class="align-items-center" style="width: 100%" alt="avatar">
                    </div>
                    <div class="col-md-8">
                        <ul class="list-group mb-3 list-group-flush mb-2">
                            <li class="list-group-item px-0 d-flex">
                                <span class="mb-0 mr-2">Nom: </span><span id="name"></span>
                            </li>
                            <li class="list-group-item px-0 d-flex">
                                <span class="mb-0 mr-2">Téléphone: </span><span id="phone"></span>
                            </li>
                            <li class="list-group-item px-0 d-flex">
                                <span class="mb-0 mr-2">Adresse: </span><span id="address"></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <hr class="my-1">
                <div class="text-center">
                    <ul class="list-group mb-3 list-group-flush">
                        <li class="list-group-item px-0 d-flex">
                            <span class="mb-0 mr-2">Description: </span><span id="description"></span>
                        </li>
                    </ul>
                </div>
                <hr class="my-1">
                <div>Equipes:</div>
                <div class="team" id="team"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>

$(function () {

    $(document).on('click', '.btn-show', function () {
        var url = "{{route('admin.organizations.show','id-organization')}}";
        var _this = $(this);
        var id_organization = _this.attr('id-organization');
        url = url.replace('id-organization', id_organization)
        $.get(url, function (data) {
            $('#phone').text(data.organization.phone);
            $('#name').text(data.organization.name);
            $('#address').text(data.organization.address);
            $('#description').text(data.organization.description);
            var img = data.organization.logo ? "{{ asset('storage/'.'url-img') }}" : `https://ui-avatars.com/api/?name=${data.organization.name}&rounded=true&background=0D8ABC&color=fff&size=300`;
            $('#logo-organization').attr('src', img.replace('url-img', data.organization.logo ));
            data.organization.teams.map(function (team) {
                $('#team').append(`<div class='ml-3'>- ${team.name}</div>`);
            });
        });
    });


    var btn_yes = $('#btn-yes');
    var id_organization = 0;
    var url = "{{route('admin.organizations.delete','id-organization')}}";

    $(document).on('click', '.delete-btn', function () {
        console.log('delete clicked');
        var _this = $(this);
        id_organization = _this.attr('id-organization');
        console.log(_this);
        url = url.replace('id-organization', id_organization)
        btn_yes.attr('href', url);
    });

});

</script>
@endsection
