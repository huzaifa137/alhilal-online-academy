@extends('Student.layouts.sidebar')

@section('main-content')
<div class="sd-content">

    {{-- ── WELCOME BANNER ── --}}
    <div class="sd-welcome-banner">
        <div class="sd-welcome-pattern"></div>
        <div class="sd-welcome-left">
            <div class="sd-welcome-badge">
                <i class="fas fa-circle-check"></i>
                You completed {{ $lessonsThisWeek }} lesson{{ $lessonsThisWeek == 1 ? '' : 's' }} this week
            </div>
            <h1>Welcome Back,<br>{{ $student->firstname ?? ($student->fullname ?? "Student") }}</h1>
            @if($lastProgress && $lastProgress->lesson)
                <p>You're <strong style="color:rgba(255,255,255,0.85);">{{ $overallProgress }}%</strong> through
                    <strong style="color:rgba(255,255,255,0.85);">{{ $lastProgress->lesson->topic->subject->name ?? 'your course' }}</strong>.
                    Pick up right where you left off and keep going!
                </p>
            @else
                <p>You have <strong style="color:rgba(255,255,255,0.85);">{{ $totalAvailableLessons }} lessons</strong> available. Start learning today!</p>
            @endif
        </div>
        <div class="sd-welcome-actions">
            @if($lastProgress && $lastProgress->lesson)
                <a href="{{ route('student.lessons.show', $lastProgress->lesson->id) }}" class="sd-continue-btn">
                    <i class="fas fa-play"></i> Continue Lesson
                </a>
            @else
                <a href="{{ route('student.lessons.lists') }}" class="sd-continue-btn">
                    <i class="fas fa-play"></i> Browse Lessons
                </a>
            @endif
            <div class="sd-streak">
                <i class="fas fa-fire"></i>
                <span>{{ $lessonsThisWeek }} lesson{{ $lessonsThisWeek == 1 ? '' : 's' }} completed this week</span>
            </div>
        </div>
    </div>

    {{-- ── STAT CARDS ── --}}
    <div class="sd-stats-grid">
        <div class="sd-stat-card">
            <div class="sd-stat-card-top">
                <div class="sd-stat-icon sd-stat-icon-purple"><i class="fas fa-play-circle"></i></div>
            </div>
            <div class="sd-stat-num">{{ $completedLessons }}</div>
            <div class="sd-stat-label">Lessons Completed</div>
            <div class="sd-stat-bar">
                <div class="sd-stat-bar-fill" style="width:{{ $totalAvailableLessons > 0 ? round(($completedLessons/$totalAvailableLessons)*100) : 0 }}%;"></div>
            </div>
        </div>
        <div class="sd-stat-card">
            <div class="sd-stat-card-top">
                <div class="sd-stat-icon sd-stat-icon-green"><i class="fas fa-check-circle"></i></div>
            </div>
            <div class="sd-stat-num">{{ $quizzesPassed }}</div>
            <div class="sd-stat-label">Quizzes Passed</div>
            <div class="sd-stat-bar">
                <div class="sd-stat-bar-fill" style="width:{{ min($quizzesPassed * 10, 100) }}%;background:var(--gradient-green);"></div>
            </div>
        </div>
        <div class="sd-stat-card">
            <div class="sd-stat-card-top">
                <div class="sd-stat-icon sd-stat-icon-gold"><i class="fas fa-chalkboard"></i></div>
            </div>
            <div class="sd-stat-num">{{ $enrolledClasses }}</div>
            <div class="sd-stat-label">Enrolled Classes</div>
            <div class="sd-stat-bar">
                <div class="sd-stat-bar-fill" style="width:{{ min($enrolledClasses * 20, 100) }}%;background:var(--gradient-gold);"></div>
            </div>
        </div>
        <div class="sd-stat-card">
            <div class="sd-stat-card-top">
                <div class="sd-stat-icon sd-stat-icon-red"><i class="fas fa-star"></i></div>
            </div>
            <div class="sd-stat-num">{{ $avgScore }}%</div>
            <div class="sd-stat-label">Avg. Quiz Score</div>
            <div class="sd-stat-bar">
                <div class="sd-stat-bar-fill" style="width:{{ $avgScore }}%;"></div>
            </div>
        </div>
    </div>

    {{-- ── MAIN GRID ── --}}
    <div class="sd-main-grid">

        {{-- Subject Progress --}}
        <div class="sd-progress-card">
            <div class="sd-card-header">
                <div class="sd-section-title">Subject Progress</div>
                <a href="{{ route('student.lessons.lists') }}" class="sd-view-all">View All <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="sd-card-body">
                <div class="sd-subject-progress-list">
                    @forelse($subjectProgress as $sp)
                        <div class="sd-subject-prog-item">
                            <div class="sd-subject-prog-top">
                                <div class="sd-subject-prog-info">
                                    <div class="sd-subject-prog-icon"
                                        style="background:{{ $sp['color'] }}22;color:{{ $sp['color'] }}">
                                        <i class="fas {{ $sp['icon'] }}"></i>
                                    </div>
                                    <div>
                                        <div class="sd-subject-prog-name">{{ $sp['name'] }}</div>
                                        <div class="sd-subject-prog-lessons">{{ $sp['completed'] }} / {{ $sp['total'] }} lessons</div>
                                    </div>
                                </div>
                                <div class="sd-subject-prog-pct">{{ $sp['percentage'] }}%</div>
                            </div>
                            <div class="sd-prog-bar">
                                <div class="sd-prog-bar-fill" style="width:{{ $sp['percentage'] }}%;background:{{ $sp['color'] }};"></div>
                            </div>
                        </div>
                    @empty
                        <div style="text-align:center;padding:40px 20px;color:var(--muted);">
                            <i class="fas fa-book-open" style="font-size:2rem;margin-bottom:12px;display:block;"></i>
                            <p>No subjects found. Enroll in a class to see your progress.</p>
                            <a href="{{ route('student.classes.browse') }}" style="color:var(--purple);font-weight:600;font-size:0.85rem;">Browse Classes →</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Right panel --}}
        <div class="sd-quick-panel">

            {{-- Quick Actions --}}
            <div class="sd-quick-card">
                <div class="sd-section-title">Quick Actions</div>
                <div class="sd-quick-actions-grid">
                    @if($lastProgress && $lastProgress->lesson)
                        <a href="{{ route('student.lessons.show', $lastProgress->lesson->id) }}" class="sd-quick-action-btn btn-primary-action">
                            <i class="fas fa-play-circle"></i> Resume Lesson
                        </a>
                    @else
                        <a href="{{ route('student.lessons.lists') }}" class="sd-quick-action-btn btn-primary-action">
                            <i class="fas fa-play-circle"></i> Start Lesson
                        </a>
                    @endif
                    <a href="{{ route('student.lessons.lists') }}" class="sd-quick-action-btn">
                        <i class="fas fa-list"></i> My Lessons
                    </a>
                    <a href="{{ route('student.classes.browse') }}" class="sd-quick-action-btn">
                        <i class="fas fa-chalkboard"></i> Browse Classes
                    </a>
                    <button class="sd-quick-action-btn">
                        <i class="fas fa-chart-line"></i> My Reports
                    </button>
                    <a href="https://wa.me/256760808570" target="_blank" class="sd-quick-action-btn" style="color:var(--green);">
                        <i class="fab fa-whatsapp"></i> Chat Teacher
                    </a>
                    <button class="sd-quick-action-btn">
                        <i class="fas fa-award"></i> My Certs
                    </button>
                </div>
            </div>

            {{-- Upcoming Exams (right panel) --}}
            <div class="sd-quick-card">
                <div class="sd-section-title">Upcoming Exams</div>
                <div style="margin-top:14px;">
                    @forelse($upcomingExams as $exam)
                        <div class="sd-announce-item">
                            <div class="sd-announce-icon" style="background:var(--red-light);color:var(--red);">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div style="flex:1;">
                                <div class="sd-announce-title">{{ $exam->title }}</div>
                                <div class="sd-announce-text">
                                    {{ $exam->duration_minutes ? $exam->duration_minutes . ' mins' : 'No time limit' }}
                                    · {{ $exam->total_marks }} marks
                                </div>
                            </div>
                            <div class="sd-announce-time">
                                {{ \Carbon\Carbon::parse($exam->available_from)->format('d M') }}
                            </div>
                        </div>
                    @empty
                        <p style="color:var(--muted);font-size:0.82rem;text-align:center;padding:20px 0;">No upcoming exams.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    {{-- ── LESSONS SECTION ── --}}
    <div class="sd-lessons-section">
        <div class="sd-section-head">
            <div class="sd-section-title">My Lessons</div>
            <a href="{{ route('student.lessons.lists') }}" class="sd-view-all">View All Lessons <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="sd-tabs">
            <button class="sd-tab active" data-tab="inprogress">In Progress</button>
            <button class="sd-tab" data-tab="completed">Completed</button>
            <button class="sd-tab" data-tab="todo">To Do</button>
        </div>
        <div class="sd-lessons-grid" id="lessonsGrid"></div>
    </div>

    {{-- ── BOTTOM GRID ── --}}
    <div class="sd-bottom-grid">

        {{-- Upcoming Exams full list --}}
        <div class="sd-leaderboard-card">
            <div class="sd-card-header" style="padding:18px 20px 12px;">
                <div class="sd-section-title">Upcoming Exams</div>
                <span style="font-size:0.72rem;color:var(--muted);font-weight:500;">Scheduled</span>
            </div>
            <div class="sd-exam-list">
                @forelse($upcomingExams as $exam)
                    @php
                        $daysUntil = now()->diffInDays(\Carbon\Carbon::parse($exam->available_from));
                        $badgeClass = $daysUntil <= 5 ? 'badge-soon' : ($daysUntil <= 10 ? 'badge-upcoming' : 'badge-later');
                    @endphp
                    <div class="sd-exam-item">
                        <div class="sd-exam-date-box">
                            <div class="sd-exam-day">{{ \Carbon\Carbon::parse($exam->available_from)->format('d') }}</div>
                            <div class="sd-exam-month">{{ \Carbon\Carbon::parse($exam->available_from)->format('M') }}</div>
                        </div>
                        <div>
                            <div class="sd-exam-name">{{ $exam->title }}</div>
                            <div class="sd-exam-subject">
                                <i class="fas fa-clock" style="font-size:0.65rem;margin-right:3px;"></i>
                                {{ $exam->duration_minutes ? $exam->duration_minutes . ' mins' : 'No limit' }}
                                · {{ $exam->total_marks }} marks
                            </div>
                        </div>
                        <div class="sd-exam-badge {{ $badgeClass }}">{{ $daysUntil }} days</div>
                    </div>
                @empty
                    <p style="color:var(--muted);font-size:0.82rem;text-align:center;padding:30px 0;">No upcoming exams scheduled.</p>
                @endforelse
            </div>
        </div>

        {{-- Certificates --}}
        <div class="sd-leaderboard-card">
            <div class="sd-card-header" style="padding:18px 20px 12px;">
                <div class="sd-section-title">My Certificates</div>
                <a href="#" class="sd-view-all" style="font-size:0.72rem;">All <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="sd-cert-list">
                @forelse($certificates as $cert)
                    <div class="sd-cert-item">
                        <div class="sd-cert-icon" style="background:var(--gold-light);color:var(--gold)">
                            <i class="fas fa-medal"></i>
                        </div>
                        <div>
                            <div class="sd-cert-name">{{ $cert->title }}</div>
                            <div class="sd-cert-date">
                                <i class="fas fa-calendar-check" style="font-size:0.65rem;margin-right:4px;"></i>
                                Issued: {{ \Carbon\Carbon::parse($cert->issued_date)->format('M d, Y') }}
                            </div>
                        </div>
                        <div class="sd-cert-download"><i class="fas fa-download"></i></div>
                    </div>
                @empty
                    <div style="text-align:center;padding:30px 20px;color:var(--muted);">
                        <i class="fas fa-certificate" style="font-size:2rem;margin-bottom:10px;display:block;opacity:0.4;"></i>
                        <p style="font-size:0.82rem;">No certificates yet. Complete a class to earn one.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Overall Progress summary --}}
        <div class="sd-leaderboard-card">
            <div class="sd-card-header" style="padding:18px 20px 12px;">
                <div class="sd-section-title">Overall Progress</div>
                <span style="font-size:0.72rem;color:var(--muted);font-weight:500;">All Classes</span>
            </div>
            <div style="padding:16px 20px;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                    <span style="font-size:0.82rem;color:var(--muted);">Lessons Completed</span>
                    <span style="font-size:0.82rem;font-weight:700;color:var(--ink);">{{ $completedLessons }} / {{ $totalAvailableLessons }}</span>
                </div>
                <div class="sd-prog-bar" style="margin-bottom:20px;">
                    <div class="sd-prog-bar-fill" style="width:{{ $overallProgress }}%;"></div>
                </div>

                <div style="display:flex;flex-direction:column;gap:14px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:12px;background:var(--cream2);border-radius:12px;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:32px;height:32px;border-radius:9px;background:var(--purple-light);color:var(--purple);display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-chalkboard" style="font-size:0.8rem;"></i>
                            </div>
                            <span style="font-size:0.82rem;font-weight:600;">Enrolled Classes</span>
                        </div>
                        <span style="font-size:1.1rem;font-weight:700;color:var(--purple);">{{ $enrolledClasses }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:12px;background:var(--cream2);border-radius:12px;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:32px;height:32px;border-radius:9px;background:var(--green-light);color:var(--green);display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-check-circle" style="font-size:0.8rem;"></i>
                            </div>
                            <span style="font-size:0.82rem;font-weight:600;">Quizzes Passed</span>
                        </div>
                        <span style="font-size:1.1rem;font-weight:700;color:var(--green);">{{ $quizzesPassed }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:12px;background:var(--cream2);border-radius:12px;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:32px;height:32px;border-radius:9px;background:var(--gold-light);color:var(--gold);display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-star" style="font-size:0.8rem;"></i>
                            </div>
                            <span style="font-size:0.82rem;font-weight:600;">Avg. Quiz Score</span>
                        </div>
                        <span style="font-size:1.1rem;font-weight:700;color:var(--gold);">{{ $avgScore }}%</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>{{-- /sd-content --}}
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // ── REAL LESSON DATA FROM SERVER ─────────────────────────────
    const lessonData = @json($lessonData);

    function typeIcon(type) {
        const map = { video: 'fa-video', audio: 'fa-headphones', pdf: 'fa-file-pdf', text: 'fa-file-alt' };
        return map[type] || 'fa-book';
    }

    function renderLessons(tab) {
        const grid = document.getElementById('lessonsGrid');
        const lessons = lessonData[tab];

        if (!lessons || lessons.length === 0) {
            grid.innerHTML = `
                <div style="grid-column:1/-1;text-align:center;padding:50px 20px;color:var(--muted);">
                    <i class="fas fa-inbox" style="font-size:2rem;margin-bottom:12px;display:block;opacity:0.4;"></i>
                    <p>No lessons found in this category.</p>
                </div>`;
            return;
        }

        grid.innerHTML = lessons.map(l => {
            const progressBadge = l.progress > 0
                ? '<span><i class="fas fa-chart-simple"></i> ' + l.progress + '%</span>'
                : '';

            const progressBlock = l.progress > 0
                ? '<div class="sd-lesson-progress-row"><span>Progress</span><span>' + l.progress + '%</span></div>'
                + '<div class="sd-lesson-prog-bar"><div class="sd-lesson-prog-fill" style="width:' + l.progress + '%;"></div></div>'
                : '<div style="height:4px;margin-bottom:12px;"></div>';

            const actionLabel = l.progress > 0 && l.progress < 100
                ? 'Resume'
                : (l.progress === 100 ? 'Review' : 'Start');

            const secondaryAction = l.passed
                ? '<span class="sd-btn-passed"><i class="fas fa-check-circle"></i> Completed</span>'
                : '<a href="' + l.url + '" class="sd-btn-quiz"><i class="fas fa-question-circle"></i> Quiz</a>';

            return `
            <div class="sd-lesson-card">
                <div class="sd-lesson-card-top">
                    <div class="sd-lesson-type-icon" style="background:${l.color}22;color:${l.color}">
                        <i class="fas ${typeIcon(l.type)}"></i>
                    </div>
                    <span class="sd-lesson-subject-tag" style="background:${l.color}22;color:${l.color}">
                        <i class="fas ${l.icon}" style="font-size:0.65rem;"></i> ${l.subject}
                    </span>
                    <div class="sd-lesson-title">${l.title}</div>
                    <div class="sd-lesson-meta">
                        <span><i class="fas fa-clock"></i> ${l.duration}</span>
                        <span><i class="fas ${typeIcon(l.type)}"></i> ${l.type}</span>
                        ${progressBadge}
                    </div>
                </div>
                <div class="sd-lesson-card-bottom">
                    ${progressBlock}
                    <div class="sd-lesson-actions">
                        <a href="${l.url}" class="sd-btn-view">
                            <i class="fas fa-play"></i>
                            ${actionLabel}
                        </a>
                        ${secondaryAction}
                    </div>
                </div>
            </div>
            `;
        }).join('');
    }

    // ── TABS ─────────────────────────────────────────────────────
    document.querySelectorAll('.sd-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.sd-tab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            renderLessons(tab.dataset.tab);
        });
    });

    // ── MODAL HELPERS ────────────────────────────────────────────
    function openModal(id) {
        document.getElementById(id).classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        document.getElementById(id).classList.remove('open');
        document.body.style.overflow = '';
    }
    window.addEventListener('click', e => {
        document.querySelectorAll('.sd-modal').forEach(m => {
            if (e.target === m) closeModal(m.id);
        });
    });

    // ── INIT ─────────────────────────────────────────────────────
    renderLessons('inprogress');
</script>
@endsection