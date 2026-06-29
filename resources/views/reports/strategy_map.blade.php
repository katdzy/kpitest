@extends('layouts.app')

@section('title', 'Balanced Scorecard Strategy Map')
@section('page_title', 'BSC Strategy Map')

@section('header_action')
<a href="{{ route('reports.index') }}" class="btn-secondary text-slate-700 hover:bg-slate-50 gap-1.5">
    <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" /></svg>
    Reports Hub
</a>
@endsection

@section('content')
@php
    // Pre-serialize KPIs by Objective ID for Alpine.js
    $objectivesKpisData = [];
    foreach ($perspectives as $p) {
        foreach ($p->objectives as $objective) {
            $kpisData = [];
            foreach ($objective->kpis as $kpi) {
                $latestResult = $kpi->results
                    ->where('school_year', $school_year)
                    ->sortByDesc(fn($r) => $r->report_type === 'Year-Ender' ? 1 : 0)
                    ->first();
                    
                $status = $latestResult ? $latestResult->status : 'Pending';
                $actual = $latestResult ? $latestResult->actual_value : null;

                $kpisData[] = [
                    'id' => $kpi->id,
                    'measure_code' => $kpi->measure_code,
                    'measure_name' => $kpi->measure_name,
                    'measure_owner' => $kpi->measure_owner,
                    'baseline' => $kpi->baseline,
                    'targets' => [
                        '2024' => $kpi->target_2024,
                        '2025' => $kpi->target_2025,
                        '2026' => $kpi->target_2026,
                        '2027' => $kpi->target_2027,
                        '2028' => $kpi->target_2028,
                    ],
                    'actual' => $actual,
                    'status' => $status,
                    'url' => route('kpis.show', $kpi->id),
                ];
            }
            $objectivesKpisData[$objective->id] = $kpisData;
        }
    }
@endphp

