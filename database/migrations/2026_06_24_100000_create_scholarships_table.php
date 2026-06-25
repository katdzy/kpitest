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
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();

            // Required fields
            $table->string('title');
            $table->string('type'); // Scholarship / Grant / Fellowship / Assistantship
            $table->string('beneficiary_type'); // Student / Faculty / Staff / Both
            $table->string('academic_year'); // e.g. "2025-2026"

            // Optional fields
            $table->text('description')->nullable();
            $table->string('funding_source')->nullable(); // e.g. CHED, DOST, Private
            $table->string('administering_unit')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('currency', 10)->nullable()->default('PHP');
            $table->integer('beneficiaries_count')->nullable();
            $table->string('selection_criteria')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status')->nullable(); // Active / Completed / Pending / Suspended
            $table->text('outcomes')->nullable();
            $table->text('remarks')->nullable();

            // Meta / Audit
            $table->string('item_author')->nullable();
            $table->date('date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};
