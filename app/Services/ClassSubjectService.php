<?php

namespace App\Services;

use App\Models\Academic\ClassModel;
use App\Models\Academic\Lesson;
use App\Models\Academic\Topic;
use Illuminate\Support\Facades\DB;

class ClassSubjectService
{
    /**
     * Make sure a (class, subject) pair has a row in `class_subjects`.
     *
     * `class_subjects` is what actually drives the report card, the
     * certificate eligibility check, and the "My Classes" filters used by
     * teachers when adding lessons/quizzes. Topics and lessons can exist
     * for a class+subject without anyone ever explicitly running the
     * "Subject Teachers" assignment step — this keeps that table in sync
     * automatically so nothing has to be inserted by hand.
     *
     * Safe to call repeatedly: it's a no-op once the pair already exists.
     */
    public function ensureAssigned(int $classId, int $subjectId, ?int $teacherId = null): void
    {
        $class = ClassModel::find($classId);

        if (!$class || !$class->academic_year_id) {
            return;
        }

        $exists = DB::table('class_subjects')
            ->where('class_id', $classId)
            ->where('subject_id', $subjectId)
            ->where('academic_year_id', $class->academic_year_id)
            ->exists();

        if ($exists) {
            return;
        }

        $teacherId = $teacherId ?? $this->guessTeacher($classId, $subjectId) ?? $class->class_teacher_id;

        try {
            DB::table('class_subjects')->insert([
                'class_id'          => $classId,
                'subject_id'        => $subjectId,
                'teacher_id'        => $teacherId,
                'academic_year_id'  => $class->academic_year_id,
                'periods_per_week'  => 1,
                'is_compulsory'     => 1,
                'passing_marks'     => 50,
                'full_marks'        => 100,
                'status'            => 'active',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Another request created the same row a moment ago (unique
            // constraint) — that's fine, the pair is assigned either way.
        }
    }

    /**
     * Back-fill every subject that already has topics under a class but no
     * class_subjects row yet. This is what self-heals classes that were
     * set up before an explicit assignment was ever made — no SQL needed,
     * it just fixes itself the next time the class is touched.
     */
    public function backfillForClass(int $classId): void
    {
        $subjectIds = Topic::where('class_id', $classId)->pluck('subject_id')->unique();

        foreach ($subjectIds as $subjectId) {
            $this->ensureAssigned($classId, (int) $subjectId, $this->guessTeacher($classId, (int) $subjectId));
        }
    }

    /**
     * Best-guess teacher for a class+subject pair: whoever has authored the
     * most lessons under that subject's topics in this class. Falls back to
     * null (class_subjects.teacher_id is nullable) if nothing to go on,
     * in which case ensureAssigned() falls back further to the class's
     * homeroom teacher.
     */
    private function guessTeacher(int $classId, int $subjectId): ?int
    {
        $topicIds = Topic::where('class_id', $classId)->where('subject_id', $subjectId)->pluck('id');

        if ($topicIds->isEmpty()) {
            return null;
        }

        return Lesson::whereIn('topic_id', $topicIds)
            ->whereNotNull('teacher_id')
            ->select('teacher_id', DB::raw('COUNT(*) as c'))
            ->groupBy('teacher_id')
            ->orderByDesc('c')
            ->value('teacher_id');
    }
}