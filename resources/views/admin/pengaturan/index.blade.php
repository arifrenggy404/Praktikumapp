@extends('layouts.admin')

@section('title', 'Pengaturan Tampilan Web & Profil Gereja')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1"><i class="fas fa-cog text-primary me-2"></i> Pengaturan Konten Web & Akun Admin</h3>
        <p class="text-muted small mb-0">Ubah nama admin, username, password, nama gereja, foto background beranda, teks sambutan, dan kontak WA secara dinamis.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i> {{ $errors->first() }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- FORM PENGUBAHAN AKUN & NAMA ADMIN LOGIN -->
<div class="card border-0 shadow-sm rounded-4 mb-4 border-start border-5 border-danger">
    <div class="card-header bg-white py-3">
        <h5 class="fw-bold text-danger mb-0"><i class="fas fa-user-shield me-2"></i> Pengubahan Nama, Username, & Password Admin</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.profil.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted mb-1">NAMA PETUGAS ADMIN <span class="text-danger">*</span></label>
                    <input type="text" name="nama_admin" value="{{ old('nama_admin', Auth::user()->jemaat->nama_lengkap ?? 'Martina Pauwila') }}" class="form-control" required placeholder="Contoh: Martina Pauwila">
                    <small class="text-muted">Nama ini akan tampil di bagian samping menu sidebar admin.</small>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted mb-1">USERNAME LOGIN <span class="text-danger">*</span></label>
                    <input type="text" name="username" value="{{ old('username', Auth::user()->username ?? 'admin') }}" class="form-control" required>
                    <small class="text-muted">Username untuk masuk ke dashboard admin.</small>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted mb-1">PASSWORD LAMA <span class="text-danger">*</span></label>
                    <input type="password" name="password_lama" class="form-control" placeholder="Masukkan password saat ini" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small text-muted mb-1">PASSWORD BARU (OPSIONAL)</label>
                    <input type="password" name="password_baru" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small text-muted mb-1">KONFIRMASI PASSWORD BARU</label>
                    <input type="password" name="password_baru_confirmation" class="form-control" placeholder="Ulangi password baru">
                </div>
                <div class="col-12 text-end mt-3">
                    <button type="submit" class="btn btn-danger fw-bold rounded-3 px-4">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan Profil Admin
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<form action="{{ route('admin.pengaturan.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <!-- 1. IDENTITAS GEREJA & FOTO BACKGROUND BERANDA -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold text-primary mb-0"><i class="fas fa-church me-2 text-warning"></i> Identitas Nama & Foto Background</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap Gereja <span class="text-danger">*</span></label>
                        <input type="text" name="nama_gereja" value="{{ old('nama_gereja', $setting->nama_gereja ?? '') }}" class="form-control" placeholder="Contoh: Gereja Kristen Sumba Jemaat Kandara" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Singkatan / Nama Singkat Gereja <span class="text-danger">*</span></label>
                        <input type="text" name="singkatan_gereja" value="{{ old('singkatan_gereja', $setting->singkatan_gereja ?? '') }}" class="form-control" placeholder="Contoh: GKS Kandara" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tagline / Motto Gereja <span class="text-danger">*</span></label>
                        <input type="text" name="tagline_gereja" value="{{ old('tagline_gereja', $setting->tagline_gereja ?? '') }}" class="form-control" placeholder="Contoh: Bertumbuh dalam Iman, Teguh dalam Pengharapan, dan Melayani dalam Kasih" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto Background Header Beranda (Opsional)</label>
                        <input type="file" name="beranda_bg_foto" class="form-control" accept="image/*">
                        <small class="text-muted">Pilih file gambar (JPG/PNG/WEBP). Kosongkan jika ingin menggunakan gambar default.</small>
                        @if(!empty($setting->beranda_bg_foto))
                            <div class="mt-2">
                                <small class="text-success fw-bold"><i class="fas fa-image me-1"></i> Background Saat Ini:</small>
                                <img src="{{ \Illuminate\Support\Str::startsWith($setting->beranda_bg_foto, ['http://', 'https://']) ? $setting->beranda_bg_foto : asset('storage/' . $setting->beranda_bg_foto) }}" class="img-thumbnail d-block mt-1" style="max-height: 100px;">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold text-primary mb-0"><i class="fas fa-user-tie me-2 text-warning"></i> Sambutan Pendeta (Beranda)</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Pendeta</label>
                        <input type="text" name="sambutan_nama" value="{{ old('sambutan_nama', $setting->sambutan_nama ?? '') }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Jabatan Pendeta</label>
                        <input type="text" name="sambutan_jabatan" value="{{ old('sambutan_jabatan', $setting->sambutan_jabatan ?? '') }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto Pendeta (Kosongkan jika tidak diubah)</label>
                        <input type="file" name="sambutan_foto" class="form-control" accept="image/*">
                        @if(!empty($setting->sambutan_foto))
                            <div class="mt-2">
                                <small class="text-success fw-bold"><i class="fas fa-image me-1"></i> Foto Pendeta Saat Ini:</small>
                                <img src="{{ \Illuminate\Support\Str::startsWith($setting->sambutan_foto, ['http://', 'https://']) ? $setting->sambutan_foto : asset('storage/' . $setting->sambutan_foto) }}" class="img-thumbnail d-block mt-1" style="max-height: 100px;">
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Teks Sambutan Pendeta</label>
                        <textarea name="sambutan_teks" class="form-control" rows="4" required>{{ old('sambutan_teks', $setting->sambutan_teks ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold text-primary mb-0"><i class="fas fa-quote-left me-2 text-warning"></i> Ayat Emas Harian (Beranda)</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Teks Ayat Emas</label>
                        <textarea name="ayat_emas_teks" class="form-control" rows="2" required>{{ old('ayat_emas_teks', $setting->ayat_emas_teks ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan Kitab / Pasal</label>
                        <input type="text" name="ayat_emas_kitab" value="{{ old('ayat_emas_kitab', $setting->ayat_emas_kitab ?? '') }}" class="form-control" placeholder="Contoh: Matius 18:20" required>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold text-primary mb-0"><i class="fas fa-users-cog me-2 text-warning"></i> Penanggung Jawab Komisi</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">PJ Komisi Anak (PAR)</label>
                        <input type="text" name="pj_komisi_anak" value="{{ old('pj_komisi_anak', $setting->pj_komisi_anak ?? '') }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">PJ Komisi Pemuda (PERMATA)</label>
                        <input type="text" name="pj_komisi_pemuda" value="{{ old('pj_komisi_pemuda', $setting->pj_komisi_pemuda ?? '') }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">PJ Komisi Perempuan (PW)</label>
                        <input type="text" name="pj_komisi_wanita" value="{{ old('pj_komisi_wanita', $setting->pj_komisi_wanita ?? '') }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">PJ Komisi Lansia</label>
                        <input type="text" name="pj_komisi_lansia" value="{{ old('pj_komisi_lansia', $setting->pj_komisi_lansia ?? '') }}" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. PROFIL GEREJA & KONTAK -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold text-primary mb-0"><i class="fas fa-book-open me-2 text-warning"></i> Sejarah, Visi, & Misi Gereja</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Sejarah Singkat Gereja</label>
                        <textarea name="sejarah_gereja" class="form-control" rows="5" required>{{ old('sejarah_gereja', $setting->sejarah_gereja ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Visi Gereja</label>
                        <textarea name="visi_gereja" class="form-control" rows="2" required>{{ old('visi_gereja', $setting->visi_gereja ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Misi Gereja</label>
                        <textarea name="misi_gereja" class="form-control" rows="4" required>{{ old('misi_gereja', $setting->misi_gereja ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold text-primary mb-0"><i class="fas fa-map-marker-alt me-2 text-warning"></i> Kontak & Peta Lokasi</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat Lengkap Gereja</label>
                        <textarea name="alamat_gereja" class="form-control" rows="2" required>{{ old('alamat_gereja', $setting->alamat_gereja ?? '') }}</textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">No. WA Sekretariat</label>
                            <input type="text" name="no_wa_gereja" value="{{ old('no_wa_gereja', $setting->no_wa_gereja ?? '') }}" class="form-control" placeholder="081234567890" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email Gereja</label>
                            <input type="email" name="email_gereja" value="{{ old('email_gereja', $setting->email_gereja ?? '') }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">URL Google Maps Embed</label>
                        <input type="text" name="maps_embed_url" value="{{ old('maps_embed_url', $setting->maps_embed_url ?? '') }}" class="form-control" placeholder="https://www.google.com/maps/embed?...">
                    </div>
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg fw-bold rounded-4 shadow-sm py-3">
                    <i class="fas fa-save me-2"></i> Simpan Seluruh Pengaturan Web
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
