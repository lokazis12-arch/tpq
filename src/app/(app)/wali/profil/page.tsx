import { getSession } from '@/lib/auth';
import { getWaliDashboard } from '@/lib/actions';
import { redirect } from 'next/navigation';
import ProfilClient from './ProfilClient';

export const metadata = {
  title: 'Profil Saya - Darul Ikhlas',
};

export default async function WaliProfilPage() {
  const session = await getSession();
  if (!session || session.role !== 'wali_santri') redirect('/login');

  const data = await getWaliDashboard(session.id);

  if (!data) {
    return (
      <div className="text-center py-20">
        <p className="text-secondary">Gagal memuat profil atau belum ada data santri.</p>
      </div>
    );
  }

  const { student, students, parent } = data;

  return (
    <ProfilClient 
      parent={parent} 
      students={students} 
      activeStudentId={student.id} 
    />
  );
}
