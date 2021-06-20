@extends('layouts.front')
@section('content')
<!-- Inner Page Breadcrumb -->
<section class="inner_page_breadcrumb" style="background-image: url('{{ getInfoSystem() ? getInfoSystem()->getImgHeader() : '' }}') !important; background-size: cover;">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3 text-center">
                <div class="breadcrumb_content">
                    <h4 class="breadcrumb_title">Formations</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Liste des formations</li>
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
                @if (count($formations) > 0)
                    @foreach ($formations as $formation)
                    <div class="col-md-4 col-lg-4 col-xl-4">
                        @include('includes.front.formation', ['formation' => $formation])
                    </div>
                    @endforeach
                 @else
                    Aucune formation
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
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck14">
                                            <label class="custom-control-label" for="customCheck14">Le droit public<span class="float-right">(03)</span></label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck15">
                                            <label class="custom-control-label" for="customCheck15">Le droit privé <span class="float-right">(15)</span></label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck16">
                                            <label class="custom-control-label" for="customCheck16">Le droit international public <span class="float-right">(26)</span></label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck17">
                                            <label class="custom-control-label" for="customCheck17">Le droit international privé <span class="float-right">(14)</span></label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck18">
                                            <label class="custom-control-label" for="customCheck18">Le droit interne <span class="float-right">(34)</span></label>
                                        </div>


                                        <a class="color-orose" href="#"><span class="fa fa-plus pr10"></span> Voir plus</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="selected_filter_widget style3">
                      <div id="accordion" class="panel-group">
                        <div class="panel">
                              <div class="panel-heading">
                                  <h4 class="panel-title">
                                    <a href="#panelBodyAuthors" class="accordion-toggle link fz20 mb15" data-toggle="collapse" data-parent="#accordion">Formateurs</a>
                                </h4>
                              </div>
                            <div id="panelBodyAuthors" class="panel-collapse collapse show">
                                <div class="panel-body">
                                    <div class="cl_skill_checkbox">
                                        <div class="content ui_kit_checkbox style2 text-left">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck80">
                                                <label class="custom-control-label" for="customCheck80">Futurs choisis <span class="float-right">(103)</span></label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1">Senagriculture <span class="float-right">(15)</span></label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck2">
                                                <label class="custom-control-label" for="customCheck2">Scichinta  <span class="float-right">(125)</span></label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck3">
                                                <label class="custom-control-label" for="customCheck3">illugraphic <span class="float-right">(4)</span></label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="selected_filter_widget style3 mb30">
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
                </div>


        </div>
    </div>
</section>

@endsection
