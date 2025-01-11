<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'wilayah_id',
        'judul',
        'isi',
        'kategori',
        'status'
    ];

    // Relasi ke user (petugas)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke wilayah
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }

    // Relasi ke lampiran
    public function lampiran()
    {
        return $this->hasMany(LaporanLampiran::class);
    }
} 