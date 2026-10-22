<?php

use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\AttendanceHistoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QrLocationController;
use App\Http\Controllers\Admin\RecapController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Hanya admin yang boleh mengelola data master
    Route::middleware('role:admin')->group(function () {
        Route::resource('students', StudentController::class)->except(['show']);
        Route::resource('classes', ClassController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('teachers', TeacherController::class)->except(['show']);
        Route::resource('schedules', ScheduleController::class)->only(['index', 'create', 'store', 'destroy']);

        Route::get('/locations', [QrLocationController::class, 'index'])->name('locations.index');
        Route::get('/locations/create', [QrLocationController::class, 'create'])->name('locations.create');
        Route::post('/locations', [QrLocationController::class, 'store'])->name('locations.store');
        Route::post('/locations/{location}/toggle', [QrLocationController::class, 'toggle'])->name('locations.toggle');
        Route::delete('/locations/{location}', [QrLocationController::class, 'destroy'])->name('locations.destroy');
    });

    // Admin dan guru: buat/tampilkan QR, lihat kehadiran, riwayat, rekap, cetak laporan
    Route::middleware('role:admin,guru')->group(function () {
        Route::get('/locations/{location}/display', [QrLocationController::class, 'display'])->name('locations.display');
        Route::get('/locations/{location}/refresh', [QrLocationController::class, 'refresh'])->name('locations.refresh');

        Route::get('/history', [AttendanceHistoryController::class, 'index'])->name('history.index');
        Route::get('/recap', [RecapController::class, 'index'])->name('recap.index');
        Route::get('/recap/print', [RecapController::class, 'print'])->name('recap.print');
    });
});
