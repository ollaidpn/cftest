@extends('layouts.front')

@section('content')
<!-- Inner Page Breadcrumb -->
<section class="inner_page_breadcrumb csv2" style="background-image: url('{{ getInfoSystem() ? getInfoSystem()->getImgHeader() : '' }}') !important; background-size: cover;">
    <div class="container">
        <div class="row">
            <div class="col-xl-9">
                <div class="breadcrumb_content">
                    <div class="cs_row_one csv2">
                        <div class="cs_ins_container">
                            <div class="cs_instructor">
                                <ul class="cs_instrct_list float-left mb0">
                                    <li class="list-inline-item"><img class="thumb rounded-circle" src="{{ $formation->teacher() ? $formation->teacher()->image() : '' }}" alt="avatar"></li>
                                    <li class="list-inline-item"><a class="color-white" href="#">{{ $formation->teacher() ? $formation->teacher()->getFullName() : '' }}</a></li>
                                    <li class="list-inline-item"><a class="color-white" href="#">En ligne depuis: {{ $formation->getFormatedCreatedAt() ?? '' }}</a></li>
                                </ul>
                                <ul class="cs_watch_list float-right mb0">
                                    <li class="list-inline-item"><a class="color-white" href="#"><span class="flaticon-like"></span></a></li>
                                    <li class="list-inline-item"><a class="color-white" href="#">Liste d'envie</a></li>
                                    <li class="list-inline-item"><a class="color-white" href="#"><span class="flaticon-share"> Partager</span></a></li>
                                </ul>
                            </div>
                            <h3 class="cs_title color-white">{{ $formation->title ?? '' }}</h3>
                            <h3 class="cs_title color-white">{{ $formation->id ?? '' }}</h3>

                            <ul class="cs_review_seller">
                                @if ($formation->categories)
                                    @foreach ($formation->categories as $category)
                                        <li class="list-inline-item"><a class="color-white" href="{{route('category.show',$category->slug)}}"><span>{{ $category->title ?? '' }}</span></a></li>
                                    @endforeach
                                @endif
                            </ul>
                            @if ($formation->show_stats == '1')
                                <ul class="cs_review_enroll">
                                    <li class="list-inline-item"><a class="color-white" href="#"><span class="flaticon-profile"></span> {{ count($formation->students) }} apprenants</a></li>
                                </ul>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Team Members -->
