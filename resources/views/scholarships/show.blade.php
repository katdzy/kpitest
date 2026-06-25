@extends('layouts.app')

@section('title', $scholarship->title . ' — Scholarship/Grant')
@section('page_title', 'Scholarships & Grants — Detail')
@section('header_action')
    <a href="{{ route('scholarships.edit', $scholarship->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold text-white bg-[#9b1c1c] hover:bg-[#7f1d1d] rounded-lg shadow-sm transition-all">
        <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
        Edit
    </a>
@endsection

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex text-xs font-semibold text-slate-500 space-x-2">
        <a href="{{ route('scholarships.index') }}" class="hover:text-amber-600">Scholarships & Grants</a>
        <span>/</span>
        <span class="text-slate-900">{{ Str::limit($scholarship->title, 50) }}</span>
    </nav>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Left: Main Details --}}
        <div class="space-y-6 lg:col-span-2">

            {{-- Header Card --}}
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6">
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    @php
                        $typeColors = ['Scholarship'=>'amber','Grant'=>'blue','Fellowship'=>'purple','Assistantship'=>'teal'];
                        $tc = $typeColors[$scholarship->type] ?? 'slate';
                    @endphp
                    <span class="inline-flex items-center rounded-lg bg-{{ $tc }}-50 px-3 py-1 text-xs font-bold text-{{ $tc }}-700 border border-{{ $tc }}-200/50">{{ $scholarship->type }}</span>
                    @if($scholarship->status)
                        @php $sc = ['Active'=>'emerald','Completed'=>'slate','Pending'=>'amber','Suspended'=>'red'][$scholarship->status] ?? 'slate'; @endphp
                        <span class="inline-flex items-center rounded-lg bg-{{ $sc }}-50 px-3 py-1 text-xs font-bold text-{{ $sc }}-700 border border-{{ $sc }}-200/50">{{ $scholarship->status }}</span>
                    @endif
                    <span class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">{{ $scholarship->academic_year }}</span>
                </div>
                <h2 class="text-2xl font-extrabold text-slate-900">{{ $scholarship->title }}</h2>
                @if($scholarship->administering_unit)
                    <p class="mt-1 text-sm text-slate-500 font-medium">Administered by: <strong class="text-slate-700">{{ $scholarship->administering_unit }}</strong></p>
                @endif
                @if($scholarship->description)
                    <div class="mt-5 border-t border-slate-100 pt-4">
                        <p class="text-sm text-slate-600 leading-relaxed">{{ $scholarship->description }}</p>
                    </div>
                @endif
            </div>

            {{-- Funding & Beneficiaries --}}
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Funding & Beneficiaries
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 bg-amber-50/40 rounded-xl p-4 border border-amber-100/50">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Funding Source</span>
                        <div class="text-sm font-semibold text-slate-800 mt-1">{{ $scholarship->funding_source ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Amount</span>
                        <div class="text-xl font-extrabold text-amber-700 mt-1">
                            @if($scholarship->amount)
                                {{ $scholarship->currency ?? 'PHP' }} {{ number_format($scholarship->amount, 2) }}
                            @else N/A @endif
                        </div>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Beneficiaries</span>
                        <div class="text-xl font-extrabold text-slate-900 mt-1">{{ $scholarship->beneficiaries_count ? number_format($scholarship->beneficiaries_count) : 'N/A' }}</div>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Beneficiary Type</span>
                        <div class="text-sm font-semibold text-slate-800 mt-1">{{ $scholarship->beneficiary_type }}</div>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Start Date</span>
                        <div class="text-sm font-semibold text-slate-800 mt-1">{{ $scholarship->start_date?->format('M d, Y') ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">End Date</span>
                        <div class="text-sm font-semibold text-slate-800 mt-1">{{ $scholarship->end_date?->format('M d, Y') ?? 'N/A' }}</div>
                    </div>
                </div>
                @if($scholarship->selection_criteria)
                    <div class="mt-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Selection Criteria</span>
                        <p class="text-sm text-slate-600 mt-1">{{ $scholarship->selection_criteria }}</p>
                    </div>
                @endif
            </div>

            {{-- Outcomes & Remarks --}}
            @if($scholarship->outcomes || $scholarship->remarks)
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-4">
                @if($scholarship->outcomes)
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Outcomes</span>
                        <p class="text-sm text-slate-600 mt-1 leading-relaxed whitespace-pre-line">{{ $scholarship->outcomes }}</p>
                    </div>
                @endif
                @if($scholarship->remarks)
                    <div class="{{ $scholarship->outcomes ? 'border-t border-slate-100 pt-4' : '' }}">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Remarks</span>
                        <p class="text-sm text-slate-600 mt-1 leading-relaxed whitespace-pre-line">{{ $scholarship->remarks }}</p>
                    </div>
                @endif
            </div>
            @endif
        </div>

        {{-- Right: Sidebar Meta --}}
        <div class="space-y-5">
            {{-- Quick Actions --}}
            <div class="flex flex-col space-y-2.5">
                <a href="{{ route('scholarships.edit', $scholarship->id) }}" class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white bg-amber-500 hover:bg-amber-600 rounded-xl shadow-sm transition-all">
                    <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                    Edit Record
                </a>
                <a href="{{ route('scholarships.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl shadow-sm transition-all">
                    <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Add New Record
                </a>
                <form action="{{ route('scholarships.destroy', $scholarship->id) }}" method="POST" onsubmit="return confirm('Delete this scholarship record? This cannot be undone.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-xl transition-all">
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Delete Record
                    </button>
                </form>
            </div>

            {{-- Record Meta --}}
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-5 space-y-3 text-xs">
                <h4 class="font-bold text-slate-700 uppercase tracking-wider border-b border-slate-100 pb-2">Record Information</h4>
                <div class="flex justify-between"><span class="text-slate-400">Author</span><span class="font-semibold text-slate-700">{{ $scholarship->item_author ?? 'N/A' }}</span></div>
                @if($scholarship->date)
                    <div class="flex justify-between"><span class="text-slate-400">Date</span><span class="font-semibold text-slate-700">{{ $scholarship->date->format('M d, Y') }}</span></div>
                @endif
                <div class="flex justify-between"><span class="text-slate-400">Created</span><span class="font-mono text-slate-500">{{ $scholarship->created_at->format('M d, Y') }}</span></div>
                <div class="flex justify-between"><span class="text-slate-400">Updated</span><span class="font-mono text-slate-500">{{ $scholarship->updated_at->format('M d, Y') }}</span></div>
            </div>
        </div>
    </div>
</div>
@endsection
