<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::withCount('students')->latest()->paginate(15);

        return view('admin.classes.index', compact('classes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255', 'unique:classes,name']]);

        SchoolClass::create($data);

        return back()->with('status', 'Kelas berhasil ditambahkan.');
    }

    public function update(Request $request, SchoolClass $class)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255', 'unique:classes,name,' . $class->id]]);

        $class->update($data);

        return back()->with('status', 'Kelas berhasil diperbarui.');
    }

    public function destroy(SchoolClass $class)
    {
        $class->delete();

        return back()->with('status', 'Kelas berhasil dihapus.');
    }
}
