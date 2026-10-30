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
use App\Support\ContentLanguage;
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

        // Which teaching languages each class has published lessons in, so the
        // view can show e.g. "English · Kiswahili" and hint when the language
        // the student has selected has nothing yet.
        $languagesByClass = Lesson::join('topics', 'topics.id', '=', 'lessons.topic_id')
            ->whereIn('topics.class_id', $classes->pluck('id'))
            ->where('lessons.status', 'published')
            ->select('topics.class_id', 'lessons.language')
            ->distinct()
            ->get()
            ->groupBy('class_id')
            ->map(fn ($rows) => $rows->pluck('language')->filter()->unique()->values()->all());

        $viewerLanguage = ContentLanguage::current();

        $classes->each(function ($class) use ($classIdsWithSubjects, $classIdsWithLessons, $languagesByClass, $viewerLanguage) {
            $class->has_content = in_array($class->id, $classIdsWithSubjects) && in_array($class->id, $classIdsWithLessons);
            $class->content_languages = $languagesByClass->get($class->id, []);
            $class->has_content_in_viewer_language = in_array($viewerLanguage, $class->content_languages, true);
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

        // Each language is its own learning track: only lessons and study
        // materials taught in the language the student has selected are listed.
        $viewerLanguage = ContentLanguage::viewerLanguage();

        foreach ($enrollments as $enrollment) {
            $class = $enrollment->class;
            if (!$class)
                continue;

            $classPaid = strtolower($enrollment->payment_status) === 'paid';
            $className = $class->name;

            if (!isset($groupedLessons[$className])) {
                // Languages this class has published lessons in (for the
                // "nothing in your language yet" hint in the view).
                $availableLanguages = Lesson::whereHas('topic', fn($q) => $q->where('class_id', $class->id))
                    ->where('status', 'published')
                    ->distinct()
                    ->pluck('language')
                    ->filter()
                    ->values()
                    ->all();

                $groupedLessons[$className] = [
                    'class_id' => $class->id,
                    'level' => $class->level->name ?? '',
                    'class_paid' => $classPaid,
                    'class_pending' => !$classPaid,
                    'enrollment' => $enrollment,
                    'available_languages' => $availableLanguages,
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
                ->inLanguage($viewerLanguage)
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
                    ->inLanguage($viewerLanguage)
                    ->count();

                $groupedLessons[$className]['subjects'][$subjectName]['topics'][$topicName]['lessons'][] = $lesson;
            }

            // Subject materials (PDFs) for this class — grouped by subject.
            // Visible to every student enrolled here; download access is
            // gated in the view by the same $classPaid flag used for lessons.
            $materials = \App\Models\Academic\SubjectMaterial::with(['subject', 'materialPayments'])
                ->where('class_id', $class->id)
                ->where('status', 'active')
                ->inLanguage($viewerLanguage)
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

        if (!ContentLanguage::allows($lesson->language)) {
            return $this->languageMismatchJson($lesson->language);
        }

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

        // A lesson taught in another language is not part of this student's
        // current learning track.
        if (!ContentLanguage::allows($lesson->language)) {
            return redirect()->route('student.lessons.lists')
                ->with('error', ContentLanguage::mismatchMessage($lesson->language));
        }

        // Drafts / archived lessons are never visible to students.
        if ($lesson->status !== 'published') {
            return redirect()->route('student.lessons.lists')
                ->with('error', 'This lesson is not available.');
        }

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
            ->where('language', $lesson->language)
            ->where('lesson_order', '<', $lesson->lesson_order)
            ->where('status', 'published')
            ->orderBy('lesson_order', 'desc')
            ->first();

        $nextLesson = Lesson::where('topic_id', $lesson->topic_id)
            ->where('language', $lesson->language)
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
        if (!ContentLanguage::allows($lesson->language)) {
            return $this->languageMismatchJson($lesson->language);
        }

        $studentId = session('LoggedStudent');

        $existing = StudentProgress::where('student_id', $studentId)
            ->where('lesson_id', $lesson->id)
            ->first();

        // Never downgrade a lesson that's already completed/passed just
        // because the student re-opened it to review it.
        if ($existing && in_array($existing->status, ['completed', 'passed'])) {
            return response()->json(['success' => true, 'progress' => $existing]);
        }

        $progress = StudentProgress::updateOrCreate(
            ['student_id' => $studentId, 'lesson_id' => $lesson->id],
            ['status' => 'in_progress', 'started_at' => now()]
        );

        return response()->json(['success' => true, 'progress' => $progress]);
    }

    // ── Mark lesson complete ──────────────────────────────────────────
    public function completeLesson(Request $request, Lesson $lesson)
    {
        if (!ContentLanguage::allows($lesson->language)) {
            return $this->languageMismatchJson($lesson->language);
        }

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
        if (!ContentLanguage::allows($lesson->language)) {
            return $this->languageMismatchJson($lesson->language);
        }

        $studentId = session('LoggedStudent');

        $existing = StudentProgress::where('student_id', $studentId)
            ->where('lesson_id', $lesson->id)
            ->first();

        $data = [];

        // Only touch status if the lesson isn't already completed/passed —
        // a rewatch/scrub ping should never undo a completion.
        if (!$existing || !in_array($existing->status, ['completed', 'passed'])) {
            $data['status'] = 'in_progress';
        }

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

    /**
     * JSON 403 for AJAX endpoints when a student asks for something taught in
     * a different language than the one they currently have selected.
     */
    protected function languageMismatchJson(?string $contentLanguage)
    {
        return response()->json([
            'success' => false,
            'language_mismatch' => true,
            'content_language' => $contentLanguage,
            'message' => ContentLanguage::mismatchMessage($contentLanguage),
        ], 403);
    }
}
