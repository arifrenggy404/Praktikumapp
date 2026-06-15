<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class InventarisController extends Controller
{
    /**
     * Cetak Data Inventaris ke PDF
     */
    public function cetakPdf(Request $request)
    {
        $inventaris = Inventaris::with('kondisi')
            ->when($request->search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('nama_barang', 'like', "%{$search}%");
                });
            })
            ->orderBy('nama_barang', 'asc')
            ->get();
            
        $pdf = Pdf::loadView('admin.inventaris.pdf', compact('inventaris'));
        return $pdf->download('laporan-inventaris-aset.pdf');
    }

    /**
     * 1. TAMPILKAN SEMUA DATA INVENTARIS
     */
    public function index(Request $request)
    {
        $assets = Inventaris::with('kondisi')
            ->when($request->search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('nama_barang', 'like', "%{$search}%");
                });
            })
            ->orderBy('nama_barang', 'asc')
            ->get();

        return view('admin.inventaris.index', compact('assets'));
    }

    /**
     * 2. TAMPILKAN FORM TAMBAH BARANG
     */
    public function create()
    {
        // Mengambil master data kondisi untuk opsi dropdown di form
        $kondisis = DB::table('kondisi_barangs')->get();
        return view('admin.inventaris.create', compact('kondisis'));
    }

    /**
     * 3. SIMPAN BARANG BARU KE DATABASE
     */
    public function store(Request $request)
    {
        // Validasi disesuaikan dengan skema tabel inventaris Anda
        $request->validate([
            'nama_barang'      => 'required|string|max:150', // Sesuai string(150)
            'jumlah_kuantitas' => 'required|integer|min:1',
            'kondisi_id'       => 'required|exists:kondisi_barangs,id', // Validasi ke tabel kondisi_barangs
        ]);

        // Proses penyimpanan data menggunakan Eloquent
        Inventaris::create([
            'nama_barang'      => $request->nama_barang,
            'jumlah_kuantitas' => $request->jumlah_kuantitas, 
            'kondisi_id'       => $request->kondisi_id, // Menyimpan ID relasi kondisi
        ]);

        return redirect()->route('inventaris.index')->with('success', 'Aset inventaris baru berhasil dicatat!');
    }

    /**
     * 4. TAMPILKAN FORM EDIT BARANG
     */
    public function edit(string $id)
    {
        $asset = Inventaris::findOrFail($id);
        $kondisis = DB::table('kondisi_barangs')->get();
        return view('admin.inventaris.edit', compact('asset', 'kondisis'));
    }

    /**
     * 5. PERBARUI DATA BARANG DI DATABASE
     */
    public function update(Request $request, string $id)
    {
        $asset = Inventaris::findOrFail($id);

        $request->validate([
            'nama_barang'      => 'required|string|max:150',
            'jumlah_kuantitas' => 'required|integer|min:1',
            'kondisi_id'       => 'required|exists:kondisi_barangs,id',
        ]);

        $asset->update([
            'nama_barang'      => $request->nama_barang,
            'jumlah_kuantitas' => $request->jumlah_kuantitas,
            'kondisi_id'       => $request->kondisi_id,
        ]);

        return redirect()->route('inventaris.index')->with('success', 'Data inventaris berhasil diperbarui!');
    }

    /**
     * 6. HAPUS DATA BARANG DARI DATABASE
     */
    public function destroy(string $id)
    {
        $asset = Inventaris::findOrFail($id);
        $asset->delete();

        return redirect()->route('inventaris.index')->with('success', 'Aset inventaris berhasil dihapus!');
    }
}