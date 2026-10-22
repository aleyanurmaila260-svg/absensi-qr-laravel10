@extends('admin.layouts.app')
@section('title', 'Lokasi & QR')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="m-0">Titik lokasi QR presensi</h5>
        <a href="{{ route('admin.locations.create') }}" class="btn btn-dark btn-sm">Tambah lokasi</a>
    </div>

    <div class="row g-3">
        @forelse ($locations as $location)
            <div class="col-4">
                <div class="card p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <p class="fw-semibold m-0">{{ $location->name }}</p>
                        <span class="badge bg-{{ $location->is_active ? 'success' : 'secondary' }}">{{ $location->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                    </div>
                    <p class="text-muted small mb-2">Kode: {{ $location->code }}</p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.locations.display', $location) }}" class="btn btn-sm btn-dark" target="_blank">Tampilkan QR</a>
                        <form action="{{ route('admin.locations.toggle', $location) }}" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-outline-secondary">{{ $location->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                        </form>
                        <form action="{{ route('admin.locations.destroy', $location) }}" method="POST" onsubmit="return confirm('Hapus lokasi ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada lokasi QR. Tambahkan titik seperti Gerbang, Lobi, atau Lab.</p>
        @endforelse
    </div>
@endsection
