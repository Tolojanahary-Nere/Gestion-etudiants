<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Dashboard</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
    <div id="app" class="layout-wrapper">
        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Sidebar -->
        <nav class="layout-sidebar" id="layoutSidebar">
            <div class="sidebar-header">
                <i class="bi bi-bootstrap-fill me-2 text-primary"></i>
                <span>GESTION ETUDIANTS</span>
            </div>
            <ul class="nav flex-column sidebar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Tableau de bord</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('students*') ? 'active' : '' }}" href="{{ route('students.index') }}">
                        <i class="bi bi-people"></i>
                        <span>Etudiant</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('subjects*') ? 'active' : '' }}" href="{{ route('subjects.index') }}">
                        <i class="bi bi-journal-bookmark"></i>
                        <span>Matières</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('grades*') ? 'active' : '' }}" href="{{ route('grades.index') }}">
                        <i class="bi bi-clipboard-check"></i>
                        <span>Notes</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div class="layout-page">
            <!-- Topbar -->
            <nav class="layout-topbar">
                <div class="d-flex align-items-center flex-grow-1 me-3">
                    <button class="btn btn-icon btn-text-secondary me-3 d-lg-none" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <form id="globalSearchForm" method="GET" class="w-100 d-none d-lg-flex" style="max-width: 400px;">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-0 text-muted"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control bg-transparent border-0 text-white shadow-none" placeholder="Rechercher..." value="{{ request('search') }}">
                        </div>
                    </form>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        // Search Logic
                        const form = document.getElementById('globalSearchForm');
                        const path = window.location.pathname;
                        
                        if (path.includes('/students')) {
                            form.action = "{{ route('students.index') }}";
                            form.querySelector('input').placeholder = "Rechercher un étudiant...";
                        } else if (path.includes('/subjects')) {
                            form.action = "{{ route('subjects.index') }}";
                             form.querySelector('input').placeholder = "Rechercher une matière...";
                        } else if (path.includes('/grades')) {
                            form.action = "{{ route('grades.index') }}";
                             form.querySelector('input').placeholder = "Rechercher une note (étudiant/matière)...";
                        } else {
                            form.style.visibility = 'hidden';
                        }

                        // Sidebar Toggle Logic
                        const sidebarToggle = document.getElementById('sidebarToggle');
                        const layoutSidebar = document.getElementById('layoutSidebar');
                        const sidebarOverlay = document.getElementById('sidebarOverlay');

                        if (sidebarToggle && layoutSidebar && sidebarOverlay) {
                            function toggleSidebar() {
                                layoutSidebar.classList.toggle('show');
                                sidebarOverlay.classList.toggle('show');
                            }

                            sidebarToggle.addEventListener('click', (e) => {
                                e.stopPropagation();
                                toggleSidebar();
                            });

                            sidebarOverlay.addEventListener('click', () => {
                                toggleSidebar();
                            });
                        }
                    });
                </script>

                <!-- User Dropdown removed -->
            </nav>

            <!-- Content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
        </div>
    </div>
    @livewireScripts
</body>
</html>
