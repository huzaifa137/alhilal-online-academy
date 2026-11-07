<?php
// app/Http/Controllers/Teacher/ClassAssignmentController.php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Academic\AcademicYear;
use App\Models\Academic\ClassModel;
use App\Models\Academic\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClassAssignmentController extends Controller
{
    /**
     * Role value used for teacher accounts in the users table.
     */
    private const TEACHER_ROLE = 2;

    /**
     * List all teachers (user_role = 2), for use in assignment dropdowns.
     */
public function getTeachers()
{
    $teachers = User::where('user_role', self::TEACHER_ROLE)
        ->orderBy('firstname')
        ->get(['id', 'firstname', 'lastname', 'email']);  // removed 'fullname'

    return response()->json($teachers);
}

    /**
     * Get academic years for dropdown
     */
    public function getAcademicYears()
    {
        $academicYears = AcademicYear::orderBy('start_date', 'desc')
            ->get(['id', 'name', 'start_date', 'end_date', 'is_current']);

        return response()->json($academicYears);
    }

    /**
     * List classes with their current homeroom/class teacher and
     * the count of subject-teacher assignments, for the "Class Teachers" tab.
     */
    public function getClassTeacherAssignments()
    {
        $classes = ClassModel::with(['level', 'level.section', 'classTeacher'])
            ->withCount('subjects')
            ->orderBy('name')
            ->get();

        return response()->json($classes);
    }

    /**
     * Assign (or change/remove) the homeroom/class teacher for a class.
     * Writes to classes.class_teacher_id.
     */
    public function assignClassTeacher(Request $request, ClassModel $class)
    {
        $validator = Validator::make($request->all(), [
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($request->teacher_id) {
            $isTeacher = User::where('id', $request->teacher_id)
                ->where('user_role', self::TEACHER_ROLE)
                ->exists();

            if (!$isTeacher) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected user is not a teacher.',
                ], 422);
            }
        }

        $class->update(['class_teacher_id' => $request->teacher_id]);
        $class->load(['level', 'level.section', 'classTeacher']);

        return response()->json([
            'success' => true,
            'class' => $class,
            'message' => $request->teacher_id
                ? 'Class teacher assigned successfully'
                : 'Class teacher removed successfully',
        ]);
    }

    /**
     * List class-subject-teacher assignments (the rows that actually
     * unlock "My Classes" in lesson/quiz creation for a teacher).
     */
    public function getSubjectAssignments()
    {
        $assignments = DB::table('class_subjects')
            ->join('classes', 'classes.id', '=', 'class_subjects.class_id')
            ->join('subjects', 'subjects.id', '=', 'class_subjects.subject_id')
            ->join('academic_years', 'academic_years.id', '=', 'class_subjects.academic_year_id')
            ->leftJoin('users', 'users.id', '=', 'class_subjects.teacher_id')
            ->select(
                'class_subjects.id',
                'class_subjects.class_id',
                'class_subjects.subject_id',
                'class_subjects.teacher_id',
                'class_subjects.academic_year_id',
                'class_subjects.periods_per_week',
                'class_subjects.is_compulsory',
                'class_subjects.status',
                'classes.name as class_name',
                'subjects.name as subject_name',
                'academic_years.name as academic_year_name',
                'users.fullname as teacher_fullname',
                'users.firstname as teacher_firstname',
                'users.lastname as teacher_lastname'
            )
            ->orderBy('classes.name')
            ->orderBy('subjects.name')
            ->get();

        return response()->json($assignments);
    }

    /**
     * Create a new class-subject-teacher assignment.
     * This is what populates class_subjects.teacher_id, which is the
     * value the Quiz/Lesson "My Classes" dropdowns filter on.
     */
    public function storeSubjectAssignment(Request $request)
    {
        $activeYear = AcademicYear::where('is_current', 1)->first();

        if (!$activeYear) {
            return response()->json([
                'success' => false,
                'message' => 'No active academic year set. Please activate an academic year first.',
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'periods_per_week' => 'nullable|integer|min:1|max:40',
            'is_compulsory' => 'nullable|boolean',
            'passing_marks' => 'nullable|integer|min:0',
            'full_marks' => 'nullable|integer|min:1',
            'status' => 'nullable|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $isTeacher = User::where('id', $request->teacher_id)
            ->where('user_role', self::TEACHER_ROLE)
            ->exists();

        if (!$isTeacher) {
            return response()->json([
                'success' => false,
                'message' => 'Selected user is not a teacher.',
            ], 422);
        }

        // Prevent assigning the exact same teacher to the same class+subject twice
        $duplicate = DB::table('class_subjects')
            ->where('class_id', $request->class_id)
            ->where('subject_id', $request->subject_id)
            ->where('academic_year_id', $activeYear->id)
            ->where('teacher_id', $request->teacher_id)
            ->exists();

        if ($duplicate) {
            return response()->json([
                'success' => false,
                'message' => 'This teacher is already assigned to this class and subject.',
            ], 422);
        }

        $id = DB::table('class_subjects')->insertGetId([
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
            'academic_year_id' => $activeYear->id,
            'periods_per_week' => $request->periods_per_week ?? 1,
            'is_compulsory' => $request->boolean('is_compulsory', true),
            'passing_marks' => $request->passing_marks ?? 50,
            'full_marks' => $request->full_marks ?? 100,
            'status' => $request->status ?? 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'id' => $id,
            'message' => 'Teacher assigned to class & subject successfully',
        ]);
    }

    /**
     * Update an existing class-subject-teacher assignment
     * (e.g. swap the teacher, change periods/marks).
     */
    public function updateSubjectAssignment(Request $request, $classSubjectId)
    {
        $assignment = DB::table('class_subjects')->where('id', $classSubjectId)->first();

        if (!$assignment) {
            return response()->json([
                'success' => false,
                'message' => 'Assignment not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'teacher_id' => 'required|exists:users,id',
            'periods_per_week' => 'nullable|integer|min:1|max:40',
            'is_compulsory' => 'nullable|boolean',
            'passing_marks' => 'nullable|integer|min:0',
            'full_marks' => 'nullable|integer|min:1',
            'status' => 'nullable|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $isTeacher = User::where('id', $request->teacher_id)
            ->where('user_role', self::TEACHER_ROLE)
            ->exists();

        if (!$isTeacher) {
            return response()->json([
                'success' => false,
                'message' => 'Selected user is not a teacher.',
            ], 422);
        }

        // Prevent turning this row into a duplicate of another existing row
        $duplicate = DB::table('class_subjects')
            ->where('id', '!=', $classSubjectId)
            ->where('class_id', $assignment->class_id)
            ->where('subject_id', $assignment->subject_id)
            ->where('academic_year_id', $assignment->academic_year_id)
            ->where('teacher_id', $request->teacher_id)
            ->exists();

        if ($duplicate) {
            return response()->json([
                'success' => false,
                'message' => 'This teacher is already assigned to this class and subject.',
            ], 422);
        }

        DB::table('class_subjects')->where('id', $classSubjectId)->update([
            'teacher_id' => $request->teacher_id,
            'periods_per_week' => $request->periods_per_week ?? $assignment->periods_per_week,
            'is_compulsory' => $request->has('is_compulsory') ? $request->boolean('is_compulsory') : $assignment->is_compulsory,
            'passing_marks' => $request->passing_marks ?? $assignment->passing_marks,
            'full_marks' => $request->full_marks ?? $assignment->full_marks,
            'status' => $request->status ?? $assignment->status,
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Assignment updated successfully',
        ]);
    }

    /**
     * Remove a class-subject-teacher assignment.
     * Blocks deletion if topics/lessons already exist for that class+subject,
     * to avoid orphaning lesson/quiz content a teacher relies on.
     */
    public function destroySubjectAssignment($classSubjectId)
    {
        $assignment = DB::table('class_subjects')->where('id', $classSubjectId)->first();

        if (!$assignment) {
            return response()->json([
                'success' => false,
                'message' => 'Assignment not found',
            ], 404);
        }

        $hasTopics = DB::table('topics')
            ->where('class_id', $assignment->class_id)
            ->where('subject_id', $assignment->subject_id)
            ->exists();

        if ($hasTopics) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot remove this assignment: topics already exist for this class and subject.',
            ], 400);
        }

        DB::table('class_subjects')->where('id', $classSubjectId)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Assignment removed successfully',
        ]);
    }
}