<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ClearData extends Command
{
    protected $signature = 'clear:data';
    protected $description = 'Delete all cars, drivers, bayars from Supabase';

    public function handle()
    {
        $url = config('supabase.url') . '/rest/v1/';
        $key = config('supabase.key');
        $headers = [
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
        ];

        $this->info('🗑️ Menghapus semua data...');

        Http::withHeaders($headers)->delete($url . 'bayars?id=gt.0');
        $this->info('  ✅ bayars dihapus');

        Http::withHeaders($headers)->delete($url . 'cars?id=gt.0');
        $this->info('  ✅ cars dihapus');

        Http::withHeaders($headers)->delete($url . 'drivers?id=gt.0');
        $this->info('  ✅ drivers dihapus');

        $this->info('🎉 Semua data berhasil dihapus!');
    }
}
