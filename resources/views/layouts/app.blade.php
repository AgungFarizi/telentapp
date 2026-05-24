<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — TELENT</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe',
                            300: '#93c5fd', 400: '#60a5fa', 500: '#3b82f6',
                            600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af',
                            900: '#1e3a8a', 950: '#172554',
                        },
                        telent: {
                            green: '#0f7a4d',
                            'green-dark': '#0a5c3a',
                            'green-light': '#e8f5ee',
                            'green-soft': '#f1faf5',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Alpine.js --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Custom CSS --}}
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* === SIDEBAR LINK STYLE === */
        .sidebar-link {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.7rem 1rem;
            border-radius: 0.625rem;
            color: #475569;          /* slate-600 */
            font-size: 0.92rem;
            font-weight: 500;
            transition: all .2s ease;
        }
        .sidebar-link:hover {
            background: #f1faf5;     /* very light green */
            color: #0f7a4d;
        }
        .sidebar-link svg { color: #64748b; transition: color .2s ease; }
        .sidebar-link:hover svg { color: #0f7a4d; }

        .sidebar-link.active {
            background: #e8f5ee;     /* light green pill */
            color: #0f7a4d;
            font-weight: 600;
        }
        .sidebar-link.active svg { color: #0f7a4d; }
        .sidebar-link.active::after {
            content: "";
            position: absolute;
            right: -0.5rem;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            border-radius: 4px;
            background: #0f7a4d;
        }

        .badge-green  { @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800; }
        .badge-red    { @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800; }
        .badge-yellow { @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800; }
        .badge-blue   { @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800; }
        .badge-purple { @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800; }
        .badge-gray   { @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800; }

        .scrollbar-thin::-webkit-scrollbar { width: 4px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: #f1f5f9; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 2px; }
    </style>

    @stack('styles')
</head>
<body class="h-full bg-slate-50">

<div x-data="{ sidebarOpen: false, sidebarCollapsed: false }" class="flex h-screen overflow-hidden">

    {{-- ============================================================ --}}
    {{-- SIDEBAR --}}
    {{-- ============================================================ --}}
    {{-- Mobile Overlay --}}
    <div x-show="sidebarOpen"
         x-cloak
         @click="sidebarOpen = false"
         class="fixed inset-0 z-20 bg-black/50 lg:hidden">
    </div>

    {{-- Sidebar --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed lg:relative inset-y-0 left-0 z-30 flex flex-col transition-all duration-300 ease-in-out bg-white border-r border-slate-200"
           :style="sidebarCollapsed ? 'width: 76px' : 'width: 260px'">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-5 py-6">
            <img
                src="{{ asset('images/logo-telentapp.png') }}"
                alt="TELENT Logo"
                class="flex-shrink-0 w-11 h-11 object-contain"
            >
            <div x-show="!sidebarCollapsed" x-cloak class="overflow-hidden leading-tight">
                <div class="text-telent-green font-extrabold text-xl tracking-tight">TELENT</div>
                <div class="text-slate-400 text-xs font-medium">Internship System</div>
            </div>
        </div>

        {{-- User Info (kept hidden visually – data/methods preserved) --}}
        <div x-show="false" x-cloak class="hidden">
            <img src="{{ auth()->user()->foto_profil_url }}" alt="{{ auth()->user()->nama_lengkap }}">
            <span>{{ auth()->user()->nama_lengkap }}</span>
            <span>{{ auth()->user()->getRoleLabel() }}</span>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto scrollbar-thin px-3 py-2 space-y-1">
            @yield('sidebar-menu')
        </nav>

        {{-- Collapse Toggle (Desktop) --}}
        <div class="hidden lg:flex items-center justify-end px-3 py-2">
            <button @click="sidebarCollapsed = !sidebarCollapsed"
                    class="p-1.5 rounded-lg text-slate-400 hover:text-telent-green hover:bg-telent-green-soft transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          :d="sidebarCollapsed ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7'"/>
                </svg>
            </button>
        </div>

        {{-- Bottom: Settings + Logout --}}
        <div class="px-3 pb-5 pt-3 border-t border-slate-100 space-y-1">
            {{-- Settings --}}
           <a href="{{ route(auth()->user()->getProfilRoute()) }}"
                    class="sidebar-link {{ request()->routeIs('*profil*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>

                    <span x-show="!sidebarCollapsed" x-cloak>Settings</span>
                </a>

            {{-- Logout --}}
            <form method="POST" action="{{ route('auth.logout') }}">
                @csrf
                <button type="submit" class="sidebar-link w-full text-left hover:!bg-red-50 hover:!text-red-600 [&:hover_svg]:!text-red-600">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span x-show="!sidebarCollapsed" x-cloak>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- ============================================================ --}}
    {{-- MAIN CONTENT --}}
    {{-- ============================================================ --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- Top Bar --}}
        <header class="bg-white border-b border-slate-200 flex items-center justify-between px-4 lg:px-6 h-16 flex-shrink-0">
            <div class="flex items-center gap-3">
                {{-- Mobile menu toggle --}}
                <button @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                {{-- Page Title --}}
                <div>
                    <h1 class="text-lg font-semibold text-telent-green">@yield('page-title', 'Dashboard')</h1>
                    @hasSection('page-subtitle')
                    <p class="text-xs text-slate-500 hidden sm:block">@yield('page-subtitle')</p>
                    @endif
                </div>
            </div>

            {{-- Right Side --}}
            <div class="flex items-center gap-2">
                {{-- Notifikasi --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                            class="relative p-2 rounded-lg text-slate-500 hover:bg-slate-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        @php $notifCount = auth()->user()->notifikasiBelumDibaca()->count(); @endphp
                        @if($notifCount > 0)
                        <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">
                            {{ $notifCount > 9 ? '9+' : $notifCount }}
                        </span>
                        @endif
                    </button>

                    {{-- Dropdown Notifikasi --}}
                    <div x-show="open" x-cloak @click.away="open = false"
                         class="absolute right-0 top-12 w-80 bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden z-50">
                        <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                            <h3 class="font-semibold text-slate-800 text-sm">Notifikasi</h3>
                            @if($notifCount > 0)
                            <span class="bg-red-100 text-red-700 text-xs px-2 py-0.5 rounded-full font-medium">{{ $notifCount }} baru</span>
                            @endif
                        </div>
                        <div class="max-h-72 overflow-y-auto scrollbar-thin">
                            @forelse(auth()->user()->notifikasi()->orderBy('created_at','desc')->take(5)->get() as $notif)
                            <a href="{{ $notif->url_tujuan ?? '#' }}"
                               class="flex items-start gap-3 px-4 py-3 hover:bg-slate-50 transition-colors border-b border-slate-50 {{ !$notif->sudah_dibaca ? 'bg-blue-50/50' : '' }}">
                                <span class="text-xl flex-shrink-0 mt-0.5">{{ $notif->icon }}</span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-800 truncate">{{ $notif->judul }}</p>
                                    <p class="text-xs text-slate-500 mt-0.5 line-clamp-2">{{ $notif->pesan }}</p>
                                    <p class="text-xs text-slate-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                                </div>
                                @if(!$notif->sudah_dibaca)
                                <div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0 mt-1.5"></div>
                                @endif
                            </a>
                            @empty
                            <div class="px-4 py-6 text-center">
                                <p class="text-sm text-slate-500">Tidak ada notifikasi</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- User Menu --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                            class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-slate-100 transition-colors">
                        <img src="{{ auth()->user()->foto_profil_url }}"
                             class="w-7 h-7 rounded-full object-cover"
                             alt="{{ auth()->user()->nama_lengkap }}">
                        <span class="text-sm font-medium text-slate-700 hidden sm:block max-w-[120px] truncate">{{ auth()->user()->nama_lengkap }}</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak @click.away="open = false"
                         class="absolute right-0 top-11 w-48 bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden z-50">
                        <div class="px-4 py-3 border-b border-slate-100">
                            <p class="text-sm font-medium text-slate-800">{{ auth()->user()->nama_lengkap }}</p>
                            <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="py-1">
                            <a href="{{ route(auth()->user()->getProfilRoute()) }}"
                               class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Profil Saya
                            </a>
                            <form method="POST" action="{{ route('auth.logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Alert Messages --}}
        @if(session('success') || session('error') || session('info') || $errors->any())
        <div class="px-4 lg:px-6 pt-4">
            @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-cloak
                 class="flex items-start gap-3 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm font-medium flex-1">{{ session('success') }}</span>
                <button @click="show = false" class="text-green-600 hover:text-green-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div class="flex items-start gap-3 p-4 bg-red-50 border border-red-200 rounded-xl text-red-800">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm font-medium flex-1">{{ session('error') }}</span>
            </div>
            @endif

            @if(session('info'))
            <div class="flex items-start gap-3 p-4 bg-blue-50 border border-blue-200 rounded-xl text-blue-800">
                <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm font-medium flex-1">{{ session('info') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="flex items-start gap-3 p-4 bg-red-50 border border-red-200 rounded-xl text-red-800">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <p class="text-sm font-semibold">Terdapat kesalahan:</p>
                    <ul class="mt-1 text-sm list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
        @endif

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto p-4 lg:p-6">
            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>


