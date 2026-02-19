<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SupabaseService
{
    protected static function baseUrl()
    {
        return config('supabase.url') . '/rest/v1';
    }

    protected static function headers($token = null)
    {
        $key = $token ?? config('supabase.key');
        return [
            'apikey' => config('supabase.key'),
            'Authorization' => 'Bearer ' . $key,
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation',
        ];
    }

    /**
     * GET — Ambil semua data dari tabel
     * @param string $table
     * @param string $select (kolom yang dimau, default *)
     * @param array $filters ['column' => 'eq.value']
     * @param string|null $order 'column.desc' atau 'column.asc'
     * @return array
     */
    public static function getAll($table, $select = '*', $filters = [], $order = null)
    {
        $query = ['select' => $select];

        foreach ($filters as $key => $value) {
            $query[$key] = $value;
        }

        if ($order) {
            $query['order'] = $order;
        }

        $response = Http::withHeaders(self::headers())
            ->get(self::baseUrl() . '/' . $table, $query);

        return $response->json() ?? [];
    }

    /**
     * GET — Ambil satu data by ID
     */
    public static function getById($table, $id, $select = '*')
    {
        $response = Http::withHeaders(self::headers())
            ->get(self::baseUrl() . '/' . $table, [
                'select' => $select,
                'id' => 'eq.' . $id,
            ]);

        $data = $response->json();
        return $data[0] ?? null;
    }

    /**
     * GET — Ambil satu data by slug
     */
    public static function getBySlug($table, $slug, $select = '*')
    {
        $response = Http::withHeaders(self::headers())
            ->get(self::baseUrl() . '/' . $table, [
                'select' => $select,
                'slug' => 'eq.' . $slug,
            ]);

        $data = $response->json();
        return $data[0] ?? null;
    }

    /**
     * GET — Ambil satu data by column value
     */
    public static function getByColumn($table, $column, $value, $select = '*')
    {
        $response = Http::withHeaders(self::headers())
            ->get(self::baseUrl() . '/' . $table, [
                'select' => $select,
                $column => 'eq.' . $value,
            ]);

        $data = $response->json();
        return $data[0] ?? null;
    }

    /**
     * GET — Search / LIKE query
     */
    public static function search($table, $column, $keyword, $select = '*', $order = null)
    {
        $query = [
            'select' => $select,
            $column => 'ilike.*' . $keyword . '*',
        ];

        if ($order) {
            $query['order'] = $order;
        }

        $response = Http::withHeaders(self::headers())
            ->get(self::baseUrl() . '/' . $table, $query);

        return $response->json() ?? [];
    }

    /**
     * POST — Insert data baru
     * @return array data yang baru di-insert
     */
    public static function create($table, $data)
    {
        $response = Http::withHeaders(self::headers())
            ->post(self::baseUrl() . '/' . $table, $data);

        $result = $response->json();
        return is_array($result) && isset($result[0]) ? $result[0] : $result;
    }

    /**
     * PATCH — Update data by ID
     */
    public static function update($table, $id, $data)
    {
        $response = Http::withHeaders(self::headers())
            ->patch(self::baseUrl() . '/' . $table . '?id=eq.' . $id, $data);

        $result = $response->json();
        return is_array($result) && isset($result[0]) ? $result[0] : $result;
    }

    /**
     * DELETE — Hapus data by ID
     */
    public static function delete($table, $id)
    {
        $response = Http::withHeaders(self::headers())
            ->delete(self::baseUrl() . '/' . $table . '?id=eq.' . $id);

        return $response->successful();
    }

    /**
     * PATCH — Update satu kolom saja
     */
    public static function updateColumn($table, $id, $column, $value)
    {
        return self::update($table, $id, [$column => $value]);
    }
}
