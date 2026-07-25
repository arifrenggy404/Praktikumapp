@extends('layouts.admin')

@section('title', 'Kelola Galeri Foto Kegiatan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1"><i class="fas fa-images text-primary me-2"></i> Galeri Foto Kegiatan</h3>
        <p class="text-muted small mb-0">Kelola dokumentasi foto Natal, Paskah, Bakti Sosial, dan Ibadah Gereja.</p>
    </div>
    <button class="btn btn-primary rounded-3" data-bs-toggle="modal" data-bs-target="#modalTambahGaleri">
        <i class="fas fa-plus me-1"></i> Upload Foto Kegiatan
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">
    @forelse($galeris as $g)
        <div class="col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div style="height: 180px; overflow: hidden; position: relative;">
                    <img src="{{ Str::startsWith($g->gambar, 'http') ? $g->gambar : asset('storage/' . $g->gambar) }}" class="w-100 h-100" style="object-fit: cover;" alt="Galeri">
                    <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2">{{ $g->kategori }}</span>
                </div>
                <div class="p-3 d-flex flex-column flex-grow-1 bg-white">
                    <h6 class="fw-bold text-dark mb-1">{{ $g->judul }}</h6>
                    <small class="text-muted mb-3 flex-grow-1">{{ Str::limit($g->deskripsi, 60) }}</small>
                    <div class="d-flex justify-content-between align-items-center border-top pt-2">
                        <small class="text-muted">{{ $g->tanggal_kegiatan }}</small>
                        <form action="{{ route('admin.galeri.destroy', $g->id) }}" method="POST" onsubmit="return confirm('Hapus foto ini dari galeri?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm rounded-3"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-5 text-center text-muted">
                <i class="fas fa-images fa-3x mb-3 opacity-50"></i>
                <h5>Belum ada dokumentasi foto galeri.</h5>
            </div>
        </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $galeris->links() }}
</div>

<!-- MODAL TAMBAH GALERI -->
<div class="modal fade" id="modalTambahGaleri" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-upload me-2"></i> Upload Foto Kegiatan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Kegiatan / Momen <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" placeholder="Contoh: Perayaan Paskah 2026" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori Foto <span class="text-danger">*</span></label>
                        <select name="kategori" class="form-select" required>
                            <option value="Natal">Natal</option>
                            <option value="Paskah">Paskah</option>
                            <option value="Bakti Sosial">Bakti Sosial</option>
                            <option value="Ibadah">Ibadah</option>
                            <option value="Pemuda">Pemuda</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih File Foto <span class="text-danger">*</span></label>
                        <input type="file" name="gambar" class="form-control" accept="image/*" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanggal Kegiatan <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_kegiatan" value="{{ date('Y-m-d') }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi Foto (Opsional)</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Keterangan singkat momen foto..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-3 fw-bold">Upload Foto</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
