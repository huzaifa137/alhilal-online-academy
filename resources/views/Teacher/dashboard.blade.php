@extends('Teacher.layouts.teacher-master')

@section('title', 'Teacher Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Teacher Dashboard')

@section('additional-css')
<style>
    .welcome-banner{background:linear-gradient(135deg,#1A0A2E 0%,#2D0F5C 50%,#4A1A1A 100%);border-radius:24px;padding:32px 40px;display:flex;align-items:center;justify-content:space-between;position:relative;overflow:hidden;}
    .welcome-banner::before{content:'';position:absolute;inset:0;background-image:repeating-linear-gradient(0deg,transparent,transparent 60px,rgba(255,255,255,.02) 60px,rgba(255,255,255,.02) 61px),repeating-linear-gradient(90deg,transparent,transparent 60px,rgba(255,255,255,.02) 60px,rgba(255,255,255,.02) 61px);}
    .welcome-orb-1{position:absolute;width:300px;height:300px;border-radius:50%;background:radial-gradient(circle,rgba(107,70,193,.3) 0%,transparent 70%);top:-80px;right:100px;pointer-events:none;}
    .welcome-orb-2{position:absolute;width:200px;height:200px;border-radius:50%;background:radial-gradient(circle,rgba(220,38,38,.2) 0%,transparent 70%);bottom:-60px;right:40px;pointer-events:none;}
    .welcome-text{position:relative;z-index:2;}
    .welcome-eyebrow{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);padding:5px 14px;border-radius:40px;font-size:.72rem;color:rgba(255,255,255,.7);letter-spacing:1.5px;text-transform:uppercase;font-weight:600;margin-bottom:14px;}
    .welcome-dot{width:7px;height:7px;border-radius:50%;background:#4ade80;box-shadow:0 0 8px rgba(74,222,128,.6);animation:pulse-dot 2s ease-in-out infinite;}
    @keyframes pulse-dot{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.6;transform:scale(1.3)}}
    .welcome-title{font-size:1.8rem;font-weight:700;color:white;margin-bottom:8px;}
    .welcome-title span{background:linear-gradient(135deg,#C084FC,#F87171);-webkit-background-clip:text;background-clip:text;color:transparent;}
    .welcome-sub{font-size:.9rem;color:rgba(255,255,255,.55);}
    .welcome-actions{position:relative;z-index:2;display:flex;gap:10px;align-items:center;}
    .btn-banner{display:inline-flex;align-items:center;gap:8px;padding:11px 22px;border-radius:40px;font-weight:600;font-size:.85rem;text-decoration:none;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all .25s;}
    .btn-banner-primary{background:var(--gradient);color:white;box-shadow:0 6px 20px rgba(107,70,193,.35);}
    .btn-banner-primary:hover{transform:translateY(-2px);box-shadow:0 10px 28px rgba(107,70,193,.45);color:white;}
    .btn-banner-ghost{background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);color:white;backdrop-filter:blur(8px);}
    .btn-banner-ghost:hover{background:rgba(255,255,255,.18);color:white;}
    .kpi-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;}
    .kpi-card{background:white;border-radius:20px;padding:24px;border:1px solid var(--border);position:relative;overflow:hidden;transition:all .25s;}
    .kpi-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:var(--gradient);transform:scaleX(0);transform-origin:left;transition:transform .3s;}
    .kpi-card:hover{transform:translateY(-4px);box-shadow:var(--shadow-md);}
    .kpi-card:hover::before{transform:scaleX(1);}
    .kpi-top{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px;}
    .kpi-icon{width:46px;height:46px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;}
    .kpi-icon-purple{background:var(--purple-light);color:var(--purple);}
    .kpi-icon-red{background:var(--red-light);color:var(--red);}
    .kpi-icon-gold{background:var(--gold-light);color:var(--gold);}
    .kpi-icon-green{background:var(--green-light);color:var(--green);}
    .kpi-num{font-family:'Playfair Display',serif;font-size:2.2rem;font-weight:700;color:var(--ink);line-height:1;margin-bottom:4px;}
    .kpi-label{font-size:.8rem;color:var(--muted);font-weight:500;}
    .kpi-sub{font-size:.72rem;color:var(--muted);margin-top:8px;padding-top:8px;border-top:1px solid var(--border);}
    .cols-2{display:grid;grid-template-columns:1fr 1fr;gap:22px;}
    .cols-3{display:grid;grid-template-columns:2fr 1fr;gap:22px;}
    .chart-wrap{position:relative;height:240px;}
    .class-list{display:flex;flex-direction:column;gap:0;}
    .class-item{display:flex;align-items:center;gap:14px;padding:14px 0;border-bottom:1px solid var(--border);transition:background .2s;}
    .class-item:last-child{border-bottom:none;}
    .class-color-bar{width:4px;height:42px;border-radius:4px;flex-shrink:0;}
    .class-info{flex:1;}
    .class-name{font-size:.9rem;font-weight:600;color:var(--ink);margin-bottom:3px;}
    .class-meta{font-size:.74rem;color:var(--muted);display:flex;gap:12px;}
    .class-actions{display:flex;gap:8px;}
    .btn-sm-action{padding:6px 14px;border-radius:30px;font-size:.74rem;font-weight:600;border:none;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:all .2s;font-family:'DM Sans',sans-serif;}
    .btn-sm-purple{background:var(--purple-light);color:var(--purple);}
    .btn-sm-purple:hover{background:var(--purple);color:white;}
    .student-table{width:100%;border-collapse:collapse;}
    .student-table th{text-align:left;font-size:.7rem;font-weight:600;letter-spacing:1.2px;text-transform:uppercase;color:var(--muted);padding:0 16px 12px;border-bottom:1px solid var(--border);}
    .student-table td{padding:14px 16px;font-size:.85rem;border-bottom:1px solid var(--border);vertical-align:middle;}
    .student-table tr:last-child td{border-bottom:none;}
    .student-cell{display:flex;align-items:center;gap:10px;}
    .student-ava{width:34px;height:34px;border-radius:50%;background:var(--gradient);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:.8rem;flex-shrink:0;}
    .student-name{font-weight:600;color:var(--ink);font-size:.85rem;}
    .student-class{font-size:.72rem;color:var(--muted);}
    .activity-list{display:flex;flex-direction:column;}
    .activity-item{display:flex;gap:12px;align-items:flex-start;padding:14px 0;border-bottom:1px solid var(--border);}
    .activity-item:last-child{border-bottom:none;}
    .activity-icon{width:36px;height:36px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:.9rem;flex-shrink:0;}
    .activity-text{flex:1;}
    .activity-msg{font-size:.83rem;color:var(--ink);font-weight:500;line-height:1.4;}
    .activity-msg strong{color:var(--purple);}
    .activity-time{font-size:.7rem;color:var(--muted);margin-top:3px;}
    .quick-actions-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;}
    .qa-btn{display:flex;flex-direction:column;align-items:center;gap:10px;padding:20px 12px;background:white;border:1px solid var(--border);border-radius:18px;text-decoration:none;cursor:pointer;transition:all .25s;position:relative;overflow:hidden;font-family:'DM Sans',sans-serif;}
    .qa-btn::before{content:'';position:absolute;bottom:0;left:0;right:0;height:3px;background:var(--gradient);transform:scaleX(0);transition:transform .25s;transform-origin:left;}
    .qa-btn:hover{transform:translateY(-4px);box-shadow:var(--shadow-md);border-color:var(--border2);}
    .qa-btn:hover::before{transform:scaleX(1);}
    .qa-icon{width:46px;height:46px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;}
    .qa-label{font-size:.8rem;font-weight:600;color:var(--ink);text-align:center;}
    .status-badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:.7rem;font-weight:600;}
    .status-active{background:var(--green-light);color:var(--green);}
    .status-pending{background:var(--gold-light);color:var(--gold);}
    @media(max-width:1200px){.kpi-grid{grid-template-columns:repeat(2,1fr)}}
    @media(max-width:900px){.cols-2,.cols-3{grid-template-columns:1fr}.welcome-banner{flex-direction:column;gap:20px;align-items:flex-start}}
    @media(max-width:600px){.kpi-grid{grid-template-columns:1fr}.quick-actions-grid{grid-template-columns:repeat(2,1fr)}}
