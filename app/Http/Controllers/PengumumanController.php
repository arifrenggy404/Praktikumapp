<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function publicIndex(Request $request)
    {
        $query = Pengumuman::orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', "%{$request->search}%")
                  ->orWhere('isi', 'like', "%{$request->search}%");
            });
        }

        $pengumumen = $query->paginate(10);
        return view('pengumuman_publik', compact('pengumumen'));
    }

    public function adminIndex()
    {
        $pengumumen = Pengumuman::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.pengumuman.index', compact('pengumumen'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'dibuat_oleh' => 'required|string|max:255',
        ]);

        $validated['tanggal_dibuat'] = now()->format('Y-m-d');

        Pengumuman::create($validated);

        return redirect()->back()->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'dibuat_oleh' => 'required|string|max:255',
        ]);

        $pengumuman->update($validated);

        return redirect()->back()->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();

        return redirect()->back()->with('success', 'Pengumuman berhasil dihapus.');
    }
}
