@extends('Student.layouts.sidebar')

@section('main-content')
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        :root {
            --accent: #6B46C1;
            --accent-lt: #EDE9FA;
            --gold: #D97706;
            --gold-lt: #FEF3C7;
            --green: #059669;
            --green-lt: #D1FAE5;
            --red: #DC2626;
            --red-lt: #FEE2E2;
            --ink: #1A0A2E;
            --muted: #6B6584;
            --border: #E3E0F0;
            --surface: #fff;
            --bg: #F5F3FD;
            --radius: 18px;
            --shadow: 0 4px 20px rgba(107, 70, 193, .10);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .rc-wrap {
            font-family: 'DM Sans', sans-serif;
            color: var(--ink);
            padding: 0 30px 60px;
        }

        .rc-header {
            padding-top: 2em;
            margin-bottom: 32px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: 16px;
        }

        .rc-eyebrow {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 6px;
        }

        .rc-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 800;
            color: var(--ink);
        }

        .rc-title em {
            font-style: italic;
            color: var(--accent);
        }

        .rc-subtitle {
            color: var(--muted);
            font-size: .84rem;
            margin-top: 6px;
        }

        /* Grid */
        .rc-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 24px;
        }

        .rc-card {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all .25s;
        }

        .rc-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(107, 70, 193, .15);
            border-color: var(--accent);
        }

        .rc-card-banner {
            background: linear-gradient(135deg, #6B46C1 0%, #4C2E8A 60%, #D97706 100%);
            padding: 20px 22px 16px;
            position: relative;
            overflow: hidden;
        }

        .rc-card-banner::after {
            content: '📊';
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 3rem;
            opacity: .2;
        }

        .rc-card-type {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .75);
            margin-bottom: 6px;
        }

        .rc-card-class {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: #fff;
        }

        .rc-card-body {
            padding: 20px 22px;
        }

        .rc-card-meta {
            font-size: .75rem;
            color: var(--muted);
            margin-bottom: 16px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .rc-card-meta span {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .rc-score-row {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 16px;
            padding: 14px 16px;
            background: var(--bg);
            border-radius: 12px;
        }

        .rc-score-num {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--accent);
            line-height: 1;
        }

        .rc-score-sub {
            font-size: .68rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .05em;
            margin-top: 3px;
        }

        .rc-pill-row {
            display: flex;
            gap: 10px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .rc-pill {
            padding: 5px 14px;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .rc-pill-green {
            background: var(--green-lt);
            color: var(--green);
        }

        .rc-pill-gold {
            background: var(--gold-lt);
            color: var(--gold);
        }

        .rc-pill-purple {
            background: var(--accent-lt);
            color: var(--accent);
        }

        .rc-pill-muted {
            background: var(--bg);
            color: var(--muted);
        }

        .rc-progress-label {
            display: flex;
            justify-content: space-between;
            font-size: .72rem;
            color: var(--muted);
            margin-bottom: 6px;
        }

        .rc-progress-track {
            width: 100%;
            height: 8px;
            background: var(--bg);
            border-radius: 999px;
            overflow: hidden;
            margin-bottom: 16px;
        }

        .rc-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--accent), var(--gold));
            border-radius: 999px;
        }

        .rc-report-no {
            font-size: .7rem;
            color: var(--muted);
            margin-bottom: 16px;
            font-family: monospace;
        }

        .rc-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .rc-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            border-radius: 999px;
            font-size: .77rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all .2s;
            text-decoration: none;
        }

        .rc-btn-primary {
            background: var(--accent);
            color: #fff;
        }

        .rc-btn-primary:hover {
            background: #4C2E8A;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(107, 70, 193, .3);
            color: #fff;
        }

        .rc-btn-outline {
            background: #fff;
            color: var(--accent);
            border: 1.5px solid var(--accent);
        }

        .rc-btn-outline:hover {
            background: var(--accent-lt);
        }

        /* Empty state */
        .rc-empty {
            grid-column: 1/-1;
            text-align: center;
            padding: 80px 40px;
            background: var(--surface);
            border: 1.5px dashed var(--border);
            border-radius: var(--radius);
        }

        .rc-empty-icon {
            font-size: 3rem;
            margin-bottom: 16px;
            opacity: .5;
        }

        .rc-empty-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            margin-bottom: 10px;
            color: var(--ink);
        }

        .rc-empty-text {
            color: var(--muted);
            font-size: .85rem;
            margin-bottom: 24px;
        }

        @media(max-width:768px) {
            .rc-title {
                font-size: 1.5rem;
            }
        }

        .rc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(min(340px, 100%), 1fr));
    gap: 24px;
}

.rc-wrap {
    overflow-x: hidden;
}

