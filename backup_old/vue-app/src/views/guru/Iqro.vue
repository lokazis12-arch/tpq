<template>
  <div class="page-wrapper pb-safe">
    <AppNavbar title="Progres Iqro" showBack role="guru" />
    <main class="page-content">
      <div class="card card-accent" style="margin-bottom:16px;">
        <h3 style="font-size:15px;font-weight:600;margin-bottom:12px;">Input Progres Iqro</h3>
        <form @submit.prevent="handleAdd" class="form-row">
          <div class="form-field"><label class="input-label">Santri</label>
            <select v-model="form.santri_id" class="input" required><option value="">Pilih Santri</option><option v-for="s in santriList" :key="s.id" :value="s.id">{{ s.nama }}</option></select></div>
          <div class="form-field"><label class="input-label">Jilid</label>
            <select v-model="form.jilid" class="input" required><option value="">Jilid</option><option v-for="i in 6" :key="i" :value="i">Jilid {{ i }}</option></select></div>
          <div class="form-field"><label class="input-label">Halaman</label>
            <select v-model="form.halaman" class="input" required><option value="">Halaman</option><option v-for="i in 32" :key="i" :value="i">{{ i }}</option></select></div>
          <div class="form-field"><label class="input-label">Kategori</label>
            <select v-model="form.kategori" class="input"><option value="bacaan">Bacaan</option><option value="hafalan">Hafalan</option></select></div>
          <div class="form-field" style="align-self:flex-end;"><button type="submit" class="btn btn-primary">Simpan</button></div>
        </form>
      </div>
      <div class="table-container">
        <table><thead><tr><th>Santri</th><th>Jilid</th><th>Halaman</th><th>Kategori</th><th>Aksi</th></tr></thead>
          <tbody>
            <tr v-for="p in progresList" :key="p.id">
              <td>{{ getSantriName(p.santri_id) }}</td><td><span class="chip chip-emerald">Jilid {{ p.jilid }}</span></td><td>{{ p.halaman }}</td>
              <td><span class="chip" :class="p.kategori==='hafalan'?'chip-success':'chip-neutral'">{{ p.kategori }}</span></td>
              <td><button class="btn-icon" @click="handleDelete(p.id)" style="color:var(--color-error);"><span class="material-icon" style="font-size:18px;">delete</span></button></td>
            </tr>
            <tr v-if="progresList.length===0"><td colspan="5" class="empty-state" style="padding:32px;">Belum ada data</td></tr>
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
const santriList = ref([]); const progresList = ref([])
const form = ref({ santri_id: '', jilid: '', halaman: '', kategori: 'bacaan' })

const fetchSantri = async () => { const { data } = await safeQuery(() => supabase.from('santri').select('*')); santriList.value = data || [] }
const fetchProgres = async () => { const { data } = await safeQuery(() => supabase.from('progres_iqro').select('*').order('created_at', { ascending: false })); progresList.value = data || [] }
const getSantriName = (id) => { const s = santriList.value.find(x => x.id === id); return s ? s.nama : '-' }

const handleAdd = async () => {
  const { error } = await supabase.from('progres_iqro').insert([form.value])
  if (error) { showError('Gagal menyimpan progres'); return }
  form.value = { santri_id: '', jilid: '', halaman: '', kategori: 'bacaan' }
  showSuccess('Progres Iqro disimpan!'); fetchProgres()
}
const handleDelete = async (id) => {
  const { error } = await supabase.from('progres_iqro').delete().eq('id', id)
  if (error) { showError('Gagal menghapus'); return }
  showSuccess('Data dihapus'); fetchProgres()
}
onMounted(() => { fetchSantri(); fetchProgres() })
</script>

<style scoped>
.page-wrapper { min-height:100vh; background:var(--color-surface); }
.page-content { max-width:768px; margin:0 auto; padding:16px; padding-bottom:100px; }
.form-row { display:flex; gap:12px; flex-wrap:wrap; }
.form-field { display:flex; flex-direction:column; min-width:130px; flex:1; }
@media(max-width:640px) { .form-row { flex-direction:column; } .form-field { min-width:auto; } }
@media(min-width:768px) { .page-content { padding-left:96px; } }
</style>
