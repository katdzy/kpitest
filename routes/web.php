<?php

use App\Http\Controllers\KpiController;
use App\Http\Controllers\KpiReportController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\OutreachProgramController;
use App\Http\Controllers\AccreditationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResearchProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

use App\Http\Controllers\KpiResultImportController;

Route::get('kpis/import', [KpiResultImportController::class, 'show'])->name('kpis.import');
Route::post('kpis/import', [KpiResultImportController::class, 'import'])->name('kpis.import.post');
Route::get('kpis/import/template', [KpiResultImportController::class, 'downloadTemplate'])->name('kpis.import.template');

// KPI Library Dashboard & status transition (must come before the resource routes)
Route::get('kpis/dashboard', [KpiController::class, 'dashboard'])->name('kpis.dashboard');
Route::put('kpis/{kpi}/status', [KpiController::class, 'updateStatus'])->name('kpis.status');

Route::resource('kpis', KpiController::class);

// Nested: report submission for a specific KPI (/kpis/{kpi}/reports/create)
Route::resource('kpis.reports', KpiReportController::class)->only(['create', 'store']);

Route::resource('departments', DepartmentController::class);
Route::resource('scholarships', ScholarshipController::class);
Route::resource('outreach', OutreachProgramController::class);
Route::resource('accreditations', AccreditationController::class);
Route::resource('research', ResearchProjectController::class);

// ── Reports & Scorecards ────────────────────────────────────────
Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('index');
    Route::get('/five-year-plan', [ReportController::class, 'fiveYearPlan'])->name('five-year-plan');
    Route::get('/{school_year}', [ReportController::class, 'schoolYear'])->name('school-year');
    Route::get('/{school_year}/mid-year', [ReportController::class, 'midYear'])->name('mid-year');
    Route::get('/{school_year}/year-ender', [ReportController::class, 'yearEnder'])->name('year-ender');
});

Route::get('/strategy-map', [ReportController::class, 'strategyMap'])->name('strategy-map');


