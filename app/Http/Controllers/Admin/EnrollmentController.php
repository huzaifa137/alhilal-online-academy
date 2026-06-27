<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Academic\ClassEnrollment;
use App\Models\Academic\ClassModel;
use App\Models\User;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $query = ClassEnrollment::with(['student', 'class'])->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->search) {
            $s = $request->search;
            $query->whereHas('student', function ($q) use ($s) {
                $q->where('firstname', 'like', "%$s%")
                  ->orWhere('lastname', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%");
            });
        }

        $enrollments = $query->paginate(20);
        $pending     = ClassEnrollment::where('status', 'pending')->count();
        $classes     = ClassModel::where('status', 'active')->get();

        return view('Admin.enrollments.index', compact('enrollments', 'pending', 'classes'));
    }

    public function approve($id)
    {
        $enrollment = ClassEnrollment::findOrFail($id);
        $enrollment->update(['status' => 'active']);
        return back()->with('success', 'Enrollment approved.');
    }

    public function reject($id)
    {
        $enrollment = ClassEnrollment::findOrFail($id);
        $enrollment->update(['status' => 'rejected']);
        return back()->with('success', 'Enrollment rejected.');
    }

    public function destroy($id)
    {
        ClassEnrollment::findOrFail($id)->delete();
        return back()->with('success', 'Enrollment removed.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'class_id'   => 'required|exists:classes,id',
        ]);

        $exists = ClassEnrollment::where('student_id', $request->student_id)
            ->where('class_id', $request->class_id)->exists();

        if ($exists) {
            return back()->with('error', 'Student already enrolled in this class.');
        }

        ClassEnrollment::create([
            'student_id'       => $request->student_id,
            'class_id'         => $request->class_id,
            'enrollment_date'  => now(),
            'status'           => 'active',
            'payment_status'   => 'pending',
        ]);

        return back()->with('success', 'Student enrolled successfully.');
    }
}