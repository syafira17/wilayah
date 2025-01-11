<?php

namespace App\Imports;

use App\Models\Wilayah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class WilayahImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $wilayah = Wilayah::create([
            'kode_wilayah' => $row['kode_wilayah'],
            'nama_wilayah' => $row['nama_wilayah'],
            'jenis' => strtolower($row['jenis']),
            'status' => strtolower($row['status']),
            'latitude' => $row['latitude'] ?? null,
            'longitude' => $row['longitude'] ?? null,
            'deskripsi' => $row['deskripsi'] ?? null
        ]);

        if (isset($row['jumlah_penduduk']) || isset($row['luas_wilayah'])) {
            $wilayah->detail()->create([
                'jumlah_penduduk' => $row['jumlah_penduduk'] ?? 0,
                'luas_wilayah' => $row['luas_wilayah'] ?? 0
            ]);
        }

        return $wilayah;
    }

    public function rules(): array
    {
        return [
            'kode_wilayah' => 'required|unique:wilayah',
            'nama_wilayah' => 'required',
            'jenis' => 'required|in:provinsi,kabupaten,kecamatan,desa',
            'status' => 'required|in:aktif,nonaktif'
        ];
    }
} 