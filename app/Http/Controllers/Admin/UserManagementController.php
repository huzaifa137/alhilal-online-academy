<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Academic\ClassEnrollment;
use App\Models\Academic\ExamResult;
use App\Models\Academic\StudentProgress;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    // ── Students ──────────────────────────────────────────────────────────
    public function students(Request $request)
    {
        $query = User::where('user_role', 1)->with(['certificates']);

        if ($request->search) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('firstname', 'like', "%$s%")
                  ->orWhere('lastname', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%");
            });
        }

        if ($request->status) {
            $query->where('account_status', $request->status == 'active' ? 10 : 0);
        }

        $students = $query->orderByDesc('created_at')->paginate(20);

        return view('Admin.users.students', compact('students'));
    }

    public function showStudent($id)
    {
        $student = User::where('user_role', 1)->findOrFail($id);
        $enrollments  = ClassEnrollment::with('class')->where('student_id', $id)->get();
        $examResults  = ExamResult::with('exam')->where('student_id', $id)->orderByDesc('created_at')->take(10)->get();
        $progress     = StudentProgress::with('lesson')->where('student_id', $id)->get();
        $certificates = $student->certificates;
        $avgScore     = $examResults->avg('percentage');

        return view('Admin.users.student-show', compact(
            'student', 'enrollments', 'examResults', 'progress', 'certificates', 'avgScore'
        ));
    }

    public function toggleStudentStatus($id)
    {
        $student = User::where('user_role', 1)->findOrFail($id);
        $student->account_status = $student->account_status == 10 ? 0 : 10;
        $student->save();
        return back()->with('success', 'Student status updated.');
    }

    public function destroyStudent($id)
    {
        $student = User::where('user_role', 1)->findOrFail($id);
        $student->delete();
        return redirect()->route('admin.students')->with('success', 'Student deleted.');
    }

    // ── Teachers ──────────────────────────────────────────────────────────
    public function teachers(Request $request)
    {
        $query = User::where('user_role', 2);

        if ($request->search) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('firstname', 'like', "%$s%")
                  ->orWhere('lastname', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%");
            });
        }

        $teachers = $query->withCount('createdLessons as lesson_count')
            ->orderByDesc('created_at')->paginate(20);

        return view('Admin.users.teachers', compact('teachers'));
    }

    public function showTeacher($id)
    {
        $teacher = User::where('user_role', 2)->findOrFail($id);
        $lessons  = $teacher->createdLessons()->with('topic.subject')->orderByDesc('created_at')->get();
        $avgScore = ExamResult::whereHas('exam.lesson', fn($q) => $q->where('teacher_id', $id))->avg('percentage');

        return view('Admin.users.teacher-show', compact('teacher', 'lessons', 'avgScore'));
    }

    public function toggleTeacherStatus($id)
    {
        $teacher = User::where('user_role', 2)->findOrFail($id);
        $teacher->account_status = $teacher->account_status == 10 ? 0 : 10;
        $teacher->save();
        return back()->with('success', 'Teacher status updated.');
    }
}