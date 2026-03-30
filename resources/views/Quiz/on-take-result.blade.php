@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">Take Quiz</h4>
        </div>
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="d-flex"><svg class="svg-icon"
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                        </svg><span class="breadcrumb-icon"> Home</span></a></li>
                <li class="breadcrumb-item active" aria-current="page">Take Quiz</li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="mb-0">Results for: <strong>{{ $quiz->title }}</strong></h5>
                    <div class="text-end">
                        <h5 class="mb-2"><span style="color: red;">Your Score : </span> {{ $score }} /
                            {{ $total }}</h5>
                        <a href="{{ url('/courses/module-information/' . $quiz->course_id) }}"
                            class="btn btn-info btn-sm ms-auto">
                            <i class="fas fa-arrow-left"></i> Return to module
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @foreach ($results as $index => $result)
                        <div class="mb-4 border p-3 rounded">
                            <h5>Question {{ $index + 1 }}: {{ $result['question'] }}</h5>
                            <p><strong>Your Answer:</strong> {{ $result['user_answer'] }}</p>
                            {{-- <p><strong>Correct Answer:</strong> {{ $result['correct_answer'] }}</p> --}}
                            @if ($result['is_correct'])
                                <p class="text-success"><i class="fa fa-check-circle"></i> Correct</p>
                            @else
                                <p class="text-danger"><i class="fa fa-times-circle"></i> Incorrect</p>
                            @endif
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('quizzes.show', $quiz->id) }}" class="btn btn-sm btn-primary retake-quiz-btn">
                            <i class="fa fa-redo"></i> Retake Quiz
                        </a>
                        <h5 class="mb-0"> <span style="color: red;">Your Score : </span> {{ $score }} /
                            {{ $total }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    </div>
    </div>
    </div>
@endsection
@section('js')
    <!-- Load SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.retake-quiz-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const quizUrl = this.getAttribute('href');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You are about to retake this quiz.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, retake it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = quizUrl;
                        }
                    });
                });
            });
        });
    </script>
@endsection
