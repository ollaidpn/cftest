@extends('layouts.front')
@section('content')
<!-- Inner Page Breadcrumb -->
<section class="inner_page_breadcrumb" style="background-image: url('{{ getInfoSystem() ? getInfoSystem()->getImgHeader() : '' }}') !important; background-size: cover;">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3 text-center">
                <div class="breadcrumb_content">
                    <h4 class="breadcrumb_title">Résultat de la rechercher</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Recherche</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Courses List 2 -->
<section class="courses-list2 pb40">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8 col-xl-9">
                <div class="row courses_container style2">
                @if (count($formations->where('type', "public")) > 0)
                    @foreach ($formations->where('type', "public") as $formation)
                    <div class="col-md-4 col-lg-4 col-xl-4">
                        @include('includes.front.formation', ['formation' => $formation])
                    </div>
                    @endforeach
                 @else
                    <div class="col-12 text-center">
                        <h3>Aucun Résultat</h3>
                    </div>
                 @endif
                </div>
                <div class="row">
                    <div class="col-lg-12 mt50 d-flex justify-content-center">
                        {{ $formations->links() }}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xl-3">
                <div class="selected_filter_widget style3 mb30">
                      <div id="accordion" class="panel-group">
                        <div class="panel">
                              <div class="panel-heading">
                                  <h4 class="panel-title">
                                    <a href="#panelBodySoftware" class="accordion-toggle link fz20 mb15" data-toggle="collapse" data-parent="#accordion">Catégorie de formations</a>
                                </h4>
                              </div>
                            <div id="panelBodySoftware" class="panel-collapse collapse show">
                                <div class="panel-body">
                                    <div class="ui_kit_checkbox">
                                        @foreach ($Categorie as $cat)
                                            <div class="custom-control custom-checkbox">
                                                <a href="{{route('category.show', $cat->slug)}}">
                                                    {{$cat->nom}}
                                                </a>
                                            </div>
                                        @endforeach




                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="selected_filter_widget style3 mb30">
                      <div id="accordion" class="panel-group">
                        <div class="panel">
                              <div class="panel-heading">
                                  <h4 class="panel-title">
                                    <a href="#panelBodyPrice" class="accordion-toggle link fz20 mb15" data-toggle="collapse" data-parent="#accordion">Type</a>
                                </h4>
                              </div>
                            <div id="panelBodyPrice" class="panel-collapse collapse show">
                                <div class="panel-body">
                                    <div class="ui_kit_whitchbox">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                            <label class="custom-control-label" for="customSwitch1">Payants </label>
                                        </div>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch2">
                                            <label class="custom-control-label" for="customSwitch2">Gratuits</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}


        </div>
    </div>
</section>

@endsection
