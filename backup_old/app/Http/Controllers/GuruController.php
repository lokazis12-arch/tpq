<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Absensi;
use App\Models\ProgresIqro;
use App\Models\ProgresSholat;
use App\Models\User;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function dashboard()
    {
        $totalSantri = Santri::count();
        $absenHariIni = Absensi::whereDate('tanggal', today())->count();
        $iqroHariIni = ProgresIqro::whereDate('tanggal', today())->count();
        
        return view('guru.dashboard', compact('totalSantri', 'absenHariIni', 'iqroHariIni'));
    }

    public function santriIndex()
    {
        $santris = Santri::with('waliSantri')->get();
        $walis = User::where('role', 'wali_santri')->get();
        return view('guru.santri', compact('santris', 'walis'));
    }

    public function santriStore(Request $request)
    {
        $waliType = $request->validate([
            'wali_type' => 'required|in:existing,new',
        ])['wali_type'];
        
        $santriData = $request->validate([
            'nama_lengkap' => 'required|string',
            'alamat' => 'required|string',
            'pengajian' => 'required|string',
        ]);
        
        if ($waliType === 'existing') {
            $request->validate([
                'wali_santri_id' => 'required|exists:users,id',
            ]);
            $santriData['wali_santri_id'] = $request->wali_santri_id;
        } else {
            $request->validate([
                'wali_name' => 'required|string',
                'wali_email' => 'required|email',
                'wali_phone' => 'nullable|string',
            ]);
            
            // Create new wali account
            $wali = User::create([
                'name' => $request->wali_name,
                'email' => $request->wali_email,
                'password' => Hash::make('password123'),
                'role' => 'wali_santri',
                'phone' => $request->wali_phone,
            ]);
            
            $santriData['wali_santri_id'] = $wali->id;
        }
        
        $santriData['nis'] = date('y') . rand(1000, 9999);
        
        Santri::create($santriData);
        
        $message = $waliType === 'new' 
            ? 'Santri berhasil ditambahkan. Akun wali santri dibuat dengan email: ' . $request->wali_email . ' dan password: password123'
            : 'Santri berhasil ditambahkan';
            
        return back()->with('success', $message);
    }

    public function absensiIndex()
    {
        $santris = Santri::where('status_aktif', true)->get();
        $absensis = Absensi::with('santri')->latest('tanggal')->take(50)->get();
        return view('guru.absensi', compact('santris', 'absensis'));
    }

    public function absensiStore(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'status' => 'required|in:hadir,izin,sakit,alpa',
        ]);
        
        Absensi::updateOrCreate(
            ['santri_id' => $request->santri_id, 'tanggal' => today()],
            ['status' => $request->status, 'guru_id' => auth()->id()]
        );
        return back()->with('success', 'Absensi disimpan');
    }

    public function iqroIndex()
    {
        $santris = Santri::where('status_aktif', true)->get();
        $iqros = ProgresIqro::with('santri')->latest('tanggal')->take(50)->get();
        return view('guru.iqro', compact('santris', 'iqros'));
    }

    public function iqroStore(Request $request)
    {
        $data = $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'kategori' => 'required|in:iqro,alquran,tajwid',
            'level' => 'nullable|required_if:kategori,iqro|string',
            'status_lulus' => 'required|boolean',
            'catatan_guru' => 'nullable|string',
            // Iqro pages
            'iqro_1_pages' => 'nullable|array',
            'iqro_2_pages' => 'nullable|array',
            'iqro_3_pages' => 'nullable|array',
            'iqro_4_pages' => 'nullable|array',
            'iqro_5_pages' => 'nullable|array',
            'iqro_6_pages' => 'nullable|array',
            // Juz 30 surahs
            'juz_30_surahs' => 'nullable|array',
            // Tajwid rules
            'tajwid_nun_mati' => 'nullable|array',
            'tajwid_mim_mati' => 'nullable|array',
            'tajwid_mad' => 'nullable|array',
            'tajwid_berhenti' => 'nullable|array',
        ]);
        $data['guru_id'] = auth()->id();
        $data['tanggal'] = today();
        
        // Calculate halaman from checked pages only for Iqro category
        if($data['kategori'] === 'iqro') {
            $level = $data['level'];
            $pagesField = 'iqro_' . $level . '_pages';
            if(isset($data[$pagesField]) && is_array($data[$pagesField]) && count($data[$pagesField]) > 0) {
                $data['halaman'] = max($data[$pagesField]);
            } else {
                $data['halaman'] = '0';
            }
        } else {
            $data['level'] = null;
            $data['halaman'] = '0';
        }
        
        ProgresIqro::create($data);
        return back()->with('success', 'Progres Iqro disimpan');
    }

    public function sholatIndex()
    {
        $santris = Santri::where('status_aktif', true)->get();
        $sholats = ProgresSholat::with('santri')->latest('tanggal')->take(50)->get();
        return view('guru.sholat', compact('santris', 'sholats'));
    }

    public function sholatStore(Request $request)
    {
        $data = $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'niat' => 'required|boolean',
            'takbiratul_ihram' => 'required|boolean',
            'doa_iftitah' => 'required|boolean',
            'al_fatihah' => 'required|boolean',
            'surat_ayat' => 'required|boolean',
            'bacaan_ruku' => 'required|boolean',
            'bacaan_itidal' => 'required|boolean',
            'bacaan_sujud' => 'required|boolean',
            'duduk_antara_sujud' => 'required|boolean',
            'tasyahud_awal' => 'required|boolean',
            'tasyahud_akhir' => 'required|boolean',
            'sholawat_nabi' => 'required|boolean',
            'doa_sebelum_salam' => 'required|boolean',
            'salam' => 'required|boolean',
            'status_lulus' => 'required|boolean',
            'catatan_guru' => 'nullable|string',
        ]);
        $data['guru_id'] = auth()->id();
        $data['tanggal'] = today();
        
        ProgresSholat::create($data);
        return back()->with('success', 'Progres Sholat disimpan');
    }

    public function pembayaranIndex()
    {
        $santris = Santri::where('status_aktif', true)->get();
        $pembayarans = Pembayaran::with('santri')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->take(50)->get();
        return view('guru.pembayaran', compact('santris', 'pembayarans'));
    }

    public function pembayaranStore(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer',
            'jumlah_bayar' => 'required|numeric|min:0',
        ]);

        Pembayaran::updateOrCreate(
            ['santri_id' => $request->santri_id, 'bulan' => $request->bulan, 'tahun' => $request->tahun],
            [
                'jumlah_bayar' => $request->jumlah_bayar,
                'status' => 'lunas',
                'tanggal_bayar' => today(),
                'penerima_id' => auth()->id(),
            ]
        );
        return back()->with('success', 'Pembayaran berhasil dicatat');
    }

    public function santriDestroy($id)
    {
        Santri::findOrFail($id)->delete();
        return back()->with('success', 'Data santri berhasil dihapus');
    }

    public function absensiDestroy($id)
    {
        Absensi::findOrFail($id)->delete();
        return back()->with('success', 'Data absensi berhasil dihapus');
    }

    public function iqroDestroy($id)
    {
        ProgresIqro::findOrFail($id)->delete();
        return back()->with('success', 'Data progres iqro berhasil dihapus');
    }

    public function sholatDestroy($id)
    {
        ProgresSholat::findOrFail($id)->delete();
        return back()->with('success', 'Data progres sholat berhasil dihapus');
    }

    public function pembayaranDestroy($id)
    {
        Pembayaran::findOrFail($id)->delete();
        return back()->with('success', 'Data pembayaran berhasil dihapus');
    }
}
