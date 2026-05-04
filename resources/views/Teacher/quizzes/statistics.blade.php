@extends('Teacher.layouts.teacher-master')

@section('title', 'Quiz Statistics - ' . $exam->title)
@section('page-title', 'Quiz Statistics')
@section('breadcrumb', 'Quizzes')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
        --c-emerald: #059669;
        --c-green-lt: #D1FAE5;
        --c-red: #DC2626;
        --c-red-lt: #FEE2E2;
        --c-gold: #D97706;
        --c-gold-lt: #FEF3C7;
        --c-blue: #3B82F6;
        --c-blue-lt: #DBEAFE;
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

    .qz-stats-wrap {
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

    /* Action Buttons Top */
    .qz-action-buttons {
        display: flex;
        gap: 12px;
        margin-bottom: 28px;
        justify-content: flex-end;
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
        text-align: center;
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
        margin: 0 auto 12px;
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

    /* Info Card */
    .qz-info-card {
        background: var(--c-surface);
        border: 1.5px solid var(--c-border);
        border-radius: var(--radius-xl);
        overflow: hidden;
        margin-bottom: 32px;
        box-shadow: var(--shadow-sm);
    }

    .qz-info-head {
        padding: 18px 24px;
        background: var(--c-surface2);
        border-bottom: 1.5px solid var(--c-border);
    }

    .qz-info-title {
        font-family: 'DM Serif Display', serif;
        font-size: 1rem;
        font-weight: 400;
        color: var(--c-ink);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .qz-info-title i {
        color: var(--c-accent);
    }

    .qz-info-body {
        padding: 20px 24px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
    }

    .qz-info-item {
        display: flex;
        flex-direction: column;
    }

    .qz-info-label {
        font-size: .68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--c-muted);
        margin-bottom: 4px;
    }

    .qz-info-value {
        font-size: .9rem;
        font-weight: 600;
        color: var(--c-ink);
    }

    /* Results Card */
    .qz-results-card {
        background: var(--c-surface);
        border: 1.5px solid var(--c-border);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .qz-results-head {
        padding: 18px 24px;
        background: var(--c-surface2);
        border-bottom: 1.5px solid var(--c-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .qz-results-title {
        font-family: 'DM Serif Display', serif;
        font-size: 1rem;
        font-weight: 400;
        color: var(--c-ink);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .qz-results-title i {
        color: var(--c-accent);
    }

    .qz-results-badge {
        background: var(--c-accent-lt);
        color: var(--c-accent);
        padding: 4px 12px;
        border-radius: var(--radius-pill);
        font-size: .7rem;
        font-weight: 600;
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

    /* Result Badges */
    .qz-result-passed {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 11px;
        border-radius: var(--radius-pill);
        font-size: .7rem;
        font-weight: 700;
        background: var(--c-green-lt);
        color: var(--c-emerald);
    }

    .qz-result-failed {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 11px;
        border-radius: var(--radius-pill);
        font-size: .7rem;
        font-weight: 700;
        background: var(--c-red-lt);
        color: var(--c-red);
    }

    .qz-score-good {
        color: var(--c-emerald);
        font-weight: 700;
    }

    .qz-score-bad {
        color: var(--c-red);
        font-weight: 700;
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

    /* Back Button */
    .qz-back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--c-muted);
        text-decoration: none;
        font-size: .8rem;
        margin-bottom: 16px;
        transition: color .15s;
    }

    .qz-back-link:hover {
        color: var(--c-accent);
    }

    /* Responsive */
    @media (max-width: 1000px) {
        .qz-stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }
    }

    @media (max-width: 768px) {
        .qz-page-title {
            font-size: 1.5rem;
        }

        .qz-stats-grid {
            grid-template-columns: 1fr;
        }

        .qz-info-body {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .qz-results-head {
            flex-direction: column;
            align-items: flex-start;
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

        .qz-action-buttons {
            justify-content flex-start;
        }
    }
</style>

<div class="qz-stats-wrap">
    {{-- Back Link --}}
    <a href="{{ route('teacher.quizzes.index') }}" class="qz-back-link">
        <i class="fas fa-arrow-left"></i> Back to Quizzes
    </a>

    {{-- Page Header --}}
    <div class="qz-page-header">
        <div>
            <div class="qz-page-eyebrow"><i class="fas fa-chart-line"></i> Analytics</div>
            <h1 class="qz-page-title">Quiz <em>Statistics</em></h1>
            <div class="qz-page-subtitle">Performance insights for {{ $exam->title }}</div>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="qz-stats-grid">
        <div class="qz-stat-card">
            <div class="qz-stat-icon" style="background: var(--c-accent-lt); color: var(--c-accent);">
                <i class="fas fa-users"></i>
            </div>
            <div class="qz-stat-number">{{ $totalAttempts }}</div>
            <div class="qz-stat-label">Total Attempts</div>
        </div>
        <div class="qz-stat-card">
            <div class="qz-stat-icon" style="background: var(--c-green-lt); color: var(--c-emerald);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="qz-stat-number">{{ $completedAttempts }}</div>
            <div class="qz-stat-label">Completed</div>
        </div>
        <div class="qz-stat-card">
            <div class="qz-stat-icon" style="background: var(--c-blue-lt); color: var(--c-blue);">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="qz-stat-number">{{ $passedAttempts }}</div>
            <div class="qz-stat-label">Passed</div>
        </div>
        <div class="qz-stat-card">
            <div class="qz-stat-icon" style="background: var(--c-gold-lt); color: var(--c-gold);">
                <i class="fas fa-percent"></i>
            </div>
            <div class="qz-stat-number">{{ round($avgScore, 1) }}%</div>
            <div class="qz-stat-label">Average Score</div>
        </div>
    </div>

    {{-- Quiz Information Card --}}
    <div class="qz-info-card">
        <div class="qz-info-head">
            <div class="qz-info-title">
                <i class="fas fa-info-circle"></i>
                Quiz Information
            </div>
        </div>
        <div class="qz-info-body">
            <div class="qz-info-item">
                <span class="qz-info-label">Title</span>
                <span class="qz-info-value">{{ $exam->title }}</span>
            </div>
            <div class="qz-info-item">
                <span class="qz-info-label">Total Marks</span>
                <span class="qz-info-value">{{ $exam->total_marks }}</span>
            </div>
            <div class="qz-info-item">
                <span class="qz-info-label">Pass Mark</span>
                <span class="qz-info-value">{{ $exam->pass_mark }}%</span>
            </div>
            <div class="qz-info-item">
                <span class="qz-info-label">Questions</span>
                <span class="qz-info-value">{{ $exam->questions->count() }}</span>
            </div>
            <div class="qz-info-item">
                <span class="qz-info-label">Status</span>
                <span class="qz-info-value">
                    <span class="qz-badge qz-badge-{{ $exam->status }}" style="display: inline-flex; align-items: center; gap: 4px;">
                        <span class="dot"></span>{{ ucfirst($exam->status) }}
                    </span>
                </span>
            </div>
            @if($exam->class)
            <div class="qz-info-item">
                <span class="qz-info-label">Class</span>
                <span class="qz-info-value">{{ $exam->class->name ?? 'N/A' }}</span>
            </div>
            @endif
            @if($exam->subject)
            <div class="qz-info-item">
                <span class="qz-info-label">Subject</span>
                <span class="qz-info-value">{{ $exam->subject->name ?? 'N/A' }}</span>
            </div>
            @endif
        </div>
    </div>

    {{-- Student Results Card --}}
    <div class="qz-results-card">
        <div class="qz-results-head">
            <div class="qz-results-title">
                <i class="fas fa-user-graduate"></i>
                Student Results
            </div>
            <div class="qz-results-badge">
                <i class="fas fa-chart-simple"></i> {{ $exam->attempts->count() }} submissions
            </div>
        </div>

        <div class="qz-table-wrap">
            @if($exam->attempts->count() > 0)
                <table class="qz-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Score</th>
                            <th>Percentage</th>
                            <th>Result</th>
                            <th>Attempted On</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($exam->attempts->sortByDesc('created_at') as $attempt)
                            <tr>
                                <td data-label="Student">
                                    <i class="fas fa-user-circle" style="color: var(--c-accent); margin-right: 6px;"></i>
                                    {{ $attempt->student->name ?? 'Student' }}
                                </td>
                                <td data-label="Score">
                                    <span class="{{ ($attempt->marks_obtained ?? 0) >= ($exam->total_marks / 2) ? 'qz-score-good' : 'qz-score-bad' }}">
                                        {{ $attempt->marks_obtained ?? 0 }}/{{ $exam->total_marks }}
                                    </span>
                                </td>
                                <td data-label="Percentage">{{ round($attempt->percentage ?? 0, 1) }}%</td>
                                <td data-label="Result">
                                    @if($attempt->is_passed)
                                        <span class="qz-result-passed">
                                            <i class="fas fa-check-circle"></i> Passed
                                        </span>
                                    @else
                                        <span class="qz-result-failed">
                                            <i class="fas fa-times-circle"></i> Failed
                                        </span>
                                    @endif
                                </td>
                                <td data-label="Attempted On">
                                    <i class="far fa-calendar-alt" style="color: var(--c-muted); margin-right: 4px;"></i>
                                    {{ $attempt->created_at->format('M d, Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="qz-empty">
                    <div class="qz-empty-ring">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <p>No attempts yet for this quiz.</p>
                    <p style="font-size: .75rem; color: var(--c-muted); margin-top: 8px;">
                        Once students take the quiz, their results will appear here.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
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

    .qz-badge-draft {
        background: var(--c-gold-lt);
        color: var(--c-gold);
    }

    .qz-badge-draft .dot {
        background: var(--c-gold);
    }

    .qz-badge-published {
        background: var(--c-green-lt);
        color: var(--c-emerald);
    }

    .qz-badge-published .dot {
        background: var(--c-emerald);
    }

    .qz-badge-closed {
        background: var(--c-red-lt);
        color: var(--c-red);
    }

    .qz-badge-closed .dot {
        background: var(--c-red);
    }
</style>
@endpush
@endsection