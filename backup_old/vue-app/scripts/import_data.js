import { createClient } from '@supabase/supabase-js';
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// Load environment variables from .env
const envPath = path.join(__dirname, '..', '.env');
const envContent = fs.readFileSync(envPath, 'utf8');
const env = {};
envContent.split('\n').forEach(line => {
    const parts = line.split('=');
    if (parts.length >= 2) {
        const key = parts[0].trim();
        const value = parts.slice(1).join('=').trim();
        env[key] = value;
    }
});

const supabaseUrl = env.VITE_SUPABASE_URL;
const supabaseKey = env.VITE_SUPABASE_ANON_KEY;

if (!supabaseUrl || !supabaseKey) {
    console.error('Missing Supabase credentials in .env');
    process.exit(1);
}

const supabase = createClient(supabaseUrl, supabaseKey);

const santriData = [
    { name: "Aban Azhari", address: "KBS", class: "Al-Qur'an" },
    { name: "Adreena Keysha", address: "Griya Taman Sari", class: "Iqra' 1" },
    { name: "Ah. Alif Rizki", address: "KBS", class: "Al-Qur'an" },
    { name: "Ahmad Zakwan Razik", address: "KBS", class: "Al-Qur'an" },
    { name: "Ain Al Qadri", address: "KBS", class: "Al-Qur'an" },
    { name: "Annisa Shezan Qaisra", address: "Griya Taman Sari", class: "Al-Qur'an" },
    { name: "Anggun Firmansyah", address: "Griya Taman Sari", class: "Iqra' 6" },
    { name: "M. Ar Royan Alfa Rizki", address: "KBS", class: "IQRO" },
    { name: "Asraf Ghani Al Qadri", address: "KBS", class: "Al-Qur'an" },
    { name: "Azka Aulia", address: "KBS", class: "Iqra' 5" },
    { name: "Bela Nursafitri", address: "GTS", class: "Iqra' 5" },
    { name: "Datu Arkanel Reyhan", address: "GTS", class: "Al-Qur'an" },
    { name: "Dimas Maulana", address: "KBS", class: "Al-Qur'an" },
    { name: "Faiz Akbar Maulidi", address: "KBS", class: "Iqra 5" },
    { name: "Farzana Al-Mahira", address: "GTS", class: "Iqra' 3" },
    { name: "Fatih Ali Muslim", address: "KBS", class: "Al-Qur'an" },
    { name: "Fatimah Az Zahra", address: "KBS", class: "Al-Qur'an" },
    { name: "Halan Dwi Firmansyah", address: "GTS", class: "Iqra 4" },
    { name: "Haekal", address: "GTS", class: "Iqra 3" },
    { name: "Hafis Ibnu Hasan", address: "KBS", class: "Iqra 4" },
    { name: "Muh.Harith Arsya", address: "GTS", class: "Iqra 5" },
    { name: "M.Khidir Ali Muslim", address: "KBS", class: "IQRO" },
    { name: "Kinara Kayla Putri", address: "KBS", class: "Al-Qur'an" },
    { name: "Julian Arzuyan Depita", address: "KBS", class: "Iqra' 3" },
    { name: "Kasih Anzu Arizki", address: "KBS", class: "Iqra' 5" },
    { name: "Kinara Kayla Putri", address: "Griya Taman Sari", class: "Al-Qur'an" },
    { name: "M. Abizar Raffhizi", address: "Sudak Pallace", class: "Iqra 1" },
    { name: "M. Al Ghazali", address: "KBS", class: "Iqra 3" },
    { name: "M. Azka Fadli Ramadhan", address: "GTS", class: "Al-Qur'an" },
    { name: "M. Dzaka Raffasya", address: "Sudak Pallace", class: "Iqra 4" },
    { name: "M Ali Sandi", address: "KBS", class: "IQRO" },
    { name: "Rizwan", address: "KBS", class: "IQRO" },
    { name: "Sandi Walidaen", address: "KBS", class: "IQRO" },
    { name: "Sopian Hamdi", address: "KBS", class: "Al-Qur'an" },
    { name: "Raisa Aprilion Nuro", address: "NURSULA", class: "IQRO" },
    { name: "Syafana Adifa", address: "KBS", class: "Iqra' 4" },
    { name: "M Rizky Pratama", address: "KBS", class: "IQRO" },
    { name: "Toyyibburahman Arif", address: "KBS", class: "Iqra 5" },
    { name: "Yusni Fatimatun Zahra", address: "KBS", class: "Iqra' 5" },
    { name: "Zuhaera Fazila", address: "KBS", class: "Iqra' 6" },
    { name: "Aulian Basira Sujito", address: "GTS", class: "Iqro 3" },
    { name: "M Sarip Arrosit", address: "KBS", class: "IQRO" },
    { name: "Nagata Fariz Pratama", address: "GTS", class: "IQRO" },
    { name: "Lalu Ahmad Hisan Abyad Ahis", address: "GTS", class: "IQRO’5" },
    { name: "M.Gibran Algifari", address: "KBS ", class: "IQRO" },
    { name: "Zhafran Shidqi Al Hasan", address: "GTS", class: "IQRO 2" },
    { name: "Athaar Abrisam Rahman", address: "GTS", class: "IQRO " },
    { name: "Alma salman", address: "GTS", class: "IQRO" },
    { name: "Raisa Aprilion Nuro", address: "NURSULA", class: "IQRO" },
    { name: "KAKAK RAISA", address: "GTS", class: "IQRO" }
];

async function createAccount(email, password, name, role, studentData = null) {
    console.log(`Creating account for ${name} (${email})...`);
    
    try {
        // 1. Sign up
        const { data: authData, error: authError } = await supabase.auth.signUp({
            email: email,
            password: password,
            options: {
                data: {
                    full_name: name
                }
            }
        });

        if (authError) {
            console.error(`Error signing up ${email}:`, authError.message);
            return;
        }

        const userId = authData.user.id;

        // 2. Create profile
        const { error: profileError } = await supabase
            .from('profiles')
            .upsert({
                id: userId,
                name: name,
                email: email,
                role: role
            });

        if (profileError) {
            console.error(`Error creating profile for ${email}:`, profileError.message);
            return;
        }

        // 3. Create santri record if applicable
        if (studentData) {
            const { error: santriError } = await supabase
                .from('santri')
                .insert({
                    wali_santri_id: userId,
                    nis: `NIS-${Date.now()}-${Math.floor(Math.random() * 1000)}`,
                    nama_lengkap: studentData.name,
                    alamat: studentData.address,
                    pengajian: studentData.class,
                    nama_wali: name,
                    status_aktif: true
                });

            if (santriError) {
                console.error(`Error creating santri record for ${studentData.name}:`, santriError.message);
            }
        }

        console.log(`Successfully created account for ${name}`);
    } catch (err) {
        console.error(`Unexpected error for ${name}:`, err.message);
    }
}

async function run() {
    // 1. Create Teacher Account
    await createAccount('azis@gmail.com', 'password123', 'Ustaz Azis', 'guru');

    // 2. Create Student/Wali Accounts
    for (const student of santriData) {
        const username = student.name.toLowerCase().replace(/[^a-z]/g, '');
        const email = `${username}@tpq.com`;
        const password = 'password123';
        
        await createAccount(email, password, student.name, 'wali_santri', student);
        
        // Wait a bit to avoid rate limiting
        await new Promise(resolve => setTimeout(resolve, 300));
    }
}

run();
