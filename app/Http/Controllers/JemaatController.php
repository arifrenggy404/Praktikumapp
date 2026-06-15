<?php

namespace App\Http\Controllers;

use App\Models\Jemaat;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class JemaatController extends Controller
{
    /**
     * Cetak Data Jemaat ke PDF
     */
    public function cetakPdf(Request $request)
    {
        $query = Jemaat::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('alamat_domisili', 'like', "%{$search}%");
            });
        }

        $jemaats = $query->orderBy('nama_lengkap', 'asc')->get();
        $pdf = Pdf::loadView('admin.jemaat.pdf', compact('jemaats'));
        return $pdf->download('laporan-data-jemaat.pdf');
    }

    // 1. TAMPILKAN SEMUA DATA JEMAAT
    public function index(Request $request)
    {
        $query = Jemaat::query();

        // Fitur Pencarian Nama atau Alamat
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('alamat_domisili', 'like', "%{$search}%");
            });
        }

        $jemaats = $query->orderBy('nama_lengkap', 'asc')->paginate(15);
        return view('admin.jemaat.index', compact('jemaats'));
    }

    // 2. TAMPILKAN FORM TAMBAH JEMAAT
    public function create()
    {
        return view('admin.jemaat.create');
    }

    // 3. SIMPAN DATA JEMAAT BARU KE DATABASE
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kartu_keluarga_id' => 'nullable|exists:kartu_keluargas,id',
            'nama_lengkap'    => 'required|string|max:255',
            'jenis_kelamin'   => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'    => 'required|string|max:100',
            'tanggal_lahir'   => 'required|date',
            'alamat_domisili' => 'required|string',
            'no_hp'           => 'nullable|string|max:15',
            'status_baptis'   => 'required|in:Sudah,Belum',
            'status_sidi'     => 'required|in:Sudah,Belum',
            'tanggal_baptis'  => 'nullable|date',
            'tanggal_sidi'    => 'nullable|date',
            'nama_orang_tua'  => 'nullable|string|max:255',
        ]);

        Jemaat::create($validated);

        return redirect()->route('jemaat.index')->with('success', 'Data jemaat berhasil ditambahkan!');
    }

    // 4. TAMPILKAN FORM EDIT DATA JEMAAT
    public function edit(string $id)
    {
        $jemaat = Jemaat::findOrFail($id);
        return view('admin.jemaat.edit', compact('jemaat'));
    }

    // 5. PERBARUI DATA JEMAAT DI DATABASE
    public function update(Request $request, string $id)
    {
        $jemaat = Jemaat::findOrFail($id);

        $validated = $request->validate([
            'kartu_keluarga_id' => 'nullable|exists:kartu_keluargas,id',
            'nama_lengkap'    => 'required|string|max:255',
            'jenis_kelamin'   => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'    => 'required|string|max:100',
            'tanggal_lahir'   => 'required|date',
            'alamat_domisili' => 'required|string',
            'no_hp'           => 'nullable|string|max:15',
            'status_baptis'   => 'required|in:Sudah,Belum',
            'status_sidi'     => 'required|in:Sudah,Belum',
            'tanggal_baptis'  => 'nullable|date',
            'tanggal_sidi'    => 'nullable|date',
            'nama_orang_tua'  => 'nullable|string|max:255',
        ]);

        $jemaat->update($validated);

        return redirect()->route('jemaat.index')->with('success', 'Data jemaat berhasil diperbarui!');
    }

    // 6. HAPUS DATA JEMAAT DARI DATABASE
    public function destroy(string $id)
    {
        $jemaat = Jemaat::findOrFail($id);
        $jemaat->delete();

        return redirect()->route('jemaat.index')->with('success', 'Data jemaat berhasil dihapus!');
    }

    /**
     * API untuk pencarian jemaat (Select2 AJAX)
     */
    public function search(Request $request)
    {
        $search = $request->get('q');
        
        // Debug: Cek koneksi dan jumlah total
        \Log::info('Search Query: ' . $search);
        \Log::info('DB Connection: ' . \DB::getDefaultConnection());
        \Log::info('Total in DB: ' . Jemaat::count());

        $jemaats = Jemaat::where('nama_lengkap', 'LIKE', "%$search%")
            ->select('id', 'nama_lengkap as text')
            ->limit(10)
            ->get();

        return response()->json($jemaats);
    }
}