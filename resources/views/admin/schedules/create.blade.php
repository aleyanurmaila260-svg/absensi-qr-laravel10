@extends('admin.layouts.app')
@section('title', 'Tambah Jadwal')

@section('content')
    <h5 class="mb-3">Tambah jadwal</h5>
    <div class="card p-3" style="max-width:480px">
        <form method="POST" action="{{ route('admin.schedules.store') }}">
            @csrf
            <div class="mb-3"><label class="form-label">Kelas</label>
                <select name="class_id" class="form-select" required>
                    @foreach ($classes as $class)<option value="{{ $class->id }}">{{ $class->name }}</option>@endforeach
                </select>
            </div>
            <div class="mb-3"><label class="form-label">Mata pelajaran</label>
                <select name="subject_id" class="form-select" required>
                    @foreach ($subjects as $subject)<option value="{{ $subject->id }}">{{ $subject->name }}</option>@endforeach
                </select>
            </div>
            <div class="mb-3"><label class="form-label">Guru</label>
                <select name="teacher_id" class="form-select" required>
                    @foreach ($teachers as $teacher)<option value="{{ $teacher->id }}">{{ $teacher->name }}</option>@endforeach
                </select>
            </div>
            <div class="mb-3"><label class="form-label">Hari</label>
                <select name="day" class="form-select" required>
                    @foreach (['senin','selasa','rabu','kamis','jumat','sabtu'] as $day)<option value="{{ $day }}">{{ ucfirst($day) }}</option>@endforeach
                </select>
            </div>
            <div class="row mb-3">
                <div class="col"><label class="form-label">Jam mulai</label><input type="time" name="start_time" class="form-control" required></div>
                <div class="col"><label class="form-label">Jam selesai</label><input type="time" name="end_time" class="form-control" required></div>
            </div>
            <button class="btn btn-dark">Simpan</button>
        </form>
    </div>
@endsection
