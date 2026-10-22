@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')
    <h5 class="mb-4">Dashboard presensi hari ini</h5>
    <div class="row g-3 mb-4">
        <div class="col-4">
            <div class="card p-3"><small class="text-muted">Total siswa</small><div class="fs-3 fw-semibold">{{ $totalStudents }}</div></div>
        </div>
        <div class="col-4">
            <div class="card p-3"><small class="text-muted">Hadir hari ini</small><div class="fs-3 fw-semibold text-success">{{ $hadir }}</div></div>
        </div>
        <div class="col-4">
            <div class="card p-3"><small class="text-muted">Telat hari ini</small><div class="fs-3 fw-semibold text-warning">{{ $telat }}</div></div>
        </div>
    </div>

    <div class="card p-3">
        <p class="fw-semibold mb-2">Scan terbaru</p>
        <table class="table table-sm">
            <thead><tr><th>Nama</th><th>Kelas</th><th>Lokasi</th><th>Jam scan</th><th>Status</th></tr></thead>
            <tbody>
            @forelse ($recent as $item)
                <tr>
                    <td>{{ $item->student->name }}</td>
                    <td>{{ $item->student->schoolClass->name }}</td>
                    <td>{{ $item->location->name }}</td>
                    <td>{{ $item->scan_time->format('H:i') }}</td>
                    <td><span class="badge bg-{{ $item->status === 'hadir' ? 'success' : 'warning' }}">{{ ucfirst($item->status) }}</span></td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">Belum ada presensi hari ini.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
