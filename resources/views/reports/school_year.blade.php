@extends('layouts.app')

@section('title', 'Annual Report — AY ' . $school_year)
@section('page_title', 'Annual Report — AY ' . $school_year)

@section('header_action')
<div class="flex items-center gap-2">
    <button onclick="window.print()" class="btn-secondary text-slate-700 hover:bg-slate-50 gap-1.5 cursor-pointer">
        <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.844l-2.437-2.437m0 0l2.437-2.437m-2.437 2.437H21M4.5 12V3.75A2.25 2.25 0 0 1 6.75 1.5h10.5a2.25 2.25 0 0 1 2.25 2.25V12" />
        </svg>
        Print / PDF
    </button>
    <a href="{{ route('reports.mid-year', $school_year) }}" class="btn-secondary text-slate-700 hover:bg-slate-50 gap-1.5">
        <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
        Mid-Year
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
        <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-red-50 border border-red-200/60 text-xs font-bold text-red-700">AY {{ $school_year }}</span>
    </nav>

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4 animate-fade-up">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Annual Scorecard</h1>
            <p class="text-sm text-slate-500 mt-1">Complete KPI performance report for School Year {{ $school_year }}, grouped by BSC Perspective and Strategic Objective.</p>
        </div>
    </div>

    {{-- Status Summary Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3 animate-fade-up animate-fade-up-1">
        @php
            $summaryCards = [
                ['label' => 'Total KPIs', 'value' => $statusSummary['total'], 'color' => 'slate', 'hex' => '#64748b'],
                ['label' => 'Mid-Year', 'value' => $statusSummary['mid_year_reported'], 'color' => 'blue', 'hex' => '#2563eb'],
                ['label' => 'Year-Ender', 'value' => $statusSummary['year_ender_reported'], 'color' => 'violet', 'hex' => '#7c3aed'],
                ['label' => 'On Track', 'value' => $statusSummary['on_track'], 'color' => 'emerald', 'hex' => '#059669'],
                ['label' => 'Warning', 'value' => $statusSummary['warning'], 'color' => 'amber', 'hex' => '#d97706'],
                ['label' => 'Off Track', 'value' => $statusSummary['off_track'], 'color' => 'red', 'hex' => '#dc2626'],
                ['label' => 'Pending', 'value' => $statusSummary['pending'], 'color' => 'slate', 'hex' => '#94a3b8'],
            ];
        @endphp
        @foreach ($summaryCards as $card)
            <div class="stat-card p-4 text-center">
                <p class="text-[9px] font-bold uppercase tracking-wider mb-1" style="color: {{ $card['hex'] }}">{{ $card['label'] }}</p>
                <p class="text-xl font-extrabold" style="color: {{ $card['hex'] }}">{{ $card['value'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- KPI Table grouped by Perspective → Objective --}}
    @foreach ($perspectives as $perspective)
        @if ($perspective->objectives->flatMap->kpis->count() > 0)
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm overflow-hidden animate-fade-up animate-fade-up-2">
            {{-- Perspective Header --}}
            <div class="px-5 py-4 border-b border-slate-100" style="background: linear-gradient(135deg, {{ $perspective->hex_color }}08, {{ $perspective->hex_color }}15);">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg text-white text-xs font-bold" style="background: {{ $perspective->hex_color }};">
                        {{ substr($perspective->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-800">{{ $perspective->name }}</h2>
                        <p class="text-[10px] text-slate-400">{{ $perspective->objectives->count() }} objectives · {{ $perspective->objectives->flatMap->kpis->count() }} KPIs</p>
                    </div>
                </div>
            </div>

            {{-- Objectives & KPIs --}}
            @foreach ($perspective->objectives as $objective)
                @if ($objective->kpis->count() > 0)
                <div class="border-b border-slate-50 last:border-b-0">
                    {{-- Objective Header --}}
                    <div class="px-5 py-3 bg-slate-50/50">
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-md text-white" style="background: {{ $perspective->hex_color }};">{{ $objective->code }}</span>
                            <span class="text-xs font-bold text-slate-700">{{ $objective->title }}</span>
                            <span class="text-[10px] text-slate-400 ml-auto">Owner: {{ $objective->owner }}</span>
                        </div>
                    </div>

                    {{-- KPI rows --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-100">
                                    <th class="text-left px-5 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">KPI</th>
                                    <th class="text-left px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Owner</th>
                                    <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Baseline</th>
                                    <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Target</th>
                                    <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-blue-500">Mid-Year</th>
                                    <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-emerald-500">Year-Ender</th>
                                    <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach ($objective->kpis as $kpi)
                                    @php
                                        $kpiResults = $results[$kpi->id] ?? collect();
                                        $midYear = $kpiResults->where('report_type', 'Mid-Year')->first();
                                        $yearEnder = $kpiResults->where('report_type', 'Year-Ender')->first();
                                        $latestResult = $yearEnder ?? $midYear;
                                        $status = $latestResult->status ?? 'Pending';
                                        $targetField = 'target_' . explode('-', $school_year)[0];
                                        $yearTarget = $kpi->{$targetField} ?? $kpi->target ?? '—';
                                    @endphp
                                    <tr class="table-row-accent accent-crimson hover:bg-slate-25 transition-colors">
                                        <td class="px-5 py-3">
                                            <a href="{{ route('kpis.show', $kpi->id) }}" class="hover:text-red-700 transition-colors">
                                                <span class="text-[10px] font-bold font-mono text-red-700 bg-red-50 px-1.5 py-0.5 rounded">{{ $kpi->measure_code }}</span>
                                                <span class="text-xs text-slate-700 ml-1.5 font-medium">{{ Str::limit($kpi->measure_name, 50) }}</span>
                                            </a>
                                        </td>
                                        <td class="px-3 py-3 text-xs text-slate-500">{{ $kpi->measure_owner }}</td>
                                        <td class="px-3 py-3 text-xs text-slate-500 text-center font-mono">{{ $kpi->baseline ?? '—' }}</td>
                                        <td class="px-3 py-3 text-xs text-slate-700 text-center font-mono font-semibold">{{ $yearTarget }}</td>
                                        <td class="px-3 py-3 text-center">
                                            @if ($midYear)
                                                <span class="text-xs font-bold font-mono {{ $midYear->status === 'On Track' ? 'text-emerald-600' : ($midYear->status === 'Warning' ? 'text-amber-600' : 'text-red-600') }}">
                                                    {{ $midYear->actual_value }}
                                                </span>
                                            @else
                                                <span class="text-[10px] text-slate-300">—</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-3 text-center">
                                            @if ($yearEnder)
                                                <span class="text-xs font-bold font-mono {{ $yearEnder->status === 'On Track' ? 'text-emerald-600' : ($yearEnder->status === 'Warning' ? 'text-amber-600' : 'text-red-600') }}">
                                                    {{ $yearEnder->actual_value }}
                                                </span>
                                            @else
                                                <span class="text-[10px] text-slate-300">—</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-3 text-center">
                                            @php
                                                $statusConfig = match ($status) {
                                                    'On Track'  => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'dot' => 'bg-emerald-500'],
                                                    'Warning'   => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'dot' => 'bg-amber-500'],
                                                    'Off Track' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'dot' => 'bg-red-500'],
                                                    default     => ['bg' => 'bg-slate-50', 'text' => 'text-slate-500', 'border' => 'border-slate-200', 'dot' => 'bg-slate-400'],
                                                };
                                            @endphp
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                                                {{ $status }}
                                            </span>
                                        </td>
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
    <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm overflow-hidden animate-fade-up animate-fade-up-3">
        <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/80">
            <div class="flex items-center gap-3">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-200 text-slate-600 text-xs font-bold">?</div>
                <div>
                    <h2 class="text-sm font-bold text-slate-700">General / Unmapped KPIs</h2>
                    <p class="text-[10px] text-slate-400">{{ $unmappedKpis->count() }} KPIs not yet assigned to a BSC Objective</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="text-left px-5 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">KPI</th>
                        <th class="text-left px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Owner</th>
                        <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Baseline</th>
                        <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Target</th>
                        <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-blue-500">Mid-Year</th>
                        <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-emerald-500">Year-Ender</th>
                        <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($unmappedKpis as $kpi)
                        @php
                            $kpiResults = $results[$kpi->id] ?? collect();
                            $midYear = $kpiResults->where('report_type', 'Mid-Year')->first();
                            $yearEnder = $kpiResults->where('report_type', 'Year-Ender')->first();
                            $latestResult = $yearEnder ?? $midYear;
                            $status = $latestResult->status ?? 'Pending';
                            $targetField = 'target_' . explode('-', $school_year)[0];
                            $yearTarget = $kpi->{$targetField} ?? $kpi->target ?? '—';
                        @endphp
                        <tr class="table-row-accent accent-crimson hover:bg-slate-25 transition-colors">
                            <td class="px-5 py-3">
                                <a href="{{ route('kpis.show', $kpi->id) }}" class="hover:text-red-700 transition-colors">
                                    <span class="text-[10px] font-bold font-mono text-red-700 bg-red-50 px-1.5 py-0.5 rounded">{{ $kpi->measure_code }}</span>
                                    <span class="text-xs text-slate-700 ml-1.5 font-medium">{{ Str::limit($kpi->measure_name, 50) }}</span>
                                </a>
                            </td>
                            <td class="px-3 py-3 text-xs text-slate-500">{{ $kpi->measure_owner }}</td>
                            <td class="px-3 py-3 text-xs text-slate-500 text-center font-mono">{{ $kpi->baseline ?? '—' }}</td>
                            <td class="px-3 py-3 text-xs text-slate-700 text-center font-mono font-semibold">{{ $yearTarget }}</td>
                            <td class="px-3 py-3 text-center">
                                @if ($midYear)
                                    <span class="text-xs font-bold font-mono {{ $midYear->status === 'On Track' ? 'text-emerald-600' : ($midYear->status === 'Warning' ? 'text-amber-600' : 'text-red-600') }}">{{ $midYear->actual_value }}</span>
                                @else
                                    <span class="text-[10px] text-slate-300">—</span>
                                @endif
                            </td>
                            <td class="px-3 py-3 text-center">
                                @if ($yearEnder)
                                    <span class="text-xs font-bold font-mono {{ $yearEnder->status === 'On Track' ? 'text-emerald-600' : ($yearEnder->status === 'Warning' ? 'text-amber-600' : 'text-red-600') }}">{{ $yearEnder->actual_value }}</span>
                                @else
                                    <span class="text-[10px] text-slate-300">—</span>
                                @endif
                            </td>
                            <td class="px-3 py-3 text-center">
                                @php
                                    $statusConfig = match ($status) {
                                        'On Track'  => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'dot' => 'bg-emerald-500'],
                                        'Warning'   => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'dot' => 'bg-amber-500'],
                                        'Off Track' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'dot' => 'bg-red-500'],
                                        default     => ['bg' => 'bg-slate-50', 'text' => 'text-slate-500', 'border' => 'border-slate-200', 'dot' => 'bg-slate-400'],
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                                    {{ $status }}
                                </span>
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
