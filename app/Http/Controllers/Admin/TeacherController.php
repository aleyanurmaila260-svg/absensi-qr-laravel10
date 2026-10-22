<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = User::where('role', 'guru')->latest()->paginate(15);

        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'guru';

        User::create($data);

        return redirect()->route('admin.teachers.index')->with('status', 'Guru berhasil ditambahkan.');
    }

    public function edit(User $teacher)
    {
        abort_unless($teacher->role === 'guru', 404);

        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, User $teacher)
    {
        abort_unless($teacher->role === 'guru', 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $teacher->id],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $teacher->update($data);

        return redirect()->route('admin.teachers.index')->with('status', 'Data guru berhasil diperbarui.');
    }

    public function destroy(User $teacher)
    {
        abort_unless($teacher->role === 'guru', 404);

        $teacher->delete();

        return back()->with('status', 'Data guru berhasil dihapus.');
    }
}
