<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class LessonController extends Controller
{

    public function saveModuleLesson(Request $request)
    {

        $request->validate([
            'module_id'   => 'required|exists:modules,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'video_url'   => 'required|url',
        ]);

        $lesson = new Lesson();

        $lesson->module_id   = $request->module_id;
        $lesson->title       = $request->title;
        $lesson->description = $request->description;
        $lesson->video_url   = $request->video_url;

        $lesson->save();

        return redirect()->back()->with('success', 'Lesson added successfully.');
    }

    public function updateModuleLesson(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'video_url'   => 'required|url',
        ]);

        $lesson = Lesson::findOrFail($request->lesson_id);

        $lesson->title       = $request->title;
        $lesson->description = $request->description;
        $lesson->video_url   = $request->video_url;
        $lesson->save();

        return redirect()->back()->with('success', 'Lesson updated successfully.');
    }

    public function deleteModuleLesson($id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();

        return response()->json(['message' => 'Lesson deleted successfully.']);
    }

    public function showLesson($id)
    {

        $lesson = Lesson::with(['module.course'])->findOrFail($id);

        return view('Lessons.lesson-details', compact('lesson'));
    }

    public function moduleDetails($LessonId)
    {

        $lessonDetail = Lesson::find($LessonId);
        $moduleDetail = Module::find($lessonDetail->module_id);

        $course = Course::where('id', $moduleDetail->course_id)->first();

        return view('Courses.module-information', compact(['course']));
    }

    public function lessonComplete(Request $request, Lesson $lesson)
    {
        $user = User::find(session('LoggedAdmin'));

        $quiz = $lesson->quiz;

        if ($quiz) {

            $result = DB::table('quiz_user')
                ->where('quiz_id', $quiz->id)
                ->where('user_id', $user->id)
                ->orderByDesc('completed_at')
                ->first();

            if (! $result) {
                return response()->json([
                    'message' => 'You must attempt the quiz on this lesson before marking it complete.',
                ], 403);
            }

            $correct = $result->score ?? 0;
            $total   = $result->total ?? 0;

            if ($total == 0) {
                return response()->json([
                    'message' => 'Quiz data is invalid (total questions missing).',
                ], 400);
            }

            $percentage = ($correct / $total) * 100;

            if ($percentage < 50) {
                return response()->json([
                    'message' => 'You must score at least 50% in the lesson quiz before completing this lesson.',
                ], 403);
            }
        }

        if ($user && ! $user->completedLessons->contains($lesson->id)) {
            $user->completedLessons()->attach($lesson->id);
        }

        return response()->json(['message' => 'Lesson marked as completed']);
    }

}
