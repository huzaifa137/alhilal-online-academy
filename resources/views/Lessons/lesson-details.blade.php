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

    .video-container {
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
    }

    .video-container iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    .ratio-16x9 {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
        max-width: 100%;
    }

    .ratio-16x9 iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>{{ $lesson->title }}</h4>
                <a href="{{ url('lessons/module-details/' . $lesson->id) }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back to module
                </a>
            </div>
            <div class="card-body">

                <p><strong>Module:</strong> {{ $lesson->module->title }}</p>
                <p><strong>Course:</strong> {{ $lesson->module->course->title }}</p>

                @if ($lesson->video_url)
                    @php
                        $embedUrl = str_replace('watch?v=', 'embed/', $lesson->video_url);
                    @endphp
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="video-container">
                                <div class="ratio ratio-16x9">
                                    <iframe src="{{ $embedUrl }}" frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection
