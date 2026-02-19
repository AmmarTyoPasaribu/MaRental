<?php

/**
 * Seeder Script — Upload gambar ke Cloudinary & Insert data ke Supabase
 * Jalankan: php artisan tinker < seed_data.php
 */

use App\Services\CloudinaryService;
use App\Services\SupabaseService;
use Illuminate\Support\Str;

echo "🚗 Mulai seeding data...\n\n";

// ============================================
// DATA MOBIL
// ============================================
$carImages = glob(storage_path('app/public/assets/cars/*.jpg'));
$carNames = [
    'Toyota Avanza',
    'Honda Brio',
    'Mitsubishi Xpander',
    'Daihatsu Xenia',
    'Toyota Fortuner',
    'Suzuki Ertiga',
    'Honda CR-V',
    'Toyota Innova',
];

$carSpecs = [
    ['harga_sewa' => 350000, 'bahan_bakar' => 'Bensin', 'jumlah_kursi' => 7, 'transmisi' => 'Manual', 'deskripsi' => 'MPV keluarga yang irit dan nyaman untuk perjalanan jauh.', 'nomor_mobil' => 'DD 1234 MA'],
    ['harga_sewa' => 250000, 'bahan_bakar' => 'Bensin', 'jumlah_kursi' => 5, 'transmisi' => 'Matic', 'deskripsi' => 'City car compact yang lincah untuk dalam kota.', 'nomor_mobil' => 'DD 5678 HR'],
    ['harga_sewa' => 400000, 'bahan_bakar' => 'Bensin', 'jumlah_kursi' => 7, 'transmisi' => 'Matic', 'deskripsi' => 'MPV modern dengan desain sporty dan fitur lengkap.', 'nomor_mobil' => 'DD 9012 XP'],
    ['harga_sewa' => 300000, 'bahan_bakar' => 'Bensin', 'jumlah_kursi' => 7, 'transmisi' => 'Manual', 'deskripsi' => 'MPV ekonomis cocok untuk keluarga besar.', 'nomor_mobil' => 'DD 3456 XN'],
    ['harga_sewa' => 700000, 'bahan_bakar' => 'Diesel', 'jumlah_kursi' => 7, 'transmisi' => 'Matic', 'deskripsi' => 'SUV premium dengan tenaga besar dan fitur offroad.', 'nomor_mobil' => 'DD 7890 FT'],
    ['harga_sewa' => 350000, 'bahan_bakar' => 'Bensin', 'jumlah_kursi' => 7, 'transmisi' => 'Matic', 'deskripsi' => 'MPV nyaman dengan kabin luas dan AC dingin.', 'nomor_mobil' => 'DD 2345 ER'],
    ['harga_sewa' => 550000, 'bahan_bakar' => 'Bensin', 'jumlah_kursi' => 5, 'transmisi' => 'Matic', 'deskripsi' => 'SUV mewah dengan interior premium dan berkendara halus.', 'nomor_mobil' => 'DD 6789 CV'],
    ['harga_sewa' => 450000, 'bahan_bakar' => 'Diesel', 'jumlah_kursi' => 7, 'transmisi' => 'Matic', 'deskripsi' => 'MPV legendaris yang tangguh dan nyaman untuk jarak jauh.', 'nomor_mobil' => 'DD 0123 IN'],
];

echo "📸 Upload " . count($carImages) . " gambar mobil ke Cloudinary...\n";

foreach ($carImages as $i => $imagePath) {
    if ($i >= count($carNames)) break;

    $name = $carNames[$i];
    $specs = $carSpecs[$i];

    echo "  [$i] Uploading: $name... ";

    try {
        // Upload ke Cloudinary
        $uploadedFile = new \Illuminate\Http\UploadedFile($imagePath, basename($imagePath), 'image/jpeg', null, true);
        $cloudinary = CloudinaryService::upload($uploadedFile, 'rentalmobilmar/cars');

        // Insert ke Supabase
        $result = SupabaseService::create('cars', [
            'nama_mobil' => $name,
            'slug' => Str::slug($name),
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

        echo "✅ Done!\n";
    } catch (\Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }
}

// ============================================
// DATA DRIVER
// ============================================
$driverImages = glob(storage_path('app/public/assets/drivers/*.jpg'));
$driverNames = [
    'Ahmad Fauzi',
    'Budi Santoso',
    'Cahyo Pratama',
    'Dimas Saputra',
    'Eko Wijaya',
];

echo "\n📸 Upload " . count($driverImages) . " gambar driver ke Cloudinary...\n";

foreach ($driverImages as $i => $imagePath) {
    if ($i >= count($driverNames)) break;

    $name = $driverNames[$i];

    echo "  [$i] Uploading: $name... ";

    try {
        $uploadedFile = new \Illuminate\Http\UploadedFile($imagePath, basename($imagePath), 'image/jpeg', null, true);
        $cloudinary = CloudinaryService::upload($uploadedFile, 'rentalmobilmar/drivers');

        $result = SupabaseService::create('drivers', [
            'nama_driver' => $name,
            'slug' => Str::slug($name),
            'gambar_sim' => $cloudinary['url'],
            'gambar_sim_public_id' => $cloudinary['public_id'],
            'gender' => 'tersedia',
        ]);

        echo "✅ Done!\n";
    } catch (\Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }
}

echo "\n🎉 Seeding selesai!\n";
