<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama halaman
            $table->timestamps();
        });
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Menghubungkan ke tabel users
            $table->unsignedBigInteger('page_id'); // Menghubungkan ke tabel pages
            $table->boolean('allow_create')->default(false); // Hak akses untuk membuat data
            $table->boolean('allow_view')->default(false); // Hak akses untuk melihat data
            $table->boolean('allow_update')->default(false); // Hak akses untuk mengupdate data
            $table->boolean('allow_delete')->default(false); // Hak akses untuk menghapus data
            $table->timestamps();

            // Menambahkan foreign key constraint untuk user_id dan page_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });

         
       

    }

    public function down()
    {
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('pages');
    }
};