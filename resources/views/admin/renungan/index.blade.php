@extends('layouts.admin')

@section('title', 'Kelola Renungan & Khotbah')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1"><i class="fas fa-book-open text-primary me-2"></i> Renungan & Video Khotbah</h3>
        <p class="text-muted small mb-0">Tambah dan publikasikan renungan harian atau video khotbah Minggu.</p>
    </div>
    <button class="btn btn-primary rounded-3" data-bs-toggle="modal" data-bs-target="#modalTambahRenungan">
        <i class="fas fa-plus me-1"></i> Tambah Renungan / Khotbah
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Judul</th>
                        <th>Pengkhotbah / Penulis</th>
                        <th>Ayat Alkitab</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($renungans as $index => $r)
                        <tr>
                            <td class="ps-4 text-muted fw-bold">{{ $renungans->firstItem() + $index }}</td>
                            <td>{{ $r->tanggal }}</td>
                            <td><span class="badge bg-warning text-dark">{{ $r->kategori }}</span></td>
                            <td class="fw-bold text-dark">{{ $r->judul }}</td>
                            <td>{{ $r->pengkhotbah_penulis }}</td>
                            <td class="small text-muted">{{ $r->ayat_alkitab ?? '-' }}</td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.renungan.destroy', $r->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus renungan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm rounded-3"><i class="fas fa-trash-alt"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">Belum ada data renungan atau khotbah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH RENUNGAN -->
<div class="modal fade" id="modalTambahRenungan" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-plus-circle me-2"></i> Tambah Renungan / Khotbah</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.renungan.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Renungan / Khotbah <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" placeholder="Contoh: Setia dalam Perkara Kecil" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Pengkhotbah / Penulis <span class="text-danger">*</span></label>
                            <input type="text" name="pengkhotbah_penulis" class="form-control" placeholder="Contoh: Pdt. Andreas, S.Th" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori" class="form-select" required>
                                <option value="Renungan Harian">Renungan Harian</option>
                                <option value="Khotbah Minggu">Khotbah Minggu</option>
                                <option value="Artikel">Artikel</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Ayat Alkitab (Opsional)</label>
                            <input type="text" name="ayat_alkitab" class="form-control" placeholder="Contoh: Matius 25:21">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">URL Video YouTube Khotbah (Opsional)</label>
                        <input type="url" name="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Isi Renungan / Rangkuman Khotbah <span class="text-danger">*</span></label>
                        <textarea name="isi" class="form-control" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-3 fw-bold">Simpan Renungan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
