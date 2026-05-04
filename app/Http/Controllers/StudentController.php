<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Academic\Lesson;
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
        return view('Student.dashboard');
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
