<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Darul Ikhlas</title>
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

            <div class="page-title">Catat Pembayaran</div>
            <p class="page-desc">Aktivasi akses wali dengan pencatatan iuran bulanan</p>

            @if(session('success'))
                <div class="success-msg">✓ {{ session('success') }}</div>
            @endif

            <div class="card" style="margin-bottom: 28px;">
                <div style="font-size: 15px; font-weight: 700; color: var(--gray-800); margin-bottom: 18px;">Input Pembayaran</div>
                <form action="{{ route('guru.pembayaran.store') }}" method="POST">
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
                    <div class="form-grid-2">
                        <div class="input-group">
                            <label>Bulan</label>
                            <select name="bulan" class="input-field" required>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $i == now()->month ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="input-group">
                            <label>Tahun</label>
                            <input type="number" name="tahun" class="input-field" value="{{ now()->year }}" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <label>Jumlah Bayar (Rp)</label>
                        <input type="number" name="jumlah_bayar" class="input-field" value="50000" required>
                    </div>
                    <button class="btn btn-primary" type="submit">
                        <svg style="width:18px;height:18px;fill:currentColor;" viewBox="0 0 24 24"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>
                        Catat Lunas
                    </button>
                </form>
            </div>

            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 14px;">
                <div style="font-size: 15px; font-weight: 700; color: var(--gray-800);">Riwayat Pembayaran</div>
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr><th>Santri</th><th>Periode</th><th>Jumlah</th><th>Status</th><th></th></tr>
                    </thead>
                    <tbody>
                        @forelse($pembayarans as $p)
                            <tr>
                                <td style="font-weight:600;">{{ $p->santri->nama_lengkap ?? '-' }}</td>
                                <td>{{ $p->bulan }}/{{ $p->tahun }}</td>
                                <td>Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                                <td>
                                    @if($p->status === 'lunas')
                                        <span class="badge-lunas">Lunas</span>
                                    @else
                                        <span class="badge-belum">Belum</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('guru.pembayaran.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus riwayat pembayaran ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete">
                                            <svg style="width:16px;height:16px;fill:currentColor" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="empty-state">Belum ada data pembayaran</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
