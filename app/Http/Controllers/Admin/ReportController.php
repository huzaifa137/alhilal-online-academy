<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Academic\ClassModel;
use App\Models\Academic\ClassEnrollment;
use App\Models\Academic\Lesson;
use App\Models\Academic\ExamResult;
use App\Models\Academic\StudentProgress;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Enrollment by month (last 6 months)
        $enrollmentChart = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = now()->subMonths($i);
            $enrollmentChart[] = [
                'label' => $m->format('M Y'),
                'count' => ClassEnrollment::whereYear('created_at', $m->year)
                               ->whereMonth('created_at', $m->month)->count(),
            ];
        }

        // Top performing classes
        $topClasses = ClassModel::where('status', 'active')
            ->withCount(['enrollments as student_count' => fn($q) => $q->where('status', 'active')])
            ->orderByDesc('student_count')
            ->take(5)->get();

        // Revenue summary
        $revenueByMonth = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = now()->subMonths($i);
            $revenueByMonth[] = [
                'label'  => $m->format('M Y'),
                'amount' => PaymentTransaction::where('status', 'completed')
                                ->whereYear('created_at', $m->year)
                                ->whereMonth('created_at', $m->month)->sum('amount'),
            ];
        }

        $totalStudents      = User::where('user_role', 1)->count();
        $totalTeachers      = User::where('user_role', 2)->count();
        $activeEnrollments  = ClassEnrollment::where('status', 'active')->count();
        $totalRevenue       = PaymentTransaction::where('status', 'completed')->sum('amount');
        $avgScore           = ExamResult::avg('percentage');

        return view('Admin.reports.index', compact(
            'enrollmentChart', 'topClasses', 'revenueByMonth',
            'totalStudents', 'totalTeachers', 'activeEnrollments', 'totalRevenue', 'avgScore'
        ));
    }
}