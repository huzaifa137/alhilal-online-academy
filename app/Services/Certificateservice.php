<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Academic\ClassEnrollment;
use App\Models\Academic\ClassModel;
use App\Models\Academic\Exam;
use App\Models\Academic\ExamResult;
use App\Models\Academic\Lesson;
use App\Models\Academic\StudentProgress;

class CertificateService
{
    /**
     * Work out whether a student has completed everything required for a
     * class certificate, and gather the numbers needed to render one.
     *
     * Eligibility rule:
     *   - The class enrollment must be active and fully paid.
     *   - Every published lesson in the class must be marked completed/passed.
     *   - Every published quiz attached to those lessons must be passed
     *     (by the student's best attempt).
     */
    public function evaluateClassEligibility(int $studentId, int $classId): array
    {
        $class = ClassModel::with('level.section')->find($classId);

        if (!$class) {
            return $this->notEligible(null, 'Class not found.');
        }

        $enrollment = ClassEnrollment::where('class_id', $classId)
            ->where('student_id', $studentId)
            ->first();

        if (!$enrollment || $enrollment->status !== 'active') {
            return $this->notEligible($class, 'You are not actively enrolled in this class.', $enrollment);
        }

        if (strtolower($enrollment->payment_status) !== 'paid') {
            return $this->notEligible($class, 'This class must be fully paid before a certificate can be issued.', $enrollment);
        }

        $lessons = Lesson::whereHas('topic', fn($q) => $q->where('class_id', $classId))
            ->where('status', 'published')
            ->get();

        $totalLessons = $lessons->count();

        if ($totalLessons === 0) {
            return $this->notEligible($class, 'This class has no published lessons yet.', $enrollment);
        }

        $lessonIds = $lessons->pluck('id');

        $completedLessons = StudentProgress::where('student_id', $studentId)
            ->whereIn('lesson_id', $lessonIds)
            ->whereIn('status', ['completed', 'passed'])
            ->count();

        $lessonProgressPercentage = round(($completedLessons / $totalLessons) * 100, 1);

        if ($completedLessons < $totalLessons) {
            return $this->notEligible(
                $class,
                'You still have ' . ($totalLessons - $completedLessons) . ' lesson(s) left to complete.',
                $enrollment,
                $totalLessons,
                $completedLessons,
                $lessonProgressPercentage
            );
        }

        // All lessons are complete — now check quizzes attached to those lessons.
        $quizzes = Exam::whereIn('lesson_id', $lessonIds)
            ->where('exam_type', 'quiz')
            ->where('status', 'published')
            ->get();

        $totalQuizzes = $quizzes->count();
        $passedQuizzes = 0;
        $percentages  = [];

        foreach ($quizzes as $quiz) {
            $bestResult = ExamResult::where('exam_id', $quiz->id)
                ->where('student_id', $studentId)
                ->orderByDesc('is_passed')
                ->orderByDesc('percentage')
                ->first();

            if ($bestResult) {
                $percentages[] = (float) $bestResult->percentage;
            }

            if ($bestResult && $bestResult->is_passed) {
                $passedQuizzes++;
            }
        }

        if ($totalQuizzes > 0 && $passedQuizzes < $totalQuizzes) {
            return $this->notEligible(
                $class,
                'You still need to pass ' . ($totalQuizzes - $passedQuizzes) . ' quiz(zes) to complete this class.',
                $enrollment,
                $totalLessons,
                $completedLessons,
                $lessonProgressPercentage,
                $totalQuizzes,
                $passedQuizzes
            );
        }

        $averagePercentage = count($percentages) > 0
            ? round(array_sum($percentages) / count($percentages), 1)
            : null;

        return [
            'eligible'                   => true,
            'reason'                     => null,
            'class'                      => $class,
            'enrollment'                 => $enrollment,
            'total_lessons'              => $totalLessons,
            'completed_lessons'          => $completedLessons,
            'total_quizzes'              => $totalQuizzes,
            'passed_quizzes'             => $passedQuizzes,
            'average_percentage'         => $averagePercentage,
            'lesson_progress_percentage' => $lessonProgressPercentage,
        ];
    }

    private function notEligible(
        ?ClassModel $class,
        string $reason,
        $enrollment = null,
        int $totalLessons = 0,
        int $completedLessons = 0,
        float $lessonProgressPercentage = 0,
        int $totalQuizzes = 0,
        int $passedQuizzes = 0
    ): array {
        return [
            'eligible'                   => false,
            'reason'                     => $reason,
            'class'                      => $class,
            'enrollment'                 => $enrollment,
            'total_lessons'              => $totalLessons,
            'completed_lessons'          => $completedLessons,
            'total_quizzes'              => $totalQuizzes,
            'passed_quizzes'             => $passedQuizzes,
            'average_percentage'         => null,
            'lesson_progress_percentage' => $lessonProgressPercentage,
        ];
    }

    /**
     * Work out a letter grade from a percentage score.
     */
    public function gradeForPercentage(?float $percentage): ?string
    {
        if ($percentage === null) {
            return null;
        }

        return match (true) {
            $percentage >= 90 => 'A+',
            $percentage >= 80 => 'A',
            $percentage >= 70 => 'B',
            $percentage >= 60 => 'C',
            $percentage >= 50 => 'D',
            default           => 'E',
        };
    }

    /**
     * Find an existing issued certificate for this student/class, or
     * create one if the student has just become eligible.
     */
    public function findOrIssue(int $studentId, int $classId): ?Certificate
    {
        $existing = Certificate::where('student_id', $studentId)
            ->where('class_id', $classId)
            ->where('type', 'class_completion')
            ->first();

        if ($existing) {
            return $existing;
        }

        $eligibility = $this->evaluateClassEligibility($studentId, $classId);

        if (!$eligibility['eligible']) {
            return null;
        }

        /** @var ClassModel $class */
        $class      = $eligibility['class'];
        $sectionId  = $class->level->section->id ?? null;
        $percentage = $eligibility['average_percentage'];

        return Certificate::create([
            'student_id'       => $studentId,
            'class_id'         => $classId,
            'section_id'       => $sectionId,
            'certificate_no'   => Certificate::generateCertificateNo(),
            'verification_code'=> Certificate::generateVerificationCode(),
            'type'             => 'class_completion',
            'title'            => 'Certificate of Completion',
            'description'      => "Awarded for successfully completing all lessons and assessments in {$class->name}.",
            'issued_date'      => now()->toDateString(),
            'grade'            => $this->gradeForPercentage($percentage),
            'percentage'       => $percentage,
            'pdf_path'         => '',
            'template_used'    => 'classic-gold',
            'status'           => 'issued',
            'issued_at'        => now(),
        ]);
    }
}