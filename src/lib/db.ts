import path from 'path';

let sqliteDb: any = null;

async function getSqliteDb() {
  if (!sqliteDb) {
    const Database = (await import('better-sqlite3')).default;
    const dbPath = path.join(process.cwd(), 'tpq.sqlite');
    sqliteDb = new Database(dbPath);
    sqliteDb.pragma('foreign_keys = ON');

    // Auto-migrations for SQLite
    try {
      const tableInfo = sqliteDb.prepare("PRAGMA table_info(users)").all();
      const hasPhone = tableInfo.some((col: any) => col.name === 'phone');
      if (!hasPhone) {
        sqliteDb.exec("ALTER TABLE users ADD COLUMN phone TEXT;");
      }
      const hasAvatar = tableInfo.some((col: any) => col.name === 'avatar_url');
      if (!hasAvatar) {
        sqliteDb.exec("ALTER TABLE users ADD COLUMN avatar_url TEXT;");
      }

      // Create progress_hafalan table if not exists
      sqliteDb.exec(`
        CREATE TABLE IF NOT EXISTS progress_hafalan (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          student_id INTEGER REFERENCES students(id) ON DELETE CASCADE,
          surah_name TEXT NOT NULL,
          status TEXT NOT NULL,
          notes TEXT,
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
      `);
    } catch (e) {
      console.error('SQLite migration error:', e);
    }
  }
  return sqliteDb;
}

export async function sql(strings: TemplateStringsArray, ...values: any[]): Promise<{ rows: any[]; rowCount: number }> {
  if (process.env.POSTGRES_URL) {
    // Vercel Postgres Mode (Production)
    const { sql: vercelSql } = await import('@vercel/postgres');
    
    try {
      const result = await vercelSql(strings, ...values);
      return {
        rows: result.rows,
        rowCount: result.rowCount ?? 0,
      };
    } catch (error) {
      console.error('PostgreSQL query error:', error);
      throw error;
    }
  } else {
    // SQLite Mode (Development)
    const db = await getSqliteDb();
    
    // Reconstruct query using '?' placeholders
    let query = '';
    for (let i = 0; i < strings.length; i++) {
      query += strings[i];
      if (i < values.length) {
        query += '?';
      }
    }

    // Translate basic PostgreSQL syntax into SQLite syntax
    let sqlText = query;
    sqlText = sqlText.replace(/\bSERIAL PRIMARY KEY\b/gi, 'INTEGER PRIMARY KEY AUTOINCREMENT');
    sqlText = sqlText.replace(/\bSERIAL\b/gi, 'INTEGER PRIMARY KEY AUTOINCREMENT');
    sqlText = sqlText.replace(/\bTIMESTAMP\b/gi, 'DATETIME');
    sqlText = sqlText.replace(/\bVARCHAR\(\d+\)\b/gi, 'TEXT');
    sqlText = sqlText.replace(/\bVARCHAR\b/gi, 'TEXT');
    sqlText = sqlText.replace(/\bDECIMAL\(\d+,\s*\d+\)\b/gi, 'REAL');
    sqlText = sqlText.replace(/\bDECIMAL\b/gi, 'REAL');
    sqlText = sqlText.replace(/\bBOOLEAN\b/gi, 'INTEGER');
    sqlText = sqlText.replace(/\bNOW\(\)\b/gi, 'CURRENT_TIMESTAMP');
    sqlText = sqlText.replace(/\bILIKE\b/gi, 'LIKE');

    // SQLite doesn't natively handle $1, $2, etc., which might appear in some queries.
    // Replace $1, $2, ... with ? if they exist in the query
    sqlText = sqlText.replace(/\$\d+/g, '?');

    const stmt = db.prepare(sqlText);

    // Convert Date objects to ISO strings for SQLite
    const serializedValues = values.map(val => val instanceof Date ? val.toISOString() : val);

    // Determine if this statement yields rows
    const isQuery = sqlText.trim().toUpperCase().startsWith('SELECT') || sqlText.toUpperCase().includes('RETURNING');

    if (isQuery) {
      const rows = stmt.all(...serializedValues);
      return {
        rows: rows as any[],
        rowCount: rows.length,
      };
    } else {
      const result = stmt.run(...serializedValues);
      return {
        rows: [],
        rowCount: result.changes,
      };
    }
  }
}
