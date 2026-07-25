@extends('layouts.admin')

@section('title', 'Edit Anggota Keluarga Jemaat')
@section('header', 'Manajemen Warga Jemaat')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-4 px-4 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-edit text-warning me-2"></i> Ubah Data Anggota Keluarga</h5>
                        <p class="text-muted small mb-0">Perbarui informasi anggota keluarga jemaat yang terdaftar.</p>
                    </div>
                    <a href="{{ route('jemaat.index') }}" class="btn btn-outline-secondary btn-sm fw-bold rounded-3">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('jemaat.update', $jemaat->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- DATA KELUARGA -->
                        <div class="col-12">
                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="fas fa-id-card me-2 text-warning"></i> Data Kartu Keluarga (KK)</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">NOMOR KK GEREJA <span class="text-danger">*</span></label>
                            <input type="text" name="no_kk_gereja" value="{{ old('no_kk_gereja', $jemaat->kartuKeluarga->no_kk_gereja ?? 'KK-001') }}" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">PERAN DALAM KELUARGA <span class="text-danger">*</span></label>
                            <select name="peran_keluarga" class="form-select" required>
                                <option value="Kepala Keluarga (Ayah)" {{ old('peran_keluarga', $jemaat->peran_keluarga) == 'Kepala Keluarga (Ayah)' ? 'selected' : '' }}>Kepala Keluarga (Ayah)</option>
                                <option value="Istri (Ibu)" {{ old('peran_keluarga', $jemaat->peran_keluarga) == 'Istri (Ibu)' ? 'selected' : '' }}>Istri (Ibu)</option>
                                <option value="Anak" {{ old('peran_keluarga', $jemaat->peran_keluarga) == 'Anak' ? 'selected' : '' }}>Anak</option>
                                <option value="Anggota Keluarga Lain" {{ old('peran_keluarga', $jemaat->peran_keluarga) == 'Anggota Keluarga Lain' ? 'selected' : '' }}>Anggota Keluarga Lain</option>
                            </select>
                        </div>

                        <!-- DATA PRIBADI -->
                        <div class="col-12 mt-4">
                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="fas fa-user me-2 text-warning"></i> Data Pribadi Anggota Keluarga</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">NAMA LENGKAP <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $jemaat->nama_lengkap) }}" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">JENIS KELAMIN <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="Laki-laki" {{ old('jenis_kelamin', $jemaat->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $jemaat->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">TEMPAT LAHIR <span class="text-danger">*</span></label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $jemaat->tempat_lahir) }}" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">TANGGAL LAHIR <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $jemaat->tanggal_lahir) }}" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">ALAMAT DOMISILI <span class="text-danger">*</span></label>
                            <input type="text" name="alamat_domisili" value="{{ old('alamat_domisili', $jemaat->alamat_domisili) }}" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">NO. HP / WHATSAPP</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $jemaat->no_hp) }}" class="form-control">
                        </div>

                        <!-- STATUS GEREJAWI -->
                        <div class="col-12 mt-4">
                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="fas fa-church me-2 text-warning"></i> Status Gerejawi</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">STATUS BAPTIS <span class="text-danger">*</span></label>
                            <select name="status_baptis" class="form-select" required>
                                <option value="Sudah" {{ old('status_baptis', $jemaat->status_baptis) == 'Sudah' ? 'selected' : '' }}>Sudah Baptis</option>
                                <option value="Belum" {{ old('status_baptis', $jemaat->status_baptis) == 'Belum' ? 'selected' : '' }}>Belum Baptis</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">STATUS SIDI <span class="text-danger">*</span></label>
                            <select name="status_sidi" class="form-select" required>
                                <option value="Sudah" {{ old('status_sidi', $jemaat->status_sidi) == 'Sudah' ? 'selected' : '' }}>Sudah Sidi</option>
                                <option value="Belum" {{ old('status_sidi', $jemaat->status_sidi) == 'Belum' ? 'selected' : '' }}>Belum Sidi</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-top d-flex justify-content-end gap-2">
                        <a href="{{ route('jemaat.index') }}" class="btn btn-light px-4 fw-bold rounded-3">Batal</a>
                        <button type="submit" class="btn btn-warning text-dark px-5 fw-bold rounded-3">Perbarui Data Anggota</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection