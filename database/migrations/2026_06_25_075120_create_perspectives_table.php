<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perspectives', function (Blueprint $table) {
            $table->id();
            $table->string('name');                   // e.g. "Customer & Stakeholder"
            $table->string('color')->default('slate'); // Tailwind color name for UI
            $table->string('hex_color')->nullable();   // e.g. "#2563eb"
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perspectives');
    }
};
