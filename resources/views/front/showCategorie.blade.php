@extends('layouts.front')
@section('content')
<!-- Inner Page Breadcrumb -->
<section class="inner_page_breadcrumb">
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
                        @foreach ($formations as $formation )
                        <div class="col-lg-6 col-xl-4">
                            @include('includes.front.formation', ['formation' => $formation])
                        </div>
                        @endforeach
                    @else
                        <div class="d-flex justify-content-center col-12">
                            Aucune formation
                        </div>
                    @endif
                </div>
                <div class="d-flex justify-content-center">
                    {{ $formations->links() }}
                </div>
            </div>
            <div class="col-lg-4 col-xl-3">
                <div class="selected_filter_widget style3 mb30">
                      <div id="accordion" class="panel-group">
                        <div class="panel">
                              <div class="panel-heading">
                                  <h4 class="panel-title">
                                    <a href="#panelBodySoftware" class="accordion-toggle link fz20 mb15" data-toggle="collapse" data-parent="#accordion">Cat??gorie de formations</a>
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
                                <p>
                                    <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Toggle first element</a>
                                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">Toggle second element</button>
                                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2">Toggle both elements</button>
                                  </p>
                                  <div class="row">
                                    <div class="col">
                                      <div class="collapse multi-collapse" id="multiCollapseExample1">
                                        <div class="card card-body">
                                          Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col">
                                      <div class="collapse multi-collapse" id="multiCollapseExample2">
                                        <div class="card card-body">
                                          Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                <div class="panel-body">
                                    <div class="ui_kit_whitchbox">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                            <a href="#">Payants</a> <label class="custom-control-label" for="customSwitch1"><a href="#">Payants</a> </label>
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
