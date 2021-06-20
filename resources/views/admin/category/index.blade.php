@extends('layouts.admin')
@section('includes')

@endsection

@section('content')
<livewire:category />
@endsection

@section('script')
<script>
    $('.delete-user').click(function(e){
        e.preventDefault() // Don't post the form, unless confirmed
        if (confirm('Êtes vous sûr de vouloir supprimer ?')) {
            // Post the form
            $(e.target).closest('form').submit() // Post the surrounding form
        }
    });
</script>
@endsection
