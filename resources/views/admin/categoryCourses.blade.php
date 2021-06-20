@extends('layouts.admin')
@section('includes')

@endsection

@section('content')
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">

        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Toutes les formations</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index-2.html">Admin</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Formations</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Liste</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-4 col-xxl-4 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ajouter/modifier une catégorie</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form>
                                <div class="form-group">
                                    <input type="text" class="form-control input-default " placeholder="Nom de la catégorie">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" rows="4" id="comment" placeholder="Description de la catégorie"></textarea>
                                </div>
                                <div class="form-group">
                                    <select class="form-control ">
                                        <option>Catégorie parent</option>
                                        <option>Option 2</option>
                                        <option>Option 3</option>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-primary" style="color: white; font-weight:bold">Primary</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-xxl-8 col-lg-8 ">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Liste des catégorie</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered verticle-middle table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Parent</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td style="font-weight:bold">Droit des affaires</td>
                                        <td>Droit</td>



                                        <td>
                                            <span>
                                                <a href="javascript:void()" class="mr-4" data-toggle="tooltip"
                                                    data-placement="top" title="Edit"><i
                                                        class="fa fa-pencil color-muted"></i> </a>
                                                <a href="javascript:void()" data-toggle="tooltip"
                                                    data-placement="top" title="Delete"><i
                                                        class="fa fa-close color-danger"></i></a>
                                            </span>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

@section('script')

@endsection
