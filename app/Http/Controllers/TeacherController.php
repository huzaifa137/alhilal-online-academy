<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Academic\ClassModel;
use App\Models\Subject;
use App\Models\Academic\Topic;
use App\Models\Academic\Lesson;
use App\Models\Academic\Section;

class TeacherController extends Controller
{
    public function teacherDashboard()
    {
        $teacherId = session('LoggedTeacher');

        // Count classes where teacher is assigned through class_subjects
        $assignedClassesCount = ClassModel::whereHas('subjects', function ($query) use ($teacherId) {
            $query->where('class_subjects.teacher_id', $teacherId);
        })->count();

        // Get the actual class IDs first, then count students in those classes
        $teacherClassIds = ClassModel::whereHas('subjects', function ($query) use ($teacherId) {
            $query->where('class_subjects.teacher_id', $teacherId);
        })->pluck('id');

        $totalStudents = 121;

        // For now, set pending assignments to 0
        $pendingAssignments = 0;

        return view('Teacher.dashboard', compact('assignedClassesCount', 'totalStudents', 'pendingAssignments'));
    }

    public function getDashboardData(Request $request)
    {
        $teacherId = Session('LoggedTeacher');

        // Get all sections with their levels, classes, subjects, topics, lessons
        $sections = Section::with([
            'levels' => function ($q) use ($teacherId) {
                $q->with([
                    'classes' => function ($q2) use ($teacherId) {
                        $q2->whereHas('subjects.teachers', function ($q3) use ($teacherId) {
                            $q3->where('teacher_id', $teacherId);
                        })->with([
                                    'subjects' => function ($q3) use ($teacherId) {
                                        $q3->whereHas('teachers', function ($q4) use ($teacherId) {
                                            $q4->where('teacher_id', $teacherId);
                                        })->with([
                                                    'topics' => function ($q4) {
                                                        $q4->with([
                                                            'lessons' => function ($q5) {
                                                                $q5->with('resources')->orderBy('lesson_order');
                                                            }
                                                        ])->orderBy('order_no');
                                                    }
                                                ]);
                                    }
                                ]);
                    }
                ]);
            }
        ])->get();

        // Calculate statistics
        $stats = [
            'total_classes' => ClassModel::whereHas('subjects.teachers', function ($q) use ($teacherId) {
                $q->where('teacher_id', $teacherId);
            })->count(),
            'total_subjects' => Subject::whereHas('teachers', function ($q) use ($teacherId) {
                $q->where('teacher_id', $teacherId);
            })->count(),
            'total_topics' => Topic::whereHas('class.subjects.teachers', function ($q) use ($teacherId) {
                $q->where('teacher_id', $teacherId);
            })->count(),
            'total_lessons' => Lesson::where('teacher_id', $teacherId)->count(),
        ];

        return response()->json([
            'sections' => $sections,
            'stats' => $stats
        ]);
    }
}