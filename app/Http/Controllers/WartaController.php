<?php

namespace App\Http\Controllers;

use App\Models\Warta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class WartaController extends Controller
{
    /**
     * Cetak Daftar Warta ke PDF
     */
    public function cetakPdf(Request $request)
    {
        $wartas = Warta::when($request->search, function($query, $search) {
                return $query->where('judul', 'like', "%{$search}%");
            })
            ->orderBy('tanggal_terbit', 'desc')
            ->get();
        $pdf = Pdf::loadView('admin.warta.pdf', compact('wartas'));
        return $pdf->download('laporan-daftar-warta.pdf');
    }

    /**
     * Tampilkan daftar warta jemaat (Admin Area).
     */
    public function index(Request $request)
    {
        $wartas = Warta::when($request->search, function($query, $search) {
                return $query->where('judul', 'like', "%{$search}%");
            })
            ->orderBy('tanggal_terbit', 'desc')
            ->paginate(10);
        return view('admin.warta.index', compact('wartas'));
    }

    /**
     * Form tambah warta baru.
     */
    public function create()
    {
        return view('admin.warta.create');
    }

    /**
     * Simpan warta baru ke database & storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:150',
            'tanggal_terbit' => 'required|date',
            'file_warta' => 'required|file|mimes:pdf|max:2048', // Maksimal 2MB
        ], [
            'file_warta.max' => 'Ukuran file PDF terlalu besar! Maksimal adalah 2MB agar dapat diunduh oleh jemaat.',
            'file_warta.mimes' => 'Format file harus PDF.',
            'file_warta.required' => 'Silakan pilih file PDF warta yang akan diunggah.',
        ]);

        $file = $request->file('file_warta');
        
        // Debug: Log info file
        \Log::info("Upload Attempt: " . $file->getClientOriginalName());
        \Log::info("File Size: " . $file->getSize() . " bytes");
        \Log::info("File Error: " . $file->getError());

        if ($file->getSize() == 0) {
            return back()->withErrors(['file_warta' => 'File yang diunggah kosong atau corrupt (0 byte). Silakan coba lagi.'])->withInput();
        }

        $filename = 'warta-' . time() . '.' . $file->getClientOriginalExtension();
        $targetDir = storage_path('app/public/warta');
        
        // Pastikan direktori ada
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0775, true);
        }

        // Simpan menggunakan move() bawaan Symfony (lebih robust di beberapa env)
        $file->move($targetDir, $filename);
        
        $savedPath = $targetDir . '/' . $filename;
        $actualSize = file_exists($savedPath) ? filesize($savedPath) : -1;
        
        \Log::info("Manual Move Result - Size: " . $actualSize . " bytes");
        
        if ($actualSize <= 0 && $file->getSize() > 0) {
            \Log::error("CRITICAL: Manual move resulted in 0 bytes or failed!");
            return back()->withErrors(['file_warta' => 'Gagal menyimpan file ke server (0 byte). Silakan periksa izin folder storage.'])->withInput();
        }

        Warta::create([
            'judul' => $request->judul,
            'tanggal_terbit' => $request->tanggal_terbit,
            'file_path' => $filename,
        ]);

        return redirect()->route('warta.index')->with('success', 'Warta Jemaat berhasil diterbitkan!');
    }

    /**
     * Hapus warta jemaat.
     */
    public function destroy(Warta $wartum)
    {
        // Hapus file fisik
        if ($wartum->file_path) {
            Storage::disk('public')->delete('warta/' . $wartum->file_path);
        }

        $wartum->delete();

        return redirect()->route('warta.index')->with('success', 'Warta Jemaat berhasil dihapus!');
    }

    /**
     * HALAMAN PUBLIK: Daftar warta untuk jemaat unduh.
     */
    public function publicIndex(Request $request)
    {
        $wartas = Warta::when($request->search, function($query, $search) {
                return $query->where('judul', 'like', "%{$search}%");
            })
            ->orderBy('tanggal_terbit', 'desc')
            ->paginate(12);
        return view('warta_publik', compact('wartas'));
    }
}
