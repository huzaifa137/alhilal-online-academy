<?php
namespace App\Http\Controllers;


use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{

    public function addCourseModule()
    {

        $allCourses = Course::orderBy('id', 'desc')->paginate(12);

        return view('Courses.add-course-module', compact(['allCourses']));
    }

    public function moduleInformation($courseId)
    {

        $course = Course::where('id', $courseId)->first();

        return view('Courses.module-information', compact(['course']));
    }

    public function saveCourseModule(Request $request)
    {

        $validated = $request->validate([
            'course_id'   => 'required|exists:courses,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $module = new Module();

        $module->course_id   = $validated['course_id'];
        $module->title       = $validated['title'];
        $module->description = $validated['description'] ?? '';
        $module->save();

        return back()->with('success', 'Module added successfully!');
    }

    public function updateModule(Request $request, $id)
    {

        $module = Module::findOrFail($id);

        $module->title       = $request->input('title');
        $module->description = $request->input('description');
        $module->save();

        return redirect()->back()->with('success', 'Module updated successfully.');
    }

    public function deleteModuleInformation($id)
    {
        $module = Module::findOrFail($id);
        $module->delete();

        return response()->json([
            'message' => 'Module deleted successfully.',
        ]);
    }

  
}
