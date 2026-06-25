@extends('layouts.app')

@section('title', $department->name)
@section('page_title', $department->name)
@section('header_action')
    <a href="{{ route('departments.edit', $department->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-white bg-[#9b1c1c] hover:bg-[#7f1d1d] rounded-lg shadow-sm transition-all">
        <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
        Edit
    </a>
@endsection

@section('content')
<div class="space-y-6">

    <div class="flex items-center space-x-3">
        <a href="{{ route('departments.index') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-indigo-600 font-medium transition-colors">
            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            All Departments
        </a>
    </div>

    {{-- Header Card --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 via-indigo-700 to-violet-700 p-7 shadow-lg text-white">
        <div class="relative z-10 flex items-start justify-between">
            <div>
                <span class="inline-flex items-center rounded-lg bg-white/15 px-2.5 py-1 text-xs font-bold tracking-widest uppercase text-white/80 mb-3">
                    {{ $department->code }}
                </span>
                <h1 class="text-3xl font-extrabold">{{ $department->name }}</h1>
                @if($department->college)
                    <p class="mt-1 text-indigo-200 text-sm">{{ $department->college }}</p>
                @endif
                @if($department->description)
                    <p class="mt-3 text-indigo-100 text-sm max-w-2xl">{{ $department->description }}</p>
                @endif
            </div>
            <div>
                @if($department->is_active)
                    <span class="inline-flex items-center rounded-full bg-emerald-400/20 border border-emerald-300/30 px-3 py-1.5 text-xs font-bold text-emerald-200">
                        <span class="mr-1.5 h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Active
                    </span>
                @else
                    <span class="inline-flex items-center rounded-full bg-white/10 border border-white/20 px-3 py-1.5 text-xs font-bold text-white/60">
                        Inactive
                    </span>
                @endif
            </div>
        </div>
        <div class="absolute -right-8 -bottom-8 opacity-10">
            <svg class="w-56 h-56 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
            </svg>
        </div>
    </div>

    {{-- KPI Summary Stat --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-5">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Assigned KPIs</p>
            <h3 class="text-3xl font-extrabold text-slate-900 mt-1">{{ $kpis->count() }}</h3>
        </div>
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-5">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">As Strategic Owner</p>
            <h3 class="text-3xl font-extrabold text-indigo-600 mt-1">
                {{ $kpis->filter(fn($k) => $k->pivot?->role === 'Strategic Owner')->count() }}
            </h3>
        </div>
        <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-5">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">As Data Provider</p>
            <h3 class="text-3xl font-extrabold text-teal-600 mt-1">
                {{ $kpis->filter(fn($k) => $k->pivot?->role === 'Data Provider')->count() }}
            </h3>
        </div>
    </div>

    {{-- Assigned KPIs Table --}}
    <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-900">Assigned KPIs</h2>
            <a href="{{ route('kpis.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold">View All KPIs →</a>
        </div>

        @if($kpis->isEmpty())
            <div class="py-10 text-center">
                <p class="text-sm text-slate-500">No KPIs are assigned to this department yet.</p>
                <a href="{{ route('kpis.create') }}" class="mt-2 inline-block text-xs text-indigo-600 font-semibold hover:underline">Add a KPI and assign it here</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50/75">
                        <tr>
                            <th class="py-3.5 pl-6 pr-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Code</th>
                            <th class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">KPI Name</th>
                            <th class="px-3 py-3.5 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Scope</th>
                            <th class="px-3 py-3.5 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Role</th>
                            <th class="px-3 py-3.5 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Year</th>
                            <th class="py-3.5 pl-3 pr-6 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach($kpis as $kpi)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-3.5 pl-6 pr-3 text-sm">
                                    <span class="font-mono font-bold text-slate-700 bg-slate-100 px-2 py-1 rounded-md text-xs border border-slate-200/50">{{ $kpi->measure_code }}</span>
                                </td>
                                <td class="px-3 py-3.5 text-sm">
                                    <a href="{{ route('kpis.show', $kpi->id) }}" class="font-semibold text-slate-900 hover:text-indigo-600 transition-colors">
                                        {{ $kpi->measure_name }}
                                    </a>
                                </td>
                                <td class="px-3 py-3.5 text-center text-sm">
                                    @if($kpi->scope === 'Institutional')
                                        <span class="inline-flex items-center rounded-lg bg-violet-50 px-2.5 py-1 text-xs font-semibold text-violet-700 border border-violet-200/60">Institutional</span>
                                    @else
                                        <span class="inline-flex items-center rounded-lg bg-sky-50 px-2.5 py-1 text-xs font-semibold text-sky-700 border border-sky-200/60">Departmental</span>
                                    @endif
                                </td>
                                <td class="px-3 py-3.5 text-center text-sm">
                                    @php
                                        $role = $kpi->pivot?->role ?? '—';
                                        $roleColor = match($role) {
                                            'Strategic Owner' => 'indigo',
                                            'Data Provider'   => 'teal',
                                            'Contributor'     => 'amber',
                                            default           => 'slate',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-lg bg-{{ $roleColor }}-50 px-2.5 py-1 text-xs font-semibold text-{{ $roleColor }}-700 border border-{{ $roleColor }}-200/60">
                                        {{ $role }}
                                    </span>
                                </td>
                                <td class="px-3 py-3.5 text-center text-sm font-semibold text-slate-700 font-mono">{{ $kpi->year_range }}</td>
                                <td class="py-3.5 pl-3 pr-6 text-right">
                                    <a href="{{ route('kpis.show', $kpi->id) }}"
                                       class="inline-flex h-7 w-7 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:text-indigo-600 hover:border-indigo-300 shadow-sm transition-colors">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Danger Zone --}}
    <div class="rounded-2xl border border-red-200/60 bg-red-50/40 p-5">
        <h3 class="text-sm font-bold text-red-700 mb-1">Danger Zone</h3>
        <p class="text-xs text-red-600 mb-3">Deleting this department will remove all KPI assignment records linked to it. KPI definitions will not be deleted.</p>
        <form action="{{ route('departments.destroy', $department->id) }}" method="POST"
              onsubmit="return confirm('Are you sure you want to delete \'{{ $department->name }}\'? This action cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-xl shadow-sm transition-all">
                Delete Department
            </button>
        </form>
    </div>

</div>
@endsection
