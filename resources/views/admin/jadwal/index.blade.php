@extends('layouts.admin')

@section('title', 'Kelola Jadwal Pelayanan')
@section('header', 'Manajemen Jadwal Ibadah')

@section('styles')
    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
    <style>
        .fc { --fc-border-color: #e2e8f0; --fc-button-bg-color: #2563eb; --fc-button-border-color: #2563eb; }
        .fc .fc-toolbar-title { font-size: 1.25rem; font-weight: 700; color: #1e293b; }
        .fc .fc-col-header-cell-cushion { font-size: 0.85rem; font-weight: 600; text-transform: uppercase; color: #64748b; padding: 10px 0; }
        .fc-event { cursor: pointer; padding: 2px 5px; border-radius: 4px; border: none; }
        .fc-daygrid-event-dot { border-color: #2563eb; }
        .nav-pills .nav-link { color: #64748b; font-weight: 600; padding: 8px 20px; border-radius: 8px; }
        .nav-pills .nav-link.active { background-color: #eff6ff; color: #2563eb; }
    </style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Jadwal Pelayanan Ibadah</h4>
        <p class="text-muted small mb-0">Visualisasi dan manajemen waktu pelayanan jemaat.</p>
    </div>
    <div class="d-flex gap-2">
        <ul class="nav nav-pills bg-white p-1 rounded-3 shadow-sm border me-2" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-table-tab" data-bs-toggle="pill" data-bs-target="#pills-table" type="button" role="tab"><i class="fas fa-list me-2"></i>Tabel</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-calendar-tab" data-bs-toggle="pill" data-bs-target="#pills-calendar" type="button" role="tab"><i class="fas fa-calendar-alt me-2"></i>Kalender</button>
            </li>
        </ul>
        <a href="{{ route('jadwal.pdf', ['search' => request('search')]) }}" class="btn btn-outline-danger fw-bold px-3">
            <i class="fas fa-file-pdf me-2"></i> Cetak PDF
        </a>
        <a href="{{ route('jadwal.create') }}" class="btn btn-primary fw-bold px-4">
            <i class="fas fa-plus me-2"></i> Tambah Jadwal
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
    </div>
@endif

<div class="row mb-4">
    <div class="col-md-6">
        <form action="{{ route('jadwal.index') }}" method="GET" class="d-flex gap-2">
            <div class="input-group shadow-sm">
                <span class="input-group-text bg-white border-end-0 rounded-start-4 ps-3">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-start-0 py-2" 
                    placeholder="Cari nama ibadah atau lokasi..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn btn-primary fw-bold px-4 rounded-4">Cari</button>
            @if(request('search'))
                <a href="{{ route('jadwal.index') }}" class="btn btn-light fw-bold px-4 rounded-4 border">Reset</a>
            @endif
        </form>
    </div>
</div>

<div class="tab-content" id="pills-tabContent">
    <!-- View Tabel -->
    <div class="tab-pane fade show active" id="pills-table" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">Ibadah & Waktu</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted">Lokasi</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted">Petugas</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jadwals as $jadwal)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="fw-bold text-dark">{{ $jadwal->nama_ibadah }}</div>
                                        <div class="text-muted small">
                                            <i class="far fa-calendar me-1"></i> {{ \Carbon\Carbon::parse($jadwal->tanggal_waktu)->translatedFormat('d M Y') }}
                                        </div>
                                        <div class="text-primary small fw-bold">
                                            <i class="far fa-clock me-1"></i> 
                                            {{ \Carbon\Carbon::parse($jadwal->tanggal_waktu)->format('H:i') }} 
                                            s/d 
                                            {{ $jadwal->jam_selesai ? \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') : 'Selesai' }}
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-light text-secondary border px-2 py-1">
                                            <i class="fas fa-map-marker-alt me-1"></i> {{ $jadwal->lokasi_ibadah }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <div class="small">
                                            @forelse($jadwal->pelayan as $p)
                                                <div class="mb-1">
                                                    <span class="text-muted small">{{ $p->pivot->peran }}:</span>
                                                    <span class="fw-medium">{{ $p->nama_lengkap }}</span>
                                                </div>
                                            @empty
                                                <span class="text-muted italic small">Belum di-plotting</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="py-3 text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('jadwal.edit', $jadwal->id) }}" class="btn btn-sm btn-light text-warning border">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('jadwal.destroy', $jadwal->id) }}" method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light text-danger border">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="fas fa-calendar-times fa-3x mb-3 opacity-25"></i>
                                        <p class="mb-0">Belum ada jadwal pelayanan yang dibuat.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- View Kalender -->
    <div class="tab-pane fade" id="pills-calendar" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                locale: 'id',
                events: [
                    @foreach($jadwals as $jadwal)
                    {
                        title: '{{ $jadwal->nama_ibadah }}',
                        start: '{{ \Carbon\Carbon::parse($jadwal->tanggal_waktu)->toIso8601String() }}',
                        @if($jadwal->jam_selesai)
                        end: '{{ \Carbon\Carbon::parse($jadwal->tanggal_waktu)->format("Y-m-d") }}T{{ $jadwal->jam_selesai }}',
                        @endif
                        url: '{{ route("jadwal.edit", $jadwal->id) }}',
                        backgroundColor: '#eff6ff',
                        textColor: '#2563eb',
                        borderColor: '#2563eb',
                        extendedProps: {
                            lokasi: '{{ $jadwal->lokasi_ibadah }}',
                            petugas: '{{ $jadwal->pelayan->first()->nama_lengkap ?? "Belum di-plotting" }}'
                        }
                    },
                    @endforeach
                ],
                eventDidMount: function(info) {
                    // Simple tooltip logic or popover can be added here
                }
            });

            // Re-render calendar when switching tabs to fix sizing issue
            var triggerEl = document.querySelector('#pills-calendar-tab')
            triggerEl.addEventListener('shown.bs.tab', function (event) {
                calendar.render();
            });
        });
    </script>
@endsection