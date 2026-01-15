<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function export() 
    {
        return Excel::download(new StudentsExport, 'etudiants.xlsx');
    }

    public function index(Request $request){
        $query = Student::query();

        if($request->has('search')){
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $students = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request  $request){
        //valide data
        $request->validate([
            'name'=>'required|string|min:2|max:100',
            'email'=>'required|email|unique:students,email',
            'phone'=>'required|string|min:10|max:15',
            'address'=>'required|string|min:8|max:255',
        ]);
        //creer etudiant
        Student::create($request->all());
        return redirect()->route('students.index')->with('success','Etudiant ajouter avec succes');
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name'=>'required|string|min:2|max:100',
            'email'=>'required|email|unique:students,email,'.$student->id,
            'phone'=>'required|string|min:10|max:15',
            'address'=>'required|string|min:8|max:255',
        ]);

        $student->update($request->all());
        return redirect()->route('students.index')->with('success', 'Etudiant modifié avec succès');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Etudiant supprimé avec succès');
    }
}
