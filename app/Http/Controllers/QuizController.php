<?php
namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use App\Models\UserQuizAnswer;
use App\Models\UserQuizAttempt;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class QuizController extends Controller
{
    public function createQuiz()
    {
        $courses = Course::all();
        return view('Quiz.create-quiz', compact('courses'));
    }

    public function storeQuiz(Request $request)
    {

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id'   => 'required|exists:courses,id',
            'module_id'   => 'nullable|exists:modules,id',
            'lesson_id'   => 'nullable|exists:lessons,id',
        ]);

        $quiz = new Quiz();

        $quiz->title       = $validated['title'];
        $quiz->description = $validated['description'];
        $quiz->course_id   = $request->input('course_id');

        if ($request->quiz_category == 'Lesson') {
            $quiz->type_id = $validated['lesson_id'];
            $quiz->type    = Lesson::class;
        } elseif ($request->quiz_category == 'Module') {
            $quiz->type_id = $validated['module_id'];
            $quiz->type    = Module::class;
        } elseif ($request->quiz_category == 'Course') {
            $quiz->type_id = $validated['course_id'];
            $quiz->type    = Course::class;
        }

        $quiz->save();

        return redirect()->route('quizzes.create.quiz')->with('success', 'Quiz created successfully!');
    }

    public function createAssignment()
    {
        $courses = Course::all();
        return view('Assignment.create-assignment', compact('courses'));
    }

    public function storeAssignment(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
            'course_id'   => 'required|exists:courses,id',
            'module_id'   => 'nullable|exists:modules,id',
            'lesson_id'   => 'nullable|exists:lessons,id',
        ]);

        $assignment = new Assignment();

        $assignment->title        = $validated['title'];
        $assignment->description  = $validated['description'];
        $assignment->instructions = $request->input('instructions');
        $assignment->course_id    = $request->input('course_id');

        if ($request->quiz_category == 'Module') {
            $assignment->type_id = $validated['module_id'] ?? '';
            $assignment->type    = 'Module' ?? '';
        } elseif ($request->quiz_category == 'Lesson') {
            $assignment->type_id = $validated['lesson_id'] ?? '';
            $assignment->type    = 'Lesson' ?? '';
        } elseif ($request->quiz_category == 'Course') {
            $assignment->type_id = $validated['course_id'] ?? '';
            $assignment->type    = 'Course' ?? '';
        }

        $assignment->save();

        return redirect()->route('create.assignments')->with('success', 'Assignment created successfully!');
    }

    public function getCourseModules($course_id)
    {
        $modules = Module::where('course_id', $course_id)->get(['id', 'title']);
        return response()->json($modules);
    }

    public function getModuleLesson($module_id)
    {
        $lessons = Lesson::where('module_id', $module_id)->get(['id', 'title']);
        return response()->json($lessons);
    }

    public function allQuizzesAndAssignments()
    {
        $quizCount = Quiz::all()->count();

        return view('Dashboards.all-quizzes-and-assignments', compact(['quizCount']));
    }

    public function allQuizzes()
    {

        $quizzes = Quiz::orderBy('id', 'desc')->paginate(12);

        return view('Quiz.all-quizzes', compact(['quizzes']));
    }

    public function createQuestions($quizId)
    {

        $quiz = Quiz::findOrFail($quizId);
        return view('Quiz.create-question', compact(['quiz', 'quizId']));
    }

    public function storeQuestions(Request $request, $quizId)
    {
        foreach ($request->input('questions', []) as $data) {

            $question = new Question();

            $question->quiz_id       = $quizId;
            $question->question_text = Arr::get($data, 'question');
            $question->question_type = Arr::get($data, 'type');

            $question->options = Arr::get($data, 'type') === 'mcq'
            ? json_encode(Arr::get($data, 'options', []))
            : null;

            if (Arr::get($data, 'type') === 'short_answer') {
                $question->correct_answer = Arr::get($data, 'correct_answer_short_answer');
            } elseif (Arr::get($data, 'type') === 'true_false') {
                $question->correct_answer = Arr::get($data, 'correct_answer_boolean');
            } elseif (Arr::get($data, 'type') === 'mcq') {
                $question->correct_answer = Arr::get($data, 'correct_answer_mcqs');
            }

            $question->save();
        }

        return response()->json(['success' => true]);
    }

    public function showQuizQuestions($quizId)
    {
        $quiz = Quiz::with('questions')->findOrFail($quizId);
        return view('Quiz.show-questions', compact('quiz'));
    }

    public function showQuizForm($quizId)
    {
        $quiz = Quiz::with('questions')->find($quizId);
        $user = User::find(session('LoggedAdmin'));

        $latestResults = DB::table('user_quiz_attempts')
            ->where('quiz_id', $quizId)
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->first();

        $results = [];

        $latestAttempt = UserQuizAttempt::where('quiz_id', $quizId)
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        $answers = collect();
        if ($latestAttempt) {
            $answers = UserQuizAnswer::where('user_quiz_attempt_id', $latestAttempt->id)->get();
        }

        $results = $quiz->questions->map(function ($question) use ($answers) {
            $response = $answers->firstWhere('question_id', $question->id);

            return [
                'question'       => $question->question_text,
                'user_answer'    => $response?->answer ?? null,
                'is_correct'     => $response?->is_correct ?? false,
                'has_answer'     => ! is_null($response),
                'correct_answer' => $question->correct_answer,
            ];
        });

        $hasSubmission = UserQuizAttempt::where('user_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->whereHas('answers')
            ->exists();

        $score = $results->filter(function ($result) {
            return $result['is_correct'];
        })->count();

        $total = $quiz->questions->count();

        return view('Quiz.on-take', compact(['quiz', 'results', 'answers', 'hasSubmission', 'score', 'total']));

    }

    public function submitQuiz(Request $request, Quiz $quiz)
    {
        $submittedAnswers = $request->input('answers', []);
        $questions        = $quiz->questions;

        $score   = 0;
        $total   = $questions->count();
        $results = [];

        if ($questions->isEmpty()) {
            return redirect()->back()->with('error', 'No questions were found in this quiz.');
        }

        $user = User::find(session('LoggedAdmin'));

        $userQuizAttempt = UserQuizAttempt::create([
            'user_id'      => $user->id,
            'quiz_id'      => $quiz->id,
            'score'        => 0,
            'completed_at' => now(),
        ]);

        foreach ($questions as $question) {
            $userAnswer    = isset($submittedAnswers[$question->id]) ? trim($submittedAnswers[$question->id]) : null;
            $correctAnswer = trim($question->correct_answer);

            $isCorrect = false;

            if ($question->question_type === 'short_answer') {
                $isCorrect = strtolower($userAnswer) === strtolower($correctAnswer);
            } else {
                $isCorrect = $userAnswer === $correctAnswer;
            }

            if ($isCorrect) {
                $score++;
            }

            $userQuizAttempt->answers()->create([
                'question_id' => $question->id,
                'answer'      => $userAnswer,
                'is_correct'  => $isCorrect,
            ]);

            $results[] = [
                'question'       => $question->question_text,
                'user_answer'    => $userAnswer,
                'correct_answer' => $correctAnswer,
                'is_correct'     => $isCorrect,
            ];
        }

        $userQuizAttempt->update(['score' => $score]);

        $lastAttempt = $user->quizzes()
            ->where('quiz_id', $quiz->id)
            ->orderByDesc('pivot_attempt_number')
            ->first();

        $attemptNumber = $lastAttempt ? $lastAttempt->pivot->attempt_number + 1 : 1;

        $user->quizzes()->attach($quiz->id, [
            'score'          => $score,
            'total'          => $total,
            'attempt_number' => $attemptNumber,
            'completed_at'   => now(),
        ]);

        return view('Quiz.on-take-result', [
            'quiz'          => $quiz,
            'score'         => $score,
            'total'         => $total,
            'results'       => $results,
            'attemptNumber' => $attemptNumber,
        ]);
    }

    public function attempts(Quiz $quiz)
    {

        $user = User::find(Session('LoggedAdmin'));

        $attempts = $user->quizzes()
            ->where('quiz_id', $quiz->id)
            ->orderByDesc('pivot_attempt_number')
            ->get();

        return view('quizzes.attempts', compact('quiz', 'attempts'));
    }

    public function deleteQuizQuestion($id)
    {

        $question = Question::findOrFail($id);
        $question->delete();

        return response()->json(['success' => 'Question deleted successfully']);
    }

    public function deleteQuiz($quizId)
    {

        $quizFound = Quiz::find($quizId);
        $quizFound->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Quiz has been deleted successfully!',
        ]);        
    }

}
