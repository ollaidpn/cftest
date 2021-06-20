@extends('layouts.student')

@section('content')

@livewire('learn', ['formation' => $formation])

@endsection


@section('script')



<!-- Flot -->
<script src="{{asset('assets/admin-formateurs/vendor/flot/jquery.flot.js')}}"></script>
<script src="{{asset('assets/admin-formateurs/vendor/flot/jquery.flot.pie.js')}}"></script>
<script src="{{asset('assets/admin-formateurs/vendor/flot/jquery.flot.resize.js')}}"></script>
<script src="{{asset('assets/admin-formateurs/vendor/flot-spline/jquery.flot.spline.min.js')}}"></script>
<script src="{{asset('assets/admin-formateurs/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>


<!-- Init file -->
<script src="{{asset('assets/admin-formateurs/js/plugins-init/widgets-script-init.js')}}"></script>
@endsection
