<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\SupabaseService;
use App\Services\CloudinaryService;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = collect(SupabaseService::getAll('drivers', '*', [], 'created_at.desc'))
            ->map(fn($item) => (object) $item);
        return view('admin.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('admin.drivers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_driver' => 'required|string',
            'gambar_sim' => 'required|image',
            'gender' => 'required|string',
        ]);

        $cloudinary = CloudinaryService::upload($request->file('gambar_sim'), 'rentalmobilmar/drivers');
        $slug = Str::slug($request->nama_driver, '-');

        SupabaseService::create('drivers', [
            'nama_driver' => $request->nama_driver,
            'slug' => $slug,
            'gambar_sim' => $cloudinary['url'],
            'gambar_sim_public_id' => $cloudinary['public_id'],
            'gender' => $request->gender,
        ]);

        return redirect()->route('admin.drivers.index')->with([
            'message' => 'Data driver berhasil ditambahkan!',
            'alert-type' => 'success'
        ]);
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $driverData = SupabaseService::getById('drivers', $id);
        if (!$driverData) abort(404);
        $driver = (object) $driverData;
        return view('admin.drivers.edit', compact('driver'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_driver' => 'required|string',
            'gender' => 'required|string',
        ]);

        $slug = Str::slug($request->nama_driver, '-');

        SupabaseService::update('drivers', $id, [
            'nama_driver' => $request->nama_driver,
            'slug' => $slug,
            'gender' => $request->gender,
        ]);

        return redirect()->route('admin.drivers.index')->with([
            'message' => 'Data driver berhasil diupdate!',
            'alert-type' => 'info'
        ]);
    }

    public function destroy($id)
    {
        $driver = SupabaseService::getById('drivers', $id);
        if ($driver) {
            CloudinaryService::delete($driver['gambar_sim_public_id'] ?? null);
            SupabaseService::delete('drivers', $id);
        }

        return redirect()->back()->with([
            'message' => 'Data driver berhasil dihapus!',
            'alert-type' => 'danger'
        ]);
    }

    public function updateImage(Request $request, $driverId)
    {
        $request->validate(['gambar_sim' => 'required|image']);
        $driver = SupabaseService::getById('drivers', $driverId);
        if (!$driver) abort(404);

        CloudinaryService::delete($driver['gambar_sim_public_id'] ?? null);
        $cloudinary = CloudinaryService::upload($request->file('gambar_sim'), 'rentalmobilmar/drivers');

        SupabaseService::update('drivers', $driverId, [
            'gambar_sim' => $cloudinary['url'],
            'gambar_sim_public_id' => $cloudinary['public_id'],
        ]);

        return redirect()->back()->with([
            'message' => 'Gambar driver berhasil diupdate!',
            'alert-type' => 'info'
        ]);
    }
}
