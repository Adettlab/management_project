<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sisrolepartnertype', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_role');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_role')->references('id')->on('roles')->onDelete('cascade');
            
            // Unique constraint untuk kombinasi user dan role
            $table->unique(['id_user', 'id_role']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('sisrolepartnertype');
    }
};