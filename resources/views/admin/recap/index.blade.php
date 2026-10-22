@extends('admin.layouts.app')
@section('title', 'Rekap Absensi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="m-0">Rekap absensi</h5>
        <a href="{{ route('admin.recap.print', request()->query()) }}" class="btn btn-outline-dark btn-sm">Cetak PDF</a>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-auto">
            <select name="class_id" class="form-select form-select-sm">
                <option value="">Semua kelas</option>
                @foreach ($classes as $class)
                    <option value="{{ $class->id }}" @selected($classId == $class->id)>{{ $class->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto"><input type="date" name="date_from" class="form-control form-control-sm" value="{{ $dateFrom }}"></div>
        <div class="col-auto"><input type="date" name="date_to" class="form-control form-control-sm" value="{{ $dateTo }}"></div>
        <div class="col-auto"><button class="btn btn-sm btn-dark">Terapkan</button></div>
    </form>

    <div class="card p-3">
        <table class="table table-sm">
            <thead><tr><th>Nama</th><th>Kelas</th><th>Hadir</th><th>Telat</th><th>Total scan</th></tr></thead>
            <tbody>
            @forelse ($recap as $row)
                <tr>
                    <td>{{ $row['student']->name }}</td>
                    <td>{{ $row['student']->schoolClass->name }}</td>
                    <td>{{ $row['hadir'] }}</td>
                    <td>{{ $row['telat'] }}</td>
                    <td>{{ $row['total_scan'] }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">Tidak ada data.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
