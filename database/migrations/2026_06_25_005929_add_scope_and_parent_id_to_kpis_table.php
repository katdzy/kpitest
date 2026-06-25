<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * NOTE: departments must be migrated first (run after create_departments_table).
     */
    public function up(): void
    {
        Schema::table('kpis', function (Blueprint $table) {
            // Self-referencing parent for hierarchical roll-ups
            $table->foreignId('parent_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('kpis')
                  ->nullOnDelete();

            // 'Institutional' = University-wide KPI
            // 'Departmental'  = KPI owned/contributed by a specific department
            $table->string('scope')->default('Institutional')->after('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kpis', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['parent_id', 'scope']);
        });
    }
};
