<div class="card bg-card text-white">
    <!-- Header -->
    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center border-bottom border-secondary gap-3">
        <h5 class="mb-0">Relevé de notes</h5>
        <div class="d-flex w-100 w-md-auto" style="min-width: 250px;">
            <div class="input-group">
                <span class="input-group-text bg-dark border-secondary text-secondary"><i class="bi bi-search"></i></span>
                <input wire:model.live.debounce.300ms="search" type="text" class="form-control bg-dark border-secondary text-white" placeholder="Rechercher...">
            </div>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Table -->
    <div class="table-responsive mobile-table-container">
        <table class="table table-dark table-hover mb-0 mobile-table-container">
            <thead class="table-light text-dark">
                <tr>
                    <th>#</th>
                    <th>Étudiant</th>
                    <th>Matière</th>
                    <th>Note / 20</th>
                    <th>Date d'évaluation</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($grades as $grade)
                    <tr>
                        <td>{{ $loop->iteration + ($grades->currentPage() - 1) * $grades->perPage() }}</td>
                        <td>{{ $grade->student->name }}</td>
                        <td>{{ $grade->subject->name }}</td>
                        
                        <!-- Inline Edit Cell -->
                        <td wire:click="edit({{ $grade->id }})" class="cursor-pointer">
                            @if($editingGradeId === $grade->id)
                                <div class="d-flex align-items-center">
                                    <input wire:model="editingValue" 
                                           wire:keydown.enter="save" 
                                           wire:keydown.escape="cancelEdit"
                                           type="number" step="0.5" min="0" max="20" 
                                           class="form-control form-control-sm" 
                                           autofocus>
                                    <button wire:click="save" class="btn btn-sm btn-success ms-1"><i class="bi bi-check"></i></button>
                                    <button wire:click="cancelEdit" class="btn btn-sm btn-secondary ms-1"><i class="bi bi-x"></i></button>
                                </div>
                                @error('editingValue') <span class="text-danger small">{{ $message }}</span> @enderror
                            @else
                                <span class="{{ $grade->value < 10 ? 'text-danger' : 'text-success' }} fw-bold">
                                    {{ $grade->value }}
                                </span>
                                <i class="bi bi-pencil-fill ms-2 text-secondary small opacity-50"></i>
                            @endif
                        </td>

                        <td>{{ $grade->created_at->format('d/m/Y') }}</td>
                        <td class="text-end">
                            <button wire:click="delete({{ $grade->id }})" 
                                    wire:confirm="Voulez-vous vraiment supprimer cette note ?"
                                    class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Aucune note trouvée</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($grades->hasPages())
    <div class="card-footer border-top border-secondary">
        {{ $grades->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
