@extends('admin.layouts.app')
@section('title', 'Tambah Siswa')

@section('content')
    <h5 class="mb-3">Tambah siswa</h5>
    <div class="card p-3" style="max-width:480px">
        <form method="POST" action="{{ route('admin.students.store') }}">
            @csrf
            <div class="mb-3"><label class="form-label">Kelas</label>
                <select name="class_id" class="form-select" required>
                    @foreach ($classes as $class)<option value="{{ $class->id }}">{{ $class->name }}</option>@endforeach
                </select>
            </div>
            <div class="mb-3"><label class="form-label">NIS</label><input type="text" name="nis" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Nama</label><input type="text" name="name" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
            <button class="btn btn-dark">Simpan</button>
        </form>
    </div>
@endsection
