'use server';

import { sql } from './db';
import { revalidatePath } from 'next/cache';
import { createSession, destroySession } from './auth';
import { redirect } from 'next/navigation';
import { cookies } from 'next/headers';
import fs from 'fs';
import path from 'path';

// ─── AUTH ACTIONS ────────────────────────────────────────────────

export async function loginAction(formData: FormData) {
  const email = formData.get('email') as string;
  const password = formData.get('password') as string;

  if (!email || !password) {
    return { error: 'Email dan password harus diisi.' };
  }

  try {
    const result = await sql`
      SELECT id, name, email, password, role FROM users WHERE email = ${email}
    `;

    if (result.rows.length === 0) {
      return { error: 'Email tidak ditemukan.' };
    }

    const user = result.rows[0];

    if (user.password !== password) {
      return { error: 'Password salah.' };
    }

    await createSession({
      id: user.id,
      name: user.name,
      email: user.email,
      role: user.role,
    });

    return { success: true, role: user.role };
  } catch (error: any) {
    console.error('Login error:', error);
    return { error: 'Terjadi kesalahan. Coba lagi.' };
  }
}

export async function logoutAction() {
  await destroySession();
  redirect('/login');
}

// ─── STUDENT ACTIONS ────────────────────────────────────────────

export async function getStudents(search?: string, classFilter?: string) {
  try {
    let result;
    if (search && classFilter && classFilter !== 'Semua') {
      const searchTerm = `%${search}%`;
      result = await sql`
        SELECT * FROM students WHERE name ILIKE ${searchTerm} AND class = ${classFilter} ORDER BY name ASC
      `;
    } else if (search) {
      const searchTerm = `%${search}%`;
      result = await sql`
        SELECT * FROM students WHERE name ILIKE ${searchTerm} ORDER BY name ASC
      `;
    } else if (classFilter && classFilter !== 'Semua') {
      result = await sql`
        SELECT * FROM students WHERE class = ${classFilter} ORDER BY name ASC
      `;
    } else {
      result = await sql`SELECT * FROM students ORDER BY name ASC`;
    }
    return result.rows;
  } catch (error) {
    console.error('Error fetching students:', error);
    return [];
  }
}

export async function getStudentClasses() {
  try {
    const result = await sql`SELECT DISTINCT class FROM students ORDER BY class ASC`;
    return result.rows.map((r: any) => r.class);
  } catch (error) {
    console.error('Error fetching classes:', error);
    return [];
  }
}

export async function addStudent(formData: FormData) {
  const name = formData.get('name') as string;
  const studentClass = formData.get('class') as string;
  const address = formData.get('address') as string;
  const parentName = formData.get('parent_name') as string;
  const phone = formData.get('phone') as string;

  if (!name) return { error: 'Nama harus diisi.' };

  try {
    // Create wali_santri user account
    const username = name.toLowerCase().replace(/[^a-z]/g, '');
    const email = `${username}@tpq.com`;

    const userResult = await sql`
      INSERT INTO users (name, email, password, role)
      VALUES (${name}, ${email}, 'password123', 'wali_santri')
      RETURNING id;
    `;
    const waliId = userResult.rows[0].id;

    await sql`
      INSERT INTO students (wali_santri_id, name, class, address, parent_name, phone)
      VALUES (${waliId}, ${name}, ${studentClass}, ${address}, ${parentName || 'Bpk/Ibu ' + name.split(' ')[0]}, ${phone})
    `;
    revalidatePath('/santri');
    return { success: true, email };
  } catch (error: any) {
    console.error('Error adding student:', error);
    return { error: error.message || 'Gagal menambah santri.' };
  }
}

export async function updateStudent(formData: FormData) {
  const id = formData.get('id') as string;
  const name = formData.get('name') as string;
  const studentClass = formData.get('class') as string;
  const address = formData.get('address') as string;
  const parentName = formData.get('parent_name') as string;
  const phone = formData.get('phone') as string;

  if (!id || !name) return { error: 'Data tidak valid.' };

  try {
    await sql`
      UPDATE students SET name = ${name}, class = ${studentClass}, address = ${address}, parent_name = ${parentName}, phone = ${phone}
      WHERE id = ${parseInt(id)}
    `;
    revalidatePath('/santri');
    return { success: true };
  } catch (error: any) {
    console.error('Error updating student:', error);
    return { error: error.message || 'Gagal mengubah data santri.' };
  }
}

