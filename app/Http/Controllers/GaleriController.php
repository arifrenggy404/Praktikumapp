<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function publicIndex(Request $request)
    {
        $query = Galeri::orderBy('tanggal_kegiatan', 'desc');

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $galeris = $query->paginate(12);
        return view('galeri_publik', compact('galeris'));
    }

    public function adminIndex()
    {
        $galeris = Galeri::orderBy('tanggal_kegiatan', 'desc')->paginate(15);
        return view('admin.galeri.index', compact('galeris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:Natal,Paskah,Bakti Sosial,Ibadah,Pemuda,Lainnya',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'deskripsi' => 'nullable|string',
            'tanggal_kegiatan' => 'required|date',
        ]);

        $path = $request->file('gambar')->store('galeri', 'public');

        Galeri::create([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'gambar' => $path,
            'deskripsi' => $request->deskripsi,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
        ]);

        return redirect()->back()->with('success', 'Foto kegiatan berhasil ditambahkan ke Galeri.');
    }

    public function update(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:Natal,Paskah,Bakti Sosial,Ibadah,Pemuda,Lainnya',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'deskripsi' => 'nullable|string',
            'tanggal_kegiatan' => 'required|date',
        ]);

        $data = [
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
        ];

        if ($request->hasFile('gambar')) {
            if ($galeri->gambar && Storage::disk('public')->exists($galeri->gambar)) {
                Storage::disk('public')->delete($galeri->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('galeri', 'public');
        }

        $galeri->update($data);

        return redirect()->back()->with('success', 'Foto galeri berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);
        if ($galeri->gambar && Storage::disk('public')->exists($galeri->gambar)) {
            Storage::disk('public')->delete($galeri->gambar);
        }
        $galeri->delete();

        return redirect()->back()->with('success', 'Foto galeri berhasil dihapus.');
    }
}
