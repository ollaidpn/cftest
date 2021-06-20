@extends('layouts.student')
@section('content')
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="col-lg-12">
            <nav class="breadcrumb_widgets" aria-label="breadcrumb mb30" style="background-color: #6C2B69;">
                <h4 class="title float-left" style="color: white;">Témoignage</h4>
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="#" style="color: white;">Espace Client</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: whitesmoke;">Liste temoignage</li>
                </ol>
            </nav>
        </div>
       @include('includes.messages')

       <div class="col-lg-12">
            <div class="my_course_content_container">
                <div class="my_setting_content mb30">
                    <div class="my_setting_content_header">
                        <div class="my_sch_title">
                            <h4 class="m0">Votre avis concernant la plateforme</h4>
                        </div>
                    </div>
                    <div class="">
                        <div class="col-12">
                            <form action="{{route('student.testimonial.validate')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                        <textarea class="form-control" name='testimonial' rows="6"></textarea>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                                        <button type="submit" class="btn btn-primary" style="color: white; font-weight:bold;">Enregistrer</button>
                                    </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>

@endsection