</style>
@endsection

@section('content')

@php
    $gradients = [
        'var(--gradient)',
        'linear-gradient(135deg,var(--red),var(--gold))',
        'linear-gradient(135deg,var(--green),#0EA5E9)',
        'linear-gradient(135deg,#7C3AED,#0EA5E9)',
        'linear-gradient(135deg,var(--gold),var(--red))',
        'linear-gradient(135deg,#DB2777,var(--purple))',
    ];
@endphp

{{-- Welcome Banner --}}
<div class="welcome-banner">
    <div class="welcome-orb-1"></div>
    <div class="welcome-orb-2"></div>
    <div class="welcome-text">
        <div class="welcome-eyebrow">
            <span class="welcome-dot"></span>
            {{ now()->format('l, d M Y') }}
        </div>
        <div class="welcome-title">
            Assalamu Alaikum, <span>{{ $teacher->firstname ?? ($teacher->fullname ?? 'Teacher') }}</span>
        </div>
        <div class="welcome-sub">
            You are teaching <strong style="color:#C084FC;">{{ $assignedClassesCount }} active class{{ $assignedClassesCount != 1 ? 'es' : '' }}</strong>
            with <strong style="color:#F87171;">{{ $totalStudents }} enrolled student{{ $totalStudents != 1 ? 's' : '' }}</strong>.
        </div>
    </div>
    <div class="welcome-actions">
        <a href="{{ route('teacher.lessons.create') }}" class="btn-banner btn-banner-primary">
            <i class="fas fa-plus"></i> Add Lesson
        </a>
        <a href="{{ route('teacher.lessons.lists') }}" class="btn-banner btn-banner-ghost">
            <i class="fas fa-book-open"></i> My Lessons
        </a>
    </div>
