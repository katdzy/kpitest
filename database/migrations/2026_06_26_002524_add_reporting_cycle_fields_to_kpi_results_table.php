<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kpi_results', function (Blueprint $table) {
            // Formal school year (e.g. "2025-2026") — separate from the legacy `period` string
            $table->string('school_year', 20)->nullable()->after('kpi_id');

            // "Mid-Year" or "Year-Ender"
            $table->string('report_type', 20)->nullable()->after('school_year');

            // Who submitted and when
            $table->string('submitted_by')->nullable()->after('notes');
            $table->timestamp('submitted_at')->nullable()->after('submitted_by');

            // Initiative outcome — filled in on Year-Ender reports
            $table->text('initiative_outcome')->nullable()->after('submitted_at');

            // Locks the record once the Year-Ender is finalised
            $table->boolean('is_final')->default(false)->after('initiative_outcome');
        });
    }

    public function down(): void
    {
        Schema::table('kpi_results', function (Blueprint $table) {
            $table->dropColumn([
                'school_year',
                'report_type',
                'submitted_by',
                'submitted_at',
                'initiative_outcome',
                'is_final',
            ]);
        });
    }
};
