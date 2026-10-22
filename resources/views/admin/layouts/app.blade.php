<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Absensi QR') - Sistem Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="d-flex" style="min-height:100vh">
    <nav class="bg-white border-end p-3" style="width:220px">
        <p class="fw-bold mb-4">Absensi QR</p>
        <div class="nav flex-column gap-1">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active fw-bold' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
            @if (auth()->user()->isAdmin())
                <a class="nav-link {{ request()->routeIs('admin.students.*') ? 'active fw-bold' : '' }}" href="{{ route('admin.students.index') }}">Data siswa</a>
                <a class="nav-link {{ request()->routeIs('admin.classes.*') ? 'active fw-bold' : '' }}" href="{{ route('admin.classes.index') }}">Data kelas</a>
                <a class="nav-link {{ request()->routeIs('admin.teachers.*') ? 'active fw-bold' : '' }}" href="{{ route('admin.teachers.index') }}">Data guru</a>
                <a class="nav-link {{ request()->routeIs('admin.schedules.*') ? 'active fw-bold' : '' }}" href="{{ route('admin.schedules.index') }}">Jadwal</a>
                <a class="nav-link {{ request()->routeIs('admin.locations.*') ? 'active fw-bold' : '' }}" href="{{ route('admin.locations.index') }}">Lokasi & QR</a>
            @endif
            <a class="nav-link {{ request()->routeIs('admin.history.*') ? 'active fw-bold' : '' }}" href="{{ route('admin.history.index') }}">Riwayat scan</a>
            <a class="nav-link {{ request()->routeIs('admin.recap.*') ? 'active fw-bold' : '' }}" href="{{ route('admin.recap.index') }}">Rekap & laporan</a>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button class="btn btn-outline-secondary btn-sm w-100">Keluar</button>
        </form>
    </nav>
    <main class="flex-grow-1 p-4">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @yield('content')
    </main>
</div>
</body>
</html>
