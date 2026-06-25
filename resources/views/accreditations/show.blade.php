@extends('layouts.app')

@section('title', $accreditation->program_name . ' — Accreditation')
@section('page_title', 'Accreditations — Detail')
@section('header_action')
    <a href="{{ route('accreditations.edit', $accreditation->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold text-white bg-[#9b1c1c] hover:bg-[#7f1d1d] rounded-lg shadow-sm transition-all">Edit</a>
@endsection

@section('content')
<div class="space-y-6">
    <nav class="flex text-xs font-semibold text-slate-500 space-x-2">
        <a href="{{ route('accreditations.index') }}" class="hover:text-violet-600">Accreditations</a>
        <span>/</span><span class="text-slate-900">{{ Str::limit($accreditation->program_name, 50) }}</span>
    </nav>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            {{-- Header --}}
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6">
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    @php $lc=['Program'=>'violet','Institutional'=>'indigo','Department'=>'purple'][$accreditation->level]??'slate'; @endphp
                    <span class="inline-flex items-center rounded-lg bg-{{ $lc }}-50 px-3 py-1 text-xs font-bold text-{{ $lc }}-700 border border-{{ $lc }}-200/50">{{ $accreditation->level }}</span>
                    @if($accreditation->status)
                        @php $sc=['Active'=>'emerald','Pending'=>'amber','Expired'=>'red','Under Surveillance'=>'sky','Withdrawn'=>'slate'][$accreditation->status]??'slate'; @endphp
                        <span class="inline-flex items-center rounded-lg bg-{{ $sc }}-50 px-3 py-1 text-xs font-bold text-{{ $sc }}-700 border border-{{ $sc }}-200/50">{{ $accreditation->status }}</span>
                    @endif
                    @if($accreditation->accreditation_level)
                        <span class="inline-flex items-center rounded-lg bg-violet-100 px-3 py-1 text-xs font-bold text-violet-800">{{ $accreditation->accreditation_level }}</span>
                    @endif
                </div>
                <h2 class="text-2xl font-extrabold text-slate-900">{{ $accreditation->program_name }}</h2>
                @if($accreditation->college_department)
                    <p class="mt-1 text-sm text-slate-500">College/Dept: <strong class="text-slate-700">{{ $accreditation->college_department }}</strong></p>
                @endif
                <p class="mt-1 text-sm text-slate-500">Accrediting Body: <strong class="text-slate-700">{{ $accreditation->accrediting_body }}</strong></p>
            </div>

            {{-- Dates & Survey --}}
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Validity & Survey Schedule</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 bg-violet-50/30 rounded-xl p-4 border border-violet-100/50">
                    <div><span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Validity Start</span><div class="text-sm font-semibold text-slate-800 mt-1">{{ $accreditation->validity_start?->format('M d, Y') ?? 'N/A' }}</div></div>
                    <div><span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Validity End</span>
                        <div class="text-sm font-semibold mt-1 {{ $accreditation->validity_end && $accreditation->validity_end->isPast() ? 'text-red-600' : 'text-slate-800' }}">
                            {{ $accreditation->validity_end?->format('M d, Y') ?? 'N/A' }}
                            @if($accreditation->validity_end && $accreditation->validity_end->isPast())
                                <span class="block text-[10px] font-bold text-red-500">EXPIRED</span>
                            @endif
                        </div>
                    </div>
                    <div><span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Academic Year</span><div class="text-sm font-semibold text-slate-800 mt-1 font-mono">{{ $accreditation->academic_year }}</div></div>
                    <div><span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Last Survey</span><div class="text-sm font-semibold text-slate-800 mt-1">{{ $accreditation->last_survey_date?->format('M d, Y') ?? 'N/A' }}</div></div>
                    <div><span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Next Survey</span><div class="text-sm font-semibold text-slate-800 mt-1">{{ $accreditation->next_survey_date?->format('M d, Y') ?? 'N/A' }}</div></div>
                    <div><span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Survey Visits</span><div class="text-sm font-semibold text-slate-800 mt-1">{{ $accreditation->survey_visit_count ?? 'N/A' }}</div></div>
                </div>
                @if($accreditation->certifying_officer || $accreditation->focal_person)
                    <div class="mt-4 grid grid-cols-2 gap-4">
                        @if($accreditation->certifying_officer)<div><span class="text-xs font-bold uppercase tracking-wider text-slate-400">Certifying Officer</span><div class="text-sm font-semibold text-slate-800 mt-1">{{ $accreditation->certifying_officer }}</div></div>@endif
                        @if($accreditation->focal_person)<div><span class="text-xs font-bold uppercase tracking-wider text-slate-400">Focal Person</span><div class="text-sm font-semibold text-slate-800 mt-1">{{ $accreditation->focal_person }}</div></div>@endif
                    </div>
                @endif
            </div>

            @if($accreditation->conditions || $accreditation->remarks)
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-4">
                @if($accreditation->conditions)<div><span class="text-xs font-bold uppercase tracking-wider text-slate-400">Conditions</span><p class="text-sm text-slate-600 mt-1 leading-relaxed whitespace-pre-line">{{ $accreditation->conditions }}</p></div>@endif
                @if($accreditation->remarks)<div class="{{ $accreditation->conditions ? 'border-t border-slate-100 pt-4' : '' }}"><span class="text-xs font-bold uppercase tracking-wider text-slate-400">Remarks</span><p class="text-sm text-slate-600 mt-1 leading-relaxed whitespace-pre-line">{{ $accreditation->remarks }}</p></div>@endif
            </div>
            @endif
        </div>

        <div class="space-y-5">
            <div class="flex flex-col space-y-2.5">
                <a href="{{ route('accreditations.edit', $accreditation->id) }}" class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white bg-violet-600 hover:bg-violet-700 rounded-xl shadow-sm transition-all">Edit Record</a>
                <a href="{{ route('accreditations.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl shadow-sm transition-all">Add New Record</a>
                <form action="{{ route('accreditations.destroy', $accreditation->id) }}" method="POST" onsubmit="return confirm('Delete this accreditation record?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-xl transition-all">Delete Record</button>
                </form>
            </div>
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-5 space-y-3 text-xs">
                <h4 class="font-bold text-slate-700 uppercase tracking-wider border-b border-slate-100 pb-2">Record Info</h4>
                <div class="flex justify-between"><span class="text-slate-400">Author</span><span class="font-semibold text-slate-700">{{ $accreditation->item_author ?? 'N/A' }}</span></div>
                @if($accreditation->date)<div class="flex justify-between"><span class="text-slate-400">Date</span><span class="font-semibold">{{ $accreditation->date->format('M d, Y') }}</span></div>@endif
                <div class="flex justify-between"><span class="text-slate-400">Created</span><span class="font-mono text-slate-500">{{ $accreditation->created_at->format('M d, Y') }}</span></div>
                <div class="flex justify-between"><span class="text-slate-400">Updated</span><span class="font-mono text-slate-500">{{ $accreditation->updated_at->format('M d, Y') }}</span></div>
            </div>
        </div>
    </div>
</div>
@endsection
