# MaRental 🚗

Aplikasi rental mobil online dengan fitur booking otomatis, manajemen driver, dan admin dashboard modern. Dibangun dengan Laravel + Supabase + Tailwind CSS.

---

## ✨ Fitur

- **Katalog Kendaraan** — Browse mobil tersedia dengan detail spesifikasi, harga, dan foto
- **Booking Otomatis** — Saat user rental, mobil & driver otomatis jadi *terbooking*
- **Pilih Driver** — Pilih driver tersedia atau rental tanpa driver
- **Upload Bukti** — Upload bukti pembayaran via Cloudinary
- **Riwayat Rental** — Halaman khusus lihat semua riwayat rental user
- **Admin Dashboard** — Stats overview, kelola kendaraan, driver, rental aktif, dan users
- **Auto-Release** — Admin tekan "Selesai", kendaraan & driver otomatis *tersedia* kembali
- **Auth System** — Register & login dengan password hashing (bcrypt)
- **Responsive** — Desktop & mobile friendly

---

## 🛠 Tech Stack

| Layer | Teknologi |
|---|---|
| Framework | Laravel 10 (PHP 8.2) |
| Frontend | Blade + Tailwind CSS (lokal via Vite) |
| Database | Supabase (PostgreSQL + REST API) |
| Storage | Cloudinary (upload gambar) |
| Auth | Custom session-based (bcrypt) |
| Hosting | Render |

---

## 📁 Struktur Utama

```
├── app/
│   ├── Http/Controllers/
│   │   ├── HomeController.php         # Frontend: homepage, detail, contact, rental
│   │   ├── Auth/AuthController.php    # Login, register, logout
│   │   └── Admin/                     # Dashboard, Cars, Drivers, Bayars, Users
│   └── Services/
│       ├── SupabaseService.php        # REST API client untuk Supabase
│       ├── SupabaseAuthService.php    # Auth (register, login, session)
│       └── CloudinaryService.php      # Upload gambar ke Cloudinary
├── resources/views/
│   ├── layouts/                       # admin.blade.php, frontend.blade.php
│   ├── frontend/                      # homepage, detail, contact, profile, login, register
│   └── admin/                         # dashboard, cars, drivers, bayars, users
├── routes/web.php                     # Semua route
├── vite.config.js                     # Vite + Tailwind build config
└── tailwind.config.js                 # Tailwind theme config
```

---

## 🚀 Setup Lokal

```bash
# 1. Clone repo
git clone https://github.com/USERNAME/rentalmobilmar.git
cd rentalmobilmar

# 2. Install dependencies
composer install
npm install

# 3. Copy environment
cp .env.example .env
php artisan key:generate

# 4. Isi .env (lihat bagian Environment Variables di bawah)

# 5. Build assets
npm run build

# 6. Jalankan
php artisan serve
```

---

## 🔑 Environment Variables

| Variable | Deskripsi |
|---|---|
| `APP_KEY` | Laravel app key (generate: `php artisan key:generate`) |
| `APP_URL` | URL aplikasi (lokal: `http://localhost:8000`) |
| `APP_ENV` | `local` atau `production` |
| `APP_DEBUG` | `true` (dev) atau `false` (production) |
| `SUPABASE_URL` | URL project Supabase |
| `SUPABASE_KEY` | Anon/public key dari Supabase |
| `CLOUDINARY_URL` | Full Cloudinary URL |
| `CLOUDINARY_CLOUD_NAME` | Cloudinary cloud name |
| `CLOUDINARY_API_KEY` | Cloudinary API key |
| `CLOUDINARY_API_SECRET` | Cloudinary API secret |

---

## 👤 Akun Default

Buat akun admin langsung di Supabase SQL Editor:

```sql
INSERT INTO users (name, email, password, is_admin)
VALUES ('Admin', 'admin@mail.com', '$2y$12$...hashed...', true);
```

Atau register biasa lalu ubah `is_admin` jadi `true` di tabel `users`.

---

## 📄 License

MIT
