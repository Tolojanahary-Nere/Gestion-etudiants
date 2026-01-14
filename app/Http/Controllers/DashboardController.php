<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = \App\Models\Student::count();
        $totalSubjects = \App\Models\Subject::count();
        $averageGrade = \App\Models\Grade::avg('value');
        
        // Get top 5 students by average grade
        $topStudents = \App\Models\Student::with('grades')
            ->get()
            ->sortByDesc(function($student) {
                return $student->grades->avg('value');
            })
            ->take(5);

        // Chart Data 1: Average Grade per Subject
        $subjects = \App\Models\Subject::with(['grades' => function($query) {
            $query->select('subject_id', 'value');
        }])->get();

        $subjectLabels = [];
        $subjectAverages = [];

        foreach ($subjects as $subject) {
            $subjectLabels[] = $subject->name;
            $subjectAverages[] = $subject->grades->avg('value') ?? 0;
        }

        // Chart Data 2: Grade Distribution
        $grades = \App\Models\Grade::all()->pluck('value');
        $distribution = [
            'Excellent (>=16)' => $grades->filter(fn($g) => $g >= 16)->count(),
            'Bien (14-15.9)' => $grades->filter(fn($g) => $g >= 14 && $g < 16)->count(),
            'Moyen (10-13.9)' => $grades->filter(fn($g) => $g >= 10 && $g < 14)->count(),
            'Insuffisant (<10)' => $grades->filter(fn($g) => $g < 10)->count(),
        ];

        return view('dashboard.index', compact(
            'totalStudents', 'totalSubjects', 'averageGrade', 'topStudents',
            'subjectLabels', 'subjectAverages', 'distribution'
        ));
    }
}
