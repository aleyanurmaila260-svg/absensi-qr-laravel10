<?php

namespace Database\Seeders;

use App\Models\QrLocation;
use App\Models\SchoolClass;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin Sekolah',
            'email' => 'admin@sekolah.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $guru = User::create([
            'name' => 'Budi Santoso',
            'email' => 'guru@sekolah.test',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);

        $class = SchoolClass::create(['name' => 'XII RPL 1']);
        $subject = Subject::create(['name' => 'Matematika']);

        Schedule::create([
            'class_id' => $class->id,
            'subject_id' => $subject->id,
            'teacher_id' => $guru->id,
            'day' => 'senin',
            'start_time' => '07:00',
            'end_time' => '08:30',
        ]);

        Student::create([
            'class_id' => $class->id,
            'nis' => '2024001',
            'name' => 'Bunga Lestari',
            'email' => 'bunga@siswa.test',
            'password' => Hash::make('password'),
        ]);

        // Titik lokasi QR sesuai kebutuhan: gerbang, lab, lobi
        QrLocation::create([
            'code' => 'GERBANG',
            'name' => 'Gerbang Sekolah',
            'secret_key' => Str::random(40),
            'cutoff_time' => '07:00',
            'is_active' => true,
        ]);

        QrLocation::create([
            'code' => 'LAB-RPL',
            'name' => 'Lab RPL',
            'secret_key' => Str::random(40),
            'cutoff_time' => null,
            'is_active' => true,
        ]);

        QrLocation::create([
            'code' => 'LOBI',
            'name' => 'Lobi Sekolah',
            'secret_key' => Str::random(40),
            'cutoff_time' => null,
            'is_active' => false,
        ]);
    }
}
