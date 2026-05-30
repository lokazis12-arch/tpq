<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progres Iqro - Darul Ikhlas</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .checkbox-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(64px, 1fr));
            gap: 6px;
            margin-top: 8px;
        }
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px;
            background: var(--gray-50);
            border-radius: 6px;
            border: 1px solid var(--gray-200);
            cursor: pointer;
            transition: all 0.2s;
            font-size: 13px;
        }
        .checkbox-item:hover {
            background: var(--gray-100);
        }
        .checkbox-item input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }
        .checkbox-item label {
            font-size: 13px;
            color: var(--gray-700);
            cursor: pointer;
            flex: 1;
        }
        .checkbox-item.checked {
            background: rgba(67, 233, 123, 0.1);
            border-color: rgba(67, 233, 123, 0.3);
        }
        .section-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--gray-800);
            margin-top: 16px;
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 2px solid var(--gray-200);
        }
        .subsection-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-700);
            margin-top: 12px;
            margin-bottom: 6px;
        }
        .tajwid-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            padding: 10px;
            background: var(--gray-50);
            border-radius: 6px;
            border: 1px solid var(--gray-200);
            margin-bottom: 8px;
        }
        .tajwid-item input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
            margin-top: 2px;
        }
        .tajwid-item label {
            font-size: 13px;
            color: var(--gray-700);
            cursor: pointer;
            flex: 1;
            line-height: 1.4;
        }
        .tajwid-desc {
            font-size: 12px;
            color: var(--gray-500);
            margin-top: 4px;
        }
    </style>
