<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Penduduk;
use App\Models\Laporan;
use App\Models\WilayahDocument;

class PetugasController extends Controller
{
    public function dashboard()
    {
        $wilayah = Auth::user()->wilayah;
        
        // Jika petugas belum memiliki wilayah, tampilkan halaman khusus
        if (!$wilayah) {
            return view('petugas.no-wilayah');
        }

        $totalPenduduk = $wilayah->detail->jumlah_penduduk ?? 0;
        $luasWilayah = $wilayah->detail->luas_wilayah ?? 0;
        
        // Ambil aktivitas terbaru
        $recentActivities = ActivityLog::where('wilayah_id', $wilayah->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        return view('petugas.dashboard', compact('wilayah', 'totalPenduduk', 'luasWilayah', 'recentActivities'));
    }

    // Update method lain untuk redirect ke dashboard jika tidak ada wilayah
    private function checkWilayah()
    {
        if (!Auth::user()->wilayah) {
            return redirect()->route('petugas.dashboard');
        }
        return null;
    }

    public function editWilayah()
    {
        $wilayah = Auth::user()->wilayah;
        if (!$wilayah) {
            return back()->with('error', 'Anda belum ditugaskan ke wilayah manapun');
        }
        
        return view('petugas.wilayah.edit', compact('wilayah'));
    }

    public function updateWilayah(Request $request)
    {
        $wilayah = Auth::user()->wilayah;
        if (!$wilayah) {
            return back()->with('error', 'Anda belum ditugaskan ke wilayah manapun');
        }

        $validated = $request->validate([
            'jumlah_penduduk' => 'nullable|integer|min:0',
            'luas_wilayah' => 'nullable|numeric|min:0',
            'fasilitas' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Simpan data lama untuk log
        $oldValues = $wilayah->detail ? $wilayah->detail->toArray() : [];

        // Update detail wilayah
        $wilayah->detail()->updateOrCreate(
            ['wilayah_id' => $wilayah->id],
            $validated
        );

        // Catat aktivitas
        ActivityLog::create([
            'user_id' => Auth::id(),
            'wilayah_id' => $wilayah->id,
            'activity_type' => 'update',
            'description' => 'Memperbarui data wilayah',
            'old_values' => $oldValues,
            'new_values' => $wilayah->detail->toArray()
        ]);

        // Handle upload gambar
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('wilayah-images', 'public');
                $wilayah->documents()->create([
                    'nama_dokumen' => $image->getClientOriginalName(),
                    'file_path' => $path,
                    'tipe_dokumen' => 'foto'
                ]);
            }
        }

        return back()->with('success', 'Data wilayah berhasil diperbarui');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'petugas',
            ]);

            return redirect()->back()->with('success', 'Petugas berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan petugas: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('admin.petugas.create');
    }

    public function indexPenduduk()
    {
        if ($redirect = $this->checkWilayah()) {
            return $redirect;
        }

        $wilayah = Auth::user()->wilayah;
        $penduduk = Penduduk::where('wilayah_id', $wilayah->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('petugas.penduduk.index', compact('penduduk', 'wilayah'));
    }

    public function createPenduduk()
    {
        $wilayah = Auth::user()->wilayah;
        
        // Cek apakah petugas memiliki wilayah
        if (!$wilayah) {
            return redirect()->route('petugas.dashboard')
                ->with('error', 'Anda belum ditugaskan ke wilayah manapun. Silahkan hubungi admin.');
        }

        return view('petugas.penduduk.create', compact('wilayah'));
    }

    public function storePenduduk(Request $request)
    {
        $wilayah = Auth::user()->wilayah;
        
        // Cek apakah petugas memiliki wilayah
        if (!$wilayah) {
            return redirect()->route('petugas.dashboard')
                ->with('error', 'Anda belum ditugaskan ke wilayah manapun. Silahkan hubungi admin.');
        }

        $validated = $request->validate([
            'nik' => 'required|unique:penduduk,nik',
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'status' => 'nullable',
            'pekerjaan' => 'nullable',
            'kewarganegaraan' => 'nullable'
        ]);

        $validated['wilayah_id'] = $wilayah->id;

        try {
            Penduduk::create($validated);
            return redirect()->route('petugas.penduduk.index')
                ->with('success', 'Data penduduk berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan data penduduk: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function indexLaporan()
    {
        $wilayah = Auth::user()->wilayah;
        
        if (!$wilayah) {
            return redirect()->route('petugas.dashboard')
                ->with('error', 'Anda belum ditugaskan ke wilayah manapun. Silahkan hubungi admin.');
        }

        $laporan = Laporan::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('petugas.laporan.index', compact('laporan', 'wilayah'));
    }

    public function storeLaporan(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'kategori' => 'required',
            'lampiran.*' => 'nullable|file|max:2048'
        ]);

        $laporan = Laporan::create([
            'user_id' => Auth::id(),
            'wilayah_id' => Auth::user()->wilayah_id,
            'judul' => $validated['judul'],
            'isi' => $validated['isi'],
            'kategori' => $validated['kategori']
        ]);

        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $path = $file->store('laporan-lampiran', 'public');
                $laporan->lampiran()->create([
                    'file_path' => $path,
                    'nama_file' => $file->getClientOriginalName()
                ]);
            }
        }

        return redirect()->route('petugas.laporan.index')
            ->with('success', 'Laporan berhasil dibuat');
    }

    public function indexDokumen()
    {
        $wilayah = Auth::user()->wilayah;
        
        if (!$wilayah) {
            return redirect()->route('petugas.dashboard')
                ->with('error', 'Anda belum ditugaskan ke wilayah manapun. Silahkan hubungi admin.');
        }

        $dokumen = WilayahDocument::where('wilayah_id', $wilayah->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('petugas.dokumen.index', compact('dokumen', 'wilayah'));
    }

    public function storeDokumen(Request $request)
    {
        $validated = $request->validate([
            'nama_dokumen' => 'required',
            'file' => 'required|file|max:2048',
            'deskripsi' => 'nullable'
        ]);

        $path = $request->file('file')->store('wilayah-documents', 'public');

        WilayahDocument::create([
            'wilayah_id' => Auth::user()->wilayah_id,
            'nama_dokumen' => $validated['nama_dokumen'],
            'file_path' => $path,
            'deskripsi' => $validated['deskripsi'],
            'uploaded_by' => Auth::id()
        ]);

        return redirect()->route('petugas.dokumen.index')
            ->with('success', 'Dokumen berhasil diupload');
    }
} 