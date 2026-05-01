<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Santri - Darul Ikhlas</title>
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

            <div class="page-title">Manajemen Santri</div>
            <p class="page-desc">Tambah dan kelola data santri TPQ</p>

            @if(session('success'))
                <div class="success-msg">✓ {{ session('success') }}</div>
            @endif

            <div class="card" style="margin-bottom: 28px;">
                <div style="font-size: 15px; font-weight: 700; color: var(--gray-800); margin-bottom: 18px;">Tambah Santri Baru</div>
                <form action="{{ route('guru.santri.store') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="input-field" placeholder="Masukkan nama lengkap santri" required>
                    </div>
                    <div class="input-group">
                        <label>Alamat</label>
                        <textarea name="alamat" class="input-field" placeholder="Masukkan alamat tempat tinggal" required rows="2"></textarea>
                    </div>
                    <div class="input-group">
                        <label>Tingkat Pengajian</label>
                        <select name="pengajian" class="input-field" required>
                            <option value="" disabled selected>Pilih tingkat pengajian</option>
                            <option value="Iqro 1">Iqro 1</option>
                            <option value="Iqro 2">Iqro 2</option>
                            <option value="Iqro 3">Iqro 3</option>
                            <option value="Iqro 4">Iqro 4</option>
                            <option value="Iqro 5">Iqro 5</option>
                            <option value="Iqro 6">Iqro 6</option>
                            <option value="Al-Quran">Al-Quran</option>
                            <option value="Tajwid">Tajwid</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label>Wali Santri</label>
                        <div style="margin-bottom: 12px;">
                            <label style="display: flex; align-items: center; cursor: pointer;">
                                <input type="radio" name="wali_type" value="existing" checked onchange="toggleWaliFields()" style="margin-right: 8px;">
                                <span>Pilih Wali Santri yang Sudah Ada</span>
                            </label>
                            <label style="display: flex; align-items: center; cursor: pointer; margin-top: 8px;">
                                <input type="radio" name="wali_type" value="new" onchange="toggleWaliFields()" style="margin-right: 8px;">
                                <span>Buat Akun Wali Santri Baru</span>
                            </label>
                        </div>
                        
                        <div id="existing-wali-field">
                            <select name="wali_santri_id" class="input-field" required>
                                <option value="" disabled selected>Pilih wali santri</option>
                                @foreach($walis as $wali)
                                    <option value="{{ $wali->id }}">{{ $wali->name }} ({{ $wali->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div id="new-wali-fields" style="display: none;">
                            <div class="input-group" style="margin-bottom: 12px;">
                                <label>Nama Wali Santri</label>
                                <input type="text" name="wali_name" class="input-field" placeholder="Masukkan nama lengkap wali santri">
                            </div>
                            <div class="input-group" style="margin-bottom: 12px;">
                                <label>Email Wali Santri</label>
                                <input type="email" name="wali_email" id="wali_email" class="input-field" placeholder="Email otomatis dari nama anak" readonly>
                                <small style="color: var(--gray-600); font-size: 12px; margin-top: 4px; display: block;">Email akan otomatis dibuat dari nama santri + @gmail.com</small>
                            </div>
                            <div class="input-group">
                                <label>Telepon Wali Santri</label>
                                <input type="text" name="wali_phone" class="input-field" placeholder="Masukkan nomor telepon (opsional)">
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">
                        <svg style="width:18px;height:18px;fill:currentColor;" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                        Tambah Santri
                    </button>
                </form>
            </div>

            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 14px;">
                <div style="font-size: 15px; font-weight: 700; color: var(--gray-800);">Daftar Santri</div>
                <span class="badge badge-gray">{{ $santris->count() }} data</span>
            </div>

            @forelse($santris as $s)
                <div class="data-card animate-in">
                    <div class="data-card-content">
                        <div class="data-card-title">{{ $s->nama_lengkap }}</div>
                        <div class="data-card-subtitle">
                            👤 {{ $s->waliSantri->name ?? $s->nama_wali ?? '-' }} · 📖 {{ $s->pengajian ?? '-' }}<br>
                            📍 {{ $s->alamat ?? '-' }}
                        </div>
                    </div>
                    <div class="data-card-actions">
                        <form action="{{ route('guru.santri.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data santri ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn btn-delete">
                                <svg style="width:18px;height:18px;fill:currentColor" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="empty-state">Belum ada data santri terdaftar</div>
            @endforelse
        </div>
    </div>
<script>
function toggleWaliFields() {
    const existingField = document.getElementById('existing-wali-field');
    const newFields = document.getElementById('new-wali-fields');
    const waliType = document.querySelector('input[name="wali_type"]:checked').value;
    
    if (waliType === 'existing') {
        existingField.style.display = 'block';
        newFields.style.display = 'none';
        document.querySelector('select[name="wali_santri_id"]').required = true;
        document.querySelector('input[name="wali_name"]').required = false;
        document.querySelector('input[name="wali_email"]').required = false;
    } else {
        existingField.style.display = 'none';
        newFields.style.display = 'block';
        document.querySelector('select[name="wali_santri_id"]').required = false;
        document.querySelector('input[name="wali_name"]').required = true;
        document.querySelector('input[name="wali_email"]').required = false; // Auto-generated
    }
}

function generateEmailFromName() {
    const namaSantri = document.querySelector('input[name="nama_lengkap"]').value;
    const emailField = document.getElementById('wali_email');
    
    if (namaSantri && emailField) {
        // Convert name to lowercase, remove spaces and special characters, add @gmail.com
        const cleanName = namaSantri.toLowerCase()
            .replace(/\s+/g, '') // remove spaces
            .replace(/[^a-z0-9]/g, ''); // remove special characters
        emailField.value = cleanName + '@gmail.com';
    }
}

// Add event listener to nama_lengkap field
document.addEventListener('DOMContentLoaded', function() {
    const namaField = document.querySelector('input[name="nama_lengkap"]');
    if (namaField) {
        namaField.addEventListener('input', generateEmailFromName);
        namaField.addEventListener('blur', generateEmailFromName);
    }
});
</script>
</body>
</html>
