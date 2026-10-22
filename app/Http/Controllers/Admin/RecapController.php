<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;

class RecapController extends Controller
{
    // Rekap: total hadir/telat per siswa dalam rentang tanggal tertentu
    public function index(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->toDateString());
        $dateTo = $request->input('date_to', now()->toDateString());
        $classId = $request->input('class_id');

        $studentsQuery = Student::with('schoolClass')->when($classId, fn ($q) => $q->where('class_id', $classId));
        $students = $studentsQuery->get();

        $recap = $students->map(function (Student $student) use ($dateFrom, $dateTo) {
            $attendances = Attendance::where('student_id', $student->id)
                ->whereBetween('scan_time', ["{$dateFrom} 00:00:00", "{$dateTo} 23:59:59"])
                ->get();

            return [
                'student' => $student,
                'hadir' => $attendances->where('status', 'hadir')->count(),
                'telat' => $attendances->where('status', 'telat')->count(),
                'total_scan' => $attendances->count(),
            ];
        });

        $classes = SchoolClass::all();

        return view('admin.recap.index', compact('recap', 'classes', 'dateFrom', 'dateTo', 'classId'));
    }

    // Cetak laporan sebagai PDF (dompdf), untuk periode & kelas yang sama dengan rekap
    public function print(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->toDateString());
        $dateTo = $request->input('date_to', now()->toDateString());
        $classId = $request->input('class_id');

        $studentsQuery = Student::with('schoolClass')->when($classId, fn ($q) => $q->where('class_id', $classId));
        $students = $studentsQuery->get();

        $recap = $students->map(function (Student $student) use ($dateFrom, $dateTo) {
            $attendances = Attendance::where('student_id', $student->id)
                ->whereBetween('scan_time', ["{$dateFrom} 00:00:00", "{$dateTo} 23:59:59"])
                ->get();

            return [
                'student' => $student,
                'hadir' => $attendances->where('status', 'hadir')->count(),
                'telat' => $attendances->where('status', 'telat')->count(),
            ];
        });

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.recap.print', compact('recap', 'dateFrom', 'dateTo'));

        return $pdf->download("laporan-absensi-{$dateFrom}-sd-{$dateTo}.pdf");
    }
}
