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

        $lesson->update([
            'lesson_payment_status' => 'Paid',
            'lesson_amount'         => $request->required_amount,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lesson payment successful! You can now access this lesson.',
        ]);
    }

    // ── Show a specific lesson (student lesson view) ──────────────────
    public function showLesson(Lesson $lesson)
    {
        $studentId = session('LoggedStudent');

        // Load all relationships
        $lesson->load([
            'topic' => function ($q) {
                $q->with(['subject', 'class' => function ($cq) {
                    $cq->with(['level', 'academicYear']);
                }]);
            },
            'resources',
            'teacher',
            'exams' => function ($q) {
                $q->where('exam_type', 'quiz')->where('status', 'published')->with('questions');
            },
        ]);

        // Student's progress on this lesson
        $progress = StudentProgress::where('student_id', $studentId)
            ->where('lesson_id', $lesson->id)
            ->first();

        // Auto-create progress record as "in_progress" when student opens the lesson
        if (!$progress) {
            $progress = StudentProgress::create([
                'student_id'  => $studentId,
                'lesson_id'   => $lesson->id,
                'status'      => 'in_progress',
                'started_at'  => now(),
                'time_spent_seconds' => 0,
            ]);
        } elseif ($progress->status === 'not_started') {
            $progress->update(['status' => 'in_progress', 'started_at' => now()]);
        }

        // Prev / next lessons in the same topic
        $prevLesson = Lesson::where('topic_id', $lesson->topic_id)
            ->where('lesson_order', '<', $lesson->lesson_order)
            ->where('status', 'published')
            ->orderBy('lesson_order', 'desc')
            ->first();

        $nextLesson = Lesson::where('topic_id', $lesson->topic_id)
            ->where('lesson_order', '>', $lesson->lesson_order)
            ->where('status', 'published')
            ->orderBy('lesson_order')
            ->first();

        // Quiz results for this lesson's quizzes
        $quizResults = \App\Models\Academic\ExamResult::where('student_id', $studentId)
            ->whereIn('exam_id', $lesson->exams->pluck('id'))
            ->get()
            ->keyBy('exam_id');

        return view('Student.lessons.show', compact(
            'lesson', 'progress', 'prevLesson', 'nextLesson', 'quizResults'
        ));
    }

    // ── Start a lesson (mark in_progress) ────────────────────────────
    public function startLesson(Request $request, Lesson $lesson)
    {
        $studentId = session('LoggedStudent');

        $progress = StudentProgress::updateOrCreate(
            ['student_id' => $studentId, 'lesson_id' => $lesson->id],
            ['status' => 'in_progress', 'started_at' => now()]
        );

        return response()->json(['success' => true, 'progress' => $progress]);
    }

    // ── Mark lesson complete ──────────────────────────────────────────
    public function completeLesson(Request $request, Lesson $lesson)
    {
        $studentId = session('LoggedStudent');

        $progress = StudentProgress::updateOrCreate(
            ['student_id' => $studentId, 'lesson_id' => $lesson->id],
            [
                'status'       => 'completed',
                'completed_at' => now(),
                'started_at'   => now(),
                'time_spent_seconds' => $request->time_spent ?? 0,
            ]
        );

        return response()->json(['success' => true, 'progress' => $progress]);
    }

    // ── Update progress (position, time spent) ───────────────────────
    public function updateProgress(Request $request, Lesson $lesson)
    {
        $studentId = session('LoggedStudent');

        $data = ['status' => 'in_progress'];
        if ($request->has('last_position')) $data['last_position_seconds'] = $request->last_position;
        if ($request->has('time_spent'))   $data['time_spent_seconds']     = $request->time_spent;

        $progress = StudentProgress::updateOrCreate(
            ['student_id' => $studentId, 'lesson_id' => $lesson->id],
            $data
        );

        return response()->json(['success' => true, 'progress' => $progress]);
    }
}