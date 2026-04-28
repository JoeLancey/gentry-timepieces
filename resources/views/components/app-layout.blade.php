@props(['header' => null, 'actions' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gentry Timepieces</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Didact+Gothic&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --black: #0a0a0a;
            --black-soft: #141414;
            --gray-dark: #1f1f1f;
            --gray-mid: #6b6b6b;
            --gray-light: #d4d4d4;
            --gray-pale: #f0f0f0;
            --white: #ffffff;
            --accent: #0a0a0a;
            --sidebar-width: 220px;
        }

        body {
            background: var(--white);
            color: var(--black);
            font-family: 'Didact Gothic', sans-serif;
            font-size: 13px;
            min-height: 100vh;
            display: flex;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--black);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 50;
        }

        .sidebar-logo {
            padding: 2rem 1.75rem 1.5rem;
            border-bottom: 1px solid #1e1e1e;
        }

        .sidebar-logo .brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--white);
            letter-spacing: 0.08em;
            text-decoration: none;
            display: block;
        }

        .sidebar-logo .sub {
            font-size: 0.6rem;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--gray-mid);
            margin-top: 3px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1.5rem 0;
            overflow-y: auto;
        }

        .nav-section-label {
            font-size: 0.55rem;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: #3a3a3a;
            padding: 0.75rem 1.75rem 0.4rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.65rem 1.75rem;
            color: #888;
            text-decoration: none;
            font-size: 0.78rem;
            letter-spacing: 0.06em;
            transition: all 0.15s;
            border-left: 2px solid transparent;
        }

        .sidebar-link:hover {
            color: var(--white);
            background: #161616;
        }

        .sidebar-link.active {
            color: var(--white);
            border-left-color: var(--white);
            background: #161616;
        }

        .sidebar-link svg {
            width: 14px;
            height: 14px;
            opacity: 0.6;
            flex-shrink: 0;
        }

        .sidebar-link.active svg { opacity: 1; }

        .sidebar-footer {
            padding: 1.25rem 1.75rem;
            border-top: 1px solid #1e1e1e;
        }

        .sidebar-user {
            font-size: 0.72rem;
            color: #555;
            margin-bottom: 0.75rem;
            letter-spacing: 0.04em;
        }

        .sidebar-user strong { color: #aaa; display: block; font-weight: 400; }

        .btn-logout {
            width: 100%;
            background: none;
            border: 1px solid #2a2a2a;
            color: #666;
            padding: 0.5rem;
            font-family: 'Didact Gothic', sans-serif;
            font-size: 0.68rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-logout:hover {
            border-color: #555;
            color: #aaa;
        }

        /* ── MAIN ── */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .top-bar {
            background: var(--white);
            border-bottom: 1px solid var(--gray-pale);
            padding: 1.25rem 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .top-bar h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 500;
            letter-spacing: 0.04em;
            color: var(--black);
        }

        .top-bar-actions { display: flex; gap: 0.75rem; align-items: center; }

        .page-body {
            padding: 2.5rem;
            flex: 1;
        }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.55rem 1.4rem;
            font-family: 'Didact Gothic', sans-serif;
            font-size: 0.72rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            text-decoration: none;
            border-radius: 0;
            cursor: pointer;
            transition: all 0.15s;
            border: 1px solid transparent;
        }

        .btn-primary {
            background: var(--black);
            color: var(--white);
            border-color: var(--black);
        }

        .btn-primary:hover { background: #2a2a2a; border-color: #2a2a2a; }

        .btn-secondary {
            background: transparent;
            color: var(--black);
            border-color: var(--gray-light);
        }

        .btn-secondary:hover { border-color: var(--black); }

        .btn-danger {
            background: transparent;
            color: #dc2626;
            border-color: #fca5a5;
        }

        .btn-danger:hover { background: #fef2f2; }

        .btn-success {
            background: transparent;
            color: #16a34a;
            border-color: #86efac;
        }

        .btn-success:hover { background: #f0fdf4; }

        .btn-sm {
            padding: 0.35rem 0.85rem;
            font-size: 0.65rem;
        }

        /* ── CARDS ── */
        .card {
            background: var(--white);
            border: 1px solid var(--gray-pale);
            padding: 1.75rem;
        }

        .card-black {
            background: var(--black);
            color: var(--white);
            border: none;
        }

        /* ── STATS ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 1px;
            background: var(--gray-pale);
            border: 1px solid var(--gray-pale);
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--white);
            padding: 1.75rem;
        }

        .stat-label {
            font-size: 0.6rem;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: var(--gray-mid);
            margin-bottom: 0.75rem;
        }

        .stat-value {
            font-family: 'Playfair Display', serif;
            font-size: 2.75rem;
            font-weight: 400;
            color: var(--black);
            line-height: 1;
        }

        .stat-value.green { color: #16a34a; }
        .stat-value.blue { color: #1d4ed8; }
        .stat-value.purple { color: #7c3aed; }

        /* ── TABLE ── */
        .table-wrapper {
            overflow-x: auto;
        }

        .gt-table {
            width: 100%;
            border-collapse: collapse;
        }

        .gt-table thead tr {
            border-bottom: 2px solid var(--black);
        }

        .gt-table th {
            font-size: 0.6rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--gray-mid);
            padding: 0.75rem 1rem;
            text-align: left;
            font-weight: 400;
            white-space: nowrap;
        }

        .gt-table tbody tr {
            border-bottom: 1px solid var(--gray-pale);
            transition: background 0.1s;
        }

        .gt-table tbody tr:hover { background: #fafafa; }

        .gt-table td {
            padding: 0.9rem 1rem;
            font-size: 0.82rem;
            color: var(--black);
            vertical-align: middle;
        }

        /* ── BADGES ── */
        .badge {
            display: inline-block;
            font-size: 0.58rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            padding: 0.25rem 0.65rem;
            font-weight: 400;
        }

        .badge-available  { background:#f0fdf4; color:#15803d; }
        .badge-sold       { background:#fef2f2; color:#dc2626; }
        .badge-consigned  { background:#fefce8; color:#a16207; }
        .badge-reserved   { background:#f5f3ff; color:#6d28d9; }
        .badge-pending    { background:#fefce8; color:#a16207; }
        .badge-confirmed  { background:#f0fdf4; color:#15803d; }
        .badge-failed     { background:#fef2f2; color:#dc2626; }
        .badge-active     { background:#f0fdf4; color:#15803d; }
        .badge-completed  { background:#f0fdf4; color:#15803d; }
        .badge-rejected   { background:#fef2f2; color:#dc2626; }
        .badge-returned   { background:#f0f9ff; color:#0369a1; }
        .badge-expired    { background:#fafafa; color:#6b7280; }
        .badge-mint       { background:#f0fdf4; color:#15803d; }
        .badge-excellent  { background:#f0f9ff; color:#0369a1; }
        .badge-good       { background:#fefce8; color:#a16207; }
        .badge-fair       { background:#fef2f2; color:#dc2626; }
        .badge-sale       { background:#f0fdf4; color:#15803d; }
        .badge-trade_in   { background:#f5f3ff; color:#6d28d9; }
        .badge-admin      { background:#0a0a0a; color:#fff; }
        .badge-staff      { background:#f0f0f0; color:#333; }
        .badge-appraiser  { background:#f0f9ff; color:#0369a1; }
        .badge-cash            { background:#f0fdf4; color:#15803d; }
        .badge-bank_transfer   { background:#f0f9ff; color:#0369a1; }
        .badge-check           { background:#fefce8; color:#a16207; }
        .badge-success    { background:#f0fdf4; color:#15803d; }
        .badge-warning    { background:#fefce8; color:#a16207; }

        /* ── FORMS ── */
        .form-grid { display: grid; gap: 1.25rem; }
        .form-grid-2 { grid-template-columns: 1fr 1fr; }
        .form-grid-3 { grid-template-columns: 1fr 1fr 1fr; }

        .form-group { display: flex; flex-direction: column; gap: 0.4rem; }

        .gt-label {
            font-size: 0.62rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--gray-mid);
        }

        .gt-input, .gt-select, .gt-textarea {
            background: var(--white);
            border: 1px solid var(--gray-light);
            color: var(--black);
            padding: 0.65rem 0.85rem;
            font-family: 'Didact Gothic', sans-serif;
            font-size: 0.85rem;
            width: 100%;
            border-radius: 0;
            transition: border-color 0.15s;
            appearance: none;
        }

        .gt-input:focus, .gt-select:focus, .gt-textarea:focus {
            outline: none;
            border-color: var(--black);
        }

        .gt-textarea { resize: vertical; min-height: 90px; }

        .form-error {
            font-size: 0.7rem;
            color: #dc2626;
            letter-spacing: 0.04em;
        }

        /* ── ALERTS ── */
        .alert {
            padding: 0.85rem 1.1rem;
            font-size: 0.8rem;
            margin-bottom: 1.5rem;
            border-left: 3px solid;
            letter-spacing: 0.03em;
        }

        .alert-success { background: #f0fdf4; border-color: #16a34a; color: #15803d; }
        .alert-error   { background: #fef2f2; border-color: #dc2626; color: #dc2626; }

        /* ── DIVIDER ── */
        .divider {
            height: 1px;
            background: var(--gray-pale);
            margin: 1.75rem 0;
        }

        /* ── EMPTY STATE ── */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--gray-mid);
        }

        .empty-state p {
            font-size: 0.85rem;
            margin-bottom: 1.25rem;
            letter-spacing: 0.05em;
        }

        /* ── DETAIL ROW ── */
        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
        }

        .detail-row {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--gray-pale);
        }

        .detail-label {
            font-size: 0.58rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--gray-mid);
        }

        .detail-value {
            font-size: 0.88rem;
            color: var(--black);
        }

        /* ── PAGE ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .page-body > * {
            animation: fadeUp 0.3s ease both;
        }

        .page-body > *:nth-child(2) { animation-delay: 0.05s; }
        .page-body > *:nth-child(3) { animation-delay: 0.1s; }
        .page-body > *:nth-child(4) { animation-delay: 0.15s; }

        /* checkbox style */
        .gt-checkbox { width: 16px; height: 16px; accent-color: var(--black); cursor: pointer; }
    </style>
</head>
<body>

    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <div class="sidebar-logo">
            <a href="{{ route('dashboard') }}" class="brand">Gentry</a>
            <span class="sub">Timepieces</span>
        </div>

        <nav class="sidebar-nav">
            <span class="nav-section-label">Overview</span>
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <span class="nav-section-label" style="margin-top:0.75rem;">Inventory</span>
            <a href="{{ route('watches.index') }}" class="sidebar-link {{ request()->routeIs('watches.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="1.5"/><path stroke-linecap="round" stroke-width="1.5" d="M12 7v5l3 3"/></svg>
                Inventory
            </a>

            <span class="nav-section-label" style="margin-top:0.75rem;">Operations</span>
            <a href="{{ route('clients.index') }}" class="sidebar-link {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Clients
            </a>
            <a href="{{ route('appraisals.index') }}" class="sidebar-link {{ request()->routeIs('appraisals.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Appraisals
            </a>
            <a href="{{ route('consignments.index') }}" class="sidebar-link {{ request()->routeIs('consignments.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                Consignments
            </a>
            <a href="{{ route('transactions.index') }}" class="sidebar-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Transactions
            </a>
            <a href="{{ route('payments.index') }}" class="sidebar-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                Payments
            </a>

            @if(auth()->user()->isAdmin())
            <span class="nav-section-label" style="margin-top:0.75rem;">Admin</span>
            <a href="{{ route('reports.index') }}" class="sidebar-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Reports
            </a>
            <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Users
            </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                Signed in as
                <strong>{{ auth()->user()->name }}</strong>
                <span style="font-size:0.58rem; letter-spacing:0.12em; text-transform:uppercase; color:#3a3a3a;">{{ auth()->user()->role }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Sign Out</button>
            </form>
        </div>
    </aside>

    {{-- MAIN --}}
    <div class="main-wrapper">
        @php
            $showHeader = !is_null($header) || isset($slots['header']) || !is_null($actions) || isset($slots['actions']);
        @endphp
        @if($showHeader)
        <div class="top-bar">
            @if(!is_null($header))
                <h1>{{ $header }}</h1>
            @elseif(isset($slots['header']))
                <h1>{{ $slots['header'] }}</h1>
            @endif
            @if(!is_null($actions))
                <div class="top-bar-actions">{{ $actions }}</div>
            @elseif(isset($slots['actions']))
                <div class="top-bar-actions">{{ $slots['actions'] }}</div>
            @endif
        </div>
        @endif

        <main class="page-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            {{ $slot }}
        </main>
    </div>

</body>
</html>