export async function deleteStudent(id: number) {
  try {
    // Get wali_santri_id before deleting
    const student = await sql`SELECT wali_santri_id FROM students WHERE id = ${id}`;
    
    await sql`DELETE FROM students WHERE id = ${id}`;
    
    // Also delete the wali_santri user account
    if (student.rows[0]?.wali_santri_id) {
      await sql`DELETE FROM users WHERE id = ${student.rows[0].wali_santri_id}`;
    }
    
    revalidatePath('/santri');
    return { success: true };
  } catch (error: any) {
    console.error('Error deleting student:', error);
    return { error: error.message || 'Gagal menghapus santri.' };
  }
}

// ─── ATTENDANCE ACTIONS ─────────────────────────────────────────

export async function getAttendance(date: string, classFilter?: string) {
  try {
    let result;
    if (classFilter && classFilter !== 'Semua Kelas') {
      result = await sql`
        SELECT s.id as student_id, s.name, s.class, a.status, a.id as attendance_id
        FROM students s
        LEFT JOIN attendance a ON s.id = a.student_id AND a.date = ${date}
        WHERE s.class = ${classFilter}
        ORDER BY s.name ASC
      `;
    } else {
      result = await sql`
        SELECT s.id as student_id, s.name, s.class, a.status, a.id as attendance_id
        FROM students s
        LEFT JOIN attendance a ON s.id = a.student_id AND a.date = ${date}
        ORDER BY s.name ASC
      `;
    }
    return result.rows;
  } catch (error) {
    console.error('Error fetching attendance:', error);
    return [];
  }
}

export async function saveAttendance(records: { studentId: number; date: string; status: string }[]) {
  try {
    for (const record of records) {
      // Upsert: delete existing then insert
      await sql`
        DELETE FROM attendance WHERE student_id = ${record.studentId} AND date = ${record.date}
      `;
      await sql`
        INSERT INTO attendance (student_id, date, status)
        VALUES (${record.studentId}, ${record.date}, ${record.status})
      `;
    }
    revalidatePath('/absensi');
    return { success: true };
  } catch (error: any) {
    console.error('Error saving attendance:', error);
    return { error: error.message || 'Gagal menyimpan absensi.' };
  }
}

// ─── PAYMENT ACTIONS ────────────────────────────────────────────

export async function getDashboardStats() {
  try {
    const totalStudents = await sql`SELECT COUNT(*) as count FROM students`;
    const paidResult = await sql`
      SELECT COUNT(*) as count, COALESCE(SUM(amount), 0) as total 
      FROM spp_payments WHERE status = 'Lunas'
    `;
    const unpaidResult = await sql`
      SELECT COUNT(*) as count, COALESCE(SUM(amount), 0) as total 
      FROM spp_payments WHERE status = 'Belum Bayar'
    `;
    const totalPayments = await sql`SELECT COUNT(*) as count FROM spp_payments`;

    const paid = Number(paidResult.rows[0].count);
    const total = Number(totalPayments.rows[0].count);
    const percentage = total > 0 ? Math.round((paid / total) * 100) : 0;

    return {
      totalStudents: Number(totalStudents.rows[0].count),
      paidCount: paid,
      paidTotal: Number(paidResult.rows[0].total),
      unpaidCount: Number(unpaidResult.rows[0].count),
      unpaidTotal: Number(unpaidResult.rows[0].total),
      percentage,
    };
  } catch (error) {
    console.error('Error fetching dashboard stats:', error);
    return { totalStudents: 0, paidCount: 0, paidTotal: 0, unpaidCount: 0, unpaidTotal: 0, percentage: 0 };
  }
}

export async function getPaymentsByMonth(month: string, year: number) {
  try {
    const result = await sql`
      SELECT sp.*, s.name as student_name, s.class as student_class
      FROM spp_payments sp
      JOIN students s ON sp.student_id = s.id
      WHERE sp.month = ${month} AND sp.year = ${year}
      ORDER BY s.name ASC
    `;
    return result.rows;
  } catch (error) {
    console.error('Error fetching payments:', error);
    return [];
  }
}

