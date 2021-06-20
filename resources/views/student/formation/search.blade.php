@extends('layouts.student')

@section('content')

<div class="col-12">
    <div class="shortcode_widget_tab">
        @include('includes.student.search-bar')

        @include('includes.messages')

        <div class="ui_kit_tab mt-2">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active px-0 py-2" id="all-courses" role="tabpanel" aria-labelledby="all-courses-tab">
                    <div class="my_course_content_container">
                        <div class="my_course_content ">
                            <div class="my_course_content_list row pt-4 px-4 pb-0">
                                @if (count($formations) > 0)
                                    @foreach ($formations as $formation)
                                        <div class="col-md-6 col-sm-6 col-lg-4 col-xl-4">
                                            <div class="top_courses">
                                                <div class="thumb">
                                                <img class="img-whp" src="{{$formation->cover()}}" style="height: 167px;" alt="{{ $formation->title ?? '' }}">
                                                    <div class="overlay">
                                                        @if ($formation->categories)
                                                            <div class="tag" style="color:rgb(108, 43, 105); width: unset; max-width: 130px;">{{ $formation->categories->first()->title ?? '' }}</div>
                                                        @endif
                                                        <div class="icon"><span class="flaticon-like"></span></div>
                                                        <a class="tc_preview_course" href="{{ route('student.take-private-courses', $formation->slug ?? '') }}">Voir</a>
                                                    </div>
                                                </div>
                                                <div class="details">
                                                    <div class="tc_content">
                                                        <p style="color:#6C2B69">Par {{ $formation->teacher() ? $formation->teacher()->getFullName() : 'Futurs Choisis' }}</p>
                                                        <h5><a href="{{ route('student.take-private-courses', $formation->slug ?? '') }}">{{ $formation->title ?? '' }}</a></h5>
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
                                        Aucun résultat
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if (count($formations) > 0)
                            <div class="d-flex justify-content-center mt-3">
                                {{ $formations->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
