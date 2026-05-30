<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Absensi;
use App\Models\ProgresIqro;
use App\Models\ProgresSholat;
use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class WaliController extends Controller
{
    private function getSantri()
    {
        $santris = Santri::where('wali_santri_id', auth()->id())->get();
        if ($santris->isEmpty()) return null;

        $activeId = session('active_santri_id');
        if ($activeId) {
            $santri = $santris->firstWhere('id', $activeId);
            if ($santri) return $santri;
        }

        $santri = $santris->first();
        session(['active_santri_id' => $santri->id]);
        return $santri;
    }

    public function switchSantri($id)
    {
        $santri = Santri::where('wali_santri_id', auth()->id())->where('id', $id)->first();
        if ($santri) {
            session(['active_santri_id' => $santri->id]);
        }
        return redirect()->route('wali.dashboard');
    }

    public function dashboard()
    {
        $santri = $this->getSantri();
        $allSantris = Santri::where('wali_santri_id', auth()->id())->get();
        $currentSantri = $santri;

        if (!$santri) {
            return view('wali.dashboard', [
                'santri' => null, 
                'allSantris' => $allSantris,
                'currentSantri' => null
            ]);
        }

        $latestIqro = ProgresIqro::where('santri_id', $santri->id)
            ->latest('tanggal')->first();

        $latestSholat = ProgresSholat::where('santri_id', $santri->id)
            ->latest('tanggal')->first();

        $bulanIni = now()->month;
        $tahunIni = now()->year;
        $totalHadir = Absensi::where('santri_id', $santri->id)
            ->whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->where('status', 'hadir')
            ->count();

        $pembayaran = Pembayaran::where('santri_id', $santri->id)
            ->where('bulan', $bulanIni)
            ->where('tahun', $tahunIni)
            ->first();

        return view('wali.dashboard', [
            'santri' => $santri,
            'allSantris' => $allSantris,
            'currentSantri' => $currentSantri,
            'latestIqro' => $latestIqro,
            'latestSholat' => $latestSholat,
            'totalHadir' => $totalHadir,
            'pembayaran' => $pembayaran,
        ]);
    }

    public function iqro()
    {
        $santri = $this->getSantri();
        $riwayat = collect();
        $latestIqro = null;
        if ($santri) {
            $riwayat = ProgresIqro::where('santri_id', $santri->id)
                ->orderBy('tanggal', 'desc')
                ->take(20)->get();
            $latestIqro = $riwayat->first();
        }
        return view('wali.iqro', compact('santri', 'riwayat', 'latestIqro'));
    }

    public function sholat()
    {
        $santri = $this->getSantri();
        $riwayat = collect();
        $latestSholat = null;
        if ($santri) {
            $riwayat = ProgresSholat::where('santri_id', $santri->id)
                ->orderBy('tanggal', 'desc')
                ->take(20)->get();
            $latestSholat = $riwayat->first();
        }
        return view('wali.sholat', compact('santri', 'riwayat', 'latestSholat'));
    }

    public function presensi()
    {
        $santri = $this->getSantri();
        $absensi = collect();
        $totalHadir = 0;
        $totalIzin = 0;
        $totalSakit = 0;
        $totalAlpa = 0;
        $attendanceData = [];
        $totalHari = 0;
        
        if ($santri) {
            $absensi = Absensi::where('santri_id', $santri->id)
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->get();
            
            $totalHadir = $absensi->where('status', 'hadir')->count();
            $totalIzin = $absensi->where('status', 'izin')->count();
            $totalSakit = $absensi->where('status', 'sakit')->count();
            $totalAlpa = $absensi->where('status', 'alpa')->count();
            $totalHari = $absensi->count();
            
            $attendanceData = $absensi->keyBy(fn($a) => \Carbon\Carbon::parse($a->tanggal)->day)->map(fn($a) => $a->status);
        }
        
        return view('wali.presensi', compact(
            'santri', 
            'absensi',
            'totalHadir', 
            'totalIzin', 
            'totalSakit', 
            'totalAlpa',
            'attendanceData',
            'totalHari'
        ));
    }

    public function laporan()
    {
        $santri = $this->getSantri();
        $totalHadir = 0;
        $totalIzin = 0;
        $totalSakit = 0;
        $totalAlpa = 0;
        $totalHari = 0;
        $iqroHistory = collect();
        $hafalanHistory = collect();
        $iqroJilid = 'Jilid 1';
        $iqroHalaman = 0;
        $iqroProgress = 0;
        $lastSurah = 'Belum ada';
        $hafalanGrade = '-';
        $insight = null;
        
        if ($santri) {
            $bulanIni = now()->month;
            $tahunIni = now()->year;

            $totalHadir = Absensi::where('santri_id', $santri->id)
                ->whereMonth('tanggal', $bulanIni)->whereYear('tanggal', $tahunIni)
                ->where('status', 'hadir')->count();
            $totalIzin = Absensi::where('santri_id', $santri->id)
                ->whereMonth('tanggal', $bulanIni)->whereYear('tanggal', $tahunIni)
                ->where('status', 'izin')->count();
            $totalSakit = Absensi::where('santri_id', $santri->id)
                ->whereMonth('tanggal', $bulanIni)->whereYear('tanggal', $tahunIni)
                ->where('status', 'sakit')->count();
            $totalAlpa = Absensi::where('santri_id', $santri->id)
                ->whereMonth('tanggal', $bulanIni)->whereYear('tanggal', $tahunIni)
                ->where('status', 'alpa')->count();
            $totalHari = $totalHadir + $totalIzin + $totalSakit + $totalAlpa;

            $iqroHistory = ProgresIqro::where('santri_id', $santri->id)
                ->orderBy('tanggal', 'desc')->take(5)->get();
            
            $latestIqro = $iqroHistory->first();
            if ($latestIqro) {
                $iqroJilid = $latestIqro->level;
                $iqroHalaman = $latestIqro->halaman;
                $iqroProgress = $latestIqro->status_lulus ? 100 : 50;
            }

            $hafalanHistory = ProgresSholat::where('santri_id', $santri->id)
                ->orderBy('tanggal', 'desc')->take(5)->get();
            
            $latestSholat = $hafalanHistory->first();
            if ($latestSholat) {
                $lastSurah = 'Al-Fatihah';
                $hafalanGrade = $latestSholat->status_lulus ? 'A (Sangat Baik)' : 'B (Baik)';
            }
            
            $insight = 'Ananda menunjukkan peningkatan fokus yang signifikan pada bulan ini. Keterlibatan dalam kelas mengaji sangat aktif.';
        }
        
        return view('wali.laporan', compact(
            'santri',
            'totalHadir',
            'totalIzin',
            'totalSakit',
            'totalAlpa',
            'totalHari',
            'iqroHistory',
            'hafalanHistory',
            'iqroJilid',
            'iqroHalaman',
            'iqroProgress',
            'lastSurah',
            'hafalanGrade',
            'insight'
        ));
    }

    public function profile()
    {
        $user = auth()->user();
        $santris = Santri::where('wali_santri_id', $user->id)->get();
        $currentSantri = $this->getSantri();
        return view('wali.profile', compact('user', 'santris', 'currentSantri'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'phone']);

        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile'), $filename);
            $data['foto_profil'] = $filename;
        }

        $user->update($data);
        return back()->with('success', 'Profil berhasil diperbarui');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password berhasil diubah');
    }
}
