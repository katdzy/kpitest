@extends('layouts.app')

@section('title', 'Add Research Project')
@section('page_title', 'Research — Add New Project')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <nav class="flex text-xs font-semibold text-slate-500 space-x-2">
        <a href="{{ route('research.index') }}" class="hover:text-sky-600">Research</a>
        <span>/</span><span class="text-slate-900">Add New</span>
    </nav>
    <form action="{{ route('research.store') }}" method="POST" class="space-y-5">
        @csrf
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-5">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Project Information</h3>
            <div>
                <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Project Title <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">
                @error('title')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <label for="type" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Research Type <span class="text-red-500">*</span></label>
                    <select id="type" name="type" required class="block w-full rounded-xl border border-slate-200 py-2.5 px-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 bg-white">
                        <option value="">Select type</option>
                        @foreach(['Basic','Applied','Development','Action','Policy'] as $t)
                            <option value="{{ $t }}" {{ old('type') === $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="lead_researcher" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Lead Researcher <span class="text-red-500">*</span></label>
                    <input type="text" id="lead_researcher" name="lead_researcher" value="{{ old('lead_researcher') }}" required class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">
                </div>
                <div>
                    <label for="academic_year" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Academic Year <span class="text-red-500">*</span></label>
                    <select id="academic_year" name="academic_year" required class="block w-full rounded-xl border border-slate-200 py-2.5 px-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 bg-white">
                        <option value="">Select year</option>
                        @foreach($yearRanges as $yr)
                            <option value="{{ $yr }}" {{ old('academic_year') === $yr ? 'selected' : '' }}>{{ $yr }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="co_researchers" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Co-Researchers</label>
                    <input type="text" id="co_researchers" name="co_researchers" value="{{ old('co_researchers') }}" placeholder="Separate with commas" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">
                </div>
                <div>
                    <label for="implementing_unit" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Implementing Unit</label>
                    <input type="text" id="implementing_unit" name="implementing_unit" value="{{ old('implementing_unit') }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">
                </div>
            </div>
            <div>
                <label for="abstract" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Abstract</label>
                <textarea id="abstract" name="abstract" rows="4" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">{{ old('abstract') }}</textarea>
            </div>
            <div>
                <label for="keywords" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Keywords</label>
                <input type="text" id="keywords" name="keywords" value="{{ old('keywords') }}" placeholder="Separate keywords with commas" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">
            </div>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-4">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Funding & Timeline</h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <label for="funding_source" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Funding Source</label>
                    <input type="text" id="funding_source" name="funding_source" value="{{ old('funding_source') }}" placeholder="e.g. DOST, CHED, Internal" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">
                </div>
                <div>
                    <label for="funding_amount" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Funding Amount (PHP)</label>
                    <input type="number" step="0.01" min="0" id="funding_amount" name="funding_amount" value="{{ old('funding_amount') }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">
                </div>
                <div>
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Status</label>
                    <select id="status" name="status" class="block w-full rounded-xl border border-slate-200 py-2.5 px-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 bg-white">
                        <option value="">Select status</option>
                        @foreach(['Proposed','Ongoing','Completed','Published','Discontinued'] as $s)
                            <option value="{{ $s }}" {{ old('status') === $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="start_date" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Start Date</label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">
                </div>
                <div>
                    <label for="end_date" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">End Date</label>
                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-4">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Publication Details</h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="output_type" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Output Type</label>
                    <select id="output_type" name="output_type" class="block w-full rounded-xl border border-slate-200 py-2.5 px-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 bg-white">
                        <option value="">Select output type</option>
                        @foreach(['Journal Article','Conference Paper','Book','Book Chapter','Patent','Policy Brief','Thesis/Dissertation'] as $o)
                            <option value="{{ $o }}" {{ old('output_type') === $o ? 'selected' : '' }}>{{ $o }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="indexed_in" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Indexed In</label>
                    <input type="text" id="indexed_in" name="indexed_in" value="{{ old('indexed_in') }}" placeholder="e.g. Scopus, ISI, CHED Journals" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">
                </div>
            </div>
            <div>
                <label for="publication_title" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Publication / Journal / Conference Title</label>
                <input type="text" id="publication_title" name="publication_title" value="{{ old('publication_title') }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <label for="isbn_issn" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">ISBN / ISSN</label>
                    <input type="text" id="isbn_issn" name="isbn_issn" value="{{ old('isbn_issn') }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 font-mono">
                </div>
                <div>
                    <label for="doi" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">DOI</label>
                    <input type="text" id="doi" name="doi" value="{{ old('doi') }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 font-mono">
                </div>
                <div>
                    <label for="citation_count" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Citation Count</label>
                    <input type="text" id="citation_count" name="citation_count" value="{{ old('citation_count') }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-4">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Audit</h3>
            <div>
                <label for="remarks" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Remarks</label>
                <textarea id="remarks" name="remarks" rows="2" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">{{ old('remarks') }}</textarea>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="item_author" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Item Author</label>
                    <input type="text" id="item_author" name="item_author" value="{{ old('item_author') }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">
                </div>
                <div>
                    <label for="date" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Record Date</label>
                    <input type="date" id="date" name="date" value="{{ old('date') }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('research.index') }}" class="px-5 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">Cancel</a>
            <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-sky-500 hover:bg-sky-600 rounded-xl shadow-sm transition-all">Save Project</button>
        </div>
    </form>
</div>
@endsection
