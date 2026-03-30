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
@endsection
@section('content')
    <br> <br>

    <style>
        .card.toggle-tab {
            cursor: pointer;
        }

        .swal2-container {
            z-index: 2000 !important;
        }

        .progress-bar {
            font-size: 0.85rem;
            font-weight: 600;
        }

        @media (max-width: 576px) {
            .btn-group .btn {
                width: 100%;
                margin-bottom: 5px;
            }
        }

        @keyframes pulsePop {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.7);
            }

            70% {
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(255, 193, 7, 0);
            }

            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(255, 193, 7, 0);
            }
        }

        .animate-attention {
            animation: pulsePop 1.5s infinite;
        }
    </style>
    <div class="row">
        <div class="col-12 text-center">
            <h1>{{ $course->title }}</h1>
        </div>

        <div class="col-xl-9 col-lg-8 col-md-12">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-lg-12">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-12">
                            <div class="card toggle-tab" data-target="#modules">
                                <div class="card-body">
                                    <i class="fas fa-cogs card-custom-icon text-success icon-dropshadow-success"
                                        style="font-size: 40px;"></i>
                                    <p class="mb-1">Modules</p>
                                    <h2 class="mb-1 font-weight-bold">{{ $modulesCount }}</h2>
                                    <div class="progress progress-sm mt-3 bg-success-transparent">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-12">
                            <div class="card toggle-tab" data-target="#lessons">
                                <div class="card-body">
                                    <i class="fas fa-book-open card-custom-icon text-secondary icon-dropshadow-secondary"
                                        style="font-size: 40px;"></i>
                                    <p class="mb-1">Lessons</p>
                                    <h2 class="mb-1 font-weight-bold">{{ $lessonsCount }}</h2>
                                    <div class="progress progress-sm mt-3 bg-secondary-transparent">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                                            style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-12">
                            <div class="card toggle-tab" data-target="#quizzes">
                                <div class="card-body">
                                    <i class="fas fa-question-circle card-custom-icon text-primary icon-dropshadow-primary"
                                        style="font-size: 40px;"></i>
                                    <p class="mb-1">Quizzes</p>
                                    <h2 class="mb-1 font-weight-bold">{{ $quizzesCount }}</h2>
                                    <div class="progress progress-sm mt-3 bg-primary-transparent">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                            style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="tab-content mt-4" id="studyTabsContent">

                <div class="tab-pane fade" id="modules" role="tabpanel">
                    <div class="accordion" id="modulesAccordion">
                        @foreach ($course->modules as $module)
                            @php
                                $totalLessons = $module->lessons->count();
                                $completedLessons = $module->lessons
                                    ->filter(function ($lesson) {
                                        return $lesson->usersCompleted->contains(session('LoggedStudent'));
                                    })
                                    ->count();

                                $isModuleComplete = $totalLessons > 0 && $completedLessons === $totalLessons;
                            @endphp

                            <div class="card mb-2">
                                <div class="card-header d-flex justify-content-between align-items-center"
                                    id="heading-{{ $module->id }}">
                                    <strong>{{ $module->title }}</strong>
                                    <div class="d-flex gap-2">
                                        @if ($isModuleComplete)
                                            <button type="button" class="btn btn-sm btn-success mt-2">
                                                <i class="fas fa-check-circle"></i> 100% Completed
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-danger mt-2">
                                                <i class="fas fa-times-circle"></i> Not Yet Completed
                                            </button>
                                        @endif
                                        &nbsp;
                                        <button class="btn btn-sm btn-info mt-2" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-{{ $module->id }}" aria-expanded="false"
                                            aria-controls="collapse-{{ $module->id }}">
                                            <i class="fas fa-chevron-down"></i> Show Lessons
                                        </button>
                                    </div>
                                </div>

                                <div id="collapse-{{ $module->id }}" class="collapse"
                                    aria-labelledby="heading-{{ $module->id }}" data-bs-parent="#modulesAccordion">
                                    <div class="card-body">
                                        <p>{{ $module->description ?? 'No description' }}</p>

                                        @foreach ($module->lessons as $lesson)
                                            @php
                                                $isLessonComplete = $lesson->usersCompleted->contains(
                                                    session('LoggedStudent'),
                                                );
                                            @endphp

                                            <div
                                                class="border rounded p-2 mb-2 d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $lesson->title }}</strong><br>
                                                    <small>{{ $lesson->description ?? 'No description' }}</small>
                                                </div>
                                                <div>
                                                    @if ($isLessonComplete)
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check-circle"></i> Completed
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-times-circle"></i> Not Completed
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Lessons -->
                <div class="tab-pane fade show active" id="lessons" role="tabpanel">
                    @php $user = \App\Models\User::find(session('LoggedStudent')); @endphp

                    @foreach ($course->modules as $module)
                        <h5 class="mt-3">{{ $module->title }}</h5>
                        @foreach ($module->lessons as $lesson)
                            @php

                                $isCompleted = $user && $user->completedLessons->contains($lesson->id);
                                $quiz = $lesson->quiz;

                                $hasAttempted = false;

                                if ($quiz && $user) {
                                    $hasAttempted = DB::table('quiz_user')
                                        ->where('quiz_id', $quiz->id)
                                        ->where('user_id', $user->id)
                                        ->exists();
                                }
                            @endphp

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between flex-wrap align-items-start">
                                        <div class="flex-grow-1 me-3">
                                            <strong>{{ $lesson->title }}</strong><br>
                                            <small>{{ $lesson->description ?? 'No description' }}</small><br>

                                            <a href="{{ route('student.lessons.details', $lesson->id) }}"
                                                class="btn btn-sm btn-info mt-2">
                                                <i class="fas fa-eye"></i> View Lesson
                                            </a>

                                            @if ($quiz)
                                                <a href="{{ route('student.quizzes.show', $quiz->id) }}"
                                                    class="btn btn-sm mt-2 {{ $hasAttempted ? 'btn-dark' : 'btn-warning animate-attention' }} retake-quiz-btn">
                                                    <i class="fa fa-pen"></i>
                                                    {{ $hasAttempted ? 'Retake Quiz' : 'Attempt Quiz' }}
                                                </a>
                                            @else
                                                <button class="btn btn-sm btn-secondary mt-2" disabled>
                                                    <i class="fa fa-ban"></i> No Quiz Available
                                                </button>
                                            @endif

                                            @if ($isCompleted)
                                                <button type="button" class="btn btn-sm btn-success mt-2">
                                                    <i class="fas fa-check-circle"></i> 100% Completed
                                                </button>
                                            @elseif ($user)
                                                <form action="{{ route('student.lessons.complete', $lesson->id) }}"
                                                    method="POST" class="d-inline complete-lesson-form">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-primary mt-2">
                                                        <i class="fas fa-check"></i> Mark Lesson as Completed
                                                    </button>
                                                </form>
                                            @endif

                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>


                <!-- Quizzes -->
                <div class="tab-pane fade" id="quizzes" role="tabpanel">
                    @php $user = \App\Models\User::find(session('LoggedStudent')); @endphp

                    @foreach ($course->modules as $module)
                        @foreach ($module->lessons as $lesson)
                            @foreach ($lesson->quizzes as $quiz)
                                @php
                                    $hasAttempted = false;

                                    if ($quiz && $user) {
                                        $hasAttempted = DB::table('quiz_user')
                                            ->where('quiz_id', $quiz->id)
                                            ->where('user_id', $user->id)
                                            ->exists();
                                    }
                                @endphp

                                <div class="card mb-2">
                                    <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                                        <div>
                                            <strong>{{ $quiz->title }}</strong><br>
                                            <small>Belongs to Lesson: {{ $lesson->title }}</small>
                                        </div>

                                        <div>
                                            <a href="{{ route('student.quizzes.show', $quiz->id) }}"
                                                class="btn btn-sm mt-2 {{ $hasAttempted ? 'btn-dark' : 'btn-warning animate-attention' }} retake-quiz-btn">
                                                <i class="fa fa-pen"></i>
                                                {{ $hasAttempted ? 'Retake Quiz' : 'Attempt Quiz' }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    @endforeach
                </div>


            </div>
        </div>

        <!-- RIGHT SIDE: Certificate Card -->
        <div class="col-xl-3 col-lg-4 col-md-12">
            <div class="card h-100">
                <div class="card-header text-center border-0">
                    <h2>Certificates of <b>{{ Helper::student_username(Session('LoggedStudent')) }}</b></h2>
                </div>
                <div class="card-body text-center">
                    <img src="{{ URL::asset('assets/images/photos/award.png') }}" alt="img" class="sales-img mb-3">
                    <h2 class="fs-40 font-weight-bold mb-0">0</h2>
                    <p class="text-muted fs-18 mt-4">All the certificates achieved</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS bundle (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



    </div>
    </div>
    </div>
@endsection
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.toggle-tab');
            const tabs = document.querySelectorAll('.tab-pane');

            cards.forEach(card => {
                card.addEventListener('click', function() {
                    const target = this.getAttribute('data-target');

                    tabs.forEach(tab => {
                        tab.classList.remove('show', 'active');
                    });

                    const activeTab = document.querySelector(target);
                    if (activeTab) {
                        activeTab.classList.add('show', 'active');
                    }
                });
            });
        });

        $(document).ready(function() {

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    showConfirmButton: true
                });
            @endif

            $('#addModuleForm').on('submit', function() {
                const button = document.getElementById('submitModuleBtn');
                button.disabled = true;
                button.innerHTML = 'Saving... <i class="fas fa-spinner fa-spin"></i>';
            });

            $(document).on('click', '[data-bs-target="#addLessonModal"]', function() {
                const moduleId = $(this).data('module');
                $('#lessonModuleId').val(moduleId);
            });


            $('#addLessonModal').on('submit', function() {
                const button = document.getElementById('submitLessonBtn');
                button.disabled = true;
                button.innerHTML = 'Saving... <i class="fas fa-spinner fa-spin"></i>';
            });


            $('#editLessonForm').on('submit', function() {
                const button = document.getElementById('updateLessonBtn');
                button.disabled = true;
                button.innerHTML = 'Updating... <i class="fas fa-spinner fa-spin"></i>';
            });

            $(document).on('click', '.edit-module-btn', function() {
                const moduleId = $(this).data('id');
                const title = $(this).data('title');
                const description = $(this).data('description');

                $('#editModuleId').val(moduleId);
                $('#editModuleTitle').val(title);
                $('#editModuleDescription').val(description);

                $('#editModuleForm').attr('action', '/courses/update-module/' +
                    moduleId);
            });

            $('#editModuleForm').on('submit', function() {
                const button = document.getElementById('updateModuleBtn');
                button.disabled = true;
                button.innerHTML = 'Updating... <i class="fas fa-spinner fa-spin"></i>';
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.delete-module-btn', function(e) {
            e.preventDefault();
            const moduleId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'This will permanently delete the module.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/courses/delete-module/' + moduleId,
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            _method: 'DELETE'
                        },
                        success: function(response) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response
                                    .message
                            }).then(() => {
                                location
                                    .reload();
                            });
                        },
                        error: function(data) {
                            $('body').html(data.responseText);
                        }
                    });
                }
            });
        });

        $(document).on('click', '.edit-lesson-btn', function() {
            const id = $(this).data('id');
            const title = $(this).data('title');
            const desc = $(this).data('description');
            const video = $(this).data('video');

            $('#editLessonId').val(id);
            $('#editLessonTitle').val(title);
            $('#editLessonDescription').val(desc);
            $('#editLessonVideoUrl').val(video);

            $('#editLessonForm').attr('action', '/lessons/update-lesson/' + id);
        });

        $('#editLessonForm').on('submit', function() {
            const button = document.getElementById('updateLessonBtn');
            button.disabled = true;
            button.innerHTML = 'Updating... <i class="fas fa-spinner fa-spin"></i>';
        });

        $(document).on('click', '.delete-lesson-btn', function() {
            const lessonId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'This will permanently delete the lesson.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/lessons/delete-lesson/' + lessonId,
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(data) {
                            console.error(data.responseText);
                        }
                    });
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.complete-lesson-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to mark this lesson as completed?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, mark it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const url = form.action;
                            const formData = new FormData(form);

                            $.ajax({
                                url: url,
                                method: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                headers: {
                                    'X-CSRF-TOKEN': formData.get('_token'),
                                    'Accept': 'application/json'
                                },
                                success: function(data) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: data.message,
                                        timer: 1500,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload();
                                    });
                                },
                                error: function(data) {

                                    const response = data.responseJSON;
                                    if (response && response.message) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: response.message
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Unexpected Error',
                                            text: 'Something went wrong. Please check console or network tab for details.'
                                        });
                                    }

                                }
                            });
                        }
                    });

                });
            });
        });
    </script>

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
