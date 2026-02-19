<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SupabaseAuthService;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (SupabaseAuthService::check()) {
            return redirect()->route('homepage');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $result = SupabaseAuthService::login($request->email, $request->password);

        if ($result) {
            $user = SupabaseAuthService::user();
            if ($user['is_admin'] ?? false) {
                return redirect()->route('admin.dashboard.index');
            }
            return redirect()->route('homepage')->with([
                'message' => 'Selamat datang, ' . $user['name'] . '!',
                'alert-type' => 'success'
            ]);
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    public function showRegisterForm()
    {
        if (SupabaseAuthService::check()) {
            return redirect()->route('homepage');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $result = SupabaseAuthService::register(
            $request->name,
            $request->email,
            $request->password
        );

        if (isset($result['error'])) {
            return back()->withErrors(['email' => $result['error']])->withInput();
        }

        if (isset($result['id'])) {
            // Auto-login setelah register
            SupabaseAuthService::login($request->email, $request->password);

            return redirect()->route('homepage')->with([
                'message' => 'Registrasi berhasil! Selamat datang!',
                'alert-type' => 'success'
            ]);
        }

        return back()->withErrors(['email' => 'Registrasi gagal. Coba lagi.'])->withInput();
    }

    public function logout()
    {
        SupabaseAuthService::logout();
        return redirect()->route('homepage')->with([
            'message' => 'Berhasil logout!',
            'alert-type' => 'info'
        ]);
    }
}
