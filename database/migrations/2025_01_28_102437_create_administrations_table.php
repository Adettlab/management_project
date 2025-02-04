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
        Schema::create('administrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees');
            $table->foreignId('leave_category_id')->constrained('leave_categories');
            $table->date('start_date'); // Tanggal mulai
            $table->date('end_date'); // Tanggal akhir
            $table->text('description'); // Deskripsi alasan cuti
            $table->boolean('bring_laptop'); // Membawa laptop
            $table->boolean('contacted'); // Masih dapat dihubungi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrations');
    }
};
