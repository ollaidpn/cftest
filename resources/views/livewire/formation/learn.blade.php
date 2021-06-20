@push('styles')
<link href="{{asset('assets/admin-formateurs/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">

    <style>
        .custom-checkbox .custom-control-input:checked~.custom-control-label::before{
            background-color:#6C2B69;
        }
    </style>

@endpush
<div class="col-12">
    <div class="shortcode_widget_tab">
        <div class="">
            <h4 class="card-header__title">{{ $formation->title ?? '' }} <small>| Catégorie:</small>
                @foreach ($categories->where('category_parent', null) as $category)
                    <small class="list-inline-item"><a href=""  style="color: rebeccapurple !important"><strong>{{ $category->title ?? '' }}</strong></a></small>
                @endforeach
         </h4>

            <div class="progress mb-3">
                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{ $progress ?? 0 }}%" aria-valuenow="{{ $progress ?? 0 }}" aria-valuemin="0" aria-valuemax="100">{{ $progress ?? 0 }}%</div>
            </div>
        </div>
        <div class="ui_kit_tab mt0">
            <div class="row">
                <div class="col-md-8 col-lg-8 mb-3">
                    <div class="">
                        @if ($actual_content_type === 'video')
                            <div class="embed-responsive embed-responsive-16by9 d-flex fade show" style="background-color:black; align-items:center; justify-content:center;" id="vimeo-container">
                                <div class="spinner-border text-light" role="status">
                                    <span class="sr-only">Chargement...</span>
                                </div>
                                <iframe id="vimeo" class="embed-responsive-item" src="https://player.vimeo.com/video/{{ $actual_content && $actual_content_type === 'video' ? $actual_content->video : $formation->presentation_video ?? '' }}?title=0&amp;byline=0&amp;portrait=0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                            </div>
                        @elseif($actual_content_type === 'quiz')
                            <div class="fade show">
                                <div class="card border pb-3 pr-3">
                                    @if (count($actual_content->questions) !== 0)
                                        @foreach ($actual_content->questions as $key => $question)
                                            <div class="question">
                                                <div class="pt-3 pl-3">
                                                    <div class="media align-items-center">
                                                        <div class="media-left">
                                                            <h4 class="m-0 text-primary mr-2"><strong style="color: #6C2B69">#{{ ++$key }}</strong></h4>
                                                        </div>
                                                        <div class="media-body">
                                                            <h4 class="card-title m-0">
                                                                {{ $question->question ?? '' }}
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body pb-0">
                                                    <div class="row">
                                                        @if (count($question->answers) !== 0)
                                                            @foreach ($question->answers as $answer)
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input id="customCheck{{ $answer->id ?? '' }}" wire:model='answers.{{ $question->id ?? '' }}' value="{{ $answer->answer ?? '' }}" type="checkbox" class="custom-control-input">
                                                                            <label for="customCheck{{ $answer->id ?? '' }}" class="custom-control-label">
                                                                                {{ $answer->answer ?? '' }}
                                                                                @if (in_array($question->id, $question_errors) && $is_quiz_submitted)

                                                                                    @if ($answer->is_valid)
                                                                                        <span class="text-success font-weight-bold" style="font-size: 19px;">&#10003;</span>
                                                                                    @else
                                                                                        <span class="text-danger font-weight-bold" style="font-size: 15px;">&#10060;</span>
                                                                                    @endif

                                                                                @elseif (!in_array($question->id, $question_errors) && $is_quiz_submitted && $answer->is_valid)
                                                                                    <span class="text-success font-weight-bold" style="font-size: 19px;">&#10003;</span>
                                                                                @endif
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            Aucune réponse pour cette question !
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="mt-2">
                                        @endforeach

                                    @else
                                        <div>Aucune question</div>
                                    @endif


                                    <div class="pl-3">
                                        @include('includes.messages')
                                        @if ( $suspended_quiz && $suspended_quiz[$actual_content->id] && $suspended_quiz[$actual_content->id] > date('Y-m-d H:i:s') )
                                            <div class="alert alert-danger" role="alert">
                                                <?php setlocale(LC_TIME, "fr_FR"); ?>
                                                Vous n’avez pas atteint le score minimum requis. Vous pouvez réessayer à partir du {{ strftime("%e %B %Y à %X", strtotime($suspended_quiz[$actual_content->id]))}}
                                            </div>
                                        @else
                                             <button type="button" wire:click='validateQuiz' class="btn btn-success float-right">Valider <span class="text-white font-weight-bold" style="font-size: 19px;">&#10003;</span> </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if($actual_content_type === 'video')
                        <div class="card mt-3 p-3 border">
                            <h3>{{ $actual_content ? $actual_content->title :  "Vidéo présentation ".$formation->title}}</h3>
                        </div>
                    @endif
                    <div class="card border p-2 mt-3 mb-2 d-block d-sm-block d-md-none">
                        <div id="accordion" class="mt-2">
                            @if ($formation)
                                @if (count($formation->modules) !== 0)

                                    @foreach ($formation->modules as $key => $module)
                                        <div class="card">
                                            <div class="card-header pt-2" id="heading{{ $key }}" style="background-color:#6C2B69;">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapse{{ $key }}"
                                                            aria-expanded="{{ $actual_content && $actual_content_type === 'video' && ($actual_content->module->title === $module->title) ||
                                                                                $actual_content && $actual_content_type === 'quiz' && ($actual_content->title === ($module->quiz ? $module->quiz->title : '')) ?
                                                                                'show' : '' }}"  aria-controls="collapse{{ $key }}">
                                                    {{ $module->title ?? 'Module' }}
                                                    </button>
                                                </h5>
                                            </div>

                                            <div id="collapse{{ $key }}" class="collapse {{ $actual_content && $actual_content_type === 'video' && ($actual_content->module->title === $module->title) ||
                                                                                                $actual_content && $actual_content_type === 'quiz' && ($actual_content->title === ($module->quiz ? $module->quiz->title : '')) ?
                                                                                                'show' : '' }}"
                                                                                                aria-labelledby="heading{{ $key }}" data-parent="#accordion">
                                                <div class="card-body">
                                                    @if ($module->sections)
                                                        <ul>
                                                            @foreach ($module->sections as $section)

                                                                <a class="d-flex justify-content-between" href="javascript:;" @if ($key > 0 && $formation->modules[$key - 1]->quiz && in_array(["quiz" => $formation->modules[$key - 1]->quiz->id], $ended_contents ?? []) || $key === 0) wire:click='selectSection({{ $section }})' @endif>
                                                                    <li>{{ $section->title ?? '' }}</li>
                                                                    <h1>test</h1>


                                                                    @if (in_array(["video" => $section->id], $ended_contents ?? []))
                                                                        <span class="text-success font-weight-bold" style="font-size: 19px;">&#10003;</span>
                                                                    @elseif($key > 0 && !in_array(["video" => $section->id], $ended_contents ?? []) && $formation->modules[$key - 1]->quiz && !in_array(["quiz" => $formation->modules[$key - 1]->quiz->id], $ended_contents ?? []))
                                                                        <span class="text-success font-weight-bold" style="font-size: 19px;">&#128274;</span>

                                                                    @elseif($key > 0 && !in_array(["video" => $section->id], $ended_contents ?? []) && $formation->modules[$key - 1]->quiz && !in_array(["quiz" => $formation->modules[$key - 1]->quiz->id], $ended_contents ?? []))
                                                                    <span class="text-success font-weight-bold" style="font-size: 19px;">&#128274;</span>
                                                                    @endif
                                                                </a>
                                                                <hr>
                                                            @endforeach
                                                            @if ($module->quiz)

                                                                <a class="d-flex justify-content-between" href="javascript:;" @if ($key > 0 && $formation->modules[$key - 1]->quiz && in_array(["quiz" => $formation->modules[$key - 1]->quiz->id], $ended_contents ?? []) || $key === 0)  wire:click='selectQuiz({{ $module->quiz->id }})' @endif>
                                                                    <li><strong class="text-dark">Quiz: {{ $module->quiz->title ?? '' }}</strong></li>
                                                                    @if (in_array(["quiz" => $module->quiz->id], $ended_contents ?? []))
                                                                        <span class="text-success font-weight-bold" style="font-size: 19px;">&#10003;</span>
                                                                    @elseif($key > 0 && !in_array(["quiz" => $formation->modules[$key - 1]->quiz->id], $ended_contents ?? []))
                                                                        <span class="text-success font-weight-bold" style="font-size: 19px;">&#128274;</span>
                                                                    @endif
                                                                </a>
                                                                <hr>
                                                            @endif
                                                        </ul>
                                                    @else
                                                        Aucune section
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="d-flex justify-content-center font-weight-bold">Aucun contenu !</div>
                                @endif

                            @else
                                <div>
                                    Aucun module
                                </div>
                            @endif
                        </div>
                        @if (count($formation->modules) !== 0)

                            @if ($is_started)
                                <button type="button" wire:click='goToNextVideo' class="btn btn-block btn-success rounded mt-5 align-right">Suivant</button>
                            @else
                                <button type="button" wire:click='beginFormation' class="btn btn-block btn-success rounded mt-5 align-right">Commencer</button>
                            @endif

                        @endif
                    </div>
                    <div class="card mt-4 p-3 border">
                        <div class="cs_overview">
                            <h4 class="title">A propos</h4>
                            <h4 class="subtitle">Description de la formation</h4>
                            <p class="mb30">
                                {{ $formation->presentation_text ?? '' }}
                            </p>
                            <h4 class="subtitle">Objectifs de la formation</h4>
                            <ul class="row mb-4">
                                @if (count($formation->goals) > 0)
                                    @foreach ($formation->goals as $goal)
                                        <li class="col-md-6 mb-3"><i class="fa fa-check"></i> {{ $goal->title ?? '' }}</li>
                                    @endforeach
                                @else
                                    <div class="d-flex justify-content-center">
                                        Aucun contenu
                                    </div>
                                @endif
                            </ul>
                            {{-- <h4 class="subtitle">Compétences visées</h4>
                            <ul class="row mb-4">
                                @if (count($formation->targetedSkills) > 0)
                                    @foreach ($formation->targetedSkills as $targetedSkill)
                                        <li class="col-md-6 mb-3"><i class="fa fa-check"></i> {{ $targetedSkill->title ?? '' }}</li>
                                    @endforeach
                                @else
                                    <div class="d-flex justify-content-center">
                                        Aucun contenu
                                    </div>
                                @endif
                            </ul> --}}
                            <h4 class="subtitle">Prérequis</h4>
                            <ul class="list_requiremetn row">
                                @if (count($formation->requirements) > 0)
                                    @foreach ($formation->requirements as $requirement)
                                        <li class="col-md-6 mb-3"><i class="fa fa-circle mr-2"></i> {{ $requirement->title ?? '' }}</li>
                                    @endforeach
                                @else
                                    <div class="d-flex justify-content-center">
                                        Aucun prérequis
                                    </div>
                                @endif
                            </ul>
                            <h4 class="subtitle">Informations Pratiques</h4>
                            <ul class="list_requiremetn row">
                                @if ($formation->practical_informations)
                                    {{ $formation->practical_informations }}
                                @else
                                    <div class="d-flex justify-content-center">
                                        Aucun contenu
                                    </div>
                                @endif
                            </ul>
                        </div>



                        {{-- <div class="col-md-12">
                            <div class=" col-md-12 text-muted mb-3 d-flex align-items-center" href="#">
                                <img class="rounded-circle" alt="image" width="50" src="{{asset('assets/admin-formateurs/images/avatar/3.jpg')}}">
                                <div class="col" style="padding: 2em; background-color; grey">
                                    <h5 class="mb-1">Dr sultads Send you Photo fffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff</h5>
                                    <p > 1. Se familiariser avec la notion de conflits d'intérêts au sein de la Banque ;
                                        2. Mieux appréhender les enjeux liés à la gestion des conflits d'intérêts au sein de la Banque ;
                                        3. Mieux connaitre le dispositif de prévention des conflits d'intérêts au sein de la Banque ;
                                        4. Mieux connaitre le dispositif de traitement des conflits d'intérêts au sein de la Banque.</p>
                                    <small class="d-block">29 July 2020 - 02:26 PM</small>
                                </div>
                            </div>

                            <div class=" text-muted mb-3 d-flex align-items-center float-right" href="#">
                                <div class="col" style="padding: 2em; background-color; grey">
                                    <h5 class="mb-1 float-right">Moi</h5><br>
                                    <p style="text-align: right"> 1. Se familiariser avec la notion de conflits d'intérêts au sein de la Banque ;
                                        2. Mieux appréhender les enjeux liés à la gestion des conflits d'intérêts au sein de la Banque ;
                                        3. Mieux connaitre le dispositif de prévention des conflits d'intérêts au sein de la Banque ;
                                        4. Mieux connaitre le dispositif de traitement des conflits d'intérêts au sein de la Banque.</p>
                                    <small class="d-block  float-right">29 July 2020 - 02:26 PM</small>
                                </div>
                                <img class="rounded-circle" alt="image" width="50" src="{{asset('assets/admin-formateurs/images/avatar/3.jpg')}}">

                            </div>

                            <form method="post" action="#" enctype="multipart/form-data">

                                <div class="form-group">
                                    <textarea id="email-compose-editor" class="textarea_editor form-control bg-transparent" rows="5" placeholder="Tapez ici pour envoyer un message ..."></textarea>
                                </div>
                                <div class="fallback w-100 float-right">
                                    <input class="float-right" type="file" class="dropify" data-default-file="" />
                                </div>
                                <button class="btn btn-primary btn-sl-sm mt-3 float-right" type="button"><span
                                    class="mr-2"><i class="fa fa-paper-plane"></i></span> Envoyer</button>
                            </form>



                        </div> --}}
                    </div>













                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="shortcode_widget_tab card border p-2 d-none d-sm-none d-md-block">
                        <div id="accordion-module" class="mt-2">
                            @if ($formation)
                                @if (count($formation->modules) !== 0)
                                    @foreach ($formation->modules as $key => $module)
                                        <div class="card">
                                            <div class="card-header pt-2" id="headingOne{{ $key }}" style="background-color:#6C2B69;">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseOne{{ $key }}"
                                                            aria-expanded="{{ $actual_content && $actual_content_type === 'video' && ($actual_content->module->title === $module->title) ||
                                                                                $actual_content && $actual_content_type === 'quiz' && ($actual_content->title === ($module->quiz ? $module->quiz->title : '')) ?
                                                                                'show' : '' }}"  aria-controls="collapseOne{{ $key }}">
                                                    {{ $module->title ?? 'Module' }}
                                                    </button>
                                                </h5>
                                            </div>

                                            <div id="collapseOne{{ $key }}" class="collapse {{ $actual_content && $actual_content_type === 'video' && ($actual_content->module->title === $module->title) ||
                                                                                                $actual_content && $actual_content_type === 'quiz' && ($actual_content->title === ($module->quiz ? $module->quiz->title : '')) ?
                                                                                                'show' : '' }}"
                                                                                                aria-labelledby="headingOne{{ $key }}" data-parent="#accordion-module">
                                                <div class="card-body">
                                                    @if ($module->sections)
                                                        <ul>

                                                            @foreach ($module->sections as $section)
                                                                <a class="d-flex justify-content-between" href="javascript:;" @if ($key > 0 && $formation->modules[$key - 1]->quiz && in_array(["quiz" => $formation->modules[$key - 1]->quiz->id], $ended_contents ?? []) || $key === 0) wire:click='selectSection({{ $section }})' @endif>
                                                                    <li>{{ $section->title ?? '' }} </li>

                                                                    @if (in_array(["video" => $section->id], $ended_contents ?? []))
                                                                        <span class="text-success font-weight-bold" style="font-size: 19px;">&#10003;</span>
                                                                    @elseif($key > 0 && !in_array(["video" => $section->id], $ended_contents ?? []) && $formation->modules[$key - 1]->quiz && !in_array(["quiz" => $formation->modules[$key - 1]->quiz->id], $ended_contents ?? []))
                                                                        <span class="text-success font-weight-bold" style="font-size: 19px;">&#128274;</span>
                                                                    @endif
                                                                </a>

                                                                @if ($section->reference)
                                                                    <?php
                                                                    $ref = json_decode($section->reference);
                                                                    $a = $ref[0];
                                                                    $url = URL::to('/');
                                                                    $r1 = $url."/".$ref[0]

                                                                    ?>
                                                                    @foreach (json_decode($section->reference) as $key => $value)
                                                                        <a href="{{asset('storage/'.$ref[$key])}} " download><i class="fa fa-file mr-2"></i>  Pièces jointe N°{{$key+1}} <i class="fa fa-download mr-2"></i>  </a> <br>
                                                                    @endforeach
                                                                @endif





                                                                <hr>
                                                            @endforeach
                                                            @if ($module->quiz)

                                                                <a class="d-flex justify-content-between" href="javascript:;" @if ($key > 0 && $formation->modules[$key - 1]->quiz && in_array(["quiz" => $formation->modules[$key - 1]->quiz->id], $ended_contents ?? []) || $key === 0)  wire:click='selectQuiz({{ $module->quiz->id }})' @endif>
                                                                    <li><strong class="text-dark">Quiz: {{ $module->quiz->title ?? '' }}</strong></li>
                                                                    @if (in_array(["quiz" => $module->quiz->id], $ended_contents ?? []))
                                                                        <span class="text-success font-weight-bold" style="font-size: 19px;">&#10003;</span>
                                                                    @elseif($key > 0 && !in_array(["quiz" => $formation->modules[$key - 1]->quiz->id], $ended_contents ?? []))
                                                                        <span class="text-success font-weight-bold" style="font-size: 19px;">&#128274;</span>
                                                                    @endif
                                                                </a>
                                                                <hr>
                                                            @endif
                                                        </ul>
                                                    @else
                                                        Aucune section
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="d-flex justify-content-center font-weight-bold">Aucun contenu !</div>
                                @endif

                            @else
                                <div>
                                    Aucun module
                                </div>
                            @endif
                        </div>
                        @if (count($formation->modules) !== 0)

                            @if ($is_started)
                                <button type="button" wire:click='goToNextVideo' class="btn btn-block btn-success rounded mt-5 align-right">Suivant</button>
                            @else
                                <button type="button" wire:click='beginFormation' class="btn btn-block btn-success rounded mt-5 align-right">Commencer</button>
                            @endif

                        @endif
                    </div>
                    <div class="feature_course_widget csv1">
                        <ul class="list-group">
                            <h4 class="title">Caractéristiques de la formation</h4>
                            <li class="d-flex justify-content-between align-items-center">
                                @if ($count_videos)
                                    Vidéos <span class="float-right">{{ $count_videos ?? '' }}</span>
                                @endif
                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                                @if ($count_quizz)
                                    Quizzs <span class="float-right">{{ $count_quizz ?? '' }}</span>
                                @endif

                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                                Durée <span class="float-right">{{ $formation->nb_hours ?? '0' }} heures</span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                                Langue<span class="float-right">Français</span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                            Évaluations <span class="float-right">{{ $count_quizz ? 'Oui' : 'Non' }}</span>
                            </li>
                        </ul>
                    </div>
                    {{-- @if (count($categories) !== 0) --}}

















                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')

    <script src="https://player.vimeo.com/api/player.js')}}"></script>
    <script>
        $(function () {


            // document.addEventListener('livewire:load', function () {
//  alert("testv")
                window.scrollTo({ bottom: 0, behavior: "smooth" });

                var iframe = document.querySelector('iframe');
                var player = new Vimeo.Player(iframe);
                player.on('ended', function(data) {

                    @this.markContentAsFinished()
                });

                @this.on('refresh', function () {

                    $('#vimeo').remove();
                    $('#vimeo-container').append("<iframe class='embed-responsive-item' src='https://player.vimeo.com/video/{{ $actual_content && $actual_content_type === 'video' ? $actual_content->video : $formation->presentation_video ?? '' }}?title=0&amp;byline=0&amp;portrait=0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>")
                    iframe = document.querySelector('iframe');
                    player = new Vimeo.Player(iframe);

                    player.on('ended', function(data) {
                        @this.markContentAsFinished()
                    });

                });

                @this.on('scrollTop', function () {
                    // alert('test');
                    window.scrollTo({ top: 0, behavior: "smooth" });
                });

            // });
        });

    </script>

@endpush
