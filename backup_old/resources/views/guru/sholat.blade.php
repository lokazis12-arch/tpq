<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progres Sholat - Darul Ikhlas</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .checkbox-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: 8px;
            margin-top: 8px;
        }
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            background: var(--gray-50);
            border-radius: 8px;
            border: 1px solid var(--gray-200);
            cursor: pointer;
            transition: all 0.2s;
        }
        .checkbox-item:hover {
            background: var(--gray-100);
        }
        .checkbox-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        .checkbox-item label {
            font-size: 14px;
            color: var(--gray-700);
            cursor: pointer;
            flex: 1;
        }
        .checkbox-item.checked {
            background: rgba(67, 233, 123, 0.1);
            border-color: rgba(67, 233, 123, 0.3);
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

            <div class="page-title">Progres Sholat</div>
            <p class="page-desc">Input capaian bacaan sholat santri</p>

            @if(session('success'))
                <div class="success-msg">✓ {{ session('success') }}</div>
            @endif

            <div class="card" style="margin-bottom: 28px;">
                <div style="font-size: 15px; font-weight: 700; color: var(--gray-800); margin-bottom: 18px;">Input Progres</div>
                <form action="{{ route('guru.sholat.store') }}" method="POST">
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
                        <label>Komponen Bacaan Sholat</label>
                        <div class="checkbox-grid">
                            <div class="checkbox-item">
                                <input type="hidden" name="niat" value="0">
                                <input type="checkbox" name="niat" value="1" id="niat">
                                <label for="niat">Niat</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="hidden" name="takbiratul_ihram" value="0">
                                <input type="checkbox" name="takbiratul_ihram" value="1" id="takbiratul_ihram">
                                <label for="takbiratul_ihram">Takbiratul Ihram</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="hidden" name="doa_iftitah" value="0">
                                <input type="checkbox" name="doa_iftitah" value="1" id="doa_iftitah">
                                <label for="doa_iftitah">Doa Iftitah</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="hidden" name="al_fatihah" value="0">
                                <input type="checkbox" name="al_fatihah" value="1" id="al_fatihah">
                                <label for="al_fatihah">Al-Fatihah</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="hidden" name="surat_ayat" value="0">
                                <input type="checkbox" name="surat_ayat" value="1" id="surat_ayat">
                                <label for="surat_ayat">Surat/Ayat Al-Qur'an</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="hidden" name="bacaan_ruku" value="0">
                                <input type="checkbox" name="bacaan_ruku" value="1" id="bacaan_ruku">
                                <label for="bacaan_ruku">Bacaan Ruku'</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="hidden" name="bacaan_itidal" value="0">
                                <input type="checkbox" name="bacaan_itidal" value="1" id="bacaan_itidal">
                                <label for="bacaan_itidal">Bacaan I'tidal</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="hidden" name="bacaan_sujud" value="0">
                                <input type="checkbox" name="bacaan_sujud" value="1" id="bacaan_sujud">
                                <label for="bacaan_sujud">Bacaan Sujud</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="hidden" name="duduk_antara_sujud" value="0">
                                <input type="checkbox" name="duduk_antara_sujud" value="1" id="duduk_antara_sujud">
                                <label for="duduk_antara_sujud">Duduk Antara Sujud</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="hidden" name="tasyahud_awal" value="0">
                                <input type="checkbox" name="tasyahud_awal" value="1" id="tasyahud_awal">
                                <label for="tasyahud_awal">Tasyahud Awal</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="hidden" name="tasyahud_akhir" value="0">
                                <input type="checkbox" name="tasyahud_akhir" value="1" id="tasyahud_akhir">
                                <label for="tasyahud_akhir">Tasyahud Akhir</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="hidden" name="sholawat_nabi" value="0">
                                <input type="checkbox" name="sholawat_nabi" value="1" id="sholawat_nabi">
                                <label for="sholawat_nabi">Sholawat Nabi</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="hidden" name="doa_sebelum_salam" value="0">
                                <input type="checkbox" name="doa_sebelum_salam" value="1" id="doa_sebelum_salam">
                                <label for="doa_sebelum_salam">Doa Sebelum Salam</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="hidden" name="salam" value="0">
                                <input type="checkbox" name="salam" value="1" id="salam">
                                <label for="salam">Salam</label>
                            </div>
                        </div>
                    </div>
                    <div class="input-group">
                        <label>Status</label>
                        <select name="status_lulus" class="input-field" required>
                            <option value="1">✅ Lulus</option>
                            <option value="0">🔁 Progres</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label>Catatan (Opsional)</label>
                        <input type="text" name="catatan_guru" class="input-field" placeholder="Catatan tambahan untuk santri">
                    </div>
                    <button class="btn btn-primary" type="submit">Simpan Progres</button>
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
                        @forelse($sholats as $s)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($s->tanggal)->translatedFormat('d M Y') }}</td>
                                <td style="font-weight:600;">{{ $s->santri->nama_lengkap ?? '-' }}</td>
                                <td>{{ $s->completed_count }}/14 Komponen ({{ number_format($s->progress_percentage, 0) }}%)</td>
                                <td>
                                    @if($s->status_lulus) <span class="badge badge-primary">Lulus</span>
                                    @else <span class="badge badge-secondary">Progres</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('guru.sholat.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus riwayat sholat ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete">
                                            <svg style="width:16px;height:16px;fill:currentColor" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="empty-state">Belum ada data sholat</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.checkbox-item').forEach(item => {
            const checkbox = item.querySelector('input[type="checkbox"]');
            checkbox.addEventListener('change', function() {
                if(this.checked) {
                    item.classList.add('checked');
                } else {
                    item.classList.remove('checked');
                }
            });
        });
    </script>
</body>
</html>
