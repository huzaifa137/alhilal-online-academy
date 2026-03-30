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
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--End Page header-->
@endsection

<style>
    .custom-button-group>*:not(:last-child) {
        margin-right: 8px;
    }
</style>

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-header">Add question to : <strong> &nbsp; {{ $quiz->title }}</strong></h3>
                </div>

                <div class="form-border">

                    @if ($quiz->questions->count())
                        <div class="accordion mb-4" id="existingQuestionsAccordion">
                            @foreach ($quiz->questions as $index => $question)
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center"
                                        id="heading{{ $index }}">

                                        <button class="btn btn-link flex-grow-1 text-start text-left collapsed"
                                            type="button" data-toggle="collapse" data-target="#collapse{{ $index }}"
                                            aria-expanded="false" aria-controls="collapse{{ $index }}"
                                            style="text-align: left;text-decoration:none;">
                                            Question {{ $index + 1 }}: {{ Str::limit($question->question_text, 60) }}
                                        </button>

                                        <button type="button" class="btn btn-danger btn-sm ms-3 delete-existing-question"
                                            data-question-id="{{ $question->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>

                                    </div>

                                    <div id="collapse{{ $index }}" class="collapse"
                                        aria-labelledby="heading{{ $index }}"
                                        data-parent="#existingQuestionsAccordion">
                                        <div class="card-body">
                                            <p><strong>{{ $question->question_text }}</strong></p>

                                            @if ($question->question_type === 'mcq')
                                                @php $options = json_decode($question->options, true); @endphp
                                                @foreach ($options as $option)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" disabled>
                                                        <label class="form-check-label">{{ $option }}</label>
                                                    </div>
                                                @endforeach

                                                <p><strong>Correct Answer:</strong> {{ $question->correct_answer }}</p>
                                            @elseif ($question->question_type === 'true_false')
                                                <p><strong>Type:</strong> True / False</p>
                                                <p><strong>Correct Answer:</strong> {{ $question->correct_answer }}</p>
                                            @elseif ($question->question_type === 'short_answer')
                                                <p><strong>Type:</strong> Short Answer</p>
                                                <p><strong>Expected Answer:</strong> {{ $question->correct_answer }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif


                    <form id="quizForm" action="{{ route('questions.store', $quiz->id) }}" method="POST">
                        @csrf

                        <div id="question-wrapper">
                            <!-- Dynamic question blocks will be inserted here -->
                        </div>

                        <div class="d-flex justify-content-end my-3 custom-button-group">
                            <button type="button" id="add-question" class="btn btn-primary btn-sm">+ Add Question</button>

                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-file-alt me-1"></i> Submit All Questions
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
    </div>
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
    let questionIndex = 0;

    function getQuestionBlock(index) {
        return `
        <div class="card mb-3 question-block" data-index="${index}">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Question #${index + 1}</strong>
                    <button type="button" class="btn btn-danger btn-sm delete-question">
                    <i class="fas fa-trash-alt"></i> Delete
                    </button>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Question</label>
                    <input type="text" name="questions[${index}][question]" class="form-control" required>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6 mb-0">
                        <div class="form-group">
                            <label>Question Type</label>
                            <select name="questions[${index}][type]" class="form-control question-type" data-index="${index}" required>
                                <option value="">--- select ---</option>
                                <option value="true_false">True / False</option>
                                <option value="mcq">Multiple Choice (MCQ)</option>
                                <option value="short_answer">Short Answer</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6 mb-0">
                        <div class="form-group">

                            <div class="form-group d-none type-block" id="mcq-options-${index}">
                                <label>Options</label>
                                <input type="text" name="questions[${index}][options][]" class="form-control mb-2" placeholder="Option 1">
                                <input type="text" name="questions[${index}][options][]" class="form-control mb-2" placeholder="Option 2">
                                <input type="text" name="questions[${index}][options][]" class="form-control mb-2" placeholder="Option 3">
                                <input type="text" name="questions[${index}][options][]" class="form-control mb-2" placeholder="Option 4">
                                <input type="text" name="questions[${index}][correct_answer_mcqs]" class="form-control" placeholder="Correct Option">
                            </div>

                            <div class="form-group d-none type-block" id="true-false-${index}">
                                <label>Correct Answer</label>
                                <select name="questions[${index}][correct_answer_boolean]" class="form-control">
                                    <option value="true">True</option>
                                    <option value="false">False</option>
                                </select>
                            </div>

                            <div class="form-group d-none type-block" id="short-answer-${index}">
                                <label>Expected Answer (optional)</label>
                                <input type="text" name="questions[${index}][correct_answer_short_answer]" class="form-control" placeholder="Expected Answer">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;
    }

    $(document).ready(function() {
        $('#add-question').on('click', function() {
            const block = getQuestionBlock(questionIndex);
            $('#question-wrapper').append(block);
            questionIndex++;
        });

        $('#question-wrapper').on('change', '.question-type', function() {
            const index = $(this).data('index');
            const selected = $(this).val();

            $(`#mcq-options-${index}, #true-false-${index}, #short-answer-${index}`).addClass('d-none');

            if (selected === 'mcq') {
                $(`#mcq-options-${index}`).removeClass('d-none');
            } else if (selected === 'true_false') {
                $(`#true-false-${index}`).removeClass('d-none');
            } else if (selected === 'short_answer') {
                $(`#short-answer-${index}`).removeClass('d-none');
            }
        });

        $('#question-wrapper').on('click', '.delete-question', function() {
            $(this).closest('.question-block').remove();
        });

        $('#quizForm').on('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Submit All Questions?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, submit!',
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = $(this);
                    $.ajax({
                        url: form.attr('action'),
                        method: form.attr('method'),
                        data: form.serialize(),
                        success: function() {
                            Swal.fire('Success!', 'Questions submitted.', 'success')
                                .then(() => {
                                    window.location.reload();
                                });
                        },
                        error: function(err) {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
                    });
                }
            });
        });

        const form = $('#quizForm');
        const submitBtn = form.find('button[type="submit"]');

        form.on('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to add a question to this quiz.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Yes, add it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    submitBtn.prop('disabled', true);
                    submitBtn.html('Adding question... <i class="fas fa-spinner fa-spin"></i>');

                    $.ajax({
                        url: form.attr('action'),
                        method: form.attr('method'),
                        data: form.serialize(),
                        success: function(response) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Question added successfully!',
                                icon: 'success'
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(data) {
                            $('body').html(data.responseText);
                        }
                    });
                }
            });
        });
    });


    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#question-wrapper').on('click', '.delete-question', function() {
            $(this).closest('.question-block').remove();
        });

        $('#existingQuestionsAccordion').on('click', '.delete-existing-question', function() {
            const questionId = $(this).data('question-id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to delete this question.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                confirmButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: `/quiz/delete-quiz-questions/${questionId}`,
                        method: 'DELETE',
                        success: function(response) {
                            Swal.fire('Deleted!', 'The question has been deleted.',
                                    'success')
                                .then(() => {

                                    window.location
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
    });
</script>


@section('js')
@endsection
