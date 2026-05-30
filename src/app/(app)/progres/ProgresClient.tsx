'use client';

import { useState } from 'react';
import { saveProgressIqro, saveProgressSholat, saveProgressHafalan } from '@/lib/actions';

function formatDate(dateStr: string) {
  const date = new Date(dateStr);
  return new Intl.DateTimeFormat('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }).format(date);
}

const surahList = [
  "Al-Fatihah", "Al-Baqarah", "Ali 'Imran", "An-Nisa'", "Al-Ma'idah", "Al-An'am", "Al-A'raf", "Al-Anfal", "At-Taubah", "Yunus", "Hud", "Yusuf", "Ar-Ra'd", "Ibrahim", "Al-Hijr", "An-Nahl", "Al-Isra'", "Al-Kahf", "Maryam", "Ta Ha", "Al-Anbiya'", "Al-Hajj", "Al-Mu'minun", "An-Nur", "Al-Furqan", "Asy-Syu'ara'", "An-Naml", "Al-Qasas", "Al-'Ankabut", "Ar-Rum", "Luqman", "As-Sajdah", "Al-Ahzab", "Saba'", "Fatir", "Ya Sin", "As-Saffat", "Sad", "Az-Zumar", "Ghafir", "Fussilat", "Asy-Syura", "Az-Zukhruf", "Ad-Dukhan", "Al-Jasiyah", "Al-Ahqaf", "Muhammad", "Al-Fath", "Al-Hujurat", "Qaf", "Az-Zariyat", "At-Tur", "An-Najm", "Al-Qamar", "Ar-Rahman", "Al-Waqi'ah", "Al-Hadid", "Al-Mujadilah", "Al-Hasyr", "Al-Mumtahanah", "As-Saff", "Al-Jumu'ah", "Al-Munafiqun", "At-Tagabun", "At-Talaq", "At-Tahrim", "Al-Mulk", "Al-Qalam", "Al-Haqqah", "Al-Ma'arij", "Nuh", "Al-Jinn", "Al-Muzzammil", "Al-Muddassir", "Al-Qiyamah", "Al-Insan", "Al-Mursalat", "An-Naba'", "An-Nazi'at", "'Abasa", "At-Takwir", "Al-Infitar", "Al-Mutaffifin", "Al-Insyiqaq", "Al-Buruj", "At-Tariq", "Al-A'la", "Al-Gasyiyah", "Al-Fajr", "Al-Balad", "Asy-Syams", "Al-Lail", "Ad-Duha", "Asy-Syarh", "At-Tin", "Al-'Alaq", "Al-Qadr", "Al-Bayyinah", "Az-Zalzalah", "Al-'Adiyat", "Al-Qari'ah", "At-Takasur", "Al-'Asr", "Al-Humazah", "Al-Fil", "Quraisy", "Al-Ma'un", "Al-Kausar", "Al-Kafirun", "An-Nasr", "Al-Lahab", "Al-Ikhlas", "Al-Falaq", "An-Nas"
];

const surahsJuz30 = [
  "An-Naba'", "An-Nazi'at", "'Abasa", "At-Takwir", "Al-Infitar",
  "Al-Mutaffifin", "Al-Insyiqaq", "Al-Buruj", "At-Tariq", "Al-A'la",
  "Al-Ghasyiyah", "Al-Fajr", "Al-Balad", "Asy-Syams", "Al-Lail",
  "Ad-Duha", "Asy-Syarh", "At-Tin", "Al-'Alaq", "Al-Qadr",
  "Al-Bayyinah", "Az-Zalzalah", "Al-'Adiyat", "Al-Qari'ah", "At-Takasur",
  "Al-'Asr", "Al-Humazah", "Al-Fil", "Quraisy", "Al-Ma'un",
  "Al-Kausar", "Al-Kafirun", "An-Nasr", "Al-Lahab", "Al-Ikhlas",
  "Al-Falaq", "An-Nas"
];

export default function ProgresClient({ students, iqroProgress, sholatProgress, hafalanProgress }: { students: any[], iqroProgress: any[], sholatProgress: any[], hafalanProgress: any[] }) {
  const [activeTab, setActiveTab] = useState<'iqro' | 'hafalan' | 'sholat'>('iqro');
  const [selectedLevel, setSelectedLevel] = useState("Iqra' 1");
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState<{ type: 'success' | 'error', text: string } | null>(null);

  // Sholat Categories
  const sholatCategories = [
    {
      name: 'Azan & Persiapan',
      items: ['Doa Sebelum Azan', 'Azan', 'Iqomah']
    },
    {
      name: 'Gerakan & Bacaan',
      items: ['Takbiratul Ihram', 'Al-Fatihah & Ayat', 'Rukuk & I\'tidal', 'Sujud & Duduk', 'Tasyahud & Salam']
    },
    {
      name: 'Zikir & Doa',
      items: ['Zikir', 'Doa Setelah Sholat']
    }
  ];

  const handleIqroSubmit = async (formData: FormData) => {
    setLoading(true);
    setMessage(null);
    const result = await saveProgressIqro(formData);
    
    if (result?.error) {
      setMessage({ type: 'error', text: result.error });
    } else {
      setMessage({ type: 'success', text: 'Progres Iqro/Quran berhasil disimpan.' });
      setTimeout(() => window.location.reload(), 1500);
    }
    setLoading(false);
  };

  const handleHafalanSubmit = async (formData: FormData) => {
    setLoading(true);
    setMessage(null);
    const result = await saveProgressHafalan(formData);
    
    if (result?.error) {
      setMessage({ type: 'error', text: result.error });
    } else {
      setMessage({ type: 'success', text: 'Progres hafalan Juz 30 berhasil disimpan.' });
      setTimeout(() => window.location.reload(), 1500);
    }
    setLoading(false);
  };

  const handleSholatSubmit = async (formData: FormData) => {
    setLoading(true);
    setMessage(null);
    const result = await saveProgressSholat(formData);
    
    if (result?.error) {
      setMessage({ type: 'error', text: result.error });
    } else {
      setMessage({ type: 'success', text: 'Penilaian Sholat berhasil disimpan.' });
      setTimeout(() => window.location.reload(), 1500);
    }
    setLoading(false);
  };

  return (
    <div className="space-y-6">
      <div>
        <h2 className="text-2xl font-bold text-slate-900">Progres Belajar</h2>
        <p className="text-secondary text-sm">Catat perkembangan mengaji, hafalan Juz 30, dan penilaian ibadah sholat santri.</p>
      </div>

      {/* Tabs */}
      <div className="flex bg-white rounded-xl shadow-sm p-1 border border-emerald-50">
        <button
          onClick={() => setActiveTab('iqro')}
          className={`flex-1 py-3 text-sm font-semibold rounded-lg transition-colors flex items-center justify-center gap-2 ${
            activeTab === 'iqro' ? 'bg-primary text-white shadow' : 'text-secondary hover:bg-gray-50'
          }`}
        >
          <span className="material-symbols-outlined text-[20px]">auto_stories</span>
          Iqro & Quran
        </button>
        <button
          onClick={() => setActiveTab('hafalan')}
          className={`flex-1 py-3 text-sm font-semibold rounded-lg transition-colors flex items-center justify-center gap-2 ${
            activeTab === 'hafalan' ? 'bg-primary text-white shadow' : 'text-secondary hover:bg-gray-50'
          }`}
        >
          <span className="material-symbols-outlined text-[20px]">menu_book</span>
          Hafalan Juz 30
        </button>
        <button
          onClick={() => setActiveTab('sholat')}
          className={`flex-1 py-3 text-sm font-semibold rounded-lg transition-colors flex items-center justify-center gap-2 ${
            activeTab === 'sholat' ? 'bg-primary text-white shadow' : 'text-secondary hover:bg-gray-50'
          }`}
        >
          <span className="material-symbols-outlined text-[20px]">man_4</span>
          Penilaian Sholat
        </button>
      </div>

      {message && (
        <div className={`p-4 rounded-xl flex items-center gap-2 ${message.type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`}>
          <span className="material-symbols-outlined">{message.type === 'success' ? 'check_circle' : 'error'}</span>
          {message.text}
        </div>
      )}

      {/* Iqro / Quran Tab */}
      {activeTab === 'iqro' && (
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <div className="bg-white rounded-2xl p-6 shadow-sm border border-emerald-50">
            <h3 className="font-semibold text-slate-900 mb-6 flex items-center gap-2">
              <span className="material-symbols-outlined text-primary">edit_document</span>
              Input Progres Mengaji
            </h3>
            
            <form action={handleIqroSubmit} className="space-y-4">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">Pilih Santri</label>
                <select name="student_id" required className="w-full px-4 py-2 border border-gray-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-primary outline-none bg-white">
                  <option value="">-- Pilih Santri --</option>
                  {students.map(s => <option key={s.id} value={s.id}>{s.name} ({s.class})</option>)}
                </select>
              </div>

              <div className="grid grid-cols-2 gap-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">Jilid / Tingkat</label>
                  <select name="level" value={selectedLevel} onChange={(e) => setSelectedLevel(e.target.value)} required className="w-full px-4 py-2 border border-gray-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-primary outline-none bg-white">
                    <option value="Iqra' 1">Iqra' 1</option>
                    <option value="Iqra' 2">Iqra' 2</option>
                    <option value="Iqra' 3">Iqra' 3</option>
                    <option value="Iqra' 4">Iqra' 4</option>
                    <option value="Iqra' 5">Iqra' 5</option>
                    <option value="Iqra' 6">Iqra' 6</option>
                    <option value="Al-Quran">Al-Quran</option>
                    <option value="Tajwid">Tajwid</option>
                    <option value="Hafalan">Hafalan</option>
                  </select>
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">Halaman / Surah</label>
                  <select name="page_surah" required className="w-full px-4 py-2 border border-gray-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-primary outline-none bg-white">
                    <option value="">-- Pilih Halaman/Surah --</option>
                    {selectedLevel.includes("Iqra") ? (
                      Array.from({length: 45}, (_, i) => (
                        <option key={`hal-${i+1}`} value={`Halaman ${i+1}`}>Halaman {i+1}</option>
                      ))
                    ) : (
                      surahList.map((surah, idx) => (
                        <option key={surah} value={`Surah {idx+1}: ${surah}`}>Surah {idx+1}: {surah}</option>
                      ))
                    )}
                  </select>
                </div>
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan (Opsional)</label>
                <textarea name="notes" rows={3} placeholder="Evaluasi kelancaran, tajwid, dll..." className="w-full px-4 py-2 border border-gray-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-primary outline-none"></textarea>
              </div>

              <button type="submit" disabled={loading} className="w-full bg-primary hover:bg-primary-container text-white py-3 rounded-xl font-medium transition-colors mt-2">
                {loading ? 'Menyimpan...' : 'Simpan Progres'}
              </button>
            </form>
          </div>

          <div className="bg-white rounded-2xl p-6 shadow-sm border border-emerald-50">
            <h3 className="font-semibold text-slate-900 mb-4 flex items-center gap-2">
              <span className="material-symbols-outlined text-primary">history</span>
              Riwayat Progres Terakhir
            </h3>
            
            <div className="space-y-4 max-h-[500px] overflow-y-auto pr-2">
              {iqroProgress.length === 0 ? (
                <p className="text-secondary text-sm text-center py-4">Belum ada riwayat progres.</p>
              ) : (
                iqroProgress.slice(0, 10).map((prog, i) => (
                  <div key={i} className="p-4 border border-gray-100 rounded-xl bg-surface-container-low/50">
                    <div className="flex justify-between items-start mb-2">
                      <div>
                        <p className="font-medium text-slate-900">{prog.student_name}</p>
                        <p className="text-xs text-secondary">{formatDate(prog.created_at)}</p>
                      </div>
                      <span className="bg-primary/10 text-primary px-2 py-1 rounded text-xs font-bold border border-primary/20">
                        {prog.level}
                      </span>
                    </div>
                    <p className="font-semibold text-gray-800 text-sm mb-1">{prog.page_surah}</p>
                    {prog.notes && <p className="text-xs text-secondary italic">"{prog.notes}"</p>}
                  </div>
                ))
              )}
            </div>
          </div>
        </div>
      )}

      {/* Hafalan Juz 30 Tab */}
      {activeTab === 'hafalan' && (
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <div className="bg-white rounded-2xl p-6 shadow-sm border border-emerald-50">
            <h3 className="font-semibold text-slate-900 mb-6 flex items-center gap-2">
              <span className="material-symbols-outlined text-primary">edit_document</span>
              Input Progres Hafalan Juz 30
            </h3>
            
            <form action={handleHafalanSubmit} className="space-y-4">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">Pilih Santri</label>
                <select name="student_id" required className="w-full px-4 py-2 border border-gray-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-primary outline-none bg-white">
                  <option value="">-- Pilih Santri --</option>
                  {students.map(s => <option key={s.id} value={s.id}>{s.name} ({s.class})</option>)}
                </select>
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">Pilih Surah (Juz 30)</label>
                <select name="surah_name" required className="w-full px-4 py-2 border border-gray-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-primary outline-none bg-white">
                  <option value="">-- Pilih Surah --</option>
                  {surahsJuz30.map(surah => (
                    <option key={surah} value={surah}>{surah}</option>
                  ))}
                </select>
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-3">Nilai Kelancaran</label>
                <div className="flex gap-2">
                  <label className="flex-1 cursor-pointer">
                    <input type="radio" name="status" value="BELUM LANCAR" className="peer sr-only" required />
                    <div className="text-center py-3 rounded-xl border border-gray-200 text-slate-900 text-sm font-medium peer-checked:bg-red-50 peer-checked:text-error peer-checked:border-error transition-all">
                      Belum Lancar
                    </div>
                  </label>
                  <label className="flex-1 cursor-pointer">
                    <input type="radio" name="status" value="LANCAR" className="peer sr-only" required />
                    <div className="text-center py-3 rounded-xl border border-gray-200 text-slate-900 text-sm font-medium peer-checked:bg-blue-50 peer-checked:text-blue-700 peer-checked:border-blue-700 transition-all">
                      Lancar
                    </div>
                  </label>
                  <label className="flex-1 cursor-pointer">
                    <input type="radio" name="status" value="SEMPURNA" className="peer sr-only" required />
                    <div className="text-center py-3 rounded-xl border border-gray-200 text-slate-900 text-sm font-medium peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary shadow-sm transition-all">
                      Sempurna
                    </div>
                  </label>
                </div>
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan (Opsional)</label>
                <textarea name="notes" rows={3} placeholder="Makhraj, tajwid, atau saran perbaikan..." className="w-full px-4 py-2 border border-gray-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-primary outline-none"></textarea>
              </div>

              <button type="submit" disabled={loading} className="w-full bg-primary hover:bg-primary-container text-white py-3 rounded-xl font-medium transition-colors mt-2">
                {loading ? 'Menyimpan...' : 'Simpan Progres'}
              </button>
            </form>
          </div>

          <div className="bg-white rounded-2xl p-6 shadow-sm border border-emerald-50">
            <h3 className="font-semibold text-slate-900 mb-4 flex items-center gap-2">
              <span className="material-symbols-outlined text-primary">history</span>
              Riwayat Hafalan Terakhir
            </h3>
            
            <div className="space-y-4 max-h-[500px] overflow-y-auto pr-2">
              {hafalanProgress.length === 0 ? (
                <p className="text-secondary text-sm text-center py-4">Belum ada riwayat progres hafalan.</p>
              ) : (
                hafalanProgress.slice(0, 10).map((prog, i) => (
                  <div key={i} className="p-4 border border-gray-100 rounded-xl bg-surface-container-low/50">
                    <div className="flex justify-between items-start mb-2">
                      <div>
                        <p className="font-medium text-slate-900">{prog.student_name}</p>
                        <p className="text-xs text-secondary">{formatDate(prog.created_at)}</p>
                      </div>
                      <span className={`px-2 py-0.5 rounded text-[10px] font-bold ${
                        prog.status === 'SEMPURNA' ? 'bg-emerald-100 text-primary border border-emerald-200' :
                        prog.status === 'LANCAR' ? 'bg-blue-100 text-blue-700 border border-blue-200' :
                        'bg-amber-100 text-amber-700 border border-amber-200'
                      }`}>
                        {prog.status}
                      </span>
                    </div>
                    <p className="font-semibold text-gray-800 text-sm mb-1">Q.S. {prog.surah_name}</p>
                    {prog.notes && <p className="text-xs text-secondary italic">"{prog.notes}"</p>}
                  </div>
                ))
              )}
            </div>
          </div>
        </div>
      )}

      {/* Sholat Tab */}
      {activeTab === 'sholat' && (
        <div className="bg-white rounded-2xl p-6 shadow-sm border border-emerald-50">
          <h3 className="font-semibold text-slate-900 mb-6 flex items-center gap-2">
            <span className="material-symbols-outlined text-primary">task_alt</span>
            Form Penilaian Sholat & Doa
          </h3>

          <form action={handleSholatSubmit} className="space-y-6 max-w-2xl mx-auto">
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">Pilih Santri</label>
              <select name="student_id" required className="w-full px-4 py-3 border border-gray-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-primary outline-none bg-white">
                <option value="">-- Pilih Santri --</option>
                {students.map(s => <option key={s.id} value={s.id}>{s.name} ({s.class})</option>)}
              </select>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="category" required className="w-full px-4 py-3 border border-gray-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-primary outline-none bg-white">
                  <option value="">-- Kategori --</option>
                  {sholatCategories.map(c => <option key={c.name} value={c.name}>{c.name}</option>)}
                </select>
              </div>
              
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">Materi Uji</label>
                <input type="text" name="item_name" placeholder="Misal: Takbiratul Ihram, Al-Fatihah, dll" required className="w-full px-4 py-3 border border-gray-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-primary outline-none" />
              </div>
            </div>

            <div>
              <label className="block text-sm font-medium text-gray-700 mb-3">Nilai Kelancaran</label>
              <div className="flex gap-2">
                <label className="flex-1 cursor-pointer">
                  <input type="radio" name="status" value="BELUM LANCAR" className="peer sr-only" required />
                  <div className="text-center py-3 rounded-xl border border-gray-200 text-slate-900 text-sm font-medium peer-checked:bg-red-50 peer-checked:text-error peer-checked:border-error transition-all">
                    Belum Lancar
                  </div>
                </label>
                <label className="flex-1 cursor-pointer">
                  <input type="radio" name="status" value="LANCAR" className="peer sr-only" required />
                  <div className="text-center py-3 rounded-xl border border-gray-200 text-slate-900 text-sm font-medium peer-checked:bg-blue-50 peer-checked:text-blue-700 peer-checked:border-blue-700 transition-all">
                    Lancar
                  </div>
                </label>
                <label className="flex-1 cursor-pointer">
                  <input type="radio" name="status" value="SEMPURNA" className="peer sr-only" required />
                  <div className="text-center py-3 rounded-xl border border-gray-200 text-slate-900 text-sm font-medium peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary shadow-sm transition-all">
                    Sempurna
                  </div>
                </label>
              </div>
            </div>

            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
              <textarea name="notes" rows={2} placeholder="Saran perbaikan untuk santri..." className="w-full px-4 py-3 border border-gray-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-primary outline-none"></textarea>
            </div>

            <div className="pt-2">
              <button type="submit" disabled={loading} className="w-full bg-primary hover:bg-primary-container text-white py-3 rounded-xl font-medium transition-colors shadow-sm">
                {loading ? 'Menyimpan...' : 'Simpan Nilai'}
              </button>
            </div>
          </form>
        </div>
      )}
    </div>
  );
}
