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
        Schema::create('research_projects', function (Blueprint $table) {
            $table->id();

            // Required fields
            $table->string('title');
            $table->string('type'); // Basic / Applied / Development / Action / Policy
            $table->string('lead_researcher');
            $table->string('academic_year'); // e.g. "2025-2026"

            // Optional fields
            $table->text('co_researchers')->nullable(); // comma-separated names
            $table->string('implementing_unit')->nullable();
            $table->string('funding_source')->nullable(); // Internal / DOST / CHED / Private / International
            $table->decimal('funding_amount', 15, 2)->nullable();
            $table->string('status')->nullable(); // Proposed / Ongoing / Completed / Published / Discontinued
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('abstract')->nullable();
            $table->string('keywords')->nullable(); // comma-separated
            $table->string('output_type')->nullable(); // Journal Article / Conference Paper / Book / Book Chapter / Patent / Policy Brief / Thesis/Dissertation
            $table->string('publication_title')->nullable(); // Journal or conference name
            $table->string('isbn_issn')->nullable();
            $table->string('indexed_in')->nullable(); // Scopus / ISI / CHED Journals / Local
            $table->string('doi')->nullable();
            $table->string('citation_count')->nullable();
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
        Schema::dropIfExists('research_projects');
    }
};
