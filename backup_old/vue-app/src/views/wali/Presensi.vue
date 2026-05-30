<template>
  <div class="page-wrapper pb-safe">
    <AppNavbar title="Riwayat Presensi" showBack role="wali_santri" />
    <main class="page-content">
      <h2 class="page-title">Kehadiran Santri</h2>
      <div class="stats-row">
        <StatCard icon="check_circle" :value="countByStatus('hadir')" label="Hadir" class="animate-slide-up stagger-1" />
        <StatCard icon="event_busy" :value="countByStatus('alpha')" label="Alpha" accentColor="#ba1a1a" class="animate-slide-up stagger-2" />
      </div>
      <div class="table-container">
        <table><thead><tr><th>Tanggal</th><th>Status</th></tr></thead>
          <tbody>
            <tr v-for="a in absensiList" :key="a.id">
              <td>{{ formatDate(a.tanggal) }}</td>
              <td><span class="chip" :class="statusChip(a.status)">{{ a.status }}</span></td>
            </tr>
            <tr v-if="absensiList.length===0"><td colspan="2" class="empty-state" style="padding:32px;">Belum ada data presensi</td></tr>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { supabase, safeQuery } from '../../lib/supabase'
import AppNavbar from '../../components/AppNavbar.vue'
import StatCard from '../../components/StatCard.vue'

const absensiList = ref([])
const fetchAbsensi = async () => {
  const { data } = await safeQuery(() => supabase.from('absensi').select('*').order('tanggal', { ascending: false }))
  absensiList.value = data || []
}
const countByStatus = (s) => absensiList.value.filter(a => a.status === s).length
const formatDate = (d) => new Date(d).toLocaleDateString('id-ID', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' })
const statusChip = (s) => ({ hadir: 'chip-success', izin: 'chip-warning', sakit: 'chip-warning', alpha: 'chip-error' }[s] || 'chip-neutral')
onMounted(fetchAbsensi)
</script>

<style scoped>
.page-wrapper { min-height:100vh; background:var(--color-surface); }
.page-content { max-width:768px; margin:0 auto; padding:16px; padding-bottom:100px; }
.page-title { font-size:20px; font-weight:700; color:var(--color-on-surface); margin-bottom:16px; }
.stats-row { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px; }
@media(min-width:768px) { .page-content { padding-left:96px; } }
</style>
