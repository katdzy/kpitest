@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Institutional Records Portal')

@section('content')
<div class="space-y-8">

    {{-- Hero Banner --}}
    <div class="relative overflow-hidden rounded-2xl p-8 shadow-lg animate-fade-up"
         style="background: linear-gradient(135deg, #9b1c1c 0%, #7f1d1d 50%, #5c1212 100%)">

        {{-- Animated floating geometric shapes --}}
        <div class="absolute top-4 right-16 float-shape opacity-10">
            <div class="w-20 h-20 rounded-2xl border-2 border-white rotate-12"></div>
        </div>
        <div class="absolute bottom-4 right-8 float-shape-2 opacity-10">
            <div class="w-32 h-32 rounded-full border-2 border-white"></div>
        </div>
        <div class="absolute top-8 right-40 float-shape-3 opacity-[0.07]">
            <div class="w-14 h-14 rounded-full bg-white"></div>
        </div>
        <div class="absolute -bottom-4 right-56 float-shape opacity-[0.06]">
            <div class="w-24 h-24 rounded-2xl bg-white rotate-45"></div>
        </div>

        {{-- Content --}}
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 mb-4">
                <span class="w-1.5 h-1.5 rounded-full bg-red-300 animate-pulse"></span>
                <p class="text-[10px] font-bold uppercase tracking-widest text-red-200">University Institutional Records</p>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white leading-tight">
                Welcome to the<br>
                <span style="background: linear-gradient(90deg, #fff 0%, #fca5a5 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    University Portal
                </span>
            </h1>
            <p class="mt-3 text-red-200/80 text-sm max-w-lg leading-relaxed">
                Centralized management of KPIs, scholarships, outreach programs, accreditations, and research projects — all in one place.
            </p>
            <div class="mt-5 flex flex-wrap gap-3">
                <a href="{{ route('kpis.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-sm font-bold transition-all hover:bg-red-50 shadow-md"
                   style="color: #7f1d1d;">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    View KPI Library
                </a>
                <a href="{{ route('kpis.import') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-sm font-bold text-white transition-all hover:bg-white/20">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Upload Results
                </a>
            </div>
            <p class="mt-4 text-red-300/60 text-xs">{{ date('l, F j, Y · H:i') }}</p>
        </div>
    </div>

    {{-- Portal Stats Summary --}}
    <div>
        <h2 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-3">At a Glance</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @php
                $portalStats = [
                    ['label' => 'KPI Records',    'count' => \App\Models\Kpi::count(),            'color' => 'red',     'route' => route('kpis.index'),         'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 12h6m-6 4h4'],
                    ['label' => 'Scholarships',   'count' => \App\Models\Scholarship::count(),    'color' => 'amber',   'route' => route('scholarships.index'), 'icon' => 'M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A5.905 5.905 0 0 1 1.75 8.301l8.33-3.791a5.905 5.905 0 0 1 3.84 0l8.33 3.791a5.905 5.905 0 0 1 .53 10.428l-1.027.467m-15.482 0a50.57 50.57 0 0 1 15.482 0v5.334'],
                    ['label' => 'Outreach',       'count' => \App\Models\OutreachProgram::count(),'color' => 'teal',    'route' => route('outreach.index'),     'icon' => 'M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z'],
                    ['label' => 'Accreditations', 'count' => \App\Models\Accreditation::count(),  'color' => 'violet',  'route' => route('accreditations.index'),'icon' => 'M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z'],
                    ['label' => 'Research Proj.', 'count' => \App\Models\ResearchProject::count(),'color' => 'sky',     'route' => route('research.index'),     'icon' => 'M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 1-6.23-.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5'],
                ];
            @endphp
            @foreach($portalStats as $i => $stat)
            <a href="{{ $stat['route'] }}"
               class="stat-card p-5 group animate-fade-up animate-fade-up-{{ $i + 1 }}">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">{{ $stat['label'] }}</p>
                    <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-{{ $stat['color'] }}-50 text-{{ $stat['color'] }}-500 group-hover:scale-110 transition-transform">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}" />
                        </svg>
                    </div>
                </div>
                <h3 class="stat-number text-3xl font-extrabold text-slate-900 group-hover:text-{{ $stat['color'] }}-600 transition-colors">{{ $stat['count'] }}</h3>
                <div class="absolute bottom-0 inset-x-0 h-0.5 bg-{{ $stat['color'] }}-500 opacity-50 group-hover:opacity-100 group-hover:h-1 transition-all duration-200"></div>
            </a>
            @endforeach
        </div>
    </div>

    {{-- Module Cards Grid --}}
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-slate-900">Portal Modules</h2>
            <span class="text-xs text-slate-400 font-medium">6 modules available</span>
        </div>
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">

            @php
                $modules = [
                    [
                        'route'       => route('kpis.index'),
                        'color'       => 'red',
                        'from'        => 'from-red-500',
                        'to'          => 'to-rose-500',
                        'bg'          => 'bg-red-50',
                        'text'        => 'text-red-600',
                        'hover'       => 'group-hover:text-red-600',
                        'title'       => 'KPI Library',
                        'subtitle'    => \App\Models\Kpi::count() . ' records',
                        'description' => 'Manage and audit key performance indicators across academic years. Track lead/lag indicators, targets, and strategic alignment.',
                        'icon'        => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 12h6m-6 4h4',
                    ],
                    [
                        'route'       => route('scholarships.index'),
                        'color'       => 'amber',
                        'from'        => 'from-amber-400',
                        'to'          => 'to-orange-500',
                        'bg'          => 'bg-amber-50',
                        'text'        => 'text-amber-600',
                        'hover'       => 'group-hover:text-amber-600',
                        'title'       => 'Scholarships & Grants',
                        'subtitle'    => \App\Models\Scholarship::count() . ' records · ' . \App\Models\Scholarship::sum('beneficiaries_count') . ' beneficiaries',
                        'description' => 'Track institutional scholarships, external grants, and funding awarded to students and faculty across academic years.',
                        'icon'        => 'M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A5.905 5.905 0 0 1 1.75 8.301l8.33-3.791a5.905 5.905 0 0 1 3.84 0l8.33 3.791a5.905 5.905 0 0 1 .53 10.428l-1.027.467m-15.482 0a50.57 50.57 0 0 1 15.482 0v5.334',
                    ],
                    [
                        'route'       => route('outreach.index'),
                        'color'       => 'teal',
                        'from'        => 'from-teal-400',
                        'to'          => 'to-emerald-500',
                        'bg'          => 'bg-teal-50',
                        'text'        => 'text-teal-600',
                        'hover'       => 'group-hover:text-teal-600',
                        'title'       => 'Outreach Programs',
                        'subtitle'    => \App\Models\OutreachProgram::count() . ' programs · ' . \App\Models\OutreachProgram::sum('beneficiaries_count') . ' beneficiaries',
                        'description' => 'Document community extension programs, partnerships, and social engagement initiatives by the university.',
                        'icon'        => 'M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z',
                    ],
                    [
                        'route'       => route('accreditations.index'),
                        'color'       => 'violet',
                        'from'        => 'from-violet-500',
                        'to'          => 'to-purple-500',
                        'bg'          => 'bg-violet-50',
                        'text'        => 'text-violet-600',
                        'hover'       => 'group-hover:text-violet-600',
                        'title'       => 'Accreditations',
                        'subtitle'    => \App\Models\Accreditation::count() . ' records · ' . \App\Models\Accreditation::where('status','Active')->count() . ' active',
                        'description' => 'Monitor program and institutional accreditation statuses, survey schedules, and accrediting body requirements.',
                        'icon'        => 'M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z',
                    ],
                    [
                        'route'       => route('research.index'),
                        'color'       => 'sky',
                        'from'        => 'from-sky-400',
                        'to'          => 'to-blue-500',
                        'bg'          => 'bg-sky-50',
                        'text'        => 'text-sky-600',
                        'hover'       => 'group-hover:text-sky-600',
                        'title'       => 'Research',
                        'subtitle'    => \App\Models\ResearchProject::count() . ' projects · ' . \App\Models\ResearchProject::where('status','Published')->count() . ' published',
                        'description' => 'Record and track faculty and student research projects, publications, funding, and indexing in international databases.',
                        'icon'        => 'M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 1-6.23-.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5',
                    ],
                    [
                        'route'       => route('departments.index'),
                        'color'       => 'rose',
                        'from'        => 'from-rose-400',
                        'to'          => 'to-pink-500',
                        'bg'          => 'bg-rose-50',
                        'text'        => 'text-rose-600',
                        'hover'       => 'group-hover:text-rose-600',
                        'title'       => 'Departments',
                        'subtitle'    => \App\Models\Department::count() . ' departments',
                        'description' => 'View and manage institutional departments, their KPI ownership, reporting structure, and organizational hierarchy.',
                        'icon'        => 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21',
                    ],
                ];
            @endphp

            @foreach($modules as $mod)
            <a href="{{ $mod['route'] }}" class="module-card group p-6 flex flex-col animate-fade-up">
                {{-- Watermark icon --}}
                <div class="absolute -bottom-3 -right-3 opacity-[0.04] pointer-events-none">
                    <svg class="w-28 h-28 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $mod['icon'] }}" />
                    </svg>
                </div>

                <div class="flex items-center gap-3 mb-4">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl {{ $mod['bg'] }} {{ $mod['text'] }} group-hover:scale-110 transition-transform flex-shrink-0">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $mod['icon'] }}" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base {{ $mod['hover'] }} transition-colors">{{ $mod['title'] }}</h3>
                        <p class="text-xs text-slate-400">{{ $mod['subtitle'] }}</p>
                    </div>
                </div>
                <p class="text-sm text-slate-500 flex-1 leading-relaxed">{{ $mod['description'] }}</p>
                <div class="mt-4 flex items-center text-sm font-bold {{ $mod['text'] }} group-hover:translate-x-1 transition-transform">
                    Open Module
                    <svg class="ml-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </div>
                <div class="absolute bottom-0 inset-x-0 h-0.5 bg-gradient-to-r {{ $mod['from'] }} {{ $mod['to'] }} group-hover:h-1 transition-all duration-200"></div>
            </a>
            @endforeach

        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="animate-fade-up animate-fade-up-5">
        <h2 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-3">Quick Actions</h2>
        <div class="flex flex-wrap gap-2.5">
            <a href="{{ route('kpis.create') }}" class="quick-action-pill bg-red-50 border-red-200/70 text-red-700 hover:bg-red-100">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                New KPI
            </a>
            <a href="{{ route('scholarships.create') }}" class="quick-action-pill bg-amber-50 border-amber-200/70 text-amber-700 hover:bg-amber-100">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                New Scholarship
            </a>
            <a href="{{ route('outreach.create') }}" class="quick-action-pill bg-teal-50 border-teal-200/70 text-teal-700 hover:bg-teal-100">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                New Outreach
            </a>
            <a href="{{ route('accreditations.create') }}" class="quick-action-pill bg-violet-50 border-violet-200/70 text-violet-700 hover:bg-violet-100">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                New Accreditation
            </a>
            <a href="{{ route('research.create') }}" class="quick-action-pill bg-sky-50 border-sky-200/70 text-sky-700 hover:bg-sky-100">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                New Research
            </a>
            <a href="{{ route('kpis.import') }}" class="quick-action-pill bg-slate-50 border-slate-200/70 text-slate-600 hover:bg-slate-100">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                Upload KPI Results
            </a>
        </div>
    </div>

</div>
@endsection
