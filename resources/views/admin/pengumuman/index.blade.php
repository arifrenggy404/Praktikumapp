@extends('layouts.admin')

@section('title', 'Kelola Papan Pengumuman Digital')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1"><i class="fas fa-bullhorn text-primary me-2"></i> Papan Pengumuman Digital</h3>
        <p class="text-muted small mb-0">Kelola pengumuman digital yang tampil di beranda & halaman pengumuman jemaat.</p>
    </div>
    <button class="btn btn-primary rounded-3" data-bs-toggle="modal" data-bs-target="#modalTambahPengumuman">
        <i class="fas fa-plus me-1"></i> Buat Pengumuman Baru
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
                        <th>Tanggal Dibuat</th>
                        <th>Judul Pengumuman</th>
                        <th>Isi Pengumuman</th>
                        <th>Dibuat Oleh</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengumumen as $index => $p)
                        <tr>
                            <td class="ps-4 text-muted fw-bold">{{ $pengumumen->firstItem() + $index }}</td>
                            <td>{{ $p->tanggal_dibuat }}</td>
                            <td class="fw-bold text-dark">{{ $p->judul }}</td>
                            <td class="small">{{ Str::limit($p->isi, 70) }}</td>
                            <td><span class="badge bg-secondary">{{ $p->dibuat_oleh }}</span></td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.pengumuman.destroy', $p->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus pengumuman ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm rounded-3"><i class="fas fa-trash-alt"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Belum ada data pengumuman digital.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH PENGUMUMAN -->
<div class="modal fade" id="modalTambahPengumuman" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-plus-circle me-2"></i> Buat Pengumuman Digital</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.pengumuman.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Pengumuman <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" placeholder="Contoh: Pelaksanaan Ibadah Padang" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Dibuat Oleh / Pengirim <span class="text-danger">*</span></label>
                        <input type="text" name="dibuat_oleh" class="form-control" value="Majelis Jemaat" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Isi Pengumuman <span class="text-danger">*</span></label>
                        <textarea name="isi" class="form-control" rows="5" required placeholder="Tuliskan isi detail pengumuman bagi jemaat..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-3 fw-bold">Terbitkan Pengumuman</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
