import { createRouter, createWebHistory } from 'vue-router'
import { useAuth } from '../composables/useAuth'

const routes = [
  {
    path: '/',
    redirect: '/login'
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('../views/Login.vue'),
    meta: { requiresGuest: true }
  },
  {
    path: '/guru',
    name: 'GuruDashboard',
    component: () => import('../views/guru/Dashboard.vue'),
    meta: { requiresAuth: true, requiresRole: 'guru' }
  },
  {
    path: '/guru/santri',
    name: 'GuruSantri',
    component: () => import('../views/guru/Santri.vue'),
    meta: { requiresAuth: true, requiresRole: 'guru' }
  },
  {
    path: '/guru/absensi',
    name: 'GuruAbsensi',
    component: () => import('../views/guru/Absensi.vue'),
    meta: { requiresAuth: true, requiresRole: 'guru' }
  },
  {
    path: '/guru/iqro',
    name: 'GuruIqro',
    component: () => import('../views/guru/Iqro.vue'),
    meta: { requiresAuth: true, requiresRole: 'guru' }
  },
  {
    path: '/guru/sholat',
    name: 'GuruSholat',
    component: () => import('../views/guru/Sholat.vue'),
    meta: { requiresAuth: true, requiresRole: 'guru' }
  },
  {
    path: '/guru/pembayaran',
    name: 'GuruPembayaran',
    component: () => import('../views/guru/Pembayaran.vue'),
    meta: { requiresAuth: true, requiresRole: 'guru' }
  },
  {
    path: '/wali',
    name: 'WaliDashboard',
    component: () => import('../views/wali/Dashboard.vue'),
    meta: { requiresAuth: true, requiresRole: 'wali_santri' }
  },
  {
    path: '/wali/iqro',
    name: 'WaliIqro',
    component: () => import('../views/wali/Iqro.vue'),
    meta: { requiresAuth: true, requiresRole: 'wali_santri' }
  },
  {
    path: '/wali/sholat',
    name: 'WaliSholat',
    component: () => import('../views/wali/Sholat.vue'),
    meta: { requiresAuth: true, requiresRole: 'wali_santri' }
  },
  {
    path: '/wali/presensi',
    name: 'WaliPresensi',
    component: () => import('../views/wali/Presensi.vue'),
    meta: { requiresAuth: true, requiresRole: 'wali_santri' }
  },
  {
    path: '/wali/laporan',
    name: 'WaliLaporan',
    component: () => import('../views/wali/Laporan.vue'),
    meta: { requiresAuth: true, requiresRole: 'wali_santri' }
  },
  {
    path: '/wali/profile',
    name: 'WaliProfile',
    component: () => import('../views/wali/Profile.vue'),
    meta: { requiresAuth: true, requiresRole: 'wali_santri' }
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  const { isLoggedIn, getUser } = useAuth()
  const user = getUser()
  
  if (to.meta.requiresAuth && !isLoggedIn()) {
    next('/login')
  } else if (to.meta.requiresGuest && isLoggedIn()) {
    if (user?.role === 'guru') {
      next('/guru')
    } else {
      next('/wali')
    }
  } else if (to.meta.requiresRole && isLoggedIn()) {
    if (user?.role !== to.meta.requiresRole) {
      next('/')
    } else {
      next()
    }
  } else {
    next()
  }
})

export default router
