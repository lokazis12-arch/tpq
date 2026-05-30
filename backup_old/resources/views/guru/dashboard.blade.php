<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - Darul Ikhlas</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .guru-hero {
            background: linear-gradient(135deg, var(--primary) 0%, #065F46 100%);
            padding: 24px 20px 60px;
            position: relative;
            margin-bottom: -40px;
        }
        .guru-hero-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        .guru-hero-title {
            font-size: 18px;
            font-weight: 800;
            color: white;
            letter-spacing: -0.03em;
        }
        .guru-hero h2 {
            color: white;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 4px;
        }
        .guru-hero p {
            color: rgba(255,255,255,0.7);
            font-size: 14px;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            padding: 0 20px;
            position: relative;
            z-index: 5;
        }
        .stat-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 18px 12px;
            text-align: center;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-100);
        }
        .stat-card-icon {
            width: 40px; height: 40px;
            border-radius: var(--radius-md);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 10px;
        }
        .stat-card-value {
            font-size: 26px;
            font-weight: 800;
            color: var(--gray-900);
            letter-spacing: -0.03em;
            margin-bottom: 2px;
        }
        .stat-card-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .menu-section {
            padding: 28px 20px 0;
        }
        .menu-section-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 14px;
            letter-spacing: -0.01em;
        }
        .menu-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .menu-card {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px;
            background: var(--white);
            border-radius: var(--radius-lg);
            text-decoration: none;
            border: 1px solid var(--gray-100);
            box-shadow: var(--shadow-xs);
            transition: all 0.25s var(--ease);
        }
        .menu-card:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-md);
            transform: translateX(4px);
        }
        .menu-card-icon {
            width: 44px; height: 44px;
            border-radius: var(--radius-md);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .menu-card-content {
            flex: 1;
        }
        .menu-card-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 2px;
        }
        .menu-card-desc {
            font-size: 12px;
            color: var(--gray-500);
        }
        .menu-card-arrow {
            color: var(--gray-300);
            flex-shrink: 0;
        }
    </style>
</head>
<body>
    <div class="app-container" style="padding-bottom: 20px;">
        <!-- Hero Header -->
        <div class="guru-hero">
            <div class="guru-hero-top">
                <div class="guru-hero-title">🕌 Darul Ikhlas</div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="background: rgba(255,255,255,0.15); border: none; cursor: pointer; color: white; padding: 8px 14px; border-radius: 8px; font-size: 13px; font-weight: 600; font-family: var(--font);">
                        Keluar
                    </button>
                </form>
            </div>
            <h2>Assalamu'alaikum, {{ auth()->user()->name }} 👋</h2>
            <p>Ringkasan aktivitas hari ini</p>
        </div>

        <!-- Stats Cards -->
        <div class="stats-row">
            <div class="stat-card animate-in" style="animation-delay: 0.05s;">
                <div class="stat-card-icon" style="background: var(--primary-subtle); color: var(--primary);">
                    <svg style="width:20px;height:20px;fill:currentColor;" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                </div>
                <div class="stat-card-value">{{ $totalSantri }}</div>
                <div class="stat-card-label">Santri</div>
            </div>
            <div class="stat-card animate-in" style="animation-delay: 0.1s;">
                <div class="stat-card-icon" style="background: #EFF6FF; color: var(--info);">
                    <svg style="width:20px;height:20px;fill:currentColor;" viewBox="0 0 24 24"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>
                </div>
                <div class="stat-card-value">{{ $absenHariIni }}</div>
                <div class="stat-card-label">Absen</div>
            </div>
            <div class="stat-card animate-in" style="animation-delay: 0.15s;">
                <div class="stat-card-icon" style="background: var(--accent-light); color: #B45309;">
                    <svg style="width:20px;height:20px;fill:currentColor;" viewBox="0 0 24 24"><path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/></svg>
                </div>
                <div class="stat-card-value">{{ $iqroHariIni }}</div>
                <div class="stat-card-label">Iqro</div>
            </div>
        </div>

        <!-- Menu Section -->
        <div class="menu-section">
            <div class="menu-section-title">Menu Utama</div>
            <div class="menu-list">
                <a href="{{ route('guru.santri.index') }}" class="menu-card animate-in" style="animation-delay: 0.2s;">
                    <div class="menu-card-icon" style="background: var(--primary-subtle); color: var(--primary);">
                        <svg style="width:22px;height:22px;fill:currentColor;" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                    </div>
                    <div class="menu-card-content">
                        <div class="menu-card-title">Manajemen Santri</div>
                        <div class="menu-card-desc">Kelola data santri dan wali</div>
                    </div>
                    <svg class="menu-card-arrow" style="width:20px;height:20px;fill:currentColor;" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg>
                </a>

                <a href="{{ route('guru.absensi.index') }}" class="menu-card animate-in" style="animation-delay: 0.25s;">
                    <div class="menu-card-icon" style="background: #EFF6FF; color: var(--info);">
                        <svg style="width:22px;height:22px;fill:currentColor;" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/></svg>
                    </div>
                    <div class="menu-card-content">
                        <div class="menu-card-title">Input Absensi</div>
                        <div class="menu-card-desc">Catat kehadiran harian santri</div>
                    </div>
                    <svg class="menu-card-arrow" style="width:20px;height:20px;fill:currentColor;" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg>
                </a>

                <a href="{{ route('guru.iqro.index') }}" class="menu-card animate-in" style="animation-delay: 0.3s;">
                    <div class="menu-card-icon" style="background: var(--accent-light); color: #B45309;">
                        <svg style="width:22px;height:22px;fill:currentColor;" viewBox="0 0 24 24"><path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/></svg>
                    </div>
                    <div class="menu-card-content">
                        <div class="menu-card-title">Progres Iqro</div>
                        <div class="menu-card-desc">Input capaian mengaji santri</div>
                    </div>
                    <svg class="menu-card-arrow" style="width:20px;height:20px;fill:currentColor;" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg>
                </a>

                <a href="{{ route('guru.sholat.index') }}" class="menu-card animate-in" style="animation-delay: 0.35s;">
                    <div class="menu-card-icon" style="background: #FEF3C7; color: #D97706;">
                        <svg style="width:22px;height:22px;fill:currentColor;" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                    </div>
                    <div class="menu-card-content">
                        <div class="menu-card-title">Progres Sholat</div>
                        <div class="menu-card-desc">Input capaian bacaan sholat santri</div>
                    </div>
                    <svg class="menu-card-arrow" style="width:20px;height:20px;fill:currentColor;" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg>
                </a>

                <a href="{{ route('guru.pembayaran.index') }}" class="menu-card animate-in" style="animation-delay: 0.4s;">
                    <div class="menu-card-icon" style="background: #FEF2F2; color: var(--danger);">
                        <svg style="width:22px;height:22px;fill:currentColor;" viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
                    </div>
                    <div class="menu-card-content">
                        <div class="menu-card-title">Catat Pembayaran</div>
                        <div class="menu-card-desc">Aktivasi akses wali santri</div>
                    </div>
                    <svg class="menu-card-arrow" style="width:20px;height:20px;fill:currentColor;" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
