@extends('layouts.app')

@section('title', 'Accreditations')
@section('page_title', 'Accreditations')
@section('header_action')
    <a href="{{ route('accreditations.create') }}" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold text-white bg-[#9b1c1c] hover:bg-[#7f1d1d] rounded-lg shadow-sm transition-all">
        <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Add Record
    </a>
@endsection

@section('content')
<div class="space-y-6">

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="relative overflow-hidden rounded-2xl bg-white border border-slate-200/60 shadow-sm p-5 hover:shadow-md transition-all">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Records</p>
            <h3 class="text-3xl font-extrabold text-slate-900 mt-1">{{ $stats['total'] }}</h3>
            <div class="absolute bottom-0 inset-x-0 h-1 bg-gradient-to-r from-violet-500 to-purple-500"></div>
        </div>
        <div class="relative overflow-hidden rounded-2xl bg-white border border-slate-200/60 shadow-sm p-5 hover:shadow-md transition-all">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Active</p>
            <h3 class="text-3xl font-extrabold text-emerald-600 mt-1">{{ $stats['active'] }}</h3>
            <div class="absolute bottom-0 inset-x-0 h-1 bg-gradient-to-r from-emerald-400 to-green-500"></div>
        </div>
        <div class="relative overflow-hidden rounded-2xl bg-white border border-slate-200/60 shadow-sm p-5 hover:shadow-md transition-all">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Pending</p>
            <h3 class="text-3xl font-extrabold text-amber-600 mt-1">{{ $stats['pending'] }}</h3>
            <div class="absolute bottom-0 inset-x-0 h-1 bg-gradient-to-r from-amber-400 to-orange-500"></div>
        </div>
        <div class="relative overflow-hidden rounded-2xl bg-white border border-slate-200/60 shadow-sm p-5 hover:shadow-md transition-all">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Expired</p>
            <h3 class="text-3xl font-extrabold text-red-600 mt-1">{{ $stats['expired'] }}</h3>
            <div class="absolute bottom-0 inset-x-0 h-1 bg-gradient-to-r from-red-400 to-rose-500"></div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-5">
        <form action="{{ route('accreditations.index') }}" method="GET" class="flex flex-col gap-4 lg:flex-row lg:items-end">
            <div class="flex-grow">
                <label for="search" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Search</label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Program, accrediting body, department..."
                           class="block w-full rounded-xl border border-slate-200 py-2.5 pl-9 pr-3 text-sm placeholder-slate-400 focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500">
                </div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div>
                    <label for="level" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Level</label>
                    <select name="level" id="level" class="block w-full rounded-xl border border-slate-200 py-2.5 px-3 text-sm focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500 bg-white">
                        <option value="">All Levels</option>
                        @foreach(['Program','Institutional','Department'] as $l)
                            <option value="{{ $l }}" {{ request('level') === $l ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="status" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Status</label>
                    <select name="status" id="status" class="block w-full rounded-xl border border-slate-200 py-2.5 px-3 text-sm focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500 bg-white">
                        <option value="">All Statuses</option>
                        @foreach(['Active','Pending','Expired','Under Surveillance','Withdrawn'] as $s)
                            <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="accrediting_body" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Body</label>
                    <select name="accrediting_body" id="accrediting_body" class="block w-full rounded-xl border border-slate-200 py-2.5 px-3 text-sm focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500 bg-white">
                        <option value="">All Bodies</option>
                        @foreach($accreditingBodies as $body)
                            <option value="{{ $body }}" {{ request('accrediting_body') === $body ? 'selected' : '' }}>{{ $body }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="academic_year" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Year</label>
                    <select name="academic_year" id="academic_year" class="block w-full rounded-xl border border-slate-200 py-2.5 px-3 text-sm focus:border-violet-500 focus:outline-none focus:ring-1 focus:ring-violet-500 bg-white">
                        <option value="">All Years</option>
                        @foreach($academicYears as $yr)
                            <option value="{{ $yr }}" {{ request('academic_year') === $yr ? 'selected' : '' }}>{{ $yr }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <button type="submit" class="px-4 py-2.5 text-sm font-semibold text-white bg-violet-600 hover:bg-violet-700 rounded-xl transition-all shadow-sm">Filter</button>
                @if(request()->hasAny(['search','level','status','accrediting_body','academic_year']))
                    <a href="{{ route('accreditations.index') }}" class="px-4 py-2.5 text-sm font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">Reset</a>
                @endif
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl bg-white border border-slate-200/60 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50/75">
                    <tr>
                        <th class="py-3.5 pl-6 pr-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Program / Dept.</th>
                        <th class="px-3 py-3.5 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Level</th>
                        <th class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Accrediting Body</th>
                        <th class="px-3 py-3.5 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Acc. Level</th>
                        <th class="px-3 py-3.5 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Validity</th>
                        <th class="px-3 py-3.5 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                        <th class="py-3.5 pl-3 pr-6 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($accreditations as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 pl-6 pr-3 text-sm">
                            <div class="font-bold text-slate-900 hover:text-violet-600 transition-colors">
                                <a href="{{ route('accreditations.show', $item->id) }}">{{ $item->program_name }}</a>
                            </div>
                            @if($item->college_department)
                                <div class="text-xs text-slate-400 mt-0.5">{{ $item->college_department }}</div>
                            @endif
                        </td>
                        <td class="px-3 py-4 text-center text-sm">
                            @php $lc = ['Program'=>'violet','Institutional'=>'indigo','Department'=>'purple'][$item->level] ?? 'slate'; @endphp
                            <span class="inline-flex items-center rounded-lg bg-{{ $lc }}-50 px-2.5 py-1 text-xs font-semibold text-{{ $lc }}-700 border border-{{ $lc }}-200/60">{{ $item->level }}</span>
                        </td>
                        <td class="px-3 py-4 text-sm text-slate-700 font-medium">{{ $item->accrediting_body }}</td>
                        <td class="px-3 py-4 text-center text-sm font-bold text-slate-800">{{ $item->accreditation_level ?? '—' }}</td>
                        <td class="px-3 py-4 text-center text-xs text-slate-600">
                            @if($item->validity_start && $item->validity_end)
                                <div class="font-medium">{{ $item->validity_start->format('M Y') }} – {{ $item->validity_end->format('M Y') }}</div>
                            @else <span class="text-slate-400">—</span> @endif
                        </td>
                        <td class="px-3 py-4 text-center text-sm">
                            @php $sc = ['Active'=>'emerald','Pending'=>'amber','Expired'=>'red','Under Surveillance'=>'sky','Withdrawn'=>'slate'][$item->status] ?? 'slate'; @endphp
                            @if($item->status)
                                <span class="inline-flex items-center rounded-md bg-{{ $sc }}-50 px-2 py-0.5 text-xs font-semibold text-{{ $sc }}-700 border border-{{ $sc }}-200/50">{{ $item->status }}</span>
                            @else <span class="text-slate-400 text-xs">—</span> @endif
                        </td>
                        <td class="py-4 pl-3 pr-6 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('accreditations.show', $item->id) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:text-violet-600 hover:border-violet-300 shadow-sm transition-colors">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('accreditations.edit', $item->id) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:text-violet-600 hover:border-violet-300 shadow-sm transition-colors">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-5-9l4 4L9 21H5v-4l9.364-9.364z"/></svg>
                                </a>
                                <form action="{{ route('accreditations.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this accreditation record?')" class="inline-block">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-red-100 bg-white text-red-400 hover:text-white hover:bg-red-500 hover:border-red-500 shadow-sm transition-all">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="py-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="h-12 w-12 rounded-xl bg-violet-50 text-violet-400 flex items-center justify-center mb-3">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h3 class="text-sm font-semibold text-slate-700">No accreditation records found</h3>
                            <a href="{{ route('accreditations.create') }}" class="mt-3 text-violet-600 hover:text-violet-800 text-xs font-semibold underline">Add First Record</a>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($accreditations->hasPages())
            <div class="bg-slate-50 px-6 py-4 border-t border-slate-200">{{ $accreditations->links() }}</div>
        @endif
    </div>

</div>
@endsection
