<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Services\CloudinaryService;
use App\Services\SupabaseService;
use Illuminate\Http\UploadedFile;

class SeedData extends Command
{
    protected $signature = 'seed:data';
    protected $description = 'Upload images to Cloudinary and seed data to Supabase';

    public function handle()
    {
        $this->info('🚗 Mulai seeding data...');

        // ============================================
        // DATA MOBIL — dari folder storage/app/public/assets/Mobil
        // ============================================
        $mobilDir = storage_path('app/public/assets/Mobil');
        $carFiles = glob($mobilDir . '/*.jpg');

        $carSpecs = [
            'Bajaj'         => ['harga_sewa' => 150000, 'bahan_bakar' => 'Bensin', 'jumlah_kursi' => 3, 'transmisi' => 'Manual',  'deskripsi' => 'Kendaraan roda tiga yang lincah untuk dalam kota.', 'nomor_mobil' => 'DD 1111 BJ'],
            'Bentor'        => ['harga_sewa' => 100000, 'bahan_bakar' => 'Bensin', 'jumlah_kursi' => 2, 'transmisi' => 'Manual',  'deskripsi' => 'Becak motor khas Makassar, cocok untuk jarak pendek.', 'nomor_mobil' => 'DD 2222 BT'],
            'Mobil perang'  => ['harga_sewa' => 900000, 'bahan_bakar' => 'Diesel', 'jumlah_kursi' => 4, 'transmisi' => 'Manual',  'deskripsi' => 'Kendaraan tempur taktis dengan armor tebal.', 'nomor_mobil' => 'DD 3333 MP'],
            'Pesawat'       => ['harga_sewa' => 5000000,'bahan_bakar' => 'Avtur',  'jumlah_kursi' => 150,'transmisi' => 'Otomatis','deskripsi' => 'Pesawat penumpang untuk perjalanan antar kota.', 'nomor_mobil' => 'PK-MAR'],
            'Sport'         => ['harga_sewa' => 750000, 'bahan_bakar' => 'Bensin', 'jumlah_kursi' => 2, 'transmisi' => 'Matic',   'deskripsi' => 'Mobil sport bertenaga tinggi dengan desain aerodinamis.', 'nomor_mobil' => 'DD 4444 SP'],
            'Tank'          => ['harga_sewa' => 1500000,'bahan_bakar' => 'Diesel', 'jumlah_kursi' => 3, 'transmisi' => 'Manual',  'deskripsi' => 'Tank lapis baja untuk medan berat.', 'nomor_mobil' => 'DD 5555 TK'],
            'Truck'         => ['harga_sewa' => 500000, 'bahan_bakar' => 'Diesel', 'jumlah_kursi' => 3, 'transmisi' => 'Manual',  'deskripsi' => 'Truck besar untuk angkut barang berat.', 'nomor_mobil' => 'DD 6666 TR'],
            'Van'           => ['harga_sewa' => 400000, 'bahan_bakar' => 'Bensin', 'jumlah_kursi' => 8, 'transmisi' => 'Matic',   'deskripsi' => 'Van luas cocok untuk rombongan dan keluarga besar.', 'nomor_mobil' => 'DD 7777 VN'],
        ];

        $this->info("📸 Upload " . count($carFiles) . " gambar mobil ke Cloudinary...");

        foreach ($carFiles as $imagePath) {
            $filename = pathinfo($imagePath, PATHINFO_FILENAME); // e.g. "Bajaj"
            $specs = $carSpecs[$filename] ?? [
                'harga_sewa' => 300000, 'bahan_bakar' => 'Bensin', 'jumlah_kursi' => 4,
                'transmisi' => 'Matic', 'deskripsi' => 'Kendaraan rental.', 'nomor_mobil' => 'DD 0000 XX',
            ];

            $this->line("  Uploading: $filename...");

            try {
                $uploadedFile = new UploadedFile($imagePath, basename($imagePath), 'image/jpeg', null, true);
                $cloudinary = CloudinaryService::upload($uploadedFile, 'rentalmobilmar/cars');

                SupabaseService::create('cars', [
                    'nama_mobil' => $filename,
                    'slug' => Str::slug($filename),
                    'harga_sewa' => $specs['harga_sewa'],
                    'gambar' => $cloudinary['url'],
                    'gambar_public_id' => $cloudinary['public_id'],
                    'bahan_bakar' => $specs['bahan_bakar'],
                    'jumlah_kursi' => $specs['jumlah_kursi'],
                    'transmisi' => $specs['transmisi'],
                    'deskripsi' => $specs['deskripsi'],
                    'nomor_mobil' => $specs['nomor_mobil'],
                    'status' => 'tersedia',
                ]);

                $this->info("  ✅ $filename — done!");
            } catch (\Exception $e) {
                $this->error("  ❌ $filename — " . $e->getMessage());
            }
        }

        // ============================================
        // DATA DRIVER — dari folder storage/app/public/assets/Driver
        // ============================================
        $driverDir = storage_path('app/public/assets/Driver');
        $driverFiles = glob($driverDir . '/*.jpg');

        $this->info("\n📸 Upload " . count($driverFiles) . " gambar driver ke Cloudinary...");

        foreach ($driverFiles as $imagePath) {
            $filename = pathinfo($imagePath, PATHINFO_FILENAME); // e.g. "Alif"

            $this->line("  Uploading: $filename...");

            try {
                $uploadedFile = new UploadedFile($imagePath, basename($imagePath), 'image/jpeg', null, true);
                $cloudinary = CloudinaryService::upload($uploadedFile, 'rentalmobilmar/drivers');

                SupabaseService::create('drivers', [
                    'nama_driver' => $filename,
                    'slug' => Str::slug($filename),
                    'gambar_sim' => $cloudinary['url'],
                    'gambar_sim_public_id' => $cloudinary['public_id'],
                    'gender' => 'tersedia',
                ]);

                $this->info("  ✅ $filename — done!");
            } catch (\Exception $e) {
                $this->error("  ❌ $filename — " . $e->getMessage());
            }
        }

        $this->info("\n🎉 Seeding selesai!");
    }
}
