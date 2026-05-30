import { getStudents, getProgressIqro, getProgressSholat } from '@/lib/actions';
import ProgresClient from './ProgresClient';

export default async function ProgresPage() {
  const students = await getStudents();
  const iqroProgress = await getProgressIqro();
  const sholatProgress = await getProgressSholat();
  
  return (
    <ProgresClient 
      students={students} 
      iqroProgress={iqroProgress} 
      sholatProgress={sholatProgress} 
    />
  );
}
