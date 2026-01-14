<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $subjects = Subject::when($search, function($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('subjects.index', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subjects',
            'coefficient' => 'required|integer|min:1',
        ]);

        Subject::create($request->all());

        return redirect()->route('subjects.index')
                         ->with('success', 'Matière ajoutée avec succès.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name,' . $subject->id,
            'coefficient' => 'required|integer|min:1',
        ]);

        $subject->update($request->all());

        return redirect()->route('subjects.index')
                         ->with('success', 'Matière mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('subjects.index')
                         ->with('success', 'Matière supprimée avec succès.');
    }
}