<section class="course-single2 pb40">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8 col-xl-9">
                <div class="row">
                    <div class="col-lg-12">
                        @include('includes.messages')

                        <div class="courses_single_container">
                            <div class="cs_row_one">
                                <div class="cs_ins_container">
                                    <div class="courses_big_thumb">
                                        <div class="thumb">
                                            <iframe class="iframe_video" src="https://player.vimeo.com/video/{{ $formation->presentation_video ?? '' }}?title=0&amp;byline=0&amp;portrait=0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cs_rwo_tabs csv2">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" >
                                        <a class="nav-link active" id="Overview-tab" data-toggle="tab" href="#Overview" role="tab" aria-controls="Overview" aria-selected="true" >A propos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="course-tab" data-toggle="tab" href="#course" role="tab" aria-controls="course" aria-selected="false">Contenu</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="instructor-tab" data-toggle="tab" href="#instructor" role="tab" aria-controls="instructor" aria-selected="false">Le Formateur</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="Overview" role="tabpanel" aria-labelledby="Overview-tab">
                                        <div class="cs_row_two csv2">
                                            <div class="cs_overview">
                                                <h4 class="title">A propos</h4>
                                                <h4 class="subtitle">Description de la formations</h4>
                                                <p class="mb30">
                                                    {{ $formation->presentation_text ?? '' }}
                                                </p>
                                                <h4 class="subtitle">Objectifs de la formations</h4>
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
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="course" role="tabpanel" aria-labelledby="review-tab">
                                        <div class="cs_row_three csv2">
                                            <div class="course_content">
                                                <div class="cc_headers">
                                                    <h4 class="title">Contenu</h4>
                                                </div>
                                                <br>
                                                @if (count($formation->modules) > 0)
                                                    @foreach ($formation->modules as $key => $module)
                                                        <div class="details">
                                                            <div id="accordion-{{ $key }}" class="panel-group cc_tab">
                                                                <div class="panel">
                                                                    <div class="panel-heading">
                                                                        <h4 class="panel-title">
                                                                            <a href="#panelBodyCourseStart-{{ $key }}" class="accordion-toggle link" data-toggle="collapse" data-parent="#accordion-{{ $key }}">Module {{ $key+1 }}: {{ $module->title ?? '' }}</a>
                                                                        </h4>
                                                                    </div>
                                                                    <div id="panelBodyCourseStart-{{ $key }}" class="panel-collapse collapse">
                                                                        <div class="panel-body">
                                                                            <ul class="cs_list mb0">
                                                                                @if (count($module->sections) !== 0)
                                                                                    @foreach ($module->sections as $key => $section)
                                                                                        <li><span class="flaticon-play-button-1 icon"></span> {{ $section->title ?? '' }} </li>
                                                                                    @endforeach
                                                                                @else
                                                                                    <div class="d-flex justify-content-center">
                                                                                        Aucune section
                                                                                    </div>
                                                                                @endif
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="d-flex justify-content-center">
                                                        Aucun contenu
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="instructor" role="tabpanel" aria-labelledby="review-tab">
                                        <div class="cs_row_four csv2">
                                            <div class="about_ins_container">
                                                <h4 class="aii_title">Le Formateur</h4>
                                                <div class="about_ins_info">
                                                    <div class="thumb rounded-circle"><img src="{{ $formation->teacher() ? $formation->teacher()->image() : '' }}" width="100" alt="avatar"></div>
                                                </div>
                                                <div class="details">
                                                    <ul class="about_info_list">
                                                        <li class="list-inline-item"><span class="flaticon-play-button-1"></span>{{ $formation->teacher() ? count($formation->teacher()->formations) : '' }} Formations </li>
                                                    </ul>
                                                    <h4>{{ $formation->teacher() ? $formation->teacher()->getFullName() : '' }}</h4>
                                                    <p class="subtitle">{{ $formation->teacher() ? $formation->teacher()->email : '' }}</p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                                        <div class="cs_row_five csv2">
                                            <div class="student_feedback_container">
                                                <h4 class="aii_title">Avis & retours</h4>
                                                <div class="s_feeback_content">
                                                    <ul class="skills">
                                                        <li class="list-inline-item">Etoiles 5</li>
                                                        <li class="list-inline-item progressbar1" data-width="84" data-target="100">%84</li>
                                                    </ul>
                                                    <ul class="skills">
                                                        <li class="list-inline-item">Etoiles 4</li>
                                                        <li class="list-inline-item progressbar2" data-width="9" data-target="100">%9</li>
                                                    </ul>
                                                    <ul class="skills">
                                                        <li class="list-inline-item">Etoiles 3</li>
                                                        <li class="list-inline-item progressbar3" data-width="3" data-target="100">%3</li>
                                                    </ul>
                                                    <ul class="skills">
                                                        <li class="list-inline-item">Etoiles 2</li>
                                                        <li class="list-inline-item progressbar4" data-width="1" data-target="100">%1</li>
                                                    </ul>
                                                    <ul class="skills">
                                                        <li class="list-inline-item">Etoiles 1</li>
                                                        <li class="list-inline-item progressbar5" data-width="2" data-target="100">%2</li>
                                                    </ul>
                                                </div>
                                                <div class="aii_average_review text-center">
                                                    <div class="av_content">
                                                        <h2>4.5</h2>
                                                        <ul class="aii_rive_list mb0">
                                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                        </ul>
                                                        <p>Note du cours</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="cs_row_seven csv2">
                                            <div class="sfeedbacks">
                                                <div class="mbp_comment_form style2 pb0">
                                                    <h4>Votre avis à propos de ce cours</h4>
                                                    <ul>
                                                        <li class="list-inline-item pr15"><p>Votre note sur une échelle de 1 à 5 ?</p></li>
                                                        <li class="list-inline-item">
                                                            <span class="sspd_review">
                                                                <ul>
                                                                    <li class="list-inline-item"><a href="#"><i class="fa fa-star fz18"></i></a></li>
                                                                    <li class="list-inline-item"><a href="#"><i class="fa fa-star fz18"></i></a></li>
                                                                    <li class="list-inline-item"><a href="#"><i class="fa fa-star fz18"></i></a></li>
                                                                    <li class="list-inline-item"><a href="#"><i class="fa fa-star fz18"></i></a></li>
                                                                    <li class="list-inline-item"><a href="#"><i class="fa fa-star fz18"></i></a></li>
                                                                    <li class="list-inline-item"></li>
                                                                </ul>
                                                            </span>
                                                        </li>
                                                    </ul>
                                                    <form class="comments_form">

                                                        <div class="form-group">
                                                            <label for="exampleFormControlTextarea1">Votre avis</label>
                                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="6"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-thm" style="background-color:#6C2B69">Publier <span class="flaticon-right-arrow-1"></span></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="r_course_title">Formations similaires</h3>
                    </div>
                    @if (count($similar_formations) !== 0)
                        @foreach ($similar_formations as $item)
                            <div class="col-lg-6 col-xl-4">
                                @include('includes.front.formation', ['formation' => $item])
                            </div>
                        @endforeach
                    @else
                        Aucune formations similaires
                    @endif

                </div>
            </div>

            <div class="col-lg-4 col-xl-3">
                <div class="instructor_pricing_widget csv2">
                    <div class="price"><span>Prix</span> {{ $formation->price }} FCFA</div>
                    {{--  --}}

                    {{-- @if ($InCart && $InCart->formation_id=== $formation->id)
                    <p class=" text-success text-left"><strong>
                    VCe cours est déjà dans votre panier,<br>
                    <a href="#" class="cart_btnss">Voir mon panier</a></strong></p>

                    @else
                    <form  action="{{route('front.course.addtocart')}}" method="POST">
                        @csrf
                        <input type="text" name="formation_id" value="{{ $formation->id}}" hidden>
                        <input type="text" name="montant" value="{{ $formation->price}}" hidden>
                        <button type="submit" class="cart_btnss">Ajouter au panier</button>
                    </form>
                    @endif --}}



                    @if ($Enrollement && $Enrollement->formation_id == $formation->id)
                    <p class=" text-success text-left"><strong>Vous avez acheter cette formation,<br> Bon apprentissage !</strong></p>
                    <a href="{{ route('student.take-public-courses', $formation->slug ?? '') }}" class="cart_btnss_white">Accéder à la formation</a>
                    @else
                    <form  id="test" action="{{route('front.course.enroll')}}" method="POST">
                        @csrf
                        <input type="text" name="formation_id" value="{{ $formation->id}}" hidden>
                        <a href="javascript:;" class="cart_btnss" onclick="document.getElementById('test').submit();">Acheter</a>
                        <input type="hidden" name="mess" value=<%=n%>
                        {{-- <a type="submit" class="cart_btnss">Acheter</button> --}}
                    </form>
                    @endif

                    {{-- <a href="#" class="cart_btnss_white">Acheter</a> --}}
                    <h5 class="subtitle text-left"><strong>Inclus dans la formation</strong></h5>
                    <ul class="price_quere_list text-left">
                        <li><a href="#"><span class="flaticon-play-button-1"></span> {{ $formation->nb_hours ?? '' }} heure de vidéo au total</a></li>
                        <li><a href="#"><span class="flaticon-download"></span> Ressources téléchargeables</a></li>
                        <li><a href="#"><span class="flaticon-key-1"></span> Disponible partout avec vous</a></li>
                        <li><a href="#"><span class="flaticon-responsive"></span> Disponible sur mobile & web</a></li>
                        <li><a href="#"><span class="flaticon-flash"></span> Tests & examen inclus</a></li>
                        <li><a href="#"><span class="flaticon-award"></span> Attestion de réussite inclus</a></li>
                    </ul>
                </div>
                <div class="feature_course_widget csv1">
                    <ul class="list-group">
                        <h4 class="title">Caractéristiques de la formations</h4>
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
                            Durée <span class="float-right">{{ $nb_hours ?? '0' }} heures</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center">
                            Langue<span class="float-right">Français</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center">
                        Évaluations <span class="float-right">{{ $count_quizz ? 'Oui' : 'Non' }}</span>
                        </li>
                    </ul>
                </div>
                @if (count(getCategories()) !== 0)
                    <div class="blog_tag_widget csv1">
                        <h4 class="title">Catégories</h4>
                        <ul class="tag_list">
                            @foreach (getCategories()->where('category_parent', null) as $category)
                                <li class="list-inline-item"><a href="{{route('category.show',$category->slug)}}">{{ $category->title ?? '' }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
