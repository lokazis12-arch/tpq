<template>
  <div class="student-card hover-lift" @click="$emit('click')">
    <div class="student-avatar" :style="{ background: avatarColor }">
      {{ initials }}
    </div>
    <div class="student-info">
      <h3 class="student-name">{{ nama }}</h3>
      <p class="student-meta">
        <span v-if="nis">NIS: {{ nis }}</span>
        <span v-if="nis && kelas"> • </span>
        <span v-if="kelas">{{ kelas }}</span>
      </p>
      <p class="student-detail" v-if="detail">{{ detail }}</p>
    </div>
    <div class="student-actions">
      <slot name="actions">
        <span class="material-icon action-icon">chevron_right</span>
      </slot>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  nama: { type: String, required: true },
  nis: { type: String, default: '' },
  kelas: { type: String, default: '' },
  detail: { type: String, default: '' },
  gender: { type: String, default: 'L' },
})

defineEmits(['click'])

const initials = computed(() => {
  return props.nama
    .split(' ')
    .map(w => w[0])
    .slice(0, 2)
    .join('')
    .toUpperCase()
})

const avatarColor = computed(() => {
  const colors = [
    'linear-gradient(135deg, #006747, #0b6c4b)',
    'linear-gradient(135deg, #4f635b, #6f7a72)',
    'linear-gradient(135deg, #005137, #006747)',
    'linear-gradient(135deg, #3d4446, #545b5d)',
  ]
  const index = props.nama.length % colors.length
  return colors[index]
})
</script>

<style scoped>
.student-card {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 14px 16px;
  background: #ffffff;
  border-radius: var(--radius-md);
  border: 1px solid var(--color-surface-container-high);
  box-shadow: var(--shadow-level-1);
  cursor: pointer;
  border-top: 3px solid var(--color-primary-container);
}

.student-avatar {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #ffffff;
  font-size: 15px;
  font-weight: 700;
  flex-shrink: 0;
  letter-spacing: 0.02em;
}

.student-info {
  flex: 1;
  min-width: 0;
}

.student-name {
  font-size: 15px;
  font-weight: 600;
  color: var(--color-on-surface);
  margin: 0;
  line-height: 1.3;
}

.student-meta {
  font-size: 12px;
  color: var(--color-on-surface-variant);
  margin: 2px 0 0;
}

.student-detail {
  font-size: 12px;
  color: var(--color-outline);
  margin: 4px 0 0;
}

.student-actions {
  flex-shrink: 0;
}

.action-icon {
  color: var(--color-outline-variant);
  font-size: 20px;
}
</style>
