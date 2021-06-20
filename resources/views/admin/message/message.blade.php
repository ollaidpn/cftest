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
                    <h4>Derniers Messages</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index-2.html">Admin</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">messages</a></li>
                </ol>
            </div>
        </div>

        @include('includes.messages')

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Liste des messages</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Prénom</th>
                                        <th>Nom</th>
                                        <th>object mail</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            <tbody>

                                @foreach ($messages as $msg_visitors)
                                <tr>
                                    <td><a href="javascript:void(0);"><strong>{{$msg_visitors->first_name ?? ''}}</strong></a></td>
                                    <td><a href="javascript:void(0);"><strong>{{$msg_visitors->last_name ?? ''}}</strong></a></td>
                                    <td>{{$msg_visitors->object ?? ''}}</td>
                                    <td>{{$msg_visitors->created_at ?? ''}}</td>
                                    <td>
                                        <a href="#showModal" data-toggle='modal' id-msg_visitors='{{$msg_visitors->id}}' class="btn btn-sm btn-secondary btn-show"><i class="la la-eye" style="color: white" title="Afficher"></i></a>
                                        <a href="#answerModal" data-toggle='modal' email-msg_visitors='{{$msg_visitors->email ?? '' }}' class="btn btn-sm btn-primary btn-answer"><i class="la la-edit" style="color: white" title="repondre"></i></a>
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

{{-- Show Modal --}}
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
                    <div class="col-md-12">
                        <ul class="list-group mb-3 list-group-flush">
                            <li class="list-group-item px-0 d-flex">
                                <span class="mb-0 font-weight-bold mr-2">Nom: </span><span id="last_name"></span>
                            </li>
                            <li class="list-group-item px-0 d-flex">
                                <span class="mb-0 font-weight-bold mr-2">Prénom: </span><span id="first_name"></span>
                            </li>
                            <li class="list-group-item px-0 d-flex">
                                <span class="mb-0 font-weight-bold mr-2">Email: </span><span id="email"></span>
                            </li>
                            <li class="list-group-item px-0 d-flex">
                                <span class="mb-0 font-weight-bold mr-2">objet: </span><span id="object"></span>
                            </li>
                            <li class="list-group-item px-0">
                                <span class="mb-0 font-weight-bold mr-2">message: </span> <div class="mt-2" id="message"></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Answer Modal --}}
<div class="modal fade" id="answerModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Répondre</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="la la-close text-black"></i>
                </button>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.send-email') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="email" id="answer-email" />
                        <textarea class="form-control" placeholder="Ecrivez votre message" name="body" id="body" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary text-white float-right" type="submit">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- Datatable -->
<script src="{{ asset('assets/admin-formateurs/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script>
    $(function () {
        $('#example3').DataTable();
    })
</script>
<script>
    $(function () {
        $(document).on('click', '.btn-show', function () {
            var url = "{{route('admin.msgVisitors.show','id-msg_visitors')}}";
            var _this = $(this);
            var id_msgVisitor = _this.attr('id-msg_visitors');
            url = url.replace('id-msg_visitors', id_msgVisitor)
            $.get(url, function (data) {
                $('#first_name').text(data.msg_visitors.first_name);
                $('#last_name').text(data.msg_visitors.last_name);
                $('#object').text(data.msg_visitors.object);
                $('#message').text(data.msg_visitors.message);
                $('#email').text(data.msg_visitors.email);
            });
        });

        $(document).on('click', '.btn-answer', function () {
            var _this = $(this);
            email_msgVisitor = _this.attr('email-msg_visitors');
            $('#answer-email').val(email_msgVisitor);
        });
    });
</script>
@endsection
