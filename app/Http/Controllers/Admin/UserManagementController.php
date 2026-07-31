<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Academic\ClassEnrollment;
use App\Models\Academic\ExamResult;
use App\Models\Academic\StudentProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    public function storeTeacher(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname'    => 'required|string|max:255',
            'lastname'     => 'nullable|string|max:255',
            'username'     => 'required|string|max:255|unique:users,username|regex:/^[a-zA-Z0-9_]+$/',
            'email'        => 'nullable|email|unique:users,email',
            'phonenumber'  => 'required|string|max:20',
            'gender'       => 'nullable|in:male,female',
            'password'     => 'required|string|min:8|confirmed',
        ], [
            'username.regex' => 'Username can only contain letters, numbers, and underscores.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $teacher = new User();
            $teacher->firstname            = $request->firstname;
            $teacher->lastname             = $request->lastname;
            $teacher->username             = $request->username;
            $teacher->email                = $request->email;
            $teacher->phonenumber          = $request->phonenumber;
            $teacher->gender               = $request->gender;
            $teacher->password             = Hash::make($request->password);
            $teacher->user_role            = 2; // Teacher
            $teacher->account_status       = 10; // Active
            $teacher->registration_status  = 1;
            $teacher->save();

            $teacher->reg_number = 'TCH-' . date('Y') . '-' . str_pad($teacher->id, 4, '0', STR_PAD_LEFT);
            $teacher->save();

            return response()->json([
                'success' => true,
                'message' => 'Teacher added successfully.',
            ]);
        } catch (\Exception $e) {
            \Log::error('Teacher creation failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    public function updateTeacher(Request $request, $id)
    {
        $teacher = User::where('user_role', 2)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'firstname'    => 'required|string|max:255',
            'lastname'     => 'nullable|string|max:255',
            'username'     => 'required|string|max:255|unique:users,username,' . $teacher->id . '|regex:/^[a-zA-Z0-9_]+$/',
            'email'        => 'nullable|email|unique:users,email,' . $teacher->id,
            'phonenumber'  => 'required|string|max:20',
            'gender'       => 'nullable|in:male,female',
            'password'     => 'nullable|string|min:8|confirmed',
        ], [
            'username.regex' => 'Username can only contain letters, numbers, and underscores.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $teacher->firstname   = $request->firstname;
            $teacher->lastname    = $request->lastname;
            $teacher->username    = $request->username;
            $teacher->email       = $request->email;
            $teacher->phonenumber = $request->phonenumber;
            $teacher->gender      = $request->gender;

            if ($request->filled('password')) {
                $teacher->password = Hash::make($request->password);
            }

            $teacher->save();

            return response()->json([
                'success' => true,
                'message' => 'Teacher updated successfully.',
            ]);
        } catch (\Exception $e) {
            \Log::error('Teacher update failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    public function destroyTeacher($id)
    {
        try {
            $teacher = User::where('user_role', 2)->findOrFail($id);
            $teacher->delete();

            return response()->json([
                'success' => true,
                'message' => 'Teacher deleted successfully.',
            ]);
        } catch (\Exception $e) {
            \Log::error('Teacher deletion failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }
}