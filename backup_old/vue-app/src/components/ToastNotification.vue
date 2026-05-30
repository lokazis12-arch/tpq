<template>
  <div class="toast-container">
    <TransitionGroup name="toast">
      <div
        v-for="toast in toasts"
        :key="toast.id"
        class="toast"
        :class="'toast-' + toast.type"
      >
        <span class="material-icon toast-icon">{{ getIcon(toast.type) }}</span>
        <p class="toast-message">{{ toast.message }}</p>
        <button class="toast-close" @click="removeToast(toast.id)">
          <span class="material-icon" style="font-size: 18px;">close</span>
        </button>
      </div>
    </TransitionGroup>
  </div>
</template>

<script setup>
import { inject } from 'vue'

const { toasts, removeToast } = inject('toast')

const getIcon = (type) => {
  switch (type) {
    case 'success': return 'check_circle'
    case 'error': return 'error'
    case 'warning': return 'warning'
    default: return 'info'
  }
}
</script>

<style scoped>
.toast-container {
  position: fixed;
  top: 16px;
  right: 16px;
  z-index: 100;
  display: flex;
  flex-direction: column;
  gap: 8px;
  max-width: 380px;
  width: calc(100% - 32px);
}

.toast {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 12px 16px;
  border-radius: var(--radius-md);
  box-shadow: var(--shadow-level-2);
  font-size: 14px;
  font-weight: 500;
}

.toast-success {
  background: #dcfce7;
  color: #166534;
  border: 1px solid #bbf7d0;
}

.toast-error {
  background: var(--color-error-container);
  color: var(--color-error);
  border: 1px solid #fecaca;
}

.toast-warning {
  background: #fef3c7;
  color: #92400e;
  border: 1px solid #fde68a;
}

.toast-icon {
  flex-shrink: 0;
}

.toast-message {
  flex: 1;
  margin: 0;
}

.toast-close {
  flex-shrink: 0;
  background: none;
  border: none;
  cursor: pointer;
  opacity: 0.6;
  color: inherit;
  padding: 2px;
  display: flex;
}
.toast-close:hover {
  opacity: 1;
}

/* Transitions */
.toast-enter-active {
  animation: slideInRight 0.3s ease-out;
}
.toast-leave-active {
  animation: fadeOut 0.2s ease-in forwards;
}
.toast-move {
  transition: transform 0.3s ease;
}

@keyframes slideInRight {
  from { opacity: 0; transform: translateX(24px); }
  to { opacity: 1; transform: translateX(0); }
}
@keyframes fadeOut {
  from { opacity: 1; }
  to { opacity: 0; }
}
</style>
