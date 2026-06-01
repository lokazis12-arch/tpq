import { sql } from '@/lib/db';
import { NextResponse } from 'next/server';

export async function GET() {
  try {
    // Clear sholat assessments
    const sholatResult = await sql`DELETE FROM progress_sholat`;

    // Clear hafalan assessments
    const hafalanResult = await sql`DELETE FROM progress_hafalan`;

    // Clear old attendance records before June 1st, 2026
    const attendanceResult = await sql`DELETE FROM attendance WHERE date < '2026-06-01'`;

    return NextResponse.json({
      message: 'Database cleanup completed successfully.',
      sholat_cleared: sholatResult.rowCount,
      hafalan_cleared: hafalanResult.rowCount,
      attendance_cleared: attendanceResult.rowCount
    });
  } catch (error: any) {
    return NextResponse.json({ error: error.message }, { status: 500 });
  }
}
