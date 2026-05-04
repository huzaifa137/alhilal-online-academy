<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Academic\Topic;
use App\Models\Academic\Lesson;
use App\Models\Academic\LessonResource;
use App\Models\Academic\ClassModel;
use App\Models\Academic\ClassEnrollment;
use App\Models\User;
use App\Models\Academic\Subject;
use Illuminate\Http\Request;
use App\Models\Academic\ClassStudent;
use App\Models\Academic\StudentProgress;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;



class TeacherLessonController extends Controller
{

    public function getTeacherClasses()
    {
        $teacherId = Session('LoggedTeacher');

        $classes = ClassModel::whereHas('subjects', function ($query) use ($teacherId) {
            $query->where('class_subjects.teacher_id', $teacherId);
        })
            ->with([
                'level',
                'subjects' => function ($query) use ($teacherId) {
                    $query->where('class_subjects.teacher_id', $teacherId);
                }
            ])
            ->where('status', 'active')
            ->get();

        return response()->json($classes);
    }

    /**
     * Get topics for a specific class and subject
     */
    public function getTopics(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $topics = Topic::where('class_id', $request->class_id)
            ->where('subject_id', $request->subject_id)
            ->where('status', 'published')
            ->orderBy('order_no')
            ->get();

        return response()->json($topics);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic_id' => 'required|exists:topics,id',
            'title' => 'required|string|max:255',
            'title_arabic' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'lesson_type' => 'required|in:video,audio,pdf,live,text,mixed',
            'duration' => 'nullable|integer|min:1',
            'lesson_order' => 'nullable|integer',
            'status' => 'required|in:draft,published',
            'resources' => 'nullable|array',
            'resources.*.file' => 'nullable|file|max:51200', // 50MB max
            'resources.*.type' => 'required_with:resources.*.file|in:video,audio,pdf,document,image',
            'resources.*.title' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Create lesson
        $lesson = Lesson::create([
            'topic_id' => $request->topic_id,
            'teacher_id' => Session('LoggedTeacher'),
            'title' => $request->title,
            'title_arabic' => $request->title_arabic,
            'description' => $request->description,
            'notes' => $request->notes,
            'lesson_type' => $request->lesson_type,
            'video_url' => $request->video_url,
            'audio_url' => $request->audio_url,
            'duration' => $request->duration,
            'lesson_order' => $request->lesson_order ?? (Lesson::where('topic_id', $request->topic_id)->max('lesson_order') + 1),
            'status' => $request->status,
            'lesson_amount' => $request->lesson_amount,
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        // Handle file uploads as resources
        if ($request->hasFile('resources')) {
            foreach ($request->file('resources') as $index => $fileData) {
                if (isset($fileData['file']) && $fileData['file']->isValid()) {
                    $file = $fileData['file'];
                    $path = $file->store('lessons/' . $lesson->id, 'public');

                    LessonResource::create([
                        'lesson_id' => $lesson->id,
                        'type' => $fileData['type'] ?? $this->getFileType($file),
                        'title' => $fileData['title'] ?? $file->getClientOriginalName(),
                        'file_path' => $path,
                        'file_size' => $file->getSize(),
                        'sort_order' => $index,
                        'is_required' => true,
                    ]);
                }
            }
        }

        // Handle single file upload (from the old modal)
        if ($request->hasFile('lesson_file')) {
            $file = $request->file('lesson_file');
            $path = $file->store('lessons/' . $lesson->id, 'public');

            $type = match ($file->getMimeType()) {
                'video/mp4', 'video/webm', 'video/ogg' => 'video',
                'audio/mpeg', 'audio/wav', 'audio/ogg' => 'audio',
                'application/pdf' => 'pdf',
                default => 'document'
            };

            LessonResource::create([
                'lesson_id' => $lesson->id,
                'type' => $type,
                'title' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'sort_order' => 0,
                'is_required' => true,
            ]);

            // Update lesson with PDF path if applicable
            if ($type === 'pdf') {
                $lesson->update(['pdf_file' => $path]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Lesson created successfully!',
            'lesson' => $lesson->load('resources'),
            'redirect' => route('teacher.lessons.show', $lesson)
        ]);
    }

    /**
     * Get file type from mime type
     */
    private function getFileType($file)
    {
        $mime = $file->getMimeType();

        if (str_contains($mime, 'video'))
            return 'video';
        if (str_contains($mime, 'audio'))
            return 'audio';
        if (str_contains($mime, 'pdf'))
            return 'pdf';
        if (str_contains($mime, 'image'))
            return 'image';

        return 'document';
    }


    public function createLesson()
    {
        $teacherId = Session('LoggedTeacher');

        // Get teacher's assigned classes with subjects for the form
        $assignedClasses = ClassModel::whereHas('subjects', function ($query) use ($teacherId) {
            $query->where('class_subjects.teacher_id', $teacherId);
        })
            ->with([
                'level',
                'academicYear',
                'subjects' => function ($query) use ($teacherId) {
                    $query->where('class_subjects.teacher_id', $teacherId);
                }
            ])
            ->where('status', 'active')
            ->whereHas('academicYear', function ($query) {
                $query->where('is_current', true);
            })
            ->get();

        return view('Teacher.lessons.create', compact('assignedClasses'));
    }

    public function index()
    {
        $teacherId = Session('LoggedTeacher');

        $lessons = Lesson::where('teacher_id', $teacherId)
            ->with(['topic.subject', 'topic.class.level'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('Teacher.lessons.index', compact('lessons'));
    }
    public function showLesson(Lesson $lesson)
    {
        $teacherId = session('LoggedTeacher');

        // Authorize - check if the logged-in teacher owns this lesson or is admin
        // if ($lesson->teacher_id != $teacherId && session('role') !== 'admin') {
        //     abort(403, 'Unauthorized access.');
        // }

        $lesson->load([
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
        ]);

        $prevLesson = Lesson::where('topic_id', $lesson->topic_id)
            ->where('lesson_order', '<', $lesson->lesson_order)
            ->orderBy('lesson_order', 'desc')
            ->first();

        $nextLesson = Lesson::where('topic_id', $lesson->topic_id)
            ->where('lesson_order', '>', $lesson->lesson_order)
            ->orderBy('lesson_order', 'asc')
            ->first();

        // Get total students in the class
        $totalStudents = ClassStudent::where('class_id', $lesson->topic->class_id)->count();

        // Get completed count from student_progress table
        $completedCount = StudentProgress::where('lesson_id', $lesson->id)
            ->where('status', 'completed')
            ->count();

        // Get recent completions
        $recentCompletions = StudentProgress::where('lesson_id', $lesson->id)
            ->where('status', 'completed')
            ->with('student')
            ->orderBy('completed_at', 'desc')
            ->limit(5)
            ->get();

        return view('Teacher.lessons.show', compact('lesson', 'prevLesson', 'nextLesson', 'totalStudents', 'completedCount', 'recentCompletions'));
    }


    public function storeTopic(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'title_arabic' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Verify teacher is assigned to this class-subject
        $isAssigned = ClassModel::find($request->class_id)
            ->subjects()
            ->where('subjects.id', $request->subject_id)
            ->where('class_subjects.teacher_id', auth()->id())
            ->exists();

        if (!$isAssigned) {
            return response()->json([
                'success' => false,
                'message' => 'You are not assigned to teach this subject.'
            ], 403);
        }

        // Get next order number
        $maxOrder = Topic::where('class_id', $request->class_id)
            ->where('subject_id', $request->subject_id)
            ->max('order_no') ?? 0;

        $topic = Topic::create([
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'title_arabic' => $request->title_arabic,
            'description' => $request->description,
            'order_no' => $maxOrder + 1,
            'status' => 'published',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Topic created successfully!',
            'topic' => $topic
        ]);
    }

    public function lessonList()
    {        
        $teacherId = session('LoggedTeacher');
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

        return view('Teacher.lessons.lesson-lists', compact('groupedLessons', 'totalLessons', 'publishedLessons', 'draftLessons', 'recentLessons'));
    }

    public function processPayment(Request $request)
    {

        $validated = $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:mtn,airtel,card',
            'required_amount' => 'required|numeric|min:0'
        ]);

        $lesson = Lesson::findOrFail($validated['lesson_id']);

        // Check if amount is sufficient
        if ($validated['amount'] < $validated['required_amount']) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient amount. Required: UGX ' . number_format($validated['required_amount'])
            ]);
        }

        // Process payment logic here (integrate with your payment gateway)
        // For now, we'll just update the status

        $lesson->update([
            'lesson_payment_status' => 'Paid',
            'lesson_amount' => $validated['required_amount']
        ]);

        // You might want to store payment details in a payments table
        // Payment::create([...]);

        return response()->json([
            'success' => true,
            'message' => 'Payment processed successfully!'
        ]);
    }

