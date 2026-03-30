<div class="row">
    <div class="col-lg-12">
        <div class="row">

            <?php
            use App\Models\Course;
            ?>

            @foreach ($allCourses as $course)
                @php
                    $courseInformation = Course::with('modules.lessons')->find($course->id);
                    $courseModules = $courseInformation->modules;
                    $courseLessons = $courseInformation->lessons;

                    $courseModuleCount = @$courseModules->count();
                    $courseLessonsCount = @$courseLessons->count();

                    $isEnrolled = in_array($course->id, $enrolledCourseIds);
                @endphp

                <div class="col-xl-4 col-lg-6 col-sm-6">
                    <div class="card item-card">
                        <div class="card-body pb-0">
                            <div class="text-center">
                                <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : asset('assets/images/products/default.jpg') }}"
                                    alt="Course Thumbnail" class="img-fluid w-100">
                            </div>
                            <div class="card-body px-0">
                                <div class="cardtitle">
                                    <div>
                                        <a href="#"><i class="fa fa-star text-yellow fs-16"></i></a>
                                        <a href="#"><i class="fa fa-star text-yellow fs-16"></i></a>
                                        <a href="#"><i class="fa fa-star text-yellow fs-16"></i></a>
                                        <a href="#"><i class="fa fa-star text-yellow fs-16"></i></a>
                                        <a href="#"><i class="fa fa-star text-yellow fs-16"></i></a>
                                    </div>
                                    <a class="shop-title">{{ $course->title }} ({{ $courseLessonsCount ?? 0 }})</a>
                                    <h5 style="margin-top: 0.2rem; text-align: left !important;color:green;">
                                        Ugx{{ $course->selling_price }}
                                    </h5>
                                    <h5 class="text-info">
                                        ({{ $course->pricing_category == 1 ? 'Paid' : 'Free Course' }})
                                    </h5>
                                </div>

                                <div class="cardprice"
                                    style="display: flex; flex-direction: column; align-items: flex-start; text-align: left !important;">

                                    <span class="type--strikethrough"
                                        style="text-align: left !important; margin-bottom: 4px;color:red;">
                                        Ugx{{ $course->old_price }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="text-center border-top p-4">
                            <a href="{{ url('/student/course-details', $course->id) }}"
                                class="btn btn-light btn-svgs mt-1 mb-1"><svg class="svg-icon"
                                    xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                                    width="24">
                                    <path d="M0 0h24v24H0V0z" fill="none" />
                                    <path
                                        d="M12 6c-3.79 0-7.17 2.13-8.82 5.5C4.83 14.87 8.21 17 12 17s7.17-2.13 8.82-5.5C19.17 8.13 15.79 6 12 6zm0 10c-2.48 0-4.5-2.02-4.5-4.5S9.52 7 12 7s4.5 2.02 4.5 4.5S14.48 16 12 16z"
                                        opacity=".3" />
                                    <path
                                        d="M12 4C7 4 2.73 7.11 1 11.5 2.73 15.89 7 19 12 19s9.27-3.11 11-7.5C21.27 7.11 17 4 12 4zm0 13c-3.79 0-7.17-2.13-8.82-5.5C4.83 8.13 8.21 6 12 6s7.17 2.13 8.82 5.5C19.17 14.87 15.79 17 12 17zm0-10c-2.48 0-4.5 2.02-4.5 4.5S9.52 16 12 16s4.5-2.02 4.5-4.5S14.48 7 12 7zm0 7c-1.38 0-2.5-1.12-2.5-2.5S10.62 9 12 9s2.5 1.12 2.5 2.5S13.38 14 12 14z" />
                                </svg> View More</a>

                            @if ($isEnrolled)
                                <a href="javascript:void(0);" class="btn btn-success btn-svgs mt-1 mb-1 disabled"
                                    aria-disabled="true">
                                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24"
                                        width="24" viewBox="0 0 24 24"
                                        style="vertical-align: middle; margin-right: 5px;">
                                        <path fill="white"
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1.41 14.41L6.7 12.53a1 1 0 0 1 1.41-1.41l2.48 2.48 5.3-5.3a1 1 0 0 1 1.41 1.41l-6 6a1 1 0 0 1-1.41 0z" />
                                    </svg>
                                    Enrolled
                                </a>
                            @else
                                <form action="{{ route('student.add.cart', $course->id) }}" method="POST"
                                    class="add-to-cart-form" data-course-id="{{ $course->id }}"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit" id="add-to-cart-btn-{{ $course->id }}"
                                        class="btn btn-primary btn-svgs mt-1 mb-1">
                                        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24"
                                            width="24">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path d="M15.55 11l2.76-5H6.16l2.37 5z" opacity=".3" />
                                            <path
                                                d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.37-.66-.11-1.48-.87-1.48H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45z" />
                                        </svg>
                                        Enroll in Course
                                    </button>
                                </form>
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach

            <div class="card-footer w-100 mt-4">
                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <a href="{{ route('student.cart') }}" class="btn"
                            style="background-color: #28a745; color: white;">
                            <i class="fas fa-shopping-cart"></i> Proceed to Cart
                        </a>

                    </div>

                    <div>
                        {{ $allCourses->links('pagination::bootstrap-4') }}
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
