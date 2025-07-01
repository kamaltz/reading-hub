<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <x-head.tinymce-config/>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen text-gray-200 bg-gray-900">
            <div class="flex h-screen">
                <!-- Sidebar -->
                <aside id="sidebar" class="flex flex-col flex-shrink-0 w-64 border-r border-gray-800 transition-all duration-300">
                    <div class="flex justify-between items-center px-4 h-16 border-b border-gray-800">
                        <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-white sidebar-logo">
                            Reading<span class="text-indigo-400">Hub</span>
                        </a>
                        <button id="sidebarToggleInside" class="p-2 text-gray-400 rounded-lg hover:bg-gray-800 hover:text-white sidebar-toggle-btn">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                    <nav id="sidebarNav" class="overflow-y-auto flex-grow p-4 space-y-2">
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 transition-colors rounded-lg {{ request()->routeIs('dashboard') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                            <svg class="mr-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1V10a1 1 0 00-1-1H7a1 1 0 00-1 1v10a1 1 0 001 1h2z"></path></svg>
                            <span class="sidebar-text">Dashboard</span>
                        </a>

                        @if(Auth::check() && Auth::user()->isAdmin())
                            <!-- Manajemen Siswa -->
                            <div class="space-y-1">
                                <div class="px-4 py-2 text-xs font-semibold tracking-wider text-gray-500 uppercase sidebar-text">Manajemen Siswa</div>
                                <a href="{{ route('admin.students.index') }}" class="flex items-center px-4 py-2 transition-colors rounded-lg {{ request()->routeIs('admin.students.index') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                                    <svg class="mr-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"></path></svg>
                                    <span class="sidebar-text">Daftar Siswa</span>
                                </a>
                                <a href="{{ route('admin.students.create') }}" class="flex items-center px-4 py-2 ml-4 transition-colors rounded-lg {{ request()->routeIs('admin.students.create') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                                    <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    <span class="sidebar-text">Tambah Siswa</span>
                                </a>
                                <a href="{{ route('admin.students.generate') }}" class="flex items-center px-4 py-2 ml-4 transition-colors rounded-lg {{ request()->routeIs('admin.students.generate') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                                    <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    <span class="sidebar-text">Generate Akun</span>
                                </a>
                                <a href="{{ route('admin.students.import.form') }}" class="flex items-center px-4 py-2 ml-4 transition-colors rounded-lg {{ request()->routeIs('admin.students.import.form') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                                    <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
                                    <span class="sidebar-text">Import Siswa</span>
                                </a>
                            </div>

                            <!-- Manajemen Materi -->
                            <div class="space-y-1">
                                <div class="px-4 py-2 text-xs font-semibold tracking-wider text-gray-500 uppercase sidebar-text">Manajemen Materi</div>
                                <a href="{{ route('admin.materials.index') }}" class="flex items-center px-4 py-2 transition-colors rounded-lg {{ request()->routeIs('admin.materials.index') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                                    <svg class="mr-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-9-5.747h18"></path></svg>
                                    <span class="sidebar-text">Daftar Materi</span>
                                </a>
                                <a href="{{ route('admin.materials.create') }}" class="flex items-center px-4 py-2 ml-4 transition-colors rounded-lg {{ request()->routeIs('admin.materials.create') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                                    <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    <span class="sidebar-text">Tambah Materi</span>
                                </a>
                                <a href="{{ route('admin.genres.index') }}" class="flex items-center px-4 py-2 ml-4 transition-colors rounded-lg {{ request()->routeIs('admin.genres.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                                    <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5a2 2 0 012 2v5a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path></svg>
                                    <span class="sidebar-text">Genre</span>
                                </a>
                                <a href="{{ route('admin.chapters.index') }}" class="flex items-center px-4 py-2 ml-4 transition-colors rounded-lg {{ request()->routeIs('admin.chapters.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                                    <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                                    <span class="sidebar-text">Bab</span>
                                </a>
                            </div>

                            <!-- Manajemen Aktivitas -->
                            <div class="space-y-1">
                                <div class="px-4 py-2 text-xs font-semibold tracking-wider text-gray-500 uppercase sidebar-text">Manajemen Aktivitas</div>
                                <a href="{{ route('admin.activities.all') }}" class="flex items-center px-4 py-2 transition-colors rounded-lg {{ request()->routeIs('admin.activities.all') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                                    <svg class="mr-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    <span class="sidebar-text">Daftar Aktivitas</span>
                                </a>
                                <a href="{{ route('admin.activities.create') }}" class="flex items-center px-4 py-2 ml-4 transition-colors rounded-lg {{ request()->routeIs('admin.activities.create') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                                    <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    <span class="sidebar-text">Tambah Aktivitas</span>
                                </a>
                            </div>
                        @else
                            <!-- Student Menu -->
                            <div class="space-y-1">
                                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 transition-colors rounded-lg {{ request()->routeIs('dashboard') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                                    <svg class="mr-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-9-5.747h18"></path>
                                    </svg>
                                    <span class="sidebar-text">Materi</span>
                                </a>
                                <a href="{{ route('student.progress') }}" class="flex items-center px-4 py-2 transition-colors rounded-lg {{ request()->routeIs('student.progress') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                                    <svg class="mr-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    <span class="sidebar-text">Progres</span>
                                </a>
                                <a href="{{ route('student.recent') }}" class="flex items-center px-4 py-2 transition-colors rounded-lg {{ request()->routeIs('student.recent') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                                    <svg class="mr-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="sidebar-text">Aktivitas Terbaru</span>
                                </a>
                            </div>
                        @endif
                    </nav>
                    <div id="sidebarFooter" class="p-4 border-t border-gray-800">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center px-4 py-2 w-full text-gray-400 rounded-lg transition-colors hover:bg-red-900/50 hover:text-white">
                                <svg class="mr-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                <span class="sidebar-text">Log Out</span>
                            </a>
                        </form>
                    </div>
                </aside>

                <!-- Main Content -->
                <main id="mainContent" class="overflow-y-auto flex-1 transition-all duration-300">
                    <!-- Top Bar -->
                    <div class="flex justify-between items-center p-4 bg-gray-800 border-b border-gray-700">
                        <div class="flex items-center space-x-4">
                            <button id="sidebarToggle" class="p-2 text-gray-400 rounded-lg hover:bg-gray-700 hover:text-white">
                                
                            </button>
                            <h1 class="text-xl font-semibold text-white">{{ $header ?? 'Dashboard' }}</h1>
                        </div>
                        <div class="flex items-center">
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white focus:outline-none">
                                <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="text-sm font-medium">{{ Auth::user()->name ?? 'Guest' }}</span>
                            </a>
                        </div>
                    </div>

                    <!-- Page Content -->
                    <div class="p-6">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sidebar = document.getElementById('sidebar');
                const sidebarNav = document.getElementById('sidebarNav');
                const sidebarFooter = document.getElementById('sidebarFooter');
                const sidebarToggle = document.getElementById('sidebarToggle');
                const sidebarToggleInside = document.getElementById('sidebarToggleInside');
                let isCollapsed = false;

                function toggleSidebar() {
                    isCollapsed = !isCollapsed;
                    
                    if (isCollapsed) {
                        sidebar.classList.remove('w-64');
                        sidebar.classList.add('w-16');
                        sidebarNav.style.display = 'none';
                        sidebarFooter.style.display = 'none';
                        document.querySelector('.sidebar-logo').style.display = 'none';
                    } else {
                        sidebar.classList.remove('w-16');
                        sidebar.classList.add('w-64');
                        sidebarNav.style.display = 'block';
                        sidebarFooter.style.display = 'block';
                        document.querySelector('.sidebar-logo').style.display = 'block';
                    }
                }

                if (sidebarToggle) sidebarToggle.addEventListener('click', toggleSidebar);
                if (sidebarToggleInside) sidebarToggleInside.addEventListener('click', toggleSidebar);
                
                // Material filtering for students
                const chapterFilter = document.getElementById('chapterFilter');
                const genreFilter = document.getElementById('genreFilter');
                const materialCards = document.querySelectorAll('.material-card');
                
                function filterMaterials() {
                    const selectedChapter = chapterFilter?.value || '';
                    const selectedGenre = genreFilter?.value || '';
                    
                    materialCards.forEach(card => {
                        const cardChapter = card.dataset.chapter;
                        const cardGenre = card.dataset.genre;
                        
                        const chapterMatch = !selectedChapter || cardChapter === selectedChapter;
                        const genreMatch = !selectedGenre || cardGenre === selectedGenre;
                        
                        if (chapterMatch && genreMatch) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                }
                
                if (chapterFilter) chapterFilter.addEventListener('change', filterMaterials);
                if (genreFilter) genreFilter.addEventListener('change', filterMaterials);
            });
        </script>
        @stack('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    </body>
</html>