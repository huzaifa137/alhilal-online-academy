<?php
use App\Http\Controllers\Helper;
use App\Http\Controllers\Controller;
$controller = new Controller();
?>
@extends('layouts-side-bar.master')
@section('css')
    <!---jvectormap css-->
    <link href="{{ URL::asset('assets/plugins/jvectormap/jqvmap.css') }}" rel="stylesheet" />
    <!-- Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <!--Daterangepicker css-->
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">Course Information</h4>
        </div>
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="d-flex"><svg class="svg-icon"
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                        </svg><span class="breadcrumb-icon"> Home</span></a></li>
                <li class="breadcrumb-item"><a href="#">Course</a></li>
                <li class="breadcrumb-item active" aria-current="page">Course Information</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <!--/app header-->
    <div class="main-proifle">
        <div class="row">
            <div class="col-lg-7">
                <div class="box-widget widget-user">
                    <div class="widget-user-image d-sm-flex">
                        <div class="text-center">
                            <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : asset('assets/images/products/default.jpg') }}"
                                alt="Course Thumbnail" class="img-fluid w-100">
                        </div>
                        <div class="ml-sm-4 mt-4">
                            <h4 class="pro-user-username mb-3 font-weight-bold">{{ $course->title }} </h4>

                            <div class="d-flex align-items-center mb-1">
                                <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" width="24"
                                    fill="#007bff" viewBox="0 0 24 24">
                                    <path
                                        d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z" />
                                </svg>
                                &nbsp; &nbsp;
                                <div class="h6 mb-0 ms-3">{{ Helper::item_md_name($course->instructor_id) }} (Instructor)
                                </div>
                            </div>

                            <div class="d-flex mb-1">
                                <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                                    width="24">
                                    <path d="M0 0h24v24H0V0z" fill="none" />
                                    <path d="M20 8l-8 5-8-5v10h16zm0-2H4l8 4.99z" opacity=".3" />
                                    <path
                                        d="M4 20h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2zM20 6l-8 4.99L4 6h16zM4 8l8 5 8-5v10H4V8z" />
                                </svg>
                                <div class="h6 mb-0 ml-3 mt-1">ugandanprogrammer137@gmail.com</div>
                            </div>

                            <div class="d-flex">
                                <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                                    width="24">
                                    <path d="M0 0h24v24H0V0z" fill="none" />
                                    <path
                                        d="M15.2 18.21c1.21.41 2.48.67 3.8.76v-1.5c-.88-.07-1.75-.22-2.6-.45l-1.2 1.19zM6.54 5h-1.5c.09 1.32.35 2.59.75 3.79l1.2-1.21c-.24-.83-.39-1.7-.45-2.58zM14 8h5V5h-5z"
                                        opacity=".3" />
                                    <path
                                        d="M20 15.5c-1.25 0-2.45-.2-3.57-.57-.1-.03-.21-.05-.31-.05-.26 0-.51.1-.71.29l-2.2 2.2c-2.83-1.44-5.15-3.75-6.59-6.58l2.2-2.21c.28-.27.36-.66.25-1.01C8.7 6.45 8.5 5.25 8.5 4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1 0 9.39 7.61 17 17 17 .55 0 1-.45 1-1v-3.5c0-.55-.45-1-1-1zM5.03 5h1.5c.07.88.22 1.75.46 2.59L5.79 8.8c-.41-1.21-.67-2.48-.76-3.8zM19 18.97c-1.32-.09-2.6-.35-3.8-.76l1.2-1.2c.85.24 1.72.39 2.6.45v1.51zM12 3v10l3-3h6V3h-9zm7 5h-5V5h5v3z" />
                                </svg>
                                <div class="h6 mb-0 ml-3 mt-1">+256 702 082 209</div>
                            </div>

                            <p>
                                <span class="font-weight-bold fs-25"
                                    style="text-decoration: line-through;color:rgb(212, 59, 59);">
                                    (Ugx{{ $course->old_price }})
                                </span><span class="font-weight-bold fs-25">Ugx{{ $course->selling_price }}</span>
                            </p>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-auto">

                @php
                    $isEnrolled = in_array($course->id, $enrolledCourseIds);
                @endphp

                @if ($isEnrolled)
                    <div class="text-lg-right mt-4 mt-lg-0">
                        <a href="{{ route('lesson.ongoing', $course->id) }}" class="btn btn-success btn-svgs mt-1 mb-1">
                            <i class="fa fa-book me-1"></i> &nbsp; Continue Learning
                        </a>
                    </div>
                @else
                    <div class="text-lg-right mt-4 mt-lg-0">
                        <form action="{{ route('student.enroll.course.action', $course->id) }}" method="POST" class="add-to-cart-form"
                            data-course-id="{{ $course->id }}" style="display:inline;">
                            @csrf
                            <button type="submit" id="add-to-cart-btn-{{ $course->id }}"
                                class="btn btn-primary btn-svgs mt-1 mb-1">
                                <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" width="24">
                                    <path d="M0 0h24v24H0V0z" fill="none" />
                                    <path d="M15.55 11l2.76-5H6.16l2.37 5z" opacity=".3" />
                                    <path
                                        d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.37-.66-.11-1.48-.87-1.48H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45z" />
                                </svg>
                                Enroll in Course
                            </button>
                        </form>
                    </div>
                @endif

                <div class="mt-5 d-flex justify-content-end">
                    <div class="media">
                        <div class="media-icon bg-light text-primary mr-3 mt-1">
                            <i class="fa fa-users fs-18"></i>
                        </div>
                        <div class="media-body">
                            <small class="text-muted">Students Enrolled</small>
                            <div class="font-weight-bold fs-25">
                                {{ $formattedFollowers }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="profile-cover">
            <div class="wideget-user-tab">
                <div class="tab-menu-heading p-0">

                    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

                    <div class="tabs-menu1 px-3">
                        <ul class="nav">
                            <li>
                                <a href="#tab-7" class="active" data-toggle="tab">
                                    <i class="fas fa-chart-pie"></i> Overview
                                </a>
                            </li>

                            <li>
                                <a href="#tab-8" data-toggle="tab">
                                    <i class="fas fa-book-open"></i> Curriculum
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div><!-- /.profile-cover -->
    </div>



    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        .course-features li {
            border-bottom: 1px solid #eee;
            padding: 8px 0;
            font-size: 15px;
        }

        .course-features li:last-child {
            border-bottom: none;
        }

        .course-features i {
            color: #007bff;
        }

        .course-features .value {
            font-weight: 500;
        }

        .lesson-list {
            border-left: 3px solid #28a745;
            padding-left: 10px;
        }

        .lesson-item {
            background-color: #f8f9fa;
            border-radius: 4px;
            transition: background-color 0.2s ease-in-out;
            cursor: default;
        }

        .lesson-item:hover {
            background-color: #e2f0d9;
        }

        .lesson-title {
            font-weight: 500;
            color: #343a40;
        }

        .fa-play-circle {
            font-size: 1.1rem;
        }
    </style>

    <!-- Main Content -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="border-0">
                <div class="tab-content">

                    <div class="tab-pane active" id="tab-7">

                        <div class="card p-4">
                            <div class="row">

                                <div class="col-md-6 mb-4 mb-md-0">
                                    <div class="card-body p-0" style="text-align: justify">
                                        <h5 class="font-weight-bold">Course Overview</h5>
                                        <div class="main-profile-bio mb-0">
                                            <p>Simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                                                been the
                                                industry's standard dummy when an unknown printer took a galley of type and
                                                scrambled it to make a type specimen book. It has survived not only five
                                                centuries
                                                unchanged.</p>
                                            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                                                aliquip ex
                                                ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                                                velit esse
                                                cillum dolore eu fugiat nulla pariatur. </p>
                                            <p class="mb-0">Pleasure rationally encountered but because pursue
                                                consequences that
                                                are extremely painful. Occur in which toil and pain can procure him some
                                                great
                                                pleasure... <a href="">More</a></p>
                                        </div>
                                    </div>
                                </div>

                                @php
                                    use App\Models\Course;

                                    $courseInformation = Course::with('modules.lessons.quizzes')->find($course->id);
                                    $courseModules = $courseInformation->modules;
                                    $courseLessons = $courseModules->flatMap->lessons;
                                    $courseQuizzes = $courseLessons->flatMap->quizzes;

                                    $courseModuleCount = $courseModules->count();
                                    $courseLessonsCount = $courseLessons->count();
                                    $courseQuizzesCount = $courseQuizzes->count();

                                    $isEnrolled = in_array($course->id, $enrolledCourseIds);
                                @endphp


                                <div class="col-md-6">
                                    <div class="card-body p-0">
                                        <h3 class="title mb-4">Course Features</h3>
                                        <ul class="course-features list-unstyled">
                                            <li class="d-flex justify-content-between align-items-center mb-2">
                                                <div><i class="fas fa-file-alt me-2"></i> Lessons</div>
                                                <span class="value">{{ $courseLessonsCount }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center mb-2">
                                                <div><i class="fas fa-question-circle me-2"></i> Quiz</div>
                                                <span class="value">{{ $courseQuizzesCount }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center mb-2">
                                                <div><i class="fas fa-clock me-2"></i> Duration</div>
                                                <span class="value">Flexible</span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center mb-2">
                                                <div><i class="fas fa-signal me-2"></i> Skill level</div>
                                                <span class="value"
                                                    style="text-transform: capitalize;">{{ $course->difficulty }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center mb-2">
                                                <div><i class="fas fa-language me-2"></i> Language</div>
                                                <span class="value">{{ Helper::item_md_name($course->language) }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center mb-2">
                                                <div><i class="fas fa-users me-2"></i> Students</div>
                                                <span class="value">{{ $formattedFollowers }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-center mb-2">
                                                <div><i class="fas fa-certificate me-2"></i> Certificate</div>
                                                <span class="value">Yes</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab-8">
                        <div class="accordion" id="courseModulesAccordion">
                            @forelse ($course->modules as $index => $module)
                                <div class="card mb-2">
                                    <div class="card-header" id="moduleHeading{{ $index }}">
                                        <h5 class="mb-0 d-flex align-items-center justify-content-between">
                                            <button class="btn text-left" type="button" data-toggle="collapse"
                                                data-target="#moduleCollapse{{ $index }}" aria-expanded="false"
                                                aria-controls="moduleCollapse{{ $index }}">
                                                <i class="fa fa-folder mr-2 text-primary"></i>
                                                {{ $module->title }}
                                                <small class="ml-2 text-muted">({{ $module->lessons->count() }}
                                                    lessons)</small>
                                            </button>
                                        </h5>
                                    </div>

                                    <div id="moduleCollapse{{ $index }}" class="collapse"
                                        aria-labelledby="moduleHeading{{ $index }}"
                                        data-parent="#courseModulesAccordion">
                                        <div class="card-body">
                                            @if ($module->lessons->count() > 0)
                                                <ul class="list-unstyled lesson-list">
                                                    @foreach ($module->lessons as $lesson)
                                                        <li class="lesson-item d-flex align-items-center mb-2 p-2">
                                                            <i class="fa fa-play-circle text-success mr-2"></i>
                                                            <span class="lesson-title">{{ $lesson->title }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p class="text-muted">No lessons added to this module yet.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">No curriculum available.</p>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    </div>
    </div><!-- end app-content-->
    </div>
@endsection
@section('js')
    <!-- ECharts js -->
    <script src="{{ URL::asset('assets/plugins/echarts/echarts.js') }}"></script>
    <!-- Peitychart js-->
    <script src="{{ URL::asset('assets/plugins/peitychart/jquery.peity.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/peitychart/peitychart.init.js') }}"></script>
    <!-- Apexchart js-->
    <script src="{{ URL::asset('assets/js/apexcharts.js') }}"></script>
    <!--Moment js-->
    <script src="{{ URL::asset('assets/plugins/moment/moment.js') }}"></script>
    <!-- Daterangepicker js-->
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/js/daterange.js') }}"></script>
    <!---jvectormap js-->
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery.vmap.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery.vmap.world.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery.vmap.sampledata.js') }}"></script>
    <!-- Index js-->
    <script src="{{ URL::asset('assets/js/index1.js') }}"></script>
    <!-- Data tables js-->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/datatables.js') }}"></script>
    <!--Counters -->
    <script src="{{ URL::asset('assets/plugins/counters/counterup.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/counters/waypoints.min.js') }}"></script>
    <!--Chart js -->
    <script src="{{ URL::asset('assets/plugins/chart/chart.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/utils.js') }}"></script>
@endsection
