<!DOCTYPE html>
<html lang="fr">


<!-- Mirrored from eduzone.dexignzone.com/admin/app-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Nov 2020 11:57:21 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $page_title ?? 'Futurs Choisis' }} | Futurs Choisis</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/admin-formateurs/images/favicon.png')}}">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link href="{{ asset('assets/admin-formateurs/css/style.css')}}" rel="stylesheet">

    @livewireStyles()
    @yield('includes')
    @stack('styles')

</head>

<body>


    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="{{ route('home') }}" class="brand-logo">
                <img class="logo-abbr " src="{{ asset('assets/admin-formateurs/images/logocompoact.png')}}" alt="logoFC.png">
                <img class="logo-compact" src="{{ asset('assets/admin-formateurs/images/logoM.png')}}" alt="logoFC.png">
                <img class="brand-title" src="{{ asset('assets/admin-formateurs/images/logoM.png')}}" alt="logoFC.png">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
            @include('includes.admin.header')
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
            @include('includes.admin.sidebar')
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
            @yield('content')
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
            @include('includes.admin.footer')
        <!--**********************************
            Footer end
        ***********************************-->

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

	<!--removeIf(production)-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('assets/admin-formateurs/vendor/global/global.min.js')}}"></script>
    <script src="{{ asset('assets/admin-formateurs/js/deznav-init.js')}}"></script>
    <script src="{{ asset('assets/admin-formateurs/js/custom.min.js')}}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
    @livewireScripts()
    @stack('scripts')
    @yield('script')

	<!-- Svganimation scripts -->
    <script src="{{ asset('assets/admin-formateurs/vendor/svganimation/vivus.min.js')}}"></script>
    <script src="{{ asset('assets/admin-formateurs/vendor/svganimation/svg.animation.js')}}"></script>
</body>


<!-- Mirrored from eduzone.dexignzone.com/admin/app-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Nov 2020 11:57:28 GMT -->
</html>

