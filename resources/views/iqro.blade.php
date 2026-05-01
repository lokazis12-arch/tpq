<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progres - Darul Ikhlas</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <style>
        .page-header {
            margin: 10px 0 20px 0;
        }
        .page-header h2 { font-size: 20px; margin-bottom: 5px; }
        .page-header p { font-size: 13px; color: var(--text-light); }
        
        .iqro-item {
            background: white;
            border-radius: 16px;
            padding: 16px 20px;
            margin-bottom: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }
        .iqro-item.active {
            border: 1px solid var(--primary);
            box-shadow: 0 4px 15px rgba(46,125,50,0.1);
        }
        .iqro-item.active::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 5px;
            background-color: var(--primary);
            border-top-left-radius: 16px;
            border-bottom-left-radius: 16px;
        }
        .iqro-item.disabled {
            background-color: var(--neutral);
            opacity: 0.7;
        }
        
        .iqro-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .iqro-number {
            width: 36px; height: 36px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            font-size: 14px;
        }
        .bg-primary { background-color: var(--primary); color: white; }
        .bg-gray { background-color: #E0E0E0; color: var(--text-light); }
        
        .iqro-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
        }
        .iqro-subtitle {
            font-size: 11px;
            color: var(--secondary);
            font-weight: 600;
            margin-top: 2px;
        }
        
        .progress-details {
            margin-top: 15px;
            width: 100%;
        }
        .progress-text {
            display: flex; justify-content: space-between;
            font-size: 11px; font-weight: 600; color: var(--text-dark);
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Header -->
        <div class="app-header
            <svg style="width:24px;height:24px;color:var(--primary);" viewBox="0 0 24 24" fill="currentColor">
                <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
            </svg>
            <div class="app-title">Darul Ikhlas</div>
            <div class="header-icon">
                <img src="https://ui-avatars.com/api/?name=Ahmad+Rizky&background=2E7D32&color=fff" alt="User" style="width:100%;height:100%;border-radius:50%;">
            </div>
        </div>

        <div class="section-padding
            <div class="page-
                <h2>Progres Belajar</h2>
                <p>Pantau capaian tahsin harian.</p>
            </div>

            <!-- Iqro 1 -->
            <div class="iqro-item card-hover scroll-reveal">
                <div class="iqro-left">
                    <div class="iqro-number bg-primary">1</div>
                    <div class="iqro-title">Iqro 1</div>
                </div>
                <div class="badge badge-primary">Selesai</div>
            </div>

            <!-- Iqro 2 -->
            <div class="iqro-item card-hover scroll-reveal">
                <div class="iqro-left">
                    <div class="iqro-number bg-primary">2</div>
                    <div class="iqro-title">Iqro 2</div>
                </div>
                <div class="badge badge-primary">Selesai</div>
            </div>

            <!-- Iqro 3 (Active) -->
            <div class="iqro-item active bounce-in" style="flex-direction: column; align-items: stretch; padding: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                    <div class="iqro-left">
                        <div class="iqro-number bg-primary">3</div>
                        <div>
                            <div class="iqro-title" style="color: var(--primary);">Iqro 3</div>
                            <div class="iqro-subtitle">Sedang Dipelajari</div>
                        </div>
                    </div>
                    <div class="badge badge-secondary" style="display: flex; align-items: center; gap:4px;">
                        <svg style="width:12px;height:12px;fill:currentColor;" viewBox="0 0 24 24"><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46C19.54 15.03 20 13.57 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74C4.46 8.97 4 10.43 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"/></svg>
                        Proses
                    </div>
                </div>
                
                <div class="progress-details">
                    <div class="progress-text">
                        <span>Halaman 18</span>
                        <span>30 Halaman</span>
                    </div>
                    <div class="progress-container" style="height: 6px;">
                        <div class="progress-bar" style="width: 60%;"></div>
                    </div>
                </div>
            </div>

            <!-- Iqro 4 -->
            <div class="iqro-item disabled card-hover scroll-reveal">
                <div class="iqro-left">
                    <div class="iqro-number bg-gray">4</div>
                    <div class="iqro-title" style="color:var(--text-light);">Iqro 4</div>
                </div>
                <div>
                    <svg style="width:18px;height:18px;fill:var(--text-light);" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                </div>
            </div>

            <!-- Iqro 5 -->
            <div class="iqro-item disabled card-hover scroll-reveal">
                <div class="iqro-left">
                    <div class="iqro-number bg-gray">5</div>
                    <div class="iqro-title" style="color:var(--text-light);">Iqro 5</div>
                </div>
                <div>
                    <svg style="width:18px;height:18px;fill:var(--text-light);" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                </div>
            </div>
        </div>

        <!-- Bottom Navigation -->
        <div class="bottom-nav scroll-reveal">
            <a href="{{ route('wali.dashboard') }}" class="nav-item hover-scale">
                <svg class="nav-icon" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                Beranda
            </a>
            <a href="{{ route('wali.iqro') }}" class="nav-item active hover-scale">
                <svg class="nav-icon" viewBox="0 0 24 24"><path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/></svg>
                Iqro
            </a>
            <a href="{{ route('wali.presensi') }}" class="nav-item hover-scale">
                <svg class="nav-icon" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zm-7-9.5l-4 4 1.41 1.41L12 12.33V17h2v-4.67l2.59 2.58L18 13.5l-4-4z"/></svg>
                Presensi
            </a>
            <a href="#" class="nav-item hover-scale">
                <svg class="nav-icon" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg>
                Pesan
            </a>
        </div>
    </div>
</body>
</html>
