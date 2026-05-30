import { getSession } from '@/lib/auth';
import { getWaliDashboard } from '@/lib/actions';
import { redirect } from 'next/navigation';

function formatRupiah(amount: number) {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(amount);
}

function formatDate(dateStr: string) {
  const date = new Date(dateStr);
  return new Intl.DateTimeFormat('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }).format(date);
}

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

  const { student, attendanceSummary, payments, iqroProgress, sholatProgress, recentAttendance } = data;

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

  return (
    <div className="space-y-6">
      {/* Header Profile */}
      <div className="bg-gradient-to-r from-primary to-primary-container rounded-2xl p-6 text-on-primary shadow-md relative overflow-hidden">
        <div className="absolute -right-4 -top-12 opacity-10">
          <span className="material-symbols-outlined text-[150px]">menu_book</span>
        </div>
        <div className="relative z-10 flex items-center gap-4">
          <div className="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center text-2xl font-bold border-2 border-white/40 shadow-inner">
            {student.name.substring(0, 2).toUpperCase()}
          </div>
          <div>
            <h2 className="text-2xl font-bold">{student.name}</h2>
            <div className="flex gap-3 mt-1 text-primary-container-low">
              <span className="flex items-center gap-1 text-sm bg-black/10 px-2 py-0.5 rounded-md">
                <span className="material-symbols-outlined text-sm">school</span>
                Kelas: {student.class}
              </span>
              <span className="flex items-center gap-1 text-sm bg-black/10 px-2 py-0.5 rounded-md">
                <span className="material-symbols-outlined text-sm">check_circle</span>
                Santri Aktif
              </span>
            </div>
          </div>
        </div>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        {/* Progress Iqro/Quran */}
        <div className="bg-white rounded-2xl p-6 shadow-sm border border-emerald-50">
          <div className="flex justify-between items-center mb-4">
            <h3 className="text-lg font-semibold text-slate-900 flex items-center gap-2">
              <span className="material-symbols-outlined text-primary">auto_stories</span>
              Progres Mengaji
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
            <p className="text-secondary text-center py-4">Belum ada catatan progres mengaji.</p>
          )}
        </div>

        {/* Absensi Summary */}
        <div className="bg-white rounded-2xl p-6 shadow-sm border border-emerald-50">
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
            <h4 className="text-sm font-medium text-slate-900 mb-2">Riwayat Terbaru</h4>
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
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        {/* Progress Sholat */}
        <div className="bg-white rounded-2xl p-6 shadow-sm border border-emerald-50">
          <h3 className="text-lg font-semibold text-slate-900 flex items-center gap-2 mb-4">
            <span className="material-symbols-outlined text-primary">man_4</span>
            Penilaian Sholat & Doa
          </h3>
          
          {sholatProgress.length > 0 ? (
            <div className="space-y-4">
              {Object.entries(
                sholatProgress.reduce((acc: any, curr: any) => {
                  if (!acc[curr.category]) acc[curr.category] = [];
                  acc[curr.category].push(curr);
                  return acc;
                }, {})
              ).map(([category, items]: [string, any]) => (
                <div key={category} className="border border-gray-100 rounded-xl overflow-hidden">
                  <div className="bg-surface-container-low px-4 py-2 border-b border-gray-100">
                    <h4 className="font-medium text-slate-900 text-sm">{category}</h4>
                  </div>
                  <ul className="divide-y divide-gray-50">
                    {items.map((item: any) => (
                      <li key={item.id} className="p-3">
                        <div className="flex justify-between items-start mb-1">
                          <span className="text-sm font-medium text-gray-800">{item.item_name}</span>
                          <span className={`text-[10px] font-bold px-2 py-1 rounded-full ${
                            item.status === 'SEMPURNA' ? 'bg-emerald-100 text-primary' :
                            item.status === 'LANCAR' ? 'bg-blue-100 text-blue-700' :
                            'bg-red-100 text-red-700'
                          }`}>
                            {item.status}
                          </span>
                        </div>
                        {item.notes && <p className="text-xs text-secondary italic mt-1 text-gray-500">"{item.notes}"</p>}
                      </li>
                    ))}
                  </ul>
                </div>
              ))}
            </div>
          ) : (
            <p className="text-secondary text-center py-4">Belum ada penilaian sholat.</p>
          )}
        </div>

        {/* SPP Payments */}
        <div className="bg-white rounded-2xl p-6 shadow-sm border border-emerald-50">
          <h3 className="text-lg font-semibold text-slate-900 flex items-center gap-2 mb-4">
            <span className="material-symbols-outlined text-primary">payments</span>
            Riwayat SPP (3 Bulan Terakhir)
          </h3>
          
          {payments.length > 0 ? (
            <div className="space-y-3">
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
                      <p className="font-semibold text-slate-900">{payment.month} {payment.year}</p>
                      <p className="text-xs text-secondary">
                        {payment.payment_date ? formatDate(payment.payment_date) : '-'}
                      </p>
                    </div>
                  </div>
                  <div className="text-right">
                    <p className="font-bold text-gray-900">{formatRupiah(payment.amount)}</p>
                    <p className={`text-xs font-bold mt-0.5 ${
                      payment.status === 'Lunas' ? 'text-primary' : 'text-error'
                    }`}>
                      {payment.status.toUpperCase()}
                    </p>
                  </div>
                </div>
              ))}
            </div>
          ) : (
            <p className="text-secondary text-center py-4">Belum ada catatan SPP.</p>
          )}
        </div>
      </div>
    </div>
  );
}
