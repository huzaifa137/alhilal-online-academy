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
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Quiz: <strong>{{ $quiz->title }}</strong></h3>

                    <a href="{{ url('student/ongoing-lesson/' . $quiz->course_id) }}" class="btn btn-info btn-sm ms-auto">
                        <i class="fas fa-arrow-left"></i> Return to lesson
                    </a>
                </div>

                <style>
                    .custom-bg .card-header {
                        background-color: #8e98db;
                    }
                </style>

                <div class="card-body">

                    @if ($hasSubmission)
                        @if ($results->isNotEmpty())
                            <div class="accordion mb-4 custom-bg" id="mainAccordion">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center"
                                        id="mainHeading">
                                        <button class="btn btn-link text-start text-left collapsed flex-grow-1"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#mainCollapse"
                                            aria-expanded="false" aria-controls="mainCollapse"
                                            style="text-align: left; text-decoration: none;">
                                            <strong><span style="color: #FFF">Last Submission</span></strong>
                                        </button>
                                        <h6 class="mb-0">
                                            <span class="text-white">Your Score: {{ $score }} /
                                                {{ $total }}</span>
                                        </h6>
                                    </div>

                                    <div id="mainCollapse" class="collapse" aria-labelledby="mainHeading"
                                        data-bs-parent="#mainAccordion">
                                        <div class="card-body">
                                            <div class="accordion" id="previousAnswersAccordion">
                                                @foreach ($results as $index => $result)
                                                    <div class="card">
                                                        <div class="card-header d-flex justify-content-between align-items-center"
                                                            id="heading{{ $index }}">
                                                            <button
                                                                class="btn btn-link flex-grow-1 text-start text-left collapsed"
                                                                type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#collapse{{ $index }}"
                                                                aria-expanded="false"
                                                                aria-controls="collapse{{ $index }}"
                                                                style="text-align: left; text-decoration: none;">
                                                                <span class="text-white"> Question {{ $index + 1 }}:
                                                                    {{ \Illuminate\Support\Str::limit($result['question'], 60) }}
                                                                </span>
                                                            </button>
                                                        </div>

                                                        <div id="collapse{{ $index }}" class="collapse"
                                                            aria-labelledby="heading{{ $index }}"
                                                            data-bs-parent="#previousAnswersAccordion">
                                                            <div class="card-body">
                                                                <p><strong>Q:</strong> {{ $result['question'] }}</p>

                                                                @if ($result['has_answer'])
                                                                    <p><strong>Your Answer:</strong>
                                                                        {{ $result['user_answer'] }}</p>
                                                                    <p>
                                                                        <strong>Status:</strong>
                                                                        @if ($result['is_correct'])
                                                                            <span class="badge bg-success">Correct</span>
                                                                        @else
                                                                            <span class="badge bg-danger">Incorrect</span>
                                                                        @endif
                                                                    </p>
                                                                @else
                                                                    <p><em>No answer submitted for this question.</em></p>
                                                                @endif

                                                                <hr>
                                                                {{-- <p><strong>Correct Answer:</strong> {{ $result['correct_answer'] }}</p> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info">You haven't attempted this quiz yet.</div>
                        @endif
                    @else
                        <div class="alert alert-info">You haven't attempted this quiz yet.</div>
                    @endif

                    <form id="quiz-form" action="{{ route('student.quizzes.submit', $quiz->id) }}" method="POST">
                        @csrf

                        @foreach ($quiz->questions as $index => $question)
                            <div class="mb-4 border p-3 rounded">
                                <h5>Question {{ $index + 1 }}</h5>
                                <p><strong>{{ $question->question_text }}</strong></p>

                                @if ($question->question_type === 'mcq')
                                    @php $options = json_decode($question->options, true); @endphp
                                    @foreach ($options as $option)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="answers[{{ $question->id }}]" value="{{ $option }}" required>
                                            <label class="form-check-label">{{ $option }}</label>
                                        </div>
                                    @endforeach
                                @elseif ($question->question_type === 'true_false')
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]"
                                            value="true" required>
                                        <label class="form-check-label">True</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]"
                                            value="false" required>
                                        <label class="form-check-label">False</label>
                                    </div>
                                @elseif ($question->question_type === 'short_answer')
                                    <input type="text" name="answers[{{ $question->id }}]" class="form-control"
                                        placeholder="Your Answer" required>
                                @endif
                            </div>
                        @endforeach

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check-circle"></i> Submit Quiz
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap JS (before closing body tag) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </div>
    </div>
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('js')
    <!-- Load SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('quiz-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const hasInputs = e.target.querySelectorAll('input[name^="answers"]').length > 0;

            if (!hasInputs) {
                Swal.fire({
                    icon: 'error',
                    title: 'No Questions',
                    text: 'There are no questions to answer in this quiz, contact system admin for support.',
                });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "Please confirm, you want to submit your answers.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const submitBtn = e.target.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = 'Submitting...<i class="fas fa-spinner fa-spin"></i>';
                    e.target.submit();
                }
            });
        });
    </script>
@endsection
