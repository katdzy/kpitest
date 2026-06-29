@extends('layouts.app')

@section('title', 'Submit Report — ' . $kpi->measure_code)
@section('page_title', 'Submit Report')

@section('header_action')
<a href="{{ route('kpis.show', $kpi->id) }}" class="btn-secondary text-slate-700 hover:bg-slate-50 gap-1.5">
    <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
    Back to KPI
</a>
@endsection

@section('content')
@php
    $schoolYears = $schoolYears ?? [];
    $statusColors = [
        'On Track' => 'emerald',
        'Warning'  => 'amber',
        'Off Track'=> 'red',
    ];
@endphp

<div class="space-y-6" x-data="{
    reportType: '{{ $selectedType ?? '' }}',
    schoolYear: '{{ $selectedYear ?? '' }}',
    actualValue: '',
}">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 animate-fade-up">
        <a href="{{ route('dashboard') }}" class="text-slate-400 hover:text-red-700 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75"/></svg>
        </a>
        <svg class="w-3.5 h-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        <a href="{{ route('kpis.index') }}" class="text-xs font-semibold text-slate-500 uppercase tracking-wider hover:text-red-700 transition-colors">KPI Library</a>
        <svg class="w-3.5 h-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        <a href="{{ route('kpis.show', $kpi->id) }}" class="inline-flex items-center px-2 py-0.5 rounded-md bg-red-50 border border-red-200/60 text-xs font-bold font-mono text-red-700">{{ $kpi->measure_code }}</a>
        <svg class="w-3.5 h-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        <span class="text-xs font-bold text-slate-700">Submit Report</span>
    </nav>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- LEFT: Form --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- KPI Summary Card --}}
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 animate-fade-up">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <span class="text-xs font-bold font-mono text-red-700 bg-red-50 border border-red-200/50 px-2.5 py-1 rounded-lg">{{ $kpi->measure_code }}</span>
                        <h2 class="text-xl font-extrabold text-slate-900 mt-2">{{ $kpi->measure_name }}</h2>
                        <p class="text-sm text-slate-500 mt-0.5">{{ $kpi->measure_owner }}</p>
                    </div>
                    <div class="flex-shrink-0 text-right text-xs text-slate-400">
                        <span class="block font-bold text-slate-500">Baseline</span>
                        <span class="text-lg font-extrabold text-slate-800">{{ $kpi->baseline ?? '—' }}</span>
                    </div>
                </div>
            </div>

            {{-- Report Submission Form --}}
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 animate-fade-up animate-fade-up-1">
                <h3 class="text-base font-bold text-slate-900 mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"/></svg>
                    New Performance Report
                </h3>

                <form method="POST" action="{{ route('kpis.reports.store', $kpi->id) }}">
                    @csrf

                    {{-- Row 1: School Year + Report Type --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                        <div>
                            <label for="school_year" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">School Year <span class="text-red-500">*</span></label>
                            <select id="school_year" name="school_year"
                                    x-model="schoolYear"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 font-medium shadow-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all">
                                <option value="">Select school year…</option>
                                @foreach($schoolYears as $year)
                                    <option value="{{ $year }}" @selected(old('school_year', $selectedYear) === $year)>{{ $year }}</option>
                                @endforeach
                            </select>
                            @error('school_year') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Report Type <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="relative flex cursor-pointer">
                                    <input type="radio" name="report_type" value="Mid-Year" x-model="reportType"
                                           class="sr-only peer" @checked(old('report_type', $selectedType) === 'Mid-Year')>
                                    <div class="w-full flex flex-col items-center justify-center gap-1 p-3 rounded-xl border-2 border-slate-200 bg-slate-50 text-slate-500 text-xs font-bold transition-all
                                                peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:text-amber-700">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/></svg>
                                        Mid-Year
                                    </div>
                                </label>
                                <label class="relative flex cursor-pointer">
                                    <input type="radio" name="report_type" value="Year-Ender" x-model="reportType"
                                           class="sr-only peer" @checked(old('report_type', $selectedType) === 'Year-Ender')>
                                    <div class="w-full flex flex-col items-center justify-center gap-1 p-3 rounded-xl border-2 border-slate-200 bg-slate-50 text-slate-500 text-xs font-bold transition-all
                                                peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5"/></svg>
                                        Year-Ender
                                    </div>
                                </label>
                            </div>
                            @error('report_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Target for selected year (dynamic) --}}
                    <div class="mb-5 p-3.5 rounded-xl bg-indigo-50 border border-indigo-100" x-show="schoolYear" style="display:none">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-bold text-indigo-600 uppercase tracking-wider">5-Year Plan Target for <span x-text="schoolYear"></span></span>
                            <span class="font-extrabold text-indigo-800">
                                @foreach(['2024-2025' => $kpi->target_2024, '2025-2026' => $kpi->target_2025, '2026-2027' => $kpi->target_2026, '2027-2028' => $kpi->target_2027, '2028-2029' => $kpi->target_2028] as $yr => $val)
                                    <span x-show="schoolYear === '{{ $yr }}'">{{ $val ?? 'Not set' }}</span>
                                @endforeach
                            </span>
                        </div>
                    </div>

                    {{-- Row 2: Actual Value + Department --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                        <div>
                            <label for="actual_value" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                                Actual Value Achieved <span class="text-red-500">*</span>
                                @if($kpi->unit_type) <span class="font-normal text-slate-400">({{ $kpi->unit_type }})</span> @endif
                            </label>
                            <input id="actual_value" type="number" name="actual_value" step="any"
                                   value="{{ old('actual_value') }}"
                                   x-model="actualValue"
                                   placeholder="e.g. 85.5"
                                   class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all">
                            @error('actual_value') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="department_id" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Reporting Department</label>
                            <select id="department_id" name="department_id"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 font-medium shadow-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all">
                                <option value="">University-wide</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" @selected(old('department_id') == $dept->id)>{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div class="mb-5">
                        <label for="notes" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Notes / Commentary</label>
                        <textarea id="notes" name="notes" rows="3"
                                  placeholder="Any observations, context, or explanations for this period's performance…"
                                  class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 shadow-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all resize-none">{{ old('notes') }}</textarea>
                    </div>

                    {{-- Initiative Outcome (Year-Ender only) --}}
                    <div class="mb-6" x-show="reportType === 'Year-Ender'" style="display:none"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="rounded-xl bg-emerald-50 border border-emerald-200 p-4">
                            <label for="initiative_outcome" class="block text-xs font-bold uppercase tracking-wider text-emerald-700 mb-1.5">
                                <svg class="w-3.5 h-3.5 inline mr-1 -mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                Initiative Outcome <span class="text-emerald-600">(Year-Ender)</span>
                            </label>
                            <p class="text-[11px] text-emerald-600 mb-2">Describe what the strategic initiative actually achieved during this school year. This will be displayed on the Year-Ender report.</p>
                            <textarea id="initiative_outcome" name="initiative_outcome" rows="4"
                                      placeholder="e.g. The Board Exam Review Program completed with a 91% passing rate, exceeding the 88% target. A total of 142 students participated across 3 departments…"
                                      class="w-full rounded-lg border border-emerald-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all resize-none">{{ old('initiative_outcome') }}</textarea>
                        </div>
                    </div>

                    {{-- Submitted By --}}
                    <div class="mb-6">
                        <label for="submitted_by" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Submitted By</label>
                        <input id="submitted_by" type="text" name="submitted_by"
                               value="{{ old('submitted_by') }}"
                               placeholder="Full name of the person submitting this report"
                               class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all">
                    </div>

                    {{-- Submit --}}
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <a href="{{ route('kpis.show', $kpi->id) }}" class="btn-secondary text-slate-700 hover:bg-slate-50">Cancel</a>
                        <button type="submit" class="btn-primary text-white gap-2" style="background: linear-gradient(135deg,#9b1c1c,#ef4444);">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z"/></svg>
                            Submit Report
                        </button>
                    </div>
                </form>
            </div>

        </div>

        {{-- RIGHT: Existing Reports History --}}
        <div class="space-y-5">

            {{-- Guidelines --}}
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-5 animate-fade-up">
                <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/></svg>
                    Reporting Guidelines
                </h3>
                <div class="space-y-2.5 text-xs text-slate-600">
                    <div class="flex items-start gap-2">
                        <span class="mt-0.5 flex-shrink-0 w-5 h-5 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-[10px]">M</span>
                        <p><strong class="text-slate-800">Mid-Year</strong> — Submitted around January–February. Reports preliminary actual values and flags KPIs at risk.</p>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="mt-0.5 flex-shrink-0 w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-[10px]">Y</span>
                        <p><strong class="text-slate-800">Year-Ender</strong> — Submitted around May–June. Contains final actual values and an Initiative Outcome narrative.</p>
                    </div>
                </div>
            </div>

            {{-- 5-Year Targets Reference --}}
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-5 animate-fade-up animate-fade-up-1">
                <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    5-Year Targets
                </h3>
                <div class="space-y-1.5">
                    @foreach(['2024-2025' => $kpi->target_2024, '2025-2026' => $kpi->target_2025, '2026-2027' => $kpi->target_2026, '2027-2028' => $kpi->target_2027, '2028-2029' => $kpi->target_2028] as $yr => $val)
                    <div class="flex items-center justify-between text-xs py-1.5 {{ !$loop->last ? 'border-b border-slate-50' : '' }}">
                        <span class="font-semibold text-slate-500">{{ $yr }}</span>
                        <span class="font-extrabold {{ $val ? 'text-indigo-700' : 'text-slate-300' }}">
                            {{ $val ?? '—' }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Previous Reports --}}
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-5 animate-fade-up animate-fade-up-2">
                <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    Submitted Reports
                </h3>
                @if($existingReports->isEmpty())
                    <p class="text-xs text-slate-400 italic">No reports have been submitted yet for this KPI.</p>
                @else
                    <div class="space-y-4">
                        @foreach($existingReports as $year => $reports)
                        <div>
                            <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">{{ $year }}</div>
                            <div class="space-y-1.5">
                                @foreach($reports as $report)
                                @php
                                    $color = $report->statusColor();
                                    $typeColor = $report->report_type === 'Mid-Year' ? 'amber' : 'emerald';
                                @endphp
                                <div class="flex items-center justify-between p-2 rounded-lg bg-slate-50 border border-slate-100 text-xs">
                                    <span class="font-bold text-{{ $typeColor }}-700 bg-{{ $typeColor }}-50 border border-{{ $typeColor }}-200 px-1.5 py-0.5 rounded text-[10px]">
                                        {{ $report->report_type }}
                                    </span>
                                    <span class="font-extrabold text-slate-800">{{ $report->actual_value }}</span>
                                    <span class="font-bold text-{{ $color }}-700 bg-{{ $color }}-50 border border-{{ $color }}-200 px-1.5 py-0.5 rounded-full text-[10px]">
                                        {{ $report->status }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
