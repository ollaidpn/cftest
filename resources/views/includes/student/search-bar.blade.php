<div>
    <div class="my_course_content_header align-items-end mb-2 pl-0 justify-content-between d-flex">
        <div class="organization_title">
            <h4 class="mb-1">{{ Auth::user()->organization ? Auth::user()->organization->name ?? '' : 'Mes formations' }}</h4>
        </div>
        <div class="search">
            <div class="candidate_revew_select style2 text-right">
                <ul class="mb0">
                    <li class="list-inline-item">
                        <div class="candidate_revew_search_box course fn-520">
                            <form action="{{ route('student.search') }}" method="POST" class="form-inline my-2 my-lg-0">
                                @csrf
                                <input class="form-control mr-sm-2" name="search" type="search" placeholder="Recherche" aria-label="Search">
                                <button class="btn my-2 my-sm-0" type="submit"><span class="flaticon-magnifying-glass"></span></button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
