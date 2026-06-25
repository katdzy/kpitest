<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kpi_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kpi_id')->constrained()->cascadeOnDelete();

            // Null = university-wide result; set = departmental contribution entry
            $table->foreignId('department_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            // Period identifier, e.g. "2025-Q1", "2025-Q2", "2025-2026"
            $table->string('period');

            $table->double('actual_value')->nullable();
            $table->double('target_value');
            $table->double('baseline_value')->nullable();

            // Auto-computed: 'On Track', 'Warning', 'Off Track'
            $table->string('status')->nullable();

            $table->text('notes')->nullable();

            // Audit trail for data origin
            $table->string('imported_from')->nullable(); // 'Manual', 'Power BI Export', 'API'

            $table->timestamps();

            // One result entry per KPI + department + period combination
            $table->unique(['kpi_id', 'department_id', 'period']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_results');
    }
};
