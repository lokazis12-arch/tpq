import { getStudents, getStudentClasses } from '@/lib/actions';
import SantriClient from './SantriClient';

export default async function SantriPage() {
  const students = await getStudents();
  const classes = await getStudentClasses();
  return <SantriClient initialStudents={students} classes={classes} />;
}