export async function recordPayment(formData: FormData) {
  const studentId = parseInt(formData.get('student_id') as string);
  const month = formData.get('month') as string;
  const year = parseInt(formData.get('year') as string);
  const amount = parseInt(formData.get('amount') as string);
  const paymentType = (formData.get('payment_type') as string) || 'SPP';

  if (!studentId || !month || !year || !amount) return { error: 'Data tidak lengkap.' };

  try {
    // Check if payment already exists
    const existing = await sql`
      SELECT id FROM spp_payments 
      WHERE student_id = ${studentId} AND month = ${month} AND year = ${year} AND payment_type = ${paymentType}
    `;

    if (existing.rows.length > 0) {
      await sql`
        UPDATE spp_payments SET amount = ${amount}, status = 'Lunas', payment_date = NOW()
        WHERE student_id = ${studentId} AND month = ${month} AND year = ${year} AND payment_type = ${paymentType}
      `;
    } else {
      await sql`
        INSERT INTO spp_payments (student_id, month, year, amount, payment_date, status, payment_type)
        VALUES (${studentId}, ${month}, ${year}, ${amount}, NOW(), 'Lunas', ${paymentType})
      `;
    }

    revalidatePath('/bayar');
    revalidatePath('/');
    return { success: true };
  } catch (error: any) {
    console.error('Error recording payment:', error);
    return { error: error.message || 'Gagal mencatat pembayaran.' };
  }
}

export async function togglePaymentStatus(
  studentId: number,
  month: string,
  year: number,
  paymentType: string,
  newStatus: 'Lunas' | 'Belum Bayar',
  amount: number = 50000
) {
  if (!studentId || !month || !year || !paymentType) {
    return { error: 'Data tidak lengkap.' };
  }

  try {
    // Check if payment already exists
    const existing = await sql`
      SELECT id FROM spp_payments 
      WHERE student_id = ${studentId} AND month = ${month} AND year = ${year} AND payment_type = ${paymentType}
    `;

    if (newStatus === 'Lunas') {
      if (existing.rows.length > 0) {
        await sql`
          UPDATE spp_payments 
          SET amount = ${amount}, status = 'Lunas', payment_date = NOW()
          WHERE student_id = ${studentId} AND month = ${month} AND year = ${year} AND payment_type = ${paymentType}
        `;
      } else {
        await sql`
          INSERT INTO spp_payments (student_id, month, year, amount, payment_date, status, payment_type)
          VALUES (${studentId}, ${month}, ${year}, ${amount}, NOW(), 'Lunas', ${paymentType})
        `;
      }
    } else {
      // Mark as 'Belum Bayar'
      if (existing.rows.length > 0) {
        await sql`
          UPDATE spp_payments 
          SET amount = ${amount}, status = 'Belum Bayar', payment_date = NULL
          WHERE student_id = ${studentId} AND month = ${month} AND year = ${year} AND payment_type = ${paymentType}
        `;
      } else {
        await sql`
          INSERT INTO spp_payments (student_id, month, year, amount, payment_date, status, payment_type)
          VALUES (${studentId}, ${month}, ${year}, ${amount}, NULL, 'Belum Bayar', ${paymentType})
        `;
      }
    }

    revalidatePath('/bayar');
    revalidatePath('/');
    return { success: true };
  } catch (error: any) {
    console.error('Error toggling payment status:', error);
    return { error: error.message || 'Gagal mengubah status pembayaran.' };
  }
}

export async function getRecentPayments(limit: number = 10) {
  try {
    const result = await sql`
      SELECT sp.*, s.name as student_name, s.class as student_class
      FROM spp_payments sp
      JOIN students s ON sp.student_id = s.id
      WHERE sp.status = 'Lunas'
      ORDER BY sp.payment_date DESC
      LIMIT ${limit}
    `;
    return result.rows;
  } catch (error) {
    console.error('Error fetching recent payments:', error);
    return [];
  }
}

// ─── PROGRESS ACTIONS ───────────────────────────────────────────

export async function getProgressIqro(studentId?: number) {
  try {
    let result;
    if (studentId) {
      result = await sql`
        SELECT p.*, s.name as student_name, s.class as student_class
        FROM progress_iqro_quran p
        JOIN students s ON p.student_id = s.id
        WHERE p.student_id = ${studentId}
        ORDER BY p.created_at DESC
      `;
    } else {
      result = await sql`
        SELECT p.*, s.name as student_name, s.class as student_class
        FROM progress_iqro_quran p
        JOIN students s ON p.student_id = s.id
        ORDER BY p.created_at DESC
      `;
    }
    return result.rows;
  } catch (error) {
    console.error('Error fetching iqro progress:', error);
    return [];
  }
}

