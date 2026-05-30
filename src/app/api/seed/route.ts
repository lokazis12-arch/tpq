import { sql } from '@/lib/db';
import { NextResponse } from 'next/server';

const santriList = [
  { name: 'Aban Azhari', class: "Al-Qur'an", address: 'KBS', phone: '' },
  { name: 'Adreena Keysha', class: "Iqra' 1", address: 'Griya Taman Sari', phone: '081234567890' },
  { name: 'Ah. Alif Rizki', class: "Al-Qur'an", address: 'KBS', phone: '' },
  { name: 'Ahmad Zakwan Razik', class: "Al-Qur'an", address: 'KBS', phone: '' },
  { name: 'Ain Al Qadri', class: "Al-Qur'an", address: 'KBS', phone: '' },
  { name: 'Annisa Shezan Qaisra', class: "Al-Qur'an", address: 'Griya Taman Sari', phone: '081234567891' },
  { name: 'Anggun Firmansyah', class: "Iqra' 6", address: 'Griya Taman Sari', phone: '' },
  { name: 'M. Ar Royan Alfa Rizki', class: 'IQRO', address: 'KBS', phone: '081234567892' },
  { name: 'Asraf Ghani Al Qadri', class: "Al-Qur'an", address: 'KBS', phone: '081234567893' },
  { name: 'Azka Aulia', class: "Iqra' 5", address: 'KBS', phone: '' },
  { name: 'Bela Nursafitri', class: "Iqra' 5", address: 'GTS', phone: '081234567894' },
  { name: 'Datu Arkanel Reyhan', class: "Al-Qur'an", address: 'GTS', phone: '' },
  { name: 'Dimas Maulana', class: "Al-Qur'an", address: 'KBS', phone: '081234567895' },
  { name: 'Faiz Akbar Maulidi', class: 'Iqra 5', address: 'KBS', phone: '081234567896' },
  { name: 'Farzana Al-Mahira', class: "Iqra' 3", address: 'GTS', phone: '081234567897' },
  { name: 'Fatih Ali Muslim', class: "Al-Qur'an", address: 'KBS', phone: '081234567898' },
  { name: 'Fatimah Az Zahra', class: "Al-Qur'an", address: 'KBS', phone: '081234567899' },
  { name: 'Halan Dwi Firmansyah', class: 'Iqra 4', address: 'GTS', phone: '081234567800' },
  { name: 'Haekal', class: 'Iqra 3', address: 'GTS', phone: '' },
  { name: 'Hafis Ibnu Hasan', class: 'Iqra 4', address: 'KBS', phone: '' },
  { name: 'Muh.Harith Arsya', class: 'Iqra 5', address: 'GTS', phone: '081234567801' },
  { name: 'M.Khidir Ali Muslim', class: 'IQRO', address: 'KBS', phone: '081234567802' },
  { name: 'Kinara Kayla Putri', class: "Al-Qur'an", address: 'KBS', phone: '' },
  { name: 'Julian Arzuyan Depita', class: "Iqra' 3", address: 'KBS', phone: '' },
  { name: 'Kasih Anzu Arizki', class: "Iqra' 5", address: 'KBS', phone: '' },
  { name: 'M. Abizar Raffhizi', class: 'Iqra 1', address: 'Sudak Pallace', phone: '081234567803' },
  { name: 'M. Al Ghazali', class: 'Iqra 3', address: 'KBS', phone: '' },
  { name: 'M. Azka Fadli Ramadhan', class: "Al-Qur'an", address: 'GTS', phone: '081234567804' },
  { name: 'M. Dzaka Raffasya', class: 'Iqra 4', address: 'Sudak Pallace', phone: '' },
  { name: 'M Ali Sandi', class: 'IQRO', address: 'KBS', phone: '' },
  { name: 'Rizwan', class: 'IQRO', address: 'KBS', phone: '' },
  { name: 'Sandi Walidaen', class: 'IQRO', address: 'KBS', phone: '081234567805' },
  { name: 'Sopian Hamdi', class: "Al-Qur'an", address: 'KBS', phone: '' },
  { name: 'Raisa Aprilion Nuro', class: 'IQRO', address: 'NURSULA', phone: '' },
  { name: 'Syafana Adifa', class: "Iqra' 4", address: 'KBS', phone: '' },
  { name: 'M Rizky Pratama', class: 'IQRO', address: 'KBS', phone: '' },
  { name: 'Toyyibburahman Arif', class: 'Iqra 5', address: 'KBS', phone: '' },
  { name: 'Yusni Fatimatun Zahra', class: "Iqra' 5", address: 'KBS', phone: '' },
  { name: 'Zuhaera Fazila', class: "Iqra' 6", address: 'KBS', phone: '' },
  { name: 'Aulian Basira Sujito', class: 'Iqro 3', address: 'GTS', phone: '' },
  { name: 'M Sarip Arrosit', class: 'IQRO', address: 'KBS', phone: '081234567806' },
  { name: 'Nagata Fariz Pratama', class: 'IQRO', address: 'GTS', phone: '' },
  { name: 'Lalu Ahmad Hisan Abyad Ahis', class: 'IQRO’5', address: 'GTS', phone: '081234567807' },
  { name: 'M.Gibran Algifari', class: 'IQRO', address: 'KBS', phone: '081234567808' },
  { name: 'Zhafran Shidqi Al Hasan', class: 'IQRO 2', address: 'GTS', phone: '081234567809' },
  { name: 'Athaar Abrisam Rahman', class: 'IQRO', address: 'GTS', phone: '081234567810' },
  { name: 'Alma salman', class: 'IQRO', address: 'GTS', phone: '' },
  { name: 'KAKAK RAISA', class: 'IQRO', address: 'GTS', phone: '' },
];

