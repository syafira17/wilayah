<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('wilayah', function (Blueprint $table) {
            $table->enum('jenis', ['desa', 'kecamatan', 'kabupaten', 'provinsi'])->after('nama_wilayah');
            $table->foreignId('parent_id')->nullable()->after('jenis')
                ->references('id')->on('wilayah')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('wilayah', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['jenis', 'parent_id']);
        });
    }
}; 