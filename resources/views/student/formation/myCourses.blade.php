@extends('layouts.student')

@section('content')



<div class="col-12">
    <div class="shortcode_widget_tab">
        @include('includes.student.search-bar')

        <div class="ui_kit_tab mt30">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="all-courses-tab" data-toggle="tab" href="#all-courses" role="tab" aria-controls="all-courses" aria-selected="true">Tous</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">En cours</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Terminés</a>
                </li>

            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active px-0" id="all-courses" role="tabpanel" aria-labelledby="all-courses-tab">
                    <div class="my_course_content_container">
                        <div class="my_course_content ">
                            <div class="my_course_content_list row pt-4 pr-4 pl-4 pb-0">
                                @if (count($my_formations) !== 0)
                                    @foreach ($my_formations as $formation)
                                        <div class="col-md-3 col-lg-3 col-xl-3">
                                            <div class="top_courses">
                                                <div class="thumb">
                                                <img class="img-whp" src="{{$formation->cover()}}" style="height: 200px;" alt="{{ $formation->title ?? '' }}">
                                                    <div class="overlay">
                                                        @if ($formation->categories)
                                                            <div class="tag" style="color:rgb(108, 43, 105); width: unset; max-width: 130px;">{{ $formation->categories->first()->title ?? '' }}</div>
                                                        @endif
                                                        <div class="icon"><span class="flaticon-like"></span></div>
                                                        <a class="tc_preview_course" href="{{ route('student.take-public-courses', $formation->slug ?? '') }}">Voir</a>
                                                    </div>
                                                </div>
                                                <div class="details">
                                                    <div class="tc_content">
                                                        <p style="color:#6C2B69">Par {{ $formation->teacher() ? $formation->teacher()->getFullName() : 'Futurs Choisis' }}</p>
                                                        <h5><a href="{{ route('student.take-public-courses', $formation->slug ?? '') }}">{{ $formation->title ?? '' }}</a></h5>
                                                        <div class="mt-3">
                                                            <div class="progressbar1"  data-width="{{ $formation->pivot->process ?? 0 }}" data-target="100"> {{ $formation->pivot->process ?? 0 }}%</div>
                                                        </div>
                                                    </div>
                                                    <div class="tc_footer">
                                                        <ul class="tc_meta float-left">
                                                            <li class="list-inline-item"><a href="#"><i class="flaticon-profile"></i></a></li>
                                                            <li class="list-inline-item"><a href="#">{{ count($formation->students) }}</a></li>
                                                        </ul>
                                                        <div class="tc_price float-right" style="color:#6C2B69">{{$formation->price ?? ''}} FCFA</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 d-flex justify-content-center mb-3">
                                        Aucune formation
                                    </div>
                                @endif

                            </div>
                        </div>
                        @if (count($my_formations) !== 0)
                            <div class="d-flex justify-content-center mt-3">
                                {{ $my_formations->links() }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="tab-pane fade px-0" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="my_course_content_container">
                        <div class="my_course_content ">
                            <div class="my_course_content_list row pt-4 pr-4 pl-4 pb-0">
                                @if (count($in_process_formations) !== 0)
                                    @foreach ($in_process_formations as $formation)
                                        <div class="col-md-3 col-lg-3 col-xl-3">
                                            <div class="top_courses">
                                                <div class="thumb">
                                                <img class="img-whp" src="{{$formation->cover()}}" style="height: 200;" alt="{{ $formation->title ?? '' }}">
                                                    <div class="overlay">
                                                        @if ($formation->categories)
                                                            <div class="tag" style="color:rgb(108, 43, 105); width: unset; max-width: 130px;">{{ $formation->categories->first()->title ?? '' }}</div>
                                                        @endif
                                                        <div class="icon"><span class="flaticon-like"></span></div>
                                                        <a class="tc_preview_course" href="{{ route('student.take-public-courses', $formation->slug ?? '') }}">Voir</a>
                                                    </div>
                                                </div>
                                                <div class="details">
                                                    <div class="tc_content">
                                                        <p style="color:#6C2B69">Par {{ $formation->teacher() ? $formation->teacher()->getFullName() : 'Futurs Choisis' }}</p>
                                                        <h5><a href="{{ route('student.take-public-courses', $formation->slug ?? '') }}">{{ $formation->title ?? '' }}</a></h5>
                                                        <div class="mt-3">
                                                            <div class="progressbar1"  data-width="{{ $formation->pivot->process ?? 0 }}" data-target="100"> {{ $formation->pivot->process ?? 0 }}%</div>
                                                        </div>
                                                    </div>
                                                    <div class="tc_footer">
                                                        <ul class="tc_meta float-left">
                                                            <li class="list-inline-item"><a href="#"><i class="flaticon-profile"></i></a></li>
                                                            <li class="list-inline-item"><a href="#">{{ count($formation->students) }}</a></li>
                                                        </ul>
                                                        <div class="tc_price float-right" style="color:#6C2B69">{{$formation->price ?? ''}} FCFA</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 d-flex justify-content-center mb-3">
                                        Aucune formation en cours
                                    </div>
                                @endif

                            </div>
                        </div>
                        @if (count($in_process_formations) !== 0)
                            <div class="d-flex justify-content-center mt-3">
                                {{ $in_process_formations->links() }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="tab-pane fade px-0" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="my_course_content_container">
                        <div class="my_course_content ">
                            <div class="my_course_content_list row pt-4 pr-4 pl-4 pb-0">
                                @if (count($finished_formations) !== 0)
                                    @foreach ($finished_formations as $formation)
                                        <div class="col-md-3 col-lg-3 col-xl-3">
                                            <div class="top_courses">
                                                <div class="thumb">
                                                <img class="img-whp" src="{{$formation->cover()}}" style="height: 200px;" alt="{{ $formation->title ?? '' }}">
                                                    <div class="overlay">
                                                        @if ($formation->categories)
                                                            <div class="tag" style="color:rgb(108, 43, 105); width: unset; max-width: 130px;">{{ $formation->categories->first()->title ?? '' }}</div>
                                                        @endif
                                                        <div class="icon"><span class="flaticon-like"></span></div>
                                                        <a class="tc_preview_course" href="{{ route('student.take-public-courses', $formation->slug ?? '') }}">Voir</a>
                                                    </div>
                                                </div>
                                                <div class="details">
                                                    <div class="tc_content">
                                                        <p style="color:#6C2B69">Par {{ $formation->teacher() ? $formation->teacher()->getFullName() : 'Futurs Choisis' }}</p>
                                                        <h5><a href="{{ route('student.take-public-courses', $formation->slug ?? '') }}">{{ $formation->title ?? '' }}</a></h5>
                                                        <div class="mt-3">
                                                            <div class="progressbar1"  data-width="{{ $formation->pivot->process ?? 0 }}" data-target="100"> {{ $formation->pivot->process ?? 0 }}%</div>
                                                        </div>
                                                    </div>
                                                    <div class="tc_footer">
                                                        <ul class="tc_meta float-left">
                                                            <li class="list-inline-item"><a href="#"><i class="flaticon-profile"></i></a></li>
                                                            <li class="list-inline-item"><a href="#">{{ count($formation->students) }}</a></li>
                                                        </ul>
                                                        <div class="tc_price float-right" style="color:#6C2B69">{{$formation->price ?? ''}} FCFA</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 d-flex justify-content-center mb-3">
                                        Aucune formation en terminée
                                    </div>
                                @endif

                            </div>
                        </div>
                        @if (count($finished_formations) !== 0)
                            <div class="d-flex justify-content-center mt-3">
                                {{ $finished_formations->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
