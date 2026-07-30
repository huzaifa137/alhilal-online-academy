<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Academic\ClassModel;
use App\Models\Academic\Subject;
use App\Models\Academic\SubjectMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TeacherMaterialController extends Controller
{
    // ── List materials uploaded by this teacher ───────────────────────
    public function index()
    {
        $teacherId = session('LoggedTeacher');

        $materials = SubjectMaterial::with(['class', 'subject'])
            ->where('teacher_id', $teacherId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Teacher.materials.index', compact('materials'));
    }

    public function create()
    {
        return view('Teacher.materials.create');
    }

    // ── Store a new PDF material for a class + subject ────────────────
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'nullable|numeric|min:0',
            'file' => 'nullable|file|mimes:pdf|max:51200', // 50MB max, PDF only
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $teacherId = session('LoggedTeacher');
        $file = $request->file('file');

        $path = $file->store('materials/' . $request->class_id . '/' . $request->subject_id, 'public');

        $material = SubjectMaterial::create([
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $teacherId,
            'title' => $request->title,
            'description' => $request->description,
            'type' => 'pdf',
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'amount' => $request->amount ?: null,
            'sort_order' => SubjectMaterial::where('class_id', $request->class_id)
                ->where('subject_id', $request->subject_id)
                ->count(),
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => $request->amount
                ? 'PDF uploaded successfully! Students will need to pay UGX ' . number_format($request->amount) . ' to open it.'
                : 'PDF uploaded successfully! Students in this class will now see it under this subject.',
            'material' => $material,
        ]);
    }

    // ── Toggle active/inactive ─────────────────────────────────────────
    public function toggle(SubjectMaterial $material)
    {
        $teacherId = session('LoggedTeacher');

        if ($material->teacher_id != $teacherId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $material->status = $material->status === 'active' ? 'inactive' : 'active';
        $material->save();

        return response()->json(['success' => true, 'status' => $material->status]);
    }

    // ── Delete a material ───────────────────────────────────────────────
    public function destroy(SubjectMaterial $material)
    {
        $teacherId = session('LoggedTeacher');

        if ($material->teacher_id != $teacherId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return response()->json(['success' => true, 'message' => 'Material deleted.']);
    }
}