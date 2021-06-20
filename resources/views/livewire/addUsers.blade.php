<div class="content-body">
    <!-- row -->
    <div class="container-fluid">

        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Tous les réponses</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index-2.html">Admin</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Quiz</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Réponses</a></li>
                </ol>
            </div>
            {{-- flash message --}}
            @if (session()->has('success'))
            <div class="alert alert-custom alert-notice alert-light-success fade show" role="alert">
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
        {{-- fin flash message --}}
        </div>

        <div class="row">
            <div class="col-xl-3 col-xxl-3 col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ajouter/modifier une réponses</h4>

                    </div>
                    <div class="card-body">
                        <div class="basic-form">

                            <form wire:submit.prevent={{ $action }}>

                                <div class="form-group">
                                    <select class="form-control "  wire:model.lazy='formation'>
                                        <option>Choisir une formation</option>
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$formation->title}}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control "  wire:model.lazy='module_id'>
                                        <option>Choisir un module</option>
                                        @foreach($modules as $module)
                                        <option value="{{$module->id}}">{{$module->title}}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="question">Ecrire une réponse.</label>
                                    <textarea type="text" class="form-control" rows="4"  wire:model.lazy='question' id="question" class="form-control @error('name') is-invalid @enderror" placeholder="Renseigner une quesrtion ici"></textarea>

                                    @error('question')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>

                                  <button type="submit" class="btn btn-primary" style="color: white; font-weight:bold">{{-- $button --}} Enregister</button>
                            </form>





                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-xxl-9 col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Liste des réponses en fonction de chaque module</h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            {{-- Recherche & filtre --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="search" class="form-control" wire:model='query' placeholder="Recherche">
                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
                                    <div class="form-group">
                                        <select class="custom-select w-auto" wire:model.lazy='perPage' id="per_page">
                                            @for ($i = 5; $i <= 25; $i +=5)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                        <label for="per_page">résultat / page</label>
                                    </div>
                                </div>
                            </div>
                            {{-- Fin Recherche & filtre --}}

                            <table class="table table-bordered verticle-middle table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Question</th>
                                        <th scope="col">Formation</th>
                                        <th scope="col">Module</th>
                                        <th scope="col" style="text-align: right;">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quiz_answers as $quiz_answer)
                                    <tr>
                                        <td>1</td>
                                        <td style="font-weight:bold">{{$quiz_answers->question}}</td>
                                        <td>{{$quiz_answers->quiz->module->formation->title}}</td>
                                        <td>{{$quiz_answers->quiz->module->title}}</td>




                                        <td>
                                            <span>
                                                <a href="javascript:void()" class="mr-4" data-toggle="tooltip"
                                                    data-placement="top" title="Edit"><i
                                                        class="fa fa-pencil color-muted"></i> </a>
                                                <a href="javascript:void()" data-toggle="tooltip"
                                                    data-placement="top" title="Close"><i
                                                        class="fa fa-close color-danger"></i></a>
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{-- {{ $domains->links() }} --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
