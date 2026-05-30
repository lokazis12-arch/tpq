import { getStudents, getProgressIqro, getProgressSholat, getProgressHafalan } from '@/lib/actions';
import ProgresClient from './ProgresClient';

export default async function ProgresPage() {
  const students = await getStudents();
  const iqroProgress = await getProgressIqro();
  const sholatProgress = await getProgressSholat();
  const hafalanProgress = await getProgressHafalan();
  
  return (
    <ProgresClient 
      students={students} 
      iqroProgress={iqroProgress} 
      sholatProgress={sholatProgress} 
      hafalanProgress={hafalanProgress}
    />
  );
}
