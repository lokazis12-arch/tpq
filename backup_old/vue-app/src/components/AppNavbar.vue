<template>
  <div>
    <!-- Top Header (glass) -->
    <header class="top-header glass" v-if="showHeader">
      <div class="header-content">
        <button v-if="showBack" class="back-btn" @click="$router.back()">
          <span class="material-icon">arrow_back</span>
        </button>
        <div class="header-title-group">
          <h1 class="header-title">{{ title }}</h1>
          <p class="header-subtitle" v-if="subtitle">{{ subtitle }}</p>
        </div>
        <div class="header-actions">
          <slot name="actions" />
        </div>
      </div>
    </header>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav glass" v-if="showNav">
      <router-link
        v-for="item in navItems"
        :key="item.route"
        :to="item.route"
        class="nav-item"
        :class="{ active: isActive(item.route) }"
      >
        <span class="material-icon nav-icon" :class="{ 'material-icon-filled': isActive(item.route) }">
          {{ item.icon }}
        </span>
        <span class="nav-label">{{ item.label }}</span>
      </router-link>
    </nav>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'

const props = defineProps({
  title: { type: String, default: '' },
  subtitle: { type: String, default: '' },
  showBack: { type: Boolean, default: false },
  showHeader: { type: Boolean, default: true },
  showNav: { type: Boolean, default: true },
  role: { type: String, default: 'guru' }, // 'guru' or 'wali_santri'
})

const route = useRoute()

const guruNav = [
  { icon: 'dashboard', label: 'Dashboard', route: '/guru' },
  { icon: 'group', label: 'Santri', route: '/guru/santri' },
  { icon: 'fact_check', label: 'Absensi', route: '/guru/absensi' },
  { icon: 'trending_up', label: 'Progres', route: '/guru/iqro' },
  { icon: 'payments', label: 'Bayar', route: '/guru/pembayaran' },
]

const waliNav = [
  { icon: 'dashboard', label: 'Dashboard', route: '/wali' },
  { icon: 'menu_book', label: 'Iqro', route: '/wali/iqro' },
  { icon: 'mosque', label: 'Sholat', route: '/wali/sholat' },
  { icon: 'calendar_today', label: 'Presensi', route: '/wali/presensi' },
  { icon: 'assessment', label: 'Laporan', route: '/wali/laporan' },
]

const navItems = computed(() => props.role === 'guru' ? guruNav : waliNav)

const isActive = (itemRoute) => {
  return route.path === itemRoute
}
</script>

<style scoped>
.top-header {
  position: sticky;
  top: 0;
  z-index: 40;
  border-bottom: 1px solid rgba(190, 201, 193, 0.3);
}

.header-content {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 16px;
  max-width: 768px;
  margin: 0 auto;
}

.back-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 36px;
  height: 36px;
  border: none;
  background: none;
  cursor: pointer;
  border-radius: 50%;
  color: var(--color-on-surface);
  transition: background 0.15s ease;
}
.back-btn:hover {
  background: var(--color-surface-container);
}

.header-title-group {
  flex: 1;
  min-width: 0;
}

.header-title {
  font-size: 18px;
  font-weight: 700;
  color: var(--color-on-surface);
  line-height: 1.3;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.header-subtitle {
  font-size: 12px;
  color: var(--color-on-surface-variant);
  margin-top: 1px;
}

.header-actions {
  display: flex;
  align-items: center;
  gap: 8px;
  flex-shrink: 0;
}

/* Bottom Navigation */
.bottom-nav {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 40;
  display: flex;
  justify-content: space-around;
  align-items: center;
  padding: 6px 0;
  padding-bottom: calc(6px + env(safe-area-inset-bottom, 0px));
  border-top: 1px solid rgba(190, 201, 193, 0.3);
}

.nav-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 2px;
  padding: 4px 12px;
  text-decoration: none;
  color: var(--color-outline);
  border-radius: var(--radius-lg);
  transition: color 0.15s ease;
  position: relative;
  min-width: 56px;
}

.nav-item.active {
  color: var(--color-primary-container);
}

.nav-item.active::after {
  content: '';
  position: absolute;
  top: -6px;
  left: 50%;
  transform: translateX(-50%);
  width: 32px;
  height: 3px;
  background: var(--color-primary-container);
  border-radius: 0 0 3px 3px;
}

.nav-icon {
  font-size: 22px;
}

.nav-label {
  font-size: 11px;
  font-weight: 500;
  letter-spacing: 0.01em;
}

/* Desktop: sidebar instead of bottom nav */
@media (min-width: 768px) {
  .bottom-nav {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    right: auto;
    width: 80px;
    flex-direction: column;
    justify-content: flex-start;
    padding: 20px 0;
    border-top: none;
    border-right: 1px solid rgba(190, 201, 193, 0.3);
  }

  .nav-item {
    padding: 10px 8px;
  }

  .nav-item.active::after {
    top: 50%;
    left: -1px;
    transform: translateY(-50%);
    width: 3px;
    height: 32px;
    border-radius: 0 3px 3px 0;
  }
}
</style>
