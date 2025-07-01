<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Drop foreign key constraints first
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['page_id']);
        });
        
        // Drop old tables
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('pages');
    }

    public function down()
    {
        // Recreate old tables if needed for rollback
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('page_id');
            $table->boolean('allow_create')->default(false);
            $table->boolean('allow_view')->default(false);
            $table->boolean('allow_update')->default(false);
            $table->boolean('allow_delete')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }
};