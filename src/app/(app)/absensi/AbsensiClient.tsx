'use client';

import { useState, useEffect } from 'react';
import { getAttendance, saveAttendance } from '@/lib/actions';

export default function AbsensiClient({ initialAttendance, classes, initialDate }: { initialAttendance: any[], classes: string[], initialDate: string }) {
  const [attendance, setAttendance] = useState(initialAttendance);
  const [date, setDate] = useState(initialDate);
  const [classFilter, setClassFilter] = useState('Semua Kelas');
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState<{ type: 'success' | 'error', text: string } | null>(null);

  // Status mapping to colors
  const statusColors: Record<string, string> = {
    'Hadir': 'bg-primary text-white border-primary',
    'Izin': 'bg-secondary text-white border-secondary',
    'Sakit': 'bg-amber-600 text-white border-amber-600',
    'Alpa': 'bg-error text-white border-error',
  };

  const handleDateChange = async (newDate: string) => {
    setDate(newDate);
    setLoading(true);
    const result = await getAttendance(newDate, classFilter);
    setAttendance(result);
    setLoading(false);
    setMessage(null);
  };

  const handleClassFilterChange = async (newClass: string) => {
    setClassFilter(newClass);
    setLoading(true);
    const result = await getAttendance(date, newClass);
    setAttendance(result);
    setLoading(false);
    setMessage(null);
  };

  const handleStatusChange = (studentId: number, newStatus: string) => {
    setAttendance(prev => prev.map(student => {
      if (student.student_id === studentId) {
        return { ...student, status: newStatus };
      }
      return student;
    }));
  };

  const handleSave = async () => {
    setLoading(true);
    setMessage(null);
    
    const records = attendance
      .filter(a => a.status) // Only save those with a status
      .map(a => ({
        studentId: a.student_id,
        date: date,
        status: a.status
      }));

    if (records.length === 0) {
      setMessage({ type: 'error', text: 'Tidak ada absensi yang diisi.' });
      setLoading(false);
      return;
    }

    const result = await saveAttendance(records);
    if (result.error) {
      setMessage({ type: 'error', text: result.error });
    } else {
      setMessage({ type: 'success', text: 'Absensi berhasil disimpan.' });
      setTimeout(() => setMessage(null), 3000);
    }
    setLoading(false);
  };

  return (
    <div className="space-y-6">
      <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
          <h2 className="text-2xl font-bold text-slate-900">Kehadiran Santri</h2>
          <p className="text-secondary text-sm">Catat absensi santri per kelas.</p>
        </div>
        
        <div className="flex gap-3 w-full md:w-auto">
          <input 
            type="date" 
            value={date} 
            onChange={(e) => handleDateChange(e.target.value)}
            className="px-4 py-2 border border-gray-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none"
          />
          <select
            value={classFilter}
            onChange={(e) => handleClassFilterChange(e.target.value)}
            className="px-4 py-2 border border-gray-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none bg-white"
          >
            <option value="Semua Kelas">Semua Kelas</option>
            {classes.map(c => <option key={c} value={c}>{c}</option>)}
          </select>
        </div>
      </div>

      {message && (
        <div className={`p-4 rounded-xl flex items-center gap-2 ${message.type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`}>
          <span className="material-symbols-outlined">{message.type === 'success' ? 'check_circle' : 'error'}</span>
          {message.text}
        </div>
      )}

      <div className="bg-white rounded-2xl shadow-sm border border-emerald-50 overflow-hidden">
        <div className="p-4 bg-surface-container-low border-b border-gray-100 flex justify-between items-center">
          <h3 className="font-semibold text-slate-900">Daftar Santri ({attendance.length})</h3>
          <button 
            onClick={handleSave}
            disabled={loading}
            className="bg-primary hover:bg-primary-container text-white px-6 py-2 rounded-xl flex items-center gap-2 font-medium transition-colors disabled:opacity-50"
          >
            <span className="material-symbols-outlined text-sm">save</span>
            {loading ? 'Menyimpan...' : 'Simpan Absensi'}
          </button>
        </div>
        
        <div className="divide-y divide-gray-100">
          {attendance.length === 0 ? (
            <div className="p-8 text-center text-secondary">
              Tidak ada santri di kelas ini.
            </div>
          ) : (
            attendance.map(student => (
              <div key={student.student_id} className="p-4 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 hover:bg-gray-50 transition-colors">
                <div className="flex items-center gap-3">
                  <div className="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                    {student.name.substring(0, 2).toUpperCase()}
                  </div>
                  <div>
                    <p className="font-medium text-gray-900">{student.name}</p>
                    <p className="text-xs text-secondary bg-gray-100 px-2 py-0.5 rounded-full inline-block mt-1">{student.class}</p>
                  </div>
                </div>
                
                <div className="flex flex-wrap gap-2 w-full md:w-auto">
                  {['Hadir', 'Izin', 'Sakit', 'Alpa'].map(status => {
                    const isActive = student.status === status;
                    return (
                      <button
                        key={status}
                        onClick={() => handleStatusChange(student.student_id, status)}
                        className={`flex-1 md:flex-none px-4 py-2 rounded-xl border text-sm font-medium transition-all ${
                          isActive 
                            ? statusColors[status] 
                            : 'bg-white border-gray-200 text-slate-900 text-gray-600 hover:bg-gray-50'
                        }`}
                      >
                        {status}
                      </button>
                    )
                  })}
                </div>
              </div>
            ))
          )}
        </div>
      </div>
    </div>
  );
}
