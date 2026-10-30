<?php

namespace App\Services;

use App\Models\Academic\ClassEnrollment;
use App\Models\Academic\Lesson;
use App\Models\Academic\SubjectMaterial;
use App\Support\ContentLanguage;
use Illuminate\Support\Facades\DB;

/**
 * Who may download a lesson file or a study-material PDF.
 *
 * Mirrors the rules the lesson pages already enforce, but at the file itself,
 * so knowing (or guessing) a file URL is no longer enough:
 *
 *   admin    -> everything
 *   teacher  -> content they created, or in a class+subject they are assigned to
 *   student  -> published content, in the language they have selected, in a class
 *               they are actively enrolled in AND have paid for, and (when the
 *               lesson / PDF has its own price) that they have paid for.
 *
 * Each method returns null when access is allowed, otherwise a short reason.
 */
class ContentAccess
{
    public function forLesson(Lesson $lesson): ?string
    {
        $lesson->loadMissing('topic');
        $classId = $lesson->topic->class_id ?? null;
        $subjectId = $lesson->topic->subject_id ?? null;

        if (session()->has('LoggedAdmin')) {
            return null;
        }

        if (session()->has('LoggedTeacher')) {
            return $this->teacherMay((int) session('LoggedTeacher'), $lesson->teacher_id, $classId, $subjectId)
                ? null
                : 'You do not teach this lesson.';
        }

        if (session()->has('LoggedStudent')) {
            $studentId = (int) session('LoggedStudent');

            if ($lesson->status !== 'published') {
                return 'This lesson is not available.';
            }
            if (!ContentLanguage::allows($lesson->language)) {
                return ContentLanguage::mismatchMessage($lesson->language);
            }
            if ($reason = $this->studentClassProblem($studentId, $classId)) {
                return $reason;
            }
            if (!$lesson->isPaidByStudent($studentId)) {
                return 'Please pay for this lesson to access it.';
            }

            return null;
        }

        return 'Not authorised.';
    }

    public function forMaterial(SubjectMaterial $material): ?string
    {
        if (session()->has('LoggedAdmin')) {
            return null;
        }

        if (session()->has('LoggedTeacher')) {
            return $this->teacherMay((int) session('LoggedTeacher'), $material->teacher_id, $material->class_id, $material->subject_id)
                ? null
                : 'You do not teach this subject.';
        }

        if (session()->has('LoggedStudent')) {
            $studentId = (int) session('LoggedStudent');

            if ($material->status !== 'active') {
                return 'This material is not available.';
            }
            if (!ContentLanguage::allows($material->language)) {
                return ContentLanguage::mismatchMessage($material->language);
            }
            if ($reason = $this->studentClassProblem($studentId, $material->class_id)) {
                return $reason;
            }
            if (!$material->isPaidByStudent($studentId)) {
                return 'Please pay for this PDF to open it.';
            }

            return null;
        }

        return 'Not authorised.';
    }

    /** Active enrolment + class fee paid (same two checks as the lesson page). */
    private function studentClassProblem(int $studentId, $classId): ?string
    {
        $enrollment = ClassEnrollment::where('class_id', $classId)
            ->where('student_id', $studentId)
            ->where('status', 'active')
            ->first();

        if (!$enrollment) {
            return 'You are not enrolled in this class.';
        }

        if (strtolower((string) $enrollment->payment_status) !== 'paid') {
            return 'Please pay for the class before accessing its lessons.';
        }

        return null;
    }

    private function teacherMay(int $teacherId, $ownerId, $classId, $subjectId): bool
    {
        if ($ownerId && (int) $ownerId === $teacherId) {
            return true;
        }

        return $classId && $subjectId && DB::table('class_subjects')
            ->where('class_id', $classId)
            ->where('subject_id', $subjectId)
            ->where('teacher_id', $teacherId)
            ->exists();
    }
}
