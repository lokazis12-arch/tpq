<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Laporan - Darul Ikhlas</title>
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
        }
        .pattern-bg {
            background-image: radial-gradient(theme('colors.primary') 1px, transparent 1px);
            background-size: 24px 24px;
            opacity: 0.03;
        }
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col pb-20 md:pb-0">
    <!-- TopAppBar -->
    <header class="bg-white/90 dark:bg-slate-950/90 backdrop-blur-md font-['Plus_Jakarta_Sans'] font-semibold text-lg docked full-width top-0 sticky border-b border-slate-100 dark:border-slate-800 shadow-sm shadow-emerald-900/5 transition-colors duration-200 ease-in-out flex justify-between items-center w-full px-4 h-16 z-50">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-800 flex items-center justify-center text-emerald-800 dark:text-emerald-100 font-bold shadow-sm border border-slate-200">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="flex flex-col">
                <span class="font-h3 text-h3 text-emerald-900 dark:text-emerald-50 font-extrabold text-[18px]">Darul Ikhlas</span>
                <span class="font-label-sm text-label-sm text-slate-500">Dashboard → Laporan</span>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="hidden md:flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 transition-colors font-label-md text-label-md" type="submit">
                    <span class="material-symbols-outlined text-[20px]" data-icon="logout">logout</span>
                    Keluar
                </button>
            </form>
        </div>
    </header>

    <!-- Main Content Canvas -->
    <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 relative">
        <div class="absolute inset-0 pattern-bg pointer-events-none z-[-1]"></div>

        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('wali.dashboard') }}" class="inline-flex items-center gap-1 text-sm text-on-surface-variant hover:text-primary transition-colors font-label-md">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali
            </a>
        </div>

        <!-- Student Info Card -->
        <div class="bg-surface-container-lowest rounded-xl p-6 shadow-[0_4px_20px_-4px_rgba(0,77,52,0.05)] border border-surface-variant mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-emerald-100 dark:bg-emerald-800 flex items-center justify-center text-emerald-800 dark:text-emerald-100 font-h2 text-h2 shadow-sm border border-emerald-200">
                    {{ substr($currentSantri->nama_lengkap ?? 'Santri', 0, 2) }}
                </div>
                <div>
                    <h2 class="font-h3 text-h3 text-on-surface">{{ $currentSantri->nama_lengkap ?? 'Santri' }}</h2>
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">NIS: {{ $currentSantri->nis ?? '-' }}</p>
                </div>
            </div>
            <div class="bg-surface-container rounded-lg px-4 py-2 flex items-center gap-2">
                <span class="text-xl">📖</span>
                <span class="font-label-md text-label-md text-on-surface">Level: {{ $currentSantri->pengajian ?? 'Tidak ada level' }}</span>
            </div>
        </div>

        <!-- Page Header & Month Selector -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="font-h2 text-h2 text-on-surface">📊 Laporan Pembelajaran</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-1">Rekap perkembangan belajar {{ $currentSantri->nama_lengkap ?? 'Santri' }} bulan ini</p>
            </div>
            <div class="relative min-w-[200px]">
                <label class="sr-only" for="month-select">Pilih Bulan</label>
                <div class="relative">
                    <select class="appearance-none w-full bg-surface-container-lowest border border-outline-variant text-on-surface font-label-md text-label-md rounded-lg pl-4 pr-10 py-3 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary shadow-sm" id="month-select">
                        <option selected="" value="april-2026">April 2026</option>
                        <option value="maret-2026">Maret 2026</option>
                        <option value="februari-2026">Februari 2026</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-outline">
                        <span class="material-symbols-outlined">expand_more</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Stats Grid -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <!-- Kehadiran -->
            <div class="bg-surface-container-lowest rounded-xl p-6 shadow-[0_4px_20px_-4px_rgba(0,77,52,0.05)] border border-surface-variant relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-primary"></div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-primary-fixed-variant">
                        <span class="material-symbols-outlined" data-icon="calendar_today">calendar_today</span>
                    </div>
                    <h2 class="font-h3 text-h3 text-on-surface text-[20px]">Kehadiran</h2>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-on-surface-variant mb-1">Hadir</span>
                        <span class="font-h2 text-h2 text-primary text-[28px]">{{ $totalHadir ?? 0 }}<span class="text-[14px] text-outline font-normal">/{{ $totalHari ?? 0 }}</span></span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-on-surface-variant mb-1">Izin</span>
                        <span class="font-h3 text-h3 text-secondary text-[24px]">{{ $totalIzin ?? 0 }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-on-surface-variant mb-1">Sakit</span>
                        <span class="font-h3 text-h3 text-secondary text-[24px]">{{ $totalSakit ?? 0 }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-on-surface-variant mb-1">Alpa</span>
                        <span class="font-h3 text-h3 text-error text-[24px]">{{ $totalAlpa ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <!-- Progress Iqro -->
            <div class="bg-surface-container-lowest rounded-xl p-6 shadow-[0_4px_20px_-4px_rgba(0,77,52,0.05)] border border-surface-variant relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-secondary"></div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-secondary-fixed flex items-center justify-center text-on-secondary-fixed">
                        <span class="material-symbols-outlined" data-icon="menu_book">menu_book</span>
                    </div>
                    <h2 class="font-h3 text-h3 text-on-surface text-[20px]">Progress Iqro</h2>
                </div>
                <div class="mt-4">
                    <div class="flex justify-between items-end mb-2">
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm text-on-surface-variant">Posisi Saat Ini</span>
                            <span class="font-h2 text-h2 text-primary text-[28px]">{{ $iqroJilid ?? 'Jilid 1' }}</span>
                        </div>
                        <span class="font-body-md text-body-md font-medium text-secondary">Hal. {{ $iqroHalaman ?? 0 }}</span>
                    </div>
                    <div class="mt-6">
                        <div class="flex justify-between font-label-sm text-label-sm mb-2">
                            <span class="text-on-surface-variant">Pencapaian Target Bulan Ini</span>
                            <span class="text-primary font-bold">{{ $iqroProgress ?? 0 }}%</span>
                        </div>
                        <div class="w-full bg-surface-variant rounded-full h-2.5">
                            <div class="bg-primary-container h-2.5 rounded-full" style="width: {{ $iqroProgress ?? 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Sholat -->
            <div class="bg-surface-container-lowest rounded-xl p-6 shadow-[0_4px_20px_-4px_rgba(0,77,52,0.05)] border border-surface-variant relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-tertiary-container"></div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-tertiary-fixed flex items-center justify-center text-on-tertiary-fixed">
                        <span class="material-symbols-outlined" data-icon="mosque">mosque</span>
                    </div>
                    <h2 class="font-h3 text-h3 text-on-surface text-[20px]">Hafalan Surah</h2>
                </div>
                <div class="mt-4">
                    <div class="flex flex-col mb-4">
                        <span class="font-label-sm text-label-sm text-on-surface-variant">Surah Terakhir Dikuasai</span>
                        <span class="font-h2 text-h2 text-primary text-[24px] mt-1">{{ $lastSurah ?? 'Belum ada' }}</span>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between font-label-sm text-label-sm mb-2">
                            <span class="text-on-surface-variant">Kualitas Hafalan Rata-rata</span>
                            <span class="text-secondary font-bold">{{ $hafalanGrade ?? '-' }}</span>
                        </div>
                        <div class="flex gap-1 mt-2">
                            <div class="h-2 w-full bg-primary rounded-l-full"></div>
                            <div class="h-2 w-full bg-primary"></div>
                            <div class="h-2 w-full bg-primary"></div>
                            <div class="h-2 w-full bg-surface-variant"></div>
                            <div class="h-2 w-full bg-surface-variant rounded-r-full"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Detailed Lists Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
            <!-- Iqro Details -->
            <section class="bg-surface-container-lowest rounded-xl border border-surface-variant shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)] overflow-hidden">
                <div class="p-6 border-b border-surface-variant bg-surface-container-low/50">
                    <h3 class="font-h3 text-h3 text-on-surface">📚 Progres Iqro Terbaru</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Catatan harian ustadz/ustadzah bulan ini.</p>
                </div>
                <div class="divide-y divide-surface-variant">
                    @if(isset($iqroHistory) && $iqroHistory->count() > 0)
                        @foreach($iqroHistory->take(2) as $history)
                            <div class="p-6 flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                                <div class="flex gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-surface flex flex-col items-center justify-center border border-outline-variant">
                                        <span class="font-label-sm text-label-sm text-on-surface-variant">{{ \Carbon\Carbon::parse($history->tanggal)->format('M') }}</span>
                                        <span class="font-h3 text-h3 text-on-surface text-[16px]">{{ \Carbon\Carbon::parse($history->tanggal)->format('j') }}</span>
                                    </div>
                                    <div>
                                        <h4 class="font-label-md text-label-md text-on-surface">{{ $history->jilid }} - Halaman {{ $history->halaman }}</h4>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-2">📝 {{ $history->catatan ?? 'Tidak ada catatan' }}</p>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 flex sm:flex-col items-center sm:items-end gap-2">
                                    <span class="inline-flex items-center rounded-full bg-primary-fixed px-2.5 py-0.5 font-label-sm text-label-sm font-semibold text-on-primary-fixed-variant">
                                        {{ $history->status ?? 'LULUS' }}
                                    </span>
                                    <span class="font-body-sm text-body-sm text-outline">{{ $history->guru ?? 'Ust.' }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="p-6 text-center text-on-surface-variant">
                            <p>Belum ada data progres Iqro</p>
                        </div>
                    @endif
                </div>
                <div class="p-4 bg-surface-container-low text-center border-t border-surface-variant">
                    <button class="font-label-md text-label-md text-primary hover:text-primary-container transition-colors">Lihat Semua Riwayat</button>
                </div>
            </section>

            <!-- Sholat/Hafalan Details -->
            <section class="bg-surface-container-lowest rounded-xl border border-surface-variant shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)] overflow-hidden">
                <div class="p-6 border-b border-surface-variant bg-surface-container-low/50">
                    <h3 class="font-h3 text-h3 text-on-surface">Riwayat Sholat</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Perkembangan praktik sholat.</p>
                </div>
                <div class="divide-y divide-surface-variant">
                    @if(isset($hafalanHistory) && $hafalanHistory->count() > 0)
                        @foreach($hafalanHistory->take(2) as $history)
                            <div class="p-6 flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                                <div class="flex gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-surface flex flex-col items-center justify-center border border-outline-variant">
                                        <span class="font-label-sm text-label-sm text-on-surface-variant">{{ \Carbon\Carbon::parse($history->tanggal)->format('M') }}</span>
                                        <span class="font-h3 text-h3 text-on-surface text-[16px]">{{ \Carbon\Carbon::parse($history->tanggal)->format('j') }}</span>
                                    </div>
                                    <div>
                                        <h4 class="font-label-md text-label-md text-on-surface">Progress: {{ $history->progress_percentage }}%</h4>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">{{ $history->completed_count }}/14 rukun sholat terlengkapi</p>
                                        @if($history->catatan_guru)
                                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-2">📝 {{ $history->catatan_guru }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-shrink-0 flex sm:flex-col items-center sm:items-end gap-2">
                                    <span class="inline-flex items-center rounded-full {{ $history->status_lulus ? 'bg-secondary-fixed' : 'bg-surface-variant' }} px-2.5 py-0.5 font-label-sm text-label-sm font-semibold {{ $history->status_lulus ? 'text-on-secondary-fixed-variant' : 'text-on-surface-variant' }}">
                                        {{ $history->status_lulus ? 'Lulus' : 'Progres' }}
                                    </span>
                                    <span class="font-body-sm text-body-sm text-outline">{{ $history->guru ? $history->guru->name : 'Ust.' }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="p-6 text-center text-on-surface-variant">
                            <p>Belum ada data sholat</p>
                        </div>
                    @endif
                </div>
                <div class="p-4 bg-surface-container-low text-center border-t border-surface-variant">
                    <button class="font-label-md text-label-md text-primary hover:text-primary-container transition-colors">Lihat Semua Riwayat</button>
                </div>
            </section>
        </div>

        <!-- Insights / Catatan Wali Kelas Section -->
        <section class="bg-primary-container rounded-2xl p-8 shadow-lg text-on-primary-container relative overflow-hidden">
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-5"></div>
            <div class="relative z-10 flex flex-col md:flex-row gap-8 items-start">
                <div class="flex-shrink-0 bg-white/10 p-4 rounded-xl backdrop-blur-sm">
                    <span class="material-symbols-outlined text-[40px] text-white" data-icon="lightbulb">lightbulb</span>
                </div>
                <div class="flex-grow">
                    <h3 class="font-h2 text-h2 text-white mb-2">💡 Insight Pembelajaran</h3>
                    <p class="font-body-lg text-body-lg text-primary-fixed mb-6 max-w-3xl">{{ $insight ?? 'Ananda menunjukkan peningkatan fokus yang signifikan pada bulan ini. Keterlibatan dalam kelas mengaji sangat aktif.' }}</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-white/5 border border-white/10 rounded-lg p-4">
                            <h4 class="font-label-md text-label-md text-white flex items-center gap-2 mb-1">
                                🌟 Kehadiran Sangat Baik
                            </h4>
                            <p class="font-body-sm text-body-sm text-primary-fixed-dim">Anak sangat konsisten dalam kehadiran belajar.</p>
                        </div>
                        <div class="bg-white/5 border border-white/10 rounded-lg p-4">
                            <h4 class="font-label-md text-label-md text-white flex items-center gap-2 mb-1">
                                🎯 Progres Cepat
                            </h4>
                            <p class="font-body-sm text-body-sm text-primary-fixed-dim">Anak menunjukkan kemajuan yang sangat baik.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
        <a class="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-300" href="{{ route('wali.presensi') }}">
            <span class="material-symbols-outlined mb-1 text-[24px]" data-icon="fact_check">fact_check</span>
            <span>Attendance</span>
        </a>
        <a class="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-300" href="{{ route('wali.profile') }}">
            <span class="material-symbols-outlined mb-1 text-[24px]" data-icon="person">person</span>
            <span>Profile</span>
        </a>
    </nav>
</body>
</html>
