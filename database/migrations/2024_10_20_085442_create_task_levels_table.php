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
        Schema::create('task_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // E.g., Low, Medium, High
            $table->string('color')->nullable(); // Optional color for visual representation
            $table->integer('duration');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_levels');
    }
};
