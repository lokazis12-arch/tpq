import { getSession } from '@/lib/auth';
import { getWaliDashboard, getProgressIqro } from '@/lib/actions';
import { redirect } from 'next/navigation';
import LaporanClient from './LaporanClient';

export const metadata = {
  title: 'Laporan Perkembangan - Darul Ikhlas',
};

export default async function WaliLaporanPage() {
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

  const { student, sholatProgress, hafalanProgress } = data;
  
  // Fetch full iqro progress history for this child
  const iqroHistory = await getProgressIqro(student.id);

  return (
    <LaporanClient 
      studentName={student.name}
      iqroHistory={iqroHistory} 
      sholatHistory={sholatProgress} 
      hafalanHistory={hafalanProgress} 
    />
  );
}
