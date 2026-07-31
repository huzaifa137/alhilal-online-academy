<?php

namespace App\Services;

use App\Models\Academic\ClassEnrollment;
use App\Models\Academic\ClassModel;
use App\Models\Academic\Exam;
use App\Models\Academic\ExamResult;
use App\Models\Academic\Lesson;
use App\Models\Academic\StudentProgress;
use App\Models\Academic\Topic;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class ReportCardService
{
    public function __construct(private ClassSubjectService $classSubjectService)
    {
    }

    /**
     * Build a full, subject-wise report card ("pass slip") for a student in
     * a class. Unlike the certificate — which is only issued once every
     * requirement is met — this is computed live every time it is viewed,
     * so it always reflects the student's current standing, even mid-term.
     */
    public function build(int $studentId, int $classId): ?array
    {
        $class = ClassModel::with(['level.section', 'academicYear', 'classTeacher'])->find($classId);

        if (!$class) {
            return null;
        }

        $enrollment = ClassEnrollment::where('class_id', $classId)
            ->where('student_id', $studentId)
            ->first();

        if (!$enrollment) {
            return null;
        }

        $student = User::find($studentId);

        $this->classSubjectService->backfillForClass($classId);

        $subjectsPivot = $class->subjects()->get();

        $performance = $this->computeSubjectPerformance($studentId, $classId, $subjectsPivot);

        $subjectRows        = $performance['subjects'];
        $totalObtained       = $performance['total_obtained'];
        $totalFull            = $performance['total_full'];
        $totalLessons         = $performance['total_lessons'];
        $totalLessonsComplete = $performance['total_lessons_completed'];
        $totalQuizzes         = $performance['total_quizzes'];
        $totalQuizzesTaken    = $performance['total_quizzes_taken'];

        $overallPercentage = $totalFull > 0 ? round(($totalObtained / $totalFull) * 100, 1) : null;
        $overallGrade      = $overallPercentage !== null ? $this->gradeFor($overallPercentage) : null;
        $overallRemark     = $overallPercentage !== null ? $this->remarkFor($overallPercentage) : 'No assessments completed yet.';
        $lessonProgressPct = $totalLessons > 0 ? round(($totalLessonsComplete / $totalLessons) * 100, 1) : 0;

        $rank = $this->computeRank($class, $studentId, $subjectsPivot, $overallPercentage);

        $studentName = $student?->fullname
            ?? trim(($student?->firstname ?? '') . ' ' . ($student?->lastname ?? ''))
            ?: 'Student';

        return [
            'class'                    => $class,
            'enrollment'               => $enrollment,
            'student'                  => $student,
            'studentName'              => $studentName,
            'levelName'                => $class->level->name ?? null,
            'levelCode'                => $class->level->code ?? null,
            'sectionName'              => $class->level->section->name ?? null,
            'academicYearName'         => $class->academicYear->name ?? null,
            'classTeacherName'         => $class->classTeacher?->fullname
                ?? trim(($class->classTeacher?->firstname ?? '') . ' ' . ($class->classTeacher?->lastname ?? '')),
            'rollNumber'               => $enrollment->id ? str_pad((string) $enrollment->id, 4, '0', STR_PAD_LEFT) : null,
            'subjects'                 => $subjectRows,
            'totalMarksObtained'       => $totalObtained,
            'totalFullMarks'           => $totalFull,
            'overallPercentage'        => $overallPercentage,
            'overallGrade'             => $overallGrade,
            'overallRemark'            => $overallRemark,
            'totalLessons'             => $totalLessons,
            'totalLessonsCompleted'    => $totalLessonsComplete,
            'lessonProgressPercentage' => $lessonProgressPct,
            'totalQuizzes'             => $totalQuizzes,
            'totalQuizzesTaken'        => $totalQuizzesTaken,
            'rankPosition'             => $rank['position'],
            'rankOutOf'                => $rank['out_of'],
            'reportNo'                 => $this->reportNo($studentId, $classId),
            'generatedAt'              => now(),
        ];
    }

    /**
     * Compute subject-by-subject performance for one student in a class.
     *
     * Marks are derived from quiz results: for every subject, we take the
     * student's best attempt on each published quiz attached to that
     * subject's lessons, average the percentages, then scale that average
     * against the subject's official "full marks" (set by the school per
     * class/subject in class_subjects.full_marks, default 100).
     */
    private function computeSubjectPerformance(int $studentId, int $classId, $subjectsPivot): array
    {
        $subjectRows = [];

        $totalObtained     = 0;
        $totalFull          = 0;
        $totalLessons        = 0;
        $totalLessonsComplete = 0;
        $totalQuizzes         = 0;
        $totalQuizzesTaken    = 0;

        foreach ($subjectsPivot as $subject) {
            $fullMarks = (int) ($subject->pivot->full_marks ?? 100);
            $passMarks = (int) ($subject->pivot->passing_marks ?? 50);

            $topicIds = Topic::where('class_id', $classId)
                ->where('subject_id', $subject->id)
                ->pluck('id');

            $lessons = Lesson::whereIn('topic_id', $topicIds)
                ->where('status', 'published')
                ->get(['id']);

            $lessonIds     = $lessons->pluck('id');
            $lessonTotal   = $lessons->count();

            $lessonCompleted = $lessonIds->isEmpty() ? 0 : StudentProgress::where('student_id', $studentId)
                ->whereIn('lesson_id', $lessonIds)
                ->whereIn('status', ['completed', 'passed'])
                ->count();

            $quizzes = $lessonIds->isEmpty() ? collect() : Exam::whereIn('lesson_id', $lessonIds)
                ->where('exam_type', 'quiz')
                ->where('status', 'published')
                ->get(['id']);

            $quizPercentages = [];

            foreach ($quizzes as $quiz) {
                $best = ExamResult::where('exam_id', $quiz->id)
                    ->where('student_id', $studentId)
                    ->orderByDesc('percentage')
                    ->first();

                if ($best) {
                    $quizPercentages[] = (float) $best->percentage;
                }
            }

            $avgPercentage = count($quizPercentages) > 0
                ? array_sum($quizPercentages) / count($quizPercentages)
                : null;

            $marksObtained = $avgPercentage !== null
                ? (int) round(($avgPercentage / 100) * $fullMarks)
                : null;

            $teacherId = $subject->pivot->teacher_id ?? null;
            $teacher   = $teacherId ? User::find($teacherId) : null;
            $teacherName = $teacher
                ? ($teacher->fullname ?: trim(($teacher->firstname ?? '') . ' ' . ($teacher->lastname ?? '')))
                : null;

            if ($avgPercentage !== null) {
                $totalObtained += $marksObtained;
                $totalFull += $fullMarks;
            }

            $totalLessons += $lessonTotal;
            $totalLessonsComplete += $lessonCompleted;
            $totalQuizzes += $quizzes->count();
            $totalQuizzesTaken += count($quizPercentages);

            $subjectRows[] = [
                'subject_id'        => $subject->id,
                'name'              => $this->displayName($subject->name),
                'code'              => $subject->code,
                'teacher'           => $teacherName,
                'full_marks'        => $fullMarks,
                'pass_marks'        => $passMarks,
                'marks_obtained'    => $marksObtained,
                'percentage'        => $avgPercentage !== null ? round($avgPercentage, 1) : null,
                'grade'             => $avgPercentage !== null ? $this->gradeFor($avgPercentage) : null,
                'remark'            => $avgPercentage !== null ? $this->remarkFor($avgPercentage) : 'Not yet assessed',
                'is_pass'           => $marksObtained !== null ? $marksObtained >= $passMarks : null,
                'lessons_total'     => $lessonTotal,
                'lessons_completed' => $lessonCompleted,
                'lesson_progress'   => $lessonTotal > 0 ? round(($lessonCompleted / $lessonTotal) * 100, 1) : 0,
                'quizzes_total'     => $quizzes->count(),
                'quizzes_taken'     => count($quizPercentages),
            ];
        }

        return [
            'subjects'                 => $subjectRows,
            'total_obtained'           => $totalObtained,
            'total_full'               => $totalFull,
            'total_lessons'            => $totalLessons,
            'total_lessons_completed'  => $totalLessonsComplete,
            'total_quizzes'            => $totalQuizzes,
            'total_quizzes_taken'      => $totalQuizzesTaken,
        ];
    }

    /**
     * Work out this student's rank among classmates, based on overall
     * percentage. Cached briefly since it requires scanning every student
     * in the class.
     */
    private function computeRank(ClassModel $class, int $studentId, $subjectsPivot, ?float $studentPercentage): array
    {
        if ($studentPercentage === null) {
            return ['position' => null, 'out_of' => null];
        }

        $cacheKey = "report_card_rank_{$class->id}";

        $standings = Cache::remember($cacheKey, 300, function () use ($class, $subjectsPivot) {
            $studentIds = ClassEnrollment::where('class_id', $class->id)
                ->where('status', 'active')
                ->pluck('student_id');

            $rows = [];

            foreach ($studentIds as $sid) {
                $perf = $this->computeSubjectPerformance($sid, $class->id, $subjectsPivot);

                if ($perf['total_full'] > 0) {
                    $rows[$sid] = round(($perf['total_obtained'] / $perf['total_full']) * 100, 2);
                }
            }

            arsort($rows);

            return $rows;
        });

        if (empty($standings)) {
            return ['position' => null, 'out_of' => null];
        }

        $position = 1;
        foreach (array_keys($standings) as $sid) {
            if ((int) $sid === $studentId) {
                break;
            }
            $position++;
        }

        return [
            'position' => array_key_exists($studentId, $standings) ? $position : null,
            'out_of'   => count($standings),
        ];
    }

    /**
     * Some subject names carry an Arabic translation in parentheses, e.g.
     * "Fiqh (الفقه) - Primary". The report card's subject column isn't set
     * in an Arabic-capable font, so that part renders as "????" — strip it
     * and keep the clean English name, e.g. "Fiqh - Primary".
     */
    private function displayName(?string $name): ?string
    {
        if (!$name) {
            return $name;
        }

        $clean = preg_replace('/\s*\([^)]*\p{Arabic}[^)]*\)/u', '', $name);

        return trim(preg_replace('/\s{2,}/', ' ', $clean ?? $name));
    }


    public function gradeFor(?float $percentage): ?string
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
            default            => 'E',
        };
    }

    /**
     * Short teacher-style remark for a percentage score.
     */
    public function remarkFor(?float $percentage): string
    {
        if ($percentage === null) {
            return 'Not yet assessed';
        }

        return match (true) {
            $percentage >= 90 => 'Outstanding performance',
            $percentage >= 80 => 'Excellent performance',
            $percentage >= 70 => 'Very good performance',
            $percentage >= 60 => 'Good performance',
            $percentage >= 50 => 'Fair, needs more effort',
            default            => 'Needs significant improvement',
        };
    }

    /**
     * A stable, human-friendly report reference. Not persisted (the report
     * is recomputed live), but deterministic so the same student/class
     * always shows the same reference number.
     */
    private function reportNo(int $studentId, int $classId): string
    {
        return 'AHA-RPT-' . now()->format('Y') . '-' . str_pad((string) $classId, 3, '0', STR_PAD_LEFT)
            . '-' . str_pad((string) $studentId, 4, '0', STR_PAD_LEFT);
    }
}