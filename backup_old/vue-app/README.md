# Sistem TPQ Ihlas - Vue + Supabase + Vercel

Aplikasi manajemen TPQ (Taman Pendidikan Al-Quran) yang dibangun dengan Vue 3, Supabase, dan di-deploy ke Vercel.

## Tech Stack

- **Frontend**: Vue 3 + Vite
- **Database & Auth**: Supabase (PostgreSQL)
- **Hosting**: Vercel (Gratis)
- **Styling**: TailwindCSS

## Fitur

### Untuk Guru
- Dashboard overview
- Kelola data santri (CRUD)
- Catat absensi santri
- Track progres Iqro
- Track progres sholat
- Kelola pembayaran SPP

### Untuk Wali Santri
- Dashboard overview
- Lihat progres Iqro anak
- Lihat progres sholat anak
- Lihat riwayat kehadiran
- Lihat laporan lengkap
- Kelola profile

## Setup Lokal

### 1. Clone Repository
```bash
git clone <repository-url>
cd vue-app
```

### 2. Install Dependencies
```bash
npm install
```

### 3. Setup Supabase

1. Buat project baru di [Supabase](https://supabase.com)
2. Buka SQL Editor di Supabase dashboard
3. Copy dan jalankan SQL dari file `supabase-schema.sql`
4. Dapatkan credentials:
   - Project URL: Settings > API > Project URL
   - Anon Key: Settings > API > anon public key

### 4. Setup Environment Variables

Buat file `.env` di root project:
```env
VITE_SUPABASE_URL=your_supabase_project_url
VITE_SUPABASE_ANON_KEY=your_supabase_anon_key
```

### 5. Jalankan Development Server
```bash
npm run dev
```

Buka http://localhost:3000 di browser.

## Deploy ke Vercel

### 1. Push ke GitHub
```bash
git add .
git commit -m "Initial commit"
git push
```

### 2. Connect ke Vercel

1. Buka [Vercel](https://vercel.com)
2. Login dengan GitHub
3. Klik "Add New Project"
4. Import repository GitHub Anda
5. Vercel akan otomatis mendeteksi Vue + Vite
6. Add environment variables:
   - `VITE_SUPABASE_URL`
   - `VITE_SUPABASE_ANON_KEY`
7. Klik "Deploy"

### 3. Environment Variables di Vercel

Di Vercel dashboard > Settings > Environment Variables:
- `VITE_SUPABASE_URL`: URL project Supabase Anda
- `VITE_SUPABASE_ANON_KEY`: Anon key dari Supabase

## Struktur Database

### Tables
- `profiles`: Data user (guru & wali santri)
- `santri`: Data santri
- `absensi`: Catat kehadiran santri
- `pembayaran`: Data pembayaran SPP
- `progres_iqro`: Track progres membaca Iqro
- `progres_sholat`: Track progres sholat

### Security
- Row Level Security (RLS) diaktifkan
- Guru bisa CRUD semua data
- Wali santri hanya bisa view data anaknya

## Development

### Build untuk Production
```bash
npm run build
```

### Preview Production Build
```bash
npm run preview
```

## Biaya

Semua stack ini **GRATIS**:
- Vercel: Hosting frontend (gratis untuk personal projects)
- Supabase: 500MB database, 50K MAU/bulan (gratis tier)

## Support

Jika ada masalah, cek:
1. Environment variables sudah di-set dengan benar
2. SQL schema sudah dijalankan di Supabase
3. RLS policies sudah diaktifkan
