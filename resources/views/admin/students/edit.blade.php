@extends('admin.layouts.app')
@section('title', 'Edit Siswa')

@section('content')
    <h5 class="mb-3">Edit siswa</h5>
    <div class="card p-3" style="max-width:480px">
        <form method="POST" action="{{ route('admin.students.update', $student) }}">
            @csrf @method('PUT')
            <div class="mb-3"><label class="form-label">Kelas</label>
                <select name="class_id" class="form-select" required>
                    @foreach ($classes as $class)<option value="{{ $class->id }}" @selected($class->id === $student->class_id)>{{ $class->name }}</option>@endforeach
                </select>
            </div>
            <div class="mb-3"><label class="form-label">NIS</label><input type="text" name="nis" class="form-control" value="{{ $student->nis }}" required></div>
            <div class="mb-3"><label class="form-label">Nama</label><input type="text" name="name" class="form-control" value="{{ $student->name }}" required></div>
            <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ $student->email }}" required></div>
            <div class="mb-3"><label class="form-label">Password baru (opsional)</label><input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah"></div>
            <button class="btn btn-dark">Simpan perubahan</button>
        </form>
    </div>
@endsection
