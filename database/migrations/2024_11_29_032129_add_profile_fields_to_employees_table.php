<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('work_email'); // Path foto
            $table->string('nik')->unique()->nullable()->after('photo'); // NIK
            $table->enum('status', ['Kontrak', 'Freelance', 'Tetap', 'Tenaga Ahli'])
            ->nullable()
            ->after('nik'); // Status SDM
            $table->date('birth_date')->nullable()->after('status'); // Tanggal lahir
            $table->string('phone_number')->nullable()->after('birth_date'); // Nomor HP
            $table->string('telegram_link')->nullable()->after('phone_number'); // Link Telegram
            $table->text('address')->nullable()->after('telegram_link'); // Alamat
            $table->date('join_date')->nullable()->after('address'); // Tanggal masuk
            $table->string('education')->nullable()->after('join_date'); // Pendidikan terakhir
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'photo', 
                'nik', 
                'status', 
                'birth_date', 
                'phone_number', 
                'telegram_link', 
                'address', 
                'join_date', 
                'education'
            ]);
        });
    }
};
