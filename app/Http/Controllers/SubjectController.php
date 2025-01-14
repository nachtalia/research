<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Store a new subject.
     */
    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'subject_name' => 'required|string|max:255|unique:subjects,subject_name',
        ]);

        // Create Subject
        $subject = Subject::create($validated);

        // Return the created subject
        return response()->json(['message' => 'Subject added successfully!', 'subject' => $subject], 201);
    }

    /**
     * Update the subject.
     */
    public function update(Request $request, $id)
    {
        // Validation
        $validated = $request->validate([
            'subject_name' => 'required|string|max:255|unique:subjects,subject_name,' . $id,
        ]);

        // Find and update subject
        $subject = Subject::findOrFail($id);
        $subject->update($validated);

        return response()->json(['message' => 'Subject updated successfully!', 'subject' => $subject]);
    }

    /**
     * Delete the subject.
     */
    public function destroy($id)
    {
        // Find and delete subject
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return response()->json(['message' => 'Subject deleted successfully!']);
    }
}
