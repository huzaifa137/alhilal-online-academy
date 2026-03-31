<?php
use App\Http\Controllers\Helper;
use App\Http\Controllers\Controller;
$controller = new Controller();
?>
@extends('layouts-side-bar.master')
@section('css')
    <!---jvectormap css-->
    <link href="{{ URL::asset('assets/plugins/jvectormap/jqvmap.css') }}" rel="stylesheet" />
    <!-- Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <!--Daterangepicker css-->
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
    <style>
        /* Dashboard Custom Styles */
        .dashboard-card {
            position: relative;
            overflow: hidden;
            border-radius: 1rem;
            transition: all 0.3s ease;
            min-height: 130px;
            cursor: pointer;
            border: none;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.15);
        }
        .dashboard-icon {
            font-size: 2rem;
            padding: 0.75rem;
            border-radius: 1rem;
            background: rgba(255, 255, 255, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        .dashboard-card:hover .dashboard-icon {
            transform: scale(1.1);
        }
        .card-overlay {
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1), transparent 70%);
            transform: rotate(45deg);
            pointer-events: none;
            z-index: 1;
        }
        .dashboard-card .card-body {
            position: relative;
            z-index: 2;
            padding: 1.25rem;
        }
        .card-metric {
            font-weight: 700;
            font-size: 1.75rem;
            line-height: 1.2;
            margin-bottom: 0.25rem;
        }
        .label-sub {
            font-size: 0.75rem;
            opacity: 0.9;
            margin-top: 0.25rem;
        }
        .card-title {
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        .progress-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            position: relative;
            background: conic-gradient(#7c3a8c 0deg, #e9ecef 0deg);
        }
        .progress-circle-inner {
            width: 65px;
            height: 65px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: bold;
            color: #7c3a8c;
        }
        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: all 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        .honors-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.7rem;
            font-weight: 600;
            display: inline-block;
        }
        .badge-first { background: #ffd700; color: #856404; }
        .badge-second { background: #c0c0c0; color: #2c3e50; }
        .badge-third { background: #cd7f32; color: white; }
        .badge-fourth { background: #28a745; color: white; }
        .badge-failed { background: #dc3545; color: white; }
        .badge-pending { background: #ffc107; color: #856404; }
        .lesson-progress {
            height: 6px;
            border-radius: 3px;
            background: #e9ecef;
        }
        .lesson-progress-bar {
            background: linear-gradient(90deg, #7c3a8c, #9b4d96);
            border-radius: 3px;
            height: 100%;
            transition: width 0.5s ease;
        }
        .recent-lesson-item {
            border-left: 3px solid #7c3a8c;
            transition: all 0.2s;
        }
        .recent-lesson-item:hover {
            background: #f8f9fa;
            transform: translateX(5px);
        }
        .upcoming-exam {
            border-left: 3px solid #ffc107;
        }
        .completed-exam {
            border-left: 3px solid #28a745;
        }
        .payment-card {
            border-left: 3px solid #17a2b8;
        }
        .cert-card {
            transition: all 0.2s;
            cursor: pointer;
        }
        .cert-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        .welcome-banner {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            border-radius: 1rem;
            padding: 1.5rem;
            color: white;
            margin-bottom: 1.5rem;
        }
        .nav-pills-custom .nav-link {
            border-radius: 2rem;
            padding: 0.5rem 1.5rem;
            margin: 0 0.25rem;
            color: #6c757d;
            transition: all 0.2s;
        }
        .nav-pills-custom .nav-link.active {
            background: #7c3a8c;
            color: white;
        }
        .nav-pills-custom .nav-link:hover:not(.active) {
            background: #f0e6ff;
            color: #7c3a8c;
        }
        .level-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        .level-card {
            background: white;
            border-radius: 1rem;
            padding: 1rem;
            text-align: center;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: all 0.2s;
            position: relative;
        }
        .level-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        .level-locked {
            opacity: 0.7;
            background: #f8f9fa;
        }
        .level-badge {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #28a745;
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }
        .notification-badge {
            position: relative;
        }
        .notification-dot {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 10px;
            height: 10px;
            background: #dc3545;
            border-radius: 50%;
        }
        .language-selector {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            background: white;
            border-radius: 30px;
            padding: 8px 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="side-app">
        <!-- Language Selector -->
        <div class="language-selector" onclick="Swal.fire('Language', 'Select your preferred language: Arabic, English, Luganda, or Swahili', 'info')">
            <i class="bi bi-globe"></i> <span id="currentLang">English</span> <i class="bi bi-chevron-down"></i>
        </div>

        <!-- Welcome Banner with Student Info -->
        <div class="welcome-banner">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="mb-2">
                        <i class="bi bi-emoji-smile"></i> السلام عليكم, 
                        @if (!empty($student->firstname) && !empty($student->lastname))
                            {{ $student->firstname }} {{ $student->lastname }}
                        @else
                            {{ @$student->username ?? 'Amina Hassan' }}
                        @endif
                    </h3>
                    <p class="mb-0">Continue your journey in Islamic knowledge. Track your progress and earn certifications.</p>
                    <p class="mb-0 mt-1">
                        <small><i class="bi bi-mortarboard"></i> {{ $student->level ?? 'Level 3 (S.1-S.3)' }} | 
                        <i class="bi bi-envelope"></i> {{ $student->email ?? 'amina@alhilal.edu' }} |
                        <i class="bi bi-card-text"></i> Reg: {{ $student->reg_number ?? 'L3-2024-001' }}</small>
                    </p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="progress-circle" id="overallProgress">
                        <div class="progress-circle-inner">
                            @php
                                $totalLessonsValue = isset($totalLessons) && $totalLessons > 0 ? $totalLessons : 48;
                                $completedLessonsValue = isset($completedLessons) ? $completedLessons : 32;
                                $overallPercent = $totalLessonsValue > 0 ? round(($completedLessonsValue / $totalLessonsValue) * 100) : 0;
                            @endphp
                            {{ $overallPercent }}%
                        </div>
                    </div>
                    <small class="mt-2 d-block">Overall Progress</small>
                </div>
            </div>
        </div>

        <!-- Statistics Cards Row - FIXED DIVISION BY ZERO -->
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="dashboard-card text-white" style="background: linear-gradient(135deg, #1e3c72, #2a5298);">
                    <div class="card-overlay"></div>
                    <div class="card-body d-flex align-items-center">
                        <div class="dashboard-icon me-3"><i class="bi bi-mortarboard-fill"></i></div>
                        <div>
                            <div class="card-title">Levels Enrolled</div>
                            <div class="card-metric">{{ $coursesCount ?? 4 }}</div>
                            <div class="label-sub"><i class="bi bi-arrow-up"></i> P.1 – S.6</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="dashboard-card text-white" style="background: linear-gradient(135deg, #4e54c8, #8f94fb);">
                    <div class="card-overlay"></div>
                    <div class="card-body d-flex align-items-center">
                        <div class="dashboard-icon me-3"><i class="bi bi-layers-fill"></i></div>
                        <div>
                            <div class="card-title">Modules Completed</div>
                            <div class="card-metric">{{ $modulesCount ?? 12 }}</div>
                            <div class="label-sub"><i class="bi bi-book"></i> Islamic Studies</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="dashboard-card text-white" style="background: linear-gradient(135deg, #11998e, #38ef7d);">
                    <div class="card-overlay"></div>
                    <div class="card-body d-flex align-items-center">
                        <div class="dashboard-icon me-3"><i class="bi bi-bookmark-check-fill"></i></div>
                        <div>
                            <div class="card-title">Lessons Completed</div>
                            @php
                                $safeTotalLessons = isset($totalLessons) && $totalLessons > 0 ? $totalLessons : 48;
                                $safeCompletedLessons = isset($completedLessons) ? $completedLessons : 32;
                                $progressPercentage = $safeTotalLessons > 0 ? round(($safeCompletedLessons / $safeTotalLessons) * 100, 1) : 0;
                            @endphp
                            <div class="card-metric">{{ $safeCompletedLessons }}/{{ $safeTotalLessons }}</div>
                            <div class="label-sub">Progress: {{ $progressPercentage }}%</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="dashboard-card text-dark" style="background: linear-gradient(135deg, #f7971e, #ffd200);">
                    <div class="card-overlay"></div>
                    <div class="card-body d-flex align-items-center">
                        <div class="dashboard-icon me-3 bg-light text-dark"><i class="bi bi-award-fill"></i></div>
                        <div>
                            <div class="card-title">Quizzes Passed</div>
                            <div class="card-metric">{{ $quizzesPassed ?? 6 }}/{{ $quizzesTaken ?? 8 }}</div>
                            <div class="label-sub">Avg Score: {{ $averageScore ?? 76 }}%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- P.1–S.6 Levels Grid -->
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title"><i class="bi bi-grid-3x3-gap-fill"></i> Your Learning Path - P.1 to S.6</h3>
            </div>
            <div class="card-body">
                <div class="level-grid">
                    @php
                        $levels = [
                            ['name' => 'Level 1', 'range' => 'P.1 - P.4', 'progress' => 100, 'honors' => 'First Class Honors', 'locked' => false, 'icon' => '1-circle-fill'],
                            ['name' => 'Level 2', 'range' => 'P.5 - P.7', 'progress' => 100, 'honors' => 'Second Class Honors', 'locked' => false, 'icon' => '2-circle-fill'],
                            ['name' => 'Level 3', 'range' => 'S.1 - S.3', 'progress' => 75, 'honors' => 'In Progress', 'locked' => false, 'icon' => '3-circle-fill'],
                            ['name' => 'Level 4', 'range' => 'S.4 - S.5', 'progress' => 0, 'honors' => 'Locked', 'locked' => true, 'icon' => '4-circle-fill'],
                            ['name' => 'Level 5', 'range' => 'S.6', 'progress' => 0, 'honors' => 'Locked', 'locked' => true, 'icon' => '5-circle-fill']
                        ];
                    @endphp
                    @foreach($levels as $level)
                    <div class="level-card {{ $level['locked'] ? 'level-locked' : '' }}" style="position: relative;">
                        @if($level['progress'] == 100)<div class="level-badge"><i class="bi bi-check-lg"></i></div>@endif
                        <i class="bi bi-{{ $level['icon'] }}" style="font-size: 2rem; color: {{ $level['locked'] ? '#6c757d' : '#7c3a8c' }};"></i>
                        <h5 class="mt-2">{{ $level['name'] }}</h5>
                        <p class="small text-muted">{{ $level['range'] }}</p>
                        <span class="honors-badge {{ $level['honors'] == 'First Class Honors' ? 'badge-first' : ($level['honors'] == 'Second Class Honors' ? 'badge-second' : ($level['honors'] == 'In Progress' ? 'badge-info' : 'badge-secondary')) }}">
                            {{ $level['honors'] }}
                        </span>
                        <div class="lesson-progress mt-2"><div class="lesson-progress-bar" style="width: {{ $level['progress'] }}%"></div></div>
                        <small>{{ $level['progress'] }}% Complete</small>
                        @if($level['locked'])<small class="d-block text-muted mt-1">Complete previous level to unlock</small>@endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <ul class="nav nav-pills nav-pills-custom mb-4" id="dashboardTabs" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#homeTab"><i class="bi bi-speedometer2"></i> Home</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#lessonsTab"><i class="bi bi-book"></i> Lessons</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#paymentsTab"><i class="bi bi-credit-card"></i> Payments</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#examsTab"><i class="bi bi-pencil-square"></i> Exams</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reportsTab"><i class="bi bi-file-text"></i> Reports</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#certificatesTab"><i class="bi bi-award"></i> Certificates</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#notificationsTab"><i class="bi bi-bell notification-badge"><span class="notification-dot"></span></i> Notifications</a></li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Home Tab -->
            <div class="tab-pane fade show active" id="homeTab">
                <div class="row">
                    <div class="col-lg-6"><div class="card"><div class="card-body"><div id="chart-pie2" style="height: 350px;"></div></div></div></div>
                    <div class="col-lg-6"><div class="card"><div class="card-body"><div id="lessonsPieChart" style="height: 350px;"></div></div></div></div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <div class="card"><div class="card-header"><h3 class="card-title"><i class="bi bi-clock-history"></i> Recent Lessons</h3></div>
                        <div class="card-body">
                            @php
                                $recentLessons = [
                                    ['title' => 'Surah Al-Fatihah - Tafsir and Meaning', 'subject' => 'Qur\'an & Tafsir', 'duration' => '25 min', 'progress' => 100, 'completed' => true],
                                    ['title' => 'The 5 Pillars of Islam - Fiqh Essentials', 'subject' => 'Fiqh', 'duration' => '30 min', 'progress' => 100, 'completed' => true],
                                    ['title' => 'Prophet Muhammad ﷺ - Early Life (Seerah)', 'subject' => 'Seerah & Hadith', 'duration' => '20 min', 'progress' => 100, 'completed' => true],
                                    ['title' => 'Arabic Grammar - Noun Cases (I\'rab)', 'subject' => 'Lugha', 'duration' => '35 min', 'progress' => 60, 'completed' => false],
                                    ['title' => 'Hadith 1: Intentions - 40 Hadith Nawawi', 'subject' => 'Hadith Sciences', 'duration' => '15 min', 'progress' => 40, 'completed' => false]
                                ];
                            @endphp
                            @foreach($recentLessons as $lesson)
                            <div class="recent-lesson-item p-3 mb-2 bg-white rounded shadow-sm">
                                <div class="d-flex justify-content-between">
                                    <div><h6 class="mb-1">{{ $lesson['title'] }}</h6><small class="text-muted">{{ $lesson['subject'] }} | {{ $lesson['duration'] }}</small></div>
                                    <div>@if($lesson['completed'])<span class="badge badge-success"><i class="bi bi-check-circle"></i> Completed</span>@else<span class="badge badge-primary">{{ $lesson['progress'] }}%</span><button class="btn btn-sm btn-primary ml-2" onclick="continueLesson('{{ $lesson['title'] }}')">Continue</button>@endif</div>
                                </div>
                                @if(!$lesson['completed'])<div class="lesson-progress mt-2"><div class="lesson-progress-bar" style="width: {{ $lesson['progress'] }}%"></div></div>@endif
                            </div>
                            @endforeach
                        </div></div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card"><div class="card-header"><h3 class="card-title"><i class="bi bi-star"></i> Subject Performance</h3></div>
                        <div class="card-body">
                            @php
                                $subjects = [
                                    ['name' => 'Qur\'an & Tafsir', 'progress' => 85, 'completed' => 10, 'total' => 12, 'icon' => 'book'],
                                    ['name' => 'Fiqh (Islamic Jurisprudence)', 'progress' => 78, 'completed' => 8, 'total' => 10, 'icon' => 'balance-scale'],
                                    ['name' => 'Seerah & Hadith', 'progress' => 92, 'completed' => 7, 'total' => 8, 'icon' => 'star'],
                                    ['name' => 'Lugha (Arabic Language)', 'progress' => 65, 'completed' => 6, 'total' => 10, 'icon' => 'language'],
                                    ['name' => 'Aqeedah (Islamic Creed)', 'progress' => 88, 'completed' => 7, 'total' => 8, 'icon' => 'heart']
                                ];
                            @endphp
                            @foreach($subjects as $subject)
                            <div class="stat-card"><div class="d-flex justify-content-between"><span><i class="bi bi-{{ $subject['icon'] }} me-2"></i><strong>{{ $subject['name'] }}</strong></span><span class="badge badge-info">{{ $subject['progress'] }}%</span></div>
                            <div class="lesson-progress mt-1"><div class="lesson-progress-bar" style="width: {{ $subject['progress'] }}%"></div></div>
                            <small class="text-muted">{{ $subject['completed'] }}/{{ $subject['total'] }} lessons completed</small></div>
                            @endforeach
                        </div></div>
                    </div>
                </div>
            </div>

            <!-- Lessons Tab -->
            <div class="tab-pane fade" id="lessonsTab">
                <div class="card"><div class="card-header"><h3 class="card-title"><i class="bi bi-mortarboard"></i> Course Progress</h3></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light"><tr><th>#</th><th>Level / Course</th><th>Progress</th><th>Status</th><th>Honors</th><th>Certificate</th> </thead>
                            <tbody>
                                @php
                                    $courseProgress = [
                                        ['title' => 'Level 1: Qur\'an & Islamic Studies (P.1-P.4)', 'percentage' => 100, 'isCompleted' => true, 'modules' => 8, 'honors' => 'First Class Honors'],
                                        ['title' => 'Level 2: Advanced Qur\'an & Fiqh (P.5-P.7)', 'percentage' => 100, 'isCompleted' => true, 'modules' => 10, 'honors' => 'Second Class Honors'],
                                        ['title' => 'Level 3: Tafsir & Hadith Sciences (S.1-S.3)', 'percentage' => 75, 'isCompleted' => false, 'modules' => 12, 'honors' => null],
                                        ['title' => 'Level 4: Advanced Islamic Jurisprudence (S.4-S.5)', 'percentage' => 45, 'isCompleted' => false, 'modules' => 10, 'honors' => null]
                                    ];
                                @endphp
                                @foreach($courseProgress as $key => $data)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><strong>{{ $data['title'] }}</strong><br><small class="text-muted">{{ $data['modules'] }} modules</small></td>
                                    <td style="width: 200px;"><div class="lesson-progress"><div class="lesson-progress-bar" style="width: {{ $data['percentage'] }}%"></div></div><small>{{ $data['percentage'] }}% Complete</small></td>
                                    <td>@if($data['percentage'] >= 100)<span class="badge badge-success">Completed</span>@elseif($data['percentage'] >= 50)<span class="badge badge-info">In Progress</span>@else<span class="badge badge-secondary">Started</span>@endif</td>
                                    <td>@if($data['honors'])<span class="honors-badge {{ $data['honors'] == 'First Class Honors' ? 'badge-first' : 'badge-second' }}">{{ $data['honors'] }}</span>@else<span class="text-muted">—</span>@endif</td>
                                    <td class="text-center">@if($data['isCompleted'])<button class="btn btn-success btn-sm" onclick="Swal.fire('Certificate', 'Download certificate with academy logo', 'success')"><i class="bi bi-download"></i> PDF</button>@else<button class="btn btn-secondary btn-sm" disabled><i class="bi bi-lock"></i> Locked</button>@endif</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div></div>
            </div>

            <!-- Payments Tab -->
            <div class="tab-pane fade" id="paymentsTab">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card"><div class="card-header"><h3 class="card-title"><i class="bi bi-credit-card"></i> Payment History</h3></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-light"> <tr><th>Transaction ID</th><th>Description</th><th>Amount</th><th>Date</th><th>Status</th><th>Method</th></tr> </thead>
                                    <tbody>
                                        @php
                                            $payments = [
                                                ['id' => 1, 'description' => 'Level 1 Enrollment121 - Full Course', 'amount' => 49.99, 'date' => '2024-11-15', 'status' => 'completed', 'method' => 'Mobile Money'],
                                                ['id' => 2, 'description' => 'Level 2 Enrollment - Full Course', 'amount' => 49.99, 'date' => '2025-01-10', 'status' => 'completed', 'method' => 'Credit Card'],
                                                ['id' => 3, 'description' => 'Level 3 Enrollment - Full Course', 'amount' => 59.99, 'date' => '2025-02-20', 'status' => 'completed', 'method' => 'Mobile Money'],
                                                ['id' => 4, 'description' => 'Exam Retake - Arabic Grammar', 'amount' => 2.99, 'date' => '2025-03-12', 'status' => 'pending', 'method' => 'Pending']
                                            ];
                                        @endphp
                                        @foreach($payments as $payment)
                                        <tr class="payment-card"><td><code>#TRX-{{ $payment['id'] }}00{{ $payment['id'] }}</code></td><td>{{ $payment['description'] }}</td><td><strong>${{ number_format($payment['amount'], 2) }}</strong></td><td>{{ $payment['date'] }}</td><td><span class="badge {{ $payment['status'] == 'completed' ? 'badge-success' : 'badge-pending' }}">{{ ucfirst($payment['status']) }}</span></td><td><i class="bi bi-{{ $payment['method'] == 'Mobile Money' ? 'phone' : ($payment['method'] == 'Credit Card' ? 'credit-card' : 'clock') }}"></i> {{ $payment['method'] }}</td></tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="alert alert-info mt-3"><i class="bi bi-info-circle"></i> <strong>PesaPal Integration:</strong> Payments can be made via Mobile Money (MTN, Airtel) or Credit Cards. Failed exam retakes: <strong>$2.99 per attempt</strong></div>
                            <div class="text-center mt-3"><button class="btn btn-primary" onclick="Swal.fire('PesaPal', 'Redirecting to PesaPal payment gateway...', 'info')"><i class="bi bi-credit-card"></i> Make a Payment</button></div>
                        </div></div>
                    </div>
                </div>
            </div>

            <!-- Exams Tab -->
            <div class="tab-pane fade" id="examsTab">
                <div class="row">
                    <div class="col-md-6"><div class="card"><div class="card-header"><h3 class="card-title"><i class="bi bi-calendar-event"></i> Upcoming Exams</h3></div><div class="card-body">
                        @php
                            $upcomingExams = [
                                ['title' => 'Qur\'an Quiz - Surah Al-Fatihah & Al-Ikhlas', 'subject' => 'Qur\'an & Tafsir', 'date' => '2025-04-10', 'duration' => '30 min', 'questions' => 20],
                                ['title' => 'Fiqh - Taharah & Salah Assessment', 'subject' => 'Fiqh', 'date' => '2025-04-15', 'duration' => '45 min', 'questions' => 25],
                                ['title' => 'Seerah - Makkah & Madinah Period', 'subject' => 'Seerah', 'date' => '2025-04-20', 'duration' => '40 min', 'questions' => 20]
                            ];
                        @endphp
                        @foreach($upcomingExams as $exam)
                        <div class="upcoming-exam p-3 mb-2 bg-white rounded"><div class="d-flex justify-content-between"><div><h6 class="mb-1">{{ $exam['title'] }}</h6><small>{{ $exam['subject'] }} | {{ $exam['duration'] }} | {{ $exam['questions'] }} questions</small></div><span class="badge badge-warning">{{ $exam['date'] }}</span></div><button class="btn btn-sm btn-primary mt-2" onclick="Swal.fire('Coming Soon', 'Exam will be available on {{ $exam['date'] }}', 'info')"><i class="bi bi-clock"></i> Prepare</button></div>
                        @endforeach
                    </div></div></div>
                    <div class="col-md-6"><div class="card"><div class="card-header"><h3 class="card-title"><i class="bi bi-check-circle"></i> Completed Exams</h3></div><div class="card-body">
                        @php
                            $completedExams = [
                                ['title' => 'Level 1 Final Assessment', 'subject' => 'Comprehensive Islamic Studies', 'date' => '2024-12-10', 'score' => 92, 'status' => 'passed', 'honors' => 'First Class Honors'],
                                ['title' => 'Level 2 Final Assessment', 'subject' => 'Advanced Islamic Studies', 'date' => '2025-02-18', 'score' => 85, 'status' => 'passed', 'honors' => 'First Class Honors'],
                                ['title' => 'Tafsir - Surah Al-Fatihah', 'subject' => 'Qur\'an & Tafsir', 'date' => '2025-03-01', 'score' => 78, 'status' => 'passed', 'honors' => 'Second Class Honors'],
                                ['title' => 'Arabic Grammar - Nouns & Verbs', 'subject' => 'Lugha', 'date' => '2025-03-10', 'score' => 48, 'status' => 'failed', 'honors' => 'Failed']
                            ];
                        @endphp
                        @foreach($completedExams as $exam)
                        <div class="completed-exam p-3 mb-2 bg-white rounded"><div class="d-flex justify-content-between"><div><h6 class="mb-1">{{ $exam['title'] }}</h6><small>{{ $exam['subject'] }} | {{ $exam['date'] }}</small></div><span class="badge {{ $exam['status'] == 'passed' ? 'badge-success' : 'badge-danger' }}">{{ $exam['score'] }}%</span></div>
                        <div class="mt-2"><span class="honors-badge {{ $exam['score'] >= 80 ? 'badge-first' : ($exam['score'] >= 70 ? 'badge-second' : ($exam['score'] >= 60 ? 'badge-third' : ($exam['score'] >= 50 ? 'badge-fourth' : 'badge-failed'))) }}">{{ $exam['honors'] }}</span>@if($exam['status'] == 'failed')<button class="btn btn-sm btn-warning ml-2" onclick="Swal.fire('Retake Exam', 'Payment of $2.99 required to retake this exam via PesaPal', 'warning')"><i class="bi bi-arrow-repeat"></i> Retake ($2.99)</button>@endif</div></div>
                        @endforeach
                    </div></div></div>
                </div>
            </div>

            <!-- Reports Tab -->
            <div class="tab-pane fade" id="reportsTab">
                <div class="card"><div class="card-header"><h3 class="card-title"><i class="bi bi-file-text"></i> Academic Reports</h3></div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4"><div class="text-center p-3 bg-primary text-white rounded"><h4>Overall Grade</h4><h2>{{ $averageScore ?? 76 }}%</h2><small>{{ ($averageScore ?? 76) >= 80 ? 'First Class' : (($averageScore ?? 76) >= 70 ? 'Second Class' : (($averageScore ?? 76) >= 60 ? 'Third Class' : (($averageScore ?? 76) >= 50 ? 'Fourth Class' : 'Needs Improvement'))) }}</small></div></div>
                        <div class="col-md-4"><div class="text-center p-3 bg-success text-white rounded"><h4>Completed Levels</h4><h2>2/5</h2><small>Levels Achieved</small></div></div>
                        <div class="col-md-4"><div class="text-center p-3 bg-warning text-dark rounded"><h4>Honors Classification</h4><h2>{{ ($averageScore ?? 76) >= 80 ? 'First Class' : (($averageScore ?? 76) >= 70 ? 'Second Class' : (($averageScore ?? 76) >= 60 ? 'Third Class' : (($averageScore ?? 76) >= 50 ? 'Fourth Class' : 'Failed'))) }}</h2><small>Overall Standing</small></div></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-light"> <tr><th>Level</th><th>Score</th><th>Honors</th><th>Report</th></tr> </thead>
                            <tbody>
                                <tr><td>Level 1 (P.1-P.4)</td><td>92%</td><td><span class="honors-badge badge-first">First Class Honors</span></td><td><button class="btn btn-sm btn-primary" onclick="Swal.fire('Report', 'Download report with academy logo watermark', 'success')"><i class="bi bi-download"></i> PDF</button></td></tr>
                                <tr><td>Level 2 (P.5-P.7)</td><td>85%</td><td><span class="honors-badge badge-second">Second Class Honors</span></td><td><button class="btn btn-sm btn-primary" onclick="Swal.fire('Report', 'Download report with academy logo watermark', 'success')"><i class="bi bi-download"></i> PDF</button></td></tr>
                                <tr><td>Level 3 (S.1-S.3)</td><td>78%</td><td><span class="honors-badge badge-second">Second Class Honors</span></td><td><button class="btn btn-sm btn-primary" onclick="Swal.fire('Report', 'Download report with academy logo watermark', 'success')"><i class="bi bi-download"></i> PDF</button></td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3"><button class="btn btn-primary btn-lg" onclick="Swal.fire('Report Generated', 'Your full academic report with academy logo watermark is ready for download.', 'success')"><i class="bi bi-download"></i> Download Full Report (PDF)</button></div>
                </div></div>
            </div>

            <!-- Certificates Tab -->
            <div class="tab-pane fade" id="certificatesTab">
                <div class="row">
                    @php
                        $certifications = [
                            ['title' => 'Level 1 Certificate', 'level' => 'P.1 - P.4', 'honors' => 'First Class Honors', 'issued_date' => '2024-12-15'],
                            ['title' => 'Level 2 Certificate', 'level' => 'P.5 - P.7', 'honors' => 'Second Class Honors', 'issued_date' => '2025-02-20']
                        ];
                    @endphp
                    @foreach($certifications as $cert)
                    <div class="col-md-6 col-lg-4"><div class="cert-card card mb-3" onclick="Swal.fire('Certificate', 'Download {{ $cert['title'] }} with academy logo', 'success')"><div class="card-body text-center"><i class="bi bi-award-fill text-warning" style="font-size: 3rem;"></i><h5 class="mt-3">{{ $cert['title'] }}</h5><p class="text-muted small">{{ $cert['level'] }}</p><span class="honors-badge {{ $cert['honors'] == 'First Class Honors' ? 'badge-first' : 'badge-second' }}">{{ $cert['honors'] }}</span><p class="mt-2 small text-muted">Issued: {{ $cert['issued_date'] }}</p><button class="btn btn-primary btn-sm"><i class="bi bi-download"></i> Download PDF</button></div></div></div>
                    @endforeach
                </div>
            </div>

            <!-- Notifications Tab -->
            <div class="tab-pane fade" id="notificationsTab">
                <div class="card"><div class="card-header"><h3 class="card-title"><i class="bi bi-bell"></i> Notifications</h3></div>
                <div class="card-body">
                    @php
                        $notifications = [
                            ['type' => 'new_lesson', 'message' => 'New lesson added: "Surah Al-Ikhlas - Tafsir"', 'date' => '2025-03-30', 'read' => false],
                            ['type' => 'exam', 'message' => 'Upcoming exam: "Fiqh - Salah" scheduled for April 10, 2025', 'date' => '2025-03-29', 'read' => false],
                            ['type' => 'certificate', 'message' => 'Congratulations! You earned a certificate for Level 2', 'date' => '2025-02-20', 'read' => true],
                            ['type' => 'payment', 'message' => 'Payment confirmed for Level 3 Enrollment', 'date' => '2025-02-20', 'read' => true],
                            ['type' => 'new_lesson', 'message' => 'New PDF notes available: "Arabic Grammar Basics" with Arabic & English translations', 'date' => '2025-03-28', 'read' => false]
                        ];
                    @endphp
                    @foreach($notifications as $notif)
                    <div class="recent-lesson-item p-3 mb-2 bg-white rounded shadow-sm" style="border-left-color: {{ $notif['type'] == 'new_lesson' ? '#7c3a8c' : ($notif['type'] == 'exam' ? '#ffc107' : ($notif['type'] == 'certificate' ? '#28a745' : '#17a2b8')) }}">
                        <div class="d-flex justify-content-between">
                            <div>
                                <i class="bi bi-{{ $notif['type'] == 'new_lesson' ? 'book' : ($notif['type'] == 'exam' ? 'calendar-check' : ($notif['type'] == 'certificate' ? 'award' : 'credit-card')) }} me-2"></i>
                                <strong>{{ ucfirst(str_replace('_', ' ', $notif['type'])) }}</strong>
                                <p class="mb-0 mt-1">{{ $notif['message'] }}</p>
                            </div>
                            <div class="text-right">
                                <small class="text-muted">{{ $notif['date'] }}</small>
                                @if(!$notif['read'])<div class="mt-1"><span class="badge badge-danger">New</span></div>@endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="text-center mt-3"><button class="btn btn-primary" onclick="Swal.fire('Notifications', 'All notifications marked as read', 'success')"><i class="bi bi-check-all"></i> Mark All as Read</button></div>
                </div></div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('assets/plugins/charts-c3/d3.v5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/charts-c3/c3-chart.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/echarts/echarts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Course Enrolled Chart
            var chart = c3.generate({
                bindto: '#chart-pie2',
                data: {
                    columns: [['Completed Levels', 2], ['Remaining Levels', 3]],
                    type: 'pie',
                    colors: { 'Completed Levels': '#28a745', 'Remaining Levels': '#e9ecef' }
                },
                legend: { position: 'bottom' }
            });

            // Lessons Progress Pie Chart
            var lessonsChart = echarts.init(document.getElementById('lessonsPieChart'));
            @php
                $safeTotalLessons = isset($totalLessons) && $totalLessons > 0 ? $totalLessons : 48;
                $safeCompletedLessons = isset($completedLessons) ? $completedLessons : 32;
                $remainingLessons = $safeTotalLessons - $safeCompletedLessons;
            @endphp
            lessonsChart.setOption({
                tooltip: { trigger: 'item', formatter: '{a} <br/>{b}: {c} ({d}%)' },
                legend: { orient: 'vertical', left: 'left', data: ['Completed Lessons', 'Remaining Lessons'] },
                series: [{
                    name: 'Lessons Progress', type: 'pie', radius: '55%',
                    data: [
                        { value: {{ $safeCompletedLessons }}, name: 'Completed Lessons', itemStyle: { color: '#28a745' } },
                        { value: {{ $remainingLessons }}, name: 'Remaining Lessons', itemStyle: { color: '#e9ecef' } }
                    ],
                    label: { show: true, formatter: '{b}: {d}%' }
                }]
            });

            // Overall Progress Circle Animation
            let total = {{ $safeTotalLessons }};
            let completed = {{ $safeCompletedLessons }};
            let percent = total > 0 ? (completed / total) * 100 : 0;
            let angle = (percent / 100) * 360;
            document.getElementById('overallProgress').style.background = `conic-gradient(#7c3a8c ${angle}deg, #e9ecef ${angle}deg)`;
        });

        function continueLesson(lessonTitle) {
            Swal.fire({
                title: 'Continue Lesson',
                text: `Continue "${lessonTitle}"?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, continue',
                cancelButtonText: 'Later'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Great!', 'Lesson content will load here. Video/Audio/PDF player with secure playback.', 'success');
                }
            });
        }
    </script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/datatables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/counters/counterup.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/counters/waypoints.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/chart.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/utils.js') }}"></script>
@endsection