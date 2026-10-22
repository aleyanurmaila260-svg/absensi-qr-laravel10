<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Services\QrTokenService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function __construct(protected QrTokenService $qrTokenService)
    {
    }

    /**
     * Endpoint ini hanya bisa diakses lewat middleware auth:sanctum (routes/api.php),
     * jadi validasi "apakah siswa sudah login?" otomatis tertangani di sana -
     * request tanpa token Bearer yang sah akan ditolak 401 sebelum sampai ke sini.
     */
    public function scan(Request $request)
    {
        $request->validate([
            'loc' => ['required', 'string'],   // kode lokasi dari payload QR, contoh: GERBANG
            'token' => ['required', 'string'], // token acak dari payload QR
            'sig' => ['required', 'string'],   // signature dari payload QR
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
        ]);

        $student = $request->user();

        // 2) Apakah QR code masih berlaku? 3) Apakah QR code berasal dari sistem (signature cocok)?
        [$qrToken, $error] = $this->qrTokenService->validate($request->loc, $request->token, $request->sig);

        if ($error) {
            return response()->json(['message' => $error], 422);
        }

        $location = $qrToken->location;

        // Cegah absen dobel: satu siswa hanya bisa absen sekali per lokasi per hari
        $alreadyScannedToday = Attendance::where('student_id', $student->id)
            ->where('qr_location_id', $location->id)
            ->whereDate('scan_time', now()->toDateString())
            ->exists();

        if ($alreadyScannedToday) {
            return response()->json(['message' => "Anda sudah melakukan presensi di {$location->name} hari ini."], 409);
        }

        $now = now();
        $status = 'hadir';

        if ($location->cutoff_time) {
            $cutoff = $now->copy()->setTimeFromTimeString($location->cutoff_time);
            $status = $now->greaterThan($cutoff) ? 'telat' : 'hadir';
        }

        $attendance = Attendance::create([
            'student_id' => $student->id,
            'qr_location_id' => $location->id,
            'qr_token_id' => $qrToken->id,
            'scan_time' => $now,
            'status' => $status,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'device_info' => $request->userAgent(),
        ]);

        return response()->json([
            'message' => "Presensi di {$location->name} berhasil dicatat.",
            'status' => $status,
            'attendance' => $attendance,
        ]);
    }

    // Riwayat scan siswa
    public function history(Request $request)
    {
        $attendances = Attendance::with('location')
            ->where('student_id', $request->user()->id)
            ->latest('scan_time')
            ->paginate(20);

        return response()->json($attendances);
    }

    // Status absensi hari ini per lokasi, ditampilkan di layar utama aplikasi
    public function todayStatus(Request $request)
    {
        $attendances = Attendance::with('location')
            ->where('student_id', $request->user()->id)
            ->whereDate('scan_time', now()->toDateString())
            ->get();

        return response()->json($attendances);
    }
}
