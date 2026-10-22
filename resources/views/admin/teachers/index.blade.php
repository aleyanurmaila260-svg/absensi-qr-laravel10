@extends('admin.layouts.app')
@section('title', 'Data Guru')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="m-0">Data guru</h5>
        <a href="{{ route('admin.teachers.create') }}" class="btn btn-dark btn-sm">Tambah guru</a>
    </div>
    <div class="card p-3">
        <table class="table table-sm align-middle">
            <thead><tr><th>Nama</th><th>Email</th><th></th></tr></thead>
            <tbody>
            @forelse ($teachers as $teacher)
                <tr>
                    <td>{{ $teacher->name }}</td>
                    <td>{{ $teacher->email }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus guru ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center text-muted">Belum ada data guru.</td></tr>
            @endforelse
            </tbody>
        </table>
        {{ $teachers->links() }}
    </div>
@endsection
