<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Academic\ClassEnrollment;
use App\Models\Academic\ClassModel;
use App\Models\Academic\Exam;
use App\Models\Academic\ExamResult;
use App\Models\Academic\Lesson;
use App\Models\Academic\StudentProgress;
use Illuminate\Http\Request;

class StudentEnrollmentController extends Controller
{
    // ── Browse available classes ──────────────────────────────────────
    public function browseClasses()
    {
        $studentId = session('LoggedStudent');

        $classes = ClassModel::with(['level', 'level.section', 'subjects'])
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $enrolledClassIds = ClassEnrollment::where('student_id', $studentId)
            ->where('status', 'active')
            ->pluck('class_id')
            ->toArray();

        return view('Student.enrollments.browse', compact('classes', 'enrolledClassIds'));
    }

    // ── Self-enroll in a class ────────────────────────────────────────
    public function selfEnroll(Request $request)
    {
        $request->validate(['class_id' => 'required|exists:classes,id']);

        $studentId = session('LoggedStudent');

        if (!$studentId) {
            return response()->json(['success' => false, 'message' => 'Not authenticated.'], 401);
        }

        $existing = ClassEnrollment::where('class_id', $request->class_id)
            ->where('student_id', $studentId)
            ->first();

        if ($existing) {
            return response()->json(['success' => false, 'message' => 'You are already enrolled in this class.'], 400);
        }

        $class = ClassModel::findOrFail($request->class_id);

        ClassEnrollment::create([
            'class_id'        => $request->class_id,
            'student_id'      => $studentId,
            'enrollment_date' => now(),
            'status'          => 'active',
            'payment_status'  => 'pending',
            'amount_paid'     => 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => "You have successfully enrolled in {$class->name}! Pay for the class to unlock lessons.",
        ]);
    }

    // ── Student lesson list (enrolled classes → subjects → topics → lessons) ─
    public function studentLessonList()
    {
        $studentId = session('LoggedStudent');

        // All enrollments for this student
        $enrollments = ClassEnrollment::with(['class.level', 'class.subjects'])
            ->where('student_id', $studentId)
            ->where('status', 'active')
            ->get();

        $groupedLessons = [];
        $totalLessons    = 0;
        $completedLessons = 0;

        foreach ($enrollments as $enrollment) {
            $class = $enrollment->class;
            if (!$class) continue;

            $classPaid   = strtolower($enrollment->payment_status) === 'paid';
            $className   = $class->name;

            if (!isset($groupedLessons[$className])) {
                $groupedLessons[$className] = [
                    'class_id'    => $class->id,
                    'level'       => $class->level->name ?? '',
                    'class_paid'  => $classPaid,
                    'class_pending' => !$classPaid,
                    'enrollment'  => $enrollment,
                    'subjects'    => [],
                ];
            }

            // Lessons inside this class, ordered by topic
            $lessons = Lesson::with([
                'topic' => fn($q) => $q->with([
                    'subject',
                    'class' => fn($q2) => $q2->with(['level', 'academicYear']),
                ]),
                'resources',
            ])
            ->whereHas('topic', fn($q) => $q->where('class_id', $class->id))
            ->where('status', 'published')
            ->orderBy('lesson_order')
            ->get();

            foreach ($lessons as $lesson) {
                if (!$lesson->topic || !$lesson->topic->subject) continue;

                $totalLessons++;

                $subjectName = $lesson->topic->subject->name;
                $topicName   = $lesson->topic->title;

                if (!isset($groupedLessons[$className]['subjects'][$subjectName])) {
                    $groupedLessons[$className]['subjects'][$subjectName] = [
                        'subject_id'   => $lesson->topic->subject->id,
                        'subject_code' => $lesson->topic->subject->code ?? '',
                        'topics'       => [],
                    ];
                }

                if (!isset($groupedLessons[$className]['subjects'][$subjectName]['topics'][$topicName])) {
                    $groupedLessons[$className]['subjects'][$subjectName]['topics'][$topicName] = [
                        'topic_id'          => $lesson->topic->id,
                        'topic_description' => $lesson->topic->description,
                        'lessons'           => [],
                    ];
                }

                // Student progress for this lesson
                $progress = StudentProgress::where('student_id', $studentId)
                    ->where('lesson_id', $lesson->id)
                    ->first();

                $lesson->student_progress = $progress ? $progress->status : null;

                if ($progress && $progress->status === 'completed') {
                    $completedLessons++;
                }

                // Quiz count
                $lesson->quiz_count = Exam::where('lesson_id', $lesson->id)
                    ->where('exam_type', 'quiz')
                    ->where('status', 'published')
                    ->count();

                $groupedLessons[$className]['subjects'][$subjectName]['topics'][$topicName]['lessons'][] = $lesson;
            }
        }

        $enrolledClasses = count($groupedLessons);

        return view('Student.lessons.lesson-lists', compact(
            'groupedLessons',
            'enrolledClasses',
            'totalLessons',
            'completedLessons'
        ));
    }

    // ── Pay for a class (unlock all lessons in the class) ─────────────
    public function payForClass(Request $request)
    {
        $request->validate([
            'class_id'       => 'required|exists:classes,id',
            'amount'         => 'required|numeric|min:0',
            'payment_method' => 'required|in:mtn,airtel,card',
        ]);

        $studentId = session('LoggedStudent');

        $enrollment = ClassEnrollment::where('class_id', $request->class_id)
            ->where('student_id', $studentId)
            ->where('status', 'active')
            ->first();

        if (!$enrollment) {
            return response()->json(['success' => false, 'message' => 'Enrollment not found.'], 404);
        }

        if (strtolower($enrollment->payment_status) === 'paid') {
            return response()->json(['success' => false, 'message' => 'This class has already been paid for.'], 400);
        }

        $enrollment->update([
            'payment_status' => 'paid',
            'amount_paid'    => $request->amount,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Class payment successful! All lessons in this class are now unlocked.',
        ]);
    }

    // ── Pay for a single lesson ───────────────────────────────────────
    public function payForLesson(Request $request)
    {
        $request->validate([
            'lesson_id'      => 'required|exists:lessons,id',
            'amount'         => 'required|numeric|min:0',
            'payment_method' => 'required|in:mtn,airtel,card',
            'required_amount'=> 'required|numeric|min:0',
        ]);

        $studentId = session('LoggedStudent');

        $lesson = Lesson::findOrFail($request->lesson_id);

        if ((float)$request->amount < (float)$request->required_amount) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient amount. Required: UGX ' . number_format($request->required_amount),
            ]);
        }

        \App\Models\Academic\LessonPayment::updateOrCreate(
            ['lesson_id' => $lesson->id, 'student_id' => $studentId],
            ['amount_paid' => $request->required_amount, 'paid_at' => now()]
        );

        return response()->json([
            'success' => true,
            'message' => 'Lesson payment successful! You can now access this lesson.',
        ]);
    }
}