</div>

{{-- KPI Stats --}}
<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon kpi-icon-purple"><i class="fas fa-users"></i></div>
        </div>
        <div class="kpi-num">{{ $totalStudents }}</div>
        <div class="kpi-label">Total Students</div>
        <div class="kpi-sub">Across <strong>{{ $assignedClassesCount }}</strong> active classes</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon kpi-icon-red"><i class="fas fa-chalkboard"></i></div>
        </div>
        <div class="kpi-num">{{ $assignedClassesCount }}</div>
        <div class="kpi-label">Active Classes</div>
        <div class="kpi-sub">You are currently teaching</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon kpi-icon-gold"><i class="fas fa-book"></i></div>
        </div>
        <div class="kpi-num">{{ $totalLessons }}</div>
        <div class="kpi-label">Total Lessons</div>
        <div class="kpi-sub"><strong>{{ $publishedLessons }}</strong> published · {{ $totalLessons - $publishedLessons }} drafts</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon kpi-icon-green"><i class="fas fa-chart-line"></i></div>
        </div>
        <div class="kpi-num">{{ $avgCompletionRate }}%</div>
        <div class="kpi-label">Avg. Completion Rate</div>
        <div class="kpi-sub"><strong>{{ $totalQuizzes }}</strong> quizzes created</div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Quick Actions</div>
            <div class="card-subtitle">Jump straight to your most common tasks</div>
        </div>
    </div>
    <div class="card-body">
        <div class="quick-actions-grid">
            <a href="{{ route('teacher.lessons.create') }}" class="qa-btn">
                <div class="qa-icon kpi-icon-purple"><i class="fas fa-plus-circle"></i></div>
                <div class="qa-label">Add Lesson</div>
            </a>
            <a href="{{ route('teacher.lessons.lists') }}" class="qa-btn">
                <div class="qa-icon kpi-icon-red"><i class="fas fa-list"></i></div>
                <div class="qa-label">My Lessons</div>
            </a>
            <a href="{{ route('teacher.enrollments.index') }}" class="qa-btn">
                <div class="qa-icon kpi-icon-gold"><i class="fas fa-user-plus"></i></div>
                <div class="qa-label">Enrollments</div>
            </a>
            <a href="{{ route('teacher.quizzes.create') }}" class="qa-btn">
                <div class="qa-icon kpi-icon-green"><i class="fas fa-pencil-alt"></i></div>
                <div class="qa-label">Create Quiz</div>
            </a>
            <a href="{{ route('teacher.quizzes.index') }}" class="qa-btn">
                <div class="qa-icon" style="background:#EDE9FA;color:#7C3AED;"><i class="fas fa-question-circle"></i></div>
                <div class="qa-label">My Quizzes</div>
            </a>
            <a href="{{ route('teacher.settings.index') }}" class="qa-btn">
                <div class="qa-icon" style="background:#DBEAFE;color:#2563EB;"><i class="fas fa-cog"></i></div>
                <div class="qa-label">Settings</div>
            </a>
            <a href="{{ route('teacher.lessons.index') }}" class="qa-btn">
                <div class="qa-icon" style="background:#FCE7F3;color:#DB2777;"><i class="fas fa-book-open"></i></div>
                <div class="qa-label">All Lessons</div>
            </a>
            <a href="#" class="qa-btn">
                <div class="qa-icon" style="background:#D1FAE5;color:#059669;"><i class="fas fa-chart-bar"></i></div>
                <div class="qa-label">Reports</div>
            </a>
        </div>
    </div>
