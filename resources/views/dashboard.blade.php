@extends('layouts.master')
@section('css')
    <!---jvectormap css-->
    <link href="{{ URL::asset('assets/plugins/jvectormap/jqvmap.css') }}" rel="stylesheet" />
    <!-- Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <!--Daterangepicker css-->
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
    <style>
        /* Admin Dashboard Custom Styles */
        body {
            padding-bottom: 80px;
        }
        
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
        .badge-pending { background: #ffc107; color: #856404; }
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #7c3a8c;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        .recent-activity-item {
            border-left: 3px solid #7c3a8c;
            transition: all 0.2s;
        }
        .recent-activity-item:hover {
            background: #f8f9fa;
            transform: translateX(5px);
        }
        .progress-custom {
            height: 8px;
            border-radius: 10px;
            background: #e9ecef;
        }
        .progress-bar-custom {
            background: linear-gradient(90deg, #7c3a8c, #9b4d96);
            border-radius: 10px;
        }
        .welcome-banner {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            border-radius: 1rem;
            padding: 1.5rem;
            color: white;
            margin-bottom: 1.5rem;
        }
        
        /* Bottom Navigation Styles */
        .bottom-nav-admin {
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
            box-shadow: 0 -2px 15px rgba(0, 0, 0, 0.08);
        }
        .nav-item-admin {
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
        .nav-item-admin i {
            font-size: 1.4rem;
        }
        .nav-item-admin.active {
            color: #7c3a8c;
            background: rgba(124, 58, 140, 0.1);
        }
        .nav-item-admin:hover {
            color: #7c3a8c;
        }
        .admin-section {
            display: none;
            animation: fadeIn 0.3s ease;
            margin-bottom: 80px;
        }
        .admin-section.active-section {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 640px) {
            .nav-item-admin span {
                font-size: 0.6rem;
            }
            .nav-item-admin i {
                font-size: 1.2rem;
            }
        }
    </style>
@endsection
@section('page-header')
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">AlHilal Online Academy - Admin Dashboard</h4>
            <p class="text-muted mb-0">Manage Islamic Education Platform (P.1 – S.6)</p>
        </div>
        <div class="page-rightheader">
            <div class="btn-list">
                <span class="badge badge-pill badge-primary px-3 py-2">
                    <i class="fas fa-calendar-alt"></i> {{ now()->format('F j, Y') }}
                </span>
            </div>
        </div>
    </div>
@endsection
@section('content')

  @php
        use App\Models\User;
        use App\Models\Course;
        use App\Models\Lesson;
        use App\Models\Quiz;
        use App\Models\Enrollment;
       // use App\Models\Payment;
       // use App\Models\Certificate;
        use Carbon\Carbon;
        
        // User Statistics
        $totalUsers = User::count();
        $totalStudents = User::where('user_role', 1)->count();
        $totalTeachers = User::where('user_role', 3)->count();
        $totalAdmins = User::where('user_role', 2)->count();
        $activeStudents = User::where('user_role', 1)->where('account_status', 10)->count();
        
        // New users this month
        $newUsersThisMonth = User::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        // New students this month
        $newStudentsThisMonth = User::where('user_role', 1)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        // Content Statistics
        $totalCourses = Course::count();
        $totalLessons = Lesson::count();
        $totalQuizzes = Quiz::count();
        $totalEnrollments = Enrollment::count();
        
       
        
        // New lessons this month
        $newLessonsThisMonth = Lesson::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        // New quizzes this month
        $newQuizzesThisMonth = Quiz::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        // Calculate growth percentages
        $studentGrowth = $totalStudents > 0 ? round(($newStudentsThisMonth / $totalStudents) * 100, 1) : 0;
       // $revenueGrowth = $totalRevenue > 0 ? round(($revenueThisMonth / $totalRevenue) * 100, 1) : 0;
    @endphp

    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3 class="mb-2">
                    <i class="fas fa-shield-alt"></i> Welcome back, {{ Auth::user()->username ?? 'Administrator' }}
                </h3>
                <p class="mb-0">Manage AlHilal Online Academy - Islamic Education Platform (P.1 – S.6)</p>
                <p class="mb-0 mt-1">
                    <small><i class="fas fa-graduation-cap"></i> Total Students: 847 | 
                    <i class="fas fa-chalkboard-teacher"></i> Teachers: 28 | 
                    <i class="fas fa-dollar-sign"></i> Revenue: $12,580</small>
                </p>
            </div>
            <div class="col-md-4 text-center">
                <div class="progress-circle" style="width: 80px; height: 80px; margin: 0 auto;">
                    <div class="progress-circle-inner" style="width: 65px; height: 65px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; font-weight: bold; color: #7c3a8c;">78%</div>
                </div>
                <small class="mt-2 d-block">Platform Completion</small>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="row">
                <!-- Total Users -->
                <div class="col-xl-3 col-lg-3 col-md-6">
                    <div class="card dashboard-card text-white" style="background: linear-gradient(135deg, #1e3c72, #2a5298);">
                        <div class="card-overlay"></div>
                        <div class="card-body d-flex align-items-center">
                            <div class="dashboard-icon me-3"><i class="fas fa-users"></i></div>
                            <div>
                                <p class="mb-1">Total Users</p>
                                <h2 class="mb-1 font-weight-bold">{{ number_format($totalUsers) }}</h2>
                                <div class="label-sub"><i class="fas fa-arrow-up"></i> +{{ number_format($newUsersThisMonth) }} this month</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Students -->
                <div class="col-xl-3 col-lg-3 col-md-6">
                    <div class="card dashboard-card text-white" style="background: linear-gradient(135deg, #11998e, #38ef7d);">
                        <div class="card-overlay"></div>
                        <div class="card-body d-flex align-items-center">
                            <div class="dashboard-icon me-3"><i class="fas fa-user-graduate"></i></div>
                            <div>
                                <p class="mb-1">Active Students</p>
                                <h2 class="mb-1 font-weight-bold">{{ number_format($activeStudents) }}</h2>
                                <div class="label-sub"><i class="fas fa-arrow-up"></i> +{{ $studentGrowth }}% growth</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Teachers -->
                <div class="col-xl-3 col-lg-3 col-md-6">
                    <div class="card dashboard-card text-white" style="background: linear-gradient(135deg, #4e54c8, #8f94fb);">
                        <div class="card-overlay"></div>
                        <div class="card-body d-flex align-items-center">
                            <div class="dashboard-icon me-3"><i class="fas fa-chalkboard-teacher"></i></div>
                            <div>
                                <p class="mb-1">Teachers</p>
                                <h2 class="mb-1 font-weight-bold"></h2>
                                <div class="label-sub"><i class="fas fa-arrow-up"></i> +3 new</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="col-xl-3 col-lg-3 col-md-6">
                    <div class="card dashboard-card text-dark" style="background: linear-gradient(135deg, #f7971e, #ffd200);">
                        <div class="card-overlay"></div>
                        <div class="card-body d-flex align-items-center">
                            <div class="dashboard-icon me-3 bg-light text-dark"><i class="fas fa-dollar-sign"></i></div>
                            <div>
                                <p class="mb-1">Total Revenue</p>
                                <h2 class="mb-1 font-weight-bold">$12,580</h2>
                                <div class="label-sub"><i class="fas fa-arrow-up"></i> +$2,340 this month</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Metrics -->
        <div class="col-xl-12 col-lg-12">
            <div class="row">
                <!-- Certificates Issued -->
                <div class="col-xl-3 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <i class="fas fa-certificate card-custom-icon text-warning icon-dropshadow-warning" style="font-size: 36px;"></i>
                            <p class="mb-1">Certificates Issued</p>
                            <h2 class="mb-0 font-weight-bold">342</h2>
                            <small class="text-success">+45 this month</small>
                        </div>
                    </div>
                </div>

                <!-- Lessons Published -->
                <div class="col-xl-3 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <i class="fas fa-book-open card-custom-icon text-primary icon-dropshadow-primary" style="font-size: 36px;"></i>
                            <p class="mb-1">Lessons Published</p>
                            <h2 class="mb-0 font-weight-bold">{{ number_format($totalLessons) }}</h2>
                            <small class="text-success">+{{ $newLessonsThisMonth }} this month</small>
                        </div>
                    </div>
                </div>

                  <!-- Quizzes Created -->
                <div class="col-xl-3 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <i class="fas fa-pen-alt card-custom-icon text-info icon-dropshadow-info" style="font-size: 36px;"></i>
                            <p class="mb-1">Quizzes Created</p>
                            <h2 class="mb-0 font-weight-bold">{{ number_format($totalQuizzes) }}</h2>
                            <small class="text-success">+{{ $newQuizzesThisMonth }} this month</small>
                        </div>
                    </div>
                </div>

                <!-- Exams Created -->
                <div class="col-xl-3 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <i class="fas fa-pen-alt card-custom-icon text-info icon-dropshadow-info" style="font-size: 36px;"></i>
                            <p class="mb-1">Exams Created</p>
                            <h2 class="mb-0 font-weight-bold">78</h2>
                            <small class="text-success">+12 this month</small>
                        </div>
                    </div>
                </div>

                <!-- Active Payments -->
                <div class="col-xl-3 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <i class="fas fa-credit-card card-custom-icon text-success icon-dropshadow-success" style="font-size: 36px;"></i>
                            <p class="mb-1">Successful Payments</p>
                            <h2 class="mb-0 font-weight-bold">845</h2>
                            <small class="text-success">+156 this month</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Sections (Content Areas) -->
    <div id="overviewSection" class="admin-section active-section">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">User Distribution by Role</h3>
                    </div>
                    <div class="card-body">
                        <div id="userPieChart" style="height: 350px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Revenue Trend (Last 6 Months)</h3>
                    </div>
                    <div class="card-body">
                        <div id="revenueChart" style="height: 350px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Activities</h3>
                    </div>
                    <div class="card-body">
                        @php
                            $recentActivities = [
                                ['user' => 'Amina Hassan', 'action' => 'Completed Level 2', 'time' => '2 hours ago', 'type' => 'success'],
                                ['user' => 'Ibrahim Musa', 'action' => 'Paid for Level 3 Enrollment', 'time' => '3 hours ago', 'type' => 'info'],
                                ['user' => 'Fatima Ali', 'action' => 'Downloaded Certificate', 'time' => '5 hours ago', 'type' => 'warning'],
                                ['user' => 'Ustadh Ahmed', 'action' => 'Uploaded New Lesson', 'time' => '1 day ago', 'type' => 'primary'],
                                ['user' => 'Aisha Nambi', 'action' => 'Registered New Account', 'time' => '1 day ago', 'type' => 'success']
                            ];
                        @endphp
                        @foreach($recentActivities as $activity)
                        <div class="recent-activity-item p-3 mb-2 bg-white rounded shadow-sm">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>{{ $activity['user'] }}</strong>
                                    <p class="mb-0 mt-1">{{ $activity['action'] }}</p>
                                </div>
                                <div class="text-right">
                                    <small class="text-muted">{{ $activity['time'] }}</small>
                                    <div><span class="badge badge-{{ $activity['type'] }}">{{ ucfirst($activity['type']) }}</span></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Honors Distribution</h3>
                    </div>
                    <div class="card-body">
                        <div id="honorsChart" style="height: 350px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="usersSection" class="admin-section">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Users</h3>
                <div class="card-options">
                    <button class="btn btn-primary btn-sm" onclick="Swal.fire('Add User', 'Create new user form', 'info')">
                        <i class="fas fa-plus"></i> Add New User
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Reg Number</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Level/Class</th>
                                <th>Status</th>
                                <th>Actions</th>
                             </thead>
                            <tbody>
                                @php
                                    $users = [
                                        ['id' => 1, 'reg' => 'L3-2024-001', 'name' => 'Amina Hassan', 'email' => 'amina@alhilal.edu', 'role' => 'Student', 'level' => 'Level 3 (S.1-S.3)', 'status' => 'Active'],
                                        ['id' => 2, 'reg' => 'L3-2024-002', 'name' => 'Ibrahim Musa', 'email' => 'ibrahim@alhilal.edu', 'role' => 'Student', 'level' => 'Level 2 (P.5-P.7)', 'status' => 'Active'],
                                        ['id' => 3, 'reg' => 'TCH-001', 'name' => 'Ustadh Ahmed Al-Hilali', 'email' => 'ahmed@alhilal.edu', 'role' => 'Teacher', 'level' => 'All Levels', 'status' => 'Active'],
                                        ['id' => 4, 'reg' => 'ADM-001', 'name' => 'Admin User', 'email' => 'admin@alhilal.edu', 'role' => 'Admin', 'level' => 'N/A', 'status' => 'Active'],
                                        ['id' => 5, 'reg' => 'L1-2024-015', 'name' => 'Fatima Ali', 'email' => 'fatima@alhilal.edu', 'role' => 'Student', 'level' => 'Level 1 (P.1-P.4)', 'status' => 'Active']
                                    ];
                                @endphp
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user['id'] }}</td>
                                    <td><code>{{ $user['reg'] }}</code></td>
                                    <td>{{ $user['name'] }}</td>
                                    <td>{{ $user['email'] }}</td>
                                    <td><span class="badge badge-{{ $user['role'] == 'Admin' ? 'danger' : ($user['role'] == 'Teacher' ? 'info' : 'primary') }}">{{ $user['role'] }}</span></td>
                                    <td>{{ $user['level'] }}</td>
                                    <td><span class="badge badge-{{ $user['status'] == 'Active' ? 'success' : 'secondary' }}">{{ $user['status'] }}</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" onclick="Swal.fire('Edit User', 'Edit user: {{ $user['name'] }}', 'info')"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger" onclick="Swal.fire('Delete User', 'Delete user: {{ $user['name'] }}?', 'warning')"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="paymentsSection" class="admin-section">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Payment Transactions (PesaPal Integration)</h3>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-success text-white"><div class="card-body text-center"><h5>Total Collected</h5><h2>$12,580</h2></div></div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-dark"><div class="card-body text-center"><h5>Pending Payments</h5><h2>$2,340</h2></div></div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white"><div class="card-body text-center"><h5>Successful</h5><h2>845</h2></div></div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white"><div class="card-body text-center"><h5>Failed</h5><h2>23</h2></div></div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light"><tr><th>Transaction ID</th><th>Student</th><th>Item</th><th>Amount</th><th>Date</th><th>Gateway</th><th>Status</th></tr></thead>
                        <tbody>
                            @php $transactions = [
                                ['id' => 'PES-001', 'student' => 'Amina Hassan', 'item' => 'Level 3 Enrollment', 'amount' => 59.99, 'date' => '2025-03-28', 'gateway' => 'PesaPal - Mobile Money', 'status' => 'Completed'],
                                ['id' => 'PES-002', 'student' => 'Ibrahim Musa', 'item' => 'Exam Retake - Arabic', 'amount' => 2.99, 'date' => '2025-03-27', 'gateway' => 'PesaPal - Card', 'status' => 'Completed'],
                                ['id' => 'PES-003', 'student' => 'Fatima Ali', 'item' => 'Level 2 Enrollment', 'amount' => 49.99, 'date' => '2025-03-26', 'gateway' => 'PesaPal - Mobile Money', 'status' => 'Completed']
                            ]; @endphp
                            @foreach($transactions as $trans)
                            <tr><td><code>{{ $trans['id'] }}</code></td><td>{{ $trans['student'] }}</td><td>{{ $trans['item'] }}</td><td><strong>${{ number_format($trans['amount'], 2) }}</strong></td><td>{{ $trans['date'] }}</td><td><i class="fas fa-mobile-alt"></i> {{ $trans['gateway'] }}</td><td><span class="badge badge-success">{{ $trans['status'] }}</span></td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="contentSection" class="admin-section">
        <div class="row">
            <div class="col-md-6">
                <div class="card"><div class="card-header"><h3 class="card-title">Content Statistics</h3></div>
                <div class="card-body">
                    @php $contentStats = [['type' => 'Video Lessons', 'total' => 156, 'active' => 150], ['type' => 'Audio Lessons', 'total' => 89, 'active' => 85], ['type' => 'PDF Notes', 'total' => 255, 'active' => 250], ['type' => 'Exams', 'total' => 78, 'active' => 75]]; @endphp
                    @foreach($contentStats as $stat)
                    <div class="mb-3"><div class="d-flex justify-content-between"><span><strong>{{ $stat['type'] }}</strong></span><span>{{ $stat['active'] }}/{{ $stat['total'] }} Active</span></div><div class="progress-custom"><div class="progress-bar-custom" style="width: {{ ($stat['active'] / $stat['total']) * 100 }}%; height: 8px;"></div></div></div>
                    @endforeach
                </div></div>
            </div>
            <div class="col-md-6">
                <div class="card"><div class="card-header"><h3 class="card-title">Level Distribution</h3></div><div class="card-body"><div id="levelChart" style="height: 350px;"></div></div></div>
            </div>
        </div>
    </div>

    <div id="examsSection" class="admin-section">
        <div class="card"><div class="card-header"><h3 class="card-title">Exam Management</h3><div class="card-options"><button class="btn btn-primary btn-sm" onclick="Swal.fire('Create Exam', 'Exam creation form', 'info')"><i class="fas fa-plus"></i> Create Exam</button></div></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light"><tr><th>Exam Title</th><th>Level</th><th>Subject</th><th>Questions</th><th>Duration</th><th>Attempts</th><th>Avg Score</th><th>Actions</th></tr></thead>
                    <tbody>
                        @php $exams = [['title' => 'Qur\'an Quiz', 'level' => 'Level 1', 'subject' => 'Qur\'an', 'questions' => 10, 'duration' => '20 min', 'attempts' => 234, 'avg' => 82], ['title' => 'Fiqh Assessment', 'level' => 'Level 2', 'subject' => 'Fiqh', 'questions' => 15, 'duration' => '30 min', 'attempts' => 189, 'avg' => 76]]; @endphp
                        @foreach($exams as $exam)
                        <tr><td>{{ $exam['title'] }}</td><td>{{ $exam['level'] }}</td><td>{{ $exam['subject'] }}</td><td>{{ $exam['questions'] }}</td><td>{{ $exam['duration'] }}</td><td>{{ $exam['attempts'] }}</td><td><span class="badge badge-success">{{ $exam['avg'] }}%</span></td><td><button class="btn btn-sm btn-primary" onclick="Swal.fire('Edit', 'Edit exam', 'info')"><i class="fas fa-edit"></i></button> <button class="btn btn-sm btn-danger" onclick="Swal.fire('Delete', 'Delete exam?', 'warning')"><i class="fas fa-trash"></i></button></td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div></div>
    </div>

    <div id="certificatesSection" class="admin-section">
        <div class="card"><div class="card-header"><h3 class="card-title">Certificates Issued</h3></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light"><tr><th>Certificate ID</th><th>Student</th><th>Level</th><th>Honors</th><th>Issued Date</th><th>Download</th></tr></thead>
                    <tbody>
                        @php $certificates = [['id' => 'CERT-001', 'student' => 'Amina Hassan', 'level' => 'Level 1', 'honors' => 'First Class Honors', 'date' => '2024-12-15'], ['id' => 'CERT-002', 'student' => 'Ibrahim Musa', 'level' => 'Level 1', 'honors' => 'First Class Honors', 'date' => '2024-12-15']]; @endphp
                        @foreach($certificates as $cert)
                        <tr><td><code>{{ $cert['id'] }}</code></td><td>{{ $cert['student'] }}</td><td>{{ $cert['level'] }}</td><td><span class="honors-badge badge-first">{{ $cert['honors'] }}</span></td><td>{{ $cert['date'] }}</td><td><button class="btn btn-sm btn-success" onclick="Swal.fire('Download', 'Certificate with academy logo is ready', 'success')"><i class="fas fa-download"></i> PDF</button></td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div></div>
    </div>

    <!-- Bottom Navigation -->
    <div class="bottom-nav-admin">
        <button class="nav-item-admin active" data-section="overviewSection">
            <i class="fas fa-chart-line"></i>
            <span>Overview</span>
        </button>
        <button class="nav-item-admin" data-section="usersSection">
            <i class="fas fa-users"></i>
            <span>Users</span>
        </button>
        <button class="nav-item-admin" data-section="paymentsSection">
            <i class="fas fa-credit-card"></i>
            <span>Payments</span>
        </button>
        <button class="nav-item-admin" data-section="contentSection">
            <i class="fas fa-book"></i>
            <span>Content</span>
        </button>
        <button class="nav-item-admin" data-section="examsSection">
            <i class="fas fa-pen-square"></i>
            <span>Exams</span>
        </button>
        <button class="nav-item-admin" data-section="certificatesSection">
            <i class="fas fa-certificate"></i>
            <span>Certificates</span>
        </button>
    </div>
