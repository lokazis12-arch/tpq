import { ref, provide, inject } from 'vue'

const TOAST_KEY = 'toast'
let nextId = 0

export function createToast() {
  const toasts = ref([])

  const addToast = (message, type = 'success', duration = 3000) => {
    const id = ++nextId
    toasts.value.push({ id, message, type })
    if (duration > 0) {
      setTimeout(() => removeToast(id), duration)
    }
  }

  const removeToast = (id) => {
    toasts.value = toasts.value.filter(t => t.id !== id)
  }

  const showSuccess = (message) => addToast(message, 'success')
  const showError = (message) => addToast(message, 'error')
  const showWarning = (message) => addToast(message, 'warning')

  return {
    toasts,
    addToast,
    removeToast,
    showSuccess,
    showError,
    showWarning,
  }
}

export function provideToast(app) {
  const toast = createToast()
  app.provide(TOAST_KEY, toast)
  return toast
}

export function useToast() {
  const toast = inject(TOAST_KEY)
  if (!toast) {
    // Fallback for non-injected usage
    return createToast()
  }
  return toast
}
