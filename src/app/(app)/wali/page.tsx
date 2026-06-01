import { getSession } from '@/lib/auth';
import { getWaliDashboard } from '@/lib/actions';
import { redirect } from 'next/navigation';
import Link from 'next/link';

function formatRupiah(amount: number) {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(amount);
}

function formatDate(dateStr: string) {
  const date = new Date(dateStr);
  return new Intl.DateTimeFormat('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }).format(date);
}

const indonesianMonths = [
  'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
];

export default async function WaliDashboard() {
  const session = await getSession();
  if (!session || session.role !== 'wali_santri') redirect('/login');

  const data = await getWaliDashboard(session.id);

  if (!data) {
    return (
      <div className="flex flex-col items-center justify-center py-20 text-center">
        <div className="w-24 h-24 bg-surface-container-low rounded-full flex items-center justify-center text-primary mb-4">
          <span className="material-symbols-outlined text-4xl">child_care</span>
        </div>
        <h2 className="text-xl font-bold text-slate-900 mb-2">Belum Ada Data Santri</h2>
        <p className="text-secondary max-w-md">
          Akun Anda belum terhubung dengan data santri. Silakan hubungi admin/guru TPQ untuk menautkan data putra/putri Anda.
        </p>
      </div>
    );
  }

  const { student, students, parent, attendanceSummary, payments, iqroProgress, sholatProgress, recentAttendance, hafalanProgress } = data;

  // Process attendance summary
  const getAttendanceCount = (status: string) => {
    const record = attendanceSummary.find((r: any) => r.status === status);
    return record ? parseInt(record.count) : 0;
  };

  const hadirCount = getAttendanceCount('Hadir');
  const izinCount = getAttendanceCount('Izin');
  const sakitCount = getAttendanceCount('Sakit');
  const alpaCount = getAttendanceCount('Alpa');
  const totalDays = hadirCount + izinCount + sakitCount + alpaCount;
  const attendanceRate = totalDays > 0 ? Math.round((hadirCount / totalDays) * 100) : 0;

  // Check SPP due date (10th of every month)
  const today = new Date();
  const currentMonth = indonesianMonths[today.getMonth()];
  const currentYear = today.getFullYear();
  const currentDay = today.getDate();

  // Look for current month's SPP payment with status "Lunas"
  const currentSppPayment = payments.find(
    (p: any) => p.month === currentMonth && p.year === currentYear && p.payment_type === 'SPP'
  );

  const isSppPaid = currentSppPayment?.status === 'Lunas';
  const showSppWarning = !isSppPaid && currentDay > 10;
  const showSppReminder = !isSppPaid && currentDay <= 10;

  // Calculate Juz 30 Hafalan Progress (37 surahs total from An-Naba' to An-Nas)
  const totalJuz30Surahs = 37;
  const memorizedSurahsCount = hafalanProgress.filter(
    (h: any) => h.status === 'SEMPURNA' || h.status === 'LANCAR'
  ).length;
  const hafalanPercentage = Math.round((memorizedSurahsCount / totalJuz30Surahs) * 100);

  // WhatsApp setup
  const ustadzWa = '6287847423809';
  const parentName = parent?.name || session.name;
  const scheduleAlQuran = [
    { day: 'Senin', subject: 'Fikih', icon: 'menu_book' },
    { day: 'Selasa', subject: 'Al-Qur\'an', icon: 'auto_stories' },
    { day: 'Rabu', subject: 'Tajwid', icon: 'menu_book' },
    { day: 'Kamis', subject: 'Fikih', icon: 'menu_book' },
    { day: 'Jum\'at', subject: 'Hafalan Surah', icon: 'interpreter_mode' },
    { day: 'Sabtu', subject: 'Tajwid', icon: 'menu_book' },
    { day: 'Minggu', subject: 'Al-Qur\'an', icon: 'auto_stories' },
  ];

  const scheduleIqro = [
    { day: 'Senin', subject: 'Fikih', icon: 'menu_book' },
    { day: 'Selasa', subject: 'Iqro', icon: 'auto_stories' },
    { day: 'Rabu', subject: 'Iqro', icon: 'auto_stories' },
    { day: 'Kamis', subject: 'Fikih', icon: 'menu_book' },
    { day: 'Jum\'at', subject: 'Hafalan Surah', icon: 'interpreter_mode' },
    { day: 'Sabtu', subject: 'Iqro', icon: 'auto_stories' },
    { day: 'Minggu', subject: 'Iqro', icon: 'auto_stories' },
  ];

  const isAlQuran = student.class && /qur/i.test(student.class);
  const currentSchedule = isAlQuran ? scheduleAlQuran : scheduleIqro;

  const daysOfWeek = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
  const todayDayName = daysOfWeek[new Date().getDay()];

  const normalizeDay = (day: string) => day.toLowerCase().replace(/[^a-z]/g, '');
  const todayNormalized = normalizeDay(todayDayName);

  const waMessage = `Assalamu'alaikum Ustaz, saya ${parentName} (orang tua dari ${student.name}) ingin mengonfirmasi terkait SPP / perkembangan belajar anak saya.`;
  const waLink = `https://wa.me/${ustadzWa}?text=${encodeURIComponent(waMessage)}`;

  return (
    <div className="space-y-6 pb-12">
      {/* Active Child Display / Header */}
      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h2 className="text-2xl font-bold text-slate-900">Beranda Wali Santri</h2>
          <p className="text-secondary text-sm">Informasi perkembangan belajar untuk putra-putri Anda.</p>
        </div>
        {students.length > 1 && (
          <div className="flex items-center gap-2 bg-primary-container px-3 py-1.5 rounded-xl border border-primary/20">
            <span className="material-symbols-outlined text-primary text-[18px]">family_history</span>
            <span className="text-xs text-on-primary-container font-medium">
              Santri Aktif: <strong className="font-bold">{student.name}</strong>
            </span>
            <Link href="/wali/profil" className="text-xs font-bold text-primary hover:underline ml-2">
              (Ganti)
            </Link>
          </div>
        )}
      </div>

      {/* SPP Payment Alert Banner */}
      {showSppWarning && (
        <div className="bg-red-50 border border-red-200 rounded-2xl p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shadow-sm animate-pulse">
          <div className="flex gap-3">
            <span className="material-symbols-outlined text-red-600 text-3xl">warning</span>
            <div>
              <h4 className="font-bold text-red-900 text-sm">Tunggakan SPP - Jatuh Tempo Tanggal 10</h4>
              <p className="text-xs text-red-700 mt-0.5">
                SPP bulan <strong>{currentMonth} {currentYear}</strong> belum tercatat lunas. Silakan hubungi Ustaz atau lakukan pembayaran administrasi.
              </p>
            </div>
          </div>
          <a
            href={waLink}
            target="_blank"
            rel="noopener noreferrer"
            className="flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors shrink-0"
          >
            <span className="material-symbols-outlined text-sm">chat</span>
            Konfirmasi Via WA
          </a>
        </div>
      )}

      {showSppReminder && (
        <div className="bg-amber-50 border border-amber-200 rounded-2xl p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shadow-sm">
          <div className="flex gap-3">
            <span className="material-symbols-outlined text-amber-600 text-3xl">info</span>
            <div>
              <h4 className="font-bold text-amber-900 text-sm">Pengingat Pembayaran SPP</h4>
              <p className="text-xs text-amber-700 mt-0.5">
                SPP bulan <strong>{currentMonth} {currentYear}</strong> jatuh tempo tanggal 10. Silakan hubungi Ustaz untuk konfirmasi pembayaran.
              </p>
            </div>
          </div>
          <a
            href={waLink}
            target="_blank"
            rel="noopener noreferrer"
            className="flex items-center gap-2 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors shrink-0"
          >
            <span className="material-symbols-outlined text-sm">chat</span>
            Konfirmasi SPP
          </a>
        </div>
      )}

      {/* Main Stats Card */}
      <div className="bg-gradient-to-r from-primary to-primary-container rounded-2xl p-6 text-on-primary shadow-md relative overflow-hidden">
        <div className="absolute -right-4 -top-12 opacity-10">
          <span className="material-symbols-outlined text-[150px]">menu_book</span>
        </div>
        <div className="relative z-10 flex items-center gap-4">
          {parent?.avatar_url ? (
            <img 
              src={parent.avatar_url} 
              alt="Avatar" 
              className="w-16 h-16 rounded-full border-2 border-white/40 shadow-inner object-cover" 
              />
          ) : (
            <div className="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center text-2xl font-bold border-2 border-white/40 shadow-inner">
              {student.name.substring(0, 2).toUpperCase()}
            </div>
          )}
          <div>
            <h2 className="text-2xl font-bold">{student.name}</h2>
            <div className="flex gap-3 mt-1 text-primary-container-low">
              <span className="flex items-center gap-1 text-sm bg-black/10 px-2 py-0.5 rounded-md">
                <span className="material-symbols-outlined text-sm">school</span>
                Kelas: {student.class}
              </span>
              <span className="flex items-center gap-1 text-sm bg-black/10 px-2 py-0.5 rounded-md">
                <span className="material-symbols-outlined text-sm">badge</span>
                NIS: {23000 + student.id}
              </span>
            </div>
          </div>
        </div>
      </div>

      {/* Jadwal Pelajaran Card */}
      <div className="bg-white rounded-2xl p-6 shadow-sm border border-emerald-50">
        <div className="flex flex-col sm:flex-row justify-between sm:items-center gap-2 mb-4">
          <h3 className="text-lg font-semibold text-slate-900 flex items-center gap-2">
            <span className="material-symbols-outlined text-primary">calendar_today</span>
            Jadwal Pelajaran Kelas {isAlQuran ? 'Al-Qur\'an' : 'Iqro'}
          </h3>
          <span className="text-xs text-primary bg-primary-container px-3 py-1.5 rounded-xl font-semibold border border-primary/10 self-start sm:self-auto">
            Hari ini: {todayDayName}
          </span>
        </div>
        <div className="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3">
          {currentSchedule.map((item, idx) => {
            const isToday = todayNormalized === normalizeDay(item.day);
            return (
              <div 
                key={idx} 
                className={`p-3 rounded-xl border text-center transition-all duration-300 relative ${
                  isToday 
                    ? 'bg-primary text-white border-primary shadow-md scale-105 z-10 font-medium' 
                    : 'bg-slate-50 border-slate-100 text-slate-700 hover:bg-slate-100/70 hover:border-slate-200'
                }`}
              >
                <p className={`text-[10px] font-bold uppercase tracking-wider ${isToday ? 'text-primary-container-low' : 'text-slate-400'}`}>
                  {item.day}
                </p>
                <span className={`material-symbols-outlined text-2xl my-2 block ${isToday ? 'text-white' : 'text-primary'}`}>
                  {item.icon}
                </span>
                <p className="text-xs font-bold truncate">
                  {item.subject}
                </p>
                {isToday && (
                  <span className="absolute -top-1.5 -right-1.5 bg-amber-500 text-white text-[8px] px-1.5 py-0.5 rounded-full font-black uppercase tracking-widest shadow-sm animate-pulse">
                    Hari Ini
                  </span>
                )}
              </div>
            );
          })}
        </div>
      </div>

      {/* Grid Row 1: Hafalan Juz 30 & Progres Mengaji */}
      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        {/* Hafalan Juz 30 Summary Card */}
        <div className="bg-white rounded-2xl p-6 shadow-sm border border-emerald-50 flex flex-col justify-between">
          <div>
            <div className="flex justify-between items-center mb-4">
              <h3 className="text-lg font-semibold text-slate-900 flex items-center gap-2">
                <span className="material-symbols-outlined text-primary font-bold">menu_book</span>
                Hafalan Juz 30
              </h3>
              <span className="text-sm font-bold text-primary bg-primary/10 px-2.5 py-1 rounded-md">
                {hafalanPercentage}% Selesai
              </span>
            </div>

            <div className="space-y-4">
              <div>
                <div className="flex justify-between text-xs text-secondary mb-1">
                  <span>Progres Hafalan</span>
                  <span className="font-semibold">{memorizedSurahsCount} dari {totalJuz30Surahs} Surah</span>
                </div>
                <div className="w-full bg-slate-100 rounded-full h-3">
                  <div 
                    className="bg-primary h-3 rounded-full transition-all duration-500" 
                    style={{ width: `${hafalanPercentage}%` }}
                  ></div>
                </div>
              </div>

              <div>
                <h4 className="text-xs font-semibold text-slate-800 uppercase tracking-wider mb-2">Riwayat Hafalan Terbaru</h4>
                {hafalanProgress.length > 0 ? (
                  <div className="space-y-2">
                    {hafalanProgress.slice(0, 3).map((item: any, idx: number) => (
                      <div key={idx} className="flex justify-between items-start text-sm p-2 rounded-xl bg-slate-50 border border-slate-100">
                        <div>
                          <p className="font-semibold text-slate-800">Q.S. {item.surah_name}</p>
                          {item.notes && <p className="text-xs text-secondary italic mt-0.5">"{item.notes}"</p>}
                        </div>
                        <span className={`px-2 py-0.5 rounded text-[10px] font-bold shrink-0 ${
                          item.status === 'SEMPURNA' ? 'bg-emerald-100 text-primary' :
                          item.status === 'LANCAR' ? 'bg-blue-100 text-blue-700' :
                          'bg-amber-100 text-amber-700'
                        }`}>
                          {item.status}
                        </span>
                      </div>
                    ))}
                  </div>
                ) : (
                  <p className="text-xs text-secondary text-center py-4 bg-slate-50 rounded-xl border border-slate-100">
                    Belum ada riwayat hafalan Juz 30.
                  </p>
                )}
              </div>
            </div>
          </div>

          <div className="pt-4 border-t border-slate-50 mt-4">
            <Link 
              href="/wali/laporan" 
              className="flex items-center justify-center gap-1.5 w-full text-center py-2.5 bg-primary-container text-on-primary-container font-semibold rounded-xl text-sm hover:bg-primary-container/80 transition-colors"
            >
              <span className="material-symbols-outlined text-[16px]">visibility</span>
              Lihat Detail Hafalan
            </Link>
          </div>
        </div>

        {/* Progress Iqro/Quran Card */}
        <div className="bg-white rounded-2xl p-6 shadow-sm border border-emerald-50 flex flex-col justify-between">
          <div>
            <div className="flex justify-between items-center mb-4">
              <h3 className="text-lg font-semibold text-slate-900 flex items-center gap-2">
                <span className="material-symbols-outlined text-primary">auto_stories</span>
                Progres Mengaji (Iqro/Quran)
              </h3>
            </div>
            
            {iqroProgress ? (
              <div className="bg-surface-container-low rounded-xl p-4 border border-slate-200">
                <div className="flex justify-between items-end mb-2">
                  <p className="text-sm text-secondary">Terakhir diupdate: {formatDate(iqroProgress.created_at)}</p>
                </div>
                <div className="flex items-baseline gap-2 mb-3">
                  <span className="text-3xl font-bold text-primary">{iqroProgress.level}</span>
                  <span className="text-lg font-medium text-primary">{iqroProgress.page_surah}</span>
                </div>
                {iqroProgress.notes && (
                  <div className="bg-white rounded-lg p-3 text-sm text-secondary border border-gray-100 italic">
                    "{iqroProgress.notes}"
                  </div>
                )}
              </div>
            ) : (
              <p className="text-secondary text-center py-8">Belum ada catatan progres mengaji.</p>
            )}
          </div>
          
          <div className="pt-4 border-t border-slate-50 mt-4">
            <Link 
              href="/wali/laporan" 
              className="flex items-center justify-center gap-1.5 w-full text-center py-2.5 bg-primary-container text-on-primary-container font-semibold rounded-xl text-sm hover:bg-primary-container/80 transition-colors"
            >
              <span className="material-symbols-outlined text-[16px]">visibility</span>
              Lihat Riwayat Belajar
            </Link>
          </div>
        </div>
      </div>

      {/* Grid Row 2: Penilaian Sholat & Kehadiran */}
      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        {/* Penilaian Sholat & Doa Card */}
        <div className="bg-white rounded-2xl p-6 shadow-sm border border-emerald-50 flex flex-col justify-between">
          <div>
            <div className="flex justify-between items-center mb-4">
              <h3 className="text-lg font-semibold text-slate-900 flex items-center gap-2">
                <span className="material-symbols-outlined text-primary">man_4</span>
                Penilaian Sholat & Doa
              </h3>
            </div>
            
            <div className="space-y-3">
              {sholatProgress.length > 0 ? (
                sholatProgress.slice(0, 3).map((item: any, idx: number) => (
                  <div key={idx} className="p-3 bg-slate-50 border border-slate-100 rounded-xl space-y-1">
                    <div className="flex justify-between items-start">
                      <div>
                        <p className="text-[10px] text-slate-400 font-semibold uppercase">{item.category}</p>
                        <p className="text-sm font-bold text-slate-800 mt-0.5">{item.item_name}</p>
                      </div>
                      <span className={`px-2 py-0.5 rounded text-[10px] font-bold shrink-0 ${
                        item.status === 'SEMPURNA' ? 'bg-emerald-100 text-primary' :
                        item.status === 'LANCAR' ? 'bg-blue-100 text-blue-700' :
                        'bg-amber-100 text-amber-700'
                      }`}>
                        {item.status}
                      </span>
                    </div>
                    {item.notes && <p className="text-xs text-secondary italic mt-1 text-slate-500">"{item.notes}"</p>}
                  </div>
                ))
              ) : (
                <p className="text-xs text-secondary text-center py-8 bg-slate-50 rounded-xl border border-slate-100">
                  Belum ada catatan penilaian sholat & doa.
                </p>
              )}
            </div>
          </div>
          
          <div className="pt-4 border-t border-slate-50 mt-4">
            <Link 
              href="/wali/laporan" 
              className="flex items-center justify-center gap-1.5 w-full text-center py-2.5 bg-primary-container text-on-primary-container font-semibold rounded-xl text-sm hover:bg-primary-container/80 transition-colors"
            >
              <span className="material-symbols-outlined text-[16px]">visibility</span>
              Lihat Detail Sholat & Doa
            </Link>
          </div>
        </div>

        {/* Kehadiran (Absensi) Card */}
        <div className="bg-white rounded-2xl p-6 shadow-sm border border-emerald-50 flex flex-col justify-between">
          <div>
            <div className="flex justify-between items-center mb-4">
              <h3 className="text-lg font-semibold text-slate-900 flex items-center gap-2">
                <span className="material-symbols-outlined text-primary">fact_check</span>
                Kehadiran (30 Hari Terakhir)
              </h3>
              <span className="text-sm font-bold text-primary bg-primary/10 px-2 py-1 rounded-md">{attendanceRate}% Hadir</span>
            </div>
            
            <div className="grid grid-cols-4 gap-2 mb-6">
              <div className="bg-primary-container/50 rounded-lg p-3 text-center border border-slate-200">
                <p className="text-2xl font-bold text-primary">{hadirCount}</p>
                <p className="text-[10px] uppercase font-bold text-primary mt-1">Hadir</p>
              </div>
              <div className="bg-blue-50 rounded-lg p-3 text-center border border-blue-100">
                <p className="text-2xl font-bold text-blue-700">{izinCount}</p>
                <p className="text-[10px] uppercase font-bold text-blue-600 mt-1">Izin</p>
              </div>
              <div className="bg-amber-50 rounded-lg p-3 text-center border border-amber-100">
                <p className="text-2xl font-bold text-amber-700">{sakitCount}</p>
                <p className="text-[10px] uppercase font-bold text-amber-600 mt-1">Sakit</p>
              </div>
              <div className="bg-red-50 rounded-lg p-3 text-center border border-red-100">
                <p className="text-2xl font-bold text-red-700">{alpaCount}</p>
                <p className="text-[10px] uppercase font-bold text-red-600 mt-1">Alpa</p>
              </div>
            </div>
            
            <div>
              <h4 className="text-sm font-medium text-slate-900 mb-2">Riwayat Absensi Terbaru</h4>
              <div className="space-y-2">
                {recentAttendance.slice(0, 3).map((att: any) => (
                  <div key={att.id} className="flex justify-between items-center text-sm p-2 rounded-md hover:bg-gray-50">
                    <span className="text-secondary">{formatDate(att.date)}</span>
                    <span className={`px-2 py-0.5 rounded text-xs font-bold ${
                      att.status === 'Hadir' ? 'bg-emerald-100 text-primary' :
                      att.status === 'Izin' ? 'bg-blue-100 text-blue-700' :
                      att.status === 'Sakit' ? 'bg-amber-100 text-amber-700' :
                      'bg-red-100 text-red-700'
                    }`}>
                      {att.status}
                    </span>
                  </div>
                ))}
                {recentAttendance.length === 0 && <p className="text-xs text-secondary text-center">Belum ada riwayat.</p>}
              </div>
            </div>
          </div>
          
          <div className="pt-4 border-t border-slate-50 mt-4">
            <Link 
              href="/wali/presensi" 
              className="flex items-center justify-center gap-1.5 w-full text-center py-2.5 bg-primary-container text-on-primary-container font-semibold rounded-xl text-sm hover:bg-primary-container/80 transition-colors"
            >
              <span className="material-symbols-outlined text-[16px]">calendar_month</span>
              Detail Kalender Absensi
            </Link>
          </div>
        </div>
      </div>

      {/* Grid Row 3: SPP Payments Card (Full Width on Desktop) */}
      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div className="bg-white rounded-2xl p-6 shadow-sm border border-emerald-50 md:col-span-2">
          <h3 className="text-lg font-semibold text-slate-900 flex items-center gap-2 mb-4">
            <span className="material-symbols-outlined text-primary">payments</span>
            Administrasi SPP (3 Bulan Terakhir)
          </h3>
          
          {payments.length > 0 ? (
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
              {payments.map((payment: any) => (
                <div key={payment.id} className="flex justify-between items-center p-4 border border-gray-100 rounded-xl bg-surface-container-low/50">
                  <div className="flex items-center gap-3">
                    <div className={`w-10 h-10 rounded-full flex items-center justify-center ${
                      payment.status === 'Lunas' ? 'bg-primary/10 text-primary' : 'bg-red-100 text-red-500'
                    }`}>
                      <span className="material-symbols-outlined">
                        {payment.status === 'Lunas' ? 'check_circle' : 'pending'}
                      </span>
                    </div>
                    <div>
                      <p className="font-semibold text-slate-900 text-sm">
                        {payment.month} {payment.year}
                      </p>
                      <p className="text-[10px] text-secondary">
                        {payment.payment_type && payment.payment_type !== 'SPP' ? payment.payment_type : 'SPP Bulanan'}
                      </p>
                    </div>
                  </div>
                  <div className="text-right">
                    <p className="font-bold text-gray-900 text-sm">{formatRupiah(payment.amount)}</p>
                    <p className={`text-[10px] font-bold mt-0.5 ${
                      payment.status === 'Lunas' ? 'text-primary' : 'text-error'
                    }`}>
                      {payment.status.toUpperCase()}
                    </p>
                  </div>
                </div>
              ))}
            </div>
          ) : (
            <p className="text-secondary text-center py-8">Belum ada catatan SPP.</p>
          )}
        </div>
      </div>

      {/* Floating WhatsApp Action Button */}
      <a
        href={waLink}
        target="_blank"
        rel="noopener noreferrer"
        className="fixed bottom-24 right-6 flex items-center gap-2 bg-[#25D366] hover:bg-[#20ba5a] text-white px-4 py-3 rounded-full shadow-lg transition-transform hover:scale-105 active:scale-95 z-40 text-sm font-semibold"
      >
        <svg 
          className="w-5 h-5 fill-current" 
          viewBox="0 0 24 24"
        >
          <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.513 2.262 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.835-3c1.654.983 3.226 1.487 4.967 1.488 5.485 0 9.948-4.468 9.95-9.956.002-2.656-1.03-5.153-2.906-7.03C16.223 3.626 13.731 2.593 11.08 2.59c-5.484 0-9.946 4.467-9.948 9.953-.001 1.76.495 3.328 1.492 4.97L1.61 21.05l3.856-1.417c1.371.748 2.68 1.134 4.095 1.134H11.08zM17.47 14.39c-.3-.149-1.77-.874-2.03-.972-.27-.099-.46-.149-.66.149-.19.3-.76.972-.93 1.16-.18.199-.36.229-.66.079-1.2-.59-2.06-1.04-2.88-2.45-.22-.38.22-.35.63-1.16.07-.15.03-.28-.01-.38-.05-.1-.46-1.11-.63-1.53-.17-.41-.36-.35-.5-.35H9.42c-.17 0-.44.06-.67.3-.23.25-.89.87-.89 2.12 0 1.25.91 2.45 1.03 2.62.13.17 1.79 2.73 4.33 3.82.6.26 1.08.41 1.45.53.61.19 1.16.16 1.6.1.49-.07 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.13-.27-.2-.57-.35z"/>
        </svg>
        Hubungi Ustaz
      </a>
    </div>
  );
}
