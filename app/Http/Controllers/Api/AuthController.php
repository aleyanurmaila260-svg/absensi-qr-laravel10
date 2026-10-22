<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $student = Student::where('email', $request->email)->first();

        if (! $student || ! Hash::check($request->password, $student->password)) {
            throw ValidationException::withMessages(['email' => ['Email atau password salah.']]);
        }

        $token = $student->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'token' => $token,
            'student' => [
                'id' => $student->id,
                'name' => $student->name,
                'nis' => $student->nis,
                'class_id' => $student->class_id,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Berhasil logout.']);
    }

    // Digunakan untuk halaman profil siswa di aplikasi mobile
    public function me(Request $request)
    {
        $student = $request->user()->load('schoolClass');

        return response()->json($student);
    }
}
