@extends('layouts.master')
@section('css')
    <!-- Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <!-- Daterangepicker css -->
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
    <style>
        /* Teacher Dashboard Custom Styles */
        .bottom-nav-teacher {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: white;
            display: flex;
            justify-content: space-around;
            padding: 0.6rem 0.8rem 0.8rem;
            border-top: 1px solid #e9ecef;
            z-index: 1000;
            box-shadow: 0 -2px 15px rgba(0,0,0,0.08);
        }
        .nav-item-teacher {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            text-decoration: none;
            color: #6c757d;
            font-size: 0.7rem;
            font-weight: 500;
            transition: 0.2s;
            cursor: pointer;
            background: none;
            border: none;
            flex: 1;
            padding: 5px 0;
            border-radius: 12px;
        }
        .nav-item-teacher i {
            font-size: 1.4rem;
        }
        .nav-item-teacher.active {
            color: #7c3a8c;
            background: rgba(124,58,140,0.1);
        }
        .nav-item-teacher:hover {
            color: #7c3a8c;
        }
        .teacher-section {
            display: none;
            animation: fadeIn 0.3s ease;
            margin-bottom: 80px;
        }
        .teacher-section.active-section {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .upload-area {
            border: 2px dashed #d4a373;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            background: #fef9ef;
            cursor: pointer;
            transition: 0.2s;
        }
        .upload-area:hover {
            border-color: #7c3a8c;
            background: #faf5ea;
        }
        .exam-card, .lesson-card {
            background: white;
            border-radius: 16px;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid #e9ecef;
            transition: 0.2s;
        }
        .exam-card:hover, .lesson-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transform: translateY(-2px);
        }
        .report-stat {
            background: linear-gradient(135deg, #7c3a8c, #9b4d96);
            color: white;
            border-radius: 20px;
            padding: 1.2rem;
            text-align: center;
        }
        .btn-teacher {
            background: #7c3a8c;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: 0.2s;
        }
        .btn-teacher:hover {
            background: #5a2a6e;
            color: white;
            transform: translateY(-1px);
        }
        .btn-outline-teacher {
            background: transparent;
            border: 1px solid #7c3a8c;
            color: #7c3a8c;
            padding: 8px 20px;
            border-radius: 30px;
            transition: 0.2s;
        }
        .btn-outline-teacher:hover {
            background: #7c3a8c;
            color: white;
        }
        .quiz-question-item {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
            border-left: 3px solid #7c3a8c;
        }
        .stats-card {
            background: white;
            border-radius: 20px;
            padding: 1.2rem;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: 0.2s;
        }
        .stats-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .badge-passed {
            background: #28a745;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
        }
        .badge-failed {
            background: #dc3545;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
        }
        .badge-honors {
            background: #ffc107;
            color: #856404;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }
        .progress-custom {
            height: 8px;
            border-radius: 10px;
            background: #e9ecef;
        }
        .progress-bar-custom {
            background: #7c3a8c;
            border-radius: 10px;
        }
        .honors-first { background: linear-gradient(135deg, #ffd700, #ffb347); color: #4a1d6d; }
        .honors-second { background: linear-gradient(135deg, #c0c0c0, #a0a0a0); color: #2c3e50; }
        .honors-third { background: linear-gradient(135deg, #cd7f32, #b87333); color: white; }
        .honors-fourth { background: linear-gradient(135deg, #90be6d, #6c9e4f); color: white; }
    </style>
@endsection
@section('page-header')
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">Teacher Dashboard</h4>
            <p class="text-muted mb-0">Manage Islamic education content | P.1 – S.6 Curriculum</p>
        </div>
        <div class="page-rightheader">
            <div class="btn-list">
                <span class="badge badge-pill badge-primary px-3 py-2">
                    <i class="fas fa-chalkboard-teacher"></i> Ustadh Ahmed Al-Hilali
                </span>
                <span class="badge badge-pill badge-light px-3 py-2">
                    <i class="fas fa-language"></i> Arabic | English
                </span>
             
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- Statistics Cards with Dummy Data -->
    <div class="row mb-4">
        <div class="col-xl-3 col-lg-3 col-md-6">
            <div class="stats-card">
                <i class="fas fa-book-open text-primary" style="font-size: 32px;"></i>
                <p class="mb-1 mt-2 text-muted">Total Lessons</p>
                <h2 class="mb-0 font-weight-bold" id="totalLessons">156</h2>
                <small class="text-success"><i class="fas fa-arrow-up"></i> +24 this month</small>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6">
            <div class="stats-card">
                <i class="fas fa-file-alt text-success" style="font-size: 32px;"></i>
                <p class="mb-1 mt-2 text-muted">Exams Created</p>
                <h2 class="mb-0 font-weight-bold" id="totalExams">42</h2>
                <small class="text-success"><i class="fas fa-arrow-up"></i> +8 this month</small>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6">
            <div class="stats-card">
                <i class="fas fa-users text-info" style="font-size: 32px;"></i>
                <p class="mb-1 mt-2 text-muted">Active Students</p>
                <h2 class="mb-0 font-weight-bold" id="activeStudents">847</h2>
                <small class="text-success"><i class="fas fa-arrow-up"></i> +127 this week</small>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6">
            <div class="stats-card">
                <i class="fas fa-chart-line text-warning" style="font-size: 32px;"></i>
                <p class="mb-1 mt-2 text-muted">Avg. Quiz Score</p>
                <h2 class="mb-0 font-weight-bold" id="avgScore">74.8%</h2>
                <small class="text-success"><i class="fas fa-arrow-up"></i> +3.2%</small>
            </div>
        </div>
    </div>

    <!-- Upload Content Section -->
    <div id="uploadContentSection" class="teacher-section active-section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-cloud-upload-alt mr-2"></i> Upload New Content</h3>
                        <div class="card-options">
                            <span class="badge badge-info">Notes | Videos | Audios</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="uploadContentForm">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-layer-group"></i> Select Level</label>
                                        <select class="form-control" id="levelSelect" required>
                                            <option value="">Choose Level</option>
                                            <option value="Level 1 (P.1-P.4)">Level 1 (P.1-P.4)</option>
                                            <option value="Level 2 (P.5-P.7)">Level 2 (P.5-P.7)</option>
                                            <option value="Level 3 (S.1-S.3)">Level 3 (S.1-S.3)</option>
                                            <option value="Level 4 (S.4-S.5)">Level 4 (S.4-S.5)</option>
                                            <option value="Level 5 (S.6)">Level 5 (S.6)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-chalkboard"></i> Select Class</label>
                                        <select class="form-control" id="classSelect" required>
                                            <option value="">Choose Class</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-book"></i> Subject</label>
                                        <input type="text" class="form-control" id="subjectName" placeholder="Qur'an, Fiqh, Seerah, Lugha" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fas fa-heading"></i> Lesson Title</label>
                                        <input type="text" class="form-control" id="lessonTitle" placeholder="Enter lesson title (Arabic/English)" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fas fa-file-alt"></i> Content Type</label>
                                        <select class="form-control" id="contentType" required>
                                            <option value="video">Video Lesson</option>
                                            <option value="audio">Audio Lesson</option>
                                            <option value="pdf">PDF Notes (Arabic+Translation)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fas fa-dollar-sign"></i> Price (UG)</label>
                                        <input type="number" class="form-control" id="price" placeholder="0.00" value="2.99" step="0.01">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><i class="fas fa-link"></i> Content URL / File Link</label>
                                        <input type="text" class="form-control" id="contentUrl" placeholder="YouTube link, audio URL, or PDF link" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><i class="fas fa-align-left"></i> Lesson Description</label>
                                        <textarea class="form-control" id="lessonDesc" rows="3" placeholder="Describe what students will learn in this lesson..."></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-teacher"><i class="fas fa-upload"></i> Upload Lesson</button>
                                    <button type="reset" class="btn btn-outline-teacher ml-2"><i class="fas fa-undo"></i> Reset</button>
                                </div>
                            </div>
                        </form>
                        
                        <hr class="mt-4">
                        <h5><i class="fas fa-history"></i> Recently Uploaded Lessons</h5>
                        <div id="recentLessonsList" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Exams Section -->
    <div id="createExamsSection" class="teacher-section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-pen-alt mr-2"></i> Create New Exam / Quiz</h3>
                        <div class="card-options">
                            <span class="badge badge-warning">Auto-marked | Randomized MCQs</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="createExamForm">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-tag"></i> Exam Title</label>
                                        <input type="text" class="form-control" id="examTitle" required placeholder="e.g., Quran Quiz - Surah Al-Fatihah">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fas fa-layer-group"></i> Level</label>
                                        <select class="form-control" id="examLevel" required>
                                            <option value="">Select Level</option>
                                            <option value="Level 1">Level 1 (P.1-P.4)</option>
                                            <option value="Level 2">Level 2 (P.5-P.7)</option>
                                            <option value="Level 3">Level 3 (S.1-S.3)</option>
                                            <option value="Level 4">Level 4 (S.4-S.5)</option>
                                            <option value="Level 5">Level 5 (S.6)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fas fa-book"></i> Subject</label>
                                        <input type="text" class="form-control" id="examSubject" placeholder="Qur'an, Fiqh, etc." required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><i class="fas fa-clock"></i> Duration (min)</label>
                                        <input type="number" class="form-control" id="examDuration" value="30" required>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> Exams are auto-marked. Students need ≥50% to pass. Grading: 80-100% First Class, 70-79% Second Class, 60-69% Third Class, 50-59% Fourth Class.
                            </div>
                            <div id="questionsContainer">
                                <div class="quiz-question-item" data-question-idx="0">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label><strong><i class="fas fa-question-circle"></i> Question 1</strong></label>
                                            <input type="text" class="form-control" placeholder="Enter question text" name="question[]" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label><i class="fas fa-check-circle"></i> Correct Answer (0-3)</label>
                                            <input type="number" class="form-control" placeholder="0,1,2,3" name="correct[]" min="0" max="3" required>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6"><input type="text" class="form-control" placeholder="Option A" name="opt1[]" required></div>
                                        <div class="col-md-6"><input type="text" class="form-control" placeholder="Option B" name="opt2[]" required></div>
                                        <div class="col-md-6 mt-2"><input type="text" class="form-control" placeholder="Option C" name="opt3[]" required></div>
                                        <div class="col-md-6 mt-2"><input type="text" class="form-control" placeholder="Option D" name="opt4[]" required></div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-teacher mb-3" id="addQuestionBtn"><i class="fas fa-plus"></i> Add Question</button>
                            <div>
                                <button type="submit" class="btn btn-teacher"><i class="fas fa-save"></i> Create Exam</button>
                                <button type="reset" class="btn btn-outline-teacher ml-2"><i class="fas fa-undo"></i> Reset</button>
                            </div>
                        </form>
                        
                        <hr class="mt-4">
                        <h5><i class="fas fa-list"></i> Existing Exams</h5>
                        <div id="examsList" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Reports Section -->
    <div id="viewReportsSection" class="teacher-section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i> Student Performance Reports</h3>
                        <div class="card-options">
                            <span class="badge badge-success">With Academy Logo Watermark</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="report-stat">
                                    <i class="fas fa-chart-line fa-2x mb-2"></i>
                                    <h4>Class Average</h4>
                                    <h2 class="mb-0" id="classAverage">74.8%</h2>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="report-stat" style="background: linear-gradient(135deg, #e35f5f, #c24b4b);">
                                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                                    <h4>Pass Rate</h4>
                                    <h2 class="mb-0" id="passRate">71%</h2>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="report-stat" style="background: linear-gradient(135deg, #4caf50, #2e7d32);">
                                    <i class="fas fa-trophy fa-2x mb-2"></i>
                                    <h4>Top Student Score</h4>
                                    <h2 class="mb-0" id="topScore">98%</h2>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="report-stat" style="background: linear-gradient(135deg, #ff9800, #f57c00);">
                                    <i class="fas fa-users fa-2x mb-2"></i>
                                    <h4>Students Tested</h4>
                                    <h2 class="mb-0" id="studentsTested">623</h2>
                                </div>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="reportsTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Reg. Number</th>
                                        <th>Exam Title</th>
                                        <th>Score</th>
                                        <th>Honors Classification</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Report</th>
                                    </tr>
                                </thead>
                                <tbody id="reportsTableBody">
                                    <!-- Dummy data will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Section -->
    <div id="analyticsSection" class="teacher-section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-chart-line mr-2"></i> Learning Analytics Dashboard</h3>
                        <div class="card-options">
                            <span class="badge badge-primary">Real-time Insights</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5>Lesson Completion Rate by Level</h5>
                                        <canvas id="lessonCompletionChart" width="400" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5>Subject Performance Analysis</h5>
                                        <canvas id="subjectPerformanceChart" width="400" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5>Weekly Quiz Scores Trend</h5>
                                        <canvas id="weeklyTrendChart" width="400" height="250"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5><i class="fas fa-trophy"></i> Top Performing Subjects</h5>
                                        <div id="topSubjectsList" class="mt-2"></div>
                                        <hr>
                                        <h5 class="mt-3"><i class="fas fa-exclamation-triangle"></i> Areas for Improvement</h5>
                                        <div id="improvementAreas"></div>
                                        <hr>
                                        <h5 class="mt-3"><i class="fas fa-chart-simple"></i> Honors Distribution</h5>
                                        <div id="honorsDistribution"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Navigation for Teacher -->
    <div class="bottom-nav-teacher">
        <button class="nav-item-teacher" data-section="uploadContentSection">
            <i class="fas fa-cloud-upload-alt"></i>
            <span>Upload</span>
        </button>
        <button class="nav-item-teacher" data-section="createExamsSection">
            <i class="fas fa-pen-alt"></i>
            <span>Exams</span>
        </button>
        <button class="nav-item-teacher" data-section="viewReportsSection">
            <i class="fas fa-chart-bar"></i>
            <span>Reports</span>
        </button>
        <button class="nav-item-teacher" data-section="analyticsSection">
            <i class="fas fa-chart-line"></i>
            <span>Analytics</span>
        </button>
        <button class="nav-item-teacher" id="teacherLogoutBtn" style="color: #dc3545;">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span>
    </button>
    </div>
@endsection
@section('js')
    <!-- Chart js -->
    <script src="{{ URL::asset('assets/plugins/chart/chart.bundle.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Dummy Data based on system requirements
        let lessonsData = [
            { id: 1, title: "Introduction to Tajweed", level: "Level 1", class: "P.3", subject: "Qur'an", type: "video", price: 2.99, date: "2025-03-25", views: 156 },
            { id: 2, title: "Basics of Wudu (Ablution)", level: "Level 2", class: "P.6", subject: "Fiqh", type: "video", price: 2.99, date: "2025-03-24", views: 142 },
            { id: 3, title: "Prophet Muhammad ﷺ - Early Life", level: "Level 3", class: "S.2", subject: "Seerah", type: "pdf", price: 1.99, date: "2025-03-23", views: 198 },
            { id: 4, title: "Arabic Alphabet - Pronunciation", level: "Level 1", class: "P.2", subject: "Lugha", type: "audio", price: 1.49, date: "2025-03-22", views: 234 },
            { id: 5, title: "The 5 Pillars of Islam", level: "Level 2", class: "P.7", subject: "Fiqh", type: "video", price: 2.99, date: "2025-03-21", views: 312 },
            { id: 6, title: "Tafsir - Surah Al-Fatihah", level: "Level 4", class: "S.4", subject: "Qur'an", type: "video", price: 3.99, date: "2025-03-20", views: 187 },
            { id: 7, title: "Hadith - The Importance of Knowledge", level: "Level 5", class: "S.6", subject: "Hadith", type: "pdf", price: 2.49, date: "2025-03-19", views: 145 }
        ];
        
        let examsData = [
            { id: 1, title: "Qur'an Quiz - Surah Al-Fatihah", level: "Level 1", subject: "Qur'an", questions: 10, duration: 20, date: "2025-03-20", attempts: 234, avgScore: 82 },
            { id: 2, title: "Fiqh - Taharah (Purity)", level: "Level 2", subject: "Fiqh", questions: 15, duration: 30, date: "2025-03-19", attempts: 189, avgScore: 76 },
            { id: 3, title: "Seerah - Makkah Period", level: "Level 3", subject: "Seerah", questions: 12, duration: 25, date: "2025-03-18", attempts: 156, avgScore: 85 },
            { id: 4, title: "Arabic Grammar - Nouns", level: "Level 4", subject: "Lugha", questions: 20, duration: 40, date: "2025-03-17", attempts: 98, avgScore: 68 },
            { id: 5, title: "Hadith - 40 Hadith Nawawi", level: "Level 5", subject: "Hadith", questions: 15, duration: 35, date: "2025-03-16", attempts: 87, avgScore: 79 }
        ];
        
        let reportsData = [
            { student: "Amina Hassan", reg: "L1-001", exam: "Qur'an Quiz - Surah Al-Fatihah", score: 92, honors: "First Class Honors", status: "Passed", date: "2025-03-28", cert: true },
            { student: "Ibrahim Musa", reg: "L1-023", exam: "Qur'an Quiz - Surah Al-Fatihah", score: 88, honors: "First Class Honors", status: "Passed", date: "2025-03-28", cert: true },
            { student: "Fatima Ali", reg: "L2-045", exam: "Fiqh - Taharah", score: 95, honors: "First Class Honors", status: "Passed", date: "2025-03-27", cert: true },
            { student: "Yusuf Kato", reg: "L2-067", exam: "Fiqh - Taharah", score: 45, honors: "Failed", status: "Failed", date: "2025-03-27", cert: false },
            { student: "Aisha Nambi", reg: "L3-089", exam: "Seerah - Makkah Period", score: 78, honors: "Second Class Honors", status: "Passed", date: "2025-03-26", cert: true },
            { student: "Omar Ssebunya", reg: "L3-102", exam: "Seerah - Makkah Period", score: 82, honors: "First Class Honors", status: "Passed", date: "2025-03-26", cert: true },
            { student: "Zainab Nabatanzi", reg: "L4-034", exam: "Arabic Grammar - Nouns", score: 67, honors: "Third Class Honors", status: "Passed", date: "2025-03-25", cert: true },
            { student: "Hamza Kayemba", reg: "L4-056", exam: "Arabic Grammar - Nouns", score: 52, honors: "Fourth Class Honors", status: "Passed", date: "2025-03-25", cert: true },
            { student: "Maryam Naluyima", reg: "L5-078", exam: "Hadith - 40 Hadith Nawawi", score: 34, honors: "Failed", status: "Failed", date: "2025-03-24", cert: false },
            { student: "Abdullah Ssemakula", reg: "L5-091", exam: "Hadith - 40 Hadith Nawawi", score: 96, honors: "First Class Honors", status: "Passed", date: "2025-03-24", cert: true },
            { student: "Khadija Nsereko", reg: "L1-112", exam: "Qur'an Quiz - Surah Al-Fatihah", score: 71, honors: "Second Class Honors", status: "Passed", date: "2025-03-23", cert: true },
            { student: "Musa Kayiira", reg: "L2-134", exam: "Fiqh - Taharah", score: 63, honors: "Third Class Honors", status: "Passed", date: "2025-03-23", cert: true }
        ];
        
        // Level to classes mapping
        const levelClasses = {
            "Level 1 (P.1-P.4)": ["P.1", "P.2", "P.3", "P.4"],
            "Level 2 (P.5-P.7)": ["P.5", "P.6", "P.7"],
            "Level 3 (S.1-S.3)": ["S.1", "S.2", "S.3"],
            "Level 4 (S.4-S.5)": ["S.4", "S.5"],
            "Level 5 (S.6)": ["S.6"]
        };
        
        // Render functions
        function renderRecentLessons() {
            let html = '';
            lessonsData.slice(0, 5).forEach(lesson => {
                let typeIcon = lesson.type === 'video' ? '<i class="fas fa-video text-primary"></i>' : 
                              lesson.type === 'audio' ? '<i class="fas fa-headphones text-success"></i>' : 
                              '<i class="fas fa-file-pdf text-danger"></i>';
                html += `
                    <div class="lesson-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>${typeIcon} ${lesson.title}</strong><br>
                                <small class="text-muted">${lesson.level} | ${lesson.class} | ${lesson.subject}</small>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-primary">$${lesson.price}</span>
                                <span class="badge badge-light ml-2">${lesson.views} views</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="progress progress-custom">
                                <div class="progress-bar progress-bar-custom" style="width: ${Math.min(100, Math.floor(lesson.views / 3))}%"></div>
                            </div>
                        </div>
                    </div>
                `;
            });
            $('#recentLessonsList').html(html);
        }
        
        function renderExamsList() {
            let html = '';
            examsData.forEach(exam => {
                let honorsColor = exam.avgScore >= 80 ? 'first' : exam.avgScore >= 70 ? 'second' : exam.avgScore >= 60 ? 'third' : 'fourth';
                html += `
                    <div class="exam-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong><i class="fas fa-file-alt text-primary mr-2"></i> ${exam.title}</strong><br>
                                <small class="text-muted">${exam.level} | ${exam.subject} | ${exam.questions} questions | ${exam.duration} mins</small>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-info">${exam.attempts} attempts</span>
                                <span class="badge badge-warning ml-2">Avg: ${exam.avgScore}%</span>
                            </div>
                        </div>
                    </div>
                `;
            });
            $('#examsList').html(html);
        }
        
        function getHonorsClass(score) {
            if (score >= 80) return "First Class Honors";
            if (score >= 70) return "Second Class Honors";
            if (score >= 60) return "Third Class Honors";
            if (score >= 50) return "Fourth Class Honors";
            return "Failed";
        }
        
        function getHonorsBadgeClass(score) {
            if (score >= 80) return "badge-warning";
            if (score >= 70) return "badge-secondary";
            if (score >= 60) return "badge-info";
            if (score >= 50) return "badge-success";
            return "badge-danger";
        }
        
        function renderReportsTable() {
            let html = '';
            reportsData.forEach(r => {
                let statusClass = r.status === 'Passed' ? 'badge-passed' : 'badge-failed';
                let honorsClass = getHonorsBadgeClass(r.score);
                html += `
                    <tr>
                        <td><i class="fas fa-user-graduate mr-2"></i> ${r.student}</td>
                        <td><code>${r.reg}</code></td>
                        <td>${r.exam}</td>
                        <td><strong>${r.score}%</strong></td>
                        <td><span class="badge ${honorsClass}">${r.honors}</span></td>
                        <td><span class="${statusClass}">${r.status}</span></td>
                        <td>${r.date}</td>
                        <td class="text-center">
                            ${r.cert ? '<i class="fas fa-download text-primary" style="cursor:pointer" onclick="downloadReport()"></i>' : '<i class="fas fa-ban text-muted"></i>'}
                        </td>
                    </tr>
                `;
            });
            $('#reportsTableBody').html(html);
        }
        
        function updateStats() {
            $('#totalLessons').text(lessonsData.length);
            $('#totalExams').text(examsData.length);
            $('#activeStudents').text(847);
            
            let avgScore = reportsData.reduce((sum, r) => sum + r.score, 0) / reportsData.length;
            $('#avgScore').text(avgScore.toFixed(1) + '%');
            $('#classAverage').text(avgScore.toFixed(1) + '%');
            
            let passedCount = reportsData.filter(r => r.status === "Passed").length;
            let passRate = (passedCount / reportsData.length * 100).toFixed(1);
            $('#passRate').text(passRate + '%');
            
            let topScore = Math.max(...reportsData.map(r => r.score));
            $('#topScore').text(topScore + '%');
            $('#studentsTested').text(reportsData.length);
        }
        
        // Level select change
        $('#levelSelect').on('change', function() {
            let level = $(this).val();
            let classes = levelClasses[level] || [];
            let options = '<option value="">Choose Class</option>';
            classes.forEach(c => options += `<option value="${c}">${c}</option>`);
            $('#classSelect').html(options);
        });
        
        // Upload Content
        $('#uploadContentForm').on('submit', function(e) {
            e.preventDefault();
            let newLesson = {
                id: lessonsData.length + 1,
                title: $('#lessonTitle').val(),
                level: $('#levelSelect').val(),
                class: $('#classSelect').val(),
                subject: $('#subjectName').val(),
                type: $('#contentType').val(),
                price: parseFloat($('#price').val()),
                url: $('#contentUrl').val(),
                description: $('#lessonDesc').val(),
                date: new Date().toLocaleDateString(),
                views: 0
            };
            lessonsData.unshift(newLesson);
            renderRecentLessons();
            updateStats();
            Swal.fire('Success!', 'Lesson uploaded successfully. Students can now purchase and access.', 'success');
            $('#uploadContentForm')[0].reset();
            $('#classSelect').html('<option value="">Choose Class</option>');
        });
        
        // Add Question
        let questionCount = 1;
        $('#addQuestionBtn').on('click', function() {
            let newQuestion = `
                <div class="quiz-question-item mt-3" data-question-idx="${questionCount}">
                    <div class="row">
                        <div class="col-md-8">
                            <label><strong><i class="fas fa-question-circle"></i> Question ${questionCount + 1}</strong></label>
                            <input type="text" class="form-control" placeholder="Enter question text" name="question[]" required>
                        </div>
                        <div class="col-md-4">
                            <label><i class="fas fa-check-circle"></i> Correct Answer (0-3)</label>
                            <input type="number" class="form-control" placeholder="0,1,2,3" name="correct[]" min="0" max="3" required>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6"><input type="text" class="form-control" placeholder="Option A" name="opt1[]" required></div>
                        <div class="col-md-6"><input type="text" class="form-control" placeholder="Option B" name="opt2[]" required></div>
                        <div class="col-md-6 mt-2"><input type="text" class="form-control" placeholder="Option C" name="opt3[]" required></div>
                        <div class="col-md-6 mt-2"><input type="text" class="form-control" placeholder="Option D" name="opt4[]" required></div>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger mt-2 remove-question-btn">Remove Question</button>
                </div>
            `;
            $('#questionsContainer').append(newQuestion);
            questionCount++;
            
            $('.remove-question-btn').off('click').on('click', function() {
                $(this).closest('.quiz-question-item').remove();
            });
        });
        
        // Create Exam
        $('#createExamForm').on('submit', function(e) {
            e.preventDefault();
            let examTitle = $('#examTitle').val();
            let examLevel = $('#examLevel').val();
            let examSubject = $('#examSubject').val();
            let examDuration = $('#examDuration').val();
            
            let questions = [];
            $('.quiz-question-item').each(function(idx) {
                let qText = $(this).find('input[name="question[]"]').val();
                let correct = $(this).find('input[name="correct[]"]').val();
                if (qText) {
                    questions.push({ text: qText, correct: parseInt(correct) });
                }
            });
            
            let newExam = {
                id: examsData.length + 1,
                title: examTitle,
                level: examLevel,
                subject: examSubject,
                questions: questions.length,
                duration: examDuration,
                date: new Date().toLocaleDateString(),
                attempts: 0,
                avgScore: 0
            };
            examsData.push(newExam);
            renderExamsList();
            updateStats();
            Swal.fire('Success!', `Exam "${examTitle}" created with ${questions.length} questions. Students need ≥50% to pass.`, 'success');
            $('#createExamForm')[0].reset();
            $('#questionsContainer').html(`
                <div class="quiz-question-item" data-question-idx="0">
                    <div class="row">
                        <div class="col-md-8">
                            <label><strong><i class="fas fa-question-circle"></i> Question 1</strong></label>
                            <input type="text" class="form-control" placeholder="Enter question text" name="question[]" required>
                        </div>
                        <div class="col-md-4">
                            <label><i class="fas fa-check-circle"></i> Correct Answer (0-3)</label>
                            <input type="number" class="form-control" placeholder="0,1,2,3" name="correct[]" min="0" max="3" required>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6"><input type="text" class="form-control" placeholder="Option A" name="opt1[]" required></div>
                        <div class="col-md-6"><input type="text" class="form-control" placeholder="Option B" name="opt2[]" required></div>
                        <div class="col-md-6 mt-2"><input type="text" class="form-control" placeholder="Option C" name="opt3[]" required></div>
                        <div class="col-md-6 mt-2"><input type="text" class="form-control" placeholder="Option D" name="opt4[]" required></div>
                    </div>
                </div>
            `);
            questionCount = 1;
        });
        
        // Navigation between sections
        $('.nav-item-teacher').on('click', function() {
            $('.nav-item-teacher').removeClass('active');
            $(this).addClass('active');
            let targetSection = $(this).data('section');
            $('.teacher-section').removeClass('active-section');
            $('#' + targetSection).addClass('active-section');
        });
        
        // Initialize Charts
        let ctx1 = document.getElementById('lessonCompletionChart')?.getContext('2d');
        let ctx2 = document.getElementById('subjectPerformanceChart')?.getContext('2d');
        let ctx3 = document.getElementById('weeklyTrendChart')?.getContext('2d');
        
        if (ctx1) {
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ['Level 1', 'Level 2', 'Level 3', 'Level 4', 'Level 5'],
                    datasets: [{
                        label: 'Lesson Completion %',
                        data: [85, 78, 72, 68, 82],
                        backgroundColor: '#7c3a8c',
                        borderRadius: 8
                    }]
                },
                options: { responsive: true, maintainAspectRatio: true }
            });
        }
        
        if (ctx2) {
            new Chart(ctx2, {
                type: 'radar',
                data: {
                    labels: ['Qur\'an', 'Fiqh', 'Seerah', 'Lugha', 'Hadith'],
                    datasets: [{
                        label: 'Average Scores',
                        data: [85, 72, 88, 65, 79],
                        backgroundColor: 'rgba(124,58,140,0.2)',
                        borderColor: '#7c3a8c',
                        pointBackgroundColor: '#e35f5f'
                    }]
                }
            });
        }
        
        if (ctx3) {
            new Chart(ctx3, {
                type: 'line',
                data: {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                    datasets: [{
                        label: 'Average Quiz Scores',
                        data: [68, 72, 75, 78],
                        borderColor: '#e35f5f',
                        tension: 0.3,
                        fill: true,
                        backgroundColor: 'rgba(227,95,95,0.1)'
                    }]
                }
            });
        }
        
        // Analytics data
        $('#topSubjectsList').html(`
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <span><i class="fas fa-star-of-life text-warning"></i> Seerah</span>
                <span class="badge badge-primary badge-pill">88%</span>
            </div>
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <span><i class="fas fa-quran text-success"></i> Qur'an</span>
                <span class="badge badge-primary badge-pill">85%</span>
            </div>
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <span><i class="fas fa-balance-scale text-info"></i> Fiqh</span>
                <span class="badge badge-primary badge-pill">72%</span>
            </div>
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <span><i class="fas fa-hadith text-secondary"></i> Hadith</span>
                <span class="badge badge-primary badge-pill">79%</span>
            </div>
        `);
        
        $('#improvementAreas').html(`
            <div class="list-group-item bg-light border-left-danger">
                <i class="fas fa-exclamation-triangle text-danger"></i> Arabic Grammar (Lugha) - 65%
                <div class="progress progress-custom mt-1">
                    <div class="progress-bar bg-danger" style="width: 65%"></div>
                </div>
            </div>
            <div class="list-group-item bg-light mt-2">
                <i class="fas fa-chart-line text-warning"></i> Fiqh - Advanced Topics
                <div class="progress progress-custom mt-1">
                    <div class="progress-bar bg-warning" style="width: 72%"></div>
                </div>
            </div>
        `);
        
        $('#honorsDistribution').html(`
            <div class="list-group-item">
                <div class="d-flex justify-content-between">
                    <span><i class="fas fa-crown text-warning"></i> First Class (80-100%)</span>
                    <span>38%</span>
                </div>
                <div class="progress progress-custom mt-1">
                    <div class="progress-bar bg-warning" style="width: 38%"></div>
                </div>
            </div>
            <div class="list-group-item mt-2">
                <div class="d-flex justify-content-between">
                    <span><i class="fas fa-medal text-secondary"></i> Second Class (70-79%)</span>
                    <span>25%</span>
                </div>
                <div class="progress progress-custom mt-1">
                    <div class="progress-bar bg-secondary" style="width: 25%"></div>
                </div>
            </div>
            <div class="list-group-item mt-2">
                <div class="d-flex justify-content-between">
                    <span><i class="fas fa-medal text-info"></i> Third Class (60-69%)</span>
                    <span>18%</span>
                </div>
                <div class="progress progress-custom mt-1">
                    <div class="progress-bar bg-info" style="width: 18%"></div>
                </div>
            </div>
            <div class="list-group-item mt-2">
                <div class="d-flex justify-content-between">
                    <span><i class="fas fa-check-circle text-success"></i> Fourth Class (50-59%)</span>
                    <span>12%</span>
                </div>
                <div class="progress progress-custom mt-1">
                    <div class="progress-bar bg-success" style="width: 12%"></div>
                </div>
            </div>
        `);
        
        // Download report function
        window.downloadReport = function() {
            Swal.fire('Report Generated', 'Report with academy logo watermark is ready for download.', 'success');
        };
        
        // Initialize all
        renderRecentLessons();
        renderExamsList();
        renderReportsTable();
        updateStats();
        $('.nav-item-teacher:first').addClass('active');

        // Add this function to handle teacher logout
function confirmLogout() {
    Swal.fire({
        title: "Are you sure?",
        text: "Do you really want to logout from your teacher account?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Logout",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            Swal.fire({
                title: 'Logging out...',
                text: 'Please wait',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Redirect to teacher logout route
            window.location.href = '{{ route("teacher-logout") }}';
        }
    });
}

// Add event listener for the bottom nav logout button
document.getElementById('teacherLogoutBtn')?.addEventListener('click', function(event) {
    event.preventDefault();
    confirmLogout();
});
    </script>
    
@endsection