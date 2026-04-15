<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Academic\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::withCount('levels')
                           ->orderBy('sort_order')
                           ->paginate(20);
        
        return view('Admin.academic.sections.index', compact('sections'));
    }
    
    public function create()
    {
        return view('admin.academic.sections.create');
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:sections',
            'code' => 'required|string|max:20|unique:sections',
            'description' => 'nullable|string',
            'sort_order' => 'integer',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        Section::create($request->all());
        
        return redirect()->route('admin.sections.index')
                         ->with('success', 'Section created successfully.');
    }
    
    public function edit(Section $section)
    {
        return view('admin.academic.sections.edit', compact('section'));
    }
    
    public function update(Request $request, Section $section)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:sections,name,' . $section->id,
            'code' => 'required|string|max:20|unique:sections,code,' . $section->id,
            'description' => 'nullable|string',
            'sort_order' => 'integer',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $section->update($request->all());
        
        return redirect()->route('admin.sections.index')
                         ->with('success', 'Section updated successfully.');
    }
    
    public function destroy(Section $section)
    {
        // Check if section has levels
        if ($section->levels()->count() > 0) {
            return redirect()->back()
                             ->with('error', 'Cannot delete section with existing levels.');
        }
        
        $section->delete();
        
        return redirect()->route('admin.sections.index')
                         ->with('success', 'Section deleted successfully.');
    }
    
    public function toggleStatus(Section $section)
    {
        $section->update([
            'status' => $section->status === 'active' ? 'inactive' : 'active'
        ]);
        
        return response()->json([
            'success' => true,
            'status' => $section->status,
            'message' => 'Section status updated.'
        ]);
    }
}