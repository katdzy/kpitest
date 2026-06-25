@extends('layouts.app')

@section('title', 'Departments')
@section('page_title', 'Departments')
@section('header_action')
    <a href="{{ route('departments.create') }}" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold text-white bg-[#9b1c1c] hover:bg-[#7f1d1d] rounded-lg shadow-sm transition-all">
        <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Add Department
    </a>
@endsection

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Departments</h1>
            <p class="text-sm text-slate-500 mt-1">Manage university departments and their KPI ownership roles.</p>
        </div>
        <a href="{{ route('departments.create') }}" class="inline-flex items-center px-4 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm transition-all">
            <svg class="w-5 h-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Add Department
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-slate-200/60">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Departments</p>
            <h3 class="text-3xl font-extrabold text-slate-900 mt-1.5">{{ $stats['total'] }}</h3>
            <div class="absolute bottom-0 inset-x-0 h-1 bg-gradient-to-r from-indigo-500 to-violet-500"></div>
        </div>
        <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-slate-200/60">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Active</p>
            <h3 class="text-3xl font-extrabold text-emerald-600 mt-1.5">{{ $stats['active'] }}</h3>
            <div class="absolute bottom-0 inset-x-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-500"></div>
        </div>
        <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-slate-200/60">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Inactive</p>
            <h3 class="text-3xl font-extrabold text-slate-400 mt-1.5">{{ $stats['inactive'] }}</h3>
            <div class="absolute bottom-0 inset-x-0 h-1 bg-gradient-to-r from-slate-300 to-slate-400"></div>
        </div>
    </div>

    {{-- Search --}}
    <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-5">
        <form action="{{ route('departments.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-grow">
                <label for="search" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Search Departments</label>
                <div class="relative rounded-xl shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           placeholder="Search by name, code, or college..."
                           class="block w-full rounded-xl border border-slate-200 py-2.5 pl-10 pr-3 text-sm placeholder-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                </div>
            </div>
            <div class="flex items-end space-x-2.5">
                <button type="submit" class="px-4 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-all shadow-sm">
                    Search
                </button>
                @if(request()->filled('search') || request()->filled('active'))
                    <a href="{{ route('departments.index') }}" class="px-4 py-2.5 text-sm font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Departments Table --}}
    <div class="overflow-hidden rounded-2xl bg-white border border-slate-200/60 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50/75">
                    <tr>
                        <th class="py-3.5 pl-6 pr-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Department</th>
                        <th class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Code</th>
                        <th class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">College / Division</th>
                        <th class="px-3 py-3.5 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">KPIs</th>
                        <th class="px-3 py-3.5 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                        <th class="py-3.5 pl-3 pr-6 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($departments as $dept)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 pl-6 pr-3 text-sm">
                                <a href="{{ route('departments.show', $dept->id) }}" class="font-bold text-slate-900 hover:text-indigo-600 transition-colors">
                                    {{ $dept->name }}
                                </a>
                                @if($dept->description)
                                    <p class="text-xs text-slate-400 mt-0.5 truncate max-w-xs">{{ Str::limit($dept->description, 70) }}</p>
                                @endif
                            </td>
                            <td class="px-3 py-4 text-sm">
                                <span class="font-mono font-bold text-slate-700 bg-slate-100 px-2 py-1 rounded-md text-xs border border-slate-200/50">{{ $dept->code }}</span>
                            </td>
                            <td class="px-3 py-4 text-sm text-slate-600">{{ $dept->college ?? '—' }}</td>
                            <td class="px-3 py-4 text-center text-sm font-bold text-slate-800">{{ $dept->kpis_count ?? $dept->kpis()->count() }}</td>
                            <td class="px-3 py-4 text-center text-sm">
                                @if($dept->is_active)
                                    <span class="inline-flex items-center rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 border border-emerald-200/60">Active</span>
                                @else
                                    <span class="inline-flex items-center rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500 border border-slate-200">Inactive</span>
                                @endif
                            </td>
                            <td class="py-4 pl-3 pr-6 text-right">
                                <div class="flex items-center justify-end space-x-2.5">
                                    <a href="{{ route('departments.show', $dept->id) }}"
                                       class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 hover:text-indigo-600 hover:border-indigo-300 shadow-sm transition-colors" title="View">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </a>
                                    <a href="{{ route('departments.edit', $dept->id) }}"
                                       class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 hover:text-indigo-600 hover:border-indigo-300 shadow-sm transition-colors" title="Edit">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M18.364 4.982a8.25 8.25 0 010 11.667L9 21l-3 1 1-3 9.364-9.364zm0 0l-1.393-1.393z" /></svg>
                                    </a>
                                    <form action="{{ route('departments.destroy', $dept->id) }}" method="POST"
                                          onsubmit="return confirm('Delete department \'{{ $dept->name }}\'? This will also remove all KPI assignments for this department.');"
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-red-100 bg-white text-red-500 hover:text-white hover:bg-red-500 hover:border-red-500 shadow-sm transition-all" title="Delete">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-slate-400">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" /></svg>
                                    </div>
                                    <h3 class="text-sm font-semibold text-slate-800 mt-3">No departments found</h3>
                                    <p class="text-xs text-slate-500 mt-1">Create your first department to start assigning KPI ownership.</p>
                                    <a href="{{ route('departments.create') }}" class="mt-4 text-indigo-600 hover:text-indigo-800 text-xs font-semibold underline">Create Department</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($departments->hasPages())
            <div class="bg-slate-50 px-6 py-4 border-t border-slate-200">
                {{ $departments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
