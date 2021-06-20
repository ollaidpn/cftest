<div id="quizz">
    @if (session()->has('success'))
        <div class="alert alert-success alert-notice alert-light-success fade show" role="alert">
            <div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
        <div class="alert-text">{{ session('success') }}</div>
            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="ki ki-close"></i></span>
                </button>
            </div>
        </div>
    @elseif (session()->has('error'))
        <div class="alert alert-danger alert-notice alert-light-danger fade show" role="alert">
            <div class="alert-icon"><i class="flaticon2-delete"></i></div>
        <div class="alert-text">{{ session('error') }}</div>
            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="ki ki-close"></i></span>
                </button>
            </div>
        </div>
    @elseif ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-md-8" style="padding-left: 1.9rem !important;">
            <form wire:submit.prevent={{ $action }}>
                <div class="form-group">
                    <label class="form-label">Module concerné</label>
                    <select name="" required wire:model="quizz.module_id" class="custom-select" id="">
                        @if ($modules)
                            @foreach ($modules as $module)
                                <option value="{{ $module->id }}">{{ $module->title ?? '' }}</option>
                            @endforeach
                        @else
                            Aucun module
                        @endif
                    </select>
                    @error('module_id')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Question</label>
                    <input type="text" required wire:model.defer="quizz.question" name="name_section" class="form-control">
                    @error('question')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex align-items-end">
                    <div class="form-group w-100 mr-2">
                        <label class="form-label">Réponse</label>
                        <input type="text" wire:model.defer="quizz.answer" name="name_section" class="form-control">
                        @error('answer')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <small>Si la réponse que vous avez donnée est la bonne, cochez la case suivante.</small>
                    <div class="form-check mb-3">
                        <input type="checkbox" wire:model.defer="quizz.is_answer_true" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label font-weight-bold mt-0 mr-5" for="exampleCheck1">Vrai</label>
                        @error('is_answer_true')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                @if ($actual_question)
                    @foreach ($actual_question->answers as $answer)
                    <div class="align-items-center d-flex mb-2">
                        <a href="javascript:;" wire:click="selectAnswer({{ $answer->id }})">
                            <span class="mr-3">{{ $answer->answer }}</span>
                        </a>
                        <a href="javascript:;" wire:click="deleteAnswer({{ $answer->id }})">
                            <i class="la font-weight-bold text-danger la-trash" style="font-size: 24px;"></i>
                        </a>
                    </div>
                    @endforeach
                @endif

                <div class="form-group mt-4 float-right">
                    <button type="submit" class="btn btn-success text-white">Enregistrer</button>
                    <button type="button" wire:click='resetAll' class="btn btn-primary text-white">Annuler</button>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <strong>
                Architecture
            </strong>
            <div id="accordion2" class="mt-2">
                @if ($quizzes)
                    @foreach ($quizzes as $key => $quizz)
                        <div class="card">
                            <div class="card-header pt-2" id="headingTwo{{ $key }}" style="background-color:#6C2B69;">
                                <h5 class="mb-0">
                                    <button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseTwo{{ $key }}" aria-expanded="true" aria-controls="collapseTwo{{ $key }}">
                                    {{ $quizz->title ?? 'Quizz' }}
                                    </button>
                                </h5>
                                {{-- @if (sizeof($quizz->questions) > 0)
                                    <a href="#deleteConfirmationModal1" class="float-right" title="Supprimer ce module" data-toggle="modal">
                                @else --}}
                                    <a href="javascript:;" class="float-right" title="Supprimer ce module" wire:click="deleteQuiz({{ $quizz->id }})">
                                {{-- @endif --}}
                                    <i class="la font-weight-bold text-white la-trash" style="font-size: 24px;"></i>
                                </a>
                            </div>

                            <div id="collapseTwo{{ $key }}" class="collapse {{ count($quizzes) - 1 === $key ? 'show' : '' }}" aria-labelledby="headingTwo{{ $key }}" data-parent="#accordion2">
                                <div class="card-body">
                                    @if ($quizz->questions)
                                        <ul>
                                            @foreach ($quizz->questions as $question)
                                                <li class="d-flex justify-content-between">
                                                    <a href="javascript:;" wire:click="selectQuestion({{ $question->id }})">{{ $question->question }}</a>
                                                    <a href="javascript:;" wire:click="deleteQuestion({{ $question->id }})">
                                                        <i class="la font-weight-bold text-danger la-trash" style="font-size: 24px;"></i>
                                                    </a>
                                                </li>
                                                <hr>

                                            @endforeach
                                            <div class="d-flex justify-content-end mt-4">
                                                <button type="button" wire:click="addQuestion({{ $quizz->id }})" class="btn btn-success text-white">Question +</button>
                                            </div>
                                        </ul>

                                    @else
                                        Aucune question
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div>
                        Aucun quizz
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteConfirmationModal1" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Attention</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    Impossible de supprimer ce quizz car il contient des questions. Veuillez supprimer les questions appartenant à ce quizz.
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-danger font-weight-bold"
                        data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        $(function () {
            @this.on('scrollTop', function () {
                window.scrollTo({ top: 0, behavior: "smooth" });
            });
        });
    </script>
@endpush
