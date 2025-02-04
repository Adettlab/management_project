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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')
            ->onDelete('cascade');
            $table->string('name');
            $table->foreignId('task_status_id')->constrained('task_statuses');
            $table->foreignId('task_level_id')->constrained('task_levels');
            $table->foreignId('assigned_project_employee_id')
            ->constrained('project_employees');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
