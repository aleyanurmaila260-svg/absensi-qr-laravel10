<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qr_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qr_location_id')->constrained('qr_locations')->cascadeOnDelete();
            $table->string('token')->unique(); // kode acak unik per rotasi
            $table->string('signature'); // HMAC-SHA256(location_code|token|issued_at, secret_key)
            $table->dateTime('issued_at');
            $table->dateTime('expires_at'); // masa berlaku singkat, misal 30-60 detik
            $table->timestamps();

            $table->index(['qr_location_id', 'expires_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qr_tokens');
    }
};
