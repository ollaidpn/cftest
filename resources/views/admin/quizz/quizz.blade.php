@extends('layouts.admin')
@section('content')
    <livewire:quizz>
@endsection
@section('script')

<script>

    jQuery(document).ready(function() {

        var btn_yes = $('#btn-yes');

        $(document).on('click', '.delete-btn', function () {
            console.log('delete clicked');
            var _this = $(this);
            var id_quiz = _this.attr('id-quiz');
            console.log(_this);
            btn_yes.attr('wire:click', `delete(${id_quiz})`);
        });

        btn_yes.on('click', function () {
            $('#deleteConfirmationModal').modal('hide');
        });

    });

</script>


@endsection
