@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <h3 class="text-white mb-4">Tableau de bord</h3>
        
        <!-- Stats Cards -->
        <div class="row mb-4">
            <!-- Total Students -->
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card bg-card text-white border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted small mb-2">Total Étudiants</h6>
                                <h2 class="mb-0">{{ $totalStudents }}</h2>
                            </div>
                            <div class="fs-1 text-primary"><i class="bi bi-people"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Subjects -->
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card bg-card text-white border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted small mb-2">Matières</h6>
                                <h2 class="mb-0">{{ $totalSubjects }}</h2>
                            </div>
                            <div class="fs-1 text-info"><i class="bi bi-book"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Average Grade -->
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card bg-card text-white border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted small mb-2">Moyenne Globale</h6>
                                <h2 class="mb-0">{{ number_format($averageGrade, 2) }} / 20</h2>
                            </div>
                            <div class="fs-1 text-warning"><i class="bi bi-bar-chart"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row mb-4">
            <div class="col-lg-6 mb-4">
                <div class="card bg-card text-white border-0 h-100">
                    <div class="card-header border-bottom border-secondary">
                        <h5 class="mb-0">Moyenne par Matière</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-card text-white border-0 h-100">
                    <div class="card-header border-bottom border-secondary">
                        <h5 class="mb-0">Répartition des Notes</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="pieChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Students Table -->
        <div class="card bg-card text-white border-0">
            <div class="card-header border-bottom border-secondary">
                <h5 class="mb-0">Meilleurs Étudiants (Top 5)</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Rang</th>
                            <th>Nom</th>
                            <th>Moyenne</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($topStudents as $index => $student)
                        <tr>
                            <td>
                                @if($loop->first) <i class="bi bi-trophy-fill text-warning"></i> 
                                @elseif($loop->iteration == 2) <i class="bi bi-trophy-fill text-secondary"></i>
                                @elseif($loop->iteration == 3) <i class="bi bi-trophy-fill text-danger"></i>
                                @else {{ $loop->iteration }}
                                @endif
                            </td>
                            <td>{{ $student->name }}</td>
                            <td>
                                <span class="badge {{ $student->grades->avg('value') >= 15 ? 'bg-success' : ($student->grades->avg('value') >= 10 ? 'bg-warning' : 'bg-danger') }}">
                                    {{ number_format($student->grades->avg('value'), 2) }} / 20
                                </span>
                            </td>
                            <td>{{ $student->email }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-3">Aucun étudiant noté pour le moment.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Bar Chart - Subjects
        const ctxBar = document.getElementById('barChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: {!! json_encode($subjectLabels) !!},
                datasets: [{
                    label: 'Moyenne',
                    data: {!! json_encode($subjectAverages) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 20,
                        grid: { color: 'rgba(255, 255, 255, 0.1)' },
                        ticks: { color: '#fff' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#fff' }
                    }
                },
                plugins: {
                    legend: { labels: { color: '#fff' } }
                }
            }
        });

        // Pie Chart - Distribution
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_keys($distribution)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($distribution)) !!},
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.7)', // Green
                        'rgba(54, 162, 235, 0.7)', // Blue
                        'rgba(255, 206, 86, 0.7)', // Yellow
                        'rgba(255, 99, 132, 0.7)'  // Red
                    ],
                    borderColor: 'transparent'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'right', labels: { color: '#fff' } }
                }
            }
        });
    });
</script>
@endsection
