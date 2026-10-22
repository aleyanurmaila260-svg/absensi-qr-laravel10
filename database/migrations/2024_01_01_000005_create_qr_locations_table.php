<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qr_locations', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // contoh: GERBANG, LAB-RPL, LOBI
            $table->string('name');
            $table->string('secret_key'); // dipakai untuk signature HMAC, jangan diekspos ke luar
            $table->time('cutoff_time')->nullable(); // batas waktu dianggap "tepat waktu", opsional
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qr_locations');
    }
};
