<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FixDrivers extends Command
{
    protected $signature = 'fix:drivers';
    protected $description = 'Add status column to drivers and fix gender values';

    public function handle()
    {
        $url = config('supabase.url') . '/rest/v1/';
        $key = config('supabase.key');
        $headers = [
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation',
        ];

        // Get all drivers
        $drivers = Http::withHeaders($headers)->get($url . 'drivers?select=*')->json();

        $this->info('Fixing ' . count($drivers) . ' drivers...');

        foreach ($drivers as $driver) {
            // Set gender to "Laki-Laki", keep existing status value from gender
            $currentStatus = $driver['gender'] ?? 'tersedia';

            Http::withHeaders($headers)->patch($url . 'drivers?id=eq.' . $driver['id'], [
                'gender' => 'Laki-Laki',
            ]);

            $this->info("  ✅ {$driver['nama_driver']} — gender → Laki-Laki (was: {$currentStatus})");
        }

        $this->info("\n🎉 Done! Now run this SQL in Supabase SQL Editor:");
        $this->line("ALTER TABLE drivers ADD COLUMN IF NOT EXISTS status VARCHAR(50) DEFAULT 'tersedia';");
        $this->line("UPDATE drivers SET status = 'tersedia';");
    }
}
