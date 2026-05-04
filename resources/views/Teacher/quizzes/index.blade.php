@extends('Teacher.layouts.teacher-master')

@section('title', 'Quiz Management')
@section('page-title', 'Quiz Management')
@section('breadcrumb', 'Quizzes')

@section('content')
    <style>
        :root {
            --c-bg: #F0EEF8;
            --c-surface: #FFFFFF;
            --c-surface2: #F7F6FB;
            --c-border: #E3E0F0;
            --c-ink: #1A1628;
            --c-muted: #7C748E;
            --c-accent: #5B3FD9;
            --c-accent-lt: #EAE6FF;
            --c-indigo: #4F46E5;
            --c-pink: #D946A8;
            --c-emerald: #059669;
            --c-amber: #D97706;
            --c-red: #DC2626;
            --c-red-lt: #FEE2E2;
            --c-green-lt: #D1FAE5;
            --c-blue: #3B82F6;
            --c-blue-lt: #DBEAFE;
            --c-gold: #D97706;
            --c-gold-lt: #FEF3C7;
            --radius-lg: 18px;
            --radius-xl: 24px;
            --radius-pill: 999px;
            --shadow-sm: 0 1px 3px rgba(91, 63, 217, .07), 0 1px 2px rgba(0, 0, 0, .04);
            --shadow-md: 0 4px 16px rgba(91, 63, 217, .10), 0 2px 6px rgba(0, 0, 0, .05);
            --shadow-lg: 0 12px 40px rgba(91, 63, 217, .14), 0 4px 12px rgba(0, 0, 0, .06);
            --gradient: linear-gradient(135deg, #5B3FD9 0%, #8B5CF6 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--c-bg);
            font-family: 'DM Sans', sans-serif;
        }

        .qz-wrap {
            width: 100%;
            font-family: 'DM Sans', sans-serif;
            color: var(--c-ink);
        }

        /* Page Header */
        .qz-page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 32px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .qz-page-eyebrow {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--c-accent);
            margin-bottom: 6px;
        }

        .qz-page-title {
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: 2rem;
            font-weight: 400;
            color: var(--c-ink);
            line-height: 1.15;
            margin: 0;
        }

        .qz-page-title em {
            font-style: italic;
            color: var(--c-accent);
        }

        .qz-page-subtitle {
            margin-top: 6px;
            font-size: .83rem;
            color: var(--c-muted);
            font-weight: 400;
        }

        /* Stats Grid */
        .qz-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }

        .qz-stat-card {
            background: var(--c-surface);
            border: 1.5px solid var(--c-border);
            border-radius: var(--radius-lg);
            padding: 20px;
            transition: all .22s ease;
            cursor: default;
        }

        .qz-stat-card:hover {
            transform: translateY(-2px);
            border-color: var(--c-accent);
            box-shadow: var(--shadow-md);
        }

        .qz-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-bottom: 16px;
        }

        .qz-stat-number {
            font-family: 'DM Serif Display', serif;
            font-size: 1.8rem;
            font-weight: 400;
            color: var(--c-ink);
            line-height: 1.1;
        }

        .qz-stat-label {
            font-size: .73rem;
            font-weight: 600;
            color: var(--c-muted);
            margin-top: 6px;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        /* Main Cards */
        .qz-card {
            background: var(--c-surface);
            border: 1.5px solid var(--c-border);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            margin-bottom: 32px;
        }

        .qz-card-head {
            padding: 22px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            border-bottom: 1.5px solid var(--c-border);
            background: var(--c-surface2);
        }

        .qz-card-label {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .qz-card-icon {
            width: 34px;
            height: 34px;
            background: var(--c-accent-lt);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--c-accent);
            font-size: .9rem;
            flex-shrink: 0;
        }

        .qz-card-title {
            font-family: 'DM Serif Display', serif;
            font-size: 1.15rem;
            font-weight: 400;
            color: var(--c-ink);
            margin: 0;
        }

        .qz-card-sub {
            font-size: .76rem;
            color: var(--c-muted);
            margin-top: 1px;
        }

        .qz-card-body {
            padding: 0;
        }

        /* Buttons */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--c-accent);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: .82rem;
            font-weight: 600;
            padding: 9px 20px;
            border-radius: var(--radius-pill);
            border: none;
            cursor: pointer;
            transition: background .2s, box-shadow .2s, transform .15s;
            letter-spacing: .02em;
            text-decoration: none;
        }

        .btn-primary:hover {
            background: #4930C2;
            box-shadow: 0 6px 20px rgba(91, 63, 217, .32);
            transform: translateY(-1px);
            color: white;
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            border-radius: var(--radius-pill);
            border: 1.5px solid var(--c-border);
            background: var(--c-surface);
            color: var(--c-muted);
            font-family: 'DM Sans', sans-serif;
            font-size: .72rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s, border-color .15s;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: var(--c-surface2);
            border-color: var(--c-muted);
        }

        /* Dropdown */
        .qz-dropdown {
            position: relative;
            display: inline-block;
        }

        .qz-dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: var(--c-surface);
            border: 1.5px solid var(--c-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            min-width: 200px;
            z-index: 100;
            margin-top: 8px;
            overflow: hidden;
        }

        .qz-dropdown-menu a {
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            color: var(--c-ink);
            transition: background 0.2s;
            font-size: .82rem;
            font-weight: 500;
        }

        .qz-dropdown-menu a:hover {
            background: var(--c-accent-lt);
            color: var(--c-accent);
        }

        .qz-dropdown-menu i {
            width: 24px;
            color: var(--c-accent);
        }

        /* Table */
        .qz-table-wrap {
            overflow-x: auto;
        }

        .qz-table {
            width: 100%;
            border-collapse: collapse;
        }

        .qz-table thead th {
            text-align: left;
            padding: 13px 20px;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .09em;
            text-transform: uppercase;
            color: var(--c-muted);
            background: var(--c-surface2);
            border-bottom: 1.5px solid var(--c-border);
            white-space: nowrap;
        }

        .qz-table tbody td {
            padding: 14px 20px;
            font-size: .84rem;
            color: var(--c-ink);
            border-bottom: 1px solid var(--c-border);
            vertical-align: middle;
        }

        .qz-table tbody tr:last-child td {
            border-bottom: none;
        }

        .qz-table tbody tr {
            transition: background .15s;
        }

        .qz-table tbody tr:hover {
            background: var(--c-surface2);
        }

        /* Badges */
        .qz-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 11px;
            border-radius: var(--radius-pill);
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .03em;
            text-transform: capitalize;
        }

        .qz-badge .dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
        }

        .qz-badge-published {
            background: var(--c-green-lt);
            color: var(--c-emerald);
        }

        .qz-badge-published .dot {
            background: var(--c-emerald);
        }

        .qz-badge-draft {
            background: var(--c-gold-lt);
            color: var(--c-gold);
        }

        .qz-badge-draft .dot {
            background: var(--c-gold);
        }

        .qz-badge-closed {
            background: var(--c-red-lt);
            color: var(--c-red);
        }

        .qz-badge-closed .dot {
            background: var(--c-red);
        }

        /* Action Buttons */
        .qz-actions {
            display: flex;
            gap: 6px;
        }

        .qz-icon-btn {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            border: 1.5px solid var(--c-border);
            background: var(--c-surface);
            color: var(--c-muted);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            transition: all .18s;
            text-decoration: none;
        }

        .qz-icon-btn:hover {
            border-color: var(--c-accent);
            color: var(--c-accent);
            background: var(--c-accent-lt);
        }

        .qz-icon-btn.danger:hover {
            border-color: var(--c-red);
            color: var(--c-red);
            background: var(--c-red-lt);
        }

        /* Empty State */
        .qz-empty {
            text-align: center;
            padding: 72px 40px;
        }

        .qz-empty-ring {
            width: 72px;
            height: 72px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: var(--c-surface2);
            border: 2px dashed var(--c-border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            color: var(--c-muted);
        }

        /* Responsive */
        @media (max-width: 1000px) {
            .qz-stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }
        }

        @media (max-width: 768px) {
            .qz-stats-grid {
                grid-template-columns: 1fr;
            }

            .qz-page-title {
                font-size: 1.5rem;
            }

            .qz-card-head {
                padding: 16px 20px;
            }

            .qz-card-body {
                padding: 0;
            }

            .qz-table thead {
                display: none;
            }

            .qz-table tbody tr {
                display: block;
                border: 1.5px solid var(--c-border);
                border-radius: var(--radius-lg);
                margin-bottom: 12px;
                padding: 8px 0;
            }

            .qz-table tbody td {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 10px 16px;
                border-bottom: 1px solid var(--c-border);
            }

            .qz-table tbody td:last-child {
                border-bottom: none;
            }

            .qz-table tbody td::before {
                content: attr(data-label);
                font-size: .7rem;
                font-weight: 700;
                color: var(--c-muted);
                min-width: 100px;
            }
        }
    </style>

    <div class="qz-wrap">
        {{-- Page Header --}}
        <div class="qz-page-header">
            <div>
                <div class="qz-page-eyebrow"><i class="fas fa-tasks"></i> Assessment Management</div>
                <h1 class="qz-page-title">Quiz <em>Management</em></h1>
                <div class="qz-page-subtitle">Create and manage quizzes for your lessons and classes</div>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="qz-stats-grid">
            <div class="qz-stat-card">
                <div class="qz-stat-icon" style="background: var(--c-accent-lt); color: var(--c-accent);">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="qz-stat-number">{{ $lessonQuizzes->count() + $classQuizzes->count() }}</div>
                <div class="qz-stat-label">Total Quizzes</div>
            </div>
            <div class="qz-stat-card">
                <div class="qz-stat-icon" style="background: var(--c-green-lt); color: var(--c-emerald);">
                    <i class="fas fa-book"></i>
                </div>
                <div class="qz-stat-number">{{ $lessonQuizzes->count() }}</div>
                <div class="qz-stat-label">Lesson Quizzes</div>
            </div>
            <div class="qz-stat-card">
                <div class="qz-stat-icon" style="background: var(--c-blue-lt); color: var(--c-blue);">
                    <i class="fas fa-chalkboard"></i>
                </div>
                <div class="qz-stat-number">{{ $classQuizzes->count() }}</div>
                <div class="qz-stat-label">Class Quizzes</div>
            </div>
            <div class="qz-stat-card">
                <div class="qz-stat-icon" style="background: var(--c-gold-lt); color: var(--c-gold);">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="qz-stat-number">
                    {{ $lessonQuizzes->where('status', 'published')->count() + $classQuizzes->where('status', 'published')->count() }}
                </div>
                <div class="qz-stat-label">Published</div>
            </div>
        </div>

        {{-- Create Quiz Button --}}
        <div style="margin-bottom: 24px; display: flex; justify-content: flex-end;">
            <div class="qz-dropdown">
                <button class="btn-primary" onclick="toggleCreateDropdown()">
                    <i class="fas fa-plus-circle"></i> Create New Quiz
                    <i class="fas fa-chevron-down" style="margin-left: 8px; font-size: .7rem;"></i>
                </button>
                <div id="createDropdown" class="qz-dropdown-menu">
                    <a href="{{ route('teacher.quizzes.create', ['type' => 'lesson']) }}">
                        <i class="fas fa-book-open"></i> Lesson Quiz
                    </a>
                    <a href="{{ route('teacher.quizzes.create', ['type' => 'class']) }}">
                        <i class="fas fa-chalkboard"></i> Class Quiz
                    </a>
                </div>
            </div>
        </div>

        {{-- Lesson Quizzes Section --}}
        <div class="qz-card">
            <div class="qz-card-head">
                <div class="qz-card-label">
                    <div class="qz-card-icon"><i class="fas fa-book-open"></i></div>
                    <div>
                        <div class="qz-card-title">Lesson Quizzes</div>
                        <div class="qz-card-sub">Quizzes attached to specific lessons</div>
                    </div>
                </div>
            </div>

            <div class="qz-card-body">
                <div class="qz-table-wrap">
                    @if($lessonQuizzes->count() > 0)
                        <table class="qz-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Lesson</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Total Marks</th>
                                    <th>Pass Mark</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lessonQuizzes as $quiz)
                                    <tr>
                                        <td data-label="Title">
                                            <strong>{{ $quiz->title }}</strong>
                                        </td>
                                        <td data-label="Lesson">{{ $quiz->lesson->title ?? 'N/A' }}</td>
                                        <td data-label="Class">{{ $quiz->class->name ?? 'N/A' }}</td>
                                        <td data-label="Subject">{{ $quiz->subject->name ?? 'N/A' }}</td>
                                        <td data-label="Total Marks">{{ $quiz->total_marks }}</td>
                                        <td data-label="Pass Mark">{{ $quiz->pass_mark }}%</td>
                                        <td data-label="Status">
                                            <span class="qz-badge qz-badge-{{ $quiz->status }}">
                                                <span class="dot"></span>{{ ucfirst($quiz->status) }}
                                            </span>
                                        </td>
                                        <td data-label="Actions">
                                            <div class="qz-actions">
                                                <a href="{{ route('teacher.quizzes.add-questions', $quiz->id) }}" class="qz-icon-btn"
                                                    title="Add Questions">
                                                    <i class="fas fa-plus-circle"></i>
                                                </a>
                                                <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" class="qz-icon-btn" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('teacher.quizzes.statistics', $quiz->id) }}" class="qz-icon-btn"
                                                    title="Statistics">
                                                    <i class="fas fa-chart-line"></i>
                                                </a>
                                                <button onclick="deleteQuiz({{ $quiz->id }})" class="qz-icon-btn danger" title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="qz-empty">
                            <div class="qz-empty-ring"><i class="fas fa-file-alt"></i></div>
                            <p>No lesson quizzes created yet.</p>
                            <a href="{{ route('teacher.quizzes.create', ['type' => 'lesson']) }}" class="btn-primary" style="margin-top: 16px;">
                                <i class="fas fa-plus"></i> Create Lesson Quiz
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Class Quizzes Section --}}
        <div class="qz-card">
            <div class="qz-card-head">
                <div class="qz-card-label">
                    <div class="qz-card-icon"><i class="fas fa-chalkboard"></i></div>
                    <div>
                        <div class="qz-card-title">Class Quizzes (General)</div>
                        <div class="qz-card-sub">General quizzes for entire classes</div>
                    </div>
                </div>
            </div>

            <div class="qz-card-body">
                <div class="qz-table-wrap">
                    @if($classQuizzes->count() > 0)
                        <table class="qz-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Total Marks</th>
                                    <th>Pass Mark</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($classQuizzes as $quiz)
                                    <tr>
                                        <td data-label="Title">
                                            <strong>{{ $quiz->title }}</strong>
                                        </td>
                                        <td data-label="Class">{{ $quiz->class->name ?? 'N/A' }}</td>
                                        <td data-label="Subject">{{ $quiz->subject->name ?? 'N/A' }}</td>
                                        <td data-label="Total Marks">{{ $quiz->total_marks }}</td>
                                        <td data-label="Pass Mark">{{ $quiz->pass_mark }}%</td>
                                        <td data-label="Status">
                                            <span class="qz-badge qz-badge-{{ $quiz->status }}">
                                                <span class="dot"></span>{{ ucfirst($quiz->status) }}
                                            </span>
                                        </td>
                                        <td data-label="Actions">
                                            <div class="qz-actions">
                                                <a href="{{ route('teacher.quizzes.add-questions', $quiz->id) }}" class="qz-icon-btn"
                                                    title="Add Questions">
                                                    <i class="fas fa-plus-circle"></i>
                                                </a>
                                                <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" class="qz-icon-btn" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('teacher.quizzes.statistics', $quiz->id) }}" class="qz-icon-btn"
                                                    title="Statistics">
                                                    <i class="fas fa-chart-line"></i>
                                                </a>
                                                <button onclick="deleteQuiz({{ $quiz->id }})" class="qz-icon-btn danger" title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="qz-empty">
                            <div class="qz-empty-ring"><i class="fas fa-chalkboard"></i></div>
                            <p>No class quizzes created yet.</p>
                            <a href="{{ route('teacher.quizzes.create', ['type' => 'class']) }}" class="btn-primary" style="margin-top: 16px;">
                                <i class="fas fa-plus"></i> Create Class Quiz
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleCreateDropdown() {
            const dropdown = document.getElementById('createDropdown');
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('createDropdown');
            const button = event.target.closest('.btn-primary');
            if (!button && dropdown) {
                dropdown.style.display = 'none';
            }
        });

        function deleteQuiz(quizId) {
            Swal.fire({
                title: 'Delete Quiz?',
                text: 'This will permanently delete the quiz and all its questions. This action cannot be undone.',
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
                        didOpen: () => Swal.showLoading()
                    });

                    fetch(`/teacher/quizzes/${quizId}`, {
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
                            Swal.fire('Error', 'Failed to delete quiz', 'error');
                        });
                }
            });
        }
    </script>
@endsection