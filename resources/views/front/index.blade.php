@extends('layouts.front')
@section('include')
    <style>
        .home3_bgi6 {
            background-image: url('') !important;
            -webkit-background-size: cover;
            background-size: cover;
            background-position: center center;
            height: 1006px;
        }
    </style>
@endsection
@section('content')

	<!-- Home Design -->
	<section class="home-three home3-overlay home3_bgi6" style="background-image: url('{{ getInfoSystem() ? getInfoSystem()->getImgSlider() : '' }}') !important;">
		<div class="container">
			<div class="row posr">
				<div class="col-lg-12">
					<div class="home-text text-center">
						<h2 class="fz50">Construis tes compétences, choisis ton futur...</h2>
						<a class="btn home_btn" href="{{ route('front.courses')}}">Démarrer</a>
					</div>
				</div>
			</div>
			<div class="row_style">
				<svg class="waves" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 300" preserveAspectRatio="none"> <path d="M 1000 280 l 2 -253 c -155 -36 -310 135 -415 164 c -102.64 28.35 -149 -32 -235 -31 c -80 1 -142 53 -229 80 c -65.54 20.34 -101 15 -126 11.61 v 54.39 z"></path><path d="M 1000 261 l 2 -222 c -157 -43 -312 144 -405 178 c -101.11 33.38 -159 -47 -242 -46 c -80 1 -153.09 54.07 -229 87 c -65.21 25.59 -104.07 16.72 -126 16.61 v 22.39 z"></path><path d="M 1000 296 l 1 -230.29 c -217 -12.71 -300.47 129.15 -404 156.29 c -103 27 -174 -30 -257 -29 c -80 1 -130.09 37.07 -214 70 c -61.23 24 -108 15.61 -126 10.61 v 22.39 z"></path></svg>
			</div>
		</div>
	</section>

	<!-- School Category Courses -->
	<section id="our-top-courses" class="our-courses">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 offset-lg-3">
					<div class="main-title text-center">
						<h3 class="mt0">Nos Formations</h3>
					</div>
				</div>
			</div>
 			<div class="row">
                 @if ($last_formations)
                    @foreach ($last_formations as $formation)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        @include('includes.front.formation', ['formation' => $formation])
                    </div>
                    @endforeach
                 @else
                    Aucune formation
                 @endif
				<div class="col-lg-6 offset-lg-3">
					<div class="courses_all_btn text-center">
						<a class="btn btn-transparent" href="{{ route('front.courses')}}">Voir Toutes les formations</a>
					</div>
				</div>
 			</div>
		</div>
	</section>

	<!-- Our Popular Courses -->
	<section class="popular-courses bgc-thm2">
		<div class="container-fluid style2">
			<div class="row">
				<div class="col-lg-6 offset-lg-3">
					<div class="main-title text-center">
						<h3 class="mt0 color-white">Nos Formations populaires</h3>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="popular_course_slider">
						@if ($most_views_formations)
                            @foreach ($most_views_formations as $formation )
                            <div class="item">
                                @include('includes.front.formation', ['formation' => $formation])
                            </div>
                            @endforeach
                        @else
                            Aucune formation
                        @endif
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Our Testimonials -->
	<section id="our-testimonials" class="our-testimonial">
		<div class="container-fluid">
            @if ($testimonials)
                <div class="row d-none d-sm-none d-md-block">
                    <div class="col-lg-6 offset-lg-3">
                        <div class="main-title text-center">
                            <h3 class="mt0">Témoignages</h3>
                            <p>Ce que nos apprenants disent de nous.</p>
                        </div>
                    </div>
                </div>
                <div class="row d-none d-sm-none d-md-block">
                    <div class="col-lg-12">
                        <div class="testimonial_slider_home2">
                            @foreach ($testimonials as $testimonial )
                            <div class="item">
                                <div class="testimonial_item home2">
                                    <div class="details">
                                        <div class="icon"><span class="fa fa-quote-left"></span></div>
                                        <p>{{$testimonial->testimonial ?? ''}}</p>
                                    </div>
                                    <div class="thumb">
                                        <img class="img-fluid rounded-circle" src="{{ $testimonial->user->image() }}" alt="">
                                        <div class="title">{{ $testimonial->user->getFullName() ?? ''}}</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
			<div class="row mt60">
				<div class="col-sm-6 col-lg-6 col-xl-6" style="background-image: url('{{ asset('assets/admin-formateurs/images/courses/learn.jpg') }}'); background-size:cover;">
				</div>
				<div class="col-sm-6 col-lg-6 col-xl-6">
					<div class="becomea_instructor style2 text-right tac-xxsd">
						<div class="bi_grid">
							<h3>Vous voulez apprendre ?</h3>
							<p>Augmenter vos compétences et recever une certification de fin de formation.</p>
							<a class="btn btn-dark" href="{{ route('register') }}">Ouvrir un compte<span class="flaticon-right-arrow-1"></span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection


