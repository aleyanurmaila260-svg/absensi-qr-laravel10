@extends('admin.layouts.app')
@section('title', 'Tambah Guru')

@section('content')
    <h5 class="mb-3">Tambah guru</h5>
    <div class="card p-3" style="max-width:480px">
        <form method="POST" action="{{ route('admin.teachers.store') }}">
            @csrf
            <div class="mb-3"><label class="form-label">Nama</label><input type="text" name="name" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
            <button class="btn btn-dark">Simpan</button>
        </form>
    </div>
@endsection
