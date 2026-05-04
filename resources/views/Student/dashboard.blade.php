@extends('Student.layouts.sidebar')

@section('main-content')
    {{-- ── PAGE CONTENT ── --}}
    <div class="sd-content">

        {{-- ── WELCOME BANNER ── --}}
        <div class="sd-welcome-banner">
            <div class="sd-welcome-pattern"></div>
            <div class="sd-welcome-left">
                <div class="sd-welcome-badge">
                    <i class="fas fa-circle-check"></i>
                    You completed 3 lessons this week
                </div>
                <h1>Continue Your<br>Islamic Journey</h1>
                <p>You're 72% through <strong style="color:rgba(255,255,255,0.85);">Tafsir — Chapter 5</strong>. Pick
                    up right where you left off and keep your streak alive!</p>
            </div>
            <div class="sd-welcome-actions">
                <a href="#" class="sd-continue-btn" onclick="openModal('lessonModal')">
                    <i class="fas fa-play"></i> Continue Lesson
                </a>
                <div class="sd-streak">
                    <i class="fas fa-fire"></i>
                    <span>7-day streak — keep it going!</span>
                </div>
            </div>
        </div>

        {{-- ── STAT CARDS ── --}}
        <div class="sd-stats-grid">
            <div class="sd-stat-card">
                <div class="sd-stat-card-top">
                    <div class="sd-stat-icon sd-stat-icon-purple"><i class="fas fa-play-circle"></i></div>
                    <div class="sd-stat-trend sd-trend-up"><i class="fas fa-arrow-up"></i> 12%</div>
                </div>
                <div class="sd-stat-num" data-count="34">34</div>
                <div class="sd-stat-label">Lessons Completed</div>
                <div class="sd-stat-bar">
                    <div class="sd-stat-bar-fill" style="width:68%;"></div>
                </div>
            </div>
            <div class="sd-stat-card">
                <div class="sd-stat-card-top">
                    <div class="sd-stat-icon sd-stat-icon-green"><i class="fas fa-check-circle"></i></div>
                    <div class="sd-stat-trend sd-trend-up"><i class="fas fa-arrow-up"></i> 8%</div>
                </div>
                <div class="sd-stat-num" data-count="28">28</div>
                <div class="sd-stat-label">Quizzes Passed</div>
                <div class="sd-stat-bar">
                    <div class="sd-stat-bar-fill" style="width:78%;background:var(--gradient-green);"></div>
                </div>
            </div>
            <div class="sd-stat-card">
                <div class="sd-stat-card-top">
                    <div class="sd-stat-icon sd-stat-icon-gold"><i class="fas fa-award"></i></div>
                    <div class="sd-stat-trend sd-trend-up"><i class="fas fa-arrow-up"></i> 1 new</div>
                </div>
                <div class="sd-stat-num" data-count="3">3</div>
                <div class="sd-stat-label">Certificates Earned</div>
                <div class="sd-stat-bar">
                    <div class="sd-stat-bar-fill" style="width:60%;background:var(--gradient-gold);"></div>
                </div>
            </div>
            <div class="sd-stat-card">
                <div class="sd-stat-card-top">
                    <div class="sd-stat-icon sd-stat-icon-red"><i class="fas fa-star"></i></div>
                    <div class="sd-stat-trend sd-trend-up"><i class="fas fa-arrow-up"></i> 5pts</div>
                </div>
                <div class="sd-stat-num" data-count="87">87</div>
                <div class="sd-stat-label">Avg. Quiz Score %</div>
                <div class="sd-stat-bar">
                    <div class="sd-stat-bar-fill" style="width:87%;"></div>
                </div>
            </div>
        </div>

        {{-- ── MAIN GRID ── --}}
        <div class="sd-main-grid">

            {{-- Subject Progress --}}
            <div class="sd-progress-card">
                <div class="sd-card-header">
                    <div class="sd-section-title">Subject Progress</div>
                    <a href="#" class="sd-view-all">View All <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="sd-card-body">
                    <div class="sd-subject-progress-list">

                        <div class="sd-subject-prog-item">
                            <div class="sd-subject-prog-top">
                                <div class="sd-subject-prog-info">
                                    <div class="sd-subject-prog-icon"
                                        style="background:var(--purple-light);color:var(--purple)"><i
                                            class="fas fa-book-quran"></i></div>
                                    <div>
                                        <div class="sd-subject-prog-name">Quran & Tafsir</div>
                                        <div class="sd-subject-prog-lessons">12 / 15 lessons</div>
                                    </div>
                                </div>
                                <div class="sd-subject-prog-pct">80%</div>
                            </div>
                            <div class="sd-prog-bar">
                                <div class="sd-prog-bar-fill"
                                    style="width:80%;color:var(--purple);background:var(--gradient);"></div>
                            </div>
                        </div>

                        <div class="sd-subject-prog-item">
                            <div class="sd-subject-prog-top">
                                <div class="sd-subject-prog-info">
                                    <div class="sd-subject-prog-icon" style="background:var(--red-light);color:var(--red)">
                                        <i class="fas fa-scroll"></i>
                                    </div>
                                    <div>
                                        <div class="sd-subject-prog-name">Hadith Studies</div>
                                        <div class="sd-subject-prog-lessons">8 / 15 lessons</div>
                                    </div>
                                </div>
                                <div class="sd-subject-prog-pct">53%</div>
                            </div>
                            <div class="sd-prog-bar">
                                <div class="sd-prog-bar-fill"
                                    style="width:53%;color:var(--red);background:linear-gradient(135deg,var(--red),#F87171);">
                                </div>
                            </div>
                        </div>

                        <div class="sd-subject-prog-item">
                            <div class="sd-subject-prog-top">
                                <div class="sd-subject-prog-info">
                                    <div class="sd-subject-prog-icon"
                                        style="background:var(--gold-light);color:var(--gold)"><i
                                            class="fas fa-scale-balanced"></i></div>
                                    <div>
                                        <div class="sd-subject-prog-name">Fiqh (Islamic Law)</div>
                                        <div class="sd-subject-prog-lessons">10 / 12 lessons</div>
                                    </div>
                                </div>
                                <div class="sd-subject-prog-pct">83%</div>
                            </div>
                            <div class="sd-prog-bar">
                                <div class="sd-prog-bar-fill"
                                    style="width:83%;color:var(--gold);background:var(--gradient-gold);"></div>
                            </div>
                        </div>

                        <div class="sd-subject-prog-item">
                            <div class="sd-subject-prog-top">
                                <div class="sd-subject-prog-info">
                                    <div class="sd-subject-prog-icon"
                                        style="background:var(--green-light);color:var(--green)"><i
                                            class="fas fa-language"></i></div>
                                    <div>
                                        <div class="sd-subject-prog-name">Arabic Language</div>
                                        <div class="sd-subject-prog-lessons">6 / 15 lessons</div>
                                    </div>
                                </div>
                                <div class="sd-subject-prog-pct">40%</div>
                            </div>
                            <div class="sd-prog-bar">
                                <div class="sd-prog-bar-fill"
                                    style="width:40%;color:var(--green);background:var(--gradient-green);"></div>
                            </div>
                        </div>

                        <div class="sd-subject-prog-item">
                            <div class="sd-subject-prog-top">
                                <div class="sd-subject-prog-info">
                                    <div class="sd-subject-prog-icon"
                                        style="background:var(--blue-light);color:var(--blue)"><i class="fas fa-mosque"></i>
                                    </div>
                                    <div>
                                        <div class="sd-subject-prog-name">Seerah & History</div>
                                        <div class="sd-subject-prog-lessons">11 / 14 lessons</div>
                                    </div>
                                </div>
                                <div class="sd-subject-prog-pct">79%</div>
                            </div>
                            <div class="sd-prog-bar">
                                <div class="sd-prog-bar-fill"
                                    style="width:79%;color:var(--blue);background:linear-gradient(135deg,var(--blue),#60A5FA);">
                                </div>
                            </div>
                        </div>

                        <!-- NEW: Aqeedah (Islamic Creed) -->
                        <div class="sd-subject-prog-item">
                            <div class="sd-subject-prog-top">
                                <div class="sd-subject-prog-info">
                                    <div class="sd-subject-prog-icon"
                                        style="background:linear-gradient(135deg, #8B5CF6, #6D28D9);color:white"><i
                                            class="fas fa-star-and-crescent"></i></div>
                                    <div>
                                        <div class="sd-subject-prog-name">Aqeedah (Islamic Creed)</div>
                                        <div class="sd-subject-prog-lessons">14 / 18 lessons</div>
                                    </div>
                                </div>
                                <div class="sd-subject-prog-pct">78%</div>
                            </div>
                            <div class="sd-prog-bar">
                                <div class="sd-prog-bar-fill"
                                    style="width:78%;background:linear-gradient(135deg, #8B5CF6, #6D28D9);"></div>
                            </div>
                        </div>

                        <!-- NEW: Tajweed & Recitation -->
                        <div class="sd-subject-prog-item">
                            <div class="sd-subject-prog-top">
                                <div class="sd-subject-prog-info">
                                    <div class="sd-subject-prog-icon"
                                        style="background:linear-gradient(135deg, #10B981, #059669);color:white"><i
                                            class="fas fa-microphone-alt"></i></div>
                                    <div>
                                        <div class="sd-subject-prog-name">Tajweed & Recitation</div>
                                        <div class="sd-subject-prog-lessons">9 / 12 lessons</div>
                                    </div>
                                </div>
                                <div class="sd-subject-prog-pct">75%</div>
                            </div>
                            <div class="sd-prog-bar">
                                <div class="sd-prog-bar-fill"
                                    style="width:75%;background:linear-gradient(135deg, #10B981, #059669);"></div>
                            </div>
                        </div>

                        <!-- NEW: Islamic Manners & Ethics (Akhlaq) -->
                        <div class="sd-subject-prog-item">
                            <div class="sd-subject-prog-top">
                                <div class="sd-subject-prog-info">
                                    <div class="sd-subject-prog-icon"
                                        style="background:linear-gradient(135deg, #F59E0B, #D97706);color:white"><i
                                            class="fas fa-hand-peace"></i></div>
                                    <div>
                                        <div class="sd-subject-prog-name">Akhlaq (Islamic Manners)</div>
                                        <div class="sd-subject-prog-lessons">15 / 20 lessons</div>
                                    </div>
                                </div>
                                <div class="sd-subject-prog-pct">75%</div>
                            </div>
                            <div class="sd-prog-bar">
                                <div class="sd-prog-bar-fill"
                                    style="width:75%;background:linear-gradient(135deg, #F59E0B, #D97706);"></div>
                            </div>
                        </div>

                        <!-- NEW: Duas & Adhkar -->
                        <div class="sd-subject-prog-item">
                            <div class="sd-subject-prog-top">
                                <div class="sd-subject-prog-info">
                                    <div class="sd-subject-prog-icon"
                                        style="background:linear-gradient(135deg, #EC4899, #BE185D);color:white"><i
                                            class="fas fa-hands-praying"></i></div>
                                    <div>
                                        <div class="sd-subject-prog-name">Duas & Adhkar</div>
                                        <div class="sd-subject-prog-lessons">18 / 25 lessons</div>
                                    </div>
                                </div>
                                <div class="sd-subject-prog-pct">72%</div>
                            </div>
                            <div class="sd-prog-bar">
                                <div class="sd-prog-bar-fill"
                                    style="width:72%;background:linear-gradient(135deg, #EC4899, #BE185D);"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Right panel --}}
            <div class="sd-quick-panel">

                {{-- Quick Actions --}}
                <div class="sd-quick-card">
                    <div class="sd-section-title">Quick Actions</div>
                    <div class="sd-quick-actions-grid">
                        <button class="sd-quick-action-btn btn-primary-action" onclick="openModal('lessonModal')">
                            <i class="fas fa-play-circle"></i> Resume Lesson
                        </button>
                        <button class="sd-quick-action-btn" onclick="openModal('quizModal')">
                            <i class="fas fa-question-circle"></i> Take Quiz
                        </button>
                        <button class="sd-quick-action-btn">
                            <i class="fas fa-file-pdf"></i> PDF Notes
                        </button>
                        <button class="sd-quick-action-btn">
                            <i class="fas fa-award"></i> My Certs
                        </button>
                        <a href="https://wa.me/256702082209" target="_blank" class="sd-quick-action-btn"
                            style="color:var(--green);">
                            <i class="fab fa-whatsapp"></i> Chat Teacher
                        </a>
                        <button class="sd-quick-action-btn">
                            <i class="fas fa-chart-line"></i> My Reports
                        </button>
                    </div>
                </div>

                {{-- Announcements --}}
                <div class="sd-quick-card">
                    <div class="sd-section-title">Announcements</div>
                    <div style="margin-top:14px;">
                        <div class="sd-announce-item">
                            <div class="sd-announce-icon" style="background:var(--red-light);color:var(--red);"><i
                                    class="fas fa-bullhorn"></i></div>
                            <div style="flex:1;">
                                <div class="sd-announce-title">Termly Exams — April 2025</div>
                                <div class="sd-announce-text">All S.3 exams begin April 28th. Ensure all lesson quizzes
                                    are passed before then.</div>
                            </div>
                            <div class="sd-announce-time">2h ago</div>
                        </div>
                        <div class="sd-announce-item">
                            <div class="sd-announce-icon" style="background:var(--gold-light);color:var(--gold);"><i
                                    class="fas fa-star"></i></div>
                            <div style="flex:1;">
                                <div class="sd-announce-title">New: Fiqh Chapter 6 Uploaded</div>
                                <div class="sd-announce-text">Ustadh Rashid has added 3 new video lessons to Fiqh,
                                    Level 3.</div>
                            </div>
                            <div class="sd-announce-time">1d ago</div>
                        </div>
                        <div class="sd-announce-item">
                            <div class="sd-announce-icon" style="background:var(--green-light);color:var(--green);"><i
                                    class="fas fa-certificate"></i></div>
                            <div style="flex:1;">
                                <div class="sd-announce-title">Certificate Ready!</div>
                                <div class="sd-announce-text">Your Level 2 completion certificate is ready to download.
                                </div>
                            </div>
                            <div class="sd-announce-time">3d ago</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ── LESSONS SECTION ── --}}
        <div class="sd-lessons-section">
            <div class="sd-section-head">
                <div class="sd-section-title">My Lessons</div>
                <a href="#" class="sd-view-all">View All Lessons <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="sd-tabs">
                <button class="sd-tab active" data-tab="inprogress">In Progress</button>
                <button class="sd-tab" data-tab="completed">Completed</button>
                <button class="sd-tab" data-tab="todo">To Do</button>
            </div>
            <div class="sd-lessons-grid" id="lessonsGrid">
                <!-- Rendered by JS -->
            </div>
        </div>

        {{-- ── BOTTOM GRID ── --}}
        <div class="sd-bottom-grid">

            {{-- Leaderboard --}}
            <div class="sd-leaderboard-card">
                <div class="sd-card-header" style="padding:18px 20px 12px;">
                    <div class="sd-section-title">Class Leaderboard</div>
                    <span style="font-size:0.72rem;color:var(--muted);font-weight:500;">This Month</span>
                </div>
                <div class="sd-leader-list">
                    <div class="sd-leader-item">
                        <div class="sd-leader-rank rank-1"><i class="fas fa-crown" style="font-size:0.65rem;"></i>
                        </div>
                        <div class="sd-leader-avatar-sm">FA</div>
                        <div class="sd-leader-name">Fatuma Abubakar<span>98% avg score</span></div>
                        <div class="sd-leader-score">1,240 pts</div>
                    </div>
                    <div class="sd-leader-item">
                        <div class="sd-leader-rank rank-2">2</div>
                        <div class="sd-leader-avatar-sm" style="background:linear-gradient(135deg,#475569,#94A3B8);">
                            MK</div>
                        <div class="sd-leader-name">Muhammad Kato<span>94% avg score</span></div>
                        <div class="sd-leader-score">1,180 pts</div>
                    </div>
                    <div class="sd-leader-item is-me">
                        <div class="sd-leader-rank rank-3">3</div>
                        <div class="sd-leader-avatar-sm">{{ strtoupper(substr(auth()->user()->name ?? 'ST', 0, 2)) }}
                        </div>
                        <div class="sd-leader-name">{{ auth()->user()->name ?? 'You' }} <span style="color:var(--purple);">←
                                You · 87% avg</span></div>
                        <div class="sd-leader-score" style="color:var(--purple);">1,090 pts</div>
                    </div>
                    <div class="sd-leader-item">
                        <div class="sd-leader-rank rank-other">4</div>
                        <div class="sd-leader-avatar-sm" style="background:linear-gradient(135deg,#B45309,#F59E0B);">
                            AN</div>
                        <div class="sd-leader-name">Aisha Nakimuli<span>82% avg score</span></div>
                        <div class="sd-leader-score">980 pts</div>
                    </div>
                    <div class="sd-leader-item">
                        <div class="sd-leader-rank rank-other">5</div>
                        <div class="sd-leader-avatar-sm" style="background:linear-gradient(135deg,#1D4ED8,#60A5FA);">
                            IS</div>
                        <div class="sd-leader-name">Ibrahim Ssemanda<span>78% avg score</span></div>
                        <div class="sd-leader-score">910 pts</div>
                    </div>
                </div>
            </div>

            {{-- Certificates --}}
            <div class="sd-leaderboard-card">
                <div class="sd-card-header" style="padding:18px 20px 12px;">
                    <div class="sd-section-title">My Certificates</div>
                    <a href="#" class="sd-view-all" style="font-size:0.72rem;">All <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="sd-cert-list">
                    <div class="sd-cert-item">
                        <div class="sd-cert-icon" style="background:var(--gold-light);color:var(--gold)"><i
                                class="fas fa-medal"></i></div>
                        <div>
                            <div class="sd-cert-name">Level 2 Completion</div>
                            <div class="sd-cert-date"><i class="fas fa-calendar-check"
                                    style="font-size:0.65rem;margin-right:4px;"></i>Issued: March 15, 2025</div>
                        </div>
                        <div class="sd-cert-download"><i class="fas fa-download"></i></div>
                    </div>
                    <div class="sd-cert-item">
                        <div class="sd-cert-icon" style="background:var(--purple-light);color:var(--purple)"><i
                                class="fas fa-award"></i></div>
                        <div>
                            <div class="sd-cert-name">Quran Recitation — P.6</div>
                            <div class="sd-cert-date"><i class="fas fa-calendar-check"
                                    style="font-size:0.65rem;margin-right:4px;"></i>Issued: Jan 10, 2025</div>
                        </div>
                        <div class="sd-cert-download"><i class="fas fa-download"></i></div>
                    </div>
                    <div class="sd-cert-item">
                        <div class="sd-cert-icon" style="background:var(--green-light);color:var(--green)"><i
                                class="fas fa-certificate"></i></div>
                        <div>
                            <div class="sd-cert-name">Level 1 — Full Completion</div>
                            <div class="sd-cert-date"><i class="fas fa-calendar-check"
                                    style="font-size:0.65rem;margin-right:4px;"></i>Issued: Sept 5, 2024</div>
                        </div>
                        <div class="sd-cert-download"><i class="fas fa-download"></i></div>
                    </div>
                    <div class="sd-cert-item" style="opacity:0.5;pointer-events:none;">
                        <div class="sd-cert-icon" style="background:var(--cream2);color:var(--muted)"><i
                                class="fas fa-lock"></i></div>
                        <div>
                            <div class="sd-cert-name">Level 3 Completion</div>
                            <div class="sd-cert-date">Complete all S.3 lessons to unlock</div>
                        </div>
                        <div class="sd-cert-download" style="background:var(--cream2);color:var(--muted);"><i
                                class="fas fa-lock"></i></div>
                    </div>
                </div>
            </div>

            {{-- Upcoming Exams --}}
            <div class="sd-leaderboard-card">
                <div class="sd-card-header" style="padding:18px 20px 12px;">
                    <div class="sd-section-title">Upcoming Exams</div>
                    <a href="#" class="sd-view-all" style="font-size:0.72rem;">Schedule <i
                            class="fas fa-arrow-right"></i></a>
                </div>
                <div class="sd-exam-list">
                    <div class="sd-exam-item">
                        <div class="sd-exam-date-box">
                            <div class="sd-exam-day">28</div>
                            <div class="sd-exam-month">Apr</div>
                        </div>
                        <div>
                            <div class="sd-exam-name">Tafsir — Term Exam</div>
                            <div class="sd-exam-subject"><i class="fas fa-clock"
                                    style="font-size:0.65rem;margin-right:3px;"></i>90 mins · S.3 Level</div>
                        </div>
                        <div class="sd-exam-badge badge-soon">5 days</div>
                    </div>
                    <div class="sd-exam-item">
                        <div class="sd-exam-date-box">
                            <div class="sd-exam-day">02</div>
                            <div class="sd-exam-month">May</div>
                        </div>
                        <div>
                            <div class="sd-exam-name">Arabic Language Test</div>
                            <div class="sd-exam-subject"><i class="fas fa-clock"
                                    style="font-size:0.65rem;margin-right:3px;"></i>60 mins · S.3 Level</div>
                        </div>
                        <div class="sd-exam-badge badge-upcoming">9 days</div>
                    </div>
                    <div class="sd-exam-item">
                        <div class="sd-exam-date-box">
                            <div class="sd-exam-day">10</div>
                            <div class="sd-exam-month">May</div>
                        </div>
                        <div>
                            <div class="sd-exam-name">Fiqh — Chapter Assessment</div>
                            <div class="sd-exam-subject"><i class="fas fa-clock"
                                    style="font-size:0.65rem;margin-right:3px;"></i>75 mins · S.3 Level</div>
                        </div>
                        <div class="sd-exam-badge badge-later">17 days</div>
                    </div>
                    <div class="sd-exam-item">
                        <div class="sd-exam-date-box">
                            <div class="sd-exam-day">18</div>
                            <div class="sd-exam-month">May</div>
                        </div>
                        <div>
                            <div class="sd-exam-name">Seerah — Term End Exam</div>
                            <div class="sd-exam-subject"><i class="fas fa-clock"
                                    style="font-size:0.65rem;margin-right:3px;"></i>90 mins · S.3 Level</div>
                        </div>
                        <div class="sd-exam-badge badge-later">25 days</div>
                    </div>
                </div>
            </div>

        </div>

    </div>{{-- /sd-content --}}

    {{-- ── PAGE CONTENT ── --}}
    <div class="sd-content">

        {{-- ── WELCOME BANNER ── --}}
        <div class="sd-welcome-banner">
            <div class="sd-welcome-pattern"></div>
            <div class="sd-welcome-left">
                <div class="sd-welcome-badge">
                    <i class="fas fa-circle-check"></i>
                    You completed 3 lessons this week
                </div>
                <h1>Continue Your<br>Islamic Journey</h1>
                <p>You're 72% through <strong style="color:rgba(255,255,255,0.85);">Tafsir — Chapter 5</strong>. Pick
                    up right where you left off and keep your streak alive!</p>
            </div>
            <div class="sd-welcome-actions">
                <a href="#" class="sd-continue-btn" onclick="openModal('lessonModal')">
                    <i class="fas fa-play"></i> Continue Lesson
                </a>
                <div class="sd-streak">
                    <i class="fas fa-fire"></i>
                    <span>7-day streak — keep it going!</span>
                </div>
            </div>
        </div>

        {{-- ── STAT CARDS ── --}}
        <div class="sd-stats-grid">
            <div class="sd-stat-card">
                <div class="sd-stat-card-top">
                    <div class="sd-stat-icon sd-stat-icon-purple"><i class="fas fa-play-circle"></i></div>
                    <div class="sd-stat-trend sd-trend-up"><i class="fas fa-arrow-up"></i> 12%</div>
                </div>
                <div class="sd-stat-num" data-count="34">34</div>
                <div class="sd-stat-label">Lessons Completed</div>
                <div class="sd-stat-bar">
                    <div class="sd-stat-bar-fill" style="width:68%;"></div>
                </div>
            </div>
            <div class="sd-stat-card">
                <div class="sd-stat-card-top">
                    <div class="sd-stat-icon sd-stat-icon-green"><i class="fas fa-check-circle"></i></div>
                    <div class="sd-stat-trend sd-trend-up"><i class="fas fa-arrow-up"></i> 8%</div>
                </div>
                <div class="sd-stat-num" data-count="28">28</div>
                <div class="sd-stat-label">Quizzes Passed</div>
                <div class="sd-stat-bar">
                    <div class="sd-stat-bar-fill" style="width:78%;background:var(--gradient-green);"></div>
                </div>
            </div>
            <div class="sd-stat-card">
                <div class="sd-stat-card-top">
                    <div class="sd-stat-icon sd-stat-icon-gold"><i class="fas fa-award"></i></div>
                    <div class="sd-stat-trend sd-trend-up"><i class="fas fa-arrow-up"></i> 1 new</div>
                </div>
                <div class="sd-stat-num" data-count="3">3</div>
                <div class="sd-stat-label">Certificates Earned</div>
                <div class="sd-stat-bar">
                    <div class="sd-stat-bar-fill" style="width:60%;background:var(--gradient-gold);"></div>
                </div>
            </div>
            <div class="sd-stat-card">
                <div class="sd-stat-card-top">
                    <div class="sd-stat-icon sd-stat-icon-red"><i class="fas fa-star"></i></div>
                    <div class="sd-stat-trend sd-trend-up"><i class="fas fa-arrow-up"></i> 5pts</div>
                </div>
                <div class="sd-stat-num" data-count="87">87</div>
                <div class="sd-stat-label">Avg. Quiz Score %</div>
                <div class="sd-stat-bar">
                    <div class="sd-stat-bar-fill" style="width:87%;"></div>
                </div>
            </div>
        </div>

        {{-- ── MAIN GRID ── --}}
        <div class="sd-main-grid">

            {{-- Subject Progress --}}
            <div class="sd-progress-card">
                <div class="sd-card-header">
                    <div class="sd-section-title">Subject Progress</div>
                    <a href="#" class="sd-view-all">View All <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="sd-card-body">
                    <div class="sd-subject-progress-list">

                        <div class="sd-subject-prog-item">
                            <div class="sd-subject-prog-top">
                                <div class="sd-subject-prog-info">
                                    <div class="sd-subject-prog-icon"
                                        style="background:var(--purple-light);color:var(--purple)"><i
                                            class="fas fa-book-quran"></i></div>
                                    <div>
                                        <div class="sd-subject-prog-name">Quran & Tafsir</div>
                                        <div class="sd-subject-prog-lessons">12 / 15 lessons</div>
                                    </div>
                                </div>
                                <div class="sd-subject-prog-pct">80%</div>
                            </div>
                            <div class="sd-prog-bar">
                                <div class="sd-prog-bar-fill"
                                    style="width:80%;color:var(--purple);background:var(--gradient);"></div>
                            </div>
                        </div>

                        <div class="sd-subject-prog-item">
                            <div class="sd-subject-prog-top">
                                <div class="sd-subject-prog-info">
                                    <div class="sd-subject-prog-icon" style="background:var(--red-light);color:var(--red)">
                                        <i class="fas fa-scroll"></i>
                                    </div>
                                    <div>
                                        <div class="sd-subject-prog-name">Hadith Studies</div>
                                        <div class="sd-subject-prog-lessons">8 / 15 lessons</div>
                                    </div>
                                </div>
                                <div class="sd-subject-prog-pct">53%</div>
                            </div>
                            <div class="sd-prog-bar">
                                <div class="sd-prog-bar-fill"
                                    style="width:53%;color:var(--red);background:linear-gradient(135deg,var(--red),#F87171);">
                                </div>
                            </div>
                        </div>

                        <div class="sd-subject-prog-item">
                            <div class="sd-subject-prog-top">
                                <div class="sd-subject-prog-info">
                                    <div class="sd-subject-prog-icon"
                                        style="background:var(--gold-light);color:var(--gold)"><i
                                            class="fas fa-scale-balanced"></i></div>
                                    <div>
                                        <div class="sd-subject-prog-name">Fiqh (Islamic Law)</div>
                                        <div class="sd-subject-prog-lessons">10 / 12 lessons</div>
                                    </div>
                                </div>
                                <div class="sd-subject-prog-pct">83%</div>
                            </div>
                            <div class="sd-prog-bar">
                                <div class="sd-prog-bar-fill"
                                    style="width:83%;color:var(--gold);background:var(--gradient-gold);"></div>
                            </div>
                        </div>

                        <div class="sd-subject-prog-item">
                            <div class="sd-subject-prog-top">
                                <div class="sd-subject-prog-info">
                                    <div class="sd-subject-prog-icon"
                                        style="background:var(--green-light);color:var(--green)"><i
                                            class="fas fa-language"></i></div>
                                    <div>
                                        <div class="sd-subject-prog-name">Arabic Language</div>
                                        <div class="sd-subject-prog-lessons">6 / 15 lessons</div>
                                    </div>
                                </div>
                                <div class="sd-subject-prog-pct">40%</div>
                            </div>
                            <div class="sd-prog-bar">
                                <div class="sd-prog-bar-fill"
                                    style="width:40%;color:var(--green);background:var(--gradient-green);"></div>
                            </div>
                        </div>

                        <div class="sd-subject-prog-item">
                            <div class="sd-subject-prog-top">
                                <div class="sd-subject-prog-info">
                                    <div class="sd-subject-prog-icon"
                                        style="background:var(--blue-light);color:var(--blue)"><i class="fas fa-mosque"></i>
                                    </div>
                                    <div>
                                        <div class="sd-subject-prog-name">Seerah & History</div>
                                        <div class="sd-subject-prog-lessons">11 / 14 lessons</div>
                                    </div>
                                </div>
                                <div class="sd-subject-prog-pct">79%</div>
                            </div>
                            <div class="sd-prog-bar">
                                <div class="sd-prog-bar-fill"
                                    style="width:79%;color:var(--blue);background:linear-gradient(135deg,var(--blue),#60A5FA);">
                                </div>
                            </div>
                        </div>

                        <!-- NEW: Aqeedah (Islamic Creed) -->
                        <div class="sd-subject-prog-item">
                            <div class="sd-subject-prog-top">
                                <div class="sd-subject-prog-info">
                                    <div class="sd-subject-prog-icon"
                                        style="background:linear-gradient(135deg, #8B5CF6, #6D28D9);color:white"><i
                                            class="fas fa-star-and-crescent"></i></div>
                                    <div>
                                        <div class="sd-subject-prog-name">Aqeedah (Islamic Creed)</div>
                                        <div class="sd-subject-prog-lessons">14 / 18 lessons</div>
                                    </div>
                                </div>
                                <div class="sd-subject-prog-pct">78%</div>
                            </div>
                            <div class="sd-prog-bar">
                                <div class="sd-prog-bar-fill"
                                    style="width:78%;background:linear-gradient(135deg, #8B5CF6, #6D28D9);"></div>
                            </div>
                        </div>

                        <!-- NEW: Tajweed & Recitation -->
                        <div class="sd-subject-prog-item">
                            <div class="sd-subject-prog-top">
                                <div class="sd-subject-prog-info">
                                    <div class="sd-subject-prog-icon"
                                        style="background:linear-gradient(135deg, #10B981, #059669);color:white"><i
                                            class="fas fa-microphone-alt"></i></div>
                                    <div>
                                        <div class="sd-subject-prog-name">Tajweed & Recitation</div>
                                        <div class="sd-subject-prog-lessons">9 / 12 lessons</div>
                                    </div>
                                </div>
                                <div class="sd-subject-prog-pct">75%</div>
                            </div>
                            <div class="sd-prog-bar">
                                <div class="sd-prog-bar-fill"
                                    style="width:75%;background:linear-gradient(135deg, #10B981, #059669);"></div>
                            </div>
                        </div>

                        <!-- NEW: Islamic Manners & Ethics (Akhlaq) -->
                        <div class="sd-subject-prog-item">
                            <div class="sd-subject-prog-top">
                                <div class="sd-subject-prog-info">
                                    <div class="sd-subject-prog-icon"
                                        style="background:linear-gradient(135deg, #F59E0B, #D97706);color:white"><i
                                            class="fas fa-hand-peace"></i></div>
                                    <div>
                                        <div class="sd-subject-prog-name">Akhlaq (Islamic Manners)</div>
                                        <div class="sd-subject-prog-lessons">15 / 20 lessons</div>
                                    </div>
                                </div>
                                <div class="sd-subject-prog-pct">75%</div>
                            </div>
                            <div class="sd-prog-bar">
                                <div class="sd-prog-bar-fill"
                                    style="width:75%;background:linear-gradient(135deg, #F59E0B, #D97706);"></div>
                            </div>
                        </div>

                        <!-- NEW: Duas & Adhkar -->
                        <div class="sd-subject-prog-item">
                            <div class="sd-subject-prog-top">
                                <div class="sd-subject-prog-info">
                                    <div class="sd-subject-prog-icon"
                                        style="background:linear-gradient(135deg, #EC4899, #BE185D);color:white"><i
                                            class="fas fa-hands-praying"></i></div>
                                    <div>
                                        <div class="sd-subject-prog-name">Duas & Adhkar</div>
                                        <div class="sd-subject-prog-lessons">18 / 25 lessons</div>
                                    </div>
                                </div>
                                <div class="sd-subject-prog-pct">72%</div>
                            </div>
                            <div class="sd-prog-bar">
                                <div class="sd-prog-bar-fill"
                                    style="width:72%;background:linear-gradient(135deg, #EC4899, #BE185D);"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Right panel --}}
            <div class="sd-quick-panel">

                {{-- Quick Actions --}}
                <div class="sd-quick-card">
                    <div class="sd-section-title">Quick Actions</div>
                    <div class="sd-quick-actions-grid">
                        <button class="sd-quick-action-btn btn-primary-action" onclick="openModal('lessonModal')">
                            <i class="fas fa-play-circle"></i> Resume Lesson
                        </button>
                        <button class="sd-quick-action-btn" onclick="openModal('quizModal')">
                            <i class="fas fa-question-circle"></i> Take Quiz
                        </button>
                        <button class="sd-quick-action-btn">
                            <i class="fas fa-file-pdf"></i> PDF Notes
                        </button>
                        <button class="sd-quick-action-btn">
                            <i class="fas fa-award"></i> My Certs
                        </button>
                        <a href="https://wa.me/256702082209" target="_blank" class="sd-quick-action-btn"
                            style="color:var(--green);">
                            <i class="fab fa-whatsapp"></i> Chat Teacher
                        </a>
                        <button class="sd-quick-action-btn">
                            <i class="fas fa-chart-line"></i> My Reports
                        </button>
                    </div>
                </div>

                {{-- Announcements --}}
                <div class="sd-quick-card">
                    <div class="sd-section-title">Announcements</div>
                    <div style="margin-top:14px;">
                        <div class="sd-announce-item">
                            <div class="sd-announce-icon" style="background:var(--red-light);color:var(--red);"><i
                                    class="fas fa-bullhorn"></i></div>
                            <div style="flex:1;">
                                <div class="sd-announce-title">Termly Exams — April 2025</div>
                                <div class="sd-announce-text">All S.3 exams begin April 28th. Ensure all lesson quizzes
                                    are passed before then.</div>
                            </div>
                            <div class="sd-announce-time">2h ago</div>
                        </div>
                        <div class="sd-announce-item">
                            <div class="sd-announce-icon" style="background:var(--gold-light);color:var(--gold);"><i
                                    class="fas fa-star"></i></div>
                            <div style="flex:1;">
                                <div class="sd-announce-title">New: Fiqh Chapter 6 Uploaded</div>
                                <div class="sd-announce-text">Ustadh Rashid has added 3 new video lessons to Fiqh,
                                    Level 3.</div>
                            </div>
                            <div class="sd-announce-time">1d ago</div>
                        </div>
                        <div class="sd-announce-item">
                            <div class="sd-announce-icon" style="background:var(--green-light);color:var(--green);"><i
                                    class="fas fa-certificate"></i></div>
                            <div style="flex:1;">
                                <div class="sd-announce-title">Certificate Ready!</div>
                                <div class="sd-announce-text">Your Level 2 completion certificate is ready to download.
                                </div>
                            </div>
                            <div class="sd-announce-time">3d ago</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ── LESSONS SECTION ── --}}
        <div class="sd-lessons-section">
            <div class="sd-section-head">
                <div class="sd-section-title">My Lessons</div>
                <a href="#" class="sd-view-all">View All Lessons <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="sd-tabs">
                <button class="sd-tab active" data-tab="inprogress">In Progress</button>
                <button class="sd-tab" data-tab="completed">Completed</button>
                <button class="sd-tab" data-tab="todo">To Do</button>
            </div>
            <div class="sd-lessons-grid" id="lessonsGrid">
                <!-- Rendered by JS -->
            </div>
        </div>

        {{-- ── BOTTOM GRID ── --}}
        <div class="sd-bottom-grid">

            {{-- Leaderboard --}}
            <div class="sd-leaderboard-card">
                <div class="sd-card-header" style="padding:18px 20px 12px;">
                    <div class="sd-section-title">Class Leaderboard</div>
                    <span style="font-size:0.72rem;color:var(--muted);font-weight:500;">This Month</span>
                </div>
                <div class="sd-leader-list">
                    <div class="sd-leader-item">
                        <div class="sd-leader-rank rank-1"><i class="fas fa-crown" style="font-size:0.65rem;"></i>
                        </div>
                        <div class="sd-leader-avatar-sm">FA</div>
                        <div class="sd-leader-name">Fatuma Abubakar<span>98% avg score</span></div>
                        <div class="sd-leader-score">1,240 pts</div>
                    </div>
                    <div class="sd-leader-item">
                        <div class="sd-leader-rank rank-2">2</div>
                        <div class="sd-leader-avatar-sm" style="background:linear-gradient(135deg,#475569,#94A3B8);">
                            MK</div>
                        <div class="sd-leader-name">Muhammad Kato<span>94% avg score</span></div>
                        <div class="sd-leader-score">1,180 pts</div>
                    </div>
                    <div class="sd-leader-item is-me">
                        <div class="sd-leader-rank rank-3">3</div>
                        <div class="sd-leader-avatar-sm">{{ strtoupper(substr(auth()->user()->name ?? 'ST', 0, 2)) }}
                        </div>
                        <div class="sd-leader-name">{{ auth()->user()->name ?? 'You' }} <span style="color:var(--purple);">←
                                You · 87% avg</span></div>
                        <div class="sd-leader-score" style="color:var(--purple);">1,090 pts</div>
                    </div>
                    <div class="sd-leader-item">
                        <div class="sd-leader-rank rank-other">4</div>
                        <div class="sd-leader-avatar-sm" style="background:linear-gradient(135deg,#B45309,#F59E0B);">
                            AN</div>
                        <div class="sd-leader-name">Aisha Nakimuli<span>82% avg score</span></div>
                        <div class="sd-leader-score">980 pts</div>
                    </div>
                    <div class="sd-leader-item">
                        <div class="sd-leader-rank rank-other">5</div>
                        <div class="sd-leader-avatar-sm" style="background:linear-gradient(135deg,#1D4ED8,#60A5FA);">
                            IS</div>
                        <div class="sd-leader-name">Ibrahim Ssemanda<span>78% avg score</span></div>
                        <div class="sd-leader-score">910 pts</div>
                    </div>
                </div>
            </div>

            {{-- Certificates --}}
            <div class="sd-leaderboard-card">
                <div class="sd-card-header" style="padding:18px 20px 12px;">
                    <div class="sd-section-title">My Certificates</div>
                    <a href="#" class="sd-view-all" style="font-size:0.72rem;">All <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="sd-cert-list">
                    <div class="sd-cert-item">
                        <div class="sd-cert-icon" style="background:var(--gold-light);color:var(--gold)"><i
                                class="fas fa-medal"></i></div>
                        <div>
                            <div class="sd-cert-name">Level 2 Completion</div>
                            <div class="sd-cert-date"><i class="fas fa-calendar-check"
                                    style="font-size:0.65rem;margin-right:4px;"></i>Issued: March 15, 2025</div>
                        </div>
                        <div class="sd-cert-download"><i class="fas fa-download"></i></div>
                    </div>
                    <div class="sd-cert-item">
                        <div class="sd-cert-icon" style="background:var(--purple-light);color:var(--purple)"><i
                                class="fas fa-award"></i></div>
                        <div>
                            <div class="sd-cert-name">Quran Recitation — P.6</div>
                            <div class="sd-cert-date"><i class="fas fa-calendar-check"
                                    style="font-size:0.65rem;margin-right:4px;"></i>Issued: Jan 10, 2025</div>
                        </div>
                        <div class="sd-cert-download"><i class="fas fa-download"></i></div>
                    </div>
                    <div class="sd-cert-item">
                        <div class="sd-cert-icon" style="background:var(--green-light);color:var(--green)"><i
                                class="fas fa-certificate"></i></div>
                        <div>
                            <div class="sd-cert-name">Level 1 — Full Completion</div>
                            <div class="sd-cert-date"><i class="fas fa-calendar-check"
                                    style="font-size:0.65rem;margin-right:4px;"></i>Issued: Sept 5, 2024</div>
                        </div>
                        <div class="sd-cert-download"><i class="fas fa-download"></i></div>
                    </div>
                    <div class="sd-cert-item" style="opacity:0.5;pointer-events:none;">
                        <div class="sd-cert-icon" style="background:var(--cream2);color:var(--muted)"><i
                                class="fas fa-lock"></i></div>
                        <div>
                            <div class="sd-cert-name">Level 3 Completion</div>
                            <div class="sd-cert-date">Complete all S.3 lessons to unlock</div>
                        </div>
                        <div class="sd-cert-download" style="background:var(--cream2);color:var(--muted);"><i
                                class="fas fa-lock"></i></div>
                    </div>
                </div>
            </div>

            {{-- Upcoming Exams --}}
            <div class="sd-leaderboard-card">
                <div class="sd-card-header" style="padding:18px 20px 12px;">
                    <div class="sd-section-title">Upcoming Exams</div>
                    <a href="#" class="sd-view-all" style="font-size:0.72rem;">Schedule <i
                            class="fas fa-arrow-right"></i></a>
                </div>
                <div class="sd-exam-list">
                    <div class="sd-exam-item">
                        <div class="sd-exam-date-box">
                            <div class="sd-exam-day">28</div>
                            <div class="sd-exam-month">Apr</div>
                        </div>
                        <div>
                            <div class="sd-exam-name">Tafsir — Term Exam</div>
                            <div class="sd-exam-subject"><i class="fas fa-clock"
                                    style="font-size:0.65rem;margin-right:3px;"></i>90 mins · S.3 Level</div>
                        </div>
                        <div class="sd-exam-badge badge-soon">5 days</div>
                    </div>
                    <div class="sd-exam-item">
                        <div class="sd-exam-date-box">
                            <div class="sd-exam-day">02</div>
                            <div class="sd-exam-month">May</div>
                        </div>
                        <div>
                            <div class="sd-exam-name">Arabic Language Test</div>
                            <div class="sd-exam-subject"><i class="fas fa-clock"
                                    style="font-size:0.65rem;margin-right:3px;"></i>60 mins · S.3 Level</div>
                        </div>
                        <div class="sd-exam-badge badge-upcoming">9 days</div>
                    </div>
                    <div class="sd-exam-item">
                        <div class="sd-exam-date-box">
                            <div class="sd-exam-day">10</div>
                            <div class="sd-exam-month">May</div>
                        </div>
                        <div>
                            <div class="sd-exam-name">Fiqh — Chapter Assessment</div>
                            <div class="sd-exam-subject"><i class="fas fa-clock"
                                    style="font-size:0.65rem;margin-right:3px;"></i>75 mins · S.3 Level</div>
                        </div>
                        <div class="sd-exam-badge badge-later">17 days</div>
                    </div>
                    <div class="sd-exam-item">
                        <div class="sd-exam-date-box">
                            <div class="sd-exam-day">18</div>
                            <div class="sd-exam-month">May</div>
                        </div>
                        <div>
                            <div class="sd-exam-name">Seerah — Term End Exam</div>
                            <div class="sd-exam-subject"><i class="fas fa-clock"
                                    style="font-size:0.65rem;margin-right:3px;"></i>90 mins · S.3 Level</div>
                        </div>
                        <div class="sd-exam-badge badge-later">25 days</div>
                    </div>
                </div>
            </div>

        </div>

    </div>{{-- /sd-content --}}
    </div>{{-- /sd-main --}}

    {{-- ════════════ MODALS ════════════ --}}

    {{-- Lesson Modal --}}
    <div class="sd-modal" id="lessonModal">
        <div class="sd-modal-box">
            <button class="sd-modal-close" onclick="closeModal('lessonModal')"><i class="fas fa-times"></i></button>
            <div class="sd-modal-icon"><i class="fas fa-play-circle"></i></div>
            <div class="sd-modal-title">Tafsir — Chapter 5, Lesson 3</div>
            <div class="sd-modal-sub">Video Lesson · 24 minutes · Ustadh Rashid Al-Farouq</div>
            <div
                style="background:var(--ink);border-radius:16px;aspect-ratio:16/9;display:flex;align-items:center;justify-content:center;margin-bottom:18px;position:relative;overflow:hidden;">
                <div
                    style="position:absolute;inset:0;background:radial-gradient(circle at center,rgba(107,70,193,0.3),transparent 70%);">
                </div>
                <button
                    style="width:60px;height:60px;border-radius:50%;background:var(--gradient);color:white;font-size:1.3rem;border:none;cursor:pointer;box-shadow:0 8px 24px rgba(107,70,193,0.5);z-index:2;transition:transform 0.2s;"
                    onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                    <i class="fas fa-play"></i>
                </button>
            </div>
            <div style="display:flex;gap:10px;">
                <button onclick="closeModal('lessonModal')"
                    style="flex:1;padding:11px;background:var(--cream2);border-radius:50px;font-size:0.85rem;font-weight:600;color:var(--muted);border:1px solid var(--border);">Close</button>
                <button onclick="closeModal('lessonModal');openModal('quizModal')"
                    style="flex:1;padding:11px;background:var(--gradient);color:white;border-radius:50px;font-size:0.85rem;font-weight:600;box-shadow:0 4px 14px rgba(107,70,193,0.3);">Take
                    Quiz <i class="fas fa-arrow-right"></i></button>
            </div>
        </div>
    </div>

    {{-- Quiz Modal --}}
    <div class="sd-modal" id="quizModal">
        <div class="sd-modal-box">
            <button class="sd-modal-close" onclick="closeModal('quizModal')"><i class="fas fa-times"></i></button>
            <div class="sd-modal-icon" style="color:var(--red);"><i class="fas fa-question-circle"></i></div>
            <div class="sd-modal-title" id="qzTitle">Tafsir — Chapter 5 Quiz</div>
            <div class="sd-modal-sub">Answer all questions. You need 60% or above to pass.</div>
            <div id="qzQuestions"></div>
            <div class="quiz-result-box" id="qzResult" style="display:none;"></div>
            <button class="sd-submit-quiz-btn" id="qzSubmitBtn">
                <i class="fas fa-check"></i> Submit Answers
            </button>
        </div>
    </div>

    {{-- Notification Modal --}}
    <div class="sd-modal" id="notifModal">
        <div class="sd-modal-box" style="max-width:400px;">
            <button class="sd-modal-close" onclick="closeModal('notifModal')"><i class="fas fa-times"></i></button>
            <div class="sd-modal-title" style="margin-bottom:18px;">Notifications</div>
            <div style="display:flex;flex-direction:column;gap:0;">
                <div
                    style="display:flex;align-items:flex-start;gap:12px;padding:12px 0;border-bottom:1px solid var(--border);">
                    <div
                        style="width:36px;height:36px;border-radius:10px;background:var(--red-light);color:var(--red);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div>
                        <div style="font-size:0.82rem;font-weight:600;color:var(--ink);margin-bottom:3px;">Exam Reminder:
                            Tafsir in 5 days</div>
                        <div style="font-size:0.75rem;color:var(--muted);">Make sure you've passed all 15 lesson quizzes
                            before the exam.</div>
                    </div>
                </div>
                <div
                    style="display:flex;align-items:flex-start;gap:12px;padding:12px 0;border-bottom:1px solid var(--border);">
                    <div
                        style="width:36px;height:36px;border-radius:10px;background:var(--gold-light);color:var(--gold);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div>
                        <div style="font-size:0.82rem;font-weight:600;color:var(--ink);margin-bottom:3px;">3 New Fiqh
                            Lessons Added</div>
                        <div style="font-size:0.75rem;color:var(--muted);">Ustadh Rashid uploaded Chapter 6 with video +
                            PDF notes.</div>
                    </div>
                </div>
                <div
                    style="display:flex;align-items:flex-start;gap:12px;padding:12px 0;border-bottom:1px solid var(--border);">
                    <div
                        style="width:36px;height:36px;border-radius:10px;background:var(--green-light);color:var(--green);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-award"></i>
                    </div>
                    <div>
                        <div style="font-size:0.82rem;font-weight:600;color:var(--ink);margin-bottom:3px;">Certificate
                            Ready to Download</div>
                        <div style="font-size:0.75rem;color:var(--muted);">Your Level 2 completion certificate is now
                            available.</div>
                    </div>
                </div>
                <div
                    style="display:flex;align-items:flex-start;gap:12px;padding:12px 0;border-bottom:1px solid var(--border);">
                    <div
                        style="width:36px;height:36px;border-radius:10px;background:var(--purple-light);color:var(--purple);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div>
                        <div style="font-size:0.82rem;font-weight:600;color:var(--ink);margin-bottom:3px;">You're #3 on the
                            Class Leaderboard!</div>
                        <div style="font-size:0.75rem;color:var(--muted);">Keep passing quizzes to move up this month.
                        </div>
                    </div>
                </div>
                <div style="display:flex;align-items:flex-start;gap:12px;padding:12px 0;">
                    <div
                        style="width:36px;height:36px;border-radius:10px;background:var(--blue-light);color:var(--blue);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-comment"></i>
                    </div>
                    <div>
                        <div style="font-size:0.82rem;font-weight:600;color:var(--ink);margin-bottom:3px;">Teacher replied
                            to your question</div>
                        <div style="font-size:0.75rem;color:var(--muted);">Ustadh Rashid answered your question on Hadith
                            Ch. 3.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // ── MODAL HELPERS ────────────────────────────────────────
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

        // ── SIDEBAR TOGGLE ────────────────────────────────────────
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('open');
        }

        // ── NAV ACTIVE STATE ─────────────────────────────────────
