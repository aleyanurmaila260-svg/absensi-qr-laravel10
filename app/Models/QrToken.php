<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrToken extends Model
{
    use HasFactory;

    protected $fillable = ['qr_location_id', 'token', 'signature', 'issued_at', 'expires_at'];

    protected $casts = [
        'issued_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function location()
    {
        return $this->belongsTo(QrLocation::class, 'qr_location_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function isExpired(): bool
    {
        return now()->greaterThan($this->expires_at);
    }

    // Payload inilah yang dijadikan konten QR image (bukan cuma "token" polos)
    public function toPayload(): array
    {
        return [
            'loc' => $this->location->code,
            'token' => $this->token,
            'sig' => $this->signature,
        ];
    }
}
