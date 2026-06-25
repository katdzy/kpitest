@extends('layouts.app')

@section('title', 'Edit — ' . $scholarship->title)
@section('page_title', 'Scholarships & Grants — Edit')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <nav class="flex text-xs font-semibold text-slate-500 space-x-2">
        <a href="{{ route('scholarships.index') }}" class="hover:text-amber-600">Scholarships & Grants</a>
        <span>/</span>
        <a href="{{ route('scholarships.show', $scholarship->id) }}" class="hover:text-amber-600">{{ Str::limit($scholarship->title, 40) }}</a>
        <span>/</span><span class="text-slate-900">Edit</span>
    </nav>

    <form action="{{ route('scholarships.update', $scholarship->id) }}" method="POST" class="space-y-5">
        @csrf @method('PUT')

        {{-- Basic Info --}}
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-5">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Basic Information</h3>
            <div>
                <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Title <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $scholarship->title) }}" required
                       class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 @error('title') border-red-300 @enderror">
                @error('title')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <label for="type" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Type <span class="text-red-500">*</span></label>
                    <select id="type" name="type" required class="block w-full rounded-xl border border-slate-200 py-2.5 px-3 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 bg-white">
                        @foreach(['Scholarship','Grant','Fellowship','Assistantship'] as $t)
                            <option value="{{ $t }}" {{ old('type', $scholarship->type) === $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="beneficiary_type" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Beneficiary Type <span class="text-red-500">*</span></label>
                    <select id="beneficiary_type" name="beneficiary_type" required class="block w-full rounded-xl border border-slate-200 py-2.5 px-3 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 bg-white">
                        @foreach(['Student','Faculty','Staff','Both'] as $bt)
                            <option value="{{ $bt }}" {{ old('beneficiary_type', $scholarship->beneficiary_type) === $bt ? 'selected' : '' }}>{{ $bt }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="academic_year" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Academic Year <span class="text-red-500">*</span></label>
                    <select id="academic_year" name="academic_year" required class="block w-full rounded-xl border border-slate-200 py-2.5 px-3 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 bg-white">
                        @foreach($yearRanges as $yr)
                            <option value="{{ $yr }}" {{ old('academic_year', $scholarship->academic_year) === $yr ? 'selected' : '' }}>{{ $yr }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="administering_unit" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Administering Unit</label>
                    <input type="text" id="administering_unit" name="administering_unit" value="{{ old('administering_unit', $scholarship->administering_unit) }}"
                           class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">
                </div>
                <div>
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Status</label>
                    <select id="status" name="status" class="block w-full rounded-xl border border-slate-200 py-2.5 px-3 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 bg-white">
                        <option value="">Select status</option>
                        @foreach(['Active','Pending','Completed','Suspended'] as $s)
                            <option value="{{ $s }}" {{ old('status', $scholarship->status) === $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Description</label>
                <textarea id="description" name="description" rows="3"
                          class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">{{ old('description', $scholarship->description) }}</textarea>
            </div>
        </div>

        {{-- Funding --}}
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-4">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Funding Details</h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <label for="funding_source" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Funding Source</label>
                    <input type="text" id="funding_source" name="funding_source" value="{{ old('funding_source', $scholarship->funding_source) }}"
                           class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">
                </div>
                <div>
                    <label for="amount" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Amount</label>
                    <input type="number" step="0.01" min="0" id="amount" name="amount" value="{{ old('amount', $scholarship->amount) }}"
                           class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">
                </div>
                <div>
                    <label for="currency" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Currency</label>
                    <select id="currency" name="currency" class="block w-full rounded-xl border border-slate-200 py-2.5 px-3 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 bg-white">
                        @foreach(['PHP','USD','EUR'] as $c)
                            <option value="{{ $c }}" {{ old('currency', $scholarship->currency ?? 'PHP') === $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <label for="beneficiaries_count" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">No. of Beneficiaries</label>
                    <input type="number" min="0" id="beneficiaries_count" name="beneficiaries_count" value="{{ old('beneficiaries_count', $scholarship->beneficiaries_count) }}"
                           class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">
                </div>
                <div>
                    <label for="start_date" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Start Date</label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $scholarship->start_date?->format('Y-m-d')) }}"
                           class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">
                </div>
                <div>
                    <label for="end_date" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">End Date</label>
                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $scholarship->end_date?->format('Y-m-d')) }}"
                           class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">
                </div>
            </div>
            <div>
                <label for="selection_criteria" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Selection Criteria</label>
                <input type="text" id="selection_criteria" name="selection_criteria" value="{{ old('selection_criteria', $scholarship->selection_criteria) }}"
                       class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">
            </div>
        </div>

        {{-- Outcomes & Meta --}}
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-4">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Outcomes & Audit</h3>
            <div>
                <label for="outcomes" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Outcomes</label>
                <textarea id="outcomes" name="outcomes" rows="3" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">{{ old('outcomes', $scholarship->outcomes) }}</textarea>
            </div>
            <div>
                <label for="remarks" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Remarks</label>
                <textarea id="remarks" name="remarks" rows="2" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">{{ old('remarks', $scholarship->remarks) }}</textarea>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="item_author" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Item Author</label>
                    <input type="text" id="item_author" name="item_author" value="{{ old('item_author', $scholarship->item_author) }}"
                           class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">
                </div>
                <div>
                    <label for="date" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Record Date</label>
                    <input type="date" id="date" name="date" value="{{ old('date', $scholarship->date?->format('Y-m-d')) }}"
                           class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('scholarships.show', $scholarship->id) }}" class="px-5 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">Cancel</a>
            <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-amber-500 hover:bg-amber-600 rounded-xl shadow-sm transition-all">Update Record</button>
        </div>
    </form>
</div>
@endsection