document.querySelectorAll('.sd-nav-item').forEach(item => {
    item.addEventListener('click', function(e) {

        const hasSection = this.dataset.section;

        // Only prevent if you're actually using SPA sections
        if (hasSection && this.getAttribute('href') === '#') {
            e.preventDefault();
        }

    });
});

        // ── LESSON DATA ──────────────────────────────────────────
        const lessonData = {
            inprogress: [{
                title: 'Tafsir — Surah Al-Baqarah Part 3',
                subject: 'Quran & Tafsir',
                icon: 'fas fa-book-quran',
                subjColor: 'purple',
                type: 'video',
                typeIcon: 'fas fa-video',
                duration: '24 min',
                progress: 72,
                passed: false
            },
            {
                title: 'Principles of Hadith Authentication',
                subject: 'Hadith Studies',
                icon: 'fas fa-scroll',
                subjColor: 'red',
                type: 'audio',
                typeIcon: 'fas fa-headphones',
                duration: '18 min',
                progress: 45,
                passed: false
            },
            {
                title: 'Wudu & Salah — Advanced Rules',
                subject: 'Fiqh',
                icon: 'fas fa-scale-balanced',
                subjColor: 'gold',
                type: 'pdf',
                typeIcon: 'fas fa-file-pdf',
                duration: '30 min',
                progress: 88,
                passed: false
            },
            ],
            completed: [{
                title: 'Introduction to Tafsir Methodology',
                subject: 'Quran & Tafsir',
                icon: 'fas fa-book-quran',
                subjColor: 'purple',
                type: 'video',
                typeIcon: 'fas fa-video',
                duration: '20 min',
                progress: 100,
                passed: true
            },
            {
                title: 'The Life of Prophet Muhammad ﷺ',
                subject: 'Seerah',
                icon: 'fas fa-mosque',
                subjColor: 'blue',
                type: 'video',
                typeIcon: 'fas fa-video',
                duration: '32 min',
                progress: 100,
                passed: true
            },
            {
                title: 'Arabic Alphabet & Pronunciation',
                subject: 'Arabic',
                icon: 'fas fa-language',
                subjColor: 'green',
                type: 'pdf',
                typeIcon: 'fas fa-file-pdf',
                duration: '15 min',
                progress: 100,
                passed: true
            },
            ],
            todo: [{
                title: 'Hadith of Jibreel — Commentary',
                subject: 'Hadith Studies',
                icon: 'fas fa-scroll',
                subjColor: 'red',
                type: 'video',
                typeIcon: 'fas fa-video',
                duration: '28 min',
                progress: 0,
                passed: false
            },
            {
                title: 'Zakat — Calculation & Rules',
                subject: 'Fiqh',
                icon: 'fas fa-scale-balanced',
                subjColor: 'gold',
                type: 'audio',
                typeIcon: 'fas fa-headphones',
                duration: '22 min',
                progress: 0,
                passed: false
            },
            {
                title: 'Arabic Verb Conjugation Basics',
                subject: 'Arabic',
                icon: 'fas fa-language',
                subjColor: 'green',
                type: 'pdf',
                typeIcon: 'fas fa-file-pdf',
                duration: '20 min',
                progress: 0,
                passed: false
            },
            ]
        };

        const colorMap = {
            purple: {
                tag: 'background:var(--purple-light);color:var(--purple)',
                icon: 'background:var(--purple-light);color:var(--purple)'
            },
            red: {
                tag: 'background:var(--red-light);color:var(--red)',
                icon: 'background:var(--red-light);color:var(--red)'
            },
            gold: {
                tag: 'background:var(--gold-light);color:var(--gold)',
                icon: 'background:var(--gold-light);color:var(--gold)'
            },
            blue: {
                tag: 'background:var(--blue-light);color:var(--blue)',
                icon: 'background:var(--blue-light);color:var(--blue)'
            },
            green: {
                tag: 'background:var(--green-light);color:var(--green)',
                icon: 'background:var(--green-light);color:var(--green)'
            },
        };

        let activeTab = 'inprogress';

        function renderLessons(tab) {
            const grid = document.getElementById('lessonsGrid');
            const lessons = lessonData[tab];
            grid.innerHTML = lessons.map((l, i) => `
                            <div class="sd-lesson-card">
                                <div class="sd-lesson-card-top">
                                    <div class="sd-lesson-type-icon" style="${colorMap[l.subjColor].icon}"><i class="${l.typeIcon}"></i></div>
                                    <span class="sd-lesson-subject-tag" style="${colorMap[l.subjColor].tag}">
                                        <i class="${l.icon}" style="font-size:0.65rem;"></i> ${l.subject}
                                    </span>
                                    <div class="sd-lesson-title">${l.title}</div>
                                    <div class="sd-lesson-meta">
                                        <span><i class="fas fa-clock"></i> ${l.duration}</span>
                                        <span><i class="fas fa-${l.type}"></i> ${l.type.charAt(0).toUpperCase() + l.type.slice(1)}</span>
                                        ${l.progress > 0 ? `<span><i class="fas fa-chart-simple"></i> ${l.progress}%</span>` : ''}
                                    </div>
                                </div>
                                <div class="sd-lesson-card-bottom">
                                    ${l.progress > 0 ? `
                                        <div class="sd-lesson-progress-row"><span>Progress</span><span>${l.progress}%</span></div>
                                        <div class="sd-lesson-prog-bar"><div class="sd-lesson-prog-fill" style="width:${l.progress}%;"></div></div>
                                        ` : '<div style="height:4px;margin-bottom:12px;"></div>'}
                                    <div class="sd-lesson-actions">
                                        <button class="sd-btn-view" onclick="openModal('lessonModal')">
                                            <i class="fas fa-play"></i> ${l.progress > 0 && l.progress < 100 ? 'Resume' : l.progress === 100 ? 'Review' : 'Start'}
                                        </button>
                                        ${l.passed
                    ? '<span class="sd-btn-passed"><i class="fas fa-check-circle"></i> Quiz Passed</span>'
                    : `<button class="sd-btn-quiz" onclick="openModal('quizModal')"><i class="fas fa-question-circle"></i> Quiz</button>`
                }
                                    </div>
                                </div>
                            </div>
                        `).join('');
        }

        // ── TABS ─────────────────────────────────────────────────
        document.querySelectorAll('.sd-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.sd-tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                activeTab = tab.dataset.tab;
                renderLessons(activeTab);
            });
        });

        // ── QUIZ LOGIC ───────────────────────────────────────────
        const quizData = [{
            q: 'What is the primary linguistic meaning of "Tafsir"?',
            opts: ['Explanation & Elucidation', 'Memorisation', 'Recitation', 'Translation'],
            correct: 0
        },
        {
            q: 'Which companion was most renowned for his knowledge of Tafsir?',
            opts: ['Abu Bakr (RA)', 'Abdullah ibn Masood (RA)', 'Bilal (RA)', 'Umar (RA)'],
            correct: 1
        },
        {
            q: 'What is a prerequisite for giving a valid Tafsir?',
            opts: ['Knowledge of Arabic language', 'Only memorising Quran', 'Knowing all scholars',
                'Writing skill'],
            correct: 0
        },
        {
            q: 'What does "Tafsir bil-Mathur" refer to?',
            opts: ['Tafsir by personal opinion', 'Tafsir based on narrations & tradition', 'Tafsir through science',
                'Tafsir by dreams'
            ],
            correct: 1
        },
        {
            q: 'Which surah is this chapter\'s Tafsir focused on?',
            opts: ['Al-Fatiha', 'Al-Baqarah', 'Al-Imran', 'An-Nisa'],
            correct: 1
        }
        ];

        function renderQuiz() {
            document.getElementById('qzQuestions').innerHTML = quizData.map((q, i) => `
                            <div class="quiz-q-block">
                                <p>${i + 1}. ${q.q}</p>
                                ${q.opts.map((opt, oi) => `
                                        <label class="quiz-opt">
                                            <input type="radio" name="qz${i}" value="${oi}" style="width:auto;"> ${opt}
                                        </label>`).join('')}
                            </div>`).join('');
            document.getElementById('qzResult').style.display = 'none';
        }

        document.getElementById('qzSubmitBtn').addEventListener('click', () => {
            let correct = 0;
            quizData.forEach((q, i) => {
                const sel = document.querySelector(`input[name="qz${i}"]:checked`);
                if (sel && parseInt(sel.value) === q.correct) correct++;
            });
            const pct = Math.round((correct / quizData.length) * 100);
            const passed = pct >= 60;
            const rb = document.getElementById('qzResult');
            rb.style.display = 'block';
            rb.className = `quiz-result-box ${passed ? 'qr-pass' : 'qr-fail'}`;
            rb.innerHTML = passed ?
                `<i class="fas fa-check-circle"></i> Excellent! You scored ${pct}% (${correct}/${quizData.length}) — Quiz Passed!` :
                `<i class="fas fa-times-circle"></i> You scored ${pct}% — You need 60% to pass. Review the lesson and try again.`;
            if (passed) {
                Swal.fire({
                    title: 'Quiz Passed! 🎉',
                    html: `Congratulations! You scored <strong>${pct}%</strong>.`,
                    icon: 'success',
                    confirmButtonColor: '#6B46C1',
                    timer: 3000
                });
            }
        });

        // ── INIT ─────────────────────────────────────────────────
        renderLessons('inprogress');
        renderQuiz();
    </script>
@endsection