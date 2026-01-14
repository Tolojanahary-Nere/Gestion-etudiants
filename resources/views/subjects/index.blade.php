@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-white mb-0">Gestion des Matières</h3>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-plus-lg me-1"></i> Ajouter une matière
            </button>
        </div>

        <div class="card bg-card text-white mb-4">
            <div class="card-body">
                <form action="{{ route('subjects.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Rechercher une matière..." value="{{ request('search') }}">
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
                            <th>Nom</th>
                            <th>Coefficient</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subjects as $subject)
                        <tr>
                            <td>{{ $loop->iteration + ($subjects->currentPage() - 1) * $subjects->perPage() }}</td>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->coefficient }}</td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-info me-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal" 
                                    data-id="{{ $subject->id }}"
                                    data-name="{{ $subject->name }}"
                                    data-coefficient="{{ $subject->coefficient }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal" 
                                    data-id="{{ $subject->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">Aucune matière trouvée</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($subjects->hasPages())
            <div class="card-footer border-top border-secondary">
                {{ $subjects->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('subjects.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une matière</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Coefficient</label>
                        <input type="number" name="coefficient" class="form-control" min="1" value="1" required>
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
                    <h5 class="modal-title">Modifier la matière</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Coefficient</label>
                        <input type="number" name="coefficient" id="edit_coefficient" class="form-control" min="1" required>
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
                    <p>Voulez-vous vraiment supprimer cette matière ?</p>
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
            var name = button.getAttribute('data-name');
            var coefficient = button.getAttribute('data-coefficient');
            
            var form = document.getElementById('editForm');
            form.action = '/subjects/' + id;
            
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_coefficient').value = coefficient;
        });

        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var form = document.getElementById('deleteForm');
            form.action = '/subjects/' + id;
        });
    });
</script>
@endsection
