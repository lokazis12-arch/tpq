'use client';

import { useState, useEffect } from 'react';
import { recordPayment, getPaymentStatusReport, togglePaymentStatus } from '@/lib/actions';
import SearchableSelect from '@/components/SearchableSelect';

function formatRupiah(amount: number) {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(amount);
}

export default function BayarClient({ students, recentPayments }: { students: any[], recentPayments: any[] }) {
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState<{ type: 'success' | 'error', text: string } | null>(null);

  const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
  const currentYear = new Date().getFullYear();
  const years = [currentYear - 1, currentYear, currentYear + 1];
  const currentMonth = months[new Date().getMonth()];

  const [filterType, setFilterType] = useState('SPP');
  const [filterMonth, setFilterMonth] = useState(currentMonth);
  const [filterYear, setFilterYear] = useState(currentYear);
  const [reportData, setReportData] = useState<any[]>([]);
  const [loadingReport, setLoadingReport] = useState(false);
  const [searchQuery, setSearchQuery] = useState('');
  const [actionLoading, setActionLoading] = useState<Record<number, boolean>>({});

  const fetchReport = async (type: string, month: string, year: number) => {
    setLoadingReport(true);
    try {
      const data = await getPaymentStatusReport(month, year, type);
      setReportData(data);
    } catch (error) {
      console.error('Gagal mengambil laporan:', error);
    } finally {
      setLoadingReport(false);
    }
  };

  useEffect(() => {
    fetchReport(filterType, filterMonth, filterYear);
  }, [filterType, filterMonth, filterYear]);

  const handleSubmit = async (formData: FormData) => {
    setLoading(true);
    setMessage(null);
    const result = await recordPayment(formData);
    
    if (result?.error) {
      setMessage({ type: 'error', text: result.error });
    } else {
      setMessage({ type: 'success', text: 'Pembayaran SPP berhasil dicatat.' });
      setTimeout(() => {
        window.location.reload(); // Quick way to refresh recent payments
      }, 1500);
    }
    setLoading(false);
  };

  const handleToggleStatus = async (studentId: number, targetStatus: 'Lunas' | 'Belum Bayar') => {
    if (targetStatus === 'Belum Bayar') {
      const confirmCancel = window.confirm('Apakah Anda yakin ingin membatalkan status LUNAS untuk santri ini?');
      if (!confirmCancel) return;
    }
    
    setActionLoading(prev => ({ ...prev, [studentId]: true }));
    setMessage(null);
    
    const amount = 50000;
    
    const result = await togglePaymentStatus(
      studentId,
      filterMonth,
      filterYear,
      filterType,
      targetStatus,
      amount
    );
    
    if (result?.error) {
      setMessage({ type: 'error', text: result.error });
    } else {
      setMessage({ 
        type: 'success', 
        text: `Status pembayaran berhasil diubah menjadi ${targetStatus === 'Lunas' ? 'Lunas' : 'Belum Bayar'}.` 
      });
      await fetchReport(filterType, filterMonth, filterYear);
      setTimeout(() => {
        window.location.reload();
      }, 1000);
    }
    setActionLoading(prev => ({ ...prev, [studentId]: false }));
  };

  return (
    <div className="space-y-6">
      <div>
        <h2 className="text-2xl font-bold text-slate-900">Pembayaran SPP</h2>
        <p className="text-secondary text-sm">Catat pembayaran SPP bulanan santri.</p>
      </div>

      <div className="flex flex-col lg:flex-row gap-6">
        {/* Form Section */}
        <div className="flex-grow lg:w-2/3">
          <div className="bg-white rounded-2xl p-6 shadow-sm border border-emerald-50">
            <h3 className="font-semibold text-slate-900 mb-6 flex items-center gap-2">
              <span className="material-symbols-outlined text-primary">add_card</span>
              Form Pencatatan SPP
            </h3>

            {message && (
              <div className={`p-4 rounded-xl flex items-center gap-2 mb-6 ${message.type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`}>
                <span className="material-symbols-outlined">{message.type === 'success' ? 'check_circle' : 'error'}</span>
                {message.text}
              </div>
            )}

            <form action={handleSubmit} className="space-y-5">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">Pilih Santri</label>
                <SearchableSelect 
                  options={students} 
                  name="student_id" 
                  required 
                  placeholder="-- Pilih/Cari Santri --"
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">Tipe Pembayaran</label>
                <select name="payment_type" required className="w-full px-4 py-3 border border-gray-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none bg-white">
                  <option value="SPP">SPP Bulanan</option>
                  <option value="Daftar Ulang">Daftar Ulang Tahunan</option>
                </select>
              </div>

              <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                  <select name="month" defaultValue={currentMonth} required className="w-full px-4 py-3 border border-gray-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none bg-white">
                    {months.map(m => <option key={m} value={m}>{m}</option>)}
                  </select>
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                  <select name="year" defaultValue={currentYear} required className="w-full px-4 py-3 border border-gray-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none bg-white">
                    {years.map(y => <option key={y} value={y}>{y}</option>)}
                  </select>
                </div>
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">Nominal (Rp)</label>
                <input type="number" name="amount" defaultValue={50000} required className="w-full px-4 py-3 border border-gray-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none" />
              </div>

              <div className="pt-4">
                <button 
                  type="submit" 
                  disabled={loading}
                  className="w-full bg-primary hover:bg-primary-container text-white py-3 rounded-xl font-medium transition-colors disabled:opacity-70 flex justify-center items-center gap-2"
                >
                  {loading ? 'Menyimpan...' : (
                    <>
                      <span className="material-symbols-outlined">save</span>
                      Simpan Pembayaran
                    </>
                  )}
                </button>
              </div>
            </form>
          </div>
        </div>

        {/* Info & History Section */}
        <div className="w-full lg:w-1/3 space-y-6">
          <div className="bg-gradient-to-br from-primary to-primary-container p-6 rounded-2xl text-white shadow-md relative overflow-hidden">
            <span className="material-symbols-outlined absolute right-[-20px] bottom-[-20px] text-[120px] opacity-10">payments</span>
            <h3 className="font-semibold text-emerald-50 mb-1">Iuran SPP Bulanan</h3>
            <p className="text-3xl font-bold mb-2">Rp 50.000</p>
            <p className="text-sm text-emerald-100 opacity-90">Per bulan / santri</p>
            <div className="mt-3 pt-3 border-t border-white/20 text-xs text-emerald-100/80 font-medium">
              Daftar Ulang: Rp 50.000 (1x setahun)
            </div>
          </div>

          <div className="bg-white rounded-2xl p-6 shadow-sm border border-emerald-50">
            <h3 className="font-semibold text-slate-900 mb-4 flex items-center gap-2">
              <span className="material-symbols-outlined text-primary">history</span>
              Riwayat Terbaru
            </h3>
            
            <div className="space-y-4">
              {recentPayments.length === 0 ? (
                <p className="text-sm text-secondary text-center py-4">Belum ada pembayaran.</p>
              ) : (
                recentPayments.map(payment => (
                  <div key={payment.id} className="flex justify-between items-center border-b border-gray-50 pb-3 last:border-0 last:pb-0">
                    <div>
                      <p className="font-medium text-sm text-gray-900">{payment.student_name}</p>
                      <p className="text-xs text-secondary">{payment.month} {payment.year} • <span className="font-semibold text-primary">{payment.payment_type || 'SPP'}</span></p>
                    </div>
                    <div className="text-right">
                      <p className="text-sm font-semibold text-primary">{formatRupiah(payment.amount)}</p>
                      <span className="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded font-bold">LUNAS</span>
                    </div>
                  </div>
                ))
              )}
            </div>
          </div>
        </div>
      </div>

      {/* Laporan Status Pembayaran */}
      <div className="bg-white rounded-2xl p-6 shadow-sm border border-emerald-50 space-y-6">
        <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-gray-100 pb-4">
          <div>
            <h3 className="text-lg font-bold text-slate-900 flex items-center gap-2">
              <span className="material-symbols-outlined text-primary">analytics</span>
              Laporan Status Pembayaran
            </h3>
            <p className="text-secondary text-xs">Pantau siapa saja yang sudah lunas atau belum.</p>
          </div>
          
          {/* Stats summary */}
          <div className="flex gap-3">
            <span className="bg-emerald-50 text-primary border border-emerald-100 px-3 py-1.5 rounded-xl text-xs font-semibold flex items-center gap-1">
              <span className="material-symbols-outlined text-sm">check_circle</span>
              Lunas: {reportData.filter(r => r.status === 'Lunas').length}
            </span>
            <span className="bg-rose-50 text-error border border-rose-100 px-3 py-1.5 rounded-xl text-xs font-semibold flex items-center gap-1">
              <span className="material-symbols-outlined text-sm">cancel</span>
              Belum: {reportData.filter(r => r.status === 'Belum Bayar').length}
            </span>
          </div>
        </div>

        {/* Filter controls */}
        <div className="flex flex-col md:flex-row gap-4 items-center justify-between">
          <div className="flex flex-wrap gap-3 w-full md:w-auto">
            <select 
              value={filterType}
              onChange={(e) => setFilterType(e.target.value)}
              className="px-4 py-2 rounded-xl border border-gray-200 text-slate-900 focus:border-primary focus:ring-1 focus:ring-primary outline-none bg-white text-sm"
            >
              <option value="SPP">SPP Bulanan</option>
              <option value="Daftar Ulang">Daftar Ulang Tahunan</option>
            </select>

            {filterType === 'SPP' && (
              <select 
                value={filterMonth}
                onChange={(e) => setFilterMonth(e.target.value)}
                className="px-4 py-2 rounded-xl border border-gray-200 text-slate-900 focus:border-primary focus:ring-1 focus:ring-primary outline-none bg-white text-sm"
              >
                {months.map(m => <option key={m} value={m}>{m}</option>)}
              </select>
            )}

            <select 
              value={filterYear}
              onChange={(e) => setFilterYear(Number(e.target.value))}
              className="px-4 py-2 rounded-xl border border-gray-200 text-slate-900 focus:border-primary focus:ring-1 focus:ring-primary outline-none bg-white text-sm"
            >
              {years.map(y => <option key={y} value={y}>{y}</option>)}
            </select>
          </div>

          {/* Search box */}
          <div className="relative w-full md:w-64">
            <span className="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-secondary text-sm">search</span>
            <input 
              type="text" 
              placeholder="Cari nama santri..." 
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
              className="w-full pl-9 pr-4 py-2 rounded-xl border border-gray-200 text-slate-900 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none"
            />
          </div>
        </div>

        {/* Table Section */}
        <div className="border border-gray-100 rounded-xl overflow-hidden">
          {loadingReport ? (
            <div className="text-center py-10 text-secondary flex flex-col items-center justify-center gap-2">
              <span className="material-symbols-outlined animate-spin text-primary">sync</span>
              <p className="text-xs">Memuat laporan...</p>
            </div>
          ) : (
            <div className="overflow-x-auto">
              <table className="w-full text-left border-collapse text-sm">
                <thead>
                  <tr className="bg-surface-container-low text-slate-900 text-xs">
                    <th className="px-6 py-3 font-semibold">No</th>
                    <th className="px-6 py-3 font-semibold">Nama Santri</th>
                    <th className="px-6 py-3 font-semibold">Kelas</th>
                    <th className="px-6 py-3 font-semibold">Status</th>
                    <th className="px-6 py-3 font-semibold">Nominal</th>
                    <th className="px-6 py-3 font-semibold">Tanggal Pembayaran</th>
                    <th className="px-6 py-3 font-semibold text-right">Aksi</th>
                  </tr>
                </thead>
                <tbody className="divide-y divide-gray-100">
                  {reportData.filter(r => r.studentName.toLowerCase().includes(searchQuery.toLowerCase())).length === 0 ? (
                    <tr>
                      <td colSpan={7} className="px-6 py-8 text-center text-secondary text-xs">
                        Tidak ada data ditemukan.
                      </td>
                    </tr>
                  ) : (
                    reportData
                      .filter(r => r.studentName.toLowerCase().includes(searchQuery.toLowerCase()))
                      .map((row, idx) => (
                        <tr key={row.studentId} className="hover:bg-gray-50/50 transition-colors">
                          <td className="px-6 py-3 text-secondary">{idx + 1}</td>
                          <td className="px-6 py-3 font-medium text-gray-900">{row.studentName}</td>
                          <td className="px-6 py-3">
                            <span className="bg-slate-100 text-slate-700 px-2 py-0.5 rounded text-[10px] font-semibold">
                              {row.studentClass}
                            </span>
                          </td>
                          <td className="px-6 py-3">
                            <span className={`px-2 py-0.5 rounded text-[10px] font-bold ${
                              row.status === 'Lunas' 
                                ? 'bg-green-100 text-green-700' 
                                : 'bg-red-100 text-red-600'
                            }`}>
                              {row.status.toUpperCase()}
                            </span>
                          </td>
                          <td className="px-6 py-3 font-medium text-gray-900">
                            {row.status === 'Lunas' ? formatRupiah(row.amount) : '-'}
                          </td>
                          <td className="px-6 py-3 text-secondary text-xs">
                            {row.status === 'Lunas' && row.paymentDate 
                              ? new Intl.DateTimeFormat('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }).format(new Date(row.paymentDate)) 
                              : '-'}
                            {row.paymentMonth && row.paymentMonth !== filterMonth && filterType === 'SPP' && ` (di Bulan: ${row.paymentMonth})`}
                          </td>
                          <td className="px-6 py-3 text-right">
                            {row.status === 'Lunas' ? (
                              <button
                                onClick={() => handleToggleStatus(row.studentId, 'Belum Bayar')}
                                disabled={actionLoading[row.studentId]}
                                className="bg-rose-50 hover:bg-rose-100 text-rose-600 px-3 py-1.5 rounded-xl text-xs font-semibold inline-flex items-center gap-1 transition-colors border border-rose-100 disabled:opacity-50"
                              >
                                {actionLoading[row.studentId] ? (
                                  <span className="material-symbols-outlined text-sm animate-spin">sync</span>
                                ) : (
                                  <span className="material-symbols-outlined text-sm">cancel</span>
                                )}
                                Batal
                              </button>
                            ) : (
                              <button
                                onClick={() => handleToggleStatus(row.studentId, 'Lunas')}
                                disabled={actionLoading[row.studentId]}
                                className="bg-emerald-50 hover:bg-emerald-100 text-primary px-3 py-1.5 rounded-xl text-xs font-semibold inline-flex items-center gap-1 transition-colors border border-emerald-100 disabled:opacity-50"
                              >
                                {actionLoading[row.studentId] ? (
                                  <span className="material-symbols-outlined text-sm animate-spin">sync</span>
                                ) : (
                                  <span className="material-symbols-outlined text-sm">check_circle</span>
                                )}
                                Bayar
                              </button>
                            )}
                          </td>
                        </tr>
                      ))
                  )}
                </tbody>
              </table>
            </div>
          )}
        </div>
      </div>
    </div>
  );
}
