@extends('layouts.admin')
@section('includes')
    <link href="{{ asset('assets/admin-formateurs/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">

        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Tous les Témoignages</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index-2.html">Admin</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Témoignages</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Liste</a></li>
                </ol>
            </div>
        </div>

        @include('includes.messages')

        <div class="row">
            <div class="col-lg-12">
                <ul class="nav nav-pills mb-3">
                </ul>
            </div>
            <div class="col-lg-12">
                <div class="row tab-content">
                    <div id="list-view" class="tab-pane fade active show col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Liste complète </h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Prénom</th>
                                                <th>Nom</th>
                                                <th>Email</th>
                                                <th>Témoignage</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($testimonials as $key => $testimonial)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td><a href="javascript:void(0);"><strong>{{$testimonial->user->first_name ?? ''}}</strong></a></td>
                                                <td><a href="javascript:void(0);"><strong>{{$testimonial->user->last_name ?? ''}}</strong></a></td>
                                                <td>{{$testimonial->user->email ?? ''}}</td>
                                                <td>{{ strlen($testimonial->testimonial) > 50 ? substr($testimonial->testimonial, 0, 50).'...' : $testimonial->testimonial ?? '' }}</td>
                                                <td>
                                                    <a href="{{ route('admin.testimonials.update', $testimonial->id) }}" class="btn btn-sm btn-success"><i class="la {{ $testimonial->status === 'pending' ? 'la-check' : 'la-remove' }}" style="color: black" title="Approuver / Desapprouver"></i></a>
                                                    <a href="#showModal" data-toggle='modal' id-testimonial={{$testimonial->id}} class="btn btn-sm btn-secondary btn-show"><i class="la la-eye" style="color: white" title="Afficher"></i></a>
                                                    <a href="#deleteConfirmationModal" data-toggle='modal' id-testimonial={{$testimonial->id}} class="btn btn-sm btn-danger delete-btn"><i class="la la-trash-o" title="Delete"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

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
                    Voulez vous vraiment supprimer ce témoignage ?
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
                    <div class="text-center">
                        <ul class="list-group mb-3 list-group-flush">
                            <li class="list-group-item px-0 d-flex">
                                <span class="mb-0 font-weight-bold mr-2">Prénom: </span><span id="first_name"></span>
                            </li>
                            <li class="list-group-item px-0 d-flex">
                                <span class="mb-0 font-weight-bold mr-2">Nom: </span><span id="last_name"></span>
                            </li>
                            <li class="list-group-item px-0 d-flex">
                                <span class="mb-0 font-weight-bold mr-2">Email: </span><span id="email"></span>
                            </li>
                            <li class="list-group-item px-0 text-left">
                                <span class="mb-0 font-weight-bold mr-2">Témoignage: </span><div id="testimonial"></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(function () {

        $(document).on('click', '.btn-show', function () {
            var url = "{{route('admin.testimonials.show','id-testimonial')}}";
            var _this = $(this);
            id_testimonial = _this.attr('id-testimonial');
            url = url.replace('id-testimonial', id_testimonial);
            $.get(url, function (data) {
                $('#first_name').text(data.testimonial.user.first_name);
                $('#last_name').text(data.testimonial.user.last_name);
                $('#email').text(data.testimonial.user.email);
                $('#testimonial').text(data.testimonial.testimonial);
            });
        });
    });
</script>
<script>

    jQuery(document).ready(function() {

        var btn_yes = $('#btn-yes');
        var id_testimonial = 0;
        var url = "{{route('admin.testimonials.destroy','id-testimonial')}}"

        $(document).on('click', '.delete-btn', function () {
            console.log('delete clicked');
            var _this = $(this);
            id_testimonial = _this.attr('id-testimonial');
            console.log(_this);
            url = url.replace('id-testimonial', id_testimonial)
            btn_yes.attr('href', url);
        });

    });

</script>
<script src="{{ asset('assets/admin-formateurs/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script>
    $(function () {
        $('#example3').DataTable();
    })
</script>
@endsection