</div>

{{-- My Classes --}}
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">My Classes</div>
            <div class="card-subtitle">Active classes you're teaching this term</div>
        </div>
        <a href="{{ route('teacher.enrollments.index') }}" class="card-link">Manage Enrollments <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="card-body" style="padding-top:0;">
        @if($dashboardClasses->count() > 0)
        <div class="class-list">
            @foreach($dashboardClasses as $i => $class)
            <div class="class-item">
                <div class="class-color-bar" style="background:{{ $gradients[$i % count($gradients)] }};"></div>
                <div class="class-info">
                    <div class="class-name">{{ $class->name }}</div>
                    <div class="class-meta">
                        <span><i class="fas fa-graduation-cap"></i>{{ $class->level->name ?? 'N/A' }}</span>
                        @php $studentCount = \App\Models\Academic\ClassEnrollment::where('class_id',$class->id)->where('status','active')->count(); @endphp
                        <span><i class="fas fa-users"></i>{{ $studentCount }} Students</span>
                        @php $lessonCount = \App\Models\Academic\Lesson::whereHas('topic', fn($q)=>$q->where('class_id',$class->id))->where('teacher_id', session('LoggedTeacher'))->count(); @endphp
                        <span><i class="fas fa-book"></i>{{ $lessonCount }} Lessons</span>
                    </div>
                </div>
                <div class="class-actions">
                    <a href="{{ route('teacher.lessons.lists') }}" class="btn-sm-action btn-sm-purple"><i class="fas fa-eye"></i> View Lessons</a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p style="color:var(--muted);padding:20px 0;">No classes assigned yet. Contact admin to get assigned to classes.</p>
        @endif
    </div>
</div>

{{-- Students + Activity --}}
<div class="cols-2">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Recent Enrollments</div>
                <div class="card-subtitle">Latest students enrolled in your classes</div>
            </div>
            <a href="{{ route('teacher.enrollments.index') }}" class="card-link">All <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="card-body" style="padding:0 24px;">
            <table class="student-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Class</th>
                        <th>Payment</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentEnrollments as $enrollment)
                    <tr>
                        <td>
                            <div class="student-cell">
                                <div class="student-ava">{{ strtoupper(substr($enrollment->student->firstname ?? 'S', 0, 1) . substr($enrollment->student->lastname ?? 'T', 0, 1)) }}</div>
                                <div>
                                    <div class="student-name">{{ $enrollment->student->firstname ?? '' }} {{ $enrollment->student->lastname ?? 'Unknown' }}</div>
                                    <div class="student-class">{{ $enrollment->student->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:.82rem;">{{ $enrollment->class->name ?? '—' }}</td>
                        <td>
                            <span class="status-badge {{ $enrollment->payment_status === 'paid' ? 'status-active' : 'status-pending' }}">
                                <i class="fas fa-circle" style="font-size:5px;"></i>
                                {{ ucfirst($enrollment->payment_status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" style="text-align:center;color:var(--muted);padding:24px;">No enrollments yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Recent Activity</div>
                <div class="card-subtitle">Latest lesson completions by students</div>
            </div>
        </div>
        <div class="card-body" style="padding-top:0;">
            <div class="activity-list">
                @forelse($recentCompletions as $completion)
                <div class="activity-item">
                    <div class="activity-icon" style="background:var(--green-light);color:var(--green);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="activity-text">
                        <div class="activity-msg">
                            <strong>{{ $completion->student->firstname ?? 'Student' }} {{ $completion->student->lastname ?? '' }}</strong>
                            completed <em>{{ $completion->lesson->title ?? 'a lesson' }}</em>
                        </div>
                        <div class="activity-time">{{ $completion->completed_at ? $completion->completed_at->diffForHumans() : 'Recently' }}</div>
                    </div>
                </div>
                @empty
                <div style="padding:20px 0;color:var(--muted);font-size:.85rem;">No lesson completions recorded yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Simple engagement chart placeholder
const engCtx = document.createElement('canvas');
// Only render if element exists
</script>
@endsection
