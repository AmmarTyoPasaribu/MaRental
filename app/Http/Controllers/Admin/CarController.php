<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\SupabaseService;
use App\Services\CloudinaryService;

class CarController extends Controller
{
    public function index()
    {
        $cars = collect(SupabaseService::getAll('cars', '*', [], 'created_at.desc'))
            ->map(fn($item) => (object) $item);
        return view('admin.cars.index', compact('cars'));
    }

    public function create()
    {
        return view('admin.cars.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mobil' => 'required|string',
            'harga_sewa' => 'required|numeric',
            'gambar' => 'required|image',
            'bahan_bakar' => 'required|string',
            'jumlah_kursi' => 'required|numeric',
            'transmisi' => 'required|string',
            'deskripsi' => 'required|string',
            'nomor_mobil' => 'required|string',
            'status' => 'required|string',
        ]);

        $cloudinary = CloudinaryService::upload($request->file('gambar'), 'rentalmobilmar/cars');
        $slug = Str::slug($request->nama_mobil, '-');

        SupabaseService::create('cars', [
            'nama_mobil' => $request->nama_mobil,
            'slug' => $slug,
            'harga_sewa' => $request->harga_sewa,
            'gambar' => $cloudinary['url'],
            'gambar_public_id' => $cloudinary['public_id'],
            'bahan_bakar' => $request->bahan_bakar,
            'jumlah_kursi' => $request->jumlah_kursi,
            'transmisi' => $request->transmisi,
            'deskripsi' => $request->deskripsi,
            'nomor_mobil' => $request->nomor_mobil,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.cars.index')->with([
            'message' => 'Data mobil berhasil ditambahkan!',
            'alert-type' => 'success'
        ]);
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $carData = SupabaseService::getById('cars', $id);
        if (!$carData) abort(404);
        $car = (object) $carData;
        return view('admin.cars.edit', compact('car'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_mobil' => 'required|string',
            'harga_sewa' => 'required|numeric',
            'bahan_bakar' => 'required|string',
            'jumlah_kursi' => 'required|numeric',
            'transmisi' => 'required|string',
            'deskripsi' => 'required|string',
            'nomor_mobil' => 'required|string',
            'status' => 'required|string',
        ]);

        $slug = Str::slug($request->nama_mobil, '-');

        SupabaseService::update('cars', $id, [
            'nama_mobil' => $request->nama_mobil,
            'slug' => $slug,
            'harga_sewa' => $request->harga_sewa,
            'bahan_bakar' => $request->bahan_bakar,
            'jumlah_kursi' => $request->jumlah_kursi,
            'transmisi' => $request->transmisi,
            'deskripsi' => $request->deskripsi,
            'nomor_mobil' => $request->nomor_mobil,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.cars.index')->with([
            'message' => 'Data mobil berhasil diupdate!',
            'alert-type' => 'info'
        ]);
    }

    public function destroy($id)
    {
        $car = SupabaseService::getById('cars', $id);
        if ($car) {
            CloudinaryService::delete($car['gambar_public_id'] ?? null);
            SupabaseService::delete('cars', $id);
        }

        return redirect()->back()->with([
            'message' => 'Data mobil berhasil dihapus!',
            'alert-type' => 'danger'
        ]);
    }

    public function updateImage(Request $request, $carId)
    {
        $request->validate(['gambar' => 'required|image']);
        $car = SupabaseService::getById('cars', $carId);
        if (!$car) abort(404);

        CloudinaryService::delete($car['gambar_public_id'] ?? null);
        $cloudinary = CloudinaryService::upload($request->file('gambar'), 'rentalmobilmar/cars');

        SupabaseService::update('cars', $carId, [
            'gambar' => $cloudinary['url'],
            'gambar_public_id' => $cloudinary['public_id'],
        ]);

        return redirect()->back()->with([
            'message' => 'Gambar mobil berhasil diupdate!',
            'alert-type' => 'info'
        ]);
    }
}