</head>
<body>
    <div class="app-container" style="padding-bottom: 20px;">
        <div class="app-header">
            <div class="app-title">🕌 Darul Ikhlas</div>
        </div>

        <div class="section-padding" style="padding-top: 16px;">
            <a href="{{ route('guru.dashboard') }}" class="back-link">
                <svg style="width:18px;height:18px;fill:currentColor;" viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                Kembali
            </a>

            <div class="page-title">Progres Iqro</div>
            <p class="page-desc">Input capaian mengaji santri</p>

            @if(session('success'))
                <div class="success-msg">✓ {{ session('success') }}</div>
            @endif

            <div class="card" style="margin-bottom: 28px;">
                <div style="font-size: 15px; font-weight: 700; color: var(--gray-800); margin-bottom: 18px;">Input Progres</div>
                <form action="{{ route('guru.iqro.store') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <label>Pilih Santri</label>
                        <select name="santri_id" class="input-field" required>
                            <option value="" disabled selected>Pilih santri</option>
                            @foreach($santris as $s)
                                <option value="{{ $s->id }}">{{ $s->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group">
                        <label>Kategori</label>
                        <select name="kategori" id="kategori_select" class="input-field" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="iqro">📖 Iqro</option>
                            <option value="alquran">📕 Al-Quran (Juz 30)</option>
                            <option value="tajwid">🎓 Tajwid</option>
                        </select>
                    </div>

                    <!-- Iqro Section -->
                    <div id="section_iqro" style="display: none;">
                        <div class="input-group">
                            <label>Level (Jilid)</label>
                            <select name="level" id="iqro_level_select" class="input-field">
                                <option value="" disabled selected>Pilih Jilid Iqro</option>
                                @for($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}">Iqro {{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="section-title">📖 Iqro</div>
                        
                        <div id="iqro_1_pages" class="iqro-pages-section" style="display: none;">
                            <div class="subsection-title">Iqro 1 (36 Halaman)</div>
                            <div class="checkbox-grid">
                                @for($i = 1; $i <= 36; $i++)
                                    <div class="checkbox-item">
                                        <input type="checkbox" name="iqro_1_pages[]" value="{{ $i }}" id="iqro1_{{ $i }}">
                                        <label for="iqro1_{{ $i }}">{{ $i }}</label>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <div id="iqro_2_pages" class="iqro-pages-section" style="display: none;">
                            <div class="subsection-title">Iqro 2 (32 Halaman)</div>
                            <div class="checkbox-grid">
                                @for($i = 1; $i <= 32; $i++)
                                    <div class="checkbox-item">
                                        <input type="checkbox" name="iqro_2_pages[]" value="{{ $i }}" id="iqro2_{{ $i }}">
                                        <label for="iqro2_{{ $i }}">{{ $i }}</label>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <div id="iqro_3_pages" class="iqro-pages-section" style="display: none;">
                            <div class="subsection-title">Iqro 3 (32 Halaman)</div>
                            <div class="checkbox-grid">
                                @for($i = 1; $i <= 32; $i++)
                                    <div class="checkbox-item">
                                        <input type="checkbox" name="iqro_3_pages[]" value="{{ $i }}" id="iqro3_{{ $i }}">
                                        <label for="iqro3_{{ $i }}">{{ $i }}</label>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <div id="iqro_4_pages" class="iqro-pages-section" style="display: none;">
                            <div class="subsection-title">Iqro 4 (32 Halaman)</div>
                            <div class="checkbox-grid">
                                @for($i = 1; $i <= 32; $i++)
                                    <div class="checkbox-item">
                                        <input type="checkbox" name="iqro_4_pages[]" value="{{ $i }}" id="iqro4_{{ $i }}">
                                        <label for="iqro4_{{ $i }}">{{ $i }}</label>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <div id="iqro_5_pages" class="iqro-pages-section" style="display: none;">
                            <div class="subsection-title">Iqro 5 (32 Halaman)</div>
                            <div class="checkbox-grid">
                                @for($i = 1; $i <= 32; $i++)
                                    <div class="checkbox-item">
                                        <input type="checkbox" name="iqro_5_pages[]" value="{{ $i }}" id="iqro5_{{ $i }}">
                                        <label for="iqro5_{{ $i }}">{{ $i }}</label>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <div id="iqro_6_pages" class="iqro-pages-section" style="display: none;">
                            <div class="subsection-title">Iqro 6 (32 Halaman)</div>
                            <div class="checkbox-grid">
                                @for($i = 1; $i <= 32; $i++)
                                    <div class="checkbox-item">
                                        <input type="checkbox" name="iqro_6_pages[]" value="{{ $i }}" id="iqro6_{{ $i }}">
                                        <label for="iqro6_{{ $i }}">{{ $i }}</label>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <!-- Al-Quran Section -->
                    <div id="section_alquran" style="display: none;">
                        <div class="section-title">📕 Juz 30 (Al-Quran)</div>
                        <div class="checkbox-grid">
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="an_naba" id="surah_an_naba">
                            <label for="surah_an_naba">An-Naba'</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="an_naziat" id="surah_an_naziat">
                            <label for="surah_an_naziat">An-Nazi'at</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="abasa" id="surah_abasa">
                            <label for="surah_abasa">'Abasa</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="at_takwir" id="surah_at_takwir">
                            <label for="surah_at_takwir">At-Takwir</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="al_infitar" id="surah_al_infitar">
                            <label for="surah_al_infitar">Al-Infitar</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="al_mutaffifin" id="surah_al_mutaffifin">
                            <label for="surah_al_mutaffifin">Al-Mutaffifin</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="al_Insyiqaq" id="surah_al_Insyiqaq">
                            <label for="surah_al_Insyiqaq">Al-Insyiqaq</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="al_buruj" id="surah_al_buruj">
                            <label for="surah_al_buruj">Al-Buruj</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="at_tariq" id="surah_at_tariq">
                            <label for="surah_at_tariq">At-Tariq</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="al_ala" id="surah_al_ala">
                            <label for="surah_al_ala">Al-A'la</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="al_gasyiyah" id="surah_al_gasyiyah">
                            <label for="surah_al_gasyiyah">Al-Gasyiyah</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="al_fajr" id="surah_al_fajr">
                            <label for="surah_al_fajr">Al-Fajr</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="al_balad" id="surah_al_balad">
                            <label for="surah_al_balad">Al-Balad</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="asy_syams" id="surah_asy_syams">
                            <label for="surah_asy_syams">Asy-Syams</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="al_lail" id="surah_al_lail">
                            <label for="surah_al_lail">Al-Lail</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="ad_duha" id="surah_ad_duha">
                            <label for="surah_ad_duha">Ad-Duha</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="asy_syarh" id="surah_asy_syarh">
                            <label for="surah_asy_syarh">Asy-Syarh</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="at_tin" id="surah_at_tin">
                            <label for="surah_at_tin">At-Tin</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="al_alaq" id="surah_al_alaq">
                            <label for="surah_al_alaq">Al-'Alaq</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="al_qadr" id="surah_al_qadr">
                            <label for="surah_al_qadr">Al-Qadr</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="al_bayyinah" id="surah_al_bayyinah">
                            <label for="surah_al_bayyinah">Al-Bayyinah</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="az_zalzalah" id="surah_az_zalzalah">
                            <label for="surah_az_zalzalah">Az-Zalzalah</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="al_adiyat" id="surah_al_adiyat">
                            <label for="surah_al_adiyat">Al-'Adiyat</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="al_qariah" id="surah_al_qariah">
                            <label for="surah_al_qariah">Al-Qari'ah</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="at_takatsur" id="surah_at_takatsur">
                            <label for="surah_at_takatsur">At-Takatsur</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="al_asr" id="surah_al_asr">
                            <label for="surah_al_asr">Al-'Asr</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="al_humazah" id="surah_al_humazah">
                            <label for="surah_al_humazah">Al-Humazah</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="al_fil" id="surah_al_fil">
                            <label for="surah_al_fil">Al-Fil</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="quraisy" id="surah_quraisy">
                            <label for="surah_quraisy">Quraisy</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="al_maun" id="surah_al_maun">
                            <label for="surah_al_maun">Al-Ma'un</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="al_kautsar" id="surah_al_kautsar">
                            <label for="surah_al_kautsar">Al-Kautsar</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="al_kafirun" id="surah_al_kafirun">
                            <label for="surah_al_kafirun">Al-Kafirun</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="an_nasr" id="surah_an_nasr">
                            <label for="surah_an_nasr">An-Nasr</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="al_lahab" id="surah_al_lahab">
                            <label for="surah_al_lahab">Al-Lahab</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="al_ikhlas" id="surah_al_ikhlas">
                            <label for="surah_al_ikhlas">Al-Ikhlas</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="al_falaq" id="surah_al_falaq">
                            <label for="surah_al_falaq">Al-Falaq</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="juz_30_surahs[]" value="an_nas" id="surah_an_nas">
                            <label for="surah_an_nas">An-Nas</label>
                        </div>
                    </div>

                    <!-- Tajwid Section -->
                    <div id="section_tajwid" style="display: none;">
                        <div class="section-title">🎓 Tajwid</div>
                    
                    <div class="subsection-title">1. Hukum Nun Mati (ن) dan Tanwin (ً ٍ ٌ)</div>
                    <div class="tajwid-item">
                        <input type="checkbox" name="tajwid_nun_mati[]" value="izh_har_halqi" id="tajwid_izh_har_halqi">
                        <div>
                            <label for="tajwid_izh_har_halqi">Izh-har Halqi</label>
                            <div class="tajwid-desc">Dibaca jelas jika bertemu huruf halqi (ء, هـ, ع, ح, غ, خ)</div>
                        </div>
                    </div>
                    <div class="tajwid-item">
                        <input type="checkbox" name="tajwid_nun_mati[]" value="idgham_bighunnah" id="tajwid_idgham_bighunnah">
                        <div>
                            <label for="tajwid_idgham_bighunnah">Idgham Bighunnah</label>
                            <div class="tajwid-desc">Melebur dengan dengung jika bertemu huruf ي, ن, م, و</div>
                        </div>
                    </div>
                    <div class="tajwid-item">
                        <input type="checkbox" name="tajwid_nun_mati[]" value="idgham_bilaghunnah" id="tajwid_idgham_bilaghunnah">
                        <div>
                            <label for="tajwid_idgham_bilaghunnah">Idgham Bilaghunnah</label>
                            <div class="tajwid-desc">Melebur tanpa dengung jika bertemu huruf ل, ر</div>
                        </div>
                    </div>
                    <div class="tajwid-item">
                        <input type="checkbox" name="tajwid_nun_mati[]" value="iqlab" id="tajwid_iqlab">
                        <div>
                            <label for="tajwid_iqlab">Iqlab</label>
                            <div class="tajwid-desc">Mengubah suara menjadi 'm' jika bertemu huruf ب</div>
                        </div>
                    </div>
                    <div class="tajwid-item">
                        <input type="checkbox" name="tajwid_nun_mati[]" value="ikhfa_haqiqi" id="tajwid_ikhfa_haqiqi">
                        <div>
                            <label for="tajwid_ikhfa_haqiqi">Ikhfa' Haqiqi</label>
                            <div class="tajwid-desc">Dibaca samar/mendengung jika bertemu 15 huruf lainnya</div>
                        </div>
                    </div>

                    <div class="subsection-title">2. Hukum Mim Mati (م)</div>
                    <div class="tajwid-item">
                        <input type="checkbox" name="tajwid_mim_mati[]" value="ikhfa_syafawi" id="tajwid_ikhfa_syafawi">
                        <div>
                            <label for="tajwid_ikhfa_syafawi">Ikhfa' Syafawi</label>
                            <div class="tajwid-desc">Samar jika bertemu ب</div>
                        </div>
                    </div>
                    <div class="tajwid-item">
                        <input type="checkbox" name="tajwid_mim_mati[]" value="idgham_mimi" id="tajwid_idgham_mimi">
                        <div>
                            <label for="tajwid_idgham_mimi">Idgham Mimi (Mutamasilain)</label>
                            <div class="tajwid-desc">Melebur jika bertemu م</div>
                        </div>
                    </div>
                    <div class="tajwid-item">
                        <input type="checkbox" name="tajwid_mim_mati[]" value="izh_har_syafawi" id="tajwid_izh_har_syafawi">
                        <div>
                            <label for="tajwid_izh_har_syafawi">Izh-har Syafawi</label>
                            <div class="tajwid-desc">Jelas jika bertemu huruf selain م dan ب</div>
                        </div>
                    </div>

                    <div class="subsection-title">3. Panjang Pendek (Mad)</div>
                    <div class="tajwid-item">
                        <input type="checkbox" name="tajwid_mad[]" value="mad_thabii" id="tajwid_mad_thabii">
                        <div>
                            <label for="tajwid_mad_thabii">Mad Thabi'i</label>
                            <div class="tajwid-desc">Panjang 2 harakat (dasar)</div>
                        </div>
                    </div>
                    <div class="tajwid-item">
                        <input type="checkbox" name="tajwid_mad[]" value="mad_wajib_muttashil" id="tajwid_mad_wajib_muttashil">
                        <div>
                            <label for="tajwid_mad_wajib_muttashil">Mad Wajib Muttashil</label>
                            <div class="tajwid-desc">Bertemu hamzah dalam satu kata (panjang 4-5 harakat)</div>
                        </div>
                    </div>
                    <div class="tajwid-item">
                        <input type="checkbox" name="tajwid_mad[]" value="mad_jaiz_munfashil" id="tajwid_mad_jaiz_munfashil">
                        <div>
                            <label for="tajwid_mad_jaiz_munfashil">Mad Jaiz Munfashil</label>
                            <div class="tajwid-desc">Bertemu hamzah di kata berbeda</div>
                        </div>
                    </div>
                    <div class="tajwid-item">
                        <input type="checkbox" name="tajwid_mad[]" value="mad_arid_lissukun" id="tajwid_mad_arid_lissukun">
                        <div>
                            <label for="tajwid_mad_arid_lissukun">Mad Arid Lissukun</label>
                            <div class="tajwid-desc">Panjang di akhir kalimat/saat berhenti</div>
                        </div>
                    </div>

                    <div class="subsection-title">4. Aturan Berhenti dan Pengucapan</div>
                    <div class="tajwid-item">
                        <input type="checkbox" name="tajwid_berhenti[]" value="qalqalah" id="tajwid_qalqalah">
                        <div>
                            <label for="tajwid_qalqalah">Qalqalah</label>
                            <div class="tajwid-desc">Suara memantul pada huruf (ب, ج, د, ط, ق)</div>
                        </div>
                    </div>
                    <div class="tajwid-item">
                        <input type="checkbox" name="tajwid_berhenti[]" value="ghunnah" id="tajwid_ghunnah">
                        <div>
                            <label for="tajwid_ghunnah">Ghunnah</label>
                            <div class="tajwid-desc">Mendengung kuat pada ن dan م bertasydid</div>
                        </div>
                    </div>
                    <div class="tajwid-item">
                        <input type="checkbox" name="tajwid_berhenti[]" value="waqaf_ibtida" id="tajwid_waqaf_ibtida">
                        <div>
                            <label for="tajwid_waqaf_ibtida">Waqaf & Ibtida'</label>
                            <div class="tajwid-desc">Tahu kapan harus berhenti dan memulai kembali bacaan</div>
                        </div>
                    </div>
                    </div>

                    <div class="input-group" style="margin-top: 20px;">
                        <label>Status</label>
                        <select name="status_lulus" class="input-field" required>
                            <option value="1">✅ Lanjut</option>
                            <option value="0">🔁 Ulang</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label>Catatan (Opsional)</label>
                        <input type="text" name="catatan_guru" class="input-field" placeholder="Catatan tambahan untuk santri">
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <button class="btn btn-primary" type="submit">Simpan Progres</button>
                        <button type="button" class="btn" style="background: var(--gray-200); color: var(--gray-700);" onclick="resetForm()">Hapus Inputan</button>
                    </div>
                </form>
            </div>

            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 14px;">
                <div style="font-size: 15px; font-weight: 700; color: var(--gray-800);">Riwayat Progres</div>
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr><th>Tanggal</th><th>Santri</th><th>Progres</th><th>Status</th><th></th></tr>
                    </thead>
                    <tbody>
                        @forelse($iqros as $i)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($i->tanggal)->translatedFormat('d M Y') }}</td>
                                <td style="font-weight:600;">{{ $i->santri->nama_lengkap ?? '-' }}</td>
                                <td>Jilid {{ $i->level }}, Hal. {{ $i->halaman }}</td>
                                <td>
                                    @if($i->status_lulus) <span class="badge badge-primary">Lanjut</span>
                                    @else <span class="badge badge-secondary">Ulang</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('guru.iqro.destroy', $i->id) }}" method="POST" onsubmit="return confirm('Hapus riwayat iqro ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete">
                                            <svg style="width:16px;height:16px;fill:currentColor" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="empty-state">Belum ada data iqro</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        // Show/hide sections based on category selection
        const kategoriSelect = document.getElementById('kategori_select');
        if(kategoriSelect) {
            kategoriSelect.addEventListener('change', function() {
                const selectedKategori = this.value;
                // Hide all main sections
                document.getElementById('section_iqro').style.display = 'none';
                document.getElementById('section_alquran').style.display = 'none';
                document.getElementById('section_tajwid').style.display = 'none';
                
                // Show selected section
                if(selectedKategori) {
                    document.getElementById('section_' + selectedKategori).style.display = 'block';
                }
                
                // Reset Iqro level dropdown and hide all Iqro pages
                const levelSelect = document.getElementById('iqro_level_select');
                if(levelSelect) {
                    levelSelect.value = '';
                }
                document.querySelectorAll('.iqro-pages-section').forEach(section => {
                    section.style.display = 'none';
                });
            });
        }

        // Show/hide Iqro pages based on level selection
        const levelSelect = document.getElementById('iqro_level_select');
        if(levelSelect) {
            levelSelect.addEventListener('change', function() {
                const selectedLevel = this.value;
                // Hide all Iqro sections
                document.querySelectorAll('.iqro-pages-section').forEach(section => {
                    section.style.display = 'none';
                });
                // Show selected Iqro section
                if(selectedLevel) {
                    const selectedSection = document.getElementById('iqro_' + selectedLevel + '_pages');
                    if(selectedSection) {
                        selectedSection.style.display = 'block';
                    }
                }
            });
        }

        // Checkbox styling
        document.querySelectorAll('.checkbox-item, .tajwid-item').forEach(item => {
            const checkbox = item.querySelector('input[type="checkbox"]');
            if(checkbox) {
                checkbox.addEventListener('change', function() {
                    if(this.checked) {
                        item.classList.add('checked');
                    } else {
                        item.classList.remove('checked');
                    }
                });
            }
        });

        // Reset form function
        function resetForm() {
            const form = document.querySelector('form');
            if(form) {
                form.reset();
                // Hide all main sections
                document.getElementById('section_iqro').style.display = 'none';
                document.getElementById('section_alquran').style.display = 'none';
                document.getElementById('section_tajwid').style.display = 'none';
                // Hide all Iqro sections
                document.querySelectorAll('.iqro-pages-section').forEach(section => {
                    section.style.display = 'none';
                });
                // Remove checked class from all checkboxes
                document.querySelectorAll('.checkbox-item, .tajwid-item').forEach(item => {
                    item.classList.remove('checked');
                });
            }
        }
    </script>
</body>
</html>
