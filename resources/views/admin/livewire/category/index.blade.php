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

        @if (session()->has('success'))
        <div class="alert alert-success fade show" role="alert">
            <div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
            <div class="alert-text">{{ session('success') }}</div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="ki ki-close"></i></span>
                    </button>
                </div>
            </div>
        @elseif (session()->has('error'))
            <div class="alert alert-custom alert-notice alert-light-danger fade show" role="alert">
                <div class="alert-icon"><i class="flaticon2-delete"></i></div>
            <div class="alert-text">{{ session('error') }}</div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="ki ki-close"></i></span>
                    </button>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-xl-4 col-xxl-4 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ajouter/modifier une catégorie</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form wire:submit.prevent={{ $action }}>
                                <div class="form-group">
                                    <input type="text" wire:model.lazy='title' class="form-control input-default " placeholder="Nom de la catégorie">
                                </div>
                                <div class="form-group">
                                    <textarea wire:model.lazy='description' class="form-control" rows="4" id="comment" placeholder="Description de la catégorie"></textarea>
                                </div>
                                <div class="form-group">
                                    <select wire:model.lazy='category_parent' class="custom-select">
                                        <option value="0">Pas de Catégorie parent</option>
                                        @foreach ($all_categories as $category)
                                            <option value={{ $category->id ?? '' }}>{{ $category->title ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-block btn-primary" style="color: white; font-weight:bold">Enregistrer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-xxl-8 col-lg-8">
                <div class="card">
                    <div class="card-header row">
                        <div class="col-md-6">
                            <input type="search" class="form-control" wire:model='query' placeholder="Recherche">
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <div class="form-group">
                                <select class="w-auto form-control" wire:model.lazy='perPage' id="per_page">
                                    @for ($i = 5; $i <= 25; $i +=5)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                                <label for="per_page">categorie par page</label>
                            </div>
                        </div>
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
                                    @foreach ($categories as $key => $category)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td style="font-weight:bold">{{ $category->title }}</td>
                                        <td>{{$category->parent ? $category->parent->title : "neant"}}</td>
                                        <td>

                                                <div class="row">
                                                    <div class="ml-4">
                                                        <a href="javascript:void()" wire:click='edit({{$category->id ?? ''}})' class="mr-4 btn btn-primary" data-toggle="tooltip"
                                                            data-placement="top" title="Edit" style="color: white">Modifier </a>
                                                    </div>

                                                    {{-- <div class="form-group">
                                                        <input type="submit" class="delete-user" value="Effacer ">
                                                    </div> --}}
                                                    <div>
                                                        <form action="{{ route('categorie.destroy',$category->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="form-group">
                                                                <input type="submit" class="btn btn-danger delete-user" value="Supprimer ">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>


                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $categories->links() }}
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
                    Voulez vous vraiment supprimer cette categorie ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold"
                        data-dismiss="modal">Non</button>
                    <button type="button" id="btn-yes" wire:click=''
                        class="btn btn-danger font-weight-bold">Oui</button>
                </div>
            </div>
        </div>
    </div>


</div>

