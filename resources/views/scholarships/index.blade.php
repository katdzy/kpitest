@extends('layouts.app')

@section('title', 'Scholarships & Grants')
@section('page_title', 'Scholarships & Grants')
@section('header_action')
    <a href="{{ route('scholarships.create') }}" class="btn-primary text-white gap-1.5" style="background:#9b1c1c;">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Add Record
    </a>
@endsection

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4 animate-fade-up">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Scholarships &amp; Grants</h1>
            <p class="text-sm text-slate-500 mt-1">Track institutional scholarships, grants, and student financial awards.</p>
        </div>
        <a href="{{ route('scholarships.create') }}" class="btn-primary text-white gap-1.5" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Add New Record
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 animate-fade-up animate-fade-up-1">
        <div class="stat-card p-5 group">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Records</p>
                <div class="flex h-7 w-7 rounded-lg bg-amber-50 text-amber-500 items-center justify-center">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347"/></svg>
                </div>
            </div>
            <h3 class="stat-number text-3xl font-extrabold text-slate-900">{{ $stats['total'] }}</h3>
            <div class="absolute bottom-0 inset-x-0 h-0.5 bg-gradient-to-r from-amber-400 to-orange-500 group-hover:h-1 transition-all"></div>
        </div>
        <div class="stat-card p-5 group">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Active</p>
                <div class="flex h-7 w-7 rounded-lg bg-emerald-50 text-emerald-500 items-center justify-center">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                </div>
            </div>
            <h3 class="stat-number text-3xl font-extrabold text-emerald-600">{{ $stats['active'] }}</h3>
            <div class="absolute bottom-0 inset-x-0 h-0.5 bg-gradient-to-r from-emerald-400 to-teal-500 group-hover:h-1 transition-all"></div>
        </div>
        <div class="stat-card p-5 group">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Completed</p>
                <div class="flex h-7 w-7 rounded-lg bg-slate-100 text-slate-500 items-center justify-center">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5"/></svg>
                </div>
            </div>
            <h3 class="stat-number text-3xl font-extrabold text-slate-700">{{ $stats['completed'] }}</h3>
            <div class="absolute bottom-0 inset-x-0 h-0.5 bg-gradient-to-r from-slate-400 to-slate-500 group-hover:h-1 transition-all"></div>
        </div>
        <div class="stat-card p-5 group">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Beneficiaries</p>
                <div class="flex h-7 w-7 rounded-lg bg-amber-50 text-amber-500 items-center justify-center">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0"/></svg>
                </div>
            </div>
            <h3 class="stat-number text-3xl font-extrabold text-amber-600">{{ number_format($stats['beneficiaries']) }}</h3>
            <div class="absolute bottom-0 inset-x-0 h-0.5 bg-gradient-to-r from-amber-400 to-yellow-400 group-hover:h-1 transition-all"></div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm overflow-hidden animate-fade-up animate-fade-up-2">
        <div class="px-5 py-3.5 border-b border-slate-100 flex items-center gap-2">
            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"/></svg>
            <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider">Filters</h3>
            @if(request()->hasAny(['search','type','status','academic_year','sort']))
                <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded-full bg-amber-50 border border-amber-200/60 text-[10px] font-bold text-amber-600">Filters Active</span>
            @endif
        </div>
        <div class="p-5">
        <form action="{{ route('scholarships.index') }}" method="GET" class="flex flex-col gap-4 lg:flex-row lg:items-end">
            <div class="flex-grow">
                <label for="search" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Search</label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Title, funding source, unit..."
                           class="form-input amber pl-9">
                </div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div>
                    <label for="type" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Type</label>
                    <select name="type" id="type" class="form-input amber">
                        <option value="">All Types</option>
                        @foreach(['Scholarship','Grant','Fellowship','Assistantship'] as $t)
                            <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="status" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Status</label>
                    <select name="status" id="status" class="form-input amber">
                        <option value="">All Statuses</option>
                        @foreach(['Active','Completed','Pending','Suspended'] as $s)
                            <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="academic_year" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Year</label>
                    <select name="academic_year" id="academic_year" class="form-input amber">
                        <option value="">All Years</option>
                        @foreach($academicYears as $yr)
                            <option value="{{ $yr }}" {{ request('academic_year') === $yr ? 'selected' : '' }}>{{ $yr }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="sort" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Sort By</label>
                    <select name="sort" id="sort" class="form-input amber">
                        <option value="default" {{ $sort === 'default' ? 'selected' : '' }}>Title A–Z</option>
                        <option value="amount_desc" {{ $sort === 'amount_desc' ? 'selected' : '' }}>Amount (High–Low)</option>
                        <option value="amount_asc" {{ $sort === 'amount_asc' ? 'selected' : '' }}>Amount (Low–High)</option>
                        <option value="year" {{ $sort === 'year' ? 'selected' : '' }}>Year (Newest)</option>
                        <option value="beneficiaries" {{ $sort === 'beneficiaries' ? 'selected' : '' }}>Beneficiaries (Most)</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="btn-primary text-white gap-1.5" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Filter
                </button>
                @if(request()->hasAny(['search','type','status','academic_year','sort']))
                    <a href="{{ route('scholarships.index') }}" class="btn-secondary text-slate-600 hover:bg-slate-50">Reset</a>
                @endif
            </div>
        </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl bg-white border border-slate-200/60 shadow-sm animate-fade-up animate-fade-up-3">
        {{-- Table header bar --}}
        <div class="px-6 py-3.5 border-b border-slate-100 flex items-center justify-between">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                @if($scholarships->total() > 0)
                    Showing {{ $scholarships->firstItem() }}–{{ $scholarships->lastItem() }} of {{ number_format($scholarships->total()) }} records
                @else
                    Scholarship Records
                @endif
            </span>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-200/60">
                {{ number_format($scholarships->total()) }} total
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50/75">
                    <tr>
                        <th class="py-3.5 pl-6 pr-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Title</th>
                        <th class="px-3 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-slate-500">Type</th>
                        <th class="px-3 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-slate-500">Year</th>
                        <th class="px-3 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Funding Source</th>
                        <th class="px-3 py-3.5 text-right text-xs font-bold uppercase tracking-wider text-slate-500">Amount</th>
                        <th class="px-3 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-slate-500">Beneficiaries</th>
                        <th class="px-3 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-slate-500">Status</th>
                        <th class="py-3.5 pl-3 pr-6 text-right text-xs font-bold uppercase tracking-wider text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($scholarships as $item)
                    <tr class="table-row-accent accent-amber group">
                        <td class="py-4 pl-6 pr-3 text-sm">
                            <div class="font-bold text-slate-900">
                                <a href="{{ route('scholarships.show', $item->id) }}" class="hover:text-amber-600 transition-colors">{{ $item->title }}</a>
                            </div>
                            @if($item->administering_unit)
                                <div class="text-xs text-slate-400 mt-0.5 flex items-center gap-1">
                                    <svg class="w-3 h-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18"/></svg>
                                    {{ $item->administering_unit }}
                                </div>
                            @endif
                        </td>
                        <td class="px-3 py-4 text-center text-sm">
                            @php
                                $typeColors = ['Scholarship'=>'amber','Grant'=>'blue','Fellowship'=>'purple','Assistantship'=>'teal'];
                                $tc = $typeColors[$item->type] ?? 'slate';
                            @endphp
                            <span class="badge bg-{{ $tc }}-50 text-{{ $tc }}-700 border-{{ $tc }}-200/60">{{ $item->type }}</span>
                        </td>
                        <td class="px-3 py-4 text-center">
                            <span class="inline-flex items-center px-2 py-1 rounded-md bg-slate-50 border border-slate-200/70 text-xs font-bold text-slate-700 font-mono">{{ $item->academic_year }}</span>
                        </td>
                        <td class="px-3 py-4 text-sm text-slate-600 max-w-xs truncate">{{ $item->funding_source ?? '—' }}</td>
                        <td class="px-3 py-4 text-right text-sm font-bold text-slate-800">
                            @if($item->amount)
                                {{ $item->currency ?? 'PHP' }} {{ number_format($item->amount, 2) }}
                            @else
                                <span class="text-slate-300 font-normal text-xs">N/A</span>
                            @endif
                        </td>
                        <td class="px-3 py-4 text-center text-sm font-semibold text-slate-700">
                            {{ $item->beneficiaries_count ? number_format($item->beneficiaries_count) : '—' }}
                        </td>
                        <td class="px-3 py-4 text-center text-sm">
                            @php
                                $sc = ['Active'=>'emerald','Completed'=>'slate','Pending'=>'amber','Suspended'=>'red'][$item->status] ?? 'slate';
                            @endphp
                            @if($item->status)
                                <span class="badge bg-{{ $sc }}-50 text-{{ $sc }}-700 border-{{ $sc }}-200/50">{{ $item->status }}</span>
                            @else
                                <span class="text-slate-300 text-xs">—</span>
                            @endif
                        </td>
                        <td class="py-4 pl-3 pr-6 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('scholarships.show', $item->id) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:text-amber-600 hover:border-amber-300 hover:bg-amber-50 shadow-sm transition-all" title="View">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('scholarships.edit', $item->id) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:text-amber-600 hover:border-amber-300 hover:bg-amber-50 shadow-sm transition-all" title="Edit">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-5-9l4 4L9 21H5v-4l9.364-9.364z"/></svg>
                                </a>
                                <form action="{{ route('scholarships.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete \'{{ $item->title }}\' ? This cannot be undone.')" class="inline-block">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-red-100 bg-white text-red-400 hover:text-white hover:bg-red-500 hover:border-red-500 shadow-sm transition-all" title="Delete">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-16 text-center">
                            <div class="flex flex-col items-center max-w-sm mx-auto">
                                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-50 text-amber-300 mb-4 shadow-sm">
                                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347"/></svg>
                                </div>
                                <h3 class="text-base font-bold text-slate-800">No scholarships or grants found</h3>
                                <p class="text-sm text-slate-400 mt-1.5 leading-relaxed">Try clearing the filters or add a new record to get started.</p>
                                <div class="flex items-center gap-3 mt-5">
                                    <a href="{{ route('scholarships.index') }}" class="btn-secondary text-slate-600 hover:bg-slate-50 text-sm">Clear Filters</a>
                                    <a href="{{ route('scholarships.create') }}" class="btn-primary text-white text-sm gap-1.5" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                        Add First Record
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($scholarships->hasPages())
            <div class="bg-slate-50 px-6 py-4 border-t border-slate-200">{{ $scholarships->links() }}</div>
        @endif
    </div>

</div>
@endsection
