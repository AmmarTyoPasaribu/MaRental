<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class AddDriverStatus extends Command
{
    protected $signature = 'db:add-driver-status';
    protected $description = 'Add status column to drivers table via Supabase RPC';

    public function handle()
    {
        $url = config('supabase.url');
        $key = config('supabase.key');
        $headers = [
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation',
        ];

        // Try to update all drivers with status field.
        // If the column doesn't exist, this will fail and we'll just inform.
        $drivers = Http::withHeaders($headers)
            ->get($url . '/rest/v1/drivers?select=id,nama_driver,status')
            ->json();

        if (isset($drivers['message']) || isset($drivers['code'])) {
            $this->warn('Column "status" belum ada di tabel drivers.');
            $this->info('');
            $this->info('Jalankan SQL ini di Supabase SQL Editor:');
            $this->line('');
            $this->line("ALTER TABLE drivers ADD COLUMN IF NOT EXISTS status VARCHAR(50) DEFAULT 'tersedia';");
            $this->line("UPDATE drivers SET status = 'tersedia';");
            $this->line('');
            $this->info('Kemudian tambahkan RLS policy:');
            $this->line("-- Jika belum ada policy untuk drivers, tambahkan:");
            $this->line("CREATE POLICY \"Allow public read drivers\" ON drivers FOR SELECT USING (true);");
            $this->line("CREATE POLICY \"Allow public update drivers\" ON drivers FOR UPDATE USING (true);");
            return;
        }

        $this->info('✅ Column "status" sudah ada! Saat ini:');
        foreach ($drivers as $d) {
            $this->line("  - {$d['nama_driver']}: {$d['status']}");
        }
    }
}
