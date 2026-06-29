@extends('layouts.app')

@section('title', 'Reports & Scorecards')
@section('page_title', 'Reports & Scorecards')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4 animate-fade-up">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-red-700">
                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                </div>
                <span class="text-xs font-bold text-red-700 uppercase tracking-widest">Balanced Scorecard</span>
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Reports & Scorecards</h1>
            <p class="text-sm text-slate-500 mt-1">Access annual, mid-year, and year-ender reports for each school year of the 5-year strategic plan.</p>
        </div>
        <div class="flex items-center gap-3 text-xs text-slate-500">
            <a href="{{ route('reports.five-year-plan') }}" class="btn-primary text-white gap-1.5" style="background:linear-gradient(135deg,#9b1c1c,#ef4444);">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" /></svg>
                5-Year Strategic Plan
            </a>
        </div>
    </div>

    {{-- 5-Year Plan Timeline Banner --}}
    <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-5 animate-fade-up animate-fade-up-1">
        <div class="flex items-center gap-3 mb-4">
            <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-violet-100 text-violet-600">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-800">5-Year Strategic Plan Timeline</h3>
                <p class="text-xs text-slate-400">AY 2024-2025 through AY 2028-2029</p>
            </div>
        </div>

        {{-- Timeline visual --}}
        <div class="relative">
            <div class="absolute top-1/2 left-0 right-0 h-0.5 bg-slate-200 -translate-y-1/2 rounded-full"></div>
            <div class="relative flex justify-between">
                @foreach ($schoolYears as $i => $sy)
                    @php
                        $startYear = (int) explode('-', $sy)[0];
                        $isCurrent = $startYear <= date('Y') && (int) explode('-', $sy)[1] >= date('Y');
                        $summary = $yearSummaries[$sy];
                        $totalReports = $summary['mid_year_count'] + $summary['year_ender_count'];
                    @endphp
                    <div class="flex flex-col items-center relative z-10">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full text-xs font-bold transition-all
                            {{ $isCurrent ? 'bg-red-700 text-white shadow-lg shadow-red-200 ring-4 ring-red-100' : ($totalReports > 0 ? 'bg-emerald-500 text-white' : 'bg-white border-2 border-slate-300 text-slate-500') }}">
                            @if ($totalReports > 0 && !$isCurrent)
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                            @else
                                {{ $i + 1 }}
                            @endif
                        </div>
                        <span class="mt-2 text-[10px] font-bold {{ $isCurrent ? 'text-red-700' : 'text-slate-500' }}">{{ $sy }}</span>
                        @if ($isCurrent)
                            <span class="mt-0.5 text-[8px] font-bold uppercase tracking-widest text-red-500 bg-red-50 px-1.5 py-0.5 rounded-full">Current</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Global Stats Bar --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 animate-fade-up animate-fade-up-2">
        @php
            $allOnTrack  = collect($yearSummaries)->sum('on_track');
            $allWarning  = collect($yearSummaries)->sum('warning');
            $allOffTrack = collect($yearSummaries)->sum('off_track');
            $allReports  = collect($yearSummaries)->sum(fn($s) => $s['mid_year_count'] + $s['year_ender_count']);
        @endphp
        <div class="stat-card p-4">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Total KPIs</p>
            <p class="text-2xl font-extrabold text-slate-800">{{ number_format($totalKpis) }}</p>
        </div>
        <div class="stat-card p-4">
            <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-500 mb-1">On Track</p>
            <p class="text-2xl font-extrabold text-emerald-600">{{ $allOnTrack }}</p>
        </div>
        <div class="stat-card p-4">
            <p class="text-[10px] font-bold uppercase tracking-wider text-amber-500 mb-1">Warning</p>
            <p class="text-2xl font-extrabold text-amber-600">{{ $allWarning }}</p>
        </div>
        <div class="stat-card p-4">
            <p class="text-[10px] font-bold uppercase tracking-wider text-red-500 mb-1">Off Track</p>
            <p class="text-2xl font-extrabold text-red-600">{{ $allOffTrack }}</p>
        </div>
    </div>

    {{-- School Year Cards --}}
    <div class="space-y-4 animate-fade-up animate-fade-up-3">
        <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
            School Year Reports
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach ($schoolYears as $sy)
                @php
                    $s = $yearSummaries[$sy];
                    $startYear = (int) explode('-', $sy)[0];
                    $isCurrent = $startYear <= date('Y') && (int) explode('-', $sy)[1] >= date('Y');
                    $midPct = $totalKpis > 0 ? round(($s['mid_year_count'] / $totalKpis) * 100) : 0;
                    $yePct  = $totalKpis > 0 ? round(($s['year_ender_count'] / $totalKpis) * 100) : 0;
                @endphp
                <div class="stat-card p-5 {{ $isCurrent ? 'ring-2 ring-red-200' : '' }}">
                    {{-- Year Header --}}
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2.5">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl {{ $isCurrent ? 'bg-red-700 text-white' : 'bg-slate-100 text-slate-600' }} font-bold text-sm">
                                {{ explode('-', $sy)[0][2] . explode('-', $sy)[0][3] }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">AY {{ $sy }}</p>
                                @if ($isCurrent)
                                    <span class="text-[9px] font-bold uppercase tracking-widest text-red-600 bg-red-50 px-1.5 py-0.5 rounded-full">Current Year</span>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('reports.school-year', $sy) }}" class="text-xs font-semibold text-red-700 hover:text-red-900 transition-colors flex items-center gap-1">
                            View
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                        </a>
                    </div>

                    {{-- Submission Progress --}}
                    <div class="space-y-3">
                        {{-- Mid-Year --}}
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Mid-Year</span>
                                <span class="text-[10px] font-bold text-slate-500">{{ $s['mid_year_count'] }} / {{ $totalKpis }}</span>
                            </div>
                            <div class="metric-progress">
                                <div class="metric-progress-fill" style="width: {{ $midPct }}%; background: linear-gradient(90deg, #2563eb, #60a5fa);"></div>
                            </div>
                        </div>

                        {{-- Year-Ender --}}
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Year-Ender</span>
                                <span class="text-[10px] font-bold text-slate-500">{{ $s['year_ender_count'] }} / {{ $totalKpis }}</span>
                            </div>
                            <div class="metric-progress">
                                <div class="metric-progress-fill" style="width: {{ $yePct }}%; background: linear-gradient(90deg, #059669, #34d399);"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Status Indicators --}}
                    @if ($s['on_track'] + $s['warning'] + $s['off_track'] > 0)
                        <div class="flex items-center gap-2 mt-4 pt-3 border-t border-slate-100">
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> {{ $s['on_track'] }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> {{ $s['warning'] }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> {{ $s['off_track'] }}
                            </span>
                        </div>
                    @endif

                    {{-- Quick Links --}}
                    <div class="flex gap-2 mt-3">
                        <a href="{{ route('reports.mid-year', $sy) }}" class="text-[10px] font-bold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-2.5 py-1 rounded-lg transition-colors">Mid-Year Report</a>
                        <a href="{{ route('reports.year-ender', $sy) }}" class="text-[10px] font-bold text-emerald-600 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 px-2.5 py-1 rounded-lg transition-colors">Year-Ender Report</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
