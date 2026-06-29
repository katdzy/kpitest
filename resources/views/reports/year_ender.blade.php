@extends('layouts.app')

@section('title', 'Year-Ender Report — AY ' . $school_year)
@section('page_title', 'Year-Ender Report — AY ' . $school_year)

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
    <a href="{{ route('reports.mid-year', $school_year) }}" class="btn-secondary text-slate-700 hover:bg-slate-50 gap-1.5">
        <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
        Mid-Year
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
        <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-emerald-50 border border-emerald-200/60 text-xs font-bold text-emerald-700">Year-Ender</span>
    </nav>

    {{-- Page Header --}}
    <div class="animate-fade-up">
        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Year-Ender Final Report</h1>
        <p class="text-sm text-slate-500 mt-1">
            Definitive final scorecard for AY {{ $school_year }}
            @if ($prevYear)
                with year-over-year comparison against AY {{ $prevYear }}.
            @else
                (baseline year — no previous year for comparison).
            @endif
        </p>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 animate-fade-up animate-fade-up-1">
        @php
            $cards = [
                ['label' => 'Total KPIs', 'value' => $statusSummary['total'], 'hex' => '#64748b'],
                ['label' => 'Reported', 'value' => $statusSummary['reported'], 'hex' => '#7c3aed'],
                ['label' => 'Pending', 'value' => $statusSummary['pending'], 'hex' => '#94a3b8'],
                ['label' => 'On Track', 'value' => $statusSummary['on_track'], 'hex' => '#059669'],
                ['label' => 'Warning', 'value' => $statusSummary['warning'], 'hex' => '#d97706'],
                ['label' => 'Off Track', 'value' => $statusSummary['off_track'], 'hex' => '#dc2626'],
            ];
        @endphp
        @foreach ($cards as $card)
            <div class="stat-card p-4 text-center">
                <p class="text-[9px] font-bold uppercase tracking-wider mb-1" style="color: {{ $card['hex'] }}">{{ $card['label'] }}</p>
                <p class="text-xl font-extrabold" style="color: {{ $card['hex'] }}">{{ $card['value'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Results by Perspective → Objective --}}
    @foreach ($perspectives as $perspective)
        @if ($perspective->objectives->flatMap->kpis->count() > 0)
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm overflow-hidden animate-fade-up animate-fade-up-2">
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
                    {{-- Objective Header --}}
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
                                    <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Final Actual</th>
                                    <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Status</th>
                                    <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-violet-500">YoY Change</th>
                                    <th class="text-left px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Initiative Outcome</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach ($objective->kpis as $kpi)
                                    @php
                                        $result = $yearEnderResults[$kpi->id] ?? null;
                                        $prevResult = $prevYearResults[$kpi->id] ?? null;
                                        $targetField = 'target_' . explode('-', $school_year)[0];
                                        $yearTarget = $kpi->{$targetField} ?? $kpi->target ?? '—';

                                        // YoY calculation
                                        $yoyChange = null;
                                        $yoyDirection = null;
                                        if ($result && $prevResult && $prevResult->actual_value > 0) {
                                            $yoyChange = round((($result->actual_value - $prevResult->actual_value) / $prevResult->actual_value) * 100, 1);
                                            $yoyDirection = $yoyChange > 0 ? 'up' : ($yoyChange < 0 ? 'down' : 'flat');
                                        }

                                        // Status movement
                                        $statusMovement = null;
                                        if ($result && $prevResult) {
                                            $statusOrder = ['Off Track' => 0, 'Warning' => 1, 'On Track' => 2];
                                            $curr = $statusOrder[$result->status] ?? -1;
                                            $prev = $statusOrder[$prevResult->status] ?? -1;
                                            if ($curr > $prev) $statusMovement = 'improved';
                                            elseif ($curr < $prev) $statusMovement = 'declined';
                                            else $statusMovement = 'maintained';
                                        }
                                    @endphp
                                    <tr class="table-row-accent accent-crimson transition-colors">
                                        <td class="px-5 py-3">
                                            <a href="{{ route('kpis.show', $kpi->id) }}" class="hover:text-red-700 transition-colors">
                                                <span class="text-[10px] font-bold font-mono text-red-700 bg-red-50 px-1.5 py-0.5 rounded">{{ $kpi->measure_code }}</span>
                                                <span class="text-xs text-slate-700 ml-1.5 font-medium">{{ Str::limit($kpi->measure_name, 40) }}</span>
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
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold border bg-orange-50 text-orange-600 border-orange-200">Pending</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-3 text-center">
                                            @if ($yoyChange !== null)
                                                <div class="flex flex-col items-center gap-0.5">
                                                    <span class="inline-flex items-center gap-0.5 text-xs font-bold {{ $yoyDirection === 'up' ? 'text-emerald-600' : ($yoyDirection === 'down' ? 'text-red-600' : 'text-slate-500') }}">
                                                        @if ($yoyDirection === 'up')
                                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25" /></svg>
                                                        @elseif ($yoyDirection === 'down')
                                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 4.5l15 15m0 0V8.25m0 11.25H8.25" /></svg>
                                                        @else
                                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" /></svg>
                                                        @endif
                                                        {{ $yoyChange > 0 ? '+' : '' }}{{ $yoyChange }}%
                                                    </span>
                                                    @if ($statusMovement)
                                                        <span class="text-[8px] font-bold uppercase tracking-wider {{ $statusMovement === 'improved' ? 'text-emerald-500' : ($statusMovement === 'declined' ? 'text-red-500' : 'text-slate-400') }}">
                                                            {{ $statusMovement }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-[10px] text-slate-300">—</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-3 text-xs text-slate-600 max-w-[250px]">
                                            @if ($result && $result->initiative_outcome)
                                                <p class="line-clamp-2" title="{{ $result->initiative_outcome }}">{{ $result->initiative_outcome }}</p>
                                            @else
                                                <span class="text-[10px] text-slate-300">—</span>
                                            @endif
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
                        <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Final Actual</th>
                        <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Status</th>
                        <th class="text-center px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-violet-500">YoY Change</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($unmappedKpis as $kpi)
                        @php
                            $result = $yearEnderResults[$kpi->id] ?? null;
                            $prevResult = $prevYearResults[$kpi->id] ?? null;
                            $targetField = 'target_' . explode('-', $school_year)[0];
                            $yearTarget = $kpi->{$targetField} ?? $kpi->target ?? '—';
                            $yoyChange = null;
                            $yoyDirection = null;
                            if ($result && $prevResult && $prevResult->actual_value > 0) {
                                $yoyChange = round((($result->actual_value - $prevResult->actual_value) / $prevResult->actual_value) * 100, 1);
                                $yoyDirection = $yoyChange > 0 ? 'up' : ($yoyChange < 0 ? 'down' : 'flat');
                            }
                        @endphp
                        <tr class="table-row-accent accent-crimson transition-colors">
                            <td class="px-5 py-3">
                                <span class="text-[10px] font-bold font-mono text-red-700 bg-red-50 px-1.5 py-0.5 rounded">{{ $kpi->measure_code }}</span>
                                <span class="text-xs text-slate-700 ml-1.5 font-medium">{{ Str::limit($kpi->measure_name, 40) }}</span>
                            </td>
                            <td class="px-3 py-3 text-xs text-slate-500 text-center font-mono">{{ $yearTarget }}</td>
                            <td class="px-3 py-3 text-center">
                                @if ($result)
                                    <span class="text-xs font-bold font-mono {{ $result->status === 'On Track' ? 'text-emerald-600' : ($result->status === 'Warning' ? 'text-amber-600' : 'text-red-600') }}">{{ $result->actual_value }}</span>
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
                            <td class="px-3 py-3 text-center">
                                @if ($yoyChange !== null)
                                    <span class="text-xs font-bold {{ $yoyDirection === 'up' ? 'text-emerald-600' : ($yoyDirection === 'down' ? 'text-red-600' : 'text-slate-500') }}">
                                        {{ $yoyChange > 0 ? '+' : '' }}{{ $yoyChange }}%
                                    </span>
                                @else
                                    <span class="text-[10px] text-slate-300">—</span>
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
