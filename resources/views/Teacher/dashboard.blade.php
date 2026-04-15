@extends('Teacher..layouts.teacher-master')

@section('title', 'Teacher Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Teacher Dashboard')

@section('additional-css')
<style>
    /* ── WELCOME BANNER ── */
    .welcome-banner {
        background: linear-gradient(135deg, var(--ink) 0%, #2D0F5C 50%, #4A1A1A 100%);
        border-radius: 24px;
        padding: 32px 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            repeating-linear-gradient(0deg, transparent, transparent 60px, rgba(255, 255, 255, 0.02) 60px, rgba(255, 255, 255, 0.02) 61px),
            repeating-linear-gradient(90deg, transparent, transparent 60px, rgba(255, 255, 255, 0.02) 60px, rgba(255, 255, 255, 0.02) 61px);
    }

    .welcome-orb-1 {
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(107, 70, 193, 0.3) 0%, transparent 70%);
        top: -80px;
        right: 100px;
        pointer-events: none;
    }

    .welcome-orb-2 {
        position: absolute;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(220, 38, 38, 0.2) 0%, transparent 70%);
        bottom: -60px;
        right: 40px;
        pointer-events: none;
    }

    .welcome-text {
        position: relative;
        z-index: 2;
    }

    .welcome-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        padding: 5px 14px;
        border-radius: 40px;
        font-size: 0.72rem;
        color: rgba(255, 255, 255, 0.7);
        letter-spacing: 1.5px;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 14px;
    }

    .welcome-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #4ade80;
        box-shadow: 0 0 8px rgba(74, 222, 128, 0.6);
        animation: pulse-dot 2s ease-in-out infinite;
    }

    @keyframes pulse-dot {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.6;
            transform: scale(1.3);
        }
    }

    .welcome-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: white;
        margin-bottom: 8px;
    }

    .welcome-title span {
        background: linear-gradient(135deg, #C084FC, #F87171);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .welcome-sub {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.55);
    }

    .welcome-actions {
        position: relative;
        z-index: 2;
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .btn-banner {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 22px;
        border-radius: 40px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        transition: all 0.25s;
    }

    .btn-banner-primary {
        background: var(--gradient);
        color: white;
        box-shadow: 0 6px 20px rgba(107, 70, 193, 0.35);
    }

    .btn-banner-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(107, 70, 193, 0.45);
        color: white;
    }

    .btn-banner-ghost {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        backdrop-filter: blur(8px);
    }

    .btn-banner-ghost:hover {
        background: rgba(255, 255, 255, 0.18);
        color: white;
    }

    /* ── KPI STATS ROW ── */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }

    .kpi-card {
        background: white;
        border-radius: 20px;
        padding: 24px;
        border: 1px solid var(--border);
        position: relative;
        overflow: hidden;
        transition: all 0.25s;
    }

    .kpi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--gradient);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s;
    }

    .kpi-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }

    .kpi-card:hover::before {
        transform: scaleX(1);
    }

    .kpi-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .kpi-icon {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .kpi-icon-purple {
        background: var(--purple-light);
        color: var(--purple);
    }

    .kpi-icon-red {
        background: var(--red-light);
        color: var(--red);
    }

    .kpi-icon-gold {
        background: var(--gold-light);
        color: var(--gold);
    }

    .kpi-icon-green {
        background: var(--green-light);
        color: var(--green);
    }

    .kpi-trend {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 20px;
    }

    .kpi-trend-up {
        background: var(--green-light);
        color: var(--green);
    }

    .kpi-trend-down {
        background: var(--red-light);
        color: var(--red);
    }

    .kpi-num {
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--ink);
        line-height: 1;
        margin-bottom: 4px;
    }

    .kpi-label {
        font-size: 0.8rem;
        color: var(--muted);
        font-weight: 500;
    }

    .kpi-sub {
        font-size: 0.72rem;
        color: var(--muted);
        margin-top: 8px;
        padding-top: 8px;
        border-top: 1px solid var(--border);
    }

    .kpi-sub strong {
        color: var(--ink);
    }

    /* ── TWO-COLUMN GRID ── */
    .cols-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 22px;
    }

    .cols-3 {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 22px;
    }

    /* ── CHART CONTAINER ── */
    .chart-wrap {
        position: relative;
        height: 240px;
    }

    /* ── MY CLASSES ── */
    .class-list {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .class-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid var(--border);
        transition: background 0.2s;
    }

    .class-item:last-child {
        border-bottom: none;
    }

    .class-color-bar {
        width: 4px;
        height: 42px;
        border-radius: 4px;
        flex-shrink: 0;
    }

    .class-info {
        flex: 1;
    }

    .class-name {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--ink);
        margin-bottom: 3px;
    }

    .class-meta {
        font-size: 0.74rem;
        color: var(--muted);
        display: flex;
        gap: 12px;
    }

    .class-meta i {
        margin-right: 3px;
    }

    .class-actions {
        display: flex;
        gap: 8px;
    }

    .btn-sm-action {
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 0.74rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
        font-family: 'DM Sans', sans-serif;
    }

    .btn-sm-purple {
        background: var(--purple-light);
        color: var(--purple);
    }

    .btn-sm-purple:hover {
        background: var(--purple);
        color: white;
    }

    .btn-sm-outline {
        background: transparent;
        border: 1px solid var(--border2);
        color: var(--muted);
    }

    .btn-sm-outline:hover {
        border-color: var(--purple);
        color: var(--purple);
    }

    /* ── UPCOMING SESSIONS ── */
    .session-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .session-item {
        display: flex;
        gap: 14px;
        align-items: flex-start;
    }

    .session-time-col {
        text-align: center;
        flex-shrink: 0;
    }

    .session-time {
        font-family: 'Playfair Display', serif;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--ink);
        line-height: 1;
    }

    .session-ampm {
        font-size: 0.65rem;
        color: var(--muted);
        font-weight: 500;
        text-transform: uppercase;
    }

    .session-connector {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 0 2px;
    }

    .session-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        border: 2px solid var(--purple);
        background: white;
        flex-shrink: 0;
    }

    .session-line {
        width: 2px;
        flex: 1;
        background: var(--border2);
        min-height: 30px;
    }

    .session-info {
        flex: 1;
        background: var(--cream);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 12px 16px;
        transition: all 0.2s;
    }

    .session-info:hover {
        border-color: var(--purple);
        box-shadow: var(--shadow-sm);
    }

    .session-name {
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--ink);
        margin-bottom: 4px;
    }

    .session-tags {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .session-tag {
        font-size: 0.68rem;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 20px;
        background: var(--purple-light);
        color: var(--purple);
    }

    .session-tag-red {
        background: var(--red-light);
        color: var(--red);
    }

    .session-tag-gold {
        background: var(--gold-light);
        color: var(--gold);
    }

    .session-tag-green {
        background: var(--green-light);
        color: var(--green);
    }

    /* ── RECENT STUDENTS ── */
    .student-table {
        width: 100%;
        border-collapse: collapse;
    }

    .student-table th {
        text-align: left;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        color: var(--muted);
        padding: 0 16px 12px;
        border-bottom: 1px solid var(--border);
    }

    .student-table td {
        padding: 14px 16px;
        font-size: 0.85rem;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }

    .student-table tr:last-child td {
        border-bottom: none;
    }

    .student-table tbody tr {
        transition: background 0.15s;
    }

    .student-table tbody tr:hover {
        background: var(--cream2);
    }

    .student-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .student-ava {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: var(--gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 0.8rem;
        flex-shrink: 0;
    }

    .student-ava-2 {
        background: linear-gradient(135deg, var(--gold) 0%, var(--red) 100%);
    }

    .student-ava-3 {
        background: linear-gradient(135deg, var(--green) 0%, var(--purple) 100%);
    }

    .student-ava-4 {
        background: linear-gradient(135deg, #0EA5E9 0%, var(--purple) 100%);
    }

    .student-ava-5 {
        background: linear-gradient(135deg, var(--red) 0%, var(--gold) 100%);
    }

    .student-name {
        font-weight: 600;
        color: var(--ink);
        font-size: 0.85rem;
    }

    .student-class {
        font-size: 0.72rem;
        color: var(--muted);
    }

    .progress-mini-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .progress-mini-bar {
        flex: 1;
        height: 6px;
        background: var(--purple-light);
        border-radius: 40px;
        overflow: hidden;
    }

    .progress-mini-fill {
        height: 100%;
        border-radius: 40px;
        background: var(--gradient);
    }

    .progress-mini-pct {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--ink);
        white-space: nowrap;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .status-active {
        background: var(--green-light);
        color: var(--green);
    }

    .status-pending {
        background: var(--gold-light);
        color: var(--gold);
    }

    .status-inactive {
        background: var(--red-light);
        color: var(--red);
    }

    /* ── MINI ACTIVITY FEED ── */
    .activity-list {
        display: flex;
        flex-direction: column;
    }

    .activity-item {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        padding: 14px 0;
        border-bottom: 1px solid var(--border);
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .activity-text {
        flex: 1;
    }

    .activity-msg {
        font-size: 0.83rem;
        color: var(--ink);
        font-weight: 500;
        line-height: 1.4;
    }

    .activity-msg strong {
        color: var(--purple);
    }

    .activity-time {
        font-size: 0.7rem;
        color: var(--muted);
        margin-top: 3px;
    }

    /* ── QUICK ACTIONS ── */
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }

    .qa-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        padding: 20px 12px;
        background: white;
        border: 1px solid var(--border);
        border-radius: 18px;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.25s;
        position: relative;
        overflow: hidden;
        font-family: 'DM Sans', sans-serif;
    }

    .qa-btn::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--gradient);
        transform: scaleX(0);
        transition: transform 0.25s;
        transform-origin: left;
    }

    .qa-btn:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: var(--border2);
    }

    .qa-btn:hover::before {
        transform: scaleX(1);
    }

    .qa-icon {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .qa-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--ink);
        text-align: center;
    }

    /* ── ASSIGNMENT CARDS ── */
    .assignment-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .assignment-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 16px;
        background: var(--cream);
        border: 1px solid var(--border);
        border-radius: 14px;
        transition: all 0.2s;
    }

    .assignment-item:hover {
        border-color: var(--purple);
        box-shadow: var(--shadow-sm);
    }

    .assignment-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        flex-shrink: 0;
    }

    .assignment-info {
        flex: 1;
    }

    .assignment-name {
        font-size: 0.87rem;
        font-weight: 600;
        color: var(--ink);
        margin-bottom: 3px;
    }

    .assignment-meta {
        font-size: 0.73rem;
        color: var(--muted);
        display: flex;
        gap: 10px;
    }

    .assignment-right {
        text-align: right;
    }

    .assignment-due {
        font-size: 0.72rem;
        font-weight: 600;
        color: var(--red);
        margin-bottom: 4px;
    }

    .assignment-submissions {
        font-size: 0.72rem;
        color: var(--muted);
    }

    .assignment-btn {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
        background: var(--purple-light);
        color: var(--purple);
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: all 0.2s;
        font-family: 'DM Sans', sans-serif;
    }

    .assignment-btn:hover {
        background: var(--purple);
        color: white;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 1200px) {
        .kpi-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .quick-actions-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (max-width: 900px) {
        .cols-2, .cols-3 {
            grid-template-columns: 1fr;
        }
        .welcome-banner {
            flex-direction: column;
            gap: 20px;
            align-items: flex-start;
        }
    }

    @media (max-width: 600px) {
        .kpi-grid {
            grid-template-columns: 1fr;
        }
        .quick-actions-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endsection

@section('content')
    {{-- ── WELCOME BANNER ── --}}
    <div class="welcome-banner">
        <div class="welcome-orb-1"></div>
        <div class="welcome-orb-2"></div>
        <div class="welcome-text">
            <div class="welcome-eyebrow">
                <span class="welcome-dot"></span>
                {{ now()->format('l, d M Y') }}
            </div>
            <div class="welcome-title">
                Assalamu Alaikum, <span>{{ auth()->user()->first_name ?? 'Teacher' }}</span>
            </div>
            <div class="welcome-sub">
                You have <strong style="color:#C084FC;">3 classes today</strong> and <strong style="color:#F87171;">5 pending submissions</strong> awaiting your review.
            </div>
        </div>
        <div class="welcome-actions">
            <a href="#" class="btn-banner btn-banner-primary" id="addLessonBtn">
                <i class="fas fa-plus"></i> Add Lesson
            </a>
            <a href="#" class="btn-banner btn-banner-ghost">
                <i class="fas fa-calendar-alt"></i> View Schedule
            </a>
        </div>
    </div>

    {{-- ── KPI STATS ── --}}
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-icon kpi-icon-purple"><i class="fas fa-users"></i></div>
                <div class="kpi-trend kpi-trend-up"><i class="fas fa-arrow-up"></i> 8%</div>
            </div>
            <div class="kpi-num">142</div>
            <div class="kpi-label">Total Students</div>
            <div class="kpi-sub"><strong>+11</strong> enrolled this month</div>
        </div>

        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-icon kpi-icon-red"><i class="fas fa-chalkboard"></i></div>
                <div class="kpi-trend kpi-trend-up"><i class="fas fa-arrow-up"></i> 2</div>
            </div>
            <div class="kpi-num">6</div>
            <div class="kpi-label">Active Classes</div>
            <div class="kpi-sub"><strong>3 classes</strong> scheduled today</div>
        </div>

        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-icon kpi-icon-gold"><i class="fas fa-tasks"></i></div>
                <div class="kpi-trend kpi-trend-down"><i class="fas fa-arrow-down"></i> 5</div>
            </div>
            <div class="kpi-num">5</div>
            <div class="kpi-label">Pending Reviews</div>
            <div class="kpi-sub"><strong>2 urgent</strong> due tomorrow</div>
        </div>

        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-icon kpi-icon-green"><i class="fas fa-chart-line"></i></div>
                <div class="kpi-trend kpi-trend-up"><i class="fas fa-arrow-up"></i> 5%</div>
            </div>
            <div class="kpi-num">87%</div>
            <div class="kpi-label">Avg. Completion Rate</div>
            <div class="kpi-sub">Up from <strong>82%</strong> last month</div>
        </div>
    </div>

    {{-- ── QUICK ACTIONS ── --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Quick Actions</div>
                <div class="card-subtitle">Jump straight to your most common tasks</div>
            </div>
        </div>
        <div class="card-body">
            <div class="quick-actions-grid">
                <a href="#" class="qa-btn">
                    <div class="qa-icon kpi-icon-purple"><i class="fas fa-plus-circle"></i></div>
                    <div class="qa-label">Add Lesson</div>
                </a>
                <a href="#" class="qa-btn">
                    <div class="qa-icon kpi-icon-red"><i class="fas fa-file-alt"></i></div>
                    <div class="qa-label">New Assignment</div>
                </a>
                <a href="#" class="qa-btn">
                    <div class="qa-icon kpi-icon-gold"><i class="fas fa-clipboard-list"></i></div>
                    <div class="qa-label">Take Attendance</div>
                </a>
                <a href="#" class="qa-btn">
                    <div class="qa-icon kpi-icon-green"><i class="fas fa-pencil-alt"></i></div>
                    <div class="qa-label">Create Quiz</div>
                </a>
                <a href="#" class="qa-btn">
                    <div class="qa-icon" style="background:#EDE9FA;color:#7C3AED;"><i class="fas fa-chart-bar"></i></div>
                    <div class="qa-label">View Reports</div>
                </a>
                <a href="#" class="qa-btn">
                    <div class="qa-icon" style="background:#DBEAFE;color:#2563EB;"><i class="fas fa-video"></i></div>
                    <div class="qa-label">Start Session</div>
                </a>
                <a href="#" class="qa-btn">
                    <div class="qa-icon" style="background:#FCE7F3;color:#DB2777;"><i class="fas fa-bullhorn"></i></div>
                    <div class="qa-label">Announcement</div>
                </a>
                <a href="#" class="qa-btn">
                    <div class="qa-icon" style="background:#D1FAE5;color:#059669;"><i class="fas fa-envelope"></i></div>
                    <div class="qa-label">Message Parent</div>
                </a>
            </div>
        </div>
    </div>

    {{-- ── CHART + UPCOMING SESSIONS ── --}}
    <div class="cols-3">
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Student Engagement</div>
                    <div class="card-subtitle">Lesson completions over the last 7 days</div>
                </div>
                <a href="#" class="card-link">Full Report <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card-body">
                <div class="chart-wrap">
                    <canvas id="engagementChart"></canvas>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Today's Sessions</div>
                    <div class="card-subtitle">{{ now()->format('d M Y') }}</div>
                </div>
                <a href="#" class="card-link">All <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card-body">
                <div class="session-list">
                    <div class="session-item">
                        <div class="session-time-col">
                            <div class="session-time">8:00</div>
                            <div class="session-ampm">AM</div>
                        </div>
                        <div class="session-connector">
                            <div class="session-dot" style="border-color:var(--purple);"></div>
                            <div class="session-line"></div>
                        </div>
                        <div class="session-info">
                            <div class="session-name">Quran Recitation — Level 2</div>
                            <div class="session-tags">
                                <span class="session-tag">28 Students</span>
                                <span class="session-tag-gold">60 min</span>
                            </div>
                        </div>
                    </div>

                    <div class="session-item">
                        <div class="session-time-col">
                            <div class="session-time">10:30</div>
                            <div class="session-ampm">AM</div>
                        </div>
                        <div class="session-connector">
                            <div class="session-dot" style="border-color:var(--red);"></div>
                            <div class="session-line"></div>
                        </div>
                        <div class="session-info">
                            <div class="session-name">Fiqh Foundations — Grade 5</div>
                            <div class="session-tags">
                                <span class="session-tag">34 Students</span>
                                <span class="session-tag-red">45 min</span>
                            </div>
                        </div>
                    </div>

                    <div class="session-item">
                        <div class="session-time-col">
                            <div class="session-time">2:00</div>
                            <div class="session-ampm">PM</div>
                        </div>
                        <div class="session-connector">
                            <div class="session-dot" style="border-color:var(--green);"></div>
                            <div class="session-line" style="min-height:0;"></div>
                        </div>
                        <div class="session-info">
                            <div class="session-name">Arabic Language — Beginners</div>
                            <div class="session-tags">
                                <span class="session-tag">19 Students</span>
                                <span class="session-tag-green">90 min</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── MY CLASSES ── --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">My Classes</div>
                <div class="card-subtitle">All active classes you're teaching this term</div>
            </div>
            <a href="#" class="card-link">Manage All <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="card-body" style="padding-top:0;">
            <div class="class-list">
                @php
                    $classes = [
                        ['name' => 'Quran Recitation — Level 2', 'students' => 28, 'days' => 'Mon, Wed, Fri', 'time' => '8:00 AM', 'gradient' => 'var(--gradient)'],
                        ['name' => 'Fiqh Foundations — Grade 5', 'students' => 34, 'days' => 'Tue, Thu', 'time' => '10:30 AM', 'gradient' => 'linear-gradient(135deg,var(--red),var(--gold))'],
                        ['name' => 'Arabic Language — Beginners', 'students' => 19, 'days' => 'Mon, Wed', 'time' => '2:00 PM', 'gradient' => 'linear-gradient(135deg,var(--green),#0EA5E9)'],
                        ['name' => 'Aqeedah — Secondary Level', 'students' => 22, 'days' => 'Sat', 'time' => '9:00 AM', 'gradient' => 'linear-gradient(135deg,#7C3AED,#0EA5E9)'],
                        ['name' => 'Tajweed Advanced — Level 4', 'students' => 16, 'days' => 'Fri', 'time' => '4:00 PM', 'gradient' => 'linear-gradient(135deg,var(--gold),var(--red))'],
                        ['name' => 'Seerah of the Prophet ﷺ', 'students' => 23, 'days' => 'Tue, Sat', 'time' => '11:00 AM', 'gradient' => 'linear-gradient(135deg,#DB2777,var(--purple))'],
                    ];
                @endphp

                @foreach($classes as $class)
                <div class="class-item">
                    <div class="class-color-bar" style="background:{{ $class['gradient'] }};"></div>
                    <div class="class-info">
                        <div class="class-name">{{ $class['name'] }}</div>
                        <div class="class-meta">
                            <span><i class="fas fa-users"></i>{{ $class['students'] }} Students</span>
                            <span><i class="fas fa-calendar"></i>{{ $class['days'] }}</span>
                            <span><i class="fas fa-clock"></i>{{ $class['time'] }}</span>
                        </div>
                    </div>
                    <div class="class-actions">
                        <a href="#" class="btn-sm-action btn-sm-purple"><i class="fas fa-eye"></i> View</a>
                        <a href="#" class="btn-sm-action btn-sm-outline"><i class="fas fa-edit"></i></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ── STUDENTS + ACTIVITY ── --}}
    <div class="cols-2">
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Recent Students</div>
                    <div class="card-subtitle">Latest activity across your classes</div>
                </div>
                <a href="#" class="card-link">All Students <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card-body" style="padding:0 24px;">
                <table class="student-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Progress</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $students = [
                                ['initials' => 'AK', 'name' => 'Aisha Kamara', 'class' => 'Quran Level 2', 'progress' => 88, 'status' => 'Active', 'avatar_class' => ''],
                                ['initials' => 'IS', 'name' => 'Ibrahim Ssekatawa', 'class' => 'Fiqh Grade 5', 'progress' => 74, 'status' => 'Active', 'avatar_class' => 'student-ava-2'],
                                ['initials' => 'MN', 'name' => 'Mariam Nakato', 'class' => 'Arabic Beginners', 'progress' => 61, 'status' => 'Pending', 'avatar_class' => 'student-ava-3'],
                                ['initials' => 'YM', 'name' => 'Yusuf Mugenyi', 'class' => 'Tajweed Adv.', 'progress' => 95, 'status' => 'Active', 'avatar_class' => 'student-ava-4'],
                                ['initials' => 'FA', 'name' => 'Fatuma Atieno', 'class' => 'Aqeedah Sec.', 'progress' => 42, 'status' => 'Inactive', 'avatar_class' => 'student-ava-5'],
                            ];
                        @endphp

                        @foreach($students as $student)
                        <tr>
                            <td>
                                <div class="student-cell">
                                    <div class="student-ava {{ $student['avatar_class'] }}">{{ $student['initials'] }}</div>
                                    <div>
                                        <div class="student-name">{{ $student['name'] }}</div>
                                        <div class="student-class">{{ $student['class'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="progress-mini-wrap">
                                    <div class="progress-mini-bar">
                                        <div class="progress-mini-fill" style="width:{{ $student['progress'] }}%;"></div>
                                    </div>
                                    <div class="progress-mini-pct">{{ $student['progress'] }}%</div>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-{{ strtolower($student['status']) }}">
                                    <i class="fas fa-circle" style="font-size:5px;"></i> {{ $student['status'] }}
                                </span>
                            </td>
                            <td><a href="#" class="assignment-btn">View</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Recent Activity</div>
                    <div class="card-subtitle">Live updates from your classes</div>
                </div>
            </div>
            <div class="card-body" style="padding-top:0;">
                <div class="activity-list">
                    @php
                        $activities = [
                            ['icon' => 'act-green', 'icon_class' => 'fa-check-circle', 'msg' => '<strong>Yusuf Mugenyi</strong> completed Tajweed Quiz — scored 94%', 'time' => '5 minutes ago'],
                            ['icon' => 'act-purple', 'icon_class' => 'fa-file-upload', 'msg' => '<strong>Aisha Kamara</strong> submitted assignment: Seerah Essay', 'time' => '22 minutes ago'],
                            ['icon' => 'act-gold', 'icon_class' => 'fa-exclamation-triangle', 'msg' => '<strong>Fatuma Atieno</strong> has not logged in for 7 days', 'time' => '1 hour ago'],
                            ['icon' => 'act-purple', 'icon_class' => 'fa-user-plus', 'msg' => '<strong>New student</strong> Omar Kiggundu joined Arabic Beginners', 'time' => '2 hours ago'],
                            ['icon' => 'act-red', 'icon_class' => 'fa-comment-alt', 'msg' => '<strong>Mariam Nakato</strong> asked a question in Fiqh forum', 'time' => '3 hours ago'],
                            ['icon' => 'act-green', 'icon_class' => 'fa-star', 'msg' => '<strong>Ibrahim Ssekatawa</strong> earned a Memorization Badge 🏅', 'time' => 'Yesterday, 4:30 PM'],
                        ];
                    @endphp

                    @foreach($activities as $activity)
                    <div class="activity-item">
                        <div class="activity-icon {{ $activity['icon'] }}"><i class="fas {{ $activity['icon_class'] }}"></i></div>
                        <div class="activity-text">
                            <div class="activity-msg">{!! $activity['msg'] !!}</div>
                            <div class="activity-time">{{ $activity['time'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ── PENDING ASSIGNMENTS ── --}}
    <div class="cols-2">
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Pending Assignments</div>
                    <div class="card-subtitle">Submissions awaiting your feedback</div>
                </div>
                <a href="#" class="card-link">All Assignments <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card-body">
                <div class="assignment-list">
                    @php
                        $assignments = [
                            ['icon' => 'kpi-icon-red', 'icon_class' => 'fa-file-alt', 'name' => 'Tajweed Rules — Chapter 4', 'class' => 'Tajweed Adv.', 'students' => 16, 'submitted' => 11, 'due' => 'Due Tomorrow', 'due_color' => 'var(--red)'],
                            ['icon' => 'kpi-icon-purple', 'icon_class' => 'fa-pencil-alt', 'name' => 'Five Pillars Essay', 'class' => 'Fiqh Grade 5', 'students' => 34, 'submitted' => 28, 'due' => 'Due in 3 days', 'due_color' => 'var(--gold)'],
                            ['icon' => 'kpi-icon-gold', 'icon_class' => 'fa-microphone', 'name' => 'Surah Al-Mulk Recitation', 'class' => 'Quran Level 2', 'students' => 28, 'submitted' => 7, 'due' => 'Due in 5 days', 'due_color' => 'var(--green)'],
                        ];
                    @endphp

                    @foreach($assignments as $assignment)
                    <div class="assignment-item">
                        <div class="assignment-icon {{ $assignment['icon'] }}"><i class="fas {{ $assignment['icon_class'] }}"></i></div>
                        <div class="assignment-info">
                            <div class="assignment-name">{{ $assignment['name'] }}</div>
                            <div class="assignment-meta">
                                <span><i class="fas fa-chalkboard" style="margin-right:4px;"></i>{{ $assignment['class'] }}</span>
                                <span><i class="fas fa-users" style="margin-right:4px;"></i>{{ $assignment['students'] }} students</span>
                            </div>
                        </div>
                        <div class="assignment-right">
                            <div class="assignment-due" style="color:{{ $assignment['due_color'] }};">{{ $assignment['due'] }}</div>
                            <div class="assignment-submissions">{{ $assignment['submitted'] }}/{{ $assignment['students'] }} submitted</div>
                        </div>
                        <a href="#" class="assignment-btn">Review</a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Attendance Overview</div>
                    <div class="card-subtitle">This week across all classes</div>
                </div>
                <a href="#" class="card-link">Full Report <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card-body">
                <div class="chart-wrap" style="height:200px;margin-bottom:16px;">
                    <canvas id="attendanceChart"></canvas>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:4px;">
                    <div style="background:var(--green-light);border-radius:14px;padding:14px;text-align:center;">
                        <div style="font-family:'Playfair Display',serif;font-size:1.8rem;font-weight:700;color:var(--green);">91%</div>
                        <div style="font-size:0.75rem;color:var(--green);font-weight:600;margin-top:2px;">Present Rate</div>
                    </div>
                    <div style="background:var(--red-light);border-radius:14px;padding:14px;text-align:center;">
                        <div style="font-family:'Playfair Display',serif;font-size:1.8rem;font-weight:700;color:var(--red);">9%</div>
                        <div style="font-size:0.75rem;color:var(--red);font-weight:600;margin-top:2px;">Absent Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    {{-- ADD LESSON MODAL --}}
    <div class="sd-modal" id="addLessonModal">
        <div class="sd-modal-box">
            <button class="sd-modal-close" onclick="closeAddLessonModal()"><i class="fas fa-times"></i></button>
            <div class="sd-modal-icon"><i class="fas fa-plus-circle"></i></div>
            <div class="sd-modal-title">Add New Lesson</div>
            <div class="sd-modal-sub">Create a new lesson for your students</div>

            <form id="addLessonForm" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label><strong>Lesson Number *</strong></label>
                    <input type="text" class="form-control" id="lessonNumber" placeholder="e.g., Lesson 1, Chapter 2" required>
                    <span class="text-muted-sm">Enter the lesson sequence number</span>
                </div>
                <div class="form-group">
                    <label><strong>Lesson Title *</strong></label>
                    <input type="text" class="form-control" id="lessonTitle" placeholder="Enter lesson title" required>
                </div>
                <div class="form-group">
                    <label><strong>Subject *</strong></label>
                    <select class="form-control" id="lessonSubject" required>
                        <option value="">Select Subject</option>
                        <option value="Quran & Tafsir">Quran & Tafsir</option>
                        <option value="Hadith Studies">Hadith Studies</option>
                        <option value="Fiqh">Fiqh</option>
                        <option value="Seerah">Seerah</option>
                        <option value="Arabic Language">Arabic Language</option>
                        <option value="Aqeedah">Aqeedah</option>
                        <option value="Tajweed">Tajweed</option>
                        <option value="Akhlaq (Islamic Manners)">Akhlaq (Islamic Manners)</option>
                    </select>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label><strong>Level *</strong></label>
                        <select class="form-control" id="lessonLevel" required>
                            <option value="">Select Level</option>
                            <option value="Level 1">Level 1 (P.1–P.4)</option>
                            <option value="Level 2">Level 2 (P.5–P.7)</option>
                            <option value="Level 3">Level 3 (S.1–S.3)</option>
                            <option value="Level 4">Level 4 (S.4–S.5)</option>
                            <option value="Level 5">Level 5 (S.6)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><strong>Class *</strong></label>
                        <select class="form-control" id="lessonClass" required>
                            <option value="">Select Class</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label><strong>Lesson Type *</strong></label>
                    <select class="form-control" id="lessonType" required>
                        <option value="video">Video Lesson</option>
                        <option value="audio">Audio Lesson</option>
                        <option value="pdf">PDF Notes</option>
                    </select>
                </div>
                <div class="form-group">
                    <label><strong>Content URL</strong></label>
                    <input type="text" class="form-control" id="contentUrl" placeholder="YouTube URL, audio link, or PDF link">
                    <span class="text-muted-sm">Provide a direct link to your content</span>
                </div>
                <div class="form-group">
                    <label><strong>Or Upload File</strong></label>
                    <div class="upload-area" id="uploadArea" onclick="document.getElementById('fileInput').click()">
                        <i class="fas fa-cloud-upload-alt fa-2x" style="margin-bottom:8px;color:var(--purple);"></i>
                        <p>Click to browse or drag & drop</p>
                        <span class="text-muted-sm">Supported: MP4, MP3, PDF (Max 50MB)</span>
                        <input type="file" id="fileInput" name="lesson_file" style="display:none" accept=".mp4,.mp3,.pdf">
                    </div>
                    <div id="fileInfo" style="display:none;">
                        <div class="file-alert">
                            <span><i class="fas fa-file"></i> <span id="fileName"></span></span>
                            <button type="button" class="file-alert-close" onclick="clearFile()">&times;</button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label><strong>Description</strong></label>
                    <textarea class="form-control" id="lessonDesc" rows="3" placeholder="Brief description of the lesson..."></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label><strong>Duration (minutes)</strong></label>
                        <input type="number" class="form-control" id="lessonDuration" placeholder="e.g., 15" value="15" min="1" max="60">
                    </div>
                    <div class="form-group">
                        <label><strong>Price (UGX)</strong></label>
                        <input type="number" class="form-control" id="lessonPrice" placeholder="0" value="0" step="1000">
                    </div>
                </div>
                <div class="form-group">
                    <label><strong>Status</strong></label>
                    <select class="form-control" id="lessonStatus">
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
                <div style="display:flex; gap:12px; margin-top:20px;">
                    <button type="button" class="btn-cancel" onclick="closeAddLessonModal()">Cancel</button>
                    <button type="submit" class="btn-save"><i class="fas fa-save"></i> Save Lesson</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // ── ADD LESSON MODAL ──────────────────────────────────────
        const levelClassesMap = {
            "Level 1": ["P.1", "P.2", "P.3", "P.4"],
            "Level 2": ["P.5", "P.6", "P.7"],
            "Level 3": ["S.1", "S.2", "S.3"],
            "Level 4": ["S.4", "S.5"],
            "Level 5": ["S.6"]
        };
        let selectedFile = null;

        function openAddLessonModal() {
            document.getElementById('addLessonForm').reset();
            document.getElementById('lessonClass').innerHTML = '<option value="">Select Class</option>';
            clearFile();
            document.getElementById('addLessonModal').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeAddLessonModal() {
            document.getElementById('addLessonModal').classList.remove('open');
            document.body.style.overflow = '';
            document.getElementById('addLessonForm').reset();
            document.getElementById('lessonClass').innerHTML = '<option value="">Select Class</option>';
            clearFile();
        }

        document.getElementById('addLessonBtn').addEventListener('click', function(e) {
            e.preventDefault();
            openAddLessonModal();
        });

        document.getElementById('lessonLevel').addEventListener('change', function() {
            const classSelect = document.getElementById('lessonClass');
            classSelect.innerHTML = '<option value="">Select Class</option>';
            if (this.value && levelClassesMap[this.value]) {
                levelClassesMap[this.value].forEach(c => {
                    const opt = document.createElement('option');
                    opt.value = `${this.value} (${c})`;
                    opt.textContent = c;
                    classSelect.appendChild(opt);
                });
            }
        });

        document.getElementById('fileInput').addEventListener('change', function() {
            if (this.files && this.files[0]) {
                selectedFile = this.files[0];
                if (selectedFile.size > 50 * 1024 * 1024) {
                    alert('File size exceeds 50MB limit');
                    this.value = '';
                    selectedFile = null;
                    document.getElementById('fileInfo').style.display = 'none';
                    return;
                }
                document.getElementById('fileName').textContent = 
                    `${selectedFile.name} (${(selectedFile.size / (1024 * 1024)).toFixed(2)} MB)`;
                document.getElementById('fileInfo').style.display = 'block';
            }
        });

        function clearFile() {
            selectedFile = null;
            document.getElementById('fileInput').value = '';
            document.getElementById('fileInfo').style.display = 'none';
        }

        document.getElementById('addLessonModal').addEventListener('click', function(e) {
            if (e.target === this) closeAddLessonModal();
        });

        document.getElementById('addLessonForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData();
            formData.append('lesson_number', document.getElementById('lessonNumber').value);
            formData.append('lesson_title', document.getElementById('lessonTitle').value);
            formData.append('lesson_subject', document.getElementById('lessonSubject').value);
            formData.append('lesson_level', document.getElementById('lessonLevel').value);
            formData.append('lesson_class', document.getElementById('lessonClass').value);
            formData.append('lesson_type', document.getElementById('lessonType').value);
            formData.append('content_url', document.getElementById('contentUrl').value);
            formData.append('lesson_desc', document.getElementById('lessonDesc').value);
            formData.append('lesson_duration', document.getElementById('lessonDuration').value);
            formData.append('lesson_price', document.getElementById('lessonPrice').value);
            formData.append('lesson_status', document.getElementById('lessonStatus').value);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');
            if (selectedFile) formData.append('lesson_file', selectedFile);

            fetch('/teacher/upload-lesson', {
                method: 'POST',
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    closeAddLessonModal();
                    alert('Lesson saved successfully!');
                } else {
                    alert(data.message || 'Something went wrong');
                }
            })
            .catch(() => alert('Failed to save lesson. Please try again.'));
        });

        // ── Engagement Line Chart ──────────────────────────────────
        const engCtx = document.getElementById('engagementChart').getContext('2d');
        const engGrad = engCtx.createLinearGradient(0, 0, 0, 240);
        engGrad.addColorStop(0, 'rgba(107,70,193,0.3)');
        engGrad.addColorStop(1, 'rgba(107,70,193,0)');

        new Chart(engCtx, {
            type: 'line',
            data: {
                labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                datasets: [{
                    label: 'Completions',
                    data: [42, 68, 54, 89, 73, 95, 61],
                    borderColor: '#6B46C1',
                    backgroundColor: engGrad,
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.45,
                    pointBackgroundColor: '#6B46C1',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }, {
                    label: 'Logins',
                    data: [55, 80, 66, 102, 88, 110, 74],
                    borderColor: '#DC2626',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.45,
                    pointBackgroundColor: '#DC2626',
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    borderDash: [5, 3],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 10,
                            boxHeight: 10,
                            font: { family: 'DM Sans', size: 11 },
                            color: '#6B6584',
                            usePointStyle: true,
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1A0A2E',
                        titleFont: { family: 'Playfair Display', size: 13 },
                        bodyFont: { family: 'DM Sans', size: 12 },
                        padding: 12,
                        cornerRadius: 12,
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(107,70,193,0.08)' },
                        ticks: { font: { family: 'DM Sans', size: 11 }, color: '#6B6584' }
                    },
                    y: {
                        grid: { color: 'rgba(107,70,193,0.08)' },
                        ticks: { font: { family: 'DM Sans', size: 11 }, color: '#6B6584' }
                    }
                }
            }
        });

        // ── Attendance Doughnut Chart ─────────────────────────────
        const attCtx = document.getElementById('attendanceChart').getContext('2d');
        new Chart(attCtx, {
            type: 'doughnut',
            data: {
                labels: ['Present', 'Absent', 'Late'],
                datasets: [{
                    data: [91, 6, 3],
                    backgroundColor: ['#16A34A', '#DC2626', '#D97706'],
                    borderColor: '#FDFBF7',
                    borderWidth: 3,
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 10,
                            boxHeight: 10,
                            font: { family: 'DM Sans', size: 11 },
                            color: '#6B6584',
                            padding: 12,
                            usePointStyle: true,
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1A0A2E',
                        titleFont: { family: 'Playfair Display', size: 13 },
                        bodyFont: { family: 'DM Sans', size: 12 },
                        padding: 12,
                        cornerRadius: 12,
                    }
                }
            }
        });
    </script>
@endsection