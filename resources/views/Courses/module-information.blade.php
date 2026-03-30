@extends('layouts.master')

@section('page-header')
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">Course Modules</h4>
        </div>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

<style>
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

@section('content')
    <div class="row">
        <div class="col-12 col-lg-5 col-xl-4 mb-3">
            @include('Courses.partials.course-summary', ['course' => $course])
        </div>

        <div class="col-12 col-lg-7 col-xl-8">
            <div class="card">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <h5 class="card-title m-0">Modules in: {{ $course->title }}</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModuleModal">
                        <i class="fas fa-plus"></i> Add Module
                    </button>
                </div>
                <div class="card-body">
                    @php $user = \App\Models\User::find(session('LoggedAdmin')); @endphp

                    @forelse($course->modules as $count => $module)
                        @php
                            $totalLessons = $module->lessons->count();
                            $completedLessons = $user
                                ? $module->lessons
                                    ->filter(fn($lesson) => $user->completedLessons->contains($lesson->id))
                                    ->count()
                                : 0;
                            $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
                        @endphp

                        <div class="card p-3 mb-3 shadow-sm">
                            <div
                                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                                <div class="w-100">
                                    <h5>{{ $module->title }}</h5>
                                    <div class="progress mt-1" style="height: 20px;">
                                        <div class="progress-bar bg-success" role="progressbar"
                                            style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}"
                                            aria-valuemin="0" aria-valuemax="100">
                                            {{ $progress }}%
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-2 mt-2 mt-md-0">
                                    <button class="btn btn-sm btn-info" data-bs-toggle="collapse"
                                        data-bs-target="#lessons-{{ $module->id }}">
                                        <i class="fas fa-book-open"></i> Lessons
                                    </button>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#addLessonModal" data-module="{{ $module->id }}">
                                        <i class="fas fa-plus"></i> Add Lesson
                                    </button>
                                    <a href="#" class="btn btn-sm btn-warning edit-module-btn"
                                        data-id="{{ $module->id }}" data-title="{{ $module->title }}"
                                        data-description="{{ $module->description }}" data-bs-toggle="modal"
                                        data-bs-target="#editModuleModal">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="#" class="btn btn-sm btn-danger delete-module-btn"
                                        data-id="{{ $module->id }}">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div id="lessons-{{ $module->id }}" class="collapse mt-2">
                            @forelse($module->lessons as $lesson)
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

                                <div class="border rounded p-3 mb-2 position-relative">
                                    <div class="d-flex flex-wrap justify-content-end gap-2 mb-2">
                                        <a href="{{ route('lessons.details', $lesson->id) }}"
                                            class="btn btn-sm btn-success">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <button class="btn btn-sm btn-info edit-lesson-btn" data-id="{{ $lesson->id }}"
                                            data-title="{{ $lesson->title }}"
                                            data-description="{{ $lesson->description }}"
                                            data-video="{{ $lesson->video_url }}" data-bs-toggle="modal"
                                            data-bs-target="#editLessonModal">
                                            <i class="fas fa-sliders"></i> Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-lesson-btn"
                                            data-id="{{ $lesson->id }}">
                                            <i class="fas fa-ban"></i> Delete
                                        </button>
                                    </div>

                                    <strong>{{ $lesson->title }}</strong><br>
                                    <small>{{ $lesson->description }}</small><br>
                                    <small><i class="fas fa-video"></i> {{ $lesson->video_url }}</small><br>

                                    @if ($isCompleted)
                                        <button type="button" class="btn btn-sm btn-success mt-2">
                                            <i class="fas fa-check-circle"></i> Completed
                                        </button>
                                    @elseif ($user)
                                        <form action="{{ route('lessons.complete', $lesson->id) }}" method="POST"
                                            class="d-inline complete-lesson-form">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-primary mt-2">
                                                <i class="fas fa-check"></i> Mark as Completed
                                            </button>
                                        </form>
                                    @endif

                                    @if ($quiz = $lesson->quiz)
                                        <a href="{{ route('quizzes.show', $quiz->id) }}"
                                            class="btn btn-sm mt-2 {{ $hasAttempted ? 'btn-info' : 'btn-warning animate-attention' }} retake-quiz-btn">
                                            <i class="fa fa-pen"></i> {{ $hasAttempted ? 'Retake Quiz' : 'Attempt Quiz' }}
                                        </a>
                                    @else
                                        <button class="btn btn-sm btn-secondary mt-2" disabled>
                                            <i class="fa fa-ban"></i> No Quiz Available
                                        </button>
                                    @endif

                                </div>
                            @empty
                                <p>No lessons yet.</p>
                            @endforelse
                        </div>
                    @empty
                        <p>No modules yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModuleModal" tabindex="-1" aria-labelledby="addModuleLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('save.course.module') }}" id="addModuleForm">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">

                    <div class="modal-header">
                        <h5 class="modal-title">Add New Module</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="submitModuleBtn">
                            <i class="fas fa-paper-plane"></i> Save Module
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <div class="modal fade" id="editModuleModal" tabindex="-1" aria-labelledby="editModuleLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="" id="editModuleForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="module_id" id="editModuleId">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Module</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" id="editModuleTitle" class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3" id="editModuleDescription" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="updateModuleBtn">
                            <i class="fas fa-save"></i> Update Module
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addLessonModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('save.module.lesson') }}" method="POST">
                @csrf
                <input type="hidden" name="module_id" id="lessonModuleId">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Lesson</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Lesson Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="form-group mt-2">
                            <label>Description</label>
                            <textarea name="description" class="form-control" required></textarea>
                        </div>
                        <div class="form-group mt-2">
                            <label>Video URL</label>
                            <input type="url" class="form-control" name="video_url" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="submitLessonBtn">
                            <i class="fas fa-paper-plane"></i> Save Lesson
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="editLessonModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="" id="editLessonForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="lesson_id" id="editLessonId">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Lesson</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Lesson Title</label>
                            <input type="text" class="form-control" name="title" id="editLessonTitle" required>
                        </div>
                        <div class="form-group mt-2">
                            <label>Description</label>
                            <textarea class="form-control" name="description" id="editLessonDescription" required></textarea>
                        </div>
                        <div class="form-group mt-2">
                            <label>Video URL</label>
                            <input type="url" class="form-control" name="video_url" id="editLessonVideoUrl"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit" id="updateLessonBtn">
                            <i class="fas fa-save"></i> Update Lesson
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    </div>
    </div>
    </div>
    </div>
@endsection

<!-- External links for font-awesome, bootstrap, and SweetAlert -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
