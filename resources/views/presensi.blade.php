<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi - Darul Ikhlas</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <style>
        .page-header { margin: 10px 0 20px 0; }
        .page-header h2 { font-size: 20px; margin-bottom: 5px; }
        .page-header p { font-size: 13px; color: var(--text-light); }
        
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
            margin-bottom: 20px;
        }
        .stat-card {
            border-radius: 16px;
            padding: 15px 10px;
            text-align: center;
            color: white;
        }
        .stat-card.hadir { background-color: var(--primary); }
        .stat-card.izin { background-color: var(--secondary); color: var(--text-dark); }
        .stat-card.sakit { background-color: #E0E0E0; color: var(--text-dark); }
        
        .stat-number { font-size: 24px; font-weight: 700; margin-bottom: 5px; }
        .stat-label { font-size: 12px; font-weight: 600; }
        
        /* Calendar */
        .calendar-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            margin-bottom: 25px;
        }
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .calendar-nav { cursor: pointer; color: var(--text-light); }
        
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            gap: 5px;
        }
        .day-name {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 10px;
        }
        .day-name.sunday { color: #E53935; }
        
        .day-cell {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            border-radius: 50%;
            position: relative;
            color: var(--text-light);
            margin: 2px;
        }
        .day-cell.active-month { color: var(--text-dark); }
        .day-cell.sunday { color: #E53935; }
        
        /* Status Colors */
        .day-cell.status-hadir {
            background-color: var(--primary);
            color: white;
        }
        .day-cell.status-izin {
            background-color: var(--secondary);
            color: var(--text-dark);
        }
        .day-cell.today {
            border: 2px solid var(--primary);
            background-color: transparent;
            color: var(--primary);
        }
        
        /* Checkmark for hadir */
        .day-cell.status-hadir::after {
            content: '';
            position: absolute;
            bottom: -2px; right: -2px;
            width: 10px; height: 10px;
            background-color: white;
            border-radius: 50%;
            border: 2px solid var(--primary);
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%232E7D32"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>');
            background-size: 8px;
            background-position: center;
            background-repeat: no-repeat;
        }

        .section-title { font-size: 16px; font-weight: 700; margin-bottom: 15px; }
        
        .history-item {
            background: white;
            border-radius: 16px;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02);
            margin-bottom: 10px;
        }
        .history-icon {
            width: 40px; height: 40px;
            border-radius: 50%;
            background-color: #E8F5E9;
            color: var(--primary);
            display: flex; align-items: center; justify-content: center;
        }
        .history-title { font-weight: 700; font-size: 14px; margin-bottom: 4px; }
        .history-time { font-size: 12px; color: var(--text-light); }
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
            <div class="page-header
                <h2>Presensi Bulanan</h2>
                <p>Pantau kehadiran harian anak Anda.</p>
            </div>

            <div class="stats-grid scroll-reveal">
                <div class="stat-card hadir bounce-in">
                    <div class="stat-number">20</div>
                    <div class="stat-label">Hadir</div>
                </div>
                <div class="stat-card iz
                    <div class="stat-number">1</div>
                    <div class="stat-label">Izin</div>
                </div>
                <div class="stat-card sakit
                    <div class="stat-number">0</div>
                    <div class="stat-label">Sakit</div>
                </div>
            </div>

            <!-- Calendar -->
            <div class="calendar-card card-hover scroll-reveal">
                <div class="calendar-header">
                    <svg class="calendar-nav" style="width:20px;height:20px;" viewBox="0 0 24 24" fill="currentColor"><path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"/></svg>
                    <span>Oktober 2023</span>
                    <svg class="calendar-nav" style="width:20px;height:20px;" viewBox="0 0 24 24" fill="currentColor"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>
                </div>
                
                <div class="calendar-grid">
                    <div class="day-name sunday">M</div>
                    <div class="day-name">S</div>
                    <div class="day-name">S</div>
                    <div class="day-name">R</div>
                    <div class="day-name">K</div>
                    <div class="day-name">J</div>
                    <div class="day-name">S</div>
                    
                    <!-- Week 1 -->
                    <div class="day-cell sunday">1</div>
                    <div class="day-cell active-month status-hadir">2</div>
                    <div class="day-cell active-month status-hadir">3</div>
                    <div class="day-cell active-month status-hadir">4</div>
                    <div class="day-cell active-month status-izin">5</div>
                    <div class="day-cell active-month">6</div>
                    <div class="day-cell active-month">7</div>
                    
                    <!-- Week 2 -->
                    <div class="day-cell sunday active-month">8</div>
                    <div class="day-cell active-month status-hadir">9</div>
                    <div class="day-cell active-month status-hadir">10</div>
                    <div class="day-cell active-month status-hadir">11</div>
                    <div class="day-cell active-month status-hadir">12</div>
                    <div class="day-cell active-month status-hadir">13</div>
                    <div class="day-cell active-month">14</div>
                    
                    <!-- Week 3 -->
                    <div class="day-cell sunday active-month">15</div>
                    <div class="day-cell active-month">16</div>
                    <div class="day-cell active-month">17</div>
                    <div class="day-cell active-month">18</div>
                    <div class="day-cell active-month">19</div>
                    <div class="day-cell active-month today">20</div>
                    <div class="day-cell active-month">21</div>
                    
                    <!-- Week 4 -->
                    <div class="day-cell sunday active-month">22</div>
                    <div class="day-cell active-month">23</div>
                    <div class="day-cell active-month">24</div>
                    <div class="day-cell active-month">25</div>
                    <div class="day-cell active-month">26</div>
                    <div class="day-cell active-month">27</div>
                    <div class="day-cell active-month">28</div>
                    
                    <!-- Week 5 -->
                    <div class="day-cell sunday active-month">29</div>
                    <div class="day-cell active-month">30</div>
                    <div class="day-cell active-month">31</div>
                    <div class="day-cell">1</div>
                    <div class="day-cell">2</div>
                    <div class="day-cell">3</div>
                    <div class="day-cell">4</div>
                </div>
            </div>

            <!-- History -->
            <div class="section-title scroll-reveal">Riwayat Terakhir</div>
            <div class="history-item card-hover scroll-reveal">
                <div class="history-icon">
                    <svg style="width:20px;height:20px;fill:currentColor;" viewBox="0 0 24 24"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>
                </div>
                <div>
                    <div class="history-title">Hadir</div>
                    <div class="history-time">Jumat, 13 Okt 2023 • 15:30 WIB</div>
                </div>
            </div>
            
            <div class="history-item">
                <div class="history-icon" style="background:#FFF8E1; color:var(--secondary);">
                    <svg style="width:20px;height:20px;fill:currentColor;" viewBox="0 0 24 24"><path d="M11 15h2v2h-2zm0-8h2v6h-2zm.99-5C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/></svg>
                </div>
                <div>
                    <div class="history-title">Izin</div>
                    <div class="history-time">Kamis, 5 Okt 2023 • 08:00 WIB</div>
                </div>
            </div>
        </div>

        <!-- Bottom Navigation -->
        <div class="bottom-nav">
            <a href="{{ route('wali.dashboard') }}" class="nav-item">
                <svg class="nav-icon" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                Beranda
            </a>
            <a href="{{ route('wali.iqro') }}" class="nav-item
                <svg class="nav-icon" viewBox="0 0 24 24"><path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/></svg>
                Iqro
            </a>
            <a href="{{ route('wali.presensi') }}" class="nav-item active hover-scale">
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
