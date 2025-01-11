<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function index(Request $request)
    {
        $query = Wilayah::with(['parent', 'detail']);

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_wilayah', 'like', "%{$request->search}%")
                  ->orWhere('kode_wilayah', 'like', "%{$request->search}%");
            });
        }

        if ($request->jenis) {
            $query->where('jenis', $request->jenis);
        }

        $wilayah = $query->orderBy('jenis')
                        ->orderBy('nama_wilayah')
                        ->paginate(10);

        $jenisWilayah = [
            'provinsi' => 'Provinsi',
            'kabupaten' => 'Kabupaten',
            'kecamatan' => 'Kecamatan',
            'desa' => 'Desa'
        ];

        return view('wilayah.index', compact('wilayah', 'jenisWilayah'));
    }

    public function show($id)
    {
        $wilayah = Wilayah::with(['parent', 'detail', 'documents'])
                         ->where('status', 'aktif')
                         ->findOrFail($id);

        return view('wilayah.show', compact('wilayah'));
    }
} 