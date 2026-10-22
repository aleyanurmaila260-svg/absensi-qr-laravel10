<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $totalStudents = Student::count();

        $query = Attendance::whereDate('scan_time', $today);

        $hadir = (clone $query)->where('status', 'hadir')->count();
        $telat = (clone $query)->where('status', 'telat')->count();

        $recent = (clone $query)->with(['student.schoolClass', 'location'])
            ->latest('scan_time')
            ->limit(10)
            ->get();

        return view('admin.dashboard.index', compact('totalStudents', 'hadir', 'telat', 'recent'));
    }
}
