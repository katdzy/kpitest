<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('objectives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perspective_id')->constrained()->cascadeOnDelete();
            $table->string('code');              // e.g. "O1", "O2"
            $table->string('title');             // e.g. "Improve Graduate Competitiveness"
            $table->text('intended_result')->nullable(); // narrative from BSC bottom section
            $table->string('owner')->nullable(); // e.g. "AAO, OIA, SSAC"
            $table->unsignedTinyInteger('order')->default(0);
            $table->timestamps();

            $table->unique('code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('objectives');
    }
};