export async function saveProgressIqro(formData: FormData) {
  const studentId = parseInt(formData.get('student_id') as string);
  const level = formData.get('level') as string;
  const pageSurah = formData.get('page_surah') as string;
  const notes = formData.get('notes') as string;

  if (!studentId || !level || !pageSurah) return { error: 'Data tidak lengkap.' };

  try {
    await sql`
      INSERT INTO progress_iqro_quran (student_id, level, page_surah, notes)
      VALUES (${studentId}, ${level}, ${pageSurah}, ${notes})
    `;
    revalidatePath('/progres');
    return { success: true };
  } catch (error: any) {
    console.error('Error saving iqro progress:', error);
    return { error: error.message || 'Gagal menyimpan progres.' };
  }
}

export async function getProgressSholat(studentId?: number) {
  try {
    let result;
    if (studentId) {
      result = await sql`
        SELECT p.*, s.name as student_name, s.class as student_class
        FROM progress_sholat p
        JOIN students s ON p.student_id = s.id
        WHERE p.student_id = ${studentId}
        ORDER BY p.created_at DESC
      `;
    } else {
      result = await sql`
        SELECT p.*, s.name as student_name, s.class as student_class
        FROM progress_sholat p
        JOIN students s ON p.student_id = s.id
        ORDER BY p.created_at DESC
      `;
    }
    return result.rows;
  } catch (error) {
    console.error('Error fetching sholat progress:', error);
    return [];
  }
}

export async function saveProgressSholat(formData: FormData) {
  const studentId = parseInt(formData.get('student_id') as string);
  const category = formData.get('category') as string;
  const itemName = formData.get('item_name') as string;
  const status = formData.get('status') as string;
  const notes = formData.get('notes') as string;

  if (!studentId || !category || !itemName || !status) return { error: 'Data tidak lengkap.' };

  try {
    // Upsert: update if exists, insert if not
    const existing = await sql`
      SELECT id FROM progress_sholat WHERE student_id = ${studentId} AND item_name = ${itemName}
    `;

    if (existing.rows.length > 0) {
      await sql`
        UPDATE progress_sholat SET status = ${status}, notes = ${notes}, category = ${category}, created_at = NOW()
        WHERE student_id = ${studentId} AND item_name = ${itemName}
      `;
    } else {
      await sql`
        INSERT INTO progress_sholat (student_id, category, item_name, status, notes)
        VALUES (${studentId}, ${category}, ${itemName}, ${status}, ${notes})
      `;
    }
    revalidatePath('/progres');
    return { success: true };
  } catch (error: any) {
    console.error('Error saving sholat progress:', error);
    return { error: error.message || 'Gagal menyimpan progres.' };
  }
}

// ─── WALI SANTRI ACTIONS ────────────────────────────────────────

export async function getWaliDashboard(userId: number, studentId?: number) {
  try {
    // Get all student(s) linked to this wali
    const studentsResult = await sql`
      SELECT * FROM students WHERE wali_santri_id = ${userId}
    `;
    const students = studentsResult.rows;

    if (students.length === 0) return null;

    // Fetch parent profile info
    const parentResult = await sql`
      SELECT id, name, email, phone, avatar_url FROM users WHERE id = ${userId}
    `;
    const parent = parentResult.rows[0] || null;

    // Determine which student is selected
    let selectedStudent = students[0];
    if (studentId) {
      const match = students.find((s: any) => s.id === studentId);
      if (match) selectedStudent = match;
    } else {
      const cookieStore = await cookies();
      const cookieVal = cookieStore.get('selected_student_id')?.value;
      if (cookieVal) {
        const parsedId = parseInt(cookieVal);
        const match = students.find((s: any) => s.id === parsedId);
        if (match) selectedStudent = match;
      }
    }

    const currentStudentId = selectedStudent.id;

    // Get attendance summary (last 30 days)
    const thirtyDaysAgo = new Date();
    thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);
    const dateString = thirtyDaysAgo.toISOString().split('T')[0];

    const attendance = await sql`
      SELECT status, COUNT(*) as count FROM attendance 
      WHERE student_id = ${currentStudentId} AND date >= ${dateString}
      GROUP BY status
    `;

    // Get latest SPP payment
    const payment = await sql`
      SELECT * FROM spp_payments WHERE student_id = ${currentStudentId}
      ORDER BY year DESC, created_at DESC LIMIT 3
    `;

    // Get iqro progress
    const iqro = await sql`
      SELECT * FROM progress_iqro_quran WHERE student_id = ${currentStudentId}
      ORDER BY created_at DESC LIMIT 1
    `;

    // Get sholat progress
    const sholat = await sql`
      SELECT * FROM progress_sholat WHERE student_id = ${currentStudentId}
      ORDER BY created_at DESC
    `;

    // Get recent attendance
    const recentAttendance = await sql`
      SELECT * FROM attendance WHERE student_id = ${currentStudentId}
      ORDER BY date DESC LIMIT 10
    `;

    // Get hafalan progress
    const hafalan = await sql`
      SELECT * FROM progress_hafalan WHERE student_id = ${currentStudentId}
      ORDER BY created_at DESC
    `;

    return {
      student: selectedStudent,
      students: students,
      parent: parent,
      attendanceSummary: attendance.rows,
      payments: payment.rows,
      iqroProgress: iqro.rows[0] || null,
      sholatProgress: sholat.rows,
      recentAttendance: recentAttendance.rows,
      hafalanProgress: hafalan.rows,
    };
  } catch (error) {
    console.error('Error fetching wali dashboard:', error);
    return null;
  }
}

