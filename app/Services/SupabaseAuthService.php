<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SupabaseAuthService
{
    /**
     * Register user baru — simpan di tabel `users` via Supabase REST API
     */
    public static function register($name, $email, $password, $isAdmin = false)
    {
        // Cek apakah email sudah terdaftar
        $existing = SupabaseService::getAll('users', '*', ['email' => 'eq.' . $email]);
        if (!empty($existing)) {
            return ['error' => 'Email sudah terdaftar.'];
        }

        $user = SupabaseService::create('users', [
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'is_admin' => $isAdmin,
        ]);

        return $user;
    }

    /**
     * Login — cari user di tabel, verifikasi password
     */
    public static function login($email, $password)
    {
        $users = SupabaseService::getAll('users', '*', ['email' => 'eq.' . $email]);

        if (empty($users)) {
            return null;
        }

        $user = $users[0];

        if (!Hash::check($password, $user['password'])) {
            return null;
        }

        // Simpan user info di session
        Session::put('supabase_user', [
            'id' => $user['id'],
            'email' => $user['email'],
            'name' => $user['name'],
            'is_admin' => $user['is_admin'] ?? false,
        ]);

        return $user;
    }

    /**
     * Logout — hapus session
     */
    public static function logout()
    {
        Session::forget('supabase_user');
    }

    /**
     * Cek apakah user sedang login
     */
    public static function check()
    {
        return Session::has('supabase_user');
    }

    /**
     * Ambil user yang sedang login
     */
    public static function user()
    {
        return Session::get('supabase_user');
    }

    /**
     * Cek apakah user adalah admin
     */
    public static function isAdmin()
    {
        $user = self::user();
        return $user && ($user['is_admin'] ?? false);
    }

    /**
     * Update profil user (nama/email)
     */
    public static function updateUser($id, $data)
    {
        $result = SupabaseService::update('users', $id, $data);

        // Update session juga
        $user = Session::get('supabase_user');
        if (isset($data['name'])) $user['name'] = $data['name'];
        if (isset($data['email'])) $user['email'] = $data['email'];
        Session::put('supabase_user', $user);

        return $result;
    }

    /**
     * Update password user
     */
    public static function updatePassword($id, $newPassword)
    {
        return SupabaseService::update('users', $id, [
            'password' => Hash::make($newPassword),
        ]);
    }
}
