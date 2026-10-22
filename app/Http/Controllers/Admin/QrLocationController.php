<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QrLocation;
use App\Services\QrTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrLocationController extends Controller
{
    public function __construct(protected QrTokenService $qrTokenService)
    {
    }

    public function index()
    {
        $locations = QrLocation::latest()->get();

        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.locations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:30', 'unique:qr_locations,code'],
            'name' => ['required', 'string', 'max:255'],
            'cutoff_time' => ['nullable', 'date_format:H:i'],
        ]);

        $data['code'] = strtoupper(str_replace(' ', '-', $data['code']));
        $data['secret_key'] = Str::random(40);
        $data['is_active'] = true;

        QrLocation::create($data);

        return redirect()->route('admin.locations.index')->with('status', 'Lokasi QR berhasil ditambahkan.');
    }

    public function toggle(QrLocation $location)
    {
        $location->update(['is_active' => ! $location->is_active]);

        return back()->with('status', 'Status lokasi berhasil diperbarui.');
    }

    public function destroy(QrLocation $location)
    {
        $location->delete();

        return back()->with('status', 'Lokasi berhasil dihapus.');
    }

    // Layar QR yang berjalan untuk satu lokasi (dipajang di gerbang/lab, dsb)
    public function display(QrLocation $location)
    {
        return view('admin.locations.display', compact('location'));
    }

    // Dipanggil via AJAX oleh halaman display setiap beberapa detik untuk mengambil token terbaru
    public function refresh(QrLocation $location)
    {
        $token = $location->latestActiveToken() ?? $this->qrTokenService->generate($location);

        $svg = base64_encode(
            QrCode::format('svg')->size(280)->generate(json_encode($token->toPayload()))
        );

        return response()->json([
            'qr_svg_base64' => $svg,
            'expires_in' => now()->diffInSeconds($token->expires_at, false),
        ]);
    }
}
