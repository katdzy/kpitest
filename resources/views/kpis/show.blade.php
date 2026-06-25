@extends('layouts.app')

@section('title', $kpi->measure_code . ' - ' . $kpi->measure_name)

@section('content')
<div class="space-y-6">

    <!-- Breadcrumbs / Top Actions -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4 animate-fade-up">
        {{-- Improved Breadcrumb --}}
        <nav class="flex items-center gap-1.5" aria-label="Breadcrumb">
            <a href="{{ route('dashboard') }}" class="text-slate-400 hover:text-red-700 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75"/></svg>
            </a>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            <a href="{{ route('kpis.index') }}" class="text-xs font-semibold text-slate-500 uppercase tracking-wider hover:text-red-700 transition-colors">KPI Library</a>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-red-50 border border-red-200/60 text-xs font-bold font-mono text-red-700">{{ $kpi->measure_code }}</span>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            <span class="text-xs font-bold text-slate-700 font-mono">{{ $kpi->year_range }}</span>
        </nav>

        <!-- Actions -->
        <div class="flex flex-wrap gap-2">
            <!-- Clone / Create New Version -->
            <a href="{{ route('kpis.create', ['clone_from_id' => $kpi->id]) }}" class="btn-secondary text-slate-700 hover:bg-slate-50 gap-1.5">
                <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 0 0-3.7-3.7 48.656 48.656 0 0 0-7.324 0 4.006 4.006 0 0 0-3.7 3.7C4.68 9.58 4.633 10.781 4.633 12c0 1.218.047 2.42.139 3.628a4.006 4.006 0 0 0 3.7 3.7c2.408.18 4.887.18 7.296 0a4.006 4.006 0 0 0 3.7-3.7c.09-1.209.138-2.41.138-3.628Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9" />
                </svg>
                Clone Version
            </a>

            <!-- Edit -->
            <a href="{{ route('kpis.edit', $kpi->id) }}" class="btn-primary text-white gap-1.5" style="background:linear-gradient(135deg,#6366f1,#4f46e5);">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
                Edit KPI
            </a>

            <!-- Delete -->
            <form action="{{ route('kpis.destroy', $kpi->id) }}" method="POST"
                  onsubmit="return confirm('Delete this KPI version? This cannot be undone.');"
                  class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-secondary text-red-600 border-red-200 hover:bg-red-50 gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                    Delete
                </button>
            </form>
        </div>
    </div>

    <!-- Main Grid: Left details, Right Versioning & Meta -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        
        <!-- Left: KPI Specs Detail -->
        <div class="space-y-6 lg:col-span-2">
            
            <!-- General KPI Header Info -->
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="bg-red-50 text-red-700 border border-red-200/50 text-sm font-bold font-mono px-3 py-1 rounded-lg">
                                {{ $kpi->measure_code }}
                            </span>

                            {{-- Scope Badge --}}
                            @if($kpi->scope === 'Institutional')
                                <span class="bg-violet-50 text-violet-700 border border-violet-200/50 text-xs font-semibold px-2.5 py-0.5 rounded-full">🏛 Institutional</span>
                            @else
                                <span class="bg-sky-50 text-sky-700 border border-sky-200/50 text-xs font-semibold px-2.5 py-0.5 rounded-full">🏢 Departmental</span>
                            @endif
                            
                            @if ($kpi->category === 'Academic')
                                <span class="bg-blue-50 text-blue-700 border border-blue-200/50 text-xs font-semibold px-2.5 py-0.5 rounded-full">Academic</span>
                            @elseif ($kpi->category === 'Research')
                                <span class="bg-purple-50 text-purple-700 border border-purple-200/50 text-xs font-semibold px-2.5 py-0.5 rounded-full">Research</span>
                            @elseif ($kpi->category === 'Financial')
                                <span class="bg-emerald-50 text-emerald-700 border border-emerald-200/50 text-xs font-semibold px-2.5 py-0.5 rounded-full">Financial</span>
                            @elseif ($kpi->category === 'Student Services')
                                <span class="bg-indigo-50 text-indigo-700 border border-indigo-200/50 text-xs font-semibold px-2.5 py-0.5 rounded-full">Student Services</span>
                            @else
                                <span class="bg-slate-50 text-slate-700 border border-slate-200/50 text-xs font-semibold px-2.5 py-0.5 rounded-full">{{ $kpi->category }}</span>
                            @endif

                            @if ($kpi->lead_lag)
                                <span class="bg-slate-100 text-slate-700 border border-slate-200/50 text-xs font-semibold px-2 py-0.5 rounded-md">{{ $kpi->lead_lag }}</span>
                            @endif
                        </div>
                        <h2 class="text-2xl font-extrabold text-slate-900 mt-3">{{ $kpi->measure_name }}</h2>
                        <div class="flex items-center space-x-2 mt-2 text-sm text-slate-500 font-medium">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Owner: <strong class="text-slate-800">{{ $kpi->measure_owner }}</strong></span>
                        </div>
                    </div>
                </div>

                @if ($kpi->description)
                    <div class="mt-6 border-t border-slate-100 pt-5">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Description</h3>
                        <p class="text-sm text-slate-600 mt-2 leading-relaxed whitespace-pre-line">{{ $kpi->description }}</p>
                    </div>
                @endif
            </div>

            <!-- Targets & Thresholds -->
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-950 mb-4 flex items-center">
                    <!-- Target icon -->
                    <svg class="w-5 h-5 mr-2 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z" />
                    </svg>
                    Target & Threshold Metrics
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <!-- Baseline -->
                    <div class="relative overflow-hidden rounded-xl bg-slate-50 border border-slate-200/60 p-4 shadow-sm">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-slate-200 text-slate-500">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75Z"/></svg>
                            </div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Baseline</span>
                        </div>
                        <div class="text-2xl font-extrabold text-slate-700">{{ $kpi->baseline ?? '—' }}</div>
                    </div>
                    <!-- High Threshold -->
                    <div class="relative overflow-hidden rounded-xl bg-emerald-50 border border-emerald-200/60 p-4 shadow-sm">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5"/></svg>
                            </div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">High Threshold</span>
                        </div>
                        <div class="text-2xl font-extrabold text-emerald-700">{{ $kpi->high_threshold ?? '—' }}</div>
                    </div>
                    <!-- Low Threshold -->
                    <div class="relative overflow-hidden rounded-xl bg-red-50 border border-red-200/60 p-4 shadow-sm">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-100 text-red-500">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                            </div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-red-500">Low Threshold</span>
                        </div>
                        <div class="text-2xl font-extrabold text-red-700">{{ $kpi->low_threshold ?? '—' }}</div>
                    </div>
                </div>

                <!-- 5-Year Target Timeline -->
                <div class="border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                    <div class="bg-slate-50 border-b border-slate-200 px-4 py-2.5 flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center">
                            <svg class="w-4 h-4 mr-1.5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                            5-Year Target Trajectory
                        </span>
                        @if($kpi->target)
                        <span class="text-[10px] font-bold text-slate-500 bg-white px-2 py-1 rounded border border-slate-200">Current Target: {{ $kpi->target }}</span>
                        @endif
                    </div>
                    <div class="flex divide-x divide-slate-100">
                        @foreach(['2024', '2025', '2026', '2027', '2028'] as $year)
                            @php $hasTarget = !empty($kpi->{'target_'.$year}); @endphp
                            <div class="flex-1 p-3 {{ $hasTarget ? 'bg-white' : 'bg-slate-50/50' }} text-center relative group">
                                <div class="text-[10px] font-bold text-slate-400 mb-1">Target {{ $year }}</div>
                                @if($hasTarget)
                                    <div class="text-lg font-extrabold text-indigo-700">{{ $kpi->{'target_'.$year} }}</div>
                                    <div class="absolute inset-x-0 bottom-0 h-1 bg-indigo-500 rounded-t-md opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                @else
                                    <div class="text-sm font-semibold text-slate-300">—</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                @if ($kpi->target_rationale)
                    <div class="mt-4.5">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Target Rationale</h4>
                        <p class="text-sm text-slate-600 mt-1 whitespace-pre-line leading-relaxed">{{ $kpi->target_rationale }}</p>
                    </div>
                @endif
            </div>

            <!-- Methodology & Measurement Details -->
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-950 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 9.172V5L8 4z" />
                    </svg>
                    Methodology & Data Parameters
                </h3>
                
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Formula</span>
                        <div class="mt-1 bg-slate-50/75 border border-slate-200/60 rounded-xl p-3.5 text-sm font-mono text-slate-700 break-words">
                            {{ $kpi->formula ?? 'Not defined' }}
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Unit Type</span>
                                <div class="text-sm font-semibold text-slate-800 mt-1">{{ $kpi->unit_type ?? 'N/A' }}</div>
                            </div>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Polarity</span>
                                <div class="text-sm font-semibold text-slate-800 mt-1">
                                    @if ($kpi->polarity === 'Positive')
                                        <span class="inline-flex items-center text-emerald-600 font-bold">
                                            Maximize (+)
                                        </span>
                                    @elseif ($kpi->polarity === 'Negative')
                                        <span class="inline-flex items-center text-red-600 font-bold">
                                            Minimize (-)
                                        </span>
                                    @elseif ($kpi->polarity === 'Neutral')
                                        <span class="inline-flex items-center text-slate-600 font-bold">
                                            Maintain (=)
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 border-t border-slate-100 pt-3">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Measure Type</span>
                                <div class="text-sm font-semibold text-slate-800 mt-1">{{ $kpi->measure_type }}</div>
                            </div>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Lead or Lag</span>
                                <div class="text-sm font-semibold text-slate-800 mt-1">{{ $kpi->lead_lag ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Strategic Alignment -->
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-950 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Strategic Alignment
                </h3>
                
                <div class="space-y-4">
                    <!-- BSC Perspective & Theme -->
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">BSC Perspective</span>
                            <div class="mt-1">
                                @if($kpi->bscPerspective)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-{{ $kpi->bscPerspective->color }}-50 text-{{ $kpi->bscPerspective->color }}-700 border border-{{ $kpi->bscPerspective->color }}-200">
                                        {{ $kpi->bscPerspective->name }}
                                    </span>
                                @else
                                    <span class="text-sm font-semibold text-slate-800">{{ $kpi->perspective ?? 'N/A' }}</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Strategic Theme</span>
                            <div class="text-sm font-semibold text-slate-800 mt-1">{{ $kpi->strategic_theme ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <!-- Strategic Objective -->
                    <div class="border-t border-slate-100 pt-4">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <div class="sm:col-span-2">
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Strategic Objective</span>
                                @if($kpi->bscObjective)
                                    <div class="text-sm font-semibold text-slate-900 mt-1 flex items-start gap-2">
                                        <span class="font-mono bg-slate-100 px-1.5 py-0.5 rounded text-xs text-slate-600 border border-slate-200">{{ $kpi->bscObjective->code }}</span>
                                        <span>{{ $kpi->bscObjective->title }}</span>
                                    </div>
                                    @if($kpi->bscObjective->intended_result)
                                        <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">{{ $kpi->bscObjective->intended_result }}</p>
                                    @endif
                                @else
                                    <div class="text-sm font-semibold text-slate-800 mt-1">{{ $kpi->objective ?? 'N/A' }}</div>
                                @endif
                            </div>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Objective Owner</span>
                                <div class="text-sm font-semibold text-slate-800 mt-1">
                                    {{ $kpi->bscObjective ? $kpi->bscObjective->owner : ($kpi->objective_owner ?? 'N/A') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($kpi->strategic_initiatives)
                        <div class="border-t border-slate-100 pt-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Strategic Initiatives</span>
                            <p class="text-sm text-slate-600 mt-1 whitespace-pre-line leading-relaxed">{{ $kpi->strategic_initiatives }}</p>
                        </div>
                    @endif

                    @if ($kpi->intended_results)
                        <div class="border-t border-slate-100 pt-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Intended Results</span>
                            <p class="text-sm text-slate-600 mt-1 whitespace-pre-line leading-relaxed">{{ $kpi->intended_results }}</p>
                        </div>
                    @endif

                    @if ($kpi->comparator)
                        <div class="border-t border-slate-100 pt-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Comparator / Benchmark</span>
                            <div class="text-sm text-slate-800 font-semibold mt-1">{{ $kpi->comparator }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Performance Results & History -->
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-950 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z" />
                    </svg>
                    Performance Results &amp; History
                </h3>

                <div class="overflow-x-auto -mx-6 sm:mx-0">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50/75">
                            <tr>
                                <th scope="col" class="py-3 px-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Period</th>
                                <th scope="col" class="py-3 px-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Department</th>
                                <th scope="col" class="py-3 px-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Baseline</th>
                                <th scope="col" class="py-3 px-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Target</th>
                                <th scope="col" class="py-3 px-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Actual</th>
                                <th scope="col" class="py-3 px-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                                <th scope="col" class="py-3 px-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Notes</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($kpi->results()->orderBy('period', 'desc')->get() as $result)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="whitespace-nowrap py-3.5 px-4 text-xs font-bold text-slate-900 font-mono">
                                        {{ $result->period }}
                                    </td>
                                    <td class="whitespace-nowrap py-3.5 px-4 text-xs font-medium text-slate-700">
                                        @if ($result->department)
                                            <span class="inline-flex items-center text-slate-700">
                                                <span class="font-mono text-[10px] font-bold text-sky-700 bg-sky-50 border border-sky-200/50 px-1.5 py-0.5 rounded mr-1">{{ $result->department->code }}</span>
                                                <span class="truncate max-w-[120px]">{{ $result->department->name }}</span>
                                            </span>
                                        @else
                                            <span class="text-slate-400 italic">University-wide</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap py-3.5 px-4 text-center text-xs text-slate-600 font-semibold font-mono">
                                        {{ $result->baseline_value !== null ? number_format($result->baseline_value, 1) : '-' }}
                                    </td>
                                    <td class="whitespace-nowrap py-3.5 px-4 text-center text-xs text-red-700 font-bold font-mono">
                                        {{ number_format($result->target_value, 1) }}
                                    </td>
                                    <td class="whitespace-nowrap py-3.5 px-4 text-center text-xs text-slate-900 font-bold font-mono">
                                        {{ $result->actual_value !== null ? number_format($result->actual_value, 1) : '-' }}
                                    </td>
                                    <td class="whitespace-nowrap py-3.5 px-4 text-center">
                                        @php
                                            $color = $result->statusColor();
                                        @endphp
                                        <span class="inline-flex items-center rounded-full bg-{{ $color }}-50 px-2 py-0.5 text-[10px] font-bold text-{{ $color }}-700 border border-{{ $color }}-200/60">
                                            {{ $result->status }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-xs text-slate-500 max-w-xs truncate" title="{{ $result->notes }}">
                                        {{ $result->notes ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-6 text-center text-xs text-slate-400 italic">
                                        No performance results uploaded for this KPI yet. Use "Upload Results" in the sidebar to add performance data.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Right Side: Year Versioning History & Admin Audit Meta -->
        <div class="space-y-6">
            
            <!-- active version info box (crimson brand) -->
            <div class="rounded-2xl text-white shadow-lg p-6 relative overflow-hidden"
                 style="background: linear-gradient(135deg, #9b1c1c 0%, #7f1d1d 55%, #5c1212 100%)">
                <!-- Floating decoration -->
                <div class="absolute -right-6 -top-6 float-shape opacity-10">
                    <div class="w-24 h-24 rounded-2xl border-2 border-white rotate-12"></div>
                </div>
                <div class="absolute -bottom-4 right-8 float-shape-2 opacity-10">
                    <div class="w-16 h-16 rounded-full border-2 border-white"></div>
                </div>
                <div class="relative z-10 space-y-3">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-white/10 border border-white/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-300 animate-pulse"></span>
                        <span class="text-[9px] font-bold uppercase tracking-widest text-red-200">Active Version</span>
                    </div>
                    <h3 class="text-4xl font-extrabold font-mono tracking-tight">{{ $kpi->year_range }}</h3>
                    <p class="text-xs text-red-200/80 leading-relaxed">
                        Showing targets and methodologies for the <strong class="text-white">{{ $kpi->year_range }}</strong> audit cycle.
                    </p>
                </div>
            </div>

            <!-- Version Range History -->
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Version & Year History</h3>
                
                <div class="space-y-4">
                    <!-- current selection node -->
                    <div class="flex items-center space-x-3.5 p-3 rounded-xl border border-red-200 bg-red-50/50">
                        <div class="flex h-6 w-6 items-center justify-center rounded-full bg-red-700 text-[10px] font-bold text-white">
                            ✓
                        </div>
                        <div class="flex-grow">
                            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Current View</span>
                            <div class="text-sm font-extrabold text-red-950 font-mono mt-0.5">{{ $kpi->year_range }}</div>
                        </div>
                    </div>

                    <!-- other historical nodes -->
                    @forelse ($otherVersions as $ver)
                        <a href="{{ route('kpis.show', $ver->id) }}" class="flex items-center space-x-3.5 p-3 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-slate-100 hover:border-slate-200 transition-all group">
                            <div class="flex h-6 w-6 items-center justify-center rounded-full bg-slate-200 text-slate-500 group-hover:bg-red-100 group-hover:text-red-700 transition-colors">
                                <!-- clock/history icon -->
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="flex-grow">
                                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Alternate Version</span>
                                <div class="text-sm font-bold text-slate-700 font-mono mt-0.5 group-hover:text-red-700 transition-colors">{{ $ver->year_range }}</div>
                            </div>
                            <svg class="h-4 w-4 text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @empty
                        <p class="text-xs text-slate-400 italic">No other year-range versions exist for this KPI. Use "Clone as New Version" to establish targets for other years.</p>
                    @endforelse
                </div>
            </div>

            <!-- Administration & Audit Logs Details -->
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-4.5">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-2.5">Audit & Administrative</h3>
                
                <div class="grid grid-cols-2 gap-3.5 text-xs">
                    <div>
                        <span class="font-bold text-slate-400 uppercase tracking-wider">Data Provider</span>
                        <div class="font-semibold text-slate-800 mt-0.5 truncate" title="{{ $kpi->data_provider }}">{{ $kpi->data_provider ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <span class="font-bold text-slate-400 uppercase tracking-wider">Data Source</span>
                        <div class="font-semibold text-slate-800 mt-0.5 truncate" title="{{ $kpi->data_source }}">{{ $kpi->data_source ?? 'N/A' }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3.5 text-xs border-t border-slate-100 pt-3">
                    <div>
                        <span class="font-bold text-slate-400 uppercase tracking-wider">Collect Frequency</span>
                        <div class="font-semibold text-slate-800 mt-0.5">{{ $kpi->collection_frequency ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <span class="font-bold text-slate-400 uppercase tracking-wider">Report Frequency</span>
                        <div class="font-semibold text-slate-800 mt-0.5">{{ $kpi->reporting_frequency ?? 'N/A' }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3.5 text-xs border-t border-slate-100 pt-3">
                    <div>
                        <span class="font-bold text-slate-400 uppercase tracking-wider">Verified By</span>
                        <div class="font-semibold text-slate-800 mt-0.5 truncate" title="{{ $kpi->verified_by }}">{{ $kpi->verified_by ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <span class="font-bold text-slate-400 uppercase tracking-wider">Validated By</span>
                        <div class="font-semibold text-slate-800 mt-0.5 truncate" title="{{ $kpi->validated_by }}">{{ $kpi->validated_by ?? 'N/A' }}</div>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-3.5 space-y-2 text-xs">
                    <div class="flex justify-between items-center text-slate-500">
                        <span>Record Author:</span>
                        <span class="font-semibold text-slate-800">{{ $kpi->item_author ?? 'N/A' }}</span>
                    </div>
                    @if ($kpi->date)
                        <div class="flex justify-between items-center text-slate-500">
                            <span>Authoring Date:</span>
                            <span class="font-semibold text-slate-800">{{ $kpi->date->format('m/d/Y') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between items-center text-slate-500 border-t border-slate-50/75 pt-2">
                        <span>Created:</span>
                        <span class="font-mono">{{ $kpi->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-slate-500">
                        <span>Last Updated:</span>
                        <span class="font-mono">{{ $kpi->updated_at->format('M d, Y H:i') }}</span>
                    </div>
                </div>
            </div>

            {{-- Scope & Hierarchy Panel --}}
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-4">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-2.5">Scope & Hierarchy</h3>

                <div class="text-xs space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-slate-400 uppercase tracking-wider">Scope</span>
                        @if($kpi->scope === 'Institutional')
                            <span class="inline-flex items-center rounded-lg bg-violet-50 px-2.5 py-1 text-xs font-semibold text-violet-700 border border-violet-200/60">Institutional</span>
                        @else
                            <span class="inline-flex items-center rounded-lg bg-sky-50 px-2.5 py-1 text-xs font-semibold text-sky-700 border border-sky-200/60">Departmental</span>
                        @endif
                    </div>
                </div>

                {{-- Parent KPI --}}
                @if($kpi->parent)
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1.5">Reports Into (Parent)</span>
                        <a href="{{ route('kpis.show', $kpi->parent->id) }}"
                           class="flex items-center space-x-2.5 p-2.5 rounded-xl border border-violet-100 bg-violet-50/50 hover:bg-violet-100 hover:border-violet-200 transition-all group">
                            <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-violet-100 text-violet-600 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12" /></svg>
                            </div>
                            <div class="flex-grow min-w-0">
                                <div class="text-[10px] text-violet-500 font-bold uppercase tracking-wider">{{ $kpi->parent->measure_code }}</div>
                                <div class="text-xs font-semibold text-slate-800 truncate group-hover:text-violet-700 transition-colors">{{ $kpi->parent->measure_name }}</div>
                            </div>
                        </a>
                    </div>
                @endif

                {{-- Child KPIs --}}
                @if($kpi->children->isNotEmpty())
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1.5">Contributing KPIs ({{ $kpi->children->count() }})</span>
                        <div class="space-y-1.5">
                            @foreach($kpi->children as $child)
                                <a href="{{ route('kpis.show', $child->id) }}"
                                   class="flex items-center space-x-2 p-2 rounded-lg border border-sky-100 bg-sky-50/30 hover:bg-sky-100 hover:border-sky-200 transition-all group">
                                    <span class="font-mono text-[10px] font-bold text-sky-700 bg-sky-100 px-1.5 py-0.5 rounded">{{ $child->measure_code }}</span>
                                    <span class="text-xs font-semibold text-slate-700 truncate group-hover:text-sky-700 transition-colors">{{ $child->measure_name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if(!$kpi->parent && $kpi->children->isEmpty())
                    <p class="text-xs text-slate-400 italic">No parent or child KPIs linked. Edit this KPI to set up a hierarchy.</p>
                @endif
            </div>

            {{-- Department Assignments Panel --}}
            @if($kpi->departments->isNotEmpty())
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-3">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-2.5">Department Assignments</h3>
                <div class="space-y-2">
                    @foreach($kpi->departments as $dept)
                        @php
                            $role = $dept->pivot?->role ?? 'Contributor';
                            $roleColor = match($role) {
                                'Strategic Owner' => 'indigo',
                                'Data Provider'   => 'teal',
                                'Contributor'     => 'amber',
                                default           => 'slate',
                            };
                        @endphp
                        <a href="{{ route('departments.show', $dept->id) }}"
                           class="flex items-center justify-between p-2.5 rounded-xl border border-slate-100 hover:bg-slate-50 hover:border-slate-200 transition-all group">
                            <div class="flex items-center space-x-2.5 min-w-0">
                                <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-slate-100 text-slate-500 flex-shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-xs font-bold text-slate-800 truncate group-hover:text-red-700 transition-colors">{{ $dept->name }}</div>
                                    <div class="text-[10px] font-mono text-slate-400">{{ $dept->code }}</div>
                                </div>
                            </div>
                            <span class="inline-flex items-center rounded-md bg-{{ $roleColor }}-50 px-2 py-0.5 text-[10px] font-bold text-{{ $roleColor }}-700 border border-{{ $roleColor }}-200/60 flex-shrink-0 ml-2">
                                {{ $role }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

    </div>

</div>
@endsection
