<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Riwayat Presensi - Darul Ikhlas</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-primary-fixed": "#002114",
                        "on-primary-container": "#8fe2ba",
                        "primary-fixed-dim": "#84d7af",
                        "on-tertiary-container": "#ccd3d5",
                        "on-secondary-fixed": "#0c1f19",
                        "inverse-on-surface": "#eef2ed",
                        "surface-variant": "#e0e3df",
                        "error-container": "#ffdad6",
                        "surface-container-highest": "#e0e3df",
                        "tertiary-fixed-dim": "#c1c8ca",
                        "tertiary-container": "#545b5d",
                        "primary-fixed": "#a0f4ca",
                        "on-tertiary-fixed-variant": "#41484a",
                        "on-secondary": "#ffffff",
                        "on-primary": "#ffffff",
                        "on-surface": "#181d1a",
                        "tertiary-fixed": "#dde4e6",
                        "inverse-surface": "#2d312e",
                        "secondary": "#4f635b",
                        "primary": "#004d34",
                        "secondary-container": "#d1e7dd",
                        "primary-container": "#006747",
                        "on-tertiary-fixed": "#161d1f",
                        "on-secondary-container": "#556961",
                        "inverse-primary": "#84d7af",
                        "surface": "#f7faf5",
                        "background": "#f7faf5",
                        "secondary-fixed-dim": "#b6cbc2",
                        "secondary-fixed": "#d1e7dd",
                        "surface-container-lowest": "#ffffff",
                        "on-error": "#ffffff",
                        "surface-dim": "#d7dbd6",
                        "on-primary-fixed-variant": "#005137",
                        "surface-bright": "#f7faf5",
                        "surface-tint": "#0b6c4b",
                        "surface-container": "#ebefea",
                        "tertiary": "#3d4446",
                        "outline-variant": "#bec9c1",
                        "on-surface-variant": "#3f4943",
                        "surface-container-low": "#f1f5f0",
                        "on-tertiary": "#ffffff",
                        "outline": "#6f7a72",
                        "surface-container-high": "#e5e9e4",
                        "on-secondary-fixed-variant": "#374b44",
                        "on-error-container": "#93000a",
                        "on-background": "#181d1a",
                        "error": "#ba1a1a"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "base": "8px",
                        "md": "24px",
                        "xl": "80px",
                        "sm": "12px",
                        "xs": "4px",
                        "margin": "24px",
                        "gutter": "16px",
                        "lg": "48px"
                    },
                    "fontFamily": {
                        "h1": ["Plus Jakarta Sans"],
                        "label-sm": ["Plus Jakarta Sans"],
                        "h3": ["Plus Jakarta Sans"],
                        "body-lg": ["Plus Jakarta Sans"],
                        "body-sm": ["Plus Jakarta Sans"],
                        "label-md": ["Plus Jakarta Sans"],
                        "h2": ["Plus Jakarta Sans"],
                        "body-md": ["Plus Jakarta Sans"]
                    },
                    "fontSize": {
                        "h1": ["40px", { "lineHeight": "1.2", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "label-sm": ["12px", { "lineHeight": "1.2", "fontWeight": "500" }],
                        "h3": ["24px", { "lineHeight": "1.4", "fontWeight": "600" }],
                        "body-lg": ["18px", { "lineHeight": "1.6", "fontWeight": "400" }],
                        "body-sm": ["14px", { "lineHeight": "1.5", "fontWeight": "400" }],
                        "label-md": ["14px", { "lineHeight": "1.2", "letterSpacing": "0.01em", "fontWeight": "600" }],
                        "h2": ["32px", { "lineHeight": "1.3", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "body-md": ["16px", { "lineHeight": "1.6", "fontWeight": "400" }]
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: theme('colors.background');
            color: theme('colors.on-background');
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>
<body class="antialiased min-h-screen pb-24 md:pb-0">
    <!-- TopAppBar -->
    <header class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md font-plus-jakarta-sans font-bold text-lg text-emerald-800 dark:text-emerald-400 docked full-width top-0 sticky border-b border-slate-100 dark:border-slate-800 shadow-sm flex items-center justify-between px-6 h-16 w-full z-40 transition-colors duration-200 ease-in-out hover:bg-emerald-50 dark:hover:bg-emerald-900/20">
        <div class="flex items-center gap-sm">
            <div class="w-8 h-8 rounded-full overflow-hidden bg-surface-container-highest border border-outline-variant flex items-center justify-center">
                <span class="material-symbols-outlined text-on-surface-variant text-[20px]" data-icon="person">person</span>
            </div>
            <span class="font-plus-jakarta-sans font-extrabold text-emerald-900 dark:text-emerald-100">Darul Ikhlas</span>
        </div>
        <div class="flex items-center">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="w-10 h-10 rounded-full flex items-center justify-center text-emerald-800 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors" type="submit">
                    <span class="material-symbols-outlined" data-icon="logout">logout</span>
                </button>
            </form>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-md">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('wali.dashboard') }}" class="inline-flex items-center gap-1 text-sm text-on-surface-variant hover:text-primary transition-colors font-label-md">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali
            </a>
        </div>

        <!-- Breadcrumbs & Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-sm mb-md">
            <div>
                <nav aria-label="Breadcrumb" class="flex text-on-surface-variant font-label-md text-label-md mb-xs">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li class="inline-flex items-center">
                            <a class="inline-flex items-center hover:text-primary transition-colors" href="{{ route('wali.dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <span class="material-symbols-outlined text-[16px] mx-1">chevron_right</span>
                                <span aria-current="page" class="text-on-surface">Presensi</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="font-h2 text-h2 text-on-surface">Riwayat Presensi</h1>
            </div>
            <!-- Month Selector -->
            <div class="relative">
                <select class="appearance-none bg-surface-container-lowest border border-outline-variant text-on-surface font-body-md text-body-md rounded-lg pl-sm pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary cursor-pointer w-full sm:w-auto shadow-sm">
                    <option value="10-2023">Oktober 2023</option>
                    <option value="09-2023">September 2023</option>
                    <option value="08-2023">Agustus 2023</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-on-surface-variant">
                    <span class="material-symbols-outlined">expand_more</span>
                </div>
            </div>
        </div>

        <!-- Summary Stats Bento Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-sm md:gap-md mb-lg">
            <!-- Hadir -->
            <div class="bg-surface-container-lowest rounded-xl p-sm md:p-md border border-outline-variant shadow-sm relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-1 bg-primary"></div>
                <div class="flex items-start justify-between">
                    <div>
                        <p class="font-label-md text-label-md text-on-surface-variant mb-xs">Hadir</p>
                        <h3 class="font-h2 text-h2 text-primary">{{ $totalHadir ?? 0 }}</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Hari</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-primary-container/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined" data-weight="fill">check_circle</span>
                    </div>
                </div>
            </div>
            <!-- Izin -->
            <div class="bg-surface-container-lowest rounded-xl p-sm md:p-md border border-outline-variant shadow-sm relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-1 bg-[#F59E0B]"></div>
                <div class="flex items-start justify-between">
                    <div>
                        <p class="font-label-md text-label-md text-on-surface-variant mb-xs">Izin</p>
                        <h3 class="font-h2 text-h2 text-[#F59E0B]">{{ $totalIzin ?? 0 }}</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Hari</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-[#F59E0B]/10 flex items-center justify-center text-[#F59E0B]">
                        <span class="material-symbols-outlined" data-weight="fill">info</span>
                    </div>
                </div>
            </div>
            <!-- Sakit -->
            <div class="bg-surface-container-lowest rounded-xl p-sm md:p-md border border-outline-variant shadow-sm relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-1 bg-[#3B82F6]"></div>
                <div class="flex items-start justify-between">
                    <div>
                        <p class="font-label-md text-label-md text-on-surface-variant mb-xs">Sakit</p>
                        <h3 class="font-h2 text-h2 text-[#3B82F6]">{{ $totalSakit ?? 0 }}</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Hari</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-[#3B82F6]/10 flex items-center justify-center text-[#3B82F6]">
                        <span class="material-symbols-outlined" data-weight="fill">medical_services</span>
                    </div>
                </div>
            </div>
            <!-- Alpa -->
            <div class="bg-surface-container-lowest rounded-xl p-sm md:p-md border border-outline-variant shadow-sm relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-1 bg-error"></div>
                <div class="flex items-start justify-between">
                    <div>
                        <p class="font-label-md text-label-md text-on-surface-variant mb-xs">Alpa</p>
                        <h3 class="font-h2 text-h2 text-error">{{ $totalAlpa ?? 0 }}</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Hari</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-error-container flex items-center justify-center text-on-error-container">
                        <span class="material-symbols-outlined" data-weight="fill">cancel</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area: Calendar & Legend -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-md items-start">
            <!-- Calendar View -->
            <div class="lg:col-span-3 bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm overflow-hidden">
                <div class="p-md border-b border-outline-variant flex justify-between items-center bg-surface-container-low">
                    <h2 class="font-h3 text-h3 text-on-surface">Kalender Presensi</h2>
                    <div class="flex gap-2">
                        <button class="p-1 rounded hover:bg-surface-variant transition-colors text-on-surface-variant">
                            <span class="material-symbols-outlined">chevron_left</span>
                        </button>
                        <button class="p-1 rounded hover:bg-surface-variant transition-colors text-on-surface-variant">
                            <span class="material-symbols-outlined">chevron_right</span>
                        </button>
                    </div>
                </div>
                <div class="p-sm md:p-md">
                    <!-- Days Header -->
                    <div class="grid grid-cols-7 gap-1 text-center mb-sm">
                        <div class="font-label-md text-label-md text-error py-2">Min</div>
                        <div class="font-label-md text-label-md text-on-surface-variant py-2">Sen</div>
                        <div class="font-label-md text-label-md text-on-surface-variant py-2">Sel</div>
                        <div class="font-label-md text-label-md text-on-surface-variant py-2">Rab</div>
                        <div class="font-label-md text-label-md text-on-surface-variant py-2">Kam</div>
                        <div class="font-label-md text-label-md text-on-surface-variant py-2">Jum</div>
                        <div class="font-label-md text-label-md text-on-surface-variant py-2">Sab</div>
                    </div>
                    <!-- Calendar Grid -->
                    <div class="grid grid-cols-7 gap-1 md:gap-2">
                        @php
                            $daysInMonth = 31;
                            $firstDayOfMonth = 0; // 0 = Sunday
                            $today = date('j');
                            $attendanceData = []; // This should be populated from controller
                        @endphp
                        
                        @for($i = 0; $i < $firstDayOfMonth; $i++)
                            <div class="aspect-square flex items-center justify-center font-body-md text-body-md text-outline rounded-lg bg-surface-container-low/50">{{ $i + 1 }}</div>
                        @endfor
                        
                        @for($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $dayOfWeek = ($firstDayOfMonth + $day - 1) % 7;
                                $isSunday = $dayOfWeek == 0;
                                $isToday = $day == $today;
                                $status = $attendanceData[$day] ?? null;
                            @endphp
                            
                            @if($isSunday)
                                <div class="aspect-square flex flex-col items-center justify-center font-body-md text-body-md text-error rounded-lg bg-error-container/20 border border-transparent">
                                    <span>{{ $day }}</span>
                                </div>
                            @elseif($isToday)
                                <div class="aspect-square flex flex-col items-center justify-center font-body-md text-body-md text-on-primary rounded-lg bg-primary cursor-pointer border border-transparent shadow-md relative group">
                                    <span class="font-bold">{{ $day }}</span>
                                    @if($status == 'hadir')
                                        <div class="w-1.5 h-1.5 rounded-full bg-on-primary mt-1"></div>
                                    @elseif($status == 'izin')
                                        <div class="w-1.5 h-1.5 rounded-full bg-[#F59E0B] mt-1"></div>
                                    @elseif($status == 'sakit')
                                        <div class="w-1.5 h-1.5 rounded-full bg-[#3B82F6] mt-1"></div>
                                    @elseif($status == 'alpa')
                                        <div class="w-1.5 h-1.5 rounded-full bg-error mt-1"></div>
                                    @endif
                                </div>
                            @else
                                <div class="aspect-square flex flex-col items-center justify-center font-body-md text-body-md text-on-surface rounded-lg bg-surface hover:bg-surface-variant cursor-pointer border border-transparent transition-colors relative group">
                                    <span>{{ $day }}</span>
                                    @if($status == 'hadir')
                                        <div class="w-1.5 h-1.5 rounded-full bg-primary mt-1"></div>
                                    @elseif($status == 'izin')
                                        <div class="w-1.5 h-1.5 rounded-full bg-[#F59E0B] mt-1"></div>
                                    @elseif($status == 'sakit')
                                        <div class="w-1.5 h-1.5 rounded-full bg-[#3B82F6] mt-1"></div>
                                    @elseif($status == 'alpa')
                                        <div class="w-1.5 h-1.5 rounded-full bg-error mt-1"></div>
                                    @endif
                                </div>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Legend Section -->
            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm p-md">
                <h3 class="font-h3 text-h3 text-on-surface mb-sm pb-xs border-b border-outline-variant">Keterangan</h3>
                <ul class="space-y-sm">
                    <li class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-primary shadow-sm"></div>
                        <span class="font-body-md text-body-md text-on-surface-variant">Hadir Tepat Waktu</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-[#F59E0B] shadow-sm"></div>
                        <span class="font-body-md text-body-md text-on-surface-variant">Izin / Terlambat</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-[#3B82F6] shadow-sm"></div>
                        <span class="font-body-md text-body-md text-on-surface-variant">Sakit</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-error shadow-sm"></div>
                        <span class="font-body-md text-body-md text-on-surface-variant">Tanpa Keterangan (Alpa)</span>
                    </li>
                    <li class="flex items-center gap-3 pt-xs mt-xs border-t border-outline-variant">
                        <div class="w-6 h-6 rounded bg-error-container/20 flex items-center justify-center border border-error/20">
                            <span class="text-[10px] text-error font-bold">L</span>
                        </div>
                        <span class="font-body-md text-body-md text-on-surface-variant">Hari Libur / Minggu</span>
                    </li>
                </ul>
                <!-- Quick Action -->
                <div class="mt-lg pt-sm border-t border-outline-variant">
                    <button class="w-full bg-surface-container border border-outline-variant hover:bg-surface-variant text-on-surface font-label-md py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">download</span>
                        Unduh Rekap Bulanan
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- BottomNavBar (Mobile Only) -->
    <nav class="md:hidden bg-white dark:bg-slate-950 font-['Plus_Jakarta_Sans'] text-[11px] font-medium fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 pb-safe pt-2 h-20 rounded-t-2xl border-t border-slate-100 dark:border-slate-800 shadow-[0_-4px_12px_rgba(0,103,71,0.05)] transition-all duration-300 ease-in-out">
        <a class="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-300" href="{{ route('wali.dashboard') }}">
            <span class="material-symbols-outlined mb-1 text-[24px]" data-icon="home">home</span>
            <span>Home</span>
        </a>
        <a class="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-300" href="{{ route('wali.iqro') }}">
            <span class="material-symbols-outlined mb-1 text-[24px]" data-icon="menu_book">menu_book</span>
            <span>Iqro</span>
        </a>
        <a class="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-300" href="{{ route('wali.sholat') }}">
            <span class="material-symbols-outlined mb-1 text-[24px]" data-icon="mosque">mosque</span>
            <span>Sholat</span>
        </a>
        <a class="flex flex-col items-center justify-center text-emerald-700 dark:text-emerald-400 font-bold bg-emerald-50/50 dark:bg-emerald-900/20 rounded-xl px-3 py-1 hover:text-emerald-600 dark:hover:text-emerald-300" href="{{ route('wali.presensi') }}">
            <span class="material-symbols-outlined mb-1 text-[24px]" data-icon="fact_check" data-weight="fill" style="font-variation-settings: 'FILL' 1;">fact_check</span>
            <span>Attendance</span>
        </a>
        <a class="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-300" href="{{ route('wali.profile') }}">
            <span class="material-symbols-outlined mb-1 text-[24px]" data-icon="person">person</span>
            <span>Profile</span>
        </a>
    </nav>
</body>
</html>
