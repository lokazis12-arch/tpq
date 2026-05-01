<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Dibatasi - Darul Ikhlas</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <style>
        .blocked-wrapper {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            min-height: 85vh; text-align: center; padding: 30px;
        }
        .blocked-icon-wrap {
            width: 80px; height: 80px; border-radius: var(--radius-full);
            background: linear-gradient(135deg, #EF4444, #DC2626);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 28px;
            animation: pulse 2.5s infinite;
            box-shadow: 0 8px 24px rgba(239,68,68,0.3);
        }
        .blocked-icon-wrap svg { fill: white; width: 36px; height: 36px; }
        .blocked-title { font-size: 22px; font-weight: 800; color: var(--gray-900); margin-bottom: 10px; letter-spacing: -0.02em; }
        .blocked-msg { font-size: 14px; color: var(--gray-500); line-height: 1.7; margin-bottom: 28px; max-width: 300px; }
        .blocked-info-box {
            background: #FEF3C7; border: 1px solid #FDE68A; border-radius: var(--radius-md);
            padding: 16px 18px; width: 100%; margin-bottom: 24px; text-align: left;
        }
        .blocked-info-box strong { color: #92400E; font-size: 13px; }
        .blocked-info-box span { font-size: 13px; color: var(--gray-600); line-height: 1.6; }
        .blocked-footer { font-size: 12px; color: var(--gray-400); margin-top: 16px; }
    </style>
</head>
<body>
    <div class="app-container">
        <div class="blocked-wrapper hero-fade-in">
            <div class="blocked-icon-wrap bounce-in">
                <svg viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
            </div>
            <h1 class="blocked-title hero-fade-in-delay-1">Akses Dibatasi</h1>
            <p class="blocked-msg hero-fade-in-delay-2">
                Menu Progres, Presensi, dan Laporan tidak dapat diakses karena terdapat iuran yang belum lunas.
            </p>

            <div class="blocked-info-box card-hover scroll-reveal">
                <strong>⚠️ Iuran Belum Lunas</strong><br>
                <span>
                    Santri: {{ $santri->nama_lengkap }}<br>
                    Periode: {{ $bulan }}
                </span>
            </div>

            <a href="{{ route('wali.dashboard') }}" class="btn btn-primary button-press hover-lift hover-glow" style="max-width: 280px;">Kembali ke Dashboard</a>
            <p class="blocked-footer">Silakan hubungi pihak TPQ untuk melakukan pembayaran.</p>
        </div>
    </div>
</body>
</html>
