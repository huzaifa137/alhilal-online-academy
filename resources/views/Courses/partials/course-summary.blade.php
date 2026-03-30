<div class="card box-widget widget-user">
    <div class="widget-user-image mx-auto mt-5">
        <img alt="User Avatar" class="rounded-circle" src="{{ URL::asset('assets/images/users/16.jpg') }}">
    </div>
    <div class="card-body text-center">
        <div class="pro-user">
            <h3 class="pro-user-username text-dark mb-1">
                {{ \App\Http\Controllers\Helper::item_md_name($course->instructor_id) ?? 'N/A' }}
            </h3>
            <h6 class="pro-user-desc text-muted">
                {{ \App\Http\Controllers\Helper::item_md_name($course->category_id) ?? 'N/A' }}
            </h6>
            <a href="{{ url('/users/users-profile') }}" class="btn btn-primary mt-3">View Profile</a>
        </div>
    </div>
    <div class="card-footer p-0">
        <div class="row">
            <div class="col-sm-12 border-right text-center">
                <div class="description-block p-4">
                    <h5 class="description-header mb-1 font-weight-bold">{{ $course->title }}</h5>
                    <span class="text-muted">Language:
                        {{ \App\Http\Controllers\Helper::item_md_name($course->language) ?? 'N/A' }}</span><br>
                    <span class="text-muted">Difficulty: <span
                            class="text-capitalize">{{ $course->difficulty }}</span></span>
                </div>
            </div>
        </div>
    </div>
</div>
