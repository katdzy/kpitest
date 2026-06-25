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
        Schema::create('outreach_programs', function (Blueprint $table) {
            $table->id();

            // Required fields
            $table->string('program_name');
            $table->string('program_type'); // Community / Extension / Partnership / Livelihood / Health / Education
            $table->string('implementing_unit');
            $table->string('academic_year'); // e.g. "2025-2026"

            // Optional fields
            $table->text('description')->nullable();
            $table->string('target_community')->nullable();
            $table->string('location')->nullable();
            $table->text('partner_agencies')->nullable(); // comma-separated or JSON
            $table->integer('beneficiaries_count')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status')->nullable(); // Planned / Ongoing / Completed / Cancelled
            $table->text('outcomes')->nullable();
            $table->text('challenges')->nullable();
            $table->text('recommendations')->nullable();
            $table->string('program_coordinator')->nullable();

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
        Schema::dropIfExists('outreach_programs');
    }
};
