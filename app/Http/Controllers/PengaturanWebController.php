<?php

namespace App\Http\Controllers;

use App\Models\PengaturanWeb;
use Illuminate\Http\Request;

class PengaturanWebController extends Controller
{
    /**
     * Tampilan Pengaturan Web di Admin
     */
    public function index()
    {
        $setting = PengaturanWeb::first();
        if (!$setting) {
            $setting = PengaturanWeb::create([
                'nama_gereja' => 'Gereja Kristen Sumba Jemaat Kandara',
                'singkatan_gereja' => 'GKS Kandara',
                'tagline_gereja' => 'Bertumbuh dalam Iman, Teguh dalam Pengharapan, dan Melayani dalam Kasih',
                'sambutan_nama' => 'Pdt. Andreas, S.Th',
                'sambutan_jabatan' => 'Pendeta Jemaat GKS Kandara',
                'sambutan_teks' => 'Selamat datang di portal resmi GKS Jemaat Kandara.',
                'ayat_emas_teks' => 'Sebab di mana dua atau tiga orang berkumpul dalam Nama-Ku, di situ Aku ada di tengah-tengah mereka.',
                'ayat_emas_kitab' => 'Matius 18:20',
                'sejarah_gereja' => 'Sejarah GKS Kandara.',
                'visi_gereja' => 'Menjadi Jemaat Mandiri.',
                'misi_gereja' => 'Melayani dengan Kasih.',
                'alamat_gereja' => 'Jl. Kandara, Waingapu, Sumba Timur.',
                'no_wa_gereja' => '081234567890',
                'email_gereja' => 'info@gkskandara.or.id',
            ]);
        }

        return view('admin.pengaturan.index', compact('setting'));
    }

    /**
     * Simpan / Update Pengaturan Web dari Admin
     */
    public function update(Request $request)
    {
        $setting = PengaturanWeb::first();
        if (!$setting) {
            $setting = new PengaturanWeb();
        }

        $validated = $request->validate([
            'nama_gereja' => 'required|string|max:255',
            'singkatan_gereja' => 'required|string|max:100',
            'tagline_gereja' => 'required|string|max:255',
            'beranda_bg_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
            'sambutan_nama' => 'required|string|max:255',
            'sambutan_jabatan' => 'required|string|max:255',
            'sambutan_teks' => 'required|string',
            'ayat_emas_teks' => 'required|string',
            'ayat_emas_kitab' => 'required|string|max:255',
            'sejarah_gereja' => 'required|string',
            'visi_gereja' => 'required|string',
            'misi_gereja' => 'required|string',
            'alamat_gereja' => 'required|string',
            'no_wa_gereja' => 'required|string|max:50',
            'email_gereja' => 'required|email|max:255',
            'maps_embed_url' => 'nullable|string',
            'pj_komisi_anak' => 'required|string|max:255',
            'pj_komisi_pemuda' => 'required|string|max:255',
            'pj_komisi_wanita' => 'required|string|max:255',
            'pj_komisi_lansia' => 'required|string|max:255',
            'sambutan_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('beranda_bg_foto')) {
            $validated['beranda_bg_foto'] = $request->file('beranda_bg_foto')->store('pengaturan', 'public');
        }

        if ($request->hasFile('sambutan_foto')) {
            $validated['sambutan_foto'] = $request->file('sambutan_foto')->store('pengaturan', 'public');
        }

        $setting->fill($validated)->save();

        return redirect()->back()->with('success', 'Pengaturan nama gereja, foto background, & konten website berhasil diperbarui.');
    }
}
