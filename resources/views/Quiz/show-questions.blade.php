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
                <li class="breadcrumb-item active" aria-current="page">Quiz</li>
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
                    <h3>Questions for Quiz: <strong>{{ $quiz->title }}</strong></h3>
                </div>
                <div class="card-body">
                    @if ($quiz->questions->isEmpty())
                        <p>No questions added yet.</p>
                    @else
                        @foreach ($quiz->questions as $index => $question)
                            <div class="mb-4 border p-3 rounded">
                                <h5>Question {{ $index + 1 }}:</h5>
                                <p><strong>Type:</strong> {{ ucfirst($question->question_type) }}</p>
                                <p><strong>Text:</strong> {{ $question->question_text }}</p>

                                @if ($question->question_type === 'mcq')
                                    <p><strong>Options:</strong></p>
                                    @php $options = json_decode($question->options, true); @endphp
                                    <ul>
                                        @foreach ($options as $option)
                                            <li>{{ $option }}</li>
                                        @endforeach
                                    </ul>
                                    <p><strong>Correct Answer:</strong> {{ $question->correct_answer }}</p>
                                @elseif($question->question_type === 'true_false')
                                    <p><strong>Correct Answer:</strong> {{ ucfirst($question->correct_answer) }}</p>
                                @elseif($question->question_type === 'short_answer')
                                    <p><strong>Expected Answer:</strong> {{ $question->correct_answer }}</p>
                                @endif
                            </div>
                        @endforeach
                    @endif
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
@endsection
