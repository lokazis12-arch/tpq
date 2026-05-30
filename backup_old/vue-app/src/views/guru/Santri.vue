<template>
  <div class="page-wrapper pb-safe">
    <AppNavbar title="Kelola Santri" showBack role="guru" />
    <main class="page-content">
      <div class="page-header">
        <h2 class="page-title">Data Santri</h2>
        <button class="btn btn-primary btn-sm" @click="showForm = !showForm">
          <span class="material-icon" style="font-size:18px;">{{ showForm ? 'close' : 'add' }}</span>
          {{ showForm ? 'Tutup' : 'Tambah' }}
        </button>
      </div>

      <!-- Add Form -->
      <Transition name="page">
        <div v-if="showForm" class="card card-accent" style="margin-bottom:16px;">
          <h3 style="font-size:15px;font-weight:600;margin-bottom:12px;">Tambah Santri Baru</h3>
          <form @submit.prevent="handleAdd" class="form-grid">
            <div class="form-field"><label class="input-label">Nama Santri</label><input v-model="form.nama" class="input" placeholder="Nama lengkap" required /></div>
            <div class="form-field"><label class="input-label">Tanggal Lahir</label><input v-model="form.tanggal_lahir" type="date" class="input" required /></div>
            <div class="form-field"><label class="input-label">Jenis Kelamin</label>
              <select v-model="form.jenis_kelamin" class="input" required><option value="">Pilih</option><option value="L">Laki-laki</option><option value="P">Perempuan</option></select>
            </div>
            <div class="form-field"><label class="input-label">Alamat</label><input v-model="form.alamat" class="input" placeholder="Alamat" /></div>
            <div class="form-field"><label class="input-label">Nama Wali</label><input v-model="form.nama_wali" class="input" placeholder="Nama wali" /></div>
            <div class="form-field"><label class="input-label">No HP Wali</label><input v-model="form.no_hp_wali" class="input" placeholder="08xxx" /></div>
            <div class="form-field" style="grid-column:1/-1;"><button type="submit" class="btn btn-primary" style="width:100%;">Simpan Santri</button></div>
          </form>
        </div>
      </Transition>

      <!-- Santri List -->
      <div class="santri-list">
        <StudentCard v-for="s in santriList" :key="s.id" :nama="s.nama" :nis="s.tanggal_lahir" :kelas="s.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'" :detail="s.nama_wali ? 'Wali: ' + s.nama_wali : ''">
          <template #actions>
            <button class="btn-icon" @click.stop="handleDelete(s.id)" title="Hapus" style="color:var(--color-error);">
              <span class="material-icon" style="font-size:20px;">delete_outline</span>
            </button>
          </template>
        </StudentCard>
        <div v-if="santriList.length === 0" class="empty-state">
          <span class="material-icon">group_off</span>
          <p>Belum ada data santri</p>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { supabase, safeQuery } from '../../lib/supabase'
import { useToast } from '../../composables/useToast'
import AppNavbar from '../../components/AppNavbar.vue'
import StudentCard from '../../components/StudentCard.vue'

const { showSuccess, showError } = useToast()
const santriList = ref([])
const showForm = ref(false)
const form = ref({ nama: '', tanggal_lahir: '', jenis_kelamin: '', alamat: '', nama_wali: '', no_hp_wali: '' })

const fetchSantri = async () => {
  const { data } = await safeQuery(() => supabase.from('santri').select('*'))
  santriList.value = data || []
}

const handleAdd = async () => {
  const { error } = await supabase.from('santri').insert([form.value])
  if (error) { 
    console.error('Supabase error:', error);
    showError('Gagal: ' + error.message); 
    return 
  }
  form.value = { nama: '', tanggal_lahir: '', jenis_kelamin: '', alamat: '', nama_wali: '', no_hp_wali: '' }
  showForm.value = false
  showSuccess('Santri berhasil ditambahkan!')
  fetchSantri()
}

const handleDelete = async (id) => {
  if (!confirm('Hapus santri ini?')) return
  const { error } = await supabase.from('santri').delete().eq('id', id)
  if (error) { showError('Gagal menghapus'); return }
  showSuccess('Santri dihapus')
  fetchSantri()
}

onMounted(fetchSantri)
</script>

<style scoped>
.page-wrapper { min-height:100vh; background:var(--color-surface); }
.page-content { max-width:768px; margin:0 auto; padding:16px; padding-bottom:100px; }
.page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; }
.page-title { font-size:20px; font-weight:700; color:var(--color-on-surface); }
.form-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.form-field { display:flex; flex-direction:column; }
.santri-list { display:flex; flex-direction:column; gap:10px; }
@media(max-width:640px) { .form-grid { grid-template-columns:1fr; } }
@media(min-width:768px) { .page-content { padding-left:96px; } }
</style>
