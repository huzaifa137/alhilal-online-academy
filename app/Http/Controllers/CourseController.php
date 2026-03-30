<?php
namespace App\Http\Controllers;

use App\Models\contactUs;
use App\Models\Course;
use DB;
use Mail;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function addCourse()
    {

        $instructors = DB::table('master_datas')->where('md_master_code_id', config('constants.options.COURSE_INSTRUCTORS'))->get();
        $categories  = DB::table('master_datas')->where('md_master_code_id', config('constants.options.COURSE_CATEGORIES'))->get();
        $languages   = DB::table('master_datas')->where('md_master_code_id', config('constants.options.COURSE_LANGUAGES'))->get();

        return view('Courses.add-course', compact(['instructors', 'categories', 'languages']));
    }

    public function storeCourse(Request $request)
    {

        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'language'         => 'nullable|string',
            'difficulty'       => 'required|in:beginner,intermediate,advanced',
            'tags'             => 'nullable|json',
            'thumbnail'        => 'nullable|file|image',
            'category_id'      => 'required',
            'instructor_id'    => 'required',
            'is_published'     => 'required',
            'pricing_category' => 'required',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $course = Course::create([
            'title'            => $validated['title'],
            'description'      => $validated['description'],
            'language'         => $validated['language'],
            'difficulty'       => $validated['difficulty'],
            'tags'             => $validated['tags'] ? json_decode($validated['tags']) : [],
            'thumbnail'        => $thumbnailPath,
            'category_id'      => $validated['category_id'],
            'instructor_id'    => $validated['instructor_id'],
            'pricing_category' => $validated['pricing_category'],
            'is_published'     => 1,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Course has been successfully Added!',
        ]);
    }

    public function allCourses()
    {

        $allCourses = Course::orderBy('id', 'desc')->paginate(12);

        return view('Courses.all-courses', compact(['allCourses']));
    }

    public function courseInformation($id)
    {

        $course = Course::where('id', $id)->first();

        return view('Courses.course-information', compact(['course']));
    }

    public function editcourseInformation($id)
    {

        $course = Course::where('id', $id)->first();

        return view('Courses.edit-course-information', compact(['course']));
    }

    public function updateCourseInformation(Request $request)
    {

        $course = Course::find($request->course_id);

        if ($course) {

            $tags = $request->tags ? array_map('trim', explode(',', $request->tags)) : [];

            $course->update([
                'title'            => $request->title,
                'description'      => $request->description,
                'language'         => $request->language,
                'difficulty'       => $request->difficulty,
                'selling_price'    => $request->selling_price,
                'old_price'        => $request->old_price,
                'tags'             => $tags,
                'category_id'      => $request->category,
                'instructor_id'    => $request->instructor_id,
                'pricing_category' => $request->pricing_category,
            ]);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Course Information updated successfully !',
        ]);
    }

    public function deletecourseInformation($id)
    {
        $course = Course::findOrFail($id);

        $course->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Course deleted successfully!',
        ]);
    }

    public function contactUs()
    {
        $messages = contactUs::orderBy('created_at', 'desc')->get();

        return view('Courses.contact-us', compact(['messages']));
    }

    public function updateMessageResponse(Request $request, $messageId)
    {
        $message = contactUs::findOrFail($messageId);
        $user = user::findOrFail($message->student_id);

        $message->admin_response_message = $request->input('response');
        $message->admin_response_status  = 1;
        $message->admin_responded_by     = Session('LoggedAdmin');
        $message->save();
        
        $data = [
            'email'           => $message->student_email,
            'username'        => $user->username,
            'student_message' => $request->input('response'),
            'title'           => 'U.P STUDENT MESSAGE FROM CONTACT US',
            'response_status' => $message->admin_response_status == 1 ? 'Responded' : 'Pending',
        ];

        Mail::send('emails.student-contact-us-response', $data, function ($message) use ($data) {
            $message->to($data['email'], $data['email'])->subject($data['title']);
        });

        return redirect()->back()->with('success', 'Response submitted successfully.');

    }

}
