<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\SupabaseService;
use App\Services\SupabaseAuthService;
use App\Services\CloudinaryService;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search') && $request->input('search')) {
            $cars = SupabaseService::search('cars', 'nama_mobil', $request->input('search'), '*', 'created_at.desc');
            $drivers = SupabaseService::search('drivers', 'nama_driver', $request->input('search'), '*', 'created_at.desc');
        } elseif ($request->has('searcha') && $request->input('searcha')) {
            $cars = SupabaseService::getAll('cars', '*', ['status' => 'eq.' . $request->input('searcha')], 'created_at.desc');
            $drivers = SupabaseService::getAll('drivers', '*', ['status' => 'eq.' . $request->input('searcha')], 'created_at.desc');
        } else {
            $cars = SupabaseService::getAll('cars', '*', [], 'created_at.desc');
            $drivers = SupabaseService::getAll('drivers', '*', [], 'created_at.desc');
        }

        // Convert arrays to objects for Blade compatibility
        $cars = collect($cars)->map(fn($item) => (object) $item);
        $drivers = collect($drivers)->map(fn($item) => (object) $item);

        return view('frontend.homepage', compact('cars', 'drivers'));
    }

    public function contact($slug = null)
    {
        if (!SupabaseAuthService::check()) {
            return redirect()->route('login');
        }

        $car = null;
        if ($slug) {
            $carData = SupabaseService::getBySlug('cars', $slug);
            if ($carData) {
                $car = (object) $carData;
            }
        }
        $drivers = collect(SupabaseService::getAll('drivers', '*', [], 'created_at.desc'))
            ->map(fn($item) => (object) $item)
            ->filter(fn($d) => ($d->status ?? 'tersedia') === 'tersedia');
        return view('frontend.contact', compact('car', 'drivers'));
    }

    public function detail($slug)
    {
        $carData = SupabaseService::getBySlug('cars', $slug);
        if (!$carData) {
            abort(404);
        }
        $car = (object) $carData;
        return view('frontend.detail', compact('car'));
    }

    public function contactStore(Request $request)
    {
        $request->validate([
            'namaku' => 'required|string',
            'mobilrental' => 'required|string',
            'driverrental' => 'nullable|string',
            'bukti' => 'required|image',
        ]);

        $cloudinary = CloudinaryService::upload($request->file('bukti'), 'rentalmobilmar/bayars');
        $slug = Str::slug($request->namaku, '-') . '-' . time();

        // Create bayar record
        SupabaseService::create('bayars', [
            'namaku' => $request->namaku,
            'mobilrental' => $request->mobilrental,
            'driverrental' => $request->driverrental,
            'bukti' => $cloudinary['url'],
            'bukti_public_id' => $cloudinary['public_id'],
            'slug' => $slug,
        ]);

        // Auto-update car status to terbooking
        $car = SupabaseService::getByColumn('cars', 'nama_mobil', $request->mobilrental);
        if ($car) {
            SupabaseService::update('cars', $car['id'], ['status' => 'terbooking']);
        }

        // Auto-update driver status to terbooking (if driver selected)
        if ($request->driverrental && $request->driverrental !== 'Tidak Pakai Driver') {
            $driver = SupabaseService::getByColumn('drivers', 'nama_driver', $request->driverrental);
            if ($driver) {
                SupabaseService::update('drivers', $driver['id'], ['status' => 'terbooking']);
            }
        }

        return redirect()->route('homepage')->with([
            'message' => 'Pesanan berhasil! Mobil ' . $request->mobilrental . ' sedang diproses.',
            'alert-type' => 'success'
        ]);
    }

    public function myRentals()
    {
        if (!SupabaseAuthService::check()) {
            return redirect()->route('login');
        }

        $user = SupabaseAuthService::user();
        $bayars = SupabaseService::getAll('bayars', '*', ['namaku' => 'eq.' . $user['name']], 'created_at.desc');
        $cars = SupabaseService::getAll('cars', '*', [], 'created_at.desc');
        $drivers = SupabaseService::getAll('drivers', '*', [], 'created_at.desc');

        $bayars = collect($bayars)->map(fn($item) => (object) $item);
        $cars = collect($cars)->map(fn($item) => (object) $item);
        $drivers = collect($drivers)->map(fn($item) => (object) $item);

        return view('frontend.myrentals', compact('bayars', 'cars', 'drivers'));
    }

    public function profile()
    {
        if (!SupabaseAuthService::check()) {
            return redirect()->route('login');
        }
        return view('frontend.profile');
    }

    public function updateprofile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = SupabaseAuthService::user();
        $updateData = ['name' => $request->input('name')];

        if ($request->input('email') !== $user['email']) {
            $updateData['email'] = $request->input('email');
        }

        SupabaseAuthService::updateUser($user['id'], $updateData);

        if ($request->filled('password')) {
            SupabaseAuthService::updatePassword($user['id'], $request->input('password'));
        }

        return redirect()->route('homepage')->with([
            'message' => 'Profil berhasil diupdate!',
            'alert-type' => 'info'
        ]);
    }
}
