<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SupabaseService;

class UserController extends Controller
{
    public function index()
    {
        $users = collect(SupabaseService::getAll('users', '*', [], 'created_at.desc'))
            ->map(fn($item) => (object) $item);
        return view('admin.users.index', compact('users'));
    }

    public function destroy($id)
    {
        SupabaseService::delete('users', $id);

        return redirect()->back()->with([
            'message' => 'User berhasil dihapus!',
            'alert-type' => 'success'
        ]);
    }
}
