@extends('Teacher.layouts.teacher-master')

@section('title', 'My Lessons')
@section('page-title', 'My Lessons')
@section('breadcrumb', 'Lessons')

@section('content')
    <style>
        /* Additional styles for lessons index page */
        .lessons-header-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-glow-card {
            background: white;
            border-radius: 24px;
            padding: 20px 24px;
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-glow-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--gradient);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .stat-glow-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(107, 70, 193, 0.1);
        }

        .stat-glow-card:hover::before {
            transform: scaleX(1);
        }

        .stat-icon-wrap {
            width: 52px;
            height: 52px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 16px;
        }

        .stat-number-main {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 800;
            color: var(--ink);
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-label-main {
            font-size: 0.8rem;
            color: var(--muted);
            font-weight: 500;
        }

        .card-modern {
            background: white;
            border-radius: 28px;
            border: 1px solid var(--border);
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .card-modern-header {
            padding: 24px 28px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            background: white;
        }

        .card-modern-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--ink);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-modern-subtitle {
            font-size: 0.8rem;
            color: var(--muted);
            margin-top: 4px;
        }

        .btn-primary-glow {
            background: var(--gradient);
            color: white;
            padding: 12px 26px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(107, 70, 193, 0.25);
        }

        .btn-primary-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(107, 70, 193, 0.35);
            color: white;
        }

        .data-table-modern {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table-modern thead th {
            text-align: left;
            padding: 18px 20px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: var(--muted);
            background: var(--cream2);
            border-bottom: 1px solid var(--border);
        }

        .data-table-modern tbody td {
            padding: 18px 20px;
            font-size: 0.85rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            transition: background 0.2s ease;
        }

        .data-table-modern tbody tr {
            transition: all 0.2s ease;
        }

        .data-table-modern tbody tr:hover {
            background: var(--cream);
        }

        .lesson-cell {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .lesson-icon {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--purple-light) 0%, var(--purple) 100%);
            color: white;
            box-shadow: 0 4px 10px rgba(107, 70, 193, 0.2);
        }

        .lesson-info h4 {
            font-weight: 700;
            color: var(--ink);
            font-size: 0.9rem;
            margin-bottom: 4px;
        }

        .lesson-info p {
            font-size: 0.7rem;
            color: var(--muted);
            line-height: 1.3;
        }

        .badge-modern {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .badge-type {
            background: var(--purple-light);
            color: var(--purple);
        }

        .badge-status-published {
            background: var(--green-light);
            color: var(--green);
        }

        .badge-status-draft {
            background: var(--gold-light);
            color: var(--gold);
        }

        .badge-status-archived {
            background: var(--red-light);
            color: var(--red);
        }

        .action-menu {
            position: relative;
            display: inline-block;
        }

        .action-trigger {
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 40px;
            padding: 8px 14px;
            cursor: pointer;
            transition: all 0.2s;
            color: var(--muted);
            font-size: 0.8rem;
        }

        .action-trigger:hover {
            background: var(--cream2);
            border-color: var(--purple);
            color: var(--purple);
        }

        .action-dropdown {
            position: absolute;
            right: 0;
            top: 120%;
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            min-width: 160px;
            z-index: 50;
            display: none;
            overflow: hidden;
        }

        .action-dropdown.open {
            display: block;
            animation: fadeSlideDown 0.2s ease;
        }

        @keyframes fadeSlideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .action-dropdown a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px;
            font-size: 0.8rem;
            color: var(--ink);
            text-decoration: none;
            transition: background 0.2s;
        }

        .action-dropdown a:hover {
            background: var(--cream2);
        }

        .action-dropdown a.danger {
            color: var(--red);
        }

        .pagination-modern {
            display: flex;
            justify-content: flex-end;
            margin-top: 28px;
        }

        .pagination-modern .pagination {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .pagination-modern .page-item {
            list-style: none;
        }

        .pagination-modern .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: white;
            border: 1px solid var(--border);
            color: var(--ink);
            text-decoration: none;
            font-size: 0.8rem;
            transition: all 0.2s;
        }

        .pagination-modern .page-link:hover {
            background: var(--purple-light);
            border-color: var(--purple);
            color: var(--purple);
        }

        .pagination-modern .active .page-link {
            background: var(--gradient);
            border-color: transparent;
            color: white;
        }

        .empty-state-modern {
            text-align: center;
            padding: 70px 40px;
        }

        .empty-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--purple-light) 0%, #FEE2E2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 2.5rem;
            color: var(--purple);
        }

        @media (max-width: 1000px) {
            .lessons-header-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .data-table-modern thead th {
                padding: 12px 12px;
            }

            .data-table-modern tbody td {
                padding: 12px 12px;
            }
        }

        @media (max-width: 800px) {
            .card-modern-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .lessons-header-stats {
                grid-template-columns: 1fr;
            }

            .data-table-modern thead {
                display: none;
            }

            .data-table-modern tbody tr {
                display: block;
                margin-bottom: 16px;
                border: 1px solid var(--border);
                border-radius: 20px;
                padding: 16px;
            }

            .data-table-modern tbody td {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 10px 0;
                border-bottom: 1px solid var(--border);
            }

            .data-table-modern tbody td:last-child {
                border-bottom: none;
            }

            .data-table-modern tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                font-size: 0.7rem;
                color: var(--muted);
                width: 90px;
            }

            .lesson-cell {
                flex-direction: column;
                text-align: center;
            }
        }

        /* ============================================
           EDIT LESSON MODAL - ENHANCED STYLES
           ============================================ */

        /* Modal Overlay Enhancement */
        .modal-overlay {
            background: rgba(26, 10, 46, 0.85);
            backdrop-filter: blur(8px);
        }

        /* Modal Container Redesign */
        .modal-container {
            background: var(--cream, #FDFBF7);
            border-radius: var(--radius-xl, 30px);
            border: 1px solid var(--border, rgba(107, 70, 193, 0.10));
            box-shadow: var(--shadow-lg, 0 16px 48px rgba(107, 70, 193, 0.15));
            overflow: hidden;
        }

        /* Modal Header Enhancement */
        .modal-header {
            background: linear-gradient(135deg, var(--cream2, #F7F3EE) 0%, var(--cream, #FDFBF7) 100%);
            border-bottom: 1px solid var(--border, rgba(107, 70, 193, 0.10));
            padding: 28px 32px;
        }

        .modal-icon {
            background: var(--gradient-soft, linear-gradient(135deg, #EDE9FA 0%, #FEE2E2 100%));
            width: 52px;
            height: 52px;
            border-radius: 18px;
            box-shadow: 0 4px 12px rgba(107, 70, 193, 0.12);
        }

        .modal-icon i {
            background: var(--gradient, linear-gradient(135deg, var(--purple) 0%, var(--red) 100%));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-size: 1.3rem;
        }

        .modal-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 700;
            background: var(--gradient, linear-gradient(135deg, var(--purple) 0%, var(--red) 100%));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .modal-subtitle {
            color: var(--muted2, #9892B0);
            font-size: 0.8rem;
        }

        .modal-close {
            background: white;
            border: 1px solid var(--border, rgba(107, 70, 193, 0.10));
            border-radius: 12px;
            transition: all 0.25s ease;
        }

        .modal-close:hover {
            background: var(--red-light, #FEE2E2);
            border-color: var(--red, #DC2626);
            color: var(--red, #DC2626);
            transform: rotate(90deg);
        }

        /* Modal Body */
        .modal-body {
            padding: 32px;
            background: var(--cream, #FDFBF7);
        }

        /* Form Sections */
        .form-section {
            margin-bottom: 32px;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--border, rgba(107, 70, 193, 0.10));
        }

        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .form-section-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--purple, #6B46C1);
            margin-bottom: 20px;
            padding-bottom: 8px;
            border-bottom: 2px solid var(--purple-light, #EDE9FA);
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .form-section-title i {
            font-size: 0.95rem;
            background: var(--gradient, linear-gradient(135deg, var(--purple) 0%, var(--red) 100%));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* Form Groups */
        .form-group label {
            color: var(--ink2, #3B2459);
            font-weight: 600;
            font-size: 0.8rem;
            margin-bottom: 8px;
        }

        .form-group .required {
            color: var(--red, #DC2626);
            font-weight: 700;
        }

        /* Form Controls Enhancement */
        .form-control {
            background: white;
            border: 1.5px solid var(--border, rgba(107, 70, 193, 0.10));
            border-radius: 14px;
            padding: 11px 16px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem;
            transition: all 0.25s ease;
        }

        .form-control:hover {
            border-color: var(--purple-mid, #7C55CC);
        }

        .form-control:focus {
            border-color: var(--purple, #6B46C1);
            box-shadow: 0 0 0 3px rgba(107, 70, 193, 0.15);
            outline: none;
        }

        select.form-control {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236B46C1' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            appearance: none;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 90px;
        }

        /* File Upload Area */
        .current-file-info {
            margin-bottom: 16px;
        }

        .file-info-card {
            background: linear-gradient(135deg, var(--green-light, #DCFCE7) 0%, #E8F9EF 100%);
            border: 1px solid rgba(22, 163, 74, 0.2);
            border-radius: 14px;
            padding: 12px 18px;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: var(--green, #16A34A);
            font-weight: 500;
        }

        .file-info-card i {
            font-size: 1.1rem;
        }

        .upload-area-small {
            background: var(--purple-xlight, #F5F3FD);
            border: 2px dashed var(--border2, rgba(107, 70, 193, 0.20));
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.25s ease;
            margin-top: 8px;
        }

        .upload-area-small:hover {
            border-color: var(--purple, #6B46C1);
            background: var(--purple-light, #EDE9FA);
            transform: translateY(-2px);
        }

        .upload-area-small i {
            color: var(--purple, #6B46C1);
            font-size: 1.2rem;
            margin-right: 8px;
        }

        .upload-area-small span {
            color: var(--muted, #6B6584);
            font-size: 0.85rem;
        }

        .file-alert {
            background: var(--purple-light, #EDE9FA);
            border-radius: 14px;
            padding: 12px 18px;
            margin-top: 14px;
            border: 1px solid var(--border2, rgba(107, 70, 193, 0.20));
        }

        .file-alert span {
            color: var(--purple, #6B46C1);
            font-weight: 500;
        }

        /* Form Row */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        /* Modal Footer */
        .modal-footer {
            padding: 24px 32px;
            background: linear-gradient(135deg, var(--cream2, #F7F3EE) 0%, var(--cream, #FDFBF7) 100%);
            border-top: 1px solid var(--border, rgba(107, 70, 193, 0.10));
            gap: 16px;
        }

        /* Buttons Enhancement */
        .btn-cancel {
            background: white;
            border: 1.5px solid var(--border2, rgba(107, 70, 193, 0.20));
            border-radius: 40px;
            padding: 12px 28px;
            color: var(--muted, #6B6584);
            font-weight: 600;
            transition: all 0.25s ease;
        }

        .btn-cancel:hover {
            background: var(--purple-xlight, #F5F3FD);
            border-color: var(--purple, #6B46C1);
            color: var(--purple, #6B46C1);
            transform: translateY(-2px);
        }

        .btn-save {
            background: var(--gradient, linear-gradient(135deg, var(--purple) 0%, var(--red) 100%));
            border: none;
            border-radius: 40px;
            padding: 12px 32px;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 14px rgba(107, 70, 193, 0.3);
            transition: all 0.25s ease;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(107, 70, 193, 0.4);
        }

        /* Loading State */
        .loading-state {
            padding: 60px 40px;
            text-align: center;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 3px solid var(--purple-light, #EDE9FA);
            border-top-color: var(--purple, #6B46C1);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .loading-state p {
            color: var(--muted, #6B6584);
            font-size: 0.9rem;
        }

        /* Small Text */
        small,
        .text-muted-sm {
            font-size: 0.7rem;
            color: var(--muted2, #9892B0);
            margin-top: 6px;
            display: block;
        }

        /* Inline styles for action dropdowns */
        .action-dropdown a {
            transition: all 0.2s ease;
        }

        .action-dropdown a:hover {
            background: var(--purple-light, #EDE9FA);
            padding-left: 22px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .modal-container {
                max-width: 95%;
            }

            .modal-header {
                padding: 20px 24px;
            }

            .modal-body {
                padding: 24px;
            }

            .modal-footer {
                padding: 20px 24px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .modal-icon {
                width: 44px;
                height: 44px;
            }

            .modal-title {
                font-size: 1.2rem;
            }
        }

        /* Custom scrollbar for modal */
        .modal-container::-webkit-scrollbar {
            width: 6px;
        }

        .modal-container::-webkit-scrollbar-track {
            background: var(--purple-light, #EDE9FA);
            border-radius: 10px;
        }

        .modal-container::-webkit-scrollbar-thumb {
            background: var(--gradient, linear-gradient(135deg, var(--purple) 0%, var(--red) 100%));
            border-radius: 10px;
        }

        .modal-container::-webkit-scrollbar-thumb:hover {
            background: var(--purple-dark, #4C2E8A);
        }
    </style>

    <div class="lessons-container">

        {{-- Animated Stats Row --}}
        <div class="lessons-header-stats">
            <div class="stat-glow-card">
                <div class="stat-icon-wrap" style="background: var(--purple-light); color: var(--purple);">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="stat-number-main">{{ $lessons->total() ?? 0 }}</div>
                <div class="stat-label-main">Total Lessons</div>
            </div>
            <div class="stat-glow-card">
                <div class="stat-icon-wrap" style="background: var(--green-light); color: var(--green);">
                    <i class="fas fa-globe"></i>
                </div>
                <div class="stat-number-main">{{ $lessons->where('status', 'published')->count() ?? 0 }}</div>
                <div class="stat-label-main">Published</div>
            </div>
            <div class="stat-glow-card">
                <div class="stat-icon-wrap" style="background: var(--gold-light); color: var(--gold);">
                    <i class="fas fa-pen-fancy"></i>
                </div>
                <div class="stat-number-main">{{ $lessons->where('status', 'draft')->count() ?? 0 }}</div>
                <div class="stat-label-main">Drafts</div>
            </div>
            <div class="stat-glow-card">
                <div class="stat-icon-wrap" style="background: linear-gradient(135deg, #E0E7FF, #C7D2FE); color: #4F46E5;">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="stat-number-main">{{ $lessons->groupBy('topic_id')->count() ?? 0 }}</div>
                <div class="stat-label-main">Topics Covered</div>
            </div>
        </div>

        {{-- Main Card Table --}}
        <div class="card-modern">
            <div class="card-modern-header">
                <div>
                    <div class="card-modern-title">
                        <i class="fas fa-graduation-cap" style="color: var(--purple);"></i>
                        All Lessons
                    </div>
                    <div class="card-modern-subtitle">Manage and organize your lesson content</div>
                </div>
                <div>
                    <a href="{{ route('teacher.lessons.create') }}" class="btn-primary-glow">
                        <i class="fas fa-plus-circle"></i> Create New Lesson
                    </a>
                </div>
            </div>

            <div class="card-body" style="padding: 0;">
                @if($lessons->count() > 0)
                    <div style="overflow-x: auto;">
                        <table class="data-table-modern">
                            <thead>
                                <tr>
                                    <th>Lesson</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Topic</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lessons as $lesson)
                                    <tr>
                                        <td data-label="Lesson">
                                            <div class="lesson-cell">
                                                <div class="lesson-icon">
                                                    <i
                                                        class="fas fa-{{ $lesson->lesson_type === 'video' ? 'video' : ($lesson->lesson_type === 'audio' ? 'headphones' : 'file-alt') }}"></i>
                                                </div>
                                                <div class="lesson-info">
                                                    <h4>{{ Str::limit($lesson->title, 45) }}</h4>
                                                    <p>{{ Str::limit($lesson->description, 55) }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="Class">
                                            <span style="font-weight: 500;">{{ $lesson->topic->class->name ?? 'N/A' }}</span>
                                        </td>
                                        <td data-label="Subject">
                                            {{ $lesson->topic->subject->name ?? 'N/A' }}
                                        </td>
                                        <td data-label="Topic">
                                            {{ Str::limit($lesson->topic->title ?? 'N/A', 25) }}
                                        </td>
                                        <td data-label="Type">
                                            <span class="badge-modern badge-type">
                                                <i
                                                    class="fas fa-{{ $lesson->lesson_type === 'video' ? 'video' : ($lesson->lesson_type === 'audio' ? 'headphones' : ($lesson->lesson_type === 'pdf' ? 'file-pdf' : 'file')) }}"></i>
                                                {{ ucfirst($lesson->lesson_type) }}
                                            </span>
                                        </td>
                                        <td data-label="Status">
                                            @if($lesson->status === 'published')
                                                <span class="badge-modern badge-status-published">
                                                    <i class="fas fa-check-circle"></i> Published
                                                </span>
                                            @elseif($lesson->status === 'draft')
                                                <span class="badge-modern badge-status-draft">
                                                    <i class="fas fa-edit"></i> Draft
                                                </span>
                                            @else
                                                <span class="badge-modern badge-status-archived">
                                                    <i class="fas fa-archive"></i> Archived
                                                </span>
                                            @endif
                                        </td>
                                        <td data-label="Created">
                                            <div style="display: flex; flex-direction: column;">
                                                <span>{{ $lesson->created_at->format('M d, Y') }}</span>
                                                <span
                                                    style="font-size: 0.65rem; color: var(--muted);">{{ $lesson->created_at->diffForHumans() }}</span>
                                            </div>
                                        </td>
                                        <td data-label="Actions">
                                            <div class="action-menu">
                                                <button class="action-trigger" onclick="toggleActionMenu(this)">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <div class="action-dropdown">
                                                    <a href="{{ route('teacher.lessons.show', $lesson) }}">
                                                        <i class="fas fa-eye"></i> View Details
                                                    </a>
                                                    <a href="#" onclick="event.preventDefault(); editLesson({{ $lesson->id }});">
                                                        <i class="fas fa-edit"></i> Edit Lesson
                                                    </a>
                                                    @if($lesson->status === 'published')
                                                        <a href="#"
                                                            onclick="event.preventDefault(); unpublishLesson({{ $lesson->id }});">
                                                            <i class="fas fa-arrow-down"></i> Unpublish
                                                        </a>
                                                    @else
                                                        <a href="#" onclick="event.preventDefault(); publishLesson({{ $lesson->id }});">
                                                            <i class="fas fa-check-circle"></i> Publish
                                                        </a>
                                                    @endif
                                                    <a href="#" class="danger"
                                                        onclick="event.preventDefault(); deleteLesson({{ $lesson->id }}, '{{ addslashes($lesson->title) }}');">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-modern">
                        {{ $lessons->links() }}
                    </div>
                @else
                    <div class="empty-state-modern">
                        <div class="empty-icon">
                            <i class="fas fa-chalkboard-user"></i>
                        </div>
                        <h3
                            style="font-family: 'Playfair Display', serif; font-size: 1.4rem; color: var(--ink); margin-bottom: 10px;">
                            No Lessons Yet</h3>
                        <p
                            style="color: var(--muted); margin-bottom: 28px; max-width: 380px; margin-left: auto; margin-right: auto;">
                            You haven't created any lessons. Start building engaging content for your students.
                        </p>
                        <a href="{{ route('teacher.lessons.create') }}" class="btn-primary-glow">
                            <i class="fas fa-plus-circle"></i> Create Your First Lesson
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Edit Lesson Modal --}}
    <div id="editLessonModal" class="modal-overlay" style="display: none;">
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-header-content">
                    <div class="modal-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div>
                        <h3 class="modal-title">Edit Lesson</h3>
                        <p class="modal-subtitle">Update your lesson details</p>
                    </div>
                </div>
                <button class="modal-close" onclick="closeEditModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="editLessonForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_lesson_id" name="lesson_id">

                <div class="modal-body">
                    <div class="loading-state" id="editLoadingState" style="display: none;">
                        <div class="spinner"></div>
                        <p>Loading lesson data...</p>
                    </div>

                    <div id="editFormContent" style="display: none;">
                        {{-- Class & Subject Section --}}
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-chalkboard"></i>
                                <span>Class & Subject</span>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Class <span class="required">*</span></label>
                                    <select id="edit_class_id" class="form-control" required>
                                        <option value="">-- Select Class --</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Subject <span class="required">*</span></label>
                                    <select id="edit_subject_id" class="form-control" required>
                                        <option value="">-- First select class --</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Topic Section --}}
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-layer-group"></i>
                                <span>Topic</span>
                            </div>
                            <div class="form-group">
                                <label>Topic <span class="required">*</span></label>
                                <select id="edit_topic_id" name="topic_id" class="form-control" required>
                                    <option value="">-- Select Topic --</option>
                                </select>
                            </div>
                        </div>

                        {{-- Lesson Details Section --}}
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-pencil-alt"></i>
                                <span>Lesson Details</span>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Lesson Title <span class="required">*</span></label>
                                    <input type="text" id="edit_title" name="title" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Lesson Title (Arabic)</label>
                                    <input type="text" id="edit_title_arabic" name="title_arabic" class="form-control">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Lesson Type <span class="required">*</span></label>
                                    <select id="edit_lesson_type" name="lesson_type" class="form-control" required>
                                        <option value="video">🎬 Video Lesson</option>
                                        <option value="audio">🎵 Audio Lesson</option>
                                        <option value="pdf">📄 PDF Notes</option>
                                        <option value="text">📝 Text Lesson</option>
                                        <option value="mixed">📚 Mixed Content</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Duration (minutes)</label>
                                    <input type="number" id="edit_duration" name="duration" class="form-control" min="1">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea id="edit_description" name="description" class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        {{-- Lesson Material Section --}}
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Lesson Material (Optional)</span>
                            </div>
                            <div class="current-file-info" id="currentFileInfo">
                                <div class="file-info-card">
                                    <i class="fas fa-file"></i>
                                    <span id="currentFileName"></span>
                                </div>
                            </div>
                            <div class="upload-area-small" id="editUploadArea"
                                onclick="document.getElementById('edit_lesson_file').click()">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Click to upload new file (optional)</span>
                                <input type="file" id="edit_lesson_file" name="lesson_file" style="display: none;"
                                    accept=".mp4,.mp3,.pdf">
                            </div>
                            <div id="editFileInfo" style="display: none;">
                                <div class="file-alert">
                                    <span><i class="fas fa-file"></i> <span id="editFileName"></span></span>
                                    <button type="button" class="file-alert-close"
                                        onclick="clearEditFile()">&times;</button>
                                </div>
                            </div>
                        </div>

                        {{-- Additional Settings Section --}}
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-cog"></i>
                                <span>Additional Settings</span>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Lesson Order</label>
                                    <input type="number" id="edit_lesson_order" name="lesson_order" class="form-control"
                                        min="1">
                                    <small>Leave empty for auto order</small>
                                </div>
                                <div class="form-group">
                                    <label>Amount (UGX)</label>
                                    <input type="text" id="edit_lesson_amount" name="lesson_amount" class="form-control"
                                        placeholder="e.g., 15,000" required>
                                </div>
                                <div class="form-group">
                                    <label>Status <span class="required">*</span></label>
                                    <select id="edit_status" name="status" class="form-control" required>
                                        <option value="draft">📝 Draft</option>
                                        <option value="published">✅ Published</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Teacher Notes (Private)</label>
                                <textarea id="edit_notes" name="notes" class="form-control" rows="2"></textarea>
                                <small>Only visible to teachers</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeEditModal()">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn-save btn-primary-glow">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(26, 22, 40, 0.8);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-y: auto;
            padding: 20px;
        }

        .modal-container {
            background: white;
            border-radius: 28px;
            max-width: 800px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            animation: modalSlideIn 0.3s ease;
            box-shadow: 0 20px 60px rgba(91, 63, 217, 0.3);
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-30px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-header {
            padding: 24px 28px;
            border-bottom: 1.5px solid var(--c-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--c-surface2);
            border-radius: 28px 28px 0 0;
        }

        .modal-header-content {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .modal-icon {
            width: 48px;
            height: 48px;
            background: var(--c-accent-lt);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--c-accent);
            font-size: 1.3rem;
        }

        .modal-title {
            font-family: 'DM Serif Display', serif;
            font-size: 1.3rem;
            font-weight: 400;
            color: var(--c-ink);
            margin: 0;
        }

        .modal-subtitle {
            font-size: 0.75rem;
            color: var(--c-muted);
            margin: 4px 0 0;
        }

        .modal-close {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            border: 1.5px solid var(--c-border);
            background: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--c-muted);
            transition: all 0.2s;
        }

        .modal-close:hover {
            background: var(--c-red-lt);
            border-color: var(--c-red);
            color: var(--c-red);
        }

        .modal-body {
            padding: 28px;
        }

        .modal-footer {
            padding: 20px 28px;
            border-top: 1.5px solid var(--c-border);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            background: var(--c-surface2);
            border-radius: 0 0 28px 28px;
        }

        .form-section {
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--c-border);
        }

        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .form-section-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--c-accent);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            margin-bottom: 16px;
        }

        .form-group {
            margin-bottom: 0;
        }

        .form-group label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--c-ink);
            margin-bottom: 6px;
        }

        .form-group .required {
            color: var(--c-red);
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--c-border);
            border-radius: 12px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--c-accent);
            box-shadow: 0 0 0 3px rgba(91, 63, 217, 0.1);
        }

        textarea.form-control {
            resize: vertical;
        }

        .upload-area-small {
            background: var(--c-surface2);
            border: 2px dashed var(--c-border);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 12px;
        }

        .upload-area-small:hover {
            border-color: var(--c-accent);
            background: var(--c-accent-lt);
        }

        .current-file-info {
            margin-bottom: 12px;
        }

        .file-info-card {
            background: var(--c-green-lt);
            border-radius: 12px;
            padding: 10px 14px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--c-emerald);
            font-size: 0.85rem;
        }

        .btn-cancel {
            padding: 10px 24px;
            border-radius: 40px;
            border: 1.5px solid var(--c-border);
            background: #DC2626;
            color: #FFF;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-cancel:hover {
            background: #DC2626;
            border-color: #FFF;
        }

        .btn-save {
            padding: 10px 28px;
            border-radius: 40px;
            border: none;
            background: #4930C2;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-save:hover {
            background: #4930C2;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(91, 63, 217, 0.3);
        }

        .loading-state {
            text-align: center;
            padding: 40px;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 3px solid var(--c-border);
            border-top-color: var(--c-accent);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto 16px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        small {
            font-size: 0.7rem;
            color: var(--c-muted);
            display: block;
            margin-top: 4px;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .modal-container {
                max-width: 95%;
            }

            .modal-header {
                padding: 18px 20px;
            }

            .modal-body {
                padding: 20px;
            }
        }
    </style>

    <script>
        let editSelectedFile = null;

        // Edit Lesson Function
        function editLesson(lessonId) {
            const modal = document.getElementById('editLessonModal');
            const loadingState = document.getElementById('editLoadingState');
            const formContent = document.getElementById('editFormContent');

            modal.style.display = 'flex';
            loadingState.style.display = 'block';
            formContent.style.display = 'none';

            // Fetch lesson data
            fetch(`/teacher/lessons/${lessonId}/edit`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        populateEditForm(data);
                        loadingState.style.display = 'none';
                        formContent.style.display = 'block';
                    } else {
                        Swal.fire('Error', data.message || 'Failed to load lesson data', 'error');
                        closeEditModal();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Failed to load lesson data', 'error');
                    closeEditModal();
                });
        }

        function populateEditForm(data) {
            const lesson = data.lesson;
            document.getElementById('edit_lesson_id').value = lesson.id;
            document.getElementById('edit_title').value = lesson.title;
            document.getElementById('edit_title_arabic').value = lesson.title_arabic || '';
            document.getElementById('edit_description').value = lesson.description || '';
            document.getElementById('edit_notes').value = lesson.notes || '';
            document.getElementById('edit_lesson_type').value = lesson.lesson_type;
            document.getElementById('edit_duration').value = lesson.duration || '';
            document.getElementById('edit_lesson_order').value = lesson.lesson_order || '';
            document.getElementById('edit_lesson_amount').value = lesson.lesson_amount || '';
            document.getElementById('edit_status').value = lesson.status;

            // Show current file
            if (lesson.resources && lesson.resources.length > 0) {
                const resource = lesson.resources[0];
                document.getElementById('currentFileName').textContent = resource.title;
                document.getElementById('currentFileInfo').style.display = 'block';
            } else {
                document.getElementById('currentFileInfo').style.display = 'none';
            }

            // Populate classes dropdown
            const classSelect = document.getElementById('edit_class_id');
            classSelect.innerHTML = '<option value="">-- Select Class --</option>';
            data.classes.forEach(cls => {
                const option = document.createElement('option');
                option.value = cls.id;
                option.textContent = `${cls.name} (${cls.level?.section?.name || ''} - ${cls.level?.name || ''})`;
                if (cls.id == data.current_class_id) option.selected = true;
                classSelect.appendChild(option);
            });

            // Populate subjects dropdown
            const subjectSelect = document.getElementById('edit_subject_id');
            subjectSelect.innerHTML = '<option value="">-- Select Subject --</option>';
            data.subjects.forEach(subj => {
                const option = document.createElement('option');
                option.value = subj.id;
                option.textContent = `${subj.name} (${subj.code || ''})`;
                if (subj.id == data.current_subject_id) option.selected = true;
                subjectSelect.appendChild(option);
            });

            // Populate topics dropdown
            const topicSelect = document.getElementById('edit_topic_id');
            topicSelect.innerHTML = '<option value="">-- Select Topic --</option>';
            data.topics.forEach(topic => {
                const option = document.createElement('option');
                option.value = topic.id;
                option.textContent = topic.title;
                if (topic.id == data.current_topic_id) option.selected = true;
                topicSelect.appendChild(option);
            });

            // Add event listeners for dynamic filtering
            setupEditEventListeners();
        }

        function setupEditEventListeners() {
            const classSelect = document.getElementById('edit_class_id');
            const subjectSelect = document.getElementById('edit_subject_id');
            const topicSelect = document.getElementById('edit_topic_id');

            // Remove old listeners and add new ones
            classSelect.removeEventListener('change', handleEditClassChange);
            classSelect.addEventListener('change', handleEditClassChange);

            subjectSelect.removeEventListener('change', handleEditSubjectChange);
            subjectSelect.addEventListener('change', handleEditSubjectChange);
        }

        async function handleEditClassChange() {
            const classId = this.value;
            const subjectSelect = document.getElementById('edit_subject_id');
            const topicSelect = document.getElementById('edit_topic_id');

            subjectSelect.innerHTML = '<option value="">Loading subjects...</option>';
            topicSelect.innerHTML = '<option value="">-- Select Topic --</option>';

            if (!classId) {
                subjectSelect.innerHTML = '<option value="">-- Select Subject --</option>';
                return;
            }

            try {
                const response = await fetch(`/teacher/lessons/classes/${classId}/subjects`);
                const data = await response.json();

                subjectSelect.innerHTML = '<option value="">-- Select Subject --</option>';
                if (data.subjects && data.subjects.length > 0) {
                    data.subjects.forEach(subject => {
                        const option = document.createElement('option');
                        option.value = subject.id;
                        option.textContent = `${subject.name} (${subject.code || ''})`;
                        subjectSelect.appendChild(option);
                    });
                } else {
                    subjectSelect.innerHTML += '<option value="" disabled>No subjects available</option>';
                }
            } catch (error) {
                console.error('Error loading subjects:', error);
            }
        }

        async function handleEditSubjectChange() {
            const subjectId = this.value;
            const classId = document.getElementById('edit_class_id').value;
            const topicSelect = document.getElementById('edit_topic_id');

            topicSelect.innerHTML = '<option value="">Loading topics...</option>';

            if (!subjectId || !classId) {
                topicSelect.innerHTML = '<option value="">-- Select Topic --</option>';
                return;
            }

            try {
                const response = await fetch(`/teacher/lessons/classes/${classId}/subjects/${subjectId}/topics`);
                const data = await response.json();

                topicSelect.innerHTML = '<option value="">-- Select Topic --</option>';
                if (data.topics && data.topics.length > 0) {
                    data.topics.forEach(topic => {
                        const option = document.createElement('option');
                        option.value = topic.id;
                        option.textContent = topic.title;
                        topicSelect.appendChild(option);
                    });
                } else {
                    topicSelect.innerHTML += '<option value="" disabled>No topics available</option>';
                }
            } catch (error) {
                console.error('Error loading topics:', error);
            }
        }

        // Handle edit form submission
        document.getElementById('editLessonForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const lessonId = document.getElementById('edit_lesson_id').value;
            const formData = new FormData(this);

            const submitBtn = document.querySelector('#editLessonForm .btn-save');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            submitBtn.disabled = true;

            try {
                const response = await fetch(`/teacher/lessons/${lessonId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    body: formData
                });

                // 🔥 THIS is the key part
                if (!response.ok) {
                    const errorText = await response.text();
                    document.body.innerHTML = errorText;
                    return;
                }

                const data = await response.json();

                if (data.success) {
                    Swal.fire('Success!', data.message, 'success').then(() => {
                        location.reload();
                    });
                    closeEditModal();
                } else {
                    if (data.errors) {
                        const errors = Object.values(data.errors).flat().join('\n');
                        Swal.fire('Validation Error', errors, 'error');
                    } else {
                        Swal.fire('Error', data.message || 'Failed to update lesson', 'error');
                    }
                }

            } catch (error) {
                console.error('Error:', error);

                // fallback if it's a real JS/network error
                document.body.innerHTML = `<pre>${error}</pre>`;
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });

        // Publish/Unpublish functions
        function publishLesson(lessonId) {
            Swal.fire({
                title: 'Publish Lesson?',
                text: 'This lesson will be visible to students.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10B981',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, publish it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Publishing...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch(`/teacher/lessons/${lessonId}/publish`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Published!', data.message, 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error', data.message, 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Error', 'Failed to publish lesson', 'error');
                        });
                }
            });
        }

        function unpublishLesson(lessonId) {
            Swal.fire({
                title: 'Unpublish Lesson?',
                text: 'This lesson will be hidden from students.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#F59E0B',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, unpublish it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Unpublishing...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch(`/teacher/lessons/${lessonId}/unpublish`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Unpublished!', data.message, 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error', data.message, 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Error', 'Failed to unpublish lesson', 'error');
                        });
                }
            });
        }

        // Delete Lesson Function
        function deleteLesson(lessonId, lessonTitle) {
            Swal.fire({
                title: 'Delete Lesson?',
                html: `Are you sure you want to delete "<strong>${lessonTitle}</strong>"?<br>This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DC2626',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Deleting...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch(`/teacher/lessons/${lessonId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Deleted!', data.message, 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error', data.message, 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Error', 'Failed to delete lesson', 'error');
                        });
                }
            });
        }

        // File handling for edit modal
        document.getElementById('edit_lesson_file').addEventListener('change', function () {
            if (this.files && this.files[0]) {
                editSelectedFile = this.files[0];
                if (editSelectedFile.size > 50 * 1024 * 1024) {
                    Swal.fire('Error', 'File size exceeds 50MB limit', 'error');
                    this.value = '';
                    editSelectedFile = null;
                    document.getElementById('editFileInfo').style.display = 'none';
                    return;
                }
                const fileSizeMB = (editSelectedFile.size / (1024 * 1024)).toFixed(2);
                document.getElementById('editFileName').textContent = `${editSelectedFile.name} (${fileSizeMB} MB)`;
                document.getElementById('editFileInfo').style.display = 'block';
                document.getElementById('currentFileInfo').style.display = 'none';
            }
        });

        function clearEditFile() {
            editSelectedFile = null;
            document.getElementById('edit_lesson_file').value = '';
            document.getElementById('editFileInfo').style.display = 'none';
            document.getElementById('currentFileInfo').style.display = 'block';
        }

        function closeEditModal() {
            document.getElementById('editLessonModal').style.display = 'none';
            document.getElementById('editLessonForm').reset();
            document.getElementById('editFileInfo').style.display = 'none';
            editSelectedFile = null;
        }

        // Update the action dropdown links in your table
        // Replace the existing action dropdown HTML with these updated links

        // For Edit link:
        // <a href="#" onclick="event.preventDefault(); editLesson({{ $lesson->id }});">
        //     <i class="fas fa-edit"></i> Edit Lesson
        // </a>

        // For Publish/Unpublish:
        // @if($lesson->status === 'published')
            //     <a href="#" onclick="event.preventDefault(); unpublishLesson({{ $lesson->id }});">
            //         <i class="fas fa-arrow-down"></i> Unpublish
            //     </a>
        // @else
            //     <a href="#" onclick="event.preventDefault(); publishLesson({{ $lesson->id }});">
            //         <i class="fas fa-check-circle"></i> Publish
            //     </a>
        // @endif

        // For Delete:
        // <a href="#" class="danger" onclick="event.preventDefault(); deleteLesson({{ $lesson->id }}, '{{ addslashes($lesson->title) }}');">
        //     <i class="fas fa-trash-alt"></i> Delete
        // </a>
    </script>

    <script>
        function toggleActionMenu(btn) {
            event.stopPropagation();
            const dropdown = btn.nextElementSibling;
            const isOpen = dropdown.classList.contains('open');

            // Close all other open dropdowns
            document.querySelectorAll('.action-dropdown.open').forEach(d => {
                if (d !== dropdown) d.classList.remove('open');
            });

            if (isOpen) {
                dropdown.classList.remove('open');
            } else {
                dropdown.classList.add('open');
            }
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function () {
            document.querySelectorAll('.action-dropdown.open').forEach(d => {
                d.classList.remove('open');
            });
        });
    </script>
@endsection

@section('js')
    <script>
        // Add entrance animations
        document.addEventListener('DOMContentLoaded', function () {
            const cards = document.querySelectorAll('.stat-glow-card, .card-modern');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = `opacity 0.4s ease ${index * 0.1}s, transform 0.4s ease ${index * 0.1}s`;
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 50);
            });
        });
    </script>
@endsection