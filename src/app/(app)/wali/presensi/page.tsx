import { getSession } from '@/lib/auth';
import { getWaliDashboard } from '@/lib/actions';
import { redirect } from 'next/navigation';
import Link from 'next/link';

export const metadata = {
  title: 'Riwayat Presensi - Darul Ikhlas',
};

const indonesianDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

function getDayName(dateStr: string) {
  const date = new Date(dateStr);
  return indonesianDays[date.getDay()];
}

function formatDate(dateStr: string) {
  const date = new Date(dateStr);
  return new Intl.DateTimeFormat('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }).format(date);
}

export default async function WaliPresensiPage() {
  const session = await getSession();
  if (!session || session.role !== 'wali_santri') redirect('/login');

  const data = await getWaliDashboard(session.id);
  if (!data) {
    return (
      <div className="text-center py-20">
        <p className="text-secondary">Belum ada data untuk ditampilkan.</p>
      </div>
    );
  }

  const { student, attendanceSummary, recentAttendance } = data;

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
    <div className="max-w-md mx-auto space-y-6 pb-12">
      {/* Breadcrumbs */}
      <nav className="text-xs text-slate-500 flex gap-1 items-center px-1">
        <Link href="/wali" className="hover:text-primary transition-colors">Dashboard</Link>
        <span className="material-symbols-outlined text-[12px] text-slate-400">chevron_right</span>
        <span className="text-slate-700 font-medium">Riwayat Presensi</span>
      </nav>

      <div>
        <h2 className="text-2xl font-bold text-slate-900">Kehadiran Santri</h2>
        <p className="text-secondary text-sm">Riwayat kehadiran kelas untuk <strong>{student.name}</strong>.</p>
      </div>

      {/* Summary Box */}
      <div className="bg-white rounded-2xl p-6 shadow-sm border border-emerald-50">
        <div className="flex justify-between items-center mb-4 pb-3 border-b border-slate-50">
          <h3 className="font-bold text-slate-800 text-sm flex items-center gap-1.5">
            <span className="material-symbols-outlined text-primary text-[18px]">analytics</span>
            Persentase Kehadiran
          </h3>
          <span className="text-xs font-bold text-primary bg-primary/10 px-2 py-0.5 rounded">
            {attendanceRate}% Hadir
          </span>
        </div>

        <div className="grid grid-cols-4 gap-2 mb-2">
          <div className="bg-emerald-50/50 rounded-xl p-3 text-center border border-emerald-100/50">
            <p className="text-2xl font-black text-primary">{hadirCount}</p>
            <p className="text-[10px] uppercase font-bold text-primary mt-1">Hadir</p>
          </div>
          <div className="bg-blue-50/50 rounded-xl p-3 text-center border border-blue-100/50">
            <p className="text-2xl font-black text-blue-700">{izinCount}</p>
            <p className="text-[10px] uppercase font-bold text-blue-600 mt-1">Izin</p>
          </div>
          <div className="bg-amber-50/50 rounded-xl p-3 text-center border border-amber-100/50">
            <p className="text-2xl font-black text-amber-700">{sakitCount}</p>
            <p className="text-[10px] uppercase font-bold text-amber-600 mt-1">Sakit</p>
          </div>
          <div className="bg-red-50/50 rounded-xl p-3 text-center border border-red-100/50">
            <p className="text-2xl font-black text-red-700">{alpaCount}</p>
            <p className="text-[10px] uppercase font-bold text-red-600 mt-1">Alpa</p>
          </div>
        </div>
        <p className="text-[10px] text-slate-400 text-center mt-2">Data dihitung dari 30 hari terakhir pembelajaran aktif.</p>
      </div>

      {/* Attendance History List */}
      <div className="bg-white rounded-2xl p-6 shadow-sm border border-emerald-50">
        <h3 className="text-lg font-bold text-slate-900 flex items-center gap-2 mb-4">
          <span className="material-symbols-outlined text-primary text-[22px]">format_list_bulleted</span>
          Jurnal Absensi Harian
        </h3>

        {recentAttendance.length === 0 ? (
          <p className="text-secondary text-sm text-center py-8">Belum ada data kehadiran santri.</p>
        ) : (
          <div className="divide-y divide-slate-100">
            {recentAttendance.map((att: any) => (
              <div key={att.id} className="flex justify-between items-center py-3">
                <div>
                  <h4 className="font-bold text-slate-800 text-sm">
                    {getDayName(att.date)}, {formatDate(att.date)}
                  </h4>
                  <span className="text-[10px] text-slate-400">Jam Pembelajaran TPQ</span>
                </div>
                <span className={`px-2.5 py-1 rounded-lg text-xs font-black tracking-wide uppercase ${
                  att.status === 'Hadir' ? 'bg-emerald-100 text-primary border border-emerald-200' :
                  att.status === 'Izin' ? 'bg-blue-100 text-blue-700 border border-blue-200' :
                  att.status === 'Sakit' ? 'bg-amber-100 text-amber-700 border border-amber-200' :
                  'bg-red-100 text-red-700 border border-red-200'
                }`}>
                  {att.status}
                </span>
              </div>
            ))}
          </div>
        )}
      </div>
    </div>
  );
}
