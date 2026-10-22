@extends('admin.layouts.app')
@section('title', 'Riwayat Scan')

@section('content')
    <h5 class="mb-3">Riwayat scan siswa</h5>
    <p class="text-muted small">Siapa yang scan, kapan, dan di lokasi QR mana.</p>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-auto">
            <select name="location_id" class="form-select form-select-sm">
                <option value="">Semua lokasi</option>
                @foreach ($locations as $location)
                    <option value="{{ $location->id }}" @selected(request('location_id') == $location->id)>{{ $location->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <select name="class_id" class="form-select form-select-sm">
                <option value="">Semua kelas</option>
                @foreach ($classes as $class)
                    <option value="{{ $class->id }}" @selected(request('class_id') == $class->id)>{{ $class->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto"><input type="date" name="date" class="form-control form-control-sm" value="{{ request('date', now()->toDateString()) }}"></div>
        <div class="col-auto"><button class="btn btn-sm btn-dark">Filter</button></div>
    </form>

    <div class="card p-3">
        <table class="table table-sm">
            <thead><tr><th>Nama</th><th>Kelas</th><th>Lokasi</th><th>Jam scan</th><th>Status</th></tr></thead>
            <tbody>
            @forelse ($attendances as $item)
                <tr>
                    <td>{{ $item->student->name }}</td>
                    <td>{{ $item->student->schoolClass->name }}</td>
                    <td>{{ $item->location->name }}</td>
                    <td>{{ $item->scan_time->format('d/m/Y H:i') }}</td>
                    <td><span class="badge bg-{{ $item->status === 'hadir' ? 'success' : 'warning' }}">{{ ucfirst($item->status) }}</span></td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">Tidak ada data.</td></tr>
            @endforelse
            </tbody>
        </table>
        {{ $attendances->links() }}
    </div>
@endsection
