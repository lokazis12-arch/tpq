'use client';

import { useState } from 'react';
import { addStudent, updateStudent, deleteStudent, getStudents } from '@/lib/actions';

export default function SantriClient({ initialStudents, classes }: { initialStudents: any[], classes: string[] }) {
  const [students, setStudents] = useState(initialStudents);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [modalMode, setModalMode] = useState<'add' | 'edit'>('add');
  const [selectedStudent, setSelectedStudent] = useState<any>(null);
  
  const [search, setSearch] = useState('');
  const [classFilter, setClassFilter] = useState('Semua');
  
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState<{ type: 'success' | 'error', text: string } | null>(null);

  const handleSearch = async (e?: React.FormEvent) => {
    if (e) e.preventDefault();
    const result = await getStudents(search, classFilter);
    setStudents(result);
  };

  const openAddModal = () => {
    setModalMode('add');
    setSelectedStudent(null);
    setIsModalOpen(true);
    setMessage(null);
  };

  const openEditModal = (student: any) => {
    setModalMode('edit');
    setSelectedStudent(student);
    setIsModalOpen(true);
    setMessage(null);
  };

  const closeModal = () => {
    setIsModalOpen(false);
  };

  const handleSubmit = async (formData: FormData) => {
    setLoading(true);
    setMessage(null);
    let result: any;

    if (modalMode === 'add') {
      result = await addStudent(formData);
    } else {
      formData.append('id', selectedStudent.id);
      result = await updateStudent(formData);
    }

    if (result?.error) {
      setMessage({ type: 'error', text: result.error });
    } else {
      setMessage({ 
        type: 'success', 
        text: modalMode === 'add' 
          ? `Santri berhasil ditambahkan. Akun Wali: ${result?.email}` 
          : 'Data santri berhasil diubah.' 
      });
      setTimeout(() => {
        closeModal();
        handleSearch();
      }, 2000);
    }
    setLoading(false);
  };

  const handleDelete = async (id: number, name: string) => {
    if (confirm(`Apakah Anda yakin ingin menghapus santri ${name}? Data absen dan SPP juga akan terhapus.`)) {
      const result = await deleteStudent(id);
      if (result.error) {
        alert(result.error);
      } else {
        handleSearch();
      }
    }
  };

  return (
    <div className="space-y-6">
      <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
          <h2 className="text-2xl font-bold text-slate-900">Manajemen Santri</h2>
          <p className="text-secondary text-sm">Total {students.length} santri terdaftar</p>
        </div>
        <button 
          onClick={openAddModal}
          className="bg-primary hover:bg-primary-container text-white px-4 py-2 rounded-xl flex items-center gap-2 font-medium shadow-sm transition-colors"
        >
          <span className="material-symbols-outlined">person_add</span>
          Tambah Santri
        </button>
      </div>

      <div className="bg-white rounded-2xl p-4 shadow-sm border border-emerald-50">
        <form onSubmit={handleSearch} className="flex flex-col md:flex-row gap-4">
          <div className="flex-grow relative">
            <span className="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-secondary">search</span>
            <input 
              type="text" 
              placeholder="Cari nama santri..." 
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              className="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-200 text-slate-900 focus:border-primary focus:ring-1 focus:ring-primary outline-none"
            />
          </div>
          <select 
            value={classFilter}
            onChange={(e) => {
              setClassFilter(e.target.value);
            }}
            className="px-4 py-2 rounded-xl border border-gray-200 text-slate-900 focus:border-primary focus:ring-1 focus:ring-primary outline-none bg-white"
          >
            <option value="Semua">Semua Kelas</option>
            {classes.map(c => (
              <option key={c} value={c}>{c}</option>
            ))}
          </select>
          <button type="submit" className="bg-surface-container-low text-slate-900 px-6 py-2 rounded-xl hover:bg-primary-container/50 font-medium transition-colors border border-slate-200">
            Filter
          </button>
        </form>
      </div>

      <div className="bg-white rounded-2xl shadow-sm border border-emerald-50 overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full text-left border-collapse">
            <thead>
              <tr className="bg-surface-container-low text-slate-900 text-sm">
                <th className="px-6 py-4 font-semibold">Santri</th>
                <th className="px-6 py-4 font-semibold">Kelas</th>
                <th className="px-6 py-4 font-semibold">Kontak Wali</th>
                <th className="px-6 py-4 font-semibold">Alamat</th>
                <th className="px-6 py-4 font-semibold text-right">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-gray-100">
              {students.length === 0 ? (
                <tr>
                  <td colSpan={5} className="px-6 py-12 text-center text-secondary">
                    Tidak ada data santri ditemukan.
                  </td>
                </tr>
              ) : (
                students.map((student) => (
                  <tr key={student.id} className="hover:bg-gray-50 transition-colors">
                    <td className="px-6 py-4">
                      <div className="flex items-center gap-3">
                        <div className="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm">
                          {student.name.substring(0, 2).toUpperCase()}
                        </div>
                        <span className="font-medium text-gray-900">{student.name}</span>
                      </div>
                    </td>
                    <td className="px-6 py-4 text-sm text-gray-600">
                      <span className="bg-primary-container/50 text-primary px-2 py-1 rounded border border-slate-200 text-xs font-semibold">
                        {student.class}
                      </span>
                    </td>
                    <td className="px-6 py-4 text-sm">
                      <p className="font-medium text-gray-800">{student.parent_name}</p>
                      <p className="text-secondary text-xs">{student.phone || '-'}</p>
                    </td>
                    <td className="px-6 py-4 text-sm text-gray-600 max-w-[200px] truncate" title={student.address}>
                      {student.address || '-'}
                    </td>
                    <td className="px-6 py-4 text-right">
                      <button onClick={() => openEditModal(student)} className="text-blue-600 hover:bg-blue-50 p-2 rounded-lg transition-colors mr-1">
                        <span className="material-symbols-outlined text-[20px]">edit</span>
                      </button>
                      <button onClick={() => handleDelete(student.id, student.name)} className="text-error hover:bg-red-50 p-2 rounded-lg transition-colors">
                        <span className="material-symbols-outlined text-[20px]">delete</span>
                      </button>
                    </td>
                  </tr>
                ))
              )}
            </tbody>
          </table>
        </div>
      </div>

      {isModalOpen && (
        <div className="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
          <div className="bg-white rounded-2xl shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto">
            <div className="p-6">
              <div className="flex justify-between items-center mb-6">
                <h3 className="text-xl font-bold text-slate-900">
                  {modalMode === 'add' ? 'Tambah Santri' : 'Edit Santri'}
                </h3>
                <button onClick={closeModal} className="text-gray-400 hover:bg-gray-100 p-1 rounded-full transition-colors">
                  <span className="material-symbols-outlined">close</span>
                </button>
              </div>

              {message && (
                <div className={`p-3 rounded-xl text-sm mb-4 ${message.type === 'error' ? 'bg-error-container text-error' : 'bg-green-100 text-green-800'}`}>
                  {message.text}
                </div>
              )}

              <form action={handleSubmit} className="space-y-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                  <input type="text" name="name" defaultValue={selectedStudent?.name} required className="w-full px-4 py-2 border border-gray-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none" />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                  <input type="text" name="class" defaultValue={selectedStudent?.class} required className="w-full px-4 py-2 border border-gray-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none" />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">Nama Wali Santri</label>
                  <input type="text" name="parent_name" defaultValue={selectedStudent?.parent_name} placeholder="Contoh: Bpk. Budi" className="w-full px-4 py-2 border border-gray-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none" />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">Nomor WA Wali</label>
                  <input type="text" name="phone" defaultValue={selectedStudent?.phone} className="w-full px-4 py-2 border border-gray-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none" />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                  <textarea name="address" defaultValue={selectedStudent?.address} rows={2} className="w-full px-4 py-2 border border-gray-200 text-slate-900 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none"></textarea>
                </div>
                
                <div className="pt-4 flex gap-3">
                  <button type="button" onClick={closeModal} className="flex-1 bg-gray-100 text-gray-700 py-3 rounded-xl font-medium hover:bg-gray-200 transition-colors">
                    Batal
                  </button>
                  <button type="submit" disabled={loading} className="flex-1 bg-primary text-white py-3 rounded-xl font-medium hover:bg-primary-container disabled:opacity-70 transition-colors">
                    {loading ? 'Menyimpan...' : 'Simpan'}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}
