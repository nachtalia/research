<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Store a new section.
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'section_name' => 'required|string|max:255|unique:sections,section_name',
            'teacher_id' => 'required|exists:teachers,id',
            'grade_level_id' => 'nullable|exists:grade_levels,id',
        ]);
    
        // Check for existing section (duplicate check)
        $existingSection = Section::where('section_name', $validated['section_name'])->first();
    
        if ($existingSection) {
            return response()->json([
                'message' => 'Section name already exists.',
            ], 409);
        }
    
        // Create section using validated data
        $section = Section::create($validated);
    
        return response()->json($section, 201);
    }
    
    /**
     * Update the section.
     */
    public function update(Request $request, $id)
    {
        // Validation
        $validated = $request->validate([
            'section_name' => 'required|string|max:255|unique:sections,section_name,' . $id,
            'teacher_id' => 'required|exists:teachers,id',
            'grade_level_id' => 'nullable|exists:grade_levels,id',
        ]);

        // Find and update section
        $section = Section::findOrFail($id);
        $section->update($validated);

        return response()->json(['message' => 'Section updated successfully!']);
    }

    /**
     * Delete a section.
     */
    public function destroy($id)
    {
        // Find and delete section
        $section = Section::findOrFail($id);
        $section->delete();

        return response()->json(['message' => 'Section deleted successfully!']);
    }
}
