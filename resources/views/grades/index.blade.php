@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-white mb-0">Gestion des Notes</h3>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-plus-lg me-1"></i> Ajouter une note
            </button>
        </div>

        <div class="card bg-card text-white mb-4">
            <div class="card-body">
                <form action="{{ route('grades.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Rechercher par étudiant ou matière..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card bg-card text-white">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead class="table-light text-dark">
                        <tr>
                            <th>#</th>
                            <th>Étudiant</th>
                            <th>Matière</th>
                            <th>Note (/20)</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($grades as $grade)
                        <tr>
                            <td>{{ $loop->iteration + ($grades->currentPage() - 1) * $grades->perPage() }}</td>
                            <td>{{ $grade->student->name }}</td>
                            <td>{{ $grade->subject->name }}</td>
                            <td>
                                <span class="badge {{ $grade->value >= 15 ? 'bg-success' : ($grade->value >= 10 ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $grade->value }}
                                </span>
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-info me-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal" 
                                    data-id="{{ $grade->id }}"
                                    data-student-id="{{ $grade->student_id }}"
                                    data-subject-id="{{ $grade->subject_id }}"
                                    data-value="{{ $grade->value }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal" 
                                    data-id="{{ $grade->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">Aucune note trouvée</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($grades->hasPages())
            <div class="card-footer border-top border-secondary">
                {{ $grades->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('grades.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une note</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Étudiant</label>
                        <select name="student_id" class="form-select" required>
                            <option value="">Sélectionner un étudiant</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Matière</label>
                        <select name="subject_id" class="form-select" required>
                            <option value="">Sélectionner une matière</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Note (sur 20)</label>
                        <input type="number" name="value" class="form-control" min="0" max="20" step="0.25" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Modifier la note</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Étudiant</label>
                        <select name="student_id" id="edit_student_id" class="form-select" required>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Matière</label>
                        <select name="subject_id" id="edit_subject_id" class="form-select" required>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Note (sur 20)</label>
                        <input type="number" name="value" id="edit_value" class="form-control" min="0" max="20" step="0.25" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-warning">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Confirmer la suppression</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Voulez-vous vraiment supprimer cette note ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var studentId = button.getAttribute('data-student-id');
            var subjectId = button.getAttribute('data-subject-id');
            var value = button.getAttribute('data-value');
            
            var form = document.getElementById('editForm');
            form.action = '/grades/' + id;
            
            document.getElementById('edit_student_id').value = studentId;
            document.getElementById('edit_subject_id').value = subjectId;
            document.getElementById('edit_value').value = value;
        });

        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var form = document.getElementById('deleteForm');
            form.action = '/grades/' + id;
        });
    });
</script>
@endsection
