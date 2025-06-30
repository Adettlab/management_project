<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('simenuweb', function (Blueprint $table) {
            $table->id();
            $table->string('teks'); // Pengganti 'name' dari pages
            $table->string('navigate_url')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('tingkat')->nullable();
            $table->integer('sort_order')->nullable();
            $table->boolean('is_visible')->default(false);
            $table->unsignedBigInteger('parent_menu_id')->nullable();
            $table->timestamps();

            // Self-referencing foreign key untuk parent menu
            $table->foreign('parent_menu_id')->references('id')->on('simenuweb')->onDelete('cascade');
        });

        // Insert basic menu items (hanya teks, sisanya null atau default)
        DB::table('simenuweb')->insert([
            ['id' => 1, 'teks' => 'dashboard', 'is_visible' => false, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'teks' => 'projects', 'is_visible' => false, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'teks' => 'tasks', 'is_visible' => false, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'teks' => 'activity', 'is_visible' => false, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'teks' => 'admin', 'is_visible' => false, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('simenuweb');
    }
};