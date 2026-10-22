<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrLocation extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'secret_key', 'cutoff_time', 'is_active'];

    protected $hidden = ['secret_key']; // jangan pernah ikut terkirim ke response

    protected $casts = ['is_active' => 'boolean'];

    public function tokens()
    {
        return $this->hasMany(QrToken::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function latestActiveToken()
    {
        return $this->tokens()->where('expires_at', '>', now())->latest('issued_at')->first();
    }
}
