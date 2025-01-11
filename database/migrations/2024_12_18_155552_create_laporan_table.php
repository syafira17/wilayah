<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('wilayah_id')->constrained('wilayah')->onDelete('cascade');
            $table->string('judul');
            $table->text('isi');
            $table->string('kategori');
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        Schema::create('laporan_lampiran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('laporan')->onDelete('cascade');
            $table->string('file_path');
            $table->string('nama_file');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_lampiran');
        Schema::dropIfExists('laporan');
    }
}; 