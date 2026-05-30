import { getAttendance, getStudentClasses } from '@/lib/actions';
import AbsensiClient from './AbsensiClient';

export default async function AbsensiPage() {
  const today = new Date().toISOString().split('T')[0];
  const attendance = await getAttendance(today);
  const classes = await getStudentClasses();
  return <AbsensiClient initialAttendance={attendance} classes={classes} initialDate={today} />;
}
