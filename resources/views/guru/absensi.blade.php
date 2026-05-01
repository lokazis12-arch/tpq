<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Absensi - Darul Ikhlas</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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

            <div class="page-title">Input Absensi</div>
            <p class="page-desc">Catat kehadiran santri hari ini</p>

            @if(session('success'))
                <div class="success-msg">✓ {{ session('success') }}</div>
            @endif

            <div class="card" style="margin-bottom: 28px;">
                <div style="font-size: 15px; font-weight: 700; color: var(--gray-800); margin-bottom: 18px;">Catat Kehadiran</div>
                <form action="{{ route('guru.absensi.store') }}" method="POST">
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
                        <label>Status Kehadiran</label>
                        <select name="status" class="input-field" required>
                            <option value="hadir">✅ Hadir</option>
                            <option value="izin">📋 Izin</option>
                            <option value="sakit">🏥 Sakit</option>
                            <option value="alpa">❌ Alpa</option>
                        </select>
                    </div>
                    <button class="btn btn-primary" type="submit">Simpan Absensi</button>
                </form>
            </div>

            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 14px;">
                <div style="font-size: 15px; font-weight: 700; color: var(--gray-800);">Riwayat Absensi</div>
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr><th>Tanggal</th><th>Santri</th><th>Status</th><th></th></tr>
                    </thead>
                    <tbody>
                        @forelse($absensis as $a)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($a->tanggal)->translatedFormat('d M Y') }}</td>
                                <td style="font-weight:600;">{{ $a->santri->nama_lengkap ?? '-' }}</td>
                                <td>
                                    @if($a->status === 'hadir') <span class="badge badge-primary">Hadir</span>
                                    @elseif($a->status === 'izin') <span class="badge badge-secondary">Izin</span>
                                    @elseif($a->status === 'sakit') <span class="badge badge-secondary">Sakit</span>
                                    @else <span class="badge" style="background:#FEF2F2; color:var(--danger);">Alpa</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('guru.absensi.destroy', $a->id) }}" method="POST" onsubmit="return confirm('Hapus riwayat absensi ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete">
                                            <svg style="width:16px;height:16px;fill:currentColor" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="empty-state">Belum ada data absensi</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
