<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Academic\ClassModel;
use App\Models\Academic\ClassEnrollment;
use App\Models\Academic\Lesson;
use App\Models\Academic\Subject;
use App\Models\Academic\Topic;
use App\Models\Academic\Exam;
use App\Models\Academic\ExamResult;
use App\Models\Academic\StudentProgress;
use App\Models\Academic\AcademicYear;
use App\Models\Academic\Section;
use App\Models\Academic\Level;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Users ───────────────────────────────────────────────
        $totalStudents = User::where('user_role', 1)->count();
        $totalTeachers = User::where('user_role', 2)->count();
        $totalAdmins = User::whereIn('user_role', [0, 3])->count();
        $totalUsers = User::count();

        // ── Academic ────────────────────────────────────────────
        $totalClasses = ClassModel::where('status', 'active')->count();
        $totalLessons = Lesson::count();
        $publishedLessons = Lesson::where('status', 'published')->count();
        $totalSubjects = Subject::where('status', 'active')->count();
        $totalTopics = Topic::where('status', 'published')->count();
        $totalExams = Exam::count();
        $totalEnrollments = ClassEnrollment::where('status', 'active')->count();
        $pendingEnrollments = ClassEnrollment::where('status', 'pending')->count();

        // ── Progress ────────────────────────────────────────────
        $totalCompletions = StudentProgress::whereIn('status', ['completed', 'passed'])->count();
        $totalProgressRecords = StudentProgress::count();
        $overallCompletionRate = $totalProgressRecords > 0
            ? round(($totalCompletions / $totalProgressRecords) * 100) : 0;

        // ── Payments ────────────────────────────────────────────
        $totalRevenue = PaymentTransaction::where('status', 'completed')->sum('amount');
        $pendingPayments = PaymentTransaction::whereIn('status', ['pending', 'processing'])->count();
        $overdueAmount = PaymentTransaction::where('status', 'failed')->sum('amount');

        // ── Recent data ─────────────────────────────────────────
        $recentStudents = User::where('user_role', 1)
            ->orderByDesc('created_at')->limit(8)->get();

        $recentLessons = Lesson::with(['topic.subject', 'teacher'])
            ->orderByDesc('created_at')->limit(6)->get();

        $recentEnrollments = ClassEnrollment::with(['student', 'class'])
            ->orderByDesc('created_at')->limit(6)->get();

        // ── Top teachers by avg student score ───────────────────
        $topTeachers = User::where('user_role', 2)
            ->withCount('createdLessons as lesson_count')
            ->get()
            ->map(function ($teacher) {
                $avgScore = ExamResult::whereHas('exam.lesson', function ($q) use ($teacher) {
                    $q->where('teacher_id', $teacher->id);
                })->avg('percentage');
                $teacher->avg_score = $avgScore ? round($avgScore, 1) : null;
                return $teacher;
            })
            ->filter(fn($t) => $t->avg_score !== null)
            ->sortByDesc('avg_score')
            ->take(5)
            ->values();

        // ── Subject performance ─────────────────────────────────
        $subjectPerformance = Subject::where('status', 'active')
            ->withCount('topics as topic_count')
            ->get()
            ->map(function ($subject) {
                $avgScore = ExamResult::whereHas('exam.lesson.topic', function ($q) use ($subject) {
                    $q->where('subject_id', $subject->id);
                })->avg('percentage');
                $subject->avg_score = $avgScore ? round($avgScore) : 0;
                return $subject;
            })
            ->sortByDesc('avg_score')
            ->take(7)
            ->values();

        // ── Monthly enrollment chart data (last 12 months) ──────
        $monthlyData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyData[] = [
                'label' => $month->format('M'),
                'enrollments' => ClassEnrollment::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)->count(),
                'completions' => StudentProgress::whereIn('status', ['completed', 'passed'])
                    ->whereYear('updated_at', $month->year)
                    ->whereMonth('updated_at', $month->month)->count(),
                'revenue' => PaymentTransaction::where('status', 'completed')
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)->sum('amount'),
            ];
        }

        // ── Academic year & section/level counts ─────────────────
        $currentAcademicYear = AcademicYear::where('is_current', true)->first();
        $totalSections = Section::where('status', 'active')->count();
        $totalLevels = Level::where('status', 'active')->count();

        // ── Certificates ─────────────────────────────────────────
        $totalCertificates = \App\Models\Certificate::count();

        return view('Admin.dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalAdmins',
            'totalUsers',
            'totalClasses',
            'totalLessons',
            'publishedLessons',
            'totalSubjects',
            'totalTopics',
            'totalExams',
            'totalEnrollments',
            'pendingEnrollments',
            'totalCompletions',
            'overallCompletionRate',
            'totalRevenue',
            'pendingPayments',
            'overdueAmount',
            'recentStudents',
            'recentLessons',
            'recentEnrollments',
            'topTeachers',
            'subjectPerformance',
            'monthlyData',
            'currentAcademicYear',
            'totalSections',
            'totalLevels',
            'totalCertificates'
        ));
    }
}