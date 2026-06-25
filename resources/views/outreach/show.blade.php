@extends('layouts.app')

@section('title', $outreach->program_name . ' — Outreach')
@section('page_title', 'Outreach Programs — Detail')
@section('header_action')
    <a href="{{ route('outreach.edit', $outreach->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold text-white bg-[#9b1c1c] hover:bg-[#7f1d1d] rounded-lg shadow-sm transition-all">Edit</a>
@endsection

@section('content')
<div class="space-y-6">
    <nav class="flex text-xs font-semibold text-slate-500 space-x-2">
        <a href="{{ route('outreach.index') }}" class="hover:text-teal-600">Outreach Programs</a>
        <span>/</span><span class="text-slate-900">{{ Str::limit($outreach->program_name, 50) }}</span>
    </nav>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6">
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    @php $typeColors=['Community'=>'teal','Extension'=>'emerald','Partnership'=>'blue','Livelihood'=>'amber','Health'=>'rose','Education'=>'indigo']; $tc=$typeColors[$outreach->program_type]??'slate'; @endphp
                    <span class="inline-flex items-center rounded-lg bg-{{ $tc }}-50 px-3 py-1 text-xs font-bold text-{{ $tc }}-700 border border-{{ $tc }}-200/50">{{ $outreach->program_type }}</span>
                    @if($outreach->status)
                        @php $sc=['Planned'=>'sky','Ongoing'=>'teal','Completed'=>'slate','Cancelled'=>'red'][$outreach->status]??'slate'; @endphp
                        <span class="inline-flex items-center rounded-lg bg-{{ $sc }}-50 px-3 py-1 text-xs font-bold text-{{ $sc }}-700 border border-{{ $sc }}-200/50">{{ $outreach->status }}</span>
                    @endif
                    <span class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">{{ $outreach->academic_year }}</span>
                </div>
                <h2 class="text-2xl font-extrabold text-slate-900">{{ $outreach->program_name }}</h2>
                <p class="mt-1 text-sm text-slate-500">Implementing Unit: <strong class="text-slate-700">{{ $outreach->implementing_unit }}</strong></p>
                @if($outreach->description)
                    <p class="mt-4 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-4">{{ $outreach->description }}</p>
                @endif
            </div>

            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Program Details</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 bg-teal-50/30 rounded-xl p-4 border border-teal-100/50">
                    <div><span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Target Community</span><div class="text-sm font-semibold text-slate-800 mt-1">{{ $outreach->target_community ?? 'N/A' }}</div></div>
                    <div><span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Location</span><div class="text-sm font-semibold text-slate-800 mt-1">{{ $outreach->location ?? 'N/A' }}</div></div>
                    <div><span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Beneficiaries</span><div class="text-xl font-extrabold text-teal-700 mt-1">{{ $outreach->beneficiaries_count ? number_format($outreach->beneficiaries_count) : 'N/A' }}</div></div>
                    <div><span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Start Date</span><div class="text-sm font-semibold text-slate-800 mt-1">{{ $outreach->start_date?->format('M d, Y') ?? 'N/A' }}</div></div>
                    <div><span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">End Date</span><div class="text-sm font-semibold text-slate-800 mt-1">{{ $outreach->end_date?->format('M d, Y') ?? 'N/A' }}</div></div>
                    <div><span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Coordinator</span><div class="text-sm font-semibold text-slate-800 mt-1">{{ $outreach->program_coordinator ?? 'N/A' }}</div></div>
                </div>
                @if($outreach->partner_agencies)
                    <div class="mt-4"><span class="text-xs font-bold uppercase tracking-wider text-slate-400">Partner Agencies</span><p class="text-sm text-slate-600 mt-1">{{ $outreach->partner_agencies }}</p></div>
                @endif
            </div>

            @if($outreach->outcomes || $outreach->challenges || $outreach->recommendations)
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-4">
                @if($outreach->outcomes)<div><span class="text-xs font-bold uppercase tracking-wider text-slate-400">Outcomes</span><p class="text-sm text-slate-600 mt-1 leading-relaxed whitespace-pre-line">{{ $outreach->outcomes }}</p></div>@endif
                @if($outreach->challenges)<div class="{{ $outreach->outcomes ? 'border-t border-slate-100 pt-4' : '' }}"><span class="text-xs font-bold uppercase tracking-wider text-slate-400">Challenges</span><p class="text-sm text-slate-600 mt-1 leading-relaxed whitespace-pre-line">{{ $outreach->challenges }}</p></div>@endif
                @if($outreach->recommendations)<div class="border-t border-slate-100 pt-4"><span class="text-xs font-bold uppercase tracking-wider text-slate-400">Recommendations</span><p class="text-sm text-slate-600 mt-1 leading-relaxed whitespace-pre-line">{{ $outreach->recommendations }}</p></div>@endif
            </div>
            @endif
        </div>

        <div class="space-y-5">
            <div class="flex flex-col space-y-2.5">
                <a href="{{ route('outreach.edit', $outreach->id) }}" class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white bg-teal-500 hover:bg-teal-600 rounded-xl shadow-sm transition-all">Edit Record</a>
                <a href="{{ route('outreach.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl shadow-sm transition-all">Add New Program</a>
                <form action="{{ route('outreach.destroy', $outreach->id) }}" method="POST" onsubmit="return confirm('Delete this program?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-xl transition-all">Delete Record</button>
                </form>
            </div>
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-5 space-y-3 text-xs">
                <h4 class="font-bold text-slate-700 uppercase tracking-wider border-b border-slate-100 pb-2">Record Info</h4>
                <div class="flex justify-between"><span class="text-slate-400">Author</span><span class="font-semibold text-slate-700">{{ $outreach->item_author ?? 'N/A' }}</span></div>
                @if($outreach->date)<div class="flex justify-between"><span class="text-slate-400">Date</span><span class="font-semibold">{{ $outreach->date->format('M d, Y') }}</span></div>@endif
                <div class="flex justify-between"><span class="text-slate-400">Created</span><span class="font-mono text-slate-500">{{ $outreach->created_at->format('M d, Y') }}</span></div>
                <div class="flex justify-between"><span class="text-slate-400">Updated</span><span class="font-mono text-slate-500">{{ $outreach->updated_at->format('M d, Y') }}</span></div>
            </div>
        </div>
    </div>
</div>
@endsection