@endsection
@section('js')
    <!-- ECharts js -->
    <script src="{{ URL::asset('assets/plugins/echarts/echarts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Navigation between sections
            $('.nav-item-admin').on('click', function() {
                $('.nav-item-admin').removeClass('active');
                $(this).addClass('active');
                let target = $(this).data('section');
                $('.admin-section').removeClass('active-section');
                $('#' + target).addClass('active-section');
            });
            
            // User Distribution Pie Chart
            var userChart = echarts.init(document.getElementById('userPieChart'));
            userChart.setOption({
                tooltip: { trigger: 'item' },
                legend: { top: '5%', left: 'center' },
                series: [{
                    name: 'Users',
                    type: 'pie',
                    radius: '55%',
                    data: [
                        { value: 847, name: 'Students', itemStyle: { color: '#28a745' } },
                        { value: 28, name: 'Teachers', itemStyle: { color: '#17a2b8' } },
                        { value: 5, name: 'Admins', itemStyle: { color: '#dc3545' } }
                    ],
                    label: { show: true, formatter: '{b}: {d}%' }
                }]
            });

            // Revenue Trend Chart
            var revenueChart = echarts.init(document.getElementById('revenueChart'));
            revenueChart.setOption({
                tooltip: { trigger: 'axis' },
                xAxis: { type: 'category', data: ['Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'] },
                yAxis: { type: 'value', name: 'Revenue ($)' },
                series: [{
                    name: 'Revenue',
                    type: 'line',
                    data: [1850, 2100, 2450, 2780, 3120, 3580],
                    smooth: true,
                    lineStyle: { color: '#7c3a8c', width: 3 },
                    areaStyle: { opacity: 0.1, color: '#7c3a8c' }
                }]
            });

            // Honors Distribution Chart
            var honorsChart = echarts.init(document.getElementById('honorsChart'));
            honorsChart.setOption({
                tooltip: { trigger: 'item' },
                legend: { top: '5%', left: 'center' },
                series: [{
                    name: 'Honors',
                    type: 'pie',
                    radius: '55%',
                    data: [
                        { value: 38, name: 'First Class (80-100%)', itemStyle: { color: '#ffd700' } },
                        { value: 25, name: 'Second Class (70-79%)', itemStyle: { color: '#c0c0c0' } },
                        { value: 18, name: 'Third Class (60-69%)', itemStyle: { color: '#cd7f32' } },
                        { value: 12, name: 'Fourth Class (50-59%)', itemStyle: { color: '#28a745' } },
                        { value: 7, name: 'Failed (<50%)', itemStyle: { color: '#dc3545' } }
                    ]
                }]
            });

            // Level Distribution Chart
            var levelChart = echarts.init(document.getElementById('levelChart'));
            levelChart.setOption({
                tooltip: { trigger: 'axis', axisPointer: { type: 'shadow' } },
                xAxis: { type: 'category', data: ['Level 1', 'Level 2', 'Level 3', 'Level 4', 'Level 5'] },
                yAxis: { type: 'value', name: 'Students' },
                series: [{
                    name: 'Enrolled',
                    type: 'bar',
                    data: [156, 142, 198, 98, 45],
                    itemStyle: { color: '#7c3a8c', borderRadius: [5, 5, 0, 0] }
                }]
            });
        });
    </script>

    <!-- Data tables js-->
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
    <!--Counters -->
    <script src="{{ URL::asset('assets/plugins/counters/counterup.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/counters/waypoints.min.js') }}"></script>
    <!--Chart js -->
    <script src="{{ URL::asset('assets/plugins/chart/chart.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/utils.js') }}"></script>
@endsection