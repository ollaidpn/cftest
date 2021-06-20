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
            <form wire:submit.prevent='storeQuizz'>
                <div class="form-group">
                    <label class="form-label">Module concerné</label>
                    <select name="" wire:model.defer="quizz.module_id" class="custom-select" id="">
                        @if ($modules)
                            @foreach ($modules as $module)
                                <option value="{{ $module->id }}">{{ $module->title ?? '' }}</option>
                            @endforeach
                        @else
                            Aucun module
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Question</label>
                    <input type="text" wire:model.defer="quizz.question" name="name_section" class="form-control">
                </div>
                <div class="d-flex align-items-end">
                    <div class="form-group w-100 mr-2">
                        <label class="form-label">Réponse</label>
                        <input type="text" wire:model.defer="quizz.answer" name="name_section" class="form-control">
                    </div>
                    {{-- <div class="form-group">
                        <button type="button" wire:click='incrementCountAnswer' class="btn btn-success text-white btn-block"><i class="la la-check font-weight-bold"></i></button>
                    </div> --}}
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <small>Si la réponse que vous avez donnée est la bonne, cochez la case suivante.</small>
                    <div class="form-check mb-3">
                        <input type="checkbox" wire:model.defer="quizz.is_answer_true" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label font-weight-bold mt-0 mr-5" for="exampleCheck1">Vrai</label>
                    </div>
                </div>

                @if ($actual_question)
                    @foreach ($actual_question->answers as $answer)
                    <div class="align-items-center d-flex mb-2">
                        <span class="mr-3">{{ $answer->answer }}</span>
                        <a href="javascript:;" wire:click.prevent="delete({{ $answer->id }})"><i class="la font-weight-bold text-danger la-trash" style="font-size: 24px;"></i></a>
                    </div>
                    @endforeach
                @endif

                <div class="form-group mt-4 float-right">
                    <button type="button" wire:click='storeQuizz' class="btn btn-success text-white">Enregistrer</button>
                    <button type="button" wire:click='finished' class="btn btn-primary text-white">Terminer</button>
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
                            </div>

                            <div id="collapseTwo{{ $key }}" class="collapse {{ $count_quizzes - 1 === $key ? 'show' : '' }}" aria-labelledby="headingTwo{{ $key }}" data-parent="#accordion2">
                                <div class="card-body">
                                    @if ($quizz->questions)
                                        <ul>
                                            @foreach ($quizz->questions as $question)
                                                <li>{{ $question->question ?? '' }}</li>
                                            @endforeach
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
