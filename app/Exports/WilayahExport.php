<?php

namespace App\Exports;

use App\Models\Wilayah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class WilayahExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Wilayah::with(['parent', 'detail'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Kode Wilayah',
            'Nama Wilayah',
            'Jenis',
            'Parent Wilayah',
            'Status',
            'Jumlah Penduduk',
            'Luas Wilayah',
            'Latitude',
            'Longitude',
            'Deskripsi'
        ];
    }

    public function map($wilayah): array
    {
        return [
            $wilayah->id,
            $wilayah->kode_wilayah,
            $wilayah->nama_wilayah,
            ucfirst($wilayah->jenis),
            $wilayah->parent ? $wilayah->parent->nama_wilayah : '-',
            ucfirst($wilayah->status),
            $wilayah->detail ? $wilayah->detail->jumlah_penduduk : 0,
            $wilayah->detail ? $wilayah->detail->luas_wilayah : 0,
            $wilayah->latitude,
            $wilayah->longitude,
            $wilayah->deskripsi
        ];
    }
} 