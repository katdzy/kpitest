@extends('layouts.app')

@section('title', 'Add New KPI')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Header / Back -->
    <div class="flex items-center space-x-3">
        <a href="{{ route('kpis.index') }}" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 hover:text-indigo-600 hover:border-indigo-300 shadow-sm transition-all">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">
                @if($kpi && request('clone_from_id'))
                    Clone KPI: {{ $kpi->measure_code }}
                @else
                    Create KPI Record
                @endif
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">
                @if($kpi && request('clone_from_id'))
                    Duplicating KPI details. Please specify a new Year Range and adjust targets as needed.
                @else
                    Add a new performance measure, align it strategically, and set targets.
                @endif
            </p>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('kpis.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- CARD 1: General Details -->
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center">
                <div class="h-6 w-6 rounded-md bg-indigo-50 text-indigo-600 flex items-center justify-center mr-2 font-bold text-xs">1</div>
                <h3 class="text-base font-bold text-slate-900">General Information</h3>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Measure Code -->
                <div>
                    <label for="measure_code" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Measure Code *</label>
                    <input type="text" 
                           name="measure_code" 
                           id="measure_code" 
                           value="{{ old('measure_code', $kpi?->measure_code) }}"
                           placeholder="e.g. UNIV-AC-001" 
                           class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors @error('measure_code') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                           required
                    >
                    <span class="text-[10px] text-slate-400 mt-1 block">Primary identifier code.</span>
                </div>

                <!-- Measure Name -->
                <div class="sm:col-span-2">
                    <label for="measure_name" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Measure Name *</label>
                    <input type="text" 
                           name="measure_name" 
                           id="measure_name" 
                           value="{{ old('measure_name', $kpi?->measure_name) }}"
                           placeholder="e.g. 4-Year Graduation Rate" 
                           class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors @error('measure_name') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                           required
                    >
                    <span class="text-[10px] text-slate-400 mt-1 block">Descriptive title of the indicator.</span>
                </div>

                <!-- Measure Owner -->
                <div class="sm:col-span-2">
                    <label for="measure_owner" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Measure Owner *</label>
                    <input type="text" 
                           name="measure_owner" 
                           id="measure_owner" 
                           value="{{ old('measure_owner', $kpi?->measure_owner) }}"
                           placeholder="e.g. Dr. Elizabeth Vance (Provost)" 
                           class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors @error('measure_owner') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                           required
                    >
                    <span class="text-[10px] text-slate-400 mt-1 block">Department lead or administrator responsible.</span>
                </div>

                <!-- Year Range -->
                <div>
                    <label for="year_range" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Year Range *</label>
                    <select name="year_range" 
                            id="year_range" 
                            class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors bg-white @error('year_range') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                            required
                    >
                        <option value="">Select Year Range</option>
                        @foreach ($yearRanges as $range)
                            <!-- For cloning, we default to the next range to prevent validation duplicates -->
                            <option value="{{ $range }}" {{ old('year_range', $kpi && request('clone_from_id') ? '' : $kpi?->year_range) === $range ? 'selected' : '' }}>{{ $range }}</option>
                        @endforeach
                    </select>
                    <span class="text-[10px] text-slate-400 mt-1 block">Active audit cycle/year.</span>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Lifecycle Status</label>
                    <select name="status"
                            id="status"
                            class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors bg-white @error('status') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                    >
                        @foreach (\App\Models\Kpi::STATUSES as $s)
                            <option value="{{ $s }}" {{ old('status', $kpi?->status ?? 'Draft') === $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                    <span class="text-[10px] text-slate-400 mt-1 block">Current lifecycle stage of this KPI.</span>
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Category *</label>
                    <select name="category" 
                            id="category" 
                            class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors bg-white @error('category') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                            required
                    >
                        <option value="">Select Category</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category', $kpi?->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    <span class="text-[10px] text-slate-400 mt-1 block">Operational category.</span>
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Date</label>
                    <input type="date" 
                           name="date" 
                           id="date" 
                           value="{{ old('date', $kpi?->date ? $kpi->date->format('Y-m-d') : '') }}"
                           class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors @error('date') border-red-300 @enderror"
                    >
                    <span class="text-[10px] text-slate-400 mt-1 block">Authorship date.</span>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1 font-sans">Description</label>
                <textarea name="description" 
                          id="description" 
                          rows="3" 
                          placeholder="Provide a detailed explanation of what this KPI measures..." 
                          class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors @error('description') border-red-300 @enderror"
                >{{ old('description', $kpi?->description) }}</textarea>
            </div>
        </div>

        <!-- CARD 2: Methodology & Measurement -->
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center">
                <div class="h-6 w-6 rounded-md bg-indigo-50 text-indigo-600 flex items-center justify-center mr-2 font-bold text-xs">2</div>
                <h3 class="text-base font-bold text-slate-900">Methodology & Formula</h3>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Measure Type -->
                <div class="sm:col-span-2">
                    <label for="measure_type" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Measure Type *</label>
                    <input type="text" 
                           name="measure_type" 
                           id="measure_type" 
                           value="{{ old('measure_type', $kpi?->measure_type) }}"
                           placeholder="e.g. Academic Excellence, Growth, Sustainability" 
                           class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors @error('measure_type') border-red-300 @enderror"
                           required
                    >
                    <span class="text-[10px] text-slate-400 mt-1 block">Sub-classification.</span>
                </div>

                <!-- Lead/Lag -->
                <div>
                    <label for="lead_lag" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Lead/Lag</label>
                    <select name="lead_lag" 
                            id="lead_lag" 
                            class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors bg-white"
                    >
                        <option value="">Select Type</option>
                        <option value="Lead" {{ old('lead_lag', $kpi?->lead_lag) === 'Lead' ? 'selected' : '' }}>Lead</option>
                        <option value="Lag" {{ old('lead_lag', $kpi?->lead_lag) === 'Lag' ? 'selected' : '' }}>Lag</option>
                    </select>
                </div>

                <!-- Polarity -->
                <div>
                    <label for="polarity" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Polarity</label>
                    <select name="polarity" 
                            id="polarity" 
                            class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors bg-white"
                    >
                        <option value="">Select Polarity</option>
                        <option value="Positive" {{ old('polarity', $kpi?->polarity) === 'Positive' ? 'selected' : '' }}>Positive (Maximize)</option>
                        <option value="Negative" {{ old('polarity', $kpi?->polarity) === 'Negative' ? 'selected' : '' }}>Negative (Minimize)</option>
                        <option value="Neutral" {{ old('polarity', $kpi?->polarity) === 'Neutral' ? 'selected' : '' }}>Neutral (Maintain/Range)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                <!-- Formula -->
                <div class="sm:col-span-2">
                    <label for="formula" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Formula</label>
                    <textarea name="formula" 
                              id="formula" 
                              rows="3" 
                              placeholder="Mathematical description: e.g. (Graduates / Total Cohort) * 100" 
                              class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm font-mono focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                    >{{ old('formula', $kpi?->formula) }}</textarea>
                </div>

                <!-- Unit Type -->
                <div>
                    <label for="unit_type" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Unit Type</label>
                    <input type="text" 
                           name="unit_type" 
                           id="unit_type" 
                           value="{{ old('unit_type', $kpi?->unit_type) }}"
                           placeholder="e.g. Percentage, Currency ($M), Hours, Count" 
                           class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                    >
                </div>
            </div>
        </div>

        <!-- CARD 3: Targets & Thresholds -->
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center">
                <div class="h-6 w-6 rounded-md bg-indigo-50 text-indigo-600 flex items-center justify-center mr-2 font-bold text-xs">3</div>
                <h3 class="text-base font-bold text-slate-900">Target & Threshold Levels</h3>
            </div>

            <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                <!-- Baseline -->
                <div>
                    <label for="baseline" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Baseline</label>
                    <input type="text" 
                           name="baseline" 
                           id="baseline" 
                           value="{{ old('baseline', $kpi?->baseline) }}"
                           placeholder="e.g. 58.5%" 
                           class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                <!-- Target -->
                <div>
                    <label for="target" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1 font-sans">Current Target</label>
                    <input type="text" 
                           name="target" 
                           id="target" 
                           value="{{ old('target', $kpi?->target) }}"
                           placeholder="e.g. 62.0%" 
                           class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                    >
                </div>

                <!-- High Threshold -->
                <div>
                    <label for="high_threshold" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">High Threshold</label>
                    <input type="text" 
                           name="high_threshold" 
                           id="high_threshold" 
                           value="{{ old('high_threshold', $kpi?->high_threshold) }}"
                           placeholder="e.g. 65.0%" 
                           class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                    >
                </div>

                <!-- Low Threshold -->
                <div>
                    <label for="low_threshold" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Low Threshold</label>
                    <input type="text" 
                           name="low_threshold" 
                           id="low_threshold" 
                           value="{{ old('low_threshold', $kpi?->low_threshold) }}"
                           placeholder="e.g. 56.0%" 
                           class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                    >
                </div>
            </div>

            <!-- 5-Year Target Plan -->
            <div class="mt-8 border-t border-slate-100 pt-5">
                <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    5-Year Target Trajectory
                </h4>
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-5">
                    @foreach([2024, 2025, 2026, 2027, 2028] as $year)
                        <div>
                            <label for="target_{{ $year }}" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Target {{ $year }}</label>
                            <input type="text" 
                                   name="target_{{ $year }}" 
                                   id="target_{{ $year }}" 
                                   value="{{ old('target_'.$year, $kpi?->{'target_'.$year}) }}"
                                   placeholder="Value" 
                                   class="block w-full rounded-md border border-slate-200 py-1.5 px-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors bg-slate-50 hover:bg-white"
                            >
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Target Rationale -->
            <div>
                <label for="target_rationale" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1 font-sans">Target Rationale</label>
                <textarea name="target_rationale" 
                          id="target_rationale" 
                          rows="2" 
                          placeholder="Justification for targets: e.g. Aligning with top state rankings..." 
                          class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                >{{ old('target_rationale', $kpi?->target_rationale) }}</textarea>
            </div>
        </div>

        <!-- CARD 4: Strategic Alignment -->
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center">
                <div class="h-6 w-6 rounded-md bg-indigo-50 text-indigo-600 flex items-center justify-center mr-2 font-bold text-xs">4</div>
                <h3 class="text-base font-bold text-slate-900">Strategic Alignment</h3>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <!-- Perspective -->
                <div>
                    <label for="perspective_id" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">BSC Perspective</label>
                    <select name="perspective_id" id="perspective_id" class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors bg-white">
                        <option value="">Select Perspective...</option>
                        @foreach($perspectives as $p)
                            <option value="{{ $p->id }}" {{ old('perspective_id', $kpi?->perspective_id) == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Strategic Theme -->
                <div>
                    <label for="strategic_theme" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Strategic Theme</label>
                    <input type="text" 
                           name="strategic_theme" 
                           id="strategic_theme" 
                           value="{{ old('strategic_theme', $kpi?->strategic_theme) }}"
                           placeholder="e.g. Student Centricity, Innovation" 
                           class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                    >
                </div>

                <!-- Objective -->
                <div class="sm:col-span-2">
                    <label for="objective_id" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Strategic Objective</label>
                    <select name="objective_id" id="objective_id" class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors bg-white">
                        <option value="">Select Objective...</option>
                        @foreach($objectives as $obj)
                            <option value="{{ $obj->id }}" {{ old('objective_id', $kpi?->objective_id) == $obj->id ? 'selected' : '' }}>
                                {{ $obj->code }}: {{ $obj->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Objective Owner -->
                <div class="sm:col-span-2">
                    <label for="objective_owner" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Objective Owner</label>
                    <input type="text" 
                           name="objective_owner" 
                           id="objective_owner" 
                           value="{{ old('objective_owner', $kpi?->objective_owner) }}"
                           placeholder="e.g. Provost Office" 
                           class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                    >
                </div>
            </div>

            <!-- Strategic Initiatives -->
            <div>
                <label for="strategic_initiatives" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1 font-sans">Strategic Initiatives</label>
                <textarea name="strategic_initiatives" 
                          id="strategic_initiatives" 
                          rows="2" 
                          placeholder="Action items: e.g. Introduce degree audit software..." 
                          class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                >{{ old('strategic_initiatives', $kpi?->strategic_initiatives) }}</textarea>
            </div>

            <!-- Intended Results -->
            <div>
                <label for="intended_results" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1 font-sans">Intended Results</label>
                <textarea name="intended_results" 
                          id="intended_results" 
                          rows="2" 
                          placeholder="Impact goals: e.g. Reduced average debt load, ranking improvements..." 
                          class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                >{{ old('intended_results', $kpi?->intended_results) }}</textarea>
            </div>

            <!-- Comparator -->
            <div>
                <label for="comparator" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Comparator / Peer Benchmark</label>
                <input type="text" 
                       name="comparator" 
                       id="comparator" 
                       value="{{ old('comparator', $kpi?->comparator) }}"
                       placeholder="e.g. Peer state average is 55.4%" 
                       class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                >
            </div>
        </div>

        <!-- CARD 5: Administration & Authorship -->
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center">
                <div class="h-6 w-6 rounded-md bg-indigo-50 text-indigo-600 flex items-center justify-center mr-2 font-bold text-xs">5</div>
                <h3 class="text-base font-bold text-slate-900">Audit & Administration</h3>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Data Provider -->
                <div>
                    <label for="data_provider" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1 font-sans">Data Provider</label>
                    <input type="text" 
                           name="data_provider" 
                           id="data_provider" 
                           value="{{ old('data_provider', $kpi?->data_provider) }}"
                           placeholder="e.g. Office of Institutional Research" 
                           class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                    >
                </div>

                <!-- Data Source -->
                <div>
                    <label for="data_source" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Data Source</label>
                    <input type="text" 
                           name="data_source" 
                           id="data_source" 
                           value="{{ old('data_source', $kpi?->data_source) }}"
                           placeholder="e.g. Banner Student System" 
                           class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                    >
                </div>

                <!-- Item Author -->
                <div>
                    <label for="item_author" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Item Author</label>
                    <input type="text" 
                           name="item_author" 
                           id="item_author" 
                           value="{{ old('item_author', $kpi?->item_author) }}"
                           placeholder="e.g. Sarah Jenkins" 
                           class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                    >
                </div>

                <!-- Collection Frequency -->
                <div>
                    <label for="collection_frequency" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Collection Frequency</label>
                    <input type="text" 
                           name="collection_frequency" 
                           id="collection_frequency" 
                           value="{{ old('collection_frequency', $kpi?->collection_frequency) }}"
                           placeholder="e.g. Monthly, Quarterly, Annually" 
                           class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                    >
                </div>

                <!-- Reporting Frequency -->
                <div>
                    <label for="reporting_frequency" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Reporting Frequency</label>
                    <input type="text" 
                           name="reporting_frequency" 
                           id="reporting_frequency" 
                           value="{{ old('reporting_frequency', $kpi?->reporting_frequency) }}"
                           placeholder="e.g. Quarterly, Annually" 
                           class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                    >
                </div>

                <!-- Blank grid cell -->
                <div class="hidden lg:block"></div>

                <!-- Verified By -->
                <div>
                    <label for="verified_by" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Verified By</label>
                    <input type="text" 
                           name="verified_by" 
                           id="verified_by" 
                           value="{{ old('verified_by', $kpi?->verified_by) }}"
                           placeholder="e.g. Dr. Robert Chen" 
                           class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                    >
                </div>

                <!-- Validated By -->
                <div>
                    <label for="validated_by" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Validated By</label>
                    <input type="text" 
                           name="validated_by" 
                           id="validated_by" 
                           value="{{ old('validated_by', $kpi?->validated_by) }}"
                           placeholder="e.g. Academic Committee" 
                           class="block w-full rounded-lg border border-slate-200 py-2 px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors"
                    >
                </div>
            </div>
        </div>

        <!-- Form Submission Actions -->
        <div class="flex items-center justify-end space-x-3.5 pt-4">
            <a href="{{ route('kpis.index') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl transition-all">
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl shadow-sm hover:shadow-md transition-all active:scale-[0.98]">
                Save KPI Record
            </button>
        </div>

    </form>

</div>
@endsection
