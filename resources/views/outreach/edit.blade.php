@extends('layouts.app')

@section('title', 'Edit — ' . $outreach->program_name)
@section('page_title', 'Outreach Programs — Edit')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <nav class="flex text-xs font-semibold text-slate-500 space-x-2">
        <a href="{{ route('outreach.index') }}" class="hover:text-teal-600">Outreach Programs</a>
        <span>/</span>
        <a href="{{ route('outreach.show', $outreach->id) }}" class="hover:text-teal-600">{{ Str::limit($outreach->program_name, 40) }}</a>
        <span>/</span><span class="text-slate-900">Edit</span>
    </nav>
    <form action="{{ route('outreach.update', $outreach->id) }}" method="POST" class="space-y-5">
        @csrf @method('PUT')
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-5">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Program Information</h3>
            <div>
                <label for="program_name" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Program Name <span class="text-red-500">*</span></label>
                <input type="text" id="program_name" name="program_name" value="{{ old('program_name', $outreach->program_name) }}" required class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <label for="program_type" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Type <span class="text-red-500">*</span></label>
                    <select id="program_type" name="program_type" required class="block w-full rounded-xl border border-slate-200 py-2.5 px-3 text-sm focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500 bg-white">
                        @foreach(['Community','Extension','Partnership','Livelihood','Health','Education'] as $t)
                            <option value="{{ $t }}" {{ old('program_type', $outreach->program_type) === $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="implementing_unit" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Implementing Unit <span class="text-red-500">*</span></label>
                    <input type="text" id="implementing_unit" name="implementing_unit" value="{{ old('implementing_unit', $outreach->implementing_unit) }}" required class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
                </div>
                <div>
                    <label for="academic_year" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Academic Year <span class="text-red-500">*</span></label>
                    <select id="academic_year" name="academic_year" required class="block w-full rounded-xl border border-slate-200 py-2.5 px-3 text-sm focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500 bg-white">
                        @foreach($yearRanges as $yr)
                            <option value="{{ $yr }}" {{ old('academic_year', $outreach->academic_year) === $yr ? 'selected' : '' }}>{{ $yr }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="target_community" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Target Community</label>
                    <input type="text" id="target_community" name="target_community" value="{{ old('target_community', $outreach->target_community) }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
                </div>
                <div>
                    <label for="location" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Location</label>
                    <input type="text" id="location" name="location" value="{{ old('location', $outreach->location) }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
                </div>
            </div>
            <div>
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Description</label>
                <textarea id="description" name="description" rows="3" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">{{ old('description', $outreach->description) }}</textarea>
            </div>
        </div>
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-4">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Details & Timeline</h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <label for="beneficiaries_count" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Beneficiaries Count</label>
                    <input type="number" min="0" id="beneficiaries_count" name="beneficiaries_count" value="{{ old('beneficiaries_count', $outreach->beneficiaries_count) }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
                </div>
                <div>
                    <label for="start_date" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Start Date</label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $outreach->start_date?->format('Y-m-d')) }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
                </div>
                <div>
                    <label for="end_date" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">End Date</label>
                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $outreach->end_date?->format('Y-m-d')) }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Status</label>
                    <select id="status" name="status" class="block w-full rounded-xl border border-slate-200 py-2.5 px-3 text-sm focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500 bg-white">
                        <option value="">Select status</option>
                        @foreach(['Planned','Ongoing','Completed','Cancelled'] as $s)
                            <option value="{{ $s }}" {{ old('status', $outreach->status) === $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="program_coordinator" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Program Coordinator</label>
                    <input type="text" id="program_coordinator" name="program_coordinator" value="{{ old('program_coordinator', $outreach->program_coordinator) }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
                </div>
            </div>
            <div>
                <label for="partner_agencies" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Partner Agencies</label>
                <input type="text" id="partner_agencies" name="partner_agencies" value="{{ old('partner_agencies', $outreach->partner_agencies) }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
            </div>
        </div>
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-4">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Outcomes & Audit</h3>
            <div>
                <label for="outcomes" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Outcomes</label>
                <textarea id="outcomes" name="outcomes" rows="3" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">{{ old('outcomes', $outreach->outcomes) }}</textarea>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="challenges" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Challenges</label>
                    <textarea id="challenges" name="challenges" rows="2" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">{{ old('challenges', $outreach->challenges) }}</textarea>
                </div>
                <div>
                    <label for="recommendations" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Recommendations</label>
                    <textarea id="recommendations" name="recommendations" rows="2" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">{{ old('recommendations', $outreach->recommendations) }}</textarea>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="item_author" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Item Author</label>
                    <input type="text" id="item_author" name="item_author" value="{{ old('item_author', $outreach->item_author) }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
                </div>
                <div>
                    <label for="date" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Record Date</label>
                    <input type="date" id="date" name="date" value="{{ old('date', $outreach->date?->format('Y-m-d')) }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
                </div>
            </div>
        </div>
        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('outreach.show', $outreach->id) }}" class="px-5 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">Cancel</a>
            <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-teal-500 hover:bg-teal-600 rounded-xl shadow-sm transition-all">Update Program</button>
        </div>
    </form>
</div>
@endsection
