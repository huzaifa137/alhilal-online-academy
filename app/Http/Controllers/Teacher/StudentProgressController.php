<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Academic\Lesson;
use App\Models\Academic\StudentProgress;
use App\Models\User;
use App\Models\Academic\ClassStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentProgressController extends Controller
{
    /**
     * Mark a lesson as completed by a student
     */
    public function markCompleted(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lesson_id' => 'required|exists:lessons,id',
            'student_id' => 'required|exists:users,id',
            'time_spent' => 'nullable|integer',
            'score' => 'nullable|integer|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $progress = StudentProgress::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'lesson_id' => $request->lesson_id,
            ],
            [
                'status' => 'completed',
                'score' => $request->score,
                'time_spent_seconds' => $request->time_spent ?? 0,
                'completed_at' => now(),
                'started_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Lesson marked as completed!',
            'progress' => $progress
        ]);
    }

    /**
     * Update progress for a student (video/audio position, time spent)
     */
    public function updateProgress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lesson_id' => 'required|exists:lessons,id',
            'student_id' => 'required|exists:users,id',
            'last_position' => 'nullable|integer',
            'time_spent' => 'nullable|integer',
            'status' => 'nullable|in:not_started,in_progress,completed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $progress = StudentProgress::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'lesson_id' => $request->lesson_id,
            ],
            [
                'status' => $request->status ?? 'in_progress',
                'last_position_seconds' => $request->last_position ?? 0,
                'time_spent_seconds' => $request->time_spent ?? 0,
                'started_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Progress updated!',
            'progress' => $progress
        ]);
    }

    /**
     * Get progress for a specific lesson and student
     */
    public function getProgress($lessonId, $studentId)
    {
        $progress = StudentProgress::where('lesson_id', $lessonId)
            ->where('student_id', $studentId)
            ->first();

        return response()->json([
            'success' => true,
            'progress' => $progress ?? [
                'status' => 'not_started',
                'time_spent_seconds' => 0,
                'last_position_seconds' => 0,
                'score' => null
            ]
        ]);
    }

    /**
     * Get all students and their progress for a lesson
     */
    public function getLessonProgress($lessonId)
    {
        try {
            // Load lesson with its topic and class
            $lesson = Lesson::with(['topic', 'topic.class'])->find($lessonId);
            
            if (!$lesson) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lesson not found'
                ], 404);
            }
            
            // Check if lesson has a topic with class
            if (!$lesson->topic || !$lesson->topic->class) {
                return response()->json([
                    'success' => true,
                    'students' => [],
                    'total_students' => 0,
                    'completed_count' => 0,
                    'message' => 'No class associated with this lesson'
                ]);
            }
            
            $classId = $lesson->topic->class_id;
            
            // Get all students enrolled in this class using ClassStudent model
            $enrolledStudents = ClassStudent::where('class_id', $classId)
                ->with('student')
                ->get();
            
            if ($enrolledStudents->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'students' => [],
                    'total_students' => 0,
                    'completed_count' => 0,
                    'message' => 'No students enrolled in this class'
                ]);
            }
            
            // Get progress for each student
            $progressData = [];
            $completedCount = 0;
            
            foreach ($enrolledStudents as $enrollment) {
                $student = $enrollment->student;
                
                if (!$student) {
                    continue;
                }
                
                $progress = StudentProgress::where('lesson_id', $lessonId)
                    ->where('student_id', $student->id)
                    ->first();
                
                $progressStatus = $progress ? $progress->status : 'not_started';
                
                if ($progressStatus === 'completed') {
                    $completedCount++;
                }
                
                $progressData[] = [
                    'student' => [
                        'id' => $student->id,
                        'name' => $student->name ?? $student->first_name . ' ' . ($student->last_name ?? ''),
                        'email' => $student->email ?? ''
                    ],
                    'progress' => $progress ? [
                        'status' => $progress->status,
                        'time_spent_seconds' => $progress->time_spent_seconds ?? 0,
                        'completed_at' => $progress->completed_at,
                        'score' => $progress->score
                    ] : [
                        'status' => 'not_started',
                        'time_spent_seconds' => 0,
                        'completed_at' => null,
                        'score' => null
                    ]
                ];
            }
            
            return response()->json([
                'success' => true,
                'students' => $progressData,
                'total_students' => count($progressData),
                'completed_count' => $completedCount
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching student progress: ' . $e->getMessage()
            ], 500);
        }
    }
}