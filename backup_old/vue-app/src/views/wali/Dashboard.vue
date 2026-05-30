<template>
  <div class="page-wrapper pb-safe">
    <AppNavbar title="Dashboard" subtitle="Pantau perkembangan anak Anda" role="wali_santri">
      <template #actions>
        <router-link to="/wali/profile" class="btn-icon" title="Profile">
          <span class="material-icon" style="color:var(--color-outline);">person</span>
        </router-link>
        <button @click="handleLogout" class="btn-icon" title="Logout">
          <span class="material-icon" style="color:var(--color-outline);">logout</span>
        </button>
      </template>
    </AppNavbar>
    <main class="page-content">
      <div class="greeting-card">
        <div class="child-avatar"><span class="material-icon" style="font-size:32px;color:white;">child_care</span></div>
        <div><h2 class="greeting-title">Assalamualaikum 👋</h2><p class="greeting-sub">Dashboard Wali Santri</p></div>
      </div>
      <div class="menu-grid">
        <router-link v-for="(m, i) in menus" :key="m.route" :to="m.route" class="menu-card hover-lift animate-slide-up" :class="'stagger-'+(i+1)">
          <div class="menu-icon" :style="{background: m.bg}"><span class="material-icon">{{ m.icon }}</span></div>
          <div class="menu-info"><span class="menu-label">{{ m.label }}</span><span class="menu-desc">{{ m.desc }}</span></div>
          <span class="material-icon" style="color:var(--color-outline-variant);font-size:20px;">chevron_right</span>
        </router-link>
      </div>
    </main>
  </div>
</template>

<script setup>
import { useAuth } from '../../composables/useAuth'
import { useRouter } from 'vue-router'
import AppNavbar from '../../components/AppNavbar.vue'

const router = useRouter()
const { logout } = useAuth()
const handleLogout = () => { logout(); router.push('/login') }

const menus = [
  { icon: 'menu_book', label: 'Progres Iqro', desc: 'Lihat progres membaca', route: '/wali/iqro', bg: 'linear-gradient(135deg,#1565c0,#1e88e5)' },
  { icon: 'mosque', label: 'Progres Sholat', desc: 'Lihat progres sholat', route: '/wali/sholat', bg: 'linear-gradient(135deg,#f57f17,#ff8f00)' },
  { icon: 'calendar_today', label: 'Presensi', desc: 'Lihat kehadiran', route: '/wali/presensi', bg: 'linear-gradient(135deg,#2e7d32,#43a047)' },
  { icon: 'assessment', label: 'Laporan', desc: 'Lihat laporan lengkap', route: '/wali/laporan', bg: 'linear-gradient(135deg,#006747,#0b6c4b)' },
]
</script>

<style scoped>
.page-wrapper { min-height:100vh; background:var(--color-surface); }
.page-content { max-width:768px; margin:0 auto; padding:16px; padding-bottom:100px; }
.greeting-card { display:flex; align-items:center; gap:16px; background:linear-gradient(135deg,#004d34,#006747); border-radius:var(--radius-lg); padding:24px; color:white; margin-bottom:20px; }
.child-avatar { width:56px; height:56px; border-radius:50%; background:rgba(255,255,255,0.2); display:flex; align-items:center; justify-content:center; }
.greeting-title { font-size:20px; font-weight:700; margin-bottom:2px; }
.greeting-sub { font-size:13px; opacity:0.8; }
.menu-grid { display:flex; flex-direction:column; gap:10px; }
.menu-card { display:flex; align-items:center; gap:14px; padding:16px; background:#fff; border-radius:var(--radius-md); border:1px solid var(--color-surface-container-high); box-shadow:var(--shadow-level-1); text-decoration:none; }
.menu-icon { width:44px; height:44px; border-radius:var(--radius-md); display:flex; align-items:center; justify-content:center; color:white; flex-shrink:0; }
.menu-icon .material-icon { font-size:22px; }
.menu-info { flex:1; }
.menu-label { display:block; font-size:15px; font-weight:600; color:var(--color-on-surface); }
.menu-desc { display:block; font-size:12px; color:var(--color-on-surface-variant); margin-top:2px; }
@media(min-width:768px) { .page-content { padding-left:96px; } }
</style>
