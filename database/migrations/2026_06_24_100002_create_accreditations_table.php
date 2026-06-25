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
        Schema::create('accreditations', function (Blueprint $table) {
            $table->id();

            // Required fields
            $table->string('program_name'); // e.g. "BS Computer Science" or "Institutional"
            $table->string('level'); // Program / Institutional / Department
            $table->string('accrediting_body'); // e.g. AACCUP, PAASCU, CHED, ISO
            $table->string('academic_year'); // e.g. "2025-2026"

            // Optional fields
            $table->string('accreditation_level')->nullable(); // Level I, II, III, IV / Candidate / Accredited / Reaccredited
            $table->string('status')->nullable(); // Active / Pending / Expired / Under Surveillance / Withdrawn
            $table->date('validity_start')->nullable();
            $table->date('validity_end')->nullable();
            $table->string('certifying_officer')->nullable();
            $table->string('college_department')->nullable();
            $table->date('last_survey_date')->nullable();
            $table->date('next_survey_date')->nullable();
            $table->integer('survey_visit_count')->nullable();
            $table->text('conditions')->nullable(); // Any conditions attached to the accreditation
            $table->text('remarks')->nullable();
            $table->string('focal_person')->nullable();

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
        Schema::dropIfExists('accreditations');
    }
};
