<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Academic\ClassEnrollment;
use App\Models\Academic\ClassModel;
use App\Models\Academic\Exam;
use App\Models\Academic\ClassStudent;
use App\Models\Academic\Lesson;
use App\Models\Academic\StudentProgress;
use App\Models\Academic\Topic;
use Illuminate\Http\Request;

class StudentLessonController extends Controller
{
    // ── Browse available classes ──────────────────────────────────────
    public function browseClasses()
    {

        $studentId = session('LoggedStudent');

        $classes = ClassModel::with(['level', 'level.section', 'subjects'])
            ->where('status', 'active')
            // ->orderBy('name')
            ->get();

        // Classes that have no subject-linked topics, or no published lessons
        // yet, cannot be enrolled into — flag them so the view can disable
        // "Enroll Now" and prompt the student to contact the Admin instead.
        // NOTE: subjects here are derived from `topics.subject_id`, not the
        // `class_subjects` pivot table — the pivot is a separate admin
        // assignment table and is not what actually drives lesson content.
        $classIdsWithSubjects = Topic::whereIn('class_id', $classes->pluck('id'))
            ->whereNotNull('subject_id')
            ->pluck('class_id')
            ->unique()
            ->toArray();

        $classIdsWithLessons = Lesson::whereHas('topic', fn($q) => $q->whereIn('class_id', $classes->pluck('id')))
            ->where('status', 'published')
            ->get()
            ->pluck('topic.class_id')
            ->unique()
            ->toArray();

        $classes->each(function ($class) use ($classIdsWithSubjects, $classIdsWithLessons) {
            $class->has_content = in_array($class->id, $classIdsWithSubjects) && in_array($class->id, $classIdsWithLessons);
        });

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

        // A class must have at least one subject-linked topic and one
        // published lesson before a student is allowed to enroll in it.
        // (Subjects are derived from `topics.subject_id`, not the unused
        // `class_subjects` pivot table.)
        $hasSubjects = Topic::where('class_id', $class->id)
            ->whereNotNull('subject_id')
            ->exists();
        $hasLessons = Lesson::whereHas('topic', fn($q) => $q->where('class_id', $class->id))
            ->where('status', 'published')
            ->exists();

        if (!$hasSubjects || !$hasLessons) {
            return response()->json([
                'success' => false,
                'no_content' => true,
                'message' => "\"{$class->name}\" does not have any subjects or lessons available yet. Please contact the Admin to add lessons to this class.",
            ], 422);
        }

        // Enroll and activate the class immediately — no separate
        // "Activate Class" step required from the student.
        ClassEnrollment::create([
            'class_id' => $request->class_id,
            'student_id' => $studentId,
            'enrollment_date' => now(),
            'status' => 'active',
            'payment_status' => 'paid',
            'amount_paid' => 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => "You have successfully enrolled in {$class->name}! The class is now active and its lessons are unlocked.",
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
        $totalLessons = 0;
        $completedLessons = 0;

        foreach ($enrollments as $enrollment) {
            $class = $enrollment->class;
            if (!$class)
                continue;

            $classPaid = strtolower($enrollment->payment_status) === 'paid';
            $className = $class->name;

            if (!isset($groupedLessons[$className])) {
                $groupedLessons[$className] = [
                    'class_id' => $class->id,
                    'level' => $class->level->name ?? '',
                    'class_paid' => $classPaid,
                    'class_pending' => !$classPaid,
                    'enrollment' => $enrollment,
                    'subjects' => [],
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
                if (!$lesson->topic || !$lesson->topic->subject)
                    continue;

                $totalLessons++;

                $subjectName = $lesson->topic->subject->name;
                $topicName = $lesson->topic->title;

                if (!isset($groupedLessons[$className]['subjects'][$subjectName])) {
                    $groupedLessons[$className]['subjects'][$subjectName] = [
                        'subject_id' => $lesson->topic->subject->id,
                        'subject_code' => $lesson->topic->subject->code ?? '',
                        'topics' => [],
                        'materials' => [],
                    ];
                }

                if (!isset($groupedLessons[$className]['subjects'][$subjectName]['topics'][$topicName])) {
                    $groupedLessons[$className]['subjects'][$subjectName]['topics'][$topicName] = [
                        'topic_id' => $lesson->topic->id,
                        'topic_description' => $lesson->topic->description,
                        'lessons' => [],
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

                // Per-student payment status (NOT the global lessons.lesson_payment_status —
                // that column reflects nothing student-specific and must not be used for gating).
                $lesson->is_paid_by_student = $lesson->isPaidByStudent($studentId);

                // Quiz count
                $lesson->quiz_count = Exam::where('lesson_id', $lesson->id)
                    ->where('exam_type', 'quiz')
                    ->where('status', 'published')
                    ->count();

                $groupedLessons[$className]['subjects'][$subjectName]['topics'][$topicName]['lessons'][] = $lesson;
            }

            // Subject materials (PDFs) for this class — grouped by subject.
            // Visible to every student enrolled here; download access is
            // gated in the view by the same $classPaid flag used for lessons.
            $materials = \App\Models\Academic\SubjectMaterial::with(['subject', 'materialPayments'])
                ->where('class_id', $class->id)
                ->where('status', 'active')
                ->orderBy('sort_order')
                ->get();

            foreach ($materials as $material) {
                if (!$material->subject) {
                    continue;
                }

                // Per-student payment status — same gating rule as lessons.
                $material->is_paid_by_student = $material->isPaidByStudent($studentId);

                $subjectName = $material->subject->name;

                if (!isset($groupedLessons[$className]['subjects'][$subjectName])) {
                    $groupedLessons[$className]['subjects'][$subjectName] = [
                        'subject_id' => $material->subject->id,
                        'subject_code' => $material->subject->code ?? '',
                        'topics' => [],
                        'materials' => [],
                    ];
                }

                $groupedLessons[$className]['subjects'][$subjectName]['materials'][] = $material;
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
            'class_id' => 'required|exists:classes,id',
            'amount' => 'required|numeric|min:0',
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
            'amount_paid' => $request->amount,
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
            'lesson_id' => 'required|exists:lessons,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:mtn,airtel,card',
            'required_amount' => 'required|numeric|min:0',
        ]);

        $studentId = session('LoggedStudent');

        $lesson = Lesson::findOrFail($request->lesson_id);

        if ((float) $request->amount < (float) $request->required_amount) {
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

    // ── Show a specific lesson (student lesson view) ──────────────────
    public function showLesson(Lesson $lesson)
    {

        $studentId = session('LoggedStudent');

        $lesson->loadMissing('topic.class');
        $classId = $lesson->topic->class_id ?? null;

        $enrollment = ClassEnrollment::where('class_id', $classId)
            ->where('student_id', $studentId)
            ->where('status', 'active')
            ->first();

        $classPaid  = $enrollment && strtolower($enrollment->payment_status) === 'paid';
        $lessonPaid = $lesson->isPaidByStudent($studentId);

        if (!$enrollment) {
            return redirect()->route('student.lessons.lists')
                ->with('error', 'You are not enrolled in this class.');
        }

        if (!$classPaid) {
            return redirect()->route('student.lessons.lists')
                ->with('error', 'Please pay for the class before accessing its lessons.');
        }

        if (!$lessonPaid) {
            return redirect()->route('student.lessons.lists')
                ->with('error', 'Please pay for this lesson to access it.');
        }

        // Load all relationships
        $lesson->load([
            'topic' => function ($q) {
                $q->with([
                    'subject',
                    'class' => function ($cq) {
                        $cq->with(['level', 'academicYear']);
                    }
                ]);
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
                'student_id' => $studentId,
                'lesson_id' => $lesson->id,
                'status' => 'in_progress',
                'started_at' => now(),
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
            'lesson',
            'progress',
            'prevLesson',
            'nextLesson',
            'quizResults'
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
                'status' => 'completed',
                'completed_at' => now(),
                'started_at' => now(),
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
        if ($request->has('last_position'))
            $data['last_position_seconds'] = $request->last_position;
        if ($request->has('time_spent'))
            $data['time_spent_seconds'] = $request->time_spent;

        $progress = StudentProgress::updateOrCreate(
            ['student_id' => $studentId, 'lesson_id' => $lesson->id],
            $data
        );

        return response()->json(['success' => true, 'progress' => $progress]);
    }

    public function activateClass(Request $request)
    {
        $classId = $request->input('class_id');
        $studentId = session('LoggedStudent');

        $enrollment = ClassEnrollment::where('class_id', $classId)
            ->where('student_id', $studentId)
            ->first();

        if (!$enrollment) {
            return response()->json(['success' => false, 'message' => 'Enrollment not found.']);
        }

        $enrollment->payment_status = 'paid';
        $enrollment->status = 'active';
        $enrollment->save();

        return response()->json(['success' => true, 'message' => 'Class activated successfully.']);
    }
}