export async function GET() {
  try {
    // Delete tables to avoid duplicates and reset auto-increment IDs
    await sql`DELETE FROM spp_payments;`;
    await sql`DELETE FROM attendance;`;
    await sql`DELETE FROM progress_iqro_quran;`;
    await sql`DELETE FROM progress_sholat;`;
    await sql`DELETE FROM students;`;
    await sql`DELETE FROM users;`;
    try {
      await sql`DELETE FROM sqlite_sequence WHERE name IN ('spp_payments', 'attendance', 'progress_iqro_quran', 'progress_sholat', 'students', 'users');`;
    } catch (e) {
      // sqlite_sequence might not exist if tables were never created with AUTOINCREMENT, ignore
    }

    // 1. Seed Teacher (Guru)
    await sql`
      INSERT INTO users (name, email, password, role)
      VALUES ('Ustaz Azis', 'azis@gmail.com', 'password123', 'guru');
    `;

    const addedStudents = [];

    // 2. Seed Wali Santri and Students
    for (const santri of santriList) {
      const username = santri.name.toLowerCase().replace(/[^a-z]/g, '');
      const email = `${username}@tpq.com`;
      const password = 'password123';
      const parentName = 'Bpk/Ibu ' + santri.name.split(' ')[0];

      // Insert Wali Santri user
      const userResult = await sql`
        INSERT INTO users (name, email, password, role)
        VALUES (${santri.name}, ${email}, ${password}, 'wali_santri')
        RETURNING id;
      `;
      const waliSantriId = userResult.rows[0].id;

      // Insert Student record linked to Wali Santri
      const studentResult = await sql`
        INSERT INTO students (wali_santri_id, name, class, address, parent_name, phone)
        VALUES (${waliSantriId}, ${santri.name}, ${santri.class}, ${santri.address}, ${parentName}, ${santri.phone})
        RETURNING id, name, class;
      `;
      
      addedStudents.push(studentResult.rows[0]);
    }

    // 3. Seed some Mock Payments, Attendance, and Progress for a few students to make dashboard look populated
    const today = new Date();
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    const currentMonthIndex = today.getMonth();
    const currentYear = today.getFullYear();

    for (let i = 0; i < addedStudents.length; i++) {
      const student = addedStudents[i];

      // A. Seed SPP payments
      // Some paid, some unpaid
      const paidStatus = i % 5 === 0 ? 'Belum Bayar' : 'Lunas';
      const paymentDate = paidStatus === 'Lunas' ? new Date(currentYear, currentMonthIndex, 5 + (i % 20)) : null;
      const amount = 100000;

      await sql`
        INSERT INTO spp_payments (student_id, month, year, amount, payment_date, status)
        VALUES (${student.id}, ${months[currentMonthIndex]}, ${currentYear}, ${amount}, ${paymentDate}, ${paidStatus});
      `;

      // B. Seed some mock attendance
      // Last 5 days
      for (let dayOffset = 0; dayOffset < 5; dayOffset++) {
        const date = new Date();
        date.setDate(today.getDate() - dayOffset);
        
        // Randomize status
        let status = 'Hadir';
        if (i % 12 === 0 && dayOffset === 1) status = 'Izin';
        else if (i % 15 === 0 && dayOffset === 2) status = 'Sakit';
        else if (i % 20 === 0 && dayOffset === 0) status = 'Alpa';

        await sql`
          INSERT INTO attendance (student_id, date, status)
          VALUES (${student.id}, ${date.toISOString().split('T')[0]}, ${status});
        `;
      }

      // C. Seed mock progress (Iqro/Quran)
      const pageNum = 1 + (i % 20);
      await sql`
        INSERT INTO progress_iqro_quran (student_id, level, page_surah, notes)
        VALUES (${student.id}, ${student.class}, ${'Halaman ' + pageNum}, 'Alhamdulillah membacanya cukup lancar.');
      `;

      // D. Seed mock progress (Sholat)
      await sql`
        INSERT INTO progress_sholat (student_id, category, item_name, status, notes)
        VALUES 
          (${student.id}, 'Gerakan & Bacaan', 'Takbiratul Ihram', 'SEMPURNA', 'Gerakan tangan sudah lurus dan takbir terdengar jelas.'),
          (${student.id}, 'Azan & Persiapan', 'Doa Sebelum Azan', 'LANCAR', 'Mulai hafal, perlu sedikit bimbingan pada tajwid.');
      `;
    }

    return NextResponse.json({ 
      message: 'Seed data inserted successfully', 
      users_count: santriList.length + 1,
      students_count: addedStudents.length
    });
  } catch (error: any) {
    return NextResponse.json({ error: error.message }, { status: 500 });
  }
}

