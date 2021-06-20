<!DOCTYPE html>
<html lang="fr">

<!-- Mirrored from grandetest.com/theme/edumy-html/page-dashboard.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Nov 2020 11:51:01 GMT -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="academy, college, coursera, courses, education, elearning, kindergarten, lms, lynda, online course, online education, school, training, udemy, university">
<meta name="description" content="Futurs Choisis">
<meta name="CreativeLayers" content="ATFN">
<!-- css file -->
<link rel="stylesheet" href="{{ asset('assets/front-clients/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/front-clients/css/style.css')}}">
<link rel="stylesheet" href="{{ asset('assets/front-clients/css/dashbord_navitaion.css')}}">
<!-- Responsive stylesheet -->
<link rel="stylesheet" href="{{ asset('assets/front-clients/css/responsive.css')}}">
<!-- Title -->
<title>{{ $page_title ?? 'Futurs Choisis' }} | Futurs Choisis</title>
<!-- Favicon -->
<link href="{{ getInfoSystem() ? getInfoSystem()->getFavicon() : '' }}" sizes="128x128" rel="shortcut icon" type="image/x-icon" />
<link href="{{ getInfoSystem() ? getInfoSystem()->getFavicon() : '' }}" sizes="128x128" rel="shortcut icon" />
<style>
    .btn-primary {
        background-color:#6C2B69;
        border-color:#6C2B69 !important;
    }
</style>

@livewireStyles
@stack('styles')
@yield('styles')
</head>
<body>
<div class="wrapper">
    <div class="preloader"></div>
	<!-- Main Header Nav -->
    @include('includes.student.header')

	<!-- Main Header Nav For Mobile -->
    @include('includes.student.mobile-navbar')

	<!-- Our Dashbord Sidebar -->
    @include('includes.student.sidebar')

    <div class="our-dashbord dashbord" style="min-height: 94vh;">
		<div class="dashboard_main_content" style="min-height:94vh;">
			<div class="container-fluid" style="display: flex; justify-content: space-between; flex-direction: column; min-height:94vh;">
				<div class="main_content_container">
                    @yield('content')
                </div>
                <!-- Our Footer -->
                @include('includes.student.footer')
			</div>
		</div>
    </div>

    <a class="scrollToHome" href="#"><i class="flaticon-up-arrow-1"></i></a>
</div>

<!-- Wrapper End -->
<script type="text/javascript" src="{{ asset('assets/front-clients/js/jquery-3.3.1.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/front-clients/js/jquery-migrate-3.0.0.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/front-clients/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/front-clients/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/front-clients/js/jquery.mmenu.all.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/front-clients/js/ace-responsive-menu.js')}}"></script>
{{-- <script type="text/javascript" src="{{ asset('assets/front-clients/js/chart.min.js')}}"></script> --}}
{{-- <script type="text/javascript" src="{{ asset('assets/front-clients/js/chart-custome.js')}}"></script> --}}
<script type="text/javascript" src="{{ asset('assets/front-clients/js/bootstrap-select.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/front-clients/js/snackbar.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/front-clients/js/simplebar.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/front-clients/js/parallax.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/front-clients/js/scrollto.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/front-clients/js/jquery-scrolltofixed-min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/front-clients/js/jquery.counterup.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/front-clients/js/wow.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/front-clients/js/progressbar.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/front-clients/js/slider.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/front-clients/js/timepicker.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/front-clients/js/wow.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/front-clients/js/dashboard-script.js')}}"></script>
<!-- Custom script for all pages -->
<script type="text/javascript" src="{{ asset('assets/front-clients/js/script.js')}}"></script>
@livewireScripts
@stack('scripts')
@yield('scripts')
</body>

</html>
