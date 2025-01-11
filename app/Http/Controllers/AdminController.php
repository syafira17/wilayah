<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LoginHistory;
use App\Models\Wilayah;
use App\Models\WilayahDetail;
use App\Models\WilayahDocument;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Exports\WilayahExport;
use App\Imports\WilayahImport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class AdminController extends Controller
{
    public function showPetugas()
    {
        $petugas = User::where('role', 'petugas')
            ->orderBy('created_at', 'desc')
            ->get();
        Log::info('Jumlah petugas yang ditemukan: ' . $petugas->count());
        return view('admin.petugas.index', compact('petugas'));
    }

    public function createPetugas()
    {
        $wilayah = Wilayah::where('status', 'aktif')
            ->where('jenis', 'kecamatan')
            ->orderBy('nama_wilayah')
            ->get();
        return view('admin.petugas.create', compact('wilayah'));
    }

    public function storePetugas(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'wilayah_id' => 'required|exists:wilayah,id',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'petugas',
                'wilayah_id' => $request->wilayah_id,
            ]);

            return redirect()->route('admin.petugas.index')
                ->with('success', 'Petugas berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan petugas: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function loginHistory()
    {
        $loginHistory = LoginHistory::with('user')
            ->orderBy('login_at', 'desc')
            ->get();
        return view('admin.login-history', compact('loginHistory'));
    }

    public function editPetugas($id)
    {
        $petugas = User::findOrFail($id);
        $wilayah = Wilayah::where('status', 'aktif')
            ->where('jenis', 'kecamatan')
            ->orderBy('nama_wilayah')
            ->get();
        return view('admin.petugas.edit', compact('petugas', 'wilayah'));
    }

    public function updatePetugas(Request $request, $id)
    {
        try {
            $petugas = User::findOrFail($id);
            
            $validated = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|min:8',
                'wilayah_id' => 'required|exists:wilayah,id',
            ]);

            $petugas->name = $validated['name'];
            $petugas->email = $validated['email'];
            $petugas->wilayah_id = $validated['wilayah_id'];
            
            if (!empty($validated['password'])) {
                $petugas->password = Hash::make($validated['password']);
            }

            $petugas->save();

            return redirect()->route('admin.petugas.index')
                ->with('success', 'Data petugas berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data.'])
                ->withInput();
        }
    }

    public function showDetailPetugas($id)
    {
        $petugas = User::findOrFail($id);
        $loginHistory = LoginHistory::where('user_id', $id)
            ->orderBy('login_at', 'desc')
            ->get();
        return view('admin.petugas.detail', compact('petugas', 'loginHistory'));
    }

    public function destroyPetugas($id)
    {
        try {
            $petugas = User::findOrFail($id);
            $petugas->delete();
            
            return redirect()->route('admin.petugas.index')
                ->with('success', 'Petugas berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error saat menghapus petugas: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus petugas.']);
        }
    }

    public function indexWilayah(Request $request)
    {
        $query = Wilayah::query();

        // Filter berdasarkan jenis
        if ($request->has('jenis') && $request->jenis != '') {
            $query->where('jenis', $request->jenis);
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Pencarian berdasarkan nama atau kode
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('nama_wilayah', 'like', '%'.$request->search.'%')
                  ->orWhere('kode_wilayah', 'like', '%'.$request->search.'%');
            });
        }

        $wilayah = $query->with('parent')
                         ->orderBy('created_at', 'desc')
                         ->paginate(10);

        $jenisWilayah = Wilayah::getJenisWilayah();
        
        return view('admin.wilayah.index', compact('wilayah', 'jenisWilayah'));
    }

    public function createWilayah()
    {
        try {
            $jenisWilayah = Wilayah::getJenisWilayah();
            $parentWilayah = Wilayah::orderBy('nama_wilayah')->get();
            return view('admin.wilayah.create', compact('jenisWilayah', 'parentWilayah'));
        } catch (\Exception $e) {
            Log::error('Error in createWilayah: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memuat form.']);
        }
    }

    public function storeWilayah(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_wilayah' => 'required|max:255',
                'kode_wilayah' => 'required|unique:wilayah',
                'jenis' => 'required|in:desa,kecamatan,kabupaten,provinsi',
                'parent_id' => 'nullable|exists:wilayah,id',
                'status' => 'required|in:aktif,nonaktif',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180',
                'jumlah_penduduk' => 'nullable|integer|min:0',
                'luas_wilayah' => 'nullable|numeric|min:0',
                'fasilitas' => 'nullable|string',
            ]);

            DB::beginTransaction();

            // Buat wilayah
            $wilayah = Wilayah::create([
                'nama_wilayah' => $validated['nama_wilayah'],
                'kode_wilayah' => $validated['kode_wilayah'],
                'jenis' => $validated['jenis'],
                'parent_id' => $validated['parent_id'],
                'status' => $validated['status'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ]);

            // Buat detail wilayah
            $wilayah->detail()->create([
                'jumlah_penduduk' => $validated['jumlah_penduduk'] ?? 0,
                'luas_wilayah' => $validated['luas_wilayah'] ?? 0,
                'fasilitas' => $validated['fasilitas'],
            ]);

            DB::commit();

            return redirect()->route('admin.wilayah.index')
                ->with('success', 'Wilayah berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function editWilayah($id)
    {
        $wilayah = Wilayah::findOrFail($id);
        return view('admin.wilayah.edit', compact('wilayah'));
    }

    public function updateWilayah(Request $request, $id)
    {
        try {
            $wilayah = Wilayah::findOrFail($id);
            $oldValues = $wilayah->toArray();
            
            $validated = $request->validate([
                'nama_wilayah' => 'required|string|max:255',
                'kode_wilayah' => 'required|string|max:50|unique:wilayah,kode_wilayah,'.$id,
                'jenis' => 'required|in:provinsi,kabupaten,kecamatan,desa',
                'parent_id' => 'nullable|exists:wilayah,id',
                'deskripsi' => 'nullable|string',
                'status' => 'required|in:aktif,nonaktif',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $wilayah->update($validated);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'wilayah_id' => $wilayah->id,
                'activity_type' => 'update',
                'description' => 'Mengupdate data wilayah ' . $wilayah->nama_wilayah,
                'old_values' => $oldValues,
                'new_values' => $wilayah->toArray(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);

            // Handle image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('wilayah-documents', 'public');
                    $wilayah->documents()->create([
                        'nama_dokumen' => $image->getClientOriginalName(),
                        'file_path' => $path,
                        'tipe_dokumen' => 'foto',
                        'deskripsi' => 'Foto wilayah ' . $wilayah->nama_wilayah
                    ]);

                    // Catat aktivitas upload gambar
                    ActivityLog::create([
                        'user_id' => auth()->id(),
                        'wilayah_id' => $wilayah->id,
                        'activity_type' => 'upload',
                        'description' => 'Mengunggah foto baru: ' . $image->getClientOriginalName()
                    ]);
                }
            }

            return redirect()->route('admin.wilayah.index')
                ->with('success', 'Wilayah berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error updating wilayah: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroyWilayah($id)
    {
        try {
            $wilayah = Wilayah::findOrFail($id);
            $wilayah->delete();
            
            ActivityLog::create([
                'user_id' => auth()->id(),
                'wilayah_id' => $wilayah->id,
                'activity_type' => 'delete',
                'description' => 'Menghapus wilayah: ' . $wilayah->nama_wilayah,
                'old_values' => $wilayah->toArray(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);

            return redirect()->route('admin.wilayah.index')
                ->with('success', 'Wilayah berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus wilayah.']);
        }
    }

    public function showWilayah($id)
    {
        $wilayah = Wilayah::findOrFail($id);
        return view('admin.wilayah.show', compact('wilayah'));
    }

    public function statistics()
    {
        // Data untuk pie chart kategori wilayah
        $wilayahByJenis = Wilayah::select('jenis', DB::raw('count(*) as total'))
            ->groupBy('jenis')
            ->get();

        // Data untuk bar chart status wilayah
        $wilayahByStatus = Wilayah::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // Data untuk tabel ringkasan
        $summary = [
            'total_wilayah' => Wilayah::count(),
            'wilayah_aktif' => Wilayah::where('status', 'aktif')->count(),
            'wilayah_nonaktif' => Wilayah::where('status', 'nonaktif')->count(),
            'provinsi' => Wilayah::where('jenis', 'provinsi')->count(),
            'kabupaten' => Wilayah::where('jenis', 'kabupaten')->count(),
            'kecamatan' => Wilayah::where('jenis', 'kecamatan')->count(),
            'desa' => Wilayah::where('jenis', 'desa')->count(),
        ];

        return view('admin.statistics', compact('wilayahByJenis', 'wilayahByStatus', 'summary'));
    }

    public function showMap()
    {
        $wilayah = Wilayah::all();
        return view('admin.wilayah.map', compact('wilayah'));
    }

    public function updateDetails(Request $request, $id)
    {
        $wilayah = Wilayah::findOrFail($id);
        
        $validated = $request->validate([
            'jumlah_penduduk' => 'nullable|integer|min:0',
            'luas_wilayah' => 'nullable|numeric|min:0',
            'fasilitas' => 'nullable|string'
        ]);

        $wilayah->detail()->updateOrCreate(
            ['wilayah_id' => $wilayah->id],
            $validated
        );

        return back()->with('success', 'Data pendukung berhasil diperbarui');
    }

    public function storeDocument(Request $request, $id)
    {
        $wilayah = Wilayah::findOrFail($id);
        
        $validated = $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'tipe_dokumen' => 'required|in:foto,dokumen',
            'file' => 'required|file|max:10240', // max 10MB
            'deskripsi' => 'nullable|string'
        ]);

        $path = $request->file('file')->store('wilayah-documents', 'public');

        $wilayah->documents()->create([
            'nama_dokumen' => $validated['nama_dokumen'],
            'tipe_dokumen' => $validated['tipe_dokumen'],
            'file_path' => $path,
            'deskripsi' => $validated['deskripsi']
        ]);

        return back()->with('success', 'File berhasil diupload');
    }

    public function destroyDocument($id)
    {
        $document = WilayahDocument::findOrFail($id);
        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return back()->with('success', 'File berhasil dihapus');
    }

    public function activityLogs(Request $request)
    {
        $query = ActivityLog::with(['user', 'wilayah']);

        if ($request->type) {
            $query->ofType($request->type);
        }

        if ($request->date) {
            $query->onDate($request->date);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.activity-logs', compact('logs'));
    }

    public function exportWilayah(Request $request)
    {
        $wilayah = Wilayah::with(['parent', 'detail'])->get();
        return view('admin.wilayah.export', compact('wilayah'));
    }

    public function indexUser(Request $request)
    {
        $query = User::query();

        // Filter pencarian
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        // Filter role
        if ($request->role) {
            $query->where('role', $request->role);
        }

        $users = $query->with('wilayah')
                       ->orderBy('created_at', 'desc')
                       ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $wilayah = Wilayah::where('status', 'aktif')->get();
        
        return view('admin.users.edit', compact('user', 'wilayah'));
    }

    public function updateUser(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'role' => 'required|in:admin,petugas,user',
                'wilayah_id' => 'nullable|required_if:role,petugas|exists:wilayah,id',
                'password' => 'nullable|min:8|confirmed',
            ]);

            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->role = $validated['role'];
            $user->wilayah_id = $validated['role'] === 'petugas' ? $validated['wilayah_id'] : null;

            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error saat update user: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data.'])
                ->withInput($request->except('password'));
        }
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus');
    }

    public function showUsers()
    {
        $users = User::where('role', 'user')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|confirmed'
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'user'
            ]);

            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Error saat membuat user: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }
} 