    // Creating Lessons

    public function getAvailableClasses()
    {
        $teacherId = Session('LoggedTeacher');

        // Get all active classes with their levels and sections
        $classes = ClassModel::with(['level', 'level.section'])
            ->where('status', 'active')
            ->orderBy('level_id')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'classes' => $classes
        ]);
    }

    /**
     * Get subjects for a specific class based on the class's section
     */
    public function getAvailableClassSubjects($classId)
    {
        // Find the class with its level and section
        $class = ClassModel::with(['level', 'level.section'])->findOrFail($classId);

        // Get the section_id from the class's level
        $sectionId = $class->level->section_id;

        // Get all subjects that belong to this section
        $subjects = Subject::where('section_id', $sectionId)
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'subjects' => $subjects,
            'section_id' => $sectionId,
            'class' => $class
        ]);
    }

    public function getSubjectTopics($classId, $subjectId)
    {
        // Get topics that belong to both the class and subject
        $topics = Topic::where('class_id', $classId)
            ->where('subject_id', $subjectId)
            ->where('status', 'published')
            ->orderBy('order_no')
            ->get(['id', 'title', 'title_arabic', 'description']);

        return response()->json([
            'success' => true,
            'topics' => $topics,
            'class_id' => $classId,
            'subject_id' => $subjectId
        ]);
    }

    public function edit(Lesson $lesson)
    {
        // Verify ownership
        if ($lesson->teacher_id != Session('LoggedTeacher')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }

        $lesson->load(['topic', 'topic.subject', 'topic.class', 'resources']);

        // Get available classes for the teacher
        $classes = ClassModel::with('level.section')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        // Get subjects based on the lesson's class section
        $subjects = Subject::where('section_id', $lesson->topic->class->level->section_id)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        // Get topics for the lesson's class and subject
        $topics = Topic::where('class_id', $lesson->topic->class_id)
            ->where('subject_id', $lesson->topic->subject_id)
            ->where('status', 'published')
            ->orderBy('order_no')
            ->get();

        return response()->json([
            'success' => true,
            'lesson' => $lesson,
            'classes' => $classes,
            'subjects' => $subjects,
            'topics' => $topics,
            'current_class_id' => $lesson->topic->class_id,
            'current_subject_id' => $lesson->topic->subject_id,
            'current_topic_id' => $lesson->topic_id
        ]);
    }

    /**
     * Update lesson
     */
    public function update(Request $request, Lesson $lesson)
    {
        // Verify ownership
        if ($lesson->teacher_id != Session('LoggedTeacher')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'topic_id' => 'required|exists:topics,id',
            'title' => 'required|string|max:255',
            'title_arabic' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'lesson_type' => 'required|in:video,audio,pdf,live,text,mixed',
            'duration' => 'nullable|integer|min:1',
            'lesson_order' => 'nullable|integer',
            'status' => 'required|in:draft,published,archived',
            'lesson_amount' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Update lesson
        $lesson->update([
            'topic_id' => $request->topic_id,
            'title' => $request->title,
            'title_arabic' => $request->title_arabic,
            'description' => $request->description,
            'notes' => $request->notes,
            'lesson_type' => $request->lesson_type,
            'duration' => $request->duration,
            'lesson_order' => $request->lesson_order,
            'status' => $request->status,
            'lesson_amount' => $request->lesson_amount,
            'published_at' => $request->status === 'published' && $lesson->status !== 'published' ? now() : $lesson->published_at,
        ]);

        // Handle new file upload if present
        if ($request->hasFile('lesson_file')) {
            $file = $request->file('lesson_file');
            $path = $file->store('lessons/' . $lesson->id, 'public');

            $type = match ($file->getMimeType()) {
                'video/mp4', 'video/webm', 'video/ogg' => 'video',
                'audio/mpeg', 'audio/wav', 'audio/ogg' => 'audio',
                'application/pdf' => 'pdf',
                default => 'document'
            };

            $oldResource = $lesson->resources()->where('is_required', true)->first();
            if ($oldResource) {
                Storage::disk('public')->delete($oldResource->file_path);
                $oldResource->delete();
            }

            LessonResource::create([
                'lesson_id' => $lesson->id,
                'type' => $type,
                'title' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'sort_order' => 0,
                'is_required' => true,
            ]);

            if ($type === 'pdf') {
                $lesson->update(['pdf_file' => $path]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Lesson updated successfully!',
            'lesson' => $lesson->load('resources')
        ]);
    }

    /**
     * Publish lesson
     */
    public function publish(Lesson $lesson)
    {
        // Verify ownership
        if ($lesson->teacher_id != Session('LoggedTeacher')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }

        $lesson->update([
            'status' => 'published',
            'published_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lesson published successfully!',
            'status' => 'published'
        ]);
    }

    /**
     * Unpublish lesson
     */
    public function unpublish(Lesson $lesson)
    {
        // Verify ownership
        if ($lesson->teacher_id != Session('LoggedTeacher')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }

        $lesson->update([
            'status' => 'draft',
            'published_at' => null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lesson unpublished successfully!',
            'status' => 'draft'
        ]);
    }

    /**
     * Delete lesson
     */
    public function destroy(Lesson $lesson)
    {
        // Verify ownership
        if ($lesson->teacher_id != Session('LoggedTeacher')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }

        // Delete all resources files
        foreach ($lesson->resources as $resource) {
            Storage::disk('public')->delete($resource->file_path);
            $resource->delete();
        }

        // Delete lesson
        $lesson->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lesson deleted successfully!'
        ]);
    }

    public function enrollmentManagement()
    {
        $teacherId = Session('LoggedTeacher');

        // Get classes taught by this teacher
        $classes = ClassModel::with(['level', 'subjects'])
            ->where('status', 'active')
            ->get();

        // Get all students (user_role = 1)
        $students = User::where('user_role', 1)
            ->where('account_status', 10)
            ->orderBy('firstname')
            ->get(['id', 'firstname', 'lastname', 'email', 'reg_number']);

        // Get current enrollments
        $enrollments = ClassEnrollment::with(['class', 'student'])
            ->whereIn('class_id', $classes->pluck('id'))
            ->get();

        return view('Teacher.enrollments.index', compact('classes', 'students', 'enrollments'));
    }

    /**
     * Enroll a student in a class
     */
    public function enrollStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required|exists:classes,id',
            'student_id' => 'required|exists:users,id',
            'payment_status' => 'required|in:paid,partial,pending',
            'amount_paid' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if student is already enrolled
        $existing = ClassEnrollment::where('class_id', $request->class_id)
            ->where('student_id', $request->student_id)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Student is already enrolled in this class.'
            ], 400);
        }

        $enrollment = ClassEnrollment::create([
            'class_id' => $request->class_id,
            'student_id' => $request->student_id,
            'enrollment_date' => now(),
            'status' => 'active',
            'payment_status' => $request->payment_status,
            'amount_paid' => $request->amount_paid ?? 0,
        ]);

        $enrollment->load(['class', 'student']);

        return response()->json([
            'success' => true,
            'message' => 'Student enrolled successfully!',
            'enrollment' => $enrollment
        ]);
    }

    /**
     * Update enrollment status
     */
    public function updateEnrollment(Request $request, $enrollmentId)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:active,completed,suspended,expelled',
            'payment_status' => 'required|in:paid,partial,pending',
            'amount_paid' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $enrollment = ClassEnrollment::findOrFail($enrollmentId);
        $enrollment->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
            'amount_paid' => $request->amount_paid ?? $enrollment->amount_paid,
        ]);

        $enrollment->load(['class', 'student']);

        return response()->json([
            'success' => true,
            'message' => 'Enrollment updated successfully!',
            'enrollment' => $enrollment
        ]);
    }

    /**
     * Remove student from class
     */
    public function removeEnrollment($enrollmentId)
    {
        $enrollment = ClassEnrollment::findOrFail($enrollmentId);
        $enrollment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Student removed from class successfully!'
        ]);
    }

    /**
     * Get enrolled students for a class
     */
    public function getEnrolledStudents($classId)
    {
        $enrollments = ClassEnrollment::with('student')
            ->where('class_id', $classId)
            ->where('status', 'active')
            ->get();

        return response()->json([
            'success' => true,
            'students' => $enrollments
        ]);
    }
}