@extends('admin.layouts.app')
@section('title', 'Data Kelas')

@section('content')
    <h5 class="mb-3">Data kelas</h5>

    <div class="card p-3 mb-3" style="max-width:420px">
        <form method="POST" action="{{ route('admin.classes.store') }}" class="d-flex gap-2">
            @csrf
            <input type="text" name="name" class="form-control" placeholder="Nama kelas, contoh: XII RPL 1" required>
            <button class="btn btn-dark">Tambah</button>
        </form>
    </div>

    <div class="card p-3">
        <table class="table table-sm align-middle">
            <thead><tr><th>Nama kelas</th><th>Jumlah siswa</th><th></th></tr></thead>
            <tbody>
            @forelse ($classes as $class)
                <tr>
                    <td>{{ $class->name }}</td>
                    <td>{{ $class->students_count }}</td>
                    <td class="text-end">
                        <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kelas ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center text-muted">Belum ada kelas.</td></tr>
            @endforelse
            </tbody>
        </table>
        {{ $classes->links() }}
    </div>
@endsection
