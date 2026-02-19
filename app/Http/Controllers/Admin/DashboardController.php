<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SupabaseService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $cars = collect(SupabaseService::getAll('cars', '*', [], 'created_at.desc'))
            ->map(fn($item) => (object) $item);
        $drivers = collect(SupabaseService::getAll('drivers', '*', [], 'created_at.desc'))
            ->map(fn($item) => (object) $item);
        $bayars = collect(SupabaseService::getAll('bayars', '*', [], 'created_at.desc'))
            ->map(fn($item) => (object) $item);
        $users = collect(SupabaseService::getAll('users', '*', [], 'created_at.desc'))
            ->map(fn($item) => (object) $item);

        return view('admin.dashboard', compact('cars', 'drivers', 'bayars', 'users'));
    }
}
