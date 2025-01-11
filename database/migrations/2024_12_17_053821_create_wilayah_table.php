<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wilayah', function (Blueprint $table) {
            $table->id();
            $table->string('nama_wilayah');
            $table->string('kode_wilayah')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('status')->default('aktif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wilayah');
    }
};