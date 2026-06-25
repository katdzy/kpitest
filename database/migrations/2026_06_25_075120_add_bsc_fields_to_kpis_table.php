<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kpis', function (Blueprint $table) {
            // BSC hierarchy linkage
            $table->foreignId('perspective_id')
                  ->nullable()
                  ->after('status_changed_at')
                  ->constrained()
                  ->nullOnDelete();

            $table->foreignId('objective_id')
                  ->nullable()
                  ->after('perspective_id')
                  ->constrained()
                  ->nullOnDelete();

            // 5-year annual targets (AY starting year)
            $table->string('target_2024')->nullable()->after('objective_id');
            $table->string('target_2025')->nullable()->after('target_2024');
            $table->string('target_2026')->nullable()->after('target_2025');
            $table->string('target_2027')->nullable()->after('target_2026');
            $table->string('target_2028')->nullable()->after('target_2027');
        });
    }

    public function down(): void
    {
        Schema::table('kpis', function (Blueprint $table) {
            $table->dropForeign(['perspective_id']);
            $table->dropForeign(['objective_id']);
            $table->dropColumn([
                'perspective_id', 'objective_id',
                'target_2024', 'target_2025', 'target_2026',
                'target_2027', 'target_2028',
            ]);
        });
    }
};
