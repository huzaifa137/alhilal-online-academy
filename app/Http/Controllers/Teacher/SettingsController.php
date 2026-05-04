<?php
// app/Http/Controllers/Teacher/SettingsController.php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Academic\Topic;
use App\Models\Academic\Section;
use App\Models\Academic\Level;
use App\Models\Academic\ClassModel;
use App\Models\Academic\Subject;
use App\Models\Academic\AcademicYear;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function index()
    {
        $stats = [
            'sections' => Section::count(),
            'levels' => Level::count(),
            'classes' => ClassModel::count(),
            'subjects' => Subject::count(),
            'topics' => Topic::count(),
        ];

        return view('Teacher.settings.index', compact('stats'));
    }

    // Sections Management
    public function getSections()
    {
        $sections = Section::orderBy('sort_order')->get();
        return response()->json($sections);
    }

    public function storeSection(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:sections',
            'description' => 'nullable|string',
            'sort_order' => 'integer',
            'status' => 'required|in:active,inactive'
        ]);

        $section = Section::create($request->all());
        return response()->json(['success' => true, 'section' => $section, 'message' => 'Section created successfully']);
    }

    public function updateSection(Request $request, Section $section)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:sections,code,' . $section->id,
            'description' => 'nullable|string',
            'sort_order' => 'integer',
            'status' => 'required|in:active,inactive'
        ]);

        $section->update($request->all());
        return response()->json(['success' => true, 'section' => $section, 'message' => 'Section updated successfully']);
    }

    public function destroySection(Section $section)
    {
        // Check if has related levels
        if ($section->levels()->count() > 0) {
            return response()->json(['success' => false, 'message' => 'Cannot delete section with associated levels'], 400);
        }

        $section->delete();
        return response()->json(['success' => true, 'message' => 'Section deleted successfully']);
    }

    // Levels Management
    public function getLevels()
    {
        $levels = Level::with('section')->orderBy('id')->get();
        return response()->json($levels);
    }

    public function storeLevel(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:levels',
            'description' => 'nullable|string',
            'sort_order' => 'integer',
            'status' => 'required|in:active,inactive'
        ]);

        $level = Level::create($request->all());
        $level->load('section');
        return response()->json(['success' => true, 'level' => $level, 'message' => 'Level created successfully']);
    }

    public function updateLevel(Request $request, Level $level)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:levels,code,' . $level->id,
            'description' => 'nullable|string',
            'sort_order' => 'integer',
            'status' => 'required|in:active,inactive'
        ]);

        $level->update($request->all());
        $level->load('section');
        return response()->json(['success' => true, 'level' => $level, 'message' => 'Level updated successfully']);
    }

    public function destroyLevel(Level $level)
    {
        // Check if has related classes
        if ($level->classes()->count() > 0) {
            return response()->json(['success' => false, 'message' => 'Cannot delete level with associated classes'], 400);
        }

        $level->delete();
        return response()->json(['success' => true, 'message' => 'Level deleted successfully']);
    }

    // Classes Management
    public function getClasses()
    {
        $classes = ClassModel::with(['level', 'level.section'])->orderBy('id', 'asc')->get();
        return response()->json($classes);
    }

    public function storeClass(Request $request)
    {
        // 1. Get active academic year
        $activeYear = AcademicYear::where('is_current', 1)->first();

        if (!$activeYear) {
            return response()->json([
                'success' => false,
                'message' => 'No active academic year set. Please activate an academic year first.'
            ], 422);
        }

        // 2. Validate request
        $validator = Validator::make($request->all(), [
            'level_id' => 'required|exists:levels,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:classes',
            'capacity' => 'nullable|integer',
            'room_number' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // 3. Inject academic year automatically
        $data = $validator->validated();
        $data['academic_year_id'] = $activeYear->id;

        // 4. Create class
        $class = ClassModel::create($data);
        $class->load(['level', 'level.section']);

        return response()->json([
            'success' => true,
            'class' => $class,
            'message' => 'Class created successfully'
        ]);
    }

    public function updateClass(Request $request, ClassModel $class)
    {
        $request->validate([
            'level_id' => 'required|exists:levels,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:classes,code,' . $class->id,
            'capacity' => 'nullable|integer',
            'room_number' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        $class->update($request->all());
        $class->load(['level', 'level.section']);
        return response()->json(['success' => true, 'class' => $class, 'message' => 'Class updated successfully']);
    }

    public function destroyClass(ClassModel $class)
    {
        // Check if has related topics
        if ($class->topics()->count() > 0) {
            return response()->json(['success' => false, 'message' => 'Cannot delete class with associated topics'], 400);
        }

        $class->delete();
        return response()->json(['success' => true, 'message' => 'Class deleted successfully']);
    }

    // Subjects Management
    public function getSubjects()
    {
        $subjects = Subject::orderBy('sort_order')->get();
        return response()->json($subjects);
    }

    public function storeSubject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section_id' => 'nullable|exists:sections,id',
            'name' => 'required|string|max:255',
            'name_arabic' => 'nullable|string|max:255',
            'code' => 'required|string|max:20|unique:subjects,code',
            'category' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:active,inactive',
        ]);

        // ❌ Validation failed
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // ✅ Create subject safely
        $subject = Subject::create($validator->validated());

        $subject->load('section');

        return response()->json([
            'success' => true,
            'subject' => $subject,
            'message' => 'Subject created successfully'
        ]);
    }


    public function updateSubject(Request $request, Subject $subject)
    {
        $validator = Validator::make($request->all(), [
            'section_id' => 'nullable|exists:sections,id',
            'name' => 'required|string|max:255',
            'name_arabic' => 'nullable|string|max:255',
            'code' => 'required|string|max:20|unique:subjects,code,' . $subject->id,
            'category' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:active,inactive',
        ]);

        // ❌ Validation failed
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // ✅ Update subject safely
        $subject->update($validator->validated());

        $subject->load('section');

        return response()->json([
            'success' => true,
            'subject' => $subject,
            'message' => 'Subject updated successfully'
        ]);
    }

    public function destroySubject(Subject $subject)
    {
        // Check if has related topics
        if ($subject->topics()->count() > 0) {
            return response()->json(['success' => false, 'message' => 'Cannot delete subject with associated topics'], 400);
        }

        $subject->delete();
        return response()->json(['success' => true, 'message' => 'Subject deleted successfully']);
    }

    // Topics Management
public function getTopics()
{
    $topics = Topic::with(['subject', 'subject.section', 'class', 'class.level', 'class.level.section'])
        ->orderBy('order_no')
        ->get();
    return response()->json($topics);
}

    public function storeTopic(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'title' => 'required|string|max:255',
            'title_arabic' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'learning_objectives' => 'nullable|string',
            'order_no' => 'integer',
            'status' => 'required|in:published,draft,archived'
        ]);

        $topic = Topic::create($request->all());
        $topic->load(['subject', 'class', 'class.level', 'class.level.section']);
        return response()->json(['success' => true, 'topic' => $topic, 'message' => 'Topic created successfully']);
    }

    public function updateTopic(Request $request, Topic $topic)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'title' => 'required|string|max:255',
            'title_arabic' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'learning_objectives' => 'nullable|string',
            'order_no' => 'integer',
            'status' => 'required|in:published,draft,archived'
        ]);

        $topic->update($request->all());
        $topic->load(['subject', 'class', 'class.level', 'class.level.section']);
        return response()->json(['success' => true, 'topic' => $topic, 'message' => 'Topic updated successfully']);
    }

    public function destroyTopic(Topic $topic)
    {
        // Check if has related lessons
        if ($topic->lessons()->count() > 0) {
            return response()->json(['success' => false, 'message' => 'Cannot delete topic with associated lessons'], 400);
        }

        $topic->delete();
        return response()->json(['success' => true, 'message' => 'Topic deleted successfully']);
    }
}