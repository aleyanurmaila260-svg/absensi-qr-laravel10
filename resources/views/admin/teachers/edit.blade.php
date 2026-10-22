@extends('admin.layouts.app')
@section('title', 'Edit Guru')

@section('content')
    <h5 class="mb-3">Edit guru</h5>
    <div class="card p-3" style="max-width:480px">
        <form method="POST" action="{{ route('admin.teachers.update', $teacher) }}">
            @csrf @method('PUT')
            <div class="mb-3"><label class="form-label">Nama</label><input type="text" name="name" class="form-control" value="{{ $teacher->name }}" required></div>
            <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ $teacher->email }}" required></div>
            <div class="mb-3"><label class="form-label">Password baru (opsional)</label><input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah"></div>
            <button class="btn btn-dark">Simpan perubahan</button>
        </form>
    </div>
@endsection
