@extends('layouts.app')

@section('title', 'Import KPI Performance Results')
@section('page_title', 'Import KPI Results')

@section('content')
<div class="space-y-6">

    <!-- Breadcrumbs / Top Actions -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
        <nav class="flex text-xs font-semibold text-slate-500 uppercase tracking-wider space-x-2">
            <a href="{{ route('kpis.index') }}" class="hover:text-indigo-600">KPI Library</a>
            <span>/</span>
            <span class="text-slate-900 font-bold">Import Results</span>
        </nav>
        
        <a href="{{ route('kpis.import.template') }}" 
           class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-xl shadow-sm hover:shadow-md transition-all active:scale-[0.98]">
            <svg class="w-4.5 h-4.5 mr-2 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            Download CSV Template
        </a>
    </div>

    <!-- Main Grid: Left Upload and instruction, Right format rules -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        <!-- Left: Upload Zone & Errors -->
        <div class="space-y-6 lg:col-span-2">

            <!-- Import Error Report Card -->
            @if (session()->has('import_errors'))
                <div class="rounded-2xl bg-red-50 border border-red-200 shadow-sm p-6 space-y-3">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <h3 class="text-sm font-bold text-red-800 uppercase tracking-wider">CSV Validation Errors</h3>
                    </div>
                    <p class="text-xs text-red-700 font-medium">The import was aborted because validation failed. Please fix the following errors in your CSV file and try again:</p>
                    
                    <div class="max-h-60 overflow-y-auto rounded-xl border border-red-200/60 bg-white p-3 divide-y divide-red-50">
                        @foreach (session('import_errors') as $error)
                            <div class="py-2 first:pt-0 last:pb-0 flex items-start space-x-2 text-xs font-semibold text-red-700">
                                <span class="bg-red-100 text-red-800 px-1.5 py-0.5 rounded text-[10px] font-bold font-mono">Row</span>
                                <span class="leading-relaxed">{{ $error }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Standard Laravel Validation Errors -->
            @if ($errors->any())
                <div class="rounded-2xl bg-red-50 border border-red-200 shadow-sm p-5 space-y-2">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <h3 class="text-sm font-bold text-red-800 uppercase tracking-wider">System Errors</h3>
                    </div>
                    <ul class="list-disc pl-5 text-xs text-red-700 space-y-1 font-semibold">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Upload Card -->
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-950 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Upload Performance Data CSV File
                </h3>

                <form action="{{ route('kpis.import.post') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Drag & Drop Zone -->
                    <div x-data="{ dragging: false }"
                         @dragover.prevent="dragging = true"
                         @dragleave.prevent="dragging = false"
                         @drop="dragging = false"
                         class="relative flex flex-col items-center justify-center border-2 border-dashed rounded-2xl p-10 text-center transition-all duration-200"
                         :class="dragging ? 'border-indigo-500 bg-indigo-50/40 ring-2 ring-indigo-200' : 'border-slate-200 bg-slate-50 hover:bg-slate-50/80 hover:border-slate-300'">
                        
                        <div class="bg-white p-3.5 rounded-2xl border border-slate-200/60 shadow-sm mb-4 text-slate-500 group-hover:scale-105 transition-transform">
                            <!-- CSV file icon -->
                            <svg class="w-8 h-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                        </div>
                        
                        <div class="space-y-1.5">
                            <p class="text-sm font-bold text-slate-800">
                                Drag &amp; drop your performance CSV file here, or
                                <label for="csv_file" class="text-indigo-600 hover:text-indigo-700 cursor-pointer font-extrabold hover:underline">browse files</label>
                            </p>
                            <p class="text-xs text-slate-400 font-medium">Accepts CSV files up to 2MB in size.</p>
                        </div>

                        <input type="file" 
                               name="csv_file" 
                               id="csv_file" 
                               class="hidden" 
                               accept=".csv,text/csv,text/plain"
                               onchange="updateFileName(this)">

                        <div id="file_selected_indicator" class="hidden mt-4 bg-indigo-50 border border-indigo-200 text-indigo-800 px-3.5 py-1.5 rounded-xl text-xs font-bold font-mono">
                            Selected: <span id="selected_filename" class="font-sans">filename.csv</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-3 border-t border-slate-100 pt-5">
                        <a href="{{ route('kpis.index') }}" class="px-4 py-2.5 text-sm font-semibold text-slate-700 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl shadow-sm hover:shadow-md transition-all active:scale-[0.98]">
                            Upload and Import
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <!-- Right Side: Format Rules and Columns Definition -->
        <div class="space-y-6">

            <!-- Format Rules Instruction Box -->
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-4">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-2.5">CSV Import Rules</h3>
                
                <div class="space-y-3.5 text-xs text-slate-600 leading-relaxed font-medium">
                    <p>To ensure smooth processing, make sure your CSV follows these constraints:</p>
                    
                    <div class="flex items-start space-x-2">
                        <span class="text-indigo-500 font-bold">•</span>
                        <span>The column headers must match the definitions exactly. Order does not matter.</span>
                    </div>
                    <div class="flex items-start space-x-2">
                        <span class="text-indigo-500 font-bold">•</span>
                        <span>KPI codes and Department codes are case-sensitive and must exist in the library.</span>
                    </div>
                    <div class="flex items-start space-x-2">
                        <span class="text-indigo-500 font-bold">•</span>
                        <span>Numeric values should not contain currency symbols or commas (e.g. use <code>12500</code> instead of <code>$12,500</code>). Percentages should be decimal numbers (e.g. <code>65.5</code>).</span>
                    </div>
                    <div class="flex items-start space-x-2">
                        <span class="text-indigo-500 font-bold">•</span>
                        <span>If a row has matching <code>measure_code</code>, <code>department_code</code>, and <code>period</code>, its target, baseline, actual and notes will be updated with the new values.</span>
                    </div>
                </div>
            </div>

            <!-- Column Definitions -->
            <div class="rounded-2xl bg-white border border-slate-200/60 shadow-sm p-6 space-y-4">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-2.5">Column Specifications</h3>
                
                <div class="space-y-4 max-h-[400px] overflow-y-auto pr-1">
                    <!-- Column: measure_code -->
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-xs font-bold text-slate-900">measure_code</span>
                            <span class="text-[9px] bg-red-100 text-red-800 font-extrabold px-1 rounded uppercase tracking-wider">Required</span>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1 font-medium leading-normal">The unique identifier of the KPI (e.g., <code>UNIV-AC-001</code>).</p>
                    </div>

                    <!-- Column: period -->
                    <div class="border-t border-slate-100 pt-3">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-xs font-bold text-slate-900">period</span>
                            <span class="text-[9px] bg-red-100 text-red-800 font-extrabold px-1 rounded uppercase tracking-wider">Required</span>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1 font-medium leading-normal">The tracking timeframe identifier (e.g., <code>2025-Q1</code> or <code>2025-2026</code>).</p>
                    </div>

                    <!-- Column: target_value -->
                    <div class="border-t border-slate-100 pt-3">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-xs font-bold text-slate-900">target_value</span>
                            <span class="text-[9px] bg-red-100 text-red-800 font-extrabold px-1 rounded uppercase tracking-wider">Required</span>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1 font-medium leading-normal">The numeric performance target for the period (e.g., <code>65.0</code>).</p>
                    </div>

                    <!-- Column: actual_value -->
                    <div class="border-t border-slate-100 pt-3">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-xs font-bold text-slate-900">actual_value</span>
                            <span class="text-[9px] bg-slate-100 text-slate-600 font-extrabold px-1 rounded uppercase tracking-wider">Optional</span>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1 font-medium leading-normal">The numeric actual performance achieved. If unknown, leave blank.</p>
                    </div>

                    <!-- Column: baseline_value -->
                    <div class="border-t border-slate-100 pt-3">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-xs font-bold text-slate-900">baseline_value</span>
                            <span class="text-[9px] bg-slate-100 text-slate-600 font-extrabold px-1 rounded uppercase tracking-wider">Optional</span>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1 font-medium leading-normal">The baseline starting value for comparison (e.g., <code>60.2</code>).</p>
                    </div>

                    <!-- Column: department_code -->
                    <div class="border-t border-slate-100 pt-3">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-xs font-bold text-slate-900">department_code</span>
                            <span class="text-[9px] bg-slate-100 text-slate-600 font-extrabold px-1 rounded uppercase tracking-wider">Optional</span>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1 font-medium leading-normal">Department unique abbreviation (e.g., <code>COE</code>, <code>ORI</code>). Leave blank for Institutional.</p>
                    </div>

                    <!-- Column: notes -->
                    <div class="border-t border-slate-100 pt-3">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-xs font-bold text-slate-900">notes</span>
                            <span class="text-[9px] bg-slate-100 text-slate-600 font-extrabold px-1 rounded uppercase tracking-wider">Optional</span>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1 font-medium leading-normal">Explanations or annotations for the score or variance (e.g. reason for drop).</p>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<script>
    function updateFileName(input) {
        const fileIndicator = document.getElementById('file_selected_indicator');
        const filenameSpan = document.getElementById('selected_filename');
        if (input.files && input.files.length > 0) {
            filenameSpan.textContent = input.files[0].name;
            fileIndicator.classList.remove('hidden');
        } else {
            fileIndicator.classList.add('hidden');
        }
    }
</script>
@endsection
