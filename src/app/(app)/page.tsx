import { getDashboardStats, getStudents, getRecentPayments } from '@/lib/actions';
import { getSession } from '@/lib/auth';
import Link from 'next/link';

function formatRupiah(amount: number) {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(amount);
}

export default async function DashboardPage() {
  const session = await getSession();
  const stats = await getDashboardStats();
  const recentPayments = await getRecentPayments(5);

  return (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex flex-col gap-1">
        <h2 className="text-2xl font-bold text-slate-900 dark:text-emerald-50">
          Selamat Datang, {session?.name}
        </h2>
        <p className="text-secondary dark:text-gray-400">
          Ringkasan data TPQ Darul Ikhlas hari ini.
        </p>
      </div>

      {/* Stats Cards */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
        {/* Total Lunas */}
        <div className="bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-emerald-50 dark:border-slate-700 relative overflow-hidden">
          <div className="absolute top-0 left-0 w-full h-1 bg-primary"></div>
          <div className="flex justify-between items-start mb-4">
            <div>
              <p className="text-sm font-medium text-secondary dark:text-gray-400">Total Lunas</p>
              <h3 className="text-2xl font-bold text-slate-900 dark:text-emerald-50 mt-1">
                {formatRupiah(stats.paidTotal)}
              </h3>
            </div>
            <div className="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary">
              <span className="material-symbols-outlined">account_balance_wallet</span>
            </div>
          </div>
          <p className="text-xs text-secondary dark:text-gray-400">
            Dari {stats.paidCount} santri bulan ini
          </p>
        </div>

        {/* Belum Bayar */}
        <div className="bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-red-50 dark:border-slate-700 relative overflow-hidden">
          <div className="absolute top-0 left-0 w-full h-1 bg-error"></div>
          <div className="flex justify-between items-start mb-4">
            <div>
              <p className="text-sm font-medium text-secondary dark:text-gray-400">Belum Dibayar</p>
              <h3 className="text-2xl font-bold text-slate-900 dark:text-emerald-50 mt-1">
                {formatRupiah(stats.unpaidTotal)}
              </h3>
            </div>
            <div className="w-10 h-10 rounded-full bg-error/10 flex items-center justify-center text-error">
              <span className="material-symbols-outlined">money_off</span>
            </div>
          </div>
          <p className="text-xs text-secondary dark:text-gray-400">
            Dari {stats.unpaidCount} santri bulan ini
          </p>
        </div>

        {/* Progres */}
        <div className="bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-emerald-50 dark:border-slate-700 relative overflow-hidden">
          <div className="absolute top-0 left-0 w-full h-1 bg-secondary"></div>
          <div className="flex justify-between items-start mb-4">
            <div>
              <p className="text-sm font-medium text-secondary dark:text-gray-400">Progres Pembayaran</p>
              <h3 className="text-2xl font-bold text-slate-900 dark:text-emerald-50 mt-1">
                {stats.percentage}%
              </h3>
            </div>
            <div className="w-10 h-10 rounded-full bg-secondary/10 flex items-center justify-center text-secondary">
              <span className="material-symbols-outlined">monitoring</span>
            </div>
          </div>
          <div className="w-full bg-gray-100 dark:bg-slate-700 rounded-full h-2">
            <div className="bg-primary h-2 rounded-full" style={{ width: `${stats.percentage}%` }}></div>
          </div>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {/* Quick Actions */}
        <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-emerald-50 dark:border-slate-700">
          <h3 className="text-lg font-semibold text-slate-900 dark:text-emerald-50 mb-4">
            Aksi Cepat
          </h3>
          <div className="grid grid-cols-2 gap-4">
            <Link href="/santri" className="flex flex-col items-center justify-center p-4 bg-surface-container-low dark:bg-slate-700/50 rounded-xl hover:bg-primary-container/50 dark:hover:bg-slate-700 transition-colors border border-transparent hover:border-slate-200">
              <span className="material-symbols-outlined text-3xl text-primary mb-2">group_add</span>
              <span className="text-sm font-medium text-slate-900 dark:text-emerald-100">Tambah Santri</span>
            </Link>
            <Link href="/absensi" className="flex flex-col items-center justify-center p-4 bg-surface-container-low dark:bg-slate-700/50 rounded-xl hover:bg-primary-container/50 dark:hover:bg-slate-700 transition-colors border border-transparent hover:border-slate-200">
              <span className="material-symbols-outlined text-3xl text-primary mb-2">fact_check</span>
              <span className="text-sm font-medium text-slate-900 dark:text-emerald-100">Isi Absensi</span>
            </Link>
            <Link href="/bayar" className="flex flex-col items-center justify-center p-4 bg-surface-container-low dark:bg-slate-700/50 rounded-xl hover:bg-primary-container/50 dark:hover:bg-slate-700 transition-colors border border-transparent hover:border-slate-200">
              <span className="material-symbols-outlined text-3xl text-primary mb-2">payments</span>
              <span className="text-sm font-medium text-slate-900 dark:text-emerald-100">Catat SPP</span>
            </Link>
            <Link href="/progres" className="flex flex-col items-center justify-center p-4 bg-surface-container-low dark:bg-slate-700/50 rounded-xl hover:bg-primary-container/50 dark:hover:bg-slate-700 transition-colors border border-transparent hover:border-slate-200">
              <span className="material-symbols-outlined text-3xl text-primary mb-2">menu_book</span>
              <span className="text-sm font-medium text-slate-900 dark:text-emerald-100">Input Progres</span>
            </Link>
          </div>
        </div>

        {/* Recent Payments */}
        <div className="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-emerald-50 dark:border-slate-700">
          <div className="flex justify-between items-center mb-4">
            <h3 className="text-lg font-semibold text-slate-900 dark:text-emerald-50">
              Pembayaran Terakhir
            </h3>
            <Link href="/bayar" className="text-sm font-medium text-primary hover:underline">
              Lihat Semua
            </Link>
          </div>
          
          {recentPayments.length === 0 ? (
            <div className="text-center py-8 text-secondary">
              <span className="material-symbols-outlined text-4xl mb-2 opacity-50">receipt_long</span>
              <p>Belum ada transaksi</p>
            </div>
          ) : (
            <ul className="space-y-4">
              {recentPayments.map((payment: any) => (
                <li key={payment.id} className="flex items-center justify-between p-3 hover:bg-surface-container-low dark:hover:bg-slate-700/50 rounded-xl transition-colors">
                  <div className="flex items-center gap-3">
                    <div className="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm">
                      {payment.student_name.substring(0, 2).toUpperCase()}
                    </div>
                    <div>
                      <p className="font-medium text-slate-900 dark:text-emerald-100">{payment.student_name}</p>
                      <p className="text-xs text-secondary">{payment.month} {payment.year}</p>
                    </div>
                  </div>
                  <div className="text-right">
                    <p className="font-semibold text-slate-900 dark:text-emerald-100">{formatRupiah(payment.amount)}</p>
                    <span className="inline-block px-2 py-1 bg-primary/10 text-primary text-[10px] font-bold rounded-full">LUNAS</span>
                  </div>
                </li>
              ))}
            </ul>
          )}
        </div>
      </div>
    </div>
  );
}
