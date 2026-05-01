<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Darul Ikhlas</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <style>
        .profile-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            margin-bottom: 25px;
            border: 1px solid var(--border);
        }
        .profile-info { display: flex; align-items: center; gap: 15px; }
        .avatar-bg {
            width: 50px; height: 50px;
            background-color: #263238;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
        }
        .student-name { font-weight: 700; font-size: 16px; margin-bottom: 4px; }
        .student-class { font-size: 12px; color: var(--text-light); display: flex; align-items: center; gap:4px; }
        .qr-btn {
            width: 36px; height: 36px;
            background-color: #F1F8E9;
            color: var(--primary);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }

        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .header-flex h2 { font-size: 18px; line-height: 1.2;}
        .header-flex p { font-size: 12px; color: var(--text-light); margin-top: 4px; }
        
        .month-selector {
            border: 1px solid var(--primary);
            color: var(--primary);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: flex; align-items: center; gap: 5px;
            background: white;
        }

        .report-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            margin-bottom: 15px;
            border: 1px solid var(--border);
        }
        .card-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; }
        .card-title-flex { display: flex; align-items: center; gap: 10px; }
        .icon-box {
            width: 32px; height: 32px;
            background-color: #E8F5E9;
            color: var(--primary);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
        }
        .report-title { font-size: 14px; font-weight: 700; }
        
        .materi-title { font-size: 13px; color: var(--text-dark); font-weight: 500; margin-left: 42px;}
        .progress-info { display: flex; justify-content: space-between; font-size: 11px; margin-top: 15px; margin-bottom: 5px; font-weight: 600;}
        
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .stat-box {
            background: white;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid var(--border);
            position: relative;
        }
        .stat-icon { position: absolute; top: 15px; right: 15px; color: var(--secondary); }
        .stat-label { font-size: 11px; font-weight: 600; color: var(--text-light); margin-bottom: 15px; }
        .stat-value { font-size: 28px; font-weight: 700; color: var(--primary); margin-bottom: 5px; }
        .stat-desc { font-size: 11px; color: var(--text-dark); }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Header -->
        <div class="app-header">">">">">
            <svg style="width:24px;height:24px;color:var(--primary);" viewBox="0 0 24 24" fill="currentColor">
                <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
            </svg>
            <div class="app-title">Darul Ikhlas</div>
            <div class="header-icon">
                <img src="https://ui-avatars.com/api/?name=Ahmad+Rizky&background=2E7D32&color=fff" alt="User" style="width:100%;height:100%;border-radius:50%;">
            </div>
        </div>

        <div class="section-padding">">">">">
            <!-- Profile Card -->
            <div class="profile-card">">">">">
                <div class="profile-info">
                    <div class="avatar-bg">
                        <img src="https://ui-avatars.com/api/?name=MR&background=263238&color=fff" alt="Student" style="border-radius:50%; width:100%;">
                    </div>
                    <div>
                        <div class="student-name">Muhammad Rayhan</div>
                        <div class="student-class">
                            <svg style="width:14px;height:14px;fill:currentColor;" viewBox="0 0 24 24"><path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/></svg>
                            Kelas 4 - Jilid 5
                        </div>
                    </div>
                </div>
                <div class="qr-btn
                    <svg style="width:20px;height:20px;fill:currentColor;" viewBox="0 0 24 24"><path d="M3 3h8v8H3zm2 2v4h4V5zm8-2h8v8h-8zm2 2v4h4V5zM3 13h8v8H3zm2 2v4h4v-4zm13-2h2v2h-2zm-3 3h2v2h-2zm3 3h2v2h-2zm-3-3h2v2h-2zm-3-3h2v2h-2zm0 3h2v2h-2z"/></svg>
                </div>
            </div>

            <div class="header-flex
                <div>
                    <h2>Ringkasan Laporan</h2>
                    <p>Evaluasi bulanan santri</p>
                </div>
                <div class="month-selector">
                    Oktober 2023
                    <svg style="width:16px;height:16px;fill:currentColor;" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
                </div>
            </div>

            <!-- Progress Card -->
            <div class="report-card
                <div class="card-row">
                    <div class="card-title-flex">
                        <div class="icon-box">
                            <svg style="width:18px;height:18px;fill:currentColor;" viewBox="0 0 24 24"><path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/></svg>
                        </div>
                        <div class="report-title">Progress Belajar</div>
                    </div>
                    <div class="badge badge-primary" style="background:#E8F5E9; color:var(--primary);">Sedang Berjalan</div>
                </div>
                
                <div class="materi-title">Juz 30 - Surah Al-Fajr</div>
                
                <div class="progress-info">
                    <span style="color:var(--text-light);">Pencapaian Ayat (15/30)</span>
                    <span style="color:var(--text-dark);">50%</span>
                </div>
                <div class="progress-container">
                    <div class="progress-bar" style="width: 50%;"></div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid-2
                <div class="stat-box
                    <svg class="stat-icon" style="width:20px;height:20px;" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    <div class="stat-label">Nilai Rata-rata</div>
                    <div class="stat-value" style="color:var(--primary);">A-</div>
                    <div class="stat-desc">Sangat Baik (88.5)</div>
                </div>
                
                <div class="stat-box">
                    <svg class="stat-icon" style="width:20px;height:20px;color:var(--text-light);" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zm-7-9.5l-4 4 1.41 1.41L12 12.33V17h2v-4.67l2.59 2.58L18 13.5l-4-4z"/></svg>
                    <div class="stat-label">Kehadiran</div>
                    <div class="stat-value" style="color:var(--text-dark);">92%</div>
                    <div class="stat-desc">Hadir: 22 Hari</div>
                </div>
            </div>
            
            <!-- Button -->
            <button onclick="window.print()" class="btn btn-primary button-press hover-lift hover-glow" style="margin-bottom: 20px; border-radius: 12px; display:flex; justify-content:center; gap:8px;">
                <svg style="width:20px;height:20px;fill:currentColor;" viewBox="0 0 24 24"><path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/></svg>
                Cetak Laporan
            </button>
        </div>

        <!-- Bottom Navigation -->
        <div class="bottom-nav scroll-reveal">
            <a href="{{ route('wali.dashboard') }}" class="nav-item hover-scale">
                <svg class="nav-icon" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                Beranda
            </a>
            <a href="{{ route('wali.iqro') }}" class="nav-item hover-scale">
                <svg class="nav-icon" viewBox="0 0 24 24"><path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/></svg>
                Iqro
            </a>
            <a href="{{ route('wali.presensi') }}" class="nav-item hover-scale">
                <svg class="nav-icon" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zm-7-9.5l-4 4 1.41 1.41L12 12.33V17h2v-4.67l2.59 2.58L18 13.5l-4-4z"/></svg>
                Presensi
            </a>
            <a href="#" class="nav-item active hover-scale">
                <svg class="nav-icon" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg>
                Pesan
            </a>
        </div>
    </div>
</body>
</html>
