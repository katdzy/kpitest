@extends('layouts.app')

@section('title', 'Mid-Year Report — AY ' . $school_year)
@section('page_title', 'Mid-Year Report — AY ' . $school_year)

@section('header_action')
<div class="flex items-center gap-2">
    <button onclick="window.print()" class="btn-secondary text-slate-700 hover:bg-slate-50 gap-1.5 cursor-pointer">
        <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.844l-2.437-2.437m0 0l2.437-2.437m-2.437 2.437H21M4.5 12V3.75A2.25 2.25 0 0 1 6.75 1.5h10.5a2.25 2.25 0 0 1 2.25 2.25V12" />
        </svg>
        Print / PDF
    </button>
    <a href="{{ route('reports.school-year', $school_year) }}" class="btn-secondary text-slate-700 hover:bg-slate-50 gap-1.5">
        <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
        Annual Report
    </a>
    <a href="{{ route('reports.year-ender', $school_year) }}" class="btn-secondary text-slate-700 hover:bg-slate-50 gap-1.5">
        <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
        Year-Ender
    </a>
</div>
@endsection

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 animate-fade-up" aria-label="Breadcrumb">
        <a href="{{ route('reports.index') }}" class="text-xs font-semibold text-slate-500 uppercase tracking-wider hover:text-red-700 transition-colors">Reports</a>
        <svg class="w-3.5 h-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        <a href="{{ route('reports.school-year', $school_year) }}" class="text-xs font-semibold text-slate-500 uppercase tracking-wider hover:text-red-700 transition-colors">AY {{ $school_year }}</a>
        <svg class="w-3.5 h-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-blue-50 border border-blue-200/60 text-xs font-bold text-blue-700">Mid-Year</span>
    </nav>

    {{-- Page Header --}}
    <div class="animate-fade-up">
        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Mid-Year Update Report</h1>
        <p class="text-sm text-slate-500 mt-1">Review mid-year progress, identify at-risk KPIs, and track submission gaps for AY {{ $school_year }}.</p>
    </div>

    {{-- Summary Bar --}}
    <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-5 animate-fade-up animate-fade-up-1">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            {{-- Headline stat --}}
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800">
                        {{ $statusSummary['reported'] }} of {{ $statusSummary['total'] }} KPIs reported
                    </p>
                    <p class="text-xs text-slate-400">
                        {{ $statusSummary['pending'] }} pending submission{{ $statusSummary['pending'] !== 1 ? 's' : '' }}
                    </p>
                </div>
            </div>

            {{-- Status pills --}}
            <div class="flex flex-wrap gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    {{ $statusSummary['on_track'] }} On Track
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    {{ $statusSummary['warning'] }} Warning
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                    {{ $statusSummary['off_track'] }} Off Track
                </span>
            </div>
        </div>

        {{-- Progress bar --}}
        <div class="mt-4">
            @php $pct = $statusSummary['total'] > 0 ? round(($statusSummary['reported'] / $statusSummary['total']) * 100) : 0; @endphp
            <div class="flex items-center justify-between mb-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Submission Progress</span>
                <span class="text-[10px] font-bold text-blue-600">{{ $pct }}%</span>
            </div>
            <div class="metric-progress" style="height: 8px;">
                <div class="metric-progress-fill" style="width: {{ $pct }}%; background: linear-gradient(90deg, #2563eb, #60a5fa);"></div>
            </div>
        </div>
    </div>

    {{-- At-Risk KPIs --}}
    @if ($atRiskResults->count() > 0)
    <div class="rounded-2xl bg-white border border-red-200/60 shadow-sm overflow-hidden animate-fade-up animate-fade-up-2">
        <div class="px-5 py-4 border-b border-red-100 bg-red-50/50">
            <div class="flex items-center gap-3">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-100 text-red-600">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" /></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-red-800">At-Risk KPIs</h2>
                    <p class="text-[10px] text-red-600">{{ $atRiskResults->count() }} KPIs are Warning or Off Track at mid-year</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-red-100">
                        <th class="text-left px-5 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">KPI</th>
                        <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Target</th>
                        <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Actual</th>
                        <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Gap</th>
                        <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Status</th>
                        <th class="text-left px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Notes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-red-50">
                    @foreach ($atRiskResults as $result)
                        @php
                            $kpi = $result->kpi;
                            $gap = $result->target_value > 0 ? round((($result->actual_value - $result->target_value) / $result->target_value) * 100, 1) : 0;
                        @endphp
                        <tr class="hover:bg-red-50/30 transition-colors">
                            <td class="px-5 py-3">
                                <a href="{{ route('kpis.show', $kpi->id) }}" class="hover:text-red-700 transition-colors">
                                    <span class="text-[10px] font-bold font-mono text-red-700 bg-red-50 px-1.5 py-0.5 rounded">{{ $kpi->measure_code }}</span>
                                    <span class="text-xs text-slate-700 ml-1.5 font-medium">{{ Str::limit($kpi->measure_name, 40) }}</span>
                                </a>
                            </td>
                            <td class="px-3 py-3 text-xs text-slate-500 text-center font-mono">{{ $result->target_value }}</td>
                            <td class="px-3 py-3 text-xs font-bold text-center font-mono {{ $result->status === 'Off Track' ? 'text-red-600' : 'text-amber-600' }}">{{ $result->actual_value }}</td>
                            <td class="px-3 py-3 text-xs font-bold text-center {{ $gap < 0 ? 'text-red-600' : 'text-emerald-600' }}">{{ $gap > 0 ? '+' : '' }}{{ $gap }}%</td>
                            <td class="px-3 py-3 text-center">
                                @php
                                    $sc = $result->status === 'Warning'
                                        ? ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'dot' => 'bg-amber-500']
                                        : ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'dot' => 'bg-red-500'];
                                @endphp
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $sc['bg'] }} {{ $sc['text'] }} {{ $sc['border'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $sc['dot'] }}"></span>
                                    {{ $result->status }}
                                </span>
                            </td>
                            <td class="px-3 py-3 text-xs text-slate-500 max-w-[200px] truncate">{{ $result->notes ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Full Mid-Year Results by Perspective --}}
    @foreach ($perspectives as $perspective)
        @if ($perspective->objectives->flatMap->kpis->count() > 0)
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm overflow-hidden animate-fade-up animate-fade-up-3">
            {{-- Perspective Header --}}
            <div class="px-5 py-4 border-b border-slate-100" style="background: linear-gradient(135deg, {{ $perspective->hex_color }}08, {{ $perspective->hex_color }}15);">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg text-white text-xs font-bold" style="background: {{ $perspective->hex_color }};">
                        {{ substr($perspective->name, 0, 1) }}
                    </div>
                    <h2 class="text-sm font-bold text-slate-800">{{ $perspective->name }}</h2>
                </div>
            </div>

            @foreach ($perspective->objectives as $objective)
                @if ($objective->kpis->count() > 0)
                <div class="border-b border-slate-50 last:border-b-0">
                    <div class="px-5 py-2.5 bg-slate-50/50">
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-md text-white" style="background: {{ $perspective->hex_color }};">{{ $objective->code }}</span>
                            <span class="text-xs font-bold text-slate-700">{{ $objective->title }}</span>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-100">
                                    <th class="text-left px-5 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">KPI</th>
                                    <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Target</th>
                                    <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Actual</th>
                                    <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Status</th>
                                    <th class="text-left px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Notes</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach ($objective->kpis as $kpi)
                                    @php
                                        $result = $midYearResults[$kpi->id] ?? null;
                                        $isPending = in_array($kpi->id, $pendingKpiIds);
                                        $targetField = 'target_' . explode('-', $school_year)[0];
                                        $yearTarget = $kpi->{$targetField} ?? $kpi->target ?? '—';
                                    @endphp
                                    <tr class="table-row-accent accent-crimson transition-colors {{ $isPending ? 'bg-slate-50/50' : '' }}">
                                        <td class="px-5 py-3">
                                            <a href="{{ route('kpis.show', $kpi->id) }}" class="hover:text-red-700 transition-colors">
                                                <span class="text-[10px] font-bold font-mono text-red-700 bg-red-50 px-1.5 py-0.5 rounded">{{ $kpi->measure_code }}</span>
                                                <span class="text-xs text-slate-700 ml-1.5 font-medium">{{ Str::limit($kpi->measure_name, 45) }}</span>
                                            </a>
                                        </td>
                                        <td class="px-3 py-3 text-xs text-slate-500 text-center font-mono">{{ $yearTarget }}</td>
                                        <td class="px-3 py-3 text-center">
                                            @if ($result)
                                                <span class="text-xs font-bold font-mono {{ $result->status === 'On Track' ? 'text-emerald-600' : ($result->status === 'Warning' ? 'text-amber-600' : 'text-red-600') }}">
                                                    {{ $result->actual_value }}
                                                </span>
                                            @else
                                                <span class="text-[10px] text-slate-300 italic">Not submitted</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-3 text-center">
                                            @if ($result)
                                                @php
                                                    $sc = match ($result->status) {
                                                        'On Track'  => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'dot' => 'bg-emerald-500'],
                                                        'Warning'   => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'dot' => 'bg-amber-500'],
                                                        'Off Track' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'dot' => 'bg-red-500'],
                                                        default     => ['bg' => 'bg-slate-50', 'text' => 'text-slate-500', 'border' => 'border-slate-200', 'dot' => 'bg-slate-400'],
                                                    };
                                                @endphp
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $sc['bg'] }} {{ $sc['text'] }} {{ $sc['border'] }}">
                                                    <span class="w-1.5 h-1.5 rounded-full {{ $sc['dot'] }}"></span>
                                                    {{ $result->status }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold border bg-orange-50 text-orange-600 border-orange-200">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-3 text-xs text-slate-500 max-w-[200px] truncate">{{ $result->notes ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        @endif
    @endforeach

    {{-- Unmapped KPIs --}}
    @if ($unmappedKpis->count() > 0)
    <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm overflow-hidden animate-fade-up">
        <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/80">
            <div class="flex items-center gap-3">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-200 text-slate-600 text-xs font-bold">?</div>
                <h2 class="text-sm font-bold text-slate-700">General / Unmapped KPIs</h2>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="text-left px-5 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">KPI</th>
                        <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Target</th>
                        <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Actual</th>
                        <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($unmappedKpis as $kpi)
                        @php
                            $result = $midYearResults[$kpi->id] ?? null;
                            $targetField = 'target_' . explode('-', $school_year)[0];
                            $yearTarget = $kpi->{$targetField} ?? $kpi->target ?? '—';
                        @endphp
                        <tr class="table-row-accent accent-crimson transition-colors">
                            <td class="px-5 py-3">
                                <span class="text-[10px] font-bold font-mono text-red-700 bg-red-50 px-1.5 py-0.5 rounded">{{ $kpi->measure_code }}</span>
                                <span class="text-xs text-slate-700 ml-1.5 font-medium">{{ Str::limit($kpi->measure_name, 45) }}</span>
                            </td>
                            <td class="px-3 py-3 text-xs text-slate-500 text-center font-mono">{{ $yearTarget }}</td>
                            <td class="px-3 py-3 text-center">
                                @if ($result)
                                    <span class="text-xs font-bold font-mono">{{ $result->actual_value }}</span>
                                @else
                                    <span class="text-[10px] text-slate-300">—</span>
                                @endif
                            </td>
                            <td class="px-3 py-3 text-center">
                                @if ($result)
                                    @php
                                        $sc = match ($result->status) {
                                            'On Track'  => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'dot' => 'bg-emerald-500'],
                                            'Warning'   => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'dot' => 'bg-amber-500'],
                                            'Off Track' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'dot' => 'bg-red-500'],
                                            default     => ['bg' => 'bg-slate-50', 'text' => 'text-slate-500', 'border' => 'border-slate-200', 'dot' => 'bg-slate-400'],
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $sc['bg'] }} {{ $sc['text'] }} {{ $sc['border'] }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $sc['dot'] }}"></span>
                                        {{ $result->status }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold border bg-orange-50 text-orange-600 border-orange-200">Pending</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>
@endsection
