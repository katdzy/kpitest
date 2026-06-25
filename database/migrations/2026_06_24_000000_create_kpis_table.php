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
        Schema::create('kpis', function (Blueprint $table) {
            $table->id();
            
            // Required fields
            $table->string('measure_code');
            $table->string('measure_owner');
            $table->string('measure_name');
            $table->string('measure_type');
            $table->string('category');
            $table->string('year_range'); // e.g. "2025-2026"
            
            // Optional fields
            $table->text('description')->nullable();
            $table->string('lead_lag')->nullable(); // e.g. "Lead", "Lag"
            $table->string('polarity')->nullable(); // e.g. "Positive", "Negative", "Neutral"
            $table->text('formula')->nullable();
            $table->string('unit_type')->nullable(); // e.g. "%", "USD", "Count"
            $table->string('data_provider')->nullable();
            $table->string('data_source')->nullable();
            $table->string('collection_frequency')->nullable(); // e.g. "Monthly", "Quarterly", "Annually"
            $table->string('reporting_frequency')->nullable(); // e.g. "Quarterly", "Annually"
            $table->string('verified_by')->nullable();
            $table->string('validated_by')->nullable();
            $table->string('baseline')->nullable();
            $table->string('target')->nullable();
            $table->string('high_threshold')->nullable();
            $table->string('low_threshold')->nullable();
            $table->text('target_rationale')->nullable();
            $table->string('perspective')->nullable(); // e.g. "Customer", "Financial", etc.
            $table->string('strategic_theme')->nullable();
            $table->string('objective')->nullable();
            $table->string('objective_owner')->nullable();
            $table->text('strategic_initiatives')->nullable();
            $table->text('intended_results')->nullable();
            $table->string('comparator')->nullable();
            $table->string('item_author')->nullable();
            $table->date('date')->nullable();
            
            $table->timestamps();
            
            // Unique key to support versioning of the same KPI code over different years
            $table->unique(['measure_code', 'year_range']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpis');
    }
};
