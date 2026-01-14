<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $grades = Grade::with(['student', 'subject'])
            ->when($search, function($query, $search) {
                 return $query->whereHas('student', function($q) use ($search) {
                     $q->where('name', 'like', "%{$search}%");
                 })->orWhereHas('subject', function($q) use ($search) {
                     $q->where('name', 'like', "%{$search}%");
                 });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        $students = Student::all(); // For the modals
        $subjects = Subject::all(); // For the modals
        return view('grades.index', compact('grades', 'students', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'value' => 'required|numeric|min:0|max:20',
        ]);

        // Check if grade already exists for this student/subject
        $exists = Grade::where('student_id', $request->student_id)
                       ->where('subject_id', $request->subject_id)
                       ->exists();

        if ($exists) {
             return redirect()->back()->withErrors(['error' => 'Cet étudiant a déjà une note pour cette matière.']);
        }

        Grade::create($request->all());

        return redirect()->route('grades.index')
                         ->with('success', 'Note ajoutée avec succès.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'value' => 'required|numeric|min:0|max:20',
        ]);

        // If changing student/subject, check for duplicates (excluding current)
        if ($grade->student_id != $request->student_id || $grade->subject_id != $request->subject_id) {
             $exists = Grade::where('student_id', $request->student_id)
                       ->where('subject_id', $request->subject_id)
                       ->where('id', '!=', $grade->id)
                       ->exists();
             if ($exists) {
                 return redirect()->back()->withErrors(['error' => 'Cet étudiant a déjà une note pour cette matière.']);
            }
        }

        $grade->update($request->all());

        return redirect()->route('grades.index')
                         ->with('success', 'Note mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        $grade->delete();

        return redirect()->route('grades.index')
                         ->with('success', 'Note supprimée avec succès.');
    }
}
