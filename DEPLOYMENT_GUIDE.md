# 🚗 MaRental — Panduan Deploy Lengkap

Panduan ini menjelaskan cara mendapatkan API key Supabase & Cloudinary, upload ke GitHub, dan hosting di Render.

---

## 1. 🗄️ Setup Supabase (Database PostgreSQL Cloud)

### Buat Akun & Project
1. Buka [supabase.com](https://supabase.com) → klik **Start your project**
2. Login dengan **GitHub** (gratis!)
3. Klik **New Project**
4. Isi:
   - **Name**: `rentalmobilmar`
   - **Database Password**: buat password kuat (SIMPAN INI!)
   - **Region**: pilih **Southeast Asia (Singapore)** 
5. Klik **Create new project** — tunggu ±2 menit

### Ambil Connection String
1. Di dashboard project, klik **⚙️ Settings** (kiri bawah)
2. Klik **Database**
3. Scroll ke bagian **Connection string** → pilih tab **URI**
4. Salin info berikut untuk `.env`:
   ```
   DB_CONNECTION=pgsql
   DB_HOST=db.xxxxx.supabase.co    ← dari Host
   DB_PORT=5432
   DB_DATABASE=postgres
   DB_USERNAME=postgres
   DB_PASSWORD=password-kamu       ← password saat buat project
   ```

> **Tips**: Jangan pakai "Connection Pooler" untuk Laravel, pakai **Direct Connection**.

---

## 2. 🖼️ Setup Cloudinary (Image Storage Cloud)

### Buat Akun
1. Buka [cloudinary.com](https://cloudinary.com) → klik **Sign Up for Free**
2. Isi form registrasi (nama, email, password)
3. Pilih plan **Free** (25 credits/bulan, cukup untuk proyek ini)

### Ambil API Key
1. Login ke [Cloudinary Console](https://console.cloudinary.com)
2. Di **Dashboard**, kamu akan melihat:
   - **Cloud Name**: `dxxxxxxxxxxx`
   - **API Key**: `123456789012345`
   - **API Secret**: `abcdefghijklmnop` (klik 👁️ untuk lihat)
3. Salin ke `.env`:
   ```
   CLOUDINARY_CLOUD_NAME=dxxxxxxxxxxx
   CLOUDINARY_API_KEY=123456789012345
   CLOUDINARY_API_SECRET=abcdefghijklmnop
   ```

---

## 3. 📦 Upload ke GitHub

### Pertama Kali (Belum Ada Repo)
```bash
# Dari folder project
cd d:\projek\rentalmobilmar

# Init git
git init
git add .
git commit -m "Initial commit: MaRental"

# Buat repo di GitHub (via browser):
# → github.com → New Repository → nama: "rentalmobilmar" → Create

# Push
git remote add origin https://github.com/USERNAME/rentalmobilmar.git
git branch -M main
git push -u origin main
```

### Update Selanjutnya
```bash
git add .
git commit -m "pesan perubahan"
git push
```

> **PENTING**: Pastikan `.env` ada di `.gitignore` — jangan pernah push file `.env` ke GitHub!

---

## 4. 🚀 Hosting di Render

### Buat Akun
1. Buka [render.com](https://render.com) → klik **Get Started for Free**
2. Login dengan **GitHub**

### Deploy App
1. Klik **New** → **Web Service**
2. Connect ke GitHub repo `rentalmobilmar`
3. Isi konfigurasi:
   - **Name**: `marental`
   - **Region**: Singapore
   - **Branch**: `main`
   - **Runtime**: `Docker` (atau PHP jika tersedia)
   - **Build Command**: 
     ```
     composer install --no-dev --optimize-autoloader && npm install && npm run build && php artisan config:cache && php artisan route:cache && php artisan view:cache
     ```
   - **Start Command**:
     ```
     php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
     ```
4. Tambah **Environment Variables** (klik Advanced):
   ```
   APP_NAME=MaRental
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://marental.onrender.com
   APP_KEY=                          ← jalankan `php artisan key:generate --show` di lokal, copy hasilnya
   
   DB_CONNECTION=pgsql
   DB_HOST=db.xxxxx.supabase.co
   DB_PORT=5432
   DB_DATABASE=postgres
   DB_USERNAME=postgres
   DB_PASSWORD=password-supabase-kamu
   
   CLOUDINARY_CLOUD_NAME=dxxxxxxxxxxx
   CLOUDINARY_API_KEY=123456789012345
   CLOUDINARY_API_SECRET=abcdefghijklmnop
   
   SESSION_DRIVER=cookie
   CACHE_DRIVER=file
   ```
5. Klik **Create Web Service**

### Setelah Deploy
- Render akan otomatis build dan deploy
- URL app kamu: `https://marental.onrender.com`
- Setiap kali push ke GitHub, Render auto-deploy ulang

---

## ⚡ Quick Checklist

- [ ] Buat akun Supabase → salin DB credentials
- [ ] Buat akun Cloudinary → salin API keys
- [ ] Update `.env` lokal dengan credentials
- [ ] Test di lokal: `php artisan migrate:fresh` lalu `php artisan serve`
- [ ] Upload ke GitHub
- [ ] Deploy di Render dengan env variables
- [ ] Test semua fitur di production
