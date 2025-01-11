<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;

    protected $table = 'penduduk';

    protected $fillable = [
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'rt',
        'rw',
        'wilayah_id',
        'status',
        'pekerjaan',
        'kewarganegaraan'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Relasi ke wilayah
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }
} 