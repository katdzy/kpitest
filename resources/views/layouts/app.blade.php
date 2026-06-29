<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') — University Portal</title>
    <meta name="description" content="University Institutional Records Portal — centralized management of KPIs, scholarships, research, outreach and accreditations.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <!-- Styles and Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --crimson: #9b1c1c;
            --crimson-dark: #7f1d1d;
            --crimson-deeper: #5c1212;
            --crimson-mid: #8b1a1a;
            --crimson-light: #b91c1c;
        }
        body { font-family: 'Instrument Sans', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', sans-serif; }

        @media print {
            aside, header, nav, button, a.btn-primary, a.btn-secondary, #page-load-bar, .no-print {
                display: none !important;
            }
            body {
                background: white !important;
                color: black !important;
                font-size: 11pt !important;
            }
            .lg\:pl-64 {
                padding-left: 0 !important;
            }
            main, .space-y-6, .py-6 {
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
                width: 100% !important;
            }
            .shadow-sm, .shadow-md, .shadow-lg, .shadow-xl, .shadow-2xl, .shadow-xs {
                box-shadow: none !important;
                border-radius: 0 !important;
            }
            .border, .border-slate-200\/60, .border-slate-100, .border-red-200\/60, .border-slate-150 {
                border: 1px solid #94a3b8 !important;
            }
            .bg-slate-50, .bg-slate-50\/80, .bg-slate-50\/50, .bg-slate-50\/30, .bg-red-50\/50, .bg-red-50\/30, .bg-violet-50, .bg-emerald-50\/50 {
                background-color: transparent !important;
                background-image: none !important;
            }
            .animate-fade-up, .animate-fade-up-1, .animate-fade-up-2, .animate-fade-up-3 {
                animation: none !important;
                transform: none !important;
                opacity: 1 !important;
            }
            .page-break {
                page-break-before: always !important;
            }
            table {
                width: 100% !important;
                border-collapse: collapse !important;
            }
            th, td {
                padding: 4px 6px !important;
                font-size: 9pt !important;
                color: black !important;
            }
            .text-slate-400, .text-slate-500, .text-slate-600 {
                color: #374151 !important;
            }
        }
    </style>
