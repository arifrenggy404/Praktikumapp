<?php

namespace Database\Seeders;

use App\Models\Jemaat;
use App\Models\KartuKeluarga;
use App\Models\Pelayan;
use App\Models\Inventaris;
use App\Models\KondisiBarang;
use App\Models\JadwalPelayanan;
use App\Models\PelayanJadwal;
use App\Models\Warta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Kartu Keluarga
        $kk1 = KartuKeluarga::create(['no_kk_gereja' => 'KK-001', 'kepala_keluarga_id' => null]);
        $kk2 = KartuKeluarga::create(['no_kk_gereja' => 'KK-002', 'kepala_keluarga_id' => null]);
        $kk3 = KartuKeluarga::create(['no_kk_gereja' => 'KK-003', 'kepala_keluarga_id' => null]);

        // 2. JEMAAT KELUARGA 1 (Bpk. Yohanes)
        $j1 = Jemaat::create([
            'kartu_keluarga_id' => $kk1->id,
            'nama_lengkap' => 'Bpk. Yohanes Sumba',
            'jenis_kelamin' => 'Laki-laki',
            'peran_keluarga' => 'Kepala Keluarga (Ayah)',
            'tempat_lahir' => 'Waingapu',
            'tanggal_lahir' => '1970-05-10',
            'alamat_domisili' => 'Kandara RT 01',
            'no_hp' => '081234567891',
            'status_baptis' => 'Sudah',
            'status_sidi' => 'Sudah',
        ]);
        
        $j2 = Jemaat::create([
            'kartu_keluarga_id' => $kk1->id,
            'nama_lengkap' => 'Ibu Maria Sumba',
            'jenis_kelamin' => 'Perempuan',
            'peran_keluarga' => 'Istri (Ibu)',
            'tempat_lahir' => 'Lewa',
            'tanggal_lahir' => '1975-08-20',
            'alamat_domisili' => 'Kandara RT 01',
            'no_hp' => '081234567892',
            'status_baptis' => 'Sudah',
            'status_sidi' => 'Sudah',
        ]);

        $j3 = Jemaat::create([
            'kartu_keluarga_id' => $kk1->id,
            'nama_lengkap' => 'Daniel Sumba',
            'jenis_kelamin' => 'Laki-laki',
            'peran_keluarga' => 'Anak',
            'tempat_lahir' => 'Waingapu',
            'tanggal_lahir' => '2005-03-15',
            'alamat_domisili' => 'Kandara RT 01',
            'status_baptis' => 'Sudah',
            'status_sidi' => 'Sudah',
            'nama_orang_tua' => 'Bpk. Yohanes & Ibu Maria',
        ]);

        $j4 = Jemaat::create([
            'kartu_keluarga_id' => $kk1->id,
            'nama_lengkap' => 'Grace Sumba',
            'jenis_kelamin' => 'Perempuan',
            'peran_keluarga' => 'Anak',
            'tempat_lahir' => 'Waingapu',
            'tanggal_lahir' => '2012-07-22',
            'alamat_domisili' => 'Kandara RT 01',
            'status_baptis' => 'Sudah',
            'status_sidi' => 'Belum',
            'nama_orang_tua' => 'Bpk. Yohanes & Ibu Maria',
        ]);

        // JEMAAT KELUARGA 2 (Pdt. Andreas)
        $j5 = Jemaat::create([
            'kartu_keluarga_id' => $kk2->id,
            'nama_lengkap' => 'Pdt. Andreas, S.Th',
            'jenis_kelamin' => 'Laki-laki',
            'peran_keluarga' => 'Kepala Keluarga (Ayah)',
            'tempat_lahir' => 'Kupang',
            'tanggal_lahir' => '1980-12-12',
            'alamat_domisili' => 'Pastori GKS Kandara',
            'no_hp' => '081234567890',
            'status_baptis' => 'Sudah',
            'status_sidi' => 'Sudah',
        ]);

        $j6 = Jemaat::create([
            'kartu_keluarga_id' => $kk2->id,
            'nama_lengkap' => 'Ibu Martha Andreas',
            'jenis_kelamin' => 'Perempuan',
            'peran_keluarga' => 'Istri (Ibu)',
            'tempat_lahir' => 'Waingapu',
            'tanggal_lahir' => '1984-04-18',
            'alamat_domisili' => 'Pastori GKS Kandara',
            'status_baptis' => 'Sudah',
            'status_sidi' => 'Sudah',
        ]);

        $j7 = Jemaat::create([
            'kartu_keluarga_id' => $kk2->id,
            'nama_lengkap' => 'Timotius Andreas',
            'jenis_kelamin' => 'Laki-laki',
            'peran_keluarga' => 'Anak',
            'tempat_lahir' => 'Kupang',
            'tanggal_lahir' => '2010-09-09',
            'alamat_domisili' => 'Pastori GKS Kandara',
            'status_baptis' => 'Sudah',
            'status_sidi' => 'Belum',
            'nama_orang_tua' => 'Pdt. Andreas & Ibu Martha',
        ]);

        // JEMAAT KELUARGA 3 (Bpk. Markus)
        $j8 = Jemaat::create([
            'kartu_keluarga_id' => $kk3->id,
            'nama_lengkap' => 'Bpk. Markus Kambera',
            'jenis_kelamin' => 'Laki-laki',
            'peran_keluarga' => 'Kepala Keluarga (Ayah)',
            'tempat_lahir' => 'Melolo',
            'tanggal_lahir' => '1978-01-05',
            'alamat_domisili' => 'Kandara RT 03',
            'no_hp' => '081234567893',
            'status_baptis' => 'Sudah',
            'status_sidi' => 'Sudah',
        ]);

        $j9 = Jemaat::create([
            'kartu_keluarga_id' => $kk3->id,
            'nama_lengkap' => 'Ibu Ruth Kambera',
            'jenis_kelamin' => 'Perempuan',
            'peran_keluarga' => 'Istri (Ibu)',
            'tempat_lahir' => 'Waingapu',
            'tanggal_lahir' => '1981-11-25',
            'alamat_domisili' => 'Kandara RT 03',
            'status_baptis' => 'Sudah',
            'status_sidi' => 'Sudah',
        ]);

        $j10 = Jemaat::create([
            'kartu_keluarga_id' => $kk3->id,
            'nama_lengkap' => 'Sarah Kambera',
            'jenis_kelamin' => 'Perempuan',
            'peran_keluarga' => 'Anak',
            'tempat_lahir' => 'Waingapu',
            'tanggal_lahir' => '2015-06-30',
            'alamat_domisili' => 'Kandara RT 03',
            'status_baptis' => 'Sudah',
            'status_sidi' => 'Belum',
            'nama_orang_tua' => 'Bpk. Markus & Ibu Ruth',
        ]);

        // Update Kepala Keluarga ID
        $kk1->update(['kepala_keluarga_id' => $j1->id]);
        $kk2->update(['kepala_keluarga_id' => $j5->id]);
        $kk3->update(['kepala_keluarga_id' => $j8->id]);

        // 3. Pelayan
        Pelayan::create([
            'jemaat_id' => $j5->id,
            'jabatan' => 'Pendeta',
            'tanggal_mulai' => '2020-01-01',
            'is_aktif' => true,
        ]);

        Pelayan::create([
            'jemaat_id' => $j1->id,
            'jabatan' => 'Penatua',
            'tanggal_mulai' => '2022-06-01',
            'is_aktif' => true,
        ]);

        // 4. Inventaris
        $kondisiBagus = DB::table('kondisi_barangs')->where('nama_kondisi', 'Bagus')->first()->id;
        
        Inventaris::create([
            'nama_barang' => 'Kursi Plastik',
            'jumlah_kuantitas' => 100,
            'kondisi_id' => $kondisiBagus,
        ]);

        // 5. Jadwal Pelayanan
        $jadwal1 = JadwalPelayanan::create([
            'nama_ibadah' => 'Ibadah Minggu Pagi',
            'semester' => 'Ganjil 2026',
            'tanggal_waktu' => '2026-06-14 06:00:00',
            'lokasi_ibadah' => 'Gedung Gereja Utama',
        ]);

        // 6. Pelayan Jadwal
        PelayanJadwal::create([
            'jadwal_id' => $jadwal1->id,
            'jemaat_id' => $j5->id,
            'peran' => 'Pengkhotbah',
        ]);

        // 7. Warta
        Warta::create([
            'judul' => 'Warta Jemaat Minggu II Juni 2026',
            'tanggal_terbit' => '2026-06-08',
            'file_path' => 'warta_dummy.pdf',
        ]);

        // 8. Pengumuman Dummy
        \App\Models\Pengumuman::create([
            'judul' => 'Pelaksanaan Ibadah Padang Pemuda & PAR',
            'isi' => 'Diberitahukan kepada seluruh jemaat bahwa pada hari Sabtu mendatang akan diadakan Ibadah Padang gabungan PAR dan PERMATA bertempat di Pantai Walakiri.',
            'tanggal_dibuat' => date('Y-m-d'),
            'dibuat_oleh' => 'Majelis Jemaat',
        ]);

        // 9. Renungan Dummy
        \App\Models\Renungan::create([
            'judul' => 'Setia dalam Perkara Kecil',
            'pengkhotbah_penulis' => 'Pdt. Andreas, S.Th',
            'tanggal' => date('Y-m-d'),
            'kategori' => 'Khotbah Minggu',
            'isi' => 'Tuhan menghargai setiap kesetiaan kita dalam tugas pelayanan sehari-hari...',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'ayat_alkitab' => 'Matius 25:21',
        ]);

        // 10. Galeri Dummy
        \App\Models\Galeri::create([
            'judul' => 'Dokumentasi Perayaan Paskah Jemaat',
            'kategori' => 'Paskah',
            'gambar' => 'https://images.unsplash.com/photo-1548625149-fc4a29cf7092?w=800&auto=format&fit=crop',
            'deskripsi' => 'Sukacita peribadatan Paskah bersama seluruh warga jemaat.',
            'tanggal_kegiatan' => date('Y-m-d'),
        ]);

        // 11. Pendaftaran Dummy
        \App\Models\Pendaftaran::create([
            'jenis_pendaftaran' => 'Baptis',
            'nama_lengkap' => 'Gabriel Sumba',
            'no_hp_wa' => '081234567890',
            'email' => 'gabriel@example.com',
            'alamat' => 'Kandara RT 02',
            'catatan_keterangan' => 'Pendaftaran Baptis Kudus Anak',
            'status' => 'Pending',
        ]);

        // 12. Pengaturan Web Default
        \App\Models\PengaturanWeb::create([
            'nama_gereja' => 'Gereja Kristen Sumba Jemaat Kandara',
            'singkatan_gereja' => 'GKS Kandara',
            'tagline_gereja' => 'Bertumbuh dalam Iman, Teguh dalam Pengharapan, dan Melayanan dalam Kasih',
            'sambutan_nama' => 'Pdt. Andreas, S.Th',
            'sambutan_jabatan' => 'Pendeta Jemaat GKS Kandara',
            'sambutan_teks' => 'Salam sejahtera dalam kasih Tuhan kita Yesus Kristus. Selamat datang di portal resmi GKS Jemaat Kandara.',
            'ayat_emas_teks' => 'Sebab di mana dua atau tiga orang berkumpul dalam Nama-Ku, di situ Aku ada di tengah-tengah mereka.',
            'ayat_emas_kitab' => 'Matius 18:20',
            'sejarah_gereja' => 'Gereja Kristen Sumba Jemaat Kandara tumbuh berawal dari pos pelayanan persekutuan doa warga jemaat di wilayah Kandara.',
            'visi_gereja' => 'Menjadi Jemaat yang Mandiri, Misionaris, dan Berakar dalam Kasih Kristus.',
            'misi_gereja' => "1. Koinonia: Membina persekutuan jemaat.\n2. Marturia: Menyaksikan Injil Kristus.\n3. Diakonia: Menjalankan pelayanan kasih.",
            'alamat_gereja' => 'Jl. Kandara, Kelurahan Kandara, Waingapu, Kab. Sumba Timur, Nusa Tenggara Timur.',
            'no_wa_gereja' => '081234567890',
            'email_gereja' => 'info@gkskandara.or.id',
            'pj_komisi_anak' => 'Ibu Maria & Tim Guru SM',
            'pj_komisi_pemuda' => 'Bpk. Yohanes & Pengurus Pemuda',
            'pj_komisi_wanita' => 'Ibu Martha & Pengurus PW',
            'pj_komisi_lansia' => 'Penatua Pendamping Lansia',
        ]);
    }
}
