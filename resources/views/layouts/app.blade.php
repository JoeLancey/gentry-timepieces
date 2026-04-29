<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gentry Timepieces</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900 font-sans antialiased">

    {{-- SIDEBAR --}}
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 border-r border-gray-800">
        {{-- Logo --}}
        <div class="flex flex-col items-center px-6 py-8 border-b border-gray-800">
            <a href="{{ route('dashboard') }}" class="text-2xl font-serif font-semibold text-white tracking-wider">Gentry</a>
            <span class="text-xs tracking-[0.3em] uppercase text-gray-500 mt-1">Timepieces</span>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-4 py-6 overflow-y-auto">
            <p class="px-2 mb-2 text-xs font-semibold tracking-wider text-gray-600 uppercase">Overview</p>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-400 rounded-lg transition-all duration-200 hover:bg-gray-800 hover:text-white {{ request()->routeIs('dashboard') ? 'bg-gray-800 text-white' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <p class="px-2 mb-2 mt-6 text-xs font-semibold tracking-wider text-gray-600 uppercase">Inventory</p>
            <a href="{{ route('watches.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-400 rounded-lg transition-all duration-200 hover:bg-gray-800 hover:text-white {{ request()->routeIs('watches.*') ? 'bg-gray-800 text-white' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="1.5"/><path stroke-linecap="round" stroke-width="1.5" d="M12 7v5l3 3"/></svg>
                Inventory
            </a>

            <p class="px-2 mb-2 mt-6 text-xs font-semibold tracking-wider text-gray-600 uppercase">Operations</p>
            <a href="{{ route('clients.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-400 rounded-lg transition-all duration-200 hover:bg-gray-800 hover:text-white {{ request()->routeIs('clients.*') ? 'bg-gray-800 text-white' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Clients
            </a>
            <a href="{{ route('appraisals.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-400 rounded-lg transition-all duration-200 hover:bg-gray-800 hover:text-white {{ request()->routeIs('appraisals.*') ? 'bg-gray-800 text-white' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Appraisals
            </a>
            <a href="{{ route('consignments.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-400 rounded-lg transition-all duration-200 hover:bg-gray-800 hover:text-white {{ request()->routeIs('consignments.*') ? 'bg-gray-800 text-white' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                Consignments
            </a>
            <a href="{{ route('transactions.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-400 rounded-lg transition-all duration-200 hover:bg-gray-800 hover:text-white {{ request()->routeIs('transactions.*') ? 'bg-gray-800 text-white' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Transactions
            </a>
            <a href="{{ route('payments.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-400 rounded-lg transition-all duration-200 hover:bg-gray-800 hover:text-white {{ request()->routeIs('payments.*') ? 'bg-gray-800 text-white' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                Payments
            </a>

            @if(auth()->user()->isAdmin())
            <div class="mt-6 pt-4 border-t border-gray-700">
                <p class="px-3 mb-1 text-[10px] font-bold tracking-[0.2em] uppercase text-amber-400 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                    ADMIN PANEL
                </p>
                <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-amber-300 rounded transition-all duration-200 hover:bg-amber-900/30 hover:text-amber-100 {{ request()->routeIs('reports.*') ? 'bg-amber-900/40 text-amber-100 font-semibold border-l-2 border-amber-400' : 'border-l-2 border-transparent' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                    Reports
                </a>
                <a href="{{ route('activity-logs.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-amber-300 rounded transition-all duration-200 hover:bg-amber-900/30 hover:text-amber-100 {{ request()->routeIs('activity-logs.*') ? 'bg-amber-900/40 text-amber-100 font-semibold border-l-2 border-amber-400' : 'border-l-2 border-transparent' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    Activity Logs
                </a>
                <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-amber-300 rounded transition-all duration-200 hover:bg-amber-900/30 hover:text-amber-100 {{ request()->routeIs('users.*') ? 'bg-amber-900/40 text-amber-100 font-semibold border-l-2 border-amber-400' : 'border-l-2 border-transparent' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Users
                </a>
            </div>
            @endif
        </nav>

        {{-- User Section --}}
        <div class="px-4 py-4 border-t border-gray-800">
            <div class="flex flex-col mb-3">
                <span class="text-xs text-gray-500 uppercase tracking-wider">Signed in as</span>
                <span class="text-sm font-medium text-white">{{ auth()->user()->name }}</span>
                <span class="text-xs text-gray-600 mt-0.5 uppercase tracking-wider">{{ auth()->user()->role }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full px-3 py-2 text-xs font-medium text-gray-400 border border-gray-700 rounded hover:bg-gray-800 hover:text-white transition-colors duration-200">
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="ml-64 flex-1 flex flex-col min-h-screen">
        {{-- Top Bar --}}
        @isset($header)
        <header class="bg-white border-b border-gray-200 px-8 py-4 sticky top-0 z-40 shadow-sm">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-serif font-medium tracking-tight">{{ $header }}</h1>
                @isset($actions)
                <div class="flex items-center gap-3">{{ $actions }}</div>
                @endisset
            </div>
        </header>
        @endisset

        {{-- Page Content --}}
        <main class="flex-1 p-8 bg-gray-50">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg fade-in">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg fade-in">{{ session('error') }}</div>
            @endif

            {{ $slot }}
        </main>
    </div>

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        .fade-in { animation: fadeIn 0.3s ease-in; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</body>
</html>