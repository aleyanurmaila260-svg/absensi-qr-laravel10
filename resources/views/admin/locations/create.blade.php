@extends('admin.layouts.app')
@section('title', 'Tambah Lokasi')

@section('content')
    <h5 class="mb-3">Tambah lokasi QR</h5>
    <div class="card p-3" style="max-width:480px">
        <form method="POST" action="{{ route('admin.locations.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Kode lokasi</label>
                <input type="text" name="code" class="form-control" placeholder="Contoh: GERBANG, LAB-RPL" required>
                <div class="form-text">Huruf besar/kecil bebas, akan otomatis dirapikan jadi format GERBANG, LAB-RPL, dsb.</div>
            </div>
            <div class="mb-3"><label class="form-label">Nama lokasi</label><input type="text" name="name" class="form-control" placeholder="Contoh: Gerbang Sekolah" required></div>
            <div class="mb-3">
                <label class="form-label">Batas waktu tepat waktu (opsional)</label>
                <input type="time" name="cutoff_time" class="form-control">
                <div class="form-text">Kosongkan jika lokasi ini tidak perlu status telat, misal Lab/ruang kegiatan.</div>
            </div>
            <button class="btn btn-dark">Simpan</button>
        </form>
    </div>
@endsection
