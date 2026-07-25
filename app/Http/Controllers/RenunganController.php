<?php

namespace App\Http\Controllers;

use App\Models\Renungan;
use Illuminate\Http\Request;

class RenunganController extends Controller
{
    public function publicIndex(Request $request)
    {
        $query = Renungan::orderBy('tanggal', 'desc');

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', "%{$request->search}%")
                  ->orWhere('pengkhotbah_penulis', 'like', "%{$request->search}%")
                  ->orWhere('isi', 'like', "%{$request->search}%");
            });
        }

        $renungans = $query->paginate(9);
        return view('renungan_publik', compact('renungans'));
    }

    public function adminIndex()
    {
        $renungans = Renungan::orderBy('tanggal', 'desc')->paginate(15);
        return view('admin.renungan.index', compact('renungans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'pengkhotbah_penulis' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'kategori' => 'required|in:Renungan Harian,Khotbah Minggu,Artikel',
            'isi' => 'required|string',
            'video_url' => 'nullable|url',
            'ayat_alkitab' => 'nullable|string|max:255',
        ]);

        Renungan::create($validated);

        return redirect()->back()->with('success', 'Renungan / Khotbah berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $renungan = Renungan::findOrFail($id);
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'pengkhotbah_penulis' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'kategori' => 'required|in:Renungan Harian,Khotbah Minggu,Artikel',
            'isi' => 'required|string',
            'video_url' => 'nullable|url',
            'ayat_alkitab' => 'nullable|string|max:255',
        ]);

        $renungan->update($validated);

        return redirect()->back()->with('success', 'Renungan / Khotbah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $renungan = Renungan::findOrFail($id);
        $renungan->delete();

        return redirect()->back()->with('success', 'Renungan berhasil dihapus.');
    }
}
