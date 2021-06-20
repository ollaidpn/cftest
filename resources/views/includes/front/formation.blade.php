<div class="top_courses">
    <div class="thumb">
    <img class="img-whp" src="{{$formation->cover()}}" style="height: 167px;" alt="{{ $formation->title ?? '' }}">
        <div class="overlay">
            @if ($formation->categories)
                <div class="tag" style="color:rgb(108, 43, 105); width: unset; max-width: 130px;">{{ $formation->categories->first()->title ?? '' }}</div>
            @endif
            <div class="icon"><span class="flaticon-like"></span></div>
            <a class="tc_preview_course" href="{{ route('front.course.show', $formation->slug ?? '') }}">Voir</a>
        </div>
    </div>
    <div class="details">
        <div class="tc_content">
            <p style="color:#6C2B69">Par {{ $formation->teacher() ? $formation->teacher()->getFullName() : 'Futurs Choisis' }}</p>
            <h5><a href="{{ route('front.course.show', $formation->slug ?? '') }}">{{ $formation->title ?? '' }}</a></h5>
        </div>
        <div class="tc_footer">
            @if ($formation->show_stats == '1')
                <ul class="tc_meta float-left">
                    <li class="list-inline-item"><a href="#"><i class="flaticon-profile"></i></a></li>
                    <li class="list-inline-item"><a href="#">{{ count($formation->students) }}</a></li>
                </ul>
            @endif

            <div class="tc_price float-right" style="color:#6C2B69">{{$formation->price ?? ''}} FCFA</div>
        </div>
    </div>
</div>
