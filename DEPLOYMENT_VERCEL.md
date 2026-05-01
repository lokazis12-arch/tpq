# Deploy Laravel ke Vercel (Gratis)

## Persiapan Sebelum Deploy

### 1. Generate APP_KEY
Jalankan perintah berikut untuk generate APP_KEY:
```bash
php artisan key:generate
```
Copy nilai APP_KEY dari file `.env` untuk digunakan di Vercel.

### 2. Install Dependencies
Pastikan semua dependencies sudah terinstall:
```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

### 3. Setup Database
Untuk deployment gratis di Vercel:
- Gunakan SQLite (default)
- Pastikan file `database/database.sqlite` ada atau akan dibuat otomatis

## Cara Deploy ke Vercel

### Option 1: Deploy via Vercel CLI

1. Install Vercel CLI:
```bash
npm i -g vercel
```

2. Login ke Vercel:
```bash
vercel login
```

3. Deploy:
```bash
vercel
```

4. Set environment variables di dashboard Vercel:
   - Buka dashboard Vercel
   - Pilih project
   - Settings > Environment Variables
   - Tambahkan variable:
     - `APP_KEY` (dari hasil `php artisan key:generate`)
     - `APP_ENV` = `production`
     - `APP_DEBUG` = `false`
     - `APP_URL` = `https://your-app-name.vercel.app`
     - `DB_CONNECTION` = `sqlite`
     - `CACHE_DRIVER` = `array`
     - `SESSION_DRIVER` = `array`

### Option 2: Deploy via GitHub

1. Push project ke GitHub repository
2. Buka [vercel.com](https://vercel.com)
3. Klik "Add New Project"
4. Import repository GitHub
5. Vercel akan otomatis mendeteksi konfigurasi dari `vercel.json`
6. Set environment variables di bagian Environment Variables
7. Klik "Deploy"

## Environment Variables yang Diperlukan

Set di Vercel dashboard (Settings > Environment Variables):

```
APP_KEY=base64:your-generated-key-here
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.vercel.app
DB_CONNECTION=sqlite
CACHE_DRIVER=array
SESSION_DRIVER=array
LOG_CHANNEL=errorlog
```

## Catatan Penting

1. **Database**: Untuk deployment gratis, menggunakan SQLite. Jika butuh database production (PostgreSQL/MySQL), gunakan layanan eksternal seperti:
   - [Supabase](https://supabase.com) (gratis)
   - [PlanetScale](https://planetscale.com) (gratis tier)
   - [Neon](https://neon.tech) (gratis)

2. **Storage**: Vercel tidak menyediakan persistent storage. Gunakan layanan eksternal untuk file upload:
   - AWS S3
   - Cloudflare R2
   - DigitalOcean Spaces

3. **Session & Cache**: Menggunakan `array` driver untuk deployment gratis (tidak persistent). Untuk production, gunakan Redis atau database.

4. **Build Process**: Vercel akan otomatis menjalankan:
   - `composer install --no-dev --optimize-autoloader`
   - `npm install`
   - `npm run build`

## Troubleshooting

### Error 500
- Cek logs di Vercel dashboard
- Pastikan `APP_KEY` sudah di-set dengan benar
- Pastikan environment variables sudah lengkap

### Database Connection Error
- Pastikan file `database/database.sqlite` ada
- Atau gunakan database eksternal dan set connection string

### File Upload Error
- Gunakan layanan storage eksternal (S3, R2, dll)
- Update konfigurasi `FILESYSTEM_DISK` di environment variables

## Update Deployment

Untuk update deployment:
- Push commit baru ke GitHub (otomatis redeploy)
- Atau jalankan `vercel --prod` jika menggunakan CLI
