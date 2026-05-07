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
            --color-primary: #111827;
            --color-gray-50: #f9fafb;
            --color-gray-100: #f3f4f6;
            --color-gray-200: #e5e7eb;
            --color-gray-300: #d1d5db;
            --color-gray-400: #9ca3af;
            --color-gray-500: #6b7280;
            --color-gray-600: #4b5563;
            --color-gray-700: #374151;
            --color-gray-800: #1f2937;
            --color-gray-900: #111827;
            --color-white: #ffffff;
            --color-success: #10b981;
            --color-danger: #ef4444;
            --color-warning: #f59e0b;
            --sidebar-width: 260px;
            --font-sans: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            --font-serif: 'Playfair Display', serif;
        }

        body {
            background: var(--color-gray-50);
            color: var(--color-gray-900);
            font-family: var(--font-sans);
            font-size: 14px;
            font-weight: 500;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--color-gray-900);
            display: grid;
            grid-template-rows: auto minmax(0, 1fr) auto;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 50;
            overflow: hidden;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.12);
        }

        .sidebar-logo {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-logo .brand {
            font-family: var(--font-serif);
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--color-white);
            letter-spacing: 0.05em;
            text-decoration: none;
            display: block;
        }

        .sidebar-logo .sub {
            font-size: 0.65rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 4px;
            font-weight: 500;
        }

        .sidebar-nav {
            min-height: 0;
            padding: 1.5rem 0;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior: contain;
        }

        .nav-section-label {
            font-size: 0.68rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.35);
            padding: 1rem 1.5rem 0.5rem;
            font-weight: 700;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: rgba(255, 255, 255, 0.65);
            text-decoration: none;
            font-size: 0.9rem;
            letter-spacing: 0.025em;
            transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 2px solid transparent;
            font-weight: 500;
        }

        .sidebar-link:hover {
            color: var(--color-white);
            background: rgba(255, 255, 255, 0.08);
            border-left-color: rgba(255, 255, 255, 0.3);
        }

        .sidebar-link-button {
            width: 100%;
            background: none;
            border: 0;
            text-align: left;
            font: inherit;
            appearance: none;
        }

        .sidebar-link.active {
            color: var(--color-white);
            border-left-color: var(--color-white);
            background: rgba(255, 255, 255, 0.12);
            font-weight: 600;
        }

        .sidebar-link svg {
            width: 18px;
            height: 18px;
            opacity: 0.7;
            flex-shrink: 0;
        }

        .sidebar-link.active svg { opacity: 1; }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-user {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 1rem;
            letter-spacing: 0.04em;
            font-weight: 500;
        }

        .sidebar-user strong { 
            color: rgba(255, 255, 255, 0.85); 
            display: block; 
            font-weight: 600;
            margin-top: 3px;
        }

        .btn-logout {
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: rgba(255, 255, 255, 0.7);
            padding: 0.6rem;
            font-family: var(--font-sans);
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.15s;
            border-radius: 4px;
            font-weight: 600;
        }

        .btn-logout:hover {
            background: rgba(255, 255, 255, 0.15);
            color: var(--color-white);
            border-color: rgba(255, 255, 255, 0.3);
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
            background: var(--color-white);
            border-bottom: 1px solid var(--color-gray-200);
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 40;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .top-bar h1 {
            font-family: var(--font-serif);
            font-size: 1.75rem;
            font-weight: 600;
            letter-spacing: -0.01em;
            color: var(--color-gray-900);
            margin: 0;
        }

        .top-bar-actions { 
            display: flex; 
            gap: 1rem; 
            align-items: center;
        }

        .page-body {
            padding: 2rem;
            flex: 1;
            max-width: 100%;
        }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.65rem 1.25rem;
            font-family: var(--font-sans);
            font-size: 0.9rem;
            letter-spacing: 0.025em;
            text-decoration: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid transparent;
            font-weight: 500;
        }

        .btn:focus {
            outline: 2px solid transparent;
            outline-offset: 2px;
        }

        .btn-primary {
            background: var(--color-primary);
            color: var(--color-white);
            border-color: var(--color-primary);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .btn-primary:hover { 
            background: var(--color-gray-700);
            border-color: var(--color-gray-700);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: var(--color-white);
            color: var(--color-gray-700);
            border-color: var(--color-gray-300);
        }

        .btn-secondary:hover { 
            border-color: var(--color-gray-400);
            background: var(--color-gray-50);
        }

        .btn-danger {
            background: var(--color-danger);
            color: var(--color-white);
            border-color: var(--color-danger);
        }

        .btn-danger:hover { 
            background: #dc2626;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }

        .btn-success {
            background: var(--color-success);
            color: var(--color-white);
            border-color: var(--color-success);
        }

        .btn-success:hover { 
            background: #059669;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .btn-sm {
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
        }

        .btn-ghost {
            background: transparent;
            color: var(--color-gray-600);
            padding: 0.5rem;
        }

        .btn-ghost:hover {
            background: var(--color-gray-100);
            color: var(--color-primary);
        }

        /* ── CARDS ── */
        .card {
            background: var(--color-white);
            border: 1px solid var(--color-gray-200);
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.18s ease;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .card-black {
            background: var(--color-primary);
            color: var(--color-white);
            border: none;
        }

        /* ── STATS ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--color-white);
            padding: 1.5rem;
            border-radius: 8px;
            border: 1px solid var(--color-gray-200);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.18s ease;
        }

        .stat-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .stat-label {
            font-size: 0.75rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--color-gray-500);
            margin-bottom: 0.75rem;
            font-weight: 600;
        }

        .stat-value {
            font-family: var(--font-serif);
            font-size: 2rem;
            font-weight: 700;
            color: var(--color-primary);
            line-height: 1;
            letter-spacing: -0.02em;
        }

        .stat-value.green { color: var(--color-success); }
        .stat-value.blue { color: #0284c7; }
        .stat-value.purple { color: #7c3aed; }

        /* ── TABLE ── */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 8px;
            border: 1px solid var(--color-gray-200);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .gt-table {
            width: 100%;
            border-collapse: collapse;
        }

        .gt-table thead tr {
            border-bottom: 1px solid var(--color-gray-200);
            background: var(--color-gray-50);
        }

        .gt-table th {
            font-size: 0.75rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--color-gray-600);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            white-space: nowrap;
        }

        .gt-table tbody tr {
            border-bottom: 1px solid var(--color-gray-200);
            transition: background 0.15s ease;
        }

        .gt-table tbody tr:hover { 
            background: var(--color-gray-50);
        }

        .gt-table td {
            padding: 1rem;
            font-size: 0.9rem;
            color: var(--color-gray-700);
            vertical-align: middle;
        }

        /* ── BADGES ── */
        .badge {
            display: inline-block;
            font-size: 0.7rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.4rem 0.8rem;
            font-weight: 600;
            border-radius: 4px;
        }

        .badge-available  { background: #d1fae5; color: #065f46; }
        .badge-sold       { background: #fee2e2; color: #7f1d1d; }
        .badge-consigned  { background: #fef3c7; color: #78350f; }
        .badge-reserved   { background: #ede9fe; color: #4c1d95; }
        .badge-pending    { background: #fef3c7; color: #78350f; }
        .badge-confirmed  { background: #d1fae5; color: #065f46; }
        .badge-failed     { background: #fee2e2; color: #7f1d1d; }
        .badge-active     { background: #d1fae5; color: #065f46; }
        .badge-completed  { background: #d1fae5; color: #065f46; }
        .badge-rejected   { background: #fee2e2; color: #7f1d1d; }
        .badge-returned   { background: #dbeafe; color: #0c2340; }
        .badge-expired    { background: #f3f4f6; color: #4b5563; }
        .badge-mint       { background: #d1fae5; color: #065f46; }
        .badge-excellent  { background: #dbeafe; color: #0c2340; }
        .badge-good       { background: #fef3c7; color: #78350f; }
        .badge-fair       { background: #fee2e2; color: #7f1d1d; }
        .badge-sale       { background: #d1fae5; color: #065f46; }
        .badge-buy        { background: #dbeafe; color: #1d4ed8; }
        .badge-trade_in   { background: #ede9fe; color: #4c1d95; }
        .badge-admin      { background: #1f2937; color: #fff; }
        .badge-staff      { background: #e5e7eb; color: #374151; }
        .badge-appraiser  { background: #dbeafe; color: #0c2340; }
        .badge-cash            { background: #d1fae5; color: #065f46; }
        .badge-bank_transfer   { background: #dbeafe; color: #0c2340; }
        .badge-check           { background: #fef3c7; color: #78350f; }
        .badge-success    { background: #d1fae5; color: #065f46; }
        .badge-warning    { background: #fef3c7; color: #78350f; }

        /* ── FORMS ── */
        .form-grid { display: grid; gap: 1.5rem; }
        .form-grid-2 { grid-template-columns: 1fr 1fr; }
        .form-grid-3 { grid-template-columns: 1fr 1fr 1fr; }

        .form-group { display: flex; flex-direction: column; gap: 0.5rem; }

        .form-label {
            font-size: 0.8rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--color-gray-600);
            font-weight: 600;
        }

        .gt-label {
            font-size: 0.8rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--color-gray-600);
            font-weight: 600;
        }

        .gt-input, .gt-select, .gt-textarea,
        .form-input, .form-select, .form-textarea {
            background: var(--color-white);
            border: 1px solid var(--color-gray-300);
            color: var(--color-gray-900);
            padding: 0.75rem 0.95rem;
            font-family: var(--font-sans);
            font-size: 0.9rem;
            width: 100%;
            border-radius: 6px;
            transition: all 0.18s ease;
            appearance: none;
        }

        .gt-input:focus, .gt-select:focus, .gt-textarea:focus,
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(17, 24, 39, 0.08);
        }

        .gt-input::placeholder, .gt-textarea::placeholder,
        .form-input::placeholder, .form-textarea::placeholder {
            color: var(--color-gray-400);
        }

        .gt-input:disabled, .gt-select:disabled, .gt-textarea:disabled,
        .form-input:disabled, .form-select:disabled, .form-textarea:disabled {
            background: var(--color-gray-100);
            color: var(--color-gray-500);
            cursor: not-allowed;
        }

        .gt-select, .form-select {
            background-image: linear-gradient(45deg, transparent 50%, #6b7280 50%), 
                              linear-gradient(135deg, #6b7280 50%, transparent 50%);
            background-position: calc(100% - 12px) calc(50% - 2px), calc(100% - 7px) calc(50% - 2px);
            background-size: 5px 5px, 5px 5px;
            background-repeat: no-repeat;
            padding-right: 2rem;
        }

        .gt-textarea, .form-textarea { 
            resize: vertical; 
            min-height: 100px;
        }

        .form-error {
            font-size: 0.75rem;
            color: var(--color-danger);
            letter-spacing: 0.02em;
            margin-top: 2px;
        }

        /* ── ALERTS ── */
        .alert {
            padding: 1rem 1.25rem;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid;
            border-radius: 6px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .alert-success { 
            background: #d1fae5; 
            border-color: var(--color-success); 
            color: #065f46; 
        }
        .alert-error   { 
            background: #fee2e2; 
            border-color: var(--color-danger); 
            color: #7f1d1d; 
        }

        /* ── DIVIDER ── */
        .divider {
            height: 1px;
            background: var(--color-gray-200);
            margin: 1.5rem 0;
        }

        /* ── EMPTY STATE ── */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--color-gray-500);
        }

        .empty-state p {
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
            letter-spacing: 0.02em;
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
            gap: 0.5rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--color-gray-200);
        }

        .detail-label {
            font-size: 0.75rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--color-gray-500);
            font-weight: 600;
        }

        .detail-value {
            font-size: 0.95rem;
            color: var(--color-gray-900);
            font-weight: 500;
        }

        /* ── PAGE ANIMATIONS ── */
        @keyframes fadeUp {
            from { 
                opacity: 0; 
                transform: translateY(12px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }

        .page-body > * {
            animation: fadeUp 0.4s ease both;
        }

        .page-body > *:nth-child(1) { animation-delay: 0.05s; }
        .page-body > *:nth-child(2) { animation-delay: 0.1s; }
        .page-body > *:nth-child(3) { animation-delay: 0.15s; }
        .page-body > *:nth-child(4) { animation-delay: 0.2s; }

        /* checkbox style */
        .gt-checkbox { 
            width: 18px; 
            height: 18px; 
            accent-color: var(--color-primary); 
            cursor: pointer;
        }

        @media (max-width: 1024px) {
            .form-grid-2, .form-grid-3 { grid-template-columns: 1fr; }
            .detail-grid { grid-template-columns: 1fr; }
        }
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
            <div class="top-bar-actions">
                @if(!is_null($actions))
                    {{ $actions }}
                @elseif(isset($slots['actions']))
                    {{ $slots['actions'] }}
                @endif
            </div>
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
