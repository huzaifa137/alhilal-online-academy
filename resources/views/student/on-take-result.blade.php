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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="mb-0">Results for: <strong>{{ $quiz->title }}</strong></h5>
                    <div class="text-end">
                        <h5 class="mb-2"><span style="color: red;">Your Score : </span> {{ $score }} /
                            {{ $total }}</h5>
                        <a href="{{ url('/student/ongoing-lesson/' . $quiz->course_id) }}"
                            class="btn btn-info btn-sm ms-auto">
                            <i class="fas fa-arrow-left"></i> Return to lessons
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
                        <a href="{{ route('student.quizzes.show', $quiz->id) }}"
                            class="btn btn-sm btn-primary retake-quiz-btn">
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
