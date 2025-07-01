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
        Schema::create('sisrolepartnertypemenuweb', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user'); // Pengganti user_id
            $table->unsignedBigInteger('menu_id'); // Pengganti page_id
            $table->unsignedBigInteger('id_role')->nullable(); // Nullable, hanya terisi jika diperlukan
            $table->boolean('allow_create')->default(false);
            $table->boolean('allow_view')->default(false);
            $table->boolean('allow_update')->default(false);
            $table->boolean('allow_delete')->default(false);
            $table->boolean('allow_export')->default(false); // Field tambahan
            $table->boolean('allow_import')->default(false); // Field tambahan
            $table->boolean('allow_edit')->default(false); // Field tambahan
            $table->boolean('is_visible')->default(true); // Field tambahan
            $table->unsignedBigInteger('menu_id_ref')->nullable(); // Nullable, tidak selalu digunakan
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('menu_id')->references('id')->on('simenuweb')->onDelete('cascade');
            $table->foreign('id_role')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('menu_id_ref')->references('id')->on('simenuweb')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sisrolepartnertypemenuweb');
    }
};