export async function selectStudentAction(studentId: number) {
  const cookieStore = await cookies();
  cookieStore.set('selected_student_id', studentId.toString(), {
    httpOnly: true,
    secure: process.env.NODE_ENV === 'production',
    sameSite: 'lax',
    path: '/',
    maxAge: 60 * 60 * 24 * 30, // 30 days
  });
  revalidatePath('/wali');
  revalidatePath('/wali/laporan');
  revalidatePath('/wali/presensi');
  revalidatePath('/wali/profil');
  return { success: true };
}

export async function saveProgressHafalan(formData: FormData) {
  const studentId = parseInt(formData.get('student_id') as string);
  const surahName = formData.get('surah_name') as string;
  const status = formData.get('status') as string;
  const notes = formData.get('notes') as string;

  if (!studentId || !surahName || !status) return { error: 'Data tidak lengkap.' };

  try {
    const existing = await sql`
      SELECT id FROM progress_hafalan WHERE student_id = ${studentId} AND surah_name = ${surahName}
    `;

    if (existing.rows.length > 0) {
      await sql`
        UPDATE progress_hafalan SET status = ${status}, notes = ${notes}, created_at = CURRENT_TIMESTAMP
        WHERE student_id = ${studentId} AND surah_name = ${surahName}
      `;
    } else {
      await sql`
        INSERT INTO progress_hafalan (student_id, surah_name, status, notes)
        VALUES (${studentId}, ${surahName}, ${status}, ${notes})
      `;
    }
    revalidatePath('/progres');
    revalidatePath('/wali');
    return { success: true };
  } catch (error: any) {
    console.error('Error saving hafalan progress:', error);
    return { error: error.message || 'Gagal menyimpan progres hafalan.' };
  }
}

export async function updateWaliProfile(formData: FormData, userId: number) {
  const name = formData.get('name') as string;
  const phone = formData.get('phone') as string;
  const currentPassword = formData.get('current_password') as string;
  const newPassword = formData.get('new_password') as string;
  const confirmPassword = formData.get('confirm_password') as string;

  if (!name) return { error: 'Nama harus diisi.' };

  try {
    const userResult = await sql`
      SELECT password FROM users WHERE id = ${userId}
    `;
    const user = userResult.rows[0];

    if (currentPassword || newPassword || confirmPassword) {
      if (!currentPassword || !newPassword || !confirmPassword) {
        return { error: 'Semua field password harus diisi untuk mengubah password.' };
      }
      if (user.password !== currentPassword) {
        return { error: 'Password saat ini salah.' };
      }
      if (newPassword.length < 8) {
        return { error: 'Password baru minimal 8 karakter.' };
      }
      if (newPassword !== confirmPassword) {
        return { error: 'Konfirmasi password baru tidak cocok.' };
      }

      await sql`
        UPDATE users SET name = ${name}, phone = ${phone}, password = ${newPassword} WHERE id = ${userId}
      `;
    } else {
      await sql`
        UPDATE users SET name = ${name}, phone = ${phone} WHERE id = ${userId}
      `;
    }

    revalidatePath('/wali/profil');
    revalidatePath('/wali');
    return { success: true };
  } catch (error: any) {
    console.error('Error updating profile:', error);
    return { error: error.message || 'Gagal memperbarui profil.' };
  }
}

