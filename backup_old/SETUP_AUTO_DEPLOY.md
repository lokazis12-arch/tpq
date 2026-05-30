# Setup Auto-Deploy ke Vercel dengan GitHub

## Overview
Setup ini akan memungkinkan Anda:
- Mengubah kode di local (d:\ihlas)
- Push ke GitHub
- Vercel otomatis deploy perubahan ke production

## Langkah 1: Install Git (jika belum)

### Download dan Install Git for Windows
1. Buka https://git-scm.com/download/win
2. Download installer Git for Windows
3. Jalankan installer dengan default settings
4. Setelah install, buka terminal baru dan cek:
   ```bash
   git --version
   ```

## Langkah 2: Initialize Git Repository

Buka terminal di `d:\ihlas` dan jalankan:

```bash
cd d:\ihlas
git init
```

## Langkah 3: Review .gitignore

File `.gitignore` sudah ada di Laravel. Pastikan file-file sensitive tidak di-commit:
- `.env` (jangan push ke GitHub)
- `vendor/`
- `node_modules/`
- `storage/` (kecuali .gitignore)
- `bootstrap/cache/`

## Langkah 4: Commit Perubahan Saat Ini

```bash
git add .
git status
git commit -m "Setup Vercel deployment configuration"
```

## Langkah 5: Setup GitHub Repository

### Option A: Buat Repository di GitHub (Manual)
1. Buka https://github.com/new
2. Repository name: `ihlas` (atau nama lain)
3. Set sebagai Public atau Private
4. Jangan centang "Initialize with README"
5. Klik "Create repository"

### Option B: Buat Repository via GitHub CLI (jika terinstall)
```bash
gh repo create ihlas --public --source=.
git push -u origin main
```

## Langkah 6: Connect Local ke GitHub

Jika menggunakan Option A (manual), setelah repository dibuat:

```bash
git branch -M main
git remote add origin https://github.com/USERNAME-ANDA/ihlas.git
git push -u origin main
```

Ganti `USERNAME-ANDA` dengan GitHub username Anda.

## Langkah 7: Setup Vercel dengan GitHub

### Via Dashboard Vercel
1. Buka https://vercel.com
2. Login atau sign up (gratis dengan GitHub)
3. Klik "Add New Project"
4. Klik "Import" pada repository GitHub Anda
5. Vercel akan otomatis mendeteksi:
   - Framework: Laravel
   - Build command: `composer install --no-dev --optimize-autoloader && npm install && npm run build`
   - Output directory: `public`

6. Klik "Deploy"

### Set Environment Variables di Vercel
1. Setelah deploy pertama selesai, buka:
   - Project Settings > Environment Variables
2. Tambahkan variable:

```
APP_KEY=base64:YOUR_GENERATED_KEY
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.vercel.app
DB_CONNECTION=sqlite
CACHE_DRIVER=array
SESSION_DRIVER=array
LOG_CHANNEL=errorlog
```

3. Klik "Save"
4. Redeploy project (Settings > General > Redeploy)

## Langkah 8: Generate APP_KEY

Di local machine:
```bash
php artisan key:generate
```

Copy nilai APP_KEY dari file `.env` dan set di Vercel environment variables.

## Workflow Development Sehari-Hari

### Mengubah Kode
1. Edit kode di local (d:\ihlas)
2. Test di local:
   ```bash
   php artisan serve
   ```
3. Commit perubahan:
   ```bash
   git add .
   git commit -m "Deskripsi perubahan"
   ```
4. Push ke GitHub:
   ```bash
   git push
   ```
5. Vercel otomatis deploy (tunggu 1-2 menit)
6. Buka URL Vercel untuk melihat perubahan

### Melihat Status Deployment
- Buka dashboard Vercel
- Lihat tab "Deployments"
- Setiap commit akan muncul sebagai deployment baru
- Klik deployment untuk melihat logs

### Rollback jika Ada Error
1. Buka dashboard Vercel > Deployments
2. Klik deployment yang sebelumnya sukses
3. Klik "Promote to Production"

## Troubleshooting

### Git tidak dikenali
- Install Git dari https://git-scm.com/download/win
- Restart terminal setelah install

### Error saat push ke GitHub
- Cek GitHub credentials:
  ```bash
  git config --global user.name "Nama Anda"
  git config --global user.email "email@anda.com"
  ```
- Jika menggunakan 2FA, gunakan Personal Access Token

### Vercel tidak auto-deploy
- Pastikan repository sudah terhubung di Vercel
- Cek GitHub webhook settings
- Pastikan branch yang di-push adalah branch yang di-monitor Vercel (default: main)

### Environment variables tidak ter-load
- Pastikan variables sudah di-set di Vercel dashboard
- Redeploy setelah menambah environment variables
- Cek deployment logs untuk error

## File yang Ditambahkan untuk Vercel

- `vercel.json` - Konfigurasi Vercel
- `api/index.php` - Entry point untuk Vercel
- `.env.vercel` - Template environment variables
- `DEPLOYMENT_VERCEL.md` - Dokumentasi deployment

File-file ini sudah di-commit dan akan di-push ke GitHub.
