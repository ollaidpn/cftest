@extends('layouts.teacher')
@section('includes')
    <link rel="stylesheet" href="{{ asset('assets/admin-formateurs/plugins/bootstrap-fileinput-master/css/fileinput.css') }}">
@endsection

@section('content')

<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @if (session()->has('formation_success'))
            <div class="alert alert-success alert-dismissible alert-notice alert-light-success fade show" role="alert">
                <div class="alert-text">{{ session('formation_success') }}</div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @elseif (session()->has('formation_error'))
            <div class="alert alert-danger alert-dismissible alert-notice alert-light-danger fade show" role="alert">
                <div class="alert-text">{{ session('formation_error') }}</div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @elseif ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <livewire:add-formation.index />
    </div>
</div>
@endsection

@push('scripts')
@endpush
