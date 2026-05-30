import { getStudents, getRecentPayments } from '@/lib/actions';
import BayarClient from './BayarClient';

export default async function BayarPage() {
  const students = await getStudents();
  const recentPayments = await getRecentPayments(5);
  return <BayarClient students={students} recentPayments={recentPayments} />;
}
