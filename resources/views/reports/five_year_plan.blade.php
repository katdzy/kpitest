@extends('layouts.app')

@section('title', '5-Year Strategic Plan Overview')
@section('page_title', '5-Year Strategic Plan')

@section('header_action')
<a href="{{ route('reports.index') }}" class="btn-secondary text-slate-700 hover:bg-slate-50 gap-1.5">
    <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" /></svg>
    All Reports
</a>
@endsection

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 animate-fade-up" aria-label="Breadcrumb">
        <a href="{{ route('reports.index') }}" class="text-xs font-semibold text-slate-500 uppercase tracking-wider hover:text-red-700 transition-colors">Reports</a>
        <svg class="w-3.5 h-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-violet-50 border border-violet-200/60 text-xs font-bold text-violet-700">5-Year Strategic Plan</span>
    </nav>

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4 animate-fade-up">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-violet-50 text-violet-700">
                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" /></svg>
                </div>
                <span class="text-xs font-bold text-violet-700 uppercase tracking-widest">Executive Scorecard</span>
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">5-Year Strategic Plan Overview</h1>
            <p class="text-sm text-slate-500 mt-1">All 15 Strategic Objectives mapped across 5 school years — AY 2024-2025 through AY 2028-2029.</p>
        </div>
    </div>

    {{-- Legend --}}
    <div class="flex flex-wrap items-center gap-4 animate-fade-up animate-fade-up-1">
        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Legend:</span>
        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-emerald-700">
            <span class="w-3 h-3 rounded-full bg-emerald-500"></span> On Track
        </span>
        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-amber-700">
            <span class="w-3 h-3 rounded-full bg-amber-400"></span> Warning
        </span>
        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-red-700">
            <span class="w-3 h-3 rounded-full bg-red-500"></span> Off Track
        </span>
        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-slate-500">
            <span class="w-3 h-3 rounded-full bg-slate-300"></span> Pending
        </span>
    </div>

    {{-- Year Summary Row --}}
    <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm overflow-hidden animate-fade-up animate-fade-up-2">
        <div class="px-5 py-3 bg-slate-50/80 border-b border-slate-100">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Year-by-Year Target Attainment</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="text-left px-5 py-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 w-36">Metric</th>
                        @foreach ($schoolYears as $sy)
                            @php $isCurrent = (int)explode('-', $sy)[0] <= date('Y') && (int)explode('-', $sy)[1] >= date('Y'); @endphp
                            <th class="text-center px-3 py-3 text-[10px] font-bold uppercase tracking-wider {{ $isCurrent ? 'text-red-700 bg-red-50/50' : 'text-slate-400' }}">
                                {{ $sy }}
                                @if ($isCurrent)
                                    <span class="block text-[7px] text-red-500 mt-0.5">CURRENT</span>
                                @endif
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                        $metrics = [
                            ['label' => 'On Track', 'key' => 'on_track', 'color' => '#059669'],
                            ['label' => 'Warning', 'key' => 'warning', 'color' => '#d97706'],
                            ['label' => 'Off Track', 'key' => 'off_track', 'color' => '#dc2626'],
                            ['label' => 'Pending', 'key' => 'pending', 'color' => '#94a3b8'],
                        ];
                    @endphp
                    @foreach ($metrics as $metric)
                        <tr class="border-b border-slate-50">
                            <td class="px-5 py-2.5">
                                <span class="inline-flex items-center gap-1.5 text-xs font-bold" style="color: {{ $metric['color'] }};">
                                    <span class="w-2 h-2 rounded-full" style="background: {{ $metric['color'] }};"></span>
                                    {{ $metric['label'] }}
                                </span>
                            </td>
                            @foreach ($schoolYears as $sy)
                                @php $isCurrent = (int)explode('-', $sy)[0] <= date('Y') && (int)explode('-', $sy)[1] >= date('Y'); @endphp
                                <td class="text-center px-3 py-2.5 {{ $isCurrent ? 'bg-red-50/30' : '' }}">
                                    <span class="text-sm font-bold" style="color: {{ $metric['color'] }};">{{ $yearTotals[$sy][$metric['key']] }}</span>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    <tr class="bg-slate-50/50">
                        <td class="px-5 py-2.5 text-xs font-bold text-slate-600">Attainment %</td>
                        @foreach ($schoolYears as $sy)
                            @php
                                $isCurrent = (int)explode('-', $sy)[0] <= date('Y') && (int)explode('-', $sy)[1] >= date('Y');
                                $attainment = $yearTotals[$sy]['total'] > 0
                                    ? round(($yearTotals[$sy]['on_track'] / $yearTotals[$sy]['total']) * 100)
                                    : 0;
                            @endphp
                            <td class="text-center px-3 py-2.5 {{ $isCurrent ? 'bg-red-50/30' : '' }}">
                                <span class="text-sm font-extrabold {{ $attainment >= 80 ? 'text-emerald-600' : ($attainment >= 50 ? 'text-amber-600' : 'text-red-600') }}">
                                    {{ $attainment }}%
                                </span>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Objective Grid by Perspective --}}
    @foreach ($perspectives as $perspective)
        @if ($perspective->objectives->count() > 0)
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm overflow-hidden animate-fade-up animate-fade-up-3">
            {{-- Perspective Header --}}
            <div class="px-5 py-4 border-b border-slate-100" style="background: linear-gradient(135deg, {{ $perspective->hex_color }}08, {{ $perspective->hex_color }}15);">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg text-white text-xs font-bold" style="background: {{ $perspective->hex_color }};">
                        {{ substr($perspective->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-800">{{ $perspective->name }}</h2>
                        <p class="text-[10px] text-slate-400">{{ $perspective->objectives->count() }} strategic objectives</p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <th class="text-left px-5 py-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 min-w-[220px]">Objective</th>
                            @foreach ($schoolYears as $sy)
                                @php $isCurrent = (int)explode('-', $sy)[0] <= date('Y') && (int)explode('-', $sy)[1] >= date('Y'); @endphp
                                <th class="text-center px-3 py-3 text-[10px] font-bold uppercase tracking-wider {{ $isCurrent ? 'text-red-700 bg-red-50/50' : 'text-slate-400' }} min-w-[100px]">
                                    {{ $sy }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($perspective->objectives as $objective)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-5 py-4">
                                    <div class="flex items-start gap-2">
                                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded text-white flex-shrink-0 mt-0.5" style="background: {{ $perspective->hex_color }};">{{ $objective->code }}</span>
                                        <div>
                                            <p class="text-xs font-bold text-slate-700 leading-snug">{{ $objective->title }}</p>
                                            <p class="text-[10px] text-slate-400 mt-0.5">{{ $objective->owner }}</p>
                                        </div>
                                    </div>
                                </td>
                                @foreach ($schoolYears as $sy)
                                    @php
                                        $isCurrent = (int)explode('-', $sy)[0] <= date('Y') && (int)explode('-', $sy)[1] >= date('Y');
                                        $kpiStatuses = $matrix[$objective->id][$sy] ?? [];
                                    @endphp
                                    <td class="px-3 py-4 text-center {{ $isCurrent ? 'bg-red-50/30' : '' }}">
                                        @if (count($kpiStatuses) > 0)
                                            <div class="flex flex-wrap justify-center gap-1" x-data>
                                                @foreach ($kpiStatuses as $kpiStatus)
                                                    @php
                                                        $dotColor = match ($kpiStatus['status']) {
                                                            'On Track'  => 'bg-emerald-500',
                                                            'Warning'   => 'bg-amber-400',
                                                            'Off Track' => 'bg-red-500',
                                                            default     => 'bg-slate-300',
                                                        };
                                                    @endphp
                                                    <div class="relative group/dot">
                                                        <span class="w-3.5 h-3.5 rounded-full {{ $dotColor }} inline-block cursor-pointer transition-transform hover:scale-125"></span>
                                                        {{-- Tooltip --}}
                                                        <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 hidden group-hover/dot:block z-50">
                                                            <div class="bg-slate-800 text-white text-[10px] rounded-lg px-3 py-2 shadow-xl whitespace-nowrap min-w-[140px]">
                                                                <p class="font-bold">{{ $kpiStatus['kpi_code'] }}</p>
                                                                <p class="text-slate-300 mt-0.5">{{ Str::limit($kpiStatus['kpi_name'], 35) }}</p>
                                                                <div class="flex items-center justify-between mt-1.5 pt-1.5 border-t border-slate-600">
                                                                    <span class="text-slate-400">Target: <span class="text-white">{{ $kpiStatus['target'] ?? 'N/A' }}</span></span>
                                                                    <span class="text-slate-400">Actual: <span class="text-white font-bold">{{ $kpiStatus['actual'] ?? '—' }}</span></span>
                                                                </div>
                                                                <p class="mt-1 font-bold {{ $kpiStatus['status'] === 'On Track' ? 'text-emerald-400' : ($kpiStatus['status'] === 'Warning' ? 'text-amber-400' : ($kpiStatus['status'] === 'Off Track' ? 'text-red-400' : 'text-slate-400')) }}">{{ $kpiStatus['status'] }}</p>
                                                                <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-px">
                                                                    <div class="w-0 h-0 border-x-4 border-x-transparent border-t-4 border-t-slate-800"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-[10px] text-slate-300">—</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    @endforeach

</div>
@endsection
