<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Darul Ikhlas</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <style>
        .wali-hero {
            background: linear-gradient(135deg, var(--primary) 0%, #065F46 100%);
            padding: 20px 20px 55px;
            position: relative;
            margin-bottom: -35px;
        }
        .wali-hero-top {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 20px;
        }
        .wali-hero-brand { font-size: 18px; font-weight: 800; color: white; }
        .greeting-section { display: flex; justify-content: space-between; align-items: center; }
        .greeting-section h2 { font-size: 22px; font-weight: 700; color: white; margin-bottom: 4px; }
        .greeting-section p { font-size: 13px; color: rgba(255,255,255,0.7); }

        .child-switcher {
            padding: 7px 12px;
            font-size: 12px;
            font-weight: 600;
            font-family: var(--font);
            border-radius: var(--radius-sm);
            border: 1.5px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.1);
            color: white;
            outline: none;
            appearance: none;
            cursor: pointer;
            backdrop-filter: blur(8px);
        }

        .progress-highlight {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: 20px;
            box-shadow: var(--shadow-lg);
            margin: 0 20px 24px;
            position: relative;
            z-index: 5;
            border: 1px solid var(--gray-100);
        }
        .progress-highlight::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0; width: 4px;
            background: linear-gradient(180deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: 4px 0 0 4px;
        }
        .ph-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
        .ph-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--gray-400); }
        .ph-title { font-size: 20px; font-weight: 800; color: var(--primary); margin-bottom: 2px; letter-spacing: -0.02em; }
        .ph-desc { font-size: 13px; color: var(--gray-500); margin-bottom: 16px; }
        .ph-progress { display: flex; justify-content: space-between; font-size: 12px; font-weight: 600; margin-bottom: 6px; }

        .menu-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            padding: 0 20px;
            margin-bottom: 24px;
        }
        .menu-tile {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 20px 14px;
            text-align: center;
            text-decoration: none;
            color: var(--gray-800);
            font-weight: 700;
            font-size: 13px;
            border: 1px solid var(--gray-100);
            box-shadow: var(--shadow-xs);
            transition: all 0.25s var(--ease);
        }
        .menu-tile:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }
        .menu-tile-icon {
            width: 44px; height: 44px;
            border-radius: var(--radius-md);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 10px;
        }

        .info-section { padding: 0 20px; margin-bottom: 20px; }
        .info-title { font-size: 15px; font-weight: 700; color: var(--gray-800); margin-bottom: 12px; }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Hero -->
        <div class="wali-hero
            <div class="wali-hero-top">
                <div class="wali-hero-brand">🕌 Darul Ikhlas</div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="background: rgba(255,255,255,0.12); border: none; cursor: pointer; color: white; padding: 7px 14px; border-radius: 8px; font-size: 12px; font-weight: 600; font-family: var(--font); backdrop-filter: blur(8px);
                        <svg style="width:16px;height:16px;fill:currentColor;vertical-align:middle;margin-right:4px;" viewBox="0 0 24 24"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
            <div class="greeting-section">
                <div>
                    <p>Assalamu'alaikum 👋</p>
                    <h2>{{ $santri ? $santri->nama_lengkap : 'Belum ada data' }}</h2>
                </div>
                @if(isset($allSantris) && $allSantris->count() > 1)
                <select onchange="window.location.href=this.value" class="child-switcher">
                    @foreach($allSantris as $s)
                        <option value="{{ route('wali.switch-santri', $s->id) }}" {{ $santri && $santri->id == $s->id ? 'selected' : '' }}>
                            {{ $s->nama_lengkap }}
                        </option>
                    @endforeach
                </select>
                @endif
            </div>
        </div>

        <!-- Progress Highlight -->
        <div class="progress-highlight scroll-reveal">
            <div class="ph-top">
                <div class="ph-label">Pencapaian Saat Ini</div>
                <span class="badge badge-primary">
                    <svg style="width:10px;height:10px;fill:currentColor;" viewBox="0 0 24 24"><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46C19.54 15.03 20 13.57 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74C4.46 8.97 4 10.43 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"/></svg>
                    Proses
                </span>
            </div>
            <div class="ph-title">{{ $latestIqro ? 'Iqro ' . $latestIqro->level : 'Belum ada data' }}</div>
            <div class="ph-desc">Halaman {{ $latestIqro ? $latestIqro->halaman : '-' }}</div>
            <div class="ph-progress">
                <span style="color: var(--gray-400);">Progress Level</span>
                <span style="color: var(--primary);">65%</span>
            </div>
            <div class="progress-container">
                <div class="progress-bar" style="width: 65%;"></div>
            </div>
        </div>

        <!-- Menu Grid -->
        <div class="menu-grid scroll-reveal">
            <a href="{{ route('wali.iqro') }}" class="menu-tile hover-lift card-hover" style="animation-delay: 0.1s;">
                <div class="menu-tile-icon" style="background: var(--primary-subtle); color: var(--primary);">
                    <svg style="width:22px;height:22px;fill:currentColor;" viewBox="0 0 24 24"><path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/></svg>
                </div>
                Progress
            </a>
            <a href="{{ route('wali.presensi') }}" class="menu-tile animatmttn
                <div class="menu-tile-icon" style="background: #EFF6FF; color: var(--info);">
                    <svg style="width:22px;height:22px;fill:currentColor;" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/></svg>
                </div>
                Absensi
            </a>
            <a href="{{ route('wali.laporan') }}" class="menu-tile hover-lift card-hover" style="animation-delay: 0.2s;">
                <div class="menu-tile-icon" style="background: var(--accent-light); color: #B45309;">
                    <svg style="width:22px;height:22px;fill:currentColor;" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                </div>
                Nilai
            </a>
            <a href="#" class="menu-tile hover-lift card-hover" style="animation-delay: 0.25s;">
                <div class="menu-tile-icon" style="background: #FEF2F2; color: var(--danger);">
                    <svg style="width:22px;height:22px;fill:currentColor;" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg>
                </div>
                Chat Guru
            </a>
        </div>

        <!-- Info -->
        <div class="info-section scroll-reveal">
            <div class="info-title">Info Terbaru</div>
            <div class="card card-hover" style="background: var(--gray-50); border: 1px solid var(--gray-100);">
                <p style="font-size:13px; color:var(--gray-500); line-height:1.6;">Belum ada pengumuman terbaru dari pengurus TPQ Darul Ikhlas saat ini.</p>
            </div>
        </div>

        <!-- Bottom Navigation -->
        <div class="bottom-nav scroll-reveal">
            <a href="{{ route('wali.dashboard') }}" class="nav-item active hover-scale">
                <svg class="nav-icon" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                Beranda
            </a>
            <a href="{{ route('wali.iqro') }}" class="nav-item hover-scale">
                <svg class="nav-icon" viewBox="0 0 24 24"><path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/></svg>
                Iqro
            </a>
            <a href="{{ route('wali.presensi') }}" class="nav-item hover-scale">
                <svg class="nav-icon" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/></svg>
                Presensi
            </a>
            <a href="{{ route('wali.laporan') }}" class="nav-item hover-scale">
                <svg class="nav-icon" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                Laporan
            </a>
        </div>
    </div>
</body>
</html>
