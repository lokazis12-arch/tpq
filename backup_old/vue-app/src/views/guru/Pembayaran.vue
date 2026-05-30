<template>
  <div class="page-wrapper pb-safe">
    <AppNavbar title="Pembayaran SPP" showBack role="guru" />
    <main class="page-content">
      <!-- Summary -->
      <div class="summary-row">
        <StatCard icon="payments" :value="'Rp ' + totalLunas.toLocaleString('id-ID')" label="Total Terkumpul" class="animate-slide-up stagger-1" />
        <StatCard icon="warning" :value="totalBelum" label="Belum Lunas" accentColor="#ba1a1a" class="animate-slide-up stagger-2" />
      </div>

      <div class="card card-accent" style="margin-bottom:16px;">
        <h3 style="font-size:15px;font-weight:600;margin-bottom:12px;">Catat Pembayaran</h3>
        <form @submit.prevent="handleAdd" class="form-row">
          <div class="form-field"><label class="input-label">Santri</label>
            <select v-model="form.santri_id" class="input" required><option value="">Pilih Santri</option><option v-for="s in santriList" :key="s.id" :value="s.id">{{ s.nama }}</option></select></div>
          <div class="form-field"><label class="input-label">Bulan</label><input v-model="form.bulan" type="month" class="input" required /></div>
          <div class="form-field"><label class="input-label">Jumlah (Rp)</label><input v-model="form.jumlah" type="number" class="input" placeholder="50000" required /></div>
          <div class="form-field"><label class="input-label">Status</label>
            <select v-model="form.status" class="input"><option value="lunas">Lunas</option><option value="belum_lunas">Belum Lunas</option></select></div>
          <div class="form-field" style="align-self:flex-end;"><button type="submit" class="btn btn-primary">Simpan</button></div>
        </form>
      </div>

      <div class="table-container">
        <table><thead><tr><th>Santri</th><th>Bulan</th><th>Jumlah</th><th>Status</th><th>Aksi</th></tr></thead>
          <tbody>
            <tr v-for="p in pembayaranList" :key="p.id">
              <td>{{ getSantriName(p.santri_id) }}</td><td>{{ p.bulan }}</td>
              <td>Rp {{ Number(p.jumlah).toLocaleString('id-ID') }}</td>
              <td><span class="chip" :class="p.status==='lunas'?'chip-success':'chip-error'">{{ p.status === 'lunas' ? 'Lunas' : 'Belum' }}</span></td>
              <td><button class="btn-icon" @click="handleDelete(p.id)" style="color:var(--color-error);"><span class="material-icon" style="font-size:18px;">delete</span></button></td>
            </tr>
            <tr v-if="pembayaranList.length===0"><td colspan="5" class="empty-state" style="padding:32px;">Belum ada data</td></tr>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { supabase, safeQuery } from '../../lib/supabase'
import { useToast } from '../../composables/useToast'
import AppNavbar from '../../components/AppNavbar.vue'
import StatCard from '../../components/StatCard.vue'

const { showSuccess, showError } = useToast()
const santriList = ref([]); const pembayaranList = ref([])
const form = ref({ santri_id: '', bulan: '', jumlah: '', status: 'lunas' })

const totalLunas = computed(() => pembayaranList.value.filter(p => p.status === 'lunas').reduce((sum, p) => sum + Number(p.jumlah), 0))
const totalBelum = computed(() => pembayaranList.value.filter(p => p.status === 'belum_lunas').length)

const fetchSantri = async () => { const { data } = await safeQuery(() => supabase.from('santri').select('*')); santriList.value = data || [] }
const fetchPembayaran = async () => { const { data } = await safeQuery(() => supabase.from('pembayaran').select('*').order('bulan', { ascending: false })); pembayaranList.value = data || [] }
const getSantriName = (id) => { const s = santriList.value.find(x => x.id === id); return s ? s.nama : '-' }

const handleAdd = async () => {
  const { error } = await supabase.from('pembayaran').insert([form.value])
  if (error) { showError('Gagal menyimpan pembayaran'); return }
  form.value = { santri_id: '', bulan: '', jumlah: '', status: 'lunas' }
  showSuccess('Pembayaran dicatat!'); fetchPembayaran()
}
const handleDelete = async (id) => {
  const { error } = await supabase.from('pembayaran').delete().eq('id', id)
  if (error) { showError('Gagal menghapus'); return }
  showSuccess('Data dihapus'); fetchPembayaran()
}
onMounted(() => { fetchSantri(); fetchPembayaran() })
</script>

<style scoped>
.page-wrapper { min-height:100vh; background:var(--color-surface); }
.page-content { max-width:768px; margin:0 auto; padding:16px; padding-bottom:100px; }
.summary-row { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px; }
.form-row { display:flex; gap:12px; flex-wrap:wrap; }
.form-field { display:flex; flex-direction:column; min-width:130px; flex:1; }
@media(max-width:640px) { .form-row { flex-direction:column; } .form-field { min-width:auto; } .summary-row { grid-template-columns:1fr; } }
@media(min-width:768px) { .page-content { padding-left:96px; } }
</style>
