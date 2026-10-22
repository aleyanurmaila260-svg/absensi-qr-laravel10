<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'qr_location_id', 'qr_token_id', 'scan_time',
        'status', 'latitude', 'longitude', 'device_info',
    ];

    protected $casts = ['scan_time' => 'datetime'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function location()
    {
        return $this->belongsTo(QrLocation::class, 'qr_location_id');
    }

    public function qrToken()
    {
        return $this->belongsTo(QrToken::class, 'qr_token_id');
    }
}
