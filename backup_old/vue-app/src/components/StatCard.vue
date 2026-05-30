<template>
  <div class="stat-card hover-lift" :style="{ '--accent': accentColor }">
    <div class="stat-icon-wrap">
      <span class="material-icon stat-icon">{{ icon }}</span>
    </div>
    <div class="stat-content">
      <p class="stat-value">{{ formattedValue }}</p>
      <p class="stat-label">{{ label }}</p>
    </div>
    <div class="stat-trend" v-if="trend" :class="trend > 0 ? 'trend-up' : 'trend-down'">
      <span class="material-icon" style="font-size: 14px;">{{ trend > 0 ? 'trending_up' : 'trending_down' }}</span>
      <span>{{ Math.abs(trend) }}%</span>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  icon: { type: String, required: true },
  value: { type: [Number, String], required: true },
  label: { type: String, required: true },
  trend: { type: Number, default: null },
  accentColor: { type: String, default: '#006747' },
})

const formattedValue = computed(() => {
  if (typeof props.value === 'number') {
    return props.value.toLocaleString('id-ID')
  }
  return props.value
})
</script>

<style scoped>
.stat-card {
  background: #ffffff;
  border-radius: var(--radius-md);
  padding: 16px;
  border: 1px solid var(--color-surface-container-high);
  box-shadow: var(--shadow-level-1);
  display: flex;
  align-items: center;
  gap: 12px;
  position: relative;
  overflow: hidden;
}

.stat-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 4px;
  height: 100%;
  background: var(--accent, var(--color-primary-container));
  border-radius: 4px 0 0 4px;
}

.stat-icon-wrap {
  width: 44px;
  height: 44px;
  border-radius: var(--radius-md);
  background: var(--color-secondary-container);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.stat-icon {
  color: var(--color-primary-container);
  font-size: 22px;
}

.stat-content {
  flex: 1;
  min-width: 0;
}

.stat-value {
  font-size: 22px;
  font-weight: 700;
  color: var(--color-on-surface);
  line-height: 1.2;
  margin: 0;
}

.stat-label {
  font-size: 12px;
  font-weight: 500;
  color: var(--color-on-surface-variant);
  margin: 2px 0 0;
}

.stat-trend {
  display: flex;
  align-items: center;
  gap: 2px;
  font-size: 12px;
  font-weight: 600;
  padding: 2px 8px;
  border-radius: 9999px;
}

.trend-up {
  color: #166534;
  background: #dcfce7;
}

.trend-down {
  color: #991b1b;
  background: #fee2e2;
}
</style>
