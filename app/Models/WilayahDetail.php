<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WilayahDetail extends Model
{
    protected $table = 'wilayah_details';
    
    protected $fillable = [
        'wilayah_id',
        'jumlah_penduduk',
        'luas_wilayah',
        'fasilitas'
    ];

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }
} 