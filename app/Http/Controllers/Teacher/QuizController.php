<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Academic\Exam;
use App\Models\Academic\Question;
use App\Models\Academic\Lesson;
use App\Models\Academic\ClassModel;
use App\Models\Academic\Subject;
use App\Models\Academic\Topic;
// use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class QuizController extends Controller
{
    /**
     * Show quiz management index
     */
    public function index()
    {
        $teacherId = Session('LoggedTeacher');
        
        // Get lesson quizzes
        $lessonQuizzes = Exam::where('teacher_id', $teacherId)
            ->where('exam_type', 'quiz')
            ->whereNotNull('lesson_id')
            ->with(['lesson', 'class', 'subject'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get class quizzes (general quizzes)
        $classQuizzes = Exam::where('teacher_id', $teacherId)
            ->where('exam_type', 'quiz')
            ->whereNull('lesson_id')
            ->with(['class', 'subject'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get teacher's classes for creating new quizzes
        $classes = ClassModel::whereHas('subjects', function($query) use ($teacherId) {
            $query->where('class_subjects.teacher_id', $teacherId);
        })->with(['level', 'subjects'])->get();
        
        // Get all subjects
        $subjects = Subject::where('status', 'active')->get();
        
        return view('Teacher.quizzes.index', compact('lessonQuizzes', 'classQuizzes', 'classes', 'subjects'));
    }
    
    /**
     * Show form to create a new quiz
     */
/**
 * Show form to create a new quiz
 */
/**
 * Show form to create a new quiz
 */
public function create(Request $request)
{
    $teacherId = Session('LoggedTeacher');
    $type = $request->type; // 'lesson' or 'class'
    $lessonId = $request->lesson_id;
    
    $lesson = null;
    if ($lessonId) {
        $lesson = Lesson::with(['topic.class', 'topic.subject'])->findOrFail($lessonId);
    }
    
    // Get classes assigned to this teacher with their subjects
    $classes = ClassModel::whereHas('subjects', function($query) use ($teacherId) {
        $query->where('class_subjects.teacher_id', $teacherId);
    })
    ->with(['level', 'subjects' => function($query) use ($teacherId) {
        $query->where('class_subjects.teacher_id', $teacherId);
    }])
    ->where('status', 'active')
    ->orderBy('name')
    ->get();

    
    $subjects = Subject::where('status', 'active')->orderBy('name')->get();
    
    return view('Teacher.quizzes.create', compact('type', 'lesson', 'classes', 'subjects'));
}
    
    /**
     * Store a new quiz
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'lesson_id' => 'nullable|exists:lessons,id',
            'total_marks' => 'required|integer|min:1',
            'pass_mark' => 'required|integer|min:0|max:100',
            'duration_minutes' => 'nullable|integer|min:1|max:180',
            'available_from' => 'nullable|date',
            'available_to' => 'nullable|date|after:available_from',
            'instructions' => 'nullable|string',
            'max_attempts' => 'nullable|integer|min:1|max:10',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $exam = Exam::create([
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'lesson_id' => $request->lesson_id,
            'topic_id' => $request->topic_id ?? null,
            'teacher_id' => Session('LoggedTeacher'),
            'title' => $request->title,
            'exam_type' => 'quiz',
            'total_marks' => $request->total_marks,
            'pass_mark' => $request->pass_mark,
            'duration_minutes' => $request->duration_minutes,
            'available_from' => $request->available_from,
            'available_to' => $request->available_to,
            'instructions' => $request->instructions,
            'allow_late_submission' => true,
            'shuffle_questions' => $request->shuffle_questions ?? false,
            'status' => 'draft',
            'max_attempts' => $request->max_attempts ?? 3,
        ]);
        
        // Add custom fields to exams table if not exists
        if (!Schema::hasColumn('exams', 'max_attempts')) {
            Schema::table('exams', function ($table) {
                $table->integer('max_attempts')->default(3)->after('shuffle_questions');
            });
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Quiz created successfully!',
            'exam_id' => $exam->id,
            'redirect' => route('teacher.quizzes.add-questions', $exam->id)
        ]);
    }
    
    /**
     * Show form to add questions to quiz
     */
    public function addQuestions($examId)
    {
        $exam = Exam::with(['class', 'subject', 'lesson'])->findOrFail($examId);
        
        if ($exam->teacher_id != Session('LoggedTeacher')) {
            abort(403);
        }
        
        $existingQuestions = $exam->questions()->orderBy('sort_order')->get();
        
        return view('Teacher.quizzes.add-questions', compact('exam', 'existingQuestions'));
    }
    
    /**
     * Save questions for quiz
     */
    public function saveQuestions(Request $request, $examId)
    {
        $exam = Exam::findOrFail($examId);
        
        $validator = Validator::make($request->all(), [
            'questions' => 'required|array|min:1',
            'questions.*.type' => 'required|in:mcq,true_false,short_answer,essay',
            'questions.*.question' => 'required|string',
            'questions.*.marks' => 'required|integer|min:1',
            'questions.*.options' => 'required_if:questions.*.type,mcq|nullable|array',
            'questions.*.answer' => 'required_if:questions.*.type,mcq,true_false|nullable|string',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Delete existing questions
        $exam->questions()->delete();
        
        // Save new questions
        foreach ($request->questions as $index => $qData) {
            Question::create([
                'exam_id' => $examId,
                'question_number' => $index + 1,
                'question' => $qData['question'],
                'question_arabic' => $qData['question_arabic'] ?? null,
                'type' => $qData['type'],
                'marks' => $qData['marks'],
                'options' => $qData['options'] ?? null,
                'answer' => $qData['answer'] ?? null,
                'explanation' => $qData['explanation'] ?? null,
                'sort_order' => $index,
            ]);
        }
        
        // Update exam status to published
        $exam->update(['status' => 'published']);
        
        return response()->json([
            'success' => true,
            'message' => 'Questions added successfully! Quiz is now published.',
            'redirect' => $exam->lesson_id ? route('teacher.lessons.show', $exam->lesson_id) : route('teacher.quizzes.index')
        ]);
    }
    
    /**
     * Edit quiz
     */
    public function edit($examId)
    {
        $exam = Exam::with(['questions', 'class', 'subject', 'lesson'])->findOrFail($examId);
        
        if ($exam->teacher_id != Session('LoggedTeacher')) {
            abort(403);
        }
        
        $classes = ClassModel::where('status', 'active')->get();
        $subjects = Subject::where('status', 'active')->get();
        
        return view('Teacher.quizzes.edit', compact('exam', 'classes', 'subjects'));
    }
    
    /**
     * Update quiz
     */
    public function update(Request $request, $examId)
    {
        $exam = Exam::findOrFail($examId);
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'total_marks' => 'required|integer|min:1',
            'pass_mark' => 'required|integer|min:0|max:100',
            'duration_minutes' => 'nullable|integer|min:1',
            'available_from' => 'nullable|date',
            'available_to' => 'nullable|date|after:available_from',
            'instructions' => 'nullable|string',
            'status' => 'required|in:draft,published,closed',
            'max_attempts' => 'nullable|integer|min:1|max:10',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $exam->update([
            'title' => $request->title,
            'total_marks' => $request->total_marks,
            'pass_mark' => $request->pass_mark,
            'duration_minutes' => $request->duration_minutes,
            'available_from' => $request->available_from,
            'available_to' => $request->available_to,
            'instructions' => $request->instructions,
            'shuffle_questions' => $request->shuffle_questions ?? false,
            'status' => $request->status,
            'max_attempts' => $request->max_attempts ?? 3,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Quiz updated successfully!',
            'redirect' => route('teacher.quizzes.index')
        ]);
    }
    
    /**
     * Delete quiz
     */
    public function destroy($examId)
    {
        $exam = Exam::findOrFail($examId);
        
        if ($exam->teacher_id != Session('LoggedTeacher')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        
        // Delete related questions and attempts
        $exam->questions()->delete();
        $exam->attempts()->delete();
        $exam->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Quiz deleted successfully!'
        ]);
    }
    
    /**
     * Get quiz statistics
     */
    public function statistics($examId)
    {
        $exam = Exam::with(['attempts' => function($q) {
            $q->with('student');
        }])->findOrFail($examId);
        
        $totalAttempts = $exam->attempts->count();
        $completedAttempts = $exam->attempts->where('status', 'graded')->count();
        $passedAttempts = $exam->attempts->where('is_passed', true)->count();
        $avgScore = $exam->attempts->avg('percentage') ?? 0;
        
        return view('Teacher.quizzes.statistics', compact('exam', 'totalAttempts', 'completedAttempts', 'passedAttempts', 'avgScore'));
    }
}