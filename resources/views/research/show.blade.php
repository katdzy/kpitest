@extends('layouts.app')

@section('title', $research->title . ' — Research')
@section('page_title', 'Research — Project Detail')
@section('header_action')
    <a href="{{ route('research.edit', $research->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold text-white bg-[#9b1c1c] hover:bg-[#7f1d1d] rounded-lg shadow-sm transition-all">Edit</a>
@endsection

@section('content')
<div class="space-y-6">
    <nav class="flex text-xs font-semibold text-slate-500 space-x-2">
        <a href="{{ route('research.index') }}" class="hover:text-sky-600">Research</a>
        <span>/</span><span class="text-slate-900">{{ Str::limit($research->title, 50) }}</span>
    </nav>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            {{-- Header --}}
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6">
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    @php $tc=['Basic'=>'sky','Applied'=>'blue','Development'=>'indigo','Action'=>'teal','Policy'=>'violet'][$research->type]??'slate'; @endphp
                    <span class="inline-flex items-center rounded-lg bg-{{ $tc }}-50 px-3 py-1 text-xs font-bold text-{{ $tc }}-700 border border-{{ $tc }}-200/50">{{ $research->type }}</span>
                    @if($research->status)
                        @php $sc=['Proposed'=>'amber','Ongoing'=>'sky','Completed'=>'slate','Published'=>'emerald','Discontinued'=>'red'][$research->status]??'slate'; @endphp
                        <span class="inline-flex items-center rounded-lg bg-{{ $sc }}-50 px-3 py-1 text-xs font-bold text-{{ $sc }}-700 border border-{{ $sc }}-200/50">{{ $research->status }}</span>
                    @endif
                    @if($research->output_type)
                        <span class="inline-flex items-center rounded-lg bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 border border-emerald-200/50">{{ $research->output_type }}</span>
                    @endif
                </div>
                <h2 class="text-xl font-extrabold text-slate-900 leading-snug">{{ $research->title }}</h2>
                <p class="mt-2 text-sm text-slate-500">Lead: <strong class="text-slate-700">{{ $research->lead_researcher }}</strong></p>
                @if($research->co_researchers)
                    <p class="text-sm text-slate-500 mt-0.5">Co-Researchers: <span class="text-slate-700">{{ $research->co_researchers }}</span></p>
                @endif
                @if($research->abstract)
                    <div class="mt-5 border-t border-slate-100 pt-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Abstract</span>
                        <p class="text-sm text-slate-600 mt-2 leading-relaxed">{{ $research->abstract }}</p>
                    </div>
                @endif
                @if($research->keywords)
                    <div class="mt-3 flex flex-wrap gap-1.5">
                        @foreach(explode(',', $research->keywords) as $kw)
                            <span class="bg-sky-50 text-sky-700 text-[10px] font-semibold px-2 py-0.5 rounded-full border border-sky-200/50">{{ trim($kw) }}</span>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Funding & Timeline --}}
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Funding & Timeline</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 bg-sky-50/30 rounded-xl p-4 border border-sky-100/50">
                    <div><span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Funding Source</span><div class="text-sm font-semibold text-slate-800 mt-1">{{ $research->funding_source ?? 'N/A' }}</div></div>
                    <div><span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Funding Amount</span><div class="text-xl font-extrabold text-sky-700 mt-1">{{ $research->funding_amount ? 'PHP ' . number_format($research->funding_amount, 2) : 'N/A' }}</div></div>
                    <div><span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Implementing Unit</span><div class="text-sm font-semibold text-slate-800 mt-1">{{ $research->implementing_unit ?? 'N/A' }}</div></div>
                    <div><span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Start Date</span><div class="text-sm font-semibold text-slate-800 mt-1">{{ $research->start_date?->format('M d, Y') ?? 'N/A' }}</div></div>
                    <div><span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">End Date</span><div class="text-sm font-semibold text-slate-800 mt-1">{{ $research->end_date?->format('M d, Y') ?? 'N/A' }}</div></div>
                    <div><span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Academic Year</span><div class="text-sm font-semibold font-mono text-slate-800 mt-1">{{ $research->academic_year }}</div></div>
                </div>
            </div>

            {{-- Publication Details --}}
            @if($research->publication_title || $research->isbn_issn || $research->indexed_in || $research->doi)
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-3">
                <h3 class="text-lg font-bold text-slate-900">Publication Details</h3>
                @if($research->publication_title)<div><span class="text-xs font-bold uppercase tracking-wider text-slate-400">Publication Title</span><p class="text-sm font-semibold text-slate-800 mt-1">{{ $research->publication_title }}</p></div>@endif
                <div class="grid grid-cols-2 gap-4">
                    @if($research->isbn_issn)<div><span class="text-xs font-bold uppercase tracking-wider text-slate-400">ISBN/ISSN</span><div class="text-sm font-mono text-slate-700 mt-1">{{ $research->isbn_issn }}</div></div>@endif
                    @if($research->indexed_in)<div><span class="text-xs font-bold uppercase tracking-wider text-slate-400">Indexed In</span><div class="text-sm font-semibold text-emerald-700 mt-1">{{ $research->indexed_in }}</div></div>@endif
                    @if($research->doi)<div><span class="text-xs font-bold uppercase tracking-wider text-slate-400">DOI</span><div class="text-sm font-mono text-sky-600 mt-1 break-all">{{ $research->doi }}</div></div>@endif
                    @if($research->citation_count)<div><span class="text-xs font-bold uppercase tracking-wider text-slate-400">Citations</span><div class="text-sm font-bold text-slate-800 mt-1">{{ $research->citation_count }}</div></div>@endif
                </div>
            </div>
            @endif

            @if($research->remarks)
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Remarks</span>
                <p class="text-sm text-slate-600 mt-2 leading-relaxed whitespace-pre-line">{{ $research->remarks }}</p>
            </div>
            @endif
        </div>

        <div class="space-y-5">
            <div class="flex flex-col space-y-2.5">
                <a href="{{ route('research.edit', $research->id) }}" class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white bg-sky-500 hover:bg-sky-600 rounded-xl shadow-sm transition-all">Edit Project</a>
                <a href="{{ route('research.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl shadow-sm transition-all">Add New Project</a>
                <form action="{{ route('research.destroy', $research->id) }}" method="POST" onsubmit="return confirm('Delete this research project?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-xl transition-all">Delete Project</button>
                </form>
            </div>
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-5 space-y-3 text-xs">
                <h4 class="font-bold text-slate-700 uppercase tracking-wider border-b border-slate-100 pb-2">Record Info</h4>
                <div class="flex justify-between"><span class="text-slate-400">Author</span><span class="font-semibold text-slate-700">{{ $research->item_author ?? 'N/A' }}</span></div>
                @if($research->date)<div class="flex justify-between"><span class="text-slate-400">Date</span><span class="font-semibold">{{ $research->date->format('M d, Y') }}</span></div>@endif
                <div class="flex justify-between"><span class="text-slate-400">Created</span><span class="font-mono text-slate-500">{{ $research->created_at->format('M d, Y') }}</span></div>
                <div class="flex justify-between"><span class="text-slate-400">Updated</span><span class="font-mono text-slate-500">{{ $research->updated_at->format('M d, Y') }}</span></div>
            </div>
        </div>
    </div>
</div>
@endsection
