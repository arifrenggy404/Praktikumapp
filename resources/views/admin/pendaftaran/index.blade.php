@extends('layouts.admin')

@section('title', 'Kelola Pendaftaran Online')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1"><i class="fas fa-file-signature text-primary me-2"></i> Pendaftaran Online Jemaat</h3>
        <p class="text-muted small mb-0">Kelola permohonan Baptis, Sidi, Pernikahan, Konseling, dan Permohonan Doa.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- FILTER & PENCARIAN -->
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <form action="{{ route('admin.pendaftaran.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama, WA, alamat...">
        </div>
        <div class="col-md-3">
            <select name="jenis" class="form-select">
                <option value="">-- Semua Jenis Layanan --</option>
                <option value="Baptis" {{ request('jenis') == 'Baptis' ? 'selected' : '' }}>Baptis</option>
                <option value="Sidi" {{ request('jenis') == 'Sidi' ? 'selected' : '' }}>Sidi</option>
                <option value="Pernikahan" {{ request('jenis') == 'Pernikahan' ? 'selected' : '' }}>Pernikahan</option>
                <option value="Konseling" {{ request('jenis') == 'Konseling' ? 'selected' : '' }}>Konseling</option>
                <option value="Permohonan Doa" {{ request('jenis') == 'Permohonan Doa' ? 'selected' : '' }}>Permohonan Doa</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">-- Semua Status --</option>
                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100 fw-bold"><i class="fas fa-filter me-1"></i> Filter</button>
        </div>
    </form>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Tgl Daftar</th>
                        <th>Jenis Layanan</th>
                        <th>Nama Lengkap</th>
                        <th>Kontak (WA)</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftarans as $index => $p)
                        <tr>
                            <td class="ps-4 text-muted fw-bold">{{ $pendaftarans->firstItem() + $index }}</td>
                            <td class="small">{{ $p->created_at->format('d-m-Y H:i') }}</td>
                            <td><span class="badge bg-primary px-3 py-2">{{ $p->jenis_pendaftaran }}</span></td>
                            <td class="fw-bold text-dark">{{ $p->nama_lengkap }}</td>
                            <td>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $p->no_hp_wa) }}" target="_blank" class="btn btn-outline-success btn-sm rounded-pill">
                                    <i class="fab fa-whatsapp me-1"></i> {{ $p->no_hp_wa }}
                                </a>
                            </td>
                            <td class="small">{{ Str::limit($p->alamat, 35) }}</td>
                            <td>
                                @if($p->status == 'Pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($p->status == 'Disetujui')
                                    <span class="badge bg-info text-dark">Disetujui</span>
                                @elseif($p->status == 'Selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <!-- Quick Status Change Form -->
                                <form action="{{ route('admin.pendaftaran.status', $p->id) }}" method="POST" class="d-inline-block me-1">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                                        <option value="Pending" {{ $p->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Disetujui" {{ $p->status == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                        <option value="Selesai" {{ $p->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="Ditolak" {{ $p->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </form>

                                <!-- Edit Modal Trigger -->
                                <button class="btn btn-outline-primary btn-sm rounded-3 me-1" data-bs-toggle="modal" data-bs-target="#editModalPendaftaran{{ $p->id }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>

                                <!-- Delete Form -->
                                <form action="{{ route('admin.pendaftaran.destroy', $p->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus data pendaftaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm rounded-3"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>

                        <!-- MODAL EDIT PENDAFTARAN -->
                        <div class="modal fade" id="editModalPendaftaran{{ $p->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content rounded-4 border-0">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i> Edit Pendaftaran #{{ $p->id }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.pendaftaran.update', $p->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body p-4 text-start">
                                            <div class="row g-3 mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Jenis Pendaftaran</label>
                                                    <select name="jenis_pendaftaran" class="form-select" required>
                                                        <option value="Baptis" {{ $p->jenis_pendaftaran == 'Baptis' ? 'selected' : '' }}>Baptis</option>
                                                        <option value="Sidi" {{ $p->jenis_pendaftaran == 'Sidi' ? 'selected' : '' }}>Sidi</option>
                                                        <option value="Pernikahan" {{ $p->jenis_pendaftaran == 'Pernikahan' ? 'selected' : '' }}>Pernikahan</option>
                                                        <option value="Konseling" {{ $p->jenis_pendaftaran == 'Konseling' ? 'selected' : '' }}>Konseling</option>
                                                        <option value="Permohonan Doa" {{ $p->jenis_pendaftaran == 'Permohonan Doa' ? 'selected' : '' }}>Permohonan Doa</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Status Permohonan</label>
                                                    <select name="status" class="form-select" required>
                                                        <option value="Pending" {{ $p->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="Disetujui" {{ $p->status == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                                        <option value="Selesai" {{ $p->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                                        <option value="Ditolak" {{ $p->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nama Lengkap Pemohon</label>
                                                <input type="text" name="nama_lengkap" value="{{ $p->nama_lengkap }}" class="form-control" required>
                                            </div>

                                            <div class="row g-3 mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">No. HP / WhatsApp</label>
                                                    <input type="text" name="no_hp_wa" value="{{ $p->no_hp_wa }}" class="form-control" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Email (Opsional)</label>
                                                    <input type="email" name="email" value="{{ $p->email }}" class="form-control">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Alamat Tinggal</label>
                                                <textarea name="alamat" class="form-control" rows="2" required>{{ $p->alamat }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Catatan / Keterangan Tambahan</label>
                                                <textarea name="catatan_keterangan" class="form-control" rows="3">{{ $p->catatan_keterangan }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary rounded-3 fw-bold">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">Belum ada permohonan pendaftaran online.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $pendaftarans->links() }}
</div>
@endsection
