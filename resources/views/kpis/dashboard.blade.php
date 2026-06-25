@extends('layouts.app')

@section('title', 'KPI Library Dashboard')
@section('page_title', 'KPI Library Dashboard')

@section('header_action')
<div class="flex items-center gap-2">
    <a href="{{ route('kpis.index') }}" class="btn-secondary text-slate-700 hover:bg-slate-50 gap-1.5">
        <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/></svg>
        View All KPIs
    </a>
    <a href="{{ route('kpis.create') }}" class="btn-primary text-white gap-1.5" style="background:linear-gradient(135deg,#9b1c1c,#ef4444);">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Add New KPI
    </a>
</div>
@endsection

@section('content')
@php
    $statusConfig = [
        'Active'       => ['color' => 'emerald', 'hex' => '#059669', 'lightHex' => '#d1fae5', 'icon' => 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
        'Draft'        => ['color' => 'slate',   'hex' => '#64748b', 'lightHex' => '#f1f5f9', 'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z'],
        'Under Review' => ['color' => 'amber',   'hex' => '#d97706', 'lightHex' => '#fef3c7', 'icon' => 'M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z'],
        'Approved'     => ['color' => 'blue',    'hex' => '#2563eb', 'lightHex' => '#dbeafe', 'icon' => 'M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z'],
        'Archived'     => ['color' => 'rose',    'hex' => '#e11d48', 'lightHex' => '#ffe4e6', 'icon' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z'],
    ];
@endphp

<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4 animate-fade-up">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-red-700">
                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/></svg>
                </div>
                <span class="text-xs font-bold text-red-700 uppercase tracking-widest">KPI Library</span>
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Library Dashboard</h1>
            <p class="text-sm text-slate-500 mt-1">Health, usage, and lifecycle status of all {{ number_format($total) }} KPIs across the institution.</p>
        </div>
        <div class="flex items-center gap-3 text-xs text-slate-500">
            <div class="flex items-center gap-1.5 bg-white border border-slate-200 rounded-full px-3 py-1.5 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Live data
            </div>
            <span class="text-slate-300">·</span>
            <span>{{ now()->format('M j, Y · g:i A') }}</span>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 flex items-center gap-3 text-sm text-emerald-800 font-medium animate-fade-up">
            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="rounded-xl bg-red-50 border border-red-200 px-4 py-3 flex items-center gap-3 text-sm text-red-800 font-medium animate-fade-up">
            <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ═══ STATUS SUMMARY CARDS ═══ --}}
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5 animate-fade-up animate-fade-up-1">
        @foreach ($statusCounts as $statusName => $data)
        @php $cfg = $statusConfig[$statusName]; @endphp
        <div class="stat-card p-5 group relative overflow-hidden">
            {{-- Background glow on hover --}}
            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none" style="background: radial-gradient(circle at 80% 20%, {{ $cfg['lightHex'] }}88 0%, transparent 70%);"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">{{ $statusName }}</p>
                    <div class="flex h-7 w-7 rounded-lg items-center justify-center" style="background-color: {{ $cfg['lightHex'] }};">
                        <svg class="h-4 w-4" style="color: {{ $cfg['hex'] }};" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $cfg['icon'] }}"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-3xl font-extrabold text-slate-900">{{ number_format($data['count']) }}</h3>
                <div class="mt-2 flex items-center justify-between">
                    <div class="flex-1 bg-slate-100 rounded-full h-1.5 mr-2">
                        <div class="h-1.5 rounded-full transition-all duration-700" style="width: {{ $data['percentage'] }}%; background-color: {{ $cfg['hex'] }};"></div>
                    </div>
                    <span class="text-[11px] font-bold" style="color: {{ $cfg['hex'] }};">{{ $data['percentage'] }}%</span>
                </div>
            </div>
            <div class="absolute bottom-0 inset-x-0 h-0.5 group-hover:h-1 transition-all" style="background-color: {{ $cfg['hex'] }};"></div>
        </div>
        @endforeach
    </div>

    {{-- ═══ 5-YEAR STRATEGIC PLAN ═══ --}}
    <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm overflow-hidden animate-fade-up animate-fade-up-2">
        <div class="px-6 py-3.5 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider">5-Year Target Trajectory</h3>
            </div>
            <span class="text-[10px] font-bold text-slate-400">AY 2024–2028</span>
        </div>
        <div class="flex flex-col sm:flex-row divide-y sm:divide-y-0 sm:divide-x divide-slate-100">
            @foreach([2024, 2025, 2026, 2027, 2028] as $year)
            <div class="flex-1 p-5 text-center relative group hover:bg-slate-50 transition-colors">
                <div class="text-[11px] font-bold uppercase tracking-wider mb-2 {{ date('Y') == $year ? 'text-indigo-600' : 'text-slate-500' }}">Target {{ $year }}</div>
                <div class="text-3xl font-extrabold text-slate-900">{{ number_format($fiveYearPlan[$year] ?? 0) }}</div>
                <div class="text-xs text-slate-400 mt-1 font-medium">KPIs with targets</div>
                @if(date('Y') == $year)
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-indigo-500 rounded-t-md"></div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- ═══ STATUS WORKFLOW PIPELINE ═══ --}}
    <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm overflow-hidden animate-fade-up animate-fade-up-3">
        <div class="px-6 py-3.5 border-b border-slate-100 flex items-center gap-2">
            <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
            <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider">KPI Status Workflow</h3>
            <span class="ml-auto text-[11px] text-slate-400">Lifecycle stages</span>
        </div>
        <div class="p-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-0">
                @foreach ($statusCounts as $statusName => $data)
                @php
                    $cfg = $statusConfig[$statusName];
                    $isLast = $loop->last;
                @endphp
                <div class="flex sm:flex-col items-center sm:items-center flex-1 min-w-0">
                    {{-- Stage node --}}
                    <div class="flex flex-col items-center">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl shadow-sm border-2 transition-all"
                             style="background-color: {{ $cfg['lightHex'] }}; border-color: {{ $data['count'] > 0 ? $cfg['hex'] : '#e2e8f0' }};">
                            <svg class="h-5 w-5" style="color: {{ $data['count'] > 0 ? $cfg['hex'] : '#94a3b8' }};" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $cfg['icon'] }}"/>
                            </svg>
                        </div>
                        <span class="mt-2 text-[11px] font-bold text-center whitespace-nowrap" style="color: {{ $cfg['hex'] }};">{{ $statusName }}</span>
                        <div class="mt-1 flex items-center gap-1">
                            <span class="text-lg font-extrabold text-slate-900">{{ $data['count'] }}</span>
                            <span class="text-[10px] text-slate-400 font-medium">({{ $data['percentage'] }}%)</span>
                        </div>
                    </div>
                </div>
                @if (!$isLast)
                <div class="hidden sm:flex items-center justify-center w-8 flex-shrink-0">
                    <svg class="w-5 h-5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </div>
                @endif
                @endforeach
            </div>
            {{-- Allowed Transitions Note --}}
            <div class="mt-5 pt-4 border-t border-slate-100">
                <p class="text-[11px] text-slate-400 font-medium mb-2 uppercase tracking-wider">Allowed Transitions</p>
                <div class="flex flex-wrap gap-2 text-[11px]">
                    @foreach (\App\Models\Kpi::STATUS_TRANSITIONS as $from => $tos)
                    @php $fromCfg = $statusConfig[$from]; @endphp
                    <div class="flex items-center gap-1.5 bg-slate-50 border border-slate-100 rounded-lg px-2 py-1">
                        <span class="font-bold" style="color: {{ $fromCfg['hex'] }};">{{ $from }}</span>
                        <svg class="w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                        <span class="text-slate-600">{{ implode(', ', $tos) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ═══ CHARTS ROW ═══ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 animate-fade-up animate-fade-up-3">

        {{-- Category Breakdown Chart --}}
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm overflow-hidden">
            <div class="px-6 py-3.5 border-b border-slate-100 flex items-center gap-2">
                <svg class="w-4 h-4 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider">KPIs by Category</h3>
                <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-violet-50 text-violet-600 border border-violet-200/60">{{ $byCategory->count() }} categories</span>
            </div>
            <div class="p-6 space-y-3">
                @php
                    $catPalette = ['#8b5cf6','#3b82f6','#10b981','#f59e0b','#ef4444','#ec4899','#14b8a6','#f97316','#6366f1'];
                    $maxCatCount = $byCategory->max('count') ?: 1;
                @endphp
                @forelse ($byCategory as $idx => $cat)
                <div class="flex items-center gap-3 group cursor-default">
                    <div class="w-24 text-right text-xs font-semibold text-slate-600 truncate flex-shrink-0">{{ $cat['label'] }}</div>
                    <div class="flex-1 bg-slate-100 rounded-full h-6 relative overflow-hidden">
                        <div class="h-full rounded-full flex items-center justify-end pr-2 transition-all duration-700"
                             style="width: {{ ($cat['count'] / $maxCatCount) * 100 }}%; background-color: {{ $catPalette[$idx % count($catPalette)] }}; min-width: 2.5rem;">
                            <span class="text-white text-[11px] font-bold">{{ $cat['count'] }}</span>
                        </div>
                    </div>
                    <div class="text-[11px] font-bold text-slate-400 w-8 text-right">{{ $cat['pct'] }}%</div>
                </div>
                @empty
                <p class="text-sm text-slate-400 text-center py-6">No KPIs found.</p>
                @endforelse
            </div>
        </div>

        {{-- Year Range Distribution --}}
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm overflow-hidden">
            <div class="px-6 py-3.5 border-b border-slate-100 flex items-center gap-2">
                <svg class="w-4 h-4 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
                <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider">KPIs by Academic Year</h3>
                <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-sky-50 text-sky-600 border border-sky-200/60">{{ $byYear->count() }} years</span>
            </div>
            <div class="p-6">
                @php $maxYearCount = $byYear->max('count') ?: 1; @endphp
                @if ($byYear->isEmpty())
                    <p class="text-sm text-slate-400 text-center py-6">No data available.</p>
                @else
                <div class="flex items-end gap-2 h-40 mt-2">
                    @foreach ($byYear as $yr)
                    @php $barH = max(8, ($yr['count'] / $maxYearCount) * 100); @endphp
                    <div class="flex flex-col items-center gap-1 flex-1" title="{{ $yr['label'] }}: {{ $yr['count'] }} KPIs">
                        <span class="text-[10px] font-bold text-slate-600">{{ $yr['count'] }}</span>
                        <div class="w-full rounded-t-md transition-all duration-700" style="height: {{ $barH }}%; background: linear-gradient(to top, #9b1c1c, #ef4444);"></div>
                        <span class="text-[9px] text-slate-400 font-medium text-center leading-tight">{{ str_replace('-', '–', $yr['label']) }}</span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ═══ SCOPE + HEALTH ALERTS ROW ═══ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-fade-up animate-fade-up-4">

        {{-- Scope Distribution --}}
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm overflow-hidden">
            <div class="px-6 py-3.5 border-b border-slate-100 flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z"/></svg>
                <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider">Scope Distribution</h3>
            </div>
            <div class="p-6">
                @php
                    $scopeTotal = ($byScope['Institutional'] + $byScope['Departmental']) ?: 1;
                    $instPct = round(($byScope['Institutional'] / $scopeTotal) * 100);
                    $deptPct = round(($byScope['Departmental']  / $scopeTotal) * 100);
                @endphp
                {{-- Donut-like horizontal split --}}
                <div class="flex items-center gap-2 mb-4">
                    <div class="flex-1 flex h-4 rounded-full overflow-hidden">
                        <div class="h-full bg-violet-500 transition-all duration-700" style="width: {{ $instPct }}%;"></div>
                        <div class="h-full bg-sky-400 transition-all duration-700" style="width: {{ $deptPct }}%;"></div>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-violet-500 flex-shrink-0"></span>
                            <span class="text-sm font-semibold text-slate-700">Institutional</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-extrabold text-slate-900">{{ $byScope['Institutional'] }}</span>
                            <span class="text-xs text-slate-400 font-medium">{{ $instPct }}%</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-sky-400 flex-shrink-0"></span>
                            <span class="text-sm font-semibold text-slate-700">Departmental</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-extrabold text-slate-900">{{ $byScope['Departmental'] }}</span>
                            <span class="text-xs text-slate-400 font-medium">{{ $deptPct }}%</span>
                        </div>
                    </div>
                </div>
                <div class="mt-5 pt-4 border-t border-slate-100 text-center">
                    <span class="text-3xl font-extrabold text-slate-900">{{ number_format($total) }}</span>
                    <p class="text-xs text-slate-400 font-medium mt-0.5">Total KPIs</p>
                </div>
            </div>
        </div>

        {{-- Health Alerts --}}
        <div class="lg:col-span-2 rounded-2xl bg-white border border-slate-200/60 shadow-sm overflow-hidden">
            <div class="px-6 py-3.5 border-b border-slate-100 flex items-center gap-2">
                <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider">Data Quality Alerts</h3>
                @php $totalAlerts = array_sum($healthAlerts); @endphp
                @if ($totalAlerts > 0)
                    <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200/60">{{ $totalAlerts }} issues</span>
                @else
                    <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">✓ All good</span>
                @endif
            </div>
            <div class="p-6">
                @php
                    $alertItems = [
                        'no_target'      => ['label' => 'Missing Target Value',   'desc' => 'KPIs without a defined target', 'color' => 'red',   'icon' => 'M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z'],
                        'no_description' => ['label' => 'Missing Description',    'desc' => 'KPIs with no description text', 'color' => 'amber', 'icon' => 'M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z'],
                        'no_data_source' => ['label' => 'Missing Data Source',    'desc' => 'KPIs without data source info', 'color' => 'orange','icon' => 'M20.25 6.375c0 8.485-7.5 11.9-7.5 11.9s-7.5-3.415-7.5-11.9a7.5 7.5 0 0 1 15 0Z'],
                        'no_formula'     => ['label' => 'Missing Formula',         'desc' => 'KPIs with no calculation formula', 'color' => 'violet','icon' => 'M4.745 3A23.933 23.933 0 0 0 3 12c0 3.183.62 6.22 1.745 9M19.255 3A23.933 23.933 0 0 1 21 12c0 3.183-.62 6.22-1.745 9M8.25 8.885l1.444-.89a.75.75 0 0 1 1.105.402l2.402 7.206a.75.75 0 0 0 1.104.401l1.445-.889m-8.25.75.213.09a1.687 1.687 0 0 0 2.062-.617l4.45-6.676a1.688 1.688 0 0 1 2.062-.618l.213.09'],
                        'no_baseline'    => ['label' => 'Missing Baseline Value', 'desc' => 'KPIs without a baseline measure', 'color' => 'sky',   'icon' => 'M3 4.5h14.25M3 9h9.75M3 13.5h9.75m4.5-4.5v12m0 0-3.75-3.75M17.25 21 21 17.25'],
                    ];
                    $colorMap = [
                        'red'    => ['bg' => 'bg-red-50',    'text' => 'text-red-600',    'border' => 'border-red-200/60',    'bar' => '#ef4444'],
                        'amber'  => ['bg' => 'bg-amber-50',  'text' => 'text-amber-600',  'border' => 'border-amber-200/60',  'bar' => '#f59e0b'],
                        'orange' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-600', 'border' => 'border-orange-200/60', 'bar' => '#f97316'],
                        'violet' => ['bg' => 'bg-violet-50', 'text' => 'text-violet-600', 'border' => 'border-violet-200/60', 'bar' => '#8b5cf6'],
                        'sky'    => ['bg' => 'bg-sky-50',    'text' => 'text-sky-600',    'border' => 'border-sky-200/60',    'bar' => '#0ea5e9'],
                    ];
                @endphp
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach ($alertItems as $key => $alert)
                    @php
                        $count = $healthAlerts[$key];
                        $pct   = $total > 0 ? round(($count / $total) * 100) : 0;
                        $cc    = $colorMap[$alert['color']];
                        $severity = $pct > 50 ? 'High' : ($pct > 20 ? 'Medium' : 'Low');
                    @endphp
                    <div class="flex items-start gap-3 p-3 rounded-xl border {{ $count > 0 ? $cc['border'] . ' ' . $cc['bg'] : 'border-slate-100 bg-slate-50' }} group hover:shadow-sm transition-all">
                        <div class="flex-shrink-0 flex h-8 w-8 items-center justify-center rounded-lg {{ $count > 0 ? $cc['bg'] . ' border ' . $cc['border'] : 'bg-white border border-slate-200' }}">
                            <svg class="h-4 w-4 {{ $count > 0 ? $cc['text'] : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $alert['icon'] }}"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <p class="text-xs font-bold text-slate-700 truncate">{{ $alert['label'] }}</p>
                                <span class="text-sm font-extrabold {{ $count > 0 ? $cc['text'] : 'text-emerald-600' }} flex-shrink-0">
                                    {{ $count > 0 ? $count : '✓' }}
                                </span>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ $alert['desc'] }}</p>
                            @if ($count > 0)
                            <div class="mt-1.5 flex items-center gap-1.5">
                                <div class="flex-1 h-1 bg-white/70 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full" style="width:{{ $pct }}%; background-color: {{ $cc['bar'] }};"></div>
                                </div>
                                <span class="text-[10px] font-bold {{ $cc['text'] }}">{{ $pct }}%</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ═══ RECENT ACTIVITY + TRANSITIONS ROW ═══ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-fade-up animate-fade-up-5">

        {{-- Recently Updated KPIs --}}
        <div class="lg:col-span-2 rounded-2xl bg-white border border-slate-200/60 shadow-sm overflow-hidden">
            <div class="px-6 py-3.5 border-b border-slate-100 flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider">Recently Updated</h3>
                <a href="{{ route('kpis.index') }}" class="ml-auto text-[11px] font-semibold text-red-700 hover:text-red-900 hover:underline">View all →</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($recentKpis as $kpi)
                @php
                    $sCfg = $statusConfig[$kpi->status] ?? ['hex' => '#94a3b8', 'lightHex' => '#f1f5f9'];
                @endphp
                <div class="px-6 py-3 flex items-center gap-3 hover:bg-slate-50/50 transition-colors group">
                    <div class="flex-shrink-0 flex h-8 w-8 items-center justify-center rounded-lg text-[11px] font-extrabold" style="background-color: {{ $sCfg['lightHex'] }}; color: {{ $sCfg['hex'] }};">
                        {{ strtoupper(substr($kpi->category ?? 'K', 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('kpis.show', $kpi->id) }}" class="text-sm font-bold text-slate-800 hover:text-red-700 transition-colors truncate group-hover:underline decoration-2 underline-offset-2">{{ $kpi->measure_name }}</a>
                        </div>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="text-[10px] font-mono text-slate-400 font-semibold">{{ $kpi->measure_code }}</span>
                            <span class="text-slate-300">·</span>
                            <span class="text-[10px] text-slate-400">{{ $kpi->year_range }}</span>
                            <span class="text-slate-300">·</span>
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold" style="background-color: {{ $sCfg['lightHex'] }}; color: {{ $sCfg['hex'] }};">{{ $kpi->status }}</span>
                        </div>
                    </div>
                    <div class="flex-shrink-0 text-right">
                        <span class="text-[10px] text-slate-400">{{ $kpi->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
                @empty
                <div class="px-6 py-10 text-center text-sm text-slate-400">No KPIs found.</div>
                @endforelse
            </div>
        </div>

        {{-- Status Transition Quick Actions --}}
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm overflow-hidden">
            <div class="px-6 py-3.5 border-b border-slate-100 flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/></svg>
                <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider">Status Transitions</h3>
            </div>
            @if ($recentTransitions->isEmpty())
            <div class="p-6">
                <div class="text-center text-slate-400 py-4">
                    <svg class="h-10 w-10 mx-auto text-slate-200 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/></svg>
                    <p class="text-xs font-medium">No status changes in the last 7 days.</p>
                    <p class="text-[11px] text-slate-300 mt-1">Transitions will appear here.</p>
                </div>
                {{-- Show quick-transition widget for recent KPIs --}}
                <div class="mt-4 pt-4 border-t border-slate-100">
                    <p class="text-[11px] text-slate-400 uppercase tracking-wider font-bold mb-3">Quick Transition</p>
                    @foreach ($recentKpis->take(3) as $kpi)
                    @php
                        $sCfg    = $statusConfig[$kpi->status] ?? ['hex' => '#94a3b8', 'lightHex' => '#f1f5f9'];
                        $allowed = $kpi->allowedTransitions();
                    @endphp
                    @if (!empty($allowed))
                    <div class="mb-3 p-2.5 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-[11px] font-semibold text-slate-700 truncate mb-1.5">{{ Str::limit($kpi->measure_name, 28) }}</p>
                        <div class="flex flex-wrap gap-1">
                            @foreach ($allowed as $nextStatus)
                            @php $nCfg = $statusConfig[$nextStatus] ?? ['hex' => '#94a3b8', 'lightHex' => '#f1f5f9']; @endphp
                            <form action="{{ route('kpis.status', $kpi->id) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="{{ $nextStatus }}">
                                <button type="submit" class="text-[10px] font-bold px-2 py-0.5 rounded border transition-all hover:shadow-sm cursor-pointer" style="color: {{ $nCfg['hex'] }}; border-color: {{ $nCfg['hex'] }}55; background-color: {{ $nCfg['lightHex'] }};">
                                    → {{ $nextStatus }}
                                </button>
                            </form>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @else
            <div class="divide-y divide-slate-100">
                @foreach ($recentTransitions as $kpi)
                @php $sCfg = $statusConfig[$kpi->status] ?? ['hex' => '#94a3b8', 'lightHex' => '#f1f5f9']; @endphp
                <div class="px-4 py-3 hover:bg-slate-50/50 transition-colors">
                    <a href="{{ route('kpis.show', $kpi->id) }}" class="text-xs font-bold text-slate-700 hover:text-red-700 block truncate">{{ $kpi->measure_name }}</a>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold" style="background-color: {{ $sCfg['lightHex'] }}; color: {{ $sCfg['hex'] }};">{{ $kpi->status }}</span>
                        <span class="text-[10px] text-slate-400">{{ $kpi->status_changed_at?->diffForHumans() }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            {{-- Quick Transition --}}
            <div class="p-4 border-t border-slate-100">
                <p class="text-[11px] text-slate-400 uppercase tracking-wider font-bold mb-3">Quick Transition</p>
                @foreach ($recentKpis->take(2) as $kpi)
                @php
                    $allowed = $kpi->allowedTransitions();
                @endphp
                @if (!empty($allowed))
                <div class="mb-2 p-2 bg-slate-50 rounded-lg border border-slate-100">
                    <p class="text-[11px] font-semibold text-slate-700 truncate mb-1">{{ Str::limit($kpi->measure_name, 28) }}</p>
                    <div class="flex flex-wrap gap-1">
                        @foreach ($allowed as $nextStatus)
                        @php $nCfg = $statusConfig[$nextStatus] ?? ['hex' => '#94a3b8', 'lightHex' => '#f1f5f9']; @endphp
                        <form action="{{ route('kpis.status', $kpi->id) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="{{ $nextStatus }}">
                            <button type="submit" class="text-[10px] font-bold px-2 py-0.5 rounded border cursor-pointer" style="color: {{ $nCfg['hex'] }}; border-color: {{ $nCfg['hex'] }}55; background-color: {{ $nCfg['lightHex'] }};">→ {{ $nextStatus }}</button>
                        </form>
                        @endforeach
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            @endif
        </div>
    </div>

    {{-- ═══ FOOTER QUICK LINKS ═══ --}}
    <div class="rounded-2xl bg-gradient-to-r from-red-900 to-rose-800 p-6 text-white overflow-hidden relative animate-fade-up">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 50%, rgba(255,255,255,0.3) 0%, transparent 60%);"></div>
        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h3 class="text-lg font-extrabold">Manage Your KPI Library</h3>
                <p class="text-red-200 text-sm mt-0.5">Add new KPIs, review drafts, or import performance results.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('kpis.index') }}" class="inline-flex items-center gap-1.5 bg-white/10 hover:bg-white/20 border border-white/20 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/></svg>
                    Browse Library
                </a>
                <a href="{{ route('kpis.create') }}" class="inline-flex items-center gap-1.5 bg-white text-red-800 hover:bg-red-50 text-sm font-bold px-4 py-2 rounded-xl transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Add New KPI
                </a>
                <a href="{{ route('kpis.import') }}" class="inline-flex items-center gap-1.5 bg-white/10 hover:bg-white/20 border border-white/20 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    Import Results
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
