<?php

namespace Database\Seeders;

use App\Models\Wilayah;
use App\Models\WilayahDetail;
use Illuminate\Database\Seeder;

class WilayahSeeder extends Seeder
{
    public function run()
    {
        // Provinsi
        $provinsi = Wilayah::create([
            'kode_wilayah' => '32',
            'nama_wilayah' => 'JAWA BARAT',
            'jenis' => 'provinsi',
            'status' => 'aktif'
        ]);

        $provinsi->detail()->create([
            'jumlah_penduduk' => 48274162,
            'luas_wilayah' => 35377.76
        ]);

        // Kabupaten
        $kabupaten = Wilayah::create([
            'kode_wilayah' => '32.01',
            'nama_wilayah' => 'KABUPATEN BOGOR',
            'jenis' => 'kabupaten',
            'parent_id' => $provinsi->id,
            'status' => 'aktif'
        ]);

        $kabupaten->detail()->create([
            'jumlah_penduduk' => 5427068,
            'luas_wilayah' => 2986.13
        ]);

        // Kecamatan
        $kecamatan = Wilayah::create([
            'kode_wilayah' => '32.01.01',
            'nama_wilayah' => 'KECAMATAN CIBINONG',
            'jenis' => 'kecamatan',
            'parent_id' => $kabupaten->id,
            'status' => 'aktif'
        ]);

        $kecamatan->detail()->create([
            'jumlah_penduduk' => 343927,
            'luas_wilayah' => 43.36
        ]);

        // Desa/Kelurahan
        $desa = Wilayah::create([
            'kode_wilayah' => '32.01.01.001',
            'nama_wilayah' => 'KELURAHAN CIBINONG',
            'jenis' => 'desa',
            'parent_id' => $kecamatan->id,
            'status' => 'aktif'
        ]);

        $desa->detail()->create([
            'jumlah_penduduk' => 27465,
            'luas_wilayah' => 2.91
        ]);
    }
} 