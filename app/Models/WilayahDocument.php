<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WilayahDocument extends Model
{
    protected $table = 'wilayah_documents';
    
    protected $fillable = [
        'wilayah_id',
        'nama_dokumen',
        'file_path',
        'tipe_dokumen',
        'deskripsi'
    ];

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }
} 