<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    /**
     * Tampilan Formulir Publik Pendaftaran Online
     */
    public function publicIndex()
    {
        return view('pendaftaran_publik');
    }

    /**
     * Simpan Permohonan Pendaftaran Publik
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_pendaftaran' => 'required|in:Baptis,Sidi,Pernikahan,Konseling,Permohonan Doa',
            'nama_lengkap' => 'required|string|max:255',
            'no_hp_wa' => 'required|string|max:30',
            'email' => 'nullable|email|max:255',
            'alamat' => 'required|string',
            'catatan_keterangan' => 'nullable|string',
        ]);

        $validated['status'] = 'Pending';

        Pendaftaran::create($validated);

        return redirect()->back()->with('success', 'Terima kasih! Formulir pendaftaran ' . $request->jenis_pendaftaran . ' Anda telah berhasil dikirim. Pengurus gereja akan menghubungi Anda.');
    }

    /**
     * Admin: Daftar Pendaftaran Online
     */
    public function adminIndex(Request $request)
    {
        $query = Pendaftaran::orderBy('created_at', 'desc');

        if ($request->filled('jenis')) {
            $query->where('jenis_pendaftaran', $request->jenis);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
                  ->orWhere('no_hp_wa', 'like', "%{$request->search}%")
                  ->orWhere('alamat', 'like', "%{$request->search}%");
            });
        }

        $pendaftarans = $query->paginate(15);
        return view('admin.pendaftaran.index', compact('pendaftarans'));
    }

    /**
     * Admin: Update Data Pendaftaran
     */
    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $validated = $request->validate([
            'jenis_pendaftaran' => 'required|in:Baptis,Sidi,Pernikahan,Konseling,Permohonan Doa',
            'nama_lengkap' => 'required|string|max:255',
            'no_hp_wa' => 'required|string|max:30',
            'email' => 'nullable|email|max:255',
            'alamat' => 'required|string',
            'catatan_keterangan' => 'nullable|string',
            'status' => 'required|in:Pending,Disetujui,Selesai,Ditolak',
        ]);

        $pendaftaran->update($validated);

        return redirect()->back()->with('success', 'Data pendaftaran berhasil diperbarui.');
    }

    /**
     * Admin: Update Status Pendaftaran Saja
     */
    public function updateStatus(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $request->validate([
            'status' => 'required|in:Pending,Disetujui,Selesai,Ditolak',
        ]);

        $pendaftaran->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    /**
     * Admin: Hapus Data Pendaftaran
     */
    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->delete();

        return redirect()->back()->with('success', 'Data pendaftaran berhasil dihapus.');
    }
}
