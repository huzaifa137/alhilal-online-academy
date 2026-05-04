<?php
// app/Http/Controllers/Teacher/ExamController.php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Academic\Exam;
use App\Models\Academic\Question;
use App\Models\Academic\ExamAttempt;
use App\Models\Academic\ExamResult;
use App\Models\Academic\Lesson;
use App\Models\Academic\ClassModel;
use App\Models\Academic\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class ExamController extends Controller
{

    public function createLessonQuiz($lessonId)
    {
        $lesson = Lesson::with(['topic.class', 'topic.subject'])->findOrFail($lessonId);
        
        // Verify teacher owns this lesson
        if ($lesson->teacher_id != Session('LoggedTeacher')) {
            abort(403, 'Unauthorized access.');
        }
        
        return view('Teacher.exams.create-quiz', compact('lesson'));
    }
    
    /**
     * Store exam/quiz
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'exam_type' => 'required|in:quiz,assignment,midterm,final',
            'lesson_id' => 'nullable|exists:lessons,id',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'total_marks' => 'required|integer|min:1',
            'pass_mark' => 'required|integer|min:0|max:100',
            'duration_minutes' => 'nullable|integer|min:1',
            'available_from' => 'nullable|date',
            'available_to' => 'nullable|date|after:available_from',
            'instructions' => 'nullable|string',
            'allow_retake' => 'boolean',
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
            'teacher_id' => Session('LoggedTeacher'),
            'title' => $request->title,
            'exam_type' => $request->exam_type,
            'total_marks' => $request->total_marks,
            'pass_mark' => $request->pass_mark,
            'duration_minutes' => $request->duration_minutes,
            'available_from' => $request->available_from,
            'available_to' => $request->available_to,
            'instructions' => $request->instructions,
            'allow_late_submission' => $request->allow_late_submission ?? false,
            'shuffle_questions' => $request->shuffle_questions ?? false,
            'status' => 'draft',
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Quiz created successfully!',
            'exam' => $exam,
            'redirect' => route('teacher.exams.add-questions', $exam->id)
        ]);
    }
    
    /**
     * Add questions to exam
     */
    public function addQuestions($examId)
    {
        $exam = Exam::with(['class', 'subject', 'lesson'])->findOrFail($examId);
        
        // Verify teacher owns this exam
        if ($exam->teacher_id != Session('LoggedTeacher')) {
            abort(403, 'Unauthorized access.');
        }
        
        $existingQuestions = $exam->questions;
        
        return view('Teacher.exams.add-questions', compact('exam', 'existingQuestions'));
    }
    
    /**
     * Store questions for an exam
     */
    public function storeQuestions(Request $request, $examId)
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
        
        // Delete existing questions if any
        $exam->questions()->delete();
        
        // Store new questions
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
            'redirect' => route('teacher.lessons.show', $exam->lesson_id)
        ]);
    }
    
    /**
     * Take quiz (for students)
     */
    public function takeQuiz($examId, $studentId = null)
    {
        $exam = Exam::with(['questions', 'class', 'subject'])->findOrFail($examId);
        
        // For teacher viewing/student preview
        
        return view('Teacher.exams.take-quiz', compact('exam'));
    }
    
    /**
     * Submit quiz answers
     */
    public function submitQuiz(Request $request, $examId)
    {
        $studentId = $request->student_id ?? Session('LoggedStudent');
        $exam = Exam::with('questions')->findOrFail($examId);
        
        $validator = Validator::make($request->all(), [
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.answer' => 'nullable|string',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Check if student has attempts left
        $attemptCount = ExamResult::where('exam_id', $examId)
            ->where('student_id', $studentId)
            ->count();
        
        $maxAttempts = $exam->max_attempts ?? 3;
        
        if ($attemptCount >= $maxAttempts) {
            return response()->json([
                'success' => false,
                'message' => "You have reached the maximum number of attempts ($maxAttempts)."
            ]);
        }
        
        // Create exam attempt
        $attempt = ExamAttempt::create([
            'exam_id' => $examId,
            'student_id' => $studentId,
            'started_at' => now(),
            'submitted_at' => now(),
            'time_spent_seconds' => $request->time_spent ?? 0,
            'status' => 'submitted',
        ]);
        
        // Calculate score
        $totalMarks = 0;
        $obtainedMarks = 0;
        $answersData = [];
        
        foreach ($request->answers as $answerData) {
            $question = $exam->questions->find($answerData['question_id']);
            if (!$question) continue;
            
            $totalMarks += $question->marks;
            $isCorrect = false;
            
            // Auto-grade MCQ and True/False questions
            if (in_array($question->type, ['mcq', 'true_false'])) {
                $isCorrect = $question->checkAnswer($answerData['answer']);
                if ($isCorrect) {
                    $obtainedMarks += $question->marks;
                }
            } else {
                // For essay/short answer, marks to be assigned by teacher
                $obtainedMarks += 0;
            }
            
            $answersData[] = [
                'question_id' => $question->id,
                'student_answer' => $answerData['answer'],
                'is_correct' => $isCorrect,
                'marks_obtained' => $isCorrect ? $question->marks : 0,
            ];
        }
        
        $percentage = $totalMarks > 0 ? ($obtainedMarks / $totalMarks) * 100 : 0;
        $isPassed = $percentage >= $exam->pass_mark;
        
        // Store results
        $result = ExamResult::create([
            'exam_id' => $examId,
            'student_id' => $studentId,
            'exam_attempt_id' => $attempt->id,
            'score' => $obtainedMarks,
            'percentage' => $percentage,
            'is_passed' => $isPassed,
            'attempt_number' => $attemptCount + 1,
            'answers' => $answersData,
            'started_at' => now(),
            'completed_at' => now(),
        ]);
        
        // Update attempt with results
        $attempt->update([
            'marks_obtained' => $obtainedMarks,
            'percentage' => $percentage,
            'is_passed' => $isPassed,
            'status' => 'graded',
            'graded_at' => now(),
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Quiz submitted successfully!',
            'result' => [
                'score' => $obtainedMarks,
                'total_marks' => $totalMarks,
                'percentage' => round($percentage, 2),
                'is_passed' => $isPassed,
                'attempt_number' => $attemptCount + 1,
                'max_attempts' => $maxAttempts,
            ]
        ]);
    }
    
    /**
     * Show quiz results
     */
    public function showResults($examId, $studentId = null)
    {
        $exam = Exam::with('questions')->findOrFail($examId);
        $studentId = $studentId ?? Session('LoggedStudent');
        
        $results = ExamResult::where('exam_id', $examId)
            ->where('student_id', $studentId)
            ->with('examAttempt')
            ->orderBy('attempt_number', 'desc')
            ->get();
        
        $bestResult = $results->where('is_passed', true)->first() ?? $results->first();
        
        return response()->json([
            'success' => true,
            'results' => $results,
            'best_result' => $bestResult,
            'exam' => $exam
        ]);
    }
    
    /**
     * Get quizzes for a lesson
     */
    public function getLessonQuizzes($lessonId)
    {
        $quizzes = Exam::where('lesson_id', $lessonId)
            ->where('exam_type', 'quiz')
            ->whereIn('status', ['published', 'closed'])
            ->with(['results' => function($q) {
                $q->where('student_id', Session('LoggedStudent'));
            }])
            ->get();
        
        return response()->json([
            'success' => true,
            'quizzes' => $quizzes
        ]);
    }
    
    /**
     * Get class quizzes (general quizzes for a class)
     */
    public function getClassQuizzes($classId)
    {
        $quizzes = Exam::where('class_id', $classId)
            ->where('exam_type', 'quiz')
            ->whereNull('lesson_id')
            ->whereIn('status', ['published', 'closed'])
            ->with(['results' => function($q) {
                $q->where('student_id', Session('LoggedStudent'));
            }])
            ->get();
        
        return response()->json([
            'success' => true,
            'quizzes' => $quizzes
        ]);
    }
}