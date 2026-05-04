@extends('Teacher.layouts.teacher-master')

@section('title', $lesson->title . ' - Lesson Details')
@section('page-title', 'Lesson Details')
@section('breadcrumb', 'Lessons')

@section('content')
    <style>
        /* Additional styles matching the master layout aesthetic */
        .lesson-header {
            background: linear-gradient(135deg, var(--ink) 0%, #2D0F5C 50%, #4A1A1A 100%);
            border-radius: 28px;
            padding: 32px 36px;
            margin-bottom: 32px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .lesson-header::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(107, 70, 193, 0.25) 0%, transparent 70%);
            top: -150px;
            right: -80px;
            pointer-events: none;
        }

        .lesson-header::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(220, 38, 38, 0.15) 0%, transparent 70%);
            bottom: -100px;
            left: -60px;
            pointer-events: none;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .stat-card {
            background: white;
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(107, 70, 193, 0.08);
        }

        .resource-card {
            background: var(--cream);
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 16px;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .resource-card:hover {
            background: white;
            border-color: var(--purple-light);
            transform: translateX(6px);
            box-shadow: var(--shadow-sm);
        }

        .info-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            width: 130px;
            font-weight: 600;
            color: var(--ink);
            font-size: 0.85rem;
        }

        .info-value {
            flex: 1;
            color: var(--ink-light);
            font-size: 0.85rem;
        }

        .nav-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 40px;
            color: var(--purple);
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .nav-button:hover {
            background: var(--purple);
            color: white;
            border-color: var(--purple);
            transform: translateX(-2px);
        }

        .progress-bar-custom {
            height: 8px;
            background: var(--border);
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: var(--gradient);
            border-radius: 10px;
            transition: width 0.6s ease;
        }

        .action-btn {
            padding: 10px 22px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.85rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-edit {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-edit:hover {
            background: white;
            color: var(--purple);
            transform: translateY(-2px);
        }

        .btn-preview {
            background: var(--gradient);
            color: white;
            box-shadow: 0 4px 14px rgba(107, 70, 193, 0.3);
        }

        .btn-preview:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(107, 70, 193, 0.4);
        }

        .type-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            background: var(--cream2);
            border-radius: 50px;
            border: 1px solid var(--border);
        }

        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeSlideUp 0.5s ease forwards;
        }

        .card-custom {
            background: white;
            border-radius: 24px;
            border: 1px solid var(--border);
            overflow: hidden;
            margin-bottom: 28px;
            transition: all 0.2s ease;
        }

        .card-custom-header {
            padding: 20px 28px;
            border-bottom: 1px solid var(--border);
            background: white;
        }

        .card-custom-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--ink);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-custom-subtitle {
            font-size: 0.75rem;
            color: var(--muted);
            margin-top: 5px;
        }

        .card-custom-body {
            padding: 24px 28px;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .lesson-header {
                padding: 24px;
            }

            .card-custom-header,
            .card-custom-body {
                padding: 18px 20px;
            }
        }

        /* Resource Preview Modal Styles */
        .resource-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(26, 10, 46, 0.92);
            backdrop-filter: blur(12px);
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-y: auto;
            padding: 20px;
        }

        .resource-modal-container {
            background: var(--cream, #FDFBF7);
            border-radius: 32px;
            max-width: 90vw;
            width: 100%;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            animation: modalZoomIn 0.35s cubic-bezier(0.34, 1.2, 0.64, 1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border: 1px solid var(--border, rgba(107, 70, 193, 0.15));
        }

        @keyframes modalZoomIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(-20px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .resource-modal-header {
            padding: 20px 28px;
            border-bottom: 1.5px solid var(--border, rgba(107, 70, 193, 0.10));
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, var(--cream2, #F7F3EE) 0%, var(--cream, #FDFBF7) 100%);
            border-radius: 32px 32px 0 0;
        }

        .resource-modal-header-content {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .resource-modal-icon {
            width: 48px;
            height: 48px;
            background: var(--gradient-soft, linear-gradient(135deg, #EDE9FA 0%, #FEE2E2 100%));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        .resource-modal-icon i {
            background: var(--gradient, linear-gradient(135deg, var(--purple) 0%, var(--red) 100%));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .resource-modal-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--ink, #1A0A2E);
            margin: 0;
        }

        .resource-modal-subtitle {
            font-size: 0.75rem;
            color: var(--muted2, #9892B0);
            margin: 4px 0 0;
        }

        .resource-modal-close {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            border: 1.5px solid var(--border, rgba(107, 70, 193, 0.10));
            background: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--muted, #6B6584);
            transition: all 0.25s ease;
        }

        .resource-modal-close:hover {
            background: var(--red-light, #FEE2E2);
            border-color: var(--red, #DC2626);
            color: var(--red, #DC2626);
            transform: rotate(90deg);
        }

        .resource-modal-body {
            flex: 1;
            padding: 28px;
            overflow-y: auto;
            min-height: 400px;
            max-height: 60vh;
            background: var(--cream, #FDFBF7);
        }

        /* Video Player */
        .resource-video-container {
            position: relative;
            width: 100%;
            background: #000;
            border-radius: 20px;
            overflow: hidden;
        }

        .resource-video-container video {
            width: 100%;
            max-height: 55vh;
            outline: none;
        }

        /* PDF Viewer */
        .resource-pdf-container {
            width: 100%;
            height: 500px;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--border, rgba(107, 70, 193, 0.10));
        }

        .resource-pdf-container embed,
        .resource-pdf-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .resource-pdf-fallback {
            text-align: center;
            padding: 60px 20px;
        }

        .resource-pdf-fallback i {
            font-size: 4rem;
            color: var(--purple, #6B46C1);
            margin-bottom: 16px;
        }

        /* Audio Player */
        .resource-audio-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: var(--purple-xlight, #F5F3FD);
            border-radius: 24px;
            text-align: center;
        }

        .resource-audio-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--purple-light) 0%, var(--purple) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
        }

        .resource-audio-icon i {
            font-size: 2.5rem;
            color: white;
        }

        .resource-audio-container audio {
            width: 100%;
            margin-top: 20px;
        }

        /* Image Viewer */
        .resource-image-container {
            text-align: center;
        }

        .resource-image-container img {
            max-width: 100%;
            max-height: 55vh;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
        }

        /* Loading State */
        .resource-loading {
            text-align: center;
            padding: 60px 40px;
        }

        .resource-spinner {
            width: 48px;
            height: 48px;
            border: 3px solid var(--purple-light, #EDE9FA);
            border-top-color: var(--purple, #6B46C1);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto 16px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .resource-loading p {
            color: var(--muted, #6B6584);
            font-size: 0.85rem;
        }

        /* Modal Footer */
        .resource-modal-footer {
            padding: 20px 28px;
            border-top: 1.5px solid var(--border, rgba(107, 70, 193, 0.10));
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            background: linear-gradient(135deg, var(--cream2, #F7F3EE) 0%, var(--cream, #FDFBF7) 100%);
            border-radius: 0 0 32px 32px;
        }

        .resource-download-btn {
            padding: 10px 24px;
            border-radius: 40px;
            background: var(--green-light, #DCFCE7);
            color: var(--green, #16A34A);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.25s ease;
        }

        .resource-download-btn:hover {
            background: var(--green, #16A34A);
            color: white;
            transform: translateY(-2px);
        }

        .resource-close-btn {
            padding: 10px 24px;
            border-radius: 40px;
            border: 1.5px solid var(--border2, rgba(107, 70, 193, 0.20));
            background: white;
            color: var(--muted, #6B6584);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .resource-close-btn:hover {
            background: var(--purple-xlight, #F5F3FD);
            border-color: var(--purple, #6B46C1);
            color: var(--purple, #6B46C1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .resource-modal-container {
                max-width: 95%;
                max-height: 85vh;
            }

            .resource-modal-header {
                padding: 16px 20px;
            }

            .resource-modal-body {
                padding: 16px;
            }

            .resource-pdf-container {
                height: 400px;
            }

            .resource-audio-container {
                padding: 24px;
            }
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                {{-- Lesson Header --}}
                <div class="lesson-header animate-in">
                    <div style="position: relative; z-index: 2;">
                        <div
                            style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
                            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                <span class="badge-status">
                                    <i class="fas {{ $lesson->status == 'published' ? 'fa-globe' : 'fa-pen-fancy' }}"></i>
                                    {{ ucfirst($lesson->status) }}
                                </span>
                                @if($lesson->status == 'published' && $lesson->published_at)
                                    <span class="badge-status">
                                        <i class="fas fa-calendar-alt"></i>
                                        Published: {{ $lesson->published_at->format('M d, Y') }}
                                    </span>
                                @endif
                                <span class="badge-status">
                                    <i class="fas fa-clock"></i>
                                    Created: {{ $lesson->created_at->format('M d, Y') }}
                                </span>
                            </div>
                            <div style="display: flex; gap: 12px;">
                                <a href="{{ url('teacher/lessons') }}" class="action-btn btn-preview">
                                    <i class="fas fa-arrow-left"></i> Back to All Lessons
                                </a>
                            </div>
                        </div>

                        <h1
                            style="font-family: 'Playfair Display', serif; font-size: 2.2rem; font-weight: 700; margin-bottom: 12px;">
                            {{ $lesson->title }}
                        </h1>

                        @if($lesson->title_arabic)
                            <p
                                style="font-size: 1.1rem; opacity: 0.85; margin-bottom: 20px; font-family: 'Amiri', serif; direction: rtl;">
                                {{ $lesson->title_arabic }}
                            </p>
                        @endif

                        <div style="display: flex; gap: 28px; flex-wrap: wrap; margin-top: 20px;">
                            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; opacity: 0.9;">
                                <i class="fas fa-chalkboard-user"></i>
                                <span>{{ $lesson->teacher->name ?? 'N/A' }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; opacity: 0.9;">
                                <i class="fas fa-layer-group"></i>
                                <span>{{ $lesson->topic->class->name ?? 'N/A' }} •
                                    {{ $lesson->topic->subject->name ?? 'N/A' }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; opacity: 0.9;">
                                <i class="fas fa-folder-open"></i>
                                <span>Topic: {{ $lesson->topic->title ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Main 2-Column Grid --}}
                <div class="row">
                    <div class="col-md-8 animate-in" style="animation-delay: 0.1s;">

                        {{-- Lesson Description --}}
                        @if($lesson->description)
                            <div class="card-custom">
                                <div class="card-custom-header">
                                    <div class="card-custom-title">
                                        <i class="fas fa-align-left" style="color: var(--purple);"></i>
                                        Description
                                    </div>
                                    <div class="card-custom-subtitle">What students will learn in this lesson</div>
                                </div>
                                <div class="card-custom-body">
                                    <p style="line-height: 1.7; color: var(--ink-light); font-size: 0.95rem;">
                                        {{ $lesson->description }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        {{-- Lesson Materials / Resources --}}
                        {{-- Lesson Materials / Resources --}}
                        <div class="card-custom">
                            <div class="card-custom-header">
                                <div>
                                    <div class="card-custom-title">
                                        <i class="fas fa-paperclip" style="color: var(--purple);"></i>
                                        Materials & Resources
                                    </div>
                                    <div class="card-custom-subtitle">Downloadable content and attachments</div>
                                </div>
                            </div>
                            <div class="card-custom-body">
                                @if($lesson->resources && $lesson->resources->count() > 0)
                                    @foreach($lesson->resources as $resource)
                                        <div class="resource-card"
                                            onclick="previewResource({{ $resource->id }}, '{{ addslashes($resource->title) }}', '{{ $resource->type }}', '{{ Storage::url($resource->file_path) }}')">
                                            <div style="display: flex; align-items: center; gap: 18px;">
                                                <div
                                                    style="width: 52px; height: 52px; background: linear-gradient(135deg, var(--purple-light) 0%, var(--purple) 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 4px 10px rgba(107,70,193,0.2);">
                                                    @php
                                                        $icon = match ($resource->type) {
                                                            'video' => 'fa-video',
                                                            'audio' => 'fa-headphones',
                                                            'pdf' => 'fa-file-pdf',
                                                            'image' => 'fa-image',
                                                            default => 'fa-file'
                                                        };
                                                    @endphp
                                                    <i class="fas {{ $icon }} fa-lg"></i>
                                                </div>
                                                <div style="flex: 1;">
                                                    <h4
                                                        style="font-weight: 700; color: var(--ink); margin-bottom: 5px; font-size: 0.95rem;">
                                                        {{ $resource->title }}
                                                    </h4>
                                                    <div style="display: flex; gap: 15px; font-size: 0.7rem; color: var(--muted);">
                                                        <span>
                                                            <i class="fas fa-file"></i>
                                                            {{ strtoupper($resource->type) }}
                                                        </span>
                                                        @if($resource->file_size)
                                                            <span>
                                                                <i class="fas fa-database"></i>
                                                                {{ number_format($resource->file_size / 1048576, 2) }} MB
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div style="display: flex; gap: 8px;">
                                                    <button class="nav-button preview-btn"
                                                        style="padding: 8px 18px; font-size: 0.75rem;"
                                                        onclick="event.stopPropagation(); previewResource({{ $resource->id }}, '{{ addslashes($resource->title) }}', '{{ $resource->type }}', '{{ Storage::url($resource->file_path) }}')">
                                                        <i class="fas fa-eye"></i> Preview
                                                    </button>
                                                    <a href="{{ Storage::url($resource->file_path) }}" download class="nav-button"
                                                        style="padding: 8px 18px; font-size: 0.75rem;"
                                                        onclick="event.stopPropagation()">
                                                        <i class="fas fa-download"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div style="text-align: center; padding: 50px 20px; color: var(--muted);">
                                        <i class="fas fa-folder-open fa-3x" style="margin-bottom: 16px; opacity: 0.5;"></i>
                                        <p>No materials attached to this lesson yet.</p>
                                        <a href="{{ url('teacher/lessons/edit', $lesson->id) }}" class="nav-button"
                                            style="margin-top: 12px;">
                                            <i class="fas fa-plus"></i> Add Resources
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Teacher Notes (Private) --}}
                        @if($lesson->notes)
                            <div class="card-custom" style="background: linear-gradient(135deg, #FDFBF7 0%, #FEF5E7 100%);">
                                <div class="card-custom-header" style="border-bottom-color: rgba(237, 137, 54, 0.2);">
                                    <div class="card-custom-title">
                                        <i class="fas fa-lock" style="color: var(--warning);"></i>
                                        Private Teacher Notes
                                    </div>
                                    <div class="card-custom-subtitle">Only visible to teachers and admins</div>
                                </div>
                                <div class="card-custom-body">
                                    <p style="line-height: 1.65; color: var(--ink-light); font-style: italic;">
                                        {{ $lesson->notes }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-4 animate-in" style="animation-delay: 0.2s;">

                        {{-- Quick Stats Card --}}
                        <div class="stat-card" style="margin-bottom: 28px;">
                            <h3
                                style="font-size: 1rem; font-weight: 700; color: var(--ink); margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-chart-simple" style="color: var(--purple);"></i> Student Progress
                            </h3>

                            <div style="margin-bottom: 24px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                    <span style="font-size: 0.8rem; color: var(--muted);">Completion Rate</span>
                                    <span style="font-weight: 700; color: var(--purple); font-size: 0.9rem;">
                                        {{ $totalStudents > 0 ? round(($completedCount / $totalStudents) * 100) : 0 }}%
                                    </span>
                                </div>
                                <div class="progress-bar-custom">
                                    <div class="progress-fill"
                                        style="width: {{ $totalStudents > 0 ? ($completedCount / $totalStudents) * 100 : 0 }}%">
                                    </div>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-top: 12px;">
                                    <span style="font-size: 0.7rem; color: var(--muted);">
                                        <i class="fas fa-check-circle" style="color: var(--success);"></i>
                                        {{ $completedCount }} completed
                                    </span>
                                    <span style="font-size: 0.7rem; color: var(--muted);">
                                        <i class="fas fa-users"></i> {{ $totalStudents }} enrolled
                                    </span>
                                </div>
                            </div>

                            <div
                                style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; padding-top: 16px; border-top: 1px solid var(--border);">
                                <div>
                                    <div style="font-size: 0.7rem; color: var(--muted); margin-bottom: 6px;">
                                        <i class="fas fa-hourglass-half"></i> Duration
                                    </div>
                                    <div style="font-weight: 700; color: var(--ink); font-size: 1rem;">
                                        {{ $lesson->duration ?? '—' }} min
                                    </div>
                                </div>
                                <div>
                                    <div style="font-size: 0.7rem; color: var(--muted); margin-bottom: 6px;">
                                        <i class="fas fa-sort-numeric-down"></i> Lesson Order
                                    </div>
                                    <div style="font-weight: 700; color: var(--ink); font-size: 1rem;">
                                        #{{ $lesson->lesson_order ?? '—' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Lesson Type Card --}}
                        <div class="stat-card" style="margin-bottom: 28px;">
                            <h3
                                style="font-size: 1rem; font-weight: 700; color: var(--ink); margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-tag" style="color: var(--purple);"></i> Lesson Type
                            </h3>
                            <div class="type-badge">
                                @php
                                    $typeIcons = [
                                        'video' => 'fa-video',
                                        'audio' => 'fa-headphones',
                                        'pdf' => 'fa-file-pdf',
                                        'text' => 'fa-file-alt',
                                        'mixed' => 'fa-layer-group'
                                    ];
                                    $icon = $typeIcons[$lesson->lesson_type] ?? 'fa-file';
                                    $typeLabels = [
                                        'video' => 'Video Lesson',
                                        'audio' => 'Audio Lesson',
                                        'pdf' => 'PDF Document',
                                        'text' => 'Text Lesson',
                                        'mixed' => 'Mixed Media'
                                    ];
                                    $label = $typeLabels[$lesson->lesson_type] ?? ucfirst($lesson->lesson_type);
                                @endphp
                                <i class="fas {{ $icon }}" style="color: var(--purple); font-size: 1.1rem;"></i>
                                <span style="font-weight: 600; color: var(--ink);">{{ $label }}</span>
                            </div>
                        </div>

                        {{-- Navigation Between Lessons --}}
                        <div class="stat-card" style="margin-bottom: 28px;">
                            <h3
                                style="font-size: 1rem; font-weight: 700; color: var(--ink); margin-bottom: 18px; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-arrows-left-right" style="color: var(--purple);"></i> Navigate
                            </h3>
                            <div style="display: flex; gap: 12px;">
                                @if($prevLesson)
                                    <a href="{{ route('teacher.lessons.show', $prevLesson) }}" class="nav-button"
                                        style="flex: 1; justify-content: center;">
                                        <i class="fas fa-arrow-left"></i> Previous
                                    </a>
                                @else
                                    <button class="nav-button"
                                        style="flex: 1; justify-content: center; opacity: 0.4; cursor: not-allowed;" disabled>
                                        <i class="fas fa-arrow-left"></i> Previous
                                    </button>
                                @endif

                                @if($nextLesson)
                                    <a href="{{ route('teacher.lessons.show', $nextLesson) }}" class="nav-button"
                                        style="flex: 1; justify-content: center;">
                                        Next <i class="fas fa-arrow-right"></i>
                                    </a>
                                @else
                                    <button class="nav-button"
                                        style="flex: 1; justify-content: center; opacity: 0.4; cursor: not-allowed;" disabled>
                                        Next <i class="fas fa-arrow-right"></i>
                                    </button>
                                @endif
                            </div>
                        </div>

                        {{-- Topic & Class Details --}}
                        <div class="stat-card">
                            <h3
                                style="font-size: 1rem; font-weight: 700; color: var(--ink); margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-diagram-project" style="color: var(--purple);"></i> Topic & Class
                            </h3>

                            <div class="info-row">
                                <div class="info-label">Topic:</div>
                                <div class="info-value">{{ $lesson->topic->title ?? 'N/A' }}</div>
                            </div>
                            @if($lesson->topic->title_arabic)
                                <div class="info-row">
                                    <div class="info-label">Topic (Arabic):</div>
                                    <div class="info-value" style="direction: rtl; font-family: 'Amiri', serif;">
                                        {{ $lesson->topic->title_arabic }}
                                    </div>
                                </div>
                            @endif
                            <div class="info-row">
                                <div class="info-label">Class:</div>
                                <div class="info-value">{{ $lesson->topic->class->name ?? 'N/A' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Subject:</div>
                                <div class="info-value">{{ $lesson->topic->subject->name ?? 'N/A' }}</div>
                            </div>
                            @if(isset($lesson->topic->class->level))
                                <div class="info-row">
                                    <div class="info-label">Level:</div>
                                    <div class="info-value">
                                        {{ $lesson->topic->class->level->name ?? 'N/A' }}
                                        @if($lesson->topic->class->level->code)
                                            <span
                                                style="font-size: 0.7rem; color: var(--muted);">({{ $lesson->topic->class->level->code }})</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if($lesson->topic->description)
                                <div class="info-row" style="border-bottom: none;">
                                    <div class="info-label">Topic Desc:</div>
                                    <div class="info-value">{{ Str::limit($lesson->topic->description, 80) }}</div>
                                </div>
                            @endif
                        </div>

                        {{-- Student Progress Details --}}
                        <div class="stat-card" style="margin-top: 28px;">
                            <h3
                                style="font-size: 1rem; font-weight: 700; color: var(--ink); margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-users" style="color: var(--purple);"></i> Student Progress Details
                            </h3>

                            <div style="margin-bottom: 20px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <span style="font-size: 0.8rem; color: var(--muted);">Completion Rate</span>
                                    <span style="font-weight: 700; color: var(--purple); font-size: 0.9rem;">
                                        {{ $totalStudents > 0 ? round(($completedCount / $totalStudents) * 100) : 0 }}%
                                    </span>
                                </div>
                                <div class="progress-bar-custom">
                                    <div class="progress-fill"
                                        style="width: {{ $totalStudents > 0 ? ($completedCount / $totalStudents) * 100 : 0 }}%">
                                    </div>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-top: 12px;">
                                    <span style="font-size: 0.7rem; color: var(--muted);">
                                        <i class="fas fa-check-circle" style="color: var(--green);"></i>
                                        {{ $completedCount }} completed
                                    </span>
                                    <span style="font-size: 0.7rem; color: var(--muted);">
                                        <i class="fas fa-users"></i> {{ $totalStudents }} enrolled
                                    </span>
                                </div>
                            </div>

                            @if(isset($recentCompletions) && $recentCompletions->count() > 0)
                                <div style="margin-top: 20px; padding-top: 16px; border-top: 1px solid var(--border);">
                                    <h4 style="font-size: 0.85rem; font-weight: 700; color: var(--ink); margin-bottom: 12px;">
                                        <i class="fas fa-clock"></i> Recent Completions
                                    </h4>
                                    <div style="display: flex; flex-direction: column; gap: 10px;">
                                        @foreach($recentCompletions as $completion)
                                            <div
                                                style="display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid var(--border);">
                                                <div
                                                    style="width: 32px; height: 32px; background: linear-gradient(135deg, var(--green-light) 0%, var(--green) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                                                    <i class="fas fa-check fa-xs"></i>
                                                </div>
                                                <div style="flex: 1;">
                                                    <div style="font-weight: 600; font-size: 0.8rem; color: var(--ink);">
                                                        {{ $completion->student->name ?? 'Student' }}
                                                    </div>
                                                    <div style="font-size: 0.65rem; color: var(--muted);">
                                                        Completed {{ $completion->completed_at->diffForHumans() }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <button onclick="viewAllStudentsProgress({{ $lesson->id }})" class="nav-button"
                                style="width: 100%; justify-content: center; margin-top: 16px;">
                                <i class="fas fa-list"></i> View All Students Progress
                            </button>
                        </div>

                        {{-- Lesson Quiz Section --}}
                        <div class="stat-card" style="margin-top: 28px;">
                            <h3
                                style="font-size: 1rem; font-weight: 700; color: var(--ink); margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-question-circle" style="color: var(--purple);"></i> Lesson Quiz
                            </h3>

                            <div id="lessonQuizContainer">
                                <div class="resource-loading" style="padding: 20px;">
                                    <div class="resource-spinner"></div>
                                    <p>Loading quiz...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Resource Preview Modal --}}
    <div id="resourceModal" class="resource-modal-overlay" style="display: none;">
        <div class="resource-modal-container">
            <div class="resource-modal-header">
                <div class="resource-modal-header-content">
                    <div class="resource-modal-icon">
                        <i id="modalResourceIcon" class="fas fa-file"></i>
                    </div>
                    <div>
                        <h3 class="resource-modal-title" id="modalResourceTitle">Resource Preview</h3>
                        <p class="resource-modal-subtitle" id="modalResourceType">Loading...</p>
                    </div>
                </div>
                <button class="resource-modal-close" onclick="closeResourceModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="resource-modal-body">
                <div id="resourcePreviewContent">
                    <div class="resource-loading">
                        <div class="resource-spinner"></div>
                        <p>Loading content...</p>
                    </div>
                </div>
            </div>

            <div class="resource-modal-footer">
                <a href="#" id="downloadResourceBtn" class="resource-download-btn" download>
                    <i class="fas fa-download"></i> Download
                </a>
                <button class="resource-close-btn" onclick="closeResourceModal()">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>

    <script>
        function copyLessonLink() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                alert('Lesson link copied to clipboard!');
            }).catch(() => {
                alert('Failed to copy link.');
            });
        }
    </script>

    <script>
        // Quiz functionality
        let currentQuiz = null;
        let currentQuizResults = null;

        function loadLessonQuiz() {
            const lessonId = {{ $lesson->id }};
            const container = document.getElementById('lessonQuizContainer');

            fetch(`/teacher/exams/lesson/${lessonId}/quizzes`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.quizzes.length > 0) {
                        renderQuizzes(data.quizzes, container, 'lesson');
                    } else {
                        container.innerHTML = `
                    <div style="text-align: center; padding: 30px;">
                        <i class="fas fa-file-alt fa-2x" style="color: var(--muted); margin-bottom: 12px;"></i>
                        <p style="color: var(--muted); font-size: 0.85rem;">No quiz available for this lesson yet.</p>
                        @if($lesson->teacher_id == session('LoggedTeacher'))
                            <button onclick="createLessonQuiz()" class="nav-button" style="margin-top: 12px;">
                                <i class="fas fa-plus"></i> Create Quiz
                            </button>
                        @endif
                    </div>
                `;
                    }
                })
                .catch(error => {
                    console.error('Error loading quiz:', error);
                    container.innerHTML = `<p style="color: var(--red);">Failed to load quiz.</p>`;
                });
        }

        function renderQuizzes(quizzes, container, type) {
            let html = '';

            quizzes.forEach(quiz => {
                const hasResult = quiz.results && quiz.results.length > 0;
                const lastResult = hasResult ? quiz.results[0] : null;
                const canRetake = !hasResult || (quiz.max_attempts > quiz.results.length);

                html += `
                <div style="background: var(--cream); border-radius: 16px; padding: 16px; margin-bottom: 16px;">
                    <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 10px;">
                        <div>
                            <h4 style="font-weight: 700; color: var(--ink); margin-bottom: 6px;">${quiz.title}</h4>
                            <div style="display: flex; gap: 12px; flex-wrap: wrap; font-size: 0.75rem; color: var(--muted);">
                                <span><i class="fas fa-star"></i> Total: ${quiz.total_marks} marks</span>
                                <span><i class="fas fa-check-circle"></i> Pass: ${quiz.pass_mark}%</span>
                                ${quiz.duration_minutes ? `<span><i class="fas fa-clock"></i> ${quiz.duration_minutes} min</span>` : ''}
                            </div>
                        </div>
                        ${hasResult ? `
                            <div style="text-align: right;">
                                ${lastResult.is_passed ?
                            '<span style="background: var(--green-light); color: var(--green); padding: 4px 12px; border-radius: 20px; font-size: 0.7rem;"><i class="fas fa-trophy"></i> Passed</span>' :
                            '<span style="background: var(--red-light); color: var(--red); padding: 4px 12px; border-radius: 20px; font-size: 0.7rem;"><i class="fas fa-times"></i> Failed</span>'
                        }
                                <div style="font-size: 0.7rem; margin-top: 4px;">Score: ${lastResult.percentage}% (Attempt ${lastResult.attempt_number})</div>
                            </div>
                        ` : ''}
                    </div>

                    ${hasResult ? `
                        <div style="margin-top: 12px;">
                            <div class="progress-bar-custom" style="height: 4px;">
                                <div class="progress-fill" style="width: ${lastResult.percentage}%;"></div>
                            </div>
                        </div>
                    ` : ''}

                    <div style="display: flex; gap: 10px; margin-top: 16px;">
                        ${!hasResult || canRetake ? `
                            <button onclick="startQuiz(${quiz.id})" class="nav-button" style="padding: 8px 20px;">
                                <i class="fas fa-play"></i> ${hasResult ? 'Retake Quiz' : 'Take Quiz'}
                            </button>
                        ` : `
                            <button disabled class="nav-button" style="opacity: 0.5; cursor: not-allowed;">
                                <i class="fas fa-lock"></i> Max Attempts Reached
                            </button>
                        `}

                        ${hasResult ? `
                            <button onclick="viewQuizResults(${quiz.id})" class="btn-secondary" style="padding: 8px 20px;">
                                <i class="fas fa-chart-line"></i> View Results
                            </button>
                        ` : ''}
                    </div>
                </div>
            `;
            });

            container.innerHTML = html;
        }

        function createLessonQuiz() {
            window.location.href = `/teacher/exams/create-lesson-quiz/{{ $lesson->id }}`;
        }

        function startQuiz(examId) {
            // Open quiz in modal
            const modal = document.getElementById('quizModal');
            const container = document.getElementById('quizContainer');

            modal.style.display = 'flex';
            container.innerHTML = `
            <div class="resource-loading">
                <div class="resource-spinner"></div>
                <p>Loading quiz...</p>
            </div>
        `;

            fetch(`/teacher/exams/${examId}/take`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(response => response.text())
                .then(html => {
                    container.innerHTML = html;
                    attachQuizSubmitHandler(examId);
                    startQuizTimer();
                })
                .catch(error => {
                    container.innerHTML = `<p style="color: var(--red);">Failed to load quiz. Please try again.</p>`;
                });
        }

        function attachQuizSubmitHandler(examId) {
            const form = document.getElementById('quizForm');
            if (form) {
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    const formData = new FormData(form);
                    const answers = [];

                    // Collect answers
                    document.querySelectorAll('[name^="answers"]').forEach(input => {
                        const questionId = input.name.match(/\d+/)[0];
                        answers.push({
                            question_id: questionId,
                            answer: input.value
                        });
                    });

                    const timeSpent = calculateTimeSpent();

                    Swal.fire({
                        title: 'Submitting Quiz...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    const response = await fetch(`/teacher/exams/${examId}/submit`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            answers: answers,
                            time_spent: timeSpent,
                            student_id: {{ session('LoggedStudent') ?? 'null' }}
                    })
                    });

                    const data = await response.json();

                    if (data.success) {
                        Swal.fire({
                            icon: data.result.is_passed ? 'success' : 'warning',
                            title: data.result.is_passed ? 'Quiz Passed!' : 'Quiz Completed',
                            html: `
                            <div style="text-align: center;">
                                <p style="font-size: 1.2rem; font-weight: bold;">${data.result.percentage}%</p>
                                <p>Score: ${data.result.score}/${data.result.total_marks}</p>
                                <p>Attempt: ${data.result.attempt_number} of ${data.result.max_attempts}</p>
                                ${!data.result.is_passed && data.result.attempt_number < data.result.max_attempts ?
                                    '<p style="color: var(--warning);">You can retake this quiz.</p>' : ''}
                            </div>
                        `,
                            confirmButtonColor: '#7c3aed'
                        }).then(() => {
                            closeQuizModal();
                            loadLessonQuiz();
                        });
                    } else {
                        Swal.fire('Error', data.message || 'Failed to submit quiz', 'error');
                    }
                });
            }
        }

        let quizStartTime = Date.now();

        function startQuizTimer() {
            quizStartTime = Date.now();
        }

        function calculateTimeSpent() {
            return Math.floor((Date.now() - quizStartTime) / 1000);
        }

        function viewQuizResults(examId) {
            const modal = document.getElementById('quizResultsModal');
            const container = document.getElementById('quizResultsContainer');

            modal.style.display = 'flex';
            container.innerHTML = `
            <div class="resource-loading">
                <div class="resource-spinner"></div>
                <p>Loading results...</p>
            </div>
        `;

            fetch(`/teacher/exams/${examId}/results`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderQuizResults(data, container);
                    } else {
                        container.innerHTML = `<p>Failed to load results.</p>`;
                    }
                });
        }

        function renderQuizResults(data, container) {
            let html = `
            <div style="margin-bottom: 20px;">
                <h4 style="font-weight: 700; margin-bottom: 10px;">${data.exam.title}</h4>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; text-align: center;">
        `;

            data.results.forEach(result => {
                html += `
                <div style="background: var(--cream2); border-radius: 12px; padding: 12px;">
                    <div style="font-size: 0.7rem; color: var(--muted);">Attempt ${result.attempt_number}</div>
                    <div style="font-size: 1.2rem; font-weight: 700; ${result.is_passed ? 'color: var(--green);' : 'color: var(--red);'}">${result.percentage}%</div>
                    <div style="font-size: 0.7rem;">${result.score}/${data.exam.total_marks}</div>
                    <div style="font-size: 0.65rem; margin-top: 5px;">${new Date(result.created_at).toLocaleDateString()}</div>
                </div>
            `;
            });

            html += `
                </div>
            </div>
        `;

            container.innerHTML = html;
        }

        function closeQuizModal() {
            document.getElementById('quizModal').style.display = 'none';
        }

        function closeQuizResultsModal() {
            document.getElementById('quizResultsModal').style.display = 'none';
        }

        // Load quiz on page load
        document.addEventListener('DOMContentLoaded', function () {
            loadLessonQuiz();
        });
    </script>

    {{-- Student Progress Modal --}}
    <div id="studentsProgressModal" class="resource-modal-overlay" style="display: none;">
        <div class="resource-modal-container" style="max-width: 800px;">
            <div class="resource-modal-header">
                <div class="resource-modal-header-content">
                    <div class="resource-modal-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h3 class="resource-modal-title">Student Progress</h3>
                        <p class="resource-modal-subtitle" id="progressModalSubtitle">Loading...</p>
                    </div>
                </div>
                <button class="resource-modal-close" onclick="closeStudentsProgressModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="resource-modal-body">
                <div id="studentsProgressContent">
                    <div class="resource-loading">
                        <div class="resource-spinner"></div>
                        <p>Loading student progress...</p>
                    </div>
                </div>
            </div>

            <div class="resource-modal-footer">
                <button class="resource-close-btn" onclick="closeStudentsProgressModal()">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>

    <script>
        // Replace the entire student progress modal script section with this:

        function viewAllStudentsProgress(lessonId) {
            const modal = document.getElementById('studentsProgressModal');
            const subtitle = document.getElementById('progressModalSubtitle');
            const content = document.getElementById('studentsProgressContent');

            modal.style.display = 'flex';
            subtitle.textContent = 'Loading student data...';

            content.innerHTML = `
                <div class="resource-loading">
                    <div class="resource-spinner"></div>
                    <p>Loading student progress...</p>
                </div>
            `;

            fetch(`/teacher/lessons/progress/lesson/${lessonId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        content.innerHTML = `
                        <div class="resource-pdf-fallback">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p>${data.message || 'Failed to load student progress.'}</p>
                        </div>
                    `;
                        return;
                    }

                    if (!data.students || data.students.length === 0) {
                        content.innerHTML = `
                        <div class="resource-pdf-fallback">
                            <i class="fas fa-users"></i>
                            <p>No students found for this lesson.</p>
                            <p style="font-size: 0.8rem; margin-top: 8px;">Students need to be enrolled in the class first.</p>
                        </div>
                    `;
                        subtitle.textContent = `0 of 0 students completed`;
                        return;
                    }

                    subtitle.textContent = `${data.completed_count} of ${data.total_students} students completed`;

                    const percent = data.total_students > 0
                        ? Math.round((data.completed_count / data.total_students) * 100)
                        : 0;

                    let html = `
                    <div style="margin-bottom: 20px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="font-size: 0.8rem; color: var(--muted);">Overall Completion</span>
                            <span style="font-weight: 700; color: var(--purple);">${percent}%</span>
                        </div>
                        <div class="progress-bar-custom">
                            <div class="progress-fill" style="width: ${percent}%"></div>
                        </div>
                    </div>

                    <div style="margin-top: 20px; max-height: 400px; overflow-y: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: var(--cream2);">
                                    <th style="padding: 12px; text-align: left;">Student</th>
                                    <th style="padding: 12px; text-align: left;">Status</th>
                                    <th style="padding: 12px; text-align: left;">Time Spent</th>
                                    <th style="padding: 12px; text-align: left;">Completed</th>
                                </tr>
                            </thead>
                            <tbody>
                `;

                    data.students.forEach(item => {
                        const status = item.progress.status;
                        let statusBadge = '';
                        let statusIcon = '';

                        switch (status) {
                            case 'completed':
                                statusBadge = 'badge-status-published';
                                statusIcon = 'fa-check-circle';
                                break;
                            case 'in_progress':
                                statusBadge = 'badge-status-draft';
                                statusIcon = 'fa-hourglass-half';
                                break;
                            default:
                                statusBadge = 'badge-status-archived';
                                statusIcon = 'fa-circle';
                        }

                        const timeSpent = item.progress.time_spent_seconds || 0;
                        const minutes = Math.floor(timeSpent / 60);
                        const seconds = timeSpent % 60;
                        const timeDisplay = timeSpent > 0 ? `${minutes}m ${seconds}s` : '—';

                        const studentName = item.student.name || 'Student';
                        const initial = studentName.charAt(0).toUpperCase();

                        html += `
                        <tr style="border-bottom: 1px solid var(--border);">
                            <td style="padding: 12px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 32px; height: 32px; background: linear-gradient(135deg, var(--purple-light) 0%, var(--purple) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                                        ${initial}
                                    </div>
                                    <div style="font-weight: 500; font-size: 0.85rem;">
                                        ${studentName}
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 12px;">
                                <span class="badge-modern ${statusBadge}" style="display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fas ${statusIcon}"></i>
                                    ${status.replace('_', ' ').toUpperCase()}
                                </span>
                            </td>
                            <td style="padding: 12px; font-size: 0.8rem;">
                                ${timeDisplay}
                            </td>
                            <td style="padding: 12px;">
                                ${item.progress.completed_at
                                ? `<span style="font-size: 0.7rem; color: var(--muted);">
                                            ${new Date(item.progress.completed_at).toLocaleDateString()}
                                        </span>`
                                : '—'}
                            </td>
                        </tr>
                    `;
                    });

                    html += `
                            </tbody>
                        </table>
                    </div>
                `;

                    content.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error:', error);
                    content.innerHTML = `
                    <div class="resource-pdf-fallback">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>Error loading student progress. Please try again.</p>
                        <p style="font-size: 0.8rem; margin-top: 8px;">${error.message}</p>
                    </div>
                `;
                });
        }

        // FIXED: Close modal function - make sure it's globally accessible
        window.closeStudentsProgressModal = function () {
            const modal = document.getElementById('studentsProgressModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }

        // Close modal on overlay click
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('studentsProgressModal');
            if (modal) {
                modal.addEventListener('click', function (e) {
                    if (e.target === this) {
                        window.closeStudentsProgressModal();
                    }
                });
            }

            // Close modal with Escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    const modal = document.getElementById('studentsProgressModal');
                    if (modal && modal.style.display === 'flex') {
                        window.closeStudentsProgressModal();
                    }
                }
            });
        });
    </script>

    {{-- Quiz Taking Modal --}}
<div id="quizModal" class="resource-modal-overlay" style="display: none;">
    <div class="resource-modal-container" style="max-width: 800px; max-height: 85vh;">
        <div class="resource-modal-header">
            <div class="resource-modal-header-content">
                <div class="resource-modal-icon">
                    <i class="fas fa-pen"></i>
                </div>
                <div>
                    <h3 class="resource-modal-title">Take Quiz</h3>
                    <p class="resource-modal-subtitle">Answer all questions to complete</p>
                </div>
            </div>
            <button class="resource-modal-close" onclick="closeQuizModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="resource-modal-body" style="max-height: 65vh; overflow-y: auto;">
            <div id="quizContainer">
                <div class="resource-loading">
                    <div class="resource-spinner"></div>
                    <p>Loading quiz...</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Quiz Results Modal --}}
<div id="quizResultsModal" class="resource-modal-overlay" style="display: none;">
    <div class="resource-modal-container" style="max-width: 600px;">
        <div class="resource-modal-header">
            <div class="resource-modal-header-content">
                <div class="resource-modal-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div>
                    <h3 class="resource-modal-title">Quiz Results</h3>
                    <p class="resource-modal-subtitle">Your attempt history</p>
                </div>
            </div>
            <button class="resource-modal-close" onclick="closeQuizResultsModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="resource-modal-body">
            <div id="quizResultsContainer">
                <div class="resource-loading">
                    <div class="resource-spinner"></div>
                    <p>Loading results...</p>
                </div>
            </div>
        </div>
        
        <div class="resource-modal-footer">
            <button class="resource-close-btn" onclick="closeQuizResultsModal()">
                <i class="fas fa-times"></i> Close
            </button>
        </div>
    </div>
</div>
@endsection


@section('js')
    <script>
        // Add a little entrance delay for sidebar items
        document.addEventListener('DOMContentLoaded', function () {
            const rightCol = document.querySelector('.animate-in:last-child');
            if (rightCol) {
                rightCol.style.animationDelay = '0.15s';
            }
        });
    </script>

    <script>
        // Resource Preview Function
        function previewResource(resourceId, title, type, fileUrl) {
            const modal = document.getElementById('resourceModal');
            const modalTitle = document.getElementById('modalResourceTitle');
            const modalType = document.getElementById('modalResourceType');
            const modalIcon = document.getElementById('modalResourceIcon');
            const previewContent = document.getElementById('resourcePreviewContent');
            const downloadBtn = document.getElementById('downloadResourceBtn');

            // Set modal header
            modalTitle.textContent = title;
            modalType.textContent = type.toUpperCase();

            // Set icon based on type
            const iconMap = {
                'video': 'fa-video',
                'audio': 'fa-headphones',
                'pdf': 'fa-file-pdf',
                'image': 'fa-image',
                'document': 'fa-file'
            };
            modalIcon.className = `fas ${iconMap[type] || 'fa-file'}`;

            // Set download link
            downloadBtn.href = fileUrl;

            // Show loading
            previewContent.innerHTML = `
                                                <div class="resource-loading">
                                                    <div class="resource-spinner"></div>
                                                    <p>Loading ${type}...</p>
                                                </div>
                                            `;

            modal.style.display = 'flex';

            // Load content based on type
            setTimeout(() => {
                let html = '';

                switch (type) {
                    case 'video':
                        html = `
                                                            <div class="resource-video-container">
                                                                <video controls autoplay>
                                                                    <source src="${fileUrl}" type="video/mp4">
                                                                    Your browser does not support the video tag.
                                                                </video>
                                                            </div>
                                                        `;
                        break;

                    case 'audio':
                        html = `
                                                            <div class="resource-audio-container">
                                                                <div class="resource-audio-icon">
                                                                    <i class="fas fa-headphones"></i>
                                                                </div>
                                                                <audio controls autoplay>
                                                                    <source src="${fileUrl}" type="audio/mpeg">
                                                                    Your browser does not support the audio element.
                                                                </audio>
                                                            </div>
                                                        `;
                        break;

                    case 'pdf':
                        // Check if browser supports PDF embedding
                        const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
                        if (isMobile) {
                            html = `
                                                                <div class="resource-pdf-fallback">
                                                                    <i class="fas fa-file-pdf"></i>
                                                                    <p>PDF preview not available on mobile devices.</p>
                                                                    <a href="${fileUrl}" download class="resource-download-btn" style="margin-top: 16px; display: inline-flex;">
                                                                        <i class="fas fa-download"></i> Download PDF
                                                                    </a>
                                                                </div>
                                                            `;
                        } else {
                            html = `
                                                                <div class="resource-pdf-container">
                                                                    <embed src="${fileUrl}#toolbar=1&navpanes=1&scrollbar=1" type="application/pdf" width="100%" height="100%">
                                                                </div>
                                                            `;
                        }
                        break;

                    case 'image':
                        html = `
                                                            <div class="resource-image-container">
                                                                <img src="${fileUrl}" alt="${title}" loading="lazy">
                                                            </div>
                                                        `;
                        break;

                    default:
                        html = `
                                                            <div class="resource-pdf-fallback">
                                                                <i class="fas fa-file"></i>
                                                                <p>Preview not available for this file type.</p>
                                                                <a href="${fileUrl}" download class="resource-download-btn" style="margin-top: 16px; display: inline-flex;">
                                                                    <i class="fas fa-download"></i> Download File
                                                                </a>
                                                            </div>
                                                        `;
                        break;
                }

                previewContent.innerHTML = html;
            }, 100);
        }

        function closeResourceModal() {
            const modal = document.getElementById('resourceModal');
            const previewContent = document.getElementById('resourcePreviewContent');

            // Stop any playing video/audio
            const video = previewContent.querySelector('video');
            const audio = previewContent.querySelector('audio');
            if (video) video.pause();
            if (audio) audio.pause();

            modal.style.display = 'none';
            previewContent.innerHTML = `
                                                <div class="resource-loading">
                                                    <div class="resource-spinner"></div>
                                                    <p>Loading content...</p>
                                                </div>
                                            `;
        }

        // Close modal on overlay click
        document.getElementById('resourceModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeResourceModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('resourceModal');
                if (modal.style.display === 'flex') {
                    closeResourceModal();
                }
            }
        });
    </script>
@endsection