'use client';

import { useState } from 'react';
import { recordPayment } from '@/lib/actions';

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
                <select name="student_id" required className="w-full px-4 py-3 border border-gray-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none bg-white">
                  <option value="">-- Pilih Santri --</option>
                  {students.map(s => (
                    <option key={s.id} value={s.id}>{s.name} ({s.class})</option>
                  ))}
                </select>
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
    </div>
  );
}
