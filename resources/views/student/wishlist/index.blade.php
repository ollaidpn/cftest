@extends('layouts.student')

@section('content')

<div class="col-lg-12">
    <nav class="breadcrumb_widgets" aria-label="breadcrumb mb30" style="background-color: #6C2B69;">
        <h4 class="title float-left" style="color: white;">Liste de Souhaits</h4>
        <ol class="breadcrumb float-right">
            <li class="breadcrumb-item"><a href="#" style="color: white;">Espace Client</a></li>
            <li class="breadcrumb-item active" aria-current="page" style="color: whitesmoke;">Liste d'envie</li>
        </ol>
    </nav>
</div>
<div class="col-lg-12">
    <div class="my_course_content_container">
        <div class="my_course_content mb30">
            <div class="my_course_content_header">
                <div class="col-xl-4">
                    <div class="instructor_search_result style2">
                        <h4 class="mt10">Formations marqués</h4>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="candidate_revew_select style2 text-right">
                        <ul class="mb0">
                            <li class="list-inline-item">
                                <select class="selectpicker show-tick">
                                    <option>Nouveaux</option>
                                    <option>Récents</option>
                                    <option>Anciens</option>
                                </select>
                            </li>
                            <li class="list-inline-item">
                                <div class="candidate_revew_search_box course fn-520">
                                    <form class="form-inline my-2 my-lg-0">
                                        <input class="form-control mr-sm-2" type="search" placeholder="Tapez ici pour faire un recherche" aria-label="Search">
                                        <button class="btn my-2 my-sm-0" type="submit"><span class="flaticon-magnifying-glass"></span></button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="my_course_content_list">
                <div class="mc_content_list">
                    <div class="thumb">
                        <img class="img-whp" src="images/courses/t2.jpg" alt="t2.jpg">
                        <div class="overlay"></div>
                    </div>
                    <div class="details">
                        <div class="mc_content">
                            <p class="subtitle">par <span><strong>Carapaces</strong></span></p>
                            <h5 class="title" style="font-size: 1.7em;">Devenez Investisseur Immobilier
                            </h5>
                            <p>A travers des dizaines de vidéos ludiques, je vous accompagne pas à pas vers votre objectif final. Je vous montre comment rechercher et trouver votre bien, le négocier , l'acheter, le louer et le rentabiliser. Toutes les vidéos sont relativement courtes et optimisées pour une bonne compréhension. </p>
                        </div>
                        <div class="mc_footer">
                            <ul class="mc_meta fn-414">
                                <li class="list-inline-item"><a href="#"><i class="flaticon-profile"></i></a></li>
                                <li class="list-inline-item"><a href="#">148</a></li>
                                <li class="list-inline-item"><a href="#"><i class="flaticon-comment"></i></a></li>
                                <li class="list-inline-item"><a href="#">25</a></li>
                                <li class="list-inline-item"><a href="#">publié le: <strong>12.12/2020</strong></a></li>
                            </ul>
                            <ul class="mc_review fn-414">
                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                <li class="list-inline-item"><a href="#">(5)</a></li>
                                <li class="list-inline-item tc_price fn-414"><a href="#">19.000 Fcfa</a></li>
                            </ul>
                            <ul class="view_edit_delete_list float-right">
                                <li class="list-inline-item"><a href="#" data-toggle="tooltip" data-placement="top" title="Voir"><span class="flaticon-preview"></span></a></li>
                                <li class="list-inline-item"><a href="#" data-toggle="tooltip" data-placement="top" title="Supprimer"><span class="flaticon-delete-button"></span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="mc_content_list">
                    <div class="thumb">
                        <img class="img-whp" src="images/courses/t2.jpg" alt="t2.jpg">
                        <div class="overlay"></div>
                    </div>
                    <div class="details">
                        <div class="mc_content">
                            <p class="subtitle">par <span><strong>Carapaces</strong></span></p>
                            <h5 class="title" style="font-size: 1.7em;">Devenez Investisseur Immobilier
                            </h5>
                            <p>A travers des dizaines de vidéos ludiques, je vous accompagne pas à pas vers votre objectif final. Je vous montre comment rechercher et trouver votre bien, le négocier , l'acheter, le louer et le rentabiliser. Toutes les vidéos sont relativement courtes et optimisées pour une bonne compréhension. </p>
                        </div>
                        <div class="mc_footer">
                            <ul class="mc_meta fn-414">
                                <li class="list-inline-item"><a href="#"><i class="flaticon-profile"></i></a></li>
                                <li class="list-inline-item"><a href="#">148</a></li>
                                <li class="list-inline-item"><a href="#"><i class="flaticon-comment"></i></a></li>
                                <li class="list-inline-item"><a href="#">25</a></li>
                                <li class="list-inline-item"><a href="#">publié le: <strong>12.12/2020</strong></a></li>
                            </ul>
                            <ul class="mc_review fn-414">
                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                <li class="list-inline-item"><a href="#">(5)</a></li>
                                <li class="list-inline-item tc_price fn-414"><a href="#">19.000 Fcfa</a></li>
                            </ul>
                            <ul class="view_edit_delete_list float-right">
                                <li class="list-inline-item"><a href="#" data-toggle="tooltip" data-placement="top" title="Voir"><span class="flaticon-preview"></span></a></li>
                                <li class="list-inline-item"><a href="#" data-toggle="tooltip" data-placement="top" title="Supprimer"><span class="flaticon-delete-button"></span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="mc_content_list">
                    <div class="thumb">
                        <img class="img-whp" src="images/courses/t2.jpg" alt="t2.jpg">
                        <div class="overlay"></div>
                    </div>
                    <div class="details">
                        <div class="mc_content">
                            <p class="subtitle">par <span><strong>Carapaces</strong></span></p>
                            <h5 class="title" style="font-size: 1.7em;">Devenez Investisseur Immobilier
                            </h5>
                            <p>A travers des dizaines de vidéos ludiques, je vous accompagne pas à pas vers votre objectif final. Je vous montre comment rechercher et trouver votre bien, le négocier , l'acheter, le louer et le rentabiliser. Toutes les vidéos sont relativement courtes et optimisées pour une bonne compréhension. </p>
                        </div>
                        <div class="mc_footer">
                            <ul class="mc_meta fn-414">
                                <li class="list-inline-item"><a href="#"><i class="flaticon-profile"></i></a></li>
                                <li class="list-inline-item"><a href="#">148</a></li>
                                <li class="list-inline-item"><a href="#"><i class="flaticon-comment"></i></a></li>
                                <li class="list-inline-item"><a href="#">25</a></li>
                                <li class="list-inline-item"><a href="#">publié le: <strong>12.12/2020</strong></a></li>
                            </ul>
                            <ul class="mc_review fn-414">
                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                <li class="list-inline-item"><a href="#">(5)</a></li>
                                <li class="list-inline-item tc_price fn-414"><a href="#">19.000 Fcfa</a></li>
                            </ul>
                            <ul class="view_edit_delete_list float-right">
                                <li class="list-inline-item"><a href="#" data-toggle="tooltip" data-placement="top" title="Voir"><span class="flaticon-preview"></span></a></li>
                                <li class="list-inline-item"><a href="#" data-toggle="tooltip" data-placement="top" title="Supprimer"><span class="flaticon-delete-button"></span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="mc_content_list">
                    <div class="thumb">
                        <img class="img-whp" src="images/courses/t2.jpg" alt="t2.jpg">
                        <div class="overlay"></div>
                    </div>
                    <div class="details">
                        <div class="mc_content">
                            <p class="subtitle">par <span><strong>Carapaces</strong></span></p>
                            <h5 class="title" style="font-size: 1.7em;">Devenez Investisseur Immobilier
                            </h5>
                            <p>A travers des dizaines de vidéos ludiques, je vous accompagne pas à pas vers votre objectif final. Je vous montre comment rechercher et trouver votre bien, le négocier , l'acheter, le louer et le rentabiliser. Toutes les vidéos sont relativement courtes et optimisées pour une bonne compréhension. </p>
                        </div>
                        <div class="mc_footer">
                            <ul class="mc_meta fn-414">
                                <li class="list-inline-item"><a href="#"><i class="flaticon-profile"></i></a></li>
                                <li class="list-inline-item"><a href="#">148</a></li>
                                <li class="list-inline-item"><a href="#"><i class="flaticon-comment"></i></a></li>
                                <li class="list-inline-item"><a href="#">25</a></li>
                                <li class="list-inline-item"><a href="#">publié le: <strong>12.12/2020</strong></a></li>
                            </ul>
                            <ul class="mc_review fn-414">
                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                <li class="list-inline-item"><a href="#">(5)</a></li>
                                <li class="list-inline-item tc_price fn-414"><a href="#">19.000 Fcfa</a></li>
                            </ul>
                            <ul class="view_edit_delete_list float-right">
                                <li class="list-inline-item"><a href="#" data-toggle="tooltip" data-placement="top" title="Voir"><span class="flaticon-preview"></span></a></li>
                                <li class="list-inline-item"><a href="#" data-toggle="tooltip" data-placement="top" title="Supprimer"><span class="flaticon-delete-button"></span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
