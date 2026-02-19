<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\SupabaseService;
use App\Services\CloudinaryService;

class BayarController extends Controller
{
    public function index()
    {
        $cars = collect(SupabaseService::getAll('cars', '*', [], 'created_at.desc'))
            ->map(fn($item) => (object) $item);
        $drivers = collect(SupabaseService::getAll('drivers', '*', [], 'created_at.desc'))
            ->map(fn($item) => (object) $item);
        $bayars = collect(SupabaseService::getAll('bayars', '*', [], 'created_at.desc'))
            ->map(fn($item) => (object) $item);
        return view('admin.bayars.index', compact('bayars', 'cars', 'drivers'));
    }

    public function create()
    {
        return view('admin.bayars.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaku' => 'required|string',
            'mobilrental' => 'required|string',
            'driverrental' => 'nullable|string',
            'bukti' => 'required|image',
        ]);

        $cloudinary = CloudinaryService::upload($request->file('bukti'), 'rentalmobilmar/bayars');
        $slug = Str::slug($request->namaku, '-') . '-' . time();

        SupabaseService::create('bayars', [
            'namaku' => $request->namaku,
            'mobilrental' => $request->mobilrental,
            'driverrental' => $request->driverrental,
            'bukti' => $cloudinary['url'],
            'bukti_public_id' => $cloudinary['public_id'],
            'slug' => $slug,
        ]);

        return redirect()->route('admin.bayars.index')->with([
            'message' => 'Data pembayaran berhasil ditambahkan!',
            'alert-type' => 'success'
        ]);
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $bayarData = SupabaseService::getById('bayars', $id);
        if (!$bayarData) abort(404);
        $bayar = (object) $bayarData;
        return view('admin.bayars.edit', compact('bayar'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'namaku' => 'required|string',
            'mobilrental' => 'required|string',
            'driverrental' => 'nullable|string',
        ]);

        $slug = Str::slug($request->namaku, '-');

        SupabaseService::update('bayars', $id, [
            'namaku' => $request->namaku,
            'mobilrental' => $request->mobilrental,
            'driverrental' => $request->driverrental,
            'slug' => $slug,
        ]);

        return redirect()->route('admin.bayars.index')->with([
            'message' => 'Data pembayaran berhasil diupdate!',
            'alert-type' => 'info'
        ]);
    }

    /**
     * DELETE — Rental selesai: hapus bayar + otomatis kembalikan status mobil & driver ke 'tersedia'
     */
    public function destroy($id)
    {
        $bayar = SupabaseService::getById('bayars', $id);
        if ($bayar) {
            // Hapus bukti dari Cloudinary
            CloudinaryService::delete($bayar['bukti_public_id'] ?? null);

            // Auto-release mobil ke 'tersedia'
            $car = SupabaseService::getByColumn('cars', 'nama_mobil', $bayar['mobilrental']);
            if ($car) {
                SupabaseService::update('cars', $car['id'], ['status' => 'tersedia']);
            }

            // Auto-release driver ke 'tersedia'
            if ($bayar['driverrental'] && $bayar['driverrental'] !== 'Tidak Pakai Driver') {
                $driver = SupabaseService::getByColumn('drivers', 'nama_driver', $bayar['driverrental']);
                if ($driver) {
                    SupabaseService::update('drivers', $driver['id'], ['status' => 'tersedia']);
                }
            }

            // Hapus record bayar
            SupabaseService::delete('bayars', $id);
        }

        return redirect()->back()->with([
            'message' => 'Rental selesai! Kendaraan & driver sudah tersedia kembali.',
            'alert-type' => 'success'
        ]);
    }

    public function updateImage(Request $request, $bayarId)
    {
        $request->validate(['bukti' => 'required|image']);
        $bayar = SupabaseService::getById('bayars', $bayarId);
        if (!$bayar) abort(404);

        CloudinaryService::delete($bayar['bukti_public_id'] ?? null);
        $cloudinary = CloudinaryService::upload($request->file('bukti'), 'rentalmobilmar/bayars');

        SupabaseService::update('bayars', $bayarId, [
            'bukti' => $cloudinary['url'],
            'bukti_public_id' => $cloudinary['public_id'],
        ]);

        return redirect()->back()->with([
            'message' => 'Bukti pembayaran berhasil diupdate!',
            'alert-type' => 'info'
        ]);
    }
}
