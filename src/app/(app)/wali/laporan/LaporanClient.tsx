'use client';

import { useState } from 'react';
import Link from 'next/link';

interface LaporanClientProps {
  studentName: string;
  iqroHistory: any[];
  sholatHistory: any[];
  hafalanHistory: any[];
}

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

function formatDate(dateStr: string) {
  if (!dateStr) return '-';
  const date = new Date(dateStr);
  return new Intl.DateTimeFormat('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }).format(date);
}

export default function LaporanClient({ studentName, iqroHistory, sholatHistory, hafalanHistory }: LaporanClientProps) {
  const [activeTab, setActiveTab] = useState<'hafalan' | 'iqro' | 'sholat'>('hafalan');
  const [expandedSurah, setExpandedSurah] = useState<string | null>(null);

  // Calculate statistics for Juz 30
  const memorizedSurahs = hafalanHistory.filter(
    (h: any) => h.status === 'SEMPURNA' || h.status === 'LANCAR'
  );
  const totalMemorized = memorizedSurahs.length;
  const percentage = Math.round((totalMemorized / surahsJuz30.length) * 100);

  // Group sholat progress by category
  const sholatGrouped = sholatHistory.reduce((acc: any, curr: any) => {
    if (!acc[curr.category]) acc[curr.category] = [];
    acc[curr.category].push(curr);
    return acc;
  }, {});

  return (
    <div className="max-w-md mx-auto space-y-6 pb-12">
      {/* Breadcrumbs */}
      <nav className="text-xs text-slate-500 flex gap-1 items-center px-1">
        <Link href="/wali" className="hover:text-primary transition-colors">Dashboard</Link>
        <span className="material-symbols-outlined text-[12px] text-slate-400">chevron_right</span>
        <span className="text-slate-700 font-medium">Laporan Progres</span>
      </nav>

      <div>
        <h2 className="text-2xl font-bold text-slate-900">Rapor Progres Santri</h2>
        <p className="text-secondary text-sm">Laporan pencapaian belajar untuk <strong>{studentName}</strong>.</p>
      </div>

      {/* Tabs */}
      <div className="flex bg-white rounded-xl shadow-sm p-1 border border-emerald-50">
        <button
          onClick={() => setActiveTab('hafalan')}
          className={`flex-1 py-3 text-xs font-bold rounded-lg transition-all flex flex-col items-center justify-center gap-1 ${
            activeTab === 'hafalan' ? 'bg-primary text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50'
          }`}
        >
          <span className="material-symbols-outlined text-[20px]">menu_book</span>
          Juz 30
        </button>
        <button
          onClick={() => setActiveTab('iqro')}
          className={`flex-1 py-3 text-xs font-bold rounded-lg transition-all flex flex-col items-center justify-center gap-1 ${
            activeTab === 'iqro' ? 'bg-primary text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50'
          }`}
        >
          <span className="material-symbols-outlined text-[20px]">auto_stories</span>
          Mengaji
        </button>
        <button
          onClick={() => setActiveTab('sholat')}
          className={`flex-1 py-3 text-xs font-bold rounded-lg transition-all flex flex-col items-center justify-center gap-1 ${
            activeTab === 'sholat' ? 'bg-primary text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50'
          }`}
        >
          <span className="material-symbols-outlined text-[20px]">man_4</span>
          Sholat
        </button>
      </div>

      {/* Hafalan Juz 30 Tab */}
      {activeTab === 'hafalan' && (
        <div className="space-y-6">
          {/* Summary Banner */}
          <div className="bg-gradient-to-br from-primary/10 to-primary-container/20 border border-primary/20 rounded-2xl p-5 shadow-sm">
            <h3 className="font-bold text-primary-container-low text-sm flex items-center gap-1.5 mb-2">
              <span className="material-symbols-outlined text-[18px]">verified</span>
              Pencapaian Hafalan Juz 30
            </h3>
            <div className="flex justify-between items-baseline mb-2">
              <span className="text-3xl font-black text-primary">{totalMemorized} <span className="text-sm font-semibold text-slate-500">dari {surahsJuz30.length} surah</span></span>
              <span className="text-sm font-bold text-primary">{percentage}% Selesai</span>
            </div>
            <div className="w-full bg-slate-200/60 rounded-full h-2.5">
              <div className="bg-primary h-2.5 rounded-full" style={{ width: `${percentage}%` }}></div>
            </div>
          </div>

          {/* Surah List */}
          <div className="bg-white rounded-2xl p-4 shadow-sm border border-emerald-50">
            <div className="flex justify-between items-center mb-4 px-1">
              <h4 className="text-sm font-bold text-slate-800">Checklist Hafalan Surah</h4>
              <span className="text-[10px] text-slate-400 italic">Klik surah untuk detail</span>
            </div>

            <div className="grid grid-cols-2 gap-2">
              {surahsJuz30.map((surah) => {
                const record = hafalanHistory.find(
                  (h: any) => h.surah_name.toLowerCase() === surah.toLowerCase()
                );
                const status = record?.status || 'BELUM';
                const isExpanded = expandedSurah === surah;

                // Determine badge colors based on status
                const getStatusStyles = () => {
                  switch (status) {
                    case 'SEMPURNA':
                      return 'bg-emerald-50 border-emerald-100 text-primary';
                    case 'LANCAR':
                      return 'bg-blue-50 border-blue-100 text-blue-700';
                    case 'BELUM LANCAR':
                      return 'bg-amber-50 border-amber-100 text-amber-700';
                    default:
                      return 'bg-slate-50 border-slate-100 text-slate-400';
                  }
                };

                return (
                  <div key={surah} className="col-span-2">
                    <button
                      onClick={() => setExpandedSurah(isExpanded ? null : surah)}
                      type="button"
                      className={`w-full flex justify-between items-center px-4 py-3 rounded-xl border text-sm text-left transition-colors cursor-pointer ${getStatusStyles()}`}
                    >
                      <span className="font-bold flex items-center gap-2">
                        <span className="material-symbols-outlined text-[16px]">
                          {status === 'SEMPURNA' ? 'check_circle' : 
                           status === 'LANCAR' ? 'stars' : 
                           status === 'BELUM LANCAR' ? 'pending' : 'circle'}
                        </span>
                        {surah}
                      </span>
                      <span className="text-[10px] font-black uppercase tracking-wider">
                        {status === 'BELUM' ? 'Belum Hafal' : status}
                      </span>
                    </button>
                    
                    {/* Expandable details panel */}
                    {isExpanded && (
                      <div className="mt-1 p-4 rounded-xl bg-slate-50 border border-slate-100 text-xs text-slate-600 space-y-2 animate-fadeIn mx-1">
                        <div className="flex justify-between">
                          <span>Status Belajar:</span>
                          <strong className="font-semibold text-slate-800">{status === 'BELUM' ? 'Belum Hafal' : status}</strong>
                        </div>
                        {record?.created_at && (
                          <div className="flex justify-between">
                            <span>Diupdate Pada:</span>
                            <strong className="font-semibold text-slate-800">{formatDate(record.created_at)}</strong>
                          </div>
                        )}
                        <div>
                          <span>Catatan Pengajar:</span>
                          <p className="mt-1 italic text-slate-500 bg-white p-2 rounded border border-slate-100">
                            {record?.notes ? `"${record.notes}"` : 'Tidak ada catatan khusus.'}
                          </p>
                        </div>
                      </div>
                    )}
                  </div>
                );
              })}
            </div>
          </div>
        </div>
      )}

      {/* Iqro / Quran Tab */}
      {activeTab === 'iqro' && (
        <div className="bg-white rounded-2xl p-6 shadow-sm border border-emerald-50">
          <h3 className="text-lg font-bold text-slate-900 flex items-center gap-2 mb-6">
            <span className="material-symbols-outlined text-primary text-[22px]">history</span>
            Riwayat Pembelajaran Mengaji
          </h3>

          {iqroHistory.length === 0 ? (
            <p className="text-secondary text-sm text-center py-8">Belum ada riwayat perkembangan mengaji.</p>
          ) : (
            <div className="relative border-l-2 border-primary/20 pl-4 ml-2 space-y-6">
              {iqroHistory.map((item: any, idx: number) => (
                <div key={item.id || idx} className="relative">
                  {/* Timeline dot */}
                  <span className="absolute -left-[25px] top-1.5 w-3.5 h-3.5 bg-primary border-2 border-white rounded-full shadow-sm"></span>
                  
                  <div className="p-4 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                    <div className="flex justify-between items-start">
                      <span className="text-[10px] text-slate-400 font-medium">{formatDate(item.created_at)}</span>
                      <span className="bg-primary-container text-on-primary-container text-[10px] font-bold px-2 py-0.5 rounded border border-primary/10">
                        {item.level}
                      </span>
                    </div>
                    <h4 className="font-bold text-slate-900 text-sm">{item.page_surah}</h4>
                    {item.notes && (
                      <p className="text-xs text-secondary italic mt-1.5 text-slate-500 bg-white p-2.5 rounded border border-slate-100">
                        "{item.notes}"
                      </p>
                    )}
                  </div>
                </div>
              ))}
            </div>
          )}
        </div>
      )}

      {/* Sholat Tab */}
      {activeTab === 'sholat' && (
        <div className="space-y-4">
          {sholatHistory.length === 0 ? (
            <div className="bg-white rounded-2xl p-6 shadow-sm border border-emerald-50 text-center py-8">
              <p className="text-secondary text-sm">Belum ada riwayat penilaian sholat.</p>
            </div>
          ) : (
            Object.entries(sholatGrouped).map(([category, items]: [string, any]) => (
              <div key={category} className="bg-white rounded-2xl p-5 shadow-sm border border-emerald-50">
                <h4 className="font-bold text-slate-900 text-sm mb-3 flex items-center gap-1.5 pb-2 border-b border-slate-100">
                  <span className="material-symbols-outlined text-primary text-[18px]">bookmark</span>
                  {category}
                </h4>

                <div className="space-y-3">
                  {items.map((item: any) => (
                    <div key={item.id} className="p-3 bg-slate-50 border border-slate-100 rounded-xl space-y-1.5">
                      <div className="flex justify-between items-start">
                        <span className="text-sm font-bold text-slate-800">{item.item_name}</span>
                        <span className={`text-[9px] font-black px-2 py-0.5 rounded uppercase tracking-wider ${
                          item.status === 'SEMPURNA' ? 'bg-emerald-100 text-primary border border-emerald-200' :
                          item.status === 'LANCAR' ? 'bg-blue-100 text-blue-700 border border-blue-200' :
                          'bg-amber-100 text-amber-700 border border-amber-200'
                        }`}>
                          {item.status}
                        </span>
                      </div>
                      {item.notes && (
                        <p className="text-xs text-secondary italic text-slate-500 bg-white p-2 rounded border border-slate-100">
                          "{item.notes}"
                        </p>
                      )}
                    </div>
                  ))}
                </div>
              </div>
            ))
          )}
        </div>
      )}
    </div>
  );
}
