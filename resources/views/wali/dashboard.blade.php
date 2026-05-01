<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Dashboard Wali Santri - TPQ Darul Ikhlas</title>
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Tailwind Config -->
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container-lowest": "#ffffff",
                        "primary": "#004d34",
                        "on-tertiary": "#ffffff",
                        "on-error": "#ffffff",
                        "primary-container": "#006747",
                        "secondary-container": "#d1e7dd",
                        "surface-container-highest": "#e0e3df",
                        "outline-variant": "#bec9c1",
                        "on-tertiary-fixed": "#161d1f",
                        "on-primary": "#ffffff",
                        "inverse-on-surface": "#eef2ed",
                        "surface-container-low": "#f1f5f0",
                        "on-tertiary-fixed-variant": "#41484a",
                        "tertiary-fixed": "#dde4e6",
                        "on-primary-fixed": "#002114",
                        "on-surface-variant": "#3f4943",
                        "on-secondary-container": "#556961",
                        "surface-dim": "#d7dbd6",
                        "surface-variant": "#e0e3df",
                        "error": "#ba1a1a",
                        "inverse-primary": "#84d7af",
                        "tertiary-fixed-dim": "#c1c8ca",
                        "on-secondary-fixed-variant": "#374b44",
                        "on-tertiary-container": "#ccd3d5",
                        "primary-fixed-dim": "#84d7af",
                        "background": "#f7faf5",
                        "primary-fixed": "#a0f4ca",
                        "on-secondary": "#ffffff",
                        "secondary": "#4f635b",
                        "tertiary-container": "#545b5d",
                        "on-secondary-fixed": "#0c1f19",
                        "on-background": "#181d1a",
                        "on-primary-fixed-variant": "#005137",
                        "on-surface": "#181d1a",
                        "error-container": "#ffdad6",
                        "tertiary": "#3d4446",
                        "surface-bright": "#f7faf5",
                        "surface": "#f7faf5",
                        "surface-container": "#ebefea",
                        "surface-container-high": "#e5e9e4",
                        "outline": "#6f7a72",
                        "inverse-surface": "#2d312e",
                        "on-primary-container": "#8fe2ba",
                        "on-error-container": "#93000a",
                        "secondary-fixed": "#d1e7dd",
                        "surface-tint": "#0b6c4b",
                        "secondary-fixed-dim": "#b6cbc2"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "md": "24px",
                        "gutter": "16px",
                        "margin": "24px",
                        "base": "8px",
                        "lg": "48px",
                        "sm": "12px",
                        "xs": "4px",
                        "xl": "80px"
                    },
                    "fontFamily": {
                        "h1": ["Plus Jakarta Sans"],
                        "label-md": ["Plus Jakarta Sans"],
                        "body-sm": ["Plus Jakarta Sans"],
                        "body-lg": ["Plus Jakarta Sans"],
                        "h2": ["Plus Jakarta Sans"],
                        "body-md": ["Plus Jakarta Sans"],
                        "h3": ["Plus Jakarta Sans"],
                        "label-sm": ["Plus Jakarta Sans"]
                    },
                    "fontSize": {
                        "h1": ["40px", { "lineHeight": "1.2", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "label-md": ["14px", { "lineHeight": "1.2", "letterSpacing": "0.01em", "fontWeight": "600" }],
                        "body-sm": ["14px", { "lineHeight": "1.5", "fontWeight": "400" }],
                        "body-lg": ["18px", { "lineHeight": "1.6", "fontWeight": "400" }],
                        "h2": ["32px", { "lineHeight": "1.3", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "body-md": ["16px", { "lineHeight": "1.6", "fontWeight": "400" }],
                        "h3": ["24px", { "lineHeight": "1.4", "fontWeight": "600" }],
                        "label-sm": ["12px", { "lineHeight": "1.2", "fontWeight": "500" }]
                    }
                }
            }
        }
    </script>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>
<body class="bg-surface text-on-surface font-body-md text-body-md antialiased pt-16 pb-xl min-h-screen">
    <!-- TopAppBar -->
    <header class="fixed top-0 left-0 w-full z-50 flex items-center justify-between px-4 h-16 bg-white dark:bg-slate-900 shadow-sm shadow-emerald-900/5 font-['Plus_Jakarta_Sans'] antialiased">
        <div class="flex items-center gap-sm">
            <div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center overflow-hidden shrink-0">
                <img alt="TPQ Darul Ikhlas Logo" class="w-full h-full object-cover" data-alt="minimalist green islamic geometric pattern logo on white background" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDXYbMylvcj1xUoGzC_LrkSChWsBWrRVEZUyZm6FjDKz-FGEGNl_fy-QpadR-D3iF3815HWe2-JN0N3nNCl7VO9VwD8LaioknrmvGwl0tvoYHF-J6jZHVjVoLm7sl4EuteQYGFihXMy6TksgEL5VEPcH-WJFTZrmdKh5wx0uTaPzzbnuGCKoAB5lcD0J8qJ-EFR9MM5vH0uDDZOulTTrDPrdvMk0qEQSb6aJ_ItacIKbtkJvYzQY_HSn_ZnvHoZtZ5dw5X0rH1Qpr4"/>
            </div>
            <h1 class="text-lg font-bold text-emerald-900 dark:text-emerald-50">Darul Ikhlas</h1>
        </div>
        <div class="flex items-center gap-sm">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="w-10 h-10 rounded-full flex items-center justify-center text-emerald-900 dark:text-emerald-50 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors active:scale-95 transition-transform" type="submit">
                    <span class="material-symbols-outlined">logout</span>
                </button>
            </form>
        </div>
    </header>

    <!-- Main Content Canvas -->
    <main class="max-w-screen-md mx-auto relative z-0">
        <!-- Hero / Greeting Section -->
        <section class="relative bg-surface-container-low px-gutter py-margin overflow-hidden rounded-b-xl shadow-sm">
            <!-- Subtle Islamic Geometric Pattern Background -->
            <div class="absolute inset-0 opacity-5" style="background-image: repeating-linear-gradient(45deg, #004d34 25%, transparent 25%, transparent 75%, #004d34 75%, #004d34), repeating-linear-gradient(45deg, #004d34 25%, transparent 25%, transparent 75%, #004d34 75%, #004d34); background-position: 0 0, 10px 10px; background-size: 20px 20px;"></div>
            <div class="relative z-10">
                <p class="font-body-sm text-body-sm text-on-surface-variant mb-xs">Assalamu'alaikum,</p>
                <h2 class="font-h2 text-h2 text-primary mb-base">{{ auth()->user()->name }}</h2>
                @if($santri)
                    <div class="inline-flex items-center bg-surface-container-lowest px-sm py-xs rounded-full border border-outline-variant shadow-sm mt-xs">
                        <span class="w-2 h-2 rounded-full bg-primary-fixed mr-xs"></span>
                        <span class="font-label-sm text-label-sm text-on-surface-variant">Wali dari <strong class="text-primary font-semibold">{{ $santri->nama_lengkap }}</strong></span>
                    </div>
                @endif
            </div>
        </section>

        <!-- Child Selector (if multiple children) -->
        @if($allSantris && $allSantris->count() > 1)
            <section class="px-gutter mt-margin">
                <div class="flex gap-sm overflow-x-auto pb-xs">
                    @foreach($allSantris as $child)
                        <a href="{{ route('wali.switch-santri', $child->id) }}" 
                           class="flex-shrink-0 px-sm py-xs rounded-full border {{ $santri && $santri->id == $child->id ? 'bg-primary text-on-primary border-primary' : 'bg-surface-container-lowest text-on-surface-variant border-outline-variant' }} font-label-sm text-label-sm transition-colors">
                            {{ $child->nama_lengkap }}
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Bento Grid: Quick Overview Cards -->
        @if($santri)
            <section class="px-gutter mt-margin grid grid-cols-1 md:grid-cols-2 gap-md">
                <!-- Card 1: Halaman Iqro Terakhir -->
                <div class="bg-surface-container-lowest rounded-xl p-md border border-outline-variant shadow-sm border-t-4 border-t-primary-container relative overflow-hidden flex flex-col justify-between">
                    <div class="flex justify-between items-start mb-md">
                        <div>
                            <h3 class="font-label-md text-label-md text-on-surface-variant mb-xs">Halaman Iqro Terakhir</h3>
                            <p class="font-h3 text-h3 text-on-surface">
                                @if($latestIqro)
                                    Jilid {{ $latestIqro->level }}, Hal {{ $latestIqro->halaman }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center text-primary-container">
                            <span class="material-symbols-outlined" data-weight="fill" style="font-variation-settings: 'FILL' 1;">menu_book</span>
                        </div>
                    </div>
                    @if($latestIqro)
                        <div>
                            <div class="flex justify-between font-label-sm text-label-sm mb-xs text-on-surface-variant">
                                <span>Progres Jilid {{ $latestIqro->level }}</span>
                                <span>
                                    @if($latestIqro->level == 1)
                                        {{ round(($latestIqro->halaman / 36) * 100) }}%
                                    @else
                                        {{ round(($latestIqro->halaman / 32) * 100) }}%
                                    @endif
                                </span>
                            </div>
                            <div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
                                <div class="h-full bg-inverse-primary rounded-full" style="width: @if($latestIqro->level == 1) {{ round(($latestIqro->halaman / 36) * 100) }}% @else {{ round(($latestIqro->halaman / 32) * 100) }}% @endif;"></div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Card 2: Kehadiran Bulan Ini -->
                <div class="bg-surface-container-lowest rounded-xl p-md border border-outline-variant shadow-sm relative overflow-hidden flex items-center">
                    <div class="flex-1">
                        <h3 class="font-label-md text-label-md text-on-surface-variant mb-xs">Kehadiran Bulan Ini</h3>
                        <div class="flex items-baseline gap-xs">
                            <p class="font-h2 text-h2 text-primary">{{ $totalHadir ?? 0 }}</p>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">/ {{ $totalHadirThisMonth ?? 0 }} Hari</p>
                        </div>
                        <p class="font-label-sm text-label-sm text-primary mt-xs flex items-center gap-xs">
                            <span class="material-symbols-outlined text-[14px]">trending_up</span>
                            @if($totalHadir >= 12) Sangat Baik @elseif($totalHadir >= 8) Baik @else Perlu Ditingkatkan @endif
                        </p>
                    </div>
                    <div class="w-16 h-16 rounded-full border-4 border-surface-container border-t-primary-fixed border-r-primary-fixed flex items-center justify-center rotate-45 shrink-0">
                        <div class="w-12 h-12 rounded-full border-2 border-surface-container flex items-center justify-center -rotate-45">
                            <span class="material-symbols-outlined text-primary" data-weight="fill" style="font-variation-settings: 'FILL' 1;">how_to_reg</span>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Status SPP -->
                <div class="bg-surface-container-lowest rounded-xl p-md border border-outline-variant shadow-sm flex items-center justify-between md:col-span-2">
                    <div class="flex items-center gap-sm">
                        <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant">
                            <span class="material-symbols-outlined">payments</span>
                        </div>
                        <div>
                            <h3 class="font-label-md text-label-md text-on-surface-variant">Status SPP</h3>
                            <p class="font-body-md text-body-md text-on-surface">
                                @if($pembayaran)
                                    {{ \Carbon\Carbon::create()->month($pembayaran->bulan)->translatedFormat('F') }} {{ $pembayaran->tahun }}
                                @else
                                    Belum ada data
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="@if($pembayaran && $pembayaran->status == 'lunas') bg-secondary-container text-on-primary-fixed-variant @else bg-error-container text-on-error-container @endif font-label-md text-label-md px-sm py-xs rounded-full flex items-center gap-xs border @if($pembayaran && $pembayaran->status == 'lunas') border-inverse-primary/30 @else border-error/20 @endif">
                        <span class="material-symbols-outlined text-[16px]" data-weight="fill" style="font-variation-settings: 'FILL' 1;">
                            @if($pembayaran && $pembayaran->status == 'lunas') check_circle @else cancel @endif
                        </span>
                        @if($pembayaran && $pembayaran->status == 'lunas') Lunas @else Belum Lunas @endif
                    </div>
                </div>
            </section>

            <!-- Quick Actions Grid -->
            <section class="px-gutter mt-margin mb-xl">
                <h3 class="font-label-md text-label-md text-on-surface-variant mb-sm">Aksi Cepat</h3>
                <div class="grid grid-cols-3 gap-sm">
                    <a href="{{ route('wali.profile') }}" class="bg-surface-container-lowest border border-outline-variant rounded-xl p-sm flex flex-col items-center justify-center gap-xs shadow-sm hover:bg-surface-container-low transition-colors active:scale-95">
                        <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">person</span>
                        </div>
                        <span class="font-label-sm text-label-sm text-on-surface">Profil</span>
                    </a>
                    <a href="{{ route('wali.laporan') }}" class="bg-surface-container-lowest border border-outline-variant rounded-xl p-sm flex flex-col items-center justify-center gap-xs shadow-sm hover:bg-surface-container-low transition-colors active:scale-95">
                        <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">summarize</span>
                        </div>
                        <span class="font-label-sm text-label-sm text-on-surface">Laporan Bulanan</span>
                    </a>
                    <a href="{{ route('wali.presensi') }}" class="bg-surface-container-lowest border border-outline-variant rounded-xl p-sm flex flex-col items-center justify-center gap-xs shadow-sm hover:bg-surface-container-low transition-colors active:scale-95">
                        <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">history</span>
                        </div>
                        <span class="font-label-sm text-label-sm text-on-surface">Riwayat Absensi</span>
                    </a>
                </div>
            </section>
        @else
            <!-- Empty State -->
            <section class="px-gutter mt-margin">
                <div class="bg-surface-container-lowest rounded-xl p-lg border border-outline-variant shadow-sm text-center">
                    <span class="material-symbols-outlined text-[48px] text-on-surface-variant mb-sm">person_off</span>
                    <h3 class="font-h3 text-h3 text-on-surface mb-xs">Belum Ada Data Anak</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">Data santri Anda belum terdaftar. Silakan hubungi admin TPQ.</p>
                </div>
            </section>
        @endif
    </main>

    <!-- BottomNavBar -->
    <nav class="md:hidden bg-white dark:bg-slate-950 font-['Plus_Jakarta_Sans'] text-[11px] font-medium fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 pb-safe pt-2 h-20 rounded-t-2xl border-t border-slate-100 dark:border-slate-800 shadow-[0_-4px_12px_rgba(0,103,71,0.05)] transition-all duration-300 ease-in-out">
        <a class="flex flex-col items-center justify-center text-emerald-700 dark:text-emerald-400 font-bold bg-emerald-50/50 dark:bg-emerald-900/20 rounded-xl px-3 py-1 hover:text-emerald-600 dark:hover:text-emerald-300" href="{{ route('wali.dashboard') }}">
            <span class="material-symbols-outlined mb-1 text-[24px]" data-icon="home" data-weight="fill" style="font-variation-settings: 'FILL' 1;">home</span>
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
