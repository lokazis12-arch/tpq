<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Profil Saya - Darul Ikhlas</title>
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
        .bg-pattern {
            background-image: radial-gradient(theme('colors.outline-variant') 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.3;
        }
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col font-body-md text-body-md">
    <!-- TopAppBar -->
    <header class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md docked full-width top-0 sticky border-b border-slate-100 dark:border-slate-800 shadow-sm flex items-center justify-between px-6 h-16 w-full z-40 transition-colors duration-200 ease-in-out">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-full overflow-hidden bg-surface-container-high flex items-center justify-center">
                <img alt="Wali Santri Profile" class="w-full h-full object-cover" data-alt="Portrait of a middle-aged Indonesian man, smiling gently, wearing professional attire, clean background, warm lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDIhRlKOV-A525xMCCgQZNgkHo4UV7FcRW1yT7hW3itxh_ZhKPTCJ3Bx9FM-oIJznqjxXPJTDRhzes4SQ_tvmfAs_oxv-aUlD7zKx5njkVlbfp8W0ncUnlnDzfK2gtvp63kjBBGtOHDCw6skAzemB1_6hnbryAMh4Fje_CL5qPImcXSP0Nkzr5iozT0nQ4pPhyWczU1F4DRyRwsel_CSIiFPIqIrNFm_MMSXizyVVbpzw8uxJr9RWEQnwYpxAwcTvzNPn8UWLu5oME"/>
            </div>
            <div class="font-plus-jakarta-sans font-extrabold text-emerald-900 dark:text-emerald-100 font-h3 text-h3">Darul Ikhlas</div>
        </div>
        <div class="flex items-center gap-4 text-emerald-800 dark:text-emerald-400">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="hover:bg-emerald-50 dark:hover:bg-emerald-900/20 p-2 rounded-full transition-colors duration-200 ease-in-out flex items-center justify-center" type="submit">
                    <span class="material-symbols-outlined" data-icon="logout">logout</span>
                </button>
            </form>
        </div>
    </header>

    <!-- Main Layout Grid -->
    <div class="flex-1 flex w-full max-w-[1440px] mx-auto">
        <!-- NavigationDrawer (Desktop) -->
        <aside class="hidden md:flex flex-col h-full py-8 bg-white dark:bg-slate-900 h-full w-80 rounded-r-2xl divide-y divide-slate-100 dark:divide-slate-800 shadow-2xl sticky top-16 transition-all duration-300" style="height: calc(100vh - 64px);">
            <div class="px-6 pb-6 left_align">
                <div class="flex items-center gap-4 mb-2">
                    <div class="w-14 h-14 rounded-full bg-surface-container-high flex items-center justify-center text-primary font-bold text-xl">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="font-h3 text-h3 text-emerald-900 font-bold">{{ auth()->user()->name }}</h2>
                        <p class="font-body-sm text-body-sm text-slate-500">Orang Tua / Wali</p>
                    </div>
                </div>
            </div>
            <nav class="flex-1 px-4 pt-6 space-y-2">
                <a class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400" href="{{ route('wali.dashboard') }}">
                    <span class="material-symbols-outlined" data-icon="home">home</span>
                    <span class="font-label-md text-label-md">Dashboard</span>
                </a>
                <a class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400" href="{{ route('wali.iqro') }}">
                    <span class="material-symbols-outlined" data-icon="menu_book">menu_book</span>
                    <span class="font-label-md text-label-md">Progres Iqro</span>
                </a>
                <a class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400" href="{{ route('wali.sholat') }}">
                    <span class="material-symbols-outlined" data-icon="mosque">mosque</span>
                    <span class="font-label-md text-label-md">Progres Sholat</span>
                </a>
                <a class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400" href="{{ route('wali.presensi') }}">
                    <span class="material-symbols-outlined" data-icon="calendar_month">calendar_month</span>
                    <span class="font-label-md text-label-md">Presensi</span>
                </a>
                <a class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400" href="{{ route('wali.laporan') }}">
                    <span class="material-symbols-outlined" data-icon="description">description</span>
                    <span class="font-label-md text-label-md">Laporan</span>
                </a>
                <a class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 bg-slate-50 dark:bg-slate-800 text-primary" href="{{ route('wali.profile') }}">
                    <span class="material-symbols-outlined" data-icon="person">person</span>
                    <span class="font-label-md text-label-md">Profil Saya</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content Canvas -->
        <main class="flex-1 w-full px-4 md:px-8 py-8 pb-24 md:pb-8">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('wali.dashboard') }}" class="inline-flex items-center gap-1 text-sm text-surface-variant hover:text-primary transition-colors font-body-sm">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Kembali
                </a>
            </div>

            <!-- Breadcrumb & Header Action -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <nav aria-label="Breadcrumb" class="flex items-center space-x-2 text-surface-variant font-body-sm text-body-sm">
                    <a class="text-primary hover:text-primary-container transition-colors" href="{{ route('wali.dashboard') }}">Dashboard</a>
                    <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
                    <span class="text-on-surface-variant font-medium">Profil Saya</span>
                </nav>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-secondary-container text-on-secondary-container rounded-xl flex items-center gap-3">
                    <span class="material-symbols-outlined">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Bento Grid Layout for Profile -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Left Column: Photo & List of Children (4 cols) -->
                <div class="lg:col-span-4 flex flex-col gap-6">
                    <!-- Photo Profile Section -->
                    <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-[0_4px_20px_-4px_rgba(0,103,71,0.05)] border border-surface-container-high flex flex-col items-center text-center relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-24 bg-primary-container/10"></div>
                        <div class="relative w-32 h-32 mb-4 mt-6">
                            @if($user->foto_profil)
                                <img alt="Profile Photo" class="w-full h-full rounded-full border-4 border-surface-container-lowest shadow-md object-cover z-10" src="{{ asset('uploads/profile/' . $user->foto_profil) }}"/>
                            @else
                                <div class="w-full h-full rounded-full border-4 border-surface-container-lowest shadow-md bg-surface-container-high flex items-center justify-center z-10 text-4xl font-bold text-primary">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <h1 class="font-h3 text-h3 text-on-surface mb-1">{{ $user->name }}</h1>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mb-6">{{ $user->email }}</p>
                        <div class="w-full">
                            <form action="{{ route('wali.profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <label class="flex items-center justify-center w-full bg-secondary-container text-on-secondary-container hover:bg-primary hover:text-on-primary py-3 px-4 rounded-xl cursor-pointer transition-colors font-label-md text-label-md gap-2 border border-dashed border-primary-fixed-dim" for="photo-upload">
                                    <span class="material-symbols-outlined" data-icon="cloud_upload">cloud_upload</span>
                                    Upload Foto Baru
                                </label>
                                <input accept="image/*" class="hidden" id="photo-upload" name="foto_profil" type="file"/>
                                <p class="font-label-sm text-label-sm text-outline mt-2 text-center">JPG, GIF or PNG. Max size of 2MB</p>
                                <button class="w-full mt-4 bg-primary text-on-primary hover:bg-primary-container py-3 px-4 rounded-xl font-label-md text-label-md transition-colors shadow-sm" type="submit">
                                    Simpan Foto
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- List of Children Section -->
                    <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-[0_4px_20px_-4px_rgba(0,103,71,0.05)] border border-surface-container-high">
                        <div class="flex items-center gap-2 mb-4 border-b border-surface-variant pb-3">
                            <span class="material-symbols-outlined text-primary" data-icon="family_restroom">family_restroom</span>
                            <h2 class="font-h3 text-h3 text-on-surface">Data Santri (Anak)</h2>
                        </div>
                        @if($santris->count() > 0)
                            <div class="flex flex-col gap-3">
                                @foreach($santris as $santri)
                                    <div class="border {{ $santri->id == ($currentSantri->id ?? 0) ? 'border-primary bg-surface' : 'border-surface-variant hover:border-primary-fixed-dim bg-surface-container-lowest' }} p-4 rounded-xl flex items-center justify-between transition-colors shadow-sm relative overflow-hidden">
                                        @if($santri->id == ($currentSantri->id ?? 0))
                                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary"></div>
                                        @endif
                                        <div>
                                            <h3 class="font-label-md text-label-md text-on-surface mb-1">{{ $santri->nama_lengkap }}</h3>
                                            <div class="flex items-center gap-3 font-body-sm text-body-sm text-on-surface-variant">
                                                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]" data-icon="school">school</span> {{ $santri->pengajian ?? 'Tidak ada level' }}</span>
                                                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]" data-icon="badge">badge</span> NIS: {{ $santri->nis }}</span>
                                            </div>
                                        </div>
                                        @if($santri->id == ($currentSantri->id ?? 0))
                                            <button class="bg-primary text-on-primary px-3 py-1.5 rounded-lg font-label-sm text-label-sm shadow-sm opacity-50 cursor-not-allowed">
                                                Terpilih
                                            </button>
                                        @else
                                            <a href="{{ route('wali.switch-santri', $santri->id) }}" class="bg-secondary-container text-on-secondary-container hover:bg-primary hover:text-on-primary px-3 py-1.5 rounded-lg font-label-sm text-label-sm transition-colors">
                                                Pilih
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <span class="material-symbols-outlined text-4xl text-on-surface-variant mb-2">person_off</span>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Belum ada data santri</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column: Forms (8 cols) -->
                <div class="lg:col-span-8 flex flex-col gap-6">
                    <!-- Profile Info Form -->
                    <div class="bg-surface-container-lowest rounded-2xl p-6 md:p-8 shadow-[0_4px_20px_-4px_rgba(0,103,71,0.05)] border border-surface-container-high border-t-4 border-t-primary-fixed">
                        <div class="flex items-center gap-2 mb-6">
                            <span class="material-symbols-outlined text-primary" data-icon="manage_accounts">manage_accounts</span>
                            <h2 class="font-h2 text-h2 text-on-surface">Informasi Pribadi</h2>
                        </div>
                        <form action="{{ route('wali.profile.update') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="font-label-md text-label-md text-on-surface" for="fullname">Nama Lengkap</label>
                                    <input class="w-full bg-surface-container-lowest border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-xl px-4 py-3 font-body-md text-body-md text-on-surface transition-colors" id="fullname" name="name" placeholder="Masukkan nama lengkap" type="text" value="{{ $user->name }}"/>
                                </div>
                                <div class="space-y-2">
                                    <label class="font-label-md text-label-md text-on-surface" for="phone">Nomor Telepon (WhatsApp)</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-on-surface-variant font-body-md text-body-md">+62</span>
                                        <input class="w-full bg-surface-container-lowest border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-xl pl-12 pr-4 py-3 font-body-md text-body-md text-on-surface transition-colors" id="phone" name="phone" placeholder="8xxxxxxxxxx" type="tel" value="{{ $user->phone ?? '' }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="font-label-md text-label-md text-on-surface flex items-center gap-2" for="email">
                                    Email
                                    <span class="bg-surface-variant text-on-surface-variant text-[10px] px-2 py-0.5 rounded-full font-semibold">Readonly</span>
                                </label>
                                <input class="w-full bg-surface-container-low border border-surface-variant text-on-surface-variant rounded-xl px-4 py-3 font-body-md text-body-md cursor-not-allowed" id="email" name="email" readonly type="email" value="{{ $user->email }}"/>
                                <p class="font-label-sm text-label-sm text-outline mt-1">Email digunakan untuk login dan tidak dapat diubah.</p>
                            </div>
                            <div class="pt-4 flex justify-end">
                                <button class="bg-primary text-on-primary hover:bg-primary-container px-6 py-3 rounded-xl font-label-md text-label-md transition-colors shadow-[0_4px_12px_rgba(0,103,71,0.2)] flex items-center gap-2" type="submit">
                                    <span class="material-symbols-outlined text-[20px]" data-icon="save">save</span>
                                    Simpan Profil
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Change Password Form -->
                    <div class="bg-surface-container-lowest rounded-2xl p-6 md:p-8 shadow-[0_4px_20px_-4px_rgba(0,103,71,0.05)] border border-surface-container-high">
                        <div class="flex items-center gap-2 mb-6">
                            <span class="material-symbols-outlined text-secondary" data-icon="lock">lock</span>
                            <h2 class="font-h3 text-h3 text-on-surface">Keamanan Akun</h2>
                        </div>
                        <form action="{{ route('wali.change-password') }}" method="POST" class="space-y-5">
                            @csrf
                            <div class="space-y-2 max-w-md">
                                <label class="font-label-md text-label-md text-on-surface" for="current_password">Password Saat Ini</label>
                                <div class="relative">
                                    <input class="w-full bg-surface-container-lowest border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-xl px-4 py-3 font-body-md text-body-md text-on-surface transition-colors pr-10" id="current_password" name="current_password" placeholder="••••••••" type="password"/>
                                    <button class="absolute inset-y-0 right-0 flex items-center pr-3 text-outline" type="button" onclick="togglePassword('current_password')">
                                        <span class="material-symbols-outlined text-[20px]" data-icon="visibility_off">visibility_off</span>
                                    </button>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
                                <div class="space-y-2">
                                    <label class="font-label-md text-label-md text-on-surface" for="new_password">Password Baru</label>
                                    <input class="w-full bg-surface-container-lowest border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-xl px-4 py-3 font-body-md text-body-md text-on-surface transition-colors" id="new_password" name="new_password" placeholder="Minimal 8 karakter" type="password"/>
                                </div>
                                <div class="space-y-2">
                                    <label class="font-label-md text-label-md text-on-surface" for="confirm_password">Konfirmasi Password Baru</label>
                                    <input class="w-full bg-surface-container-lowest border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-xl px-4 py-3 font-body-md text-body-md text-on-surface transition-colors" id="confirm_password" name="new_password_confirmation" placeholder="Ulangi password baru" type="password"/>
                                </div>
                            </div>
                            <div class="pt-4">
                                <button class="bg-surface-container-high text-on-surface hover:bg-secondary-container hover:text-on-secondary-container px-6 py-3 rounded-xl font-label-md text-label-md transition-colors border border-outline-variant" type="submit">
                                    Ubah Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

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
        <a class="flex flex-col items-center justify-center text-emerald-700 dark:text-emerald-400 font-bold bg-emerald-50/50 dark:bg-emerald-900/20 rounded-xl px-3 py-1 hover:text-emerald-600 dark:hover:text-emerald-300" href="{{ route('wali.profile') }}">
            <span class="material-symbols-outlined mb-1 text-[24px]" data-icon="person" data-weight="fill" style="font-variation-settings: 'FILL' 1;">person</span>
            <span>Profile</span>
        </a>
    </nav>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const button = input.nextElementSibling;
            const icon = button.querySelector('span');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility_off';
            }
        }
    </script>
</body>
</html>
