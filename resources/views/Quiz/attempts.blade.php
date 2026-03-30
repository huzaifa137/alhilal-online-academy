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
    <h3>Attempt History for Quiz: {{ $quiz->title }}</h3>
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>#</th>
                <th>Score</th>
                <th>Total</th>
                <th>Attempt</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attempts as $attempt)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $attempt->pivot->score }}</td>
                    <td>{{ $attempt->pivot->total }}</td>
                    <td>{{ $attempt->pivot->attempt_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($attempt->pivot->completed_at)->format('d M Y h:i A') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
@section('js')
@endsection
