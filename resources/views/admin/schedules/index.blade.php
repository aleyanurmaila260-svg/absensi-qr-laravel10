@extends('admin.layouts.app')
@section('title', 'Jadwal')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="m-0">Jadwal pelajaran</h5>
        <a href="{{ route('admin.schedules.create') }}" class="btn btn-dark btn-sm">Tambah jadwal</a>
    </div>
    <div class="card p-3">
        <table class="table table-sm">
            <thead><tr><th>Hari</th><th>Jam</th><th>Kelas</th><th>Mapel</th><th>Guru</th><th></th></tr></thead>
            <tbody>
            @forelse ($schedules as $schedule)
                <tr>
                    <td>{{ ucfirst($schedule->day) }}</td>
                    <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                    <td>{{ $schedule->schoolClass->name }}</td>
                    <td>{{ $schedule->subject->name }}</td>
                    <td>{{ $schedule->teacher->name }}</td>
                    <td class="text-end">
                        <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted">Belum ada jadwal.</td></tr>
            @endforelse
            </tbody>
        </table>
        {{ $schedules->links() }}
    </div>
@endsection
