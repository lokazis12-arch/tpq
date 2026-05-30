<template>
  <div class="page-wrapper pb-safe">
    <AppNavbar title="Laporan" showBack role="wali_santri" />
    <main class="page-content">
      <h2 class="page-title">Laporan Perkembangan</h2>

      <!-- Iqro Summary -->
      <section class="section">
        <h3 class="section-title"><span class="material-icon" style="font-size:18px;vertical-align:middle;margin-right:4px;">menu_book</span> Progres Iqro</h3>
        <div class="card" v-if="iqroList.length">
          <div v-for="p in iqroList" :key="p.id" class="report-row">
            <div><span class="chip chip-emerald">Jilid {{ p.jilid }}</span></div>
            <div style="flex:1;margin:0 12px;">
              <div class="progress-track" style="height:8px;"><div class="progress-fill" :style="{width:(p.halaman/32*100)+'%'}"></div></div>
            </div>
            <span style="font-size:13px;color:var(--color-on-surface-variant);">{{ p.halaman }}/32</span>
          </div>
        </div>
        <div v-else class="empty-state" style="padding:20px;"><p>Belum ada data</p></div>
      </section>

      <!-- Sholat Summary -->
      <section class="section">
        <h3 class="section-title"><span class="material-icon" style="font-size:18px;vertical-align:middle;margin-right:4px;">mosque</span> Progres Sholat</h3>
        <div class="prayer-summary">
          <div v-for="p in sholatList" :key="p.id" class="card" style="padding:12px;text-align:center;">
            <p style="font-size:13px;font-weight:600;text-transform:capitalize;color:var(--color-on-surface);margin-bottom:4px;">{{ p.jenis_sholat }}</p>
            <span class="chip" :class="statusChip(p.status)">{{ formatSholatStatus(p.status) }}</span>
          </div>
        </div>
        <div v-if="sholatList.length===0" class="empty-state" style="padding:20px;"><p>Belum ada data</p></div>
      </section>

      <!-- Attendance Summary -->
      <section class="section">
        <h3 class="section-title"><span class="material-icon" style="font-size:18px;vertical-align:middle;margin-right:4px;">calendar_today</span> Ringkasan Kehadiran</h3>
        <div class="attendance-summary">
          <div class="att-item"><span class="att-count" style="color:#166534;">{{ countAtt('hadir') }}</span><span class="att-label">Hadir</span></div>
          <div class="att-item"><span class="att-count" style="color:#92400e;">{{ countAtt('izin') + countAtt('sakit') }}</span><span class="att-label">Izin/Sakit</span></div>
          <div class="att-item"><span class="att-count" style="color:#991b1b;">{{ countAtt('alpha') }}</span><span class="att-label">Alpha</span></div>
        </div>
      </section>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { supabase, safeQuery } from '../../lib/supabase'
import AppNavbar from '../../components/AppNavbar.vue'

const iqroList = ref([]); const sholatList = ref([]); const absensiList = ref([])

const fetchData = async () => {
  const [i, s, a] = await Promise.all([
    safeQuery(() => supabase.from('progres_iqro').select('*').order('jilid')),
    safeQuery(() => supabase.from('progres_sholat').select('*')),
    safeQuery(() => supabase.from('absensi').select('*')),
  ])
  iqroList.value = i.data || []; sholatList.value = s.data || []; absensiList.value = a.data || []
}

const statusChip = (s) => ({ sangat_lancar: 'chip-success', lancar: 'chip-emerald', belum: 'chip-neutral' }[s] || 'chip-neutral')
const formatSholatStatus = (s) => s === 'sangat_lancar' ? 'Sangat Lancar' : s.charAt(0).toUpperCase() + s.slice(1)
const countAtt = (s) => absensiList.value.filter(a => a.status === s).length

onMounted(fetchData)
</script>

<style scoped>
.page-wrapper { min-height:100vh; background:var(--color-surface); }
.page-content { max-width:768px; margin:0 auto; padding:16px; padding-bottom:100px; }
.page-title { font-size:20px; font-weight:700; color:var(--color-on-surface); margin-bottom:16px; }
.section { margin-bottom:24px; }
.section-title { font-size:15px; font-weight:600; color:var(--color-on-surface); margin-bottom:10px; }
.report-row { display:flex; align-items:center; padding:8px 0; border-bottom:1px solid var(--color-surface-container); }
.report-row:last-child { border-bottom:none; }
.prayer-summary { display:grid; grid-template-columns:repeat(3,1fr); gap:8px; }
.attendance-summary { display:flex; gap:12px; }
.att-item { flex:1; background:#fff; border-radius:var(--radius-md); padding:16px; text-align:center; border:1px solid var(--color-surface-container-high); box-shadow:var(--shadow-level-1); }
.att-count { display:block; font-size:28px; font-weight:700; }
.att-label { font-size:12px; color:var(--color-outline); margin-top:4px; display:block; }
@media(max-width:480px) { .prayer-summary { grid-template-columns:repeat(2,1fr); } }
@media(min-width:768px) { .page-content { padding-left:96px; } }
</style>
