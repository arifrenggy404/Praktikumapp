<?php

namespace App\Http\Controllers;

use App\Models\Pelayan;
use App\Models\Jemaat;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PelayanController extends Controller
{
    /**
     * Cetak Data Pelayan ke PDF
     */
    public function cetakPdf(Request $request)
    {
        $pelayans = Pelayan::with('jemaat')
            ->when($request->search, function($query, $search) {
                return $query->whereHas('jemaat', function($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%");
                });
            })
            ->orderBy('jabatan')
            ->get();
            
        $pdf = Pdf::loadView('admin.pelayan.pdf', compact('pelayans'));
        return $pdf->download('laporan-data-pelayan.pdf');
    }

    /**
     * Menampilkan daftar pelayan gereja.
     */
    public function index(Request $request)
    {
        $pelayans = Pelayan::with('jemaat')
            ->when($request->search, function($query, $search) {
                return $query->whereHas('jemaat', function($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%");
                });
            })
            ->orderBy('jabatan')
            ->get();
            
        return view('admin.pelayan.index', compact('pelayans'));
    }

    /**
     * Menampilkan form tambah pelayan.
     */
    public function create()
    {
        $jabatans = ['Pendeta', 'Vikaris', 'Penatua', 'Diaken', 'Majelis'];
        return view('admin.pelayan.create', compact('jabatans'));
    }

    /**
     * Menyimpan data pelayan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jemaat_id' => 'required|exists:jemaats,id',
            'jabatan' => 'required|in:Pendeta,Vikaris,Penatua,Diaken,Majelis',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'is_aktif' => 'boolean',
        ]);

        Pelayan::create($validated);

        return redirect()->route('pelayan.index')->with('success', 'Data Pelayan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit pelayan.
     */
    public function edit(Pelayan $pelayan)
    {
        $jabatans = ['Pendeta', 'Vikaris', 'Penatua', 'Diaken', 'Majelis'];
        return view('admin.pelayan.edit', compact('pelayan', 'jabatans'));
    }

    /**
     * Memperbarui data pelayan.
     */
    public function update(Request $request, Pelayan $pelayan)
    {
        $validated = $request->validate([
            'jemaat_id' => 'required|exists:jemaats,id',
            'jabatan' => 'required|in:Pendeta,Vikaris,Penatua,Diaken,Majelis',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'is_aktif' => 'required|boolean',
        ]);

        $pelayan->update($validated);

        return redirect()->route('pelayan.index')->with('success', 'Data Pelayan berhasil diperbarui.');
    }

    /**
     * Menghapus data pelayan.
     */
    public function destroy(Pelayan $pelayan)
    {
        $pelayan->delete();
        return redirect()->route('pelayan.index')->with('success', 'Data Pelayan berhasil dihapus.');
    }
}