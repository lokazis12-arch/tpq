<template>
  <div class="page-wrapper pb-safe">
    <AppNavbar title="Dashboard" subtitle="Assalamualaikum, Ustadz 👋" role="guru">
      <template #actions>
        <button @click="handleLogout" class="btn-icon" title="Logout">
          <span class="material-icon" style="color: var(--color-outline);">logout</span>
        </button>
      </template>
    </AppNavbar>
    <main class="page-content">
      <div class="greeting-card islamic-pattern">
        <h2 class="greeting-title">Dashboard Guru</h2>
        <p class="greeting-sub">Berikut ringkasan aktivitas TPQ hari ini.</p>
        <div class="greeting-date"><span class="material-icon" style="font-size:16px;">calendar_today</span><span>{{ todayDate }}</span></div>
      </div>
      <div class="stats-grid">
        <StatCard icon="group" :value="stats.totalSantri" label="Total Santri" :trend="5" class="animate-slide-up stagger-1" />
        <StatCard icon="check_circle" :value="stats.hadirHariIni" label="Hadir Hari Ini" accentColor="#2e7d32" class="animate-slide-up stagger-2" />
        <StatCard icon="menu_book" :value="stats.progresIqro" label="Update Iqro" accentColor="#1565c0" class="animate-slide-up stagger-3" />
        <StatCard icon="payments" :value="stats.sppLunas" label="SPP Lunas" accentColor="#f57f17" class="animate-slide-up stagger-4" />
      </div>
      <section class="section">
        <h3 class="section-title">Menu Utama</h3>
        <div class="actions-grid">
          <router-link v-for="(a, i) in actions" :key="a.route" :to="a.route" class="action-card hover-lift animate-slide-up" :class="'stagger-'+(i+1)">
            <div class="action-icon" :style="{background: a.bg}"><span class="material-icon">{{ a.icon }}</span></div>
            <span class="action-label">{{ a.label }}</span>
            <span class="action-desc">{{ a.desc }}</span>
          </router-link>
        </div>
      </section>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useAuth } from '../../composables/useAuth'
import { useRouter } from 'vue-router'
import { supabase, safeQuery } from '../../lib/supabase'
import AppNavbar from '../../components/AppNavbar.vue'
import StatCard from '../../components/StatCard.vue'

const router = useRouter()
const { logout } = useAuth()
const stats = ref({ totalSantri: 0, hadirHariIni: 0, progresIqro: 0, sppLunas: 0 })

const actions = [
  { icon: 'group', label: 'Data Santri', desc: 'Kelola data', route: '/guru/santri', bg: 'linear-gradient(135deg,#006747,#0b6c4b)' },
  { icon: 'fact_check', label: 'Absensi', desc: 'Catat hadir', route: '/guru/absensi', bg: 'linear-gradient(135deg,#2e7d32,#43a047)' },
  { icon: 'menu_book', label: 'Progres Iqro', desc: 'Track baca', route: '/guru/iqro', bg: 'linear-gradient(135deg,#1565c0,#1e88e5)' },
  { icon: 'mosque', label: 'Progres Sholat', desc: 'Track sholat', route: '/guru/sholat', bg: 'linear-gradient(135deg,#f57f17,#ff8f00)' },
  { icon: 'payments', label: 'Pembayaran', desc: 'Kelola SPP', route: '/guru/pembayaran', bg: 'linear-gradient(135deg,#ad1457,#d81b60)' },
]

const todayDate = computed(() => new Date().toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }))
const handleLogout = () => { logout(); router.push('/login') }

const fetchStats = async () => {
  try {
    const today = new Date().toISOString().split('T')[0]
    const [s, a, i, b] = await Promise.all([
      safeQuery(() => supabase.from('santri').select('id', { count: 'exact' })),
      safeQuery(() => supabase.from('absensi').select('id', { count: 'exact' }).eq('tanggal', today).eq('status', 'hadir')),
      safeQuery(() => supabase.from('progres_iqro').select('id', { count: 'exact' })),
      safeQuery(() => supabase.from('pembayaran').select('id', { count: 'exact' }).eq('status', 'lunas')),
    ])
    stats.value = { totalSantri: s.count||0, hadirHariIni: a.count||0, progresIqro: i.count||0, sppLunas: b.count||0 }
  } catch(e) {}
}
onMounted(fetchStats)
</script>

<style scoped>
.page-wrapper { min-height:100vh; background:var(--color-surface); }
.page-content { max-width:768px; margin:0 auto; padding:16px; padding-bottom:100px; }
.greeting-card { background:linear-gradient(135deg,#004d34,#006747); border-radius:var(--radius-lg); padding:24px; color:white; margin-bottom:20px; overflow:hidden; position:relative; }
.greeting-title { font-size:22px; font-weight:700; margin-bottom:4px; }
.greeting-sub { font-size:14px; opacity:0.85; margin-bottom:12px; }
.greeting-date { display:flex; align-items:center; gap:6px; font-size:12px; opacity:0.75; }
.stats-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:12px; margin-bottom:28px; }
.section { margin-bottom:24px; }
.section-title { font-size:16px; font-weight:600; color:var(--color-on-surface); margin-bottom:14px; }
.actions-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; }
.action-card { display:flex; flex-direction:column; align-items:center; gap:8px; padding:18px 8px; background:#fff; border-radius:var(--radius-md); border:1px solid var(--color-surface-container-high); box-shadow:var(--shadow-level-1); text-decoration:none; text-align:center; }
.action-icon { width:44px; height:44px; border-radius:var(--radius-md); display:flex; align-items:center; justify-content:center; color:white; }
.action-icon .material-icon { font-size:22px; }
.action-label { font-size:13px; font-weight:600; color:var(--color-on-surface); line-height:1.2; }
.action-desc { font-size:11px; color:var(--color-outline); }
@media(min-width:768px) { .page-content { padding-left:96px; } .stats-grid { grid-template-columns:repeat(4,1fr); } .actions-grid { grid-template-columns:repeat(5,1fr); } }
</style>
