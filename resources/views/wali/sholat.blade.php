<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Progres Sholat - Darul Ikhlas</title>
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
                <span class="font-label-sm text-label-sm text-slate-500">Dashboard → Progres Sholat</span>
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

        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 mb-8">
            <a class="text-primary hover:text-primary-container transition-colors font-label-md text-label-md" href="{{ route('wali.dashboard') }}">Dashboard</a>
            <span class="material-symbols-outlined text-sm text-on-surface-variant">chevron_right</span>
            <span class="text-on-surface font-medium font-label-md text-label-md">Progres Sholat</span>
        </div>

        @if($santri)
            <!-- Student Info Card -->
            <div class="bg-surface-container-lowest rounded-xl p-6 shadow-[0_4px_20px_-4px_rgba(0,77,52,0.05)] border border-surface-variant mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-emerald-100 dark:bg-emerald-800 flex items-center justify-center text-emerald-800 dark:text-emerald-100 font-h2 text-h2 shadow-sm border border-emerald-200">
                        {{ substr($santri->nama_lengkap, 0, 2) }}
                    </div>
                    <div>
                        <h2 class="font-h3 text-h3 text-on-surface">{{ $santri->nama_lengkap }}</h2>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">NIS: {{ $santri->nis }}</p>
                    </div>
                </div>
                <div class="bg-surface-container rounded-lg px-4 py-2 flex items-center gap-2">
                    <span class="text-xl">🕌</span>
                    <span class="font-label-md text-label-md text-on-surface">Level: {{ $santri->pengajian ?? 'Tidak ada level' }}</span>
                </div>
            </div>

            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="font-h2 text-h2 text-on-surface">🕌 Progres Bacaan Sholat</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-1">Pantau perkembangan praktik sholat {{ $santri->nama_lengkap }}</p>
            </div>

            @if($latestSholat)
                <!-- Latest Progress Card -->
                <section class="bg-primary-container rounded-2xl p-8 shadow-lg text-on-primary-container relative overflow-hidden mb-8">
                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-5"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-6">
                            <span class="material-symbols-outlined text-[32px]">mosque</span>
                            <h2 class="font-h2 text-h2 text-white">Progres Terbaru</h2>
                            <span class="ml-auto font-label-md text-label-md text-primary-fixed">{{ \Carbon\Carbon::parse($latestSholat->tanggal)->locale('id')->translatedFormat('d F Y') }}</span>
                        </div>
                        
                        <div class="mb-6">
                            <div class="flex justify-between font-label-md text-label-md mb-2">
                                <span class="text-white">Progress Keseluruhan</span>
                                <span class="text-white font-bold">{{ number_format($latestSholat->progress_percentage, 0) }}%</span>
                            </div>
                            <div class="w-full bg-white/20 rounded-full h-3">
                                <div class="bg-white h-3 rounded-full transition-all duration-500" style="width: {{ $latestSholat->progress_percentage }}%"></div>
                            </div>
                            <p class="font-body-sm text-body-sm text-primary-fixed mt-2">{{ $latestSholat->completed_count }}/14 rukun sholat terlengkapi</p>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-7 gap-3">
                            <div class="bg-white/10 rounded-lg p-3 flex flex-col items-center gap-2 backdrop-blur-sm border border-white/10">
                                <div class="w-8 h-8 rounded-full {{ $latestSholat->niat ? 'bg-primary-fixed text-on-primary-fixed-variant' : 'bg-white/20 text-white/60' }} flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[16px]">{{ $latestSholat->niat ? 'check' : 'close' }}</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-white text-center">Niat</span>
                            </div>
                            <div class="bg-white/10 rounded-lg p-3 flex flex-col items-center gap-2 backdrop-blur-sm border border-white/10">
                                <div class="w-8 h-8 rounded-full {{ $latestSholat->takbiratul_ihram ? 'bg-primary-fixed text-on-primary-fixed-variant' : 'bg-white/20 text-white/60' }} flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[16px]">{{ $latestSholat->takbiratul_ihram ? 'check' : 'close' }}</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-white text-center">Takbir</span>
                            </div>
                            <div class="bg-white/10 rounded-lg p-3 flex flex-col items-center gap-2 backdrop-blur-sm border border-white/10">
                                <div class="w-8 h-8 rounded-full {{ $latestSholat->doa_iftitah ? 'bg-primary-fixed text-on-primary-fixed-variant' : 'bg-white/20 text-white/60' }} flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[16px]">{{ $latestSholat->doa_iftitah ? 'check' : 'close' }}</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-white text-center">Iftitah</span>
                            </div>
                            <div class="bg-white/10 rounded-lg p-3 flex flex-col items-center gap-2 backdrop-blur-sm border border-white/10">
                                <div class="w-8 h-8 rounded-full {{ $latestSholat->al_fatihah ? 'bg-primary-fixed text-on-primary-fixed-variant' : 'bg-white/20 text-white/60' }} flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[16px]">{{ $latestSholat->al_fatihah ? 'check' : 'close' }}</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-white text-center">Fatihah</span>
                            </div>
                            <div class="bg-white/10 rounded-lg p-3 flex flex-col items-center gap-2 backdrop-blur-sm border border-white/10">
                                <div class="w-8 h-8 rounded-full {{ $latestSholat->surat_ayat ? 'bg-primary-fixed text-on-primary-fixed-variant' : 'bg-white/20 text-white/60' }} flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[16px]">{{ $latestSholat->surat_ayat ? 'check' : 'close' }}</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-white text-center">Surat</span>
                            </div>
                            <div class="bg-white/10 rounded-lg p-3 flex flex-col items-center gap-2 backdrop-blur-sm border border-white/10">
                                <div class="w-8 h-8 rounded-full {{ $latestSholat->bacaan_ruku ? 'bg-primary-fixed text-on-primary-fixed-variant' : 'bg-white/20 text-white/60' }} flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[16px]">{{ $latestSholat->bacaan_ruku ? 'check' : 'close' }}</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-white text-center">Ruku'</span>
                            </div>
                            <div class="bg-white/10 rounded-lg p-3 flex flex-col items-center gap-2 backdrop-blur-sm border border-white/10">
                                <div class="w-8 h-8 rounded-full {{ $latestSholat->bacaan_itidal ? 'bg-primary-fixed text-on-primary-fixed-variant' : 'bg-white/20 text-white/60' }} flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[16px]">{{ $latestSholat->bacaan_itidal ? 'check' : 'close' }}</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-white text-center">I'tidal</span>
                            </div>
                            <div class="bg-white/10 rounded-lg p-3 flex flex-col items-center gap-2 backdrop-blur-sm border border-white/10">
                                <div class="w-8 h-8 rounded-full {{ $latestSholat->bacaan_sujud ? 'bg-primary-fixed text-on-primary-fixed-variant' : 'bg-white/20 text-white/60' }} flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[16px]">{{ $latestSholat->bacaan_sujud ? 'check' : 'close' }}</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-white text-center">Sujud</span>
                            </div>
                            <div class="bg-white/10 rounded-lg p-3 flex flex-col items-center gap-2 backdrop-blur-sm border border-white/10">
                                <div class="w-8 h-8 rounded-full {{ $latestSholat->duduk_antara_sujud ? 'bg-primary-fixed text-on-primary-fixed-variant' : 'bg-white/20 text-white/60' }} flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[16px]">{{ $latestSholat->duduk_antara_sujud ? 'check' : 'close' }}</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-white text-center">Duduk</span>
                            </div>
                            <div class="bg-white/10 rounded-lg p-3 flex flex-col items-center gap-2 backdrop-blur-sm border border-white/10">
                                <div class="w-8 h-8 rounded-full {{ $latestSholat->tasyahud_awal ? 'bg-primary-fixed text-on-primary-fixed-variant' : 'bg-white/20 text-white/60' }} flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[16px]">{{ $latestSholat->tasyahud_awal ? 'check' : 'close' }}</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-white text-center">T. Awal</span>
                            </div>
                            <div class="bg-white/10 rounded-lg p-3 flex flex-col items-center gap-2 backdrop-blur-sm border border-white/10">
                                <div class="w-8 h-8 rounded-full {{ $latestSholat->tasyahud_akhir ? 'bg-primary-fixed text-on-primary-fixed-variant' : 'bg-white/20 text-white/60' }} flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[16px]">{{ $latestSholat->tasyahud_akhir ? 'check' : 'close' }}</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-white text-center">T. Akhir</span>
                            </div>
                            <div class="bg-white/10 rounded-lg p-3 flex flex-col items-center gap-2 backdrop-blur-sm border border-white/10">
                                <div class="w-8 h-8 rounded-full {{ $latestSholat->sholawat_nabi ? 'bg-primary-fixed text-on-primary-fixed-variant' : 'bg-white/20 text-white/60' }} flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[16px]">{{ $latestSholat->sholawat_nabi ? 'check' : 'close' }}</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-white text-center">Sholawat</span>
                            </div>
                            <div class="bg-white/10 rounded-lg p-3 flex flex-col items-center gap-2 backdrop-blur-sm border border-white/10">
                                <div class="w-8 h-8 rounded-full {{ $latestSholat->doa_sebelum_salam ? 'bg-primary-fixed text-on-primary-fixed-variant' : 'bg-white/20 text-white/60' }} flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[16px]">{{ $latestSholat->doa_sebelum_salam ? 'check' : 'close' }}</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-white text-center">Doa</span>
                            </div>
                            <div class="bg-white/10 rounded-lg p-3 flex flex-col items-center gap-2 backdrop-blur-sm border border-white/10">
                                <div class="w-8 h-8 rounded-full {{ $latestSholat->salam ? 'bg-primary-fixed text-on-primary-fixed-variant' : 'bg-white/20 text-white/60' }} flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[16px]">{{ $latestSholat->salam ? 'check' : 'close' }}</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-white text-center">Salam</span>
                            </div>
                        </div>

                        @if($latestSholat->catatan_guru)
                            <div class="mt-6 bg-white/10 rounded-xl p-4 backdrop-blur-sm border border-white/10">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="material-symbols-outlined">edit_note</span>
                                    <span class="font-label-md text-label-md font-semibold text-white">Catatan Guru</span>
                                </div>
                                <p class="font-body-md text-body-md text-primary-fixed">{{ $latestSholat->catatan_guru }}</p>
                            </div>
                        @endif
                    </div>
                </section>
            @else
                <div class="bg-surface-container-lowest rounded-xl p-8 shadow-sm border border-surface-variant mb-8 text-center">
                    <span class="material-symbols-outlined text-6xl text-on-surface-variant mb-4">mosque</span>
                    <h3 class="font-h2 text-h2 text-on-surface mb-2">Belum Ada Progres</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant">Belum ada data progres sholat untuk {{ $santri->nama_lengkap }}</p>
                </div>
            @endif

            <!-- History Section -->
            <section class="bg-surface-container-lowest rounded-xl border border-surface-variant shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)] overflow-hidden">
                <div class="p-6 border-b border-surface-variant bg-surface-container-low/50">
                    <h3 class="font-h3 text-h3 text-on-surface">📋 Riwayat Progres Sholat</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Riwayat lengkap progres sholat {{ $santri->nama_lengkap }}</p>
                </div>
                @if($riwayat->count() > 0)
                    <div class="divide-y divide-surface-variant">
                        @foreach($riwayat as $item)
                            <div class="p-6 flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                                <div class="flex gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-lg {{ $item->status_lulus ? 'bg-primary-container text-primary' : 'bg-surface-variant text-on-surface-variant' }} flex flex-col items-center justify-center border border-outline-variant">
                                        <span class="font-label-sm text-label-sm">{{ \Carbon\Carbon::parse($item->tanggal)->format('M') }}</span>
                                        <span class="font-h3 text-h3 text-[16px]">{{ \Carbon\Carbon::parse($item->tanggal)->format('j') }}</span>
                                    </div>
                                    <div>
                                        <h4 class="font-label-md text-label-md text-on-surface">{{ $item->completed_count }}/14 Komponen Selesai</h4>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d M Y') }} • {{ number_format($item->progress_percentage, 0) }}% Selesai</p>
                                        @if($item->catatan_guru)
                                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-2">📝 {{ $item->catatan_guru }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center rounded-full {{ $item->status_lulus ? 'bg-primary-fixed text-on-primary-fixed-variant' : 'bg-surface-variant text-on-surface-variant' }} px-3 py-1.5 font-label-sm text-label-sm font-semibold">
                                        {{ $item->status_lulus ? 'LULUS' : 'PROGRES' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-8 text-center">
                        <span class="material-symbols-outlined text-6xl text-on-surface-variant mb-4">mosque</span>
                        <h3 class="font-h2 text-h2 text-on-surface mb-2">Belum Ada Riwayat</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Belum ada riwayat progres sholat untuk {{ $santri->nama_lengkap }}</p>
                    </div>
                @endif
            </section>

        @else
            <!-- No Data State -->
            <div class="bg-surface-container-lowest rounded-xl p-8 shadow-sm border border-surface-variant text-center">
                <span class="material-symbols-outlined text-6xl text-on-surface-variant mb-4">person_off</span>
                <h3 class="font-h2 text-h2 text-on-surface mb-2">Tidak Ada Data</h3>
                <p class="font-body-md text-body-md text-on-surface-variant">Data santri tidak tersedia</p>
            </div>
        @endif
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
        <a class="flex flex-col items-center justify-center text-emerald-700 dark:text-emerald-400 font-bold bg-emerald-50/50 dark:bg-emerald-900/20 rounded-xl px-3 py-1 hover:text-emerald-600 dark:hover:text-emerald-300" href="{{ route('wali.sholat') }}">
            <span class="material-symbols-outlined mb-1 text-[24px]" data-icon="mosque" data-weight="fill" style="font-variation-settings: 'FILL' 1;">mosque</span>
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
