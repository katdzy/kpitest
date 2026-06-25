@extends('layouts.app')

@section('title', 'Add Department')
@section('page_title', 'Add Department')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center space-x-3">
        <a href="{{ route('departments.index') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-indigo-600 font-medium transition-colors">
            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            Back to Departments
        </a>
    </div>

    <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/60">
            <h2 class="text-lg font-bold text-slate-900">Create New Department</h2>
            <p class="text-sm text-slate-500 mt-0.5">Add an organizational unit that will be used in KPI ownership assignments.</p>
        </div>

        <form action="{{ route('departments.store') }}" method="POST" class="px-6 py-6 space-y-5">
            @csrf

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Department Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                       placeholder="e.g. College of Engineering"
                       class="block w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('name') border-red-400 @enderror">
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Code --}}
            <div>
                <label for="code" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Department Code <span class="text-red-500">*</span>
                </label>
                <input type="text" name="code" id="code" value="{{ old('code') }}"
                       placeholder="e.g. COE"
                       class="block w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm font-mono focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('code') border-red-400 @enderror">
                <p class="mt-1 text-xs text-slate-400">Short unique identifier. Must be unique across all departments.</p>
                @error('code') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- College / Division --}}
            <div>
                <label for="college" class="block text-sm font-semibold text-slate-700 mb-1.5">College / Division</label>
                <input type="text" name="college" id="college" value="{{ old('college') }}"
                       placeholder="e.g. Academic Affairs Division"
                       class="block w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-semibold text-slate-700 mb-1.5">Description</label>
                <textarea name="description" id="description" rows="3"
                          placeholder="Brief description of this department's role..."
                          class="block w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">{{ old('description') }}</textarea>
            </div>

            {{-- Active Status --}}
            <div class="flex items-center space-x-3">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                       class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                <label for="is_active" class="text-sm font-semibold text-slate-700">Active Department</label>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('departments.index') }}" class="px-4 py-2.5 text-sm font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">
                    Cancel
                </a>
                <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm transition-all">
                    Create Department
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
