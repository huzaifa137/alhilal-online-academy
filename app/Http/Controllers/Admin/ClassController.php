<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Academic\ClassModel;
use App\Models\Academic\Level;
use App\Models\Academic\AcademicYear;
use App\Models\User;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $query = ClassModel::with(['level', 'academicYear', 'classTeacher'])
            ->withCount(['enrollments as student_count' => fn($q) => $q->where('status', 'active')]);

        if ($request->search) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%$s%")
                  ->orWhere('code', 'like', "%$s%");
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $classes       = $query->orderByDesc('created_at')->paginate(20);
        $levels        = Level::where('status', 'active')->get();
        $academicYears = AcademicYear::orderByDesc('year')->get();
        $teachers      = User::where('user_role', 2)->orderBy('firstname')->get();

        return view('Admin.classes.index', compact('classes', 'levels', 'academicYears', 'teachers'));
    }
}
