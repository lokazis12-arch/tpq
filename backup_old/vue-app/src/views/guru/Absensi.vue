<template>
  <div class="page-wrapper pb-safe">
    <AppNavbar title="Input Absensi" showBack role="guru" />
    <main class="page-content">
      <div class="card card-accent" style="margin-bottom:16px;">
        <h3 style="font-size:15px;font-weight:600;margin-bottom:12px;">Catat Kehadiran</h3>
        <form @submit.prevent="handleAdd" class="form-row">
          <div class="form-field" style="flex:2;"><label class="input-label">Santri</label>
            <select v-model="form.santri_id" class="input" required><option value="">Pilih Santri</option><option v-for="s in santriList" :key="s.id" :value="s.id">{{ s.nama }}</option></select>
          </div>
          <div class="form-field" style="flex:1;"><label class="input-label">Tanggal</label><input v-model="form.tanggal" type="date" class="input" required /></div>
          <div class="form-field" style="flex:1;"><label class="input-label">Status</label>
            <select v-model="form.status" class="input" required><option value="hadir">Hadir</option><option value="izin">Izin</option><option value="sakit">Sakit</option><option value="alpha">Alpha</option></select>
          </div>
          <div class="form-field" style="align-self:flex-end;"><button type="submit" class="btn btn-primary">Catat</button></div>
        </form>
      </div>

      <div class="table-container">
        <table><thead><tr><th>Santri</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr></thead>
          <tbody>
            <tr v-for="a in absensiList" :key="a.id">
              <td>{{ getSantriName(a.santri_id) }}</td>
              <td>{{ a.tanggal }}</td>
              <td><span class="chip" :class="statusChip(a.status)">{{ a.status }}</span></td>
              <td><button class="btn-icon" @click="handleDelete(a.id)" style="color:var(--color-error);"><span class="material-icon" style="font-size:18px;">delete</span></button></td>
            </tr>
            <tr v-if="absensiList.length===0"><td colspan="4" class="empty-state" style="padding:32px;">Belum ada data absensi</td></tr>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { supabase, safeQuery } from '../../lib/supabase'
import { useToast } from '../../composables/useToast'
import AppNavbar from '../../components/AppNavbar.vue'

const { showSuccess, showError } = useToast()
const santriList = ref([]); const absensiList = ref([])
const form = ref({ santri_id: '', tanggal: new Date().toISOString().split('T')[0], status: 'hadir' })

const fetchSantri = async () => { const { data } = await safeQuery(() => supabase.from('santri').select('*')); santriList.value = data || [] }
const fetchAbsensi = async () => { const { data } = await safeQuery(() => supabase.from('absensi').select('*').order('tanggal', { ascending: false })); absensiList.value = data || [] }
const getSantriName = (id) => { const s = santriList.value.find(x => x.id === id); return s ? s.nama : '-' }

const statusChip = (s) => ({ hadir: 'chip-success', izin: 'chip-warning', sakit: 'chip-warning', alpha: 'chip-error' }[s] || 'chip-neutral')

const handleAdd = async () => {
  const { error } = await supabase.from('absensi').insert([form.value])
  if (error) { showError('Gagal mencatat absensi'); return }
  form.value = { santri_id: '', tanggal: new Date().toISOString().split('T')[0], status: 'hadir' }
  showSuccess('Absensi dicatat!'); fetchAbsensi()
}
const handleDelete = async (id) => {
  const { error } = await supabase.from('absensi').delete().eq('id', id)
  if (error) { showError('Gagal menghapus'); return }
  showSuccess('Data dihapus'); fetchAbsensi()
}
onMounted(() => { fetchSantri(); fetchAbsensi() })
</script>

<style scoped>
.page-wrapper { min-height:100vh; background:var(--color-surface); }
.page-content { max-width:768px; margin:0 auto; padding:16px; padding-bottom:100px; }
.form-row { display:flex; gap:12px; flex-wrap:wrap; }
.form-field { display:flex; flex-direction:column; min-width:140px; }
@media(max-width:640px) { .form-row { flex-direction:column; } .form-field { min-width:auto; } }
@media(min-width:768px) { .page-content { padding-left:96px; } }
</style>
