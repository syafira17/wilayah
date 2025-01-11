<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    protected $table = 'wilayah';
    
    protected $fillable = [
        'kode_wilayah',
        'nama_wilayah',
        'jenis',
        'parent_id',
        'status'
    ];

    public function parent()
    {
        return $this->belongsTo(Wilayah::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Wilayah::class, 'parent_id');
    }

    public static function getJenisWilayah()
    {
        return [
            'provinsi' => 'Provinsi',
            'kabupaten' => 'Kabupaten',
            'kecamatan' => 'Kecamatan',
            'desa' => 'Desa'
        ];
    }

    public function detail()
    {
        return $this->hasOne(WilayahDetail::class);
    }

    public function documents()
    {
        return $this->hasMany(WilayahDocument::class);
    }
}