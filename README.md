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