export async function uploadAvatarAction(formData: FormData, userId: number) {
  const file = formData.get('avatar') as any;
  if (!file || file.size === 0) return { error: 'File tidak ditemukan.' };

  const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/jpg'];
  if (!validTypes.includes(file.type)) {
    return { error: 'Format file tidak didukung. Gunakan JPG, GIF, atau PNG.' };
  }

  if (file.size > 2 * 1024 * 1024) {
    return { error: 'Ukuran file melebihi batas 2MB.' };
  }

  try {
    const bytes = await file.arrayBuffer();
    const buffer = Buffer.from(bytes);

    const uploadDir = path.join(process.cwd(), 'public', 'uploads');
    if (!fs.existsSync(uploadDir)) {
      fs.mkdirSync(uploadDir, { recursive: true });
    }

    const filename = `avatar_${userId}_${Date.now()}${path.extname(file.name)}`;
    const filePath = path.join(uploadDir, filename);

    fs.writeFileSync(filePath, buffer);
    const avatarUrl = `/uploads/${filename}`;

    await sql`
      UPDATE users SET avatar_url = ${avatarUrl} WHERE id = ${userId}
    `;

    revalidatePath('/wali/profil');
    revalidatePath('/wali');
    return { success: true, avatarUrl };
  } catch (error: any) {
    console.error('Error uploading avatar:', error);
    return { error: 'Gagal mengunggah foto profil.' };
  }
}

export async function getStudentCount() {
  try {
    const result = await sql`SELECT COUNT(*) as count FROM students`;
    return Number(result.rows[0].count);
  } catch {
    return 0;
  }
}

export async function getAttendanceSummaryToday() {
  try {
    const today = new Date().toISOString().split('T')[0];
    const result = await sql`
      SELECT status, COUNT(*) as count FROM attendance
      WHERE date = ${today}
      GROUP BY status
    `;
    return result.rows;
  } catch {
    return [];
  }
}

export async function getPaymentStatusReport(month: string, year: number, paymentType: string) {
  try {
    const studentsResult = await sql`SELECT id, name, class FROM students ORDER BY name ASC`;
    const students = studentsResult.rows;

    let paymentsResult;
    if (paymentType === 'Daftar Ulang') {
      // Check if they paid at all during the selected year
      paymentsResult = await sql`
        SELECT student_id, amount, payment_date, status, month
        FROM spp_payments 
        WHERE year = ${year} AND payment_type = 'Daftar Ulang' AND status = 'Lunas'
      `;
    } else {
      // Check if they paid for the specific month/year
      paymentsResult = await sql`
        SELECT student_id, amount, payment_date, status
        FROM spp_payments 
        WHERE month = ${month} AND year = ${year} AND payment_type = 'SPP' AND status = 'Lunas'
      `;
    }
    const payments = paymentsResult.rows;

    // Map students with their payment status
    const report = students.map((student: any) => {
      const payment = payments.find((p: any) => p.student_id === student.id);
      return {
        studentId: student.id,
        studentName: student.name,
        studentClass: student.class,
        status: payment ? 'Lunas' : 'Belum Bayar',
        amount: payment ? Number(payment.amount) : 0,
        paymentDate: payment ? payment.payment_date : null,
        paymentMonth: payment ? payment.month : null,
      };
    });

    return report;
  } catch (error) {
    console.error('Error generating payment report:', error);
    return [];
  }
}

export async function getProgressHafalan(studentId?: number) {
  try {
    let result;
    if (studentId) {
      result = await sql`
        SELECT p.*, s.name as student_name, s.class as student_class
        FROM progress_hafalan p
        JOIN students s ON p.student_id = s.id
        WHERE p.student_id = ${studentId}
        ORDER BY p.created_at DESC
      `;
    } else {
      result = await sql`
        SELECT p.*, s.name as student_name, s.class as student_class
        FROM progress_hafalan p
        JOIN students s ON p.student_id = s.id
        ORDER BY p.created_at DESC
      `;
    }
    return result.rows;
  } catch (error) {
    console.error('Error fetching hafalan progress:', error);
    return [];
  }
}
