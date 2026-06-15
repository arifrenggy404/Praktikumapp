<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelayanan;
use App\Models\Jemaat;
use App\Models\Warta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class JadwalPelayananController extends Controller
{
    /**
     * Cetak Jadwal Pelayanan ke PDF
     */
    public function cetakPdf(Request $request)
    {
        $jadwals = JadwalPelayanan::with('pelayan')
            ->when($request->search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('nama_ibadah', 'like', "%{$search}%")
                      ->orWhere('lokasi_ibadah', 'like', "%{$search}%");
                });
            })
            ->orderBy('tanggal_waktu', 'asc')
            ->get();
        
        // Transform data untuk memudahkan tampilan di PDF
        $jadwals->transform(function($jadwal) {
            $dt = Carbon::parse($jadwal->tanggal_waktu);
            $jadwal->tanggal_ibadah = $dt->toDateString();
            $jadwal->jam_mulai = $dt->toTimeString();
            return $jadwal;
        });

        $pdf = Pdf::loadView('admin.jadwal.pdf', compact('jadwals'));
        return $pdf->download('laporan-jadwal-ibadah.pdf');
    }

    /**
     * 1. TAMPILKAN SEMUA JADWAL IBADAH
     */
    public function index(Request $request)
    {
        // Mengambil jadwal beserta data jemaat yang menjadi pelayan lewat relasi Many-to-Many
        $jadwals = JadwalPelayanan::with('pelayan')
            ->when($request->search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('nama_ibadah', 'like', "%{$search}%")
                      ->orWhere('lokasi_ibadah', 'like', "%{$search}%");
                });
            })
            ->orderBy('tanggal_waktu', 'asc')
            ->get();
            
        return view('admin.jadwal.index', compact('jadwals'));
    }

    /**
     * 2. TAMPILKAN FORM TAMBAH JADWAL
     */
    public function create()
    {
        // Mengambil hanya data jemaat yang terdaftar sebagai Pelayan Aktif
        $jemaats = Jemaat::with('pelayan')->whereHas('pelayan', function($q) {
            $q->where('is_aktif', true);
        })->orderBy('nama_lengkap', 'asc')->get();
        
        return view('admin.jadwal.create', compact('jemaats'));
    }

    /**
     * 3. SIMPAN JADWAL BARU DAN UPLOAD WARTA JEMAAT PDF
     */
    public function store(Request $request)
    {
        // Validasi input dengan pemisahan Tanggal dan Jam Mulai
        $request->validate([
            'nama_ibadah'   => 'required|string|max:100',
            'tanggal'       => 'required|date',
            'jam_mulai'     => 'required|date_format:H:i',
            'jam_selesai'   => 'nullable|date_format:H:i',
            'lokasi_ibadah' => 'required|string|max:255',
            'pelayan_id'    => 'required|exists:jemaats,id',
            'warta_digital' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // Rekombinasi Tanggal dan Jam Mulai menjadi format Datetime (Y-m-d H:i:s)
        $tanggalWaktu = $request->tanggal . ' ' . $request->jam_mulai . ':00';

        // Handler Proses Unggah File PDF Warta Jemaat
        $namaFileWarta = null;
        if ($request->hasFile('warta_digital')) {
            $file = $request->file('warta_digital');
            $namaFileWarta = 'warta-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('warta', $namaFileWarta, 'public');
        }

        // Simpan data utama jadwal
        $jadwal = JadwalPelayanan::create([
            'nama_ibadah'   => $request->nama_ibadah,
            'tanggal_waktu' => $tanggalWaktu,
            'jam_selesai'   => $request->jam_selesai,
            'lokasi_ibadah' => $request->lokasi_ibadah, 
            'semester'      => 'Jan-Jun 2026',
            'warta_digital' => $namaFileWarta,
        ]);

        // Simpan data plotting pelayan
        $jadwal->pelayan()->attach($request->pelayan_id, [
            'peran' => 'Pemimpin Ibadah'
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal pelayanan ibadah berhasil diterbitkan!');
    }

    /**
     * 4. TAMPILKAN FORM EDIT JADWAL
     */
    public function edit(string $id)
    {
        $jadwal = JadwalPelayanan::with('pelayan')->findOrFail($id);
        
        // Mengambil hanya data jemaat yang terdaftar sebagai Pelayan Aktif
        $jemaats = Jemaat::with('pelayan')->whereHas('pelayan', function($q) {
            $q->where('is_aktif', true);
        })->orderBy('nama_lengkap', 'asc')->get();

        return view('admin.jadwal.edit', compact('jadwal', 'jemaats'));
    }

    /**
     * 5. PERBARUI JADWAL DAN SINKRONISASI WARTA DIGITAL
     */
    public function update(Request $request, string $id)
    {
        $jadwal = JadwalPelayanan::findOrFail($id);

        // Validasi input
        $request->validate([
            'nama_ibadah'   => 'required|string|max:100',
            'tanggal'       => 'required|date',
            'jam_mulai'     => 'required|date_format:H:i',
            'jam_selesai'   => 'nullable|date_format:H:i',
            'lokasi_ibadah' => 'required|string|max:255',
            'pelayan_id'    => 'required|exists:jemaats,id',
            'warta_digital' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // Rekombinasi Tanggal dan Jam Mulai
        $tanggalWaktu = $request->tanggal . ' ' . $request->jam_mulai . ':00';

        // Penanganan File Warta
        $namaFileWarta = $jadwal->warta_digital;
        if ($request->hasFile('warta_digital')) {
            // Hapus file lama jika ada
            if ($jadwal->warta_digital) {
                Storage::disk('public')->delete('warta/' . $jadwal->warta_digital);
            }

            $file = $request->file('warta_digital');
            $namaFileWarta = 'warta-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('warta', $namaFileWarta, 'public');
        }

        // Update data utama jadwal
        $jadwal->update([
            'nama_ibadah'   => $request->nama_ibadah,
            'tanggal_waktu' => $tanggalWaktu,
            'jam_selesai'   => $request->jam_selesai,
            'lokasi_ibadah' => $request->lokasi_ibadah,
            'semester'      => 'Jan-Jun 2026',
            'warta_digital' => $namaFileWarta,
        ]);

        // Sinkronisasi data pada tabel pivot
        $jadwal->pelayan()->sync([
            $request->pelayan_id => ['peran' => 'Pemimpin Ibadah']
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal pelayanan berhasil diperbarui!');
    }

    /**
     * 6. HAPUS JADWAL IBADAH
     */
    public function destroy(string $id)
    {
        $jadwal = JadwalPelayanan::findOrFail($id);
        
        // Hapus file warta jika ada
        if ($jadwal->warta_digital) {
            Storage::disk('public')->delete('warta/' . $jadwal->warta_digital);
        }

        // Putus hubungan di tabel pivot pelayan_jadwals terlebih dahulu demi menjaga integritas relasi FK
        $jadwal->pelayan()->detach();
        
        // Hapus baris data utama dari tabel jadwal_pelayanans
        $jadwal->delete();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal pelayanan berhasil dihapus!');
    }
}
