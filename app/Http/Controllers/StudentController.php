<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Academic\Lesson;
use App\Models\Academic\ClassEnrollment;
use App\Models\Academic\StudentProgress;
use App\Models\Academic\ExamResult;
use App\Models\User;
class StudentController extends Controller
{

    public function register(Request $request)
    {
        return view('users.register');
    }

    public function homePage()
    {
        return view('home-page');
    }

  public function studentDashboard()
    {
        $studentId = session('LoggedStudent');
        $student = \App\Models\User::find($studentId);

        // Count enrolled classes
        $enrolledClasses = \App\Models\Academic\ClassEnrollment::where('student_id', $studentId)
            ->where('status', 'active')
            ->count();

        // Count completed lessons
        $completedLessons = \App\Models\Academic\StudentProgress::where('student_id', $studentId)
            ->where('status', 'completed')
            ->count();

        // Count quizzes passed
        $quizzesPassed = \App\Models\Academic\ExamResult::where('student_id', $studentId)
            ->where('is_passed', true)
            ->count();

        // Avg quiz score
        $avgScore = \App\Models\Academic\ExamResult::where('student_id', $studentId)
            ->avg('percentage');
        $avgScore = $avgScore ? round($avgScore) : 0;

        // Get enrolled class IDs
        $enrolledClassIds = \App\Models\Academic\ClassEnrollment::where('student_id', $studentId)
            ->where('status', 'active')
            ->pluck('class_id');

        // Subject progress: for each subject in enrolled classes, compute completed/total lessons
        $subjectProgress = [];
        if ($enrolledClassIds->isNotEmpty()) {
            $subjectsData = \App\Models\Academic\Subject::whereHas('topics', function ($q) use ($enrolledClassIds) {
                $q->whereIn('class_id', $enrolledClassIds);
            })->with(['topics' => function ($q) use ($enrolledClassIds) {
                $q->whereIn('class_id', $enrolledClassIds)->with(['lessons' => function ($lq) {
                    $lq->where('status', 'published');
                }]);
            }])->get();

            foreach ($subjectsData as $subject) {
                $totalSubjectLessons = 0;
                $completedSubjectLessons = 0;
                foreach ($subject->topics as $topic) {
                    foreach ($topic->lessons as $lesson) {
                        $totalSubjectLessons++;
                        $done = \App\Models\Academic\StudentProgress::where('student_id', $studentId)
                            ->where('lesson_id', $lesson->id)
                            ->whereIn('status', ['completed', 'passed'])
                            ->exists();
                        if ($done) $completedSubjectLessons++;
                    }
                }
                if ($totalSubjectLessons > 0) {
                    $subjectProgress[] = [
                        'name'       => $subject->name,
                        'icon'       => $subject->icon ?? 'fa-book',
                        'color'      => $subject->color ?? '#6B46C1',
                        'completed'  => $completedSubjectLessons,
                        'total'      => $totalSubjectLessons,
                        'percentage' => round(($completedSubjectLessons / $totalSubjectLessons) * 100),
                    ];
                }
            }
        }

        // In-progress lessons (started but not completed)
        $inProgressLessons = \App\Models\Academic\StudentProgress::where('student_id', $studentId)
            ->where('status', 'in_progress')
            ->with(['lesson' => function ($q) {
                $q->with(['topic.subject', 'resources']);
            }])
            ->orderByDesc('updated_at')
            ->limit(6)
            ->get()
            ->filter(fn($p) => $p->lesson !== null);

        // Completed lessons (for the "completed" tab)
        $completedLessonsList = \App\Models\Academic\StudentProgress::where('student_id', $studentId)
            ->whereIn('status', ['completed', 'passed'])
            ->with(['lesson' => function ($q) {
                $q->with(['topic.subject', 'resources']);
            }])
            ->orderByDesc('completed_at')
            ->limit(6)
            ->get()
            ->filter(fn($p) => $p->lesson !== null);

        // Not-started lessons (available but no progress yet)
        $progressLessonIds = \App\Models\Academic\StudentProgress::where('student_id', $studentId)
            ->pluck('lesson_id');
        $todoLessons = \App\Models\Academic\Lesson::with(['topic.subject', 'resources'])
            ->whereHas('topic', fn($q) => $q->whereIn('class_id', $enrolledClassIds))
            ->where('status', 'published')
            ->whereNotIn('id', $progressLessonIds)
            ->orderBy('lesson_order')
            ->limit(6)
            ->get();

        // Last/current lesson being studied
        $lastProgress = \App\Models\Academic\StudentProgress::where('student_id', $studentId)
            ->whereIn('status', ['in_progress', 'completed'])
            ->with('lesson.topic.subject')
            ->orderByDesc('updated_at')
            ->first();

        // Upcoming exams for enrolled classes
        $upcomingExams = \App\Models\Academic\Exam::whereIn('class_id', $enrolledClassIds)
            ->where('status', 'published')
            ->where('available_from', '>=', now())
            ->orderBy('available_from')
            ->limit(4)
            ->get();

        // Certificates
        // $certificates = \App\Models\Academic\Certificate::where('student_id', $studentId)
        //     ->orderByDesc('created_at')
        //     ->limit(4)
        //     ->get();
        $certificates = collect([]);

        // Total lessons available to student
        $totalAvailableLessons = \App\Models\Academic\Lesson::whereHas('topic', fn($q) => $q->whereIn('class_id', $enrolledClassIds))
            ->where('status', 'published')->count();

        // Overall completion percentage
        $overallProgress = $totalAvailableLessons > 0
            ? round(($completedLessons / $totalAvailableLessons) * 100) : 0;

        // Lessons this week
        $lessonsThisWeek = \App\Models\Academic\StudentProgress::where('student_id', $studentId)
            ->whereIn('status', ['completed', 'passed'])
            ->where('completed_at', '>=', now()->startOfWeek())
            ->count();

        // ── Build lesson data for the front-end tabs (in_progress / completed / todo) ──
        // Moved out of the Blade view: keeps the template free of inline PHP closures
        // inside @json(), which some editors/linters mis-tokenize as JavaScript and
        // misreport as a bracket-matching error.
        $lessonData = [
            'inprogress' => $this->mapLessonsForFrontend($inProgressLessons, false),
            'completed'  => $this->mapLessonsForFrontend($completedLessonsList, true),
            'todo'       => $this->mapTodoLessonsForFrontend($todoLessons),
        ];

        return view('Student.dashboard', compact(
            'student', 'enrolledClasses', 'completedLessons', 'quizzesPassed', 'avgScore',
            'subjectProgress', 'inProgressLessons', 'completedLessonsList', 'todoLessons',
            'lastProgress', 'upcomingExams', 'certificates',
            'totalAvailableLessons', 'overallProgress', 'lessonsThisWeek', 'lessonData'
        ));
    }

