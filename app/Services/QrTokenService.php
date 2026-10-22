<?php

namespace App\Services;

use App\Models\QrLocation;
use App\Models\QrToken;
use Illuminate\Support\Str;

class QrTokenService
{
    // Masa berlaku satu token QR. Diperpendek supaya screenshot cepat basi.
    const TOKEN_LIFETIME_SECONDS = 30;

    /**
     * Buat token baru untuk sebuah lokasi. Dipanggil admin saat generate QR,
     * dan otomatis dipanggil ulang oleh endpoint refresh setiap TOKEN_LIFETIME_SECONDS.
     */
    public function generate(QrLocation $location): QrToken
    {
        $token = Str::random(24);
        $issuedAt = now();
        $expiresAt = $issuedAt->copy()->addSeconds(self::TOKEN_LIFETIME_SECONDS);

        $signature = $this->sign($location->code, $token, $issuedAt->timestamp, $location->secret_key);

        return QrToken::create([
            'qr_location_id' => $location->id,
            'token' => $token,
            'signature' => $signature,
            'issued_at' => $issuedAt,
            'expires_at' => $expiresAt,
        ]);
    }

    /**
     * Validasi payload yang dikirim aplikasi mobile hasil scan QR.
     * Mengembalikan [QrToken, null] jika valid, atau [null, alasan] jika ditolak.
     */
    public function validate(string $locationCode, string $token, string $signature): array
    {
        $location = QrLocation::where('code', $locationCode)->where('is_active', true)->first();

        if (! $location) {
            return [null, 'Lokasi QR tidak ditemukan atau nonaktif.'];
        }

        $qrToken = QrToken::where('qr_location_id', $location->id)
            ->where('token', $token)
            ->first();

        if (! $qrToken) {
            return [null, 'Kode QR tidak dikenali.'];
        }

        if ($qrToken->isExpired()) {
            return [null, 'Kode QR sudah kedaluwarsa, silakan scan ulang.'];
        }

        // Kunci anti-manipulasi: signature dihitung ulang di server dan
        // dibandingkan dengan yang dikirim klien. Kalau payload QR diubah
        // manual, signature tidak akan cocok.
        $expectedSignature = $this->sign($location->code, $token, $qrToken->issued_at->timestamp, $location->secret_key);

        if (! hash_equals($expectedSignature, $signature)) {
            return [null, 'Kode QR tidak sah / terindikasi dimanipulasi.'];
        }

        return [$qrToken, null];
    }

    protected function sign(string $locationCode, string $token, int $issuedAtTimestamp, string $secretKey): string
    {
        return hash_hmac('sha256', "{$locationCode}|{$token}|{$issuedAtTimestamp}", $secretKey);
    }
}