<div class="space-y-6" x-data="{
    drawerOpen: false,
    activeCode: '',
    activeTitle: '',
    activeOwner: '',
    activeResult: '',
    activeKpis: [],
    objectivesKpis: {{ json_encode($objectivesKpisData) }},
    schoolYear: '{{ $school_year }}',
    openObjectiveDrawer(id, code, title, owner, result) {
        this.activeCode = code;
        this.activeTitle = title;
        this.activeOwner = owner;
        this.activeResult = result;
        this.activeKpis = this.objectivesKpis[id] || [];
        this.drawerOpen = true;
    }
}">

    {{-- Breadcrumbs --}}
    <nav class="flex items-center gap-1.5 animate-fade-up" aria-label="Breadcrumb">
        <a href="{{ route('reports.index') }}" class="text-xs font-semibold text-slate-500 uppercase tracking-wider hover:text-red-700 transition-colors">Reports</a>
        <svg class="w-3.5 h-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-red-50 border border-red-200/60 text-xs font-bold text-red-700">Strategy Map</span>
    </nav>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4 animate-fade-up">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-red-700">
                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25A2.25 2.25 0 0 1 13.5 8.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-1.5 2.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-red-700 uppercase tracking-widest">Balanced Scorecard</span>
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">BSC Strategy Map</h1>
            <p class="text-sm text-slate-500 mt-1">Cascading Strategic Objectives mapped to their KPIs. Click any card to slide open its detail view.</p>
        </div>

        {{-- Dropdown for School Year --}}
        <form method="GET" action="{{ route('strategy-map') }}" class="flex items-center gap-2">
            <label for="school_year" class="text-xs font-bold text-slate-500 uppercase tracking-wider">Evaluation Year:</label>
            <select name="school_year" id="school_year" onchange="this.form.submit()" 
                    class="rounded-xl border-slate-200 bg-white text-sm font-bold text-slate-700 shadow-sm focus:border-red-500 focus:ring-red-500/20 py-2 pl-3 pr-8">
                @foreach ($schoolYears as $sy)
                    <option value="{{ $sy }}" {{ $school_year === $sy ? 'selected' : '' }}>{{ $sy }}</option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- Legend --}}
    <div class="flex flex-wrap items-center gap-4 animate-fade-up animate-fade-up-1">
        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">KPI Status Legend ({{ $school_year }}):</span>
        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-emerald-700">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> On Track
        </span>
        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-amber-700">
            <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span> Warning
        </span>
        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-red-700">
            <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span> Off Track
        </span>
        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-slate-500">
            <span class="w-2.5 h-2.5 rounded-full bg-slate-300"></span> Pending
        </span>
    </div>

    {{-- Map Lanes Grid --}}
    <div class="space-y-6">
        @foreach ($perspectives as $perspective)
            @php
                $borderColor = match($perspective->color) {
                    'blue' => 'border-blue-200/80 bg-gradient-to-r from-blue-50/30 to-blue-100/10',
                    'emerald' => 'border-emerald-200/80 bg-gradient-to-r from-emerald-50/30 to-emerald-100/10',
                    'orange' => 'border-orange-200/80 bg-gradient-to-r from-orange-50/30 to-orange-100/10',
                    'violet' => 'border-violet-200/80 bg-gradient-to-r from-violet-50/30 to-violet-100/10',
                    default => 'border-slate-200/80 bg-slate-50/50'
                };
                $badgeBg = match($perspective->color) {
                    'blue' => 'bg-blue-600',
                    'emerald' => 'bg-emerald-600',
                    'orange' => 'bg-orange-600',
                    'violet' => 'bg-violet-600',
                    default => 'bg-slate-600'
                };
            @endphp
            <div class="rounded-2xl border p-5 sm:p-6 {{ $borderColor }} shadow-sm animate-fade-up">
                
                {{-- Lane Layout: Left Column = Title/Context, Right Column = Objective cards list --}}
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    
                    {{-- Perspective Banner Column --}}
                    <div class="lg:col-span-1 space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="flex items-center justify-center text-white text-[10px] font-bold h-5 w-5 rounded {{ $badgeBg }}">
                                {{ $loop->iteration }}
                            </span>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 font-mono">Perspective</span>
                        </div>
                        <h2 class="text-lg font-black text-slate-900 leading-tight">{{ $perspective->name }}</h2>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">{{ $perspective->description }}</p>
                    </div>

                    {{-- Objectives List Column --}}
                    <div class="lg:col-span-3">
                        @if ($perspective->objectives->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                                @foreach ($perspective->objectives as $objective)
                                    @php
                                        // Compute KPIs status counts for current objective
                                        $onTrack = 0;
                                        $warning = 0;
                                        $offTrack = 0;
                                        $pending = 0;
                                        foreach ($objective->kpis as $k) {
                                            $latest = $k->results
                                                ->where('school_year', $school_year)
                                                ->sortByDesc(fn($r) => $r->report_type === 'Year-Ender' ? 1 : 0)
                                                ->first();
                                            $status = $latest ? $latest->status : 'Pending';
                                            if ($status === 'On Track') $onTrack++;
                                            elseif ($status === 'Warning') $warning++;
                                            elseif ($status === 'Off Track') $offTrack++;
                                            else $pending++;
                                        }
                                        $totalKpis = $objective->kpis->count();
                                    @endphp
                                    <div @click="openObjectiveDrawer({{ $objective->id }}, '{{ $objective->code }}', '{{ addslashes($objective->title) }}', '{{ addslashes($objective->owner) }}', '{{ addslashes($objective->intended_result) }}')"
                                         class="group rounded-xl border border-slate-200 bg-white p-4.5 shadow-sm hover:shadow-md hover:border-red-300 active:scale-[0.98] cursor-pointer transition-all flex flex-col justify-between min-h-[120px]">
                                        
                                        <div>
                                            <div class="flex items-center justify-between">
                                                <span class="inline-flex items-center justify-center text-xs font-black px-1.5 py-0.5 rounded font-mono"
                                                      style="background: {{ $perspective->hex_color }}10; color: {{ $perspective->hex_color }};">
                                                    {{ $objective->code }}
                                                </span>
                                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest font-mono">{{ $objective->owner }}</span>
                                            </div>
                                            <h3 class="text-sm font-extrabold text-slate-800 leading-snug mt-2.5 group-hover:text-red-700 transition-colors">
                                                {{ $objective->title }}
                                            </h3>
                                        </div>

                                        <div class="mt-4 pt-3 border-t border-slate-50 flex items-center justify-between">
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider font-mono">
                                                {{ $totalKpis }} {{ Str::plural('KPI', $totalKpis) }}
                                            </span>
                                            
                                            {{-- Status mini-pills indicator --}}
                                            <div class="flex items-center gap-1">
                                                @if($onTrack > 0)
                                                    <span class="w-2 h-2 rounded-full bg-emerald-500" title="On Track: {{ $onTrack }}"></span>
                                                @endif
                                                @if($warning > 0)
                                                    <span class="w-2 h-2 rounded-full bg-amber-400" title="Warning: {{ $warning }}"></span>
                                                @endif
                                                @if($offTrack > 0)
                                                    <span class="w-2 h-2 rounded-full bg-red-500" title="Off Track: {{ $offTrack }}"></span>
                                                @endif
                                                @if($pending > 0 || $totalKpis === 0)
                                                    <span class="w-2 h-2 rounded-full bg-slate-300" title="Pending: {{ $pending }}"></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex items-center justify-center p-8 bg-white border border-dashed border-slate-200 rounded-xl">
                                <p class="text-xs text-slate-400 font-medium font-mono">No strategic objectives configured for this perspective.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Unmapped KPIs Section --}}
        @if ($unmappedKpis->count() > 0)
            <div class="rounded-2xl border border-dashed border-slate-300/80 bg-slate-100/40 p-5 sm:p-6 shadow-sm animate-fade-up">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    <div class="lg:col-span-1 space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="flex items-center justify-center text-white text-[10px] font-bold h-5 w-5 rounded bg-slate-500">
                                !
                            </span>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 font-mono">General</span>
                        </div>
                        <h2 class="text-lg font-black text-slate-700 leading-tight">Unmapped / General KPIs</h2>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">Metrics that exist in the system but have not been formally linked to a Strategic Objective code.</p>
                    </div>
                    <div class="lg:col-span-3">
                        <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-150">
                                        <th class="text-left px-4 py-2.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">KPI Code</th>
                                        <th class="text-left px-4 py-2.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">Name</th>
                                        <th class="text-center px-4 py-2.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">Status</th>
                                        <th class="text-right px-4 py-2.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($unmappedKpis as $kpi)
                                        @php
                                            $latest = $kpi->results
                                                ->where('school_year', $school_year)
                                                ->sortByDesc(fn($r) => $r->report_type === 'Year-Ender' ? 1 : 0)
                                                ->first();
                                            $status = $latest ? $latest->status : 'Pending';
                                            $badgeColor = match ($status) {
                                                'On Track' => 'bg-emerald-50 border-emerald-200 text-emerald-700',
                                                'Warning' => 'bg-amber-50 border-amber-200 text-amber-700',
                                                'Off Track' => 'bg-red-50 border-red-200 text-red-700',
                                                default => 'bg-slate-50 border-slate-250 text-slate-600',
                                            };
                                        @endphp
                                        <tr class="hover:bg-slate-50/50">
                                            <td class="px-4 py-3 text-xs font-bold text-slate-600 font-mono">{{ $kpi->measure_code }}</td>
                                            <td class="px-4 py-3 text-xs font-semibold text-slate-700 leading-normal">{{ $kpi->measure_name }}</td>
                                            <td class="px-4 py-3 text-center">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold border {{ $badgeColor }}">
                                                    {{ $status }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-right">
                                                <a href="{{ route('kpis.show', $kpi->id) }}" class="text-xs font-bold text-red-700 hover:text-red-800 hover:underline">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Interactive Drawer (Slide-over panel) --}}
    
    {{-- Drawer Backdrop --}}
    <div x-show="drawerOpen"
         x-transition:enter="ease-in-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in-out duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="drawerOpen = false"
         class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50"
         style="display: none;">
    </div>

    {{-- Drawer Body --}}
    <div x-show="drawerOpen"
         x-transition:enter="transform transition ease-in-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transform transition ease-in-out duration-300"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed inset-y-0 right-0 max-w-lg w-full bg-white shadow-2xl z-50 flex flex-col h-full border-l border-slate-200/80 overflow-hidden"
         style="display: none;"
         @keydown.escape.window="drawerOpen = false">
        
        {{-- Header Bar --}}
        <div class="px-5 py-4.5 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center justify-center px-2 py-0.5 rounded text-xs font-black font-mono bg-red-50 border border-red-200 text-red-700" 
                      x-text="activeCode">
                </span>
                <span class="text-xs font-black uppercase tracking-wider text-slate-400 font-mono">Objective Details</span>
            </div>
            
            <button @click="drawerOpen = false" 
                    class="rounded-lg p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-150 transition-colors focus:outline-none">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
        </div>

        {{-- Scrollable Details Area --}}
        <div class="flex-1 overflow-y-auto p-5 space-y-6">
            
            {{-- Title & Intended Result --}}
            <div class="space-y-3">
                <h3 class="text-xl font-extrabold text-slate-900 leading-snug" x-text="activeTitle"></h3>
                <div class="text-xs text-slate-500 font-medium">
                    Owner: <span class="font-extrabold text-slate-700" x-text="activeOwner || 'N/A'"></span>
                </div>
                
                <div class="rounded-xl bg-slate-50 border border-slate-200/50 p-4">
                    <h4 class="text-[9px] font-black uppercase tracking-wider text-slate-400 mb-1.5 font-mono">BSC Intended Result Description</h4>
                    <p class="text-xs text-slate-600 leading-relaxed font-medium" x-text="activeResult || 'No detailed intended result description configured.'"></p>
                </div>
            </div>

            {{-- KPIs List --}}
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-400 font-mono">Mapped Key Performance Indicators</h3>
                    <span class="text-xs text-slate-400 font-bold" x-text="`${activeKpis.length} KPIs total`"></span>
                </div>

                <template x-if="activeKpis.length === 0">
                    <div class="flex flex-col items-center justify-center p-10 bg-slate-50 border border-dashed border-slate-200 rounded-xl">
                        <svg class="w-8 h-8 text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                        <p class="text-xs text-slate-400 font-bold font-mono">No KPIs mapped to this strategic objective.</p>
                    </div>
                </template>

                <div class="space-y-4">
                    <template x-for="kpi in activeKpis" :key="kpi.id">
                        <div class="border border-slate-200/60 rounded-xl p-4 bg-slate-50/50 hover:bg-slate-50 transition-all shadow-sm space-y-3">
                            <div class="flex items-start justify-between">
                                <div class="space-y-1">
                                    <span class="text-[10px] font-bold text-slate-400 font-mono tracking-wider" x-text="kpi.measure_code"></span>
                                    <h4 class="text-sm font-extrabold text-slate-800 leading-tight" x-text="kpi.measure_name"></h4>
                                    <p class="text-[10px] text-slate-400 font-medium">Owner: <span class="font-bold text-slate-700" x-text="kpi.measure_owner || 'N/A'"></span></p>
                                </div>
                                
                                {{-- Status badge --}}
                                <span :class="`inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold border ` + 
                                    (kpi.status === 'On Track' ? 'bg-emerald-50 border-emerald-200 text-emerald-700' :
                                     kpi.status === 'Warning' ? 'bg-amber-50 border-amber-200 text-amber-700' :
                                     kpi.status === 'Off Track' ? 'bg-red-50 border-red-200 text-red-700' :
                                     'bg-slate-50 border-slate-250 text-slate-600')"
                                      x-text="kpi.status">
                                </span>
                            </div>

                            {{-- 5-Year targets trajectory visual --}}
                            <div>
                                <p class="text-[9px] font-black uppercase tracking-wider text-slate-400 mb-1.5 font-mono">5-Year Target Trajectory</p>
                                <div class="grid grid-cols-5 gap-1.5">
                                    <template x-for="year in ['2024', '2025', '2026', '2027', '2028']" :key="year">
                                        <div class="rounded-lg p-2 text-center border transition-all"
                                             :class="year === schoolYear.substring(0, 4) 
                                                 ? 'bg-red-50/50 border-red-200 ring-1 ring-red-200' 
                                                 : 'bg-white border-slate-200/60'">
                                            <span class="block text-[8px] font-bold text-slate-400 uppercase tracking-wider" x-text="`AY ${year}`"></span>
                                            <span class="block text-[11px] font-black text-slate-800 mt-0.5" x-text="kpi.targets[year] || '—'"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            {{-- Footer with actual and link --}}
                            <div class="flex items-center justify-between pt-2 border-t border-slate-100/60">
                                <div class="text-[11px] text-slate-500 font-medium">
                                    Latest Actual ({{ $school_year }}): 
                                    <span class="font-extrabold text-slate-800" x-text="kpi.actual !== null ? kpi.actual : 'No submission'"></span>
                                </div>
                                <a :href="kpi.url" class="inline-flex items-center text-[11px] font-extrabold text-red-700 hover:text-red-800 hover:underline">
                                    View details
                                    <svg class="w-3 h-3 ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                                </a>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
