<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Academic\ClassModel;
use App\Models\Academic\ClassEnrollment;
use App\Models\Academic\Lesson;
use App\Models\Academic\Exam;
use App\Models\Academic\StudentProgress;
use App\Models\User;
use App\Models\Subject;
use App\Models\Academic\Topic;
use App\Models\Academic\Section;

class TeacherController extends Controller
{
    public function teacherDashboard()
    {
        $teacherId = session('LoggedTeacher');

        // Teacher record
        $teacher = User::find($teacherId);

        // Classes the teacher is assigned to (via class_subjects pivot)
        $teacherClasses = ClassModel::with(['level'])
            ->whereHas('subjects', fn($q) => $q->where('class_subjects.teacher_id', $teacherId))
            ->where('status', 'active')
            ->get();

        $assignedClassesCount = $teacherClasses->count();
        $teacherClassIds = $teacherClasses->pluck('id');

        // Total distinct enrolled students across teacher's classes
        $totalStudents = ClassEnrollment::whereIn('class_id', $teacherClassIds)
            ->where('status', 'active')
            ->distinct('student_id')
            ->count('student_id');

        // Lessons by this teacher
        $totalLessons     = Lesson::where('teacher_id', $teacherId)->count();
        $publishedLessons = Lesson::where('teacher_id', $teacherId)->where('status', 'published')->count();

        // Quizzes created by this teacher
        $totalQuizzes = Exam::where('teacher_id', $teacherId)->where('exam_type', 'quiz')->count();

        // Recent enrollments across teacher's classes (last 5)
        $recentEnrollments = ClassEnrollment::with(['student', 'class'])
            ->whereIn('class_id', $teacherClassIds)
            ->where('status', 'active')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // Recent lesson completions by students in this teacher's classes
        $recentCompletions = StudentProgress::with(['student', 'lesson'])
            ->whereHas('lesson', fn($q) => $q->where('teacher_id', $teacherId))
            ->where('status', 'completed')
            ->orderByDesc('completed_at')
            ->limit(6)
            ->get();

        // Avg completion rate
        $totalProgressRecords = StudentProgress::whereHas('lesson', fn($q) => $q->where('teacher_id', $teacherId))->count();
        $completedRecords     = StudentProgress::whereHas('lesson', fn($q) => $q->where('teacher_id', $teacherId))
            ->where('status', 'completed')->count();
        $avgCompletionRate = $totalProgressRecords > 0
            ? round(($completedRecords / $totalProgressRecords) * 100)
            : 0;

        // Class list for dashboard display (top 6)
        $dashboardClasses = $teacherClasses->take(6);

        return view('Teacher.dashboard', compact(
            'teacher',
            'assignedClassesCount',
            'totalStudents',
            'totalLessons',
            'publishedLessons',
            'totalQuizzes',
            'recentEnrollments',
            'recentCompletions',
            'avgCompletionRate',
            'dashboardClasses'
        ));
    }

    public function getDashboardData(Request $request)
    {
        $teacherId = session('LoggedTeacher');

        $sections = Section::with([
            'levels' => function ($q) use ($teacherId) {
                $q->with([
                    'classes' => function ($q2) use ($teacherId) {
                        $q2->whereHas('subjects', fn($q3) => $q3->where('class_subjects.teacher_id', $teacherId))
                            ->with([
                                'subjects' => function ($q3) use ($teacherId) {
                                    $q3->where('class_subjects.teacher_id', $teacherId)
                                        ->with([
                                            'topics' => fn($q4) => $q4->with([
                                                'lessons' => fn($q5) => $q5->with('resources')->orderBy('lesson_order')
                                            ])->orderBy('order_no')
                                        ]);
                                }
                            ]);
                    }
                ]);
            }
        ])->get();

        $stats = [
            'total_classes'  => ClassModel::whereHas('subjects', fn($q) => $q->where('class_subjects.teacher_id', $teacherId))->count(),
            'total_lessons'  => Lesson::where('teacher_id', $teacherId)->count(),
            'total_quizzes'  => Exam::where('teacher_id', $teacherId)->where('exam_type', 'quiz')->count(),
        ];

        return response()->json(['sections' => $sections, 'stats' => $stats]);
    }
}
