<?php

namespace App\Livewire;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;

class GradesTable extends Component
{
    use WithPagination;

    public $search = '';
    public $editingGradeId = null;
    public $editingValue = null;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'editingValue' => 'required|numeric|min:0|max:20',
    ];

    public function edit($gradeId)
    {
        $this->editingGradeId = $gradeId;
        $grade = Grade::find($gradeId);
        $this->editingValue = $grade->value;
    }

    public function cancelEdit()
    {
        $this->editingGradeId = null;
        $this->editingValue = null;
    }

    public function save()
    {
        $this->validate();

        if ($this->editingGradeId) {
            $grade = Grade::find($this->editingGradeId);
            $grade->update([
                'value' => $this->editingValue,
            ]);

            session()->flash('success', 'Note mise à jour avec succès.');
        }

        $this->cancelEdit();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function delete($gradeId)
    {
        Grade::find($gradeId)->delete();
        session()->flash('success', 'Note supprimée.');
    }

    public function render()
    {
        $grades = Grade::with(['student', 'subject'])
            ->when($this->search, function($query) {
                 $query->whereHas('student', function($q) {
                     $q->where('name', 'like', "%{$this->search}%");
                 })->orWhereHas('subject', function($q) {
                     $q->where('name', 'like', "%{$this->search}%");
                 });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.grades-table', [
            'grades' => $grades,
            'students' => Student::all(),
            'subjects' => Subject::all(),
        ]);
    }
}