    /**
     * Map a collection of StudentProgress records (which have a `lesson` relation)
     * into the flat array shape the front-end lesson cards expect.
     */
    private function mapLessonsForFrontend($progressCollection, bool $passed): array
    {
        return $progressCollection->map(function ($p) use ($passed) {
            return [
                'id'       => $p->lesson->id,
                'title'    => $p->lesson->title,
                'subject'  => $p->lesson->topic->subject->name ?? 'General',
                'icon'     => $p->lesson->topic->subject->icon ?? 'fa-book',
                'color'    => $p->lesson->topic->subject->color ?? '#6B46C1',
                'type'     => $p->lesson->content_type ?? 'video',
                'duration' => ($p->lesson->duration_minutes ?? 0) . ' min',
                'progress' => $passed ? 100 : ($p->progress_percentage ?? 0),
                'passed'   => $passed,
                'url'      => route('student.lessons.show', $p->lesson->id),
            ];
        })->values()->all();
    }

    /**
     * Map a collection of Lesson records (no progress yet) into the same flat
     * array shape used by mapLessonsForFrontend(), for the "todo" tab.
     */
    private function mapTodoLessonsForFrontend($lessons): array
    {
        return $lessons->map(function ($l) {
            return [
                'id'       => $l->id,
                'title'    => $l->title,
                'subject'  => $l->topic->subject->name ?? 'General',
                'icon'     => $l->topic->subject->icon ?? 'fa-book',
                'color'    => $l->topic->subject->color ?? '#6B46C1',
                'type'     => $l->content_type ?? 'video',
                'duration' => ($l->duration_minutes ?? 0) . ' min',
                'progress' => 0,
                'passed'   => false,
                'url'      => route('student.lessons.show', $l->id),
            ];
        })->values()->all();
    }

    public function user_terms_and_conditions(Request $request)
    {
        return view('users.terms-and-conditions');
    }

    public function login(Request $request)
    {
        return view('users.login');
    }

    public function studentLessonList()
    {
        // $teacherId = session('LoggedTeacher');

        $teacherId = 2;
        
        // Get all lessons taught by this teacher with proper relationships
        $lessons = Lesson::with([
            'topic' => function ($query) {
                $query->with([
                    'subject',
                    'class' => function ($q) {
                        $q->with(['level', 'academicYear']);
                    }
                ]);
            },
            'resources',
            'teacher'
        ])
            ->where('teacher_id', $teacherId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Group lessons by Class -> Subject -> Topic
        $groupedLessons = [];
        foreach ($lessons as $lesson) {
            if (!$lesson->topic || !$lesson->topic->class || !$lesson->topic->subject) {
                continue;
            }

            $className = $lesson->topic->class->name;
            $subjectName = $lesson->topic->subject->name;
            $topicName = $lesson->topic->title;

            if (!isset($groupedLessons[$className])) {
                $groupedLessons[$className] = [
                    'class_id' => $lesson->topic->class->id,
                    'level' => $lesson->topic->class->level->name ?? '',
                    'subjects' => []
                ];
            }

            if (!isset($groupedLessons[$className]['subjects'][$subjectName])) {
                $groupedLessons[$className]['subjects'][$subjectName] = [
                    'subject_id' => $lesson->topic->subject->id,
                    'subject_code' => $lesson->topic->subject->code ?? '',
                    'topics' => []
                ];
            }

            if (!isset($groupedLessons[$className]['subjects'][$subjectName]['topics'][$topicName])) {
                $groupedLessons[$className]['subjects'][$subjectName]['topics'][$topicName] = [
                    'topic_id' => $lesson->topic->id,
                    'topic_description' => $lesson->topic->description,
                    'lessons' => []
                ];
            }

            $groupedLessons[$className]['subjects'][$subjectName]['topics'][$topicName]['lessons'][] = $lesson;
        }

        // Get statistics
        $totalLessons = $lessons->count();
        $publishedLessons = $lessons->where('status', 'published')->count();
        $draftLessons = $lessons->where('status', 'draft')->count();

        // Get recent lessons (last 5)
        $recentLessons = $lessons->take(5);

        return view('Student.student-lesson-lists', compact('groupedLessons', 'totalLessons', 'publishedLessons', 'draftLessons', 'recentLessons'));
    }
}