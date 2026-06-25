@extends('layouts.app')

@section('title', 'Edit — ' . $accreditation->program_name)
@section('page_title', 'Accreditations — Edit')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <nav class="flex text-xs font-semibold text-slate-500 space-x-2">
        <a href="{{ route('accreditations.index') }}" class="hover:text-violet-600">Accreditations</a>
        <span>/</span>
        <a href="{{ route('accreditations.show', $accreditation->id) }}" class="hover:text-violet-600">{{ Str::limit($accreditation->program_name, 40) }}</a>
        <span>/</span><span class="text-slate-900">Edit</span>
    </nav>
    <form action="{{ route('accreditations.update', $accreditation->id) }}" method="POST" class="space-y-5">
        @csrf @method('PUT')
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-5">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Program & Accrediting Body</h3>
            <div>
                <label for="program_name" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Program / Institutional Name <span class="text-red-500">*</span></label>
                <input type="text" id="program_name" name="program_name" value="{{ old('program_name', $accreditation->program_name) }}" required class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500">
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <label for="level" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Level <span class="text-red-500">*</span></label>
                    <select id="level" name="level" required class="block w-full rounded-xl border border-slate-200 py-2.5 px-3 text-sm focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500 bg-white">
                        @foreach(['Program','Institutional','Department'] as $l)
                            <option value="{{ $l }}" {{ old('level', $accreditation->level) === $l ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="accrediting_body" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Accrediting Body <span class="text-red-500">*</span></label>
                    <input type="text" id="accrediting_body" name="accrediting_body" value="{{ old('accrediting_body', $accreditation->accrediting_body) }}" required class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500">
                </div>
                <div>
                    <label for="academic_year" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Academic Year <span class="text-red-500">*</span></label>
                    <select id="academic_year" name="academic_year" required class="block w-full rounded-xl border border-slate-200 py-2.5 px-3 text-sm focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500 bg-white">
                        @foreach($yearRanges as $yr)
                            <option value="{{ $yr }}" {{ old('academic_year', $accreditation->academic_year) === $yr ? 'selected' : '' }}>{{ $yr }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="college_department" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">College / Department</label>
                    <input type="text" id="college_department" name="college_department" value="{{ old('college_department', $accreditation->college_department) }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500">
                </div>
                <div>
                    <label for="accreditation_level" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Accreditation Level</label>
                    <input type="text" id="accreditation_level" name="accreditation_level" value="{{ old('accreditation_level', $accreditation->accreditation_level) }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500">
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-4">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Validity & Survey Schedule</h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Status</label>
                    <select id="status" name="status" class="block w-full rounded-xl border border-slate-200 py-2.5 px-3 text-sm focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500 bg-white">
                        <option value="">Select status</option>
                        @foreach(['Active','Pending','Expired','Under Surveillance','Withdrawn'] as $s)
                            <option value="{{ $s }}" {{ old('status', $accreditation->status) === $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="validity_start" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Validity Start</label>
                    <input type="date" id="validity_start" name="validity_start" value="{{ old('validity_start', $accreditation->validity_start?->format('Y-m-d')) }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500">
                </div>
                <div>
                    <label for="validity_end" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Validity End</label>
                    <input type="date" id="validity_end" name="validity_end" value="{{ old('validity_end', $accreditation->validity_end?->format('Y-m-d')) }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500">
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <label for="last_survey_date" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Last Survey Date</label>
                    <input type="date" id="last_survey_date" name="last_survey_date" value="{{ old('last_survey_date', $accreditation->last_survey_date?->format('Y-m-d')) }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500">
                </div>
                <div>
                    <label for="next_survey_date" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Next Survey Date</label>
                    <input type="date" id="next_survey_date" name="next_survey_date" value="{{ old('next_survey_date', $accreditation->next_survey_date?->format('Y-m-d')) }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500">
                </div>
                <div>
                    <label for="survey_visit_count" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">No. of Survey Visits</label>
                    <input type="number" min="0" id="survey_visit_count" name="survey_visit_count" value="{{ old('survey_visit_count', $accreditation->survey_visit_count) }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500">
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="certifying_officer" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Certifying Officer</label>
                    <input type="text" id="certifying_officer" name="certifying_officer" value="{{ old('certifying_officer', $accreditation->certifying_officer) }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500">
                </div>
                <div>
                    <label for="focal_person" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Focal Person</label>
                    <input type="text" id="focal_person" name="focal_person" value="{{ old('focal_person', $accreditation->focal_person) }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500">
                </div>
            </div>
            <div>
                <label for="conditions" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Conditions</label>
                <textarea id="conditions" name="conditions" rows="2" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500">{{ old('conditions', $accreditation->conditions) }}</textarea>
            </div>
            <div>
                <label for="remarks" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Remarks</label>
                <textarea id="remarks" name="remarks" rows="2" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500">{{ old('remarks', $accreditation->remarks) }}</textarea>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="item_author" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Item Author</label>
                    <input type="text" id="item_author" name="item_author" value="{{ old('item_author', $accreditation->item_author) }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500">
                </div>
                <div>
                    <label for="date" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Record Date</label>
                    <input type="date" id="date" name="date" value="{{ old('date', $accreditation->date?->format('Y-m-d')) }}" class="block w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500">
                </div>
            </div>
        </div>
        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('accreditations.show', $accreditation->id) }}" class="px-5 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">Cancel</a>
            <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-violet-600 hover:bg-violet-700 rounded-xl shadow-sm transition-all">Update Record</button>
        </div>
    </form>
</div>
@endsection
