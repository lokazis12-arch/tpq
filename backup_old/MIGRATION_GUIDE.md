# Migration Guide: Laravel → Vue + Supabase + Vercel

## Overview
Project ini telah dimigrasi dari Laravel ke Vue 3 + Supabase + Vercel untuk hosting gratis dan deployment yang lebih mudah.

## Apa yang Sudah Dilakukan

### 1. Vue 3 Project Structure
- Project Vue 3 + Vite dibuat di folder `vue-app/`
- TailwindCSS untuk styling
- Vue Router untuk navigasi
- Supabase client terinstall

### 2. Authentication System
- Login page dengan Supabase Auth
- Register page dengan role selection (guru/wali_santri)
- Role-based routing dan middleware
- Auto-redirect berdasarkan role setelah login

### 3. Guru Pages
- Dashboard dengan overview
- Manajemen Santri (CRUD)
- Absensi (catat kehadiran)
- Progres Iqro (track bacaan)
- Progres Sholat (track sholat)
- Pembayaran SPP

### 4. Wali Santri Pages
- Dashboard dengan overview
- View Progres Iqro anak
- View Progres Sholat anak
- View Presensi/kehadiran
- Laporan lengkap dengan statistik
- Profile management

### 5. Database Schema
- SQL schema lengkap di `vue-app/supabase-schema.sql`
- Tables: profiles, santri, absensi, pembayaran, progres_iqro, progres_sholat
- Row Level Security (RLS) policies
- Auto-trigger untuk profile creation
- Indexes untuk performance

### 6. Vercel Configuration
- `vercel.json` sudah dikonfigurasi
- Build command: `npm run build`
- Output directory: `dist`

## Langkah Selanjutnya (Anda Harus Lakukan)

### 1. Setup Supabase Project

1. Buka [https://supabase.com](https://supabase.com)
2. Sign up / Login
3. Klik "New Project"
4. Isi:
   - Name: `ihlas-tpq` (atau nama lain)
   - Database Password: (buat password yang kuat)
   - Region: Pilih yang terdekat (Singapore)
5. Klik "Create new project"
6. Tunggu 1-2 menit untuk setup

### 2. Import Database Schema

1. Di Supabase dashboard, buka **SQL Editor**
2. Klik "New Query"
3. Copy semua isi dari file `vue-app/supabase-schema.sql`
4. Paste ke SQL Editor
5. Klik "Run" (atau CMD/Ctrl + Enter)
6. Pastikan tidak ada error

### 3. Get Supabase Credentials

1. Di Supabase dashboard, buka **Settings > API**
2. Copy:
   - **Project URL**: `https://xxxxx.supabase.co`
   - **anon public key**: `eyJxxxxx...`

### 4. Setup Environment Variables

Buat file `.env` di dalam folder `vue-app/`:

```env
VITE_SUPABASE_URL=https://your-project.supabase.co
VITE_SUPABASE_ANON_KEY=your-anon-key-here
```

### 5. Install Dependencies & Test Lokal

```bash
cd vue-app
npm install
npm run dev
```

Buka http://localhost:3000 dan test:
- Register sebagai guru
- Register sebagai wali santri
- Login dan cek semua fitur

### 6. Deploy ke Vercel

#### Option A: Via Vercel Dashboard (Rekomendasi)

1. Push `vue-app/` folder ke GitHub repository baru
2. Buka [https://vercel.com](https://vercel.com)
3. Login dengan GitHub
4. Klik "Add New Project"
5. Import repository GitHub Anda
6. Vercel akan otomatis detect Vue + Vite
7. Di Environment Variables:
   - `VITE_SUPABASE_URL`: paste URL dari Supabase
   - `VITE_SUPABASE_ANON_KEY`: paste anon key dari Supabase
8. Klik "Deploy"
9. Tunggu deploy selesai (1-2 menit)

#### Option B: Via Vercel CLI

```bash
npm install -g vercel
cd vue-app
vercel
```

Ikuti instruksi di terminal.

## Perbedaan dengan Laravel

### Authentication
- **Laravel**: Session-based auth dengan database
- **Vue + Supabase**: JWT-based auth dengan Supabase Auth

### Database
- **Laravel**: MySQL/SQLite dengan Eloquent ORM
- **Vue + Supabase**: PostgreSQL dengan Supabase Client

### Routing
- **Laravel**: Server-side routing dengan Blade
- **Vue + Supabase**: Client-side routing dengan Vue Router

### Deployment
- **Laravel**: Butuh VPS/shared hosting (berbayar)
- **Vue + Supabase**: Vercel (gratis) + Supabase (gratis)

## Backup Laravel Code

Kode Laravel asli masih ada di folder `laravel-backup/` jika Anda ingin mengembalikannya.

## Troubleshooting

### Error: "Supabase client not initialized"
- Pastikan file `.env` ada di root folder `vue-app/`
- Pastikan environment variables benar

### Error: "RLS policy violation"
- Pastikan SQL schema sudah dijalankan di Supabase
- Cek RLS policies di Supabase dashboard

### Error: "Build failed di Vercel"
- Pastikan environment variables di-set di Vercel dashboard
- Cek build logs di Vercel

### Data tidak muncul
- Pastikan user sudah login
- Cek RLS policies mengizinkan akses
- Cek console browser untuk error

## Biaya

- **Vercel**: Gratis (Personal plan)
- **Supabase**: Gratis (500MB database, 50K MAU/bulan)
- **Total**: Rp 0/bulan

Cukup untuk:
- ~50 santri aktif
- ~10 guru
- ~100 wali santri
- Ribuan record absensi/progres

## Support

Jika ada masalah:
1. Cek console browser (F12)
2. Cek Supabase dashboard logs
3. Cek Vercel deployment logs
4. Review SQL schema dan RLS policies
