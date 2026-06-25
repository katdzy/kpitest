@extends('layouts.app')

@section('title', 'KPI Library')
@section('page_title', 'KPI Library')
@section('header_action')
    <div class="flex items-center gap-2">
        <a href="{{ route('kpis.import') }}" class="btn-secondary text-slate-700 hover:bg-slate-50 gap-1.5">
            <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
            Upload
        </a>
        <a href="{{ route('kpis.create') }}" class="btn-primary text-white gap-1.5" style="background:#9b1c1c;">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Add KPI
        </a>
    </div>
@endsection

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4 animate-fade-up">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">University KPI Library</h1>
            <p class="text-sm text-slate-500 mt-1">Manage and audit key performance indicator versions across academic years.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('kpis.import') }}" class="btn-secondary text-slate-700 hover:bg-slate-50 gap-1.5">
                <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                Upload Results
            </a>
            <a href="{{ route('kpis.create') }}" class="btn-primary text-white gap-1.5" style="background: linear-gradient(135deg,#9b1c1c,#ef4444);">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Add New KPI
            </a>
        </div>
    </div>

    {{-- Statistics Overview --}}
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5 animate-fade-up animate-fade-up-1">
        {{-- Total --}}
        <div class="stat-card p-5 lg:col-span-1 group">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total KPIs</p>
                <div class="flex h-7 w-7 rounded-lg bg-red-50 text-red-600 items-center justify-center">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                </div>
            </div>
            <h3 class="stat-number text-3xl font-extrabold text-slate-900">{{ $stats['total'] }}</h3>
            <div class="absolute bottom-0 inset-x-0 h-0.5 bg-gradient-to-r from-red-600 to-rose-500 group-hover:h-1 transition-all"></div>
        </div>
        {{-- Institutional --}}
        <div class="stat-card p-5 group">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Institutional</p>
                <div class="flex h-7 w-7 rounded-lg bg-violet-50 text-violet-500 items-center justify-center">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z"/></svg>
                </div>
            </div>
            <h3 class="stat-number text-3xl font-extrabold text-violet-600">{{ $stats['institutional'] }}</h3>
            <div class="absolute bottom-0 inset-x-0 h-0.5 bg-gradient-to-r from-violet-500 to-purple-500 group-hover:h-1 transition-all"></div>
        </div>
        {{-- Departmental --}}
        <div class="stat-card p-5 group">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Departmental</p>
                <div class="flex h-7 w-7 rounded-lg bg-sky-50 text-sky-500 items-center justify-center">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
                </div>
            </div>
            <h3 class="stat-number text-3xl font-extrabold text-sky-600">{{ $stats['departmental'] }}</h3>
            <div class="absolute bottom-0 inset-x-0 h-0.5 bg-gradient-to-r from-sky-500 to-blue-500 group-hover:h-1 transition-all"></div>
        </div>
        {{-- Lead --}}
        <div class="stat-card p-5 group">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Lead Indicators</p>
                <div class="flex h-7 w-7 rounded-lg bg-teal-50 text-teal-500 items-center justify-center">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                </div>
            </div>
            <h3 class="stat-number text-3xl font-extrabold text-slate-900">{{ $stats['lead'] }}</h3>
            <div class="absolute bottom-0 inset-x-0 h-0.5 bg-gradient-to-r from-teal-500 to-emerald-500 group-hover:h-1 transition-all"></div>
        </div>
        {{-- Categories --}}
        <div class="stat-card p-5 group">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Categories</p>
                <div class="flex h-7 w-7 rounded-lg bg-purple-50 text-purple-500 items-center justify-center">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                </div>
            </div>
            <h3 class="stat-number text-3xl font-extrabold text-slate-900">{{ $stats['categories_count'] }}</h3>
            <div class="absolute bottom-0 inset-x-0 h-0.5 bg-gradient-to-r from-purple-500 to-pink-500 group-hover:h-1 transition-all"></div>
        </div>
    </div>

    {{-- Search and Filter Bar --}}
    <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm overflow-hidden animate-fade-up animate-fade-up-2">
        <div class="px-5 py-3.5 border-b border-slate-100 flex items-center gap-2">
            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"/></svg>
            <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider">Filters</h3>
            @if(request()->hasAny(['search', 'category', 'year_range', 'lead_lag', 'sort', 'scope', 'status', 'perspective_id', 'objective_id']))
                <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded-full bg-red-50 border border-red-200/60 text-[10px] font-bold text-red-600">Filters Active</span>
            @endif
        </div>
        <div class="p-5">
            <form action="{{ route('kpis.index') }}" method="GET" class="flex flex-col gap-4 xl:flex-row xl:items-end">
                {{-- Search Input --}}
                <div class="flex-grow">
                    <label for="search" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Search KPIs</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Search by code, measure name, or owner..."
                               class="form-input pl-9">
                    </div>
                </div>

                {{-- Filters --}}
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4 xl:w-auto">
                    <div>
                        <label for="perspective_id" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Perspective</label>
                        <select name="perspective_id" id="perspective_id" class="form-input">
                            <option value="">All Perspectives</option>
                            @foreach ($perspectives as $p)
                                <option value="{{ $p->id }}" {{ request('perspective_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="objective_id" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Objective</label>
                        <select name="objective_id" id="objective_id" class="form-input">
                            <option value="">All Objectives</option>
                            @foreach ($objectives as $obj)
                                <option value="{{ $obj->id }}" {{ request('objective_id') == $obj->id ? 'selected' : '' }}>{{ $obj->code }}: {{ $obj->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="category" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Category</label>
                        <select name="category" id="category" class="form-input">
                            <option value="">All Categories</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="scope" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Scope</label>
                        <select name="scope" id="scope" class="form-input">
                            <option value="">All Scopes</option>
                            <option value="Institutional" {{ request('scope') === 'Institutional' ? 'selected' : '' }}>Institutional</option>
                            <option value="Departmental" {{ request('scope') === 'Departmental' ? 'selected' : '' }}>Departmental</option>
                        </select>
                    </div>
                    <div>
                        <label for="year_range" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Year Range</label>
                        <select name="year_range" id="year_range" class="form-input">
                            <option value="">All Years</option>
                            @foreach ($yearRanges as $range)
                                <option value="{{ $range }}" {{ request('year_range') === $range ? 'selected' : '' }}>{{ $range }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="lead_lag" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Type</label>
                        <select name="lead_lag" id="lead_lag" class="form-input">
                            <option value="">All Types</option>
                            <option value="Lead" {{ request('lead_lag') === 'Lead' ? 'selected' : '' }}>Lead</option>
                            <option value="Lag" {{ request('lead_lag') === 'Lag' ? 'selected' : '' }}>Lag</option>
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Status</label>
                        <select name="status" id="status" class="form-input">
                            <option value="">All Statuses</option>
                            @foreach (\App\Models\Kpi::STATUSES as $s)
                                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="sort" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Sort By</label>
                        <select name="sort" id="sort" class="form-input">
                            <option value="default"     {{ $sort === 'default'     ? 'selected' : '' }}>Code A–Z</option>
                            <option value="name"        {{ $sort === 'name'        ? 'selected' : '' }}>Name A–Z</option>
                            <option value="perspective" {{ $sort === 'perspective' ? 'selected' : '' }}>Perspective</option>
                            <option value="objective"   {{ $sort === 'objective'   ? 'selected' : '' }}>Objective</option>
                            <option value="theme"       {{ $sort === 'theme'       ? 'selected' : '' }}>Theme A–Z</option>
                        </select>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex items-center gap-2">
                    <button type="submit" class="btn-primary text-white gap-1.5" style="background:linear-gradient(135deg,#9b1c1c,#ef4444);">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Filter
                    </button>
                    @if (request()->hasAny(['search', 'category', 'year_range', 'lead_lag', 'sort', 'scope', 'status', 'perspective_id', 'objective_id']))
                        <a href="{{ route('kpis.index') }}" class="btn-secondary text-slate-600 hover:bg-slate-50">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- KPI List Card --}}
    <div class="overflow-hidden rounded-2xl bg-white border border-slate-200/60 shadow-sm animate-fade-up animate-fade-up-3">
        {{-- Table header bar --}}
        <div class="px-6 py-3.5 border-b border-slate-100 flex items-center justify-between">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                @if($kpis->total() > 0)
                    Showing {{ $kpis->firstItem() }}–{{ $kpis->lastItem() }} of {{ number_format($kpis->total()) }} records
                @else
                    KPI Records
                @endif
            </span>
            <div class="flex items-center gap-2">
                <a href="{{ route('kpis.dashboard') }}" class="inline-flex items-center gap-1 text-[11px] font-semibold text-red-700 hover:text-red-900 hover:underline">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/></svg>
                    Dashboard
                </a>
                <span class="text-slate-300">·</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-600 border border-red-200/60">
                    {{ number_format($kpis->total()) }} total
                </span>
            </div>
        </div>

        <div class="divide-y divide-slate-100 bg-white">
            @forelse ($kpis as $item)
                <div class="p-6 hover:bg-slate-50/50 transition-all duration-200 relative group border-l-4 border-transparent hover:border-l-red-600">
                    <div class="flex items-start justify-between gap-4">
                        {{-- Left Side: Category Icon, Metadata, and Title --}}
                        <div class="flex items-start gap-4">
                            {{-- Category Avatar Icon --}}
                            @php
                                $catColors = [
                                    'Academic'        => ['bg' => 'bg-blue-50/80', 'text' => 'text-blue-600', 'border' => 'border-blue-200/50', 'icon' => 'academic-cap'],
                                    'Research'        => ['bg' => 'bg-purple-50/80', 'text' => 'text-purple-600', 'border' => 'border-purple-200/50', 'icon' => 'beaker'],
                                    'Financial'       => ['bg' => 'bg-emerald-50/80', 'text' => 'text-emerald-600', 'border' => 'border-emerald-200/50', 'icon' => 'banknotes'],
                                    'Student Services'=> ['bg' => 'bg-indigo-50/80', 'text' => 'text-indigo-600', 'border' => 'border-indigo-200/50', 'icon' => 'user-group'],
                                ];
                                $themeInfo = $catColors[$item->category] ?? ['bg' => 'bg-slate-50', 'text' => 'text-slate-600', 'border' => 'border-slate-200/50', 'icon' => 'document-chart-bar'];
                            @endphp
                            
                            <div class="flex-shrink-0 flex h-10 w-10 items-center justify-center rounded-xl {{ $themeInfo['bg'] }} {{ $themeInfo['text'] }} border {{ $themeInfo['border'] }} shadow-xs">
                                @if($themeInfo['icon'] === 'academic-cap')
                                    <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.905 59.905 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M12 2.25V3.5m-3.078 16.625C9.078 20.125 9 20.062 9 20v-3.007a3 3 0 0 1 .879-2.122L12 12.75l2.121 2.121A3 3 0 0 1 15 17.007V20c0 .062-.078.125-.122.125"/></svg>
                                @elseif($themeInfo['icon'] === 'beaker')
                                    <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v1.244c0 .89-1.077 1.334-1.707.705L7.013 4.023a1.5 1.5 0 0 0-2.121 0L3.023 5.89a1.5 1.5 0 0 0 0 2.121l.666.667c.63.63.185 1.707-.707 1.707H1.739a1.5 1.5 0 0 0-1.5 1.5v2.634a1.5 1.5 0 0 0 1.5 1.5h1.244c.89 0 1.334 1.077.705 1.707l-.666.666a1.5 1.5 0 0 0 0 2.122l1.869 1.869a1.5 1.5 0 0 0 2.121 0l.667-.666c.63-.63 1.707-.185 1.707.707v1.244a1.5 1.5 0 0 0 1.5 1.5h2.634a1.5 1.5 0 0 0 1.5-1.5v-1.244c0-.89 1.077-1.334 1.707-.705l.666.666a1.5 1.5 0 0 0 2.122 0l1.869-1.869a1.5 1.5 0 0 0 0-2.122l-.666-.666c-.63-.63-.185-1.707.707-1.707h1.244a1.5 1.5 0 0 0 1.5-1.5v-2.634a1.5 1.5 0 0 0-1.5-1.5h-1.244c-.89 0-1.334-1.077-.705-1.707l.666-.667a1.5 1.5 0 0 0 0-2.121l-1.869-1.87a1.5 1.5 0 0 0-2.121 0l-.667.667c-.63.63-1.707.185-1.707-.707V3.104a1.5 1.5 0 0 0-1.5-1.5H11.25a1.5 1.5 0 0 0-1.5 1.5Z"/></svg>
                                @elseif($themeInfo['icon'] === 'banknotes')
                                    <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5h16.5a1.5 1.5 0 0 1 1.5 1.5v12a1.5 1.5 0 0 1-1.5 1.5H3.75a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Zm13.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/></svg>
                                @elseif($themeInfo['icon'] === 'user-group')
                                    <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m0 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 0 18c0 .225.012.447.037.666A11.94 11.94 0 0 0 6 21c2.17 0 4.207-.576 5.963-1.584A6.06 6.06 0 0 0 18 18.72Zm-12-13.5a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Zm10.5 0a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/></svg>
                                @else
                                    <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                                @endif
                            </div>

                            <div class="flex-grow">
                                {{-- Meta Line 1 (Breadcrumb style) --}}
                                <div class="flex items-center gap-1.5 text-xs text-slate-400 font-medium">
                                    <span class="font-bold text-slate-700">{{ $item->category }}</span>
                                    <span class="text-slate-300">·</span>
                                    <span>{{ $item->scope }} Scope</span>
                                    <span class="text-slate-300">·</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 font-mono font-bold text-[10px]">{{ $item->measure_code }}</span>
                                    @php
                                        $statusColors = [
                                            'Active'       => 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
                                            'Draft'        => 'bg-slate-100 text-slate-500 border-slate-200/60',
                                            'Under Review' => 'bg-amber-50 text-amber-700 border-amber-200/60',
                                            'Approved'     => 'bg-blue-50 text-blue-700 border-blue-200/60',
                                            'Archived'     => 'bg-rose-50 text-rose-600 border-rose-200/60',
                                        ];
                                        $sBadge = $statusColors[$item->status] ?? 'bg-slate-100 text-slate-500 border-slate-200/60';
                                    @endphp
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded border text-[10px] font-bold {{ $sBadge }}">{{ $item->status }}</span>
                                </div>

                                {{-- Meta Line 2 (Forum Author/Date style) --}}
                                <div class="text-[11px] text-slate-400 mt-1 font-medium flex items-center gap-1">
                                    <span>Owner: <strong class="text-slate-600 font-semibold">{{ $item->measure_owner }}</strong></span>
                                    <span class="text-slate-300">·</span>
                                    <span>Year: <strong class="text-slate-600 font-semibold font-mono">{{ $item->year_range }}</strong></span>
                                </div>

                                {{-- KPI Clickable Title (Google search-like large blue title link) --}}
                                <h4 class="text-base font-bold text-slate-900 mt-2 leading-snug">
                                    <a href="{{ route('kpis.show', $item->id) }}" class="text-slate-900 hover:text-red-700 transition-colors hover:underline decoration-2 underline-offset-2">
                                        {{ $item->measure_name }}
                                    </a>
                                </h4>
                            </div>
                        </div>

                        {{-- Right Side: Options (3 dots menu dropdown) using AlpineJS --}}
                        <div class="flex items-start" x-data="{ open: false }">
                            <div class="relative">
                                <button @click="open = !open" @click.outside="open = false" type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors cursor-pointer" title="Options">
                                    <svg class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                                </button>
                                <!-- Dropdown menu -->
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute right-0 mt-1 w-40 rounded-xl bg-white border border-slate-200 shadow-lg py-1.5 z-10 hidden"
                                     :class="{'hidden': !open}">
                                    <a href="{{ route('kpis.show', $item->id) }}" class="flex items-center gap-2 px-3.5 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z"/></svg>
                                        View details
                                    </a>
                                    <a href="{{ route('kpis.edit', $item->id) }}" class="flex items-center gap-2 px-3.5 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/></svg>
                                        Edit KPI
                                    </a>
                                    <div class="h-px bg-slate-100 my-1"></div>
                                    <form action="{{ route('kpis.destroy', $item->id) }}" method="POST"
                                          onsubmit="return confirm('Delete KPI \'{{ $item->measure_name }}\' ({{ $item->year_range }})? This cannot be undone.');"
                                          class="block w-full">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex items-center gap-2 w-full text-left px-3.5 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50 transition-colors cursor-pointer">
                                            <svg class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                            Delete KPI
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Description / Snippet text --}}
                    <div class="mt-2.5 text-sm text-slate-600 pl-14 max-w-3xl leading-relaxed">
                        @if($item->description)
                            {{ Str::limit($item->description, 260, '...') }}
                        @else
                            @if($item->objective)
                                Objective is to <strong class="text-slate-800 font-medium">{{ Str::lower($item->objective) }}</strong>.
                            @endif
                            @if($item->strategic_theme)
                                Aligned with strategic theme: <span class="italic text-slate-700 font-medium">{{ $item->strategic_theme }}</span>.
                            @endif
                            This measurement operates as a <span class="font-semibold text-slate-700">{{ Str::lower($item->lead_lag) }} indicator</span> under the {{ Str::lower($item->category) }} dashboard.
                        @endif
                        <a href="{{ route('kpis.show', $item->id) }}" class="text-red-700 hover:text-red-900 text-xs font-semibold ml-1 hover:underline inline-flex items-center gap-0.5">Read more <span class="text-[10px]">→</span></a>
                    </div>

                    {{-- Tags & Action Links Row --}}
                    <div class="mt-4 pl-14 flex flex-wrap items-center justify-between gap-3">
                        {{-- Tag Badges (Forum / Rich snippet style) --}}
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-400 bg-slate-50 border border-slate-100 px-2 py-0.5 rounded">
                                Target:
                                <strong class="text-slate-700 font-bold">
                                    {{ $item->target ?: 'N/A' }}{{ $item->unit_type && $item->unit_type !== 'Percentage' && $item->unit_type !== 'Currency' ? ' ' . $item->unit_type : '' }}
                                </strong>
                            </span>

                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-400 bg-slate-50 border border-slate-100 px-2 py-0.5 rounded">
                                Type:
                                @if ($item->lead_lag === 'Lead')
                                    <span class="text-teal-600 font-bold">Lead</span>
                                @elseif ($item->lead_lag === 'Lag')
                                    <span class="text-amber-600 font-bold">Lag</span>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </span>
                            
                            @if($item->perspective)
                                <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-400 bg-slate-50 border border-slate-100 px-2 py-0.5 rounded">
                                    Perspective:
                                    <span class="text-slate-700 font-bold">{{ $item->perspective }}</span>
                                </span>
                            @endif
                        </div>

                        {{-- Action Links (Forum Style) --}}
                        <div class="flex items-center gap-3 text-xs font-semibold text-slate-400">
                            <a href="{{ route('kpis.show', $item->id) }}" class="hover:text-red-700 transition-colors inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.43 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                                View details
                            </a>
                            <span class="text-slate-300">•</span>
                            <a href="{{ route('kpis.edit', $item->id) }}" class="hover:text-red-700 transition-colors inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/></svg>
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-16 text-center">
                    <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-red-50 text-red-300 mb-4 shadow-sm">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 12h6m-6 4h4" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-800">No KPIs found</h3>
                        <p class="text-sm text-slate-400 mt-1.5 leading-relaxed">Try broadening your search term or clearing filters to find what you are looking for.</p>
                        <div class="flex items-center gap-3 mt-5">
                            <a href="{{ route('kpis.index') }}" class="btn-secondary text-slate-600 hover:bg-slate-50 text-sm">Clear Filters</a>
                            <a href="{{ route('kpis.create') }}" class="btn-primary text-white text-sm gap-1.5" style="background:linear-gradient(135deg,#9b1c1c,#ef4444);">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                Add First KPI
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($kpis->hasPages())
            <div class="bg-slate-50/75 px-6 py-4 border-t border-slate-200">
                {{ $kpis->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
