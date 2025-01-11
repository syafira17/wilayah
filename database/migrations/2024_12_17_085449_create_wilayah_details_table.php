<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wilayah_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wilayah_id')->constrained('wilayah')->onDelete('cascade');
            $table->integer('jumlah_penduduk')->nullable();
            $table->decimal('luas_wilayah', 10, 2)->nullable(); // dalam km2
            $table->text('fasilitas')->nullable();
            $table->timestamps();
        });

        Schema::create('wilayah_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wilayah_id')->constrained('wilayah')->onDelete('cascade');
            $table->string('nama_dokumen');
            $table->string('file_path');
            $table->string('tipe_dokumen'); // foto/dokumen
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wilayah_documents');
        Schema::dropIfExists('wilayah_details');
    }
}; 