@media (max-width: 480px) {
    .rc-wrap {
        padding: 0 16px 40px;
    }
}
    </style>

    <div class="rc-wrap">
        {{-- Header --}}
        <div class="rc-header">
            <div>
                <div class="rc-eyebrow"><i class="fas fa-chart-line"></i> My Progress</div>
                <h1 class="rc-title">My <em>Report Cards</em></h1>
                <p class="rc-subtitle">Live grade and progress snapshots for every class you're enrolled in</p>
            </div>
            <a href="{{ route('student.lessons.lists') }}" class="rc-btn rc-btn-outline">
                <i class="fas fa-book-open"></i> My Lessons
            </a>
        </div>

        {{-- Flash --}}
        @if(session('fail'))
            <div
                style="background:#FEE2E2;border:1px solid #DC2626;border-radius:12px;padding:14px 18px;margin-bottom:24px;color:#9B1C1C;font-size:.84rem;">
                <i class="fas fa-exclamation-triangle"></i> {{ session('fail') }}
            </div>
        @endif

        {{-- Report card cards --}}
        <div class="rc-grid">
            @forelse($snapshots as $snapshot)
                <div class="rc-card">
                    <div class="rc-card-banner">
                        <div class="rc-card-type"><i class="fas fa-graduation-cap"></i> Report Card</div>
                        <div class="rc-card-class">{{ $snapshot['class']->name ?? 'Class' }}</div>
                        @if($snapshot['levelName'])
                            <div style="font-size:.7rem;color:rgba(255,255,255,.7);margin-top:3px">
                                <i class="fas fa-layer-group"></i> {{ $snapshot['levelName'] }}
                                @if($snapshot['sectionName']) &middot; {{ $snapshot['sectionName'] }} @endif
                            </div>
                        @endif
                    </div>
                    <div class="rc-card-body">
                        <div class="rc-card-meta">
                            @if($snapshot['academicYearName'])
                                <span><i class="fas fa-calendar"></i> {{ $snapshot['academicYearName'] }}</span>
                            @endif
                            @if($snapshot['classTeacherName'])
                                <span><i class="fas fa-chalkboard-teacher"></i> {{ $snapshot['classTeacherName'] }}</span>
                            @endif
                        </div>

                        <div class="rc-score-row">
                            <div>
                                <div class="rc-score-num">
                                    {{ $snapshot['overallPercentage'] !== null ? number_format($snapshot['overallPercentage'], 1) . '%' : '—' }}
                                </div>
                                <div class="rc-score-sub">Overall Score</div>
                            </div>
                            @if($snapshot['rankPosition'])
                                <div style="border-left:1.5px solid var(--border);padding-left:16px;">
                                    <div class="rc-score-num" style="font-size:1.4rem;">
                                        #{{ $snapshot['rankPosition'] }}<span
                                            style="font-size:.9rem;color:var(--muted);">/{{ $snapshot['rankOutOf'] }}</span>
                                    </div>
                                    <div class="rc-score-sub">Class Rank</div>
                                </div>
                            @endif
                        </div>

                        <div class="rc-pill-row">
                            @if($snapshot['overallGrade'])
                                <span class="rc-pill rc-pill-gold"><i class="fas fa-star"></i> Grade
                                    {{ $snapshot['overallGrade'] }}</span>
                            @endif
                            @if($snapshot['totalFullMarks'])
                                <span class="rc-pill rc-pill-purple">
                                    {{ $snapshot['totalMarksObtained'] }} / {{ $snapshot['totalFullMarks'] }} marks
                                </span>
                            @endif
                            <span class="rc-pill rc-pill-green">
                                <i class="fas fa-question-circle"></i>
                                {{ $snapshot['totalQuizzesTaken'] }}/{{ $snapshot['totalQuizzes'] }} quizzes
                            </span>
                        </div>

                        <div class="rc-progress-label">
                            <span>Lesson Progress</span>
                            <span>{{ $snapshot['totalLessonsCompleted'] }}/{{ $snapshot['totalLessons'] }} lessons
                                ({{ $snapshot['lessonProgressPercentage'] }}%)</span>
                        </div>
                        <div class="rc-progress-track">
                            <div class="rc-progress-fill" style="width: {{ $snapshot['lessonProgressPercentage'] }}%;">
                            </div>
                        </div>

                        <div class="rc-report-no"><i class="fas fa-barcode"></i> {{ $snapshot['reportNo'] }}</div>

                        <div class="rc-actions">
                            <a href="{{ route('student.report-card.download', $snapshot['class']->id) }}"
                                class="rc-btn rc-btn-primary">
                                <i class="fas fa-download"></i> Download PDF
                            </a>
                            <a href="{{ route('student.report-card.preview', $snapshot['class']->id) }}"
                                class="rc-btn rc-btn-outline" target="_blank">
                                <i class="fas fa-eye"></i> Preview
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="rc-empty">
                    <div class="rc-empty-icon">📊</div>
                    <div class="rc-empty-title">No Report Cards Yet</div>
                    <p class="rc-empty-text">Once you're enrolled in an active class, your live report card will show up
                        here.</p>
                    <a href="{{ route('student.lessons.lists') }}" class="rc-btn rc-btn-primary">
                        <i class="fas fa-book-open"></i> Go to My Lessons
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection