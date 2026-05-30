import { sql } from '@/lib/db';
import { NextResponse } from 'next/server';

export async function GET() {
  try {
    // Create Users table
    await sql`
      CREATE TABLE IF NOT EXISTS users (
        id SERIAL PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(50) DEFAULT 'guru',
        phone VARCHAR(20),
        avatar_url VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      );
    `;

    // Try altering users to add phone/avatar_url if table already existed
    try {
      await sql`ALTER TABLE users ADD COLUMN phone VARCHAR(20);`;
    } catch (e) {}
    try {
      await sql`ALTER TABLE users ADD COLUMN avatar_url VARCHAR(255);`;
    } catch (e) {}

    // Create Students table (with wali_santri_id linked to users)
    await sql`
      CREATE TABLE IF NOT EXISTS students (
        id SERIAL PRIMARY KEY,
        wali_santri_id INTEGER REFERENCES users(id) ON DELETE SET NULL,
        name VARCHAR(255) NOT NULL,
        class VARCHAR(50),
        address VARCHAR(255),
        parent_name VARCHAR(255),
        phone VARCHAR(20),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      );
    `;

    // Create Attendance table
    await sql`
      CREATE TABLE IF NOT EXISTS attendance (
        id SERIAL PRIMARY KEY,
        student_id INTEGER REFERENCES students(id) ON DELETE CASCADE,
        date DATE NOT NULL,
        status VARCHAR(20) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      );
    `;

    // Create SPP Payments table
    await sql`
      CREATE TABLE IF NOT EXISTS spp_payments (
        id SERIAL PRIMARY KEY,
        student_id INTEGER REFERENCES students(id) ON DELETE CASCADE,
        month VARCHAR(20) NOT NULL,
        year INTEGER NOT NULL,
        amount DECIMAL(10, 2) DEFAULT 0,
        payment_date TIMESTAMP,
        status VARCHAR(20) DEFAULT 'Belum Bayar',
        payment_type VARCHAR(50) DEFAULT 'SPP',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      );
    `;

    try {
      await sql`ALTER TABLE spp_payments ADD COLUMN payment_type VARCHAR(50) DEFAULT 'SPP';`;
    } catch (e) {
      // Column might already exist, ignore
    }

    // Create Progress Iqro/Quran table
    await sql`
      CREATE TABLE IF NOT EXISTS progress_iqro_quran (
        id SERIAL PRIMARY KEY,
        student_id INTEGER REFERENCES students(id) ON DELETE CASCADE,
        level VARCHAR(50) NOT NULL,
        page_surah VARCHAR(100) NOT NULL,
        notes TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      );
    `;

    // Create Progress Sholat table
    await sql`
      CREATE TABLE IF NOT EXISTS progress_sholat (
        id SERIAL PRIMARY KEY,
        student_id INTEGER REFERENCES students(id) ON DELETE CASCADE,
        category VARCHAR(50) NOT NULL,
        item_name VARCHAR(100) NOT NULL,
        status VARCHAR(50) NOT NULL,
        notes TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      );
    `;

    // Create Progress Hafalan Juz 30 table
    await sql`
      CREATE TABLE IF NOT EXISTS progress_hafalan (
        id SERIAL PRIMARY KEY,
        student_id INTEGER REFERENCES students(id) ON DELETE CASCADE,
        surah_name VARCHAR(100) NOT NULL,
        status VARCHAR(50) NOT NULL,
        notes TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      );
    `;

    return NextResponse.json({ message: 'Database tables created successfully' });
  } catch (error: any) {
    return NextResponse.json({ error: error.message }, { status: 500 });
  }
}

