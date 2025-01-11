<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            // Tambahkan kolom baru di sini jika diperlukan
            // Contoh:
            // $table->string('new_column')->after('description')->nullable();
        });
    }

    public function down()
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            // Hapus kolom yang ditambahkan
            // $table->dropColumn('new_column');
        });
    }
};