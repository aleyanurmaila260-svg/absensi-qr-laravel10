@extends('admin.layouts.app')
@section('title', 'Data Siswa')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="m-0">Data siswa</h5>
        <a href="{{ route('admin.students.create') }}" class="btn btn-dark btn-sm">Tambah siswa</a>
    </div>
    <div class="card p-3">
        <table class="table table-sm align-middle">
            <thead><tr><th>NIS</th><th>Nama</th><th>Kelas</th><th>Email</th><th></th></tr></thead>
            <tbody>
            @forelse ($students as $student)
                <tr>
                    <td>{{ $student->nis }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->schoolClass->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus siswa ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">Belum ada data siswa.</td></tr>
            @endforelse
            </tbody>
        </table>
        {{ $students->links() }}
    </div>
@endsection
