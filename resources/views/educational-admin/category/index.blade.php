@extends('layouts.educational-admin')
@section('includes')

@endsection

@section('content')
<livewire:category />
@endsection

@section('script')

<script>

    jQuery(document).ready(function() {

        var btn_yes = $('#btn-yes');

        $(document).on('click', '.delete-btn', function () {
            console.log('delete clicked');
            var _this = $(this);
            var id_category = _this.attr('id-category');
            console.log(_this);
            btn_yes.attr('wire:click', `delete(${id_category})`);
        });

        btn_yes.on('click', function () {
            $('#deleteConfirmationModal').modal('hide');
        });

    });

</script>

@endsection