</head>
<body class="h-full flex bg-slate-50/80 antialiased selection:bg-red-800 selection:text-white"
      x-data="{ sidebarOpen: false }">

    {{-- ═══ Page Load Bar ═══ --}}
    <div id="page-load-bar"></div>

    {{-- ═══ Mobile Overlay ═══ --}}
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm z-30 lg:hidden"
         style="display:none;">
    </div>

    {{-- ═══ Sidebar ═══ --}}
    <aside class="fixed inset-y-0 left-0 z-40 flex flex-col w-64 sidebar-scroll overflow-y-auto
                  transform transition-transform duration-300 ease-in-out lg:translate-x-0"
           style="background: linear-gradient(165deg, #9b1c1c 0%, #7f1d1d 45%, #5c1212 100%)"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

        {{-- Brand --}}
        <div class="flex flex-col items-center px-5 pt-7 pb-6 border-b border-white/10">
            <div class="sidebar-logo-ring flex h-14 w-14 items-center justify-center rounded-2xl shadow-lg mb-3"
                 style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); box-shadow: 0 0 0 0 rgba(255,255,255,0.2);">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="2 2 20 20" stroke-width="1.8" stroke="white" class="size-7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A5.905 5.905 0 0 1 1.75 8.301l8.33-3.791a5.905 5.905 0 0 1 3.84 0l8.33 3.791a5.905 5.905 0 0 1 .53 10.428l-1.027.467m-15.482 0a50.57 50.57 0 0 1 15.482 0v5.334m-12-6.529V17.5a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-4.143m-9 0h9" />
                </svg>
            </div>
            <span class="text-white font-bold text-sm tracking-tight leading-tight text-center">University Portal</span>
            <span class="text-red-300 text-[10px] font-medium tracking-widest uppercase mt-0.5">Institutional Records</span>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5">

            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}"
               class="nav-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-semibold text-white/90 {{ request()->routeIs('dashboard') ? 'nav-active' : '' }}">
                <div class="flex h-7 w-7 items-center justify-center rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white/20' : 'bg-white/5' }} flex-shrink-0 transition-colors">
                    <svg class="h-4 w-4 text-red-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                </div>
                <span>Dashboard</span>
            </a>

            {{-- Section Label --}}
            <p class="px-3 pt-4 pb-1.5 text-[9px] font-black uppercase tracking-widest text-red-300/60 flex items-center gap-2">
                <span class="flex-1 h-px bg-red-400/20"></span>
                Modules
                <span class="flex-1 h-px bg-red-400/20"></span>
            </p>

            {{-- KPI Library --}}
            <a href="{{ route('kpis.index') }}"
               class="nav-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-semibold text-white/90 {{ request()->routeIs('kpis.index') || request()->routeIs('kpis.show') || request()->routeIs('kpis.create') || request()->routeIs('kpis.edit') ? 'nav-active' : '' }}">
                <div class="flex h-7 w-7 items-center justify-center rounded-lg {{ request()->routeIs('kpis.index') || request()->routeIs('kpis.show') || request()->routeIs('kpis.create') || request()->routeIs('kpis.edit') ? 'bg-white/20' : 'bg-white/5' }} flex-shrink-0 transition-colors">
                    <svg class="h-4 w-4 text-red-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 12h6m-6 4h4" />
                    </svg>
                </div>
                <span class="flex-1">KPI Library</span>
                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-md bg-white/10 text-white/60">
                    {{ \App\Models\Kpi::count() }}
                </span>
            </a>

            {{-- KPI Dashboard --}}
            <a href="{{ route('kpis.dashboard') }}"
               class="nav-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-semibold text-white/90 {{ request()->routeIs('kpis.dashboard') ? 'nav-active' : '' }}">
                <div class="flex h-7 w-7 items-center justify-center rounded-lg {{ request()->routeIs('kpis.dashboard') ? 'bg-white/20' : 'bg-white/5' }} flex-shrink-0 transition-colors">
                    <svg class="h-4 w-4 text-red-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/>
                    </svg>
                </div>
                <span class="flex-1">KPI Dashboard</span>
                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-md bg-red-400/20 text-red-300">NEW</span>
            </a>

            {{-- Upload Results --}}
            <a href="{{ route('kpis.import') }}"
               class="nav-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-semibold text-white/90 {{ request()->routeIs('kpis.import') ? 'nav-active' : '' }}">
                <div class="flex h-7 w-7 items-center justify-center rounded-lg {{ request()->routeIs('kpis.import') ? 'bg-white/20' : 'bg-white/5' }} flex-shrink-0 transition-colors">
                    <svg class="h-4 w-4 text-red-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                </div>
                <span>Upload Results</span>
            </a>

            {{-- Departments --}}
            <a href="{{ route('departments.index') }}"
               class="nav-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-semibold text-white/90 {{ request()->routeIs('departments.*') ? 'nav-active' : '' }}">
                <div class="flex h-7 w-7 items-center justify-center rounded-lg {{ request()->routeIs('departments.*') ? 'bg-white/20' : 'bg-white/5' }} flex-shrink-0 transition-colors">
                    <svg class="h-4 w-4 text-red-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                </div>
                <span class="flex-1">Departments</span>
                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-md bg-white/10 text-white/60">
                    {{ \App\Models\Department::count() }}
                </span>
            </a>

            {{-- Scholarships & Grants --}}
            <a href="{{ route('scholarships.index') }}"
               class="nav-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-semibold text-white/90 {{ request()->routeIs('scholarships.*') ? 'nav-active' : '' }}">
                <div class="flex h-7 w-7 items-center justify-center rounded-lg {{ request()->routeIs('scholarships.*') ? 'bg-white/20' : 'bg-white/5' }} flex-shrink-0 transition-colors">
                    <svg class="h-4 w-4 text-red-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A5.905 5.905 0 0 1 1.75 8.301l8.33-3.791a5.905 5.905 0 0 1 3.84 0l8.33 3.791a5.905 5.905 0 0 1 .53 10.428l-1.027.467m-15.482 0a50.57 50.57 0 0 1 15.482 0v5.334m-12-6.529V17.5a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-4.143m-9 0h9" />
                    </svg>
                </div>
                <span class="flex-1">Scholarships &amp; Grants</span>
                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-md bg-white/10 text-white/60">
                    {{ \App\Models\Scholarship::count() }}
                </span>
            </a>

            {{-- Outreach Programs --}}
            <a href="{{ route('outreach.index') }}"
               class="nav-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-semibold text-white/90 {{ request()->routeIs('outreach.*') ? 'nav-active' : '' }}">
                <div class="flex h-7 w-7 items-center justify-center rounded-lg {{ request()->routeIs('outreach.*') ? 'bg-white/20' : 'bg-white/5' }} flex-shrink-0 transition-colors">
                    <svg class="h-4 w-4 text-red-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                </div>
                <span class="flex-1">Outreach Programs</span>
                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-md bg-white/10 text-white/60">
                    {{ \App\Models\OutreachProgram::count() }}
                </span>
            </a>

            {{-- Accreditations --}}
            <a href="{{ route('accreditations.index') }}"
               class="nav-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-semibold text-white/90 {{ request()->routeIs('accreditations.*') ? 'nav-active' : '' }}">
                <div class="flex h-7 w-7 items-center justify-center rounded-lg {{ request()->routeIs('accreditations.*') ? 'bg-white/20' : 'bg-white/5' }} flex-shrink-0 transition-colors">
                    <svg class="h-4 w-4 text-red-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                    </svg>
                </div>
                <span class="flex-1">Accreditations</span>
                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-md bg-white/10 text-white/60">
                    {{ \App\Models\Accreditation::count() }}
                </span>
            </a>

            {{-- Research --}}
            <a href="{{ route('research.index') }}"
               class="nav-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-semibold text-white/90 {{ request()->routeIs('research.*') ? 'nav-active' : '' }}">
                <div class="flex h-7 w-7 items-center justify-center rounded-lg {{ request()->routeIs('research.*') ? 'bg-white/20' : 'bg-white/5' }} flex-shrink-0 transition-colors">
                    <svg class="h-4 w-4 text-red-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 1-6.23-.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                    </svg>
                </div>
                <span class="flex-1">Research</span>
                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-md bg-white/10 text-white/60">
                    {{ \App\Models\ResearchProject::count() }}
                </span>
            </a>

            {{-- Section Label: Reports --}}
            <p class="px-3 pt-4 pb-1.5 text-[9px] font-black uppercase tracking-widest text-red-300/60 flex items-center gap-2">
                <span class="flex-1 h-px bg-red-400/20"></span>
                Reports
                <span class="flex-1 h-px bg-red-400/20"></span>
            </p>

            {{-- Reports & Scorecards --}}
            <a href="{{ route('reports.index') }}"
               class="nav-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-semibold text-white/90 {{ request()->routeIs('reports.index') || request()->routeIs('reports.school-year') || request()->routeIs('reports.mid-year') || request()->routeIs('reports.year-ender') ? 'nav-active' : '' }}">
                <div class="flex h-7 w-7 items-center justify-center rounded-lg {{ request()->routeIs('reports.*') ? 'bg-white/20' : 'bg-white/5' }} flex-shrink-0 transition-colors">
                    <svg class="h-4 w-4 text-red-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <span class="flex-1">Reports & Scorecards</span>
                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-md bg-red-400/20 text-red-300">NEW</span>
            </a>

            {{-- 5-Year Strategic Plan --}}
            <a href="{{ route('reports.five-year-plan') }}"
               class="nav-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-semibold text-white/90 {{ request()->routeIs('reports.five-year-plan') ? 'nav-active' : '' }}">
                <div class="flex h-7 w-7 items-center justify-center rounded-lg {{ request()->routeIs('reports.five-year-plan') ? 'bg-white/20' : 'bg-white/5' }} flex-shrink-0 transition-colors">
                    <svg class="h-4 w-4 text-red-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" />
                    </svg>
                </div>
                <span>5-Year Strategic Plan</span>
            </a>

            {{-- Strategy Map --}}
            <a href="{{ route('strategy-map') }}"
               class="nav-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-semibold text-white/90 {{ request()->routeIs('strategy-map') ? 'nav-active' : '' }}">
                <div class="flex h-7 w-7 items-center justify-center rounded-lg {{ request()->routeIs('strategy-map') ? 'bg-white/20' : 'bg-white/5' }} flex-shrink-0 transition-colors">
                    <svg class="h-4 w-4 text-red-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25A2.25 2.25 0 0 1 13.5 8.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-1.5 2.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                </div>
                <span>Strategy Map</span>
            </a>

        </nav>

        {{-- Sidebar Footer --}}
        <div class="px-4 py-4 border-t border-white/10">
            <div class="flex items-center justify-between">
                <p class="text-[9px] text-red-300/50 uppercase tracking-widest font-semibold">v3.0.0</p>
                <p class="text-[9px] text-red-300/50">© {{ date('Y') }}</p>
            </div>
        </div>
    </aside>

    {{-- ═══ Main wrapper (offset by sidebar) ═══ --}}
    <div class="flex flex-col flex-1 min-w-0 min-h-full lg:pl-64">

        {{-- Top bar --}}
        <header class="sticky top-0 z-20 flex h-14 items-center border-b border-slate-200/70 bg-white/85 backdrop-blur-md px-4 sm:px-6 lg:px-8 gap-3">
            {{-- Mobile menu toggle --}}
            <button @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden inline-flex items-center justify-center rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-700 focus:outline-none transition-colors">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            {{-- Page title --}}
            <div class="flex-1 min-w-0">
                <h1 class="text-sm font-bold text-slate-800 truncate">@yield('page_title', 'Dashboard')</h1>
            </div>

            {{-- Right actions --}}
            <div class="flex items-center gap-3">
                {{-- Date chip --}}
                <span class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-100 text-xs font-medium text-slate-500 border border-slate-200/60">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                    </svg>
                    {{ date('M d, Y') }}
                </span>

                @hasSection('header_action')
                    @yield('header_action')
                @endif

                {{-- User Avatar placeholder --}}
                <div class="flex h-8 w-8 items-center justify-center rounded-full text-white text-xs font-bold flex-shrink-0 shadow-sm"
                     style="background: linear-gradient(135deg, #9b1c1c, #7f1d1d)"
                     title="Admin User">
                    A
                </div>
            </div>
        </header>

        {{-- Main content --}}
        <main class="flex-1 py-7">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                {{-- Flash success --}}
                @if(session('success'))
                    <div x-data="{ show: true }"
                         x-show="show"
                         x-init="setTimeout(() => show = false, 4500)"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="mb-6 flex items-center justify-between rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 shadow-sm">
                        <div class="flex items-center space-x-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 flex-shrink-0">
                                <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 ml-4 focus:outline-none p-1 rounded-lg hover:bg-emerald-100 transition-colors">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                {{-- Validation errors --}}
                @if($errors->any())
                    <div x-data="{ show: true }"
                         x-show="show"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="mb-6 rounded-xl bg-red-50 border border-red-200 px-4 py-3 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-100 flex-shrink-0">
                                    <svg class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-bold text-red-800">Please fix the following errors:</p>
                            </div>
                            <button @click="show = false" class="text-red-400 hover:text-red-600 focus:outline-none p-1 rounded-lg hover:bg-red-100 transition-colors">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <ul class="mt-2 pl-11 list-disc text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')

            </div>
        </main>

        {{-- Footer --}}
        <footer class="border-t border-slate-200/70 bg-white/60 backdrop-blur-sm py-4">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-2">
                <p class="text-xs text-slate-400">© {{ date('Y') }} University Institutional Records Portal. All rights reserved.</p>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-slate-100 border border-slate-200 text-[10px] font-bold text-slate-500 tracking-wider">v3.0.0</span>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Simple page load bar animation
        (function() {
            const bar = document.getElementById('page-load-bar');
            if (!bar) return;
            let w = 0;
            const t = setInterval(() => {
                w += Math.random() * 15;
                if (w > 85) w = 85;
                bar.style.width = w + '%';
            }, 120);
            window.addEventListener('load', () => {
                clearInterval(t);
                bar.style.width = '100%';
                setTimeout(() => { bar.style.opacity = '0'; bar.style.transition = 'opacity 0.4s'; }, 300);
            });
        })();
    </script>

</body>
</html>
