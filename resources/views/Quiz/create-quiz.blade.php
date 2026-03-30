@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">Quiz</h4>
        </div>
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="d-flex"><svg class="svg-icon"
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                        </svg><span class="breadcrumb-icon"> Home</span></a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Quiz</li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create quiz</h3>
                </div>
                <form id="quizForm" action="{{ route('quizzes.store.quiz') }}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-0">
                                <div class="form-group">
                                    <label><strong>Title</strong></label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        placeholder="Quiz Title" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6 mb-0">
                                <div class="form-group">
                                    <label><strong>Course</strong></label>
                                    <select name="course_id" class="form-control" required>
                                        <option value="">--- select ---</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label><strong>Description</strong></label>
                            <input type="text" class="form-control" id="description" name="description"
                                placeholder="quiz description">
                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-4 mb-0">
                                <div class="form-group">
                                    <label><strong>Module</strong></label>
                                    <select name="module_id" id="module_id" class="form-control" required>
                                        <option value="">--- select course ---</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-4 mb-0">
                                <div class="form-group">
                                    <label><strong>Lesson</strong></label>
                                    <select name="lesson_id" id="lesson_id" class="form-control" required>
                                        <option value="">--- select Module ---</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-4 mb-0">
                                <div class="form-group">
                                    <label><strong>Quiz Category</strong></label>
                                    <select name="quiz_category" id="quiz_category" class="form-control" required>
                                        <option value="">--- select ---</option>
                                        <option value="Module">Module</option>
                                        <option value="Lesson">Lesson</option>
                                        <option value="Course">Course</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="form-footer mt-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check-circle"></i> Save Quiz
                            </button>
                        </div>
                        
                    </div>

                </form>
            </div>
        </div>
    </div>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    </div>
    </div>
    </div>
@endsection

@if (session('success'))
    <script>
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
@endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('select[name="course_id"]').on('change', function() {
            var courseId = $(this).val();
            if (courseId) {
                $.ajax({
                    url: '/get-course-modules/' + courseId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#module_id').empty();
                        $('#module_id').append('<option value="">--- select ---</option>');
                        $.each(data, function(key, value) {
                            $('#module_id').append('<option value="' + value.id +
                                '">' + value.title + '</option>');
                        });
                    },
                    error: function(data) {
                        $('body').html(data.responseText);
                    }
                });
            } else {
                $('#module_id').empty().append('<option value="">--- select course first ---</option>');
            }
        });
    });


    $(document).ready(function() {
        $('select[name="module_id"]').on('change', function() {
            var moduleId = $(this).val();
            if (moduleId) {
                $.ajax({
                    url: '/get-course-lessons/' + moduleId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#lesson_id').empty();
                        $('#lesson_id').append('<option value="">--- select ---</option>');
                        $.each(data, function(key, value) {
                            $('#lesson_id').append('<option value="' + value.id +
                                '">' + value.title + '</option>');
                        });
                    },
                    error: function(data) {
                        $('body').html(data.responseText);
                    }
                });
            } else {
                $('#lesson_id').empty().append('<option value="">--- select module first ---</option>');
            }
        });
    });

    $(document).ready(function() {
        const form = $('#quizForm');
        const submitBtn = form.find('button[type="submit"]');

        form.on('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to create this quiz.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Yes, save it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Button UI
                    submitBtn.prop('disabled', true);
                    submitBtn.html('Creating quiz... <i class="fas fa-spinner fa-spin"></i>');

                    // Submit with AJAX
                    $.ajax({
                        url: form.attr('action'),
                        method: form.attr('method'),
                        data: form.serialize(),
                        success: function(response) {
                            // Redirect or success SweetAlert
                            Swal.fire({
                                title: 'Success!',
                                text: 'Quiz created successfully!',
                                icon: 'success'
                            }).then(() => {
                                window.location.href =
                                    "{{ route('quizzes.create.quiz') }}";
                            });
                        },
                        error: function(data) {
                            // Show raw error HTML for debugging (as you requested)
                            $('body').html(data.responseText);
                        }
                    });
                }
            });
        });
    });
</script>

@section('js')
@endsection
