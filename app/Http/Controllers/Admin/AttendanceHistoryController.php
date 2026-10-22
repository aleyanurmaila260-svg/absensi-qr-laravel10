<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\QrLocation;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class AttendanceHistoryController extends Controller
{
    // Melihat data kehadiran + riwayat scan: siapa, kapan, lokasi mana
    public function index(Request $request)
    {
        $query = Attendance::with(['student.schoolClass', 'location']);

        if ($request->filled('location_id')) {
            $query->where('qr_location_id', $request->location_id);
        }

        if ($request->filled('class_id')) {
            $query->whereHas('student', fn ($q) => $q->where('class_id', $request->class_id));
        }

        if ($request->filled('date')) {
            $query->whereDate('scan_time', $request->date);
        } else {
            $query->whereDate('scan_time', now()->toDateString());
        }

        $attendances = $query->latest('scan_time')->paginate(25)->withQueryString();

        $locations = QrLocation::all();
        $classes = SchoolClass::all();

        return view('admin.history.index', compact('attendances', 'locations', 'classes'));
    }
}
